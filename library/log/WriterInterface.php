<?php
/**
 * 日志写入接口
 */

namespace app\library\log;

interface WriterInterface
{
    
    /**
     * 写入日志内容
     * @param string $logContent 日志内容
     * @return null
     */
    public function write($logContent);
}