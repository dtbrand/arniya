# UI SYSTEM

> The visual layer: 1.42 MB of hand-written CSS across 87 files, 2,228 inline SVG icons, no framework,
> no build step, no preprocessor, no icon font. Measured 2026-08-29 from tracked files in
> `DT Brand/`. Brand rules that must not drift are fixed by `AGENTS.md`; this document records what
> the code actually does.

---

## 1. Two design systems under one brand

There is no shared stylesheet between the storefront and the admin console. They are two independent
token sets that happen to agree on the brand gold:

| | Storefront | Admin console |
| :--- | :--- | :--- |
| Entry stylesheet | one per page (`home.css`, `shop.css`, …) | `admin/Asset/css/admin.css` (136,642 B) on every page |
| Token prefix | unprefixed (`--gold-primary`, `--dark-bg`) and `--ws-*` | `--adm-*` |
| Chrome | each page prints its own header/footer | `admin/Includes/adminheader.php` (55,038 B) + `adminsidebar.php` (88,322 B) + `adminfooter.php` (4,721 B) |
| Primary font | `Plus Jakarta Sans` / `Inter` | `Inter`, then `Plus Jakarta Sans` |
| Display font | `Cinzel` | `Cinzel` |

**13 `:root` blocks** declare tokens, and the families in use across the tree are:

| Prefix | Occurrences | Owner |
| :--- | ---: | :--- |
| `--ws-*` | 1,232 | the three B2B pages — see §5 |
| `--dark-*` | 708 | storefront `main.css` / `home.css` |
| `--adm-*` | 466 | admin console |
| `--dt-*` | 387 | shared component layer (buttons, animated border) |
| `--font-*` `--gold-*` `--off-*` `--mid-*` `--soft-*` `--light-*` `--deep-*` | 786 combined | storefront |
| `--co-*` `--ac-*` `--prog-*` | 337 | page-local, undocumented |

A change to "the brand gold" therefore has to be made in at least four namespaces. There is no single
token file to edit, and introducing one is a project, not a side effect of another task.

## 2. The four token systems, quoted

**`admin/Asset/css/admin.css:10-69`** — the largest and the only one that covers a whole surface.
~60 tokens: gold `#8A681F` / `#5A4210` / `#C5A859` / `#D4AF37` / `#FAF5E8`; obsidian `#100E0C` /
`#171411` / `#221E19` / `#2E2922`; canvas `#F8F6F0`; and the layout constants every admin page
depends on — `--adm-sidebar-w: 240px`, `--adm-sidebar-collapsed-w: 68px`, `--adm-header-h: 64px`.
Changing those three breaks the sidebar collapse in `adminsidebar.php` and the sticky offset in
every module.

**`assets/css/home.css:5-29`** — storefront, unprefixed: `--off-white: #F8F6F0`,
`--dark-gold: #8A681F`, `--font-serif: 'Cinzel'`, `--font-sans: 'Inter','Montserrat'`,
`--header-h: 64px`, `--bottom-bar-h: 68px`. The two height tokens are the mobile bottom bar's
contract; a page that omits them loses its footer clearance.

**`assets/css/main.css:6-39`** — a *third* system, also unprefixed, with different names for the
same colours: `--gold-primary: #8A681F`, `--gold-radiant: #D4AF37`, `--dark-bg: #181512`,
`--bg-main: #FDFBF7`. `main.css` is **not** dead — see §7.

**`--ws-*`** — declared identically in three files, §5.

**The one value all four agree on is `#8A681F`.** Everything else — the dark background in
particular (`#100E0C` admin, `#181512` main.css) — differs per system. When a task says "match the
brand", `#8A681F` is the anchor; do not assume any other hex is shared.

## 3. Typography

Loaded from Google Fonts by `<link>` in each page head; no self-hosting, no `font-display`
override, no subsetting. `family=` occurrences across the tree:

| Font | Hits | Role |
| :--- | ---: | :--- |
| `Plus Jakarta Sans` | 232 | body text, both surfaces |
| `Cinzel` | 79 | display / brand wordmark — the ARNIYA serif |
| `Inter` | 49 | admin body, storefront fallback |
| `Montserrat` | 5 | residue in `home.css`'s `--font-sans` stack |

