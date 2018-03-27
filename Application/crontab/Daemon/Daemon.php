<?php
/**
 * Test
class TestDaemon extends Cola_Com_Daemon
{
protected $_options = array(
'maxTimes' => 3
);
public function main()
{
file_put_contents('/tmp/TestDaemon.txt', date('Y-m-d H:i:s') . "\n", FILE_APPEND | LOCK_EX);
sleep(5);
}
}

$daemon = new TestDaemon();
$daemon->run();
 *
 */
abstract class Daemon
{
    const LOG_ECHO = 1;
    const LOG_FILE = 2;

    /**
     * @var $child_pid 子进程的pid
     */
    public $child_pid;

    public $switch = true; //开关

    
    public $cnt; //重启的计数

    public $do_works = []; 

    public $sig_handlers = [];

    /**
     * 配置
     */
    public static $config = [
        'current_dir'  => '',
        'log_file'     => '/tmp/' . __CLASS__ . '.log',
        'pid'          => '/tmp/' . __CLASS__ . '.pid',
        'limit_memory' => -1, //分配最大内存
        'max_times'    => 0, //重启的最大次数
    ];

    public function __construct()
    {

        set_error_handler([$this, 'errorHandler']);
        register_shutdown_function(array($this, 'shutdown'));

        ini_set('memory_limit', self::$config['limit_memory']);
        ini_set('display_errors', 'Off');
        clearstatcache();
    }

    public function run($argv)
    {
        $command = $argv;
        if(empty($argv) || !in_array($argv, ['start', 'stop', 'restart', 'status'])){
            $command = 'help';
        }
        $this->$command();
    }

    public function start()
    {
        $this->log('Starting daemon...', self::LOG_ECHO | self::LOG_FILE);
        $this->daemonize();

        $this->log('Daemon #' . $this->getChildPid() . ' is running', self::LOG_ECHO | self::LOG_FILE);

        declare(ticks = 1){
            while($this->switch){
                $this->autoRestart();
                $this->todo();
                if($this->switch)
                    break;

                try {
                    $this->main();
                }catch (Exception $e) {

                }
            }
        }


    }

    protected function daemonize()
    {
        //检查状态

        //fork 子进程
        $this->fork();

        //信号处理
        $sig_array = [
            SIGTERM => [$this, 'defaultSigHandler'],
            SIGQUIT => [$this, 'defaultSigHandler'],
            SIGINT  => [$this, 'defaultSigHandler'],
            SIGHUP  => [$this, 'defaultSigHandler'],
        ];
        foreach ($sig_array as $signo => $callback) {
            pcntl_signal($signo, $callback);
        }

       // file_put_contents($this->_options['pid'], $this->_pid);

    }

    protected function fork()
    {
        $pid = pcntl_fork();

        if($pid == -1) { //创建子进程失败

            return false;
        }

        if($pid) { // 父进程
            exit();
        }

        //子进程
        $this->child_pid = posix_getpid(); //子进程id
        posix_setsid(); //使进程成为会话组长,让进程摆脱原会话的控制；让进程摆脱原进程组的控制；

        return true;
    }

    protected function autoRestart()
    {
        if((self::$config['max_time'] && $this->cnt >= self::$config['max_time']) ||
            (0 !== self::$config['limit_memory'] && memory_get_usage(TRUE) >= self::$config['limit_memory']))
        {
            $this->doworks = [[$this, 'restart']];
            $this->cnt = 0;
        }

        $this->cnt++;
    }


    public function getChildPid(){
        if(!file_exists(self::$config['pid'])){
            return false;
        }

        $pid = (int)file_get_contents(self::$config['pid']);

        return file_exists("/proc/{$pid}") ? $pid : FALSE;
    }

    public function todo()
    {
        foreach ($this->do_works as $row) {
            (1 === count($row)) ? call_user_func($row[0]) : call_user_func_array($row[0], $row[1]);
        }
    }

    /**
     * 需要执行的逻辑体
     *
     * @return mixed
     */
    abstract public function main();

    public function defaultSigHandler($signo)
    {
        switch ($signo) {
            case SIGTERM:
            case SIGQUIT:
            case SIGINT:
                $this->do_works = [[$this, 'stop']];
                break;
            case SIGHUP:
                $this->do_works = [[$this, 'restart']];
                break;
            default:
                break;
        }
    }

    /**
     * Regist signo handler
     *
     * @param int $sig
     * @param callback $action
     */
    public function regSigHandler($sig, $action)
    {
        $this->sig_handlers[$sig] = $action;
    }

    public function errorHandler($error_code, $msg){

    }


    /**
     * 守护进程日志
     *
     * @param string $msg
     * @param int $io, 1->just echo, 2->just write, 3->echo & write
     */
    public function log($msg, $io = self::LOG_FILE)
    {
        $datetime = date('Y-m-d H:i:s');
        $msg = "[{$datetime}] {$msg}\n";

        if ((self::LOG_ECHO & $io) && !$this->child_pid) {
            echo $msg, "\n";
        }

        if (self::LOG_FILE & $io) {
            file_put_contents(self::$config['log_file'], $msg, FILE_APPEND | LOCK_EX);
        }
    }

    /**
     * 脚本跑完执行
     */
    public function shutdown()
    {
        if ($error = error_get_last()) {
            $this->log(implode('|', $error), self::LOG_FILE);
        }

        if (is_writeable(self::$config['pid']) && $this->child_pid) {
            unlink(self::$config['pid']);
        }
    }
    
}