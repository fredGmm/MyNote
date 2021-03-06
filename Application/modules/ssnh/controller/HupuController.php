<?php
/**
 * @author FredGui
 * @version 2017-10-15
 * @modify  2017-3-11
 * @description 虎扑数据的处理输出
 * @link http://blog.kinggui.com
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
 */
namespace app\modules\ssnh\controller;

use app\library\Cache\BaseRedis;
use app\library\Common;
use app\modules\base\controller\BaseController;
use app\modules\ssnh\model\BigPlateDataModel;
use app\modules\ssnh\model\HupuArticleListModel;
use app\modules\ssnh\model\HupuHotWordModel;
use app\modules\ssnh\model\HupuUserModel;
use app\modules\ssnh\model\PlatePostNumModel;
use yii\db\Expression;

/**
 * 数据逻辑的处理,前端图标的展示是选择的 Highcharts
 * @see https://www.hcharts.cn
 * @package app\modules\ssnh\controller
 */
class HupuController extends BaseController
{

    /**
     * 布局
     */
    public $layout = 'admin_main';

    //虎扑论坛域
    const HUPU_BBS_DOMAIN = 'https://bbs.hupu.com';

    /**
     * 文章整体分析 页面
     * @return string
     */
    public function actionGlobalAnalysis()
    {

        return $this->render(__FUNCTION__);
    }
    /**
     * 用户分析 页面
     * @return string
     */
    public function actionUserAnalysis()
    {

        return $this->render(__FUNCTION__);
    }

    /**
     * 板块对比 页面
     *
     * @return string
     */
    public function actionPlateAnalysis()
    {
        return $this->render(__FUNCTION__);
    }

