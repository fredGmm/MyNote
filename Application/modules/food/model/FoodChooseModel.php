<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 2017/9/3
 * Time: 21:06
 */
namespace app\modules\food\model;

use app\modules\base\model\BaseTable;

/**
 * Class FoodChooseModel
 * @package app\modules\food\model
 *
 * @property string food_name  食物名字
 * @property string food_price  食物名字
 *
 */
class FoodChooseModel extends BaseTable {

    const TableName = 'food_choose';

    public static function getTopFive(){

        $foodData = self::find()->select('*')->asArray()->all();

        return $foodData;
    }

    public static function saveNewFood($food_info){

        $food_choose_model = new self;
        $food_choose_model->food_name = $food_info['food_name'];
        $food_choose_model->food_price = $food_info['price'];
        $food_choose_model->shop_name = $food_info['shop_name'];
        $food_choose_model->address = isset($food_info['address']) ? $food_info['address'] : '';
        $food_choose_model->ip = ISSET($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        $food_choose_model->fit_type = $food_info['fit_type'];
        $food_choose_model->kind = $food_info['kind'];
        $food_choose_model->description = $food_info['description'];
        $food_choose_model->user_id = 0;
        $food_choose_model->create_time = time();
        return $food_choose_model->save();
    }

    public static function getFoodList($page, $page_size = 2){

        $start = ($page - 1) * $page_size;
        $foods = self::find()->offset($start)->limit($page_size)->asArray()->all();
        $count = self::find()->count();
        return ['food_list'=>$foods, 'count'=>$count];
    }

}