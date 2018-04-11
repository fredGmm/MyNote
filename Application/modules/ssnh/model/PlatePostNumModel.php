<?php
/**
 * @author FredGui
 * @version 2018-2-26
 * @modify  2018-2-26
 * @description 板块发帖的数据处理
 * @link http://www.cnblogs.com/guixiaoming
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
 */

namespace app\modules\ssnh\model;

use app\modules\base\model\BaseTable;

class PlatePostNumModel extends BaseTable
{
    const TableName = 'plate_post_num';

    /** 各个板块 英文简称 对应的中文名字， 同时这个英文简称也是 爬虫时对应的class或者id */
    public static $plate_arr = [
        'bxj'            => '步行街',
        'pgq'            => '破瓜区',
        'itsm'           => 'it数码',
        'xfl'            => '学府路',
        'selfie'         => '爆照区',
        'nine999'        => '万事屋',
        'ent'            => '影视区',
        'cars'           => '车友交流',
        'acg'            => 'ACG区',
        'finance'        => '股票区',
        'music'          => '音乐区',
        'literature'     => '文学区',
        'love'           => '情感区',
        'wallpaper'      => '手机壁纸区',
        'hccares'        => '虎扑助学基金会',
        'fit'            => '健康与运动健康',
        'shh'            => '湿乎乎',
        'nba_draft_ncaa' => '选秀nba',
        'four832'        => '天天nba',
        'dailyfantasy'   => '每日对抗',
        'rockets'        => '火箭专区',
        'warriors'       => '勇士',
        'cavaliers'      => '骑士',
        'spurs'          => '马刺',
        'lakers'         => '湖人',
        'celtics'        => '凯尔特人',
        'thunder'        => '雷霆',
        'clippers'       => '快船',
        'timberwolves'   => '森林狼',
        'mavericks'      => '独行侠',
        'knicks'         => '尼克斯',
        'bulls'          => '公牛',
        'sixers'         => '76人专区',
        'nets'           => '篮网专区',
        'jszz'           => '爵士',
        'pacers'         => '步行者',
        'blazers'        => '开阔者',
        'heats'          => '热火专区',
        'suns'           => '太阳专区',
        'grizzlies'      => '灰熊专区',
        'wizards'        => '奇才专区',
        'magic'          => '魔术专区',
        'pelicans'       => '鹈鹕专区',
        'bucks'          => '雄鹿专区',
        'kings'          => '国王专区',
        'raptors'        => '猛龙专区',
        'nuggets'        => '掘金专区',
        'hawks'          => '老鹰专区',
        'hornets'        => '黄蜂专区',
        'pistons'        => '活塞专区',
        'lurenwang'      => '路人王专区',
        'fiba'           => '世界篮球-FIBA',
        //以下为 电竞
        'wzry'           => '王者荣耀',
        'lol'            => '英雄联盟',
        'pubg'           => '绝地求生',
        'grsm'           => '使荣使命',
        'zjz2'           => '终结者',
        'pubgm'          => '全军出击',
        'cjzc'           => '刺激战场',
        'qghappy'        => 'QGhappy专区',
        'dota2'          => '刀塔',
        'hs'             => '炉石传说',
        'ow'             => '守望先锋',
    ];

    /**
     * @desc 选择数据库
     *
     * @return mixed
     */
    public static function getDb()
    {
        return \Yii::$app->hupuDb;
    }

    /**
     * @desc 通过板块简称找到 板块名字
     *
     * @param $plate string 板块简称
     *
     * @return mixed|string
     */
    public static function getPlateName($plate)
    {
        return isset(self::$plate_arr[$plate]) ? self::$plate_arr[$plate] : '未知';
    }

    /**
     * 获取每个板块的 发帖数目
     *
     * @param $date string 日期 ， 例如：20180226
     * @return array
     */
    public static function getPlateData($date)
    {
        /** 大约每天会抓取 70个板块的发帖数量吧 ，暂时先限制一次性查一百个板块以下吧 */
        $plate_data = self::find()->where(['date' => $date])
            ->orderBy('num desc')
            ->limit(20)->asArray()->all();
        return $plate_data;
    }

    /**
     * 获取某个板块的 发帖数，按照日期
     *
     * @param $plate string 板块简称
     * @param $start_date string 日期 ， 例如：20180226
     * @param $end_date string 日期 ， 例如：20180226
     *
     * @return array
     */
    public static function getOnePlateData($plate, $start_date, $end_date)
    {
        /** 大约每天会抓取 70个板块的发帖数量吧 ，暂时先限制一次性查7个板块以下吧 */
        $plate_data = self::find()->select(['date', 'num', 'plate'])
            ->where(['between', 'date', $start_date, $end_date])
            ->andWhere(['plate' => $plate])
            // ->groupBy('date')
            ->limit(7)->asArray()->all();
        return $plate_data;
    }


}