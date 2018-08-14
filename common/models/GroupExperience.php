<?php

namespace common\models;

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
class GroupExperience extends \yii\db\ActiveRecord
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
            [['activity_listing_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityListing::className(), 'targetAttribute' => ['activity_listing_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
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
        return $this->hasOne(ActivityListing::className(), ['id' => 'activity_listing_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\GroupExperienceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\GroupExperienceQuery(get_called_class());
    }
}
