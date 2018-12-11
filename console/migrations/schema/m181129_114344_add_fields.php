<?php

use yii\db\Migration;

/**
 * Class m181129_114344_add_fields
 */
class m181129_114344_add_fields extends Migration
{
    const REVIEW = '{{%review}}';
    const DURATION = '{{%duration}}';
    const LUMINARY = '{{%luminary}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::REVIEW, 'date',$this->dateTime()->notNull()->defaultValue(date('Y-m-d H:i:s')));
        $this->addColumn(self::DURATION, 'seconds', $this->integer()->defaultValue(0));
        $this->addColumn(self::LUMINARY, 'total', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181129_114344_add_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181129_114344_add_fields cannot be reverted.\n";

        return false;
    }
    */
}
