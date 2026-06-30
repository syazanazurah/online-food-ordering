-- =============================================================================
-- NomNom — Online Food Ordering System
-- Database Schema v1.0
-- Engine: MySQL 8.0+ / MariaDB 10.6+
-- Character set: utf8mb4 (full Unicode incl. emoji)
-- =============================================================================
-- This file is auto-loaded by the docker-compose `db` service on first boot
-- (via the bind mount `./database:/docker-entrypoint-initdb.d:ro`).
--
-- DDL philosophy:
--   - InnoDB engine for ACID + foreign key support (payments must be ACID)
--   - utf8mb4_unicode_ci collation for Malay diacritics & multilingual reviews
--   - DECIMAL(10,2) for all money — never FLOAT/DOUBLE
--   - All tables have created_at; mutable tables have updated_at ON UPDATE
--   - Soft-delete via deleted_at where historical integrity matters
--   - One unique business key per table (slug, email, order_number) for lookups
-- =============================================================================

SET FOREIGN_KEY_CHECKS = 0;
SET NAMES utf8mb4;
SET sql_mode = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION,NO_ZERO_DATE,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO';

-- The compose file already creates the database. If you run this manually:
-- CREATE DATABASE IF NOT EXISTS food_ordering CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE food_ordering;


-- =============================================================================
-- 1. USERS
-- =============================================================================
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id`              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email`           VARCHAR(190) NOT NULL,
  `password_hash`   VARCHAR(255) NOT NULL COMMENT 'PHP password_hash() output (argon2id or bcrypt)',
  `first_name`      VARCHAR(80)  NOT NULL,
  `last_name`       VARCHAR(80)  NOT NULL,
  `phone`           VARCHAR(20)  DEFAULT NULL,
  `role`            ENUM('customer','restaurant_owner','admin') NOT NULL DEFAULT 'customer',
  `email_verified`  TINYINT(1) NOT NULL DEFAULT 0,
  `last_login_at`   TIMESTAMP NULL DEFAULT NULL,
  `created_at`      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at`      TIMESTAMP NULL DEFAULT NULL COMMENT 'Soft delete; preserves order history',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_users_email` (`email`),
  KEY `idx_users_role`  (`role`),
  KEY `idx_users_phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =============================================================================
-- 2. USER_ADDRESSES (1 user → many addresses)
-- =============================================================================
DROP TABLE IF EXISTS `user_addresses`;
CREATE TABLE `user_addresses` (
  `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`        BIGINT UNSIGNED NOT NULL,
  `label`          VARCHAR(40) NOT NULL DEFAULT 'Home' COMMENT 'Home, Office, etc.',
  `address_line1`  VARCHAR(190) NOT NULL,
  `address_line2`  VARCHAR(190) DEFAULT NULL,
  `postal_code`    VARCHAR(10)  NOT NULL,
  `city`           VARCHAR(80)  NOT NULL,
  `latitude`       DECIMAL(10,7) DEFAULT NULL,
  `longitude`      DECIMAL(10,7) DEFAULT NULL,
  `is_default`     TINYINT(1) NOT NULL DEFAULT 0,
  `created_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_addresses_user`    (`user_id`),
  KEY `idx_user_addresses_default` (`user_id`, `is_default`),
  CONSTRAINT `fk_user_addresses_user`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =============================================================================
-- 3. RESTAURANTS
-- =============================================================================
DROP TABLE IF EXISTS `restaurants`;
CREATE TABLE `restaurants` (
  `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `owner_user_id`  BIGINT UNSIGNED NOT NULL,
  `slug`           VARCHAR(120) NOT NULL COMMENT 'URL-friendly: tonys-pizzeria',
  `name`           VARCHAR(190) NOT NULL,
  `description`    TEXT DEFAULT NULL,
  `cuisine_type`   VARCHAR(60)  NOT NULL,
  `phone`          VARCHAR(20)  DEFAULT NULL,
  `address_line1`  VARCHAR(190) NOT NULL,
  `city`           VARCHAR(80)  NOT NULL,
  `postal_code`    VARCHAR(10)  NOT NULL,
  `latitude`       DECIMAL(10,7) DEFAULT NULL,
  `longitude`      DECIMAL(10,7) DEFAULT NULL,
  `delivery_fee`   DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  `prep_time_min`  SMALLINT UNSIGNED NOT NULL DEFAULT 30 COMMENT 'Estimated preparation minutes',
  `image_url`      VARCHAR(255) DEFAULT NULL,
  `rating_avg`     DECIMAL(3,2) NOT NULL DEFAULT 0.00 COMMENT 'Denormalised cache from reviews.rating',
  `rating_count`   INT UNSIGNED NOT NULL DEFAULT 0   COMMENT 'Denormalised cache from COUNT(reviews)',
  `status`         ENUM('active','paused','closed') NOT NULL DEFAULT 'active',
  `created_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_restaurants_slug`     (`slug`),
  KEY `idx_restaurants_owner`         (`owner_user_id`),
  KEY `idx_restaurants_city_status`   (`city`, `status`)             COMMENT 'Listings page filter',
  KEY `idx_restaurants_cuisine`       (`cuisine_type`, `status`)     COMMENT 'Cuisine browse filter',
  KEY `idx_restaurants_rating`        (`status`, `rating_avg` DESC)  COMMENT 'Sort by rating',
  CONSTRAINT `fk_restaurants_owner`
    FOREIGN KEY (`owner_user_id`) REFERENCES `users` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =============================================================================
