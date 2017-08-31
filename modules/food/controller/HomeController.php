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

class HomeController extends BaseController {

    public function actionFuck(){
        
        return $this->render('Fuck');
    }
}