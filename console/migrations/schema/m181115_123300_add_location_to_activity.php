<?php

use common\models\Activity;
use common\models\Location;
use \console\yii2\Migration;

/**
 * Class m181115_123300_add_location_to_activity
 */
class m181115_123300_add_location_to_activity extends Migration
{
    const ACTIVITY = '{{%activity}}';
    const LOCATION = '{{%location}}';
    const FK_ACTIVITY2LOCATION = 'fk_activity_location_id__location_id';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::ACTIVITY, 'location_id', $this->integer()->notNull());
        $location = Location::find()->one();
        $items = Activity::find()->all();
        foreach ($items as $item) {
            if ($location) {
                $item['location_id'] = $location['id'];
                $item->save();
            }
        }

        $this->addForeignKey(
            self::FK_ACTIVITY2LOCATION,
            self::ACTIVITY,
            'location_id',
            self::LOCATION,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181115_123300_add_location_to_activity cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181115_123300_add_location_to_activity cannot be reverted.\n";

        return false;
    }
    */
}