`Cinzel` is the brand signal and is fixed by `AGENTS.md`. `Montserrat` at 5 hits is vestigial; it is
listed in a fallback stack and never loaded on most pages, so text falls through to `Inter`.

## 4. Icons and the rupee glyph

**There is no icon library.** No font-awesome, no bootstrap-icons, no material-icons, no feather, no
lucide — zero references of any kind. Every icon is an inline `<svg>`: **2,228 of them across 276
files**, pasted at the point of use.

Consequences to work with rather than against:

- An icon cannot be "changed once". The same glyph is duplicated wherever it appears, so a swap is a
  find-and-replace across pages, and a *partial* swap is the normal failure mode.
- Icons inherit `currentColor` in most places, which is why they follow the gold tokens without extra
  rules. Preserve that when adding one — a hardcoded `fill="#8A681F"` will not follow a theme change.
- Adding an icon font now would mean 2,228 replacements. That is a project, not a cleanup.

**Rupee.** `₹` appears as a **literal UTF-8 character 1,830 times** and as `&#8377;` **27 times**.
`&rupee;` (which is not a valid HTML entity) appears zero times — good. The literal is correct
because every page declares `charset=utf-8`; the 27 entity uses are harmless inconsistency. Use the
literal `₹` in new code to match the 98.5 % majority.

## 5. The `--ws-*` block is triplicated byte-for-byte

`assets/css/wholesale.css`, `assets/css/reseller.css` and `assets/css/retailer.css` each open with an
**identical** `:root` block (from line 2, 8-space indented — they were extracted from inline
`<style>` blocks and never re-indented):

```css
--ws-gold-primary: #8A681F;
--ws-gold-accent:  #C5A859;
--ws-gold-deep:    #5A4210;
--ws-font-sans:    'Plus Jakarta Sans', …;
--ws-font-serif:   'Cinzel', serif;
```

Three problems, in order of how likely they are to bite:

1. **A token edit must be made three times.** The prefix is `--ws-` (wholesale) but it also styles
   the reseller and retailer pages, so an agent grepping for "reseller tokens" finds nothing and
   invents a fourth namespace.
2. These are the three largest storefront stylesheets — 271,064 + 201,596 + 193,304 B = 666 KB of the
   1.42 MB total — and each is loaded by exactly one page (§7).
3. Extracting the shared block into one file is safe *only* if all three continue to load it before
   their own rules; the cascade order matters because each file later re-declares page-local `--co-*`
   and `--prog-*` values.

## 6. Components — the button family and the animated border

`.dt-btn-*` is the closest thing to a component library. Definition counts (not usages):

| Variant | Defs | | Variant | Defs |
| :--- | ---: | :--- | :--- | ---: |
| `action` | 44 | | `danger` | 8 |
| `gold` | 19 | | `sm` | 5 |
| `pale` | 18 | | `whatsapp` | 2 |
| `emerald` | 18 | | `rose` | 2 |
| `dark` | 18 | | `primary` | 2 |
| `info` | 8 | | `blue` | 2 · `lg` | 1 |

A count above 1 means the variant is **re-declared in that many stylesheets**, each free to drift.
`.dt-btn-action` at 44 is the worst: it is the default admin row button, so a padding change applied
in one module silently disagrees with the other 43. Before restyling a button, grep the variant name
and decide whether you are changing one module or all of them — the answer is almost never "all"
by accident.

**`@property --dt-border-angle` is declared 10 times**, including **twice inside one file**:

| File | Line |
| :--- | ---: |
| `admin/Asset/css/admin.css` | `:263` **and** `:631` |
| `admin/customers/assets/css/customers.css` | `:40` |
| `admin/customers/edit.php` | `:286` |
| `admin/customers/new.php` | `:106` |
| `admin/products/assets/css/product-form.css` | `:577` |
| `admin/resellers/assets/css/resellers.css` | `:36` |
| `admin/retail/assets/css/retail.css` | `:17` |
| `admin/wholesale/assets/css/wholesale.css` | `:35` |
| `assets/css/main.css` | `:50` |

