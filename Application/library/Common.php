<?php
/**
 * @author FredGui
 * @version 2017-8-19
 * @modify  2017-8-19
 * @description 公共方法
 * @link http://blog.kinggui.com
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
 */
namespace app\library;

/**
 * 一些公共的常用方法
 * @package app\library
 */
class Common {

    /**
     * 封装curl方法
     * @author FredGui
     * @param string $url 必选  接口地址
     * @param string $method 请求方式
     * @param string $param 可选  如果是post访问填写post参数数组
     * @param int $timeout 可选  超时时间
     * @param string $cookie
     * @param int $decode
     * @return mixed|null
    */
    public static function curl($url, $method='GET', $param = '', $timeout = 30, $cookie = '', $decode = 1){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        if ($param) {
//            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        if ($cookie) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        $data = curl_exec($ch);
        $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode >= 200 && $httpCode <= 299) {
            if ($decode == 1) {
                $json_data = json_decode($data, true);
                $data = !is_null($json_data) ?  $json_data : '结果不是标准的json';
            }
        } else {
            $data = NULL;
        }
        curl_close($ch);
        return $data;
    }

    /**
     * 根据数据中的某一字段排序
     * @datetime 2016/8/4
     * @param array $array 原始数组
     * @param string $field 数组字段
     * @param bool $desc
     * @param bool $ignoreCase 是否忽略大小写
     */
    public static function sortArrByField(&$array, $field, $desc = true, $ignoreCase = false)
    {
        $fieldArr = array();
        foreach ($array as $k => $v) {
            $fieldArr[$k] = $ignoreCase ? strtolower($v[$field]) : $v[$field];
        }
        $sort = $desc ? SORT_DESC : SORT_ASC;
        array_multisort($fieldArr, $sort, $array);
    }

    /**
     * 数组转为xml数据
     *
     * @throws \RuntimeException | string
     */
    public static function arrayToXml($array){
        if(!is_array($array) || count($array) <= 0) {
            throw new \RuntimeException("数组数据异常！");
        }
        $xml = "<xml>";
        foreach ($array as $key=>$val) {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";

        return $xml;
    }

    /**
     * 将xml转为array
     *
     * @param string $xml
     *
     * @throws \RuntimeException
     * @return array
     */
    public static function xmlToArray($xml)
    {
        if(!$xml){
            throw new \RuntimeException("xml数据异常！");
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $array = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array;
    }

    /**
     * 二维数组中，以某个值作为数组键名
     *
     * @param array  $data   二维数组
     * @param string $column 字段
     *
     * @return array
     */
    public static function putValToKey($data, $column = 'id')
    {
        $map = [];
        if (empty($data) || !is_array($data)) {
            return [];
        }
        foreach ($data as $dk => $dv) {
            $map[$dv[$column]] = $dv;
        }
        return $map;
    }

    /**
     * 生成应用app token
     *
     * @return string
     */
    public static function genAccessToken()
    {

        return md5(base64_encode(pack('N6', mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand(), uniqid())));
    }
}