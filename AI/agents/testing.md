# AGENT BRIEF · TESTING

> **Scope:** verification, in a project with **no test suite and no way to reach a database from the
> development environment**. This brief is about what that leaves you, and how to report it honestly.
>
> Read with [TESTING.md](../TESTING.md), which holds the manual checklist itself.

---

## 1. Start from the truth about this project

**One of 835 commits is a `test` commit** ([CHANGELOG.md](../CHANGELOG.md) §0). GEN-A's `phpunit.xml`,
`phpstan.neon`, `playwright.config.js`, `lighthouserc.js`, `eslint.config.js` and `.github/workflows/*` were
added in a single abandoned commit (`f203dce`, 2026-08-24) and **wired to nothing** (D-1). They are not this
project's test strategy, and running them tests a directory tree that is not deployed.

Read that as a fact, not a criticism. It is why `TESTING.md` describes a procedure rather than a suite, and
why 100+ behaviours sit on a needs-live-verification list.

## 2. What actually runs here

| Check | Command | Catches |
| :--- | :--- | :--- |
| PHP syntax | `/c/xampp/php/php.exe -l <file>` | parse errors; **the only pre-upload gate for 452 files** |
| PHP syntax, all | `find "DT Brand" -name '*.php' -print0 \| xargs -0 -P 8 -n 1 /c/xampp/php/php.exe -l 2>&1 \| grep -v "No syntax errors"` | a fatal introduced anywhere |
| JS syntax | `node --check --input-type=commonjs < <file>` | a duplicate top-level `let`/`const`/`class`, which silently kills a whole file. **Not** duplicate `function` declarations — those are legal, `reseller.js` has 11 and parses fine (KI-21). Never use `--input-type=module` here |
| Reference liveness | grep the **full** path, excluding comments | a dead include, a broken `href` |

PHP 8.2 is at `/c/xampp/php/php.exe` and is **not on `PATH`**. Keep any helper script's output ASCII-only —
the Windows console is cp1252.

**There is no MySQL in this environment and no route to live.** Nothing DB-dependent is runtime-verifiable
(KI-22). There is also **no autoloader**, so `php -l` passing does not prove a missing `require_once` will not
fatal at first use — check the requires of every file you touched.

## 3. The reporting rule, which is the real deliverable

Three states, and they must never be blurred:

- **VERIFIED** — a command produced output you read. Quote the command.
- **NOT RUN HERE** — impossible in this environment (anything touching MySQL, anything requiring a browser).
  Say which, and why.
- **UNVERIFIED** — you could have checked and did not. Say so; do not upgrade it to verified by confidence.

"Tested" is not a synonym for "I am fairly sure". This project's own code follows the same rule — show
nothing rather than a plausible value (D-5) — and the documentation follows it too: **every measurement in
`AI/` carries the command that produced it and the date.**

## 4. Writing the live checklist for the owner

You cannot deploy, so a test plan **is** the test (D-8). Make it something a non-engineer can execute:
a URL, an action, and the expected result — one line each. What the accumulated list looks like:

- one order through the admin drawer and one through `/checkout`, then confirm stock decremented and
  `total_orders` / `lifetime_spend` moved
- a product round-tripped with photos + an MP4 + a pasted YouTube/Instagram link + variants + MOQ tiers
- `product.php?id=9999` returns the 404 page, not a blank
- cart totals just under and just over the ₹1999 free-shipping threshold
- the three B2B pages both empty and populated
- every WhatsApp entry point opening `917046363528`
- the eight dashboard widgets agreeing with real data, and the 1W/1M/1Y pills changing the chart
- the three canvases showing their "no data yet" text when there is none
- `/admin/` login → landing (**with** the trailing slash), and logout
- `SHOW TABLES` / `SHOW COLUMNS` output pasted back, to resolve KI-4

## 5. What to check that a test would not

Because there is no runtime coverage, some classes of bug are only findable by reading. Worth a pass on any
change:

1. **Blast radius.** Did you edit a `components/` partial? `admin/orders/components/order-table.php` renders
   13 pages; `admin/Includes/adminheader.php` renders ~190.
2. **The mirror.** Did you change a commercial rule with a browser copy? Freight, GST, tier price, lot
   minimums and coupons each have one authority and known mirrors (D-11). The coupon cap exists **twice and
   the two disagree** (KI-14) — both change together.
3. **The empty-vs-broken gate.** Does the new code believe an empty `Database::query()` result?
4. **Phantom columns.** Is every column in your SQL in `arniya_master_production.sql` (18 tables)? Anything
   only in `2026_08_25_production_upgrade.sql` does not exist on live (KI-4).
5. **Cache.** There is no cache-busting anywhere. If the owner reports a CSS/JS fix not working, hard reload
   comes before re-diagnosis.

## 6. Closing a verification item

When the owner confirms a behaviour on live, **update the finding in place** — mark the `KI-n` closed with the
date and what confirmed it, and move the line off the needs-live-verification list in
[TESTING.md](../TESTING.md). Never delete the entry. **Append, never renumber.**

