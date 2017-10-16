<?php

namespace Library\WAB;

use Library\Core\RedisBase;
use Library\WAB\db\Privilege;
use Library\WAB\db\Shop;

/**
 * Class Redis 封装了专门用于边看边买业务的存取方法
 * @package Library\WAB
 */
class Redis extends RedisBase
{

    /**
     * 构造器
     * @param array $config 可选键值：
     *  [noTimeout] boolean 默认false. 若为true，则忽略公共配置中的timeout时间（连接始终不超时）
     */
    public function __construct(array $config = null)
    {
        $CI = &get_instance();
        $CI->config->load('redis');
        $this->configMaster = config_item('redis_wab_room');
        $this->configSlave = config_item('redis_wab_room_slave');

        if (!empty($config['noTimeout'])) {
            $this->configMaster['timeout'] = 0;
            $this->configSlave['timeout'] = 0;
        }
        parent::__construct();
    }

    /**
     * @param Privilege $privilege
     * @return boolean
     */
    public function setPrivilege($privilege)
    {
        $value = json_encode($privilege);
        return $this->set('privilege_' . $privilege->room_owner_uid, $value);
    }

    /**
     * @param int $uid
     * @return Privilege
     */
    public function getPrivilege($uid)
    {
        $value = $this->get('privilege_' . $uid);
        if ($value) {
            $attributes = json_decode($value, true);
            if (is_array($attributes)) {
                $privilege = new Privilege();
                $privilege->setAttributes($attributes, false);
                return $privilege;
            }
        }
        return null;
    }

    /**
     * @param $uid
     * @return bool
     */
    public function deletePrivilege($uid)
    {
        return $this->rm('privilege_' . $uid);
    }

    /**
     * @param $room_id
     * @param $data
     * @return bool
     */
    public function setRoomData($room_id, $data)
    {
        $value = json_encode($data);
        return $this->set('room_' . $room_id, $value);
    }

    /**
     * @param int $room_id
     * @return mixed|null
     */
    public function getRoomData($room_id)
    {
        $val = $this->get('room_' . $room_id);
        if ($val) {
            $data = json_decode($val, true);
            if (is_array($data)) {
                return $data;
            }
        }
        return null;
    }

    /**
     * @param $room_id
     * @return bool
     */
    public function deleteRoomData($room_id)
    {
        return $this->rm('room_' . $room_id);
    }

    /**
     * @param $room_id
     * @param $flag
     * @return mixed|null
     */
    public function getProductUpdateData($room_id, $flag)
    {
        $val = $this->get('product_update:rid_' . $room_id . '_' . $flag);
        if ($val) {
            $data = json_decode($val, true);
            if (is_array($data)) {
                return $data;
            }
        }
        return null;
    }

    /**
     * @param $room_id
     * @param $flag
     * @param $data
     * @return bool
     */
    public function setProductUpdateData($room_id, $flag, $data)
    {
        $data['store_timestamp'] = NOW_TIME;
        $value = json_encode($data);
        return $this->set('product_update:rid_' . $room_id . '_' . $flag, $value);
    }

    /**
     * 获取分组的数据
     * @param $group_id
     * @return mixed|null
     */
    public function getShowcaseGroupData($group_id)
    {
        $val = $this->get('sc_group_' . $group_id);
        if ($val) {
            $data = json_decode($val, true);
            if (is_array($data)) {
                return $data;
            }
        }
        return null;
    }

    /**
     * 设置分组的数据
     * @param $group_id
     * @param $data
     * @return bool
     */
    public function setShowcaseGroupData($group_id, $data)
    {
        $value = json_encode($data);
        return $this->set('sc_group_' . $group_id, $value);
    }

    /**
     * 删除分组的数据
     * @param $group_id
     * @return bool
     */
    public function deleteShowcaseGroupData($group_id)
    {
        return $this->rm('sc_group_' . $group_id);
    }

    /**
     * 获取全局的商品数据
     * @return mixed|null
     */
    public function getShowcaseGlobalData()
    {
        $val = $this->get('sc_global');
        if ($val) {
            $data = json_decode($val, true);
            if (is_array($data)) {
                return $data;
            }
        }
        return null;
    }

