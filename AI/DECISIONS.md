# DECISIONS

> Architectural and operational decisions that are **already made**, with the reasoning, so no future
> task re-litigates them and no agent "improves" one by accident. Numbered `D-n` and referenced from
> other documents — **append, never renumber.** A decision here is not a rule of good software
> engineering in general; it is what this repository has settled on, and why.
>
> Where a decision was made by the **owner**, it says so. An agent may not reverse one of those.

---

## D-1 · `DT Brand/` is the only live tree. The other two generations stay on disk.

**Context.** The repository holds three generations of the same product: GEN-C `DT Brand/` (452 PHP,
FTP-deployed, so its *contents* are `/public_html/`); GEN-B `Frontend/` plus root `admin/ api/ src/
Shared/ …` (376 PHP, frozen 2026-08-25); GEN-A `app/ bootstrap/ public/ tests/ docs/` with
composer/phpunit/phpstan/playwright (a one-shot scaffold from 2026-08-24 that was never wired in).

**Decision.** Only `DT Brand/` is edited. GEN-A and GEN-B are **not** deleted — they are not
deployed, they cost nothing at runtime, and deleting 376+ files to tidy a repository is a large,
irreversible change with no user-visible benefit.

**Consequences.** A bare path is ambiguous — `src/Database.php` exists twice — so every path written
anywhere in this tree is prefixed `DT Brand/`. A grep that is not scoped returns two hits for
everything, and *the wrong one* is often the prettier file. GEN-A's tooling
(`phpunit.xml`, `playwright.config.js`, `.github/workflows/*`) describes a structure that does not
exist; it is not the project's test strategy. [PROJECT_MAP.md](PROJECT_MAP.md),
[FILE_OWNERSHIP.md](FILE_OWNERSHIP.md) §0.

**Revisit when** the owner asks for a repository cleanup as its own task, with a backup taken first.

## D-2 · No framework, no DI, no ORM, no autoloader, no build step

**Context.** PHP 8.2 on Hostinger shared hosting, deployed by FTP. The `src/` layer is 7 classes /
4,007 lines of `namespace DTBrand;` static methods. 96 files write
`require_once __DIR__ . '/../src/Database.php';` by hand. 1.42 MB of CSS and 105 JS files ship
unminified and unbundled.

**Decision.** Keep it. Do **not** introduce a container, a repository layer, an ORM, a front
controller, a composer autoloader or a build step *inside another task*.

**Why, specifically:**

- **The deployment model is file copy.** An autoloader that depends on `vendor/` adds a directory the
  owner must remember to upload; a build step adds an artifact that does not exist until someone runs
  it. Both convert "upload the file you changed" into a release process. [DEPLOYMENT.md](DEPLOYMENT.md).
- **Opcache already pays for the `require_once` sprawl.** The cost is a stat plus a cached parse. It
  is not the bottleneck; 351 KB of unminified `reseller.js` is. [PERFORMANCE.md](PERFORMANCE.md).
- **The blast radius is the whole site.** Every one of the 452 PHP files is an entry point.

**Consequences.** Add a class the same way the others are added: static, `namespace DTBrand;`, and
every consumer requires it explicitly in dependency order. Accept the duplication that follows —
`ProductCatalog.php` is the only class that requires a sibling; everywhere else the *page* requires
both.

**Revisit when** the owner commissions a re-platform as its own project.

## D-3 · The two guards are deliberately asymmetric

**Decision.** `api/_guard.php` fails **closed** (`:44-60`): any doubt → 401 and exit.
`admin/Includes/adminguard.php` fails **open** (`:70-74`, `catch (\Throwable) { return; }`) with the
comment *"Never take the admin console down on a guard failure."*

**Why.** They protect different things. A leaked JSON payload is a data breach; a console that
refuses to load during a session-handler hiccup locks the owner out of their own business.

