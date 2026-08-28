# KNOWN ISSUES

> The register of things that are **wrong, unresolved or undecided** — and, deliberately, of things
> that look wrong and must not be "fixed". Numbered `KI-n`; the numbers are referenced from other
> documents, so **append, never renumber**. Security findings live in [SECURITY.md](SECURITY.md)
> (`SEC-n`) and are only cross-referenced here. Measured 2026-08-29 by reading source; nothing was
> tested against the live host.
>
> Three states are used: **OPEN** (a defect, fix authorised in principle) · **BLOCKED** (waiting on
> the owner — a decision, a deployment or a `SHOW TABLES`) · **BY DESIGN** (recorded so nobody
> "corrects" it).

---

## KI-1 · Seed data is indistinguishable from production data — **BLOCKED**

`database/arniya_master_production.sql` seeds 8 categories, 6 demo products, **3 named customers with
a GSTIN** (`:340`), **3 orders** (`:346`) and **2 reviews** (`:365`). The reviews are attributed to
'Meenakshi Iyer (Chennai)' and 'Sunita Agarwal (Varanasi)' with `verified_buyer = 1`.

Consequences that have already caused confusion:

- The live dashboard's "TOTAL ORDERS 3" **is these three rows**. It is not a sale.
- `DT-ORD-90281` seen anywhere is either a seed row or `OrderManager::getAll()`'s demo fallback
  (KI-3).
- Any revenue figure reported to the owner must state whether seed rows are included.

The proposed cleanup is `DELETE FROM orders WHERE id IN (1,2,3)` and the matching
`id IN (101,102,103)` customer rows, in a transaction, after a dump. **It has not been run**, and an
agent must not run it: deleting rows from the live `orders` table is a data decision that belongs to
the owner, and the master protocol forbids an unconditioned or unauthorised `DELETE`. What an agent
*can* do is label seed rows in the UI rather than remove them.

## KI-2 · The live schema is whatever sequence of requests happened to run — **OPEN**

Four admin-gated routes mutate the schema or insert rows at runtime:

| Route | What it does |
| :--- | :--- |
| `api/db_audit.php` | **creates 16 tables** if absent |
| `api/db_health.php` | migrates, seeds, can mint an admin user, **can create an order** |
| `api/attributes.php:42` | creates `product_attributes` |
| `api/brands.php:40` | creates `product_brands` |
| `api/whatsapp.php:55` | creates `whatsapp_logs` |

All are behind `dt_api_require_admin()`, so this is **not** an unauthenticated exposure — it is a
data-integrity and schema-drift hazard operated from the owner's own console. `product_brands` /
`product_attributes` are also *different table names* from the `brands` / `attributes` that
`db_audit.php` creates and `db_health.php` seeds, so the brands feature is split across two tables
and nothing reconciles them. [SECURITY.md](SECURITY.md) SEC-16, [AUDIT_REPORT.md](AUDIT_REPORT.md)
H-2.

## KI-3 · Fabricated display data still shipping — **OPEN**

The single largest class of defect in the repository: code that shows a **plausible invented value**
where it should show real data or an empty state. Much has been removed (the comments in
`ProductCatalog.php`, `CustomerManager.php`, `api/wholesale.php` and `api/reseller.php` record it) —
this is what remains.

**Why it is ranked as high as security work:** an admin reads these numbers aloud to a customer. The
worst instance below generates a **different courier tracking ID on every page refresh**.

### 3a · Server-side, highest impact

| Where | What |
| :--- | :--- |
| `src/OrderManager.php:627` | `'tracking' => $r['tracking_number'] ?? ('DEL-' . rand(10000, 99999))` — a random, refresh-unstable tracking number for any untracked order |
| `src/OrderManager.php:621-622` | `items_count => '1 lot'` and `items_summary => 'Ethnic Silk Sarees'` hardcoded without reading `order_items` |
| `src/OrderManager.php:619` | a missing customer phone defaults to **the brand's own number** |
| `src/OrderManager.php:638-675` | an empty result — empty table **or dead database** — returns two complete demo orders (`DT-ORD-90281` / ₹44,688 / `DEL-94028491`, `DT-ORD-89412` / ₹8,399) |

`getAll()` has **13 call sites**, so all four reach the orders list, order stats, payments, reports,
shipping, retail, wholesale and `api/orders.php`. `admin/index.php:35` was deliberately switched off
`getAll()` for this reason and the comment there records it. [AUDIT_REPORT.md](AUDIT_REPORT.md) H-1.

