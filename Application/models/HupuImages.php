<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hupu_images".
 *
 * @property integer $id
 * @property string $url
 * @property integer $article_id
 * @property string $hupu_user_id
 * @property string $plate
 * @property integer $type
 * @property integer $is_deleted
 * @property string $create_time
 * @property string $update_time
 */
class HupuImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hupu_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'article_id', 'hupu_user_id', 'plate', 'type', 'is_deleted'], 'required'],
            [['article_id', 'type', 'is_deleted'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['url'], 'string', 'max' => 250],
            [['hupu_user_id'], 'string', 'max' => 50],
            [['plate'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'article_id' => 'Article ID',
            'hupu_user_id' => 'Hupu User ID',
            'plate' => 'Plate',
            'type' => 'Type',
            'is_deleted' => 'Is Deleted',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
