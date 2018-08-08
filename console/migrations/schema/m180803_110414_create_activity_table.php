<?php

use console\yii2\Migration;

/**
 * Class m180803_110414_create_activity_table
 */
class m180803_110414_create_activity_table extends Migration
{
    const LOCATION = '{{%location}}';
    const COUNTRY = '{{%country}}';
    const ACTIVITY = '{{%activity}}';
    const ACTIVITY_IMAGE = '{{%activity_image}}';
    const ACTIVITY_LISTING = '{{%activity_listing}}';
    const CATEGORY = '{{%category}}';
    const ACTIVITY_CATEGORY = '{{%activity_category}}';
    const TRENDING = '{{%trending}}';
    const OCCASION = '{{%occasion}}';
    const TAG = '{{%tag}}';
    const IMAGE = '{{%image}}';
    const WISHLIST = '{{%wishlist}}';
    const DURATION = '{{%duration}}';
    const REVIEW = '{{%review}}';
    const ORDER = '{{%order}}';
    const ORDER_STATUS = '{{%order_status}}';
    const GROUP_EXPERIENCE = '{{%group_experience}}';
    const CUSTOMER = '{{%customer}}';

    public function up()
    {
        /**
         * For user and different entities.
         */

        $this->createTable(self::LOCATION, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'latitude' => $this->integer()->notNull()->defaultValue(0),
            'longitude' => $this->integer()->notNull()->defaultValue(0),
            'image_id' => $this->integer(),
        ]);

