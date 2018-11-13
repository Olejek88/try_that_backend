<?php

namespace common\models;

use common\components\BaseRecord;
use common\models\query\CityQuery;
use Yii;

/**
 * This is the model class for table "{{%city}}".
 *
 * @property int $id
 * @property string $title
 *
 */
class City extends BaseRecord
{
    public const NOT_SPECIFIED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%city}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title')
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\CityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CityQuery(get_called_class());
    }
}
