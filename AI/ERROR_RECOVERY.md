# ERROR RECOVERY

> What to do when something breaks — and, more often, how to read a symptom in **this** project
> correctly. Most of the failure modes below present as something other than what they are, which is
> why they were expensive the first time.

---

## 1. The rule that comes before any debugging

**If a new error appears after your fix, do not patch the new error.** Return to the first failure and
trace from the beginning. Stacked patches are how a one-line bug becomes an unexplainable module.

In practice:

1. Read the actual error — PHP log line, browser console line, HTTP status. Not the user's paraphrase.
2. Reproduce it, or state clearly that you could not.
3. Find the **first** thing that is wrong, not the first thing that is broken.
4. Fix that one thing. Verify. Then re-ask whether the reported symptom is gone.
5. If your fix required a second fix to work, revert both and reconsider the diagnosis.

**Never widen scope while debugging.** A refactor undertaken mid-diagnosis destroys the evidence.

## 2. Diagnose in this order

| Step | Command / check | Rules out |
| :--- | :--- | :--- |
| 1 | `/c/xampp/php/php.exe -l <file>` | PHP syntax |
| 2 | `node --check --input-type=commonjs < <file>` | JS syntax. **Never `--input-type=module`** — nothing here is a module, and it reports duplicate-`function` errors that do not exist in the browser (KI-21) |
| 3 | grep the **full path** of every asset and include you changed | the substring/comment false positives that have already caused three wrong conclusions ([DECISIONS.md](DECISIONS.md) D-9) |
| 4 | is the file **in `DT Brand/`**? | editing the frozen GEN-B twin — `src/Database.php` exists twice (D-1) |
| 5 | did the owner **upload** it? | the most common "your fix didn't work" (D-8) |
| 6 | is the column **actually in `arniya_master_production.sql`**? | phantom columns from the migration that never runs ([KNOWN_ISSUES.md](KNOWN_ISSUES.md) KI-4) |

Project-wide lint sweep:

```bash
find . -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -P 8 -n 1 /c/xampp/php/php.exe -l 2>&1 | grep -v "No syntax errors"
```

There is **no MySQL in this environment**, so nothing DB-dependent can be executed here. Say so rather
than implying a check passed (KI-22).

## 3. Symptom → cause. Read this before guessing.

### The site is slow, or hangs

**`Database::getConnection()` has no negative memoisation.** It short-circuits only on
`self::$pdo !== null` (`Database.php:19`); in mock mode `$pdo` stays null, so every call re-runs the
whole `[$host, 'localhost', '127.0.0.1']` candidate loop — and `isMockMode()` (`:60-64`) calls
`getConnection()` too. A page that queries 40 times makes 40 × 2-3 TCP connection attempts while MySQL
is down. **An outage presents as a hang, not as an error.** Check `api/health.php` first; it reports
`MOCK_FALLBACK_ACTIVE`. (That endpoint is itself SEC-9 — it tells attackers the same thing.)

### A list is empty and nothing is wrong

`Database::query()` returns `[]` for an empty table **and** for a dead database. Every caller must gate
on `$db !== null && !Database::isMockMode()` before believing an empty result. `src/` mostly does;
inline page queries frequently do not. [PROJECT_MEMORY.md](PROJECT_MEMORY.md) M-8,
[DECISIONS.md](DECISIONS.md) D-5.

### It works locally and 404s on live

`/DT%20Brand/` in the URL. **16 occurrences in 6 admin JS files** — `admin/Asset/js/admin.js`,
`admin/orders/assets/js/{order-list,order-view,refunds,returns}.js`,
`admin/wholesale/assets/js/wholesale-segments.js`. On live, `DT Brand/`'s *contents* are the web root,
so the folder name must not be in the path. Do not confuse these with the 9 legitimate `wa.me` hits the
same grep finds. KI-10.

### A JS file "does nothing at all"

Three distinct causes, and the first two look identical in the browser:

