<?php
/**
 * @author FredGui
 * @version 2017-10-15
 * @modify  2017-10-15
 * @description 首页控制器
 * @link http://blog.kinggui.com
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
 */
namespace app\crontab;

use app\library\Common;
use yii\console\Controller;
use yii\helpers\Console;

/**
 *  crontab 脚本，mongodb 数据到 mysql
 */
class TestController extends Controller
{
    /**
     * 暴力方法：脚本来 找寻hupu中板块分类（fup_id）id，以此可以获取每个版块下的宏观信息
     *
     * @return null
     */
    public function actionCheckApi(){
        // 1,8:版无意见与建议
        for($fid=0; $fid<500; $fid++){
            $result = Common::curl('https://bbs.hupu.com/get_nav?fup=' . $fid);
            if(!empty($result['data'])){
                \Yii::$app->log->info('这个fid下面有数据 ：' . $fid .PHP_EOL ."https://bbs.hupu.com/get_nav?fup=" .$fid , 'defaultLogger');
            }else{
                $this->stdout('fid:' . $fid . '没有数据' . PHP_EOL, Console::FG_CYAN);
            }
            if(($fid % 10) == 0){
                sleep(5);
                $this->stdout('歇息3秒'.PHP_EOL , Console::FG_YELLOW);
            }
        }
    }

    /**
     * 脚本测试用
     */
    public function actionTest(){
        echo "please test your code ---cli";
    }
}