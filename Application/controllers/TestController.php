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
     * 迅搜，简义分词的尝试； 已经弃用了，改为 elasticsearch 了
     */
    public function actionInternals()
    {
        $so = \scws_new(); //需要安装相关的扩展
        $so->set_charset('utf-8');
        // 这里没有调用 set_dict 和 set_rule 系统会自动试调用 ini 中指定路径下的词典和规则文件
        $so->send_text("我是一个中国人,我会C++语言,我也有很多T恤衣服");
        echo "<pre>";
        while ($tmp = $so->get_result())
        {
            print_r($tmp);
        }
        $so->close();
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

    /**
     * 远程下载图片，当保存文件名称为空时则使用远程文件原来的名称
     *
     * @param string $url 图片地址
     * @param string $save_dir 保存路径
     * @param string $filename 文件名
     * @param int $type 下载方式，默认使用curl
     *
     * @return array
     */
    public static function getImage($url,$save_dir='',$filename='',$type=0){
        if(trim($url)==''){
            return array('file_name'=>'','save_path'=>'','error'=>1);
        }
        if(trim($save_dir)==''){
            $save_dir='./';
        }
        if(trim($filename)==''){//保存文件名
            $ext=strrchr($url,'.');
            if($ext!='.gif'&&$ext!='.jpg'){
                return array('file_name'=>'','save_path'=>'','error'=>3);
            }
            $filename=time().$ext;
        }
        if(0!==strrpos($save_dir,'/')){
            $save_dir.='/';
        }
        //创建保存目录
        if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){
            return array('file_name'=>'','save_path'=>'','error'=>5);
        }
        //获取远程文件所采用的方法
        if($type){
            $ch=curl_init();
            $timeout=5;
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
            $img=curl_exec($ch);
            curl_close($ch);
        }else{
            ob_start();
            readfile($url);
            $img=ob_get_contents();
            ob_end_clean();
        }
        //$size=strlen($img);
        //文件大小
        $fp2=@fopen($save_dir.$filename,'a');
        fwrite($fp2,$img);
        fclose($fp2);
        unset($img,$url);
        return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'error'=>0);
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
