<?php

namespace common\models;

use common\components\BaseRecord;
use common\models\query\ActivityListingQuery;
use Yii;

/**
 * This is the model class for table "{{%activity_listing}}".
 *
 * @property int $id
 * @property int $activity_id
 * @property int $duration_id
 * @property int $currency_id
 * @property double $cost
 * @property int $is_group
 *
 * @property Activity $activity
 * @property Duration $duration
 * @property GroupExperience[] $groupExperiences
 * @property Currency $currency
 * @property Order[] $orders
 */
class ActivityListing extends BaseRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%activity_listing}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activity_id', 'duration_id', 'currency_id', 'cost',], 'required'],
            [['activity_id', 'duration_id', 'currency_id', 'is_group'], 'integer'],
            [['cost'], 'double'],
            [
                ['activity_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Activity::class,
                'targetAttribute' => ['activity_id' => 'id']
            ],
            [
                ['duration_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Duration::class,
                'targetAttribute' => ['duration_id' => 'id']
            ],
            [
                ['currency_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Currency::class,
                'targetAttribute' => ['currency_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'activity_id' => Yii::t('app', 'Activity ID'),
            'duration_id' => Yii::t('app', 'Duration ID'),
            'currency_id' => Yii::t('app', 'Currency ID'),
            'cost' => Yii::t('app', 'Cost'),
            'is_group' => Yii::t('app', 'Is Group'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::class, ['id' => 'activity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDuration()
    {
        return $this->hasOne(Duration::class, ['id' => 'duration_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupExperiences()
    {
        return $this->hasMany(GroupExperience::class, ['activity_listing_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['activity_listing_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::class, ['id' => 'currency_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ActivityListingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActivityListingQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'activity';
        $fields[] = 'duration';
        $fields[] = 'groupExperiences';
        $fields[] = 'orders';
        $fields[] = 'currency';
        return $fields;
    }
}
