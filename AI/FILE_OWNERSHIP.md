# FILE OWNERSHIP

> There is no `CODEOWNERS`, no team and no reviewer. "Ownership" here means: **which domain a path
> belongs to, and therefore which specialist brief in `AI/agents/` governs a change to it, and what
> the blast radius is.** Measured 2026-08-29 from `git ls-files`.

---

## 0. The rule that precedes every other one

The repository contains **three generations of the same product**. Only one is live:

| Tree | Status | Never |
| :--- | :--- | :--- |
| **`DT Brand/`** | **LIVE.** Its *contents* are `/public_html/` on Hostinger | — |
| `Frontend/` + root `admin/ api/ src/ Shared/ index.php admin.php adminlogin.php logout.php health.php` | frozen 2026-08-25, 376 PHP | edit to fix a live bug |
| root `app/ bootstrap/ config/ public/ database/ tests/ docs/ scripts/` + composer/phpunit/phpstan/playwright | one-shot scaffold 2026-08-24, never wired in | treat as the architecture |

**A bare path is ambiguous.** `src/Database.php` exists twice. Always write
`DT Brand/src/Database.php`. Every path in this document is relative to `DT Brand/` unless it starts
with `AI/` or names another generation explicitly. [PROJECT_MAP.md](PROJECT_MAP.md) §1.

## 1. Tracked files in the live tree

695 tracked files: **452 PHP · 105 JS · 87 CSS · 36 images (20 png, 16 webp) · 7 md · 6 sql · 1 svg
· 1 .htaccess.**

| Path | Files | Domain | Brief |
| :--- | ---: | :--- | :--- |
| `admin/` | 542 | admin console | [agents/admin.md](agents/admin.md) |
| `shared/` | 47 | storefront fragments + seed images | [agents/frontend.md](agents/frontend.md) |
| `assets/` | 38 | storefront CSS/JS/images | [agents/ui-ux.md](agents/ui-ux.md) |
| `api/` | 22 | HTTP surface | [agents/api.md](agents/api.md) |
| `includes/` | 11 | storefront header/footer fragments | [agents/frontend.md](agents/frontend.md) |
| 11 root `.php` | 11 | storefront pages | [agents/frontend.md](agents/frontend.md) |
| `database/` | 8 | schema + migrations | [agents/database.md](agents/database.md) |
| `config/` | 8 | return-an-array config | [agents/backend.md](agents/backend.md) |
| `src/` | 7 | the service layer | [agents/backend.md](agents/backend.md) |
| `.htaccess` | 1 | web server | [agents/devops.md](agents/devops.md) |

## 2. The storefront — 11 pages, each its own owner

Every root page is a self-contained monolith: it opens its own PDO connection, prints its own HTML and
owns its own copy of any shared behaviour. There is no layout, no template engine and no controller.

| Page | Assets it owns | Notable |
| :--- | :--- | :--- |
| `index.php` | `home.css` `home.js` | requires `includes/shophader.php` + `shopbottomfotoer.php` |
| `shop.php` | `shop.css` `shop.js` | same two fragments; hardcoded 3-slide hero |
| `product.php` | `singleproduct.css` `singleproduct.js` | requires `singelproduthader.php`, `singelprodutbottomfotoer.php`, `product-not-found.php` |
| `cart.php` `checkout.php` `wishlist.php` `about-us.php` | `shop.css` | `cart.php`/`wishlist.php`/`about-us.php` use `singelprodutbottomfotoer.php` |
| `account.php` | **none — everything inline** | a shared-asset fix never reaches it |
| `wholesale.php` `reseller.php` `retailer.php` | `{name}.css` `{name}.js` + `profile-save.js` | 752 KB of JS; the `--ws-*` token block is triplicated |

A change to "the storefront header" therefore has to be made in **two** fragments
(`includes/shophader.php` and `includes/singelproduthader.php`) plus inline copies in `account.php`
and the three B2B pages. [FRONTEND.md](FRONTEND.md), [UI_SYSTEM.md](UI_SYSTEM.md) §7.

## 3. The admin console — 542 files in 26 module directories

Seven large modules hold 441 of the 542 files and **each already has a `README.md`** — read it before
changing that module, and update it rather than writing a second description:

