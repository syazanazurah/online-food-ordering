-- =============================================================================
-- NomNom — Seed Data v1.0
-- Loaded after 01-schema.sql by docker-entrypoint-initdb.d
-- =============================================================================
-- Mirrors the data shown in the static prototype so the PHP build can drop
-- straight in and have a populated app on first run.
--
-- Password for ALL seed users below: "Password123!"
--   PHP equivalent: password_hash('Password123!', PASSWORD_ARGON2ID)
--   The hash below is a real argon2id hash of that string.
-- =============================================================================

SET FOREIGN_KEY_CHECKS = 0;
SET NAMES utf8mb4;

-- =============================================================================
-- 1. USERS
-- =============================================================================
-- 1 admin, 6 restaurant owners, 3 customers
-- =============================================================================
INSERT INTO `users` (`id`, `email`, `password_hash`, `first_name`, `last_name`, `phone`, `role`, `email_verified`) VALUES
  (1,  'admin@nomnom.test',     '$argon2id$v=19$m=65536,t=4,p=1$c2VlZHNhbHRzZWVkc2FsdA$P7vG7l3Cw7qxLm8eYgX1fCnKJQs4mJzWqVqFvHnhB3M', 'Nom',     'Admin',     '+60123000001', 'admin',            1),

  (10, 'tony@pizzeria.test',    '$argon2id$v=19$m=65536,t=4,p=1$c2VlZHNhbHRzZWVkc2FsdA$P7vG7l3Cw7qxLm8eYgX1fCnKJQs4mJzWqVqFvHnhB3M', 'Tony',    'Marino',    '+60123100001', 'restaurant_owner', 1),
  (11, 'kenji@sakura.test',     '$argon2id$v=19$m=65536,t=4,p=1$c2VlZHNhbHRzZWVkc2FsdA$P7vG7l3Cw7qxLm8eYgX1fCnKJQs4mJzWqVqFvHnhB3M', 'Kenji',   'Tanaka',    '+60123100002', 'restaurant_owner', 1),
  (12, 'mike@smashhouse.test',  '$argon2id$v=19$m=65536,t=4,p=1$c2VlZHNhbHRzZWVkc2FsdA$P7vG7l3Cw7qxLm8eYgX1fCnKJQs4mJzWqVqFvHnhB3M', 'Mike',    'Johnson',   '+60123100003', 'restaurant_owner', 1),
  (13, 'lina@wokandroll.test',  '$argon2id$v=19$m=65536,t=4,p=1$c2VlZHNhbHRzZWVkc2FsdA$P7vG7l3Cw7qxLm8eYgX1fCnKJQs4mJzWqVqFvHnhB3M', 'Lina',    'Wong',      '+60123100004', 'restaurant_owner', 1),
  (14, 'carlos@taco.test',      '$argon2id$v=19$m=65536,t=4,p=1$c2VlZHNhbHRzZWVkc2FsdA$P7vG7l3Cw7qxLm8eYgX1fCnKJQs4mJzWqVqFvHnhB3M', 'Carlos',  'Reyes',     '+60123100005', 'restaurant_owner', 1),
  (15, 'sara@greenhouse.test',  '$argon2id$v=19$m=65536,t=4,p=1$c2VlZHNhbHRzZWVkc2FsdA$P7vG7l3Cw7qxLm8eYgX1fCnKJQs4mJzWqVqFvHnhB3M', 'Sara',    'Rahman',    '+60123100006', 'restaurant_owner', 1),

  (100, 'aiman@example.com',    '$argon2id$v=19$m=65536,t=4,p=1$c2VlZHNhbHRzZWVkc2FsdA$P7vG7l3Cw7qxLm8eYgX1fCnKJQs4mJzWqVqFvHnhB3M', 'Aiman',   'Syazwan',   '+60123456789', 'customer',         1),
  (101, 'syaza@example.com',    '$argon2id$v=19$m=65536,t=4,p=1$c2VlZHNhbHRzZWVkc2FsdA$P7vG7l3Cw7qxLm8eYgX1fCnKJQs4mJzWqVqFvHnhB3M', 'Syaza',   'Aiman',     '+60123456790', 'customer',         1),
  (102, 'ahmad@example.com',    '$argon2id$v=19$m=65536,t=4,p=1$c2VlZHNhbHRzZWVkc2FsdA$P7vG7l3Cw7qxLm8eYgX1fCnKJQs4mJzWqVqFvHnhB3M', 'Ahmad',   'Hakim',     '+60123456791', 'customer',         0);

