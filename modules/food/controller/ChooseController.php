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

        $foods = ['茄子煲','鱼香肉','面食'];

        $a = 'a';
        return $this->render(__FUNCTION__,['data' =>$foods],['a' => $a, 'b'=> 'bbb']);
    }



}