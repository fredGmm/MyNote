<?php
/**
 * @author FredGui
 * @version 2017-10-15
 * @modify  2017-10-15
 * @description 偶然发现一个取狗狗图片的接口，用来恶搞室友的
 * @link http://blog.kinggui.com
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
 */
namespace app\controllers;

use app\library\Common;

/**
 * 发现了一个获取狗狗图片的接口，就用这个控制器展示下
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

    /**
     * 展示图片，每次刷新即可拿到不同的可爱图片
     *
     * @see
     * @return string
     */
    public function actionRandomOneDog()
    {
        $data = Common::curl(self::DOG_API_DOMAIN . self::$apis['random']);
        return $this->render('You', ['data' => $data]);
    }
}