| Module | Files | README |
| :--- | ---: | :--- |
| `admin/wholesale/` | 75 | `admin/wholesale/README.md` |
| `admin/products/` | 74 | `admin/products/README.md` |
| `admin/resellers/` | 67 | `admin/resellers/README.md` |
| `admin/retail/` | 59 | `admin/retail/README.md` |
| `admin/orders/` | 59 | `admin/orders/README.md` |
| `admin/catalogue/` | 59 | `admin/catalogue/README.md` |
| `admin/customers/` | 48 | `admin/customers/README.md` |

The remaining 101 files: `settings/` `pricing/` `inventory/` 7 each; `whatsapp/` `users/` `system/`
`shipping/` `reports/` `payments/` `marketing/` `cms/` 6 each; `reviews/` `notifications/` 5;
`media/` `Includes/` 4; `dashboard/` 3; `Asset/` 2; `login/` 1; and **8 files at the root of
`admin/`** — `index.php`, `admin.php`, `orders.php`, `products.php`, `categories.php`, `login.php`,
`adminlogin.php`, `logout.php`.

### 3.1 The canonical module shape

`admin/orders/` is the reference layout; the other six large modules follow it:

```
admin/orders/
  README.md
  index.php  view.php  export.php  invoice.php  ledger.php  packing-slip.php  shipping-label.php
  pending.php confirmed.php processing.php packed.php shipped.php out-for-delivery.php
  delivered.php cancelled.php failed.php refunded.php refunds.php returned.php returns.php
  components/   22 partials — order-table, order-drawer, order-stats, invoice-preview, …
  assets/css/   7 files    — orders.css, order-list.css, order-view.css, …
  assets/js/    9 files    — orders.js, order-list.js, bulk-actions.js, …
```

**A status page is a filter, not a feature.** `pending.php` … `refunded.php` are thin wrappers around
the same `components/order-table.php`. Fixing a column means editing the component once — and it means
a bug in that component appears on 13 pages at once.

**Module assets are module-local.** `admin/wholesale/assets/css/wholesale.css` is a *different file*
from `assets/css/wholesale.css`. The storefront path is a substring of the admin one, so a basename
grep reports 29 referrers for a file that has 1. Always match the full `href`.
[UI_SYSTEM.md](UI_SYSTEM.md) §7.

## 4. `src/` — the service layer, 7 classes, 4,007 lines

| Class | Owns | Do not touch without reading |
| :--- | :--- | :--- |
| `ProductCatalog.php` | catalogue read/write, media typing, drafts | [BACKEND.md](BACKEND.md) §5 — the most remediated file in the repo |
| `OrderManager.php` | order create/read; **the money trust boundary** | [API.md](API.md) §5 and [DECISIONS.md](DECISIONS.md) D-4 |
| `Auth.php` | customer + admin sign-in | [SECURITY.md](SECURITY.md) SEC-2 — the master credential is deliberate |
| `CustomerManager.php` | customer CRUD, the tier-approval switch | [BACKEND.md](BACKEND.md) §6 — the honest-failure pattern |
| `Database.php` | the PDO singleton and mock mode | 96 files require it |
| `DiscountEngine.php` | storefront coupons | duplicated rule — see `OrderManager::resolveCouponDiscount()` |
| `PricingCalculator.php` | GST + order totals | 52 lines; **the only server-side pricing authority** |

All static, `namespace DTBrand;`, **no autoloader** — every consumer writes its own `require_once`.

## 5. `api/` — 22 flat files, no router

Grouped by who calls them, because that determines what a change can break:

| Group | Files | Called by |
| :--- | :--- | :--- |
| storefront-facing | `cart.php` `wholesale.php` `reseller.php` `search.php` `wishlist.php` `auth.php` `orders.php` (create) | browser JS on the 11 pages |
| admin-facing | `products.php` `customers.php` `customer_notes.php` `categories.php` `coupons.php` `reviews.php` `brands.php` `attributes.php` `upload.php` `whatsapp.php` `orders.php` (read/update) | `admin/**` JS |
| operational | `db_audit.php` `db_health.php` `health.php` | run by hand; **`db_audit.php` creates 16 tables** |
| infrastructure | `_guard.php` `index.php` | the guard; a directory listing where 14 of 15 paths are fictional |

