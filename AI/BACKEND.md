# BACKEND

> `DT Brand/src/` — 7 classes, 4,007 lines total. Measured 2026-08-29.
> This is the entire server-side "service layer". Everything else is a page that queries PDO inline.

---

## 1. The seven classes

`req` = files that `require` it · `use` = files that call `Class::` (excluding comment-only mentions)

| Class | Lines | Bytes | req | use | Role |
| :--- | ---: | ---: | ---: | ---: | :--- |
| `ProductCatalog.php` | 1,739 | 70,147 | 54 | 57 | catalogue read + product/category write. The real workhorse |
| `OrderManager.php` | 832 | 37,429 | 18 | 13 | order create/read/update. Holds the money trust boundary |
| `Auth.php` | 665 | 32,091 | 3 | **3** | customer + admin sign-in. Only `admin/login.php`, `admin/adminlogin.php`, `api/auth.php` call it |
| `CustomerManager.php` | 402 | 18,447 | 29 | 24 | customer CRUD + stats |
| `Database.php` | 182 | 4,965 | 96 | 50 | PDO singleton + mock mode |
| `DiscountEngine.php` | 145 | 5,450 | 3 | **1** | coupons. One caller: `api/cart.php:83` |
| `PricingCalculator.php` | 52 | 1,682 | 7 | 3 | GST + order totals |

All seven are `namespace DTBrand;` with **only static methods** — no constructor, no instance, no
interface, no DI. There is no autoloader: every consumer writes
`require_once __DIR__ . '/../src/X.php';` by hand. `ProductCatalog.php:5` is the only class that
requires a sibling (`Database.php`); everywhere else the *page* must require both, in order.

## 2. `Database.php` — the connection engine

`getConnection()` (`:17`) reads `DB_HOST/DB_PORT/DB_NAME/DB_USER/DB_PASS` through
`getenv() ?: <committed literal>` (`:23-27` — see [SECURITY.md](SECURITY.md) SEC-1), then tries
`[$host, 'localhost', '127.0.0.1']` in order (`:29-35`). On total failure it sets
`$isMockMode = true`, leaves `$pdo` null and **returns null** (`:52-54`).

Helpers `query()` `:71` → `[]`, `execute()` `:91` → `false`, `fetchOne()` `:110` → `null` on
failure, each `error_log()`ing the PDO message. Transaction helpers `:131-171` all no-op safely
when `$pdo` is null.

**Two defects, both real:**

1. **No negative memoisation.** `getConnection()` only short-circuits on `self::$pdo !== null`
   (`:19`). In mock mode `$pdo` stays null, so *every* subsequent call re-runs the whole candidate
   loop, and `isMockMode()` (`:60-64`) calls `getConnection()` too. A page that calls
   `Database::query()` 40 times makes 40 × 2-3 TCP connection attempts while MySQL is down. This
   is why an outage reads as a hang rather than an error.
2. **Mock mode is indistinguishable from "no rows".** `query()` returns `[]` both for an empty
   table and for a dead database. **Every** caller must therefore gate on
   `$db !== null && !Database::isMockMode()` before believing an empty result. Most of `src/` now
   does; inline page queries frequently do not. [PROJECT_MEMORY.md](PROJECT_MEMORY.md) M-8.

## 3. `Auth.php` — 17 methods, two authentication systems, three dead ones

| Method | Line | Note |
| :--- | ---: | :--- |
| `initSession()` | 14 | `session_start()` if not already started. No cookie params set |
| `register()` | 24 | a requested trade tier is stored `status='pending'` (`:77-96`); refuses B2B with no DB (`:165`) |
| `login()` | 192 | customer. Requires `status='active'`, bcrypt only, **no bypass**, fails closed (`:266`) |
| `adminLogin()` | 272 | staff. See the master-credential note below |
| `startAdminSession()` | 383 | private. Sets `admin_logged_in`, `admin_user`, `admin_role` |
| `ensureUsersTable()` | 417 | private. `CREATE TABLE IF NOT EXISTS users` on demand |
| `logout()` / `adminLogout()` | 442 / 452 | |
| `getCurrentUser()` `isLoggedIn()` `isAdminLoggedIn()` | 463-481 | session readers |
| `updateProfile()` | 490 | |
| `changePassword()` | 533 | verifies the current password first |
| `requestPasswordReset()` | 572 | writes `reset_token`/`reset_expires`; **nothing delivers the mail** |
| `generateCsrfToken()` | 618 | **DEAD — zero callers** |
| `validateCsrfToken()` | 630 | **DEAD — zero callers** |
| `canAccessOrder()` | 642 | **DEAD — zero callers, and `return true` when the DB is unreachable (`:662`)** |