1. **A duplicate top-level `let`/`const`/`class` is a `SyntaxError` that kills the entire file** — every
   handler in it silently ceases to exist. `node --check` finds this in a second; guessing does not.
   Note that **duplicate `function` declarations are legal** and do *not* cause this: `reseller.js` has
   11 of those and the file parses fine (KI-21). Check with `node --check <file>` on a copy, not with
   `--input-type=module`, which reports module-only errors the browser never applies — nothing in
   `DT Brand/` is loaded as a module.
2. **The handler is not defined at all.** `handleSaveGstProfile(event)` is called from
   `wholesale.php:940`, `retailer.php:981` and `reseller.php:1092` and defined **nowhere** — 3 call
   sites, 0 definitions (KI-7). Because the `onsubmit` throws before returning `false`, the page also
   reloads, so the user reports "it just refreshes".
3. **The handler runs, but it is the wrong copy of it.** A function declared twice silently resolves to
   the last declaration, so an edit to the first has no effect at all — and in `reseller.js` the two
   copies of `getWholesaleTier()` disagree on the tier thresholds (`:840` vs `:3083`, KI-21). If a
   change appears to do nothing, `grep -n 'function <name>'` the whole file before assuming a cache.

Diagnostic: open the console, look for `SyntaxError` (cause 1) or `ReferenceError` (cause 2). A clean
console with the old behaviour still showing is cause 3. Do not start reading the file.

### A blank white page

PHP fatal with display off. Read the host's error log — never enable `display_errors` on live. If you
must know quickly, `php -l` the file you just changed and every file it requires. Remember there is **no
autoloader**: a missing `require_once` is a fatal at the point of first use, often far from the edit.

### "Unknown column" on live but the column is in the file

The column exists only in `database/migrations/2026_08_25_production_upgrade.sql`, which
**`migrate.php` never executes** — it runs exactly one file, `arniya_master_production.sql`. Worse,
`migrate.php::status()` lists all three migration files as `PENDING_OR_APPLIED`, so it reads as though
they ran. Verify against `arniya_master_production.sql`, and ask the owner for `SHOW COLUMNS`. KI-4.

### The CSS/JS fix is uploaded and the browser disagrees

There is **no minifier, no bundler and no cache-busting query string** anywhere. The file the browser
fetched is the file on disk, cached by the browser alone. Hard-reload before believing anything.
[UI_SYSTEM.md](UI_SYSTEM.md) §11.

### An admin page renders without a login

`admin/Includes/adminguard.php:70-74` wraps its body in `catch (\Throwable) { return; }` — **any** throw
inside the guard serves the requested page unauthenticated. This is deliberate (D-3) and must not be
inverted; the authorised fix is a static "sign in again" page on the throw path. Also check whether the
URL happens to contain the substring `login` or `logout`, which exempts it outright (SEC-11).

### Sign-in appears to succeed and lands back on the login page

A 301 hop dropped the session. Fixed on 2026-08-28 by `4a97896` and `31be293`, which made the admin
login and logout redirects use the **canonical trailing slash** (`/admin/`, not `/admin`). If it recurs,
look for a new redirect that omits the slash rather than for a session bug.

### A product card renders a video inside an `<img>`

`is_primary` landed on a non-photo. `ProductCatalog::syncMedia()` (`:777`) enforces
photo-only; a write path that bypasses it reintroduces this. Related: a `data:` URL silently truncates
in `primary_image VARCHAR(255)`, which is why `mediaPath()` (`:32`) rejects them.

### Draft products are visible on the storefront

Something filtered on `status != 'trash'` instead of `ProductCatalog::PUBLIC_STATUSES`
(`in_stock,low_stock,out_of_stock`). `trash` is not in the ENUM, so that comparison passes everything.

### The cart quotes a bigger discount than the order bills

`DiscountEngine::applyCoupon()` caps a percentage only at `max_discount` (`:81-83`);
`OrderManager::resolveCouponDiscount()` also clamps to the subtotal (`:54`). With
`discount_value=150, max_discount=0` the cart quotes 1.5 × subtotal. One-line fix at
`DiscountEngine.php:80-84`, and **both implementations must change together**. KI-14.

### A chart shrinks a little on every redraw

