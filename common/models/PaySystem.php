<?php

namespace common\models;

use common\components\BaseRecord;
use common\models\query\PaySystemQuery;

/**
 * Class PaySystem
 * @package common\models
 *
 * @property integer $id
 * @property string $name
 * @property string $class
 * @property integer $enable
 */
class PaySystem extends BaseRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pay_system}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'class'], 'required'],
            [['enable'], 'integer'],
            [['name', 'class'], 'string', 'max' => 255],
            [['class'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'name' => \Yii::t('app', 'Name'),
            'class' => \Yii::t('app', 'Class'),
            'enable' => \Yii::t('app', 'Enable'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return PaySystemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PaySystemQuery(get_called_class());
    }
}