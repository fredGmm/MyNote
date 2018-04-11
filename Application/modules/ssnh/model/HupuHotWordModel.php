<?php
/**
 * @author FredGui
 * @version 2017-10-15
 * @modify  2017-10-15
 * @description 虎扑热词数据的处理
 * @link http://www.cnblogs.com/guixiaoming
 * @copyright Copyright (c) 2017 Digital Fun ,Ltd
 * @license
 */

namespace app\modules\ssnh\model;

use app\modules\base\model\BaseTable;

class HupuHotWordModel extends BaseTable{

    //表名
    const TableName = 'hupu_hot_word';

    public static function getDb()
    {
        return \Yii::$app->hupuDb;
    }

    /**
     * @desc 添加热词数据
     * @param $data
     * @return bool
     */
    public function addHotWord($data)
    {

        return $this->diySaveAttribs($data);
    }

    /**
     * @desc 取得每个话题下的 热词
     * @param $plate
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getHotWord($plate)
    {
        $query = self::find()->select(['number', 'word'])
            ->where(['date' => date('Ymd')])
            ->orderBy('number desc');
        if ($plate) {
            $query->andWhere(['type' => $plate]);
        }
        $data = $query->limit(50)->asArray()->all();

        return $data;
    }
}