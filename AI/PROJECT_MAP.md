# PROJECT MAP

> Every count in this file was produced by `git ls-files` on 2026-08-29 and is tracked-file
> based (untracked scratch files are excluded). Ownership legend at the bottom.

---

## 1. Repository root — `C:\Users\sai\Desktop\WhatsApp CRM\`

| Entry | Generation | Notes |
| :--- | :--- | :--- |
| `DT Brand/` | **GEN-C · LIVE** | 452 tracked PHP. This is `/public_html/`. **All work happens here.** |
| `AI/` | tooling | This documentation system. |
| `AGENTS.md` | tooling | 267 lines. Authoritative for process + design system. **Contains committed DB credentials at `:242-248`.** |
| `Frontend/` | GEN-B frozen | 376 PHP. Subdirs `Admin Home Reseller Retailer Shop Single-Product Wholesale`. |
| root `admin/`, `api/`, `src/`, `Shared/` | GEN-B frozen | Superseded by the same-named dirs inside `DT Brand/`. |
| root `index.php`, `admin.php`, `adminlogin.php`, `logout.php`, `health.php` | GEN-B frozen | Root `index.php` requires `Frontend/Home/home.php`. Not what the live site serves. |
| root `app/`, `bootstrap/`, `config/`, `public/`, `database/`, `tests/`, `scripts/`, `storage/` | GEN-A scaffold | One-shot 2026-08-24. Never wired in. |
| `composer.json`, `composer.phar`, `phpunit.xml`, `phpstan.neon`, `playwright.config.js`, `lighthouserc.js`, `eslint.config.js`, `.github/workflows/*` | GEN-A scaffold | Tooling for a structure that was never adopted. |
| `docs/` | docs | 24 files, partly aspirational. |
| `MASTER_ARCHITECTURE_AUDIT.md` | docs | **Known inaccurate** — claims 21 tables. See [MASTER.md](MASTER.md) §5. |
| `GEMINI.md`, `CONTRIBUTING.md`, `SECURITY.md`, `DT_BRAND_MASTER_DESIGN_SYSTEM.md`, `.agents/rules/` | docs | Merge with, do not duplicate. |
| `image.png`, `temp_inspect_users.php`, `scratch/`, `backups/`, `build/` | UNKNOWN | Classify before touching. [KNOWN_ISSUES.md](KNOWN_ISSUES.md) KI-9. |

## 2. `DT Brand/` — the live tree

```
DT Brand/                      452 tracked PHP
├── .htaccess                  the ONLY .htaccess in the live tree (72 lines)
├── index.php  shop.php  product.php  about-us.php          ← public storefront
├── wholesale.php  reseller.php  retailer.php               ← B2B (no server auth)
├── account.php  cart.php  checkout.php  wishlist.php       ← customer (no server auth)
├── admin/      542 tracked files, 362 PHP     ← the console
├── api/         22 PHP                        ← the entire JSON surface
├── src/          7 PHP                        ← all business classes
├── config/       8 PHP                        ← array configs
├── database/     8 files                      ← schema + migration runner
├── includes/    11 PHP                        ← shared page fragments
├── shared/      47 files, 29 PHP              ← modals/partials, mostly unreferenced
└── assets/      38 tracked files              ← css, js, images
```

### 2.1 `admin/` by module (PHP counts)

| Module | PHP | Module | PHP |
| :--- | ---: | :--- | ---: |
| `products/` | 53 | `retail/` | 36 |
| `wholesale/` | 48 | `customers/` | 30 |
| `catalogue/` | 42 | `inventory/` | 5 |
| `orders/` | 42 | `pricing/` | 5 |
| `resellers/` | 42 | `settings/` | 5 |
| `Includes/` | 4 | `cms/` `marketing/` `payments/` `reports/` `shipping/` `system/` `users/` `whatsapp/` | 4 each |
| `notifications/` | 3 | `reviews/` | 3 |
| `media/` | 2 | `dashboard/` `login/` | 1 each |
| `Asset/` | 0 | (css + js only) | |

Admin root files: `admin.php` (20-line shim → `index.php`), `adminlogin.php`, `categories.php`,
`index.php` (**the ~222 KB executive dashboard**), `login.php`, `logout.php`, `orders.php`, `products.php`.

### 2.2 `src/` — 7 files, the whole "service layer"

`Auth.php` · `CustomerManager.php` · `Database.php` · `DiscountEngine.php` ·
`OrderManager.php` · `PricingCalculator.php` · `ProductCatalog.php` — see [BACKEND.md](BACKEND.md).

