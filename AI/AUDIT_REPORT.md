# AUDIT REPORT

> Repository-wide audit of **ARNIYA / DT Brand's & Jai Hanuman Tex**, `DT Brand/` (GEN-C, the live tree).
> Completed **2026-08-29**. 695 tracked files: 452 PHP, 105 JS, 87 CSS, 36 images, 7 md, 6 sql, 1 svg,
> 1 `.htaccess`.
>
> **Method:** static only — `/c/xampp/php/php.exe -l`, `node --check`, full-path greps, and git history.
> **There is no MySQL and no route to live in this environment**, so nothing DB-dependent was executed.
> Every finding below is marked with how it was established. §8 lists what could not be checked at all.
>
> **No credential value appears in this document, and none may be added.** Findings reference a secret by
> file, line and variable name only. Numbering: `C-n` `H-n` `M-n` `L-n` `I-n` — **append, never renumber.**

---

## 1. Summary

| Severity | Count | Character |
| :--- | ---: | :--- |
| **CRITICAL** | 7 | remotely exploitable today; 4 of the 7 are closed by the owner, not by code |
| **HIGH** | 12 | wrong money, wrong data shown to an admin, or a whole file silently dead |
| **MEDIUM** | 10 | a feature that reaches nothing, or debt with a real cost |
| **LOW** | 6 | documentation drift and cosmetic inconsistency |
| **IMPROVEMENT** | 8 | worth doing, each as its own task |

**The headline is not a bug.** The four highest-value items in this repository are **credential rotation and
environment configuration**, and no code change closes any of them — they need the owner
([DECISIONS.md](DECISIONS.md) D-7). The highest-value *code* fix is **C-4**: four money-path values still
arrive raw from a public endpoint.

**The second headline:** this project is in better shape than a first read suggests. The asymmetric guards,
the public order endpoint, the offline admin path and the surviving second and third generations are all
**deliberate decisions with recorded reasoning** (D-1, D-3, D-4, D-6). They are listed in §7 so they are not
"fixed" by the next agent. A large amount of what looks like carelessness is a one-person business making
correct trade-offs on shared hosting.

## 2. CRITICAL

### C-1 · Live MySQL credentials are plaintext in six tracked locations

**Evidence** (verified by grep; values withheld): `AGENTS.md:242-248`, and as `getenv('…') ?: '<literal>'`
fallbacks at `src/Database.php:23-27`, `config/database.php:16`, `database/migrate.php:20-24` and `:162`,
`api/db_health.php:31-34`. **Because they are fallbacks, the literal is what live is using now.**

**Impact.** The repository is on GitHub. Anyone with read access has the live database name, user and
password. Changing the files does not help — **git history retains them**.

**Fix, in the owner's chosen order (D-7):** rotate in hPanel → set the eight env vars → confirm on live with
a **length-only** probe → *then* delete the fallback halves. Removing a fallback first takes the site down.
There is **no `.env` loader**, so a `.env` file achieves nothing. History purge (`filter-repo`/BFG) is the
owner's separate decision. **Owner. Blocking. SEC-1.**

### C-2 · The admin master password is a committed, self-healing super-admin key

**Evidence.** `src/Auth.php:286` and `:301` compare against `getenv('ADMIN_PASSWORD') ?: '<literal>'`. On a
match the `users` row is **re-stamped on every sign-in** — hash, `role='super_admin'`, `status='active'`
(`:317-334`) — and if MySQL is unreachable the session is granted anyway (`:363`).

**Impact.** A permanent skeleton key that **survives a password change and an account suspension**, and works
during a database outage. `api/health.php` publicly announces when that offline path is live (see H-7).

**Fix.** Move to `ADMIN_PASSWORD` and **change the value**. **Do not delete the offline path** — it is the
owner's lockout insurance and its retention is a recorded decision (D-6). This is also the last blocker on
C-1 step 4. **Owner. SEC-2.**

### C-3 · A GitHub token is embedded in the `origin` remote URL

**Evidence.** `.git/config`, `[remote "origin"]` URL. Value withheld.

**Impact.** Push access to the repository for anyone who reads that file or a copy of the working tree.

**Fix.** Revoke the token, then re-point `origin` at SSH or use a credential helper. **Owner. SEC-1.**

