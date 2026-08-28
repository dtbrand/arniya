# AGENT BRIEF · BACKEND

> **Scope:** `DT Brand/src/` — 7 classes, 4,007 lines — and `DT Brand/config/`. The HTTP surface that
> calls them is [api.md](api.md); schema is [database.md](database.md); the money rules themselves are
> [BUSINESS_LOGIC.md](../BUSINESS_LOGIC.md).
>
> Read with [BACKEND.md](../BACKEND.md) and [DECISIONS.md](../DECISIONS.md) D-2, D-4, D-5, D-11.

---

## 1. The seven classes

| Class | Owns | Before touching |
| :--- | :--- | :--- |
| `Database.php` | the PDO singleton + mock mode | **96 files require it** |
| `ProductCatalog.php` | catalogue read/write, media typing, drafts | the most remediated file in the repo |
| `OrderManager.php` | order create/read — **the money trust boundary** | D-4, then [API.md](../API.md) §5 |
| `Auth.php` | customer **and** admin sign-in | SEC-2 — the master credential is deliberate (D-6) |
| `CustomerManager.php` | customer CRUD, the tier-approval switch | the honest-failure pattern, §3 below |
| `PricingCalculator.php` | GST + order totals — **the only server-side pricing authority**, 52 lines | D-11 |
| `DiscountEngine.php` | storefront coupons | duplicated rule — see `OrderManager::resolveCouponDiscount()` |

All static, all `namespace DTBrand;`, **no autoloader**. Add a class the same way and require it
explicitly, in dependency order, at every consumer. Do not introduce a container, ORM, repository layer
or composer autoload inside another task (D-2).

`config/` is 8 files and **only `shipping.php` is read** — by `api/cart.php:94` and
`admin/products/components/product-shipping.php:25`. The other seven have zero readers, and
`config/database.php` leaks credentials for no purpose (SEC-1).

## 2. Mock mode is the thing that will mislead you

`Database::getConnection()` short-circuits only on `self::$pdo !== null` (`:19`). In mock mode `$pdo`
stays null, so **every call re-runs the whole `[$host, 'localhost', '127.0.0.1']` candidate loop** — and
`isMockMode()` (`:60-64`) itself calls `getConnection()`. A page that queries 40 times makes 40 × 2-3 TCP
connection attempts while MySQL is down: **an outage presents as a hang, not an error.**

And `Database::query()` returns `[]` for an empty table **and** for a dead database. So every caller must
gate on `$db !== null && !Database::isMockMode()` before believing an empty result. `src/` mostly does;
inline page queries frequently do not (D-5, KI-3).

## 3. Two patterns to copy exactly, not simplify

**The money boundary — `OrderManager::createOrder()`.** Order creation is public by design (there is no
payment gateway; orders settle offline), so the request is treated as hostile and every value that touches
money is re-derived server-side:

| Value | Re-derived by |
| :--- | :--- |
| channel / tier | `resolveChannel()` `:66-112` — re-read from `customers.type`, `status='active'` required; unverifiable → `retail` |
| unit price | `resolveItemPrices()` `:136` — from `products.{retail\|wholesale\|reseller}_price` via the fixed whitelist in `priceColumnFor()` `:118-127`, **never interpolated** |
| subtotal | accumulated server-side `:247`, then `PricingCalculator::calculateOrderTotal()` `:299` |
| coupon | `resolveCouponDiscount()` `:19` — re-reads the row, enforces `min_order_value`, caps at `max_discount`, clamps to subtotal `:54` |
| customer | a posted `customer_id` is overwritten from the session for a signed-in non-admin caller `:315-317` |

**`unit_price`, `total_amount` and `channel` must never come from the request.** The hardening is
incomplete, not wrong: `shipping` (`:296`), `gst_rate` (`:297`), `payment_status` (`:310`) and
`fulfillment_status` (`:311`) are still taken raw — SEC-5, the highest-value outstanding fix in `src/`.

**The honest-failure pattern — `CustomerManager`.** Outside strict mode MySQL coerces an unknown ENUM to
`''` while `execute()` still returns `true`, so every ENUM is whitelisted before writing (`:132`, `:139`,
`:239-244`, `:315`), and `rowCount() === 0` is disambiguated (`:264-270`, `:329-337`, `:361-367`) — zero
rows means *either* "no such customer" *or* "the value already matched", and only the second is success.

## 4. Known landmines in this domain

- **One order write does three things:** inserts, decrements stock (`:453`), and increments
  `total_orders` / `lifetime_spend` (`:456-466`). `lifetime_spend` accrues regardless of `payment_status`,
  and `outstanding_balance` is never debited. A negative `grand_total` *decreases* lifetime spend.
- **`OrderManager::getAll():627` synthesises `'DEL-' . rand(10000, 99999)`** for untracked orders across
  13 call sites, and returns two complete demo orders when the query is empty (`:638-675`). KI-3a.
- **The coupon cap is duplicated and the two copies disagree.** `DiscountEngine::applyCoupon():81-83` caps
  at `max_discount` only; `OrderManager::resolveCouponDiscount():54` also clamps to the subtotal. With
  `discount_value=150, max_discount=0` the cart quotes 1.5 × subtotal. **Both must change together**
  (KI-14).
- **`!=` is NULL-unsafe.** Use `COALESCE(\`fulfillment_status\`, 'unfulfilled') <> 'cancelled'`.
- **Never delete a `getenv('X') ?: '<literal>'` fallback** before the owner confirms the variable resolves
  on live (D-7). There is no `.env` loader — only real process env vars reach `getenv()`.

## 5. Verification

```bash
/c/xampp/php/php.exe -l "DT Brand/src/OrderManager.php"
```

`php -l` is the whole toolchain for this domain. **No MySQL here**, so no pricing, coupon, stock or counter
behaviour is runtime-verifiable — state that explicitly (KI-22). When a change needs schema, name the
migration the owner must run and stop.

