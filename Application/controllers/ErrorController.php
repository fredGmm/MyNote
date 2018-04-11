<?php
/**
 * @author FredGui
 * @version 2017-10-15
 * @modify  2017-10-15
 * @description 错误页面，包括404，无权限等
 * @link http://blog.kinggui.com
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
 */

namespace app\controllers;

use yii;
use yii\web\Controller;

/**
 * 错误控制器，结合独立操作使用
 *
 * @package app\controllers
 */
class ErrorController extends Controller
{
    /**
     * 独立操作
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction', //错误页面指向这个action，然后再路由中定义好页面
            ],
        ];
    }

    /**
     * 404 页面， 由路由配置指向这来的
     *
     * @see config/web.php
     * @return string
     */
    public function action404(){

        return $this->render('404.php');
    }
}