`session_regenerate_id(true)` fires on every successful sign-in (`:145`, `:182`, `:239`, `:370`,
`:391`) — correct. Session cookies are never configured (no `HttpOnly`/`Secure`/`SameSite`).

**The master credential.** `adminLogin()` reads `$bootstrapEmail` (`:285`) and
`$bootstrapPass = getenv('ADMIN_PASSWORD') ?: <committed literal>` (`:286`), then
`$isMaster = ($email === $bootstrapEmail && hash_equals($bootstrapPass, $password))` (`:301`).
When `$isMaster` is true the `users` row is **re-stamped on every sign-in** — password hash,
`role='super_admin'`, `status='active'` (`:317-334`) — and if the database is unreachable the
session is granted anyway (`:363`). That is deliberate owner-lockout insurance, and it is also a
permanent repo-committed skeleton key: rotating the DB password or suspending the admin row does
not revoke it. [SECURITY.md](SECURITY.md) SEC-2, [AUDIT_REPORT.md](AUDIT_REPORT.md) C-1.

## 4. `OrderManager.php` — the trust boundary, and one fabrication

**Write path — hardened, but not completely. Do not "simplify" what is there.** `createOrder()`
(`:189`) re-derives everything that touches the *unit* price: `resolveChannel()` `:66`,
`priceColumnFor()` `:118`, `resolveItemPrices()` `:136`, `resolveCouponDiscount()` `:19`, and it
overwrites a posted `customer_id` from the session (`:315-317`). Full reasoning in
[API.md](API.md) §5 and [DECISIONS.md](DECISIONS.md) D-4. It also defends against schema drift with
`ordersHasColumn()` `:503` / `tableHasColumn()` `:523` before writing optional columns.

**It stops short of the total.** `$shipping` (`:296`), `$gstRate` (`:297`),
`$paymentStatus` (`:310`, default `'paid'`) and `$fulfillmentStatus` (`:311`, default `'confirmed'`)
are taken from the request unchecked, and `PricingCalculator::calculateOrderTotal()` puts no floor on
shipping or on `grand_total` (`PricingCalculator.php:40`). On the intentionally-public create path a
posted `gst_rate: 0` removes the tax and a negative `shipping` drives the total below zero; a negative
`gst_rate` is the one variant that *is* rejected, because `calculateGst()` throws (`:27-29`). Detail and
the fix in [API.md](API.md) §5.1 — this is the highest-value outstanding fix in `src/`.

**Read path — `getAll()` (`:600`) invents display data.** On the real-database branch it maps each
row but hardcodes `items_count => '1 lot'` (`:621`) and `items_summary => 'Ethnic Silk Sarees'`
(`:622`) without reading `order_items` at all, defaults a missing phone to the brand's own number
(`:619`), and — the serious one — synthesises
`'tracking' => $r['tracking_number'] ?? ('DEL-' . rand(10000, 99999))` (`:627`). An untracked
order therefore shows a plausible, random, **different-on-every-refresh** courier tracking ID that
an admin can read out to a customer.

And when the query returns nothing — empty `orders` table **or** dead database — it returns two
fully-formed demo orders (`:638-675`): `DT-ORD-90281` / 'Radhika Sarees Emporium' / ₹44,688 /
`DEL-94028491`, and `DT-ORD-89412` / 'Pooja Sharma' / ₹8,399 / `BD-84920194`.

