<?php

namespace common\models;

use common\components\BaseRecord;
use common\models\query\ActivityTagQuery;
use Yii;

/**
 * This is the model class for table "{{%activity_tag}}".
 *
 * @property int $id
 * @property int $activity_id
 * @property int $tag_id
 *
 * @property Activity $activity
 * @property Tag $tag
 */
class ActivityTag extends BaseRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%activity_tag}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activity_id', 'tag_id'], 'required'],
            [['activity_id', 'tag_id'], 'integer'],
            [
                ['activity_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Activity::class,
                'targetAttribute' => ['activity_id' => 'id']
            ],
            [
                ['tag_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Tag::class,
                'targetAttribute' => ['tag_id' => 'id']
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
            'tag_id' => Yii::t('app', 'Tag ID'),
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
    public function getTag()
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id']);
    }


    /**
     * {@inheritdoc}
     * @return ActivityTagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActivityTagQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'activity';
        $fields[] = 'tag';
        return $fields;
    }
}
