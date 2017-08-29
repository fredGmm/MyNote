<?php
/**
 * Created by PhpStorm.
 * User: bosheng2017
 * Date: 2017/8/29
 * Time: 14:31
 */
namespace app\library;

class Common {


    /**
     * 封装curl方法
     * @author FredGui
     * @param string $url 必选  接口地址
     * @param string $post 可选  如果是post访问填写post参数数组
     * @param int $timeout 可选  超时时间
     * @param string $cookie
     * @param int $decode
     * @return mixed|null
    */
    public static function curlHtml($url, $post = '', $timeout = 30, $cookie = '', $decode = 1){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        if ($cookie) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        $data = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode == '200') {
            if ($decode == 1 && !is_null(json_decode($data))) {
                $data = json_decode($data, true);
            }
        } else {
            $data = NULL;
        }
        curl_close($ch);
        return $data;
    }
}