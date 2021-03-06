<?php
/**
 * @author FredGui
 * @version 2017-10-15
 * @modify  2017-10-15
 * @description 首页控制器
 * @link http://www.cnblogs.com/guixiaoming
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
 */

namespace app\controllers;

use app\library\Common;
use app\models\HupuImages;
use app\models\Menu;
use yii;
use yii\web\Controller;

/**
 * 首页面展示
 *
 * @package app\controllers
 */
class HomeController extends BaseController
{
    /**
     * @desc  首页
     *
     * @return string
     * @throws yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        $images = HupuImages::find()->offset(104)->limit(8)->orderBy('create_time desc')->asArray()->all();

//        var_dump($images);exit;

        return $this->render('index.php',['images' => $images]);
    }

    public function actionDetail()
    {
//        $this->layout = false;
        return $this->render('list.php');
    }

    public function actionImage(){


        return $this->render('image');
    }

    /**
     * 首页的菜单
     */
    public function actionMenu()
    {
        $menu = Menu::find()->where(['is_deleted' => 0, 'is_enabled' => 1])->asArray()->all();

        $menu = Common::recursive($menu);

        return $this->jsonOk($menu);
    }


}
