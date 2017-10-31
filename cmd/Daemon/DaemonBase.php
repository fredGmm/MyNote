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
abstract class DaemonBase
{
    const LOG_ECHO = 1;
    const LOG_FILE = 2;

    /**
     * @var $child_pid 子进程的pid
     */
    public $child_pid;

    public $pid_file;
    public $log_file; //每个子类的日志文件


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
        'pid'          => '/tmp/' . 'daemon' . '.pid',
        'limit_memory' => -1, //分配最大内存
        'max_times'    => 0, //重启的最大次数
    ];

    /**
     * 构造函数，设置path.以及注册shutdown
     */
    public function __construct()
    {
        $this->pid_file = '/tmp/' . get_class($this) . '.pid';
        $this->log_file = '/tmp/' . get_class($this) . '.log';

        set_error_handler([$this, 'errorHandler']);
        register_shutdown_function(array($this, 'shutdown'));

        ini_set('memory_limit', self::$config['limit_memory']);
        ini_set('display_errors', 'Off');
        clearstatcache();
    }

    /**
     * 执行启动程序
     * @param string $command
     */
    public function run($command = 'start')
    {
        if(empty($command) || !in_array($command, ['start', 'stop', 'restart', 'status'])){
            $command = 'help';
        }
        $this->$command();
    }

    /**
     * 开始
     */
    public function start()
    {
        $this->log('Starting daemon...', self::LOG_ECHO | self::LOG_FILE);
        $this->daemonize();

       echo 'Daemon #' . $this->getChildPid() . ' 启动成功' .PHP_EOL;

        declare(ticks = 1){
            while($this->switch){
                $this->autoRestart();
                $this->todo();

                try {
                    $this->main();
                }catch (Exception $e) {
                    var_dump($e);
                    $this->log($e->getMessage(), self::LOG_FILE);
                }
            }
        }
    }

    /**
     * 停止
     */
    public function stop()
    {
        if (!$pid = $this->getChildPid()) {
            $this->log('守护进程 GG', self::LOG_FILE);
            exit();
        }
        posix_kill($pid, SIGKILL);
    }

    protected function stopAll()
    {
        if (!is_writeable($this->log_file)) {
            $this->log('Daemon (no pid file) not running', self::LOG_ECHO);
            return FALSE;
        }

        $pid = $this->getChildPid();
        unlink($this->log_file);
        $this->log('Daemon #' . $pid . ' has stopped', self::LOG_ECHO | self::LOG_FILE);
        $this->switch = TRUE;
    }

    public function restart()
    {
        if (!$pid = $this->getChildPid()) {
            $this->log('守护进程 GG', self::LOG_FILE);
            exit();
        }

        posix_kill($pid, SIGHUP);
    }

    public function status()
    {
        if($pid = $this->getChildPid()) {
            $msg = "pid: $pid is running";
        }else {
            $msg = "进程GG";
        }

        $this->log($msg, self::LOG_ECHO);
    }

    /**
     * 帮助命令
     */
    public function help()
    {
        echo 'start | stop | status | restart';
    }

    /**
     * 检测能否正常启动
     * @return bool
     */
    protected function check()
    {
        if ($pid = $this->getChildPid()) {
            $this->log("Daemon #{$pid} has already started", self::LOG_ECHO);
            return FALSE;
        }

        $dir = dirname(self::$config['pid']);
        if (!is_writable($dir)) {
            $this->log("you do not have permission to write pid file @ {$dir}", self::LOG_ECHO);
            return FALSE;
        }

        if (!is_writable(self::$config['log_file']) || !is_writable(dirname(self::$config['log_file']))) {
            $this->log("you do not have permission to write log file: {log_file}", self::LOG_ECHO);
            return FALSE;
        }

        if (!defined('SIGHUP')) { // Check for pcntl
            $this->log('PHP is compiled without --enable-pcntl directive', self::LOG_ECHO | self::LOG_FILE);
            return FALSE;
        }

        if ('cli' !== php_sapi_name()) { // Check for CLI
            $this->log('You can only create daemon from the command line (CLI-mode)', self::LOG_ECHO | self::LOG_FILE);
            return FALSE;
        }

        if (!function_exists('posix_getpid')) { // Check for POSIX
            $this->log('PHP is compiled without --enable-posix directive', self::LOG_ECHO | self::LOG_FILE);
            return FALSE;
        }

        return TRUE;
    }

    /**
     * 创建子进程，并做好信号处理工作
     */
    protected function daemonize()
    {
        //检查状态
        $this->check();
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

       file_put_contents($this->pid_file, $this->child_pid);
    }

    /**
     * fork 子进程
     * @return bool
     */
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

    /**
     * 重启
     */
    protected function autoRestart()
    {
        if((self::$config['max_times'] && $this->cnt >= self::$config['max_time']) ||
            (0 !== self::$config['limit_memory'] && memory_get_usage(TRUE) >= self::$config['limit_memory']))
        {
            $this->doworks = [[$this, 'restart']];
            $this->cnt = 0;
        }

        $this->cnt++;
    }

    public function getChildPid(){
        if(!file_exists($this->pid_file)){
            return false;
        }

        $pid = (int)file_get_contents($this->pid_file);

        return file_exists("/proc/{$pid}") ? $pid : FALSE; //检测是否确实存在此进程
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
            file_put_contents($this->log_file, $msg, FILE_APPEND | LOCK_EX);
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