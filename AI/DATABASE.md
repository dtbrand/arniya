# DATABASE

> Source of truth: `DT Brand/database/arniya_master_production.sql`, read line-by-line on
> 2026-08-29. Version header says `2.8.4 Enterprise Edition`. Every line number below is in
> that file unless another path is named.
>
> **No MySQL exists on the dev machine.** Nothing in this document was confirmed against a
> running server; it is confirmed against the schema source and the code that queries it.

---

## 1. The one true schema — 18 tables

| # | Table | Line | Purpose |
| ---: | :--- | ---: | :--- |
| 1 | `categories` | 11 | 8 top-level categories |
| 2 | `subcategories` | 28 | FK → categories, CASCADE |
| 3 | `products` | 40 | catalogue, 4 price columns, 4 MOQ tiers |
| 4 | `product_media` | 85 | gallery, FK → products CASCADE |
| 5 | `banners` | 95 | homepage hero slides |
| 6 | `customers` | 109 | storefront + B2B accounts |
| 7 | `users` | 134 | **admin/staff only** |
| 8 | `addresses` | 147 | FK → customers CASCADE |
| 9 | `product_colors` | 164 | global colour master |
| 10 | `product_sizes` | 173 | global size master |
| 11 | `product_variants` | 181 | colour × size × sku, FK → products CASCADE |
| 12 | `wishlist_items` | 196 | FK → customers + products, both CASCADE |
| 13 | `cart_items` | 206 | `session_id` NOT NULL, `customer_id` nullable |
| 14 | `orders` | 219 | **no FK to customers** |
| 15 | `order_items` | 244 | FK → orders CASCADE |
| 16 | `coupons` | 259 | code + percentage/flat |
| 17 | `reviews` | 270 | denormalised `customer_name`, no FK |
| 18 | `customer_notes` | 289 | staff memos, FK → customers CASCADE |

`SET FOREIGN_KEY_CHECKS = 0` at `:6` and back to `1` at `:369`. Every table is
`CREATE TABLE IF NOT EXISTS`, InnoDB, `utf8mb4_unicode_ci`, `time_zone = "+05:30"`.

**There is no** `brands`, `attributes`, `settings`, `activity_logs`, `order_status_history`,
`wallets`, `wallet_transactions`, `quotations`, `whatsapp_logs`, `tags`, `segments`,
`collections` or `product_reviews` table in this file. See §5 and §6 — the situation is
worse than "they don't exist", because two other files create some of them.

## 2. Column reference

### `categories` (`:11`)
`id` · `name` VARCHAR(100) · `slug` UNIQUE · `description` TEXT · `image` **NULL** ·
`banner_image` **NULL** · `products_count` INT 0 · `display_order` INT 1 ·
`status` ENUM(active,inactive) · `created_at`

`image`/`banner_image` used to default to `/Frontend/Shop/Asset/images/…` — a directory that
does not exist in this docroot, so every category was born pointing at a 404. Both are now
`DEFAULT NULL` and the UI shows a placeholder (`:16-20`). `products_count` seeds to 0 on
purpose; both storefront and admin count products live (`:306-308`).

### `subcategories` (`:28`)
`id` · `category_id` NOT NULL · `name` · `slug` UNIQUE · `description` · `status` · `created_at`
· FK `category_id` → `categories.id` **CASCADE**

### `products` (`:40`)
`id` · `sku` UNIQUE · `title` · `slug` UNIQUE · `category_id` INT DEFAULT 0 ·
`category_name` NOT NULL · `fabric` · `weave` · `zari_type` · `pallu_style` · `blouse_piece` ·
`occasion` (all six **DEFAULT NULL**) · `mrp` · `retail_price` · `wholesale_price` ·
`reseller_price` (all DECIMAL(10,2) NOT NULL) · `moq_single` 1 · `moq_half_set` 4 ·
`moq_full_set` 8 · `moq_master_bale` 24 · `stock_qty` **0** · `rating` **0.0** ·
`reviews_count` **0** · `primary_image` NOT NULL · `badge` NULL · `is_featured` TINYINT 0 ·
`is_bestseller` TINYINT 0 · `status` ENUM · `description` · `created_at` · `updated_at` ON UPDATE
· INDEX `idx_category`, `idx_sku`, `idx_status`

