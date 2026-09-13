# Master Security Audit & Vulnerability Assessment

**Assessment Date:** 2026-09-13 (supersedes 2026-08-23)
**Auditor:** Autonomous verification pass — every row below cites live evidence, not intent.
**Companion:** `docs/audits/2026-09-13-master-audit.md` (full remediation detail)

---

## 1. Vulnerability Matrix

| Attack Vector | Evidence-Verified Finding | Status |
| --- | --- | --- |
| **Credential leakage** | Real DB/FTP password in **17 git-tracked files** (`AGENTS.md`, `config/database.php`, `src/Database.php`, `src/Auth.php`, deploy scripts…); GitHub **PAT embedded in the origin remote URL**; deployment ZIP in repo contains 6 password-bearing files | 🔴 **CRITICAL** — rotate + purge (C1) |
| **Auth-path fatal** | `api/auth/index.php:46` calls `DTBrand\RateLimiter` (class is global-namespace) → `Class not found` fatal on login/register via this router | 🔴 **CRITICAL** (C2) |
| **SQL Injection (SQLi)** | PDO prepared statements, `EMULATE_PREPARES=false`; `db_health.php` validates table names against `SHOW TABLES` before interpolation | **PASS** |
| **Cross-Site Scripting (XSS)** | Output escaped in page templates; CSP + security headers suite (Sections 55–61) | **PASS** |
| **Cross-Site Request Forgery (CSRF)** | CSRF-bound `dtAdminFetch` across admin writes (commit `e417a92f`) | **PASS** |
| **IDOR / order enumeration** | `api/orders.php` returns HTTP 401 **before** any DB query when anonymous (commit `27b21b0b`); tenant ownership checks on customer data | **PASS** |
| **Brute force** | `RateLimiter` sliding window (5/15 min login, 3/h register) wired in `src/Auth.php` — but **broken on the API auth router** (see C2) | **PASS (storefront) / FAIL (API router)** |
| **Payment webhook forgery** | Razorpay HMAC-SHA256 with `hash_equals`, idempotent on event id; webhook replay queue + protection | **PASS** |
| **Cashfree capture integrity** | `api/payments/cashfree_webhook.php:87,112` references undefined `$data` → fatal on `ORDER_PAID`; signature check passes but capture crashes | 🟠 **HIGH** (H1) |
| **Path traversal / LFI** | Includes use `__DIR__` constants; no user input reaches `include` | **PASS** |
| **Upload abuse** | Uploads dir blocks execution of `*.php/phtml/phar/cgi/pl/sh`; extension + MIME validation in `api/upload.php` | **PASS** |
| **Internal exposure** | `.htaccess` denies `config`, `database`, `src`, `tests`, `scripts`, `vendor`, `docs`, `backups`, `.git` and more + FilesMatch on `.env*`, `*.json`, `*.sql`, `*.md`, `*.phar` — but **`Shared/` is not denied** and serves raw partials/`Shared/Includes/db.php` | 🟠 **HIGH** (H3) |
| **Secret masking in logs** | `AuditManager` recursive masking (passwords, tokens, keys, CVV → `[REDACTED]`); integrations suite masks credentials | **PASS** |
| **Admin session security** | `adminguard.php` single entry; roles/permissions matrix + active session controls (Section 34) | **PASS** |

## 2. Secrets Exposure Inventory (C1 detail)

| Location | Secret | State |
| --- | --- | --- |
| `.env` (working copy) | DB pass | **Not tracked** ✓ |
| `.env.example` | Real DB pass (should be placeholder) | Tracked ✗ |
| 15 further tracked PHP/MD/PS1 files | DB pass | Tracked ✗ |
| `.git/config` origin URL | GitHub PAT | Present ✗ |
| `AGENTS.md` / `GEMINI.md` | FTP + DB + UPI credentials in plaintext | Tracked ✗ |
| `DT_Brand_Deployment_20260907_035202.zip` (tracked, 7.9 MB) | 6 files inside contain DB pass | Tracked ✗ |

**Mandatory sequence:** rotate DB/FTP/PAT → strip hardcodes into `.env` →
remove ZIP from repo → purge history (`git filter-repo`) → enable secret
scanning push protection.

## 3. Defense-in-Depth Posture (verified working)

- Fail-closed guards: `api/_guard.php` (401 JSON), `admin/includes/adminguard.php`.
- Canonical 301s ensure legacy `Frontend/*` URLs land on guarded root pages.
- `payment_transactions` audit: client IP, user-agent, payload, UTR, timestamps.
- Inventory ledger records every stock mutation with actor + reason.
- Price tier never read from request body (server-side session resolution).

## 4. Recommendation Priority

1. **Immediately** rotate all credentials in the C1 inventory; revoke the PAT.
2. Fix the C2 auth-router fatal (one-line namespace fix + regression test).
3. Fix H1 Cashfree `$data` and H3 `.htaccess` Shared deny this week.
4. Maintain weekly CodeQL + Trivy scans (already configured in GitHub Actions).