    /**
     * 文章接口,文章列表
     */
    public function actionArticleList()
    {

        $page      = \Yii::$app->request->get('page', 1);
        $page_size = \Yii::$app->request->get('limit', 10);

        $article_list = HupuArticleListModel::getArticleList($page, $page_size);
        if(empty($article_list['count'])) {
            $this->jsonOk([], 0);
        }
        foreach ($article_list['article_list'] as $ak => &$article) {
            $article_url = self::HUPU_BBS_DOMAIN . '/' . $article['article_id'] . '.html';

            $article['article_url'] = "<a href=\"$article_url\"class=\"layui-btn  layui-btn-xs\" target='_blank' lay-event=\"detail\">查看</a>";
        }
        $this->jsonOk($article_list['article_list'], $article_list['count']);
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

        $date       = \Yii::$app->request->get('date', date('Ymd', time()));
        $plate_data = PlatePostNumModel::getPlateData($date);
        $total_num  = array_sum(array_column($plate_data, 'num')); // 各种板块总和

        $table_data = [];
        foreach ($plate_data as $pk => $pv) {
            $data['id']    = $pv['id'];
            $data['plate'] = $pv['plate'];
            $data['name']  = PlatePostNumModel::getPlateName($pv['plate']);
            $data['y']     = (int)$pv['num']; //这里不转类型，highchart吃不消
            $data['per']   = bcmul(round($pv['num'] / $total_num, 4), 100, 2);

            $data['drilldown'] = 'true';
            $table_data[]      = $data;
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

        $today_date = date('Ymd', time()); //strtotime("$date")

        $start_date = date('Ymd', strtotime("$today_date last sunday") + 86400); //这个星期一
        $end_date   = date('Ymd', strtotime("$start_date") + 6 * 86400);

        $plate_data = PlatePostNumModel::getOnePlateData($plate_name, $start_date, $end_date);
        $table_data = ['name' => $plate_name, 'data' => []];
        $total_num  = array_sum(array_column($plate_data, 'num')); // 各种板块总和
        foreach ($plate_data as $pk => $plate) {
            $data['name']         = $plate['date'];
            $data['y']            = (int)$plate['num']; //这里不转类型，highchart吃不消
            $data['per']          = bcmul(round($plate['num'] / $total_num, 4), 100, 2);
            $table_data['data'][] = $data;
        }

        $this->jsonOk($table_data);
    }

    /**
     * @desc 性别的比例数据
     *
     * @return string
     */
    public function actionGenderData()
    {
        $gender_data    = HupuUserModel::getGenderData();
        $pie_table_data = [];
        foreach ($gender_data as $gk => $gv) {
            $data['name'] = HupuUserModel::getGenderName($gv['gender']);
            $data['y']    = (int)$gv['count'];
            $data['per']  = (int)ceil(($gv['count'] / 800));

            $pie_table_data[] = $data;
        }
        $this->jsonOk($pie_table_data);
    }

    /**
     * 大板块之间的对比
     *
     * @return array
     */
    public function actionBigPlate()
    {
        $date           = $this->get('date', date('Ymd'));
        $big_plate_data = BigPlateDataModel::getDataByDate($date);
        $pie_table_data = [];
        foreach ($big_plate_data as $ak => $plate_data) {
            $data['name'] = BigPlateDataModel::$big_plate_array[$plate_data['big_plate']];
            $data['y']    = (int)$plate_data['day_post_num'];

            if ($plate_data['big_plate'] == 'bxj') {
                $data['sliced']   = 'true';
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
    public function actionHotWord()
    {
        $date = $this->get('date', date('Ymd'));
        $plate = $this->get('plate', '');
        $max_date = HupuHotWordModel::getDataMaxDate();

        $date = ($date >= $max_date) ? $max_date : $date;
        $hot_word_data = HupuHotWordModel::getHotWord($plate, $date);

        $table_data    = [];
        //需要给出 highchart 定的键值
        foreach ($hot_word_data as $hk => $hot_data) {
            $data['name']   = $hot_data['word'];
            $data['weight'] = (int)$hot_data['number'];
            $table_data[]   = $data;
        }
        $this->jsonOk($table_data);
    }

    /**
     * 每天按照小时的发帖趋势图数据
     *
     * @return array
     */
    public function actionPostNumLineByHour()
    {
        $date = $this->get('date', date('Y-m-d'));
        $max_date = HupuArticleListModel::getDataMaxDate();

        $max_date_time = strtotime($max_date);
        $date_time = strtotime($date);
        $date = $date_time >= $max_date_time ? date('Y-m-d', $max_date_time) : date('Y-m-d', $date_time);

        $data = HupuArticleListModel::getDataByHour($date);
        $bxj  = []; //步行街折线数据
        $lol  = []; //lol折现数据
        $vote = []; //湿乎乎折线数据
        foreach ($data as $dk => $dv) {
            if ($dv['plate'] == 'bxj') {
                $bxj[] = ['y' => (int)$dv['count'], 'name' => $dv['post_hour'] . '时'];
            } elseif ($dv['plate'] == 'lol') {
                $lol[] = ['y' => (int)$dv['count'], 'name' => $dv['post_hour'] . '时'];
            } elseif ($dv['plate'] == 'vote') {
                $vote[] = ['y' => (int)$dv['count'], 'name' => $dv['post_hour'] . '时'];
            } else {
            }
        }
        $line_data = [['name' => '步行街', 'data' => $bxj], ['name' => '英雄联盟', 'data' => $lol], ['name' => '湿乎乎', 'data' => $vote]];
        $this->jsonOk($line_data);
    }

    /**
     * 统计发帖来自 iPhone,Android，web的比例
     *
     * @return string
     */
    public function actionGetArticleFrom()
    {
        $from_data      = HupuArticleListModel::getArticleFrom();
        $pie_table_data = [];
        foreach ($from_data as $fk => $fv) {
            if (!empty($fv['post_from'])) {
                $data['name']     = $fv['post_from'];
                $data['y']        = (int)$fv['count'];
                $pie_table_data[] = $data;
            }
        }
        $this->jsonOk($pie_table_data);
    }

    /**
     * 在线时间的统计
     *
     * @return string
     */
    public function actionOnlineTime()
    {
        $data       = HupuUserModel::onlineTimeData();
        $user_count = array_sum(array_column($data, 'count'));

        array_walk($data, function (&$v) {
            $v = [$v['online_time'], (int)$v['count']];
//            $v['count'] = (int)$v['count'];
//            $v['per'] = bcmul(round($v['count'] / $user_count, 4), 100, 2) . '%';
        });
        $this->jsonOk($data, $user_count);
    }

    /**
     * 这是一个复合统计数据，在线时间与注册时间相关联，统计注册区段的同时能看在线时间的分布
     *
     * @see http://www.cnblogs.com/guixiaoming/p/8672343.html
     * @return string
     */
    public function actionRegTime()
    {
        $data             = HupuUserModel::getRegData();
        $year             = date('Y', time()); //今年的年份
        // 时间区段 2004 ~ 2018
        $table_data       = [
            ['name' => '0~50', 'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]],
            ['name' => '50~100', 'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]],
            ['name' => '100~300', 'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]],
            ['name' => '300~500', 'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]],
            ['name' => '500~700', 'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]],
            ['name' => '700~1000', 'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]],
            ['name' => '1000~2000', 'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]],
            ['name' => '2000~5000', 'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]],
            ['name' => '5000以上', 'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]],
        ];
        $table_data_names = array_column($table_data, 'name');

        foreach ($data as $dk => &$dv) {
            /** 这一步需要优化下~~ */
            $online_in_year       = HupuUserModel::onlineTimeData(new Expression('YEAR(reg_time) = ' . $dv['reg_year']));
            $online_in_year       = Common::putValToKey($online_in_year, 'online_time');
            $dv['year']           = $year - $dv['reg_year'];
            $dv['online_in_year'] = $online_in_year;
            foreach ($online_in_year as $range => $ov) {
                $table_name_index                                              = array_search($range, $table_data_names);
                $table_data[$table_name_index]['data'][$dv['reg_year'] - 2004] = (int)$ov['count'];
            }
        }
        $this->jsonOk($table_data);
    }

    /**
     * 首页随机展示图片，目前资源有限，直接在目录下读取，然后随机展示了~~
     */
    public function actionGetImages(){

//        $redis = BaseRedis::getInstance();
//        $image_list = json_decode($redis->get('getImagesList'), true);
        if(empty($image_list)) {
            $image_path = dirname(\Yii::$app->getBasePath()) . '/web/static/img/hupu/';

            $web_path =\Yii::getAlias('@web/static/img/hupu/');

            $file_list = scandir($image_path);
            //去除 .和..
            $key1=array_search('.' ,$file_list);
            array_splice($file_list,$key1,1);
            $key2=array_search('..' ,$file_list);
            array_splice($file_list,$key2,1);
            $article_list = [];
            foreach ($file_list as $fk => $fv) {
                $image_info = explode('_', $fv);
                $article_info = HupuArticleListModel::findOne(['article_id' => $image_info[1]]);
                $article_url       = self::HUPU_BBS_DOMAIN . '/' . $image_info[1] . '.html';

                $title = $article_info['article_title'] ?? '';
                $article_list[$fk] = ['url' => $article_url, 'title' => $title];
            }

            $random_keys = array_rand($file_list, 8);
            $image_list = [];
            foreach ($random_keys as $rk => $rv) {

                $image = [
                    'image_path' =>  $web_path . $file_list[$rv],
                    'image_url' => $article_list[$rk]['url'],
                    'title' => '标题：' . $article_list[$rk]['title'],
                ];
                $image_list[] = $image;
            }

//            $redis->set('getImagesList', json_encode($image_list), 1800);
        }

        $this->jsonOk($image_list);
    }

    /**
     * @desc 用来测试的ajax 接口
     *
     * @return string
     */
    public function actionAjaxTest()
    {
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
        $this->jsonOk($data);
    }
}