`getAll()` has **13 call sites** — so those two fake orders, and the random tracking numbers, feed:

| Consumer | Line |
| :--- | :--- |
| `admin/orders/components/order-stats.php` | `:15` |
| `admin/orders/components/order-table.php` | `:15` |
| `admin/orders/index.php` (total-orders count) | `:43` |
| `admin/orders.php` | `:15` — calls `getAll(['limit' => 50])`; **`getAll()` takes no parameters**, so the limit is silently dropped |
| `admin/payments/index.php` | `:44` |
| `admin/reports/index.php` | `:34` |
| `admin/shipping/index.php` | `:37` |
| `admin/retail/components/retail-data.php` | `:19`, `:78` |
| `admin/wholesale/components/wholesale-stats.php` | `:30` |
| `api/orders.php` | `:150` — admin-guarded at `:131` |

`admin/index.php:35` was deliberately switched **off** `getAll()` for exactly this reason; the
comment there records it. [AUDIT_REPORT.md](AUDIT_REPORT.md) H-1.

**Public order tracking is well built.** `api/orders.php` (above `:131`) requires order number
**and** phone together and returns an identical 404 for "no such order" and "wrong phone"
(`:118-121`), so it cannot be used to enumerate orders. Everything that reads orders in bulk sits
behind `dt_api_require_admin('read order records')` (`:131`).

## 5. `ProductCatalog.php` — the most remediated file in the repo

47 methods. Its comments are a written record of fabrication that was removed, and they are worth
reading before touching it — e.g. `getAll()` (`:311`) used to serve an 11-product hardcoded
catalogue when MySQL was down (`:320-323`), `create()` (`:937`) used to default a missing price to
6500/4899/1399 and a missing photo to `product1.png` (`:929-936`), `getReviews()` (`:502`) replaced
seven hardcoded named reviews shown on every product, `reviewBreakdown()` (`:536`) replaced a fixed
88/9/2/1/0 histogram, and `adjustStock()` (`:1322`) used to answer `max(0, 50 + $delta)` for a
product it had never read.

Behaviours a future agent must preserve:

- **Media typing.** `mediaPath()` `:32` rejects `data:` URLs (they truncate in
  `primary_image VARCHAR(255)`) and rewrites the dead seed path `/Frontend/Shop/Asset/images/` →
  `/assets/images/`. `isVideo()` `:55` classifies by extension, `isEmbed()` `:67` by host, and
  `embedUrl()` `:86` converts YouTube/Instagram/Vimeo watch links into player URLs — a raw
  `youtube.com/watch` URL in an `<iframe src>` is refused by YouTube itself.
- **`is_primary` may only land on a photo** (`syncMedia()` `:777`), or a card renders a clip in an
  `<img>`.
- **Drafts.** `PUBLIC_STATUSES` `:17` is `in_stock,low_stock,out_of_stock`; the previous filter was
  `status != 'trash'`, and `trash` is not in the ENUM, so drafts were live on the storefront.
- **Counters are ignored, not trusted.** `products.rating`/`reviews_count` DEFAULT to 4.9/120 and
  `categories.products_count` is seeded with numbers like 840; `sideTables()` `:175` and
  `getCategoriesWithDetails()` `:439` recompute both from `reviews` and `products`.
- **Per-request memo** `self::$memo` `:20`; every write path calls `invalidateCache()` `:23`.
- **`deleteCategory()` `:1581` refuses while products still reference the category** —
  `products.category_id` has no foreign key, so the rows would otherwise be orphaned but still
  on sale.

## 6. `CustomerManager.php` — the honest-failure pattern

Nine methods, and the file's header comment (`:11-15`) records that a hardcoded customer roster was
removed because it put invented names and **real-format phone numbers** in front of an admin who
could click "WhatsApp Connect" and message a stranger.

Every method returns failure rather than a plausible lie when the database is unreachable:
`getAll()` → `[]` (`:20-26`), `create()` → `success:false` (`:161-165`), `update()` → `false`
(`:224-229`, because `admin/customers/edit.php` only navigates away on success),
`updateStatus()` → `false` (`:320-324`, because this is the switch that grants trade pricing),
`updateCreditLimit()` → `false` (`:354`).

