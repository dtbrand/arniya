# Database Reference — DT Brand's & Jai Hanuman Tex

**Source of truth:** the 25 SQL migrations in `database/migrations/`
(applied lexicographically by `install.php` / `api/db_health.php?action=migrate`).
Production database: `u602484543_demodt121` (MySQL, utf8mb4).

## Migration Ledger

| # | Migration | Purpose |
| --- | --- | --- |
| 1 | `2026_08_23_000001_create_initial_schema.sql` | Core schema |
| 2 | `2026_08_24_000001_full_production_schema.sql` | Full production tables |
| 3 | `2026_08_25_production_upgrade.sql` | Production upgrade pass |
| 4 | `2026_08_29_000001_reconcile_full_schema.sql` | Schema reconciliation |
| 5 | `2026_08_30_000001_add_brands_and_admin_tables.sql` | Brands, admins |
| 6 | `2026_08_31_000001_seed_ethnic_pillars_and_subcategories.sql` | Category seed |
| 7 | `2026_09_02_000001_create_payment_gateways_and_webhooks.sql` | Gateway tables |
| 8 | `2026_09_07_000001_add_missing_columns_indexes_and_fixes.sql` | Columns + indexes |
| 9 | `2026_09_09_000001_add_master_price_fields.sql` | Master price fields |
| 10 | `2026_09_11_000001_add_full_price_matrix_columns.sql` | Full price matrix |
| 11–14 | `2026_09_12_000001…000004` | Inventory ledger, coupon usages + audit, shipping admin, payment admin |
| 15–17 | `2026_09_12_000005…000007` | Marketing/content, reviews, notifications admin |
| 18–20 | `2026_09_12_000008…000010` | Integrations, returns + reports, admin security roles |
| 21–22 | `2026_09_12_000011…000012` | Audit log enhancement, governance + feature flags |
| 23–24 | `2026_09_12_000013…000014` | Developer/webhook queue, price history + DB integrity |
| 25 | `2026_09_13_000015_add_idempotency_and_stock_safety.sql` | Idempotency keys, stock safety |

## Core Table Map

### Catalogue

```sql
products        (id, sku, title, slug, category_id, mrp, price,
                 retail_price, wholesale_price, reseller_price, …
                 stock_qty, moq, fabric, weave, color, badge,
                 rating, reviews_count, image, status, timestamps)
categories      (id, name, slug, description, image, display_order,
                 products_count, status)
subcategories   (id, category_id, name, slug, status)
brands          (id, name, slug, logo, description, status)
attributes      (id, name, code, type, values_json)
product_media   (id, product_id, media_url, media_type, sort_order, is_primary)
product_variants / variant options — size & colour matrices
product_reviews (id, product_id, customer_name, rating, review_text,
                 verified_buyer, status)
```

### Orders & fulfilment

```sql
orders               (id, order_number, customer_id, customer_name,
                      customer_phone, channel, subtotal, discount,
                      gst_rate, gst_amount, shipping_fee, total_amount,
                      payment_method, payment_status, fulfillment_status,
                      tracking_number, courier_name, idempotency_key, created_at)
order_items          (id, order_id, product_id, product_title, sku,
                      unit_price, quantity, total_price)
order_status_history (id, order_id, old_status, new_status, comments, updated_by)
quotations           (id, quote_number, customer_id, items_json, total_amount, status)
returns / rma        (return windows, resolutions — migration 2026_09_12_000009)
```

### Payments

```sql
payment_transactions  (order payload, gateway, method, amount, client IP,
                       user-agent, UTR, status — full audit ledger)
payment_gateways      (per-gateway credentials + enablement)
payment_webhook_queue (developer suite retry/replay ledger)
```

### Customers, CRM & wallets

```sql
customers           (id, name, phone, email, password, type, city, state,
                     tier, credit_limit, outstanding_balance, total_orders,
                     lifetime_spend, gstin, pan, commission_rate, status)
customer_addresses  (address book, multi-destination)
customer_notes      (CRM notes)
wallets             (id, customer_id, balance, currency)
wallet_transactions (id, wallet_id, type, amount, description, reference_id)
wholesale_accounts  (credit limits, GST numbers, tier levels)
reseller_profiles   (commission rates, payout ledgers)
```

### Marketing & content

```sql
coupons       (code, discount_type, discount_value, min_order_amount,
               usage_limit, times_used, expires_at, status)
coupon_usages (per-customer redemption ledger)
banners, sliders, homepage layout tables (content admin)
```

### Inventory & shipping

```sql
inventory_ledger / stock_movements (every stock change with reason + actor)
shipping_zones, shipping_rates, shipment_exceptions (shipping admin)
```

### Platform & governance

```sql
admins                (name, email, password, role, status, last_login)
admin_roles / admin_permissions / admin_sessions (migration 2026_09_12_000010)
audit_logs            (15-domain trail, correlation IDs, JSON before/after)
activity_logs         (user_type, user_id, action, ip_address)
settings              (key/value/group)
feature_flags         (runtime toggles — migration 2026_09_12_000012)
webhook_events_queue  (developer suite)
price_history         (every price change, who + when + old/new)
```

## Money & Rounding Rules

- All monetary arithmetic flows through `src/Money.php` (integer-paisa safe)
  and `src/PricingCalculator.php` — the only component allowed to round GST
  (5% textile rate) and shipping.
- Stored columns use DECIMAL; never float.
- `price_history` records every price mutation for audit.

## Stock Safety

- `OrderManager` decrements stock **inside the order transaction**.
- `PaymentManager::markOrderPaidAndAdjustStock()` is the single verified-capture
  entry point; it is idempotent (migration 25 adds the idempotency guard).
- `inventory_ledger` records each movement with actor + reason; negative stock
  is prevented by conditional `UPDATE ... WHERE stock_qty >= ?` guards.

## Operating the Database

```bash
# Apply all pending migrations (idempotent, lexicographic order)
php install.php                     # fresh install + seed
# or on a live box:
curl "https://jaihanumantex.in/api/db_health.php?action=migrate"   # admin session required

# Backup (local)
php scripts/backup-database.php
```

Backup/restore drills and disaster recovery: `docs/database-backups.md`,
`docs/disaster-recovery.md`, `docs/rollback-strategy.md`.
