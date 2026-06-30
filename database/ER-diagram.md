# NomNom — Entity Relationship Diagram

This document defines the relational schema for the NomNom online food ordering system. It is the data layer that the PHP backend (Section 4.1 of the assignment) will read and write through prepared statements.

The diagram is rendered with **Mermaid**. GitHub renders it inline. To export a PNG for the assignment, paste it into https://mermaid.live and download.

---

## Schema Overview

12 core tables, grouped into 4 concerns:

| Concern | Tables |
|---|---|
| **Identity** | `users`, `user_addresses` |
| **Catalog** | `restaurants`, `restaurant_hours`, `menu_categories`, `menu_items` |
| **Ordering** | `orders`, `order_items`, `order_status_history`, `payments` |
| **Engagement** | `reviews`, `promotions` |

---

## ER Diagram

```mermaid
erDiagram
    users ||--o{ user_addresses : "owns"
    users ||--o{ orders : "places"
    users ||--o{ reviews : "writes"
    users ||--o| restaurants : "owns (if restaurant_owner)"

    restaurants ||--o{ restaurant_hours : "has"
    restaurants ||--o{ menu_categories : "groups"
    restaurants ||--o{ menu_items : "sells"
    restaurants ||--o{ orders : "fulfils"
    restaurants ||--o{ reviews : "receives"
    restaurants ||--o{ promotions : "offers"

    menu_categories ||--o{ menu_items : "contains"

    orders ||--|{ order_items : "contains"
    orders ||--o{ order_status_history : "tracks"
    orders ||--|| payments : "settled by"
    orders }o--o| user_addresses : "delivered to"
    orders }o--o| promotions : "uses"

    menu_items ||--o{ order_items : "snapshotted in"

    users {
        BIGINT id PK
        VARCHAR email UK
        VARCHAR password_hash
        VARCHAR first_name
        VARCHAR last_name
        VARCHAR phone
        ENUM role "customer|restaurant_owner|admin"
        TINYINT email_verified
        TIMESTAMP created_at
        TIMESTAMP updated_at
        TIMESTAMP deleted_at "soft delete"
    }

    user_addresses {
        BIGINT id PK
        BIGINT user_id FK
        VARCHAR label "Home/Office"
        VARCHAR address_line1
        VARCHAR address_line2
        VARCHAR postal_code
        VARCHAR city
        DECIMAL latitude
        DECIMAL longitude
        TINYINT is_default
        TIMESTAMP created_at
    }

    restaurants {
        BIGINT id PK
        BIGINT owner_user_id FK
        VARCHAR slug UK "url-friendly"
        VARCHAR name
        TEXT description
        VARCHAR cuisine_type
        VARCHAR phone
        VARCHAR address_line1
        VARCHAR city
        VARCHAR postal_code
        DECIMAL latitude
        DECIMAL longitude
        DECIMAL delivery_fee
        INT prep_time_min "minutes"
        DECIMAL rating_avg "denormalised cache"
        INT rating_count "denormalised cache"
        ENUM status "active|paused|closed"
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    restaurant_hours {
        BIGINT id PK
        BIGINT restaurant_id FK
        TINYINT day_of_week "0=Sun..6=Sat"
        TIME open_time
        TIME close_time
    }

    menu_categories {
        BIGINT id PK
        BIGINT restaurant_id FK
        VARCHAR name "Pizzas, Pasta..."
        INT sort_order
    }

    menu_items {
        BIGINT id PK
        BIGINT restaurant_id FK
        BIGINT category_id FK
        VARCHAR name
        TEXT description
        DECIMAL price
        VARCHAR image_url
        TINYINT is_available
        INT sort_order
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    orders {
        BIGINT id PK
        VARCHAR order_number UK "NN-2026-04821"
        BIGINT user_id FK
        BIGINT restaurant_id FK
        BIGINT delivery_address_id FK
        BIGINT promotion_id FK
        ENUM delivery_method "delivery|pickup"
        ENUM status "pending|confirmed|preparing|on_the_way|delivered|cancelled"
        DECIMAL subtotal
        DECIMAL delivery_fee
        DECIMAL service_charge
        DECIMAL discount_amount
        DECIMAL total
        TEXT delivery_instructions
        TIMESTAMP estimated_ready_at
        TIMESTAMP delivered_at
        TIMESTAMP created_at
        TIMESTAMP updated_at
    }

    order_items {
        BIGINT id PK
        BIGINT order_id FK
        BIGINT menu_item_id FK "nullable: item could be deleted"
        VARCHAR item_name "snapshot at order time"
        DECIMAL item_price "snapshot at order time"
        INT qty
        DECIMAL line_total
    }

    order_status_history {
        BIGINT id PK
        BIGINT order_id FK
        ENUM status "pending|confirmed|preparing|on_the_way|delivered|cancelled"
        TEXT note
        TIMESTAMP created_at
    }

    payments {
        BIGINT id PK
        BIGINT order_id FK UK "1:1"
        ENUM method "card|fpx|ewallet|cod"
        VARCHAR provider "stripe|billplz|tng|cod"
        VARCHAR provider_payment_id "external token/ref"
        DECIMAL amount
        ENUM status "pending|succeeded|failed|refunded"
        TIMESTAMP paid_at
        TIMESTAMP created_at
    }

    reviews {
        BIGINT id PK
        BIGINT user_id FK
        BIGINT restaurant_id FK
        BIGINT order_id FK UK "one review per order"
        TINYINT rating "1..5"
        TEXT comment
        TIMESTAMP created_at
    }

    promotions {
        BIGINT id PK
        BIGINT restaurant_id FK "null = platform-wide"
        VARCHAR code UK
        VARCHAR description
        ENUM discount_type "percentage|fixed"
        DECIMAL discount_value
        DECIMAL min_order_amount
        INT max_uses
        INT used_count
        DATETIME starts_at
        DATETIME ends_at
        TINYINT is_active
        TIMESTAMP created_at
    }
```