`ctx.scale(dpr, dpr)` compounds. Use `ctx.setTransform(dpr, 0, 0, dpr, 0, 0)`. Every chart in the admin
console is hand-drawn canvas — there is no charting library. [UI_SYSTEM.md](UI_SYSTEM.md) §10.

### A customer's account type silently blanks, and the write reported success

Outside strict mode MySQL coerces an unknown ENUM value to `''` while `execute()` still returns `true`.
This is why `CustomerManager` whitelists every ENUM before writing (`:132`, `:139`, `:239-244`, `:315`)
and disambiguates `rowCount() === 0` (`:264-270`, `:329-337`, `:361-367`) — zero rows means *either*
"no such customer" *or* "the value already matched", and only the second is success. Copy that pattern;
do not simplify it.

### A courier tracking ID changes on every refresh

Not a caching bug. `OrderManager::getAll():627` synthesises
`'DEL-' . rand(10000, 99999)` for any order without a `tracking_number`, across **13 call sites**. Two
complete demo orders also appear when the query returns nothing — empty table *or* dead database
(`:638-675`). KI-3a.

## 4. Undoing your own work

Local, reversible, and safe:

```bash
git diff                    # what you changed
git checkout -- <file>      # discard one file's changes
git stash                   # park everything
```

**Requires the owner's explicit permission, every time:** `git reset --hard`, `git push --force`,
`git clean -f`, `git branch -D`, `git rebase`, history rewriting (`filter-repo` / BFG), and amending a
pushed commit. Never run one to tidy up after yourself. History rewriting is additionally coupled to
[SECURITY.md](SECURITY.md) SEC-1 and is the owner's decision, taken as its own task.

Do not commit unless asked. If you are asked, stage named files — never `git add .` — and check for
anything that could hold a secret (`.env`, `config/database.php`, `.git/config`) before committing.

## 5. If a database write went wrong

1. **Stop.** Do not issue a compensating `UPDATE` to "fix" it — that is a second unverified write on
   unknown state.
2. **Report exactly what ran**: the statement, the parameters, the table, and the row count reported.
3. **Never** `DROP`, `TRUNCATE`, or `DELETE` without a `WHERE` — no exceptions, no "just the demo rows".
   Even the seed-row cleanup in KI-1 is unrun for this reason.
4. A recovery that mutates data needs the owner's explicit authorisation **and** a dump taken first. The
   owner runs it; an agent cannot reach the database from here.

Remember what a single order write already touches: it decrements stock (`OrderManager.php:453`) and
increments `total_orders` / `lifetime_spend` (`:456-466`). A forged or mistaken order therefore also
moves inventory and customer lifetime value — and with a negative `grand_total` it *decreases*
lifetime spend (SEC-5).

## 6. If something is broken on live

You cannot deploy and you cannot roll back — the owner does both (D-8). What you can do, in order:

1. **Name the fault precisely**: URL, expected vs actual, the file and line you believe is responsible.
2. **Retrieve the last known-good version** of the affected file so the owner has something to upload:
   `git log --oneline -- "<path>"` then `git show <hash>:"<path>"`.
3. **Tell them exactly which files to re-upload**, and whether a migration is involved.
4. If the fault is a schema mismatch, ask for `SHOW TABLES` / `SHOW COLUMNS` rather than guessing — that
   one unanswered question is behind KI-4, KI-8 and KI-19.

**Two things stay available even in a total database outage**, by design: the admin master credential
grants a session (`Auth.php:363`, D-6), and `api/health.php` reports the outage. Use the second to
confirm the diagnosis before assuming a code fault.

## 7. End every task with the standard report

**TASK · ROOT CAUSE · CHANGES · TESTS · RESULT · RISKS · NEXT.**

`ROOT CAUSE` is a cause, not a restatement of the symptom. `TESTS` states what was actually run —
`php -l`, `node --check` — and what could not be run here. `RISKS` names what might break that you did
not test. `NEXT` lists the files the owner must upload. [AGENT_PROTOCOL.md](AGENT_PROTOCOL.md).

