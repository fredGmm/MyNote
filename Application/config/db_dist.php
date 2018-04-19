<?php
/**
 * 数据库配置。 不同节点的配置，对应使用它的键名
 *
 * @see app\modules\ssnh\model\HupuArticleListModel.php getDb() 重写
 */
$dbArray = [
    'db'     => [
        'class'    => 'yii\db\Connection',
        'dsn'      => 'mysql:host=192.168.1.111;dbname=web_arashi',
        'username' => 'root',
        'password' => 'xiaoming',
        'charset'  => 'utf8',
    ],
    'hupuDb' => [
        'class'    => 'yii\db\Connection',
        'dsn'      => 'mysql:host=192.168.1.111;dbname=web_data',
        'username' => 'root',
        'password' => 'xiaoming',
        'charset'  => 'utf8',
    ],
];

return ['db' => $dbArray['db'], 'hupuDb' => $dbArray['hupuDb']];
