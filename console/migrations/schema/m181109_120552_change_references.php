<?php

use \console\yii2\Migration;

/**
 * Class m181109_120552_change_references
 */
class m181109_120552_change_references extends Migration
{
    const TRENDING = '{{%trending}}';
    const OCCASION = '{{%occasion}}';
    const LOCATION = '{{%location}}';
    const CITY = '{{%city}}';

    const FK_TRENDING2ACTIVITY = 'fk_trending_activity_id__activity_id';
    const FK_OCCASION2ACTIVITY = 'fk_occasion_activity_id__activity_id';
    const FK_LOCATION2ACTIVITY = 'fk_location_city_id__city_id';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey(self::FK_TRENDING2ACTIVITY, self::TRENDING);
        $this->dropForeignKey(self::FK_OCCASION2ACTIVITY, self::OCCASION);

        $this->dropColumn(self::TRENDING, 'activity_id');
        $this->dropColumn(self::OCCASION, 'activity_id');

        $this->addColumn(self::LOCATION, 'city_id', $this->integer()->notNull());
        $this->addForeignKey(
            self::FK_LOCATION2ACTIVITY,
            self::LOCATION,
            'city_id',
            self::CITY,
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
        echo "m181109_120552_change_references cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181109_120552_change_references cannot be reverted.\n";

        return false;
    }
    */
}
