# SECURITY

> Findings are numbered `SEC-n` and ordered by severity, not by discovery. Each one names the file,
> the line and the variable — **no secret value is reproduced anywhere in this documentation tree.**
> Measured 2026-08-29 by reading source. Nothing here was tested against the live host.
> Severity-classified remediation order: [AUDIT_REPORT.md](AUDIT_REPORT.md).

---

## CRITICAL

### SEC-1 · Live database credentials are committed to the repository

The production MySQL database name, user and password are present as plaintext literals in **six**
tracked locations. Five are `getenv('…') ?: '<literal>'` fallbacks, which means the literal is used
whenever the environment variable is absent — i.e. right now, on live.

| File | Line | What |
| :--- | :--- | :--- |
| `AGENTS.md` | `:242-248` | a documentation block listing the credentials outright |
| `DT Brand/src/Database.php` | `:23-27` | `DB_HOST` `DB_PORT` `DB_NAME` `DB_USER` `DB_PASS` fallbacks |
| `DT Brand/config/database.php` | `:16` | same values |
| `DT Brand/database/migrate.php` | `:20-24`, `:162` | twice in one file |
| `DT Brand/api/db_health.php` | `:31-34` | |
| `DT Brand/src/Auth.php` | `:286` | `ADMIN_PASSWORD` fallback — see SEC-2 |

Remediation is **two** actions, and the order matters:

1. **Rotate the database password** in hPanel. Everything committed must be treated as burned —
   the repository is on GitHub, and git history retains the values even after the files change.
2. **Set the environment variables on Hostinger** — `DB_HOST` `DB_PORT` `DB_NAME` `DB_USER`
   `DB_PASS` `ADMIN_EMAIL` `ADMIN_PASSWORD` `ADMIN_NAME` — **confirm they resolve**, and only then
   delete the `?: '<literal>'` halves. Removing the fallbacks first takes the site down.

Purging history (`git filter-repo` / BFG) rewrites every commit hash and requires a force-push;
that is a decision for the repository owner, recorded in [DECISIONS.md](DECISIONS.md), not something
to do inside another task.

### SEC-2 · The admin master credential is a self-healing skeleton key

`src/Auth.php::adminLogin()` reads `$bootstrapEmail` (`:285`) and
`$bootstrapPass = getenv('ADMIN_PASSWORD') ?: '<committed literal>'` (`:286`), then sets
`$isMaster = ($email === $bootstrapEmail && hash_equals($bootstrapPass, $password))` (`:301`).

When `$isMaster` is true:

- the matching `users` row is **re-stamped on every single sign-in** — password hash, `role`
  set to `super_admin`, `status` set to `active` (`:317-334`);
- and if the database is **unreachable**, the admin session is granted anyway (`:363`).

So changing that admin's password in the database does not change it, suspending the account does not
suspend it, and an attacker who has read the public GitHub repository holds a permanent super-admin
key that also works while MySQL is down. `api/health.php` will tell them when that is
(SEC-9). The behaviour is deliberate owner-lockout insurance and should not simply be deleted —
move the value to the `ADMIN_PASSWORD` env var, **change it**, and keep the offline path.
### SEC-3 · A GitHub personal access token is embedded in the git remote URL

`.git/config` stores the `origin` URL in `https://<user>:<token>@github.com/…` form. `.git/config` is
not tracked, so it is not on GitHub — but it is in every backup, every copy of the folder, and it is
readable by anything running as this user. **Revoke that token** in GitHub → Settings → Developer
settings, then re-add the remote over SSH or via a credential helper.

### SEC-4 · The database directory is web-served with no deny rule

`DT Brand/.htaccess` is the only `.htaccess` in the live tree (72 lines) and it contains **no
`<Files>` / `<FilesMatch>` / `Require` deny block at all**. Because the repository's `DT Brand/`
*is* the web root, `database/arniya_master_production.sql` — the full schema plus every seed row — is
a plain static file under the document root and is fetchable directly by URL. `Options -Indexes`
(`:6`) hides the listing; it does not protect a known filename, and the filename is in this repo.

`src/*.php` and `config/*.php` are less exposed only because `mod_php` executes them and they emit no
output — a single misconfiguration of the PHP handler turns that into full source disclosure,
including SEC-1's literals.

