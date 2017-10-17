<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Desc: 控制器的测试入口
 * Date: 2017/9/3
 * Time: 20:05
 */
namespace app\controllers;

use yii\web\Controller;

class TestController extends Controller
{
    public function actionRedis()
    {
        $redis = \app\library\Cache\BaseRedis::getInstance();
        
      //  $redis->set('test', date('Y-m-d H:i:m',time()), 3600);

        var_dump($redis->get('test'));

    }

    public function actionAjax(){
        var_dump($_POST);exit;
        $id = \Yii::$app->request->post('foodName','青椒肉丝');
        $type = \Yii::$app->request->post('foodChoose',3);

        echo  json_encode(['id' => $id, 'type' => '肉类']);
    }
    
    public function actionLog()
    {
        \Yii::$app->log->warning('info log test');
        \Yii::$app->log->warning('waring log test');
        \Yii::$app->log->error('error log test');

    }

    public function actionVv()
    {
        echo 'v';
    }
}