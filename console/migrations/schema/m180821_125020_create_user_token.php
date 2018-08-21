<?php

use console\yii2\Migration;

/**
 * Class m180821_125020_create_user_token
 */
class m180821_125020_create_user_token extends Migration
{
    const USER_TOKEN = '{{%user_token}}';
    const USER = '{{%user}}';

    public function up()
    {
        $this->createTable(self::USER_TOKEN, [
            'user_id' => $this->integer()->notNull(),
            'token' => $this->string(32)->notNull(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
            'valid_till' => $this->dateTime()->notNull()->defaultValue(0),
            'last_access' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
            'status' => $this->smallInteger(),
        ]);

        $this->addForeignKey(
            'fk_user_id__user_id',
            self::USER_TOKEN,
            'user_id',
            '{{%user}}',
            'id',
            self::FK_CASCADE,
            self::FK_RESTRICT
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_user_id__user_id', self::USER_TOKEN);
        $this->dropTable(self::USER_TOKEN);
    }
}
