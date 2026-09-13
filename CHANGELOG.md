# Changelog — DT Brand's & Jai Hanuman Tex

All notable changes are documented here. The repo uses
[Release Please](https://github.com/googleapis/release-please) (`.github/workflows/release-please.yml`,
`release-please-config.json`, `.release-please-manifest.json`) with
[Conventional Commits](https://www.conventionalcommits.org/) enforced by
`commitlint.config.js` — commit messages feed this changelog and the releases.

Project started 2026-08-14; **1,229 commits** as of 2026-09-13.

## [Unreleased]

### Added
- Root documentation suite: `ARCHITECTURE.md`, `API.md`, `DATABASE.md`,
  `DEPLOYMENT.md`, `TESTING.md`, `CODE_OF_CONDUCT.md` and this changelog,
  all verified against the working tree (2026-09-13 audit).
- `docs/audits/2026-09-13-master-audit.md` — evidence-based master audit.

### Fixed
- (pending) Known issues logged in the 2026-09-13 master audit:
  `DTBrand\RateLimiter` namespace fatal on the auth API router;
  `api/developer.php` static calls to instance `AuditManager::log()`;
  undefined `$data` in the Cashfree webhook handler; stale README claims.

## [2.0.0] — 2026-09-07

First recorded release in `.release-please-manifest.json` (installer version `2.0.0`,
`.installed` marker). Highlights up to this release, from the commit ledger:

### Added
- **Admin suite sections 25–40:** customer role hubs, inventory ledger + export
  studio, coupons & discount rules, shipping admin, payment admin with webhook
  replay protection, content/marketing admin, reviews admin, notifications with
  DLQ retry, integrations with secret masking + diagnostics, reports & export
  studio, admin users/roles/permissions, enterprise audit log (15 domains,
  secret masking, JSON diffs), system admin (12 sub-pages), developer &
  webhook-queue suite, admin UI component library (24 canonical components),
  database integrity + price history audit ledger.
- **Security sections 34 & 49–61:** admin security matrix, auth hardening,
  rate limiting, credential defense, installer lockdown, CSRF protection,
  IDOR resolution, API security/headers/uploads suite, unauthenticated order
  details now 401 before any DB query.
- **Cart/checkout hardening:** coupon validation wired live in the cart drawer;
  cart, wishlist, checkout, payment idempotency and stock safety suites.
- **B2B portals:** WhatsApp inquiry deep links in wholesale/reseller/retailer,
  unified `dtAdminFetch` with CSRF safety, create-order action + export studio
  link, `Money` engine across admin.
- **Deployment:** dual-target FTP triple-sync (HarmitEthnic + JaiHanumanTex)
  with binary TYPE I; customer portal files registered in the sync list;
  `Database` unified with `config/database.php` fallback.

### Changed
- Replaced raw browser `alert()` dialogs with luxury toast notifications across
  admin modules, checkout, auth and reseller portals.
- Admin sidebar navigation overhaul + full admin files audit with CRUD wire-up.

## Earlier development (2026-08-14 → 2026-09-06)

Foundation phase — initial schema and migrations, storefront pages, four
channel portals, WhatsApp CRM hand-off, payment gateways (Razorpay, Cashfree,
UPI deep links, COD), courier webhooks (Delhivery, BlueDart, TCI), CI/CD
(CodeQL, Trivy, Scorecard, Release Please), Playwright e2e, and the
consolidation of legacy `Frontend/` routes into the single root tree via
canonical 301 redirects. Full history:
`git log --oneline` (1,229 commits).

[Unreleased]: https://github.com/dtbrand/arniya/compare/v2.0.0...HEAD
[2.0.0]: https://github.com/dtbrand/arniya/releases/tag/v2.0.0
