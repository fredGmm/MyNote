<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 2017/8/30
 * Time: 21:54
 */
namespace app\modules\user\controller;

class LoginController extends \yii\base\Controller{

    public $layout = false;
    public function actionIndex(){

        return $this->render('Index');
    }

}