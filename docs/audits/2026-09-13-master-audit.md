# Master Audit — DT Brand's & Jai Hanuman Tex

**Audit date:** 2026-09-13
**Method:** Live evidence gathering — `php -l` across root/src/api/config/includes/admin,
full PHPUnit run (PHP 8.5.10, PHPUnit 10.5.64), PHPStan level 1 with 1 GB memory,
git-tracked-file secrets scan, directory-structure verification, `.htaccess` and CI
workflow review. Every finding below cites its evidence.

---

## 1. Executive Summary

The codebase is **structurally strong**: zero PHP syntax errors across every core
directory, a broad 131-test/770-assertion suite, layered guards on every admin/API
write, idempotent payment capture, and a genuine no-mock-data policy on the
production path. However, the audit confirms **one runtime fatal on the public
auth path**, **real production credentials committed to git in 17 files plus a
GitHub token embedded in the remote URL**, and several stale-documentation
claims that contradict the tree. Two findings are CRITICAL and should be
remediated before any further deployment.

### Grade: B− (Good architecture, urgent security hygiene + 1 fatal bug)

---

## 2. Findings Ledger

### 🔴 CRITICAL

#### C1. Production secrets committed to git (17 tracked files + remote URL token)

**Evidence:**

- `git grep -l "Gautam@9006"` → **17 tracked files**, including
  `.env.example`, `AGENTS.md`, `GEMINI.md`, `config/database.php`,
  `src/Database.php`, `src/Auth.php`, `src/SystemManager.php`,
  `api/db_health.php`, `install.php`, `database/migrate.php`,
  `scripts/deploy_triple_sync.py`, `scripts/ftp-deploy.php`,
  `scripts/ftp-deploy.ps1`, `scripts/patch_remote_schema.py`,
  `scripts/remote_db_schema_probe.py`, plus two test files.
- `git remote -v` → the GitHub **Personal Access Token (`ghp_…`) is embedded in
  the origin URL** and therefore persisted in `.git/config` and any shared
  clone scripts.
- `AGENTS.md` additionally publishes the full production FTP host/user/password,
  MySQL credentials, and UPI VPA in plaintext.
- The tracked artifact `DT_Brand_Deployment_20260907_035202.zip` (7.9 MB, 712
  files) contains **6 files with the real DB password** inside the archive.
- `.env` itself is **not** tracked (good) and `.htaccess` denies web access to
  `.env*` (good) — the exposure is via the repository, AGENTS.md, and the ZIP.

**Impact:** Anyone with repository access (and anyone who has ever cloned it)
holds production DB, FTP, and possibly org-repo write credentials.

**Remediation (order matters):**

1. **Rotate first, clean second**: change MySQL password, FTP password, and
   revoke the GitHub PAT immediately; issue a fine-grained PAT and store it in
   the credential manager — never in the remote URL
   (`git remote set-url origin https://github.com/dtbrand/arniya.git`).
2. Move all credentials to `.env` (already git-ignored) and replace hardcoded
   fallbacks in `src/Database.php` / `config/database.php` with explicit
   failures when env vars are missing.
3. Rewrite `AGENTS.md` to reference `.env` keys instead of literal secrets.
4. Remove the deployment ZIP from the repo (artifacts belong in Releases/CI).
5. Purge history with `git filter-repo`/BFG **after** rotation; enable secret
   scanning push protection.

---

#### C2. `DTBrand\RateLimiter` namespace fatal on the public auth router

**Evidence:**

- `src/RateLimiter.php` declares `class RateLimiter` with **no namespace**
  (verified line 12).
- `api/auth/index.php` line 30 imports `use DTBrand\RateLimiter;` and line 46
  calls `RateLimiter::enforce(...)` — resolves to `DTBrand\RateLimiter`,
  which does not exist →
  `Uncaught Error: Class "DTBrand\RateLimiter" not found`.
- Trigger: **any** `login` / `register` / `forgot_password` / `reset_password` /
  `admin_login` request routed through `api/auth/index.php` fatals before auth
  executes.