    /**
     * 设置全局的商品数据
     * @param array $data
     * @return bool
     */
    public function setShowcaseGlobalData($data)
    {
        $value = json_encode($data);
        return $this->set('sc_global', $value);
    }


    /**
     * @param int $name
     * @param int $expire
     * @return bool
     */
    public function acquireLock($name, $expire = 300)
    {
        return 1 == $this->setLock('lock:' . $name, time(), $expire);
    }

    /**
     * @param $name
     */
    public function releaseLock($name)
    {

        $this->rm('lock:' . $name);
    }

    /**
     * @return int|false
     */
    public function getLastGrabOrderTime()
    {
        return $this->get('last_grab_time');
    }

    /**
     * @param int $timestamp
     * @return boolean
     */
    public function setLastGrabOrderTime($timestamp)
    {
        return $this->set('last_grab_time', $timestamp);
    }

    /**
     * 获得阶段性销售收益
     * @param int $room_id
     * @param int $begin_timestamp
     * @param int $end_timestamp
     * @return mixed
     */
    public function getTotalMoney($room_id, $begin_timestamp, $end_timestamp)
    {
        $key = 'total_money_' . $room_id . '_' . $begin_timestamp . '_' . $end_timestamp;
        $data = $this->get($key);
        if ($data) {
            return json_decode($data, true);
        }
        return false;
    }

    /**
     * 设置阶段性销售收益
     * @param array $total_money
     * @param int $room_id
     * @param int $begin_timestamp
     * @param int $end_timestamp
     * @return bool
     */
    public function setTotalMoney($total_money, $room_id, $begin_timestamp, $end_timestamp)
    {
        $key = 'total_money_' . $room_id . '_' . $begin_timestamp . '_' . $end_timestamp;
        return $this->set($key, json_encode($total_money), 300);
    }


    /**
     * 获得商品按类目统计的数量
     */
    public function getItemCateStat()
    {
        $ret = $this->get('cate_item_num');
        if ($ret) {
            $res = json_decode($ret, true);
            if ($res) {
                return $res;
            }
        }
        return false;
    }

    /**
     * 获得商品按类目统计的数量
     */
    public function setItemCateStat($data)
    {

        return $this->set('cate_item_num', json_encode($data));
    }

    /**
     * 获取导出操作的元数据
     *
     * @param $search
     * @param $exportType
     * @return bool|mixed
     */
    public function getExportMetaInfo($search, $exportType)
    {
        $key = 'export_' . md5(json_encode($search) . $exportType);
        $data = $this->get($key);
        if ($data) {
            return json_decode($data, true);
        }
        return false;
    }

    /**
     * 设置导出操作的的元数据
     *
     * @param $search
     * @param $exportType
     * @param $metaInfo
     * @param int $expire
     */
    public function setExportMetaInfo($search, $exportType, $metaInfo, $expire = 600)
    {
        $key = 'export_' . md5(json_encode($search) . $exportType);
        $data = json_encode($metaInfo);
        $this->set($key, $data, $expire);
    }

    /**
     * 获取热门商品数据
     *
     * @return array|mixed
     */
    public function getHotItemData()
    {
        $data = $this->get('hot_items');
        if ($data) {
            $json = json_decode($data, true);
            if ($json) {
                return $json;
            }
        }
        return ['total' => 0, 'timestamp' => 0, 'items' => []];
    }

    /**
     * 获取热门商品数据
     *
     * @param array $data
     */
    public function setHotItemData($data)
    {
        $this->set('hot_items', json_encode($data));
    }

    /**
     * @param Shop $shop
     * @return boolean
     */
    public function setShop(Shop $shop)
    {
        $value = json_encode($shop);
        return $this->set('shop_' . $shop->room_id, $value);
    }

    /**
     * @param int $room_id
     * @return Shop
     */
    public function getShop($room_id)
    {
        $value = $this->get('shop_' . $room_id);
        if ($value) {
            $attributes = json_decode($value, true);
            if (is_array($attributes)) {
                $shop = new Shop();
                $shop->setAttributes($attributes, false);
                return $shop;
            }
        }
        return null;
    }

    /**
     * 获取全局的商品入口开关
     *
     * @return boolean
     */
    public function getShowcaseGlobalSwitch()
    {
        return $this->get('sc_global_switch');
    }

