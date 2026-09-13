# DT Brand's & Jai Hanuman Tex — Comprehensive Engineering System Audit

**Document Version:** 2.0.0
**Audit Date:** 2026-09-13 (supersedes v1.0.0 of 2026-08-23)
**Target Platform:** PHP 8.2+ / Apache / MySQL (Hostinger production)
**Evidence base:** live `php -l`, PHPUnit (131/770), PHPStan level 1, git-tracked-file scan, tree verification — see `docs/audits/2026-09-13-master-audit.md` for the findings ledger.

---

## 1. Executive System Overview

DT Brand's & Jai Hanuman Tex is an enterprise luxury ethnic textile commerce platform
combining a direct-to-consumer storefront, a B2B partner ecosystem (wholesale,
reseller, retailer), and a WhatsApp CRM hand-off — all served from a single
PHP/MySQL/Apache tree deployed on Hostinger.

## 2. Verified Tree Topology (2026-09-13)

```text
/                      # Web root — 24 storefront PHP pages
├── admin/             # 333 PHP files across 26 modules (single adminguard entry)
├── api/               # 43 endpoints + 18 sub-routers, _guard.php fails closed
├── src/               # 25 PSR-4 engines (DTBrand\ namespace)
├── Shared/            # Active storefront partials (cart, quickview, checkout…)
├── includes/          # 14 storefront helpers
├── config/            # 9 configuration files
├── database/          # 25 lexicographic SQL migrations + runner
├── tests/             # 36 test files (PHPUnit + section suites)
├── scripts/           # 36 ops/deploy/verify utilities
└── docs/              # This documentation set + audits + runbooks
```

> v1.0.0 of this document described a `Frontend/` + `Shared/` dual layout.
> That tree no longer exists: `Frontend/` routes are 301-redirected by
> `.htaccess` to root pages, `DT Brand/` is empty (untracked), and `Shared/`
> is an active partial library. `ARCHITECTURE.md` is the canonical reference.

## 3. Database Architecture

- **Database:** `u602484543_demodt121` (MySQL, utf8mb4) — 25 forward-only migrations.
- **Core tables:** `products` (tiered price matrix: retail / wholesale / reseller),
  `categories`, `subcategories`, `brands`, `attributes`, `product_media`,
  `product_variants`, `product_reviews`, `orders`, `order_items`,
  `order_status_history`, `coupons`, `coupon_usages`, `quotations`,
  `payment_transactions`, `payment_gateways`, `payment_webhook_queue`,
  `customers`, `customer_addresses`, `customer_notes`, `wallets`,
  `wallet_transactions`, `wholesale_accounts`, `reseller_profiles`,
  `inventory_ledger`, `shipping_zones`, `admins`, `admin_roles`,
  `admin_permissions`, `admin_sessions`, `audit_logs`, `activity_logs`,
  `settings`, `feature_flags`, `webhook_events_queue`, `price_history`.
- Full reference with column details: `DATABASE.md`.

## 4. Backend Engines (`src/`, PSR-4 `DTBrand\`)

| Engine | Responsibility |
| --- | --- |
| `Database` | PDO singleton, `.env` loader, host-fallback, honest mock mode |
| `ProductCatalog` / `OrderManager` / `CustomerManager` | Catalogue, transactional orders, CRM |
| `PricingCalculator` / `Money` | Single source of truth for GST/shipping rounding; integer-paisa math |
| `DiscountEngine` / `PaymentManager` / `InventoryManager` | Coupons + usage ledger, gateway capture + idempotency, stock ledger |
| `Auth` / `AdminSecurityManager` / `RateLimiter` | Sessions, roles/permissions, sliding-window limits |
| `AuditManager` | 15-domain audit trail, secret masking, JSON diff, correlation IDs |
| Cart / Checkout / Content / Notification / Report / Review / System / Developer / Integration managers | Domain suites (Sections 25–40 of the master spec) |

## 5. Quality Baseline (measured 2026-09-13)

| Check | Result |
| --- | --- |
| `php -l` (root, src, api, config, includes, admin) | 0 errors |
| PHPUnit | 131 tests / 770 assertions / 1 failure / 14 deprecations |
| PHPStan level 1 | 22 errors (4 files) — all listed in the master audit |
| CI | Lint + PHPUnit + PHPStan + ESLint/Stylelint + Playwright + CodeQL + Trivy + Scorecard |

## 6. Multi-Channel Security Model

- Price tier resolved **server-side** from the session/customer row — a tampered
  `channel=wholesale` payload cannot obtain bulk pricing.
- `api/orders.php` details: HTTP 401 before any DB query (enumeration fixed).
- Razorpay webhook: HMAC-SHA256 (`hash_equals`), idempotent on event id.
- Payment capture: idempotent, single stock-decrement entry point
  (`PaymentManager::markOrderPaidAndAdjustStock()`), full `payment_transactions` audit.

## 7. Top Risks (full detail in master audit)

1. 🔴 **C1** — Production credentials in 17 tracked files + PAT in remote URL → rotate + purge.
2. 🔴 **C2** — `DTBrand\RateLimiter` fatal on the public auth API router.
3. 🟠 — Cashfree webhook `$data` undefined; `AuditManager::log()` misuse in `api/developer.php`; `Shared/` web-reachable.
4. 🟡 — DiscountEngine outage message, dead `isset($pdo)` guards, stale docs (refreshed here).