### 3b · Admin chrome — lands on ~190 pages at once

| Where | What |
| :--- | :--- |
| `admin/Includes/adminfooter.php:15,18,20` | fake telemetry values |
| `admin/Includes/adminheader.php:624` | hardcoded "🔔 3 new wholesale orders received today!" |
| `admin/Includes/adminheader.php:755` | a demo search-results array |
| `admin/Includes/adminheader.php:760` | a demo product `wholesale_price` |

High leverage and correspondingly high risk: one edit changes every admin page.

### 3c · Admin modules

| Where | What |
| :--- | :--- |
| `admin/index.php` ~`:2452-2605` | hardcoded Orders-tab rows; the Reports tab and the invoice modal's `invOrderNumber` likewise |
| `admin/Asset/js/admin.js` | demo `orders` / `products` arrays; `launchBroadcast()`'s "1,420" recipients; `renderKPISparklines()` is dead code |
| `admin/orders/ledger.php:17` | every customer's credit terms hardcoded as `₹15,00,000 (Net 15 Days)` |
| `admin/orders/` previews | 'Rajesh Kumar (Vardhman Tex)', a literal GSTIN, `UTR-9821039812`, 112250 |
| `admin/products/brands/{index,add,edit}.php` | **wholly fabricated** — no table read |
| `admin/resellers/` | `openCreateSegmentModal` + `reseller-segments.js` invented segments |
| `admin/resellers/verification.php:59`, `view.php:64` | 'Namaste Rameshwar ji' message templates |
| `admin/marketing/banners.php:175` | "Nilambari Silk Hero" |
| `admin/inventory/stock-out.php:121` | 'KLN-SR-111 Nilambari Silk' |
| `admin/customers/assets/js/country-picker.js` | dead file that fires a fake success toast |
| `admin/catalogue/banners/*` | writes banners **no storefront page reads** |

### 3d · Storefront and B2B

| Where | What |
| :--- | :--- |
| `product.php` | hardcoded review counts |
| `shop.php` | hardcoded 3-slide hero, incl. `:87` `product1.png` |
| all three B2B pages | `.ws-cat-prog-name "Pure Silk & Zari Sarees (HSN 5007)"` progress bars; `<option value="KLN-WS-8021">` selects |
| `wholesale.php:2138`, `reseller.php:2722`, `retailer.php:2185` | a literal GSTIN in the invoice template |
| `reseller.php:3541` | `insertCustNotePrompt('Prefers Pure Silk & Jacquard sarees')` |
| `reseller.js` `retailer.js` `wholesale.js` | `window.allOrders = SAMPLE_ORDERS`, `hsn: '5007'` ×3, `image: '/assets/images/product1.png'` |
| `reseller.js:5133` | `MOQ: ${p.moq || 8}` — invents a lot size the DB does not have |
| `retailer.js:1316`, `:1332` | "July Margin Saved ₹26,800" |

### 3e · The fabricated-identity cluster — the one that can become permanent

`renderAddressBookData()` in the three B2B pages ships a complete invented trade identity —
**'Shree Krishna Silks Pvt Ltd', a GSTIN, 'Rajesh Kumar', Millennium Textile Market, 395002** — and
the same strings appear in the proforma text. `handleSaveAddress()` can **persist** it. Related:
`handleSaveNoteSubmit` stamps every note `creator: 'Rajesh Kumar'`; `handleQuickOrderSubmit` writes
only to `localStorage` while toasting success;
`recalcRepeatOrderTotal` / `handleRepeatOrderConfirm` price a repeat order at a flat `qty * 4899` with
`qty * 1200` profit; `openRepeatOrderModal` shows "Lot Size: 1 Pc".

Fix order for this cluster: stop the **write** first (`handleSaveAddress`), then the display.

## KI-4 · Three of the four migration files never run — **BLOCKED**

`database/migrate.php` executes **exactly one** file: `arniya_master_production.sql` (18 tables plus
seeds). The three files under `database/migrations/` — `2026_08_23_000001_create_initial_schema.sql`,
`2026_08_24_000001_full_production_schema.sql`, `2026_08_25_production_upgrade.sql` — are never
executed, yet `migrate.php::status()` lists them as `PENDING_OR_APPLIED`, which reads as though they
had run.