---

## Key Design Decisions

### 1. Single `users` table with role enum
Customers, restaurant owners, and admins share login mechanics, so they live in one table with a `role` column rather than three duplicate auth tables. A restaurant owner is just a `user` whose `id` appears as `restaurants.owner_user_id`.

### 2. Snapshotted line items
`order_items` copies `item_name` and `item_price` from `menu_items` at order time. If the restaurant later raises a pizza price or removes an item from the menu, the customer's receipt and order history remain accurate. `menu_item_id` is kept (nullable) for analytics but is **not** the source of truth for what was charged.

### 3. Status history table
`order_status_history` records every transition (pending → confirmed → preparing → on_the_way → delivered) with timestamp and optional note. This drives the 4-step tracker on the order-confirmation page and gives operations a complete audit trail.

### 4. Denormalised rating cache
`restaurants.rating_avg` and `rating_count` are **denormalised** from `reviews` for fast restaurant-listing queries. They are updated by the application or by a database trigger whenever a review is created, updated, or deleted. The trade-off: 6 ms saved per listing query, at the cost of one extra write on review submission.

### 5. Money is `DECIMAL(10,2)`, never `FLOAT`
Floating point cannot represent `0.10` exactly. All monetary columns use `DECIMAL(10,2)` for cents-accurate arithmetic. Up to 99,999,999.99 — well beyond any single-order or daily-revenue need.

### 6. Soft delete for users and restaurants
`users.deleted_at` and `restaurants.status='closed'` preserve historical orders even after an account or restaurant is removed. Orders themselves are **never deleted** — legal/financial requirement.

### 7. Order number is human-readable and unique
`order_number` (e.g. `NN-2026-04821`) is a separate `UNIQUE` column from the auto-increment `id`. Customers quote it in support tickets, but the database primary key stays integer for join performance.

### 8. Timestamps everywhere
Every table has `created_at`. Mutable tables also have `updated_at` (set by application or `ON UPDATE CURRENT_TIMESTAMP`). This makes incident debugging and analytics dramatically easier.

