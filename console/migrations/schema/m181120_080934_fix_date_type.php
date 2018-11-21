<?php

use yii\db\Migration;

/**
 * Class m181120_080934_fix_date_type
 */
class m181120_080934_fix_date_type extends Migration
{
    public function up()
    {
        $this->alterColumn(
            '{{%activity}}',
            'start_date',
            $this->dateTime()->notNull()->defaultValue(date('Y-m-d H:i:s'))
        );
        $this->alterColumn(
            '{{%activity}}',
            'end_date',
            $this->dateTime()->notNull()->defaultValue(date('Y-m-d H:i:s'))
        );

        $this->alterColumn(
            '{{%mail}}',
            'send_date',
            $this->dateTime()->notNull()->defaultValue(date('Y-m-d H:i:s'))
        );
        $this->alterColumn(
            '{{%mail}}',
            'read_date',
            $this->dateTime()->Null()->defaultValue(null)
        );

        $this->alterColumn(
            '{{%news}}',
            'date',
            $this->dateTime()->notNull()->defaultValue(date('Y-m-d H:i:s'))
        );

        $this->alterColumn(
            '{{%exception}}',
            'date',
            $this->string()->notNull()
        );
    }

    public function down()
    {
        echo "m181120_080934_fix_date_type cannot be reverted.\n";

        return false;
    }
}
