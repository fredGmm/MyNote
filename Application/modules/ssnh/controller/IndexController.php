<?php
/**
 * Created by PhpStorm.
 * User: bosheng2017
 * Date: 2017/12/11
 * Time: 14:07
 */

namespace app\modules\ssnh\controller;

use app\modules\base\controller\BaseController;

/**
 * Class IndexController
 * @package app\modules\ssnh\controller
 */
class IndexController extends BaseController{


    public function actionIndex(){

        $this->view->title = '山水年华业务意见集合';
        return $this->render(__FUNCTION__);
    }
}