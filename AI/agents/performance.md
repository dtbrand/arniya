# AGENT BRIEF · PERFORMANCE

> **Scope:** page weight, query count, connection behaviour and rendering cost. The constraint that shapes
> every answer: **PHP 8.2 on Hostinger shared hosting, deployed by FTP, with no build step.** A fix that
> needs a bundler is not a fix here (D-2).
>
> Read with [PERFORMANCE.md](../PERFORMANCE.md).

---

## 1. Fix these in this order

1. **The connection storm during an outage** — the only issue that turns a slow page into a hung one.
2. **Unminified JS on the B2B pages** — 752 KB across three pages, one file 351 KB.
3. **Per-page query count** — every page opens its own PDO connection and runs its own inline queries.
4. **Images** — 5.54 MB of PNG/WebP tracked, and the seed placeholders still ship.
5. **CSS weight** — 1.42 MB across 87 files, much of it triplicated tokens.

Everything below #2 is ordinary tuning. #1 is a correctness-adjacent defect.

## 2. The connection storm — read this before profiling anything

`Database::getConnection()` short-circuits only on `self::$pdo !== null` (`Database.php:19`). **There is no
negative memoisation:** in mock mode `$pdo` stays null, so every call re-runs the entire
`[$host, 'localhost', '127.0.0.1']` candidate loop — and `isMockMode()` (`:60-64`) calls `getConnection()`
too.

A page that queries 40 times therefore makes **40 × 2-3 TCP connection attempts** while MySQL is down. The
symptom the owner reports is *"the site is slow"* or *"it hangs"*, never *"the database is down"*. Check
`api/health.php` first — it reports `MOCK_FALLBACK_ACTIVE` ([ERROR_RECOVERY.md](../ERROR_RECOVERY.md) §3).

The fix is a cached failure state, and it needs care: it must not defeat the deliberate offline admin path
(`Auth.php:363`, D-6) or the honest-failure gating that depends on `isMockMode()` (D-5). Design it, state the
interaction, and get the owner's agreement before changing a file 96 files depend on.

## 3. Asset weight, measured

**105 JS files, 87 CSS files, 1.42 MB of CSS, 5.54 MB of images, all shipped unminified and unbundled.**
There is no minifier, no bundler and **no cache-busting query string anywhere** — the file the browser
fetched is the file on disk, cached by the browser alone.

The concentrations worth attacking:

- **The three B2B pages carry 752 KB of JS**, `reseller.js` alone being 351 KB / 6,032 lines. That single
  file is a bigger cost than the entire `require_once` sprawl.
- **The `--ws-*` token block is triplicated byte-for-byte** across `wholesale.css`, `reseller.css` and
  `retailer.css` — 666 KB combined ([UI_SYSTEM.md](../UI_SYSTEM.md) §5). Deduplicating it is a real win, but
  it touches three pages that have no shared layout to regression-test through (D-12) — propose it, do not
  fold it into another task.
- **2,228 inline `<svg>` elements across 276 files**, and **zero icon libraries**. Inlining is the right
  call for a no-build project; repeating the same 40-line icon 200 times is not.
- **The seed placeholder images still ship** — 18 files under `shared/Asset/images/`, still referenced by
  fabricated demo data in the B2B JS (KI-3d).

## 4. What not to do

1. **Do not add a build step, bundler, minifier or preprocessor.** The deployment model is file copy; a
   build artifact converts "upload the file you changed" into a release process (D-2).
2. **Do not "optimise" the `require_once` sprawl.** 96 hand-written requires cost a stat plus a cached parse
   under opcache. It is not the bottleneck; 351 KB of unminified JS is.
3. **Do not add a caching layer that hides an outage.** `Database::query()` already returns `[]` for both an
   empty table and a dead database (D-5); a cache in front of that makes the failure permanent.
4. **Do not micro-optimise a query you cannot run.** There is no MySQL here — no `EXPLAIN`, no timing. An
   index proposal is a proposal until the owner runs it (KI-22).
5. **Do not compress an image destructively in place.** Keep the original, and remember the owner has to
   upload whatever you produce.

## 5. Rendering cost in the admin console

Every chart is **hand-drawn `<canvas>`** — there is no charting library. Two things matter:

- **Use `ctx.setTransform(dpr, 0, 0, dpr, 0, 0)`, never `ctx.scale(dpr, dpr)`** — `scale` compounds, so the
  chart shrinks a little on every redraw (`UI_SYSTEM.md` §10).
- **Redraw on resize, do not re-create.** A per-frame allocation in a hand-rolled renderer is the whole
  performance budget of a shared-hosting page.

And `admin/Includes/adminheader.php` / `adminfooter.php` are included by **~190 pages** — anything you add
there, including a script tag, is a 190-page cost.

## 6. Verification

```bash
find "DT Brand/assets" "DT Brand/admin" -name '*.js' -printf '%s %p\n' | sort -rn | head -20
```

```bash
/c/xampp/php/php.exe -l "DT Brand/src/Database.php"
```

Byte counts and file counts are verifiable here. **Latency, query timing and connection behaviour are not** —
no MySQL, no live access. Report a measured size as measured and a predicted speedup as predicted, and give
the owner the check to run after upload.

