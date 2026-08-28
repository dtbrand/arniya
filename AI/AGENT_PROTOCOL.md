# AGENT PROTOCOL

> The operating procedure for any agent — Claude, Gemini, or a human standing in for one — working in
> this repository. It is deliberately short on philosophy and long on the specific things that have
> already gone wrong here. Read [MASTER.md](MASTER.md) first for what the project *is*; this file is
> what you *do*.
>
> The rules are ordered by how expensive it is to break them.

---

## 1. Six things to establish before the first edit

| # | Question | Answer here |
| :--- | :--- | :--- |
| 1 | **Which generation is this file in?** | Only `DT Brand/` is live. `src/Database.php` exists **twice** — [DECISIONS.md](DECISIONS.md) D-1 |
| 2 | **Who else includes it?** | `admin/orders/components/order-table.php` renders 13 pages; `adminheader.php` ~190 — [FILE_OWNERSHIP.md](FILE_OWNERSHIP.md) §9 |
| 3 | **Does the module have a `README.md`?** | Seven do (`wholesale` `products` `resellers` `retail` `orders` `catalogue` `customers`). Read it; update it, don't fork it |
| 4 | **Is the column really in the live schema?** | `database/arniya_master_production.sql` — 18 tables — is the only authority. `migrate.php` runs that file and nothing else ([KNOWN_ISSUES.md](KNOWN_ISSUES.md) KI-4) |
| 5 | **Is this rule already owned somewhere?** | Freight, GST, tier price, lot minimum and coupons each have exactly one server-side authority — D-11 |
| 6 | **Is the behaviour a bug or a decision?** | Check `DECISIONS.md` and the "Looks like a bug — BY DESIGN" table in `KNOWN_ISSUES.md` before "fixing" it |

Skipping #1 edits a frozen twin and reports success. Skipping #6 produced a PR that would have been
reverted (the asymmetric guards, D-3).

## 2. The task lifecycle

**UNDERSTAND → LOCATE → PLAN → CHANGE → VERIFY → REPORT.** No step is optional, and the order is not
negotiable.

1. **UNDERSTAND.** Restate the request in one sentence, and name what is *out* of scope. If two readings
   of the request lead to materially different work, ask — once, with the options.
2. **LOCATE.** Grep by **full path**, not basename, and exclude comments. Three wrong conclusions in
   this repo came from basename greps (D-9). Read the file before claiming anything about it.
3. **PLAN.** Name every file you will touch, and for each one what breaks if you are wrong. If the plan
   grows past the request, stop and say so rather than widening.
4. **CHANGE.** Smallest correct change. Match the surrounding style — static methods,
   `namespace DTBrand;`, hand-written `require_once` in dependency order, no new dependency (D-2).
5. **VERIFY.** §4 below. State what you ran and what you could not run.
6. **REPORT.** §8. Ending with which files the owner must upload is part of the deliverable, not a
   courtesy — a fix that is not uploaded is a fix they do not have (D-8).

## 3. Scope discipline

**The request is the deliverable.** Not a smaller version of it, and not a better idea you had while
reading the code.

- **No silent narrowing.** If part of the task turns out to be blocked, finish everything else in full
  and say plainly what you left out and why. Scaling the work down is the owner's call.
- **No silent widening.** A bug fix does not include a refactor of the file it lives in, a rename, a
  tidy-up of adjacent dead code, or a "while I was there" improvement. If you find a second real
  problem, record it in [KNOWN_ISSUES.md](KNOWN_ISSUES.md) and mention it — do not fix it.
- **Never widen scope while debugging.** A refactor undertaken mid-diagnosis destroys the evidence.
- **Root cause first.** If a new error appears after your fix, do not patch the new error — return to
  the first failure and trace from the beginning. If your fix needed a second fix to work, revert both
  and reconsider the diagnosis. [ERROR_RECOVERY.md](ERROR_RECOVERY.md) §1.

