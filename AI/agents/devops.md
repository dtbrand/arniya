# AGENT BRIEF · DEVOPS

> **Scope:** `DT Brand/.htaccess`, the deployment path, environment variables, and the git repository
> itself. **You do not deploy** — the owner pushes to GitHub and uploads by FTP to Hostinger (D-8).
>
> Read with [DEPLOYMENT.md](../DEPLOYMENT.md) and [DECISIONS.md](../DECISIONS.md) D-7, D-8.

---

## 1. The deployment model, and the bug it causes

**`DT Brand/`'s *contents* become `/public_html/`.** The folder name is not part of any live URL. That was
set on 2026-08-25 by `e3824e7` *"route clean URLs, link normalize to root, and bundle assets into DT
Brand"*, and it is the origin of **16 `/DT%20Brand/` prefixes still in 6 admin JS files** — written for the
local XAMPP layout, where the folder name *was* in the path (KI-10). They 404 on live.

There is **no CI that touches live.** GEN-A's `.github/workflows/*` describes a structure that was never
adopted (D-1). The nineteen `chore: sync … to GitHub and Hostinger FTP` commits are the closest thing to a
release log — and **they do not prove the upload happened, and they never include the database**
([CHANGELOG.md](../CHANGELOG.md) §2).

**MySQL is migrated separately**, by the owner running `php database/migrate.php` on live. So a commit that
mentions "database upgrades" means the migration *file* was committed, not that it ran. That is the whole
mechanism behind KI-4's phantom columns.

## 2. Every task ends with an upload list

Not a courtesy — the deliverable. Name full paths (`DT Brand/admin/index.php`), say whether a migration is
involved, and say what the owner should see afterwards. **A fix that is correct locally and not uploaded is a
fix the owner does not have.**

Currently pending upload, carried forward: `admin/index.php`, `admin/admin.php`, `admin/Asset/js/admin.js`,
`api/orders.php`, `admin/login.php`, `admin/adminlogin.php`, `src/Auth.php` — plus a re-run of
`database/migrate.php` for the `customers.password_hash` nullable change, the customer counter columns,
`order_items.variant_color` / `variant_size`, and `customer_notes`.

## 3. Environment variables — the sequence is not negotiable

Eight variables: `DB_HOST` `DB_PORT` `DB_NAME` `DB_USER` `DB_PASS` `ADMIN_EMAIL` `ADMIN_PASSWORD`
`ADMIN_NAME`.

**There is no `.env` loader anywhere in this project.** Creating a `.env` file achieves nothing — only real
process environment variables reach `getenv()`. They must be set in hPanel.

The owner's chosen order (D-7): **rotate the password → set all eight → confirm they resolve on live with a
length-only probe → only then delete the `?: '<literal>'` fallbacks.** Deleting a fallback before the
confirmation takes the site down, and an agent may not assume the confirmation happened.

Never print a value. A probe reports a length or a boolean, nothing else.

## 4. `.htaccess` — one file, whole-site blast radius

One `.htaccess` serves 452 PHP entry points. Two rules to respect and one gap to close:

- **Clean URLs and the canonical trailing slash.** `/admin/`, not `/admin` — a 301 hop drops the session, and
  the symptom is "sign-in succeeds and lands back on the login page" (`4a97896`, `31be293`).
- **`database/arniya_master_production.sql` is web-served with no deny rule** (SEC-4). Adding one is a real
  fix, and it is also the kind of change that can 500 an entire site — propose it, keep it minimal, and tell
  the owner exactly how to revert (re-upload the previous file).
- **Never enable `display_errors` on live.** A blank white page is a PHP fatal; read the host's error log
  instead ([ERROR_RECOVERY.md](../ERROR_RECOVERY.md) §3).

## 5. Git — what is allowed from here

Safe and local:

```bash
git -C "/c/Users/sai/Desktop/WhatsApp CRM" status --short
git -C "/c/Users/sai/Desktop/WhatsApp CRM" diff
git -C "/c/Users/sai/Desktop/WhatsApp CRM" checkout -- "<path>"
```

Retrieving a known-good version for the owner to re-upload — the closest thing to a rollback available:

```bash
git -C "/c/Users/sai/Desktop/WhatsApp CRM" log --oneline -- "<path>"
```

**Requires the owner's explicit permission, every time:** `reset --hard`, `push --force`, `clean -f`,
`branch -D`, `rebase`, amending a pushed commit, and history rewriting (`filter-repo` / BFG). History
rewriting also rewrites every hash and needs a force-push — it is the owner's decision, taken as its own
task, and it is coupled to SEC-1.

**Do not commit unless asked.** When asked: stage named files, never `git add .`, and check `.env`,
`config/database.php` and `.git/config` first — the last has held a **GitHub token in the `origin` URL**,
which needs revoking and replacing with SSH or a credential helper (SEC-1).

## 6. Verification

```bash
find "DT Brand" -name '*.php' -print0 | xargs -0 -P 8 -n 1 /c/xampp/php/php.exe -l 2>&1 | grep -v "No syntax errors"
```

That sweep is the whole pre-upload gate. **There is no staging environment, no MySQL here and no way to reach
live** (KI-22) — so `.htaccess` changes, redirect behaviour, env resolution and migrations are all
**unverified until the owner tests on live**. Say so, and give them the one-line check to run.

