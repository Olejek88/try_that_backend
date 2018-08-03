<?php

use console\yii2\Migration;

/**
 * Class m180803_091856_create_user_relation_table
 */
class m180803_091856_create_user_relation_table extends Migration
{
    const USER = '{{%user}}';
    const USER_ATTRIBUTE = '{{%user_attribute}}';

    public function up()
    {
        $this->createTable(self::USER_ATTRIBUTE, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'value' => $this->string(),
        ]);

        $this->addForeignKey(
            'fk_user_attribute_user_id__user_id',
            self::USER_ATTRIBUTE,
            'user_id',
            self::USER,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_user_attribute_user_id__user_id', self::USER_ATTRIBUTE);
        $this->dropTable(self::USER_ATTRIBUTE);
    }
}