**Consequences.** This is **not** a bug to unify, and a PR that makes the console fail closed will be
reverted. It does need a floor: on a throw the console should render a static "sign in again" page
rather than the requested page. That, plus replacing the substring exemption
(`strpos($haystack, 'login')`) with an exact-path allowlist, is the authorised fix —
[SECURITY.md](SECURITY.md) SEC-10, SEC-11.

**Owner decision on rollout:** the guard is applied by **per-page include**, not by a global
`auto_prepend_file` or `.htaccess` rule. Chosen because it is inspectable per file and cannot take the
whole console down at once.

## D-4 · Order creation is public, and the server re-derives every value that touches money

**Context.** There is no payment gateway in the project at all
([INTEGRATIONS.md](INTEGRATIONS.md) §5) — orders settle offline. Customers must be able to check out,
so `api/orders.php` create (`:202-224`) is intentionally reachable **without** an admin session.

**Decision.** The create path stays public, and `OrderManager::createOrder()` treats the request as
hostile. It re-derives:

| Value | How |
| :--- | :--- |
| channel/tier | `resolveChannel()` `:66-112` — re-read from `customers.type` with `status='active'` required; unverifiable → `retail` |
| unit price | `resolveItemPrices()` `:136` — re-read from `products.{retail\|wholesale\|reseller}_price` via the fixed whitelist in `priceColumnFor()` `:118-127`, never interpolated |
| subtotal | accumulated server-side `:247`, then `PricingCalculator::calculateOrderTotal()` `:299` |
| coupon | `resolveCouponDiscount()` `:19` — re-reads the row, enforces `min_order_value`, caps at `max_discount`, clamps to subtotal `:54` |
| customer | a posted `customer_id` is overwritten from the session for a signed-in non-admin caller `:315-317` |

**The rule that follows: `unit_price`, `total_amount` and `channel` must never come from the
request.** Any change that reintroduces one of them re-opens a priced-at-your-own-rate hole.

**Consequences.** This is why the client-side tier in `localStorage` is only *cosmetic* — anyone can
set `dtbrands_user.type = 'wholesale'` and **see** mill rates, but not buy at them
([SECURITY.md](SECURITY.md) SEC-6). It is also why the hardening must be extended rather than
trusted: `shipping`, `gst_rate`, `payment_status` and `fulfillment_status` are still taken raw
(`:296`, `:297`, `:310`, `:311`) — SEC-5, the highest-value outstanding code fix in `src/`.

## D-5 · Honest failure over plausible fill

**Decision.** When data cannot be read, show **nothing** and say so. Never synthesise a display value.

**Why this is a decision and not a preference.** It was learned from live damage:
`CustomerManager.php:11-15` records that a hardcoded customer roster put invented names and
**real-format phone numbers** in front of an admin who could click "WhatsApp Connect" and message a
stranger. `OrderManager::getAll():627` still generates `'DEL-' . rand(10000, 99999)` for an untracked
order — a plausible courier ID, **different on every refresh**, that an admin can read out to a
customer. That is the failure mode this rule exists to prevent.

**Consequences, and the mechanic that makes it hard.** `Database::query()` returns `[]` both for an
empty table and for a dead database, so **every** caller must gate on
`$db !== null && !Database::isMockMode()` before believing an empty result. `src/` mostly does; inline
page queries frequently do not. An empty field an admin can see is worth more than a plausible one.
The remaining inventory is [KNOWN_ISSUES.md](KNOWN_ISSUES.md) KI-3.

## D-6 · The admin master credential stays — it moves and changes, it is not deleted

**Context.** `Auth::adminLogin()` compares the submitted password against
`getenv('ADMIN_PASSWORD') ?: '<committed literal>'` (`src/Auth.php:286`, `:301`). When it matches, the
`users` row is **re-stamped on every sign-in** — hash, `role='super_admin'`, `status='active'`
(`:317-334`) — and if MySQL is unreachable the session is granted anyway (`:363`).

**Decision.** Keep both behaviours. Move the value to the `ADMIN_PASSWORD` environment variable and
**change it**. Do not delete the offline path.

