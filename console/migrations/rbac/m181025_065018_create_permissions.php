<?php

use yii\db\Migration;

/**
 * Class m181025_065018_create_permissions
 */
class m181025_065018_create_permissions extends Migration
{
    private $models = [
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
     * @throws Exception
     */
    public function up()
    {
        $auth = \Yii::$app->authManager;

        foreach ($this->models as $model) {
            /* @var common\components\BaseRecord $obj */
            $obj = new $model;
            foreach ($obj->getPermissions() as $permissionName) {
                $permission = $auth->createPermission($permissionName);
                $permission->description = $permissionName;
                $auth->add($permission);
            }
        }
    }

    public function down()
    {
        echo "m181025_065018_create_permissions cannot be reverted.\n";

        $auth = \Yii::$app->authManager;

        foreach ($this->models as $object) {
            /* @var common\components\BaseRecord $c */
            $c = new $object;
            foreach ($c->getPermissions() as $permission) {
                $auth->remove($auth->getPermission($permission));
            }
        }

        return true;
    }
}
