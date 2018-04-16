<?php
/**
 * @author FredGui
 * @version 2017-8-19
 * @modify  2017-8-19
 * @description 模块的基类，各个公用可以在这里编写
 * @link http://blog.kinggui.com
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
 */

namespace app\modules\base\controller;

use app\mvc\_base\model\BaseTable;
use yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\AssetBundle;
use yii\web\Controller;
use yii\web\View;

/**
 * 模块的基类控制器
 * @package app\modules\base\controller
 */
Abstract class BaseController extends Controller
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

    /**
     * 这个是yii2里面行为控制，我也没咋用
     * @return array
     */
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

    /**
     * 在 执行所有 action 之前 执行
     *
     * @param yii\base\Action $action
     *
     * @return bool
     */
    public function beforeAction($action)
    {
        $this->_modId = $this->module->id;
        $this->_ctrlId = $this->action->controller->id;
        $_actId = $this->action->id;
        $this->_fullIdPath = "/$this->_modId/$this->_ctrlId/$_actId";
        return true;
    }

    /**
     * 重写的渲染的方法，自动载入js，css，以及可能用的全局js变量【版本值，csrf token啥的】
     *
     * @param string $view 视图
     * @param array $viewParams
     * @param array $jsVars
     *
     * @return string
     * @throws yii\base\InvalidConfigException
     */
    public function render($view, $viewParams = [], $jsVars =[])
    {
        $this->getView()->registerAssetBundle(AssetBundle::className());
        $this->getView()->params['_fullIdPath'] = $this->_fullIdPath; //加入 路由全路径

        //CSRF 验证参数
        $csrfParam = \Yii::$app->request->csrfParam;
        $csrfToken = \Yii::$app->request->csrfToken;

        $addJsVarStr = '';
        foreach ($jsVars as $varKey => $value) {
            $addJsVarStr .= "var $varKey=$value;\r\n";
        }
        //定义 Js 中 页面取数据的相对根路径, 与 页面图片相对根路径, 与图片目录根路径
        $this->view->registerJs(<<<EOF
var pageApiRootUri='/$this->_modId/$this->_ctrlId.';
var cacheflag='2352345';
var csrfParam = '$csrfParam';
var csrfToken = '$csrfToken';
$addJsVarStr
EOF
            , View::POS_BEGIN);

//        注册 资源文件
//        self::addPageScript();
//        render 之前 自动 提交事务
//        BaseTable::commitAllDBTrans();
        return parent::render(str_replace('action', '', $view), $viewParams);
    }

    /**
     * 自定义的render，可以满足特定需要吧。也可以说有点多余了
     *
     * @param $funcName
     * @param array $viewParms
     * @param array $jsVars
     * @param array $layoutParms
     * @return string
     * @throws yii\base\InvalidConfigException
     */
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
      //  self::addPageScript();
        //render 之前 自动 提交事务
       // BaseTable::commitAllDBTrans();

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
     * JSON信息输出
     *
     * @param array $data 数据
     * @param int $code 信息码 默认为0
     * @param string $msg 提示信息 可有可无
     * @return string|object
     */
    public function jsonOut_($code = 0, $msg = '', $data = [])
    {
        header('Content-Type:application/json;charset=UTF-8');
        $output = array(
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        );
        $this->getResponse()->setBody(json_encode($output, JSON_UNESCAPED_UNICODE));
    }

    /**
     * ajax请求返回json数据
     * @author fredGui
     * @param array $data 返回给前端的具体数据，如果是列表的话数组格式如['count'=>14,'datalist'=>[]]
     * @param int $code 返回状态码,非0 全是失败
     * @param string $msg 提示消息语
     */
    private  function jsonOut($code, $data, $msg)
    {
        $resp = \Yii::$app->getResponse();
        $resp->format = yii\web\Response::FORMAT_JSON;
        $resp->content = json_encode(['code' => (int)$code, 'msg' => (string)$msg, 'data' => $data], JSON_UNESCAPED_UNICODE);
        $resp->send();
        exit;
    }

    public  function jsonOk($data, $count = 0, $msg = '')
    {
        $resp = \Yii::$app->getResponse();
        $resp->format = yii\web\Response::FORMAT_JSON;
        $resp->content = json_encode(['code' => 0, 'msg' => (string)$msg, 'count' => $count,'data' => $data], JSON_UNESCAPED_UNICODE);
        $resp->send();
        exit;
    }

    public  function jsonError($code = 999999, $data = [], $msg = '')
    {
        $resp = \Yii::$app->getResponse();
        $resp->format = yii\web\Response::FORMAT_JSON;
        $resp->content = json_encode(['code' => (int)$code, 'msg' => (string)$msg, 'data' => $data], JSON_UNESCAPED_UNICODE);
        $resp->send();
        exit;
    }

    /**
     * @desc get方式接参
     *
     * @param $key
     * @param $default
     * @return array|mixed
     */
    public function get($key, $default)
    {
        return \Yii::$app->request->get($key, $default);
    }

    /**
     * @desc post方式接参
     *
     * @param $key
     * @param $default
     * @return array|mixed
     */
    public function post($key, $default)
    {
        return \Yii::$app->request->post($key, $default);
    }
    
}
