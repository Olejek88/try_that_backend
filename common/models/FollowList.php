<?php

namespace common\models;

use common\components\BaseRecord;
use common\models\query\FollowListQuery;
use Yii;

/**
 * This is the model class for table "{{%follow_list}}".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $luminary_id
 *
 * @property Customer $customer
 * @property Luminary $luminary
 */
class FollowList extends BaseRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%follow_list}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'luminary_id'], 'required'],
            [['customer_id', 'luminary_id'], 'integer'],
            [
                ['customer_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Customer::class,
                'targetAttribute' => ['customer_id' => 'id']
            ],
            [
                ['luminary_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Luminary::class,
                'targetAttribute' => ['luminary_id' => 'id']
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
            'customer_id' => Yii::t('app', 'Customer ID'),
            'luminary_id' => Yii::t('app', 'Luminary ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLuminary()
    {
        return $this->hasOne(Luminary::class, ['id' => 'luminary_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\FollowListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FollowListQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'customer';
        $fields[] = 'luminary';
        return $fields;
    }
}
