# FRONTEND

> The public storefront: 11 root `.php` pages in `DT Brand/`, 11 fragments in `includes/`,
> 10 CSS + 10 JS files in `assets/`. Measured 2026-08-29.
> Admin console UI is documented separately in [ADMIN.md](ADMIN.md).

---

## 1. The pages

| Page | Lines | Bytes | Header / footer fragment | CSS · JS |
| :--- | ---: | ---: | :--- | :--- |
| `reseller.php` | 4,051 | 328,591 | **inline, own copy** | `reseller.css` · `reseller.js`, `profile-save.js` |
| `retailer.php` | 2,753 | 215,862 | **inline, own copy** | `retailer.css` · `retailer.js`, `profile-save.js` |
| `wholesale.php` | 2,706 | 212,320 | **inline, own copy** | `wholesale.css` · `wholesale.js`, `profile-save.js` |
| `index.php` | 2,050 | 134,684 | `shophader` / `shopbottomfotoer` | `home.css` · `home.js` |
| `account.php` | 1,979 | 97,829 | **inline, own copy** | **none — all CSS and JS inline** |
| `product.php` | 1,104 | 67,476 | `singelproduthader` / `singelprodutbottomfotoer` | `singleproduct.css` · `singleproduct.js` |
| `shop.php` | 522 | 30,688 | `shophader` / `shopbottomfotoer` | `shop.css` · `shop.js` |
| `checkout.php` | 249 | 13,190 | **inline** | `shop.css` · — |
| `cart.php` | 198 | 11,640 | inline / `singelprodutbottomfotoer` | `shop.css` · — |
| `wishlist.php` | 137 | 8,086 | inline / `singelprodutbottomfotoer` | `shop.css` · — |
| `about-us.php` | 56 | 3,836 | inline / `singelprodutbottomfotoer` | `shop.css` · — |

Routing is `DT Brand/.htaccess` only: `^product/([0-9]+)/?$ → product.php?id=$1` (`:13`) and
siblings. No front controller. Each page opens its own PDO connection, runs its own queries and
prints a complete HTML document with `<style>` and `<script>` inline at the bottom.

## 2. `includes/` — 6 of the 11 fragments are unreachable

| Fragment | Lines | Included by |
| :--- | ---: | :--- |
| `shophader.php` | 1,341 | `index.php:89`, `shop.php:68` |
| `shopbottomfotoer.php` | 1,354 | `index.php:2032`, `shop.php:497` |
| `singelproduthader.php` | 748 | `product.php:221` |
| `singelprodutbottomfotoer.php` | 141 | `about-us.php:51`, `cart.php:35`, `product.php:1074`, `wishlist.php:34` |
| `product-not-found.php` | 123 | `product.php:45` |
| `header.php` | 166 | **nothing** |
| `footer.php` | 77 | **nothing** |
| `mobile_bottom_nav.php` | 51 | **nothing** |
| `subnav.php` | 39 | only `header.php:164` — so unreachable in practice |
| `shopheader.php` | 6 | **nothing** — a 6-line alias `include_once shophader.php` |
| `shopfooter.php` | 6 | **nothing** — a 6-line alias `include_once shopbottomfotoer.php` |

The **misspelled names are the live ones**; the correctly-spelled `shopheader.php` /
`shopfooter.php` are unreferenced alias shims. Do not "fix the typo" by deleting the long files.
`header.php` + `footer.php` + `mobile_bottom_nav.php` + `subnav.php` look like an intended
universal header/footer refactor that was never wired up — classify, do not delete:
[FILE_OWNERSHIP.md](FILE_OWNERSHIP.md) F-3.

## 3. There is no server-side session on the storefront — at all

```
$ grep -c '$_SESSION' *.php      # every root storefront page
about-us.php 0   account.php 0   cart.php 0     checkout.php 0   index.php 0
product.php 0    reseller.php 0  retailer.php 0 shop.php 0       wholesale.php 0  wishlist.php 0
```

**Zero.** Identity, cart, wishlist, wallet and the entire B2B gate are client-side only. Measured
`localStorage` keys (storefront, excluding admin):

| Key | Sites | Holds |
| :--- | ---: | :--- |
| `dtbrands_user` | 64 | the signed-in identity **and its `type`, which selects the price tier shown** |
| `dtbrands_cart` | 39 | line items |
| `dtbrands_wishlist` | 29 | wishlist (the `wishlist_items` table is never written) |
| `dtbrands_wallet_cash` | 6 | reseller wallet balance |
| `dtbrands_recently_viewed` | 5 | |
| `reseller_customers_db` | 3 | the reseller's own CRM roster |
| `dtbrands_saved_address` | 2 | |

Consequences, stated exactly:

- Anyone can set `dtbrands_user.type = 'wholesale'` in DevTools and **see** mill rates and the
  wholesale UI. `wholesale.php`, `reseller.php`, `retailer.php` and `account.php` will render.
- They **cannot buy** at that rate. `OrderManager::resolveChannel()` re-reads the tier from
  `customers` server-side ([BACKEND.md](BACKEND.md) §4, [API.md](API.md) §5).
- Signing out on one tab does not sign out another until it reloads; clearing site data logs the
  customer out and loses the wishlist permanently.

