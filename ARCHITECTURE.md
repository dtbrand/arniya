# Architecture — DT Brand's & Jai Hanuman Tex

**Verified against the working tree on 2026-09-13.** All counts below were measured, not estimated.

## Overview

DT Brand's & Jai Hanuman Tex is a single-tree PHP 8.2+ / MySQL / Apache commerce platform that
serves four sales channels (retail, wholesale, reseller, retailer), a WhatsApp hand-off flow,
a 333-file admin console, and a REST API from one codebase. Deployment target is Hostinger
Business hosting (`https://jaihanumantex.in/`).

## Directory Topology

```text
/                          # Web root (public_html on production)
├── index.php              # Storefront landing page
├── shop.php               # Product catalogue
├── product.php            # Product detail page (PDP)
├── wholesale.php          # B2B wholesale portal
├── reseller.php           # Zero-investment reseller portal
├── retailer.php           # Retailer fast-order hub
├── account.php            # Customer identity, orders, wallet, wishlist
├── cart.php               # Shopping cart
├── checkout.php           # Checkout shell (renders Shared/checkout.php)
├── wishlist.php           # Wishlist page
├── about-us.php / contact.php / privacy.php / terms.php / shipping.php
├── install.php            # One-shot installer (delete after deployment)
├── health.php             # HTTP-level health probe
├── sitemap.php            # sitemap.xml generator
├── admin/                 # Admin console (333 PHP files across 26 modules)
│   ├── includes/adminguard.php   # Single admin-entry guard
│   ├── dashboard/  products/  orders/  customers/  catalogue/  cms/
│   ├── marketing/  inventory/  payments/  shipping/  reviews/
│   ├── notifications/  integrations/  reports/  system/  developer/
│   ├── users/  settings/  audit/  media/  pricing/  whatsapp/ ...
│   └── assets/            # Admin CSS/JS
├── api/                   # REST surface (43 top-level endpoints + 18 sub-routers)
│   ├── _guard.php         # dt_api_require_admin() — fails closed on 401
│   ├── cors.php           # Shared CORS + JSON headers
│   ├── webhooks/          # razorpay, cashfree, delhivery, bluedart, tci, whatsapp
│   ├── auth/  cart/  orders/  payments/  products/  customers/ ...
│   └── db_health.php      # Admin-guarded diagnostics & auto-migrator
├── src/                   # 25 PSR-4 domain engines (DTBrand\ namespace)
│   ├── Database.php       # PDO singleton, .env loader, mock-mode fallback
│   ├── ProductCatalog.php · OrderManager.php · CustomerManager.php
│   ├── PricingCalculator.php · DiscountEngine.php · Money.php
│   ├── PaymentManager.php · InventoryManager.php · AuditManager.php
│   ├── Auth.php · RateLimiter.php (global namespace — see known issues)
│   └── ... (Cart, Checkout, Content, Notification, Report, Review,
│            System, Developer, Integration, AdminSecurity, UIComponent,
│            PriceHistory, Wishlist managers)
├── Shared/                # Storefront partials actively included by every page
│   ├── cart.php · wishlist.php · quickview.php · checkout.php
│   ├── smartshare.php · reels.php
│   ├── Includes/          # db, logger, sentry helpers (legacy)
│   ├── Asset/             # jszip.min.js
│   └── Auth/              # logout, myaccount (legacy)
├── includes/              # 14 storefront helper partials
├── config/                # 9 config files (app, auth, database, mail, payment,
│                          # services, session, shipping, whatsapp)
├── database/
│   ├── migrations/        # 25 SQL migrations, applied lexicographically
│   └── migrate.php        # Migration runner
├── tests/                 # 36 test files (PHPUnit + custom suites)
├── scripts/               # 36 ops utilities (deploy, lint, backup, verify)
├── docs/                  # This documentation set + audits + runbooks
├── assets/                # Public CSS / JS / images
└── .htaccess              # Rewrites, canonical 301s, internal-dir denies, caching
```

**Legacy trees:** `DT Brand/` is an **empty directory** (no tracked files).
`Frontend/` no longer exists — `.htaccess` still 301-redirects its old routes to
the root pages. `Shared/` is **not** legacy: every storefront page includes its
partials (cart drawer, quick view, checkout overlay, etc.).

## Request Flow

