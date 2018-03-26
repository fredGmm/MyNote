<?php
/**
 * Created by PhpStorm.
 * User: fredGui
 * Date: 2017/9/3
 * Time: 21:06
 */
namespace app\modules\ssnh\model;

use app\modules\base\model\BaseTable;
use yii\db\Expression;

/**
 * 文章列表model类
 */
class HupuArticleListModel extends BaseTable {

    /**
     * 脚本跑的最大页面，调试或者限制用
     */
    const MAX_PAGE = 10;

    const TableName = 'hupu_article_list';

    public static function getDb()
    {
        return \Yii::$app->hupuDb;
    }


    /**
     * @desc 存新的食物信息
     * @param $food_info
     * @return bool
     */
    public static function saveNewFood($food_info){
        $food_choose_model = new self;
        $food_choose_model->food_name = $food_info['food_name'];
        $food_choose_model->food_price = $food_info['price'];
        $food_choose_model->shop_name = $food_info['shop_name'];
        $food_choose_model->address = isset($food_info['address']) ? $food_info['address'] : '';
        $food_choose_model->ip = ISSET($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        $food_choose_model->fit_type = $food_info['fit_type'];
        $food_choose_model->kind = $food_info['kind'];
        $food_choose_model->description = $food_info['description'];
        $food_choose_model->user_id = 0;
        $food_choose_model->create_time = time();
        return $food_choose_model->save();
    }

    /**
     * @desc 取得文章列表
     * @param $page
     * @param int $page_size
     * @return array
     */
    public static function getArticleList($page, $page_size = 2){

        $start = ($page - 1) * $page_size;
        $foods = self::find()->offset($start)->limit($page_size)->asArray()->all();
        $count = self::find()->count();
        
        return ['article_list'=>$foods, 'count'=>$count];
    }

    /**
     * @desc 取得文章来源的地址
     *
     * @return array
     */
    public static function getArticleFrom(){
        $from_data = self::find()
            ->select(['post_from','count' => new Expression('count(*)')])
            ->groupBy('post_from')
            ->asArray()
            ->all();
        return $from_data;
    }
    
    
    /**
     * 取得每小时发帖数目数据，板块区分
     *
     * @return array
     */
    public static function getDataByHour($date)
    {
        $data = self::find()
            ->select(['plate','post_hour','count' => new Expression('count(*)')])
            ->where(['post_date' => $date ])
            ->groupBy('plate,post_hour')
            ->asArray()->all();
        return $data;
    }

    /**
     * @desc 生成文章的迭代生成器，yield 占用少的内存
     *
     * @param $page int
     * @param $page_size int
     * @param $where array 查询的特定条件
     * @return \Generator
     */
    public static function articleIterator($page, $page_size,$where = []){
        $query = self::find()->orderBy('id desc');
        if($where){
            $query->where($where);
        }
        $total_count = $query->count();
        $page_max = $total_count / $page_size;
        do{
            $offset = ($page - 1) * $page_size;
            $article_data =  $query->offset($offset)->limit($page_size)->asArray()->all();
            $page++;
            yield $article_data;
        }while(count($article_data) < $page_size || ($page <= $page_max) || ($page > self::MAX_PAGE));
    }
}