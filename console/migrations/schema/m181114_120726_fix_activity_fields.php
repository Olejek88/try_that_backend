<?php

use \console\yii2\Migration;

/**
 * Class m181114_120726_fix_activity_fields
 */
class m181114_120726_fix_activity_fields extends Migration
{
    const ACTIVITY = '{{%activity}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn(self::ACTIVITY, 'start_date');
        $this->dropColumn(self::ACTIVITY, 'end_date');
        $this->addColumn(self::ACTIVITY, 'start_date', $this->dateTime()->null());
        $this->addColumn(self::ACTIVITY, 'end_date', $this->dateTime()->null());
        $this->alterColumn(self::ACTIVITY, 'description',$this->text()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181114_120726_fix_activity_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181114_120726_fix_activity_fields cannot be reverted.\n";

        return false;
    }
    */
}
