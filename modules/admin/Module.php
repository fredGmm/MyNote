<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 2017/8/15
 * Time: 21:56
 */
namespace app\modules\admin;

use app\modules\BaseModule;

class Module extends BaseModule{
    
    public function init()
    {
        parent::init();
        $this->controllerNamespace = __NAMESPACE__ . parent::CtrlNameSpace;

        $this->setLayoutPath(__DIR__ . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layout');
    }
}