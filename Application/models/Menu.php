<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $title
 * @property string $uri
 * @property string $image
 * @property integer $pid
 * @property integer $is_deleted
 * @property integer $sort
 * @property integer $category_id
 * @property integer $is_enabled
 * @property string $create_time
 * @property string $update_time
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'is_deleted', 'sort', 'category_id', 'is_enabled'], 'integer'],
            [['create_time', 'update_time'], 'required'],
            [['create_time', 'update_time'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['uri'], 'string', 'max' => 200],
            [['image'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'uri' => 'Uri',
            'image' => 'Image',
            'pid' => 'Pid',
            'is_deleted' => 'Is Deleted',
            'sort' => 'Sort',
            'category_id' => 'Category ID',
            'is_enabled' => 'Is Enabled',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
