<?php

namespace common\models;

use common\components\BaseRecord;
use common\models\query\GroupExperienceQuery;
use Yii;

/**
 * This is the model class for table "{{%group_experience}}".
 *
 * @property int $id
 * @property int $activity_listing_id
 * @property int $customer_id
 *
 * @property ActivityListing $activityListing
 * @property Customer $customer
 */
class GroupExperience extends BaseRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%group_experience}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activity_listing_id', 'customer_id'], 'required'],
            [['activity_listing_id', 'customer_id'], 'integer'],
            [
                ['activity_listing_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ActivityListing::class,
                'targetAttribute' => ['activity_listing_id' => 'id']
            ],
            [
                ['customer_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Customer::class,
                'targetAttribute' => ['customer_id' => 'id']
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
            'activity_listing_id' => Yii::t('app', 'Activity Listing ID'),
            'customer_id' => Yii::t('app', 'Customer ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityListing()
    {
        return $this->hasOne(ActivityListing::class, ['id' => 'activity_listing_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\GroupExperienceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GroupExperienceQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'customer';
        $fields[] = 'activityListing';
        return $fields;
    }
}
