<?php
/**
 * @author FredGui
 * @version 2017-9-6
 * @modify  2017-9-6
 * @description 首页控制器
 * @link http://blog.kinggui.com
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
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

    public function __construct($config = null)
    {
        if($config == null) {
            $this->master_config = \Yii::$app->params['redis']['default_redis'];
        }else {
            $this->master_config = $config;
        }

        if(!$this->handler_master)
        {
            $redis = $this->_connect($this->master_config);
            if(!$redis) {
                \Yii::$app->log->error('redis connect fail', 'redisLogger');
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
            \Yii::$app->log->info('REDIS CONFIG ERROR','redisLogger');
        }

        foreach ($redis_host as $host)
        {
            if (strpos($host, ':') !== FALSE) {
                $tmparr = explode(":", $host);
                $host = $tmparr[0];
                $port = $tmparr[1];
            } else {
                $port = 6379;
                \Yii::$app->log->info('redis config error, host has no port','redisLogger');

            }

            // 最大次数限制，不抛顶级异常。避免移动端崩溃
            if ($this->retryConnectNum > $this->maxConnectNum) {
                return null;
            }
            $this->retryConnectNum++;

            if(!$redis->connect($host, $port, 1))
            {
                //连接失败
               // self::$failTimes++;
                \Yii::$app->log->info('redis connect ' . $this->retryConnectNum,'redisLogger');
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
     * 连接redis主服务器
     */
    protected function _connect_master()
    {
        if(!$this->_handler_master)
        {
            $redis = $this->_connect($this->master_config);
            if(!$redis) {

            }

            $this->_handler_master = $redis;
        }

        $this->handler = $this->_handler_master;
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


    //单例统一入口
    /**
     * @param null $redis_config
     * @return \Redis
     */
    public static function getInstance($redis_config = null)
    {
        if($redis_config == null) {
            $redis_config = \Yii::$app->params['redis']['default_redis'];
        }

        if(!self::$_instance instanceof self){
            return new self($redis_config);
        }

        return self::$_instance;
    }

    /**
    +----------------------------------------------------------
     * 写入缓存
    +----------------------------------------------------------
     * @access public
    +----------------------------------------------------------
     * @param string $name 缓存变量名
     * @param mixed $value  存储数据
     * @param integer $expire  有效时间（秒）
    +----------------------------------------------------------
     * @return boolean
    +----------------------------------------------------------
     */
    public function set($name, $value, $expire = null)
    {
        $this->_connect_master();

        if (is_int($expire))
        {
            $result = $this->handler->setex($name, $expire, $value);
        }
        else
        {
            $result = $this->handler->set($name, $value);
        }

        return $result;
    }

    /**
     * @param $name
     * @return bool|string
     * @throws \RedisException
     */
    public function get($name)
    {
        $this->_connect_master();  //应该是 从库
        if ($this->handler === null) {
            throw new \RedisException('redis connect error');
        }
        return $this->handler->get($name);
    }

    /**
    +----------------------------------------------------------
     * 删除缓存
     *
    +----------------------------------------------------------
     * @access public
    +----------------------------------------------------------
     * @param string $name 缓存变量名
    +----------------------------------------------------------
     * @return boolean
    +----------------------------------------------------------
     */
    public function rm($name)
    {
        $this->_connect_master();

        return $this->handler->del([$name]);
    }

    /**
    +----------------------------------------------------------
     * 清除缓存
    +----------------------------------------------------------
     * @access public
    +----------------------------------------------------------
     * @return boolean
    +----------------------------------------------------------
     */
    public function clear()
    {
        $this->_connect_master();

        return $this->handler->flushDB();
    }

    /**
     * 扩展set，支持锁机制
     * @param string $key 缓存变量key
     * @param string $value 缓存变量值
     * @param int $expire 有效期
     */
    public function setLock($key, $value, $expire)
    {
        $expire = (int)$expire;
        if (!$expire) {
            return false;
        }
        $this->_connect_master();
        return $this->handler->set($key, $value, array('nx', 'ex' => $expire));
    }


    /*
    * 获取使用长连接的redis实例
    * return $redis | null
    */
    private function _pconnect($redis_config)
    {
        $hostname = gethostname();
        if (empty($redis_config['pconnect']) || !is_array($redis_config['pconnect']) || !$hostname)
            return null;
        $redis = new \Redis;
        $canConnect = false;
        $redisHost = '';
        $redisPort = '';
        foreach ($redis_config['pconnect'] as $redisHostPort => $phpHostnames) {
            foreach ($phpHostnames as $phpHostname) {
                // 根据php-fpm机器hostname寻找对应的redis的host和port，并建立长连接
                if ($hostname == $phpHostname) {
                    $redisHostPortArr = explode(":", $redisHostPort);
                    $redisHost = $redisHostPortArr[0];
                    $redisPort = $redisHostPortArr[1];
                    $canConnect = $redis->pconnect($redisHost, $redisPort, 1);
                    break 2;
                }
            }
        }
        if ($canConnect) {
            $redis->setOption(\Redis::OPT_PREFIX, $redis_config['pre']);
            return $redis;
        } else {
            $logger = \Douyu\Core\Di::getDefault()->getRedisLogger();
            $logger->error('redis pconnect failed! host:' . $redisHost . ':' . $redisPort);
            $logger->disableDelayWrite();
            return null;
        }
    }

    /**
     * 魔术函数，实现对redis的其他方法调用
     */
    public function __call($name, $arguments)
    {
        if(in_array(strtolower($name), ['append', 'getset', 'move', 'rename', 'renamekey', 'renamenx', 'settimeout', 'pexpire', 'pexpireat', 'expire', 'expireat',
            'setrange', 'setbit', 'setex', 'psetex', 'setnx', 'del', 'delete', 'sort',
            'decr', 'decrby', 'decrbyfloat', 'incr', 'incrby', 'incrbyfloat', 'mset', 'msetnx', 'restore', 'migrate',
            'hdel', 'hincrby', 'hincrbyfloat', 'hmset', 'hset', 'hsetnx',
            'blpop', 'brpop', 'brpoplpush', 'linsert', 'lpop', 'lpush', 'lpushx', 'lrem', 'lremove', 'lset', 'ltrim', 'listtrim',
            'rpop', 'rpoplpush', 'rpush', 'rpushx', 'sadd', 'sdiffstore', 'sinterstore', 'smove', 'srandmember', 'srem',
            'sremove', 'sunionstore', 'zadd', 'zincrby', 'zinter', 'zrem', 'zdelete', 'zremrangebyrank', 'zdeleterangebyrank',
            'zremrangebyscore', 'zdeleterangebyscore', 'zunion', 'zinterstore', 'zunionstore', 'psubscribe', 'publish', 'subscribe', 'pubsub',
            'exec', 'eval', 'evalsha', 'script'
        ]))
            $this->_connect_master();
        else
            $this->_connect_slave();

        if ($this->handler === null) {
            throw new \RedisException('redis connect error');
        }
        return call_user_func_array(array($this->handler, $name), $arguments);
    }
    
    /**
     * 带权重随机列表
     * @param array $hosts 主机数组，结构： array( 'ip' => '权重值' )
     * @return array
     */
    private function _random_host($hosts)
    {
        if(!is_array($hosts))
            return null;

        if(count($hosts) === 1)
            return [key($hosts)];

        $arr = [];
        $n = 0;
        foreach ($hosts as $v)
        {
            for($i = 0; $i < $v; $i++)
                $arr[] = $n;

            $n++;
        }

        shuffle($arr);
        $arr = array_unique($arr);

        $keys = array_keys($hosts);

        $result = [];
        foreach ($arr as $v)
            $result[] = $keys[$v];

        return $result;
    }
}