Two details worth keeping:

- **ENUM whitelists before every write** (`:132`, `:139`, `:239-244`, `:315`). Outside strict mode
  MySQL coerces an unknown ENUM value to `''` while `execute()` still returns `true` — which would
  silently blank a customer's account type and read back as success.
- **`rowCount() === 0` is disambiguated** everywhere (`:264-270`, `:329-337`, `:361-367`): zero rows
  means either "no such customer" or "the value already matched", and only the second is a success.
- `create()` never falls back to a shared literal password — an absent one becomes
  `bin2hex(random_bytes(18))` (`:155-158`), forcing the reset flow. It also writes the street
  address into `addresses` (`:189-211`), because `customers` has no address columns, and reports a
  **partial** result if that second insert fails.

## 7. `PricingCalculator.php` + `DiscountEngine.php` — and the duplicate coupon rule

`PricingCalculator` is 52 lines and three methods: `calculateWholesalePrice()` `:14`,
`calculateGst()` `:25` (default 5 %), `calculateOrderTotal()` `:36` → `subtotal, discount, taxable,
gst, gst_amount, shipping, grand_total`, with `taxable = max(0, subtotal - discount)` `:38`. Three
callers: `api/cart.php:101`, `api/wholesale.php:68`, `OrderManager.php:299`. **This is the only
server-side pricing authority in the project** — lot sizes, tier discounts, margin display and
repeat-order totals all live in client-side JS ([BUSINESS_LOGIC.md](BUSINESS_LOGIC.md)).

`taxable` is the **only** clamped value. `calculateGst()` rejects a *negative* rate by throwing
`InvalidArgumentException` (`:27-29`), so that variant fails loudly rather than silently — but there is
no upper bound, and `$grandTotal = round($taxable + $gst + $shipping, 2)` (`:40`) has no `max(0, …)`,
so a negative `shipping` reaching it from a request produces a negative order total. `api/cart.php`
passes a hardcoded `5.0` and a config-derived shipping value and is safe; `OrderManager.php:296-297`
passes both straight through from the request. [API.md](API.md) §5.1.

`DiscountEngine::applyCoupon()` (`:46`) is the *storefront* coupon path and has exactly one caller,
`api/cart.php:83`. It queries `coupons WHERE code = ? AND status = 'active'` (`:62`), enforces
`min_order_value`, caps percentages at `max_discount`, and — when connected — treats "no such row"
as authoritative (`:96-100`). When MySQL is unreachable it falls back to a three-entry in-memory
dictionary (`:19-38`: `FESTIVE25`, `VIPRESELLER`, `BULK50`) that mirrors the live seed.

**Coupon logic exists twice.** `OrderManager::resolveCouponDiscount()` (`:19`) implements the same
rule independently for the order path and additionally clamps the discount to the subtotal (`:54`).
The two must be changed together. The `$channel` parameter on `applyCoupon()` is vestigial — the
live `coupons` table has no channel column and the parameter no longer filters (`:43-45`); `cart.php`
still passes `$userType` into it.

## 8. Conventions to follow when adding backend code

- `namespace DTBrand;`, static methods, no constructor. Do **not** introduce a container, a
  repository or an ORM inside a bug-fix task — [DECISIONS.md](DECISIONS.md) D-2.
- `require_once __DIR__ . '/../src/X.php';` for **every** class you touch, in dependency order.
  There is no autoloader on the server.
- Gate on `$db !== null && !Database::isMockMode()` before trusting an empty result.
- Return `['success' => false, 'message' => …]` on failure. Never report success for a write that
  did not happen, and never invent a display value to fill a gap — an empty field an admin can see
  is worth more than a plausible one.
- Prepared statements only. Where a list must be interpolated (`sideTables()` `:142`), cast every
  element with `intval` first.
- `catch` and `error_log()`; do not echo `$e->getMessage()` to a client. Four API files still do —
  [API.md](API.md) §7.



