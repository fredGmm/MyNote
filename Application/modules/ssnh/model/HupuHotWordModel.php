<?php

namespace app\modules\ssnh\model;

use app\modules\base\model\BaseTable;

class HupuHotWordModel extends BaseTable{

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
    public  function addHotWord($data){

        return $this->diySaveAttribs($data);
    }

    /**
     * @desc 取得每个话题下的 热词
     * @param $plate
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getHotWord($plate){
        $query = self::find()->select(['number','word'])
            ->where(['date' => date('Ymd')])
            ->orderBy('number desc');
        if($plate){
            $query->andWhere(['type' => $plate]);
        }
        $data = $query->limit(50)->asArray()->all();

        return $data;
    }
}