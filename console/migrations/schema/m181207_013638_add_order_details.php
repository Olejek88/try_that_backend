<?php

use \console\yii2\Migration;

/**
 * Class m181207_013638_add_order_details
 */
class m181207_013638_add_order_details extends Migration
{
    const ORDER_DETAIL = '{{%order_details}}';
    const ORDER = '{{%order}}';
    const FK_ORDER_DETAIL2ORDER = 'fk_order_order_id__order_id';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::ORDER_DETAIL, [
            'id' => $this->primaryKey(),
            'firstName' => $this->string()->notNull(),
            'lastName' => $this->string()->notNull(),
            'order_id' => $this->integer()->notNull(),
            'company' => $this->string(),
            'phone' => $this->integer()->notNull(),
            'address' => $this->integer()
        ]);

        $this->addForeignKey(
            self::FK_ORDER_DETAIL2ORDER,
            self::ORDER_DETAIL,
            'order_id',
            self::ORDER,
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
        echo "m181207_013638_add_order_details cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181207_013638_add_order_details cannot be reverted.\n";

        return false;
    }
    */
}
