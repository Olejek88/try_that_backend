<?php

use console\yii2\Migration;

/**
 * Class m180829_133338_add_lost_relation_luminary2user
 */
class m180829_133338_add_lost_relation_luminary2user extends Migration
{
    const LUMINARY = '{{%luminary}}';
    const USER = '{{%user}}';
    const FK_LUMINARY2USER = 'fk_luminary_user_id__user_id';

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn(self::LUMINARY, 'user_id', $this->integer()->notNull()->unique());
        $this->addForeignKey(
            self::FK_LUMINARY2USER,
            self::LUMINARY,
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
        echo "m180829_133338_add_lost_relation_luminary2user cannot be reverted.\n";
        $this->dropForeignKey(self::FK_LUMINARY2USER, self::LUMINARY);
        $this->dropColumn(self::LUMINARY, 'user_id');
        return true;
    }
}