### C-4 · Four money-path values are taken raw from a public endpoint

**Evidence.** `OrderManager::createOrder()` re-derives channel, unit price, subtotal, coupon and customer
(D-4) — but `shipping` (`:296`), `gst_rate` (`:297`), `payment_status` (`:310`) and `fulfillment_status`
(`:311`) are used as posted. `payment_status` **defaults to `'paid'` with no ENUM whitelist**, and
`api/orders.php:202-224` create is reachable without a session **by design**.

**Impact.** Self-marking an order paid; `gst_rate: 0`; a **negative `shipping`** to reduce the total. Because
one order write also decrements stock (`:453`) and increments `total_orders` / `lifetime_spend`
(`:456-466`), a forged order moves inventory and customer lifetime value — and a negative `grand_total`
*decreases* lifetime spend.

**Fix.** Whitelist both ENUMs, floor `shipping` at 0, and take `gst_rate` from `PricingCalculator` rather than
the request. **This is the highest-value code fix in the repository. Agent, on instruction. SEC-5.**

**Correction carried forward:** `gst_rate: -100` is **not** exploitable — `calculateGst()` throws on a
negative rate (`PricingCalculator.php:27-29`) and `api/orders.php:227` returns 500 with no row written. An
earlier draft of this documentation claimed otherwise.

### C-5 · Any throw inside the admin guard serves the page unauthenticated

**Evidence.** `admin/Includes/adminguard.php:70-74` — `catch (\Throwable) { return; }`, commented *"Never take
the admin console down on a guard failure."* Additionally the exemption test is a **substring** match
(`strpos($haystack, 'login')`), so **any URL containing `login` or `logout` is exempt outright**.

**Impact.** A session-handler hiccup, or a crafted URL containing `login`, renders an admin page without
authentication.

**Fix — narrow, and the fail-open behaviour stays.** The asymmetry with `api/_guard.php` (which fails
**closed**, `:44-60`) is a recorded decision and **a change that makes the console fail closed will be
reverted** (D-3). The authorised fix is: on the throw path render a static "sign in again" page instead of the
requested page, and replace the substring test with an **exact-path allowlist**. **Agent, on instruction.
SEC-10, SEC-11.**

### C-6 · The full production schema, with seed rows, is web-served

**Evidence.** `database/arniya_master_production.sql` — 18 `CREATE TABLE` statements plus every seed row —
sits under the web root with **no deny rule** in `.htaccess`.

**Impact.** Anonymous download of the complete data model and the seeded accounts.

**Fix.** A deny rule for `database/` (or at minimum `*.sql`). Note this is a whole-site `.htaccess` change and
can 500 the site — keep it minimal and tell the owner how to revert (re-upload the previous file).
**Agent + owner upload. SEC-4.**

### C-7 · An unauthenticated HTTP endpoint creates 16 database tables

**Evidence.** `api/db_audit.php` performs DDL when reached; `api/db_health.php` (`:31-34` credentials) also
**seeds rows**. Neither is behind `dt_api_require_admin()`, and the `db_health.php` install key is still
published in `MASTER_ARCHITECTURE_AUDIT.md` and `docs/`.

**Impact.** A stranger can trigger schema creation and seeding on live. This is the mechanism behind the
schema-drift hazard in KI-2, and it is why "which schema actually ran" is unresolved.

**Fix.** Guard both, or remove them from the deployed tree and run them locally only. Rotate/remove the
published install key. **Agent + owner. KI-2.**

## 3. HIGH

### H-1 · Three migrations never run, and the migrator reports as though they did

`database/migrate.php` executes **exactly one file** — `arniya_master_production.sql` — but
`migrate.php::status()` lists all three files in `database/migrations/` as `PENDING_OR_APPLIED`. Every column
that exists only in `2026_08_25_production_upgrade.sql` is **phantom**: present in the repository, absent on
live. This single ambiguity is behind H-2's phantom-column class, M-3 and M-8.
**Blocked on a `SHOW TABLES` / `SHOW COLUMNS` from the owner.** KI-4.

### H-2 · Fabricated display data still reaches admins, in ~30 places