When two goals conflict, the settled order is D-13: **existing working business logic → the owner's
explicit request → security → data integrity → existing architecture → UI/UX consistency →
performance → maintainability → cleanup → new improvements.**

## 4. Verification — exactly what is available in this environment

| Check | Command |
| :--- | :--- |
| PHP syntax | `/c/xampp/php/php.exe -l <file>` — PHP 8.2, not on `PATH` |
| PHP syntax, whole tree | `find . -name '*.php' -not -path './vendor/*' -print0 \| xargs -0 -P 8 -n 1 /c/xampp/php/php.exe -l 2>&1 \| grep -v "No syntax errors"` |
| JS syntax | `node --check --input-type=commonjs < <file>` — finds the duplicate-`let`/`const` `SyntaxError` that silently kills a whole file. **Never `--input-type=module`**: it flags legal duplicate `function` declarations, which is how `reseller.js` was wrongly written off as dead (KI-21) |
| Reference liveness | grep the **full** `href` / `src` / `require` path across all 452 PHP files |

**There is no MySQL in this environment and no way to reach live from here.** Nothing DB-dependent is
runtime-verifiable (KI-22). There is also no test suite: GEN-A's `phpunit.xml`, `playwright.config.js`
and `.github/workflows/*` were added in one abandoned commit and wired to nothing (D-1). One `test`
commit exists in 835 ([CHANGELOG.md](CHANGELOG.md) §0).

So: **say what you ran, and say what you could not run.** "Verified" means a command produced output you
read. Everything else is "needs live verification" and belongs in the report and in
[TESTING.md](TESTING.md).

Windows console encoding is cp1252 — keep script output ASCII-only or it dies on an em dash.

## 5. Deleting a file — the classification gate

No file is deleted on the strength of a grep. Classify it first, write the evidence down, and delete
only with an explicit instruction (D-9):

| Class | Meaning | Action |
| :--- | :--- | :--- |
| **EXACT DUPLICATE** | byte-identical to a live file | may be proposed for deletion |
| **FUNCTIONAL DUPLICATE** | same behaviour, different bytes — e.g. `admin/adminlogin.php` vs `login.php`, 738 lines apart only in comments | propose collapsing; note it is still URL-reachable (SEC-12) |
| **LEGACY** | superseded but historically meaningful — `database/schema.sql`, `seeders.sql` | keep unless asked |
| **INTENTIONALLY DIFFERENT** | looks duplicated, is not — `api/_guard.php` fails closed, `adminguard.php` fails open (D-3) | **never** unify |
| **UNUSED** | zero requirers, verified by full-path grep — 379,197 B total | keep on disk, record it |
| **UNKNOWN** | evidence incomplete | keep on disk, → `KNOWN_ISSUES.md` |

**Two traps that have already bitten:**

- In `includes/`, **the misspelled files are the live ones.** `shophader.php` and `shopbottomfotoer.php`
  are required by `index.php` and `shop.php`; the correctly-spelled `shopheader.php` / `shopfooter.php`
  are dead. A "fix the typo" commit breaks two pages.
- Every `shared/*_modal.php` is dead **except `size_chart_modal.php`**, which is live on 6 pages. A rule
  like "delete the unused modal partials" breaks the product page.

`FILE_OWNERSHIP.md` §10 holds the full classified inventory. **Nothing in it is authorised for deletion
by that document.**

## 6. Database safety

1. **No `DROP`, no `TRUNCATE`, no `DELETE` without a `WHERE`.** No exceptions. Not even for the three
   seed orders and three seed customers in KI-1 — that cleanup is deliberately unrun.
2. **No schema change without the owner's explicit authorisation and a written impact analysis.** A
   schema change also means telling them to run `database/migrate.php` on live; FTP does not carry the
   database ([DEPLOYMENT.md](DEPLOYMENT.md)).
