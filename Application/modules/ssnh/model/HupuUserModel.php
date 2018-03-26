<?php
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

    public static function getGenderName($gender){
        $gender_arr = [
            '2' => '男',
            '1' => '女',
            '0' => '未知'
        ];

        return isset($gender_arr[$gender]) ? $gender_arr[$gender] : '未知';
    }

    public static function getGenderData()
    {
        $gender_data = self::find()->select(['gender','count' => new Expression('count(*)')])
            ->groupBy('gender')
            ->orderBy('gender')
            ->asArray()
            ->all();

        return $gender_data;
    }

    /**
     * @desc 在线时间的统计
     *
     * @return array
     */
    public static function onlineTimeData(){
        $data = self::find()
            ->select(
                [
                    'online' => new Expression('ELT(INTERVAL(h.online_time,0, 100, 300,500,700, 1000,2000,5000), \'less100\', \'100to300\', \'500to700\', \'700to1000\',\'1000to2000\',\'2000to5000\',\'more5000\')'),
                    'count'=> new Expression('(h.online_time)') ])
            ->groupBy(new Expression('ELT(INTERVAL(h.online_time,0, 100, 300,500,700, 1000,2000,5000), \'less100\', \'100to300\', \'500to700\', \'700to1000\',\'1000to2000\',\'2000to5000\',\'more5000\')'))
            ->from('hupu_user as h')
            ->asArray()
            ->all();
        return $data;
    }

}