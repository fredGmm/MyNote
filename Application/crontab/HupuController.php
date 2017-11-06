<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\crontab;

use app\models\MongdbModel;
use app\models\ScrapArticle;
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
    public function actionArticleToMysql(){

            for ($page=99; $page<1000000;$page++) {
                $this->stdout('页数：' . $page .PHP_EOL, Console::FG_BLUE);
                $article_list = MongdbModel::getArticleList($page);
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
                        if(!$articleModel->findOne(['id'=>$m[1]])){
                            $articleModel->id = $m[1];
                            $articleModel->url = $article_url;
                            $articleModel->title = $article_title;

                            preg_match_all('/[\s\x{4e00}-\x{9fff}a-zA-Z0-9#\[\]\{\}\’\”=+\-\(\)*&%$@]+/iu', $article_content, $matches);
                            $article_content = join('', $matches[0]);

                            $articleModel->article_content = $article_content;
                            $articleModel->images = json_encode($images);
                            $articleModel->create_time = time();
                            $articleModel->save();
                        }
                    }catch (\Exception $e){
                        echo mb_detect_encoding($article_content, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
                        echo  $e->getMessage() .PHP_EOL;
                        echo $m[1];
                        exit;
                    }

                }
            }
    }

}
