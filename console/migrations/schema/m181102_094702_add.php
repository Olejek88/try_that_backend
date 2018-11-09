<?php

/**
 * Class m181102_094702_add
 */
class m181102_094702_add extends \console\yii2\Migration
{
    const TAG = '{{%tag}}';
    const ACTIVITY_TAG = '{{%activity_tag}}';
    const ACTIVITY = '{{%activity}}';
    const FK_TAG2ACTIVITY = 'fk_tag_activity_id__activity_id';
    const FK_ACTIVITYTAG2TAG = 'fk_activity_tag_tag_id__tag_id';
    const FK_ACTIVITYTAG2ACTIVITY = 'fk_activity_tag_activity_id__activity_id';

    public function up()
    {
        // удаляем лишнее поле
        $this->dropForeignKey(self::FK_TAG2ACTIVITY, self::TAG);
        $this->dropColumn(self::TAG, 'activity_id');

        // таблица для хранения связи между activity и tag
        $this->createTable(self::ACTIVITY_TAG, [
            'id' => $this->primaryKey(),
            'activity_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            self::FK_ACTIVITYTAG2TAG,
            self::ACTIVITY_TAG,
            'tag_id',
            self::TAG,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            self::FK_ACTIVITYTAG2ACTIVITY,
            self::ACTIVITY_TAG,
            'activity_id',
            self::ACTIVITY,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE
        );
    }

    public function down()
    {
        echo "m181102_094702_add cannot be reverted.\n";

        return false;
    }
}
