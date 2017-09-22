<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 2017/9/21
 * Time: 20:30
 */

namespace app\modules\admin\controller;

use app\modules\base\controller\BaseController;

class FoodController extends BaseController {

    public function actionGetList()
    {
        var_dump(\Yii::$app->request->post());
    }

    public function actionAdd()
    {


        $this->jsonOk(['a' => 4321]);

        //var_dump(\Yii::$app->request->post());
    }

    public function actionDelete()
    {
        var_dump(\Yii::$app->request->post());
    }


}