<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 2017/9/4
 * Time: 21:57
 */
namespace app\modules\food\service;


use app\modules\food\model\FoodChooseModel;

class FoodAlgorithm {

    public static function getNoonMeal(){

        $food = FoodChooseModel::getTopFive();

        foreach ($food as $fk => &$v){
            $v['per'] = mt_rand(1,10)  * 10 . '%';
        }

        return $food;
    }
}