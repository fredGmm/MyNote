<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 2017/9/3
 * Time: 20:05
 */

namespace app\controllers;


class TestController extends \yii\web\Controller
{
    public function actionRedis()
    {
        $redis = \app\library\Cache\BaseRedis::getInstance();
        
      //  $redis->set('test', date('Y-m-d H:i:m',time()), 3600);

        var_dump($redis->get('test'));

    }
}
