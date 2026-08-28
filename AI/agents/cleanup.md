# AGENT BRIEF · CLEANUP

> **Scope:** dead code, duplicates, fabricated placeholder data and the 18 empty CSS stubs. **379,197 B of
> unreachable code is already classified** and none of it is authorised for deletion by any document.
>
> Read with [FILE_OWNERSHIP.md](../FILE_OWNERSHIP.md) §10, [KNOWN_ISSUES.md](../KNOWN_ISSUES.md) KI-3 and
> KI-15, and [DECISIONS.md](../DECISIONS.md) D-9.

---

## 1. Cleanup is priority 9 of 10

The settled order is D-13: **existing working business logic → the owner's explicit request → security →
data integrity → existing architecture → UI/UX consistency → performance → maintainability → cleanup → new
improvements.**

So cleanup happens **as its own task, with an explicit instruction**, and never inside another one. A tidy-up
folded into a bug fix destroys the evidence for that bug and widens the blast radius of a change nobody asked
to be wide.

## 2. The classification gate — no file dies on a grep

Six classes, evidence written down for each (D-9):

**EXACT DUPLICATE** · **FUNCTIONAL DUPLICATE** · **LEGACY** · **INTENTIONALLY DIFFERENT** · **UNUSED** ·
**UNKNOWN**

Anything landing in UNKNOWN **stays on disk** and goes to `KNOWN_ISSUES.md` with what you found.

**Three wrong conclusions were reached by grep during this audit** — this is the receipt list, and it is why
the gate exists:

1. `assets/css/wholesale.css` was credited with 29 referrers because
   `/admin/wholesale/assets/css/wholesale.css` contains it as a substring. True count: **1**.
2. `assets/css/main.css` and `header.css` were listed dead while **three admin pages link them**;
   `shared/quickview.php` was listed dead while **six storefront pages require it**.
3. Both apparent referrers of `assets/js/modals.js` turned out to be **comments**.

Verify by **full path**, exclude comments, then decide:

```bash
grep -rn 'includes/shophader.php' "DT Brand" --include=*.php | grep -v '^\s*//' 
```

## 3. The classified inventory — 379,197 B

| Class | Files | Bytes | Where |
| :--- | ---: | ---: | :--- |
| UNUSED | 21 | 284,436 | `shared/` — `Auth/myaccount.php`, **all 10 in `shared/Includes/`**, and 10 root partials |
| UNUSED | 6 | 21,598 | `includes/` — `header.php` `footer.php` `shopheader.php` `shopfooter.php` `subnav.php` `mobile_bottom_nav.php` |
| UNUSED | 5 | 73,163 | `assets/js/{modals,core,header}.js`, `assets/css/modals.css`, `shared/quickview_modal.php` |
| UNUSED | 7 | — | `config/` except `shipping.php` |
| FUNCTIONAL DUPLICATE | 1 | — | `admin/adminlogin.php` — 738 lines, identical to `login.php` bar comments, **zero inbound links, still URL-reachable** (SEC-12) |
| LEGACY | 3 | — | `database/schema.sql`, `database/seeders.sql`, `database/migrations/2026_08_25_production_upgrade.sql` |
| INTENTIONALLY DIFFERENT | 2 | — | `api/_guard.php` fails **closed**, `adminguard.php` fails **open** — D-3, **never unify** |
| UNKNOWN | 18 | <1,800 | the one-line admin CSS stubs — linked, so not dead; empty, so not doing anything |

**Three traps inside that table.** In `includes/`, **the misspelled files are the live ones** — a "fix the
typo" commit breaks `index.php` and `shop.php`. Every `shared/*_modal.php` is dead **except
`size_chart_modal.php`**, live on 6 pages. And `shared/db.php` / `shared/logger.php` are dead *files*, not
dead *ideas* — `Database.php` is the live equivalent, so removing them removes nothing that works.

**`config/database.php` is the cleanest single deletion in the repo** — zero readers, and it leaks live
credentials for no purpose. But it belongs to SEC-1 and D-7, not to a cleanup sweep: it goes when the
credential sequence goes.

## 4. Fabricated data — the other half of this brief

**Never invent a display value; never leave one standing.** This is D-5, and it was learned from live damage:
a hardcoded roster put invented names and **real-format phone numbers** in front of an admin who could click
"WhatsApp Connect" and message a stranger (`CustomerManager.php:11-15`).

Still outstanding, catalogued as KI-3a…3e:

- **3a, server-side:** `OrderManager::getAll():627` synthesises `'DEL-' . rand(10000, 99999)` for untracked
  orders across **13 call sites**, and returns two complete demo orders when the query is empty (`:638-675`).
- **3b:** `admin/Includes/adminheader.php` and `adminfooter.php` ship fabricated values onto **~190 pages**.
- **3c:** admin modules including `admin/resellers/` segments; **3d:** storefront and B2B JS, including
  `product.php`'s hardcoded review counts and `reseller.js:5133`'s invented `p.moq || 8`.
- **3e, the worst:** the fabricated-identity cluster where `handleSaveAddress()` can **persist** it.

Removing a fabricated value means the field goes **empty and says so** — not a nicer fake, not a zero
pretending to be data. Commit `baf2ac6` claimed to remove "all remaining" hardcoded metrics and ~30 sites
survived; **the sweeps were real, the "all" was aspirational** ([CHANGELOG.md](../CHANGELOG.md) §3).

Also in this family: **KI-1's three seed orders, three seed customers and two seed reviews are
indistinguishable from production data**, and the `id IN (1,2,3)` cleanup is **deliberately unrun** — no
`DELETE` runs from here, ever.

## 5. Rules

1. **An explicit instruction per deletion**, plus the classification and the evidence. No batch "remove dead
   files" commits.
2. **Never `DROP` / `TRUNCATE` / unconditioned `DELETE`.** Not even seed rows (KI-1).
3. **Do not rename to fix a spelling.** If a rename is genuinely wanted, the requiring pages change in the
   same commit.
4. **Deleting a file is a deployment event** — the owner must also remove it from the server. Say so.
5. **Update the classification in place** when you learn something; never delete a `KI-n`. Append, never
   renumber.

## 6. Verification

```bash
grep -rn 'shared/size_chart_modal.php' "DT Brand" --include=*.php
```

```bash
find "DT Brand" -name '*.php' -print0 | xargs -0 -P 8 -n 1 /c/xampp/php/php.exe -l 2>&1 | grep -v "No syntax errors"
```

Full-path greps and the lint sweep are all that runs here. **A removal cannot be runtime-verified** (no MySQL,
no browser, no live access) — so the report says which pages *should* be unaffected and that it is
**unverified until the owner uploads**.

