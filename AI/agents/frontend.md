# AGENT BRIEF · FRONTEND

> **Scope:** the 11 storefront pages at the root of `DT Brand/`, `includes/` (11 fragments), `shared/`
> (29 PHP partials) and the browser JS that drives them. Admin UI is [admin.md](admin.md); tokens,
> typography and CSS architecture are [ui-ux.md](ui-ux.md).
>
> Read with [FRONTEND.md](../FRONTEND.md) and [FILE_OWNERSHIP.md](../FILE_OWNERSHIP.md) §2 and §6.

---

## 1. What you are working in

Every root page is a **self-contained monolith**: it opens its own PDO connection, prints its own HTML,
and owns its own copy of any shared behaviour. There is no layout, no template engine, no controller and
no build step. A page is the unit of change.

| Page | Assets | Note |
| :--- | :--- | :--- |
| `index.php` `shop.php` | `home.*` / `shop.*` | require `includes/shophader.php` + `shopbottomfotoer.php` |
| `product.php` | `singleproduct.*` | requires `singelproduthader.php`, `singelprodutbottomfotoer.php`, `product-not-found.php` |
| `cart.php` `checkout.php` `wishlist.php` `about-us.php` | `shop.css` | three of them use `singelprodutbottomfotoer.php` |
| `account.php` | **none — everything inline** | a shared-asset fix never reaches it |
| `wholesale.php` `reseller.php` `retailer.php` | `{name}.css` `{name}.js` + `profile-save.js` | 752 KB of JS; the `--ws-*` token block is triplicated |

**"Fix the storefront header" means editing two fragments plus three inline copies.**
`includes/shophader.php`, `includes/singelproduthader.php`, and the inline headers in `account.php`,
`wholesale.php`, `reseller.php`, `retailer.php`.

## 2. The two fragment traps

**In `includes/`, the misspelled files are the live ones.** Live: `shophader.php`,
`shopbottomfotoer.php`, `singelproduthader.php`, `singelprodutbottomfotoer.php`,
`product-not-found.php`. Dead: `header.php`, `footer.php`, `shopheader.php`, `shopfooter.php`,
`subnav.php`, `mobile_bottom_nav.php`. **A "fix the typo" commit breaks `index.php` and `shop.php`.**

**In `shared/`, 8 of 29 files are live** — `cart.php` and `wishlist.php` (10 requirers each),
`checkout.php` (9), and `account.php` `quickview.php` `reels.php` `smartshare.php`
**`size_chart_modal.php`** (6 each). Every other `*_modal.php` is dead, so a rule like "delete the unused
modal partials" breaks the product page. All 10 files in `shared/Includes/` are dead.

## 3. Rules for this domain

1. **A JS file that "does nothing" is usually a `SyntaxError`.** One duplicate top-level
   `let`/`const`/`class` kills the whole file and every handler in it. Run
   `node --check --input-type=commonjs < file` before reading anything — and **never** with
   `--input-type=module`: nothing in `DT Brand/` is a module, and module mode invents errors for legal
   duplicate `function` declarations. `reseller.js` has 11 of those and it **parses fine**
   ([KNOWN_ISSUES.md](../KNOWN_ISSUES.md) KI-21).
2. **A change that has no effect at all may be editing a shadowed copy.** A name declared twice resolves
   to the last declaration. `reseller.js` declares `getWholesaleTier()` at `:840` and `:3083` with
   **different VIP thresholds**, and the dead one is the one you find first. `grep -n 'function <name>'`
   the whole file before concluding it is a cache (KI-21).
3. **A `ReferenceError` instead means the handler was never defined.** `handleSaveGstProfile(event)` has
   **3 call sites and 0 definitions** — `wholesale.php:940`, `retailer.php:981`, `reseller.php:1092`.
   Because the `onsubmit` throws before returning `false`, the page also reloads, so the user reports "it
   just refreshes" (KI-7).
4. **The client-side tier is cosmetic only.** `localStorage.dtbrands_user.type` decides what prices are
   *shown*; the server re-derives the channel from `customers.type` on every order (D-4). Never let a
   price, total or channel from the browser reach a write.
5. **Never invent a display value.** No placeholder name, no plausible phone number, no synthesised order
   ID. A hardcoded roster once put real-format numbers in front of an admin who could WhatsApp a stranger
   (D-5). An empty field is correct; a plausible one is a defect.
6. **Mirror, never re-decide, a commercial rule.** Free shipping over ₹1999 lives in
   `config/shipping.php`; the live browser copy is `shared/quickview.php:555`
   (`QV_FREE_SHIP_OVER = 1999`). Change the authority and the mirror in the same commit — and leave the
   coincidental `1999`s alone (a coupon minimum ×2, a demo price ×2, a `z-index` ×3). D-11.
7. **No `/DT%20Brand/` in any URL.** On live, `DT Brand/`'s contents *are* the web root. 16 occurrences
   survive in 6 admin JS files (KI-10) — do not add a twelfth pattern to that list.
8. **All WhatsApp links use `917046363528`.** All 47 raw occurrences are already correct; only the display
   formatting varies (KI-17). Do not "fix" the number.
9. **No build step, no bundler, no cache-busting.** The file the browser fetched is the file on disk. Hard
   reload before believing a fix failed (D-2).

## 4. Verification

```bash
node --check --input-type=commonjs < "DT Brand/assets/js/shop.js"
```

```bash
/c/xampp/php/php.exe -l "DT Brand/product.php"
```

There is no MySQL here, so anything that renders from a query is **unverified until the owner uploads and
looks**. Say so. The manual checklist lives in [TESTING.md](../TESTING.md); the browser-side symptoms are
in [ERROR_RECOVERY.md](../ERROR_RECOVERY.md) §3.

## 5. When you need another brief

Prices, tiers or totals → [backend.md](backend.md) · endpoint contracts → [api.md](api.md) · tokens,
fonts, spacing → [ui-ux.md](ui-ux.md) · a column that does not exist yet → [database.md](database.md) ·
anything that writes a customer record → [security.md](security.md).

