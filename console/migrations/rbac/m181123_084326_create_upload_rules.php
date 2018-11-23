<?php

use yii\db\Migration;

/**
 * Class m181123_084326_create_upload_rules
 */
class m181123_084326_create_upload_rules extends Migration
{
    /**
     * @return bool|void
     * @throws Exception
     * @throws \yii\base\Exception
     */
    public function up()
    {
        $auth = \Yii::$app->authManager;
        $luminaryRole = $auth->getRole(common\models\User::ROLE_LUMINARY);

        /* @var \yii\rbac\Rule $ruleObj */

        // uploadActivity
        $permUActivityName = 'uploadActivity';
        $permission = $auth->createPermission($permUActivityName);
        $permission->description = $permUActivityName;
        $auth->add($permission);


        // uploadActivityOwner
        $ruleClassName = 'common\components\rbac\ActivityOwnerRule';
        $ruleObj = new $ruleClassName;
        $rule = $auth->getRule($ruleObj->name);
        $permUActivityOwnerName = 'uploadActivityOwner';
        $permission = $auth->createPermission($permUActivityOwnerName);
        $permission->description = $permUActivityOwnerName;
        $permission->ruleName = $rule->name;
        $auth->add($permission);

        // link roles
        $uploadPerm = $auth->getPermission($permUActivityName);
        $auth->addChild($permission, $uploadPerm);
        $auth->addChild($luminaryRole, $permission);

        // uploadNews
        $permUNewsName = 'uploadNews';
        $permission = $auth->createPermission($permUNewsName);
        $permission->description = $permUNewsName;
        $auth->add($permission);


        // uploadNewsOwner
        $ruleClassName = 'common\components\rbac\NewsOwnerRule';
        $ruleObj = new $ruleClassName;
        $rule = $auth->getRule($ruleObj->name);
        $permUNewsOwnerName = 'uploadNewsOwner';
        $permission = $auth->createPermission($permUNewsOwnerName);
        $permission->description = $permUNewsOwnerName;
        $permission->ruleName = $rule->name;
        $auth->add($permission);

        // link roles
        $uploadPerm = $auth->getPermission($permUNewsName);
        $auth->addChild($permission, $uploadPerm);
        $auth->addChild($luminaryRole, $permission);
    }

    public function down()
    {
        echo "m181123_084326_create_upload_rules cannot be reverted.\n";

        $auth = \Yii::$app->authManager;
        $luminaryRole = $auth->getRole(common\models\User::ROLE_LUMINARY);

        // uploadActivity
        $uActivityOwnerName = 'uploadActivityOwner';
        $uActivityOwnerPerm = $auth->getPermission($uActivityOwnerName);
        $auth->removeChild($luminaryRole, $uActivityOwnerPerm);
        $uActivityName = 'uploadActivity';
        $uActivityPerm = $auth->getPermission($uActivityName);
        $auth->removeChild($uActivityOwnerPerm, $uActivityPerm);
        $auth->remove($uActivityOwnerPerm);
        $auth->remove($uActivityPerm);

        // uploadNews
        $uNewsOwnerName = 'uploadNewsOwner';
        $uNewsOwnerPerm = $auth->getPermission($uNewsOwnerName);
        $auth->removeChild($luminaryRole, $uNewsOwnerPerm);
        $uNewsName = 'uploadNews';
        $uNewsPerm = $auth->getPermission($uNewsName);
        $auth->removeChild($uNewsOwnerPerm, $uNewsPerm);
        $auth->remove($uNewsOwnerPerm);
        $auth->remove($uNewsPerm);

        return true;
    }
}
