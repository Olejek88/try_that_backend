<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%activity}}".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $luminary_id
 * @property int $category_id
 * @property int $activity_category_id
 * @property int $duration_id
 * @property int $min_customers
 * @property int $max_customers
 * @property int $start_date
 * @property int $end_date
 *
 * @property ActivityCategory $activityCategory
 * @property Category $category
 * @property Duration $duration
 * @property Luminary $luminary
 * @property ActivityImage[] $activityImages
 * @property ActivityListing[] $activityListings
 * @property Mail[] $mails
 * @property Occasion[] $occasions
 * @property Review[] $reviews
 * @property Tag[] $tags
 * @property Trending[] $trendings
 * @property Wishlist[] $wishlists
 */
class Activity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%activity}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['luminary_id', 'category_id', 'activity_category_id', 'start_date', 'end_date'], 'required'],
            [['luminary_id', 'category_id', 'activity_category_id', 'duration_id', 'min_customers', 'max_customers', 'start_date', 'end_date'], 'integer'],
            [['title', 'description'], 'string', 'max' => 255],
            [['activity_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityCategory::class, 'targetAttribute' => ['activity_category_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['duration_id'], 'exist', 'skipOnError' => true, 'targetClass' => Duration::class, 'targetAttribute' => ['duration_id' => 'id']],
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
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'luminary_id' => Yii::t('app', 'Luminary ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'activity_category_id' => Yii::t('app', 'Activity Category ID'),
            'duration_id' => Yii::t('app', 'Duration ID'),
            'min_customers' => Yii::t('app', 'Min Customers'),
            'max_customers' => Yii::t('app', 'Max Customers'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityCategory()
    {
        return $this->hasOne(ActivityCategory::class, ['id' => 'activity_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
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
    public function getLuminary()
    {
        return $this->hasOne(Luminary::class, ['id' => 'luminary_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityImages()
    {
        return $this->hasMany(ActivityImage::class, ['activity_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityListings()
    {
        return $this->hasMany(ActivityListing::class, ['activity_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMails()
    {
        return $this->hasMany(Mail::class, ['activity_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOccasions()
    {
        return $this->hasMany(Occasion::class, ['activity_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['activity_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['activity_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrendings()
    {
        return $this->hasMany(Trending::class, ['activity_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWishlists()
    {
        return $this->hasMany(Wishlist::class, ['activity_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ActivityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ActivityQuery(get_called_class());
    }
}