# AGENT BRIEF · SECURITY

> **Scope:** the whole tree, read through one lens. The findings register is
> [SECURITY.md](../SECURITY.md) (`SEC-n`) — this brief is how to work on it without making things worse.
>
> **The first rule of this brief: never reproduce a credential value.** Not in a report, a document, a
> commit message, a code comment or an error string. File, line and variable name only. That is enough for
> the owner to act and useless to anyone else.

---

## 1. What is actually at stake

A one-person business on shared hosting, with **no payment gateway** — so there is no cardholder data, and
the crown jewels are instead: the admin console (which can rewrite prices and orders), the customer table
(names, phone numbers, addresses), and the database credentials.

That shapes the priority order. **Credential exposure outranks everything else**, because it is remotely
exploitable today, needs no bug, and no code change closes it.

## 2. The credential work — order matters, and it is the owner's

Live MySQL name, user and password are plaintext in **six tracked locations**, five as
`getenv('…') ?: '<literal>'` fallbacks — meaning **the literal is what live is using right now**. Named by
file and line in SEC-1; no value appears anywhere in this tree and none may.

The owner's chosen sequence (D-7), and it cannot be reordered:

1. **Rotate the database password** in hPanel. Everything committed is burned — git history retains it even
   after the files change.
2. **Set all eight variables on Hostinger** — `DB_HOST` `DB_PORT` `DB_NAME` `DB_USER` `DB_PASS`
   `ADMIN_EMAIL` `ADMIN_PASSWORD` `ADMIN_NAME`.
3. **Confirm they resolve on live** with a **length-only** probe — never printing a value.
4. **Only then** delete the `?: '<literal>'` halves.

**Deleting a fallback before step 3 takes the site down.** And **there is no `.env` loader in the project** —
creating a `.env` file achieves nothing; only real process environment variables reach `getenv()`.

Two more, same class: a **GitHub token in the `origin` URL** in `.git/config` (revoke, then use SSH or a
credential helper), and the `db_health.php` **install key still published** in
`MASTER_ARCHITECTURE_AUDIT.md` and `docs/`.

**Purging git history** (`filter-repo` / BFG) rewrites every commit hash and needs a force-push. **The
owner's decision, taken as its own task, never inside another one.**

## 3. Two findings that must not be "fixed" the obvious way

**The admin master credential (SEC-2, D-6).** `Auth::adminLogin()` compares against
`getenv('ADMIN_PASSWORD') ?: '<committed literal>'` (`src/Auth.php:286`, `:301`); on a match the `users` row
is **re-stamped on every sign-in** — hash, `role='super_admin'`, `status='active'` (`:317-334`) — and if MySQL
is unreachable the session is granted anyway (`:363`).

State it plainly: while the literal is in a public repository it is a permanent super-admin skeleton key that
survives a password change *and* an account suspension. **But the fix is to move it to `ADMIN_PASSWORD` and
change the value — not to delete the offline path**, which is the owner's lockout insurance for a one-person
business. `ADMIN_PASSWORD` is also the last blocker on D-7 step 4.

**The admin guard fails open (SEC-10, D-3).** `adminguard.php:70-74` catches every `\Throwable` and serves the
page. **A PR that makes the console fail closed will be reverted.** The authorised fix is a static "sign in
again" page on the throw path, plus replacing the substring exemption (`strpos($haystack, 'login')` — which
exempts any URL merely *containing* `login`) with an exact-path allowlist (SEC-11).

## 4. The highest-value code fix: SEC-5

`OrderManager::createOrder()` re-derives channel, unit price, subtotal, coupon and customer (D-4) — but four
values still arrive raw from a **public** endpoint: `shipping` (`:296`), `gst_rate` (`:297`),
`payment_status` (`:310`, defaulting to `'paid'` with **no ENUM whitelist**) and `fulfillment_status`
(`:311`).

Real exploits: `gst_rate: 0`, a **negative `shipping`**, and self-marking an order paid. And because one order
write also decrements stock (`:453`) and increments `total_orders` / `lifetime_spend` (`:456-466`), a forged
order moves inventory and customer lifetime value — with a negative `grand_total` it *decreases* lifetime
spend.

**Correction worth carrying:** `gst_rate: -100` is **not** an exploit. `PricingCalculator::calculateGst()`
throws on a negative rate (`:27-29`) and `api/orders.php:227` returns 500 with no row written. An earlier
version of this documentation claimed otherwise — verify before repeating a finding.

## 5. Standing rules

1. **Public information disclosure counts.** `api/health.php` announces `MOCK_FALLBACK_ACTIVE` (SEC-9) —
   it tells an attacker exactly when the offline admin path is live. `database/arniya_master_production.sql`
   is **web-served with no deny rule** (SEC-4). `api/index.php` lists 15 paths, 14 fictional.
   `api/db_audit.php` **creates 16 tables** when reached.
2. **Prepared statements always; whitelists for identifiers.** Never interpolate a column or table name —
   `priceColumnFor()` (`OrderManager.php:118-127`) is the pattern.
3. **The client-side tier is cosmetic.** Anyone can set `localStorage.dtbrands_user.type = 'wholesale'` and
   **see** mill rates; they cannot buy at them, because the server re-reads `customers.type` (SEC-6). Do not
   "fix" the localStorage; do not start trusting it either.
4. **Session integrity:** admin redirects keep the canonical trailing slash (`/admin/`), or a 301 hop drops
   the session (`4a97896`, `31be293`).
5. **Dead code is still attack surface.** `admin/adminlogin.php` has zero inbound links and is fully
   reachable by URL (SEC-12).
6. **Report, do not exploit.** No live probing beyond what the owner asks for; nothing here can reach live
   anyway.

## 6. Verification

```bash
/c/xampp/php/php.exe -l "DT Brand/src/Auth.php"
```

`php -l` and full-path greps are the whole toolchain. **No MySQL, no live access** — every authorisation and
session behaviour is **unverified until the owner tests on live** (KI-22). Say so, and give them the exact
check to run.

