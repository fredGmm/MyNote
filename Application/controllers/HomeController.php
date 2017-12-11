<?php
/**
 * Created by PhpStorm.
 * User: bosheng2017
 * Date: 2017/11/1
 * Time: 11:10
 */

namespace app\controllers;

use app\library\log\Adapter\File;
use app\library\log\Config;
use app\library\log\log;
use app\library\log\Logger;
use app\models\MongdbModel;
use app\modules\food\model\FoodChooseModel;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\AssetBundle;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class HomeController extends Controller
{
    /**
     * @desc  首页
     *
     * @return string
     */
    public function actionIndex()
    {
        //  $this->getView()->registerAssetBundle(AssetBundle::className());
        return $this->redirect('/vue/dist/index.html');
    }

    public function actionSlides()
    {
        
    }
}