-- 4. RESTAURANT_HOURS (one row per day-of-week per restaurant)
-- =============================================================================
DROP TABLE IF EXISTS `restaurant_hours`;
CREATE TABLE `restaurant_hours` (
  `id`            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `restaurant_id` BIGINT UNSIGNED NOT NULL,
  `day_of_week`   TINYINT UNSIGNED NOT NULL COMMENT '0=Sunday, 6=Saturday',
  `open_time`     TIME NOT NULL,
  `close_time`    TIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_restaurant_hours_day` (`restaurant_id`, `day_of_week`),
  CONSTRAINT `fk_restaurant_hours_restaurant`
    FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `chk_restaurant_hours_dow` CHECK (`day_of_week` BETWEEN 0 AND 6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =============================================================================
-- 5. MENU_CATEGORIES (Pizzas, Pasta, Sides, Drinks, Desserts...)
-- =============================================================================
DROP TABLE IF EXISTS `menu_categories`;
CREATE TABLE `menu_categories` (
  `id`            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `restaurant_id` BIGINT UNSIGNED NOT NULL,
  `name`          VARCHAR(80) NOT NULL,
  `sort_order`    SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  `created_at`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_menu_categories_restaurant` (`restaurant_id`, `sort_order`),
  CONSTRAINT `fk_menu_categories_restaurant`
    FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =============================================================================
-- 6. MENU_ITEMS
-- =============================================================================
DROP TABLE IF EXISTS `menu_items`;
CREATE TABLE `menu_items` (
  `id`            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `restaurant_id` BIGINT UNSIGNED NOT NULL,
  `category_id`   BIGINT UNSIGNED NOT NULL,
  `name`          VARCHAR(190) NOT NULL,
  `description`   TEXT DEFAULT NULL,
  `price`         DECIMAL(8,2) NOT NULL,
  `image_url`     VARCHAR(255) DEFAULT NULL,
  `is_available`  TINYINT(1) NOT NULL DEFAULT 1 COMMENT '0 = sold out / hidden',
  `sort_order`    SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  `created_at`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_menu_items_restaurant_sort` (`restaurant_id`, `sort_order`)        COMMENT 'Render whole menu in order',
  KEY `idx_menu_items_category_sort`   (`category_id`, `sort_order`)          COMMENT 'Render one section in order',
  KEY `idx_menu_items_search`          (`restaurant_id`, `is_available`, `name`) COMMENT 'Search/filter on menu page',
  CONSTRAINT `fk_menu_items_restaurant`
    FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_menu_items_category`
    FOREIGN KEY (`category_id`) REFERENCES `menu_categories` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `chk_menu_items_price` CHECK (`price` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =============================================================================
-- 7. PROMOTIONS (platform-wide if restaurant_id IS NULL, else restaurant-scoped)
-- =============================================================================
DROP TABLE IF EXISTS `promotions`;
CREATE TABLE `promotions` (
  `id`               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `restaurant_id`    BIGINT UNSIGNED DEFAULT NULL COMMENT 'NULL = platform-wide',
  `code`             VARCHAR(40) NOT NULL,
  `description`      VARCHAR(255) DEFAULT NULL,
  `discount_type`    ENUM('percentage','fixed') NOT NULL,
  `discount_value`   DECIMAL(8,2) NOT NULL COMMENT 'Percentage or RM amount depending on type',
  `min_order_amount` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
  `max_uses`         INT UNSIGNED DEFAULT NULL  COMMENT 'NULL = unlimited',
  `used_count`       INT UNSIGNED NOT NULL DEFAULT 0,
  `starts_at`        DATETIME NOT NULL,
  `ends_at`          DATETIME NOT NULL,
  `is_active`        TINYINT(1) NOT NULL DEFAULT 1,
  `created_at`       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_promotions_code`   (`code`),
  KEY `idx_promotions_restaurant`   (`restaurant_id`),
  KEY `idx_promotions_active_range` (`is_active`, `starts_at`, `ends_at`) COMMENT 'Validation lookup',
  CONSTRAINT `fk_promotions_restaurant`
    FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `chk_promotions_window` CHECK (`ends_at` > `starts_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =============================================================================
-- 8. ORDERS
-- =============================================================================
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id`                    BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_number`          VARCHAR(20)  NOT NULL COMMENT 'Human-readable: NN-2026-04821',
  `user_id`               BIGINT UNSIGNED NOT NULL,
  `restaurant_id`         BIGINT UNSIGNED NOT NULL,
  `delivery_address_id`   BIGINT UNSIGNED DEFAULT NULL COMMENT 'NULL when delivery_method=pickup',
  `promotion_id`          BIGINT UNSIGNED DEFAULT NULL,
  `delivery_method`       ENUM('delivery','pickup') NOT NULL DEFAULT 'delivery',
  `status`                ENUM('pending','confirmed','preparing','on_the_way','delivered','cancelled')
                                       NOT NULL DEFAULT 'pending',
  `subtotal`              DECIMAL(10,2) NOT NULL,
  `delivery_fee`          DECIMAL(8,2)  NOT NULL DEFAULT 0.00,
  `service_charge`        DECIMAL(8,2)  NOT NULL DEFAULT 0.00,
  `discount_amount`       DECIMAL(8,2)  NOT NULL DEFAULT 0.00,
  `total`                 DECIMAL(10,2) NOT NULL,
  `delivery_instructions` TEXT DEFAULT NULL,
  `estimated_ready_at`    DATETIME DEFAULT NULL,
  `delivered_at`          DATETIME DEFAULT NULL,
  `cancelled_at`          DATETIME DEFAULT NULL,
  `cancellation_reason`   VARCHAR(255) DEFAULT NULL,
  `created_at`            TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`            TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_orders_order_number` (`order_number`),
  KEY `idx_orders_user_created`        (`user_id`, `created_at` DESC)        COMMENT 'My orders page',
  KEY `idx_orders_restaurant_status`   (`restaurant_id`, `status`)            COMMENT 'Kitchen dashboard',
  KEY `idx_orders_status_created`      (`status`, `created_at` DESC)          COMMENT 'Admin overview',
  KEY `idx_orders_address`             (`delivery_address_id`),
  KEY `idx_orders_promotion`           (`promotion_id`),
  CONSTRAINT `fk_orders_user`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_orders_restaurant`
    FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_orders_address`
    FOREIGN KEY (`delivery_address_id`) REFERENCES `user_addresses` (`id`)
    ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_orders_promotion`
    FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`)
    ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `chk_orders_total`    CHECK (`total` >= 0),
  CONSTRAINT `chk_orders_subtotal` CHECK (`subtotal` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =============================================================================
-- 9. ORDER_ITEMS (snapshotted line items)
-- =============================================================================
-- Snapshots `name` and `unit_price` so the receipt remains accurate even if the
-- menu item is later edited or deleted by the restaurant.
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id`            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id`      BIGINT UNSIGNED NOT NULL,
  `menu_item_id`  BIGINT UNSIGNED DEFAULT NULL COMMENT 'NULL if menu item is deleted later',
  `item_name`     VARCHAR(190) NOT NULL COMMENT 'Snapshot at order time',
  `unit_price`    DECIMAL(8,2) NOT NULL  COMMENT 'Snapshot at order time',
  `qty`           SMALLINT UNSIGNED NOT NULL,
  `line_total`    DECIMAL(10,2) NOT NULL COMMENT 'unit_price * qty',
  `notes`         VARCHAR(255) DEFAULT NULL COMMENT 'e.g. "no onions"',
  `created_at`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_order_items_order`     (`order_id`),
  KEY `idx_order_items_menu_item` (`menu_item_id`),
  CONSTRAINT `fk_order_items_order`
    FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_order_items_menu_item`
    FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`)
    ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `chk_order_items_qty` CHECK (`qty` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =============================================================================
-- 10. ORDER_STATUS_HISTORY (audit trail of every transition)
-- =============================================================================
DROP TABLE IF EXISTS `order_status_history`;
CREATE TABLE `order_status_history` (
  `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id`   BIGINT UNSIGNED NOT NULL,
  `status`     ENUM('pending','confirmed','preparing','on_the_way','delivered','cancelled') NOT NULL,
  `note`       TEXT DEFAULT NULL,
  `changed_by` BIGINT UNSIGNED DEFAULT NULL COMMENT 'user_id of who triggered the change (nullable for system)',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_order_status_history_order` (`order_id`, `created_at`),
  CONSTRAINT `fk_order_status_history_order`
    FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_order_status_history_user`
    FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =============================================================================
-- 11. PAYMENTS (1:1 with orders)
-- =============================================================================
-- Card details are NEVER stored. We only keep the provider's tokenised
-- reference. PCI scope is the payment provider's, not ours.
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id`                   BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id`             BIGINT UNSIGNED NOT NULL,
  `method`               ENUM('card','fpx','ewallet','cod') NOT NULL,
  `provider`             VARCHAR(40) NOT NULL COMMENT 'stripe|billplz|tng|boost|cod',
  `provider_payment_id`  VARCHAR(190) DEFAULT NULL COMMENT 'External token/charge ID from provider',
  `amount`               DECIMAL(10,2) NOT NULL,
  `currency`             CHAR(3) NOT NULL DEFAULT 'MYR',
  `status`               ENUM('pending','succeeded','failed','refunded') NOT NULL DEFAULT 'pending',
  `failure_reason`       VARCHAR(255) DEFAULT NULL,
  `paid_at`              DATETIME DEFAULT NULL,
  `refunded_at`          DATETIME DEFAULT NULL,
  `created_at`           TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`           TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_payments_order` (`order_id`)              COMMENT 'Strict 1:1 enforcement',
  KEY `idx_payments_provider_id` (`provider`, `provider_payment_id`),
  KEY `idx_payments_status`      (`status`, `created_at`),
  CONSTRAINT `fk_payments_order`
    FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `chk_payments_amount` CHECK (`amount` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =============================================================================
-- 12. REVIEWS (one review per delivered order)
-- =============================================================================
DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id`            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`       BIGINT UNSIGNED NOT NULL,
  `restaurant_id` BIGINT UNSIGNED NOT NULL,
  `order_id`      BIGINT UNSIGNED NOT NULL,
  `rating`        TINYINT UNSIGNED NOT NULL COMMENT '1..5',
  `comment`       TEXT DEFAULT NULL,
  `created_at`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_reviews_order`           (`order_id`)                COMMENT 'One review per order',
  KEY `idx_reviews_restaurant_created`    (`restaurant_id`, `created_at` DESC) COMMENT 'Recent reviews on restaurant page',
  KEY `idx_reviews_user`                  (`user_id`),
  CONSTRAINT `fk_reviews_user`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_reviews_restaurant`
    FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_reviews_order`
    FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `chk_reviews_rating` CHECK (`rating` BETWEEN 1 AND 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =============================================================================
-- TRIGGERS — keep restaurants.rating_avg / rating_count in sync with reviews
-- =============================================================================
-- Approach: maintain the denormalised cache automatically so the application
-- code never has to remember to recompute it. Performance impact: each write
-- to `reviews` causes one UPDATE on `restaurants` — acceptable trade-off for
-- the read speedup on the listings page.
-- =============================================================================
DELIMITER $$

DROP TRIGGER IF EXISTS `trg_reviews_after_insert` $$
CREATE TRIGGER `trg_reviews_after_insert`
AFTER INSERT ON `reviews`
FOR EACH ROW
BEGIN
  UPDATE `restaurants` r
  SET r.rating_avg = (
        SELECT ROUND(AVG(rating), 2)
        FROM `reviews` WHERE restaurant_id = NEW.restaurant_id
      ),
      r.rating_count = (
        SELECT COUNT(*) FROM `reviews` WHERE restaurant_id = NEW.restaurant_id
      )
  WHERE r.id = NEW.restaurant_id;
END $$

DROP TRIGGER IF EXISTS `trg_reviews_after_update` $$
CREATE TRIGGER `trg_reviews_after_update`
AFTER UPDATE ON `reviews`
FOR EACH ROW
BEGIN
  UPDATE `restaurants` r
  SET r.rating_avg = (
        SELECT ROUND(AVG(rating), 2)
        FROM `reviews` WHERE restaurant_id = NEW.restaurant_id
      ),
      r.rating_count = (
        SELECT COUNT(*) FROM `reviews` WHERE restaurant_id = NEW.restaurant_id
      )
  WHERE r.id = NEW.restaurant_id;
END $$

DROP TRIGGER IF EXISTS `trg_reviews_after_delete` $$
CREATE TRIGGER `trg_reviews_after_delete`
AFTER DELETE ON `reviews`
FOR EACH ROW
BEGIN
  UPDATE `restaurants` r
  SET r.rating_avg = COALESCE((
        SELECT ROUND(AVG(rating), 2)
        FROM `reviews` WHERE restaurant_id = OLD.restaurant_id
      ), 0.00),
      r.rating_count = (
        SELECT COUNT(*) FROM `reviews` WHERE restaurant_id = OLD.restaurant_id
      )
  WHERE r.id = OLD.restaurant_id;
END $$

-- ---------------------------------------------------------------------------
-- TRIGGER — auto-record every order status transition into history
-- ---------------------------------------------------------------------------
DROP TRIGGER IF EXISTS `trg_orders_status_history` $$
CREATE TRIGGER `trg_orders_status_history`
AFTER UPDATE ON `orders`
FOR EACH ROW
BEGIN
  IF NEW.status <> OLD.status THEN
    INSERT INTO `order_status_history` (`order_id`, `status`, `note`, `created_at`)
    VALUES (NEW.id, NEW.status, CONCAT('Auto: ', OLD.status, ' → ', NEW.status), NOW());
  END IF;
END $$

DELIMITER ;


SET FOREIGN_KEY_CHECKS = 1;

-- =============================================================================
-- END OF 01-schema.sql
-- =============================================================================