The six descriptive columns and the stock/rating/review counters previously carried
confident DEFAULTs (`'Pure Silk'`, `'Tested Gold Zari'`, `stock 50`, `rating 4.9`,
`120 reviews`, `'Bestseller'`). A product inserted without them made specific claims about
its own cloth and a rating nobody had left. Documented in the file at `:47-50` and `:65-67`.
**Do not reintroduce them.**

### `product_media` (`:85`)
`id` · `product_id` NOT NULL · `image_url` NOT NULL · `is_primary` TINYINT 0 ·
`sort_order` INT 0 · FK → `products.id` **CASCADE**

### `banners` (`:95`)
`id` · `title` · `subtitle` · `tagline` · `badge` · `cta_text` DEFAULT `'Shop Wholesale Now'` ·
`cta_link` DEFAULT `'/shop'` · `image_url` NOT NULL · `status` · `display_order`

### `customers` (`:109`)
`id` · `name` NOT NULL · `phone` VARCHAR(20) NOT NULL **UNIQUE** · `email` VARCHAR(150) ·
`password_hash` VARCHAR(255) **DEFAULT NULL** · `type` ENUM(retail,wholesale,reseller) ·
`city` · `state` · `tier` VARCHAR(50) DEFAULT `'Standard'` · `credit_limit` DECIMAL(12,2) ·
`outstanding_balance` DECIMAL(12,2) · `total_orders` INT 0 · `lifetime_spend` DECIMAL(12,2) ·
`gstin` NULL · `pan` NULL · `commission_rate` DECIMAL(5,2) · `reset_token` NULL ·
`reset_expires` TIMESTAMP NULL · `last_login` TIMESTAMP NULL ·
`status` ENUM(active,pending,suspended) · `created_at`

`phone` is UNIQUE — the three seeded customers all share `+91 70463 63528`, so **any real
customer registering with the brand's own WhatsApp number collides**. `password_hash` must
stay nullable: guest checkout and admin import both create rows without one, and the older
`schema.sql` declared it `NOT NULL` with no default, which rolled back the enclosing order
transaction in strict mode (`migrate.php:232-244`).

### `users` (`:134`) — admin/staff, a different table from `customers`
`id` · `name` · `email` NOT NULL **UNIQUE** · `phone` NULL · `password_hash` **NOT NULL** ·
`role` ENUM(super_admin,admin,manager,staff) DEFAULT `'admin'` ·
`status` ENUM(active,inactive) · `last_login` NULL · `created_at`

The master schema ships **no admin row**. `migrate.php::ensureAdminUser()` (`:153`) inserts one
only when the table has zero rows. `src/Auth.php::ensureUsersTable()` (`:417`) re-creates this
table with an identical definition if it is missing, because a database built from the older
`schema.sql` has no `users` table at all and every sign-in then reported "invalid credentials".

### `addresses` (`:147`)
`id` · `customer_id` NOT NULL · `recipient_name` · `phone` · `address_line1` NOT NULL ·
`address_line2` · `city` · `state` · `pincode` · `address_type` ENUM(home,work,warehouse) ·
`is_default` TINYINT 0 · `created_at` · FK → `customers.id` **CASCADE**

**No admin or API endpoint writes to this table.** The B2B "address book" is client-side.
See [KNOWN_ISSUES.md](KNOWN_ISSUES.md) KI-6.

### `product_colors` (`:164`) / `product_sizes` (`:173`)
Colours: `id` · `name` · `hex_code` NOT NULL · `swatch_image` NULL · `status`.
Sizes: `id` · `name` · `sort_order` · `status`. Both are **global masters, not per-product**,
and both ship **unseeded**.

### `product_variants` (`:181`)
`id` · `product_id` NOT NULL · `color_id` NULL · `color_name` NULL · `size_id` NULL ·
`size_name` NULL · `sku` NOT NULL (**not unique**) · `stock_qty` INT DEFAULT **10** ·
`price` DECIMAL(10,2) NULL · `image` NULL · FK → `products.id` **CASCADE**

`stock_qty DEFAULT 10` is the one surviving optimistic default in the schema — a variant
created without an explicit quantity claims ten pieces. Flagged, not changed.

