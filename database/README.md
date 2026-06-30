# NomNom Database — Design Documentation

This folder contains the complete database design for the NomNom online food ordering system, the data layer that backs the PHP application described in the CBSC4103 assignment.

---

## Files

| File | Purpose | Lines |
|---|---|---:|
| `ER-diagram.md` | Mermaid ER diagram + design rationale (renderable on GitHub or mermaid.live) | ~230 |
| `01-schema.sql` | Full DDL: 12 tables, indexes, FK constraints, CHECK constraints, triggers | ~370 |
| `02-seed.sql` | Sample data matching the prototype (10 users, 6 restaurants, 22 menu items, 4 orders) | ~180 |
| `README.md` | This file — design summary + how to run | — |

---

## Quick Start

The schema is auto-loaded by Docker on first boot of the `db` service (per `docker-compose.yml` in the prototype root). To run manually:

```bash
# 1. Start the database container (from the prototype/ folder)
docker compose up -d db

# 2. Schema and seed run automatically because of:
#    ./database:/docker-entrypoint-initdb.d:ro

# 3. Verify
docker exec -it nomnom-db mariadb -uroot -prootsecret food_ordering \
  -e "SELECT COUNT(*) AS user_count FROM users;"
```

To run on a non-Docker MariaDB / MySQL:

```bash
mariadb -u root -p < 01-schema.sql
mariadb -u root -p food_ordering < 02-seed.sql
```

To open in DbVisualizer Pro:
- Host: `localhost`
- Port: `3306`
- Database: `food_ordering`
- User: `nomnom` (or `root`)
- Password: as set in `docker-compose.yml`

---

## Schema Statistics

| Metric | Value |
|---|---:|
| Tables | 12 |
| Foreign keys | 14 |
| Indexes (excl. PK) | 27 |
| Triggers | 4 |
| CHECK constraints | 8 |
| Engine | InnoDB |
| Charset | utf8mb4 |
| Collation | utf8mb4_unicode_ci |

---

## Table Map (one line each)

| # | Table | Role | PK type |
|---:|---|---|---|
| 1 | `users` | Customers, owners, admins (single table + role enum) | BIGINT |
| 2 | `user_addresses` | Multiple delivery addresses per user | BIGINT |
| 3 | `restaurants` | Restaurant master record + denormalised rating cache | BIGINT |
| 4 | `restaurant_hours` | Opening hours per day-of-week | BIGINT |
| 5 | `menu_categories` | Menu sections (Pizzas, Pasta, …) | BIGINT |
| 6 | `menu_items` | Individual sellable items | BIGINT |
| 7 | `promotions` | Discount codes (platform-wide or restaurant-scoped) | BIGINT |
| 8 | `orders` | Order header with totals snapshot | BIGINT |
| 9 | `order_items` | Order lines with **price snapshot** | BIGINT |
| 10 | `order_status_history` | Audit trail of every status transition | BIGINT |
| 11 | `payments` | 1:1 with orders, tokenised provider reference only | BIGINT |
| 12 | `reviews` | One per delivered order, drives rating cache via trigger | BIGINT |

---

## Key Design Decisions (Concise)

1. **Single users table, role-based** — one auth flow for all roles
2. **Snapshotted line items** — receipts stay accurate after menu edits
3. **Audit trail in `order_status_history`** — drives the 4-step PWA tracker
4. **Denormalised `rating_avg` / `rating_count`** — fast listings, kept in sync by triggers
5. **`DECIMAL(10,2)` for money** — never floating point
6. **Soft delete for users (`deleted_at`)** — preserves historical orders
7. **Human-readable `order_number`** + integer PK — fast joins, friendly support tickets
8. **Composite indexes for common query shapes** (see Index Strategy below)
9. **`utf8mb4`** — emoji-safe and Unicode-correct for Malay reviews
10. **Tokenised payments** — only the provider's reference ID is stored, not card details

Full rationale: `ER-diagram.md`.

---

## Index Strategy

