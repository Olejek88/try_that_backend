<?php

use yii\db\Migration;

/**
 * Class m181025_111854_add_luminary_permissions
 */
class m181025_111854_add_luminary_permissions extends Migration
{
    private $models = [
        'common\models\ActivityCategory' => ['read',],
        'common\models\ActivityDuration' => ['create', 'read', 'update', 'delete'],
        'common\models\ActivityImage' => ['create', 'read', 'update', 'delete'],
        'common\models\ActivityListing' => ['create', 'read', 'update', 'delete'],
        'common\models\Activity' => ['create', 'read', 'update', 'delete'],
        'common\models\Category' => ['read',],
        'common\models\Country' => ['read',],
        'common\models\Customer' => ['read',],
        'common\models\Duration' => ['create', 'read', 'update', 'delete'],
        'common\models\ExceptionTT' => ['create', 'read', 'update', 'delete'],
        'common\models\FollowList' => ['read', 'update', 'delete'],
        'common\models\GroupExperience' => ['read',],
        'common\models\Image' => ['create', 'read', 'update', 'delete'],
        'common\models\InvoiceQuery' => ['update', 'delete'],
        'common\models\InvoiceQueryStatus' => ['read',],
        'common\models\Location' => ['create', 'read', 'update', 'delete'],
        'common\models\Luminary' => ['read', 'update',],
        'common\models\Mail' => ['create', 'update',],
        'common\models\MailStatus' => ['read',],
        'common\models\NewsImage' => ['create', 'read', 'update', 'delete'],
        'common\models\News' => ['create', 'read', 'update', 'delete'],
        'common\models\Occasion' => ['create', 'read', 'update', 'delete'],
        'common\models\Order' => [],
        'common\models\OrderStatus' => ['read',],
        'common\models\PaySystem' => ['read',],
        'common\models\Review' => ['create', 'read', 'update', 'delete'],
        'common\models\Tag' => ['create', 'read',],
        'common\models\Trending' => ['create', 'read'],
        'common\models\UserAttribute' => ['create', 'read', 'update', 'delete'],
        'common\models\UserImage' => ['create', 'read', 'update', 'delete'],
        'common\models\User' => ['read', 'update'],
        'common\models\Wishlist' => [],
    ];

    /**
     * @return bool|void
     * @throws \yii\base\Exception
     */
    public function up()
    {
        $auth = \Yii::$app->authManager;
        $luminaryRole = $auth->getRole(common\models\User::ROLE_LUMINARY);

        foreach ($this->models as $modelClassName => $modelInfo) {
            $className = explode('\\', $modelClassName);
            $className = $className[count($className) - 1];
            foreach ($modelInfo as $needPerm) {
                $permName = $needPerm . $className;
                $isOwnerSuffix = ($needPerm == 'update' || $needPerm == 'delete');
                $permName .= $isOwnerSuffix ? 'Owner' : '';
                $perm = $auth->getPermission($permName);
                $auth->addChild($luminaryRole, $perm);
            }
        }
    }

    public function down()
    {
        echo "m181025_111854_add_luminary_permissions cannot be reverted.\n";

        $auth = \Yii::$app->authManager;
        $luminaryRole = $auth->getRole(\common\models\User::ROLE_LUMINARY);

        foreach ($this->models as $modelClassName => $modelInfo) {
            $className = explode('\\', $modelClassName);
            $className = $className[count($className) - 1];
            foreach ($modelInfo as $needPerm) {
                $permName = $needPerm . $className;
                $isOwnerSuffix = ($needPerm == 'update' || $needPerm == 'delete');
                $permName .= $isOwnerSuffix ? 'Owner' : '';
                $perm = $auth->getPermission($permName);
                $auth->removeChild($luminaryRole, $perm);
            }
        }

        return true;
    }
}
