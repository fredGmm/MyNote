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

    /**
     * @desc 用来测试的ajax 接口
     *
     * @return json
     */
    public function actionAjaxTest(){
        $param1 = \Yii::$app->request->get('param1', 'default_get_1');
        $param2 = \Yii::$app->request->get('param2', 'default_get_1');
        $param3 = \Yii::$app->request->post('param3', 'default_post_1');
        $param4 = \Yii::$app->request->post('param4', 'default_post_1');

        $data = [
            'p1' => $param1,
            'p2' => $param2,
            'p3' => $param3,
            'p4' => $param4,
        ];
        $data = [
            [
                'name' => 'www',
                'y' => 30,
                'id' => '4',
                'drilldown' => 'true'
            ],
            [
                'name' => '星期二',
                'y' => 20,
                'drilldown' => 'nbnbnbnbn'
            ],
            [
                'name' => '星期三',
                'y' => 40,
                'drilldown' => 'nbnbnbnbn'
            ],
            [
                'name' => '星期四',
                'y' => 60,
                'drilldown' => 'nbnbnbnbn'
            ],
            [
                'name' => '星期五',
                'y' => 70,
                'drilldown' => 'nbnbnbnbn'
            ],
            [
                'name' => '星期六',
                'y' => 80,
                'drilldown' => 'nbnbnbnbn'
            ],
            [
                'name' => '星期日',
                'y' => 100,
                'drilldown' => 'nbnbnbnbn'
            ],
        ];
        $this->jsonOk($data);
    }
}