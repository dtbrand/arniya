# TESTING

> **Effective automated test coverage of the live tree is zero.** Measured 2026-08-29.
> A complete-looking test and CI apparatus exists — 7 PHPUnit files, 3 Playwright specs, 5 GitHub
> workflows — and **all of it targets the frozen GEN-B generation, not `DT Brand/`.**
> This document records what exists, why it does not apply, and what *can* actually be verified today.

---

## 1. What exists

| Path | Contents |
| :--- | :--- |
| `tests/Unit/` | 6 files, **25 test methods** — `AppArchitectureTest` 7, `AuthTest` 5, `ProductCatalogTest` 5, `DiscountTest` 4, `PricingTest` 3, `OrderManagerTest` 1 |
| `tests/Integration/OrderFlowTest.php` | 1 test method |
| `tests/bootstrap.php` | **5 lines** — requires `PricingCalculator.php` and `DiscountEngine.php` only |
| `tests/e2e/` | `core-flows.spec.js` 7 tests · `ui-regression.spec.js` 3 · `accessibility.spec.js` 2 |
| `phpunit.xml`, `playwright.config.js`, `lighthouserc.js`, `eslint.config.js`, `phpstan.neon` | GEN-A scaffold, 2026-08-24 |
| `.github/workflows/` | `ci.yml` (4 jobs), `codeql.yml`, `trivy.yml`, `scorecard.yml`, `release-please.yml` |
| `scripts/smoke-test.php`, `scripts/restore-test.php` | GEN-A scaffold |
| `vendor/`, `node_modules/` | present locally |

It is a professional-looking pipeline. It measures the wrong code.

## 2. Why none of it applies to the live site

**`phpunit.xml` covers the wrong `src/`.** Its `<source><include>` is `src`, `Shared`, `Frontend`
(`:21-23`) — the **root** directories, which are GEN-B frozen. `tests/bootstrap.php:4-5` requires
`__DIR__ . '/../src/…'`, which resolves to root `src/`, not `DT Brand/src/`. Those are not the same
files:

| Class | root `src/` vs `DT Brand/src/` |
| :--- | :--- |
| `PricingCalculator.php` | **103 changed lines** |
| `DiscountEngine.php` | **122 changed lines** |

**`ci.yml` never mentions `DT Brand/` at all.**

- `:34` — `find Frontend Shared src -name "*.php" -print0 \| xargs -0 -n1 php -l`. The 452 live PHP
  files are **never linted**.
- `:37` — runs the suite above.
- `:103` — `zip -r dtbrand-release.zip Frontend Shared src database docs .htaccess index.php admin.php adminlogin.php health.php`
  and uploads it as **`dtbrand-production-bundle`**. That archive is the frozen GEN-B generation plus
  the GEN-A root `.htaccess`. **Deploying it would overwrite the live site with dead code.** Nobody
  has; the deployment path is manual FTP ([DEPLOYMENT.md](DEPLOYMENT.md)). Treat the artifact name as
  actively dangerous.

**`package.json` lints the wrong tree too.** `lint:js` is `eslint "Frontend/**/*.js" "Shared/**/*.js"`
(`:8`) and `lint:css` is the same for CSS (`:9`). So `DT Brand/assets/js/reseller.js` — 351 KB with **11
names declared more than once**, two of which return different VIP tier thresholds (KI-21) — has never
been linted, and neither has any live stylesheet. `no-redeclare` or `no-dupe-class-members` pointed at the
live tree would have caught it; `node --check` cannot, because the duplicates are legal.

**Every Playwright URL is a GEN-B path that 404s on live.** All 12 `page.goto()` calls target
`/Frontend/Home/home.php`, `/Frontend/Shop/shop.php`, `/Frontend/Admin/adminlogin.php`,
`/Frontend/Wholesale/wholesale.php`, `/Frontend/Reseller/reseller.php`,
`/Frontend/Single-Product/singleproduct.php`, `/Frontend/Admin/retail/index.php`. The live web root is
`DT Brand/`, so `/Frontend/…` does not exist. Seven of those tests assert `status() === 200`, so the
suite fails 100 % — and `playwright.config.js:15` defaults `baseURL` to
**`https://jaihanumantex.in`**, meaning a bare `npx playwright test` points at production.

One mitigating fact, verified: the specs are **read-only**. There is not a single `.click()` or
`.fill()` in `tests/e2e/`, only `goto` and visibility assertions. Running them against production is
wasteful and always red, but it cannot corrupt data.
## 3. Two traps inside the existing tests

**`tests/bootstrap.php` loads 2 of the 7 classes.** `AuthTest`, `OrderManagerTest`,
`ProductCatalogTest` and `OrderFlowTest` contain **no `require` of their own**, and there is no
autoloader ([BACKEND.md](BACKEND.md) §1). Those four files reference classes that were never loaded,
so they error with "class not found" rather than failing an assertion. A red suite here is not
necessarily a code defect.

**`tests/Unit/OrderManagerTest.php` asserts the exact behaviour the live code was hardened against.**
It passes `items[].price` and a top-level `discount` in the request array and expects both to be
honoured (`:17-18`, `:20`, `:30-31`):