    /**
     * 设置全局的商品入口开关
     *
     * @param boolean $flag
     */
    public function setShowcaseGlobalSwitch($flag)
    {
        $this->set('sc_global_switch', $flag ? 1 : 0);
    }


    const MEMBER_INFO_EXPIRE_TIME = 300; //member info 过期秒数

    /**
     * 根据uid获取用户的member info(生日和星座等)
     * @param $uid
     * @return array|mixed|null
     * @throws \RedisException
     */
    public function getMemberInfo($uid)
    {
        $uid = intval($uid);
        $value = $this->get('member_info_' . $uid);
        $memberInfo = null;
        if ($value) {
            $memberInfo = json_decode($value, true);
            if (!is_array($memberInfo)) {
                $memberInfo = [];
            }
        }
        return $memberInfo;
    }

    /**
     * 根据用户uid和用户memberinfo来设置redis的缓存
     * @param $uid
     * @param $memberInfo
     */
    public function setMemberInfo($uid, $memberInfo)
    {
        $uid = intval($uid);
        $this->set('member_info_' . $uid, json_encode($memberInfo), self::MEMBER_INFO_EXPIRE_TIME);
    }

    /**
     * 获取疑似需要冻结的商品的信息
     *
     * @return array
     */
    public function getSuspiciousFrozenItems()
    {
        $value = $this->get('suspicious_frozen_items');
        if ($value) {
            $data = json_decode($value, true);
            if (is_array($data)) {
                return $data;
            }
        }

        return [];
    }

    /**
     * 设置疑似需要冻结的商品的信息
     *
     * @param $items
     */
    public function setSuspiciousFrozenItems(array $items)
    {
        if (empty($items)) {
            $this->rm('suspicious_frozen_items');
        } else {
            $this->set('suspicious_frozen_items', json_encode($items), 86400 * 7);
        }
    }

    /**
     * 获取指定平台上的活动位的缓存。
     * @param int $platform
     * @return array|null
     */
    public function getAdEntry($platform)
    {
        $val = $this->get('ad_entry:' . $platform);
        if ($val) {
            $data = json_decode($val, true);
            if (is_array($data)) {
                return $data;
            }
        }
        return null;
    }

    public function setOrderRewardConfig($name, $val)
    {
        if ($val == '') {
            $this->hdel('order_reward_config', $name);
        } else {
            $this->hset('order_reward_config',  $name, $val);
        }
    }

    public function getOrderRewardConfig($name)
    {
        $val = $this->hget('order_reward_config', $name);
        if ($val) {
            return $val;
        }
        return null;
    }

    /**
     * 获取所有的各平台的配置
     *
     * @return array
     */
    public function getAllRateOrderRewardConfig()
    {
        $rateList = [
            'platform.rate.taobao',
            'platform.rate.jingdong',
            'platform.rate.kaola',
            'platform.rate.yumall'
        ];
        $val = $this->hMGet('order_reward_config', $rateList);
        if (is_array($val) && !empty($val)) {
            return $val;
        }
        return [];
    }


    // 购物送鱼丸需求 Redis 操作相关 added by laiconglin 2017-07-12 -- start

    const USER_POST_ORDER_LIST_EXPIRE_TIME = 600; // 用户的晒单hash的过期时间
    /**
     *
     * 存储的值为 uid => json_encode($orderList)
     *
     * @param $uid
     * @param $orderList
     */
    public function setUserPostOrderList($uid, $orderList = []) {
        $key = 'user_post_order_list:' . $uid;
        $val = json_encode($orderList, JSON_UNESCAPED_UNICODE);
        $expire = self::USER_POST_ORDER_LIST_EXPIRE_TIME;
        $this->set($key , $val, $expire);
    }

    /**
     * 删除已过期用户的晒单列表
     * @param $uid
     */
    public function delUserPostOrderList($uid) {
        $key = 'user_post_order_list:' . $uid;
        $this->del($key);
    }

    /**
     * 获取用户的可晒单列表
     * @param $uid
     * @return array|mixed
     * @throws \RedisException
     */
    public function getUserPostOrderList($uid) {
        $key = 'user_post_order_list:' . $uid;
        $val = $this->get($key);
        if ($val) {
            $val = json_decode($val, true);
        }
        if (empty($val)) {
            $val = [];
        }
        return $val;
    }

