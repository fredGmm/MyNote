<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 2017/8/30
 * Time: 22:32
 */

use app\mvc\_base\model\BaseTable;
use yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\AssetBundle;
use yii\web\Controller;
use yii\web\View;

Abstract class BaseCtrl extends Controller
{


    //路径 相关
    protected $_fullIdPath; //内容格式: mod/ctrl/act
    protected $_modId;
    protected $_ctrlId;

    //设置 独立的 layout
    protected function setStandAloneLayout($layoutName)
    {
        return $this->layout = "{$this->module->id}_{$this->action->controller->id}_{$layoutName}";
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['*'],
                        'matchCallback' => function ($rule, $action) {
                            return true;
                        },
                        'denyCallback' => function ($rule, $action) {
                            return true;
                        },
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    //在 执行所有 action 之前 执行
    public function beforeAction($action)
    {
        $this->_modId = $this->module->id;
        $this->_ctrlId = $this->action->controller->id;
        $_actId = $this->action->id;
        $this->_fullIdPath = "/$this->_modId/$this->_ctrlId/$_actId";
        return true;
    }

    //自定义 Render
    public function diyRender($funcName, $viewParms = [], $jsVars = [], $layoutParms = [])
    {
        $imgRootPath = "/images";
        $imgPath = "$imgRootPath{$this->_fullIdPath}/";
        $viewParms = array_merge($viewParms, //附加 一些 预定义 变量 用于 img资源文件定位
            [
                'imgRootPath' => "$imgRootPath/",
                'imgPath' => $imgPath,
                '_modId' => $this->_modId,
                '_ctrlId' => $this->_ctrlId
            ]);
        $this->getView()->registerAssetBundle(AssetBundle::className());
        $this->getView()->params = $layoutParms;
        $this->getView()->params['_fullIdPath'] = $this->_fullIdPath; //加入 路由全路径

        //$this->view->params['_fullModIdPath'] = $this->_fullIdPath; //加入 模块全路径

        //-----------自定义附加的 js 变量
        $addJsVarStr = '';
        foreach ($jsVars as $varKey => $value) {
            $addJsVarStr .= "var $varKey=$value;\r\n";
        }

        //加入 post 提交时 需要的 防CSRF需要的校验 参数
        $csrfParam = \Yii::$app->request->csrfParam;
        $csrfToken = \Yii::$app->request->csrfToken;
        $cacheflag = \Yii::$app->params['cacheflag'];
        //定义 Js 中 页面取数据的相对根路径, 与 页面图片相对根路径, 与图片目录根路径
        $this->view->registerJs(<<<EOF

var imgRootUri='$imgRootPath/';
var pageImgRootUri='$imgPath';
var pageApiRootUri='/$this->_modId/$this->_ctrlId.';
var csrfParam = '$csrfParam';
var csrfToken = '$csrfToken';
var cacheflag='$cacheflag';
$addJsVarStr
EOF
            , View::POS_HEAD);

        //注册 资源文件
        self::addPageScript();

        //render 之前 自动 提交事务
        BaseTable::commitAllDBTrans();

        return parent::render(str_replace('action', '', $funcName), $viewParms);
    }

    //添加 网页 脚本
    private function addPageScript()
    {
        //取资源 定义 配置
        $assets = \Yii::$app->params['assets'];
        if (!empty($assets[$this->_fullIdPath])) {
            $thisView = $this->getView();
            foreach ($assets[$this->_fullIdPath] as $doWhat => $items) {
                //如果 是 注册 静态资源
                if (in_array($doWhat, ['CssFile', 'JsFile'])) {

                    $path = ['CssFile' => 'src/css', 'JsFile' => 'src/js'][$doWhat];
                    /**
                     * @var $doWhat \Yii\web\View->registerCssFile
                     * @var $doWhat \Yii\web\View->registerJsFile
                     */
                    $doWhat = "register$doWhat";
                    //根据assets.php中的配置加载静态资源
                    foreach ($items as $dataMainValue => $asset) {
                        $this->view->$doWhat("@web/$path/$asset", 'src/js' == $path ? ['data-main' => $dataMainValue] : []);
                    }
                } else {
                    //其他 非静态资源 操作
                    switch ($doWhat) {
                        //加入标题 参数
                        case 'title':
                            $thisView->title = isset($items) ? $items : '无标题';
                            break;

                        case 'access':

                            break;
                    }
                }
            }
        }
    }

    /**
     * 根据数据中的某一字段排序
     * @datetime 2016/8/4
     * @param array $array 原始数组
     * @param string $field 数组字段
     * @param bool $desc
     * @param bool $ignoreCase 是否忽略大小写
     */
    public function sortArrByField(&$array, $field, $desc = true, $ignoreCase = false)
    {
        $fieldArr = array();
        foreach ($array as $k => $v) {
            $fieldArr[$k] = $ignoreCase ? strtolower($v[$field]) : $v[$field];
        }
        $sort = $desc ? SORT_DESC : SORT_ASC;
        array_multisort($fieldArr, $sort, $array);
    }
}
