<?php
/**
 * Created by PhpStorm.
 * User: bosheng2017
 * Date: 2017/12/14
 * Time: 15:07
 */
namespace app\modules\ssnh\controller;

use app\modules\base\controller\BaseController;
use app\modules\ssnh\model\BigPlateDataModel;
use app\modules\ssnh\model\HupuArticleListModel;
use app\modules\ssnh\model\HupuHotWordModel;
use app\modules\ssnh\model\HupuUserModel;
use app\modules\ssnh\model\PlatePostNumModel;

class HupuController extends BaseController{

    /**
     * 首页面
     */
    public $layout = 'iframe_main';

    public function actionHome(){

        return $this->render(__FUNCTION__);
    }

    /**
     * 文章接口 （弃用）
     */
    public function actionArticleList(){

        $page = \Yii::$app->request->get('page', 1);
        $page_size = \Yii::$app->request->get('limit', 10);

        $article_list = HupuArticleListModel::getArticleList($page, $page_size);

        $this->jsonOk($article_list['article_list'], $article_list['count']);
    }

    /**
     * @desc 小话题图表分析页面
     *
     * @return string
     */
    public function actionAnalyze(){
        
        return $this->render(__FUNCTION__);
    }

    /**
     * 获取所有版块的 每日发帖数量
     *
     * @return void
     */
    public function actionAllPlateNum()
    {
//        $time_type = \Yii::$app->request->get('time_type', 'month');
//        $time_val = \Yii::$app->request->get('time_val', '');

        $date = \Yii::$app->request->get('date', date('Ymd', time()));
        $plate_data = PlatePostNumModel::getPlateData($date);
        $total_num = array_sum(array_column($plate_data, 'num')); // 各种板块总和

        $table_data = [];
        foreach ($plate_data as $pk => $pv){
            $data['id'] = $pv['id'];
            $data['plate'] = $pv['plate'];
            $data['name'] = PlatePostNumModel::getPlateName($pv['plate']);
            $data['y'] = (int)$pv['num']; //这里不转类型，highchart吃不消
            $data['per'] = bcmul(round($pv['num'] / $total_num, 4) , 100, 2);
//            $data['per'] = bcmul(round($pv['num'] / $total_num, 4) , 100);

            $data['drilldown'] = 'true';
            $table_data[] = $data;
        }
        $this->jsonOk($table_data);
    }

    /**
     * @desc 获取某一个板块该自然周 中每一天的发帖数量
     *
     * @return array
     */
    public function actionOnePlateNumByDate()
    {
        $plate_name = \Yii::$app->request->get('plate', 'bxj');
      //  $date = \Yii::$app->request->get('date');

        $today_date = date('Ymd', time() ); //strtotime("$date")

        $start_date = date('Ymd', strtotime("$today_date last sunday") + 86400); //这个星期一
        $end_date = date('Ymd', strtotime("$start_date") + 6*86400);

        $plate_data = PlatePostNumModel::getOnePlateData($plate_name,$start_date, $end_date);
        $table_data = ['name' => $plate_name, 'data' => []];
        $total_num = array_sum(array_column($plate_data, 'num')); // 各种板块总和
        foreach ($plate_data as $pk => $plate){
            $data['name'] = $plate['date'];
            $data['y'] = (int)$plate['num']; //这里不转类型，highchart吃不消
            $data['per'] = bcmul(round($plate['num'] / $total_num, 4) , 100, 2);
            $table_data['data'][] = $data;

        }

        $this->jsonOk($table_data);
    }

    /**
     * @desc 性别的比例数据
     *
     * @return string
     */
    public function actionGenderData(){

        $gender_data = HupuUserModel::getGenderData();
        $pie_table_data = [];
        foreach ($gender_data as $gk =>$gv){
            $data['name'] = HupuUserModel::getGenderName($gv['gender']);
            $data['y'] = (int)$gv['count'];
            $data['per'] =(int)ceil(($gv['count'] / 800));

            $pie_table_data[] = $data;
        }
        $this->jsonOk($pie_table_data);
    }

    /**
     * @return string
     */
    public function actionPlate(){
        return $this->render(__FUNCTION__);
    }

    /**
     * 大板块之间的对比
     *
     * @return array
     */
    public function actionBigPlate(){
        $date = $this->get('date', date('Ymd'));
        $big_plate_data = BigPlateDataModel::getDataByDate($date);
        $pie_table_data = [];
        foreach ($big_plate_data as $ak => $plate_data) {
            $data['name'] = BigPlateDataModel::$big_plate_array[$plate_data['big_plate']];
            $data['y'] = (int)$plate_data['day_post_num'];

            if($plate_data['big_plate'] == 'bxj') {
                $data['sliced'] = 'true';
                $data['selected'] = 'true';
            }

            $pie_table_data[] = $data;
        }
        $this->jsonOk($pie_table_data);
    }

    /**
     * 热词接口
     *
     * @return array
     */
    public function actionHotWord(){
        $plate = $this->get('plate', '');

        $hot_word_data = HupuHotWordModel::getHotWord($plate);
        $table_data = [];
        foreach ($hot_word_data as $hk => $hot_data){
            $data['name'] = $hot_data['word'];
            $data['weight'] = (int)$hot_data['number'];
            $table_data[] = $data;
        }
        $this->jsonOk($table_data);
    }

    /**
     * @desc 用来测试的ajax 接口
     *
     * @return string
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
                'drilldown' => 'true'
            ],
            [
                'name' => '星期三',
                'y' => 40,
                'drilldown' => 'true'
            ],
            [
                'name' => '星期四',
                'y' => 60,
                'drilldown' => 'true'
            ],
            [
                'name' => '星期五',
                'y' => 700000,
                'drilldown' => 'true'
            ],
            [
                'name' => '星期六',
                'y' => 80,
                'drilldown' => 'true'
            ],
            [
                'name' => '星期日',
                'y' => 100,
                'drilldown' => 'true'
            ],
        ];
        $this->jsonOk([[ 'name' => '第一','weight'=> 5] ,[ 'name' => '第二','weight'=> 1],[ 'name' => '第三','weight'=> 1],[ 'name' => '第四','weight'=> 1]]);
//        $this->jsonOk([ '第一'=> 10 , '第er'=> 10, '第san'=> 10, '第si'=> 10]);
    }
}