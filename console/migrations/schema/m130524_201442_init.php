<?php

use common\models\User;
use console\yii2\Migration;

class m130524_201442_init extends Migration
{
    const USER = '{{%user}}';

    public function up()
    {
        // @note: По-умолчанию, пользователь создается с неактивным статусом и ролью клиента.
        $this->createTable(self::USER, [
            'id' => $this->primaryKey(),
            // @todo: Может провести нормализацию и оставить лишь служебные поля?
            'firstName' => $this->string()->notNull(),
            'lastName' => $this->string()->notNull(),
            'birthDate' => $this->dateTime(),
            'email' => $this->string()->notNull()->unique(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'location_id' => $this->integer()->notNull(),
            'country_id' => $this->integer()->notNull(),
            'phone' => $this->string(),
            // @todo: В дальнейшем пересмотреть поле (notNull()->defaultValue("заглушка")).
            'image_id' => $this->integer(),
            'registeredDate' => $this->dateTime(),
            'role' => $this->string(32)->notNull()->defaultValue(User::ROLE_CLIENT),
            'status' => $this->smallInteger()->notNull()->defaultValue(User::STATUS_DELETED),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
