# API

> `DT Brand/api/` — 22 PHP files: 21 endpoints plus `_guard.php`. Measured 2026-08-29.
> Every endpoint is a flat `.php` file. There is no router, no versioning, no OpenAPI spec.

---

## 1. Conventions

- Transport: `GET` query string or `POST`. Several endpoints accept a JSON request body via
  `file_get_contents('php://input')` and fall back to `$_POST` (e.g. `api/cart.php:27-28`).
- Response: always `application/json; charset=utf-8`, usually
  `{"success": bool, "message": string, ...}`. Not enforced by any shared helper.
- Dispatch: an `action` string (`$_GET['action']` or `$data['action']`), defaulting to `create`
  on `api/orders.php` (`:161`) and to a list read elsewhere.
- **16 of 21 endpoints send `Access-Control-Allow-Origin: *`.** Any origin can call them from a
  browser. Combined with cookie-based sessions this is also why no cross-site write is possible
  *with credentials* (`*` forbids credentialed requests) — but every unauthenticated read is
  world-readable by script.

## 2. Auth matrix

`REQ` = calls to `dt_api_require_admin()` · `IS` = calls to `dt_api_is_admin()` · `CORS` = sends `Allow-Origin: *`

| Endpoint | Bytes | REQ | IS | CORS | Notes |
| :--- | ---: | ---: | ---: | :---: | :--- |
| `_guard.php` | 2,144 | — | — | no | the guard itself, not an endpoint |
| `orders.php` | 10,335 | **4** | 1 | yes | most guarded file. Create is deliberately open — see §5 |
| `db_audit.php` | 27,028 | 1 | 0 | no | **creates 16 tables**. See [DATABASE.md](DATABASE.md) §5 |
| `db_health.php` | 15,325 | 1 | 0 | no | migrator + seeder + can mint an admin + can create an order |
| `products.php` | 9,784 | 1 | 0 | yes | per-action: public read, guarded write |
| `coupons.php` | 7,553 | 1 | 0 | no | per-action |
| `reviews.php` | 6,851 | 1 | 1 | yes | per-action moderation |
| `customers.php` | 6,369 | 1 | 0 | yes | |
| `customer_notes.php` | 6,109 | 1 | 0 | no | writes `customer_notes` |
| `attributes.php` | 5,648 | 1 | 0 | yes | self-creates `product_attributes` (`:42`) |
| `brands.php` | 5,440 | 1 | 0 | yes | self-creates `product_brands` (`:40`) |
| `categories.php` | 4,986 | 1 | 0 | yes | |
| `upload.php` | 4,480 | 1 | 0 | yes | hardened — see §6 |
| `whatsapp.php` | 3,743 | 1 | 0 | yes | self-creates `whatsapp_logs` (`:55`) |
| `auth.php` | 5,388 | **0** | 0 | yes | correct — it *is* the login endpoint |
| `cart.php` | 4,430 | **0** | 0 | yes | **quotes trade prices to anyone** — §4 |
| `wholesale.php` | 3,488 | **0** | 0 | yes | **quotes wholesale lot prices to anyone** — §4 |
| `reseller.php` | 2,226 | **0** | 0 | yes | **quotes reseller price + margin to anyone** — §4 |
| `search.php` | 2,936 | **0** | 0 | yes | public catalogue search, appropriate |
| `wishlist.php` | 1,693 | **0** | 0 | yes | `$_SESSION` only — never writes `wishlist_items` |
| `health.php` | 1,135 | **0** | 0 | no | leaks DB connectivity + SKU count — §4 |
| `index.php` | 1,110 | **0** | 0 | no | directory listing, 14 of 15 paths are fictional — §7 |

**13 of the 21 endpoints** call `dt_api_require_admin()`. The 8 that do not are listed above;
five of those eight are correct by design, three are findings.

## 3. The guard — `api/_guard.php`

```php
dt_api_is_admin()      // $_SESSION['admin_logged_in'] === true && !empty($_SESSION['admin_user']['id'])
dt_api_require_admin() // else: 401 + {"success":false,"error":"unauthorized",...} + exit
```

It **fails closed** (`:44-60`), unlike the console guard which fails open. Same session keys as
`admin/Includes/adminguard.php`, so one admin sign-in covers console and API. Endpoints that mix
a public read with an admin write call it **per action** rather than at the top of the file, so
the storefront keeps working — do not "tidy" that into a file-level call.

