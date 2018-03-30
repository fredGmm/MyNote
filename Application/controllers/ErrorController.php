<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class ErrorController extends Controller
{
    /**
     * 独立操作
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction', //错误页面指向这个action，然后再路由中定义好页面
            ],
        ];
    }

    /**
     * 404 页面
     */
    public function action404(){

        return $this->render('404.php');
    }
}