Add to `DT Brand/.htaccess`:

```apache
<FilesMatch "\.(sql|sql\.gz|md|json|lock|yml|yaml|ini|log|bak|old)$">
    Require all denied
</FilesMatch>
RedirectMatch 404 ^/(database|config|src|shared|includes)/
```

Verify `/api/health.php` and the storefront still load afterwards — the `RedirectMatch` covers
`includes/`, which is *included* server-side (fine) but must not be requested directly.

## HIGH

### SEC-5 · The order total can be manipulated from the request

`OrderManager::createOrder()` re-derives the unit price, the channel, the coupon discount and the
customer — and then takes **`shipping`, `gst_rate`, `payment_status` and `fulfillment_status` straight
from the request** (`src/OrderManager.php:296`, `:297`, `:310`, `:311`).
`PricingCalculator::calculateOrderTotal()` applies `max(0, …)` to `taxable` only; `$grandTotal =
round($taxable + $gst + $shipping, 2)` (`PricingCalculator.php:40`) has no floor and `$gstRate` has
no upper bound.

The create path is deliberately reachable without an admin session so that customers can check out
(`api/orders.php:202-224`). So an unauthenticated POST with `gst_rate: 0` removes the tax from any
order and `shipping: -50000` drives `grand_total` negative. A *negative* `gst_rate` does **not** get
through — `calculateGst()` throws `InvalidArgumentException` on `$gstRate < 0` (`:27-29`), which
escapes to `api/orders.php:227` as a 500 and writes no row; `$shipping` has no such check.
`payment_status` and `fulfillment_status` are written as posted with **no ENUM whitelist**, and
`payment_status` **defaults to `'paid'`** — with no payment gateway in the project at all
([INTEGRATIONS.md](INTEGRATIONS.md) §5), a stranger can insert a paid, confirmed order for zero or
less.

This is the same class of hole that the price and channel hardening was written to close, in the same
function, three lines further down. Fix: whitelist `gst_rate` (`0, 5, 12, 18`) or force `5.0` for
non-admin callers; derive `shipping` server-side from `config/shipping.php`'s
`free_shipping_threshold` / `standard_rate`; add `max(0, …)` to `grand_total`; whitelist both status
ENUMs and force `payment_status = 'pending'` without an admin session. Detail in [API.md](API.md) §5.1.

### SEC-6 · There is no server-side session on the storefront — at all

**Zero** occurrences of `$_SESSION` across all 11 storefront pages. Identity, cart, wishlist, wallet
and the entire B2B gate live in `localStorage` (`dtbrands_user` at 64 sites, and its `type` field
selects the price tier rendered). Full detail and the exact consequences in
[FRONTEND.md](FRONTEND.md) §3.

State the impact precisely, because it is narrower than it looks: anyone can set
`dtbrands_user.type = 'wholesale'` in DevTools and **see** mill rates; they **cannot buy** at them,
because `OrderManager::resolveChannel()` re-reads the tier from `customers` server-side
([BACKEND.md](BACKEND.md) §4). This is price-list disclosure plus a cosmetic authorisation bypass,
not a payment bypass.

Fixing it means adding `Auth::initSession()` and a server-side tier read to `wholesale.php`,
`reseller.php`, `retailer.php` and `account.php`. That is a scoped project with its own testing pass,
not a side effect of another task.

### SEC-7 · Unauthenticated endpoints publish the trade price list

`api/cart.php` takes `user_type` from the request body (`:31`) and prices from it (`:46-50`);
`api/wholesale.php` `action=calculate_lot` returns `unit_wholesale_price` (`:55`, `:80`);
`api/reseller.php` `action=calculate` returns `reseller_price` plus the margin (`:34-44`). None checks
a session. A competitor can enumerate the mill rate for every SKU with unauthenticated GETs.
[API.md](API.md) §4. Fix by requiring an active session **and** re-reading the tier from `customers`,
exactly as the order path already does.
### SEC-8 · No CSRF protection on any endpoint

`Auth::generateCsrfToken()` (`src/Auth.php:618`) and `Auth::validateCsrfToken()` (`:630`) exist and
have **zero callers**. No form and no `fetch()` in the project sends a token. Every admin write —
create product, change customer status, update order, adjust stock — is a plain cookie-authenticated
POST.

