<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 2017/11/2
 * Time: 21:13
 */

namespace app\models;

use yii\db\ActiveRecord;

Abstract class BaseTable extends ActiveRecord
{
    const TableName = 'no_select_table';

    public static function tableName()
    {
        return '{{' . static::TableName . '}}';
    }
}