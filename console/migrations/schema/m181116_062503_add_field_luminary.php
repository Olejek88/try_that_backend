<?php

use \console\yii2\Migration;

/**
 * Class m181116_062503_add_field_luminary
 */
class m181116_062503_add_field_luminary extends Migration
{
    const LUMINARY = '{{%luminary}}';

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
        echo "m181116_062503_add_field_luminary cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181116_062503_add_field_luminary cannot be reverted.\n";

        return false;
    }
    */
}
