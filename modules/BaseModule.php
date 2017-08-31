<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 2017/8/15
 * Time: 21:52
 */
namespace app\modules;

use yii;
use yii\base\Module;


class BaseModule extends Module
{
    //常量
    const CtrlNameSpace = '\controller';

    const MainLayoutName = 'main';

    //经常 变动的 在外部 定义变量， 方便 继承后 直接赋值改动
    public function init()
    {
        $this->controllerNamespace = __NAMESPACE__ . self::CtrlNameSpace;
        //不变动或不经常变动的 放方法中初始化， 省去 子类 初始化
        $this->defaultRoute = 'index';
        $this->layout       = self::MainLayoutName;
        $this->setLayoutPath(__DIR__ . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layout');
    }
}