## 4. Unauthenticated endpoints — precise exposure

Verified by reading each file; the severity is narrower than it first looks, so state it exactly.

**`api/cart.php`** — takes `user_type` straight from the request body (`:31`) and prices from it
(`:46-50`): `wholesale` → `wholesale_price`, `reseller` → `reseller_price`. No session check.
**`api/wholesale.php`** — `action=calculate_lot` returns `unit_wholesale_price` and lot maths
(`:55`, `:80`) for any `product_id`.
**`api/reseller.php`** — `action=calculate` returns `reseller_price` plus a margin calculation
(`:34-44`) for any `product_id`.

These are **price-list disclosure**, not a purchasing bypass: a competitor or any visitor can
read the mill rate for every SKU with a single unauthenticated request. They **cannot** buy at
that rate — see §5. Recorded as [AUDIT_REPORT.md](AUDIT_REPORT.md) C-2.

**`api/health.php`** — unauthenticated, reports `database_pdo: CONNECTED | MOCK_FALLBACK_ACTIVE`
and `total_skus` (`:27-30`). Tells an attacker when the database is down, which is exactly when
the offline admin path in `src/Auth.php:363` becomes reachable.

**`api/wishlist.php`** — `toggle`/`add`/`remove` operate on `$_SESSION` only (`:25-38`). The
`wishlist_items` table exists and is never written. A signed-in customer's wishlist is lost at
session end. [KNOWN_ISSUES.md](KNOWN_ISSUES.md) KI-5.

## 5. The order-creation trust boundary — hardened, do not "simplify"

`api/orders.php` create (`:202-224`) is intentionally reachable without an admin session: real
customers must be able to check out. The money is safe because `src/OrderManager::createOrder()`
never trusts the request:

- **Channel** — `resolveChannel()` (`:66-112`). An admin session may name any channel (`:75-77`).
  Otherwise the tier is **re-read from `customers.type` with `status='active'` required**
  (`:86-99`); anything unverifiable falls through to `retail` (`:101`, `:104`). `whatsapp` is
  treated as a fulfilment route that prices at retail.
- **Unit price** — `resolveItemPrices()` (`:136`) re-reads `products.{retail|wholesale|reseller}_price`
  from the database via a fixed whitelist column (`priceColumnFor()`, `:118-127`), never
  interpolated from input, and falls back up the ladder so a missing tier price cannot sell at 0
  (`:166-170`).
- **Subtotal** — accumulated server-side from those prices (`:247`), then
  `PricingCalculator::calculateOrderTotal()` (`:299`).
- **Coupon** — `resolveCouponDiscount()` (`:19`) re-reads the `coupons` row, enforces
  `min_order_value`, caps at `max_discount`, and clamps to the subtotal (`:54`). A client-supplied
  `discount` is honoured only in mock mode, clamped to `[0, subtotal]` (`:291-292`).
- **Customer** — a posted `customer_id` is overwritten from the session for a signed-in non-admin
  caller (`:315-317`), so spend cannot be attributed to somebody else.

Any change that lets `unit_price`, `total_amount` or `channel` come from the request re-opens a
priced-at-your-own-rate hole. This is [DECISIONS.md](DECISIONS.md) D-4.

### 5.1 Three inputs the boundary does NOT re-derive

The hardening above covers price, channel, discount and customer. It **stops there**, and the
remaining three inputs feed `grand_total` directly:

```php
$shipping  = (float)($orderData['shipping']  ?? 0.0);     // OrderManager.php:296
$gstRate   = (float)($orderData['gst_rate']  ?? 5.0);     // OrderManager.php:297
$calc = PricingCalculator::calculateOrderTotal($subtotal, $discount, $shipping, $gstRate);  // :299
```

and `PricingCalculator::calculateOrderTotal()` applies **no floor** to shipping and **no ceiling** to
the rate:

```php
$taxable    = max(0, $subtotal - $discount);          // PricingCalculator.php:38  <- clamped
$gst        = self::calculateGst($taxable, $gstRate); // :39   <- throws if $gstRate < 0 (:27-29)
$grandTotal = round($taxable + $gst + $shipping, 2);  // :40                       <- no max(0, …)
```

