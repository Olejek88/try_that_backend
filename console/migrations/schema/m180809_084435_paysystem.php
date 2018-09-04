<?php

use console\yii2\Migration;

/**
 * Class m180809_084435_paysystem
 */
class m180809_084435_paysystem extends Migration
{
    const PAY_SYSTEM = '{{%pay_system}}';
    const INVOICE_QUERY = '{{%invoice_query}}';
    const ORDER = '{{%order}}';
    const INVOICE_QUERY_STATUS = '{{%invoice_query_status}}';

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable(self::PAY_SYSTEM, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'class' => $this->string()->notNull()->unique(),
            'enable' => $this->tinyInteger(1)->defaultValue(0),
        ]);

        $this->createTable(self::INVOICE_QUERY_STATUS, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
        ]);

        $this->createTable(self::INVOICE_QUERY, [
            'id' => $this->primaryKey(),
            'pay_system_class' => $this->string()->notNull(),
            'pay_system_name' => $this->string()->notNull(),
            'order_id' => $this->integer()->notNull()->unique(),
            'description' => $this->string(256)->notNull()->defaultValue(''),
            'cost' => $this->decimal(11, 2)->defaultValue(0.0),
            'extra_info' => $this->text()->notNull()->defaultValue(''),
            'status_id' => $this->integer()->notNull()->defaultValue(1),
            'status_date' => $this->dateTime()->null(),
            'create_date' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'last_check' => $this->dateTime()->null()->defaultValue(null),
        ]);

        $this->addForeignKey(
            'fk_invoice_query_order_id__order_id',
            self::INVOICE_QUERY,
            'order_id',
            self::ORDER,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_invoice_query_status_id__pay_system_status_id',
            self::INVOICE_QUERY,
            'status_id',
            self::INVOICE_QUERY_STATUS,
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
        echo "m180809_084435_paysystem cannot be reverted.\n";
        $this->dropForeignKey('fk_invoice_query_status_id__pay_system_status_id', self::INVOICE_QUERY);
        $this->dropForeignKey('fk_invoice_query_order_id__order_id', self::INVOICE_QUERY);
        $this->dropTable(self::INVOICE_QUERY);
        $this->dropTable(self::INVOICE_QUERY_STATUS);
        $this->dropTable(self::PAY_SYSTEM);
        return true;
    }

}