### `wishlist_items` (`:196`)
`id` · `customer_id` NOT NULL · `product_id` NOT NULL · `created_at` · FK to both, **CASCADE**.
**`api/wishlist.php` never writes this table** — it keeps the wishlist in `$_SESSION`, so a
wishlist dies with the session. [KNOWN_ISSUES.md](KNOWN_ISSUES.md) KI-5.

### `cart_items` (`:206`)
`id` · `customer_id` INT NULL · `session_id` VARCHAR(100) **NOT NULL** · `product_id` NOT NULL ·
`color` NULL · `size` NULL · `quantity` INT NOT NULL 1 · `created_at` · FK → `products.id` CASCADE.
No FK on `customer_id`, no unique key on (`session_id`,`product_id`,`color`,`size`) — the same
line can be inserted twice.

### `orders` (`:219`)
`id` · `order_number` VARCHAR(50) NOT NULL **UNIQUE** · `customer_id` INT NOT NULL ·
`customer_name` NOT NULL · `customer_phone` NOT NULL · `channel` ENUM ·
`subtotal` DECIMAL(12,2) NOT NULL · `discount` · `gst_rate` DECIMAL(4,2) DEFAULT **5.00** ·
`gst_amount` · `shipping_fee` · `total_amount` DECIMAL(12,2) NOT NULL ·
`payment_method` VARCHAR(50) DEFAULT `'razorpay'` · `payment_status` ENUM ·
`fulfillment_status` ENUM · `tracking_number` NULL ·
`courier_name` DEFAULT **`'Delhivery Express'`** · `shipping_address` TEXT NULL · `created_at` ·
INDEX `idx_order_number`, `idx_customer`

Three defaults to keep in mind: **`payment_status` defaults to `paid`**,
**`fulfillment_status` defaults to `dispatched`**, and `courier_name` defaults to a named
courier. An order row inserted with only the required columns therefore claims it was paid for
and shipped by Delhivery. `customer_id` is NOT NULL but has **no foreign key**, so orphan
orders are possible and a `JOIN customers` silently drops them — use `LEFT JOIN`.

### `order_items` (`:244`)
`id` · `order_id` NOT NULL · `product_id` NOT NULL · `product_title` NOT NULL · `sku` NOT NULL ·
`variant_color` VARCHAR(60) NULL · `variant_size` VARCHAR(60) NULL · `unit_price` NOT NULL ·
`quantity` INT NOT NULL 1 · `total_price` NOT NULL · FK → `orders.id` **CASCADE**

`variant_color`/`variant_size` are what the shopper actually picked. Without them an order for
"Red, 6.3 m" reached the warehouse as a bare product title (`migrate.php:209-214`).

### `coupons` (`:259`)
`id` · `code` UNIQUE · `discount_type` ENUM(percentage,flat) · `discount_value` NOT NULL ·
`min_order_value` · `max_discount` · `status` ENUM(active,expired)

**No `usage_limit`, no `times_used`, no `expires_at`, no `starts_at`, no per-customer limit.**
A coupon cannot expire by date and cannot be capped by redemptions. Any admin screen offering
those fields is writing nowhere.

### `reviews` (`:270`)
`id` · `product_id` NOT NULL · `customer_name` VARCHAR(100) NOT NULL · `rating` INT NOT NULL 5 ·
`review_title` · `review_text` TEXT NOT NULL · `verified_buyer` TINYINT **1** ·
`status` ENUM(approved,pending,rejected) DEFAULT **`approved`** · `created_at`

No FK to `products` or `customers`; `customer_name` is free text; `verified_buyer` defaults to
true and `status` to approved, so an unmoderated insert publishes immediately as a verified
purchase.

### `customer_notes` (`:289`)
`id` · `customer_id` NOT NULL · `author_id` INT NULL · `author_name` NOT NULL DEFAULT `'Admin'` ·
`note_text` TEXT NOT NULL · `is_important` TINYINT 0 · `created_at` · INDEX `idx_note_customer` ·
FK → `customers.id` **CASCADE**. `author_name` is denormalised on purpose so a note still reads
correctly after the staff account that wrote it is removed (`:283-288`).

## 3. ENUM catalogue — never guess these