`@property` is registered globally per document, so a duplicate declaration is not an error — the
last one parsed wins. It does mean the rotating-gradient border can be silently redefined by
whichever module loads later, and the two declarations inside `admin.css` are pure redundancy. This
is cosmetic; it is recorded so nobody debugs it twice.

## 7. Which page loads which asset — verified, not inferred

This map was built by reading the `<link>` and `<script>` tags in each page, after a basename grep
produced false positives (`/admin/wholesale/assets/css/wholesale.css` contains
`assets/css/wholesale.css` as a substring, which credited the storefront file with 29 referrers when
it has 1).

| Page | CSS | JS |
| :--- | :--- | :--- |
| `index.php` | `home.css` | `home.js` |
| `shop.php` | `shop.css` | `shop.js` |
| `product.php` | `singleproduct.css` | `singleproduct.js` |
| `cart.php` `checkout.php` `wishlist.php` `about-us.php` | `shop.css` | — |
| `account.php` | **none** | **none** |
| `wholesale.php` | `wholesale.css` | `wholesale.js` + `profile-save.js` |
| `reseller.php` | `reseller.css` | `reseller.js` + `profile-save.js` |
| `retailer.php` | `retailer.css` | `retailer.js` + `profile-save.js` |

`account.php` links **no external CSS or JS at all** — everything is inline. That is why a change to
a storefront stylesheet never affects it, and why it is the one page where a shared-component fix
must be applied by hand.

Largest stylesheets: `reseller.css` 271,064 · `home.css` 207,162 · `retailer.css` 201,596 ·
`wholesale.css` 193,304 · `admin/Asset/css/admin.css` 136,642 · `singleproduct.css` 64,657 ·
`shop.css` 61,070. Largest B2B pages, which embed most of their own markup:
`reseller.php` 328,591 B / 4,051 lines · `retailer.php` 215,862 / 2,753 ·
`wholesale.php` 212,320 / 2,706. B2B JS totals ≈ 752 KB (`reseller.js` 351,469 /
`retailer.js` 214,923 / `wholesale.js` 204,015 / `modals.js` 42,584 / `profile-save.js` 8,064).

Nothing is minified, bundled or cache-busted. A CSS edit ships as-is and is subject to browser cache
only — see [PERFORMANCE.md](PERFORMANCE.md).

## 8. Dead UI assets — and four that look dead and are not

**Confirmed dead, 73,163 B total.** Zero live referrers each; the only "references" to `modals.js`
are two *comments* (`api/products.php:30`, `shared/quickview_modal.php:7`), and the second is itself
in a dead file:

| File | Bytes | Lines |
| :--- | ---: | ---: |
| `assets/js/modals.js` | 42,584 | 923 |
| `assets/css/modals.css` | 10,600 | 409 |
| `assets/js/header.js` | 7,377 | 176 |
| `assets/js/core.js` | 6,503 | 167 |
| `shared/quickview_modal.php` | 6,099 | 104 |

**Do NOT delete these four — an inherited list said they were dead and they are not:**

- **`assets/css/main.css`** — loaded by `admin/categories.php:77`, `admin/orders.php`,
  `admin/products.php`. It is a *storefront* stylesheet three admin pages depend on.
- **`assets/css/header.css`** — same three pages (`admin/categories.php:78`).
- **`shared/quickview.php`** — required by `index.php`, `product.php`, `shop.php`, `wholesale.php`,
  `reseller.php`, `retailer.php`. Six live pages. Only the `_modal` sibling is dead.
- **`assets/js/modals.js`'s free-shipping constant is mirrored in a live file** — see below.

**18 admin CSS files are under 100 B**: one-line comment stubs, e.g. `admin/cms/cms.css` contains
only `/* cms.css - DT Brand's Admin Cms Module Styles */`. They are linked by their modules, so they
are not dead — they are placeholders. Deleting them breaks the `<link>`; emptying them is a no-op.

