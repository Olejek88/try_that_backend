<?php

namespace common\models;

use common\models\query\ExceptionTTQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%exception}}".
 *
 * @property int $id
 * @property int $luminary_id
 * @property string $date
 *
 * @property Luminary $luminary
 */
class ExceptionTT extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%exception}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['luminary_id', 'date'], 'required'],
            [['luminary_id'], 'integer'],
            [['date'], 'safe'],
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
            'luminary_id' => Yii::t('app', 'Luminary ID'),
            'date' => Yii::t('app', 'Date'),
        ];
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
     * @return \common\models\query\ExceptionTTQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExceptionTTQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'luminary';
        return $fields;
    }
}
