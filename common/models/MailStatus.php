<?php

namespace common\models;

use common\components\BaseRecord;
use common\models\query\MailStatusQuery;
use Yii;

/**
 * This is the model class for table "{{%mail_status}}".
 *
 * @property int $id
 * @property string $title
 *
 * @property Mail[] $mails
 */
class MailStatus extends BaseRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mail_status}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 128],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMails()
    {
        return $this->hasMany(Mail::class, ['status_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\MailStatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MailStatusQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'mails';
        return $fields;
    }
}
