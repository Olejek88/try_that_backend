<?php

use yii\db\Migration;

/**
 * Class m181029_103536_add_customer_read_permissions
 */
class m181029_103536_add_customer_read_permissions extends Migration
{
    /**
     * @return bool|void
     * @throws Exception
     */
    public function up()
    {
        $auth = \Yii::$app->authManager;
        $customerRole = $auth->getRole(common\models\User::ROLE_CUSTOMER);

        /* @var \yii\rbac\Rule $ruleObj */

        // read
        $ruleClassName = 'common\components\rbac\InvoiceQueryOwnerRule';
        $ruleObj = new $ruleClassName;
        $rule = $auth->getRule($ruleObj->name);
        $permissionName = 'readInvoiceQueryOwner';
        $permission = $auth->createPermission($permissionName);
        $permission->description = $permissionName;
        $permission->ruleName = $rule->name;
        $auth->add($permission);
        $readPerm = $auth->getPermission('readInvoiceQuery');
        $auth->addChild($permission, $readPerm);
        $auth->addChild($customerRole, $permission);

        // read
        $ruleClassName = 'common\components\rbac\MailOwnerRule';
        $ruleObj = new $ruleClassName;
        $rule = $auth->getRule($ruleObj->name);
        $permissionName = 'readMailOwner';
        $permission = $auth->createPermission($permissionName);
        $permission->description = $permissionName;
        $permission->ruleName = $rule->name;
        $auth->add($permission);
        $readPerm = $auth->getPermission('readMail');
        $auth->addChild($permission, $readPerm);
        $auth->addChild($customerRole, $permission);

        // read
        $ruleClassName = 'common\components\rbac\OrderOwnerRule';
        $ruleObj = new $ruleClassName;
        $rule = $auth->getRule($ruleObj->name);
        $permissionName = 'readOrderOwner';
        $permission = $auth->createPermission($permissionName);
        $permission->description = $permissionName;
        $permission->ruleName = $rule->name;
        $auth->add($permission);
        $readPerm = $auth->getPermission('readOrder');
        $auth->addChild($permission, $readPerm);
        $auth->addChild($customerRole, $permission);
    }

    public function down()
    {
        echo "m181029_103339_add_luminary_read_permissions cannot be reverted.\n";
        $auth = \Yii::$app->authManager;
        $customerRole = $auth->getRole(\common\models\User::ROLE_CUSTOMER);

        // Order
        $permissionName = 'readOrderOwner';
        $permission = $auth->getPermission($permissionName);
        $auth->removeChild($customerRole, $permission);
        $auth->remove($permission);

        // Mail
        $permissionName = 'readMailOwner';
        $permission = $auth->getPermission($permissionName);
        $auth->removeChild($customerRole, $permission);
        $auth->remove($permission);

        // InvoiceQuery
        $permissionName = 'readInvoiceQueryOwner';
        $permission = $auth->getPermission($permissionName);
        $auth->removeChild($customerRole, $permission);
        $auth->remove($permission);

        return true;
    }
}
