<?php
/**
 * @author FredGui
 * @version 2017-8-30
 * @modify  2017-8-30
 * @description 模块加载
 * @link http://blog.kinggui.com
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
 */
namespace app\modules\user\controller;

use app\modules\base\controller\BaseController;

class LoginController extends BaseController{

    public $layout = false;
    public function actionIndex(){
        return $this->render('Index');
    }

}