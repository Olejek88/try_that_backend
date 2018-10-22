<?php

namespace common\models;

use common\models\query\NewsQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property int $id
 * @property int $luminary_id
 * @property string $title
 * @property string $text
 * @property int $date
 *
 * @property Luminary $luminary
 * @property NewsImage[] $newsImages
 */
class News extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['luminary_id', 'title', 'text', 'date'], 'required'],
            [['luminary_id', 'date'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['luminary_id'], 'exist', 'skipOnError' => true, 'targetClass' => Luminary::class, 'targetAttribute' => ['luminary_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'luminary_id' => Yii::t('app', 'Luminary ID'),
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLuminary()
    {
        return $this->hasOne(Luminary::class, ['id' => 'luminary_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsImages()
    {
        return $this->hasMany(NewsImage::class, ['news_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\NewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'luminary';
        $fields[] = 'newsImages';
        return $fields;
    }
}
