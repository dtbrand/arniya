# BUSINESS LOGIC

> Every commercial rule in ARNIYA: who gets which price, how freight and GST are computed, how
> coupons and lots work, and — the part that matters most — **which of those rules the server
> actually enforces and which live only in browser JavaScript.** Measured 2026-08-29 by reading
> source. No rule here was tested against the live database.

---

## 1. The commercial model

One catalogue, **three price tiers**, sold to three audiences from the same `products` row:

| Tier | Column | Audience | Storefront page |
| :--- | :--- | :--- | :--- |
| Retail | `retail_price` | walk-up consumers | `shop.php`, `product.php`, `retailer.php` |
| Wholesale | `wholesale_price` | mills and bulk buyers | `wholesale.php` |
| Reseller | `reseller_price` | resellers who mark up and resell | `reseller.php` |

`products` also stores `mrp` (the printed MRP, used only to *derive* a displayed discount
percentage — never to price an order) and four lot sizes: `moq_single` 1, `moq_half_set` 4,
`moq_full_set` 8, `moq_master_bale` 24 (defaults from
`database/arniya_master_production.sql`).

**A tier is a property of the customer row, not of the request.** `customers.type` is
`ENUM('retail','wholesale','reseller')` and `customers.status` is
`ENUM('active','pending','suspended')`. Both are required for trade pricing:

- `Auth::register()` (`src/Auth.php:63-96`) **records** a requested trade tier but writes
  `status='pending'`, and its own comment says why: the previous version took `$data['type']`
  from the request and wrote it `active`, "which meant any visitor could pick 'Wholesaler' in the
  storefront role selector and immediately buy the whole catalogue at wholesale prices". Retail
  signup still activates immediately (`:92-95`). An already-approved B2B row is never demoted
  back to pending when the customer claims it (`:77-87`).
- `Auth::login()` (`:192`) accepts **only** `status='active'`, so a pending trade account is inert.
- `CustomerManager::updateStatus()` is therefore the switch that grants trade pricing, which is
  why it returns `false` rather than a plausible success when the database is unreachable
  ([BACKEND.md](BACKEND.md) §6).
- `OrderManager::resolveChannel()` (`:66-112`) re-reads `customers.type` with `status='active'`
  required at order time. Anything unverifiable falls through to `retail`.

So the trade gate is **two locks, both server-side**: an admin must flip `status` to `active`, and
the order path re-checks it. What is *not* server-side is the price the browser **shows** — see §2.

## 2. Where the rules live — 52 lines of server against 752 KB of browser

This is the single most important fact in this document.

**The entire server-side pricing authority is `src/PricingCalculator.php` — 52 lines, three
methods**, plus the parts of `OrderManager` and the three calculation endpoints that call it:

| Rule | Server-side? | Where |
| :--- | :---: | :--- |
| Which tier column to read | **yes** | `OrderManager::resolveChannel()` `:66`, `priceColumnFor()` `:118` |
| Unit price | **yes** | `OrderManager::resolveItemPrices()` `:136` — re-read from `products` |
| Subtotal | **yes** | accumulated at `OrderManager.php:247` |
| Coupon discount | **yes** | `resolveCouponDiscount()` `:19` / `DiscountEngine::applyCoupon()` `:46` |
| GST amount | **yes** | `PricingCalculator::calculateGst()` `:25` |
| Lot size / MOQ enforcement | **yes** | `api/cart.php:54-60`, `api/wholesale.php:41-53` |
| Freight | **yes on the cart, no on the order** | `api/cart.php:94-100` reads config; `OrderManager.php:296` takes it from the request |
| GST **rate** | **no** | `OrderManager.php:297` takes it from the request |
| Reseller margin | **yes** | `api/reseller.php:18` clamps to `[5, 50]` |
| Tier discount ladders, badges, "you save" | **no** | client JS — and `reseller.js` has **two conflicting ladders**, see below |
| Repeat-order totals | **no** | client JS |
| Proforma / invoice figures | **no** | client JS |
| Margin dashboards | **no** | client JS |

Against that, the three B2B pages ship **752 KB of JavaScript** that computes commercial numbers in
the browser and, in several places, invents them:

| File | Bytes | Lines |
| :--- | ---: | ---: |
| `assets/js/reseller.js` | 351,469 | 6,032 |
| `assets/js/retailer.js` | 214,923 | 3,590 |
| `assets/js/wholesale.js` | 204,015 | 3,408 |
| `assets/js/modals.js` | 42,584 | 923 |
| `assets/js/profile-save.js` | 8,064 | 190 |

