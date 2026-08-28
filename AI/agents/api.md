# AGENT BRIEF · API

> **Scope:** `DT Brand/api/` — 22 flat PHP files, **no router**. Each file is its own entry point,
> parses its own input and prints its own JSON. The classes behind them are [backend.md](backend.md);
> the schema is [database.md](database.md).
>
> Read with [API.md](../API.md) and [DECISIONS.md](../DECISIONS.md) D-3, D-4.

---

## 1. The 22 files, grouped by who calls them

| Group | Files | Caller |
| :--- | :--- | :--- |
| storefront-facing | `cart.php` `wholesale.php` `reseller.php` `search.php` `wishlist.php` `auth.php` `orders.php` *(create)* | browser JS on the 11 pages |
| admin-facing | `products.php` `customers.php` `customer_notes.php` `categories.php` `coupons.php` `reviews.php` `brands.php` `attributes.php` `upload.php` `whatsapp.php` `orders.php` *(read/update)* | `admin/**` JS |
| operational | `db_audit.php` `db_health.php` `health.php` | run by hand — **`db_audit.php` creates 16 tables** |
| infrastructure | `_guard.php` `index.php` | the guard; and a directory listing where **14 of 15 paths are fictional** |

`orders.php` is in two groups on purpose: **create is public, every bulk read is behind
`dt_api_require_admin()`.** An endpoint that mixes a public read with an admin write calls the guard **per
action** — do not lift it to the top of the file.

## 2. The guard, and why it fails closed here

`api/_guard.php:44-60` — **any doubt → 401 and exit.** This is the opposite of
`admin/Includes/adminguard.php`, which fails **open** so a session hiccup cannot lock the owner out of
their own console. The asymmetry is deliberate: a leaked JSON payload is a data breach, an unloadable
console is a lockout. **Do not unify them** (D-3).

So: a new endpoint that returns anything customer-specific, or writes anything, calls
`dt_api_require_admin()` — or, for a customer-scoped read, derives the customer from the **session**, never
from a query parameter.

## 3. Order creation is public, and that is the design

There is no payment gateway anywhere in the project ([INTEGRATIONS.md](../INTEGRATIONS.md) §5) — orders
settle offline over WhatsApp. So `api/orders.php:202-224` create is intentionally reachable without an
admin session, and `OrderManager::createOrder()` re-derives channel, unit price, subtotal, coupon and
customer server-side (D-4, [backend.md](backend.md) §3).

**The rule that follows: `unit_price`, `total_amount` and `channel` must never come from the request.**
Still taken raw and still open as SEC-5: `shipping` (`:296`), `gst_rate` (`:297`), `payment_status`
(`:310`, defaults to `'paid'` with no ENUM whitelist), `fulfillment_status` (`:311`).

## 4. Rules for adding or changing an endpoint

1. **Copy the shape of an existing file**, including how it emits JSON and how it sets its status code.
   There is no router, no middleware and no shared response helper to lean on.
2. **Guard per action**, not per file (§2).
3. **`api/cart.php:94-100` is the reference implementation for a commercial rule:** read
   `config/shipping.php`, floor it at 0, apply the threshold, pass a fixed rate to `PricingCalculator`.
   Its `:89-93` comment records the bug it replaced — the charge was waived above 999 while the flag
   reported above 2999, and the config file was read by nobody. Copy that shape (D-11).
4. **Never interpolate a column or table name.** Use a fixed whitelist, as `priceColumnFor()` does
   (`OrderManager.php:118-127`).
5. **Distinguish "empty" from "broken" in the response.** `Database::query()` returns `[]` for both an
   empty table and a dead database; gate on `$db !== null && !Database::isMockMode()` before returning an
   empty list as a fact (D-5).
6. **Never synthesise a value to fill a response.** No placeholder name, no invented tracking number.
   `OrderManager::getAll():627` still does this and it is a defect, not a precedent (KI-3a).
7. **Only real columns.** Verify against `database/arniya_master_production.sql` (18 tables) — a column
   that exists only in `database/migrations/2026_08_25_production_upgrade.sql` **does not exist on live**,
   because `migrate.php` never runs that file (KI-4).
8. **No credential, path or schema detail in an error body.** `api/health.php` publicly announces
   `MOCK_FALLBACK_ACTIVE`, which tells an attacker exactly when the offline admin path is live (SEC-9) —
   do not add a second endpoint like it.

## 5. Two endpoints to treat as hazardous

- **`api/db_audit.php` creates 16 tables** when run. It is not a read-only audit, and nothing stops it
  being reached over HTTP.
- **`api/db_health.php`** contains credential fallbacks (`:31-34`) and seeders that KI-2 records as a
  schema-drift hazard; its install key is still published in `MASTER_ARCHITECTURE_AUDIT.md` and `docs/`.

Neither should be reachable without authentication. Flag it; do not silently repurpose either one.

## 6. Verification

```bash
/c/xampp/php/php.exe -l "DT Brand/api/orders.php"
```

That is all that runs here. **No MySQL**, so no endpoint's behaviour is testable in this environment
(KI-22) — describe the request the owner should make on live instead:

```bash
curl -s "https://jaihanumantex.in/api/health.php"
```

Report every contract change as **unverified until the owner uploads**, and name `DT Brand/api/<file>.php`
in the upload list (D-8).