Every index below maps to a real query the application needs to make fast:

| Index | Query it serves | Page |
|---|---|---|
| `users.uk_users_email` | Login lookup | login.html |
| `restaurants.idx_restaurants_city_status` | List open restaurants in city | restaurants.html |
| `restaurants.idx_restaurants_cuisine` | Filter by cuisine | restaurants.html |
| `restaurants.idx_restaurants_rating` | Sort by rating | restaurants.html |
| `menu_items.idx_menu_items_restaurant_sort` | Render full menu in display order | restaurant-detail.html |
| `menu_items.idx_menu_items_category_sort` | Render one section in display order | restaurant-detail.html |
| `orders.uk_orders_order_number` | Customer-support lookup | profile.html |
| `orders.idx_orders_user_created` | "My orders" descending by date | profile.html |
| `orders.idx_orders_restaurant_status` | Kitchen incoming orders | (restaurant dashboard, future) |
| `orders.idx_orders_status_created` | Admin overview | (admin dashboard, future) |
| `payments.uk_payments_order` | Strict 1:1 enforcement + lookup | order-confirmation.html |
| `reviews.idx_reviews_restaurant_created` | Recent reviews on restaurant page | restaurant-detail.html |
| `promotions.uk_promotions_code` + `idx_promotions_active_range` | Validate promo at checkout | checkout.html |

---

## Triggers (Why & What They Do)

| Trigger | Fires | Purpose |
|---|---|---|
| `trg_reviews_after_insert` | `INSERT INTO reviews` | Recompute `restaurants.rating_avg` and `rating_count` |
| `trg_reviews_after_update` | `UPDATE reviews` | Same — handles rating edits |
| `trg_reviews_after_delete` | `DELETE FROM reviews` | Same — restores accuracy after deletion |
| `trg_orders_status_history` | `UPDATE orders SET status=…` | Auto-insert into `order_status_history` |

Trade-off: each review/status change incurs one extra write, but every restaurant listing query becomes a single-row index lookup with zero aggregation.

---

## Sample Queries (with the indexes they exercise)

### Restaurant listings — open, in KL, sorted by rating
```sql
SELECT id, name, cuisine_type, rating_avg, rating_count, delivery_fee
FROM restaurants
WHERE status = 'active' AND city = 'Kuala Lumpur'
ORDER BY rating_avg DESC, rating_count DESC
LIMIT 24;
-- Uses: idx_restaurants_city_status (filter) + idx_restaurants_rating (sort)
```

### A customer's order history
```sql
SELECT o.order_number, o.status, o.total, o.created_at, r.name AS restaurant
FROM orders o
JOIN restaurants r ON r.id = o.restaurant_id
WHERE o.user_id = ?
ORDER BY o.created_at DESC
LIMIT 20;
-- Uses: idx_orders_user_created
```

### Restaurant kitchen — incoming orders
```sql
SELECT o.order_number, o.created_at, COUNT(oi.id) AS items, o.total
FROM orders o
JOIN order_items oi ON oi.order_id = o.id
WHERE o.restaurant_id = ? AND o.status IN ('confirmed', 'preparing')
GROUP BY o.id
ORDER BY o.created_at ASC;
-- Uses: idx_orders_restaurant_status
```

### Order detail with payment + items
```sql
SELECT o.*, p.method, p.status AS payment_status, p.provider_payment_id
FROM orders o
LEFT JOIN payments p ON p.order_id = o.id
WHERE o.order_number = ?;

SELECT * FROM order_items WHERE order_id = ?;
SELECT * FROM order_status_history WHERE order_id = ? ORDER BY created_at;
-- Uses: uk_orders_order_number + uk_payments_order + idx_order_items_order
```

### Validate a promo code at checkout
```sql
SELECT *
FROM promotions
WHERE code = ?
  AND is_active = 1
  AND NOW() BETWEEN starts_at AND ends_at
  AND (max_uses IS NULL OR used_count < max_uses)
LIMIT 1;
-- Uses: uk_promotions_code (then idx_promotions_active_range for batch admin queries)
```

