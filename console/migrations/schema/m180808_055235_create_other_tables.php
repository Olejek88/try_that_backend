<?php

use console\yii2\Migration;

/**
 * Class m180808_055235_create_other_tables
 */
class m180808_055235_create_other_tables extends Migration
{
    const LUMINARY = '{{%luminary}}';
    const USER = '{{%user}}';
    const ORDER = '{{%order}}';
    const IMAGE = '{{%image}}';
    const CUSTOMER = '{{%customer}}';
    const ACTIVITY = '{{%activity}}';
    const FOLLOW_LIST = '{{%follow_list}}';
    const MAIL = '{{%mail}}';
    const MAIL_STATUS = '{{%mail_status}}';
    const EXCEPTION = '{{%exception}}';
    const NEWS = '{{%news}}';
    const AVAILABILITY = '{{%availability}}';
    const NEWS_IMAGE = '{{%news_image}}';

    public function up()
    {
        $this->createTable(self::LUMINARY, [
            'id' => $this->primaryKey(),
            // @todo: Реализовать константу для дефолтного значения в модели luminary.
            'verified' => $this->smallInteger()->notNull()->defaultValue(0),
            'verified_date' => $this->dateTime(),
            'rating' => $this->double(),
        ]);

        $this->createTable(self::MAIL, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'order_id' => $this->integer()->notNull(),
            'from_user_id' => $this->integer()->notNull(),
            'to_user_id' => $this->integer()->notNull(),
            'status_id' => $this->integer()->notNull(),
            'activity_id' => $this->integer()->notNull(),
            'send_date' => $this->integer()->notNull(),
            'read_date' => $this->integer()->notNull(),
        ]);

        $this->createTable(self::MAIL_STATUS, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
        ]);

        $this->createTable(self::FOLLOW_LIST, [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
            'luminary_id' => $this->integer()->notNull(),
        ]);

        $this->createTable(self::NEWS, [
            'id' => $this->primaryKey(),
            'luminary_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'date' => $this->integer()->notNull(),
        ]);

        $this->createTable(self::NEWS_IMAGE, [
            'id' => $this->primaryKey(),
            'news_id' => $this->integer()->notNull(),
            'image_id' => $this->integer()->notNull(),
        ]);

        $this->createTable(self::EXCEPTION, [
            'id' => $this->primaryKey(),
            'luminary_id' => $this->integer()->notNull(),
            'date' => $this->dateTime()->notNull()
        ]);

        $this->addForeignKey(
            'fk_mail_from_user_id__user_id',
            self::MAIL,
            'from_user_id',
            self::USER,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_mail_to_user_id__user_id',
            self::MAIL,
            'to_user_id',
            self::USER,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_mail_order_id__order_id',
            self::MAIL,
            'order_id',
            self::ORDER,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_mail_activity_id__activity_id',
            self::MAIL,
            'activity_id',
            self::ACTIVITY,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_mail_mail_status_id__mail_status_id',
            self::MAIL,
            'status_id',
            self::MAIL_STATUS,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_follow_list_customer_id__customer_id',
            self::FOLLOW_LIST,
            'customer_id',
            self::CUSTOMER,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_follow_list_luminary_id__luminary_id',
            self::FOLLOW_LIST,
            'luminary_id',
            self::LUMINARY,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_news_luminary_id__luminary_id',
            self::NEWS,
            'luminary_id',
            self::LUMINARY,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_exception_luminary_id__luminary_id',
            self::EXCEPTION,
            'luminary_id',
            self::LUMINARY,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_news_image_news_id__news_id',
            self::NEWS_IMAGE,
            'news_id',
            self::NEWS,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_news_image_image_id__image_id',
            self::NEWS_IMAGE,
            'image_id',
            self::IMAGE,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_activity_luminary_id__luminary_id',
            self::ACTIVITY,
            'luminary_id',
            self::LUMINARY,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_activity_luminary_id__luminary_id', self::ACTIVITY);
        $this->dropForeignKey('fk_news_image_image_id__image_id', self::NEWS_IMAGE);
        $this->dropForeignKey('fk_news_image_news_id__news_id', self::NEWS_IMAGE);
        $this->dropForeignKey('fk_exception_luminary_id__luminary_id', self::EXCEPTION);
        $this->dropForeignKey('fk_news_luminary_id__luminary_id', self::NEWS);
        $this->dropForeignKey('fk_follow_list_luminary_id__luminary_id', self::FOLLOW_LIST);
        $this->dropForeignKey('fk_follow_list_customer_id__customer_id', self::FOLLOW_LIST);
        $this->dropForeignKey('fk_mail_mail_status_id__mail_status_id', self::MAIL);
        $this->dropForeignKey('fk_mail_activity_id__activity_id', self::MAIL);
        $this->dropForeignKey('fk_mail_order_id__order_id', self::MAIL);
        $this->dropForeignKey('fk_mail_to_user_id__user_id', self::MAIL);
        $this->dropForeignKey('fk_mail_from_user_id__user_id', self::MAIL);
        $this->dropTable(self::EXCEPTION);
        $this->dropTable(self::NEWS_IMAGE);
        $this->dropTable(self::NEWS);
        $this->dropTable(self::FOLLOW_LIST);
        $this->dropTable(self::MAIL_STATUS);
        $this->dropTable(self::MAIL);
        $this->dropTable(self::LUMINARY);
    }
}