So on the deliberately-public create path (`:202-224`, no admin session required):

| Posted field | Effect | Severity |
| :--- | :--- | :--- |
| `gst_rate: 0` | `gst_amount` becomes 0 — a 5 % discount on every order | **HIGH** |
| `shipping: -50000` | added raw to `grand_total`, which can go **negative** | **HIGH** |
| `payment_status: 'paid'` | written as posted, **no ENUM whitelist** — and it is also the **default** (`:310`) | **HIGH** |
| `fulfillment_status: 'confirmed'` | written as posted, no whitelist, default `'confirmed'` (`:311`) | MEDIUM |
| `gst_rate: -100` | **blocked** — `calculateGst()` throws, `api/orders.php:227` returns 500, no row written | — |

The negative-rate case is worth stating precisely because it looks like the worst one and is not:
`calculateGst()` validates `$gstRate < 0` and `$amount < 0` (`:27-29`) and `calculateWholesalePrice()`
validates its own range (`:16-18`). `$shipping` is the input nobody checks — it reaches `:40` raw from
`OrderManager.php:296`.

`payment_status` defaulting to `'paid'` is defensible for a business that settles offline — there is no
payment gateway at all ([INTEGRATIONS.md](INTEGRATIONS.md) §5) — but combined with an unauthenticated
create it means a stranger can insert a paid, confirmed order for ₹0 or less.

Fix, in the same style as the existing hardening: clamp `$gstRate` to a whitelist (`0, 5, 12, 18`) or
to a fixed 5.0 for non-admin callers; derive `$shipping` server-side from
`config/shipping.php`'s `free_shipping_threshold` / `standard_rate` instead of accepting it; add
`max(0, …)` to `$grandTotal`; whitelist both status ENUMs the way `CustomerManager` already does; and
force `payment_status = 'pending'` unless an admin session is present. `api/cart.php:101` already
passes a hardcoded `5.0` and is not affected.

## 6. `api/upload.php` — the one fully hardened write path

`dt_api_require_admin('upload media')`; `finfo` MIME allowlist (`image/jpeg|png|webp|gif`,
`video/mp4`); **the file extension is derived from the verified MIME, never from the client
filename** (the file documents the prior RCE it replaced); 10 MB image / 25 MB video caps;
filename `dt_{Ymd_His}_{8 hex}.{ext}`; destination `assets/images/uploads`; and it writes a
defensive `.htaccess` there on every run (`php_flag engine off` plus a `FilesMatch` deny for
`php|php[0-9]|phtml|phar|pl|py|cgi|asp|aspx|sh`).

Only defect: the `catch (\Throwable)` returns `'Upload Exception: ' . $e->getMessage()` to the
client. Use this file as the template for any new upload path.

## 7. Contract drift

- **`api/index.php` advertises 15 endpoints; 14 do not exist.** It lists directory-style paths
  (`/api/products/index.php`, `/api/orders/index.php`, `/api/payments/index.php`,
  `/api/shipping/index.php`, `/api/media/index.php`, `/api/notifications/index.php`, …). The only
  real one is `/api/health.php`. There are no subdirectories under `api/` at all.
- **`brands.php` / `attributes.php` invent their own tables.** They `CREATE TABLE IF NOT EXISTS
  product_brands` (`:40`) and `product_attributes` (`:42`) — different names from the `brands` /
  `attributes` that `api/db_audit.php` creates and that `api/db_health.php` seeds. The brands
  feature is therefore split across two table names, and `admin/products/brands/*.php` reads a
  third possibility. Nothing reconciles them.
- **Error bodies leak internals.** `api/orders.php:227-229`, `api/cart.php:118`,
  `api/search.php:87` and `api/upload.php` all return `$e->getMessage()` verbatim. `src/Auth.php`
  was already corrected to log instead (`:157`, `:258`, `:604`); these files were not.
- **No CSRF token on any endpoint.** `Auth::generateCsrfToken()` / `validateCsrfToken()` exist at
  `src/Auth.php:618` / `:630` with **zero callers**. Mitigated in practice only by
  `Allow-Origin: *` forbidding credentialed cross-origin requests — that is not a CSRF defence
  for form posts. [SECURITY.md](SECURITY.md) SEC-8.
