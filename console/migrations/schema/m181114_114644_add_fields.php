<?php

use \console\yii2\Migration;

/**
 * Class m181114_114644_add_fields
 */
class m181114_114644_add_fields extends Migration
{
    const ACTIVITY = '{{%activity}}';
    const ACTIVITY_LISTING = '{{%activity_listing}}';
    const OCCASION = '{{%occasion}}';
    const TRENDING = '{{%trending}}';

    const FK_ACTIVITY2OCCASION = 'fk_activity_occasion_id__occasion_id';
    const FK_ACTIVITY2TRENDING = 'fk_activity_trending_id__trending_id';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::ACTIVITY, 'shortDescription', $this->text());
        $this->addColumn(self::ACTIVITY, 'occasion_id', $this->integer()->notNull());
        $this->addForeignKey(
            self::FK_ACTIVITY2OCCASION,
            self::ACTIVITY,
            'occasion_id',
            self::OCCASION,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE
        );
        $this->addColumn(self::ACTIVITY, 'trending_id', $this->integer()->notNull());
        $this->addForeignKey(
            self::FK_ACTIVITY2TRENDING,
            self::ACTIVITY,
            'trending_id',
            self::TRENDING,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE
        );

        $this->addColumn(self::ACTIVITY_LISTING, 'customers', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181114_114644_add_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181114_114644_add_fields cannot be reverted.\n";

        return false;
    }
    */
}
