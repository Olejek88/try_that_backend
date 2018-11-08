<?php

use yii\db\Migration;

/**
 * Class m181025_073929_create_permissions_luminary
 */
class m181025_073929_create_permissions_owner extends Migration
{
    private $objects = [
        'common\models\ActivityDuration' => 'common\components\rbac\ActivityDurationOwnerRule',
        'common\models\ActivityImage' => 'common\components\rbac\ActivityImageOwnerRule',
        'common\models\ActivityListing' => 'common\components\rbac\ActivityListingOwnerRule',
        'common\models\Activity' => 'common\components\rbac\ActivityOwnerRule',
        'common\models\Customer' => 'common\components\rbac\CustomerOwnerRule',
        'common\models\Duration' => 'common\components\rbac\DurationOwnerRule',
        'common\models\ExceptionTT' => 'common\components\rbac\ExceptionTTOwnerRule',
        'common\models\FollowList' => 'common\components\rbac\FollowListOwnerRule',
        'common\models\GroupExperience' => 'common\components\rbac\GroupExperienceOwnerRule',
        'common\models\Image' => 'common\components\rbac\ImageOwnerRule',
        'common\models\InvoiceQuery' => 'common\components\rbac\InvoiceQueryOwnerRule',
        'common\models\Location' => 'common\components\rbac\LocationOwnerRule',
        'common\models\Luminary' => 'common\components\rbac\LuminaryOwnerRule',
        'common\models\Mail' => 'common\components\rbac\MailOwnerRule',
        'common\models\NewsImage' => 'common\components\rbac\NewsImageOwnerRule',
        'common\models\News' => 'common\components\rbac\NewsOwnerRule',
        'common\models\Occasion' => 'common\components\rbac\OccasionOwnerRule',
        'common\models\Order' => 'common\components\rbac\OrderOwnerRule',
        'common\models\Review' => 'common\components\rbac\ReviewOwnerRule',
        'common\models\Tag' => 'common\components\rbac\TagOwnerRule',
        'common\models\Trending' => 'common\components\rbac\TrendingOwnerRule',
        'common\models\UserAttribute' => 'common\components\rbac\UserAttributeOwnerRule',
        'common\models\User' => 'common\components\rbac\UserOwnerRule',
        'common\models\Wishlist' => 'common\components\rbac\WishlistOwnerRule',
    ];

    /**
     * @return bool|void
     * @throws Exception
     * @throws \yii\base\Exception
     */
    public function up()
    {
        $auth = \Yii::$app->authManager;

        foreach ($this->objects as $model => $ruleClassName) {
            $ruleObj = new $ruleClassName;
            /* @var \common\components\BaseRecord $modelObj */
            $modelObj = new $model;
            $permissions = $modelObj->getPermissions();
            foreach (['update', 'delete'] as $permission) {
                $pName = $permissions[$permission];
                $pNameOwner = $pName . 'Owner';
                $permOwner = $auth->createPermission($pNameOwner);
                $permOwner->description = $pNameOwner;
                $permOwner->ruleName = $ruleObj->name;
                $auth->add($permOwner);
                $perm = $auth->getPermission($pName);
                $auth->addChild($permOwner, $perm);
            }
        }
    }

    public function down()
    {
        echo "m181025_073929_create_permissions_luminary cannot be reverted.\n";

        $auth = \Yii::$app->authManager;

        foreach ($this->objects as $model => $ruleClassName) {
            /* @var \common\components\BaseRecord $modelObj */
            $modelObj = new $model;
            $permissions = $modelObj->getPermissions();
            foreach (['update', 'delete'] as $permission) {
                $pName = $permissions[$permission];
                $pNameOwner = $pName . 'Owner';
                $permOwner = $auth->getPermission($pNameOwner);
                $perm = $auth->getPermission($pName);
                $auth->removeChild($permOwner, $perm);
                $auth->remove($permOwner);
            }
        }

        return true;
    }
}
