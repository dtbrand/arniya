# AGENT BRIEF · UI/UX

> **Scope:** CSS, design tokens, typography, icons, spacing and interaction polish across both surfaces —
> 87 CSS files, 1.42 MB. Page structure and PHP are [frontend.md](frontend.md) / [admin.md](admin.md).
>
> Read with [UI_SYSTEM.md](../UI_SYSTEM.md) and [DECISIONS.md](../DECISIONS.md) D-12.

---

## 1. Preserve the ARNIYA identity

`Cinzel` for display, the gold **`#8A681F`**, the dark obsidian palette. This is a saree and textile brand
selling to retail customers and to mills; the visual language is the product. **Do not modernise it, do not
neutralise it, and do not introduce a UI framework or component library** — there is no build step (D-2).

Typography in use, measured: **Plus Jakarta Sans 232 references · Cinzel 79 · Inter 49 · Montserrat 5.**
Icons: **zero icon libraries, 2,228 inline `<svg>` elements across 276 files.** Currency: the `₹` literal
appears 1,830 times against 27 `&#8377;` — match the file you are in.

## 2. Four token systems, and they are not being unified

Thirteen `:root` blocks and four prefixes coexist: **`--ws-` 1,232 · `--dark-` 708 · `--adm-` 466 ·
`--dt-` 387**, plus two unprefixed storefront sets in `home.css:5-29` and `main.css:6-39`.

**`#8A681F` is the only value all four systems agree on.**

Unifying them touches ~190 admin pages and 11 storefront pages that share no layout to regression-test
through. It is **a project with its own testing pass, not part of another task** (D-12). Until then: work
inside the token system of the file you are in, and do not introduce a fifth.

The `--ws-*` block is **triplicated byte-for-byte** across `wholesale.css`, `reseller.css` and
`retailer.css` — 666 KB combined. A change to a `--ws-*` value means three files, in the same commit.

## 3. The admin chrome contract

`admin/Asset/css/admin.css:10-69` defines ~60 `--adm-*` tokens. Three are **a contract with the sidebar JS**,
not decoration:

| Token | Value |
| :--- | :--- |
| `--adm-sidebar-w` | `240px` |
| `--adm-sidebar-collapsed-w` | `68px` |
| `--adm-header-h` | `64px` |

Change one and layout moves on ~190 pages, because `admin/Includes/adminheader.php` and `adminfooter.php`
are included by all of them.

Also note `@property --dt-border-angle` is declared **10 times**, twice inside `admin.css` alone (`:263`,
`:631`). A duplicate `@property` is not an error but it is a sign you are editing a copy.

## 4. Before you touch a stylesheet: verify the reference by full path

`admin/wholesale/assets/css/wholesale.css` is a **different file** from `assets/css/wholesale.css`. The
storefront path is a substring of the admin one, so a basename grep credited the storefront file with 29
referrers when it has **1** (D-9).

```bash
grep -rn 'href="[^"]*assets/css/main.css"' "DT Brand" --include=*.php
```

Four files that **look dead and are not**: `assets/css/main.css` and `assets/css/header.css` (linked by
`admin/categories.php`, `admin/orders.php`, `admin/products.php` — so they are **storefront *and* admin
owned**), `shared/quickview.php` (live on 6 storefront pages, and holds `QV_FREE_SHIP_OVER = 1999`), and
`shared/size_chart_modal.php` (live on 6, despite every other `*_modal.php` being dead).

Genuinely dead UI assets, **73,163 B**: `assets/js/{modals,core,header}.js`, `assets/css/modals.css`,
`shared/quickview_modal.php`. Both apparent referrers of `modals.js` were **comments**. Keep them on disk;
they are classified, not condemned ([FILE_OWNERSHIP.md](../FILE_OWNERSHIP.md) §10).

And **`account.php` links nothing external** — everything is inline. A shared-asset fix never reaches it.

## 5. Rules for adding UI

1. **Match the page's existing token system**; add a token only if the value recurs, and add it to that
   file's `:root`, not a new one.
2. **Reuse a `.dt-btn-*` variant** — `action` 44 uses, `gold` 19, `pale` / `emerald` / `dark` 18 each — before
   inventing a class.
3. **No icon library, no webfont icon.** Inline the `<svg>`, as the other 2,227 do.
4. **Accessibility is not optional:** a real focus state, a label on every control, contrast against the
   obsidian background, and a hit target that works on a phone. Most B2B traffic here is mobile.
5. **Charts are hand-drawn `<canvas>`.** `ctx.setTransform(dpr, 0, 0, dpr, 0, 0)`, never
   `ctx.scale(dpr, dpr)` — `scale` compounds and the chart shrinks on every redraw (`UI_SYSTEM.md` §10).
6. **An empty state must say it is empty.** Never render a plausible placeholder number, name or phone —
   this is D-5, learned from live damage, and it is a UI rule as much as a backend one.
7. **No cache-busting exists.** Tell the owner to hard-reload; do not add a query string to one file and
   call it a system.
8. **Do not rename a misspelled file.** In `includes/` the misspellings are the live ones.

## 6. Verification

```bash
/c/xampp/php/php.exe -l "DT Brand/shared/quickview.php"
```

```bash
node --check --input-type=commonjs < "DT Brand/assets/js/home.js"
```

CSS has no linter here and **no visual check is possible** — no browser, no live access. So: state which
pages the change reaches (name them), what you verified statically, and that appearance is **unverified until
the owner uploads and looks**. For a change to a triplicated token or a ~190-page component, say the page
count explicitly in the report.

