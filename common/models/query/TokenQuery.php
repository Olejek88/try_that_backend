<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\user\Token]].
 *
 * @see \common\models\UserToken
 */
class TokenQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\user\Token[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\user\Token|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