```text
Browser
  │
  ▼
.htaccess ── internal-dir deny / canonical 301 / browser cache
  │
  ▼
Root page (index.php, shop.php, …)
  ├── session start → src/Auth.php (login, admin guard, rate limiting)
  ├── src/ProductCatalog.php → src/Database.php (PDO, mock-mode fallback)
  ├── src/PricingCalculator.php / DiscountEngine.php / Money.php
  └── include Shared/{cart,quickview,checkout,wishlist,smartshare,reels}.php
  │
  ▼
AJAX → /api/*.php → api/_guard.php (admin writes) → src/*Manager.php → MySQL
  │
  ▼
Payment webhooks → /api/webhooks/razorpay.php (HMAC-SHA256 verify, idempotent)
                 → PaymentManager::markOrderPaidAndAdjustStock() → stock decrement
```

## The 25 `src/` Engines

| Engine | Responsibility |
| --- | --- |
| `Database` | PDO singleton; loads `.env`; multi-candidate host fallback; mock mode when MySQL is down |
| `ProductCatalog` | Catalogue reads, category taxonomy, tiered pricing exposure |
| `OrderManager` | Transactional order placement, channel resolution, stock decrement |
| `CustomerManager` | Customer CRM, tier resolution, spend analytics |
| `Auth` | Password auth, session hardening, admin login, rate-limit integration |
| `PricingCalculator` | The **only** component allowed to round GST and shipping |
| `Money` | Integer-paisa money arithmetic and storage normalisation |
| `DiscountEngine` | Coupon validation, usage ledger, caps |
| `PaymentManager` | Gateway transactions, idempotency, `markOrderPaidAndAdjustStock()` |
| `InventoryManager` | Stock ledger, movements, adjustments |
| `AuditManager` | 15-domain audit trail, secret masking, JSON diffs, correlation IDs |
| `CartManager` / `CheckoutManager` | Cart validation, checkout orchestration, idempotency |
| `RateLimiter` | Sliding-window limiter (Redis → file fallback) — **global namespace** |
| `AdminSecurityManager` | Roles, permissions matrix, session checks |
| `ContentManager` / `NotificationManager` / `ReportManager` / `ReviewManager` | CMS, multi-channel notifications, analytics/exports, review moderation |
| `SystemManager` / `DeveloperManager` / `IntegrationManager` | System ops, developer tools, gateway integrations |
| `PriceHistoryManager` / `UIComponent` / `WishlistManager` | Price audit ledger, admin component library, wishlist |

## Multi-Channel Pricing (never trust the client)

The price tier is decided **server-side** from the signed-in session/customer row:

| Channel | Source column | Gate |
| --- | --- | --- |
| Retail | `products.retail_price` | Public |
| Wholesale | `products.wholesale_price` | `customers.type='wholesale'` |
| Reseller | `products.reseller_price` | `customers.type='reseller'` |
| Retailer | `products.retail_price` + MOQ validation | `customers.type='retailer'` |
| WhatsApp | Same as retail | `OrderManager::resolveChannel()` |

A tampered `channel=wholesale` in the request body cannot obtain bulk pricing.

## HTTP Surface Protections

- `RewriteRule ^(config|database|src|app|storage|tests|scripts|scratch|vendor|bootstrap|docs|backups|\.git|\.agents|\.uix|\.vscode)/` → **403**.
- `<FilesMatch>` denies `.env*`, `.git*`, `*.json`, `*.lock`, `*.neon`, `*.xml`, `*.sql`, `*.md`, `*.yml`, `*.log`, `*.bak`, `*.phar`, `*.cache`.
- Upload directory `assets/images/uploads/` blocks execution of `*.php`, `*.phtml`, `*.phar`, `*.cgi`, `*.pl`, `*.sh`.
- Legacy `Frontend/*` routes 301 to the root pages.
- **Gap (audited 2026-09-13):** `Shared/` is *not* in the deny list; its PHP partials
  render raw HTML/JSON if requested directly. Add it to the protected-dirs rule — see
  `docs/audits/2026-09-13-master-audit.md`.

## Where to Read Next

- `API.md` — every REST endpoint
- `DATABASE.md` — schema built from the 25 migrations
- `DEPLOYMENT.md` — Hostinger install, env, cron, triple-sync
- `TESTING.md` — how the CI gates run
- `docs/audits/2026-09-13-master-audit.md` — current audit findings