The consequence to hold on to: **a number a B2B customer sees on screen was very often not produced
by the server and is not what the order row will say.** When those two disagree, the order row is
right. Any work on a commercial figure must start by asking which side computed it.

**And in `reseller.js` the browser copy disagrees with itself.** `getWholesaleTier()` is declared twice:

| | `:840` — shadowed, never runs | `:3083` — the live one |
| :--- | :--- | :--- |
| Tier 5 | `>= 800` orders, `15%` | `>= 1000` orders, `15% Margin Rebate` |
| Tier 4 | `>= 450`, `12.5%` | — |
| Tier 3 | `>= 250`, `10%` | — |
| Tier 2 | `>= 50`, `5%` | — |
| Return shape | `{name, tag, discount}` | `{tierNum, title, shortTitle, badgeText, pillText, discount, minOrders, maxOrders, nextGoal}` |

Both are `function` declarations in a classic script, so the **last one wins** and `:840` is dead code
that reads like the specification. Ten other names are duplicated the same way. **Neither ladder is
recorded anywhere on the server**, so there is no third source to break the tie — which of the two the
business actually promises is an open question, `TASK_STATE.md` P-8. KI-21, `AUDIT_REPORT.md` H-4.

## 3. Freight — one authority, two browser mirrors, and one hole

`config/shipping.php` is the authority and the **only** `config/` file with real consumers
([INTEGRATIONS.md](INTEGRATIONS.md) §2):

```php
'default_courier'           => 'delhivery',   // :8
'free_shipping_threshold'   => 1999.00,       // :9
'standard_rate'             => 150.00,        // :10
```

`api/cart.php:94-100` is the correct implementation and worth copying verbatim: it `require`s the
config, clamps both values with `max(0.0, …)`, and derives the charge —
`$shipping = ($subtotal <= 0.0 || $qualifiesFree) ? 0.0 : $shipRate;`. Its comment records the bug it
replaced: "the charge was waived above 999 while the `free_shipping` flag reported above 2999, and
`config/shipping.php` — the file that actually documents the rule — was read by nobody."
`admin/products/components/product-shipping.php:29` is the second consumer.

**Two browser copies of the threshold remain**, both as bare literals that will not follow a config
change:

| Location | Literal |
| :--- | :--- |
| `assets/js/modals.js:756` | `var DT_FREE_SHIP_OVER = 1999;` (its `:752` comment acknowledges it mirrors the config) |
| `shared/quickview.php:555` | `var QV_FREE_SHIP_OVER = 1999;` |

Other `1999` literals in the tree are **not** the threshold and must not be "unified" with it:
`api/coupons.php:72` and `src/DiscountEngine.php:23` are FESTIVE25's `min_order_value`,
`api/db_audit.php:366` is WELCOME10's, `admin/Asset/js/admin.js:120` and
`admin/Includes/adminheader.php:760` are a demo product's `wholesale_price`, and three
`z-index: 1999` rules are CSS.

**The hole:** the order path does not use any of this. `OrderManager.php:296` reads
`$shipping` straight from the request, so freight on a real order row is whatever the caller posted —
including a negative number. [SECURITY.md](SECURITY.md) SEC-5. `config/shipping.php` is exactly where
the server-side derivation should read from, and `api/cart.php:94-100` is the code to copy.

## 4. GST — 5 % everywhere, declared in four places

Textiles are billed at 5 % and that rate is the default in four separate signatures:

| Location | Form |
| :--- | :--- |
| `PricingCalculator::calculateGst()` `:25` | `float $gstRate = 5.0` |
| `PricingCalculator::calculateOrderTotal()` `:36` | `float $gstRate = 5.0` |
| `api/cart.php:101` | hardcoded `5.0` argument — **safe, cannot be influenced** |
| `OrderManager.php:297` | `(float)($orderData['gst_rate'] ?? 5.0)` — **from the request** |

`calculateGst()` **does** validate: it throws `InvalidArgumentException` when `$amount < 0` or
`$gstRate < 0` (`:27-29`). There is no upper bound and no whitelist, so `gst_rate: 0` is accepted as a
legitimate value and silently removes the tax from an order. A negative rate throws instead, escapes
`createOrder()`, and is returned by `api/orders.php:227` as a 500 with the exception text — no row is
written, but the internals leak ([SECURITY.md](SECURITY.md) SEC-14).

