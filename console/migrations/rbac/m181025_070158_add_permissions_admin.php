<?php

use yii\db\Migration;

/**
 * Class m181025_070158_add_permissions_admin
 */
class m181025_070158_add_permissions_admin extends Migration
{
    private $objects = [
        'common\models\ActivityCategory',
        'common\models\ActivityDuration',
        'common\models\ActivityImage',
        'common\models\ActivityListing',
        'common\models\Activity',
        'common\models\Category',
        'common\models\Country',
        'common\models\Customer',
        'common\models\Duration',
        'common\models\ExceptionTT',
        'common\models\FollowList',
        'common\models\GroupExperience',
        'common\models\Image',
        'common\models\InvoiceQuery',
        'common\models\InvoiceQueryStatus',
        'common\models\Location',
        'common\models\Luminary',
        'common\models\Mail',
        'common\models\MailStatus',
        'common\models\NewsImage',
        'common\models\News',
        'common\models\Occasion',
        'common\models\Order',
        'common\models\OrderStatus',
        'common\models\PaySystem',
        'common\models\Review',
        'common\models\Tag',
        'common\models\Trending',
        'common\models\UserAttribute',
        'common\models\UserImage',
        'common\models\User',
        'common\models\Wishlist',
    ];

    /**
     * @return bool|void
     * @throws \yii\base\Exception
     */
    public function up()
    {
        $auth = \Yii::$app->authManager;

        $adminRole = $auth->getRole(common\models\User::ROLE_ADMIN);

        foreach ($this->objects as $object) {
            /* @var common\components\BaseRecord $c */
            $c = new $object;
            foreach ($c->getPermissions() as $name) {
                $permission = $auth->getPermission($name);
                $auth->addChild($adminRole, $permission);
            }
        }
    }

    public function down()
    {
        echo "m181025_070158_add_permissions_admin cannot be reverted.\n";

        $auth = \Yii::$app->authManager;

        $adminRole = $auth->getRole(common\models\User::ROLE_ADMIN);

        foreach ($this->objects as $object) {
            /* @var common\components\BaseRecord $c */
            $c = new $object;
            foreach ($c->getPermissions() as $name) {
                $permission = $auth->getPermission($name);
                $auth->removeChild($adminRole, $permission);
            }
        }

        return true;
    }
}
