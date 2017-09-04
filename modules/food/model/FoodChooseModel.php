<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 2017/9/3
 * Time: 21:06
 */
namespace app\modules\food\model;

use app\modules\base\model\BaseTable;

class FoodChooseModel extends BaseTable {

    const TableName = 'food_choose';

    public static function getTopFive(){

        $foodData = self::find()->select('*')->asArray()->all();

        return $foodData;
    }
}