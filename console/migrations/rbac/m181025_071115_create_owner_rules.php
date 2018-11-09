<?php

use yii\db\Migration;

/**
 * Class m181025_071115_create_own_rules
 */
class m181025_071115_create_owner_rules extends Migration
{
    private $ruleClasses = [
        'common\components\rbac\ActivityDurationOwnerRule',
        'common\components\rbac\ActivityImageOwnerRule',
        'common\components\rbac\ActivityListingOwnerRule',
        'common\components\rbac\ActivityOwnerRule',
        'common\components\rbac\CustomerOwnerRule',
        'common\components\rbac\DurationOwnerRule',
        'common\components\rbac\ExceptionTTOwnerRule',
        'common\components\rbac\FollowListOwnerRule',
        'common\components\rbac\GroupExperienceOwnerRule',
        'common\components\rbac\ImageOwnerRule',
        'common\components\rbac\InvoiceQueryOwnerRule',
        'common\components\rbac\LocationOwnerRule',
        'common\components\rbac\LuminaryOwnerRule',
        'common\components\rbac\MailOwnerRule',
        'common\components\rbac\NewsImageOwnerRule',
        'common\components\rbac\NewsOwnerRule',
        'common\components\rbac\OccasionOwnerRule',
        'common\components\rbac\OrderOwnerRule',
        'common\components\rbac\ReviewOwnerRule',
        'common\components\rbac\TagOwnerRule',
        'common\components\rbac\TrendingOwnerRule',
        'common\components\rbac\UserAttributeOwnerRule',
        'common\components\rbac\UserOwnerRule',
        'common\components\rbac\WishlistOwnerRule',
    ];

    /**
     * @return bool|void
     * @throws Exception
     */
    public function up()
    {
        $auth = \Yii::$app->authManager;

        foreach ($this->ruleClasses as $ruleClass) {
            $rule = new $ruleClass;
            $auth->add($rule);
        }
    }

    public function down()
    {
        echo "m181025_071115_create_own_rules cannot be reverted.\n";

        $auth = \Yii::$app->authManager;

        foreach ($this->ruleClasses as $ruleClass) {
            $ruleObj = new $ruleClass;
            $rule = $auth->getRule($ruleObj->name);
            $auth->remove($rule);
        }

        return true;
    }
}
