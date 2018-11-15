<?php
/**
 * @author FredGui
 * @version 2017-10-15
 * @modify  2017-10-15
 * @description 各种测试代码，有点乱-。-
 * @link http://blog.kinggui.com
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
 */

namespace app\controllers;

use app\library\Common;
use yii\web\Controller;
use \app\library\Cache\BaseRedis;
/**
 * 测试控制器
 *
 * @package app\controllers
 */
class TestController extends Controller
{
    /**
     * redis 测试
     */
    public function actionRedis()
    {
        /** 简单的证明下redis装好了 */
        $redis = BaseRedis::getInstance();
        $redis->set('test', date('Y-m-d H:i:m',time()), 3600);
        var_dump($redis->get('test'));
    }

    /**
     * 将自己的日志类与yii2整合,todo:最好自动补全也完善下
     */
    public function actionLog()
    {
        \Yii::$app->log->info('info log test');
        \Yii::$app->log->warning('waring log test');
        \Yii::$app->log->error('error log test');
    }

    /**
     * 支付宝的回调通知，记录下
     */
    public function actionAli(){
        $all_post = $_POST;
        $json = json_encode($all_post);
        \Yii::$app->log->info($json);
        echo 'success';

    }

    /**
     * 写技术分享ppt，盗链的演示
     */
    public function actionSteal(){
        echo "这是 偷盗的 教材网的</br>";
        echo "<img src =\"https://files.dodoedu.com/resize/386x350/attachments/d1b1f34e9bc55f083c48b494180622d3.gif\">";

        echo "<hr>";
        echo "<br/>";
        echo "这里是盗取 fred的网站</br>";
        echo "<img src=\"http://data.kinggui.com/src/images/about2.jpg\">";
    }


    public static function getImage($url,$save_dir='',$filename='',$type=0){

    }

    /**
     * 生成树,递归方式。（与下 方法比较）
     *
     * @param array $data
     * @param int $pid
     * @param int $cot
     *
     * @return mixed
     */
    public function Tree($data = [], $pid = 0, $cot = 0){
        if(isset($data[$pid])) {
            foreach ($data[$pid] as $val){
                if($val['pid'] == $pid) {
                    $val['cot'] = $cot;
                    $this->tree_data = $val;
                    $this->Tree($data, $val['id'], $cot + 1);
                }
            }
        }
        return $this->tree_data;
    }

    /**
     * 生成树，引用方式
     *
     * @param $items
     * @param string $id
     * @param string $pid
     * @param string $son
     *
     * @return array
     */
    public function tree2($items, $id = 'id', $pid='pid',$son="child"){
        $tree = [];
        $tmpMap = [];
        foreach ($items as $item){
            $tmpMap[$item[$id]] = $items;
        }
        foreach ($items as $item){
            if(isset($tmpMap[$item[$pid]])){
                $tmpMap[$item[$pid]][$son][] = &$tmpMap[$item[$id]];
            }else{
                $tree[] = &$tmpMap[$item[$id]];
            }
        }
        unset($tmpMap);
        return $tree;
    }
}
