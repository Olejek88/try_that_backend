<?php

use \console\yii2\Migration;

/**
 * Class m181116_123903_change_mail_table
 */
class m181116_123903_change_mail_table extends Migration
{
    const MAIL = '{{%mail}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(self::MAIL, 'order_id', $this->integer()->null());
        //$this->addColumn(self::MAIL, 'answerTo', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181116_123903_change_mail_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181116_123903_change_mail_table cannot be reverted.\n";

        return false;
    }
    */
}
