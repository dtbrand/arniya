# Deployment Guide — DT Brand's & Jai Hanuman Tex

Target platform: **Hostinger Business** (PHP 8.2 + MySQL 8.0), live site
`https://jaihanumantex.in/`. This guide reflects the tree as audited on 2026-09-13.

## 1. One-time setup

1. Hostinger control panel → create the MySQL database and user (full privileges).
2. Upload the tree to `/public_html/` via File Manager or FTP.
3. Copy `.env.example` → `.env` and fill **real** values:

   ```ini
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://jaihanumantex.in

   DB_HOST=localhost
   DB_PORT=3306
   DB_NAME=<your db>
   DB_USER=<your user>
   DB_PASS=<your password>

   RAZORPAY_KEY_ID=rzp_live_…
   RAZORPAY_KEY_SECRET=…
   RAZORPAY_WEBHOOK_SECRET=…
   ```

   > **Security note:** `.env.example` ships with a placeholder that must be
   > replaced; never commit `.env` (it is git-ignored). The audit on
   > 2026-09-13 found real credentials hardcoded in 17 tracked files —
   > rotate them and move to environment-only configuration. See
   > `docs/audits/2026-09-13-master-audit.md` (CRITICAL findings).

4. Upload `composer.lock` and run:

   ```bash
   composer install --no-dev --optimize-autoloader
   ```

## 2. Run the installer

```bash
cd ~/domains/jaihanumantex.in/public_html
php install.php
```

The installer:

1. Checks PHP version + extensions.
2. Applies every `database/migrations/*.sql` in lexicographic order (idempotent).
3. Seeds the minimum catalogue (categories, admin user, coupons, banners).
4. Verifies all expected tables exist and prints a readiness summary.

**Delete `install.php` from the server afterwards** so the public cannot re-run it.

Seeded admin login: `/admin/login.php` — change the password immediately on first sign-in.

## 3. Cron jobs (Hostinger → Cron Jobs)

```cron
*/5 * * * * php /home/uXXXX/domains/jaihanumantex.in/public_html/api/db_health.php >/dev/null 2>&1
```

Optional daily maintenance (log rotation, backups):

```cron
0 3 * * * php /home/uXXXX/domains/jaihanumantex.in/public_html/scripts/rotate-logs.php >/dev/null 2>&1
0 4 * * * php /home/uXXXX/domains/jaihanumantex.in/public_html/scripts/backup-database.php >/dev/null 2>&1
```

## 4. Triple-sync deployment (Local → GitHub → Hostinger FTP)

Every change follows the three-step sync. The repo ships tooling for all three:

```bash
# 1. Local — validate
php scripts/lint-all.php          # php -l across the tree
vendor/bin/phpunit                # test suite

# 2. GitHub — commit + push
git add <files>
git commit -m "feat(scope): change"
git push origin main

# 3. Hostinger FTP — upload changed files
python scripts/deploy_triple_sync.py     # dual-target FTP sync (HarmitEthnic + JaiHanumanTex)
# or: php scripts/ftp-deploy.php  /  scripts/ftp-deploy.ps1
```

The FTP scripts maintain an explicit file manifest (`scripts/ftp-deploy.php`)
— when you add a new production file, register it there so triple-sync picks it up.

## 5. Post-deploy verification

```bash
python scripts/verify_live.py          # page-level smoke checks
python scripts/verify_live_seo.py      # sitemap, robots, canonical
python scripts/verify_live_guard.py    # admin/API guards fail closed
python scripts/verify_live_b2b_security.py
php scripts/smoke-test.php
```

Checklist:

- [ ] `https://jaihanumantex.in/` returns HTTP 200.
- [ ] `/api/health.php` healthy; DB diagnostics green.
- [ ] Admin login works; password already rotated.
- [ ] Test order end-to-end (UPI deep link + webhook capture) on a cheap product.
- [ ] `install.php` **deleted** from the server.
- [ ] `.env` present but not web-readable (`.htaccess` FilesMatch denies it).

## 6. Rollback

1. **Code:** redeploy the previous deployment ZIP
   (`scripts/build-deploy-zip.php` produces versioned artifacts) via FTP.
2. **Database:** migrations are forward-only; restore the latest
   `scripts/backup-database.php` snapshot and re-run the pre-migration backup.
   Full runbooks: `docs/rollback-strategy.md`, `docs/database-backups.md`,
   `docs/disaster-recovery.md`.

## 7. Production secrets policy

- Secrets live **only** in `.env` (and Hostinger's storage). Nothing else.
- Webhook secrets are verified with `hash_equals` (Razorpay HMAC-SHA256,
  Cashfree base64 HMAC) before any state change.
- If a secret ever lands in git: revoke it immediately, rotate on the provider,
  then purge history (BFG / `git filter-repo`). Rotating beats purging.