    /**
     * 设置所有可晒单的用户ID列表
     * @param array $userIdList
     */
    public function setPostOrderAllUserIdList($userIdList = []) {
        $key = 'user_post_order_all_user_id_list';
        $val = json_encode($userIdList, JSON_UNESCAPED_UNICODE);
        $expire = self::USER_POST_ORDER_LIST_EXPIRE_TIME;
        $this->set($key , $val, $expire);
    }

    /**
     * 获取所有可晒单的用户ID列表
     * @return array|mixed
     * @throws \RedisException
     */
    public function getPostOrderAllUserIdList() {
        $key = 'user_post_order_all_user_id_list';
        $val = $this->get($key);
        if ($val) {
            $val = json_decode($val, true);
        }
        if (empty($val)) {
            $val = [];
        }
        return $val;
    }


    /**
     *
     * 存储的值为对应商品的主图
     *
     * @param $source
     * @param $itemId
     * @param $itemPictUrl
     */
    public function setPostOrderItemPictUrl($source, $itemId, $itemPictUrl) {
        $key = 'post_order_item_pict_url:' . $source . ':' . $itemId;
        $expire = 86400;
        $this->set($key , $itemPictUrl, $expire);
    }

    /**
     * 获取用户的可晒单列表
     * @param $source
     * @param $itemId
     * @return string
     * @throws \RedisException
     */
    public function getPostOrderItemPictUrl($source, $itemId) {
        $key = 'post_order_item_pict_url:' . $source . ':' . $itemId;
        $val = $this->get($key);
        if (empty($val)) {
            $val = '';
        }
        return $val;
    }

    /**
     * 将收货个人提醒消息推入队列
     * @param array $orderRewardInfo
     */
    public function leftPushToOrderRewardUserHintQueue($orderRewardInfo = []) {
        $key = 'order_reward_user_hint_queue'; // 收货送鱼丸提醒用户队列
        $val = json_encode($orderRewardInfo, JSON_UNESCAPED_UNICODE);
        $this->lPush($key, $val);
    }

    /**
     * 将收货房间弹幕提醒消息推入队列
     * @param array $orderRewardInfo
     */
    public function leftPushToOrderRewardRoomDanmuQueue($orderRewardInfo = []) {
        $key = 'order_reward_room_danmu_queue'; // 收货送鱼丸房间弹幕提醒
        $val = json_encode($orderRewardInfo, JSON_UNESCAPED_UNICODE);
        $this->lPush($key, $val);
    }

    /**
     * 将京东考拉等订单更新消息推送到队列里面
     * @param array $data
     */
    public function leftPushToJdKoalaUpdateQueue($data = []) {
        $key = 'order_reward_record_jd_and_koala_trade_update_queue'; // 京东考拉等订单更新消息队列
        $val = json_encode($data, JSON_UNESCAPED_UNICODE);
        $this->lPush($key, $val);
    }


    /**
     * 弹出收货个人提醒队列中的某个
     *
     * @return array|mixed
     */
    public function rightPopOrderRewardUserHintQueue() {
        $key = 'order_reward_user_hint_queue'; // 收货送鱼丸提醒用户队列
        $val = $this->rPop($key);
        if ($val) {
            $val = json_decode($val, true);
        }
        if (empty($val)) {
            $val = [];
        }
        return $val;
    }

    /**
     * 弹出收货房间弹幕提醒队列中的某个
     * @return array|mixed
     */
    public function rightPopOrderRewardRoomDanmuQueue() {
        $key = 'order_reward_room_danmu_queue'; // 收货送鱼丸房间弹幕提醒
        $val = $this->rPop($key);
        if ($val) {
            $val = json_decode($val, true);
        }
        if (empty($val)) {
            $val = [];
        }
        return $val;
    }


    /**
     * 弹出京东考拉等订单更新消息队列
     * @return array|mixed
     */
    public function rightPopJdKoalaUpdateQueue() {
        $key = 'order_reward_record_jd_and_koala_trade_update_queue'; // 京东考拉等订单更新消息队列
        $val = $this->rPop($key);
        if ($val) {
            $val = json_decode($val, true);
        }
        if (empty($val)) {
            $val = [];
        }
        return $val;
    }


    // 购物送鱼丸需求 Redis 操作相关 added by laiconglin 2017-07-12 -- end


