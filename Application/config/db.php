<?php

return [
    'db' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=192.168.1.111;dbname=web_arashi',
        'username' => 'root',
        'password' => 'xiaoming',
        'charset' => 'utf8',
    ],
    'hupuDb' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=192.168.1.111;dbname=web_data',
        'username' => 'root',
        'password' => 'xiaoming',
        'charset' => 'utf8',
    ]

];
