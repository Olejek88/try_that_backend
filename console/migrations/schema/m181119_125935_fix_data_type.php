<?php

use yii\db\Migration;

/**
 * Class m181119_125935_fix_data_type
 */
class m181119_125935_fix_data_type extends Migration
{
    public function up()
    {
        $this->alterColumn(
            '{{%location}}',
            'longitude',
            $this->double()->notNull()->defaultValue(0)
        );
        $this->alterColumn(
            '{{%location}}',
            'latitude',
            $this->double()->notNull()->defaultValue(0)
        );
    }

    public function down()
    {
        echo "m181119_125935_fix_data_type cannot be reverted.\n";

        return false;
    }
}
