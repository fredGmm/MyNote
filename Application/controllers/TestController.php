<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Desc: 控制器的测试入口
 * Date: 2017/9/3
 * Time: 20:05
 */
namespace app\controllers;

use yii\web\Controller;

class TestController extends Controller
{
    public function actionRedis()
    {
        $redis = \app\library\Cache\BaseRedis::getInstance();
        
      //  $redis->set('test', date('Y-m-d H:i:m',time()), 3600);

        var_dump($redis->get('test'));

    }

    public function actionAjax(){
        var_dump($_POST);exit;
        $id = \Yii::$app->request->post('foodName','青椒肉丝');
        $type = \Yii::$app->request->post('foodChoose',3);

        echo  json_encode(['id' => $id, 'type' => '肉类']);
    }
    
    public function actionLog()
    {
        \Yii::$app->log->warning('info log test');
        \Yii::$app->log->warning('waring log test');
        \Yii::$app->log->error('error log test');

    }

    public function actionVv()
    {
        echo 'v';
    }

    public function actionLiwei()
    {
        //服务器信息
        $server = 'udp://192.168.1.111:9998';

        //消息结束符号
        $msg_eof = "\n";
        $socket = stream_socket_server($server, $errno, $errstr, STREAM_SERVER_BIND);
        if (!$socket) {
            die("$errstr ($errno)");
        }

        do {
            //接收客户端发来的信息
            $inMsg = stream_socket_recvfrom($socket, 1024, 0, $peer);

            //服务端打印出相关信息
//            echo "Client : $peer\n";
//            echo "Receive : {$inMsg}";
            //给客户端发送信息
            $outMsg = substr('你发送的消息是:' . $inMsg, 0, (strrpos($inMsg, $msg_eof))).' -- '.date("Y-m-d H:i:s\r\n");
            stream_socket_sendto($socket, $outMsg, 0, $peer);

        } while ($inMsg !== false);
    }

    public function actionCli(){
        $ip = '192.168.1.111';
        $port = '9998';
        $sendMsg = '1111111111111';
        $handle = stream_socket_client("udp://{$ip}:{$port}", $errno, $errstr);
        if( !$handle ){
            die("ERROR: {$errno} - {$errstr}\n");
        }
        fwrite($handle, $sendMsg."\n");
        $result = fread($handle, 1024);
        fclose($handle);

        var_dump($result);
    }
}
