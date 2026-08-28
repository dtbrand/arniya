# CHANGELOG

> The project had **no changelog**. This one is reconstructed from git history on 2026-08-29 and then
> maintained forward: from here on, every agent task appends its entry. It records *what landed*, not
> what a commit message claimed — where those differ, the difference is the interesting part.
>
> Commit subjects are quoted from git. Full history: `git log --date=short --oneline`.

---

## 0. The shape of the history

**835 commits between 2026-08-14 and 2026-08-29** — fifteen calendar days, one of them empty
(2026-08-26).

| Date | Commits | | Date | Commits |
| :--- | ---: | :--- | :--- | ---: |
| 2026-08-14 | 15 | | 2026-08-22 | 74 |
| 2026-08-15 | 10 | | 2026-08-23 | 56 |
| 2026-08-16 | 104 | | 2026-08-24 | 26 |
| 2026-08-17 | 75 | | 2026-08-25 | 48 |
| 2026-08-18 | 56 | | 2026-08-26 | **0** |
| 2026-08-19 | 85 | | 2026-08-27 | 58 |
| 2026-08-20 | 112 | | 2026-08-28 | 4 |
| 2026-08-21 | 111 | | 2026-08-29 | 1 |

Conventional-commit prefixes: `feat` 435 · `fix` 236 · `style` 51 · `chore` 19 · `clean` 11 ·
`refactor` 9 · `docs` 9 · `revert` 2 · `test` **1** · `perf` 1 · `layout` 1.

**Read that last line as a fact about the project, not a criticism.** One `test` commit in 835 is why
[TESTING.md](TESTING.md) describes a verification procedure rather than a suite, and why 100+
behaviours are still on the needs-live-verification list. The `feat`:`fix` ratio of roughly 2:1 at
~55 commits/day is the signature of a build sprint, which is also why fabricated placeholder data got
committed and then had to be removed file by file ([KNOWN_ISSUES.md](KNOWN_ISSUES.md) KI-3).

## 1. The three generations, with the commits that created them

This is the most useful thing in the history, because it dates the ambiguity that
[DECISIONS.md](DECISIONS.md) D-1 exists to manage.

| Generation | Born | Last touched | Evidence |
| :--- | :--- | :--- | :--- |
| **GEN-B** — `Frontend/` + root `admin/ api/ src/ Shared/` | 2026-08-14, `a3adc5d` *"Initial commit: Luxury WhatsApp CRM Storefront"* | **2026-08-25** — `7719ed2` (root `src/`), `592cffb` (`Frontend/`) | frozen; 376 PHP |
| **GEN-A** — `app/ bootstrap/ public/ tests/ storage/` + composer/phpunit/phpstan/playwright | **2026-08-24, `f203dce`** *"feat(arch): implement full enterprise PHP folder structure (public, admin, api, app, config, bootstrap, database, storage)"* | **the same commit** | created and abandoned in **one commit**; `app/` has never been touched again |
| **GEN-C** — `DT Brand/` | **2026-08-25, `1a8decc`** *"feat: rebuild complete DT Brand e-commerce ecosystem with modular architecture, live APIs, responsive UI and admin suite"* | 2026-08-29 | **LIVE**; 452 PHP |

**2026-08-25 is the pivot.** GEN-B was frozen and GEN-C was born on the same day, and the second
`DT Brand/` commit — `e3824e7` *"fix: route clean URLs, link normalize to root, and bundle assets into
DT Brand"* — is where the deployment model was set: `DT Brand/`'s **contents** become
`/public_html/`. That single decision is the origin of the 16 broken `/DT%20Brand/` URL prefixes still
in six admin JS files (KI-10) — they were written for the local XAMPP layout, where the folder name was
part of the path.

GEN-A deserves one more sentence, because its presence misleads every new reader: `f203dce` added
`phpunit.xml`, `phpstan.neon`, `playwright.config.js`, `lighthouserc.js`, `eslint.config.js` and
`.github/workflows/*` in a single "enterprise folder structure" commit, and **nothing was ever wired
to them.** They are not this project's test strategy, CI or architecture.

## 2. `chore: sync … to GitHub and Hostinger FTP` is the deployment record

Nineteen `chore:` commits carry that phrasing, e.g. `a3d9e26` (2026-08-29), `af715e6` and `dab1147`
(2026-08-28), `9477c4d` and `681364e` (2026-08-27). They are the closest thing the project has to a
release log: each marks a batch the owner uploaded by FTP.

