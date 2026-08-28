# ARCHITECTURE

> How this system is actually put together, as of 2026-08-29. Claims cite `path:line`.
> Read [PROJECT_MEMORY.md](PROJECT_MEMORY.md) first for the three-generation problem.

---

## 1. Deployment topology

```
GitHub  dtbrand/arniya  (branch: main)
        │
        │  owner commits, then uploads by FTP  (there is no CI deploy)
        ▼
Hostinger shared hosting
        /public_html/            ← the CONTENTS of the repo's  DT Brand/  directory
        MySQL  (name withheld - SEC-1)
        https://jaihanumantex.in
```

There is no build step, no bundler, no `composer install` on the server, no autoloader
generation. PHP files are served directly by Apache; CSS and JS are hand-written and
served as-is. Anything that would need a compile step does not exist here.

## 2. Request lifecycle — storefront

```
GET /product/3
  → DT Brand/.htaccess:13   RewriteRule ^product/([0-9]+)/?$  product.php?id=$1
  → product.php
        require_once __DIR__ . '/src/Database.php'  (plus ProductCatalog etc.)
        Database::getConnection()   → PDO, or NULL + mock mode  (src/Database.php:52)
        renders one monolithic HTML document, inline <script> at the bottom
  → browser then calls  /api/products.php?action=...  for anything dynamic
```

Every storefront page is a single self-contained PHP file that opens its own database
connection, does its own queries and prints its own HTML. There is no controller, no
router, no template engine, no view layer. `includes/header.php` and `includes/footer.php`
are shared fragments; several pages carry their own near-duplicate header instead
(see [FILE_OWNERSHIP.md](FILE_OWNERSHIP.md) F-3).

## 3. Request lifecycle — admin console

```
GET /admin/orders/view.php?id=12
  → DT Brand/admin/orders/view.php
        require_once __DIR__ . '/../Includes/adminguard.php'
              ├─ session_start, requires  $_SESSION['admin_logged_in'] === true
              │                     and   $_SESSION['admin_user']['id']
              ├─ exempts any path containing "login" / "logout"
              ├─ only guards paths containing "/admin"
              └─ catch (\Throwable) → FAILS OPEN  (a guard bug must not lock the owner out)
        require_once __DIR__ . '/../Includes/adminheader.php'   (sidebar + topbar)
        page body
        require_once .../adminfooter.php
```

Guard coverage measured 2026-08-29: **358 of 362** PHP files under `admin/` include the
guard. The four that do not are `admin/adminlogin.php`, `admin/login.php`,
`admin/login/index.php`, `admin/logout.php` — correct, they are the login surface.

## 4. Request lifecycle — JSON API

```
POST /api/orders.php   body: action=create&...
  → api/orders.php
        require_once __DIR__ . '/_guard.php'
        dt_api_require_admin('...')   → 401 JSON + exit   (FAILS CLOSED, api/_guard.php:44)
        Database::getConnection()
        echo json_encode([...])
```

`api/_guard.php` reads the same session keys as the console guard, so one admin login
covers both surfaces. Endpoints that mix a public read with an admin write call
`dt_api_require_admin()` **per action** rather than at the top of the file, so the
storefront keeps working. Full matrix: [API.md](API.md).

## 5. Layering (as built, not as wished)

| Layer | Reality |
| :--- | :--- |
| Presentation | 11 root storefront `.php` files + 362 admin `.php` files. HTML, PHP and inline JS interleaved. |
| "Service" | 7 classes in `DT Brand/src/`. Thin. `PricingCalculator` is 52 lines. |
| Data access | Raw PDO prepared statements, written inline in pages and endpoints as often as in `src/`. |
| Config | 8 files in `DT Brand/config/` returning arrays. **Partly unread** — see [INTEGRATIONS.md](INTEGRATIONS.md). |
| Client state | `localStorage` (`dtbrands_user`, cart, wishlist) — authoritative on the B2B pages. |

There is **no dependency injection, no interface, no repository, no unit of work**. The
`src/` classes are all-static utility holders. Do not introduce a framework layer to
"fix" this during a bug-fix task; see [DECISIONS.md](DECISIONS.md) D-2.

## 6. The two authentication systems

| | Customer / partner | Admin / staff |
| :--- | :--- | :--- |
| Table | `customers` | `users` |
| Entry | `src/Auth.php::login()` (`:192`) | `src/Auth.php::adminLogin()` (`:272`) |
| Session keys | `$_SESSION['user']`, `$_SESSION['user_type']` | `$_SESSION['admin_logged_in']`, `$_SESSION['admin_user']`, `$_SESSION['admin_role']` |
| Gate | **client-side only** on every page — see [SECURITY.md](SECURITY.md) SEC-6 | `admin/Includes/adminguard.php` + `api/_guard.php` |
| DB down | fails closed (`:266`) | master credential accepted offline (`:363`) |

`session_regenerate_id(true)` is called on every successful sign-in (`src/Auth.php:145`,
`:182`, `:239`, `:370`, `:391`). Session cookie flags are never configured — no
`session_set_cookie_params`, so no `HttpOnly`/`Secure`/`SameSite` hardening.

## 7. Where business rules live

Server-side pricing authority is `src/PricingCalculator.php` — 52 lines, three static
methods, GST default 5 %. Every other pricing rule (lot sizes, tier discounts, margin
display, repeat-order totals) lives in **client-side JS**: `assets/js/reseller.js` is
351 KB, `wholesale.js` 204 KB, `retailer.js` 215 KB. A browser can change any of it.
See [BUSINESS_LOGIC.md](BUSINESS_LOGIC.md) for the rules and the divergences found.

## 8. Migration engine

`database/migrate.php` executes exactly one file — `database/arniya_master_production.sql`
(`migrate.php:77-93`) — then runs three idempotent post-steps in order:
`applyColumnUpgrades()` (`:180`), `repairLegacyData()` (`:113`), `ensureAdminUser()` (`:153`).
Its web gate opens only for a signed-in admin **or** a database with zero tables
(`:293-307`); the old `?key=` install literal is gone. CLI: `php database/migrate.php`
applies, `php database/migrate.php status` only lists. Detail: [DATABASE.md](DATABASE.md).