This is [SECURITY.md](SECURITY.md) SEC-6 — the single largest architectural gap on the storefront.
Fixing it means adding `Auth::initSession()` + a server-side tier read to each B2B page, which is a
scoped project, not a side effect of another task.

## 4. API surface consumed by the storefront

`/api/products.php` (25 call sites) · `/api/customers.php` (15) · `/api/auth.php` (13) ·
`/api/orders.php` (7) · `/api/reviews.php` (5) · `/api/coupons.php` (5) · `/api/whatsapp.php` (4) ·
`/api/cart.php` (3) · `/api/wishlist.php` (1). Every call is a bare `fetch()` with no CSRF token
([API.md](API.md) §7).

## 5. Asset wiring and the three dead stylesheets

| Asset | Bytes | Consumers |
| :--- | ---: | :--- |
| `assets/css/header.css` | 13,409 | **none** |
| `assets/css/main.css` | 10,920 | **none** |
| `assets/css/modals.css` | 10,600 | **none** |
| `assets/js/core.js` | 6,503 | **none** |
| `assets/js/header.js` | 7,377 | **none** |
| `assets/js/modals.js` | 42,584 | 3 |
| everything else | | exactly the one page named in §1, except `shop.css` (5 pages) |

`header.css` / `header.js` were written for the unreferenced `includes/header.php`; they are dead
for the same reason. `includes/shophader.php` — the header that *is* live — carries its own inline
styles and references no external asset.

**Cache-busting is inconsistent and mostly self-defeating.** 1,009 occurrences of
`?v=<?php echo time(); ?>` / `?v=<?= time() ?>` remain across the tree against only 11 static
`?v=1787019062` stamps. `index.php`, `reseller.php` and `retailer.php` carry **both** —
`home.css?v=1787019062&v=<?php echo time(); ?>` — so the URL changes every second and
`mod_expires` (1 month, `.htaccess`) never applies. `shop.php`, `product.php` and `wholesale.php`
got the static stamp alone and do cache correctly. Weight involved: `reseller.js` 351 KB,
`reseller.css` 271 KB, `retailer.js` 215 KB, `home.css` 207 KB. See
[PERFORMANCE.md](PERFORMANCE.md).

## 6. The three B2B pages are the largest and least trustworthy surfaces

`wholesale.php` (2,706 lines), `reseller.php` (4,051), `retailer.php` (2,753) plus their JS
(204 KB / 351 KB / 215 KB) hold most of the project's business rules **in the browser**: lot sizes,
tier discounts, margin display, repeat-order totals, proforma generation. They also still contain
fabricated identities and merchandise that read as real data. Full inventory in
[BUSINESS_LOGIC.md](BUSINESS_LOGIC.md) and [KNOWN_ISSUES.md](KNOWN_ISSUES.md); the headline items:

- A fixed trade identity — 'Shree Krishna Silks Pvt Ltd', a GSTIN, 'Rajesh Kumar', Millennium
  Textile Market, 395002 — rendered by `renderAddressBookData()` and the proforma text in all three
  files, with `handleSaveAddress()` able to **persist** it.
- `handleSaveGstProfile` is **called but never defined** — `wholesale.php:940`,
  `reseller.php:1092`, `retailer.php:981`. The GST profile form throws on submit.
- Hardcoded `<option value="KLN-WS-8021">` SKU selects and
  `.ws-cat-prog-name "Pure Silk & Zari Sarees (HSN 5007)"` progress bars in all three pages.
- An invoice GSTIN literal at `wholesale.php:2138`, `reseller.php:2722`, `retailer.php:2185`.
- `assets/js/reseller.js` declares **11 names more than once** — later ones win silently, and the copies
  are not identical: `getWholesaleTier():840` uses `800/450/250/50` order thresholds, the winning
  `:3083` uses `1000+` for Tier 5. The file parses; this is not a `SyntaxError`. KI-21.

## 7. Conventions for storefront work

- **Design system is fixed by `AGENTS.md`**: gold `#8A681F` / `#D4AF37` / `#B8860B`, obsidian
  `#181512`, Inter + Plus Jakarta Sans, **inline SVG icons only** (no icon font, no CDN), the INR
  `₹` as an SVG, `.dt-btn-{gold,dark,emerald,pale,info}`, and the `@property --dt-border-angle`
  animated focus border. Details in [UI_SYSTEM.md](UI_SYSTEM.md).
- Add page-specific CSS/JS to that page's own file. Do **not** revive `main.css` or `core.js` to
  hold shared code without recording the decision in [DECISIONS.md](DECISIONS.md).
- Any new `<link>`/`<script>` should use the static `?v=` stamp, not `time()`.
- Never invent a product, customer, order, tracking number, GSTIN or review to fill an empty state.
  An honest empty state is the house style — `ProductCatalog` and `CustomerManager` were rewritten
  specifically to enforce it ([BACKEND.md](BACKEND.md) §5, §6).
- Absolute paths start at `/`. There are **16 remaining `/DT%20Brand/…` path prefixes**, all in
  admin JS (`admin/Asset/js/admin.js` ×6, `admin/orders/assets/js/order-view.js` ×6,
  `order-list.js`, `refunds.js`, `returns.js`, `wholesale-segments.js`); they 404 on live because
  the repo's `DT Brand/` **is** the web root. Do not confuse these with the 9 legitimate
  `…%20DT%20Brand%27s…` occurrences inside `wa.me` message text, which are correct.


