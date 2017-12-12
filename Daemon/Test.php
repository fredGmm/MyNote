<?php
/**
 * Created by PhpStorm.
 * User: bosheng2017
 * Date: 2017/10/20
 * Time: 11:49
 */

include './DaemonBase.php';

class TestDae extends DaemonBase
{

    public function main()
    {
//        $res = file_put_contents('/tmp/TestDaemon.txt', 'fsafsafa'.date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);
//        sleep(2);

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
            $outMsg = substr('你发送的消息' . $inMsg, 0, (strrpos($inMsg, $msg_eof))).' -- '.date("Y-m-d H:i:s\r\n");
            file_put_contents('/tmp/udp.txt', $inMsg.date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);
            stream_socket_sendto($socket, $outMsg, 0, $peer);

        } while ($inMsg !== false);
    }

}

$command = isset($argv[1]) ? $argv[1]:'start';

$daemon = new TestDae();
$daemon->run($command);