**Why.** This is the owner's lockout insurance for a one-person business on shared hosting: it is what
gets them back into their own console when the database is down or a row was mangled. Deleting it to
close a finding trades a theoretical attacker for a certain, eventual, real lockout.

**Consequences — state them plainly.** As long as the literal is in a public GitHub repository it is a
permanent super-admin skeleton key that survives a password change and an account suspension, and
`api/health.php` publicly announces when the offline path is live (SEC-9). Changing the value is
therefore not optional, and `ADMIN_PASSWORD` is the **last blocker** on D-7.

## D-7 · Credentials: rotate → set env → confirm → *then* delete the literals. **Owner decision.**

**Context.** The live MySQL name, user and password are plaintext in **six** tracked locations, five of
them as `getenv('…') ?: '<literal>'` fallbacks — so the literal is what is in use right now, on live.
Named by file and line in [SECURITY.md](SECURITY.md) SEC-1; **no value is reproduced anywhere in this
tree, and none may be.**

**Decision (the owner chose "set env first, then remove"), in order:**

1. **Rotate the database password** in hPanel. Everything committed is burned — git history retains it
   even after the files change.
2. **Set all eight variables on Hostinger** — `DB_HOST` `DB_PORT` `DB_NAME` `DB_USER` `DB_PASS`
   `ADMIN_EMAIL` `ADMIN_PASSWORD` `ADMIN_NAME`.
3. **Confirm they resolve on live** with a length-only probe — never printing a value. There is **no
   `.env` loader in the project**, so creating a `.env` file achieves nothing; only real process
   environment variables reach `getenv()`.
4. **Only then** delete the `?: '<literal>'` halves. Removing them first takes the site down.

**Consequences.** Steps 1-3 are the owner's; an agent cannot perform them and must not delete a
fallback on the assumption that they are done. Purging git history (`git filter-repo` / BFG) rewrites
every commit hash and needs a force-push — **that is the repository owner's call**, taken as its own
task, never inside another one. `config/database.php` is read by nobody and leaks credentials for no
purpose: the cleanest single deletion in the repo, and it belongs to this decision, not to a cleanup
sweep.

## D-8 · Deployment is the owner's. Agents edit local tracked source and report.

**Decision.** An agent changes files under the git root and stops. The owner pushes to GitHub and
uploads by FTP to Hostinger. **Nothing in this repository deploys anything** — there is no CI that
touches live, and GEN-A's `.github/workflows/*` describes a structure that was never adopted (D-1).

**Consequences.** Every task report must end with **which files to upload**, and a schema change must
name the migration the owner has to run. A fix that is correct locally and not uploaded is a fix the
owner does not have. It also means `php -l` and `node --check` are the only verification available in
this environment — there is no MySQL here, so nothing DB-dependent is runtime-verifiable
([KNOWN_ISSUES.md](KNOWN_ISSUES.md) KI-22). Say what was checked and what was not.

## D-9 · Classify, never delete blind

**Decision.** No file is deleted on the strength of a grep. Each candidate is classified —
**EXACT DUPLICATE · FUNCTIONAL DUPLICATE · LEGACY · INTENTIONALLY DIFFERENT · UNUSED · UNKNOWN** — with
the evidence written down, and anything landing in UNKNOWN stays on disk and goes to
[KNOWN_ISSUES.md](KNOWN_ISSUES.md).

**Why, with the receipts.** Three separate wrong conclusions were reached by grep during this audit:

- a basename grep credited `assets/css/wholesale.css` with 29 referrers because
  `/admin/wholesale/assets/css/wholesale.css` contains it as a substring — the true count is 1;
- `assets/css/main.css` and `assets/css/header.css` were listed as dead when three admin pages link
  them, and `shared/quickview.php` was listed as dead when six storefront pages require it;
- both apparent referrers of `assets/js/modals.js` turned out to be **comments**.

And in `includes/`, **the misspelled files are the live ones** (`shophader.php`,
`shopbottomfotoer.php`); `shopheader.php` / `shopfooter.php` are the dead ones. A "fix the typo" commit
breaks two pages. Verify by full path, exclude comments, then decide.
[FILE_OWNERSHIP.md](FILE_OWNERSHIP.md) §10.

