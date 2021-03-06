<?php

namespace common\models;

use common\components\BaseRecord;
use common\models\query\CategoryQuery;
use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property int $id
 * @property string $title
 * @property int $image_id
 *
 * @property Activity[] $activities
 * @property Image $image
 * @property Tag[] $tags
 */
class Category extends BaseRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 128],
            [['image_id'], 'integer'],
            [
                ['image_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Image::class,
                'targetAttribute' => ['image_id' => 'id']
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
            'image_id' => Yii::t('app', 'Image ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivities()
    {
        return $this->hasMany(Activity::class, ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::class, ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['category_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'activities';
        $fields[] = 'tags';
        $fields[] = 'image';
        return $fields;
    }
}
