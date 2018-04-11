<?php
/**
 * @author FredGui
 * @version 2017-11-02
 * @modify  2017-11-02
 * @description 基础模型
 * @link http://blog.kinggui.com
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
 */

namespace app\models;

use yii\db\ActiveRecord;

/**
 * 基类model，每个表model可以继承它
 * @package app\models
 */
Abstract class BaseTable extends ActiveRecord
{
    // 表名，继承后重写
    const TableName = 'no_select_table';

    public static function tableName()
    {
        return '{{' . static::TableName . '}}';
    }
}