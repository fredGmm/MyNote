<?php
$redis = [
    'host'    => '10.1.51.19:6379',
    'timeout' => FALSE,
    'expire'  => null,
    'pre'     => 'live:' // 前缀，便于多项目区分
];

$redis_slave = [
//    'host'    => [  //分布式 时权重配置方式
//        '10.1.51.19:6379' => 1,
//    ],
    'host'    => '10.1.51.19:6379',
    'timeout' => FALSE,
    'expire'  => null,
    'pre'     => 'live:' // 前缀，便于多项目区分
];