<?php

/**
 * Class m181108_134227_change_schema
 */
class m181108_134227_change_schema extends \console\yii2\Migration
{
    const CITY = '{{%city}}';
    const USER = '{{%user}}';

    const FK_USER2LOCATION = 'fk_user_location_id__location_id';
    const FK_USER2CITY = 'fk_user_city_id__city_id';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::CITY, [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
        ]);
        $this->dropForeignKey(self::FK_USER2LOCATION, self::USER);
        $this->dropColumn(self::USER, 'location_id');
        $this->addColumn(self::USER, 'city_id', $this->integer()->notNull());
        $this->addForeignKey(
            self::FK_USER2CITY,
            self::USER,
            'city_id',
            self::CITY,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181108_134227_change_schema cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181108_134227_change_schema cannot be reverted.\n";

        return false;
    }
    */
}
