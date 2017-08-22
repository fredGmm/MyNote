<?php
/**
 * Created by PhpStorm.
 * User: xubing
 * Date: 2016/8/6
 * Time: 14:40
 */

namespace Douyu\Log;


use Douyu\Di\DiInterface;
use Douyu\Log\Adapter\File;
use Douyu\ServiceProvider\YafProvider;

class LogServiceProvider extends YafProvider
{

    public function register()
    {
        $di = $this->container;

        // 日志配置服务
        $di->setShared('logConfig', function(){
            return new Config();
        });

        // 日志写入服务(注意不能是Shared)
        $di->set('fileLogWriter', function($filename, $logPath){
            return new File($filename, $logPath);
        });

        if (!defined('LOG_PATH')) {
            throw new LogException('NECESSARY_CONST_MISSING:LOG_PATH');
        }

        Logger::$logPath = LOG_PATH;

    }

    /**
     * 返回Logger服务对象
     * @param DiInterface $di
     * @param string $filename
     * @param array $keywords 关键词配置, 如果未提供, 按照默认 error => [文件名] 作为关键词
     * @return \Closure
     */
    public static function getLogger(DiInterface $di, $filename, $keywords = []) {
        return LoggerBuilder::getLoggerClosure($di, $filename, $keywords);
    }

}
