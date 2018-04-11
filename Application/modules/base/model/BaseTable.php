<?php
/**
 * @author FredGui
 * @version 2017-8-19
 * @modify  2017-8-19
 * @description 模块的基类模型
 * @link http://blog.kinggui.com
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
 */

namespace app\modules\base\model;

use yii;
use yii\db\ActiveRecord;

/**
 * 模块的基类的model
 * @package app\modules\base\model
 */
Abstract class BaseTable extends ActiveRecord
{
    const TableName = 'no_select_table';

    //是否 需要 开启 所有 数据库 的 事务
    private static $_IsDBTransOpen = false;

    //已经 开起 数据库 事务 的 事务集合
    private static $_OpendTransDBs = [];


    //-----------------------------------重写方法

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{' . static::TableName . '}}';
    }

    public function init()
    {
        parent::init();
        //事务处理
        $thisDbDsn = $this->getDb()->dsn;
        //var_dump($thisDbDsn);exit;
        //如果 标记了需要开启所有 数据库 事务， 且 本表 对应的 数据库链接 没有 开启 事务
        if (self::$_IsDBTransOpen && empty(self::$_OpendTransDBs[$thisDbDsn])) {
            //开启 并保存
            self::$_OpendTransDBs[$thisDbDsn] = $this->getDb()->beginTransaction();;
        }
    }

    //-----------------------------------代理方法

    //一次性 更新多个值, 并保存
    public function diySaveAttribs($field2ValueMap)
    {
        foreach ($field2ValueMap as $k => $v) {
            $this->setAttribute($k, $v);
        }

        return $this->save();
    }

    /**
     * 得到数据库 链接
     *
     * @param string $dbConfName
     *
     * @return  \yii\db\Connection the database connection.
     */
    public static function getConn($dbConfName = 'db')
    {
        return Yii::$app->$dbConfName;
    }

    public static function getLastInsertID($dbConfName = 'db')
    {
        return self::getConn($dbConfName)->getLastInsertID();
    }

    //批量插入
    public static function batchInsert($columns, $rows, $dbConfName = 'db')
    {
        //todo
        return self::getConn($dbConfName)->createCommand()->batchInsert(static::TableName, $columns, $rows)->execute();
    }


    public static function in($ids, $initPhValueMap = [], $castCall = null)
    {
        $idsPhStr = '';
        foreach ($ids as $k => $v) {
            $idsPhStr .= ":$k,";
            if ($castCall instanceof \Closure) {
                $v = $castCall($v);
            }
            $initPhValueMap[":$k"] = $v;
        }
        $idsPhStr = rtrim($idsPhStr, ',');

        return ["($idsPhStr)", $initPhValueMap];
    }

    //-----------------------------------事务相关

    /**
     *  设置 所有 数据库 需要开启事务
     */
    public static function beginAllDBTrans()
    {
        self::$_IsDBTransOpen = true;
    }

    /**
     *  提交或者回滚 所有 数据库的事务
     */
    private static function doAllDBTrans($isCommit = true)
    {
        //如果 未 开启 事务 则 直接 返回 真
        if (!self::$_IsDBTransOpen) {
            return true;
        }

        //确定 是 提交 还是 回滚 动作
        $action = $isCommit ? 'commit' : 'rollBack';

        //处理 所有 数据的 事务
        foreach (self::$_OpendTransDBs as $dbDns => $transConn) {
            /**
             * @var $transConn yii\db\Transaction
             */
            try {
                //先标记 当前 数据库 链接 的 事务 已被 处理
                unset(self::$_OpendTransDBs[$dbDns]);

                if (!$transConn->$action()) {
                    //如果 不成功 则 回滚 所有 其他 数据库 事务
                    return self::rollbackAllDBTrans();
                };
            } catch (\Exception $e) {
                //如果 发生 异常 则 回滚 所有事务
                return self::rollbackAllDBTrans();
            }
        }

        //如果 所有 事务 都 处理了， 则 标记 未 开启事物
        if (empty(self::$_OpendTransDBs)) {
            self::$_IsDBTransOpen = false;
        }

        //如果  所有 事务 都处理了 就返回 真
        return !self::$_IsDBTransOpen;
    }

    /**
     *  提交 所有 数据库 的 事务
     */
    public static function commitAllDBTrans()
    {
        return self::doAllDBTrans();
    }

    /**
     *  回滚 所有 数据库 事务
     */
    public static function rollbackAllDBTrans()
    {
        return self::doAllDBTrans(false);
    }

    //一次保存 多条数据到数据库
    public function SaveAttribs($field2ValueMap, $pkFieldName = '')
    {
        foreach ($field2ValueMap as $k => $v) {
            $this->$k = $v;
        }
        $isOk = $this->save();

        return $pkFieldName ? $this->attributes[$pkFieldName] : $isOk;
    }


}