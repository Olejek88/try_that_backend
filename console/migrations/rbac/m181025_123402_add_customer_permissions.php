<?php

use yii\db\Migration;

/**
 * Class m181025_123402_add_customer_permissions
 */
class m181025_123402_add_customer_permissions extends Migration
{
    private $models = [
        'common\models\ActivityCategory' => ['read',],
        'common\models\ActivityDuration' => ['read',],
        'common\models\ActivityImage' => ['read',],
        'common\models\ActivityListing' => ['read',],
        'common\models\Activity' => ['read',],
        'common\models\Category' => ['read',],
        'common\models\Country' => ['read',],
        'common\models\Customer' => ['read', 'update',],
        'common\models\Duration' => ['read',],
        'common\models\ExceptionTT' => ['read',],
        'common\models\FollowList' => ['create', 'read', 'update', 'delete'],
        'common\models\GroupExperience' => ['create', 'read', 'update', 'delete'],
        'common\models\Image' => ['create', 'read', 'update', 'delete'],
        'common\models\InvoiceQuery' => ['create', 'update', 'delete'],
        'common\models\InvoiceQueryStatus' => ['read',],
        'common\models\Location' => ['read',],
        'common\models\Luminary' => ['read',],
        'common\models\Mail' => ['create', 'update'],
        'common\models\MailStatus' => ['read',],
        'common\models\NewsImage' => ['read',],
        'common\models\News' => ['read',],
        'common\models\Occasion' => ['create', 'read', 'update', 'delete'],
        'common\models\Order' => ['create', 'update'],
        'common\models\OrderStatus' => ['read',],
        'common\models\PaySystem' => ['read',],
        'common\models\Review' => ['create', 'read', 'update', 'delete'],
        'common\models\Tag' => ['read',],
        'common\models\Trending' => ['create', 'read',],
        'common\models\UserAttribute' => ['create', 'read', 'update', 'delete'],
        'common\models\UserImage' => ['create', 'read', 'update', 'delete'],
        'common\models\User' => ['create', 'read',],
        'common\models\Wishlist' => ['create', 'read', 'update', 'delete'],
    ];

    /**
     * @return bool|void
     * @throws \yii\base\Exception
     */
    public function up()
    {
        $auth = \Yii::$app->authManager;
        $customerRole = $auth->getRole(common\models\User::ROLE_CUSTOMER);

        foreach ($this->models as $modelClassName => $modelInfo) {
            $className = explode('\\', $modelClassName);
            $className = $className[count($className) - 1];
            foreach ($modelInfo as $needPerm) {
                $permName = $needPerm . $className;
                $isOwnerSuffix = ($needPerm == 'update' || $needPerm == 'delete');
                $permName .= $isOwnerSuffix ? 'Owner' : '';
                $perm = $auth->getPermission($permName);
                $auth->addChild($customerRole, $perm);
            }
        }
    }

    public function down()
    {
        echo "m181025_123402_add_customer_permissions cannot be reverted.\n";

        $auth = \Yii::$app->authManager;
        $customerRole = $auth->getRole(\common\models\User::ROLE_CUSTOMER);

        foreach ($this->models as $modelClassName => $modelInfo) {
            $className = explode('\\', $modelClassName);
            $className = $className[count($className) - 1];
            foreach ($modelInfo as $needPerm) {
                $permName = $needPerm . $className;
                $isOwnerSuffix = ($needPerm == 'update' || $needPerm == 'delete');
                $permName .= $isOwnerSuffix ? 'Owner' : '';
                $perm = $auth->getPermission($permName);
                $auth->removeChild($customerRole, $perm);
            }
        }

        return true;
    }
}
