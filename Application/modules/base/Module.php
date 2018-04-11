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
namespace app\modules\base;

use app\modules\BaseModule;

class Module extends BaseModule{
    
    public function init()
    {
        parent::init();
        $this->controllerNamespace = __NAMESPACE__ . parent::CtrlNameSpace;

        $this->setLayoutPath(__DIR__ . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layout');
    }
}