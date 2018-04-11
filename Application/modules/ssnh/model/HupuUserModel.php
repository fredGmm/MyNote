<?php
/**
 * @author FredGui
 * @version 2017-10-15
 * @modify  2017-10-15
 * @description 虎扑用户的数据处理
 * @link http://www.cnblogs.com/guixiaoming
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
 */
namespace app\modules\ssnh\model;

use app\modules\base\model\BaseTable;
use yii\db\Expression;

class HupuUserModel extends BaseTable
{
    const TableName = 'hupu_user';

    /**
     * @desc 选择数据库
     *
     * @return mixed
     */
    public static function getDb()
    {
        return \Yii::$app->hupuDb;
    }

    /**
     * 根据性别代值获取 对应的 中文描述
     * @param $gender
     * @return mixed|string
     */
    public static function getGenderName($gender)
    {
        $gender_arr = [
            '2' => '男',
            '1' => '女',
            '0' => '未知',
        ];

        return isset($gender_arr[$gender]) ? $gender_arr[$gender] : '未知';
    }

    /**
     * 获取性别分组统计数据
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getGenderData()
    {
        $gender_data = self::find()->select(['gender', 'count' => new Expression('count(*)')])
            ->groupBy('gender')
            ->orderBy('gender')
            ->asArray()
            ->all();

        return $gender_data;
    }

    /**
     * @desc 在线时间的统计。 在线时长 在一个时间段区间内的用户数。比较复杂
     *
     * @see http://www.cnblogs.com/guixiaoming/p/8672343.html
     * @return array
     */
    public static function onlineTimeData($where = [])
    {
        $query = self::find()
            ->select(
                [
                    'online_time' => new Expression('ELT(INTERVAL(h.online_time,0, 50,100, 300,500,700, 1000,2000,5000), \'0~50\',\'50~100\',\'100~300\', \'300~500\', \'500~700\', \'700~1000\',\'1000~2000\',\'2000~5000\',\'5000以上\')'),
                    'count'       => new Expression('count(h.online_time)'),
                    //   'year' => new Expression('YEAR(reg_time)')
                ]);
        if ($where) {
            $query->where($where);
        }
        $data = $query->groupBy(new Expression('ELT(INTERVAL(h.online_time,0, 50,100, 300,500,700, 1000,2000,5000), \'0~50\',\'50~100\',\'100~300\', \'300~500\', \'500~700\', \'700~1000\',\'1000~2000\',\'2000~5000\',\'5000以上\')'))
            // ->addGroupBy(new Expression('YEAR(reg_time)'))
            ->orderBy('h.online_time')
            ->from('hupu_user as h')
            ->asArray()
            ->all();
        return $data;
    }

    /**
     * 获取注册时间的数据
     *
     * @return array
     */
    public static function getRegData()
    {
        $data = self::find()->select([
            'reg_year' => new Expression('YEAR(reg_time)'),
            'count'    => new Expression('count(*)'),
        ])
            ->groupBy(new Expression('YEAR(reg_time)'))
            ->asArray()->all();

        return $data;
    }
}