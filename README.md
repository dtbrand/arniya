# DT Brand's & Jai Hanuman Tex — Production-Ready B2B & Wholesale E-Commerce

A single-tree PHP / MySQL / Apache deployment that runs the retail storefront,
the wholesale / reseller / retailer portals, the admin console, the WhatsApp
CRM and the Razorpay + Delhivery + BlueDart + TCI webhooks out of one codebase.
Targets Hostinger Business hosting and ships with a one-shot installer.

---

## At a glance

| Concern              | Where it lives                                                |
|----------------------|---------------------------------------------------------------|
| Entry / routing      | `/index.php`, `/.htaccess` (canonical + 301 legacy routes)    |
| Storefront           | `/index.php`, `/shop.php`, `/product.php`, `/wholesale.php`, `/reseller.php`, `/retailer.php` |
| Account & cart       | `/account.php`, `/cart.php`, `/wishlist.php`, `/checkout.php` |
| Admin console        | `/admin/` (all writes guarded by `admin/includes/adminguard.php`) |
| REST API             | `/api/*.php` (admin writes guarded by `api/_guard.php`)       |
| Domain logic         | `/src/` (`ProductCatalog`, `OrderManager`, `CustomerManager`, `Auth`, `PricingCalculator`, `DiscountEngine`, `Database`) |
| Configuration        | `/config/*.php` + `/.env`                                     |
| Schema               | `/database/migrations/*.sql` (applied by `install.php`)       |
| Webhooks             | `/api/webhooks/{razorpay,delhivery,bluedart,tci,whatsapp}.php`|
| Static assets        | `/assets/{css,js,images}`                                     |
| Health checks        | `/api/db_health.php`, `/health.php`                            |

There is **no second tree**, **no Shared/** mirror, and **no `DT Brand/` or
`DT Brand New/`** left over. Every byte on disk serves a real HTTP route.

---

## Channels

- **Retail** — public storefront (`/shop.php`, `/product.php`), prices from
  `products.retail_price`.
- **Wholesale** — `/wholesale.php`, prices from `products.wholesale_price`,
  requires a `customers` row with `type='wholesale'` for the credit tier.
- **Reseller** — `/reseller.php`, prices from `products.reseller_price`,
  requires a `customers` row with `type='reseller'`.
- **Retailer** — `/retailer.php`, prices from `products.retail_price` plus
  trade MOQ validation, requires `type='retailer'`.
- **WhatsApp** — `OrderManager::resolveChannel()` returns `'whatsapp'` when
  an order is placed through the WhatsApp hand-off flow without an account.

The price tier is **never** read from the request body — it is decided from
the signed-in session / customer row, so a tampered `channel=wholesale`
cannot buy at bulk rates.

---

## Deploying to Hostinger

### One-time setup

1. Create (or reuse) a Hostinger Business account with PHP 8.2 + MySQL 8.0.
2. Create the database `u602484543_demodt121` (or your own name) and a user
   with full privileges on it.
3. In Hostinger control panel → **Files → File Manager** (or via FTP), upload
   the unzipped tree to `/public_html/`.
4. Upload the `.env.example` as `.env` and fill in real values. (Do **not**
   commit `.env` — it is in `.gitignore`.)
5. Upload `composer.lock` and run `composer install --no-dev --optimize-autoloader`.

### Run the installer

From the Hostinger terminal (or via SSH):

```bash
cd ~/domains/jaihanumantex.in/public_html
php install.php
```

The installer will:

1. Check the PHP version and required extensions.
2. Apply every `.sql` file under `database/migrations/` in lexicographic order
   (idempotent — re-runs are safe).
3. Seed a minimum-real catalogue (8 categories, an admin user, three coupon
   codes and two banners).
4. Verify that every expected table now exists.
5. Print a deploy-readiness summary.

When the installer finishes, **delete `install.php` from the server** so the
public cannot re-trigger it.

### Final manual steps

- In Hostinger control panel → **Cron Jobs**, add:
  - `*/5 * * * * php /home/u602484543/domains/jaihanumantex.in/public_html/api/db_health.php >/dev/null 2>&1`
- Point `jaihanumantex.in` and `www.jaihanumantex.in` at `/public_html/` in
  Hostinger's **Domains** panel.
- Sign in at `https://jaihanumantex.in/admin/login.php`. The seeded
  credentials are `admin@jaihanumantex.in` / `DtBrand@Admin2026`. Change the
  password on first login.

---

## Local development

```bash
git clone https://github.com/dtbrand/dtbrand-storefront.git
cd dtbrand-storefront
cp .env.example .env
# Edit .env: DB_HOST=127.0.0.1, DB_NAME=dtbrand_dev, DB_USER=root, DB_PASS=...
composer install
php install.php
php -S 0.0.0.0:8080 -t .
```

The bundled `.htaccess` makes Apache the assumed web server. For the PHP
built-in server, the canonical routes still resolve, but the 301 redirects
to legacy URLs only fire under Apache `mod_rewrite`.

---

## Security posture

- `admin/includes/adminguard.php` is the single admin-entry guard. It is
  prepended into every `/admin/*.php` automatically by the `if (!headers_sent)`
  include line at the top of each page (server-side via `.htaccess` is also
  supported — see the comment block in that file).
- `api/_guard.php` exposes `dt_api_require_admin()` and is called by every
  write endpoint before touching the database. It fails closed (HTTP 401
  JSON) when the session is anonymous.
- All queries use PDO prepared statements with `PDO::ATTR_EMULATE_PREPARES = false`.
- All money math goes through `src/PricingCalculator.php`, which is the only
  file allowed to round GST and shipping.
- `api/webhooks/razorpay.php` verifies HMAC-SHA256 against
  `RAZORPAY_WEBHOOK_SECRET` and is idempotent on the event id.
- `.htaccess` denies access to `vendor/`, `config/`, `database/`, `src/`,
  `tests/`, `scripts/`, `.env*`, `.git/`, `.github/` and `.uix/`.

---

## What "real" means in this tree

There is **no demo data, no mock orders, no fake reviews and no placeholder
products** anywhere in the production code path. If the database is
unreachable, every page renders empty rather than fabricating rows:

- `src/Database.php` returns `null` from `getConnection()` when MySQL is
  unreachable, and short-circuits subsequent calls via `Database::$attempted`.
- `src/ProductCatalog::getAll()` returns `[]` (not a hardcoded fallback list)
  on a dead connection, so the storefront shows an honest empty grid.
- `src/OrderManager::getAll()` reports an empty order list rather than
  shipping fabricated rows; admin orders widgets show "0 orders" instead of
  invented placeholders.
- `src/CustomerManager::getAll()` likewise returns `[]` on a dead database.

Endpoints that genuinely cannot be finished yet log an entry in
`AI/KNOWN_ISSUES.md` and return `HTTP 501 Not Implemented`.

---

## License

Proprietary — DT Brand's & Jai Hanuman Tex. All rights reserved.