        $this->createTable(self::COUNTRY, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'image_id' => $this->integer(),
        ]);

        /**
         * For activity (services).
         */

        $this->createTable(self::CATEGORY, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'image_id' => $this->integer(),
        ]);

        $this->createTable(self::ACTIVITY_CATEGORY, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'image_id' => $this->integer(),
        ]);

        $this->createTable(self::TRENDING, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'activity_id' => $this->integer()->notNull(),
            'image_id' => $this->integer(),
        ]);

        $this->createTable(self::OCCASION, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'activity_id' => $this->integer()->notNull(),
            'image_id' => $this->integer(),
        ]);

        $this->createTable(self::TAG, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'activity_id' => $this->integer()->notNull()
        ]);

        $this->createTable(self::IMAGE, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'path' => $this->string()
        ]);

        $this->createTable(self::ACTIVITY_IMAGE, [
            'id' => $this->primaryKey(),
            'activity_id' => $this->integer()->notNull(),
            'image_id' => $this->integer()->notNull(),
        ]);

        $this->createTable(self::WISHLIST, [
            'id' => $this->primaryKey(),
            'activity_id' => $this->integer()->notNull(),
            'customer_id' => $this->integer()->notNull(),
            'date' => $this->dateTime(),
        ]);

        // @todo: Сабж. (begin_date, end_date?)
        $this->createTable(self::DURATION, [
            'id' => $this->primaryKey(),
            'date' => $this->dateTime(),
        ]);

        $this->createTable(self::REVIEW, [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
            'activity_id' => $this->integer()->notNull(),
            'description' => $this->string(),
            'rate' => $this->integer(),
        ]);

        $this->createTable(self::GROUP_EXPERIENCE, [
            'id' => $this->primaryKey(),
            'activity_listing_id' => $this->integer()->notNull(),
            'customer_id' => $this->integer()->notNull(),
        ]);

        $this->createTable(self::ORDER, [
            'id' => $this->primaryKey(),
            'activity_listing_id' => $this->integer()->notNull(),
            'order_status_id' => $this->integer()->notNull(),
            'duration_id' => $this->integer()->notNull(),
            'start_date' => $this->dateTime(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);

        $this->createTable(self::ORDER_STATUS, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()
        ]);

        $this->createTable(self::ACTIVITY, [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->string(),
            'luminary_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'activity_category_id' => $this->integer()->notNull(),
            'duration_id' => $this->integer(),
            'min_customers' => $this->integer(),
            'max_customers' => $this->integer(),
            // @todo: Сабж.
            'start_date' => $this->integer()->notNull(),
            'end_date' => $this->integer()->notNull(),
        ]);

        $this->createTable(self::CUSTOMER, [
            'id' => $this->primaryKey(),
            // @todo: Сабж.
            'positive' => $this->integer()->notNull()->defaultValue(0),
            'negative' => $this->integer()->notNull()->defaultValue(0),
            'active' => $this->smallInteger()->notNull()->defaultValue(0),
        ]);

        $this->createTable(self::ACTIVITY_LISTING, [
            'id' => $this->primaryKey(),
            'activity_id' => $this->integer()->notNull(),
            'duration_id' => $this->integer()->notNull(),
            // @todo: Добавить связь!
            'currency_id' => $this->integer()->notNull(),
            'cost' => $this->double(),
            // @todo: Реализовать константу для дефолтного значения в модели activity_listing.
            'is_group' => $this->smallInteger()->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'fk_location_image_id__image_id',
            self::LOCATION,
            'image_id',
            self::IMAGE,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_country_image_id__image_id',
            self::COUNTRY,
            'image_id',
            self::IMAGE,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_category_image_id__image_id',
            self::CATEGORY,
            'image_id',
            self::IMAGE,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_activity_category_image_id__image_id',
            self::ACTIVITY_CATEGORY,
            'image_id',
            self::IMAGE,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_trending_activity_id__activity_id',
            self::TRENDING,
            'activity_id',
            self::ACTIVITY,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_trending_image_id__image_id',
            self::TRENDING,
            'image_id',
            self::IMAGE,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_occasion_activity_id__activity_id',
            self::OCCASION,
            'activity_id',
            self::ACTIVITY,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_occasion_image_id__image_id',
            self::OCCASION,
            'image_id',
            self::IMAGE,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_tag_category_id__category_id',
            self::TAG,
            'category_id',
            self::CATEGORY,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_tag_activity_id__activity_id',
            self::TAG,
            'activity_id',
            self::ACTIVITY,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_activity_image_activity_id__activity_id',
            self::ACTIVITY_IMAGE,
            'activity_id',
            self::ACTIVITY,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_activity_image_image_id__image_id',
            self::ACTIVITY_IMAGE,
            'image_id',
            self::IMAGE,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_wishlist_activity_id__activity_id',
            self::WISHLIST,
            'activity_id',
            self::ACTIVITY,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_wishlist_customer_id__customer_id',
            self::WISHLIST,
            'customer_id',
            self::CUSTOMER,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_review_activity_id__activity_id',
            self::REVIEW,
            'activity_id',
            self::ACTIVITY,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_review_customer_id__customer_id',
            self::REVIEW,
            'customer_id',
            self::CUSTOMER,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_group_experience_activity_listing_id__activity_listing_id',
            self::GROUP_EXPERIENCE,
            'activity_listing_id',
            self::ACTIVITY_LISTING,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_group_experience_customer_id__customer_id',
            self::GROUP_EXPERIENCE,
            'customer_id',
            self::CUSTOMER,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_order_activity_listing_id__activity_listing_id',
            self::ORDER,
            'activity_listing_id',
            self::ACTIVITY_LISTING,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_order_order_status_id__order_status_id',
            self::ORDER,
            'order_status_id',
            self::ORDER_STATUS,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_order_duration_id__duration_id',
            self::ORDER,
            'duration_id',
            self::DURATION,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_activity_category_id__category_id',
            self::ACTIVITY,
            'category_id',
            self::CATEGORY,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_activity_activity_category_id__activity_category_id',
            self::ACTIVITY,
            'activity_category_id',
            self::ACTIVITY_CATEGORY,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_activity_duration_id__duration_id',
            self::ACTIVITY,
            'duration_id',
            self::DURATION,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_activity_listing_activity_id__activity_id',
            self::ACTIVITY_LISTING,
            'activity_id',
            self::ACTIVITY,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );

        $this->addForeignKey(
            'fk_activity_listing_duration_id__duration_id',
            self::ACTIVITY_LISTING,
            'duration_id',
            self::DURATION,
            'id',
            self::FK_CASCADE,
            self::FK_CASCADE
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_activity_listing_duration_id__duration_id', self::ACTIVITY_LISTING);
        $this->dropForeignKey('fk_activity_listing_activity_id__activity_id', self::ACTIVITY_LISTING);
        $this->dropForeignKey('fk_activity_duration_id__duration_id', self::ACTIVITY);
        $this->dropForeignKey('fk_activity_activity_category_id__activity_category_id', self::ACTIVITY);
        $this->dropForeignKey('fk_activity_category_id__category_id', self::ACTIVITY);
        $this->dropForeignKey('fk_order_duration_id__duration_id', self::ORDER);
        $this->dropForeignKey('fk_order_order_status_id__order_status_id', self::ORDER);
        $this->dropForeignKey('fk_order_activity_listing_id__activity_listing_id', self::ORDER);
        $this->dropForeignKey('fk_group_experience_customer_id__customer_id', self::GROUP_EXPERIENCE);
        $this->dropForeignKey('fk_group_experience_activity_listing_id__activity_listing_id', self::GROUP_EXPERIENCE);
        $this->dropForeignKey('fk_review_customer_id__customer_id', self::REVIEW);
        $this->dropForeignKey('fk_review_activity_id__activity_id', self::REVIEW);
        $this->dropForeignKey('fk_wishlist_customer_id__customer_id', self::WISHLIST);
        $this->dropForeignKey('fk_wishlist_activity_id__activity_id', self::WISHLIST);
        $this->dropForeignKey('fk_activity_image_image_id__image_id', self::ACTIVITY_IMAGE);
        $this->dropForeignKey('fk_activity_image_activity_id__activity_id', self::ACTIVITY_IMAGE);
        $this->dropForeignKey('fk_tag_activity_id__activity_id', self::TAG);
        $this->dropForeignKey('fk_tag_category_id__category_id', self::TAG);
        $this->dropForeignKey('fk_occasion_image_id__image_id', self::OCCASION);
        $this->dropForeignKey('fk_occasion_activity_id__activity_id', self::OCCASION);
        $this->dropForeignKey('fk_trending_image_id__image_id', self::TRENDING);
        $this->dropForeignKey('fk_trending_activity_id__activity_id', self::TRENDING);
        $this->dropForeignKey('fk_activity_category_image_id__image_id', self::ACTIVITY_CATEGORY);
        $this->dropForeignKey('fk_category_image_id__image_id', self::CATEGORY);
        $this->dropForeignKey('fk_country_image_id__image_id', self::COUNTRY);
        $this->dropForeignKey('fk_location_image_id__image_id', self::LOCATION);
        $this->dropTable(self::ACTIVITY_LISTING);
        $this->dropTable(self::CUSTOMER);
        $this->dropTable(self::ACTIVITY);
        $this->dropTable(self::ORDER_STATUS);
        $this->dropTable(self::ORDER);
        $this->dropTable(self::GROUP_EXPERIENCE);
        $this->dropTable(self::REVIEW);
        $this->dropTable(self::DURATION);
        $this->dropTable(self::WISHLIST);
        $this->dropTable(self::ACTIVITY_IMAGE);
        $this->dropTable(self::IMAGE);
        $this->dropTable(self::TAG);
        $this->dropTable(self::OCCASION);
        $this->dropTable(self::TRENDING);
        $this->dropTable(self::ACTIVITY_CATEGORY);
        $this->dropTable(self::CATEGORY);
        $this->dropTable(self::COUNTRY);
        $this->dropTable(self::LOCATION);
    }
}
