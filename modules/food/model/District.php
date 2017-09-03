<?php
/**
 * Created by PhpStorm.
 * User: FredGui
 * Date: 2016/8/26
 * Time: 17:20
 */

namespace app\mvc\task\model;

use app\mvc\_base\model\BaseTable;

class District extends BaseTable{
    const TableName = 'district_data';

    public static function getDb()
    {
        return \Yii::$app->position_data;
    }
}