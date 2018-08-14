<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%news_image}}".
 *
 * @property int $id
 * @property int $news_id
 * @property int $image_id
 *
 * @property Image $image
 * @property News $news
 */
class NewsImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%news_image}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['news_id', 'image_id'], 'required'],
            [['news_id', 'image_id'], 'integer'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::class, 'targetAttribute' => ['image_id' => 'id']],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::class, 'targetAttribute' => ['news_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'news_id' => Yii::t('app', 'News ID'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::class, ['id' => 'news_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\NewsImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\NewsImageQuery(get_called_class());
    }
}
