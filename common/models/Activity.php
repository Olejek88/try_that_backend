<?php

namespace common\models;

use common\components\BaseRecord;
use common\models\query\ActivityQuery;
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
 * @property int $min_customers
 * @property int $max_customers
 * @property string $start_date
 * @property string $end_date
 *
 * @property ActivityCategory $activityCategory
 * @property Category $category
 * @property ActivityDuration[] $activityDurations
 * @property Luminary $luminary
 * @property ActivityImage[] $activityImages
 * @property ActivityListing[] $activityListings
 * @property Mail[] $mails
 * @property Occasion[] $occasions
 * @property Review[] $reviews
 * @property Tag[] $tags
 * @property ActivityTag[] $activityTags
 * @property Trending[] $trendings
 * @property Wishlist[] $wishlists
 */
class Activity extends BaseRecord
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
            [
                [
                    'luminary_id',
                    'category_id',
                    'activity_category_id',
                    'title',
                    'description',
                    'start_date',
                    'end_date'
                ],
                'required'
            ],
            [
                [
                    'luminary_id',
                    'category_id',
                    'activity_category_id',
                    'min_customers',
                    'max_customers',
                ],
                'integer'
            ],
            [
                ['start_date', 'end_date'],
                'datetime',
                'format' => 'php:Y-m-d H:i:s',
            ],
            [['title'], 'string', 'max' => 128],
            [['description'], 'string'],
            [
                ['activity_category_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ActivityCategory::class,
                'targetAttribute' => ['activity_category_id' => 'id']
            ],
            [
                ['category_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Category::class,
                'targetAttribute' => ['category_id' => 'id']
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
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'luminary_id' => Yii::t('app', 'Luminary ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'activity_category_id' => Yii::t('app', 'Activity Category ID'),
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
    public function getLuminary()
    {
        return $this->hasOne(Luminary::class, ['id' => 'luminary_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::class, ['id' => 'location_id']);
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
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('activityTags');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityTags()
    {
        return $this->hasMany(ActivityTag::class, ['activity_id' => 'id']);
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
     * @return ActivityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActivityQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityDurations()
    {
        return $this->hasMany(ActivityDuration::class, ['activity_id' => 'id']);
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'activityCategory';
        $fields[] = 'category';
        $fields[] = 'activityDurations';
        $fields[] = 'luminary';
        $fields[] = 'location';
        $fields[] = 'activityImages';
        $fields[] = 'activityListings';
        $fields[] = 'mails';
        $fields[] = 'occasions';
        $fields[] = 'reviews';
        $fields[] = 'tags';
        $fields[] = 'activityTags';
        $fields[] = 'trendings';
        $fields[] = 'wishlists';
        return $fields;
    }
}
