# AGENT BRIEF · ADMIN

> **Scope:** `DT Brand/admin/` — **542 files in 26 module directories**, the largest surface in the
> repository. Storefront pages are [frontend.md](frontend.md); tokens and chrome dimensions are
> [ui-ux.md](ui-ux.md); the guard's security posture is [security.md](security.md).
>
> Read with [ADMIN.md](../ADMIN.md) and [FILE_OWNERSHIP.md](../FILE_OWNERSHIP.md) §3.

---

## 1. Read the module README first — seven of them exist

| Module | Files | | Module | Files |
| :--- | ---: | :--- | :--- | ---: |
| `admin/wholesale/` | 75 | | `admin/orders/` | 59 |
| `admin/products/` | 74 | | `admin/catalogue/` | 59 |
| `admin/resellers/` | 67 | | `admin/customers/` | 48 |
| `admin/retail/` | 59 | | | |

Those seven hold **441 of the 542 files** and each has a `README.md`. Read it before changing the module and
**update it** rather than writing a parallel description (D-10).

The remaining 101: `settings/` `pricing/` `inventory/` 7 each; `whatsapp/` `users/` `system/` `shipping/`
`reports/` `payments/` `marketing/` `cms/` 6 each; `reviews/` `notifications/` 5; `media/` `Includes/` 4;
`dashboard/` 3; `Asset/` 2; `login/` 1; and **8 files at the root of `admin/`** — `index.php`, `admin.php`,
`orders.php`, `products.php`, `categories.php`, `login.php`, `adminlogin.php`, `logout.php`.

## 2. Blast radius — the number that decides how carefully you work

`admin/orders/` is the reference layout and the other six large modules follow it: a `README.md`, top-level
pages, `components/` (22 partials), `assets/css/` (7), `assets/js/` (9), and **13 status pages**
(`pending.php` … `refunded.php`).

**A status page is a filter, not a feature.** All 13 are thin wrappers around the same
`components/order-table.php`. Fixing a column means editing the component once — and a bug in that
component appears on 13 pages at once.

Worse: **`admin/Includes/adminheader.php` and `adminfooter.php` are included by ~190 pages**, and both still
ship fabricated display values (KI-3b). Any edit there is a 190-page change.

**Module assets are module-local.** `admin/wholesale/assets/css/wholesale.css` is a *different file* from
`assets/css/wholesale.css`. The storefront path is a substring of the admin one, so a basename grep reports
29 referrers for a file that has 1 (D-9). Always match the full `href`.

## 3. The guard fails open, deliberately

`admin/Includes/adminguard.php:70-74` wraps its body in `catch (\Throwable) { return; }` with the comment
*"Never take the admin console down on a guard failure."* **Any** throw inside the guard serves the requested
page unauthenticated.

This is a decision, not a bug (D-3): a console that refuses to load during a session-handler hiccup locks a
one-person business out of its own operations. **A change that makes it fail closed will be reverted.** The
authorised fix is narrower — render a static "sign in again" page on the throw path, and replace the
substring exemption (`strpos($haystack, 'login')`, which exempts **any** URL containing `login` or `logout`)
with an exact-path allowlist. SEC-10, SEC-11.

Rollout is by **per-page include**, not `auto_prepend_file` or `.htaccess` — the owner chose that because it
is inspectable per file and cannot take the whole console down at once.

Two related facts: `admin/adminlogin.php` is 738 lines and **functionally identical to `login.php`** with zero
inbound links but still URL-reachable (SEC-12, KI-16); and the admin master credential grants a session even
when MySQL is down (`Auth.php:363`), which is the owner's lockout insurance (D-6).

## 4. What is still fabricated, and the rule about it

**Never invent a display value.** An empty widget that says so is correct; a plausible number an admin can
read out to a customer is a defect. This was learned from live damage — a hardcoded roster once put
real-format phone numbers in front of an admin who could click "WhatsApp Connect" and message a stranger
(D-5).

Still outstanding, catalogued in KI-3: the chrome on ~190 pages (3b), several admin modules including
`admin/resellers/` segments (3c), and `OrderManager::getAll():627`'s `'DEL-' . rand(10000, 99999)` tracking
numbers plus two demo orders returned on an empty query (3a). KI-18 lists **admin actions that do not act** —
buttons that toast success and write nothing, e.g. `admin/settings/index.php:40` `"Saved locally!"` for a
non-existent `settings` table (KI-8), and the dead `admin/customers/assets/js/country-picker.js`.

## 5. Rules

1. **No `/DT%20Brand/` in a URL** — 16 survive in 6 admin JS files: `admin/Asset/js/admin.js`,
   `admin/orders/assets/js/{order-list,order-view,refunds,returns}.js`,
   `admin/wholesale/assets/js/wholesale-segments.js` (KI-10). Do not add more; do not confuse them with the
   9 legitimate `wa.me` hits the same grep finds.
2. **Redirects keep the canonical trailing slash** — `/admin/`, never `/admin`. A 301 hop drops the session
   and the symptom is "sign-in succeeds and lands back on the login page" (`4a97896`, `31be293`).
3. **Charts are hand-drawn `<canvas>`** — there is no charting library. Use
   `ctx.setTransform(dpr, 0, 0, dpr, 0, 0)`; `ctx.scale(dpr, dpr)` compounds and the chart shrinks on every
   redraw ([UI_SYSTEM.md](../UI_SYSTEM.md) §10).
4. **`--adm-sidebar-w` / `--adm-header-h` are a contract with the sidebar JS.** Changing either in
   `admin/Asset/css/admin.css` moves layout on ~190 pages.
5. **Every bulk action needs a guard per action** and a real row count back, not an optimistic toast.

## 6. Verification

```bash
/c/xampp/php/php.exe -l "DT Brand/admin/orders/components/order-table.php"
```

```bash
node --check --input-type=commonjs < "DT Brand/admin/Asset/js/admin.js"
```

**No MySQL here**, so no widget, filter or list is runtime-verifiable (KI-22). When you change a component,
name **every page it renders** in the report, and list the files for upload (D-8).

