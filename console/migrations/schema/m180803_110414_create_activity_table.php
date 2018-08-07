<?php

use console\yii2\Migration;

/**
 * Class m180803_110414_create_activity_table
 */
class m180803_110414_create_activity_table extends Migration
{
    const LOCATION = '{{%location}}';
    const COUNTRY = '{{%country}}';
    const ACTIVITY = '{{%activity}}';

    public function up()
    {
        // @todo: Добавить связь (user).
        $this->createTable(self::LOCATION, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'latitude' => $this->integer()->notNull()->defaultValue(0),
            'longitude' => $this->integer()->notNull()->defaultValue(0),
            'image_id' => $this->integer(),
        ]);

        // @todo: Добавить связь (user).
        $this->createTable(self::COUNTRY, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'image_id' => $this->integer(),
        ]);

        // @todo[msdev]: Добавить таблицы для связей и реализовать множественные обвязки (не забыть про порядок связей).
        $this->createTable(self::ACTIVITY, [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->string(),
            'luminary_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'activity_category_id' => $this->integer()->notNull(),
            // @todo: fix me one on many (occasion_id, tag_id, image_id, trending_id, duration_id).
            'occasion_id' => $this->integer()->notNull(),
            'trending_id' => $this->integer()->notNull(),
            'duration_id' => $this->integer(),
            'tag_id' => $this->integer(),
            'image_id' => $this->integer(),
            'min_customers' => $this->integer(),
            'max_customers' => $this->integer(),
            // @todo: Сабж.
            'start_date' => $this->integer()->notNull(),
            'end_date' => $this->integer()->notNull(),
        ]);

        // @todo[msdev]: Создать: occasion, tag, image, trending, duration.

//        $this->addForeignKey(
//            'fk_user_attribute_user_id__user_id',
//            self::USER_ATTRIBUTE,
//            'user_id',
//            self::USER,
//            'id',
//            self::FK_CASCADE,
//            self::FK_CASCADE
//        );
    }

    public function down()
    {
        $this->dropTable(self::ACTIVITY);
        $this->dropTable(self::COUNTRY);
        $this->dropTable(self::LOCATION);
    }
}
