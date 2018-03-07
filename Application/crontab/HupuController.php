<?php

namespace app\crontab;

use app\library\Common;
use app\library\Essearch\CurdData;
use app\models\MongdbModel;
use app\models\ScrapArticle;
use app\models\WxbTitleModel;
use app\modules\ssnh\model\HupuArticleListModel;
use app\modules\ssnh\model\HupuHotWordModel;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use PHPUnit\Framework\Constraint\Exception;
use yii\console\Controller;
use yii\helpers\Console;

/**
 *  crontab 脚本，mongodb 数据到 mysql
 */
class HupuController extends Controller
{
    /**
     *
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = '后台跑起')
    {
        echo $message . "\n";
    }

    /**
     * 从 mongo里取数据 ，存入MySQL，后期放弃这种方案。觉得麻烦了
     */
    public function actionArticleToMysql($category='lol'){
        $count = MongdbModel::getCount(['category' => 'bxj']);

        $page_total = ceil($count / 100);
        $page_size = 100;

        $update_count = 0;
        for ($page=0; $page<=$page_total;$page++) {
            $this->stdout('页数：' . $page .PHP_EOL, Console::FG_BLUE);
            $start = ($page - 1) * $page_size;
            $article_list = MongdbModel::getArticleList($start,$page_size, $category);

            foreach ($article_list as $k => $article) {
                $article_url = $article['_id'];
                $article_content = $article['article_content'];
                $article_title = $article['title'];
                $images       = $article['images'];
                # $time = (array)$article['timestamp'];
                preg_match('#^.*/(\w+)\.html.*#',$article_url,$m);

                if (!isset($m[1]) || !is_numeric($m[1])) {
                    continue;
                }
                try{
                    $articleModel = new ScrapArticle();
                    $isExist = $articleModel->findOne(['id'=>$m[1]]);

                    if(!$isExist){
                        $articleModel->id = $m[1];
                        $articleModel->url = $article_url;
                        $articleModel->title = $article_title;
                        $articleModel->category = $article['category'];

                        preg_match_all('/[\s\x{4e00}-\x{9fff}a-zA-Z0-9#\[\]\{\}\’\”=+\-\(\)*&%$@]+/iu', $article_content, $matches);
                        $article_content = join('', $matches[0]);

                        $articleModel->article_content = $article_content;
                        $articleModel->images = json_encode($images);
                        $articleModel->create_time = time();
                        $articleModel->save();
                    }else{
                        $status = $articleModel->updateAll(['category' => 'bxj'],['id'=>$m[1]]);
                        $status && $update_count++;
                        $status && $this->stdout('更新条数：' . $update_count . 'id:'. $m[1] .PHP_EOL, Console::FG_BLUE);
                    }
                }catch (\Exception $e){
                   // echo mb_detect_encoding($article_content, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
                    echo  $e->getMessage() .PHP_EOL;
                    echo $m[1] . PHP_EOL;
                    var_dump($article);

                }

            }
        }
    }

    /**
     * 迅搜简易分词试试而已,使用utf-8词典
     */
    public function actionDivisionWordHandle()
    {
        $sh = scws_open();
        scws_set_charset($sh, 'utf-8');
        scws_set_dict($sh, '/usr/local/scws/etc/dict.utf8.xdb');
        scws_set_rule($sh, '/usr/local/scws/etc/rules.utf8.ini');
        $text = "刁康是个帅比，会打球，能幽默，还特么年薪30万";
        scws_send_text($sh, $text);
        $top = scws_get_tops($sh, 100);
        echo "<pre>";
        print_r($top);
    }

    /**
     * 提取抓取到的标题中的热词
     *
     * @return array
     */
    public function actionGetTitleHotWord()
    {
        $page = 1;
        $page_size = 1000;
        $article_iterator = HupuArticleListModel::articleIterator($page,$page_size, ['post_date' => date('Y-m-d', time())]);

        $add_count = 0; //这一次脚本添加了多少词
        $update_count = 0; // 这一次

        $today_date = date('Ymd', time());
        /** 使用迭代器更加省 内存 */
        foreach ($article_iterator as $article_list){
            /** 空的生成器时 可跳出 */
           if(empty($article_list)){
               break;
           }
           foreach ($article_list as $key => $article){
               $words = CurdData::analyzeDocument($article['article_title'], CurdData::IK_SMART);
               $this->stdout($article['id'] . ' : ' . $article['article_title'] . PHP_EOL, Console::FG_BLUE);
               if(!empty($words)){
                   foreach ($words as $word) {
                       $insert_data = [
                           'word' => $word['token'],
                           'number' => 1,
                           'date' => $today_date,
                           'type' => $article['plate'],
                           'create_time' => time(),
                       ];
                       $is_exist = HupuHotWordModel::find()
                           ->where(['word' =>$word['token'],'date' => $today_date, 'type' => $article['plate'] ])
                           ->one();
                       if($is_exist){
                            $num = (int)$is_exist->number + 1;
                           $is_exist->number = $num;
                           $update_status = $is_exist->save();
                           $update_status && ($update_count++);
                       }else{
                           $status = (new HupuHotWordModel())->addHotWord($insert_data);
                           $status && ($add_count++);
                       }
                   }
               }
           }

        }

        printf("本次运行共添加了%d条热词，更新词的出现次数%d次", $add_count, $update_count);
    }


    /**
     * 脚本测试用
     */
    public function actionTest(){
        $page = 1;
        $page_size = 10;

//        $data = HupuArticleListModel::getArticleList($page, $page_size);
//
//        $count = 0;
//        foreach ($data['article_list'] as $dk =>$dv){
//            $result = CurdData::writeDocument($dv['id'],CurdData::$type[0],$dv);
//            if($result){
//                echo $count++ ;
//            }
//        }
//        exit;
//        var_dump($data);exit;
//       var_dump(CurdData::deleteDocument(3, CurdData::$type[0]));
        var_dump(CurdData::analyzeDocument('逼格好厉害的吗'));
//        var_dump(CurdData::search(CurdData::$type[0], ['article_title' => '步行街'],$page, $page_size));

    }
}
