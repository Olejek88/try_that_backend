<?php

namespace common\models;

use common\models\query\ImageQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%image}}".
 *
 * @property int $id
 * @property string $title
 * @property string $path
 *
 * @property ActivityCategory[] $activityCategories
 * @property ActivityImage[] $activityImages
 * @property Category[] $categories
 * @property Country[] $countries
 * @property Location[] $locations
 * @property NewsImage[] $newsImages
 * @property Occasion[] $occasions
 * @property Trending[] $trendings
 */
class Image extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%image}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'path'], 'string', 'max' => 255],
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
            'path' => Yii::t('app', 'Path'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityCategories()
    {
        return $this->hasMany(ActivityCategory::class, ['image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityImages()
    {
        return $this->hasMany(ActivityImage::class, ['image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountries()
    {
        return $this->hasMany(Country::class, ['image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocations()
    {
        return $this->hasMany(Location::class, ['image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsImages()
    {
        return $this->hasMany(NewsImage::class, ['image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOccasions()
    {
        return $this->hasMany(Occasion::class, ['image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrendings()
    {
        return $this->hasMany(Trending::class, ['image_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ImageQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'activityCategories';
        $fields[] = 'activityImages';
        $fields[] = 'categories';
        $fields[] = 'countries';
        $fields[] = 'locations';
        $fields[] = 'newsImages';
        $fields[] = 'occasions';
        $fields[] = 'trendings';
        return $fields;
    }
}