```php
'items'    => [['price' => 3850.00, 'quantity' => 8], ['price' => 3350.00, 'quantity' => 4]],
'discount' => 2000.00,
…
$this->assertEquals(44200.00, $order['pricing']['subtotal']);
$this->assertEquals(2000.00,  $order['pricing']['discount']);
```

The **live** `OrderManager::createOrder()` deliberately ignores both: `resolveItemPrices()` re-reads
`products.{tier}_price` from the database, and a client-supplied `discount` is honoured only for an
admin session ([API.md](API.md) §5, [DECISIONS.md](DECISIONS.md) D-4). So if anyone repoints this test
at the live class it will fail, and the obvious "fix" is to re-open the priced-at-your-own-rate hole.

**Do not repoint that test. Rewrite it** to assert the opposite: that a request-supplied `price` and
`discount` are *discarded* for a non-admin caller. That is the single most valuable test this project
could have.

The same file also uses the retired phone number `+91 98765 43210` (`:14`) — inside the frozen tree,
so out of scope for the global renumber to `917046363528`, but do not copy it into a new test.

## 4. What can actually be verified today

**No MySQL is available locally**, so nothing database-dependent is runtime-verifiable in this
environment. Everything below is static. PHP 8.2.12 CLI lives at `/c/xampp/php/php.exe` and is **not
on `PATH`**.

Full-tree PHP lint — the one verification that covers the live code, run from the repository root:

```bash
find . -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -P 8 -n 1 /c/xampp/php/php.exe -l 2>&1 | grep -v "No syntax errors"
```

Silence is a pass. Live tree only:

```bash
find "DT Brand" -name '*.php' -print0 | xargs -0 -P 8 -n 1 /c/xampp/php/php.exe -l 2>&1 | grep -v "No syntax errors"
```

Single JS file — note the flag, because root `package.json` declares `"type": "module"` while every
file in `DT Brand/assets/js/` is a classic script:

```bash
node --check --input-type=commonjs < "DT Brand/assets/js/reseller.js"
```

Constraints on any script written for this environment: the Windows console is **cp1252**, so emit
**ASCII only** — a `₹` or a box-drawing character will crash the pipe. And `TodoWrite` is unavailable
in this session.

## 5. The gap, stated plainly

Everything that matters is verified by hand, on the live host, after the owner uploads. There is no
automated check on:

- the money path — `resolveChannel()`, `resolveItemPrices()`, `resolveCouponDiscount()`,
  `PricingCalculator::calculateOrderTotal()`;
- schema drift — `ordersHasColumn()` / `tableHasColumn()` exist precisely because the live schema is
  uncertain ([DATABASE.md](DATABASE.md));
- the admin guard census — 358 of 362 files, currently verified only by grep;
- mock-mode behaviour — the single most common source of "it shows zero" bug reports;
- any of the 452 live PHP files' syntax, in CI.

## 6. If a test suite is built, build it in this order

Highest value per unit of effort, and each step is independently useful:

1. **Repoint `ci.yml:34` to lint `DT Brand/`.** One line. Immediately covers 452 files.
2. **Repoint `package.json` `lint:js` / `lint:css` at `DT Brand/assets/`.** Will surface the 11
   duplicate declarations in `reseller.js` on the first run.
3. **Delete or rename the `package-artifact` job** (`ci.yml:90-110`). An artifact called
   `dtbrand-production-bundle` that contains the wrong generation is a footgun waiting for a hurry.
4. **A new `tests/live/` suite with its own bootstrap** requiring `DT Brand/src/*.php` in dependency
   order. Start with `PricingCalculator` (pure functions, no database — 3 real tests immediately) and
   `DiscountEngine`'s in-memory fallback dictionary.
5. **The trust-boundary test** described in §3: assert that request-supplied `price`, `discount` and
   `channel` are all discarded for a non-admin caller. This protects the highest-risk code in the
   project.
6. **Mock-mode tests**: with no reachable database, assert `CustomerManager::getAll()` returns `[]`,
   `create()` returns `success:false`, and `ProductCatalog::getAll()` returns `[]` — i.e. that nothing
   fabricates. `OrderManager::getAll()` will **fail** this, correctly ([BACKEND.md](BACKEND.md) §4).
7. **Playwright, repointed** at real live URLs — `/`, `/shop`, `/product/1`, `/admin/login/`,
   `/wholesale`, `/reseller`, `/retailer`, `/cart`, `/checkout`, `/account`, `/about-us` — kept
   read-only, and pointed at a staging host rather than `jaihanumantex.in` before any interaction is
   added.

Steps 1–3 are three lines of configuration and should not wait for steps 4–7.

## 7. Manual verification backlog

A large list of live checks accumulated over previous phases — one order through the admin drawer and
one through `/checkout`, product create with photos + MP4 + a pasted YouTube link + variants, the
`?id=9999` 404 paths, review moderation, the three B2B pages empty and populated, every WhatsApp entry
point resolving to `917046363528`, and the dashboard widgets agreeing with the database — is tracked
in [TASK_STATE.md](TASK_STATE.md), not here. It stays blocked until the owner deploys.

