<?php

namespace common\models;

use common\components\BaseRecord;
use common\models\query\WishlistQuery;
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
class Wishlist extends BaseRecord
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
            [['date'], 'datetime', 'format' => 'php:Y-m-d H:s:i'],
            [
                ['activity_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Activity::class,
                'targetAttribute' => ['activity_id' => 'id']
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
        return $this->hasOne(Activity::class, ['id' => 'activity_id']);
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
     * @return \common\models\query\WishlistQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WishlistQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'activity';
        $fields[] = 'customer';
        return $fields;
    }
}
