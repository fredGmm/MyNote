<?php
/**
 * Created by PhpStorm.
 * User: xubing
 * Date: 2016/11/16
 * Time: 13:30
 */

namespace Douyu\Log;

use Douyu\Di\DiInterface;

class LoggerBuilder
{
    /**
     * @param DiInterface $di
     * @param $filename
     * @param array $keywords
     * @return \Closure
     */
    public static function getLoggerClosure(DiInterface $di, $filename, $keywords = []) {
        return function() use ($di, $filename, $keywords) {
            // 如果没有提供关键词数据则使用 error => 文件名 作为关键词
            if (!$keywords) {
                $keywords = ['error' => [$filename]];
            }
            $logger = new Logger($di->get('logConfig')
                ,['keywords' => $keywords]
            );
            $writer = $di->get('fileLogWriter', [$filename.'-'.date('Y-m-d').'.log', Logger::$logPath]);
            $logger->setWriter($writer);
            return $logger;
        };
    }
}