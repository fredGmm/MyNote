<?php
/**
 * Created by PhpStorm.
 * User: fredgui
 * Date: 2018/9/29
 * Time: 18:01
 */
namespace app\modules\gmm\controllers;

use app\controllers\BaseController;
use app\library\Common;
use app\models\HupuImages;
use app\models\Items;

class IndexController extends \app\modules\base\controller\BaseController
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

            $img->url = rtrim(str_replace('https:', 'http:', $img->url), 'g') . 'g';



        }
//        var_dump($imgs);
//        exit;
        return $this->render('item-list', ['imgs' => $imgs]);
    }

    /**
     * @param $image_id
     * @param $url
     * @param $article
     */
    public function actionDown($image_id, $url, $article){

        $data = Common::downImage($url, './upload');

        $this->jsonOk($data);

    }


}