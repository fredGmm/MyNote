<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\crontab;

use app\library\Common;
use app\models\MongdbModel;
use app\models\ScrapArticle;
use app\models\WxbTitleModel;
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
     * 从 mongo里取数据 ，存入MySQL
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

    public function actionWxbTitleApart()
    {
        $word_arr = [];
        $sh = scws_open();
        scws_set_charset($sh, 'utf-8');
        scws_set_dict($sh, '/usr/local/scws/etc/dict.utf8.xdb');
        scws_set_rule($sh, '/usr/local/scws/etc/rules.utf8.ini');
        $ret = WxbTitleModel::find()->asArray()->all();
        foreach ($ret as $rk => $rv){
            scws_send_text($sh, $rv['title']);
            $apart_words = scws_get_tops($sh, 4);
            foreach ($apart_words as $apart_word){

                if(isset($word_arr[$apart_word['word']]['times'])) {
                    $word_arr[$apart_word['word']]['times'] += $apart_word['times'];
                }else{
                    $word_arr[$apart_word['word']]['times'] = $apart_word['times'];
                }
                if(isset($word_arr[$apart_word['word']]['weight'])) {
                    $word_arr[$apart_word['word']]['weight'] = bcadd($word_arr[$apart_word['word']]['weight'],$apart_word['weight']);
                }else{
                    $word_arr[$apart_word['word']]['weight'] = $apart_word['weight'];
                }

            }
        }

        Common::sortArrByField($word_arr,'times',true);
        $to_db_data = array_slice($word_arr,0,20);

    }

}
