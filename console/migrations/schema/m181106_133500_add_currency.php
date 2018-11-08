<?php

use console\yii2\Migration;

/**
 * Class m181106_133500_add_currency
 */
class m181106_133500_add_currency extends Migration
{
    const CURRENCY = '{{%currency}}';
    const ACTIVITY_LISTING = '{{%activity_listing}}';

    public function up()
    {
        $this->createTable(self::CURRENCY, [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
        ]);

        $this->insert(self::CURRENCY, [
            'id' => 1,
            'title' => 'руб',
        ]);

        // связь между предложением и валютой
        $this->addForeignKey(
            'fk_activity_listing_currency_id__currency_id',
            self::ACTIVITY_LISTING,
            'currency_id',
            self::CURRENCY,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );
    }

    public function down()
    {
        echo "m181106_133500_add_currency cannot be reverted.\n";

        return false;
    }
}
