<?php

/**** 日志类 ****/
// set config
$config = new \app\library\log\Config();
$log = new \app\library\log\Logger($config);
$logPath = __DIR__ . '/logs';
$fileWriter = new \app\library\log\Adapter\File('filename', $logPath);
$log->setWriter($fileWriter);

$log->info('this is a log test');

/**** 日志类 ****/
