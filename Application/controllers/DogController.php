<?php
/**
 * Created by PhpStorm.
 * User: FredGui
 * Date: 2017/9/30
 * Time: 14:30
 */
namespace app\controllers;

use app\library\Common;
use Library\Image\ImageHandle;

/**
 * 发现了一个获取狗狗图片的接口，就用这个控制器展示下
 * Class DogController
 * @package app\controllers
 */
class DogController extends BaseController{

    //接口的域名，可前去看文档
    const DOG_API_DOMAIN = 'https://dog.ceo';

    //暂时用到的接口
    public static $apis = [
        'random' => '/api/breeds/image/random', //随机获得一张狗图片
//        'list'   => '/api/breeds/list'   //返回一组狗图片
    ];

    public function actionRandomOneDog()
    {
        $data = Common::curl('https://dog.ceo/api/breeds/image/random');
        return $this->render('You', ['data' => $data]);
    }
}