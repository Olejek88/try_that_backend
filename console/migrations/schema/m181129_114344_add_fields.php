<?php

use yii\db\Migration;

/**
 * Class m181129_114344_add_fields
 */
class m181129_114344_add_fields extends Migration
{
    const MAIL = '{{%mail}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::LUMINARY, 'shortDescription', $this->text());
        $this->addColumn(self::LUMINARY, 'description', $this->text());

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
