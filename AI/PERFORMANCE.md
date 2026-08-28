# PERFORMANCE

> Every number here was measured on 2026-08-29 from tracked file sizes and source greps. **Nothing
> was profiled against the live host** — no Lighthouse run, no server timing, no query log. Treat
> these as payload and code-path facts, and the ranking as inference from them.
> Findings ranked by (bytes saved × pages affected) ÷ effort.

---

## 1. The single biggest win: 8 WebP files already exist and are never used

| Set | Files | Total | References |
| :--- | ---: | ---: | ---: |
| `assets/images/product{1..8}.png` | 8 | **4.14 MB** | **307** |
| `assets/images/product{1..8}.webp` | 8 | 0.97 MB | **0** |

Somebody converted the entire product image set to WebP, committed it, and never changed a single
`<img src>`. `.htaccess:58` even sets `ExpiresByType image/webp "access plus 1 month"` in
anticipation. Switching the references cuts **3.17 MB — a 77 % reduction — off the image payload**
with no visual change and no new files.

Related, same area:

- `assets/images/logo.png` is **265,351 bytes** and is referenced at **59** sites, i.e. it is the
  header logo on essentially every page. A quarter of a megabyte for a logo. There is no WebP
  version of it and no SVG.
- **No `<picture>` and no `srcset` anywhere in the tree** — zero occurrences across all PHP. There is
  no responsive image path at all; a phone downloads the same 650 KB PNG as a desktop.
- **Only 28 of 201 `<img>` tags carry `loading="lazy"`.** 173 do not, including the product grids.

Total image weight is 19 files / **5.54 MB**. (An earlier note in this tree said ~7.7 MB; that was
wrong and has been corrected in [PROJECT_MAP.md](PROJECT_MAP.md) §2.7.)

## 2. Cache-busting defeats itself on the four heaviest assets

**1,009** occurrences of `?v=<?php echo time(); ?>` / `?v=<?= time() ?>` remain, against only **11**
static `?v=1787019062` stamps. A `time()` buster changes the URL **every second**, so `mod_expires`
(1 month, `.htaccess:52-65`) can never apply and every visit is a cold fetch.

Worse, three pages emit **both** stamps on one URL —
`home.css?v=1787019062&v=<?php echo time(); ?>` — so the static stamp is decorative:

| Page | Stamping | Heaviest assets involved |
| :--- | :--- | :--- |
| `index.php` | both → **never caches** | `home.css` 207,162 · `home.js` 63,032 |
| `reseller.php` | both → **never caches** | `reseller.js` **351,469** · `reseller.css` **271,064** |
| `retailer.php` | both → **never caches** | `retailer.js` 214,923 · `retailer.css` 201,596 |
| `shop.php` | static only — correct | `shop.css` 61,070 · `shop.js` 39,323 |
| `product.php` | static only — correct | `singleproduct.css` 64,657 · `singleproduct.js` 51,406 |
| `wholesale.php` | static only — correct | `wholesale.js` 204,015 · `wholesale.css` 193,304 |

So the **three pages carrying 1.3 MB of CSS+JS between them are exactly the three that cannot
cache**, while the three lighter ones cache correctly. Worst admin offenders:
`admin/catalogue/index.php` 13 busters, `admin/resellers/view.php` 12, `admin/wholesale/view.php` 10,
and every `admin/orders/*.php` status page 10 each.

Fix: replace `time()` with the existing static constant everywhere, and bump it on release. Do not
leave both stamps on one URL.
## 3. A MySQL outage manifests as a hang, not an error

`src/Database.php::getConnection()` short-circuits **only** on `self::$pdo !== null` (`:19`). In mock
mode `$pdo` stays null, so every subsequent call re-runs the full candidate loop
`[$host, 'localhost', '127.0.0.1']` (`:29-35`). And `isMockMode()` (`:60-64`) calls
`getConnection()` itself.

A page that makes 40 `Database::query()` calls with a dead database therefore attempts **80–120 TCP
connections**, each waiting for its own connect timeout, before rendering. This is the highest-impact
code-path defect in the project even though it costs nothing when MySQL is healthy — it is the
difference between an error page and a browser that appears to freeze.

Fix is four lines: a `self::$connectionAttempted` flag set on first failure, checked at the top of
`getConnection()` alongside the existing `$pdo` check. [BACKEND.md](BACKEND.md) §2.

## 4. No connection reuse, no autoloader, no build step

- **Every storefront page opens its own PDO connection** and runs its own inline queries. There is no
  front controller and no shared bootstrap, so nothing is amortised across a request beyond
  `Database`'s per-process singleton.