## D-10 · One documentation tree, in `AI/`, merged with what already exists

**Decision.** `AI/` at the git root is the agent-facing memory and the single index. It **merges with**
and cross-references `AGENTS.md`, `.agents/rules/`, `docs/` and the seven module `README.md` files — it
does not restate them, and it does not replace them.

**Consequences.** Facts are recorded with file, line and a measured number, and every measurement
carries its date. `MASTER_ARCHITECTURE_AUDIT.md` is known inaccurate (it claims 21 tables; the live
schema has 18) and is superseded, not deleted. When a module `README.md` covers something, update that
README rather than growing a parallel description here. Finding numbers (`SEC-n`, `KI-n`, `D-n`,
`M-n`) are cross-referenced across files: **append, never renumber.**

## D-11 · One authority per commercial rule, named

**Decision.** Each commercial rule has exactly one server-side owner, and browser copies are treated as
**mirrors that must follow**, never as sources:

| Rule | Authority | Known mirrors |
| :--- | :--- | :--- |
| freight | `config/shipping.php` — read by `api/cart.php:94` and `admin/products/components/product-shipping.php:25` | `shared/quickview.php:555` `QV_FREE_SHIP_OVER = 1999` (live), `assets/js/modals.js:756` (dead) |
| GST | `PricingCalculator::calculateGst()`, default 5 % | four literal `5.0`s |
| tier price | `products.{retail\|wholesale\|reseller}_price` via `priceColumnFor()` | every B2B page renders from `localStorage` |
| lot minimum | `products.moq_{single,half_set,full_set,master_bale}` (1/4/8/24) | `reseller.js:5133` invents `p.moq \|\| 8` |
| coupon | `coupons` row + `OrderManager::resolveCouponDiscount()` | `DiscountEngine`'s 3-entry offline dictionary |

**`api/cart.php:94-100` is the reference implementation** — read the config, floor it at 0, apply the
threshold, pass a fixed rate to `PricingCalculator`. Copy that shape. Its `:89-93` comment records the
bug it replaced: the charge was waived above 999 while the flag reported above 2999, and
`config/shipping.php` was read by nobody.

**Consequences.** Changing a rule means changing the authority **and** every mirror in the same commit,
and *not* changing the coincidental look-alikes: `1999` is also a coupon `min_order_value` twice, a demo
price twice and a `z-index` three times. [BUSINESS_LOGIC.md](BUSINESS_LOGIC.md) §3.

## D-12 · The storefront and admin token systems stay separate for now

**Decision.** Four token namespaces coexist (`--adm-*`, `--ws-*`, and two unprefixed storefront sets in
`home.css` and `main.css`) across 13 `:root` blocks. They are **not** being unified as part of any other
task.

**Why.** `#8A681F` is the only value all four agree on. A merge touches ~190 admin pages and 11
storefront pages, and the pages have no shared layout to regression-test them through. It is a project
with its own testing pass. **Preserve the ARNIYA brand identity** — `Cinzel` for display, the gold, the
dark obsidian — in whatever is done. [UI_SYSTEM.md](UI_SYSTEM.md) §1-2.

## D-13 · Priority order when two goals conflict

Settled, and applied in this order:

1. **Existing working business logic** — do not break what earns money.
2. The **owner's explicit request**, at its stated scope. No silent widening, no silent narrowing.
3. **Security.**
4. **Data integrity.**
5. **Existing architecture** (D-2).
6. **UI/UX consistency** (D-12).
7. Performance · 8. Maintainability · 9. Cleanup · 10. New improvements.

Two rules ride on top. **Root cause first:** if a new error appears after a fix, do not stack another
patch — return to the first failure and trace from the beginning. **Database safety:** no `DROP`, no
`TRUNCATE`, no unconditioned `DELETE`, no schema change without explicit authorisation and an impact
analysis. [MASTER.md](MASTER.md), [ERROR_RECOVERY.md](ERROR_RECOVERY.md).