---

## Seed Data Summary

After running `02-seed.sql`:

| Table | Rows | Notes |
|---|---:|---|
| `users` | 10 | 1 admin, 6 owners, 3 customers; password is `Password123!` |
| `user_addresses` | 4 | Aiman has Home + Office |
| `restaurants` | 6 | Mirrors the 6 prototype restaurant cards |
| `restaurant_hours` | 21 | Hours for restaurants 1, 2, 6 |
| `menu_categories` | 14 | 6 for Tony's, plus categories for 3 other restaurants |
| `menu_items` | 22 | 11 for Tony's (full menu shown in prototype), 11 across 3 others |
| `promotions` | 3 | WELCOME10, TONYFREE5, NOMNOM20 |
| `orders` | 4 | Matches the 4 orders shown in profile.html (preparing, delivered ×2, cancelled) |
| `order_items` | 9 | Line items for all 4 orders |
| `payments` | 4 | 2 stripe, 1 billplz, 1 refunded |
| `order_status_history` | 14 | Full transition history per order |
| `reviews` | 2 | Triggers auto-set rating_avg on Greenhouse + Sakura |

---

## How This Maps to the Assignment

This database design is concrete supporting evidence for several rubric points:

| Rubric / Assignment Section | Where it lands in this DB |
|---|---|
| **§4.3 SQL — Project Requirements** | "users, restaurants, menus, orders, payments, reviews — relational dataset" → see the 12 tables here |
| **§4.3 — Performance Needs** | Indexes on FKs, filtered columns, composites for search → see `01-schema.sql` index list |
| **§4.3 — Ecosystem and Libraries** | `mysqli`/PDO with prepared statements → all sample queries above use parameter placeholders |
| **§4.3 — Scalability and Maintenance** | Versioned migration scripts in GitHub → `01-…`, `02-…` numbering pattern starts here |
| **§4.3 — Security Considerations** | Prepared statements (no concatenation), least-privilege DB users, payment tokenisation → all reflected in design |
| **§2.2 — DbVisualizer / Navicat** | Schema renders cleanly in both, EXPLAIN plans available on every indexed query |

You can drop a screenshot of DbVisualizer's auto-generated ERD (after importing this schema) directly into the assignment as the "interface" for the SQL tooling claim.

---

## Migration Discipline (Going Forward)

Add new files only — never edit `01-schema.sql` after launch.

| Filename pattern | Purpose |
|---|---|
| `01-schema.sql` | Initial schema (this file, frozen) |
| `02-seed.sql` | Initial seed (this file, frozen) |
| `03-add-loyalty-points.sql` | Future: loyalty_points table |
| `04-add-rider-tracking.sql` | Future: riders + rider_locations |
| `05-…` | etc. |

Each migration is committed to GitHub, runs in dev/staging/prod via the same Docker entrypoint, and survives team handover.

---

## Known Trade-offs (Honest Inventory)

| Decision | Trade-off |
|---|---|
| Denormalised `rating_avg` | Faster reads, but extra writes on each review change |
| Snapshotted `order_items` | Larger storage, but receipts stay correct after menu edits |
| Triggers in MySQL | Less code in PHP, but harder to test in isolation |
| Soft delete via `deleted_at` | All queries must filter `WHERE deleted_at IS NULL` (handled by application layer) |
| `ENUM` for status fields | Compact + indexed, but adding new values requires `ALTER TABLE` |
| No real-time tracking columns | Live rider GPS belongs in Redis or Pusher, not MySQL — kept out by design |

---

## Tomorrow's Step (PHP Scaffolding)

When you start the PHP layer, the first three files to create are:

1. `config/db.php` — PDO connection singleton with prepared statements
2. `includes/auth.php` — `password_verify`, session regeneration, CSRF token issuance
3. `includes/cart.php` — server-side cart stored in `$_SESSION['cart']`, syncing with client localStorage

The schema in this folder is ready to support all three without further changes.