### 9. Indexing strategy (defined in `01-schema.sql`)
- All foreign keys are indexed (MySQL does this for InnoDB FK constraints)
- `users.email` unique index — login lookup
- `orders.order_number` unique index — customer support lookup
- `orders(user_id, created_at DESC)` composite — "my orders" page
- `orders(restaurant_id, status)` composite — restaurant kitchen dashboard
- `menu_items(restaurant_id, sort_order)` composite — menu rendering in display order
- `restaurants(city, status)` composite — geographic listings filtered by open restaurants

### 10. Character set
Tables use `utf8mb4` with collation `utf8mb4_unicode_ci`. Required for full Unicode (emoji, Chinese characters in restaurant names, accented Malay diacritics in reviews).

---

## What's Intentionally Out of Scope

| Skipped | Why |
|---|---|
| `user_payment_methods` table | Card details are tokenised by Stripe/Billplz; we store only the token in `payments.provider_payment_id`. PCI scope avoided. |
| `menu_item_options` (size, toppings) | Prototype-level scope. Add a separate `menu_item_options` + `order_item_options` pair when needed. |
| `notifications` table | Push subscriptions are stored in browser/`localStorage` and posted to a webhook endpoint; no need for a DB table at this stage. |
| `sessions` table | Use PHP's default file session handler or Redis (per `docker-compose.yml`). Database sessions are slower and unnecessary here. |
| Real-time order tracking columns | Live rider GPS belongs in a separate hot store (Redis, or a small Node/WebSocket service); not in MySQL. |
| `audit_log` | Useful for admin actions but not part of the customer-facing rubric. Add later if needed. |

---

## Migration Path

The schema is shipped as a single file (`01-schema.sql`) that runs once on first database boot. From there, every change should land as a new numbered migration file (`02-add-loyalty-points.sql`, `03-add-rider-table.sql`, etc.) committed to GitHub. This is the same versioning discipline mentioned in the assignment's Section 4.3.

Recommended tooling for the real build:
- **Phinx** (`composer require robmorgan/phinx`) — PHP migrations
- **Liquibase** — language-agnostic, more enterprise
- Plain SQL files run by a `migrate.php` script — simplest for coursework

---

## Sample Queries (sanity-check the design)

**1. Restaurant listing with rating, sorted by rating, only open restaurants in KL:**
```sql
SELECT id, name, cuisine_type, rating_avg, rating_count, delivery_fee, prep_time_min
FROM restaurants
WHERE status = 'active' AND city = 'Kuala Lumpur'
ORDER BY rating_avg DESC, rating_count DESC
LIMIT 24;
```
*Hits the `idx_restaurants_city_status` composite index.*

**2. A customer's order history (most recent first):**
```sql
SELECT o.order_number, o.status, o.total, o.created_at, r.name AS restaurant_name
FROM orders o
INNER JOIN restaurants r ON r.id = o.restaurant_id
WHERE o.user_id = ?
ORDER BY o.created_at DESC
LIMIT 20;
```
*Hits the `idx_orders_user_created` composite.*

**3. Restaurant kitchen dashboard — incoming orders:**
```sql
SELECT o.order_number, o.created_at, COUNT(oi.id) AS items, o.total
FROM orders o
INNER JOIN order_items oi ON oi.order_id = o.id
WHERE o.restaurant_id = ? AND o.status IN ('confirmed', 'preparing')
GROUP BY o.id
ORDER BY o.created_at ASC;
```
*Hits the `idx_orders_restaurant_status` composite.*

**4. Order detail with line items:**
```sql
SELECT o.*, p.method AS payment_method, p.status AS payment_status
FROM orders o
LEFT JOIN payments p ON p.order_id = o.id
WHERE o.order_number = ?;
-- then a second query for order_items
```

**5. Trigger-friendly: recompute restaurant rating after a new review:**
```sql
UPDATE restaurants r
SET rating_avg = (SELECT AVG(rating) FROM reviews WHERE restaurant_id = r.id),
    rating_count = (SELECT COUNT(*) FROM reviews WHERE restaurant_id = r.id)
WHERE r.id = ?;
```

---

*Next file: `01-schema.sql` — the full DDL with all CREATE TABLE statements, indexes, and foreign keys.*
