<?php
/**
 * Created by PhpStorm.
 * User: FredGui
 * Date: 2017/12/14
 * Time: 17:20
 */

namespace app\modules\ssnh\controller;

use app\modules\base\controller\BaseController;

class SuggestionController extends BaseController{

    /**
     * 首页面
     */
    public $layout = 'iframe_main';

    public function actionAll(){

        return $this->render(__FUNCTION__);
    }

    public function actionList()
    {
        $data = [
            [
                'question_id' => 1,
                'question_type' => 'kfs',
                'question_text' => 'a',
                'question_score' => 1
            ],
            [
                'question_id' => 2,
                'question_type' => 'kfs',
                'question_text' => 'a',
                'question_score' => '<i class="layui-icon" style="font-size: 20px; color: #1E9FFF;">&#xe6c6;32</i>'
            ]
        ];
        //&#xe654;

        $this->jsonOk($data,2);
    }

}