<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%location}}".
 *
 * @property int $id
 * @property string $title
 * @property int $latitude
 * @property int $longitude
 * @property int $image_id
 *
 * @property Image $image
 */
class Location extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%location}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['latitude', 'longitude', 'image_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'image_id' => Yii::t('app', 'Image ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\LocationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\LocationQuery(get_called_class());
    }
}