- **No autoloader.** Each consumer writes `require_once __DIR__ . '/../src/X.php';` by hand — 96 files
  require `Database.php`, 54 require `ProductCatalog.php`. Each is a stat + parse. Opcache makes this
  cheap in production and it is *not* worth restructuring for; noted so nobody adds a composer
  autoloader "for speed" and breaks the deployment model ([DECISIONS.md](DECISIONS.md) D-2).
- **No minification, no bundling, no tree-shaking.** `reseller.js` ships 351 KB of hand-written,
  unminified JavaScript. `mod_deflate` is on (`.htaccess:36-49`) and covers `application/javascript`
  and `text/css`, so the wire cost is roughly a third of that — but parse and compile cost is not
  compressed.
- `ProductCatalog` has a **per-request memo** (`self::$memo` `:20`, invalidated by
  `invalidateCache()` `:23`) and `sideTables()` `:135` fetches media, variants and reviews in **one
  query each** rather than per product. That is the one place N+1 was already designed out — preserve
  it.

## 5. Page weight, worst first

| Page | HTML bytes | + CSS | + JS | Total shipped |
| :--- | ---: | ---: | ---: | ---: |
| `reseller.php` | 328,591 | 271,064 | 359,533 | **959,188 B ≈ 937 KB** |
| `retailer.php` | 215,862 | 201,596 | 222,987 | 640,445 B ≈ 625 KB |
| `wholesale.php` | 212,320 | 193,304 | 212,079 | 617,703 B ≈ 603 KB |
| `index.php` | 134,684 | 207,162 | 63,032 | 404,878 B ≈ 395 KB |
| `product.php` | 67,476 | 64,657 | 51,406 | 183,539 B ≈ 179 KB |
| `shop.php` | 30,688 | 61,070 | 39,323 | 131,081 B ≈ 128 KB |
| `account.php` | 97,829 | — | — | 97,829 B ≈ 96 KB (all inline) |

JS totals include `profile-save.js` (8,064), which all three B2B pages load. Add images and
`reseller.php` is past 1.4 MB on first paint, uncacheable (§2). The three B2B pages are the problem
set on every axis — weight, cacheability, and correctness ([FRONTEND.md](FRONTEND.md) §6).

`admin/index.php` is **221,799 bytes of HTML in one response** — 19 tab panels, of which the user sees
one. Plus `admin/Asset/css/admin.css` 136,642 and `admin/Asset/js/admin.js` 86,405. Lazy-rendering
the 18 hidden tabs is the single biggest admin win, and it is a real refactor, not a tweak.

## 6. Dead weight that ships or sits

**Never referenced by anything** — 48,809 bytes, safe to stop shipping once classified
([FILE_OWNERSHIP.md](FILE_OWNERSHIP.md)):
`assets/css/header.css` 13,409 · `assets/css/main.css` 10,920 · `assets/css/modals.css` 10,600 ·
`assets/js/header.js` 7,377 · `assets/js/core.js` 6,503.

**Duplicate declarations that ship and then get discarded:** `assets/js/reseller.js` declares **11 names
more than once** — the browser parses every copy, the last wins, and the earlier ones are transferred and
compiled for nothing. Small next to the 351 KB total, and **not** the reason to touch this file: the
copies of `getWholesaleTier()` disagree on the tier thresholds, which is a correctness bug (KI-21).

**Unreachable server-side templates** (parsed only if requested, so no runtime cost, but they inflate
every deploy): the 6 unreachable `includes/` fragments, 29 PHP files under `shared/` that are mostly
unreferenced, and the frozen GEN-A/GEN-B trees outside `DT Brand/`.

## 7. Ranked plan

| # | Change | Saving | Effort |
| --: | :--- | :--- | :--- |
| 1 | Point `product*.png` references at the existing `.webp` | **3.17 MB** across 307 sites | mechanical |
| 2 | Replace all 1,009 `time()` busters with the static stamp | makes 1.3 MB of CSS/JS cacheable | mechanical |
| 3 | `loading="lazy"` on the 173 `<img>` tags without it | defers most of the image payload | mechanical |
| 4 | Negative memoisation in `Database::getConnection()` | turns an outage hang into an error | 4 lines |
| 5 | Convert / replace `logo.png` (265 KB, 59 pages) | ~250 KB every page | small |
| 6 | Add `srcset` to product grids | large on mobile | medium |
| 7 | Lazy-render `admin/index.php`'s 18 hidden tabs | ~200 KB per admin page load | refactor |
| 8 | Minify `reseller.js` / `reseller.css` / `retailer.*` | parse + compile time | needs a build step — **decide first** ([DECISIONS.md](DECISIONS.md)) |

Items 1–5 are safe, local and independently verifiable. Items 7–8 change architecture; record the
decision before starting either. Nothing in this document should be actioned during a bootstrap or
bug-fix task.

