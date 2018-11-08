<?php

use yii\db\Migration;

/**
 * Class m181024_132904_init
 */
class m181024_132904_init extends Migration
{
    /**
     * @return bool|void
     * @throws Exception
     */
    public function up()
    {
        $auth = \Yii::$app->authManager;

        $adminRole = $auth->createRole(common\models\User::ROLE_ADMIN);
        $auth->add($adminRole);

        $customerRole = $auth->createRole(common\models\User::ROLE_CUSTOMER);
        $auth->add($customerRole);

        $luminaryRole = $auth->createRole(common\models\User::ROLE_LUMINARY);
        $auth->add($luminaryRole);
    }

    public function down()
    {
        echo "m181024_132904_init cannot be reverted.\n";

        $auth = \Yii::$app->authManager;

        $role = $auth->getRole(common\models\User::ROLE_LUMINARY);
        $auth->remove($role);

        $role = $auth->getRole(common\models\User::ROLE_CUSTOMER);
        $auth->remove($role);

        $role = $auth->getRole(common\models\User::ROLE_ADMIN);
        $auth->remove($role);

        return true;
    }
}