**Any column that exists only in `2026_08_25_production_upgrade.sql` is a phantom.** Code that reads
it fails on live with a real SQL error. This is the single most common source of "it works in the file
but not on the site".

Blocked on: a `SHOW TABLES` (and ideally `SHOW COLUMNS` for `orders`, `customers`, `order_items`) from
the live database, so the three competing authorities can be reduced to one.
[DATABASE.md](DATABASE.md), [PROJECT_MAP.md](PROJECT_MAP.md).

## KI-5 · A wishlist dies with the session — **OPEN**

`wishlist_items` exists (`id`, `customer_id`, `product_id`, `created_at`, both FKs CASCADE) and
**`api/wishlist.php` never writes it**: `toggle` / `add` / `remove` operate on `$_SESSION` only
(`:25-38`). A signed-in customer's wishlist is lost at session end. Straightforward data-loss bug, no
schema change needed. [DATABASE.md](DATABASE.md), [SECURITY.md](SECURITY.md).

## KI-6 · Nothing writes to `addresses` — **OPEN**

The table is fully specified (`address_line1/2`, `city`, `state`, `pincode`,
`address_type` ENUM(home,work,warehouse), `is_default`, FK CASCADE) and **no admin page and no API
endpoint inserts into it**. The only writer anywhere is `CustomerManager::create()`, which writes the
street address at `:189-211` and reports a *partial* result if that insert fails. The B2B "address
book" is entirely client-side — see KI-3e, which is why fixing that write path matters.

## KI-7 · `handleSaveGstProfile` does not exist — **OPEN, fix offered**

Three live pages call a function that is defined nowhere in the tree:

```
wholesale.php:940   <form id="wsGstForm" onsubmit="handleSaveGstProfile(event)">
retailer.php:981    <form id="wsGstForm" onsubmit="handleSaveGstProfile(event)">
reseller.php:1092   <form id="wsGstForm" onsubmit="handleSaveGstProfile(event)">
```

Verified: **3 call sites, 0 definitions.** Submitting the GST profile form throws
`ReferenceError` and — because the handler never returns `false` — the page also reloads, so the
symptom the customer reports is "it does nothing". `customers.gstin` and `customers.pan` columns
exist and are unwired. The proposed fix is to wire the form to `api/auth.php`'s profile update; it is
**awaiting the owner's go-ahead** because it adds a write path to a B2B page.

## KI-8 · `admin/settings/index.php` saves to a table that does not exist — **OPEN**

`admin/settings/index.php:40` sets `$message = "Saved locally!"`. There is **no `settings` table** —
verified: `arniya_master_production.sql` contains 18 `CREATE TABLE` statements and none of them
mentions `settings`. So the console reports a successful save for a write that cannot land anywhere.

This breaks the project's own rule from [BACKEND.md](BACKEND.md) §8: *never report success for a write
that did not happen.* Either add the table (schema decision → owner) or change the message to state
plainly that settings are not persisted.

## KI-9 · Unclassified artifacts at the git root — **BLOCKED**

`image.png`, `temp_inspect_users.php`, `scratch/`, `backups/`, `build/`. None is part of any of the
three generations. `temp_inspect_users.php` is the one to look at first — a file with that name
plausibly connects to the live database and prints user rows, and it sits **outside** `DT Brand/`,
so it is not FTP-deployed and therefore not web-reachable on live. Classify each (LEGACY / UNUSED /
UNKNOWN) before touching anything; deletion is the owner's call.
[FILE_OWNERSHIP.md](FILE_OWNERSHIP.md) §10.

## KI-10 · 16 broken `/DT%20Brand/` URL prefixes — **OPEN**

Verified: **16 occurrences across exactly 6 admin JS files** —
`admin/Asset/js/admin.js`, `admin/orders/assets/js/{order-list,order-view,refunds,returns}.js`,
`admin/wholesale/assets/js/wholesale-segments.js`.

The literal is a fetch path built for a local XAMPP layout where the project sat in a folder named
`DT Brand`. On live, `DT Brand/`'s *contents* are the web root, so every one of these requests 404s.
Each should be a root-relative `/api/…`. Mechanical, low-risk, and it silently breaks admin order
actions today. Do **not** confuse these with the 9 legitimate `wa.me` links found by the same grep.

## KI-11 · The password reset flow cannot complete — **OPEN**

