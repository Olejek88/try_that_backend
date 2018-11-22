<?php

use yii\db\Migration;

/**
 * Class m181121_124552_fix_activity_description
 */
class m181121_124552_fix_activity_description extends Migration
{
    public function up()
    {
        $this->alterColumn(
            '{{%activity}}',
            'description',
            $this->text()->notNull()
        );
    }

    public function down()
    {
        echo "m181121_124552_fix_activity_description cannot be reverted.\n";

        return false;
    }
}
