# ADMIN

> `DT Brand/admin/` — 542 tracked files, **362 PHP**. The largest surface in the repository and the
> only one with a server-side session. Measured 2026-08-29.
> Storefront is documented in [FRONTEND.md](FRONTEND.md); the JSON surface in [API.md](API.md).

---

## 1. Entry points and shims

| Path | Lines | Bytes | Role |
| :--- | ---: | ---: | :--- |
| `index.php` | **3,146** | **221,799** | the Executive Command Center — 19 tab panels in one file |
| `login.php` | 750 | 27,100 | **the live sign-in page** |
| `adminlogin.php` | 738 | 26,263 | functional duplicate of `login.php` — see §5 |
| `logout.php` | 48 | 1,420 | |
| `products.php` | 196 | 10,839 | standalone product list, separate from `products/` |
| `categories.php` | 196 | 10,226 | standalone category list, separate from `products/categories/` |
| `orders.php` | 118 | 6,118 | standalone order list; calls `getAll(['limit'=>50])` on a **0-parameter** method |
| `admin.php` | 20 | 991 | shim → `index.php` |
| `login/index.php` | 2 | — | shim → `require_once __DIR__ . '/../login.php';` |

`.htaccess` contributes exactly one admin rule: `^admin/?$ → admin/index.php` (`:27`). Everything
else is resolved by Apache's own directory handling, which is why the trailing slash matters (§5).

## 2. Module map — PHP files per module

| Module | PHP | Module | PHP |
| :--- | ---: | :--- | ---: |
| `products/` | 53 | `retail/` | 36 |
| `wholesale/` | 48 | `customers/` | 30 |
| `catalogue/` | 42 | `inventory/` `pricing/` `settings/` | 5 each |
| `orders/` | 42 | `Includes/` | 4 |
| `resellers/` | 42 | `cms/` `marketing/` `payments/` `reports/` `shipping/` `system/` `users/` `whatsapp/` | 4 each |
| `notifications/` `reviews/` | 3 each | `media/` | 2 |
| `dashboard/` `login/` | 1 each | `Asset/` | 0 (css + js) |

`products/` `catalogue/` and the standalone `products.php` / `categories.php` are **three** catalogue
UIs over the same tables. `retail/` `wholesale/` `resellers/` are three channel consoles with
largely parallel page sets. None of that is a duplicate to delete — they are different channels with
different fields — but a change to one is not a change to the others.
## 3. The access guard — 358 of 362 files, one identical line

`admin/Includes/adminguard.php` (75 lines) is the whole console authentication check. Every guarded
page carries the same auto-inserted line as its **second** line, before any output:

```php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;
```

**362 admin PHP files · 358 include the guard · 4 do not**, and those 4 are exactly the ones that
must not: `adminlogin.php`, `login.php`, `login/index.php`, `logout.php`. There is no gap.

How it works, in order: `DT_ADMIN_GUARD_RAN` re-entry constant (`:22-25`) so nested includes cost
nothing; an IIFE (`:27`) so no variable leaks into the page; `@session_start()` (`:29-31`); resolve
`SCRIPT_NAME` + `REQUEST_URI` (`:34-36`); **return unless the path contains `/admin`** (`:40-42`);
**return if the path contains `login` or `logout`** (`:47-50`); read
`$_SESSION['admin_logged_in'] === true` (`:52-54`); otherwise 302 to `/admin/login.php` (`:61-69`).

Two properties to preserve deliberately, and one to know about:

- **It fails OPEN.** The whole body is wrapped in `catch (\Throwable)` that simply returns
  (`:70-74`), with the comment *"Never take the admin console down on a guard failure."* That is the
  opposite of `api/_guard.php`, which fails **closed** ([API.md](API.md) §3). Both choices are
  intentional: a broken console guard degrades to an unprotected page rather than a locked-out
  owner, while the API refuses. Do not "make them consistent" without a decision in
  [DECISIONS.md](DECISIONS.md).
- **The `login`/`logout` exemption is a substring match**, not a path match. Any future admin page
  whose URL happens to contain the letters `login` or `logout` — `/admin/users/logins.php`,
  `/admin/reports/logout-audit.php` — would be **silently unguarded**. Name new files accordingly.
- Session keys are shared with the API guard, so one sign-in covers both console and JSON surface.

## 4. Chrome — `Includes/`, and the 19 pages that skip the footer

| Fragment | Lines | Bytes | Included by |
| :--- | ---: | ---: | ---: |
| `adminheader.php` | 1,250 | 55,038 | 209 |
| `adminsidebar.php` | 1,065 | 88,322 | 209 |
| `adminfooter.php` | 64 | 4,721 | **190** |
| `adminguard.php` | 75 | 3,348 | 358 |

