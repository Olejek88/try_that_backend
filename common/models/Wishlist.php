<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%wishlist}}".
 *
 * @property int $id
 * @property int $activity_id
 * @property int $customer_id
 * @property string $date
 *
 * @property Activity $activity
 * @property Customer $customer
 */
class Wishlist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%wishlist}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activity_id', 'customer_id'], 'required'],
            [['activity_id', 'customer_id'], 'integer'],
            [['date'], 'safe'],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'id']],
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
            'activity_id' => Yii::t('app', 'Activity ID'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::className(), ['id' => 'activity_id']);
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
     * @return \common\models\query\WishlistQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\WishlistQuery(get_called_class());
    }
}
