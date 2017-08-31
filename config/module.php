<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 2017/8/14
 * Time: 23:38
 */

//定义 模块名
$modsName = [
    'user',
    'base',
    'food'
];


//以下部分 无特殊情况 不用修改
$modules = [
//    //基础模块 必须 先初始化
//    'base' => [
//        'class' => 'app\modules\BaseModule',
//    ],
];
foreach ($modsName as $mName) {
    $modules [$mName] = ['class' => "app\\modules\\{$mName}\\Module"];
}

return $modules;