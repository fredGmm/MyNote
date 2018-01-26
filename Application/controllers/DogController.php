<?php
/**
 * Created by PhpStorm.
 * User: bosheng2017
 * Date: 2017/9/30
 * Time: 14:30
 */
namespace app\controllers;

use app\library\Common;
use Library\Image\ImageHandle;

class DogController extends BaseController{

    public function actionYou()
    {
        $data = Common::curlHtml('https://dog.ceo/api/breeds/image/random');

        return $this->render('You', ['data' => $data]);
    }

    public function actionCheckYellow()
    {
        $domain = 'www.xxx.com';
        $name = 'uu836.mp4';
        for($year = 2016; $year<2018; $year++){
            for($month=1;$month<13;$month++){
                $url = $domain . '/' . $year . '/'. $month . '/' . $name;

                $is_exist = ImageHandle::fileIsExist($url);
                if($is_exist) {
                    echo $url;
                }
                echo "<br/>";
            }
        }

        exit;
    }
}