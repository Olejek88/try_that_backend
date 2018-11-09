<?php

namespace common\models;

use common\components\BaseRecord;
use common\models\query\ActivityTagQuery;
use Yii;

/**
 * This is the model class for table "{{%tag}}".
 *
 * @property int $id
 * @property string $title
 * @property int $category_id
 *
 * @property Category $category
 */
class Tag extends BaseRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tag}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'category_id'], 'required'],
            [['category_id',], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
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
            'category_id' => Yii::t('app', 'Category ID'),
            'activity_id' => Yii::t('app', 'Activity ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ActivityTagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActivityTagQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'category';
        return $fields;
    }
}
