<?php
/**
 * @author FredGui
 * @version 2017-10-15
 * @modify  2017-10-15
 * @description 板块的模型
 * @link http://www.cnblogs.com/guixiaoming
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
 */

namespace app\modules\ssnh\model;

use app\modules\base\model\BaseTable;

class BigPlateDataModel extends BaseTable
{

    const TableName = 'big_plate_data';

    /**
     * 每个大板块简称 对应的中文
     */
    public static $big_plate_array = [
        'nba'               => 'nba论坛',
        'site'              => '站务论坛',
        'sports'            => '综合体育论坛',
        'financial'         => '彩票中心',
        'hupu_society'      => '虎扑社团',
        'bxj_main'          => '步行街主干道',
        'china_football'    => '中国足球论坛',
        'cba'               => 'CBA论坛',
        'equipment'         => '装备论坛',
        'electronic_sports' => '游戏电竞',
        'self_plate'        => '自建模块',
    ];

    /**
     * 获取链接的db
     * @return mixed
     */
    public static function getDb()
    {
        return \Yii::$app->hupuDb;
    }

    /**
     * 获取板块名字
     * @param $plate_key
     * @return bool|string
     */
    public static function getPlateName($plate_key)
    {
        return isset(self::$big_plate_array[$plate_key]) ?? '未知';
    }

    /**
     * @desc 新增一条记录
     * @param $data
     * @return bool
     */
    public function addPlateData($data)
    {

        return $this->diySaveAttribs($data);
    }

    /**
     * @desc 取得每日的大板块发帖数目之和
     * @param $date
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getDataByDate($date)
    {

        $data = self::find()->select(['id', 'big_plate', 'day_post_num', 'date'])
            ->where(['date' => $date])
            ->asArray()->all();
        return $data;
    }
}