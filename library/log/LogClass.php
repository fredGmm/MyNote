<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 2017/8/22
 * Time: 22:40
 */

namespace app\library\log;

class LogClass {

    public $logPath;

    public function __construct()
    {
        var_dump($this->logPath);exit;
        $config = new \app\library\log\Config();
        $log = new \app\library\log\Logger($config);

        $fileWriter = new \app\library\log\Adapter\File('filename', './log');
        $log->setWriter($fileWriter);
       // return $log;
        $log->info('this is a log test');
    }

}