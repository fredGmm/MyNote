<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 2017/9/21
 * Time: 20:30
 */

namespace app\modules\admin\controller;

use app\modules\base\controller\BaseController;
use app\modules\food\model\FoodChooseModel;

class FoodController extends BaseController {

    public function actionGetList()
    {
        var_dump(\Yii::$app->request->post());
    }

    public function actionAdd()
    {
        $food_info = \Yii::$app->request->post('food_info');

        if (empty($food_info)) {
            $this->jsonError(1001, '信息不能为空');
        }
        $status = FoodChooseModel::saveNewFood($food_info);

        $status ? $this->jsonOk([], '添加成功') : $this->jsonError(20001,[],'添加失败');
    }

    public function actionDelete()
    {
        var_dump(\Yii::$app->request->post());
    }


}