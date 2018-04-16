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
namespace app\modules\ssnh\controller;

use app\modules\base\controller\BaseController;

/**
 * Class IndexController
 * @package app\modules\ssnh\controller
 */
class IndexController extends BaseController{


    /**
     * 首页页面
     * 
     * @return string
     */
    public function actionIndex(){

        //后台左上标题设置
        $this->view->title = '(●°u°●)​ 」乐趣爬虫实验室';
//        $this->view->linkTags = $this->getMenu();
      
        $this->getView()->params['left_menu'] = $this->getMenu();
        return $this->render(__FUNCTION__, [], ['navs' => $this->getMenu()]);
    }

    /**
     * 获取左侧菜单
     */
    public function getMenu(){
        $menu_data = [
            [
                'title' => '首页',
                'icon' => "icon-computer",
                'href' => "new-admin/page/main.html",
                'spread' => false
            ]
        ];

        $json_menu = json_encode($menu_data);
//        $left_menu = <<<EOF
//var navs = {$json_menu};
//EOF;
        return $json_menu;

    }
}