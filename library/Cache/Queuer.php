<?php
/**
 * @author askuy
 * @date: 2016/1/11
 * @Time: 10:28
 */

namespace Library\Core;


class Queuer
{
    public $redis = '';
    public $pre = '';
    public $table = '';
    private $data = null;
    /**
     * 默认打开验证开关
     * @var bool
     */
    protected $isCustomPop = false;
    protected $countKey = 'queuedfghjredisCount';       // 增加乱码不与其他redis变量名重复
    protected $error = '';
    protected $execMethod = 'blPop';
    protected $execParams = array(0);
    protected $queueMaxNum= 1000000;//队列最大阀值100万
    protected $queueAlarmNum = 1000;//队列超过1000条，防止错误数据大面积入队列
    protected $maxRunNum = 5;   //队列重复执行次数

    public $debug = true; //是否直接输出日志信息，避免分布式定时任务系统输出海量日志

    /**
     * runData后是否输出
     */
    protected $runDataShowMessage = true;
    /**
     * 运行
     * @return bool
     */
    public function run()
    {
        $result = $this->runData();
        if ($result === false) {
            // 记录日志，可以继承，处理错误信息
            $this->log($this->error, $this->data);
            return false;
        }
        // 运维观察信息
        if ($this->runDataShowMessage === true) {
            if ($this->debug) {
                echo 'success' . PHP_EOL;
            }
        }
        return true;
    }

    /**
     * 运行数据
     * @return bool
     */
    private function runData()
    {
        // 队列不存在
        if (!isset($this->redis) || empty($this->redis)) {
            $this->error = 'QUEUE_NOT_EXIST';

            return false;
        }

        // 表不存在
        if (!isset($this->table) || empty($this->table)) {
            $this->error = 'TABLE_NOT_EXIST';

            return false;
        }

        // 前缀不存在
        if (!isset($this->pre) || empty($this->pre)) {
            $this->error = 'PRE_NOT_EXIST';

            return false;
        }


        // 弹出数据
        if(!$this->isCustomPop) {
            $this->data = $this->popQueue();
        }else {
            $this->data = $this->customQueue();
        }

        if (!isset($this->data) || empty($this->data)) {
            $this->error = 'DATA_NOT_EXIST';

            return false;
        }

        // 数据5次，就报错，redis执行次数达到最大次数
        if (isset($this->data[$this->countKey]) && ($this->data[$this->countKey] >= $this->maxRunNum)) {
            $this->error = 'REDIS_COUNT_EXEC_MAX';
            return false;
        }
        // 通过继承，处理数据
        $status = $this->processData($this->data);

        // 数据发送失败，加入队列重新运行
        if ($status === false) {
            $this->pushQueue($this->data);
        }

        return true;
    }



    /**
     * 处理数据
     * 如果未继承，强制报错
     * @param $data
     * @return bool
     */
    protected function processData($data)
    {
        $this->log('METHOD processData NOT OVERWRITE');

        return false;
    }

    /**
     * 添加到队列，并添加一个redisCount计数器
     * @param $data
     * @return mixed
     */
    public function pushQueue($data)
    {
        $this->redis->setPre($this->pre);
        $length = $this->redis->lSize($this->table);
        // 队列不存在
        if (!isset($this->redis) || empty($this->redis)) {
            $this->error = 'QUEUE_NOT_EXIST';
            return false;
        }

        // 有这个数据说明这条数据属于执行失败重新入队列
        if (isset($data[$this->countKey])) {
            // 队列超过这个值，需要进行加快队列里错误数据处理速度
            if ($length > $this->queueAlarmNum) {
                $data[$this->countKey] = intval($data[$this->countKey]) + 3;
            // 队列小于这个值，队列里错误数据处理速度可以降低
            }else {
                $data[$this->countKey] = intval($data[$this->countKey]) + 1;
            }
        // 第一次入队列
        } else {
            $data[$this->countKey] = 0;
        }
        if ($length < $this->queueMaxNum) {
            return $this->redis->lPush($this->table, json_encode($data));
        } else {
            //当队列长队大于100万时写入文件日志
            log_file('INFO', json_encode($data), 'queue_than_max_log');
            return false;
        }
    }

    /**
     * 推出队列
     * @return mixed
     */
    public function popQueue()
    {
        $this->redis->setPre($this->pre);
        array_unshift($this->execParams,$this->table);
        $data = call_user_func_array(array( $this->redis,  $this->execMethod), $this->execParams);
        switch ($this->execMethod) {
            case 'blPop' :
                $data = json_decode($data[1], true);
                break;
            default :
                break;
        }
        return $data;
    }

    /**
     * 自定义推出队列 --- 当前队列中 时间字段<=当前时间的队列 (此方法仅供抽奖使用)
     * @return bool
     */
    protected function customQueue() {
        $this->redis->setPre($this->pre);
        $data = $this->redis->lRange($this->table, 0, -1);

        $result = array();
        if(!empty($data)){
            foreach($data AS $key=>$val){
                $valArr = json_decode($val, true);

                if($valArr['endTime'] <= NOW_TIME){
                    //取出 销毁
                    $result = $valArr;
                    $this->redis->lRem($this->table, $val, 1);
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * 记录日志
     * @param $error
     * @param $data
     */
    protected function log($error, $data = null)
    {
        if (!isset($data) || empty($data)) {
            $str = 'data:null';
        } else {
            $str = 'data:' . json_encode($data);
        }
        // 运维观察错误信息
        if ($this->debug) {
            echo 'error:' . $error . ',' . $str . PHP_EOL;
        }
        log_file('ERROR', $error . ',' . $str, 'log_queue');
    }
}