<?php

namespace common\models\query;

use common\models\PaySystem;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[PaySystem]].
 *
 * @see PaySystem
 */
class PaySystemQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PaySystem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PaySystem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