`Auth::requestPasswordReset()` (`src/Auth.php:572`) writes `reset_token` and `reset_expires` to
`customers` and **nothing delivers the mail**. There is no mailer in the project;
`config/mail.php` has zero readers. Tokens accumulate unused, and a customer who asks for a reset
gets a success message and no email. Fixing it needs an SMTP decision from the owner
([INTEGRATIONS.md](INTEGRATIONS.md)); until then the honest change is to say what actually happens.

## KI-12 · There is no wallet, and no ledger — **OPEN**

"Wallet" appears 16 times in the live tree. **Every one is marketing copy, CSS or a JS label.** There
is no `wallet` table, no wallet column, no top-up path and no balance write anywhere.

Adjacent, and real:

- `customers.outstanding_balance` exists, is displayed, and is **never debited by an order**. Only
  `CustomerManager::update()` (`:248`) writes it — i.e. by hand.
- `customers.commission_rate` is stored and displayed and **computed by nothing**.
- `admin/orders/ledger.php:17` hardcodes `₹15,00,000 (Net 15 Days)` as **every** customer's credit
  terms, ignoring `credit_limit`.
- `OrderManager` *does* update `total_orders` and `lifetime_spend` (`:456-466`) — but
  `lifetime_spend` accrues regardless of `payment_status`, so an unpaid order inflates it.

Reseller payout has no storage at all. [BUSINESS_LOGIC.md](BUSINESS_LOGIC.md) §8.

## KI-13 · Reseller attribution does not exist — **OPEN**

`api/reseller.php:55` builds `smart_share_url` with a **hardcoded** `&ref=reseller_vip` for every
reseller, so two resellers sharing the same product produce the same link and no sale can be
attributed to either. Combined with KI-12's uncomputed `commission_rate`, the reseller programme has
a UI and no mechanism. A per-reseller `ref` needs a stable identifier decision from the owner.

## KI-14 · The coupon rule exists three times and cannot expire — **OPEN**

| Implementation | Caps the discount at | Clamps to subtotal |
| :--- | :--- | :---: |
| `DiscountEngine::applyCoupon()` `:81-83` | `max_discount` | **no** |
| `OrderManager::resolveCouponDiscount()` `:54` | `max_discount` | yes |
| `api/coupons.php` (admin CRUD) | — | — |

A row with `discount_value = 150` and `max_discount = 0` makes the **cart** quote 1.5 × subtotal and a
nonsense total, while the **order** correctly bills ₹0 + freight. One-line fix:
`min($discount, $subtotal)` at `DiscountEngine.php:80-84`.

And the table itself cannot express the rules the UI claims: `coupons` has `code`, `discount_type`,
`discount_value`, `min_order_value`, `max_discount`, `status` — **no expiry date, no usage limit, no
per-customer and no per-tier/channel column** — yet both code paths print "Invalid or **expired**
coupon code". `BULK50` (50 %, min ₹20,000) is usable by a retail customer. `WELCOME10` exists only in
the DB seed (`api/db_audit.php:366`) and in **neither** in-memory fallback, so it is the one coupon
that stops working when MySQL is down. The `$channel` parameter on `applyCoupon()` is vestigial.

## KI-15 · 379,197 B of unreachable code — **OPEN, classified, not authorised for deletion**

21 files in `shared/` (284,436 B) · 6 in `includes/` (21,598 B) · 5 UI assets (73,163 B) · 7 of 8
`config/` files. Full evidence and the four files that **look** dead and are live in
[FILE_OWNERSHIP.md](FILE_OWNERSHIP.md) §6, §10. Two traps repeated here because they have already
caused a wrong conclusion once:

- **`shared/size_chart_modal.php` is live on 6 pages** even though every other `*_modal.php` is dead.
- **`assets/css/main.css` and `assets/css/header.css` are live** — three admin pages link them.
- In `includes/`, **the misspelled files are the live ones** (`shophader.php`,
  `shopbottomfotoer.php`); the correctly-spelled `shopheader.php` / `shopfooter.php` are dead.

## KI-16 · `admin/adminlogin.php` is a second, unlinked login page — **BLOCKED**

738 lines, functionally identical to `admin/login.php` (the whole diff is comments), **zero inbound
references**, live and reachable by URL. It will not receive fixes applied to `login.php`. Classified
FUNCTIONAL DUPLICATE. Do not delete blind — it calls `Auth::adminLogin()` and may be bookmarked; the
collapse (redirect one to the other) needs the owner's confirmation because it touches sign-in.
[SECURITY.md](SECURITY.md) SEC-12.

