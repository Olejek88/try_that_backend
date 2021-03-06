<?php

namespace common\models;

use common\components\BaseRecord;
use common\models\query\NewsQuery;
use Yii;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property int $id
 * @property int $luminary_id
 * @property string $title
 * @property string $text
 * @property string $date
 *
 * @property Luminary $luminary
 * @property NewsImage[] $newsImages
 */
class News extends BaseRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['luminary_id', 'title', 'text'], 'required'],
            [['luminary_id'], 'integer'],
            [['date'], 'datetime', 'format' => 'php:Y-m-d H:s:i'],
            [['date'], 'default', 'value' => date('Y-m-d H:i:s')],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 128],
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
            'luminary_id' => Yii::t('app', 'Luminary ID'),
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getNewsImages()
    {
        return $this->hasMany(NewsImage::class, ['news_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\NewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'luminary';
        $fields[] = 'newsImages';
        return $fields;
    }

    public function getPermissions()
    {
        $perm = parent::getPermissions();
        $perm['upload'] = 'uploadNews';
        return $perm;
    }

    public function getRuleParams($action)
    {
        switch ($action) {
            case 'upload' :
                $newsId = \Yii::$app->request->get('newsId', 0);
                return ['News' => News::findOne($newsId)];
            default:
                return [];
        }
    }
}
