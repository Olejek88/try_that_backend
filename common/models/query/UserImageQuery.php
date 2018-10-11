<?php

namespace common\models\query;

use common\models\UserImage;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[UserImage]].
 *
 * @see \common\models\UserImage
 */
class UserImageQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserImage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserImage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
