<?php
/**
 * Created by PhpStorm.
 * User: FredGui
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

        //后台左上标题设置
        $this->view->title = '(●°u°●)​ 」乐趣爬虫实验室';
        
        return $this->render(__FUNCTION__);
    }
}