<?php
/**
 * Created by PhpStorm.
 * User: bosheng2017
 * Date: 2017/9/30
 * Time: 14:30
 */
namespace app\controllers;

use app\library\Common;

class DogController extends BaseController{

    public function actionYou()
    {
        $data = Common::curlHtml('https://dog.ceo/api/breeds/image/random');

        return $this->render('You', ['data' => $data]);
    }
}