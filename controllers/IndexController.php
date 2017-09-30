<?php

namespace app\controllers;

use app\library\log\Adapter\File;
use app\library\log\Config;
use app\library\log\log;
use app\library\log\Logger;
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
        //连接本地的 Redis 服务
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->set('name','heihei');
        $data = $redis->get('name');
        print_r($data);// 输出小明
        exit;
        var_dump(FoodChooseModel::findOne(['fid' => 1])->toArray());EXIT;
        if(!empty(Yii::$app->request->post())){
            var_dump(Yii::$app->request->post());exit;
        }
     //   return $this->render('Test');
    }

    public function actionDownImg()
    {
        self::getImage('https://http.cat/100','./','cat.jpg');
        //https://dog.ceo/dog-api/#all
    }

    /*
*功能：php完美实现下载远程图片保存到本地
*参数：文件url,保存文件目录,保存文件名称，使用的下载方式
*当保存文件名称为空时则使用远程文件原来的名称
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


    public function actionLog()
    {
        Yii::$app->log->info('test' . date('Y-m-d'));
    }
}
