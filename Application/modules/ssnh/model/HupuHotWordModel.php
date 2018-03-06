<?php

namespace app\modules\ssnh\model;

use app\modules\base\model\BaseTable;

class HupuHotWordModel extends BaseTable{

    const TableName = 'hupu_hot_word';

    public static function getDb()
    {
        return \Yii::$app->hupuDb;
    }
    
    public  function addHotWord($data){

        return $this->diySaveAttribs($data);
    }

}