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

    //添加文档方法1
    public static function insertInfo(){
        $collection = \Yii::$app->mongodb->getCollection (Customer::collectionName());
        //返回添加后的objectId，不限制于attributes
        $res = $collection->insert([
            'name' => 'John Smith22',
            'status' => 2
        ]);
        return $res;
    }

    //添加文档方法2，限制于attributes
    public static function saveInfo(){
        $customer = new Customer();
        $customer->title = '111';
        $customer->description = '222';
        $customer->insert();
        //toArray() 将对象转为数组，返回本次添加的数据JSON
        return $customer->toArray();
    }

    //删除文档
    public static function deleteInfo(){
        //返回删除的记录数
        $res = Customer::deleteAll([
            '_id' => '58ddf84f36420258358b4567'
        ]);
        return $res;
    }

    //编辑文档 - [set],[where] @修改符合条件的所有记录，没有title字段则创建
    public static function updateInfo(){
        //返回更新的条数
        $res = Customer::updateAll(
            ['title' => 'gg','description' => 'nn',],
            ['_id' => '58ddf8653642026c148b4567']
        );
        return $res;
    }

    //编辑文档 - 在所有文档中增加 age & ccy 如存在则会+1
    public static function countersInfo(){
        //返回更新的条数
        $res = Customer::updateAllCounters(['age' => 1,'ccy' => 3]);
        return $res;
    }

    //查询文档 - 聚合查询
    public static function cmsInfo(){
        $query = new Query ();
        $row = $query->select(['id,article_content','title','timestamp'])
            ->from ( self::collectionName() )
            ->where(['title' => '11111']);

//            ->average('age');//age的平均值
        //->max('age');//age最大的值
        //->min('age');//age最小的值
        //->sum('ccy');//ccy所有列相加的和
        //->count('_id');//当前数据总数
        return $row->all();
    }

    /**
     * 分页查询文档
     * @param $page
     * @param $page_size
     * @return array
     */
    public static function getArticleList($start, $page_size=100, $category = '')
    {
        $query = new Query ();
        $data = $query->select(['id','article_content','images','type','category','title','timestamp'])
            ->from ( self::collectionName() )
            ->offset($start)
            ->limit($page_size);

        if(!empty($category)) {
            $data->where(['category' => $category]);
        }

        return $data->all();
    }

    /**
     * 查询文档总数
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
    //查询文档 - 可用于分页列表
    public static function selectInfo(){
        $query = new Query ();
        $query->select(['title','description'])
            ->from (Customer::collectionName())
            ->offset ( 4 )
            ->limit ( 2 );
        $rows = $query->all();
        return $rows;
    }

    //查询文档 - 根据条件只查询一条数据
    public static function oneInfo(){
        $query = new Query ();
        $row = $query->select(['title','url'])
            ->from ( Customer::collectionName() )
            ->where(['_id' => '58ddf8653642026c148b4567'])
            ->one ();
        return $row;
    }

    //ActiveDataProvider 方式查询1
    public static function adp1Info(){
        $provider = new ActiveDataProvider ( [
            'query' => Customer::find (),
            'pagination' => [
                'totalCount' => 10,
                'pageSize' => 2,
                'page' => 4
            ]//可用于分页
        ] );
        $models = $provider->getModels ();
        return $models;
    }

    //ActiveDataProvider 方式查询2
    public static function adp2Info(){
        $query = new Query ();
        $query->select(['title'])->from ( Customer::collectionName() )->where ( [
            'title' => 'test'
        ] );
        $provider = new ActiveDataProvider ( [
            'query' => $query,
            'pagination' => [
                'totalCount' => 10,
                'pageSize' => 2,
                'page' => 2
            ]//可用于分页
        ] );
        $models = $provider->getModels ();
        return $models;
    }
}