**They do not prove the upload happened, and they never include the database.** FTP moves files; MySQL
is migrated separately by running `database/migrate.php` on live. So a `chore: sync` commit that
mentions "database upgrades" means the *migration file* was committed, not that it ran. This is the
mechanism behind [KNOWN_ISSUES.md](KNOWN_ISSUES.md) KI-4 — phantom columns that exist in a committed
migration and not in the live schema. [DEPLOYMENT.md](DEPLOYMENT.md), [DECISIONS.md](DECISIONS.md) D-8.

## 3. Commit messages that overstate what landed

Recorded so nobody trusts the subject line over the code:

| Commit | Claim | What is actually there |
| :--- | :--- | :--- |
| `0f01c6c` (08-27) | *"…enable persistent store settings configuration directly to MySQL settings table"* | **there is no `settings` table.** `arniya_master_production.sql` has 18 `CREATE TABLE` statements and none is `settings`; `admin/settings/index.php:40` reports `"Saved locally!"` for a write that lands nowhere — KI-8 |
| `3ae032c` (08-27) | *"docs: create comprehensive Mastermind Architecture & Full System Audit"* | `MASTER_ARCHITECTURE_AUDIT.md` claims **21 tables**; the live schema has **18**. Superseded by this tree, not deleted — D-10 |
| `baf2ac6` (08-27) | *"replace **all remaining** hardcoded demo metrics…"* | a large genuine sweep, but KI-3 still lists ~30 surviving sites, including `OrderManager::getAll()`'s random `DEL-` tracking numbers |
| `378f926` (08-27) | *"…100 % dynamic with live MySQL integration and real metrics"* | true for the named modules; `admin/Includes/adminheader.php` and `adminfooter.php` still ship fabricated values onto ~190 pages |

The pattern is consistent and worth internalising: **the sweeps were real, the "all" was aspirational.**
Verify per file before repeating a claim from a commit message.

## 4. The window this audit followed — 2026-08-27 → 2026-08-29

**2026-08-27 (58 commits)** — the "make it real" day. Live-MySQL binding landed across inventory
(`66508a7`, `92fa460`, `2324cac`), reviews moderation (`4d62a6d`, `712b800`), coupons
(`dd7753e` + the new `api/coupons.php`), WhatsApp broadcast + logging (`bbcf5b9` + `api/whatsapp.php`,
`7565cd5` writing `whatsapp_logs`), brands (`690868e` via `api/brands.php`), attributes (`9d9977d`),
customers (`4169038`, `8d0a749`, `96b668c`), orders (`d5375df`, `3e7cb0c`), stock adjustment
(`ca11461`), and standalone `/cart` `/checkout` `/wishlist` `/about-us` routes (`79f549a`).
`71b48b2`/`b4f54c2` added the `db_health.php` seeders that KI-2 records as a schema-drift hazard.

**2026-08-28 (4 commits)** — order drawers, packing slips, `customers.password_hash` fixes
(`af715e6`, `dab1147`), then two one-line redirect fixes: `4a97896` and `31be293` made the admin
login/logout redirects use a **canonical trailing slash** to avoid a 301 hop that dropped the session.
Small, and exactly the class of bug that only appears on live.

**2026-08-29 (1 commit)** — `a3d9e26`: dynamic dashboard analytics, live chart series and order
date-range filtering. This is the commit whose eight widgets the audit verified against the schema.

## 5. Unreleased — working tree, not yet committed

### 2026-08-29 · Documentation bootstrap (`AI/`)

**Documentation only. No application code was modified.** This is the bootstrap phase: understand,
document, organise, audit — explicitly *not* rewrite.

Added at the git root, alongside `AGENTS.md` — **27 documents plus 12 specialist briefs**:

**Registers and references:** `AI/MASTER.md` · `PROJECT_MEMORY.md` · `ARCHITECTURE.md` · `PROJECT_MAP.md` ·
`DATABASE.md` · `API.md` · `BACKEND.md` · `FRONTEND.md` · `ADMIN.md` · `SECURITY.md` · `PERFORMANCE.md` ·
`TESTING.md` · `DEPLOYMENT.md` · `INTEGRATIONS.md` · `BUSINESS_LOGIC.md` · `UI_SYSTEM.md` ·
`FILE_OWNERSHIP.md` · `KNOWN_ISSUES.md` (KI-1…KI-22) · `DECISIONS.md` (D-1…D-13) · `CHANGELOG.md`

**Operating protocol:** `ERROR_RECOVERY.md` · `AGENT_PROTOCOL.md` · `AGENT_HANDOFF.md` ·
`CLAUDE_MASTER.md` · `GEMINI_MASTER.md` · `TASK_STATE.md`

**Audit:** `AUDIT_REPORT.md` — 7 Critical, 12 High, 10 Medium, 6 Low, 8 Improvement, classified `C/H/M/L/I-n`
and cross-referenced to the `KI-n` and `SEC-n` registers. Its §7 lists ten findings that are **not**
findings, each with the decision that made them deliberate, and its §8 states what could not be checked
here at all.

