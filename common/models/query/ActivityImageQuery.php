<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\ActivityImage]].
 *
 * @see \common\models\ActivityImage
 */
class ActivityImageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\ActivityImage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ActivityImage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
