<?php


/**
 * Class m180903_113329_add_user_to_image_ref
 */
class m180903_113329_add_user_to_image_ref extends \console\yii2\Migration
{
    const LUMINARY = '{{%luminary}}';
    const DURATION = '{{%duration}}';
    const ACTIVITY_DURATION = '{{%activity_duration}}';
    const ACTIVITY = '{{%activity}}';
    const ORDER = '{{%order}}';
    const USER = '{{%user}}';
    const COUNTRY = '{{%country}}';
    const LOCATION = '{{%location}}';
    const IMAGE = '{{%image}}';
    const FK_USER2COUNTRY = 'fk_user_country_id__country_id';
    const FK_USER2LOCATION = 'fk_user_location_id__location_id';
    const FK_USER2IMAGE = 'fk_user_image_id__image_id';
    const FK_ORDER2DURATION = 'fk_order_duration_id__duration_id';
    const FK_ACTIVITY2DURATION = 'fk_activity_duration_id__duration_id';
    const FK_ACTIVITY_DURATION2ACTIVITY = 'fk_activity_duration_activity_id__activity_id';
    const FK_ACTIVITY_DURATION2DURATION = 'fk_activity_duration_duration_id__duration_id';
    const FK_ACTIVITY_DURATION2LUMINARY = 'fk_activity_duration_luminary_id__luminary_id';


    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addForeignKey(
            self::FK_USER2COUNTRY,
            self::USER,
            'country_id',
            self::COUNTRY,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE

        );

        $this->addForeignKey(
            self::FK_USER2LOCATION,
            self::USER,
            'location_id',
            self::LOCATION,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE

        );

        $this->addForeignKey(
            self::FK_USER2IMAGE,
            self::USER,
            'image_id',
            self::IMAGE,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE

        );

        $this->dropForeignKey(self::FK_ORDER2DURATION, self::ORDER);
        $this->dropColumn(self::ORDER, 'duration_id');

        $this->dropForeignKey(self::FK_ACTIVITY2DURATION, self::ACTIVITY);
        $this->dropColumn(self::ACTIVITY, 'duration_id');

        $this->createTable(self::ACTIVITY_DURATION, [
            'id' => $this->primaryKey(),
            'luminary_id' => $this->integer()->notNull(),
            'activity_id' => $this->integer()->notNull(),
            'duration_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            self::FK_ACTIVITY_DURATION2LUMINARY,
            self::ACTIVITY_DURATION,
            'luminary_id',
            self::LUMINARY,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE

        );

        $this->addForeignKey(
            self::FK_ACTIVITY_DURATION2ACTIVITY,
            self::ACTIVITY_DURATION,
            'activity_id',
            self::ACTIVITY,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE

        );

        $this->addForeignKey(
            self::FK_ACTIVITY_DURATION2DURATION,
            self::ACTIVITY_DURATION,
            'duration_id',
            self::DURATION,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE

        );

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m180903_113329_add_user_to_image_ref cannot be reverted.\n";
        $this->dropForeignKey(self::FK_USER2IMAGE, self::USER);
        $this->dropForeignKey(self::FK_USER2LOCATION, self::USER);
        $this->dropForeignKey(self::FK_USER2COUNTRY, self::USER);
        $this->dropForeignKey(self::FK_ACTIVITY_DURATION2DURATION, self::ACTIVITY_DURATION);
        $this->dropForeignKey(self::FK_ACTIVITY_DURATION2ACTIVITY, self::ACTIVITY_DURATION);
        $this->dropForeignKey(self::FK_ACTIVITY_DURATION2LUMINARY, self::ACTIVITY_DURATION);
        $this->dropTable(self::ACTIVITY_DURATION);
        $this->addColumn(self::ACTIVITY, 'duration_id', $this->integer()->notNull());
        $this->addForeignKey(
            self::FK_ACTIVITY2DURATION,
            self::ACTIVITY,
            'duration_id',
            self::DURATION,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE

        );
        $this->addColumn(self::ORDER, 'duration_id', $this->integer()->notNull());
        $this->addForeignKey(
            self::FK_ORDER2DURATION,
            self::ORDER,
            'duration_id',
            self::DURATION,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE
        );

        return true;
    }
}
