# DEPLOYMENT

> How this project reaches production, what maps where, and the two traps that make a deployment
> silently wrong. Measured 2026-08-29 from tracked files. **I do not deploy — the owner deploys.**

---

## 1. The model

Two destinations, both driven by hand:

| Destination | What goes there | How |
| :--- | :--- | :--- |
| GitHub `dtbrand/arniya`, branch `main` | the whole repository | `git push` |
| Hostinger `/public_html/` | **the *contents* of `DT Brand/`** | FTP upload |

There is no CI deployment, no rsync script, no webhook, no `.env` on the server. Nothing in this
repository can deploy anything. The GitHub Actions pipeline builds an artifact that must **not** be
deployed (§4).

## 2. The path mapping — the most common source of broken links

```
repo:  C:\Users\sai\Desktop\WhatsApp CRM\DT Brand\shop.php
live:  /public_html/shop.php          →  https://jaihanumantex.in/shop.php  (or /shop)
```

**`DT Brand/` *is* the web root.** Its name never appears in a URL. Consequences that bite:

- An absolute path must start at `/`, never `/DT Brand/` or `/DT%20Brand/`. There are **16** surviving
  `/DT%20Brand/…` prefixes, all in admin JS, and all 404 on live
  ([FRONTEND.md](FRONTEND.md) §7). Do not confuse them with the 9 legitimate `DT%20Brand` strings
  inside `wa.me` message text.
- `$_SERVER['DOCUMENT_ROOT']` on live is `/public_html`, so the admin guard's
  `$_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'` resolves correctly there — and
  resolves to nothing under a local server whose document root is the repository root. The
  `if (is_file($__dtg))` test is what stops that from being fatal ([ADMIN.md](ADMIN.md) §3).
- Everything **outside** `DT Brand/` — `Frontend/`, root `src/ api/ admin/ app/ bootstrap/ config/
  public/ tests/`, `AGENTS.md`, this `AI/` tree — must **never** be uploaded. It is frozen or
  scaffold ([PROJECT_MAP.md](PROJECT_MAP.md) §1). Uploading root `index.php` would replace the
  storefront with a GEN-B page that requires `Frontend/Home/home.php`.
- `DT Brand/.htaccess` is the **only** `.htaccess` in the live tree (72 lines) and the only one that
  should ever reach `/public_html/`. The root `.htaccess` belongs to GEN-A.

## 3. `.env` does not work here — and that changes the credential fix

Verified by grep across the entire live tree: **there is no `.env` loader.** No Dotenv, no
`parse_ini_file`, no manual parser. `.env.example` exists at the repository root and is a GEN-A
artifact; creating a matching `.env` on Hostinger would have **no effect whatsoever**, and no error
would be raised — every `getenv('DB_PASS') ?: '<literal>'` would keep silently using the literal.

This is the trap that makes the [SECURITY.md](SECURITY.md) SEC-1 remediation fail quietly. `getenv()`
reads only the real process environment. On Hostinger shared hosting that means either an
`SetEnv`/`php_value` mechanism in `.htaccess` or hPanel's own environment settings — and under
PHP-FPM (as opposed to `mod_php`) Apache's `SetEnv` does **not** reliably reach `getenv()`.
**This has not been tested on the live host and must be, before any fallback literal is deleted.**

Probe it with a single temporary file, uploaded, hit once, then deleted:

```php
<?php // envprobe.php - DELETE IMMEDIATELY AFTER READING
header('Content-Type: text/plain');
foreach (['DB_HOST','DB_PORT','DB_NAME','DB_USER','DB_PASS','ADMIN_EMAIL','ADMIN_PASSWORD','ADMIN_NAME'] as $k) {
    echo $k, ' => ', (getenv($k) === false ? 'NOT SET' : 'set (' . strlen(getenv($k)) . ' chars)'), PHP_EOL;
}
```

It prints lengths, never values. If any line reads `NOT SET`, the fallback literal for that variable
is still load-bearing and must not be removed.

`.env.example` is also **missing four variables the live code actually reads**: `ADMIN_EMAIL`,
`ADMIN_NAME`, `ADMIN_PASSWORD` and `CDN_URL`. `ADMIN_PASSWORD` is the master-credential override
(SEC-2) — the single most important variable to set, and it is absent from the only file that
documents them. The live tree reads 31 `getenv()` names in total; `.env.example` lists 28.
## 4. The CI artifact is a footgun — do not deploy it

