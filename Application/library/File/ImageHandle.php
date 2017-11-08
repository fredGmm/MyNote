<?php
/**
 * Created by PhpStorm.
 * User: bosheng2017
 * Date: 2017/11/8
 * Time: 17:39
 */

namespace Library\Image;

class ImageHandle{
    /**
     * 检测远程文件是否存在
     *
     * @param string $file_path 文件路径
     *
     * @return true
     */
    public static function fileIsExist($file_path)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $file_path);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_HEADER, 1); //返回response头部信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $curl_info = curl_getinfo($ch);
        curl_close($ch);
        return !empty($curl_info['http_code']) && $curl_info['http_code'] == 200 && !empty($curl_info['download_content_length']) ? $curl_info['download_content_length'] : false;
    }

    /**
     * 获取本地图片的文件类型
     *
     * @param string $file_path 文件路径
     *
     * @return boolean|string
     */
    public static function getImageType($file_path)
    {
        $mine_list = [
            'image/png' => 'png',
            'image/jpeg' => 'jpg',
            'image/gif' => 'gif',
            'image/bmp' => 'bmp'
        ];
        if (!is_file($file_path)) {
            return false;
        }
        if (array_key_exists($mine = mime_content_type($file_path), $mine_list)) {
            return $mine_list[$mine];
        } else {
            return false;
        }
    }
}