`orders.php` sits in two groups on purpose: create is public, every bulk read is behind
`dt_api_require_admin()`. Endpoints that mix a public read with an admin write call the guard **per
action** — do not lift it to the top of the file. [API.md](API.md) §3.

## 6. Fragment libraries — two traps

**`includes/` — 11 files, and the misspelled ones are the live ones.** Verified by grepping each
`require`:

| Live (5) | Required by |
| :--- | :--- |
| `shophader.php` | `index.php`, `shop.php` |
| `shopbottomfotoer.php` | `index.php`, `shop.php` |
| `singelproduthader.php` | `product.php` |
| `singelprodutbottomfotoer.php` | `about-us.php`, `cart.php`, `product.php`, `wishlist.php` |
| `product-not-found.php` | `product.php` |

**Unreachable (6), 21,598 B:** `header.php`, `footer.php`, `shopheader.php`, `shopfooter.php`,
`subnav.php`, `mobile_bottom_nav.php`. The correctly-spelled `shopheader.php` / `shopfooter.php` are
the dead ones; `shophader.php` / `shopbottomfotoer.php` are live. **Do not "fix the typo" by
deleting or renaming** — renaming requires editing the two pages in the same commit.

**`shared/` — 29 PHP files, 8 live and 21 dead (284,436 B).**

| Live | Requirers |
| :--- | ---: |
| `shared/cart.php` · `shared/wishlist.php` | 10 each |
| `shared/checkout.php` | 9 |
| `shared/account.php` · `shared/quickview.php` · `shared/reels.php` · `shared/smartshare.php` · **`shared/size_chart_modal.php`** | 6 each |

**Dead (21):** `Auth/myaccount.php`; **all 10 files in `shared/Includes/`** (`account` `cart`
`checkout` `db` `logger` `quickview` `reels` `sentry` `smartshare` `wishlist`); and
`auth_modal.php` `cart_drawer.php` `checkout_modal.php` `db.php` `logger.php` `quickview_modal.php`
`reels_modal.php` `sentry.php` `smart_share_modal.php` `wishlist_drawer.php`.

**The trap:** every `*_modal.php` is dead **except `size_chart_modal.php`**, which is live on 6
pages. A rule like "delete the unused modal partials" breaks the product page. And `shared/db.php`
and `shared/logger.php` are dead *files*, not dead *ideas* — `Database.php` is the live equivalent,
so deleting them removes nothing that works.

The 18 images under `shared/Asset/images/` (`product1..8` in png+webp, `logo.png`, `profile.png`) are
the **seed placeholders**. `ProductCatalog::create()` used to default a missing photo to
`product1.png`; that was removed. They are still referenced by fabricated demo data in the B2B JS —
[KNOWN_ISSUES.md](KNOWN_ISSUES.md).

## 7. `config/` — 8 files, 1 of them read

| File | Readers |
| :--- | :--- |
| `config/shipping.php` | **2** — `api/cart.php:94` and `admin/products/components/product-shipping.php:25` |
| `app.php` `auth.php` `database.php` `mail.php` `payment.php` `services.php` `whatsapp.php` | **0** |

There is **no `.env` loader anywhere in the project.** Setting a `.env` file has no effect; only real
process environment variables reach `getenv()`. `config/database.php` is read by nothing and contains
live credentials — the cleanest single deletion in the repo, and it belongs to
[SECURITY.md](SECURITY.md) SEC-1 rather than to a cleanup task.

## 8. `database/` — three competing authorities

| File | What it is |
| :--- | :--- |
| `database/arniya_master_production.sql` | the **live** schema + every seed row. 18 tables. Also web-served with no deny rule — [SECURITY.md](SECURITY.md) SEC-4 |
| `database/migrate.php` | the PHP migrator the user runs on live |
| `database/migrations/2026_08_23_000001_create_initial_schema.sql` | GEN-A era |
| `database/migrations/2026_08_24_000001_full_production_schema.sql` | GEN-A era |
| `database/migrations/2026_08_25_production_upgrade.sql` | **never runs** — its columns are phantom |
| `database/schema.sql` · `database/seeders.sql` | earlier drafts |

