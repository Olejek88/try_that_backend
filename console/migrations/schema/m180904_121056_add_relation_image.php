<?php

/**
 * Class m180904_121056_add_relation_image
 */
class m180904_121056_add_relation_image extends \console\yii2\Migration
{
    const ACTIVITY_IMAGE = '{{%activity_image}}';
    const ACTIVITY = '{{%activity}}';
    const IMAGE = '{{%image}}';
    const USER = '{{%user}}';
    const USER_IMAGE = '{{%user_image}}';
    const FK_USER2IMAGE = 'fk_user_image_id__image_id';
    const FK_USER_IMAGE2IMAGE = 'fk_user_image_image_id__image_id';
    const FK_USER_IMAGE2USER = 'fk_user_image_user_id__user_id';
    const FK_USER2USER_IMAGE = 'fk_user_user_image_id__user_image_id';
    const FK_ACTIVITY_IMAGE2IMAGE = 'fk_activity_image_image_id__image_id';
    const FK_ACTIVITY_IMAGE2USER_IMAGE = 'fk_activity_image_user_image_id__user_image_id';

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->dropForeignKey(self::FK_USER2IMAGE, self::USER);
        $this->dropColumn(self::USER, 'image_id');
        $this->createTable(self::USER_IMAGE, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'image_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey(
            self::FK_USER_IMAGE2USER,
            self::USER_IMAGE,
            'user_id',
            self::USER,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE
        );
        $this->addForeignKey(
            self::FK_USER_IMAGE2IMAGE,
            self::USER_IMAGE,
            'image_id',
            self::IMAGE,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE
        );
        $this->addColumn(self::USER, 'user_image_id', $this->integer()->Null());
        $this->addForeignKey(
            self::FK_USER2USER_IMAGE,
            self::USER,
            'user_image_id',
            self::USER_IMAGE,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE
        );

        $this->dropForeignKey(self::FK_ACTIVITY_IMAGE2IMAGE, self::ACTIVITY_IMAGE);
        $this->renameColumn(self::ACTIVITY_IMAGE, 'image_id', 'user_image_id');
        $this->addForeignKey(
            self::FK_ACTIVITY_IMAGE2USER_IMAGE,
            self::ACTIVITY_IMAGE,
            'user_image_id',
            self::USER_IMAGE,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m180904_121056_add_relation_image cannot be reverted.\n";

        $this->dropForeignKey(self::FK_ACTIVITY_IMAGE2USER_IMAGE, self::ACTIVITY_IMAGE);
        $this->renameColumn(self::ACTIVITY_IMAGE, 'user_image_id', 'image_id');
        $this->addForeignKey(
            self::FK_ACTIVITY_IMAGE2IMAGE,
            self::ACTIVITY_IMAGE,
            'image_id',
            self::IMAGE,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->dropForeignKey(self::FK_USER2USER_IMAGE, self::USER);
        $this->dropColumn(self::USER, 'user_image_id');
        $this->dropForeignKey(self::FK_USER_IMAGE2IMAGE, self::USER_IMAGE);
        $this->dropForeignKey(self::FK_USER_IMAGE2USER, self::USER_IMAGE);
        $this->dropTable(self::USER_IMAGE);
        $this->addColumn(self::USER, 'image_id', $this->integer());
        $this->addForeignKey(
            self::FK_USER2IMAGE,
            self::USER,
            'image_id',
            self::IMAGE,
            'id',
            self::FK_RESTRICT,
            self::FK_CASCADE
        );

        return true;
    }
}