| Column | Allowed values | Default |
| :--- | :--- | :--- |
| `products.status` | `in_stock` `low_stock` `out_of_stock` `draft` | `in_stock` |
| `orders.channel` | `retail` `wholesale` `reseller` `whatsapp` | `retail` |
| `orders.payment_status` | `pending` `paid` `credit` `refunded` | **`paid`** |
| `orders.fulfillment_status` | `unfulfilled` `processing` `dispatched` `delivered` `cancelled` | **`dispatched`** |
| `customers.type` | `retail` `wholesale` `reseller` | `retail` |
| `customers.status` | `active` `pending` `suspended` | `active` |
| `users.role` | `super_admin` `admin` `manager` `staff` | `admin` |
| `users.status` | `active` `inactive` | `active` |
| `reviews.status` | `approved` `pending` `rejected` | **`approved`** |
| `coupons.discount_type` | `percentage` `flat` | `percentage` |
| `coupons.status` | `active` `expired` | `active` |
| `addresses.address_type` | `home` `work` `warehouse` | `home` |
| `categories.status`, `subcategories.status`, `banners.status`, `product_colors.status`, `product_sizes.status` | `active` `inactive` | `active` |

`published`, `archived`, `pending` (on products), `shipped`, `completed`, `failed` and `inactive`
(on customers) are **not** valid values anywhere. `is_featured` / `is_bestseller` are separate
TINYINT flags, not statuses.

## 4. Migration reality

`database/migrate.php` is the only sanctioned runner. `runMigrations()` (`migrate.php:70`):

1. `exec()` the whole of `arniya_master_production.sql` (`:77-93`) — the **only** SQL file it runs.
2. `applyColumnUpgrades()` (`:180`) — 13 guarded `ALTER … ADD COLUMN`, each preceded by
   `SHOW COLUMNS … LIKE ?`, plus two `MODIFY COLUMN` statements:
   `orders.shipping_address`, `products.is_featured`, `customers.password_hash`,
   `customers.total_orders`, `customers.lifetime_spend`, `customers.gstin`, `customers.pan`,
   `customers.commission_rate`, `customers.reset_token`, `customers.reset_expires`,
   `customers.last_login`, `order_items.variant_color`, `order_items.variant_size`;
   then `customers.password_hash → VARCHAR(255) DEFAULT NULL` (`:240`) and
   `customers.status → ENUM('active','pending','suspended')` (`:247`).
   **Order matters**: an `AFTER x` clause fails outright when `x` is missing, so every AFTER
   target is added earlier in the list (`:181-186`).
3. `repairLegacyData()` (`:113`) — six idempotent prefix rewrites turning
   `/Frontend/Shop/Asset/images/` into `/assets/images/` across `products.primary_image`,
   `product_media.image_url`, `product_variants.image`, `banners.image_url`, and NULLing the two
   phantom filenames on `categories.image` / `categories.banner_image`.
4. `ensureAdminUser()` (`:153`) — inserts one `super_admin` **only when `users` is empty**.
   Email/password/name come from `ADMIN_EMAIL` / `ADMIN_PASSWORD` / `ADMIN_NAME` with committed
   literal fallbacks (`:161-163`). The password is hashed with `password_hash()` before insert.

**Web gate** (`:293-307`): opens only for a signed-in admin (`dt_api_is_admin()`) **or** a
database with zero tables (`dt_migrate_is_blank_database()`, `:277`). The old
`?key=<literal>` install gate is gone — the reasoning is recorded in the file at `:256-273`.
**CLI**: `php database/migrate.php` applies; `php database/migrate.php status` only lists.

Files in `database/migrations/` are **never executed by this runner**. `status()` (`:57`) lists
them as `PENDING_OR_APPLIED`, which reads as though they run. They do not.
Any code depending on a column introduced only in `2026_08_25_production_upgrade.sql` is a
phantom-column bug.

## 5. THREE COMPETING SCHEMA AUTHORITIES — read this before trusting any table list

The live table set is not determined by the master schema alone. Three files can create tables,
and they disagree with each other. **Which tables exist on the live server depends on which
endpoint was last run** — this cannot be resolved from source and needs a `SHOW TABLES` on live.

