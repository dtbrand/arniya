# Testing Guide — DT Brand's & Jai Hanuman Tex

Measured on 2026-09-13 (PHP 8.5.10 local, PHPUnit 10.5.64):
**131 tests, 770 assertions, 1 failure, 14 deprecations.**

## Quick commands

```bash
# Full PHPUnit suite (tests/Unit + tests/Integration via phpunit.xml)
vendor/bin/phpunit

# Single test class
vendor/bin/phpunit --filter DiscountTest

# Static analysis (level 1, phpstan.neon) — raise memory on Windows
php -d memory_limit=1G vendor/bin/phpstan analyse

# Syntax lint across the tree (used by CI)
php scripts/lint-all.php

# PHP-CS-Fixer (dry run)
vendor/bin/php-cs-fixer fix --dry-run

# Frontend linters (eslint / stylelint / prettier via package.json)
npm run lint
```

## PHPUnit suites

| Suite | Location | Focus |
| --- | --- | --- |
| Unit (PHPUnit) | `tests/Unit/` | Engines: Auth, Pricing, Money, Discount, OrderManager, CustomerManager, ProductCatalog, PaymentManager, MigrationRunner, AppArchitecture |
| Integration (PHPUnit) | `tests/Integration/OrderFlowTest.php` | End-to-end order flow against a test DB |
| Custom runners | `tests/test_unit_*.php`, `tests/test_admin_*.php` | Section-based master-spec suites (security, CSRF/IDOR, rate limits, inventory ledger, payment idempotency, admin modules…) run via `php tests/test_*.php` |
| Bootstrap | `tests/bootstrap.php` | Autoload + mock-DB environment (`Database::$isMockMode`) |

Custom suites are standalone scripts — execute them directly:

```bash
php tests/test_unit_security_auth_csrf_idor.php
php tests/test_unit_cart_checkout_stock_safety.php
php tests/test_admin_master_audit.php
```

## What CI enforces (`.github/workflows/ci.yml`)

1. `composer validate --strict`
2. `composer install`
3. **Zero** syntax errors (`php scripts/lint-all.php`)
4. Full PHPUnit suite must pass
5. Frontend QA job: eslint, stylelint, prettier check, Playwright build

Also on GitHub Actions: **CodeQL** (`codeql.yml`), **Trivy** (`trivy.yml`),
**Scorecard** (`scorecard.yml`), **Release Please** (`release-please.yml`).

## Playwright e2e

`playwright.config.js` targets the PHP built-in server. Install browsers once
(`npx playwright install`), then run the configured flows from `npm test` /
`npx playwright test`. Results land in `test-results/` (git-ignored).

## Verification scripts (live/deployed targets)

| Script | Checks |
| --- | --- |
| `scripts/smoke-test.php` | Local smoke: classes load, pages boot |
| `scripts/check-page-fatals.php` | Boots every page, catches fatals |
| `scripts/check-class-loads.php` / `check-includes.php` | Include-graph integrity |
| `scripts/comprehensive-test.php` | 1000+ assertions across engines |
| `scripts/verify_live.py` (+ `_seo`, `_guard`, `_b2b_security`) | Deployed-site probes |
| `scripts/verify_variant_order_pipeline.py` | Variant → order pipeline |
| `scripts/benchmark.php` | Micro-benchmarks |
| `scripts/restore-test.php` | Backup restore drill |

## Current known test gap (2026-09-13)

`tests/Unit/DiscountTest::testUnreachableDatabaseReturnsExplicitInvalid`
fails: when the DB is unreachable, `DiscountEngine` returns
`"invalid or expired coupon code: …"` instead of an explicit
"coupon service unavailable" message, conflating "bad coupon" with
"database down". The storefront therefore shows the wrong error during a DB
outage. Fix the engine (or the test expectation) before the next release —
tracked in `docs/audits/2026-09-13-master-audit.md`.
