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
            ->asArray()
            ->all();

        return $gender_data;
    }
}