Which of these has actually run on live is **unresolved** — it needs a `SHOW TABLES` from the owner.
Until then, treat `arniya_master_production.sql` as the only authority and any column that appears
solely in `2026_08_25_production_upgrade.sql` as absent. [DATABASE.md](DATABASE.md) §1.

## 9. Files with more than one owner

These are the places where a change needs two briefs at once. They are the usual source of a fix that
works on one surface and breaks another:

| File | Owners | Why |
| :--- | :--- | :--- |
| `assets/css/main.css` · `assets/css/header.css` | storefront **and** admin | each is linked by `admin/categories.php`, `admin/orders.php`, `admin/products.php` |
| `src/OrderManager.php` | backend + api + database + security | the money boundary, the stock decrement and the customer counters all live in one loop |
| `src/Auth.php` | backend + security + admin | one file authenticates both customers and staff |
| `api/orders.php` | api + admin + storefront | public create, public tracking, admin bulk read, all in one file |
| `admin/Includes/adminheader.php` · `adminfooter.php` | admin + ui-ux + cleanup | included by ~190 pages; both contain fabricated display values |
| `config/shipping.php` | backend + business logic | the freight authority for one API and one admin component; two browser copies mirror it |
| `shared/quickview.php` | frontend + business logic | live on 6 pages and holds `QV_FREE_SHIP_OVER = 1999` |
| `admin/Asset/css/admin.css` | ui-ux + admin | `--adm-sidebar-w` / `--adm-header-h` are a contract with the sidebar JS |

## 10. Code nobody owns — 379,197 B, classified

Every file below was verified by grepping for its own path across all 452 PHP files, excluding
self-references and comment-only mentions.

| Classification | Files | Bytes | Where |
| :--- | ---: | ---: | :--- |
| **UNUSED** — zero requirers | 21 | 284,436 | `shared/` (§6) |
| **UNUSED** | 6 | 21,598 | `includes/` (§6) |
| **UNUSED** | 5 | 73,163 | `assets/js/{modals,core,header}.js`, `assets/css/modals.css`, `shared/quickview_modal.php` |
| **UNUSED** | 7 | — | `config/` except `shipping.php` (§7) |
| **FUNCTIONAL DUPLICATE** | 1 | — | `admin/adminlogin.php` — 738 lines, identical to `login.php` bar comments, **zero inbound links**, still reachable by URL. [SECURITY.md](SECURITY.md) SEC-12 |
| **LEGACY** | 3 | — | `database/schema.sql`, `database/seeders.sql`, `database/migrations/2026_08_25_production_upgrade.sql` |
| **INTENTIONALLY DIFFERENT** | 2 | — | `api/_guard.php` fails **closed**, `admin/Includes/adminguard.php` fails **open**. Deliberate asymmetry — do not "unify" them |
| **UNKNOWN** | 18 | <1,800 | the one-line admin CSS stubs — linked, so not dead; empty, so not doing anything |

**Nothing in this table is authorised for deletion by this document.** The master protocol requires
proof plus an explicit instruction; unresolved cases live in [KNOWN_ISSUES.md](KNOWN_ISSUES.md).

## 11. Rules

1. **Prefix every path with its generation.** `DT Brand/src/...`, never `src/...`.
2. **Read the module `README.md` first** for the seven large admin modules; update it, do not write a
   parallel description.
3. **Verify a reference by full path, not basename.** The admin/storefront collision produces 29×
   false positives, and a "reference" can be a comment — both `modals.js` referrers were comments.
4. **Check §9 before editing.** If a file has two owners, the change needs both briefs.
5. **A component under `components/` is shared by every page in its module.** Editing
   `admin/orders/components/order-table.php` touches 13 pages.
6. **Classify, never delete blind.** EXACT DUPLICATE · FUNCTIONAL DUPLICATE · LEGACY ·
   INTENTIONALLY DIFFERENT · UNUSED · UNKNOWN. Anything that lands in UNKNOWN goes to
   [KNOWN_ISSUES.md](KNOWN_ISSUES.md) with the evidence, and stays on disk.
7. **A misspelled filename is not a bug to fix in passing** — in `includes/` the misspellings are the
   live files.

