<?php

use yii\db\Migration;

/**
 * Class m181029_103339_add_luminary_read_permissions
 */
class m181029_103339_add_luminary_read_permissions extends Migration
{
    /**
     * @return bool|void
     * @throws Exception
     */
    public function up()
    {
        $auth = \Yii::$app->authManager;
        $luminaryRole = $auth->getRole(common\models\User::ROLE_LUMINARY);

        // read
        $ruleClassName = 'common\components\rbac\InvoiceQueryParentOwnerRule';
        $rule = new $ruleClassName;
        $auth->add($rule);
        $permissionName = 'readInvoiceQueryParentOwner';
        $permission = $auth->createPermission($permissionName);
        $permission->description = $permissionName;
        $permission->ruleName = $rule->name;
        $auth->add($permission);
        $readPerm = $auth->getPermission('readInvoiceQuery');
        $auth->addChild($permission, $readPerm);
        $auth->addChild($luminaryRole, $permission);

        // read
        $ruleClassName = 'common\components\rbac\MailParentOwnerRule';
        $rule = new $ruleClassName;
        $auth->add($rule);
        $permissionName = 'readMailParentOwner';
        $permission = $auth->createPermission($permissionName);
        $permission->description = $permissionName;
        $permission->ruleName = $rule->name;
        $auth->add($permission);
        $readPerm = $auth->getPermission('readMail');
        $auth->addChild($permission, $readPerm);
        $auth->addChild($luminaryRole, $permission);

        // read
        $ruleClassName = 'common\components\rbac\OrderParentOwnerRule';
        $rule = new $ruleClassName;
        $auth->add($rule);
        $permissionName = 'readOrderParentOwner';
        $permission = $auth->createPermission($permissionName);
        $permission->description = $permissionName;
        $permission->ruleName = $rule->name;
        $auth->add($permission);
        $readPerm = $auth->getPermission('readOrder');
        $auth->addChild($permission, $readPerm);
        $auth->addChild($luminaryRole, $permission);

        // update
        $permissionName = 'updateOrderParentOwner';
        $permission = $auth->createPermission($permissionName);
        $permission->description = $permissionName;
        $permission->ruleName = $rule->name;
        $auth->add($permission);
        $updatePerm = $auth->getPermission('updateOrder');
        $auth->addChild($permission, $updatePerm);
        $auth->addChild($luminaryRole, $permission);
    }

    public function down()
    {
        echo "m181029_103339_add_luminary_read_permissions cannot be reverted.\n";
        $auth = \Yii::$app->authManager;
        $luminaryRole = $auth->getRole(common\models\User::ROLE_LUMINARY);

        // Order
        $permissionName = 'updateOrderParentOwner';
        $permission = $auth->getPermission($permissionName);
        $auth->removeChild($luminaryRole, $permission);
        $updatePerm = $auth->getPermission('updateOrder');
        $auth->removeChild($permission, $updatePerm);
        $auth->remove($permission);

        $permissionName = 'readOrderParentOwner';
        $permission = $auth->getPermission($permissionName);
        $auth->removeChild($luminaryRole, $permission);
        $updatePerm = $auth->getPermission('readOrder');
        $auth->removeChild($permission, $updatePerm);
        $auth->remove($permission);

        /* @var \yii\rbac\Rule $ruleObj */
        $ruleClassName = 'common\components\rbac\OrderParentOwnerRule';
        $ruleObj = new $ruleClassName;
        $rule = $auth->getRule($ruleObj->name);
        $auth->remove($rule);

        // Mail
        $permissionName = 'readMailParentOwner';
        $permission = $auth->getPermission($permissionName);
        $auth->removeChild($luminaryRole, $permission);
        $updatePerm = $auth->getPermission('readMail');
        $auth->removeChild($permission, $updatePerm);
        $auth->remove($permission);

        $ruleClassName = 'common\components\rbac\MailParentOwnerRule';
        $ruleObj = new $ruleClassName;
        $rule = $auth->getRule($ruleObj->name);
        $auth->remove($rule);

        // InvoiceQuery
        $permissionName = 'readInvoiceQueryParentOwner';
        $permission = $auth->getPermission($permissionName);
        $auth->removeChild($luminaryRole, $permission);
        $updatePerm = $auth->getPermission('readInvoiceQuery');
        $auth->removeChild($permission, $updatePerm);
        $auth->remove($permission);

        $ruleClassName = 'common\components\rbac\InvoiceQueryParentOwnerRule';
        $ruleObj = new $ruleClassName;
        $rule = $auth->getRule($ruleObj->name);
        $auth->remove($rule);

        return true;
    }
}