**One live duplicate worth knowing about.** `DT_FREE_SHIP_OVER = 1999` at `assets/js/modals.js:756`
is dead, but `QV_FREE_SHIP_OVER = 1999` at `shared/quickview.php:555` is **live on six pages** and is
a browser copy of a server value. See [BUSINESS_LOGIC.md](BUSINESS_LOGIC.md) §3 for the full list of
`1999` occurrences and which ones are coincidental — several are `z-index` and a coupon
`min_order_value`, and unifying them would be a bug.

## 9. Admin chrome

Every admin page prints the same three includes, and they are large because they carry markup, CSS
and JS inline:

| Include | Bytes | Contains |
| :--- | ---: | :--- |
| `admin/Includes/adminsidebar.php` | 88,322 | the full navigation tree + collapse behaviour |
| `admin/Includes/adminheader.php` | 55,038 | topbar, search, notification bell, `<head>` and token block |
| `admin/Includes/adminfooter.php` | 4,721 | closing markup + a telemetry strip |
| `admin/Includes/adminguard.php` | 3,348 | the auth gate — [SECURITY.md](SECURITY.md) SEC-10 |

`adminheader.php` and `adminfooter.php` both contain **fabricated display values** that appear on
~190 pages: `adminfooter.php:15,18,20` fake telemetry, `adminheader.php:624` a hardcoded
"🔔 3 new wholesale orders received today!", `:755` a demo search array, `:760` a demo product price.
They are listed in [KNOWN_ISSUES.md](KNOWN_ISSUES.md) — a fix there is high-leverage because it lands
on every page at once, and correspondingly high-risk for the same reason.

Layout depends on `--adm-sidebar-w: 240px`, `--adm-sidebar-collapsed-w: 68px` and
`--adm-header-h: 64px` from `admin.css:10-69`. Those three are a contract between the stylesheet and
the sidebar's JS toggle; change them together or not at all.

## 10. Charts are hand-drawn canvas

There is no Chart.js, no D3, no charting dependency of any kind. Every graph in the admin console is
drawn with the 2D context directly. Two rules that came out of fixing them:

- Set the device-pixel ratio with `ctx.setTransform(dpr, 0, 0, dpr, 0, 0)`, **never**
  `ctx.scale(dpr, dpr)` — `scale()` compounds across redraws and the chart shrinks on every
  re-render.
- Each canvas needs an explicit "no data yet" text path. An empty dataset must draw that string, not
  an empty axis, or the widget reads as broken. See [ADMIN.md](ADMIN.md).

## 11. Rules for adding or changing UI

1. **Find out which system you are in first.** Admin → `--adm-*` in `admin/Asset/css/admin.css`.
   B2B storefront → `--ws-*`, and remember the edit must be made in all three files (§5). Retail
   storefront → the unprefixed tokens, and check whether the page uses `home.css` or `main.css`,
   because they name the same colours differently (§2).
2. **`#8A681F` is the only cross-system constant.** Do not assume any other hex is shared.
3. **Grep the class name before restyling it.** A `.dt-btn-*` variant is re-declared in up to 44
   stylesheets (§6); changing one file changes one module.
4. **Add icons as inline `<svg>` inheriting `currentColor`.** No icon library, no new dependency —
   2,228 existing icons set the pattern.
5. **Use the literal `₹`.** All pages are UTF-8; the 27 `&#8377;` uses are the minority.
6. **Never delete a stylesheet on a basename grep.** Verify the actual `<link href>` — the
   storefront/admin path collision produced a 29× false positive (§7), and `main.css`, `header.css`
   and `shared/quickview.php` were all wrongly listed as dead.
7. **Do not "unify" a repeated literal without reading each occurrence.** `1999` is a shipping
   threshold twice, a coupon minimum twice, a demo price twice and a `z-index` three times (§8).
8. **`account.php` has no external assets.** A shared-component change never reaches it
   automatically.
9. **Keep the storefront and admin token sets separate.** Merging them into one file is a project
   with its own testing pass across ~190 admin pages and 11 storefront pages, not a step inside
   another task. [DECISIONS.md](DECISIONS.md).
10. **There is no build step.** No minifier, no bundler, no cache-buster: whatever you write is what
    the browser fetches, and a stale cache is the user's first symptom of a CSS fix that "did not
    work".