The one thing standing in the way is that 16 of 21 endpoints send `Access-Control-Allow-Origin: *`,
and `*` forbids *credentialed* cross-origin XHR. That is **not** a CSRF defence: a plain HTML
`<form action="https://jaihanumantex.in/api/products.php" method="post">` on any page an admin visits
is not subject to CORS at all. Wiring the two existing methods into the admin forms and the `fetch()`
helpers is the fix.

### SEC-9 · `api/health.php` announces when the offline admin path is open

Unauthenticated, and reports `database_pdo: CONNECTED | MOCK_FALLBACK_ACTIVE` plus `total_skus`
(`:27-30`). `MOCK_FALLBACK_ACTIVE` is precisely the condition under which `src/Auth.php:363` grants an
admin session without touching the database (SEC-2). Put the endpoint behind
`dt_api_require_admin()`, or reduce it to a bare `200 OK` with no body.

## MEDIUM

### SEC-10 · The admin console guard fails open

`admin/Includes/adminguard.php:70-74` wraps its whole body in `catch (\Throwable) { return; }` with
the comment *"Never take the admin console down on a guard failure."* Any throw inside the guard —
including a session-handler failure — serves the requested admin page **unauthenticated**. The API
guard does the opposite and fails closed (`api/_guard.php:44-60`).

Both are intentional and they should stay asymmetric, but the console side needs a floor: on a throw,
render a static "sign in again" page rather than the requested one. Full mechanics in
[ADMIN.md](ADMIN.md) §3.

### SEC-11 · The guard's exemption is a substring match

`if (strpos($haystack, 'login') !== false || strpos($haystack, 'logout') !== false) return;`
(`adminguard.php:47-50`). Any future admin page whose URL contains those letters —
`/admin/users/logins.php`, `/admin/reports/logout-audit.php` — is **silently unguarded**. No such
page exists today; this is a naming landmine, and it should become an exact-path allowlist.

### SEC-12 · `admin/adminlogin.php` is a second, unlinked authentication endpoint

738 lines, functionally **identical** to `login.php` (the entire 18-line diff is comments), with
**zero inbound references** anywhere in the tree. It is live and reachable by URL, and it will not
receive fixes applied to `login.php`. [ADMIN.md](ADMIN.md) §5. Classify, decide, then collapse —
do not delete blind, since it calls `Auth::adminLogin()` and someone may have bookmarked it.

### SEC-13 · Session cookies are never configured

`Auth::initSession()` (`:14`) calls `session_start()` with no preceding
`session_set_cookie_params()`. There is no `HttpOnly`, no `Secure`, no `SameSite` anywhere in the
project. Add them in `initSession()` so the admin session cookie is unreadable by script, is not sent
over plain HTTP, and is not attached to cross-site requests — which also mitigates SEC-8.

Credit where due: `session_regenerate_id(true)` **does** fire on every successful sign-in
(`:145`, `:182`, `:239`, `:370`, `:391`), so session fixation is already handled.
### SEC-14 · Exception messages are returned to the client

`api/orders.php:227-229`, `api/cart.php:118`, `api/search.php:87` and `api/upload.php` all return
`$e->getMessage()` verbatim in the JSON body. A PDO exception message carries the SQL, the table and
column names and sometimes the connection target. `src/Auth.php` was already corrected to
`error_log()` instead (`:157`, `:258`, `:604`) — copy that pattern into these four files and return a
fixed string.

### SEC-15 · `Auth::canAccessOrder()` fails open, and is currently dead

`src/Auth.php:642` has **zero callers**, and `return true` when the database is unreachable (`:662`).
Harmless today, an authorisation bypass the moment somebody wires it up. Fix the fail-open **now**,
while nothing depends on it.

### SEC-16 · Three endpoints create their own tables at runtime

`api/db_audit.php` creates 16 tables, `api/attributes.php:42` creates `product_attributes`,
`api/brands.php:40` creates `product_brands`, `api/whatsapp.php:55` creates `whatsapp_logs`. The
audit endpoint is admin-guarded, so this is a schema-integrity problem more than an access-control
one — but it means the live schema is whatever sequence of requests happened to run.
[DATABASE.md](DATABASE.md) §5.

### SEC-17 · Response headers are thin, and one of them is obsolete