    /**
     * 设置指定平台上的活动位的缓存。如果设置为空值，则被认为是删除。
     * @param int $platform
     * @param array|null $data
     */
    public function setAdEntry($platform, $data)
    {
        if (empty($data)) {
            $this->rm('ad_entry:' . $platform);
        } else {
            $this->set('ad_entry:' . $platform, json_encode($data));
        }
    }
    /**
     * 获取最黄新其三活动文案
     * @return mixed|null
     */
    public function getActInfo()
    {
        $val = $this->get('act_info');
        if ($val) {
            $data = json_decode($val, true);
            if (is_array($data)) {
                return $data;
            }
        }
        return null;
    }

    /**
     * 设置最黄新其三活动文案
     * @param $data
     */
    public function setActInfo($data)
    {
        if (empty($data)) {
            $this->rm('act_info');
        } else {
            $this->set('act_info' , json_encode($data));
        }
    }

    /**
     * 获取京东 token 信息。
     * 当token失效时，会在运行时刷新token，并存入redis。
     *
     * @param string $platform 如果指定了平台，则只返回对应平台的token
     * @return mixed|null
     */
    public function getJdAuth($platform = null)
    {
        $data = $this->get('jd_auth');
        if ($data) {
            $auth = json_decode($data, true);
            if (is_array($auth)) {
                if ($platform) {
                    if (isset($auth[$platform])) {
                        return $auth[$platform];
                    }
                } else {
                    return $auth;
                }
            }
        }
        return null;
    }

    /**
     * 设置京东的token信息
     * @param string $platform
     * @param string $token
     */
    public function setJdAuth($platform, $token)
    {
        $data = $this->getJdAuth();
        if (!is_array($data)) {
            $data = [];
        }
        $data[$platform] = $token;
        $this->set('jd_auth', json_encode($data));
    }

    /**
     * 获取京东疑似需要冻结的商品的信息
     *
     * @return array
     */
    public function getJdSuspiciousFrozenItems()
    {
        $value = $this->get('Jd_suspicious_frozen_items');
        if ($value) {
            $data = json_decode($value, true);
            if (is_array($data)) {
                return $data;
            }
        }
        return [];
    }

    /**
     * 设置京东疑似需要冻结的商品的信息
     *
     * @param $items
     */
    public function setJdSuspiciousFrozenItems(array $items)
    {
        if (empty($items)) {
            $this->rm('Jd_suspicious_frozen_items');
        } else {
            $this->set('Jd_suspicious_frozen_items', json_encode($items), 86400 * 7);
        }
    }


    /**
     * 获取考拉疑似需要冻结的商品的信息
     *
     * @return array
     */
    public function getKlSuspiciousFrozenItems()
    {
        $value = $this->get('Kaola_suspicious_frozen_items');
        if ($value) {
            $data = json_decode($value, true);
            if (is_array($data)) {
                return $data;
            }
        }
        return [];
    }

    /**
     * 设置京东疑似需要冻结的商品的信息
     *
     * @param $items
     */
    public function setKlSuspiciousFrozenItems(array $items)
    {
        if (empty($items)) {
            $this->rm('Kaola_suspicious_frozen_items');
        } else {
            $this->set('Kaola_suspicious_frozen_items', json_encode($items), 86400 * 7);
        }
    }

    /**
     * 获取同步商品池的序列数字
     * @return int|false
     */
    public function getSyncPoolItemSequenceNum()
    {
        return $this->get('sync_pool_item_seq_num');
    }

    /**
     * 设置一个数字
     * @param int $num
     */
    public function setSyncPoolItemSequenceNum($num)
    {
        $this->set('sync_pool_item_seq_num', $num);
    }

    protected static $queues=[];

    /**
     * @return RedisQueue
     */
    public function getQueue_updateRoomDataCache()
    {
        $key = 'ql_update_room_data_cache';

        if (isset(self::$queues[$key])) {
            return self::$queues[$key];
        }

        $this->_connect_master();
        return self::$queues[$key] = new RedisQueue($this->handler, $key);
    }

    /**
     * 获取鱼购疑似需要冻结的商品的信息
     * @return array
     */
    public function getYumallSuspiciousFrozenItems()
    {
        $value = $this->get('Yumall_suspicious_frozen_items');
        if ($value) {
            $data = json_decode($value, true);
            if (is_array($data)) {
                return $data;
            }
        }
        return [];
    }

