<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 2017/8/31
 * Time: 21:50
 */

namespace app\modules\food\controller;

use app\modules\base\controller\BaseController;
use yii\base\Controller;

class ChooseController extends BaseController {

    public function actionEat(){

        $foods = [10=>'茄子煲', 30=>'鱼香肉丝', 18=>'面食', 20=>'牛肉粉', 22=>'老婆饼'];

        return $this->render(__FUNCTION__,['data' =>$foods]);
    }



}