Worst instance: `OrderManager::getAll():627` synthesises `'DEL-' . rand(10000, 99999)` as a courier tracking
number across **13 call sites** — a plausible ID, **different on every refresh**, that an admin can read out
to a customer — and returns **two complete demo orders** when the query is empty (`:638-675`). Also
`admin/Includes/adminheader.php` / `adminfooter.php` on **~190 pages**, `admin/resellers/` segments,
`product.php` review counts, and `reseller.js:5133`'s invented `p.moq || 8`. The cluster in KI-3e can
**persist** fabricated identity via `handleSaveAddress()`. Precedent for why this matters:
`CustomerManager.php:11-15` records a hardcoded roster that put real-format phone numbers in front of an admin
who could WhatsApp a stranger. KI-3a-3e, D-5.

### H-3 · The cart can quote a bigger discount than the order bills

`DiscountEngine::applyCoupon():81-83` caps a percentage discount at `max_discount` only.
`OrderManager::resolveCouponDiscount():54` **also clamps to the subtotal**. With
`discount_value=150, max_discount=0` the cart quotes **1.5 × subtotal**. One-line fix at
`DiscountEngine.php:80-84`, and **both implementations must change in the same commit**. Coupons also cannot
expire. KI-14, D-11.

### H-4 · `reseller.js` defines 11 functions twice, and the winning copy of the tier table disagrees with the dead one

**Corrected 2026-08-29.** An earlier version of this finding said a duplicate top-level declaration is a
`SyntaxError` that kills the whole 351 KB file. That is wrong for this file: all 11 duplicates are `function`
declarations, legal in a classic script, and the file parses. `node --check` on it as a script passes, there is
**no `type="module"` anywhere in `DT Brand/`**, and `reseller.php:4044` loads it with a plain `<script src>`. The
`SyntaxError` only appears under `--input-type=module`, which is not how the browser reads it.

What is actually wrong: **the last declaration wins, and the copies diverge.** `getWholesaleTier():840` uses
thresholds **800 / 450 / 250 / 50** with `15% / 12.5% / 10% / 5%`; the winning `:3083` uses **1000+** for Tier 5
and a different return shape (`tierNum`, `badgeText`, `nextGoal`, `15% Margin Rebate`). The visible-first copy
is the dead one, so a threshold edit made in the obvious place has no effect. Same shape for `initResellerApp`,
`animateTargetGauge`, `openVipTierModal` (declared **three** times) and the four wallet-modal pairs. Severity
stays High — silent wrong-tier logic on a B2B pricing page — but the failure mode is divergence, not an outage.
Which threshold table is correct is a **product question**. KI-21.

### H-5 · `handleSaveGstProfile()` has three call sites and zero definitions

`wholesale.php:940`, `retailer.php:981`, `reseller.php:1092`, all
`<form id="wsGstForm" onsubmit="handleSaveGstProfile(event)">`. The `onsubmit` throws before returning `false`,
so the page also reloads — the user reports *"it just refreshes"*. Wiring it to `customers.gstin` via
`api/auth.php` is offered and **awaiting the owner's go-ahead**. KI-7.

### H-6 · Sixteen `/DT%20Brand/` URL prefixes 404 on live

`admin/Asset/js/admin.js`, `admin/orders/assets/js/{order-list,order-view,refunds,returns}.js`,
`admin/wholesale/assets/js/wholesale-segments.js`. On live, `DT Brand/`'s *contents* are the web root, so the
folder name must not appear in a path — a consequence of the deployment model set by `e3824e7`. Do not confuse
these with the 9 legitimate `wa.me` hits the same grep finds. KI-10.

### H-7 · `api/health.php` publicly announces when the offline admin path is live

It reports `MOCK_FALLBACK_ACTIVE`. That is genuinely useful for diagnosis — it is the first thing to check
during an outage — and it tells an attacker exactly when C-2's offline credential path will grant a session.
Fix: keep the endpoint, gate the detail. SEC-9.

### H-8 · A second, unlinked admin login page is reachable by URL

`admin/adminlogin.php` — 738 lines, functionally identical to `admin/login.php` bar comments, **zero inbound
links**, fully reachable. Doubled attack surface and doubled maintenance: a hardening fix applied to one is
silently absent from the other. Classified FUNCTIONAL DUPLICATE; collapsing it needs an explicit instruction
(D-9). SEC-12, KI-16.

### H-9 · A database outage presents as a hang, not an error