- `src/Auth.php` correctly uses the global `\RateLimiter` (lines 232/333), so
  only this router is affected — which still breaks the public API auth flow.
- Confirmed independently by PHPStan:
  `api/auth/index.php:46 — Call to static method enforce() on an unknown class DTBrand\RateLimiter`.

**Remediation:** choose one canonical namespace:
- **Preferred:** add `namespace DTBrand;` to `src/RateLimiter.php`, update the
  two global calls in `src/Auth.php` and `tests/test_unit_security_auth_csrf_idor.php`,
  and update `phpstan.neon` baseline ignore (`RateLimiter::$memCache`).
- Or: in `api/auth/index.php`, `use RateLimiter;` (global) instead.
Then add a regression test hitting the router in mock mode.

---

### 🟠 HIGH

#### H1. PHPStan: undefined `$data` in Cashfree webhook (possible fatal + broken capture)

`api/payments/cashfree_webhook.php:87` and `:112` — inside
`handleOrderPaid(array $order)`, `$data` is referenced (`$data['payment']['cf_payment_id'] ?? …`,
`$data['payment']['payment_method'] ?? …`) but never defined in that function's
scope. Under `strict_types` this is a fatal (`Error`) when a Cashfree
`ORDER_PAID` webhook fires — meaning **Cashfree captures will fail**, and the
fallback `?? 'upi'` never applies. Fix: pass the payment payload into the
function or read from `$order['payment_details']`.

#### H2. PHPStan: `AuditManager::log()` called statically with wrong arity (6 call sites)

`api/developer.php` lines 138, 177, 181, 201, 245, 263 call
`AuditManager::log('developer', 'webhook_retry', [...])`, but the real
signature is `public function log(array $params): int` (instance method,
single array param). Every webhook retry/queue/HMAC action in the developer
suite fatals. Fix: instantiate once and call `->log([...])` with named params.

#### H3. `Shared/` is web-reachable and not in the internal-dir deny list

`.htaccess` blocks `config|database|src|app|storage|tests|scripts|scratch|
vendor|bootstrap|docs|backups|.git|.agents|.uix|.vscode` but **not `Shared/`**.
The `Shared/` partials (cart, checkout, quickview, `Shared/Includes/db.php`,
`logger.php`, `sentry.php`) render raw HTML/execute outside the page context
when requested directly. Add `Shared` to the protected-dirs RewriteRule.

#### H4. README contradicts the tree (onboarding trap)

- README claims "**no `Shared/` mirror**" — `Shared/` exists, is git-tracked
  (20 files), and is **actively included** by every storefront page
  (index, shop, product, cart, checkout, wishlist, account, wholesale,
  reseller, retailer…).
- README references `AI/KNOWN_ISSUES.md` — no `AI/` directory exists.
- README points to `github.com/dtbrand/dtbrand-storefront.git` — the actual
  remote is `github.com/dtbrand/arniya.git`.
- `DT Brand/` is an **empty untracked directory** — safe to delete.

**Remediation:** update README (a corrected `ARCHITECTURE.md` now exists),
delete the empty `DT Brand/` dir.

---

### 🟡 MEDIUM

#### M1. PHPUnit: 1 failing test — DiscountEngine conflates DB outage with bad coupon

`tests/Unit/DiscountTest::testUnreachableDatabaseReturnsExplicitInvalid`
(131 tests / 770 assertions / **1 failure** / 14 deprecations): on an
unreachable database the engine returns `"invalid or expired coupon code:
save10"` instead of an explicit "service unavailable" message. Customers see
"bad coupon" during outages. Fix the engine to return a distinct
unavailable state (and keep the test).

#### M2. PHPStan: dead-guard `isset($pdo)` in seven integrations pages

`admin/integrations/{index,diagnostics,logs,messaging,payment,shipping,webhooks}.php:23`
— `Variable $pdo in isset() always exists and is always null`. The guard is
dead code; the pages likely fall through to an error path on a dead DB instead
of rendering their fallback.

#### M3. Local PHPStan worker crashes under default 128M memory