| Authority | What it creates | Gate |
| :--- | :--- | :--- |
| `database/migrate.php` | the 18 canonical tables | admin session **or** blank DB |
| `api/db_audit.php:44-255` | **16 tables of its own**, including 9 that the master schema has never defined | `dt_api_require_admin('run a database audit')` (`:29`) |
| `api/db_health.php` | execs the **older, incompatible** `database/schema.sql` + `database/seeders.sql` for `action=seed_all\|migrate` (`:155-165`) | `dt_api_require_admin('run database diagnostics')` (`:28`) |
| `api/whatsapp.php:55` | `whatsapp_logs`, ad hoc, on first use | `dt_api_require_admin('use the WhatsApp console')` (`:28`) |

`api/db_audit.php` defines: `categories` (`:44`), `products` (`:56`), `customers` (`:81`),
`orders` (`:102`), `order_items` (`:127`), `coupons` (`:141`), `order_status_history` (`:157`),
`wallets` (`:167`), `wallet_transactions` (`:177`), `quotations` (`:188`), `whatsapp_logs` (`:204`),
`activity_logs` (`:214`), `reviews` (`:225`), `brands` (`:236`), `attributes` (`:246`),
`settings` (`:255`). Its definitions of the six shared tables are **not** verified to match the
master schema, and because everything is `IF NOT EXISTS` neither file ever corrects the other.

`api/db_health.php` additionally **seeds fabricated business data**: four `brands` (`:168-175`),
four `attributes` (`:178-187`), two `reviews` attributed to named people — 'Pooja Sharma',
'Ananya Roy' (`:190-197`) — and three `whatsapp_logs` rows with invented order/quote/AWB
identifiers (`:199-208`). It also carries its own hardcoded credential candidate list at
`:31-34`, including a bare-IP host, and one action **creates a real order** through
`OrderManager::createOrder()` from a hardcoded `KLN-SR-111 × 16` payload (`:118-145`), writing
demo rows into the live `orders` table.

All four routes are admin-gated, so this is not an unauthenticated exposure — it is a
**data-integrity and schema-drift hazard** operated by the owner's own console.
Recorded as [AUDIT_REPORT.md](AUDIT_REPORT.md) H-2 and [KNOWN_ISSUES.md](KNOWN_ISSUES.md) KI-2.

## 6. Phantom tables — every reference, verified 2026-08-29

Code that queries a table the master schema does not define. If `api/db_audit.php` has been run
on live these may resolve; if not, every one of these throws.

| Table | Referenced at |
| :--- | :--- |
| `settings` | `admin/settings/index.php:35` (INSERT), `:58` (SELECT); `api/db_audit.php:388` (SELECT), `:400` (INSERT) |
| `whatsapp_logs` | `admin/notifications/index.php:21`, `:24`; `api/whatsapp.php:38`, `:66`; `api/db_health.php:201` |
| `order_status_history` | `src/OrderManager.php:745` (INSERT), `:792` (SELECT) |
| `brands` | `api/db_health.php:170` |
| `attributes` | `api/db_health.php:181` |

Searched and **not referenced anywhere** in `DT Brand/`: `activity_logs`, `wallets`,
`wallet_transactions`, `quotations`, `tags`, `segments`, `collections`, `product_reviews` —
`api/db_audit.php` creates four of them but nothing reads them.

`admin/products/brands/{index,add,edit}.php` is a complete UI over the non-existent `brands`
table. `api/brands.php` and `api/attributes.php` exist as endpoints for the same reason.

## 7. Seeded data — indistinguishable from real trade

`arniya_master_production.sql` inserts, with explicit ids:

| Rows | Line | Detail |
| ---: | ---: | :--- |
| 8 categories | 309 | ids 1-8, `products_count` 0 |
| 6 products | 323 | `KLN-SR-111` `BNR-SR-204` `PTH-MH-305` `CHN-FO-401` `BRD-LH-902` `ORG-TS-508`, ids 1-6 |
| 2 banners | 335 | artwork points at `/assets/images/product1.png`, `product3.png` |
| **3 customers** | 340 | ids 101-103. 'Radhika Sarees Emporium' (wholesale, GSTIN `24AAACH7409R1ZZ`, credit limit 500000, lifetime spend 1845000), 'Pooja Sharma (Reseller)', 'Ananya Verma'. **All three share phone `+91 70463 63528`** — the brand's own WhatsApp number, on a UNIQUE column. |
| **3 orders** | 346 | `DT-ORD-90281` ₹44,688 · `DT-ORD-89412` ₹8,399 · `DT-ORD-78194` ₹5,144, with tracking `DEL-94028491` / `BD-84920194` / `DEL-78192041` |
| 4 order_items | 352 | |
| 3 coupons | 359 | `FESTIVE25` 25 %, `VIPRESELLER` 15 %, `BULK50` 50 % |
| **2 reviews** | 365 | attributed to 'Meenakshi Iyer (Chennai)' and 'Sunita Agarwal (Varanasi)', `verified_buyer = 1` |

