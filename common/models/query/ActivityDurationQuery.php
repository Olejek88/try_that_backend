<?php

namespace common\models\query;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[common\models\ActivityDuration]].
 *
 * @see ActivityDuration
 */
class ActivityDurationQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\ActivityDuration[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ActivityDuration|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