`Database::getConnection()` short-circuits only on `self::$pdo !== null` (`:19`) — **no negative
memoisation**. In mock mode `$pdo` stays null, so every call re-runs the whole
`[$host, 'localhost', '127.0.0.1']` candidate loop, and `isMockMode()` (`:60-64`) itself calls
`getConnection()`. A page that queries 40 times makes **40 × 2-3 TCP connection attempts** while MySQL is
down. Any fix must not defeat C-2's deliberate offline path or the `isMockMode()` gating that D-5 depends on —
and it changes a file **96 files require**.

### H-10 · Seed data is indistinguishable from production data

Three orders, three customers and two reviews from `arniya_master_production.sql` are live rows with no marker.
Every "total orders: 3" reading includes them. **The `id IN (1,2,3)` cleanup is deliberately unrun** — no
`DELETE` runs from this environment, and the owner must confirm which rows are real first. KI-1.

### H-11 · Customer financial counters drift from reality

`OrderManager` does update them (`:456-466`) — an earlier claim that it never did was wrong. The real defects:
**`lifetime_spend` accrues regardless of `payment_status`**, so an unpaid order inflates it; and
**`outstanding_balance` is never debited**, so it only ever grows. Combined with C-4's raw `payment_status`,
lifetime value is not a trustworthy number.

### H-12 · Store settings report success and write nowhere

`admin/settings/index.php:40` sets `$message = "Saved locally!";` — and **there is no `settings` table** among
the 18 in `arniya_master_production.sql`, despite commit `0f01c6c` claiming persistence *"directly to MySQL
settings table"*. Either the table is added (owner's decision plus a migration) or the UI stops claiming it
saved. KI-8; the wider class is KI-18, *admin actions that do not act*.

## 4. MEDIUM

| ID | Finding | Evidence |
| :--- | :--- | :--- |
| **M-1** | **`wishlist_items` is never written** — the feature keeps state in the browser only, so a wishlist does not survive a device change | KI-5 |
| **M-2** | **`addresses` is never written** — same shape, and it interacts with the fabricated-identity cluster in H-2 | KI-6 |
| **M-3** | **Password reset stores a token nothing delivers** — no mail transport exists anywhere in the project. Users get a silent no-op | KI-11 |
| **M-4** | **379,197 B of unreachable code**: 21 files in `shared/` (284,436 B), 6 in `includes/` (21,598 B), 5 UI assets (73,163 B), 7 of 8 `config/` files. All classified, **none authorised for deletion** | KI-15, [FILE_OWNERSHIP.md](FILE_OWNERSHIP.md) §10 |
| **M-5** | **752 KB of unminified JS on three B2B pages**, `reseller.js` alone 351 KB; the `--ws-*` token block is **triplicated byte-for-byte** across three stylesheets (666 KB combined) | [UI_SYSTEM.md](UI_SYSTEM.md) §5 |
| **M-6** | **Admin actions that report success without acting** — beyond H-12: the dead `admin/customers/assets/js/country-picker.js` shows a fake success toast; curated-page bulk actions await a decision | KI-18 |
| **M-7** | **`!=` on nullable status columns** silently drops NULL rows from totals. Use `COALESCE(\`fulfillment_status\`, 'unfulfilled') <> 'cancelled'` | [DATABASE.md](DATABASE.md) |
| **M-8** | **Features blocked on absent schema** — per-product channel visibility, per-parcel weight/dimensions. Each needs a migration, so each needs the owner | KI-19 |
| **M-9** | **Reseller attribution is hardcoded**, so commission and credit cannot be trusted as reported | KI-13 |
| **M-10** | **`api/index.php` advertises 15 paths, 14 of them fictional** — a directory listing that misdescribes the API to anyone reading it, including the next agent | [FILE_OWNERSHIP.md](FILE_OWNERSHIP.md) §5 |

## 5. LOW

