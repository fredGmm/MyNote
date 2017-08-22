<?php

namespace app\controllers;

use app\library\log\log;
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
      //  echo "<pre>";
        var_dump(Yii::$app->log);exit;
        
        

        exit;
        $config = new \app\library\log\Config();
        
        $log = new \app\library\log\Logger($config);
        
        $logPath = __DIR__ . '/logs';
        
        $fileWriter = new \app\library\log\Adapter\File('filename', $logPath);
        $log->setWriter($fileWriter);
        
        $log->info('this is a log test');


        $log_config = ConfigManager::getConfig('log')->toArray();
        $di = \Douyu\Di\Di::getInstance();
        foreach ($log_config as $logName => $logParam){
            $di->setShared($logName, \Douyu\Log\LogServiceProvider::getLogger($di, $logParam['fileName'], $logParam['keyword']));
        }
        $logger = \Douyu\Di\Di::getInstance()->getShared('flashLogger');
        $logger->error('出错了,出错信息:'.$e->getMessage());
    }


}
