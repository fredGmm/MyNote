<?php
/**
 * Created by PhpStorm.
 * User: fredgui
 * Date: 2018/9/29
 * Time: 18:01
 */
namespace app\modules\gmm\controllers;

use app\models\HupuImages;
use app\models\Items;

class IndexController extends \yii\web\Controller
{
    public $layout = false;


    public function actionHome()
    {

        return $this->render('home');
    }


    public function actionIndex()
    {

        return $this->render('console');
    }



    public function actionConsole()
    {

        return $this->render('console');
    }

    public function actionPublish()
    {

        return $this->render('publish');
    }

    public function actionJobList()
    {

        return $this->render('job-list');
    }

    public function actionApplyList()
    {

        return $this->render('apply-list');
    }

    public function actionItemList()
    {
//        $items = Items::find()->joinWith('images')->orderBy("id desc ,create_time desc")->asArray()->all();

        $imgs = HupuImages::find()->offset(20)->limit(10)->orderBy('create_time desc')->all();

        foreach ($imgs as &$img){

            $img->url = str_replace('https:', 'http:', $img->url);


        }
//        var_dump($imgs);
//        exit;
        return $this->render('item-list', ['imgs' => $imgs]);
    }


}