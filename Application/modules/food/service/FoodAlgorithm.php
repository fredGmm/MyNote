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
        if (!empty($kind)) {
            $where['kind'] = $kind;
        }

        $result = $food_choose::find()->where($where)->asArray()->all();

        $data = [];
        $key = array_rand(range(0,count($result)-1), $num);
        for($i=0; $i<$num; $i++){

            $data[$i] = $result[$key[$i]];
        }

        foreach ($data as $fk => &$v){
            $v['per'] = mt_rand(1,10)  * 10 . '%';
        }

        return $data;
    }


}