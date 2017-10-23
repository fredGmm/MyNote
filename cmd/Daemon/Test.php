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
        $res = file_put_contents('/tmp/TestDaemon.txt', date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);
        sleep(10);
    }

}

$command = isset($argv[1]) ? $argv[1]:'start';

$daemon = new TestDae();
$daemon->run($command);