<?php
/**
 * @author FredGui
 * @version 2017-8-19
 * @modify  2017-8-19
 * @description 模块加载
 * @link http://blog.kinggui.com
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
 */
namespace app\modules;

use yii;
use yii\base\Module;


class BaseModule extends Module
{
    //常量
    const CtrlNameSpace = '\controller';

    const MainLayoutName = 'main';

    /**
     * 初始化，经常 变动的 在外部 定义变量， 方便 继承后 直接赋值改动
     */
    public function init()
    {
        $this->controllerNamespace = __NAMESPACE__ . self::CtrlNameSpace;
        //不变动或不经常变动的 放方法中初始化， 省去 子类 初始化
        $this->defaultRoute = 'index';
        $this->layout       = self::MainLayoutName;
        $this->setLayoutPath(__DIR__ . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layout');
    }
}