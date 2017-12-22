<?php
/**
 * Created by PhpStorm.
 * User: bosheng2017
 * Date: 2017/12/14
 * Time: 15:07
 */
namespace app\modules\ssnh\controller;

use app\modules\base\controller\BaseController;
use app\modules\ssnh\model\HupuArticleListModel;

class HupuController extends BaseController{

    /**
     * 首页面
     */
    public $layout = 'iframe_main';

    public function actionHome(){

        return $this->render(__FUNCTION__);
    }

    public function actionArticleList(){

        $page = \Yii::$app->request->get('page', 1);
        $page_size = \Yii::$app->request->get('limit', 10);

        $article_list = HupuArticleListModel::getArticleList($page, $page_size);

        $this->jsonOk($article_list['article_list'], $article_list['count']);
    }

    public function actionAnalyze(){
        
        return $this->render(__FUNCTION__);
    }
}