<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 2017/9/13
 * Time: 22:41
 */
namespace app\modules\admin\controller;

use app\modules\base\controller\BaseController;
use app\modules\food\service\FoodAlgorithm;
use yii\base\Controller;

class HomeController extends BaseController {

    public function actionIndex()
    {
        return $this->render(__FUNCTION__);
    }
}