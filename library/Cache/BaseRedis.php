<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 2017/9/6
 * Time: 21:53
 */

namespace app\library\Cache;
class BaseRedis {

    /**
     * 私有静态变量 保存全局实例化对象
     */
    private static $_instance = null;

    protected $master_config = [];
    protected $salve_config  = [];

    protected $handler;
    protected $handler_master;
    protected $handler_slave;

    protected $maxConnectNum = 2;

    protected $retryConnectNum = 0;

    public function __construct($redis_config)
    {
        if(!$this->_handler_master)
        {
            $redis = $this->_connect($this->configMaster);
            if(!$redis) {
                $logger = \Douyu\Core\Di::getDefault()->getRedisLogger();
                $logger->error('redis connect failed! host:' . $this->configMaster['host']);
                $logger->disableDelayWrite();
            }

            $this->_handler_master = $redis;
        }

        $this->handler = $this->_handler_master;
        if(!$this->master_config) {
           \Yii::$app->log->error('redis connect fail', 'redisLogger');
        }
    }

    /**
     * 连接redis
     * @param array $redis_config redis配置
     * @return null|\Redis
     */
    private function _connect($redis_config)
    {
        $redis = new \Redis;

        if(is_array($redis_config['host']))
        {
            $redis_host = $redis_config['host'];
        }
        else if(strpos($redis_config['host'], ',') !== FALSE)
        {
            $host_arr =  explode(',', $redis_config['host']);
            $redis_host = [];
            foreach ($host_arr as $v)
            {
                $v = trim($v);
                $redis_host[$v] = 1;
            }
        }
        else
        {
            $redis_host = array($redis_config['host'] => 1);
        }

        $redis_host = $this->_random_host($redis_host);
        if(!$redis_host) {
            $logger = \Douyu\Core\Di::getDefault()->getRedisLogger();
            $logger->error('缓存配置故障');
            $logger->disableDelayWrite();
        }

        foreach ($redis_host as $host)
        {
            if (strpos($host, ':') !== FALSE) {
                $tmparr = explode(":", $host);
                $host = $tmparr[0];
                $port = $tmparr[1];
            } else {
                $port = 6379;
                $logger = \Douyu\Core\Di::getDefault()->getRedisLogger();
                $logger->error('redis config error, host has no port');
                $logger->disableDelayWrite();
            }

            //Redis连接日志
            $logger = \Douyu\Core\Di::getDefault()->getRedisConnectLogger();
            $logger->info('host:' . $host . ':' . $port, ['redis_host' => [$host], 'redis_port' => [$port], 'redis_uri' => isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'cli']);

            // 最大次数限制，不抛顶级异常。避免移动端崩溃
            if ($this->retryConnectNum > $this->maxConnectNum) {
                return null;
            }
            $this->retryConnectNum++;

            if(!$redis->connect($host, $port, 1))
            {
                //连接失败
                self::$failTimes++;
                $logger = \Douyu\Core\Di::getDefault()->getRedisLogger();
                $logger->error('redis connect ' . $this->retryConnectNum . ' failed! host:' . $host . ':' . $port, ['redis_host' => [$host], 'redis_port' => [$port], 'redis_uri' => isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'cli', 'redis_retry_times' => [$this->retryConnectNum]]);
                $logger->disableDelayWrite();
            }
            else
            {
                $redis->setOption(\Redis::OPT_PREFIX, $redis_config['pre']);
                return $redis;
            }
        }

        return null;
    }


    /**
     * 及时关掉redis连接
     */
    public function __destruct()
    {
        if($this->handler_master)
            $this->handler_master->close();

        if($this->handler_slave)
            $this->handler_slave->close();
    }

    // 创建__clone方法 ，防止对象被复制
    private function __clone()
    {
    }

    //单例统一入口
    public static function getInstance()
    {
        if(!self::$_instance instanceof self){
            return new self;
        }

        return self::$_instance;
    }
}