`.htaccess:67-71` sets only `X-Content-Type-Options: nosniff` and `X-XSS-Protection: 1; mode=block`.
The latter is deprecated, ignored by every current browser, and was itself a vulnerability vector in
old ones. Missing: `Content-Security-Policy`, `X-Frame-Options` (the admin console is clickjackable),
`Referrer-Policy`, `Strict-Transport-Security`, and **any HTTPS redirect in the rewrite block** —
Hostinger may force TLS at the panel level, which this documentation cannot verify.

## LOW / informational

- `api/wishlist.php` operates on `$_SESSION` only and never writes the `wishlist_items` table
  (`:25-38`), so a signed-in customer's wishlist dies with the session. A data-loss bug, not an
  access-control one. [KNOWN_ISSUES.md](KNOWN_ISSUES.md) KI-5.
- The `db_health.php` install key is still printed in `MASTER_ARCHITECTURE_AUDIT.md` and under
  `docs/` even though the code no longer accepts it. Remove the published value regardless.
- `Auth::requestPasswordReset()` (`:572`) writes `reset_token` / `reset_expires` and **nothing
  delivers the mail**, so the reset flow cannot complete. Tokens accumulate unused.
- `Options -Indexes` is set (`.htaccess:6`) — directory browsing is off. Good.

## What is already right — do not "harden" these

Each of these was built or repaired deliberately. Changing them is a regression.

| Path | Property |
| :--- | :--- |
| `src/OrderManager::createOrder()` | re-derives channel, unit price, subtotal and coupon server-side. Never let `unit_price`, `total_amount` or `channel` come from the request. [API.md](API.md) §5, [DECISIONS.md](DECISIONS.md) D-4 |
| `api/orders.php:118-121` | public order tracking returns an **identical 404** for "no such order" and "wrong phone", and requires order number **and** phone together — not enumerable |
| `api/orders.php:131` | `dt_api_require_admin('read order records')` gates every bulk order read |
| `api/upload.php` | `finfo` MIME allowlist; **the extension is derived from the verified MIME, never the client filename**; 10 MB / 25 MB caps; writes a defensive `.htaccess` (`php_flag engine off` + a deny `FilesMatch`) into the upload directory on every run. Use it as the template for any new upload path |
| `api/_guard.php:44-60` | fails **closed** |
| `Auth::login()` `:192` | requires `status='active'`, bcrypt only, **no bypass**, fails closed at `:266` |
| `Auth::` sign-in paths | `session_regenerate_id(true)` on every success |
| `CustomerManager` | ENUM whitelists before every write, and `rowCount() === 0` disambiguated — MySQL outside strict mode coerces an unknown ENUM to `''` while reporting success |
| `CustomerManager::create()` | an absent password becomes `bin2hex(random_bytes(18))`, never a shared literal |
| `ProductCatalog::mediaPath()` | rejects `data:` URLs; `PUBLIC_STATUSES` keeps drafts off the storefront |
| all of `src/` | prepared statements; the one interpolated list (`sideTables()` `:142`) casts every element with `intval` first |

## Remediation order

1. **SEC-1 + SEC-2 together** — rotate the DB password, set all eight env vars, confirm, then delete
   the literals. Coupled: `ADMIN_PASSWORD` is the last blocker on the DB fallbacks.
2. **SEC-3** — revoke the PAT.
3. **SEC-4** — the `.htaccess` deny block. One file, immediately effective.
4. **SEC-5** — clamp `gst_rate`, derive `shipping` server-side, floor `grand_total`, force
   `payment_status='pending'` without an admin session. Highest-value code fix in `src/`.
5. **SEC-9, SEC-14, SEC-15, SEC-17** — small, local, no behaviour change for legitimate users.
6. **SEC-13 then SEC-8** — cookie flags, then CSRF tokens on admin forms.
7. **SEC-10, SEC-11, SEC-12** — the guard floor, the exact-path allowlist, the duplicate login page.
8. **SEC-7 then SEC-6** — session-gate the pricing endpoints, then the storefront session project.

Deployment is the owner's: this repository is pushed to GitHub and uploaded to Hostinger by FTP.
Nothing in this tree deploys anything. [DEPLOYMENT.md](DEPLOYMENT.md).