3. **Every write goes through a prepared statement.** Column and table names are never interpolated from
   input — use a fixed whitelist, as `priceColumnFor()` does (`OrderManager.php:118-127`).
4. **Whitelist every ENUM before writing it.** Outside strict mode MySQL coerces an unknown value to
   `''` and `execute()` still returns `true` — a silent blank reported as success.
5. **`!=` is NULL-unsafe.** Use `COALESCE(\`fulfillment_status\`, 'unfulfilled') <> 'cancelled'`.
6. **`Database::query()` returns `[]` for an empty table and for a dead database.** Gate on
   `$db !== null && !Database::isMockMode()` before believing any empty result (D-5).
7. If a write went wrong: **stop, report what ran, and do not issue a compensating `UPDATE`.**
   `ERROR_RECOVERY.md` §5.

## 7. Secrets

**Never reproduce a credential value.** Not in a report, not in a document, not in a commit message, not
in a code comment, not in an error string. Refer to it by **file, line and variable name** — that is
enough for the owner to act and useless to anyone else. Every entry in
[SECURITY.md](SECURITY.md) SEC-1 is written that way; keep it that way.

Also:

- **Do not delete a `getenv('X') ?: '<literal>'` fallback** until the owner has confirmed the variable
  resolves on live. Removing it first takes the site down. The confirmed order is D-7:
  rotate → set the eight variables → confirm with a **length-only** probe → then remove.
- **There is no `.env` loader in this project.** Creating a `.env` file achieves nothing; only real
  process environment variables reach `getenv()`.
- Before any commit, check `.env`, `config/database.php` and `.git/config` — the last one has held a
  token in the `origin` URL.
- Purging git history (`filter-repo` / BFG) rewrites every hash and needs a force-push. **Owner's
  decision, own task, never inside another one.**

## 8. The end-of-task report — mandatory, every task

```
TASK        one sentence: what was asked, at its stated scope
ROOT CAUSE  the cause. Not a restatement of the symptom. "N/A - new feature" is a valid answer
CHANGES     file:line for each edit, and why that line
TESTS       what was actually run (php -l / node --check / grep) and what could NOT be run here
RESULT      what now works, in the owner's terms
RISKS       what might break that you did not test, and what is still unverified
NEXT        the exact files to upload, any migration to run, and anything awaiting a decision
```

`NEXT` is the part the owner uses. Name paths in full (`DT Brand/admin/index.php`), say whether a
migration is involved, and list any question you are blocked on.

## 9. Keeping this tree true

The documentation is load-bearing — the next agent will act on it. So:

1. **Append a `CHANGELOG.md` entry** under `## 5. Unreleased` as you finish, dated, with `file:line`.
2. **Close findings in place.** Update the `KI-n` / `SEC-n` entry to CLOSED with the commit; never delete
   the entry. **Append, never renumber** — `SEC-n`, `KI-n`, `D-n`, `M-n` are cross-referenced across
   every file in this tree.
3. **Every measurement carries its date**, because every count here will drift.
4. **Correct a wrong claim loudly.** `CHANGELOG.md` §5 keeps a table of claims this audit had to correct
   precisely so nobody re-derives them. Add to it.
5. If a module `README.md` covers the thing, **update that README** instead of growing a parallel
   description here (D-10).
6. **Record what could not be verified as unverified.** An honest gap is worth more than a plausible
   sentence — the same rule the code follows (D-5).

## 10. What needs the owner, and cannot be done here

Deployment · database migrations · rotating credentials · setting Hostinger environment variables ·
`SHOW TABLES` / `SHOW COLUMNS` on live · git history rewriting · any destructive git or SQL operation ·
deleting a file · a schema change · reversing a `D-n` decision.

Ask once, clearly, with the exact command or value needed — then continue with everything that does not
depend on the answer. [AGENT_HANDOFF.md](AGENT_HANDOFF.md) records what is currently waiting on them.



