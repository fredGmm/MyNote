<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 2017/8/31
 * Time: 21:50
 */

namespace app\modules\food\controller;

use app\modules\base\controller\BaseController;
use app\modules\food\model\FoodChooseModel;
use app\modules\food\service\FoodAlgorithm;
use yii\base\Controller;

class ChooseController extends BaseController {

    public function actionEat(){
       
        $all_food_list = FoodChooseModel::find()->asArray()->all();
        
        return $this->render(__FUNCTION__,['all_food_list' =>$all_food_list]);
    }

    /**
     *
     * 
     */
    public function actionAjaxRecommend()
    {
        $num = \Yii::$app->request->post('num', 2);
        $kind = \Yii::$app->request->post('kind', '');

        $data = FoodAlgorithm::getNoonMeal($num,$kind);

        $this->jsonOk($data);

    }




}