There is **no per-product or per-HSN rate**. `hsn` values appear only as literals in the B2B
JavaScript (`hsn: '5007'`, three files) and in invoice markup — the schema has no HSN column that
pricing reads. A future multi-rate requirement is a schema change, not a config tweak.

## 5. Coupons — one rule, three implementations, and a table that cannot expire

The `coupons` table is seven columns:

```sql
code VARCHAR(50) UNIQUE, discount_type ENUM('percentage','flat') DEFAULT 'percentage',
discount_value DECIMAL(10,2) NOT NULL, min_order_value DECIMAL(10,2) DEFAULT 0.00,
max_discount DECIMAL(10,2) DEFAULT 0.00, status ENUM('active','expired') DEFAULT 'active'
```

**There is no expiry date, no usage limit, no per-customer restriction and no channel column.**
Expiry is an admin manually flipping `status`. Both code paths nevertheless print "Invalid or
**expired** coupon code" — misleading copy for a mechanism that does not exist.

The same rule is implemented three times:

| Behaviour | `DiscountEngine::applyCoupon()` (`:46`) | `OrderManager::resolveCouponDiscount()` (`:19`) | `api/coupons.php` |
| :--- | :--- | :--- | :--- |
| Used by | `api/cart.php:83` — **display** | `createOrder()` `:294` — **the money** | admin CRUD + a seed array `:72-73` |
| Active filter | in SQL, `AND status='active'` `:62` | in PHP after fetch `:36` | — |
| DB unreachable | falls back to a 3-entry in-memory dictionary `:106-135` | returns `0.0` `:26-28` | — |
| Query throws | falls through to the dictionary `:101-103` | returns `0.0` `:33-35` | — |
| Percentage cap | `max_discount` only `:81-83` | `max_discount` **and** `min($discount, $subtotal)` `:54` | — |
| Flat cap | `min($subtotal, $val)` `:78` | covered by `:54` | — |

The order path is the stricter of the two, which is the right way round. The divergence that shows: a
row with `discount_type='percentage'`, `discount_value=150`, `max_discount=0` makes the **cart** quote a
discount of 1.5 × subtotal (and a nonsense total), while the **order** clamps it to the subtotal and
bills ₹0 + freight. The cart is wrong, the order is right, and the customer sees the wrong one.
Fixing `DiscountEngine` means adding the same `min($discount, $subtotal)` clamp at `:80-84`.

The fallback dictionary (`DiscountEngine.php:19-38`) mirrors the live seed and is duplicated a fourth
time in `api/coupons.php:72-73`:

| Code | Type | Value | `min_order_value` | `max_discount` |
| :--- | :--- | ---: | ---: | ---: |
| `FESTIVE25` | percentage | 25 % | 1,999 | 1,500 |
| `VIPRESELLER` | percentage | 15 % | 3,000 | 2,000 |
| `BULK50` | percentage | 50 % | 20,000 | 10,000 |

`api/db_audit.php:366` seeds a fourth, `WELCOME10` (10 %, min 1,999, cap 500), which is in **neither**
fallback list — so `WELCOME10` works while MySQL is up and silently stops working when it is not.

`applyCoupon()`'s `$channel` parameter is vestigial: the table has no channel column and the parameter
no longer filters (`:43-45`), yet `api/cart.php:83` still passes `$userType` into it. Harmless, and a
trap for anyone who assumes coupons are tier-restricted. **They are not** — `BULK50` is usable by a
retail customer who reaches ₹20,000.

**Change all four together or none.** The two class implementations must stay behaviourally identical;
the two seed arrays exist only for the offline path.

## 6. Lots and MOQ — the one rule that is fully honest

Four lot types map to four `products` columns, and both endpoints that use them read the real column
instead of assuming a ladder:

| Lot type | Column | Schema default |
| :--- | :--- | ---: |
| `single` | `moq_single` | 1 |
| `half_set` | `moq_half_set` | 4 |
| `full_set` | `moq_full_set` | 8 |
| `master_bale` | `moq_master_bale` | 24 |

`api/cart.php:54-60` raises a posted quantity **up** to the lot minimum
(`$qty = max($qty, (int)($p['moq_lots']['half_set'] ?? 4))`) — it never lowers it, so a buyer can order
more than a lot but not less.

`api/wholesale.php` `action=calculate_lot` is the best-written commercial endpoint in the project and
its comments record two removed fabrications:

- it used to default to product 1 and, for an unknown id, quote **a different saree** under the
  requested id, then crash on an empty catalogue (`:23-25`). It now 400s on a missing `product_id`
  (`:26-30`) and 404s on an unknown one (`:32-36`);
- it used to assume 1/4/8/24 pieces and apply "an invented 0/30/40/48 percent discount to the MRP, so
  it quoted a wholesale rate the business never set" (`:38-40`). The discount percentage is now
  **derived** from the two stored prices — `round((($mrp - $unitWholesalePrice) / $mrp) * 100, 2)`,
  and `null` when `mrp` is 0 (`:79`).

It also fails honestly rather than guessing: no lot size recorded → "the lot total cannot be
calculated" (`:46-53`); no wholesale rate → "Please ask for a quotation" (`:56-64`). **Use this file as
the model for any new pricing endpoint.**

Its one defect is the missing session gate, which makes the mill rate for every SKU readable by anyone
([SECURITY.md](SECURITY.md) SEC-7).

**The fabricated counterpart:** `assets/js/reseller.js:5133` renders `MOQ: ${p.moq || 8}` — a
non-existent `moq` field, so every product displays a MOQ of 8 regardless of its four real columns.

## 7. Reseller margin

`api/reseller.php` `action=calculate` (`:16-58`) is the reseller economics in one place:

```php
$marginPercent = max(5, min(50, (float)($_POST['margin_percent'] ?? 15.0)));   // :18
$marginAmount  = round($resellerBase * ($marginPercent / 100), 2);              // :43
$finalSellingPrice = $resellerBase + $marginAmount;                            // :44
```

So the margin is **added on top of** `reseller_price` (it is a markup, not a discount off MRP), the
percentage is clamped to `[5, 50]` with a 15 % default, and a product with no `reseller_price` returns
`success: false` — "No reseller price is set for this product yet" (`:35-41`) — instead of quoting zero.
Same removed fabrication as `wholesale.php`: it used to default to product 1 and return the first
catalogue product under an unknown id (`:20-21`).

**`smart_share_url` (`:55`) hardcodes `&ref=reseller_vip`** for every reseller. It is a constant, not an
identifier, so no share link can be attributed to the reseller who sent it. Reseller attribution does
not exist in this system; `customers.commission_rate` is stored and displayed but **nothing computes a
commission from it**.

## 8. Credit, ledger and "wallet" — what exists and what does not

`customers` carries `tier VARCHAR(50) DEFAULT 'Standard'`, `credit_limit DECIMAL(12,2)`,
`outstanding_balance DECIMAL(12,2)` and `commission_rate DECIMAL(5,2)`.

| Field | Written by | Consumed by | Maintained automatically? |
| :--- | :--- | :--- | :--- |
| `total_orders` | `OrderManager.php:461` (+1) and `CustomerManager::update()` `:248` | customer list, summary, export, segments | **yes** |
| `lifetime_spend` | `OrderManager.php:462` (+`$grandTotal`) and `CustomerManager::update()` | KPI strip, analytics | **yes** |
| `credit_limit` | `CustomerManager::updateCreditLimit()` `:354`, `update()`, `admin/customers/new.php:393` | summary, export | admin-entered only |
| `outstanding_balance` | `CustomerManager::update()` only | tags, segments, reseller table | **no — nothing ever debits it** |
| `commission_rate` | `CustomerManager::update()` | displayed | **no — nothing computes it** |
| `tier` | `CustomerManager::update()` | displayed | admin-entered only |

Two things follow. First, `lifetime_spend` accrues `$grandTotal` **regardless of `payment_status`**
(`:457-464`), so an unpaid order still inflates it — and because SEC-5 allows a negative
`grand_total`, a forged order can *decrease* a customer's lifetime spend. That same loop also
decrements stock (`:453`), so a forged order drains inventory. Second, the counter `UPDATE` is wrapped
in `catch (\Exception $ce) {}` (`:465`) so a counter failure never rolls the order back — deliberate,
and the reason the running totals can drift from the order rows.

**There is no wallet.** The word appears 16 times in the live tree and every occurrence is marketing
copy, CSS or a JS label: `account.php:1276`/`:1693`/`:1706` describe "live dispatch tracking, and
wallet"; `admin/resellers/credit.php:44` promises "wallet balance top-ups, and adjustment history".
No `wallet` table, no balance column, no top-up code path. `admin/resellers/` payout has no storage
either.

