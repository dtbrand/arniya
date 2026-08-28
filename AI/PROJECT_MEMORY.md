# PROJECT MEMORY — durable facts, do not re-derive

> Every entry here was verified against the code. If you find one to be wrong, correct it in
> place and add a line to [CHANGELOG.md](CHANGELOG.md). Do not silently work around it.
> Last verified: 2026-08-29.

---

## M-1 · Three generations live in one repository

| Generation | Paths | Commits | Last touched | Status |
| :--- | :--- | :--- | :--- | :--- |
| **GEN-C (LIVE)** | `DT Brand/` | 101 | 2026-08-29 | Deployed. All recent commits touch only this. |
| **GEN-B (frozen)** | `Frontend/`, root `admin/`, `api/`, `src/`, `Shared/`, root `index.php`, `admin.php`, `adminlogin.php`, `logout.php`, `health.php` | 486 | 2026-08-25 | Not deployed. Historical. |
| **GEN-A (scaffold)** | root `app/`, `bootstrap/`, `config/`, `public/`, `database/`, `tests/`, `docs/`, `scripts/`, `composer.json`, `phpunit.xml`, `phpstan.neon`, `playwright.config.js`, `.github/` | 1–5 each | 2026-08-24 | One-shot drop, never wired to the live app. |

**Consequence:** a path like `src/Database.php` is ambiguous. Always write `DT Brand/src/Database.php`.
Root `index.php` requires `Frontend/Home/home.php`; that is GEN-B and is not what the live site serves.

## M-2 · Hostinger maps `DT Brand/` onto the web root

`/public_html/` == the **contents** of `DT Brand/`. Therefore:

- `DT Brand/admin/login/index.php` → `https://jaihanumantex.in/admin/login/`
- `DT Brand/api/orders.php` → `https://jaihanumantex.in/api/orders.php`
- `DT Brand/database/arniya_master_production.sql` → **publicly reachable** unless blocked. It is not
  blocked. See [SECURITY.md](SECURITY.md) SEC-4.

## M-3 · Only one SQL file ever executes

`DT Brand/database/migrate.php` runs **`DT Brand/database/arniya_master_production.sql`** and nothing else.

- `DT Brand/database/migrations/2026_08_25_production_upgrade.sql` — **never executed**. Any code that
  depends on a column introduced only there is a phantom-column bug.
- `DT Brand/database/schema.sql` — older, incompatible lineage (`password_hash NOT NULL`, `gst_number`).
- Every statement is `CREATE TABLE IF NOT EXISTS`, which **never alters an existing table**. A database
  first created from the older lineage keeps its old column set until `applyColumnUpgrades()` runs.

## M-4 · The live schema is 18 tables

`categories, subcategories, products, product_media, banners, customers, users, addresses,
product_colors, product_sizes, product_variants, wishlist_items, cart_items, orders, order_items,
coupons, reviews, customer_notes`

There is **no** `brands`, `attributes`, `settings`, `activity_logs`, `tags`, `segments`, `wallets`,
`wallet_transactions`, `quotations`, `whatsapp_logs`, `order_status_history`, `collections` or
`product_reviews` table. Code that queries those names fails at runtime. Full column detail and the
drift list: [DATABASE.md](DATABASE.md).

## M-5 · ENUM values that break queries when guessed

- `orders.fulfillment_status` = `unfulfilled | processing | dispatched | delivered | cancelled` (default `dispatched`)
- `orders.payment_status` = `pending | paid | credit | refunded` (default `paid`)
- `orders.channel` = `retail | wholesale | reseller | whatsapp` (default `retail`)
- `products.status` = `in_stock | low_stock | out_of_stock | draft` — plus a separate `is_featured`
  and `is_bestseller` flag. **`published` is a display label only; it is not a status value.**
- `customers.type` = `retail | wholesale | reseller`; `customers.status` = `active | pending | suspended`
- `users.role` = `super_admin | admin | manager | staff`
- `reviews.status` = `approved | pending | rejected`

## M-6 · `!=` is NULL-unsafe in these queries

`fulfillment_status != 'cancelled'` evaluates to NULL — not TRUE — on a row where the column is NULL,
so those rows vanish from `SUM`/`COUNT`. Always write:

```sql
COALESCE(`fulfillment_status`, 'unfulfilled') <> 'cancelled'
```

## M-7 · `OrderManager::getAll()` is not a raw row source

`DT Brand/src/OrderManager.php:600` reshapes rows into its own key names (`id` = order_number, `db_id`,
`customer`, `amount`, `status`, `source`, …) **and falls back to a built-in demo array when the database
is unreachable.** Any widget that reads raw `orders` columns must query the table directly, not call
this method. Mixing the two is what put `ORD-0 / ₹0` placeholder orders on the dashboard.

## M-8 · Mock mode fabricates confidence

`DT Brand/src/Database.php` sets `isMockMode() = true` and returns `null` when no MySQL candidate
connects (`src/Database.php:52`). Callers that do not check for null get empty arrays and `false`
returns that look like "no data" rather than "no database". Always gate on
`$db !== null && !Database::isMockMode()`.

## M-9 · The B2B pages have no server-side authentication

`wholesale.php`, `reseller.php`, `retailer.php`, `account.php`, `cart.php` and `checkout.php` contain
**zero** `$_SESSION` references. The only gate is a client-side `localStorage.getItem('dtbrands_user')`
check. Wholesale and reseller pricing is therefore public. See [SECURITY.md](SECURITY.md) SEC-7.

## M-10 · Verification tooling on this machine

- PHP 8.2.12 CLI at `/c/xampp/php/php.exe` — **not** on `PATH` as `php`.
- Project-wide lint:
  `find . -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -P 8 -n 1 /c/xampp/php/php.exe -l 2>&1 | grep -v "No syntax errors"`
- JS syntax: `node --check --input-type=commonjs < file`. A bare `node --check` misreports these files
  because the workspace `package.json` declares `"type": "module"`. Always run the control first:
  `printf 'function f(){}\nfunction f(){}\n' | node --check --input-type=commonjs`
  **This trap has already produced one wrong finding:** module mode reports duplicate `function`
  declarations as `SyntaxError`, which is how `reseller.js` came to be written off as 351 KB of dead
  code. Nothing in `DT Brand/` is loaded as a module — there is no `type="module"` anywhere in it — so
  duplicate `function` declarations are legal and the last one simply wins (KI-21).
- **No MySQL locally.** Nothing database-dependent is runtime-verifiable; say so instead of claiming it.
- Windows console is cp1252 — verification scripts must print ASCII only.
- Windows PHP writing `/tmp/x` produces `C:/tmp/x`, which MSYS tools see as `/c/tmp/x`.

## M-11 · Charts are hand-drawn

Admin analytics use raw `<canvas>` 2D drawing, not Chart.js. Use
`ctx.setTransform(dpr, 0, 0, dpr, 0, 0)` — never `ctx.scale(dpr, dpr)`, which compounds on every resize.

## M-12 · Seed data is indistinguishable from production data

`arniya_master_production.sql` seeds 8 categories, 6 demo products, **3 named customers with a GSTIN**
(`:340`), **3 orders** (`:346`) and **2 reviews** (`:365`). Any "3 orders" or `DT-ORD-90281` seen on the
live dashboard is seed data, not a real sale. See [KNOWN_ISSUES.md](KNOWN_ISSUES.md) KI-1.
