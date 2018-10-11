<?php

/**
 * Class m180830_073849_add_customer_id_to_order
 */
class m180830_073849_add_customer_id_to_order extends \console\yii2\Migration
{
    const ORDER = '{{%order}}';
    const CUSTOMER = '{{%customer}}';
    const USER = '{{%user}}';
    const FK_ORDER2CUSTOMER = 'fk_order_customer_id__customer_id';
    const FK_CUSTOMER2USER = 'fk_customer_user_id__user_id';

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn(self::ORDER, 'customer_id', $this->integer()->notNull());
        $this->addForeignKey(
            self::FK_ORDER2CUSTOMER,
            self::ORDER,
            'customer_id',
            self::CUSTOMER,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE

        );

        $this->addColumn(self::CUSTOMER, 'user_id', $this->integer()->notNull()->unique());
        $this->addForeignKey(
            self::FK_CUSTOMER2USER,
            self::CUSTOMER,
            'user_id',
            self::USER,
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
        echo "m180830_073849_add_customer_id_to_order cannot be reverted.\n";
        $this->dropForeignKey(self::FK_ORDER2CUSTOMER, self::ORDER);
        $this->dropColumn(self::ORDER, 'customer_id');

        $this->dropForeignKey(self::FK_CUSTOMER2USER, self::CUSTOMER);
        $this->dropColumn(self::CUSTOMER, 'user_id');

        return true;
    }
}