## KI-17 · The WhatsApp number is correct; its formatting is not — **OPEN, cosmetic**

Verified: **all 47 raw occurrences are `917046363528`** — there is no wrong number left in the tree.
What varies is the display format: `+91 70463 63528` ×135, `+91 7046363528` ×7, `+917046363528` ×1.
Purely cosmetic; normalise to `+91 70463 63528` when touching a file for another reason. Recorded so
the earlier "the number differs in three places" note is not acted on again.

## KI-18 · Admin actions that do not act — **OPEN**

| Where | What happens |
| :--- | :--- |
| Export Studio | cannot export a checked selection — the checkboxes are not read |
| curated-page bulk actions (`admin/products/{featured,best-sellers,new-arrivals}/`) | undecided; no writer |
| `admin/catalogue/banners/*` | writes banners that no storefront page reads (KI-3c) |
| PDP "Instant Order via WhatsApp" | opens WhatsApp and writes **no order row** |

The last one is a business decision, not obviously a bug: an order placed by chat is confirmed by hand.
It is listed because the button's label implies otherwise.

## KI-19 · Features that need a schema change — **BLOCKED on the owner**

- **Per-product channel visibility** (hide a SKU from retail but sell it wholesale) — needs a column
  or a join table.
- **Per-parcel weight and dimensions** — `admin/products/components/product-shipping.php:62` says so
  in the UI: freight is a flat rate from `config/shipping.php` and nothing stores a weight.
- **A `settings` table** (KI-8).
- **A per-reseller `ref` identifier** (KI-13).

Each is a real gap, none can be closed without an authorised migration, and
[DATABASE.md](DATABASE.md)'s rule stands: no `DROP`, no `TRUNCATE`, no unconditioned `DELETE`, and no
schema change without explicit authorisation plus an impact analysis.

## KI-20 · UI-layer debt — **OPEN, low**

`--ws-*` triplicated byte-for-byte across `wholesale.css` / `reseller.css` / `retailer.css`; **13
competing `:root` blocks** in 14 token prefix families across 1.42 MB of CSS;
`@property --dt-border-angle` declared **10 times**, twice inside `admin/Asset/css/admin.css` alone
(`:263`, `:631`); `.dt-btn-action` re-declared in **44** stylesheets; 18 one-line admin CSS stubs.
Detail and the safe order of work in [UI_SYSTEM.md](UI_SYSTEM.md) §5, §6, §8.

## KI-21 · `reseller.js` — 11 shadowed duplicate functions, and they **diverge** — **OPEN**

351,469 B / 6,032 lines, 198 `function` declarations, **11 names declared more than once**:

| Name | Times | Lines |
| :--- | ---: | :--- |
| `openVipTierModal` | 3 | 362, 849, 3148 |
| `animateTargetGauge` | 2 | 31, 2872 |
| `initResellerApp` | 2 | 292, 2897 |
| `getWholesaleTier` | 2 | 840, 3083 |
| `openFullWalletModal` / `closeFullWalletModal` | 2 each | 348 / 3157, 358 / 3167 |
| `openWalletTopupModal` / `closeWalletTopupModal` | 2 each | 370 / 3220, 374 / 3224 |
| `closeVipTierModal` | 2 | 366, 3152 |
| `updateWholesaleCartBadge` / `updateWholesaleWishlistBadge` | 2 each | 3 / 3272, 16 / 3296 |

**Resolved 2026-08-29 — this is not a `SyntaxError` and the file is not dead.** Every duplicate is a
`function` declaration, which is legal in a classic script; the last declaration in scope wins.
Verified three ways: `node --check` on the file as a script passes; there is **no `type="module"`
anywhere in `DT Brand/`**; and `reseller.php:4044` loads it with a plain `<script src>`. A
`node --check --input-type=module` run *does* report `SyntaxError: Identifier 'openVipTierModal' has
already been declared` at `:849` — that is module semantics the browser never applies to this file, and
an earlier version of this entry drew the wrong conclusion from it.

**The real defect is worse than cosmetic, because the copies are not identical.** `getWholesaleTier`
at `:840` returns tiers at **800 / 450 / 250 / 50** orders (`15% / 12.5% / 10% / 5%`); the winning copy
at `:3083` returns Tier 5 Platinum at **1000+** with a different shape entirely (`tierNum`, `title`,
`badgeText`, `pillText`, `nextGoal`, `15% Margin Rebate`). So the thresholds a reader finds first are
the ones that never run, and an agent told to "change the Tier 5 threshold" will very likely edit the
dead copy and see no effect. Same trap for the wallet and VIP-modal pairs.