| ID | Finding | Note |
| :--- | :--- | :--- |
| **L-1** | **WhatsApp display formatting varies** — `+91 70463 63528` ×135, `+91 7046363528` ×7, `+917046363528` ×1, bare `7046363528` ×128. **All 47 raw occurrences are already the correct `917046363528`** | KI-17 — **do not "fix the number"** |
| **L-2** | **The misspelled `includes/` filenames are the live ones** — `shophader.php`, `shopbottomfotoer.php`. Renaming means editing `index.php` and `shop.php` in the same commit | D-9 |
| **L-3** | **`MASTER_ARCHITECTURE_AUDIT.md` is inaccurate** — it claims 21 tables; the live schema has **18**. Superseded by `AI/`, not deleted | D-10 |
| **L-4** | **Commit subjects overstate what landed**, consistently — `0f01c6c`, `3ae032c`, `baf2ac6`, `378f926`. The sweeps were real, the "all" was aspirational | [CHANGELOG.md](CHANGELOG.md) §3 |
| **L-5** | **Unclassified root artifacts** and 18 one-line admin CSS stubs — linked, so not dead; empty, so not doing anything. Both sit in **UNKNOWN** and stay on disk | KI-9, KI-20 |
| **L-6** | **`ctx.scale(dpr, dpr)` compounds** in hand-drawn canvas charts, shrinking a chart on every redraw. Recorded as a pattern hazard; use `ctx.setTransform(dpr, 0, 0, dpr, 0, 0)` | [UI_SYSTEM.md](UI_SYSTEM.md) §10 |

## 6. IMPROVEMENT — each as its own task, none inside another

| ID | Improvement | Why it is not just "nice to have" |
| :--- | :--- | :--- |
| **I-1** | **Negative memoisation in `Database::getConnection()`** | closes H-9. Must preserve the offline admin path (D-6) and `isMockMode()` gating (D-5); touches a file **96 files require** |
| **I-2** | **Exact-path allowlist + static "sign in again" page in the admin guard** | closes C-5 without inverting the fail-open decision (D-3) |
| **I-3** | **A pre-upload check script** — the parallel `php -l` sweep plus `node --check` over all 105 JS files | the only gate that exists; **1 of 835 commits is a `test` commit** |
| **I-4** | **A written live smoke checklist** the owner can execute after each FTP upload | you cannot deploy, so the checklist *is* the test (D-8). Draft in [TESTING.md](TESTING.md) |
| **I-5** | **Deduplicate the `--ws-*` token block** across `wholesale.css` / `reseller.css` / `retailer.css` | ~666 KB, and three copies that will drift. Needs its own regression pass — the pages share no layout (D-12) |
| **I-6** | **Split `reseller.js`** (6,032 lines) after fixing H-4 | one duplicate `const` currently kills 351 KB of behaviour |
| **I-7** | **A cache-busting convention** — there is none anywhere | every CSS/JS fix currently depends on the owner hard-reloading, and on every customer's browser doing so |
| **I-8** | **Collapse `admin/login.php` + `admin/adminlogin.php`** | closes H-8; needs an explicit deletion instruction (D-9) |

**Explicitly not recommended:** introducing a framework, container, ORM, autoloader, bundler or minifier. The
deployment model is file copy over FTP, and a build artifact converts *"upload the file you changed"* into a
release process. That is a recorded decision with reasoning, not an omission — D-2.

## 7. Not findings — deliberate, with recorded reasoning

Listed so the next agent does not "fix" one. Each has a decision record.

| Looks like | Actually |
| :--- | :--- |
| two complete unused generations of the product on disk | **kept on purpose.** Not deployed, cost nothing at runtime; deleting 376+ files is a large irreversible change with no user-visible benefit — D-1 |
| the two guards contradict each other | **deliberately asymmetric.** A leaked JSON payload is a breach; an unloadable console is a lockout — D-3 |
| order creation has no authentication | **public by design** — there is no payment gateway, orders settle offline, and the server re-derives every value that touches money — D-4 |
| an admin credential that works while the database is down | **the owner's lockout insurance** for a one-person business. Move it and change it; do not delete it — D-6 |
| four competing CSS token systems | **not being unified as part of another task.** A merge touches ~190 admin and 11 storefront pages with no shared layout to test through — D-12 |
| the `1999` free-shipping literal "duplicated in 8 places" | **two live copies.** The rest are a coupon minimum ×2, a demo price ×2 and a `z-index` ×3 — D-11 |
| `assets/css/main.css`, `header.css`, `shared/quickview.php`, `shared/size_chart_modal.php` look dead | **all live.** The first two on 3 admin pages, the last two on 6 storefront pages each |
| `gst_rate: -100` cancels the goods value | **blocked.** `calculateGst()` throws (`PricingCalculator.php:27-29`); `api/orders.php:227` returns 500 with no row written |
| `OrderManager` never updates customer counters | **it does**, at `:456-466`. The real defects are H-11 |
| the WhatsApp number differs across the project | **it does not.** All 47 raw occurrences are `917046363528`; only formatting varies — L-1 |

