<?php

class Com_Pinyin_Tool {
	// 数据文件的文件句柄
	private $file = NULL;

	/**
	 * @var Com_Pinyin_Tool
	 */
	private static $instance = NULL;

	/**
	 * 单例模式
	 * @static
	 * @return null|Com_Pinyin_Tool
	 */
	public static function instance(){
		if( ! self::$instance instanceof self){
			self::$instance = new self();
		}
		return self::$instance;
	}

    /**
     * 字符串转拼音
     * @param      $str
     * @param bool $ucfirst 首字母是否大写
     * @param bool $polyphony 是否保留多音字
     * @return string
     */
    public function str2pinyin($str, $ucfirst=FALSE, $polyphony=FALSE){
		$result = '';

		foreach($this->_str_split($str) as $char){
			$pinyin = $this->get_pinyin($char);

            if ($ucfirst && strpos($pinyin, ',') !== false) {
                $pys = explode(',', $pinyin);
                $result.= implode(',', array_map('ucfirst', ($polyphony ? array_slice($pys, 0, 1) : $pys)));
            } else {
                $result.= $ucfirst ? ucfirst($pinyin) : $pinyin;
            }
		}

		return $result;
	}

	/**
	 * 获取汉字拼音的首字母
	 * @param $str
	 * @return string
	 */
	public function first_pinyin($str){
		$result = '';

		foreach($this->_str_split($str) as $char){
			$result .= substr($this->get_pinyin($char), 0, 1);
		}

		return $result;
	}

	/**
	 * 单个汉字转拼音
	 * @param $char
	 * @return string
	 */
	public function get_pinyin($char){

		if(strlen($char) === 3 && $this->file) { // 中文在utf-8编码中占用三个字节
			$offset = $this->word2dec($char);
			if($offset >= 0) {
				fseek($this->file, ($offset - 19968) << 4, SEEK_SET);
				return trim(fread($this->file, 16));
			}
		}

		return $char;
	}

	/**
	 * 汉字转十进制
	 * 汉字的二进制编码  1110xxxx 10xxxxxx 10xxxxxx
	 * @param $word
	 * @return number
	 */
	private function word2dec($word){

		return base_convert(bin2hex(iconv('utf-8', 'ucs-4', $word)), 16, 10);

	}

    private function _str_split($str){
        preg_match_all('/.{1}|[^\x00]{1,1}$/us', $str, $matches);
        return $matches[0];
    }

	private function __construct(){
		$this->file = fopen(realpath(dirname(__FILE__)).'/pinyin.dat', 'rb');
	}

	public function __destruct() {
		if($this->file){
			fclose($this->file);
		}
	}
}