`.github/workflows/ci.yml:90-110` defines a `package-artifact` job that runs
`zip -r dtbrand-release.zip Frontend Shared src database docs .htaccess index.php admin.php adminlogin.php health.php`
and uploads it as **`dtbrand-production-bundle`**, retained 14 days.

Every path in that list is GEN-B frozen or GEN-A scaffold. `DT Brand/` appears nowhere in the
workflow. Restoring that "production bundle" would overwrite the live storefront and admin console
with the previous generation. Rename the job or delete it — see [TESTING.md](TESTING.md) §6 step 3.

## 5. Database changes are a separate, manual step

FTP moves files; it does not touch MySQL. `DT Brand/database/migrate.php` is the runner and it
executes **exactly one** file — `arniya_master_production.sql`, 18 tables plus seeds. The three files
under `database/migrations/` never run, which is why their columns show up as phantom-column bugs
([DATABASE.md](DATABASE.md), [KNOWN_ISSUES.md](KNOWN_ISSUES.md) KI-4).

So a schema change is: edit `arniya_master_production.sql` → upload → run the migrator on the host →
verify. It is idempotent (`CREATE TABLE IF NOT EXISTS`, guarded `ALTER`s), but it is **not** reversible
and it is **not** run by uploading files.

Pending on live right now, none of it applied by an upload alone:

- `customers.password_hash` → nullable `MODIFY`
- `customers` additions: `total_orders`, `lifetime_spend`, `gstin`, `pan`, `commission_rate`,
  `reset_token`, `reset_expires`, `last_login`
- `order_items` additions: `variant_color`, `variant_size`
- the `customer_notes` table

Never `DROP`, `TRUNCATE` or run an unconditioned `DELETE` on the live database. That requires the
owner's explicit authorisation plus a stated impact analysis, per the operating rules — and a dump
taken first.

## 6. Upload checklist

Before:

1. `git status` clean, and the change committed. The repository is the record of what is on the host.
2. Lint the live tree — the one automated check that covers it
   ([TESTING.md](TESTING.md) §4). Silence is a pass.
3. Confirm the file list. Only paths under `DT Brand/`.

During:

4. Upload in **binary** mode. `DT Brand/assets/images/*` and any `.mp4` corrupt in ASCII mode.
5. Upload `.htaccess` explicitly — most FTP clients hide dotfiles by default, and a stale
   `.htaccess` breaks every clean route in one step.
6. If a schema change is involved, upload first, then run the migrator, then verify.

After:

7. Hard-reload. Live CSS/JS is served with a 1-month `mod_expires` header where the static `?v=`
   stamp is used ([PERFORMANCE.md](PERFORMANCE.md) §2), so a stale asset is the normal first symptom
   of a "the fix didn't work" report.
8. Check the pages the change touched, plus `/admin/login/` and one storefront page, before calling it
   done.

## 7. Known deployment-coupled hazards

| Hazard | Why it is coupled |
| :--- | :--- |
| Removing the `getenv() ?:` DB fallbacks | Site goes down instantly if the env vars are not actually reaching `getenv()` (§3). **Probe first.** |
| Changing `ADMIN_PASSWORD` handling | `src/Auth.php:301` is the owner's lockout insurance and re-stamps the admin row on every sign-in (`:317-334`). Change the value and the storage together, and verify a sign-in before closing the session. |
| Editing `.htaccess` | Every clean route, the compression and the caching live in one 72-line file. A syntax error is a site-wide 500. Keep a copy of the working version. |
| Rotating the DB password | Must land in hPanel **and** in whatever supplies `getenv()`, in that order, or the site is down between the two. |
| Purging git history for the committed credentials | Rewrites every commit hash and needs a force-push. Owner's decision, recorded in [DECISIONS.md](DECISIONS.md) — not a side effect of another task. |

## 8. Sync commits

Deployments are recorded as `chore: sync …` commits, which is the convention to follow — the message
names what was synced to GitHub **and** to Hostinger FTP, so the git log doubles as the deployment
log. Recent examples:

```
a3d9e26  chore: sync dynamic admin dashboard analytics, live chart series, and order date-range filtering …
af715e6  chore: sync comprehensive order drawers, packing slips, customer password hash fixes, and database upgrades …
dab1147  chore: sync comprehensive customer studio, catalog, variant orders, and database upgrades …
```

Fixes that were themselves deployment problems use `fix(admin):` and say so — `31be293` and `4a97896`
both correct trailing-slash 301 hops that discarded a POST body ([ADMIN.md](ADMIN.md) §5).