Fix by deleting the shadowed copy, not by renaming — but confirm against
[BUSINESS_LOGIC.md](BUSINESS_LOGIC.md) which threshold table is the intended one first; that is a
product question, not a refactor. [FRONTEND.md](FRONTEND.md), `AUDIT_REPORT.md` H-4.

## KI-22 · Nothing DB-dependent has been verified — **BLOCKED, structural**

There is **no MySQL in this environment**. Every finding in this tree was reached by reading source.
`php -l` and `node --check` are the only checks available; they prove syntax, not behaviour. So:

- No claim in these documents about *runtime* behaviour against real data has been executed.
- The list of things that need a real browser and a real database is maintained in
  [TESTING.md](TESTING.md) and tracked in [TASK_STATE.md](TASK_STATE.md).
- **Deployment is the owner's**: GitHub push + Hostinger FTP. An agent edits local tracked source and
  reports what needs uploading — it never deploys. [DEPLOYMENT.md](DEPLOYMENT.md).

## Looks like a bug — **BY DESIGN.** Changing any of these is a regression

| Thing | Why it is that way |
| :--- | :--- |
| `api/_guard.php` fails **closed**, `admin/Includes/adminguard.php` fails **open** | deliberate asymmetry: never take the console down on a guard failure, never leak data from the API. The console side still needs a floor — [SECURITY.md](SECURITY.md) SEC-10 |
| `api/orders.php` create needs **no** admin session | real customers must be able to check out. The money is safe because `createOrder()` re-derives price, channel, coupon and customer — [API.md](API.md) §5 |
| the guard is called **per action**, not at the top of the file | endpoints that mix a public read with an admin write would break the storefront otherwise |
| public order tracking returns an **identical 404** for "no such order" and "wrong phone" | anti-enumeration, and it requires order number **and** phone together |
| `Auth::adminLogin()` grants a session when MySQL is down | owner-lockout insurance. Move the value to `ADMIN_PASSWORD`, change it, **keep the offline path** — SEC-2 |
| `api/upload.php` derives the file extension from the **verified MIME**, never the filename | it replaced a real RCE. Use this file as the template for any new upload path |
| `ProductCatalog::mediaPath()` rejects `data:` URLs | they truncate in `primary_image VARCHAR(255)` |
| `is_primary` may only land on a **photo** | otherwise a card renders a video clip inside an `<img>` |
| `PUBLIC_STATUSES` = `in_stock,low_stock,out_of_stock` | `trash` is not in the ENUM, so a `status != 'trash'` filter put drafts on the storefront |
| `products.rating` / `reviews_count` / `categories.products_count` are **ignored**, not read | they are seeded with fiction (4.9 / 120 / 840) and recomputed from `reviews` and `products` |
| `CustomerManager` whitelists every ENUM and disambiguates `rowCount() === 0` | outside strict mode MySQL coerces an unknown ENUM to `''` **and reports success** |
| `CustomerManager::create()` invents `bin2hex(random_bytes(18))` for an absent password | forces the reset flow instead of a shared literal |
| `api/cart.php:54-60` raises quantity to the lot minimum and never lowers it | MOQ is a floor, not a target |
| `deleteCategory()` refuses while products reference the category | `products.category_id` has no FK, so the rows would be orphaned **and still on sale** |
| `api/wholesale.php` / `api/reseller.php` return a human message instead of a zero price | both replaced fabrications; honest failure beats a plausible number |
| `calculateGst()` throws on a negative rate | so `gst_rate: -100` is **blocked**, not an exploit. The real holes are `gst_rate: 0`, negative `shipping` and the un-whitelisted `payment_status` — SEC-5 |

## How to close an issue here

1. **Fix the root cause, not the symptom.** If a new error appears after your fix, return to the first
   failure and trace from the beginning rather than stacking patches.
2. **Verify.** `php -l` on every PHP file you touched; `node --check` on every JS file. State what you
   could not verify.
3. **Move the entry, do not delete it** — rewrite it as `CLOSED <date> — <what changed>` and add the
   change to [CHANGELOG.md](CHANGELOG.md). The numbers are referenced from other documents.
4. **If the fix needs a decision, a migration or a deployment, it stays BLOCKED** and the question goes
   to the owner. Do not guess and do not silently widen scope.

