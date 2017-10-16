<?php

//设置 mb 默认字符
mb_internal_encoding("UTF-8");

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

//$config = require(__DIR__ . '/../config/web.php');

$config = require(__DIR__ . '/../Application/config/web.php');

(new yii\web\Application($config))->run();