**Specialist briefs:** `AI/agents/` — `frontend` `backend` `api` `database` `admin` `security` `testing`
`performance` `ui-ux` `devops` `cleanup` `integration`, plus a `README.md` index that names the seven files
with two owners.

Two values were **redacted from this tree** while writing it, because the tree's own rule is that no
credential appears in it: the live database name in `MASTER.md` §1 and in `ARCHITECTURE.md`'s topology
diagram. Both now reference SEC-1 by finding number instead.

Corrections made to earlier claims **inside this tree** while writing it — listed because each one was
wrong in a way that would have caused wasted or harmful work:

| Claim that was wrong | What is true |
| :--- | :--- |
| `gst_rate: -100` cancels the goods value (was in `SECURITY.md` SEC-5, `API.md` §5.1, `BACKEND.md` §4/§7) | **blocked** — `calculateGst()` throws on a negative rate (`PricingCalculator.php:27-29`) and `api/orders.php:227` returns 500 with no row written. The real holes are `gst_rate: 0`, negative `shipping`, and `payment_status` defaulting to `'paid'` with no ENUM whitelist |
| the free-shipping threshold is duplicated in 8 places | **two**: `shared/quickview.php:555` (live) and `assets/js/modals.js:756` (dead). The other `1999` hits are a coupon minimum, a demo price and three `z-index`es |
| `assets/css/{main,header}.css` are dead | **live** — linked by `admin/categories.php`, `admin/orders.php`, `admin/products.php` |
| `shared/quickview.php` is dead | **live on 6 storefront pages**; only `quickview_modal.php` is dead |
| `assets/css/wholesale.css` has 29 referrers | **1** — the admin module path contains the storefront path as a substring |
| `OrderManager` never updates customer counters | it does, at `:456-466`; the real gaps are that `lifetime_spend` accrues regardless of `payment_status` and `outstanding_balance` is never debited |
| the live schema has 17 tables | **18** (`grep -c 'CREATE TABLE' arniya_master_production.sql`) |
| the brand WhatsApp number differs in three places | all **47** raw occurrences are `917046363528`; only the *display format* varies — KI-17 |
| `reseller.js`'s 11 duplicate declarations are a `SyntaxError` that kills all 351 KB (was in `KNOWN_ISSUES.md` KI-21, `AUDIT_REPORT.md` H-4, `TASK_STATE.md` Q-7, `ERROR_RECOVERY.md` §3, `AGENT_HANDOFF.md` §5, `agents/frontend.md`, `agents/testing.md`, `GEMINI_MASTER.md`, `TESTING.md`) | **the file parses and runs.** All 11 are duplicate `function` declarations, which are legal in a classic script; `node --check` passes on it as a script; there is **no `type="module"` anywhere in `DT Brand/`** and `reseller.php:4044` loads it with a plain `<script src>`. The error only appears under `--input-type=module`. The real defect is that the shadowed copies **diverge** — `getWholesaleTier():840` uses `800/450/250/50` thresholds, the winning `:3083` uses `1000+` for Tier 5 — so the copy a reader finds first is the one that never runs. New product decision **P-8** |

**Nothing to upload for this entry.** `AI/` sits at the git root, one level above `DT Brand/`, so it is
outside the FTP payload and never reaches `/public_html/`. The pending upload list is unchanged by this
phase and still stands from the 2026-08-28/29 work — [TASK_STATE.md](TASK_STATE.md) §7.

**Verification of the documentation-only invariant:** `php -l` over all 452 tracked PHP files in
`DT Brand/` — clean, no syntax errors; `git status --short` shows additions under `AI/` and no other path.
No MySQL and no browser exist in this environment, so nothing runtime-dependent was verified here (KI-22).

**Phase closed.** No `KI-n` or `SEC-n` entry is closed by it — documentation records defects, it does not
fix them. The queue this phase produced is `TASK_STATE.md` §3 (B-1…B-8, owner), §4 (Q-1…Q-12, code) and
§5 (P-1…P-7, product decisions), ordered by `AUDIT_REPORT.md` §9.

## 6. How to add an entry

1. **Append under `## 5. Unreleased`** as you finish a task — dated `### YYYY-MM-DD · <short title>`.
2. Record **what landed**, with `file:line`. If a claim is unverified, say so; if a check could not be
   run (no MySQL here), say that instead of implying it passed.
3. **List the files the owner must upload**, and any migration they must run. A fix that is not
   uploaded is a fix they do not have — D-8.
4. Note any `KI-n` / `SEC-n` closed, and update that entry in place rather than deleting it.
5. **Never record a secret.** Refer to a credential by file, line and variable name only.

