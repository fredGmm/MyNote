<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');


$config = [
    'id' => 'j-book',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => require(__DIR__ . '/module.php'),
    'defaultRoute'=>'index/index',
    'runtimePath' => dirname(dirname(__DIR__)) . '/runtime/',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'guimingmingtest',
            'enableCsrfValidation' => false, //暂时先关闭csfr
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'error/404',
            'errorView'   => 'app/views/error/login.php'
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,//这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
            // 'viewPath' => '@app/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.163.com',//每种邮箱的host配置不一样
                'port' => '25',//465 587
                'encryption' => 'tls',//ssl tls
                'username' => '17771869383@163.com',
                'password' => 'ming19940329',
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['17771869383@163.com' => '系统邮件'],
            ],
        ],
        'log' => [
//            'class' => 'app\library\log\Logger',
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],

        ],
        'db' => $db['db'],
        'hupuDb' => $db['hupuDb'],
        'mongodb' => [
            'class' => 'yii\mongodb\Connection',
            # 有账户的配置
            //'dsn' => 'mongodb://demofancyecommerce:fdaVBDFS#fdfdtyg423DF23#$@localhost:27017/demofancyecommerce',
            # 无账户的配置
            'dsn' => 'mongodb://192.168.1.111:27017/article',

        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require(__DIR__ . '/url.php'),
        ],
       
    ],
    'params' => $params,
];
//数据库 使用单独文件配置
$config['components'] = array_merge($config['components'], $db);

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '*'],
    ];
}

return $config;