    /**
     * 设置鱼购疑似需要冻结的商品的信息
     * @param $items
     */
    public function setYumallSuspiciousFrozenItems(array $items)
    {
        if (empty($items)) {
            $this->rm('Yumall_suspicious_frozen_items');
        } else {
            $this->set('Yumall_suspicious_frozen_items', json_encode($items), 86400 * 7);
        }
    }


    /**
     * 获取cps推广链接转换Redis
     * @param $timestamp
     */
    public function getCpsConvertCache($timestamp)
    {
        $value = $this->get('cps_convert:' . $timestamp);
        if ($value) {
            $data = json_decode($value, true);
            if (is_array($data)) {
                return $data;
            }
        }
        return [];
    }

    /**
     * 设置cps推广链接转换Redis
     * @param $timestamp
     * @param $result
     */
    public function setCpsConvertCache($timestamp, $result)
    {
        $this->set('cps_convert:' . $timestamp, json_encode($result), 300);
    }

    /**
     * 设置淘宝订单号对应的缓存数据
     * @param $tid
     * @param array $cacheInfo
     */
    public function setTbTradeUidCache($tid, $cacheInfo = ['uid' => -1])
    {
        $this->set('tb_trade_id:' . $tid, json_encode($cacheInfo), 3600 * 24 * 30);
    }

    /**
     * 获取淘宝订单号对应的缓存数据
     * @param $tid
     * @return bool|mixed
     */
    public function getTbTradeUidCache($tid)
    {
        $value = $this->get('tb_trade_id:' . $tid);
        if ($value) {
            $data = json_decode($value, true);
            if (is_array($data)) {
                return $data;
            }
        }
        return false;
    }

    /**
     * 设置用户晒单与领鱼丸详情
     * @param $uid
     * @param array $data
     * @param int $expire
     */
    public function setUserOrderRewardInfo($uid, $data = [], $expire = 86400)
    {
        $this->hMset('user_order_reward_info:' . $uid, $data);
        $this->expire('user_order_reward_info:' . $uid, $expire);
        return true;
    }


    /**
     * 获取当日用户晒单与领鱼丸详情
     * post_times:当日晒单次数  reward_amount：当日收货领鱼丸数
     * @param $uid
     * @return bool
     */
    public function getUserOrderRewardInfo($uid)
    {
        $value = $this->hGetAll('user_order_reward_info:' . $uid);
        if ($value) {
            return $value;
        }
        return false;
    }


    /**
     * 设置用户是否领取收货鱼丸cache
     * @param $uid
     * @param $tid
     * @param $data
     * @return bool true:已领取 false:没有领取
     */
    public function setIsOrderRewardCache($uid, $tid, $data)
    {
        return $this->set('is_order_reward_' . $uid . '_' . $tid, $data, 86400 * 30);
    }


    /**
     * 获取用户是否领取收货鱼丸cache
     * @param $uid
     * @param $tid
     * @return mixed
     * @throws \RedisException
     */
    public function getIsOrderRewardCache($uid, $tid)
    {
        return $this->get('is_order_reward_' . $uid . '_' . $tid);
    }

}


class RedisQueue implements \Countable, \IteratorAggregate {

    /**
     * @var \Redis
     */
    protected $handler;

    protected $key;

    public function __construct(\Redis $handler, $key)
    {
        $this->handler = $handler;
        $this->key = $key;
    }

    public function enqueue($item)
    {
        $this->handler->rPush($this->key, $item);
        return $this;
    }

    public function dequeue()
    {
        return $this->handler->lPop($this->key);
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return $this->handler->lLen($this->key);
    }

    /**
     * 迭代队列中的项。每迭代一个项，该项就会从队列中移除。
     * 迭代的项目个数不会超过调用此方法时队列的长度，所以即使在每个迭代循环末尾将项目重新加入队列也不会导致无限循环
     *
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return \Generator
     * @since 5.0.0
     */
    public function getIterator()
    {
        // 锁定要迭代的最大个数。
        $length = $this->count();
        for ($i = 0; $i < $length; $i++) {
            $item = $this->dequeue();
            if ($item !== false) {
                yield $item;
            } else {
                break;
            }
        }
    }
}