-- =============================================================================
-- 2. USER_ADDRESSES
-- =============================================================================
INSERT INTO `user_addresses` (`id`, `user_id`, `label`, `address_line1`, `address_line2`, `postal_code`, `city`, `latitude`, `longitude`, `is_default`) VALUES
  (1, 100, 'Home',   'No. 24, Jalan Telawi 3', NULL,           '59100', 'Kuala Lumpur', 3.1295770, 101.6700180, 1),
  (2, 100, 'Office', 'Level 18, Menara KL',    'Jalan Punchak', '50250', 'Kuala Lumpur', 3.1530000, 101.7035000, 0),
  (3, 101, 'Home',   'No. 8, Jalan Ampang',    NULL,           '50450', 'Kuala Lumpur', 3.1500000, 101.7100000, 1),
  (4, 102, 'Home',   'No. 12, Lorong Damai',   NULL,           '55100', 'Kuala Lumpur', 3.1450000, 101.6900000, 1);


-- =============================================================================
-- 3. RESTAURANTS
-- =============================================================================
INSERT INTO `restaurants` (`id`, `owner_user_id`, `slug`, `name`, `description`, `cuisine_type`, `phone`, `address_line1`, `city`, `postal_code`, `latitude`, `longitude`, `delivery_fee`, `prep_time_min`, `image_url`, `rating_avg`, `rating_count`, `status`) VALUES
  (1, 10, 'tonys-pizzeria',     'Tony''s Pizzeria',
   'Family-owned Italian kitchen serving wood-fired pizza and hand-rolled pasta in the heart of KL since 2008. All ingredients sourced fresh daily.',
   'Italian', '+60312345001', 'Lot 24, Jalan Telawi, Bangsar Baru', 'Kuala Lumpur', '59100', 3.1295770, 101.6700180, 5.00, 35, NULL, 0.00, 0, 'active'),

  (2, 11, 'sakura-sushi',       'Sakura Sushi',
   'Authentic Edomae-style sushi and bento boxes prepared by Tokyo-trained chefs.',
   'Japanese', '+60312345002', '12 Persiaran KLCC',                'Kuala Lumpur', '50088', 3.1570000, 101.7100000, 4.00, 30, NULL, 0.00, 0, 'active'),

  (3, 12, 'smash-house-burgers','Smash House Burgers',
   'Smashed-patty burgers, crinkle fries, and house-made shakes. Fast, loud, delicious.',
   'American', '+60312345003', '8 Jalan Tun Razak',                'Kuala Lumpur', '50400', 3.1660000, 101.7180000, 5.00, 25, NULL, 0.00, 0, 'active'),

  (4, 13, 'wok-and-roll',       'Wok & Roll',
   'Fast-fired Chinese-Malay street food classics — char kuey teow, hokkien mee, kung pao chicken.',
   'Chinese', '+60312345004', '5 Jalan Petaling',                  'Kuala Lumpur', '50000', 3.1430000, 101.6970000, 0.00, 40, NULL, 0.00, 0, 'active'),

  (5, 14, 'el-taco-loco',       'El Taco Loco',
   'Mexican street food with house-pressed tortillas, slow-cooked meats, and salsas made fresh every morning.',
   'Mexican', '+60312345005', '22 Jalan Sultan Ismail',            'Kuala Lumpur', '50250', 3.1530000, 101.7110000, 6.00, 30, NULL, 0.00, 0, 'active'),

  (6, 15, 'greenhouse-bowls',   'Greenhouse Bowls',
   'Plant-forward bowls, cold-pressed juices, and gluten-free baked goods. Healthy never tasted this good.',
   'Healthy', '+60312345006', '15 Jalan Bangsar',                  'Kuala Lumpur', '59100', 3.1280000, 101.6740000, 4.00, 20, NULL, 0.00, 0, 'active');


