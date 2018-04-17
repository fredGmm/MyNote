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
     * 获取左侧菜单,这里已经实现了 PHP来动态配置，由于时间有限，先这样代码层面配置吧-。-
     *
     * @return string
     */
    public function getMenu(){
        $menu_data = [
            [
                'title' => '首页',
                'icon' => "&#xe68e;",
                'href' => "new-admin/page/main.html",
                'spread' => false
            ],
            [
                "title" => "虎扑数据",
                'icon' => "<img src='/static/img/hupu.png'>",
                'href' => '',
                'spread' => true,
                'children' => [
                    [
                        "title"=>"文章整体分析" ,
                        "icon"=> "<img src='/static/img/analyze_16.png'>",
                        "href"=> "/ssnh/hupu/global-analysis",
                        "spread" => false
                    ],
                    [
                        "title"=>"板块对比" ,
                        "icon"=> "<img src='/static/img/pk.png'>",
                        "href"=> "",
                        "spread" => false
                    ],
                    [
                        "title"=>"用户分析" ,
                        "icon"=> "<img src='/static/img/user.png'>",
                        "href"=> "",
                        "spread" => false
                    ],
                    [
                        "title"=>"审视数据" ,
                        "icon"=> "<img src='/static/img/data.png'>",
                        "href"=> "",
                        "spread" => false
                    ],
                ]
            ],
            [
                "title" => "精彩书评",
                'icon' => "<img src='/static/img/t-book.png'>",
                'href' => '',
                'spread' => false,
                'children' => [
                    [
                        "title"=>"卷书网" ,
                        "icon"=> "<img src='/static/img/t-book.png'>",
                        "href"=> "",
                        "spread" => false
                    ],
                    [
                        "title"=>"豆瓣书评" ,
                        "icon"=> "<img src='/static/img/t-book.png'>",
                        "href"=> "",
                        "spread" => false
                    ],
                    [
                        "title"=>"荐书网" ,
                        "icon"=> "<img src='/static/img/t-book.png'>",
                        "href"=> "",
                        "spread" => false
                    ],
                ]
            ],
            [
                "title" => "相关技术",  //&#xe64e 代码
                'icon' => "<img src='/static/img/technology.png'>",
                'href' => '',
                'spread' => false,
                'children' => [
                    [
                        "title"=>"python爬虫" ,
                        "icon"=> "<img src='/static/img/py.png'>",
                        "href"=> "/doc/装修注意事项.html",
                        "spread" => false
                    ],
                    [
                        "title"=>"PHP之道" ,
                        "icon"=> "<img src='/static/img/php.png'>",
                        "href"=> "/doc/装修注意事项.html",
                        "spread" => false
                    ],
                    [
                        "title"=>"数据结构(c描述)" ,
                        "icon"=> "<img src='/static/img/structure.png'>",
                        "href"=> "/doc/装修注意事项.html",
                        "spread" => false
                    ],
                ]
            ],
            [
                "title" => "关于项目与作者",
                'icon' => "&#xe6af;",
                'href' => '',
                'spread' => false,
                'children' => [
                    [
                        "title"=>"作者" ,
                        "icon"=> "",
                        "href"=> "/doc/装修注意事项.html",
                        "spread" => false
                    ],
                    [
                        "title"=>"项目" ,
                        "icon"=> "",
                        "href"=> "/doc/装修注意事项.html",
                        "spread" => false
                    ]
                ]
            ],
            [
                "title" => "杂谈",
                'icon' => "&#xe705;",
                'href' => '/ssnh/hupu/home',
                'spread' => false,
                'children' => [
                    [
                        "title"=>"装修" ,
                        "icon"=> "&#xe631;",
                        "href"=> "/ssnh/hupu/home",
                        "spread" => false,

                    ]
                ]
            ]

        ];

        $json_menu = json_encode($menu_data);
        return $json_menu;

    }
}