`php -d memory_limit=1G vendor/bin/phpstan analyse` is required. CI (Ubuntu)
is unaffected, but local runs fail confusingly ("2 errors" = worker crashes).
Document in TESTING.md (done) or raise `memory_limit` in `phpstan.neon`.

#### M4. Stale docs/ audit reports (now refreshed)

`docs/project-audit.md`, `docs/security-audit.md`, `docs/ui-audit.md`,
`docs/performance-audit.md` were dated 2026-08-23 and described a `Frontend/`
tree that no longer exists; performance numbers cited `/Frontend/Home/home.php`.
All four were refreshed alongside this audit (see links at bottom).

#### M5. 14 PHPUnit deprecation notices

PHPUnit 10.5 flags 14 deprecations (mostly data-provider/return-type
signatures). Non-blocking; schedule a pass before the PHPUnit 11 bump.

---

### 🟢 PASS (verified good)

| Area | Evidence |
| --- | --- |
| **Zero PHP syntax errors** | `php -l` clean across root (24 pages), `src/` (25), `api/` (43 + 18 routers), `config/` (9), `includes/` (14), `admin/` (333) |
| **Admin guard chain** | `admin/includes/adminguard.php` exists and README's claim holds; `api/_guard.php` fails closed (HTTP 401 JSON) |
| **Order enumeration fixed** | `api/orders.php` details 401 before any DB query (commit `27b21b0b`) |
| **Rate limiting exists** | `RateLimiter` sliding window (Redis → file), wired into `src/Auth.php` login + admin login (except the C2 router bug) |
| **Idempotent payment capture** | Migration 25 (`add_idempotency_and_stock_safety`), webhook queue + replay protection |
| **SQLi posture** | PDO prepared statements with `EMULATE_PREPARES = false`; `db_health.php` validates table names against `SHOW TABLES` before interpolating |
| **Upload hardening** | `.htaccess` blocks PHP execution in `assets/images/uploads/` |
| **No fabricated data** | DB-down renders honest empty states (ProductCatalog `[]`, OrderManager `[]`) — README's "what real means" holds |
| **CI gates** | Lint (0 errors), PHPUnit, PHPStan, ESLint/Stylelint/Prettier, Playwright; CodeQL + Trivy + Scorecard + Release Please |
| **Health endpoints** | `/api/health.php`, `/api/db_health.php` (admin-guarded) |
| **Secrets not web-readable** | `.htaccess` FilesMatch denies `.env*`, `*.json`, `*.lock`, `*.sql`, `*.md`, `*.phar`… |

---

## 3. Test & Static Analysis Baseline (2026-09-13)

| Check | Result |
| --- | --- |
| `php -l` (all core dirs) | **0 errors** |
| PHPUnit | **131 tests, 770 assertions, 1 failure, 14 deprecations** |
| PHPStan (level 1, 1G) | **22 errors** across 4 files (C2, H1, H2, M2 above) |
| ESLint/Stylelint | Not run in this audit (CI covers on push) |

---

## 4. Remediation Roadmap (priority order)

1. **Today** — C1 rotation (DB, FTP, GitHub PAT), remove token from remote URL, delete ZIP from repo.
2. **Today** — C2 namespace fix + regression test (auth API currently broken).
3. **This week** — H1 Cashfree `$data`, H2 `AuditManager::log()` call sites, H3 `.htaccess` Shared deny.
4. **This week** — H4 README corrections; delete empty `DT Brand/`.
5. **Next sprint** — M1 DiscountEngine unavailable-state, M2 dead isset guards, M5 deprecations.

---

## 5. Companion Documents (refreshed in this audit)

- `docs/project-audit.md` — full engineering system audit (2026-09-13)
- `docs/security-audit.md` — vulnerability matrix (2026-09-13)
- `docs/ui-audit.md` — UI/responsive/accessibility compliance
- `docs/performance-audit.md` — caching/compression benchmark map
- Root docs: `ARCHITECTURE.md`, `API.md`, `DATABASE.md`, `DEPLOYMENT.md`, `TESTING.md`