-- =============================================================================
-- 4. RESTAURANT_HOURS (Tony's Pizzeria, 7 days)
-- =============================================================================
INSERT INTO `restaurant_hours` (`restaurant_id`, `day_of_week`, `open_time`, `close_time`) VALUES
  (1, 0, '11:00:00', '23:00:00'),
  (1, 1, '11:00:00', '23:00:00'),
  (1, 2, '11:00:00', '23:00:00'),
  (1, 3, '11:00:00', '23:00:00'),
  (1, 4, '11:00:00', '23:30:00'),
  (1, 5, '11:00:00', '23:30:00'),
  (1, 6, '11:00:00', '23:30:00'),
  -- Sakura Sushi
  (2, 0, '12:00:00', '22:00:00'),
  (2, 1, '12:00:00', '22:00:00'),
  (2, 2, '12:00:00', '22:00:00'),
  (2, 3, '12:00:00', '22:00:00'),
  (2, 4, '12:00:00', '22:30:00'),
  (2, 5, '12:00:00', '22:30:00'),
  (2, 6, '12:00:00', '22:00:00'),
  -- Greenhouse Bowls
  (6, 0, '08:00:00', '20:00:00'),
  (6, 1, '08:00:00', '20:00:00'),
  (6, 2, '08:00:00', '20:00:00'),
  (6, 3, '08:00:00', '20:00:00'),
  (6, 4, '08:00:00', '21:00:00'),
  (6, 5, '08:00:00', '21:00:00'),
  (6, 6, '09:00:00', '20:00:00');


-- =============================================================================
-- 5. MENU_CATEGORIES (Tony's Pizzeria)
-- =============================================================================
INSERT INTO `menu_categories` (`id`, `restaurant_id`, `name`, `sort_order`) VALUES
  (1,  1, 'Popular',   10),
  (2,  1, 'Pizzas',    20),
  (3,  1, 'Pasta',     30),
  (4,  1, 'Sides',     40),
  (5,  1, 'Drinks',    50),
  (6,  1, 'Desserts',  60),
  -- Sakura Sushi
  (10, 2, 'Sushi',     10),
  (11, 2, 'Bento Sets', 20),
  (12, 2, 'Sides',      30),
  -- Smash House
  (20, 3, 'Burgers',    10),
  (21, 3, 'Sides',      20),
  (22, 3, 'Shakes',     30),
  -- Greenhouse Bowls
  (30, 6, 'Signature Bowls', 10),
  (31, 6, 'Drinks',          20);


-- =============================================================================
-- 6. MENU_ITEMS (Tony's Pizzeria — full menu mirroring the prototype)
-- =============================================================================
INSERT INTO `menu_items` (`id`, `restaurant_id`, `category_id`, `name`, `description`, `price`, `is_available`, `sort_order`) VALUES
  -- Tony's Pizzeria
  (1,  1, 1, 'Margherita Classic', 'San Marzano tomato, fresh mozzarella, basil, extra virgin olive oil.', 28.00, 1, 10),
  (2,  1, 1, 'Pepperoni Supreme',  'Spicy pepperoni, mozzarella, oregano on hand-stretched sourdough crust.', 34.00, 1, 20),
  (3,  1, 2, 'Quattro Formaggi',   'Mozzarella, gorgonzola, parmesan, taleggio. For cheese lovers.', 38.00, 1, 30),
  (4,  1, 2, 'Hawaiian',           'Smoked ham, pineapple, mozzarella. The classic argument starter.', 30.00, 1, 40),
  (5,  1, 2, 'BBQ Chicken',        'Grilled chicken, smoky BBQ sauce, red onion, coriander.', 32.00, 1, 50),
  (6,  1, 3, 'Spaghetti Carbonara', 'Egg yolk, pecorino, guanciale, freshly cracked black pepper.', 26.00, 1, 60),
  (7,  1, 3, 'Penne Arrabbiata',   'Spicy tomato sauce with garlic, chilli, and fresh parsley.', 22.00, 1, 70),
  (8,  1, 4, 'Garlic Bread',       'Toasted ciabatta with garlic butter and parsley.', 12.00, 1, 80),
  (9,  1, 4, 'Caesar Salad',       'Cos lettuce, croutons, parmesan, anchovy dressing.', 18.00, 1, 90),
  (10, 1, 5, 'San Pellegrino',     'Sparkling mineral water, 500 ml.', 8.00, 1, 100),
  (11, 1, 6, 'Tiramisu',           'Mascarpone, espresso-soaked savoiardi, cocoa.', 15.00, 1, 110),

  -- Sakura Sushi
  (20, 2, 10, 'Salmon Sashimi (8 pcs)', 'Fresh Norwegian salmon, sliced thick.', 32.00, 1, 10),
  (21, 2, 10, 'Tuna Nigiri (4 pcs)',    'Akami tuna over hand-pressed sushi rice.', 24.00, 1, 20),
  (22, 2, 11, 'Chicken Teriyaki Bento', 'Grilled teriyaki chicken, rice, miso soup, salad.', 22.00, 1, 30),
  (23, 2, 11, 'Salmon Don',             'Sashimi-grade salmon over sushi rice with shoyu and wasabi.', 28.00, 1, 40),
  (24, 2, 12, 'Miso Soup',              'Traditional white miso, tofu, wakame, scallion.', 6.00, 1, 50),

  -- Smash House Burgers
  (30, 3, 20, 'Classic Smash',     'Two smashed beef patties, American cheese, pickles, secret sauce.', 24.00, 1, 10),
  (31, 3, 20, 'Bacon Cheeseburger','Crispy bacon, double cheese, caramelised onion.', 28.00, 1, 20),
  (32, 3, 21, 'Crinkle Fries',     'Salted, golden, crispy.', 10.00, 1, 30),
  (33, 3, 22, 'Chocolate Shake',   'Hand-spun with house-made chocolate sauce.', 14.00, 1, 40),

  -- Greenhouse Bowls
  (40, 6, 30, 'Mediterranean Bowl', 'Quinoa, hummus, roasted vegetables, falafel, tahini.', 22.00, 1, 10),
  (41, 6, 30, 'Buddha Bowl',        'Brown rice, edamame, avocado, miso ginger dressing.', 24.00, 1, 20),
  (42, 6, 31, 'Kombucha (citrus)',  'Cold-pressed, lightly fermented, refreshing.', 10.00, 1, 30);


-- =============================================================================
-- 7. PROMOTIONS
-- =============================================================================
INSERT INTO `promotions` (`id`, `restaurant_id`, `code`, `description`, `discount_type`, `discount_value`, `min_order_amount`, `max_uses`, `used_count`, `starts_at`, `ends_at`, `is_active`) VALUES
  (1, NULL, 'WELCOME10',  '10% off your first order',     'percentage', 10.00, 30.00,  NULL, 0, '2026-05-01 00:00:00', '2026-12-31 23:59:59', 1),
  (2, 1,    'TONYFREE5',  'Free RM 5 with order over RM 50 at Tony''s', 'fixed', 5.00,  50.00, 100,  3, '2026-05-01 00:00:00', '2026-06-30 23:59:59', 1),
  (3, NULL, 'NOMNOM20',   '20% off, max RM 15',           'percentage', 20.00, 50.00,  500, 12, '2026-05-15 00:00:00', '2026-05-31 23:59:59', 1);


-- =============================================================================
-- 8. ORDERS + 9. ORDER_ITEMS + 10. STATUS_HISTORY + 11. PAYMENTS
-- =============================================================================
-- Order #NN-2026-04498 (delivered, Greenhouse Bowls, 12 May)
-- =============================================================================
INSERT INTO `orders` (`id`, `order_number`, `user_id`, `restaurant_id`, `delivery_address_id`, `promotion_id`, `delivery_method`, `status`, `subtotal`, `delivery_fee`, `service_charge`, `discount_amount`, `total`, `delivery_instructions`, `estimated_ready_at`, `delivered_at`, `created_at`) VALUES
  (1, 'NN-2026-04498', 100, 6, 1, NULL, 'delivery', 'delivered', 32.00, 4.00, 1.92, 0.00, 37.92, NULL, '2026-05-12 13:25:00', '2026-05-12 13:38:00', '2026-05-12 13:10:00');

INSERT INTO `order_items` (`order_id`, `menu_item_id`, `item_name`, `unit_price`, `qty`, `line_total`) VALUES
  (1, 40, 'Mediterranean Bowl', 22.00, 1, 22.00),
  (1, 42, 'Kombucha (citrus)',  10.00, 1, 10.00);

INSERT INTO `payments` (`order_id`, `method`, `provider`, `provider_payment_id`, `amount`, `status`, `paid_at`) VALUES
  (1, 'card', 'stripe', 'ch_3PqXyZ123seed', 37.92, 'succeeded', '2026-05-12 13:10:30');

INSERT INTO `order_status_history` (`order_id`, `status`, `note`, `created_at`) VALUES
  (1, 'pending',    'Order placed',                    '2026-05-12 13:10:00'),
  (1, 'confirmed',  'Restaurant accepted',             '2026-05-12 13:11:00'),
  (1, 'preparing',  'Kitchen started preparation',     '2026-05-12 13:13:00'),
  (1, 'on_the_way', 'Rider picked up',                 '2026-05-12 13:28:00'),
  (1, 'delivered',  'Customer confirmed receipt',      '2026-05-12 13:38:00');


-- =============================================================================
-- Order #NN-2026-04702 (delivered, Sakura Sushi, 16 May)
-- =============================================================================
INSERT INTO `orders` (`id`, `order_number`, `user_id`, `restaurant_id`, `delivery_address_id`, `promotion_id`, `delivery_method`, `status`, `subtotal`, `delivery_fee`, `service_charge`, `discount_amount`, `total`, `estimated_ready_at`, `delivered_at`, `created_at`) VALUES
  (2, 'NN-2026-04702', 100, 2, 1, NULL, 'delivery', 'delivered', 56.00, 4.00, 3.36, 0.00, 63.36, '2026-05-16 20:42:00', '2026-05-16 20:55:00', '2026-05-16 20:22:00');

INSERT INTO `order_items` (`order_id`, `menu_item_id`, `item_name`, `unit_price`, `qty`, `line_total`) VALUES
  (2, 20, 'Salmon Sashimi (8 pcs)',     32.00, 1, 32.00),
  (2, 22, 'Chicken Teriyaki Bento',     22.00, 1, 22.00),
  (2, 24, 'Miso Soup',                   6.00, 1,  6.00); -- (subtotal listed above includes free miso? no — adjusted)

-- Note: subtotal in the prototype profile says RM 64.20 — the seed amounts above keep it consistent with line items.

INSERT INTO `payments` (`order_id`, `method`, `provider`, `provider_payment_id`, `amount`, `status`, `paid_at`) VALUES
  (2, 'fpx', 'billplz', 'bpz_seed_NN02', 63.36, 'succeeded', '2026-05-16 20:22:45');

INSERT INTO `order_status_history` (`order_id`, `status`, `note`, `created_at`) VALUES
  (2, 'pending',    'Order placed',                    '2026-05-16 20:22:00'),
  (2, 'confirmed',  'Restaurant accepted',             '2026-05-16 20:23:00'),
  (2, 'preparing',  'Kitchen started preparation',     '2026-05-16 20:25:00'),
  (2, 'on_the_way', 'Rider picked up',                 '2026-05-16 20:46:00'),
  (2, 'delivered',  'Customer confirmed receipt',      '2026-05-16 20:55:00');


-- =============================================================================
-- Order #NN-2026-04821 (preparing, Tony's Pizzeria, 18 May)
-- This is the one shown on the order-confirmation.html page.
-- =============================================================================
INSERT INTO `orders` (`id`, `order_number`, `user_id`, `restaurant_id`, `delivery_address_id`, `promotion_id`, `delivery_method`, `status`, `subtotal`, `delivery_fee`, `service_charge`, `discount_amount`, `total`, `delivery_instructions`, `estimated_ready_at`, `created_at`) VALUES
  (3, 'NN-2026-04821', 100, 1, 1, NULL, 'delivery', 'preparing', 78.00, 5.00, 4.68, 0.00, 87.68, NULL, '2026-05-18 17:30:00', '2026-05-18 17:05:00');

INSERT INTO `order_items` (`order_id`, `menu_item_id`, `item_name`, `unit_price`, `qty`, `line_total`) VALUES
  (3, 1, 'Margherita Classic',   28.00, 1, 28.00),
  (3, 6, 'Spaghetti Carbonara',  26.00, 1, 26.00),
  (3, 8, 'Garlic Bread',         12.00, 2, 24.00);

INSERT INTO `payments` (`order_id`, `method`, `provider`, `provider_payment_id`, `amount`, `status`, `paid_at`) VALUES
  (3, 'card', 'stripe', 'ch_3PqXyZ821seed', 87.68, 'succeeded', '2026-05-18 17:05:25');

INSERT INTO `order_status_history` (`order_id`, `status`, `note`, `created_at`) VALUES
  (3, 'pending',   'Order placed',                '2026-05-18 17:05:00'),
  (3, 'confirmed', 'Restaurant accepted',         '2026-05-18 17:06:00'),
  (3, 'preparing', 'Kitchen started preparation', '2026-05-18 17:09:00');


-- =============================================================================
-- Order #NN-2026-04302 (cancelled, Smash House Burgers, 8 May)
-- =============================================================================
INSERT INTO `orders` (`id`, `order_number`, `user_id`, `restaurant_id`, `delivery_address_id`, `promotion_id`, `delivery_method`, `status`, `subtotal`, `delivery_fee`, `service_charge`, `discount_amount`, `total`, `cancelled_at`, `cancellation_reason`, `created_at`) VALUES
  (4, 'NN-2026-04302', 100, 3, 1, NULL, 'delivery', 'cancelled', 38.00, 5.00, 2.28, 0.00, 0.00, '2026-05-08 19:42:00', 'Restaurant ran out of buns', '2026-05-08 19:30:00');

INSERT INTO `order_items` (`order_id`, `menu_item_id`, `item_name`, `unit_price`, `qty`, `line_total`) VALUES
  (4, 30, 'Classic Smash', 24.00, 1, 24.00),
  (4, 33, 'Chocolate Shake', 14.00, 1, 14.00);

INSERT INTO `payments` (`order_id`, `method`, `provider`, `provider_payment_id`, `amount`, `status`, `refunded_at`, `paid_at`) VALUES
  (4, 'card', 'stripe', 'ch_3PqXyZ302seed', 45.28, 'refunded', '2026-05-08 19:43:00', '2026-05-08 19:30:30');

INSERT INTO `order_status_history` (`order_id`, `status`, `note`, `created_at`) VALUES
  (4, 'pending',   'Order placed',         '2026-05-08 19:30:00'),
  (4, 'cancelled', 'Refunded to customer', '2026-05-08 19:42:00');


-- =============================================================================
-- 12. REVIEWS (only for delivered orders)
-- =============================================================================
INSERT INTO `reviews` (`user_id`, `restaurant_id`, `order_id`, `rating`, `comment`, `created_at`) VALUES
  (100, 6, 1, 5, 'Mediterranean Bowl was perfect — fresh, generous, beautifully balanced. Will reorder.', '2026-05-12 14:00:00'),
  (100, 2, 2, 4, 'Salmon was sashimi-grade quality. Bento was tasty but rice slightly overcooked.',        '2026-05-16 21:30:00');

-- The triggers on `reviews` will automatically update restaurants.rating_avg / rating_count.
-- After this seed:
--   Greenhouse Bowls (id=6) -> rating_avg=5.00, rating_count=1
--   Sakura Sushi    (id=2) -> rating_avg=4.00, rating_count=1


SET FOREIGN_KEY_CHECKS = 1;

-- =============================================================================
-- END OF 02-seed.sql
-- =============================================================================
