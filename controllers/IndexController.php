<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\AssetBundle;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class IndexController extends Controller
{
    /**
     * @desc arashi 首页- 我们的arashi
     *
     * @return string
     */
    public function actionIndex()
    {
      //  $this->getView()->registerAssetBundle(AssetBundle::className());
      
        return $this->render('index');
    }

    public function actionTodayNews(){

        return $this->render('today-new');
    }



    public function actionTest(){
       echo  Yii::$app->basePath;
    }


}