### 2.3 `api/` — 22 endpoints

`_guard.php` `attributes.php` `auth.php` `brands.php` `cart.php` `categories.php` `coupons.php`
`customer_notes.php` `customers.php` `db_audit.php` `db_health.php` `health.php` `index.php`
`orders.php` `products.php` `reseller.php` `reviews.php` `search.php` `upload.php` `whatsapp.php`
`wholesale.php` `wishlist.php`

`attributes.php` and `brands.php` query tables that **do not exist** in the live schema.
Auth matrix and per-endpoint detail: [API.md](API.md).

### 2.4 `config/` — 8 array configs

`app.php` `auth.php` `database.php` `mail.php` `payment.php` `services.php` `shipping.php` `whatsapp.php`
Several are never `require`d by any live page — see [INTEGRATIONS.md](INTEGRATIONS.md).

### 2.5 `database/` — 8 files, only one executes

| File | Executed? |
| :--- | :--- |
| `arniya_master_production.sql` | **YES** — the only one `migrate.php` runs. 18 tables + seeds. |
| `migrate.php` | the runner |
| `migrations/2026_08_23_000001_create_initial_schema.sql` | no |
| `migrations/2026_08_24_000001_full_production_schema.sql` | no |
| `migrations/2026_08_25_production_upgrade.sql` | **no** — a frequent source of phantom-column bugs |
| `schema.sql` | no — older, incompatible lineage |
| `seeders.sql`, `seeders/DatabaseSeeder.php` | no |

`migrate.php::status()` lists everything in `migrations/` as `PENDING_OR_APPLIED`, which
reads as though those three files run. They do not. [KNOWN_ISSUES.md](KNOWN_ISSUES.md) KI-4.

### 2.6 `includes/` — 11 fragments, 6 of them unreachable

`shophader.php` (1,341 lines) and `shopbottomfotoer.php` (1,354) are the **live** header and footer
— `index.php` and `shop.php` include them. The correctly-spelled `shopheader.php` /
`shopfooter.php` are 6-line alias shims with **zero** consumers, so do not "fix the typo" by
deleting the long files. `singelproduthader.php` (748) serves `product.php`;
`singelprodutbottomfotoer.php` (141) serves four pages; `product-not-found.php` (123) is
`product.php`'s 404 body. Unreferenced: `header.php` (166), `footer.php` (77),
`mobile_bottom_nav.php` (51), `subnav.php` (39, reachable only via `header.php`), and the two
shims. Classify, do not delete. [FILE_OWNERSHIP.md](FILE_OWNERSHIP.md) F-3, [FRONTEND.md](FRONTEND.md) §2.

### 2.7 `assets/` — measured sizes

| CSS | bytes | JS | bytes |
| :--- | ---: | :--- | ---: |
| `reseller.css` | 271,064 | `reseller.js` | 351,469 |
| `home.css` | 207,162 | `retailer.js` | 214,923 |
| `retailer.css` | 201,596 | `wholesale.js` | 204,015 |
| `wholesale.css` | 193,304 | `home.js` | 63,032 |
| `singleproduct.css` | 64,657 | `singleproduct.js` | 51,406 |
| `shop.css` | 61,070 | `modals.js` | 42,584 |
| `header.css` | 13,409 | `shop.js` | 39,323 |
| `main.css` | 10,920 | `profile-save.js` | 8,064 |
| `modals.css` | 10,600 | `header.js` | 7,377 |
| | | `core.js` | 6,503 |

`admin/Asset/css/admin.css` 136,642 · `admin/Asset/js/admin.js` 86,405.
Images: 19 files, **5.54 MB** — of which the 8 `product*.webp` (0.97 MB total) have **zero**
references while their 8 `product*.png` originals (4.14 MB) have 307. **Five assets have no consumer
at all**: `header.css` (13,409), `main.css` (10,920), `modals.css` (10,600), `core.js` (6,503),
`header.js` (7,377) — `header.css` / `header.js` were written for the unreferenced
`includes/header.php`. See [PERFORMANCE.md](PERFORMANCE.md) and [FRONTEND.md](FRONTEND.md) §5.

## 3. Ownership legend

- **LIVE** — deployed, edit freely under the normal rules.
- **FROZEN** — a previous generation. Read for history. Do not edit, do not delete without authorisation.
- **SCAFFOLD** — dropped in, never wired. Do not build on it without a decision recorded in [DECISIONS.md](DECISIONS.md).
- **UNKNOWN** — classify in [FILE_OWNERSHIP.md](FILE_OWNERSHIP.md) before any action.
