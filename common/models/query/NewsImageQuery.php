<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\NewsImage]].
 *
 * @see \common\models\NewsImage
 */
class NewsImageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\NewsImage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\NewsImage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