The 19-page gap is not random: **all 18 pages of `retail/`** plus `products/index.php` print their
own `</body></html>` and their own `<script>` tags instead of including the footer. They therefore
render **no mobile bottom navigation dock** — `adminfooter.php:30-63` is the only definition of
`.adm-mobile-bottom-dock`, the five-tab sticky app bar with the centre "Add Product" FAB. On a phone
the entire retail console has no bottom nav while every other module does.

`adminfooter.php` also prints three **hardcoded** status values as though they were live telemetry:
`Hostinger Live Cloud: Synchronized` (`:15`), `DB Version: v2.8.4 Enterprise` (`:18`) and
`Active CRM WebSockets: 14 Sessions` (`:20`). Nothing measures any of them. They sit on 190 admin
pages. [AUDIT_REPORT.md](AUDIT_REPORT.md) M-x, and see §7.
## 5. `login.php` and `adminlogin.php` — a functional duplicate, and the trailing slash

`diff login.php adminlogin.php` produces **18 changed lines, all of them comments**. Every executable
statement is identical. So:

- `login.php` (750 lines) is reachable at `/admin/login.php` **and** at `/admin/login/` via the
  2-line `login/index.php` shim. This is the page the console redirects to.
- `adminlogin.php` (738 lines) has **zero inbound references** — no PHP, no JS, no `.htaccess` rule
  anywhere in the tree links to it. It is reachable only by typing the URL.

Classify it **FUNCTIONAL DUPLICATE**, not dead: it is a working, unguarded authentication endpoint
that will silently miss any fix applied to `login.php`. It is also one of only three files that call
`Auth::` at all ([BACKEND.md](BACKEND.md) §1). [FILE_OWNERSHIP.md](FILE_OWNERSHIP.md).

**Why the trailing slash is load-bearing.** `login.php:603-615` carries a 13-line comment that is the
single most useful piece of documentation in the admin tree, and it must survive any reformat. In
short: `admin/login` is a **real directory** on disk, so posting to `/admin/login` without the slash
makes Apache `DirectorySlash` issue a 301 to `/admin/login/`; a browser following a 301 re-sends as
**GET and discards the body**. The typed email and password were destroyed before PHP ran,
`REQUEST_METHOD` was never `POST`, `Auth::adminLogin()` was never called, and the form simply
re-rendered empty with no error. Nothing was ever wrong with the credentials. The same reasoning
governs the logout redirect and the post-login redirect — see the two most recent commits,
`31be293` and `4a97896`.

## 6. `admin/index.php` — the 222 KB Executive Command Center

3,146 lines, **19 tab panels** in one document, switched client-side by `switchAdmTab()`:

`tab-overview` `:592` · `tab-products` `:1674` · `tab-orders` `:1888` · `tab-whatsapp` `:1952` ·
`tab-partners` `:2043` · `tab-customers` `:2084` · `tab-reports` `:2149` · `tab-settings` `:2237` ·
`tab-pricing` `:2303` · `tab-reviews` `:2419` · `tab-inventory` `:2493` · `tab-shipping` `:2558` ·
`tab-payments` `:2622` · `tab-marketing` `:2682` · `tab-cms` `:2742` · `tab-media` `:2798` ·
`tab-notifications` `:2841` · `tab-users` `:2893` · `tab-system` `:2948`.

Most of those 19 tabs are **summary views that duplicate a full module** under `admin/<module>/`.
The tab is not the source of truth; the module is.

Server-side data, all of it gathered in `:14-67`:

```php
require_once … Database.php, ProductCatalog.php, CustomerManager.php, OrderManager.php   // :14-17
$db                    = Database::getConnection();                                       // :24
$allProducts           = ProductCatalog::getAll(true);                                    // :27
$categoriesList        = ProductCatalog::getCategories();                                 // :29
$allCustomers          = CustomerManager::getAll();                                       // :31
$totalWholesaleCount   = count(CustomerManager::getByType('wholesale'));                  // :33
$totalResellerCount    = count(CustomerManager::getByType('reseller'));                   // :34
$recentOrdersList      = [];   // :41 — deliberately NOT OrderManager::getAll(); comment :35-40
$totalOrdersCount      = 0;                                                               // :42
$dbLive                = ($db !== null && !Database::isMockMode());                       // :67
$notCancelled = "COALESCE(`fulfillment_status`, 'unfulfilled') <> 'cancelled'";           // :68
```

