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

    public static function saveNewFood($food_info){

        $food_choose_model = new self;
        $food_choose_model->food_name = $food_info['food_name'];
        $food_choose_model->shop_name = $food_info['shop_name'];
        $food_choose_model->address = isset($food_info['address']) ? $food_info['address'] : '';
        $food_choose_model->ip = 0;
        $food_choose_model->fit_type = $food_info['fit_type'];
        $food_choose_model->kind = $food_info['kind'];
        $food_choose_model->description = $food_info['description'];
        $food_choose_model->user_id = 0;
        return $food_choose_model->save();
    }

    public static function getFoodList(){

        $foods = self::find()->offset(0)->limit(10)->asArray()->all();
        $count = self::find()->count();
        return ['food_list'=>$foods, 'count'=>$count];
    }

}