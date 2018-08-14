<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%luminary}}".
 *
 * @property int $id
 * @property int $verified
 * @property string $verified_date
 * @property double $rating
 *
 * @property Activity[] $activities
 * @property ExceptionTT[] $exceptions
 * @property FollowList[] $followLists
 * @property News[] $news
 */
class Luminary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%luminary}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['verified'], 'integer'],
            [['verified_date'], 'safe'],
            [['rating'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'verified' => Yii::t('app', 'Verified'),
            'verified_date' => Yii::t('app', 'Verified Date'),
            'rating' => Yii::t('app', 'Rating'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivities()
    {
        return $this->hasMany(Activity::class, ['luminary_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExceptions()
    {
        return $this->hasMany(ExceptionTT::class, ['luminary_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollowLists()
    {
        return $this->hasMany(FollowList::class, ['luminary_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::class, ['luminary_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\LuminaryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\LuminaryQuery(get_called_class());
    }
}