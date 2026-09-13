# Master Performance Audit & Optimization Assessment

**Assessment Date:** 2026-09-13 (supersedes 2026-08-23)
**Target:** DT Brand's & Jai Hanuman Tex production application.

---

## 1. What was verified from the tree (2026-09-13)

The previous version of this document listed per-endpoint millisecond timings
against a `Frontend/` tree that no longer exists. Those numbers were not
reproducible and have been removed. What follows is **configuration-level
evidence** verified directly from the repo, plus the tooling to regenerate
live numbers.

### Compression & caching (`.htaccess` — verified)

| Control | State |
| --- | --- |
| Gzip (mod_deflate) for HTML/CSS/JS/JSON/SVG | Configured |
| `ExpiresActive` + long-lived cache for images/fonts, 1-month CSS/JS | Configured |
| No-cache for auth/admin/health paths | Configured |
| Google Fonts preconnect + `font-display: swap` | Present in page heads |

### Server-side efficiency (verified in code)

| Mechanism | Evidence |
| --- | --- |
| Single PDO connection per request | `src/Database.php` singleton + `$attempted` short-circuit (no repeated TCP dials on DB-down) |
| Honest empty-state fallbacks | Catalogue/orders render `[]` without retry storms |
| Sliding-window rate limiting offload | `RateLimiter` uses Redis when the extension is present |
| Admin asset pipeline | Bundled `dist/` + `.browserslistrc` build targets |
| Index coverage | Migration `2026_09_07_000001_add_missing_columns_indexes_and_fixes.sql` + integrity migration `2026_09_12_000014` |

## 2. Regenerate live numbers (runbook)

```bash
# Local micro-benchmarks
php scripts/benchmark.php

# Live-site probes (headers, TTFB, compression)
python scripts/verify_live.py
python scripts/probe_live.py
```

For full waterfall/Lighthouse metrics, run the configured
`lighthouserc.js` collection and attach the JSON to a new
`docs/audits/<date>-performance.md` entry.

## 3. Structural risks to watch

1. **Storefront page weight** — root pages embed large inline payloads
   (e.g., `wholesale.php`, `reseller.php`, `retailer.php` are multi-thousand-line
   monolith pages). Gzip mitigates transfer, but template extraction
   (like the admin component library) is the next big win.
2. **PHPStan memory** — local static analysis needs `memory_limit=1G`;
   not user-facing but slows the dev loop.
3. **Rate limiter file fallback** — without Redis, limits persist to disk per
   key; fine at current traffic, revisit under load.

## 4. Known-good baseline from CI

CI runs the Playwright suite on every push (headless), so gross UI
regressions are caught before deploy; `scripts/benchmark.php` results are not
yet archived — adding a nightly job that stores them in `docs/audits/` would
make future versions of this document quantitative again.
