<?php
/**
 * @author FredGui
 * @version 2017-9-30
 * @modify  2017-9-30
 * @description 基类控制器，每个非模块内的web控制器可以继承它
 * @link http://blog.kinggui.com
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
 */

namespace app\controllers;

use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use Yii;

/**
 * 控制基类
 * 
 * @package app\controllers
 */
Abstract class BaseController extends Controller
{
    //记录访问uri
    protected $fullUri;
    protected $modId;
    protected $ctrlId;
    protected $actId;

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->modId = $this->module->id;
        $this->ctrlId = $this->action->controller->id;
        $this->actId = $this->action->id;
        $this->fullUri = "/$this->modId/$this->ctrlId/$this->actId";

//        $this->enableCsrfValidation = false;
//        Yii::$app->response->format = Response::FORMAT_JSON;

        if(parent::beforeAction($action)){

            $origin = ArrayHelper::getValue($_SERVER, 'HTTP_ORIGIN');
            
            if ($origin) {
                $scheme = parse_url($origin, PHP_URL_SCHEME);
                $host = parse_url($origin, PHP_URL_HOST);
                $port = parse_url($origin, PHP_URL_PORT);

                $url = "{$scheme}://{$host}";
                if ($port) {
                    $url .= ":{$port}";
                }
                $headers = 'X-Requested-With, Content-Type, ' . join(', ', array_keys(Yii::$app->request->headers->toArray()));
                $header = Yii::$app->response->headers;
                $header->add('Access-Control-Allow-Origin', $url);
                $header->add('Access-Control-Allow-Headers', $headers);
                $header->add('Access-Control-Allow-Methods', 'GET, POST, PATCH, DELETE, OPTIONS');
                $header->add('Access-Control-Allow-Credentials', 'true');

            }

            if (Yii::$app->request->method == 'OPTIONS') {
                return false;
            }

            return true;
        }else{
            return false;
        }
    }


    public  function jsonOk($data, $count = 0, $msg = '')
    {
        $resp = \Yii::$app->getResponse();
        $resp->format = Response::FORMAT_JSON;
        $resp->content = json_encode(['code' => 0, 'msg' => (string)$msg, 'count' => $count,'data' => $data], JSON_UNESCAPED_UNICODE);
        $resp->send();
        exit;
    }

    public  function jsonError($code = 999999, $data = [], $msg = '')
    {
        $resp = \Yii::$app->getResponse();
        $resp->format = Response::FORMAT_JSON;
        $resp->content = json_encode(['code' => (int)$code, 'msg' => (string)$msg, 'data' => $data], JSON_UNESCAPED_UNICODE);
        $resp->send();
        exit;
    }


}