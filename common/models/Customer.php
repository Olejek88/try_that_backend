<?php

namespace common\models;

use common\components\BaseRecord;
use common\models\query\CustomerQuery;
use Yii;

/**
 * This is the model class for table "{{%customer}}".
 *
 * @property int $id
 * @property int $positive
 * @property int $negative
 * @property int $active
 * @property int $user_id
 *
 * @property FollowList[] $followLists
 * @property GroupExperience[] $groupExperiences
 * @property Review[] $reviews
 * @property Wishlist[] $wishlists
 * @property User $user
 */
class Customer extends BaseRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%customer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['positive', 'negative', 'active'], 'integer'],
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id']
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
            'positive' => Yii::t('app', 'Positive'),
            'negative' => Yii::t('app', 'Negative'),
            'active' => Yii::t('app', 'Active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollowLists()
    {
        return $this->hasMany(FollowList::class, ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupExperiences()
    {
        return $this->hasMany(GroupExperience::class, ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWishlists()
    {
        return $this->hasMany(Wishlist::class, ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return CustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomerQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'user';
        $fields[] = 'followLists';
        $fields[] = 'groupExperiences';
        $fields[] = 'reviews';
        $fields[] = 'wishlists';
        return $fields;
    }

}
