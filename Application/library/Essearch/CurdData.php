<?php

namespace app\library\Essearch;

use app\library\Common;

class CurdData {

    /**
     * @var array eslasticsearch配置项
     */
    private static $essearch_config = [
        'host' => 'http://192.168.100.65:9200',
        'index_name' => 'hupu_data',
//        'number_of_shards' => 3,
//        'number_of_replicas' => 1
    ];

    /**
     * @var array 已有的索引类型
     */
    public static $type = [
        'article',
        'user'
    ];

    const IK_MAX = 'ik_max_word'; //会将文本做最细粒度的拆分；尽可能多的拆分出词语
    const IK_SMART = 'ik_smart'; //会做最粗粒度的拆分；已被分出的词语将不会再次被其它词语占有


    /**
     * @desc 创建essearch 的索引
     *
     * @param $index string 需要创建的索引
     *
     * @return bool
     */
    public function createIndex($index){
        $uri = '/' . $index;
        $result = Common::curl(self::$essearch_config['host'] . $uri, 'PUT');

        return !empty($result['acknowledged']) ? true : false ;
    }

    /**
     * 存入文档
     *
     * @param $id int id
     * @param $type string 类型
     * @param $data string 请求参数
     *
     * @return bool
     */
    public static function writeDocument($id, $type, $data)
    {
        $url = self::$essearch_config['host'] . '/' . self::$essearch_config['index_name'] . '/' . $type . '/' . $id;

        $result = Common::curl($url,'PUT',json_encode($data));
       
        if (!empty($result['result']) && in_array($result['result'], ['updated', 'created'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 删除文档
     * @param $id int id
     * @param $type string 类型
     *
     * @return bool
     */
    public static function deleteDocument($id, $type)
    {
        $url = self::$essearch_config['host'] . '/' . self::$essearch_config['index_name'] . '/' . $type . '/' . $id;

        $result = Common::curl($url,'DELETE');
        if (!empty($result['result']) && $result['result'] == 'deleted') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 文档的分词
     * @param $data
     * @param string $analyzer
     *
     * @see https://github.com/medcl/elasticsearch-analysis-ik
     *
     * @return array
     */
    public static function analyzeDocument($data, $analyzer = self::IK_MAX)
    {
        $url = self::$essearch_config['host'] . '/hupu_data/_analyze?analyzer=' . $analyzer;
        $result = Common::curl($url,'GET',$data);

        return empty($result['tokens']) ? [] : $result['tokens'];
    }

    /**
     * @desc 暂时先是 字段搜索，后面有业务需求再丰富
     *
     * @param $type string 文档类型
     * @param $condition array 查询条件数组，后期需要丰富的
     * @param $page int 页码
     * @param $page_num int 页面大小
     *
     * @see https://www.elastic.co/guide/cn/elasticsearch/guide/current/index.html
     * @return array
     */
    public static function search($type, $condition, $page, $page_num){
        $page = max(1, intval($page));
        $num = min(50, intval($page_num));
        $url = self::$essearch_config['host'] .'/' . self::$essearch_config['index_name'] . '/' . $type . '/_search?size=' . $num . '&from=' . ($page - 1) * $num . '&explain=1';

        $query['match'] =$condition;

        $result = Common::curl($url,'GET', json_encode(["query" => $query]));
       
        if (!empty($result['hits']['total'])) {
            return ['count' => $result['hits']['total'], 'data' => $result['hits']['hits']];
        } else {
            return ['count' => 0, 'data' => []];
        }
    }
}