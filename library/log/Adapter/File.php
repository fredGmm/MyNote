<?php

namespace app\library\log\Adapter;

use SebastianBergmann\CodeCoverage\RuntimeException;

class File
{

    /**
     * DI对象
     * @var Di
     */
    protected $di;

    /**
     * 完整的日志文件路径
     * @var string
     */
    protected $fileFullPath;

    /**
     * 写入方式
     * @var string
     */
    protected $writeModel;

    /**
     * 文件日志构造函数
     *
     * @param string $fileName 日志文件名
     * @param string $filePath 日志路径
     * @param string $writeModel 文件写入模式
     * @throws RuntimeException
     */
    public function __construct($fileName, $filePath, $writeModel = 'a')
    {
        $this->writeModel = $writeModel;
        if (!is_dir($filePath)) {
            $filePath = rtrim($filePath, DIRECTORY_SEPARATOR);
            $result = mkdir($filePath, 0755, true);
            if (!$result) {
                throw new RuntimeException(sprintf('无法创建目录文件夹 %s', $filePath));
            }
        }
        $fileFullPath = $filePath . DIRECTORY_SEPARATOR . $fileName . '_' . date('Y-m-d') . '.log';
        if (!is_writable($filePath)) {
            throw new RuntimeException(sprintf('日志文件目录 %s 无法写入,请检查权限.', $fileFullPath));
        }
        $this->fileFullPath = $fileFullPath;
    }

    /**
     * 设定DI对象
     * @param Di $dependencyInjector
     */
    public function setDI(Di $dependencyInjector)
    {
        $this->di = $dependencyInjector;
    }

    /**
     * 返回当前DI对象
     * @return Di
     */
    public function getDI()
    {
        return $this->di;
    }

    /**
     * 获取日志文件的完整路径
     * @return string
     */
    public function getLogFileFullPath()
    {
        return $this->fileFullPath;
    }

    /**
     * 写入日志
     *
     * @param string $logContent
     * @throws LogException
     * @return null
     */
    public function write($logContent)
    {
        // 出于性能考虑, 每次调用写入方法时才会打开文件句柄写数据
        $fileHandle = fopen($this->fileFullPath, $this->writeModel);
        flock($fileHandle, LOCK_EX);
        if (fwrite($fileHandle, $logContent) === false) {
            throw new RuntimeException(sprintf('日志文件 %s 无法写入, 请检查权限', $this->fileFullPath));
        }
        fflush($fileHandle);
        flock($fileHandle, LOCK_UN);
        fclose($fileHandle);
    }
}
