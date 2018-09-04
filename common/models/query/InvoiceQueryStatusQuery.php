<?php

namespace common\models\query;

use common\models\InvoiceQueryStatus;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[InvoiceQueryStatus]].
 *
 * @see InvoiceQueryStatus
 */
class InvoiceQueryStatusQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return InvoiceQueryStatus[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return InvoiceQueryStatus|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