The last four rows are corrections to **earlier drafts of this project's own documentation**. Each was
confidently wrong in a way that would have caused wasted or harmful work; the full list is
[CHANGELOG.md](CHANGELOG.md) §5.

## 8. Method, and the limits of this audit

**What was run.** `/c/xampp/php/php.exe -l` (PHP 8.2) over the tree;
`node --check --input-type=commonjs` on the large JS files; `git log` / `git ls-files` for history and
inventory; and full-path greps — **excluding comments, and scoped to `DT Brand/`** — to establish every
reference count. Each numeric claim in this tree carries the command that produced it and the date
**2026-08-29**.

**What could not be run, and therefore is not verified by this audit:**

- **Anything touching MySQL.** There is no database in this environment and no route to live. No query,
  migration, index, constraint, ENUM coercion, `rowCount()` behaviour or counter update was executed. KI-22.
- **Anything requiring a browser.** No rendering, no layout, no console, no network panel. H-4's syntax error
  is confirmed; whether the page is *currently* broken for a user is not.
- **The live schema.** Which of the three competing authorities actually ran is **unknown** (H-1) and needs
  `SHOW TABLES` / `SHOW COLUMNS` from the owner. Several findings' exact scope depends on that answer.
- **Whether any given fix is deployed.** FTP uploads are the owner's and leave no trace in the repository; a
  `chore: sync` commit records intent, not an upload (D-8, [CHANGELOG.md](CHANGELOG.md) §2).
- **Runtime security behaviour** — session handling, the guard's actual throw path, redirect chains. Statically
  read, not exercised.

**What this audit did not attempt:** no penetration testing, no live probing, no dependency scan (there are no
dependencies — no composer, no npm in the live tree), and **no exploitation of any finding**.

**Confidence.** Findings citing a `file:line` were read directly. Counts were measured. Anything stated as a
consequence *at runtime* — C-5's exploitability, H-3's cart figure, H-9's connection count — is a reading of
the code, not an observation of live behaviour. Treated as such, and worth confirming after upload.

## 9. Recommended order of work

**Do the first block before writing any code.** It is the only block that closes a remotely exploitable
exposure, and none of it is an agent's to do.

1. **C-1, C-2, C-3 — the owner.** Rotate the database password; set the eight environment variables; confirm
   with a length-only probe; revoke the GitHub token. Then, and only then, an agent removes the literals.
2. **H-1 — the owner.** Paste `SHOW TABLES` and `SHOW COLUMNS` from live. This unblocks H-1, H-12, M-8 and
   scopes several others. One command, large payoff.
3. **C-4** — whitelist the two ENUMs, floor `shipping`, take `gst_rate` from `PricingCalculator`. The highest-value
   code fix, and small.
4. **C-6, C-7** — deny rule for `database/`; guard or withdraw `db_audit.php` and `db_health.php`.
5. **C-5** — the narrow guard fix (static page on throw, exact-path allowlist). **Not** a fail-closed rewrite.
6. **H-3, H-5, H-4, H-6** — four contained fixes with visible user impact: the coupon divergence (both copies
   in one commit), the missing handler, the duplicate declarations, the 16 broken prefixes.
7. **H-2** — continue the fabricated-data sweep, starting with `OrderManager::getAll():627` and the ~190-page
   admin chrome. Empty and honest, never a nicer fake (D-5).
8. **H-9, H-11, H-12** — then the MEDIUM band, then the IMPROVEMENT tasks one at a time.

**H-10 stays open until the owner identifies which rows are real.** No `DELETE` runs from here, ever.

Each item above is one task, with one report — **TASK · ROOT CAUSE · CHANGES · TESTS · RESULT · RISKS ·
NEXT** — and `NEXT` names the files to upload ([AGENT_PROTOCOL.md](AGENT_PROTOCOL.md) §8). Close a finding by
updating it **in place** here and in its `KI-n` / `SEC-n` entry, with the date and the commit. **Append, never
renumber.**