The live dashboard's "TOTAL ORDERS 3" is these rows. **Before reporting any revenue figure to
the owner, state whether seed rows are included.** Deleting them is a data decision for the
owner, not an agent — see [KNOWN_ISSUES.md](KNOWN_ISSUES.md) KI-1 for the proposed
`id IN (1,2,3)` / `id IN (101,102,103)` cleanup and why it has not been run.

## 8. Query rules for this schema

1. **`!=` is NULL-unsafe.** `fulfillment_status != 'cancelled'` is NULL — not TRUE — on a NULL
   row, so those rows vanish from `SUM`/`COUNT`. Always:
   ```sql
   COALESCE(`fulfillment_status`, 'unfulfilled') <> 'cancelled'
   ```
2. **`orders` has no FK to `customers`.** Use `LEFT JOIN customers`; an `INNER JOIN` silently
   drops orphan orders and understates revenue.
3. **Never `SELECT *` into a template.** Column sets differ between databases built from
   `schema.sql` and from the master schema.
4. **Guard every connection**: `$db !== null && !Database::isMockMode()` before you trust a
   result. See [BACKEND.md](BACKEND.md) §2.
5. **Money is DECIMAL** — cast with `(float)` only at the display boundary, never in arithmetic
   that will be written back.
6. **`reviews` has no FK**: a rating aggregate must filter `status = 'approved'` explicitly,
   because the default is `approved` and there is no join to validate `product_id`.
7. **Prepared statements only.** Every query in `src/` and `api/` uses `prepare`/`execute` with
   `ATTR_EMULATE_PREPARES => false`. Do not break that pattern; no string interpolation into SQL.

## 9. Foreign keys and cascade map

```
categories ──CASCADE──> subcategories
products   ──CASCADE──> product_media, product_variants, cart_items, wishlist_items
customers  ──CASCADE──> addresses, wishlist_items, customer_notes
orders     ──CASCADE──> order_items
```

**No FK at all on:** `orders.customer_id`, `cart_items.customer_id`, `reviews.product_id`,
`product_variants.color_id`, `product_variants.size_id`, `customer_notes.author_id`,
`products.category_id` (INT DEFAULT 0, joined by `category_name` in several places instead).

Deleting a customer therefore **cascades away their addresses, wishlist and staff notes but
leaves their orders behind** as orphans with `customer_name`/`customer_phone` preserved on the
row. That is arguably correct for accounting, but it is not what an admin "delete customer"
button implies. Flag it before wiring any such button.

## 10. Integrity gaps worth knowing

- `product_variants.sku` is **not unique** — two variants can share a SKU.
- `cart_items` has no unique constraint on (`session_id`,`product_id`,`color`,`size`).
- `coupons` cannot expire by date and cannot track redemptions (§2).
- `customers.phone` UNIQUE + three seed rows on the brand's own number = a registration
  collision waiting to happen (§7).
- `products.rating` / `reviews_count` are **denormalised counters with no trigger**. Nothing in
  the codebase recomputes them from `reviews`; they stay 0 unless a screen writes them.
- `categories.products_count` likewise: seeded 0, counted live everywhere, never maintained.
- `orders` has no `updated_at`, so "when did this order change status" is unanswerable — which
  is why `order_status_history` was invented in `src/OrderManager.php` against a table that
  does not exist (§6).

## 11. Deployment note

After uploading any code that depends on the column upgrades in §4, the owner must run:

```bash
php database/migrate.php
```

on the live server (SSH or Hostinger's terminal), **or** load `/database/migrate.php?action=run`
while signed in as admin. It is idempotent and non-destructive: 18 × `CREATE TABLE IF NOT
EXISTS`, guarded `ALTER … ADD COLUMN`, prefix-only `UPDATE`s, and an admin insert that only
fires on an empty `users` table. See [DEPLOYMENT.md](DEPLOYMENT.md).






