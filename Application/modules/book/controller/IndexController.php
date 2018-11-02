<?php
/**
 * @author FredGui
 * @version 2017-10-15
 * @modify  2017-3-11
 * @description 虎扑数据的处理输出
 * @link http://blog.kinggui.com
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
 */
namespace app\modules\book\controller;

use app\modules\base\controller\BaseController;

/**
 * Class IndexController
 * @package app\modules\ssnh\controller
 */
class IndexController extends BaseController
{


    /**
     * 首页页面
     *
     * @throws
     * @return string
     */
    public function actionIndex()
    {
        return $this->jsonOk(['status' => 'success', [['cover_img' => '', 'book_name' => ''],['cover_img' => '', 'book_name' => ''],['cover_img' => '', 'book_name' => '']]]);
    }


}