`admin/orders/ledger.php:17` hardcodes `$credit_limit = '15,00,000 (Net 15 Days)'` and prints it as
the customer's credit terms (`:139`) for every order.

## 9. Fabricated commercial figures — the inventory

These are numbers an owner or a customer could act on. None is computed from data.

| Where | Fabrication |
| :--- | :--- |
| `src/OrderManager.php:627` | `'DEL-' . rand(10000, 99999)` tracking number, **different on every refresh**, on 13 call sites. There is no carrier integration that could ever reconcile it ([INTEGRATIONS.md](INTEGRATIONS.md) §4) |
| `src/OrderManager.php:621-622` | `items_count => '1 lot'`, `items_summary => 'Ethnic Silk Sarees'` — `order_items` is never read |
| `src/OrderManager.php:638-675` | two complete demo orders returned whenever the query is empty **or** the DB is down |
| `assets/js/retailer.js:1316`, `:1332` | "July Margin Saved ₹26,800" |
| `assets/js/reseller.js:5133` | `MOQ: ${p.moq || 8}` |
| `assets/js/reseller.js` repeat-order | `recalcRepeatOrderTotal` / `handleRepeatOrderConfirm` price a repeat order at a flat `qty * 4899` with `qty * 1200` profit; `openRepeatOrderModal` shows "Lot Size: 1 Pc" |
| `admin/Asset/js/admin.js` `launchBroadcast` | reports a reach of "1,420" for a broadcast that sends nothing ([INTEGRATIONS.md](INTEGRATIONS.md) §3) |
| `admin/Includes/adminfooter.php:15,18,20` | `Hostinger Live Cloud: Synchronized`, `DB Version: v2.8.4 Enterprise`, `Active CRM WebSockets: 14 Sessions` — on 190 admin pages |
| `admin/Includes/adminheader.php:624` | "🔔 3 new wholesale orders received today!" |
| `admin/orders/ledger.php:17` | `₹15,00,000 (Net 15 Days)` credit terms |
| `admin/orders/` previews | `UTR-9821039812` — there is no payment gateway, so no UTR can exist |
| all three B2B pages | `.ws-cat-prog-name "Pure Silk & Zari Sarees (HSN 5007)"` progress bars, `<option value="KLN-WS-8021">` depot selects, and an invoice GSTIN literal (`wholesale.php:2138`, `reseller.php:2722`, `retailer.php:2185`) |
| `admin/inventory/stock-out.php:121` | `KLN-SR-111 Nilambari Silk` |
| `admin/marketing/banners.php:175` | "Nilambari Silk Hero" |

`ProductCatalog.php`'s comments record the same class of thing already **removed** from the catalogue —
an 11-product hardcoded catalogue served when MySQL was down (`:320-323`), a missing price defaulting to
6500/4899/1399 (`:929-936`), seven named reviews shown on every product (`:502`), a fixed 88/9/2/1/0
rating histogram (`:536`), and `adjustStock()` answering `max(0, 50 + $delta)` for a product it had never
read (`:1322`). That is the standard to hold new code to.

## 10. Rules for changing a commercial rule

1. **Find every implementation first.** Freight is in 3 places, GST in 4, the coupon rule in 4. A
   one-sided change produces a cart that disagrees with the invoice, which is worse than the bug.
2. **The server decides, the browser displays.** Never let a price, tier, discount, freight amount or
   tax rate arrive from the request and be written. `OrderManager::resolveItemPrices()` and
   `resolveChannel()` are the pattern; `OrderManager.php:296-297` and `:310-311` are the four inputs
   that still violate it.
3. **`config/shipping.php` is the only live config file.** Read it with `require` and clamp what you
   read (`api/cart.php:94-100`). Do not add a new literal.
4. **Fail honestly.** `api/wholesale.php:46-64` and `api/reseller.php:35-41` return
   `success: false` with a human explanation when a rate is missing. An empty field an admin can see is
   worth more than a plausible invented one.
5. **A displayed number needs a source.** If you cannot name the column or the calculation behind a
   figure you are adding, it is a fabrication — put "Not available yet" there instead.
6. **Coupons have no expiry, no usage limit and no tier restriction.** Do not write UI copy that claims
   otherwise, and if the business needs them, that is a schema change plus both class implementations.
7. Record the decision in [DECISIONS.md](DECISIONS.md) whenever a rule changes value or moves side.