`$recentOrdersList = []` is a **fix, not an oversight**, and its own comment (`:35-40`) records why:
`OrderManager::getAll()` falls back to a demo array on a dead connection **and** reshapes live rows
into its own key names (`customer`, `amount`, `status`, `source`) while every widget here reads raw
`orders` columns — so the demo rows rendered as `ORD-0` / ₹0 placeholders. Do not "restore" the call.
Real rows are loaded further down, only when `$dbLive`.

Two invariants for any new dashboard query:

- **Gate on `$dbLive`** before rendering a zero. Otherwise an outage reads as "you have no orders".
- **Use `$notCancelled` (`:68`), not `!=`.** `fulfillment_status` is nullable and `!=` is NULL-unsafe
  in MySQL, so `WHERE fulfillment_status != 'cancelled'` silently drops every unfulfilled order.
  Each analytics query is also wrapped individually — the comment at `:44-66` records that a single
  bad column used to blank the entire dashboard.

Four hand-drawn `<canvas>` charts, no charting library: `admAppCircularGauge` `:633`,
`admRefSalesChart` `:990`, `admRevenueChart` `:1454`, `admCategoryChart` `:1494`. Rendering rules
(DPR transform, "no data yet" text) are in [UI_SYSTEM.md](UI_SYSTEM.md).

## 7. Fabricated content still in the console

The eight dashboard widgets named in the user's last hardening pass now read real data. These do
**not**, and an admin cannot tell by looking. Report them; do not silently expand a task to fix them.

| Location | Fabrication |
| :--- | :--- |
| `Includes/adminfooter.php:15,18,20` | `Hostinger Live Cloud: Synchronized`, `DB Version: v2.8.4 Enterprise`, `Active CRM WebSockets: 14 Sessions` — on **190** pages |
| `Includes/adminheader.php:624` | `🔔 3 new wholesale orders received today!` |
| `Includes/adminheader.php:755` | demo global-search result array |
| `index.php` Orders tab `~:2452-2605` | `ORD-9842` / `ORD-9841`, 'Ananya Sharma', `KLN-SR-111` rows, 'Surat Central Depot', and `Delhivery Express (Air)` at `:2598` |
| `index.php` Reports tab | fabricated report rows |
| `index.php` invoice modal | `invOrderNumber` literal |
| `Asset/js/admin.js` | demo `orders` / `products` arrays; `launchBroadcast`'s "1,420" reach; `renderKPISparklines()` is dead code |
| `products/brands/{index,add,edit}.php` | wholly fabricated brand list — and see the `product_brands` vs `brands` table split, [API.md](API.md) §7 |
| `orders/` previews | 'Rajesh Kumar (Vardhman Tex)', a GSTIN literal, `UTR-9821039812`, `112250` |
| `resellers/verification.php:59`, `resellers/view.php:64` | 'Namaste Rameshwar ji' WhatsApp templates |
| `resellers/` segments | `openCreateSegmentModal` + `reseller-segments.js` invent segments |
| `marketing/banners.php:175` | 'Nilambari Silk Hero' |
| `inventory/stock-out.php:121` | `KLN-SR-111 Nilambari Silk` |
| `customers/assets/js/country-picker.js` | dead file that still fires a success toast |

Plus these **silent no-ops**, which are worse than a wrong number because they claim success:
`settings/index.php` writes to a `settings` table that does not exist and reports "Saved locally!";
the reseller payout screen has no storage at all; **no admin endpoint writes to `addresses`**; and
Export Studio cannot export a checked selection. [KNOWN_ISSUES.md](KNOWN_ISSUES.md).

## 8. Conventions for admin work

- **Every new admin PHP file gets the guard line as line 2**, verbatim, before any output. Never name
  a file or route so its path contains `login` or `logout` (§3).
- Include `adminsidebar.php` then `adminheader.php` then, at the end, `adminfooter.php` — set
  `$active_nav` before the includes so both the sidebar and the mobile dock highlight correctly.
- Read through `src/` classes, not inline PDO, when a method already exists — but **never**
  `OrderManager::getAll()` for a display surface (§6).
- Assets belong in the module's own `assets/` directory; only truly console-wide code goes in
  `Asset/css/admin.css` (136,642 B) or `Asset/js/admin.js` (86,405 B).
- Use the static `?v=` stamp on new `<script>`/`<link>` tags, not `?v=<?php echo time(); ?>`.
  `catalogue/index.php` alone emits 13 `time()` busters ([PERFORMANCE.md](PERFORMANCE.md)).
- Absolute paths start at `/admin/…`. The **16** surviving `/DT%20Brand/…` prefixes are all in admin
  JS and all 404 on live ([FRONTEND.md](FRONTEND.md) §7).
- An honest empty state beats a plausible number. That rule is why `$recentOrdersList` is empty.



