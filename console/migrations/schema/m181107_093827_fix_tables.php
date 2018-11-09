<?php

use console\yii2\Migration;

/**
 * Class m181107_093827_fix_tables
 */
class m181107_093827_fix_tables extends Migration
{
    const DURATION = '{{%duration}}';
    const IMAGE = '{{%image}}';
    const LUMINARY = '{{%luminary}}';
    const USER = '{{%user}}';
    const ACTIVITY_DURATION = '{{%activity_duration}}';
    const ACTIVITY_IMAGE = '{{%activity_image}}';
    const USER_IMAGE = '{{%user_image}}';
    const LOCATION = '{{%location}}';

    public function up()
    {
        $this->dropColumn(self::DURATION, 'date');
        $this->addColumn(self::DURATION, 'duration', $this->string());
        $this->addColumn(self::DURATION, 'luminary_id', $this->integer()->defaultValue(null)->null());
        $this->addForeignKey(
            'fk_duration_luminary_id__luminary_id',
            self::DURATION,
            'luminary_id',
            self::LUMINARY,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE
        );

        $this->dropForeignKey('fk_activity_duration_luminary_id__luminary_id', self::ACTIVITY_DURATION);
        $this->dropColumn('{{%activity_duration}}', 'luminary_id');

        $this->addColumn(self::IMAGE, 'user_id', $this->integer()->defaultValue(null)->null());
        $this->addForeignKey(
            'fk_image_user_id__user_id',
            self::IMAGE,
            'user_id',
            self::USER,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE
        );

        $this->dropForeignKey('fk_activity_image_user_image_id__user_image_id', self::ACTIVITY_IMAGE);
        $this->renameColumn(self::ACTIVITY_IMAGE, 'user_image_id', 'image_id');
        $this->addForeignKey(
            'fk_activity_image_image_id__image_id',
            self::ACTIVITY_IMAGE,
            'image_id',
            self::IMAGE,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->dropForeignKey('fk_user_user_image_id__user_image_id', self::USER);
        $this->renameColumn(self::USER, 'user_image_id', 'image_id');
        $this->addForeignKey(
            'fk_user_image_id__image_id',
            self::USER,
            'image_id',
            self::IMAGE,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->dropTable(self::USER_IMAGE);

        $this->addColumn(self::LOCATION, 'user_id', $this->integer()->defaultValue(null)->null());
        $this->addForeignKey(
            'fk_location_user_id__user_id',
            self::LOCATION,
            'user_id',
            self::USER,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );
    }

    public function down()
    {
        echo "m181107_093827_fix_tables cannot be reverted.\n";

        return false;
    }
}
