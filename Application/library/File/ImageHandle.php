<?php
/**
 * @author FredGui
 * @version 2017-9-6
 * @modify  2017-9-6
 * @description 文件处理的类
 * @link http://blog.kinggui.com
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
 */
namespace Library\Image;

/**
 * 文件处理
 *
 * @package Library\Image
 */
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

    /**
     * 获取远程文件信息
     * @param $file_url
     * @return bool
     */
    public static function getRemoteFileInfo($file_url, &$is_big){
//        $header_array = get_headers($file_url, true);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $file_url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_HEADER, 1); //返回response头部信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $curl_info = curl_getinfo($ch);
        curl_close($ch);

        if($curl_info['http_code'] != 200 || $curl_info['download_content_length'] <= 0){
            return false; //网络问题或者资源文件不存在，可以加入重试机制
        }

        /** 大于50M 的属于大文件了 */
        if($curl_info['download_content_length'] / 1024 > 50){
            $is_big = 1;
        }

        return $curl_info['download_content_length'];
    }

    /**
     * 下载远程文件
     *
     * @param string $file_url 文件地址
     * @param $save_path
     * @param $is_big
     *
     * @throws RuntimeException
     * @return string
     */
    public static function downRemoteFile($file_url, $save_path = '/tmp/api', $is_big = 0){

        $file_name = 'api_' . uniqid('api');
        $file_path = $save_path . '/' .$file_name;

        /** 检查目录权限 */
        if(!is_dir($save_path) || !is_writable($save_path)) {
            throw new \RuntimeException('save path must be directory and writable', 9001);
        }
        /** 大文件下载 */
        if($is_big) {
            set_time_limit(0);
            ini_set('memory_limit', '512M');
            $header = get_headers($file_url, 1);
            $size = $header['Content-Length'];
            $fp = fopen($file_url, 'rb');
            if ($fp === false){
                throw new \RuntimeException('file open fail');
            }
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$file_path.'"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . $size);
            ob_clean();
            ob_end_flush();
            set_time_limit(0);

            $chunkSize = 1024 * 1024;
            while (!feof($fp)) {
                $buffer = fread($fp, $chunkSize);
                echo $buffer;
                ob_flush();
                flush();
            }
            fclose($fp);
            return $file_path;
        }
        $content = file_get_contents($file_url);
        file_put_contents($file_path,$content);
        return $file_path;
    }

}