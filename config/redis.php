<?php

return [
    'default_redis' => [
        'host'    => '127.0.0.1:6379',
        'timeout' => FALSE,
        'expire'  => null,
        'pre'     => 'arashi:' // 前缀，便于多项目区分
    ],
    'default_redis_slave' => [
        'host'    => [  //分布式 时权重配置方式
            '127.0.0.1:6379' => 1,
        ],
        //   'host'    => '10.1.51.19:6379',
        'timeout' => FALSE,
        'expire'  => null,
        'pre'     => 'arashi:' // 前缀，便于多项目区分
    ]
];