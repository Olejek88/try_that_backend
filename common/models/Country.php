<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%country}}".
 *
 * @property int $id
 * @property string $title
 * @property int $image_id
 *
 * @property Image $image
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%country}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['image_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::class, 'targetAttribute' => ['image_id' => 'id']],
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
            'image_id' => Yii::t('app', 'Image ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::class, ['id' => 'image_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\CountryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CountryQuery(get_called_class());
    }
}
