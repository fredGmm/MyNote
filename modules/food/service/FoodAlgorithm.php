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

    public static function getNoonMeal($num = 2, $kind = ''){

        $food_choose = new FoodChooseModel();
        $where = [];
        if (empty($kind)) {
            $where['kind'] = $kind;
        }

        $result = $food_choose::find()->where($where)->limit($num)->asArray()->all();

        foreach ($result as $fk => &$v){
            $v['per'] = mt_rand(1,10)  * 10 . '%';
        }

        return $result;
    }


}