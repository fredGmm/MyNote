<?php
/*
 * http://www.yiiframework.com/
 * */
namespace app\models;

use yii\mongodb\Query;
use yii\mongodb\ActiveRecord;
use yii\data\ActiveDataProvider;

class MongdbModel extends ActiveRecord
{
    //指定集合名称
    public static function collectionName()
    {
        return 'web_page';
    }

    //定义字段属性
    public function attributes()
    {
        return [
            '_id',
            'article_content',
            'title',
            'images',
            'category',
            'timestamp'
        ];
    }

    /**
     * 查询文档 - 聚合查询
     */
    public static function cmsInfo(){
        $query = new Query ();
        $row = $query->select(['id,article_content','title','timestamp'])
            ->from ( self::collectionName() )
            ->where(['title' => '11111']);
//            ->average('age');//age的平均值
//            ->max('age');//age最大的值
//            ->min('age');//age最小的值
//            ->sum('ccy');//ccy所有列相加的和
//            ->count('_id');//当前数据总数
        return $row->all();
    }

    /**
     * 分页查询文档
     * @param int $start 开始
     * @param int $limit 页面大小
     * @return array
     */
    public static function getArticleList($start, $limit=100, $category = '')
    {
        $query = new Query ();
        $data = $query->select(['id','article_content','images','type','category','title','timestamp'])
            ->from ( self::collectionName() )
            ->offset($start)
            ->limit($limit);

        if(!empty($category)) {
            $data->where(['category' => $category]);
        }

        return $data->all();
    }

    /**
     * 查询文档总数
     * @param array $where 条件
     * @return int
     */
    public static function getCount($where = [])
    {
        $count = (new Query ())->select(['id,article_content','title','timestamp'])
            ->from ( self::collectionName() );
        if($where){
            $count->where($where);
        }
        return $count->count();
    }

}
