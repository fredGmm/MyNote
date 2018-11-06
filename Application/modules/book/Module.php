<?php
/**
 * @author FredGui
 * @version 2018-8-19
 * @modify  2018-8-19
 * @description 模块加载
 * @link http://blog.kinggui.com
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
 */
namespace app\modules\book;

use app\modules\BaseModule;

class Module extends BaseModule
{

    public function init()
    {
        parent::init();
        $this->controllerNamespace = __NAMESPACE__ . parent::CtrlNameSpace;
    }
}