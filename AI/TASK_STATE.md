# TASK STATE

> The live queue. **Update this file as you work, not afterwards** — it is what the next session reads to
> find out where the work stopped. [AGENT_HANDOFF.md](AGENT_HANDOFF.md) holds the context needed to
> interpret it; [AUDIT_REPORT.md](AUDIT_REPORT.md) holds the findings this queue drains.
>
> Last updated **2026-08-29**. Finding IDs (`C-n` `H-n` `M-n` `L-n` `I-n`) are `AUDIT_REPORT.md`'s;
> `KI-n` / `SEC-n` / `D-n` are the registers'. **Append, never renumber.**

---

## 1. The invariant right now

**Bootstrap phase — UNDERSTAND + DOCUMENT + ORGANIZE + AUDIT — is CLOSED as of 2026-08-29.**
**No application code was modified in it,** and the closing sweep in §2 proves it. The owner asked
explicitly for no rewrites during bootstrap, and none happened.

**Nothing in §4 has started.** The next phase is code, and it begins only on an explicit instruction —
Q-1 first, per [AUDIT_REPORT.md](AUDIT_REPORT.md) §9. Until then `git status` should still show additions
under `AI/` and nothing else; anything else in the working tree means a session stopped mid-task, so find
out where before adding to it.

## 2. Done

| # | Item | Landed |
| :--- | :--- | :--- |
| 1 | Admin login 301 trailing-slash fix (`/admin/`, not `/admin`) | `4a97896`, `31be293` — 2026-08-28 |
| 2 | Order drawers, packing slips, `customers.password_hash` fix | `af715e6`, `dab1147` — 2026-08-28 |
| 3 | Dashboard: 8 live widgets, real chart series, order date-range filtering | `a3d9e26` — 2026-08-29 |
| 4 | WhatsApp number normalised to `917046363528` — **all 47 raw occurrences verified correct** | earlier session; re-verified 2026-08-29 (L-1) |
| 5 | **The `AI/` documentation tree — 27 files** | this phase, uncommitted |
| 6 | **KI-21 / H-4 corrected** — `reseller.js` is not dead; the real defect is diverging shadowed copies | this phase, uncommitted (raised **P-8**) |

**Item 5, file by file.** Complete: `MASTER.md` · `PROJECT_MEMORY.md` · `ARCHITECTURE.md` ·
`PROJECT_MAP.md` · `DATABASE.md` · `API.md` · `BACKEND.md` · `FRONTEND.md` · `ADMIN.md` · `SECURITY.md` ·
`PERFORMANCE.md` · `TESTING.md` · `DEPLOYMENT.md` · `INTEGRATIONS.md` · `BUSINESS_LOGIC.md` ·
`UI_SYSTEM.md` · `FILE_OWNERSHIP.md` · `KNOWN_ISSUES.md` (KI-1…KI-22) · `DECISIONS.md` (D-1…D-13) ·
`CHANGELOG.md` · `ERROR_RECOVERY.md` · `AGENT_PROTOCOL.md` · `AGENT_HANDOFF.md` · `CLAUDE_MASTER.md` ·
`GEMINI_MASTER.md` · `AUDIT_REPORT.md` · `TASK_STATE.md`, plus `agents/` — 12 briefs and a `README.md`.

**Remaining in this phase: nothing.** The closing validation ran on 2026-08-29 and is recorded in
[CHANGELOG.md](CHANGELOG.md) §5: `php -l` over all **452** PHP files in `DT Brand/` — clean;
`node --check --input-type=commonjs` over all **105** JS files in `DT Brand/` — clean;
`git status --short` — `?? AI/` and nothing else, so the documentation-only invariant held. The
persistent memory note that said 17 tables now says **18**.

**One finding was corrected during that sweep, and it changes what Q-7 is.** `reseller.js` was recorded
as dead — 351 KB killed by a `SyntaxError`. It is not: all 11 duplicates are `function` declarations,
legal in a classic script, and the file parses. The error only appears under
`node --check --input-type=module`, which applies to nothing here. The real bug is that the shadowed
copies **diverge** — `getWholesaleTier():840` and `:3083` use different VIP tier thresholds — so the new
blocker is a product decision, **P-8**. Corrected in KI-21, `AUDIT_REPORT.md` H-4, `FRONTEND.md`,
`BUSINESS_LOGIC.md` §2, `PERFORMANCE.md`, `TESTING.md`, `ERROR_RECOVERY.md` §3, `AGENT_PROTOCOL.md` §4,
`AGENT_HANDOFF.md` §4/§5, `GEMINI_MASTER.md` §6, `agents/frontend.md`, `agents/testing.md`.

## 3. Blocked on the owner — nothing here can be done from this environment

| # | What is needed | Unblocks |
| :--- | :--- | :--- |
| B-1 | **Rotate the MySQL password** in hPanel | C-1 |
| B-2 | **Set the eight env vars** — `DB_HOST` `DB_PORT` `DB_NAME` `DB_USER` `DB_PASS` `ADMIN_EMAIL` `ADMIN_PASSWORD` `ADMIN_NAME` — and **confirm they resolve on live** with a length-only probe | C-1 step 4, C-2 |
| B-3 | **Change the admin password** and move it to `ADMIN_PASSWORD` | C-2, and it is the last blocker on C-1 |
| B-4 | **Revoke the GitHub token** in the `origin` URL in `.git/config`; switch to SSH or a credential helper | C-3 |
| B-5 | **Paste `SHOW TABLES` and `SHOW COLUMNS`** from live | H-1, H-12, M-8, and the scope of several others |
| B-6 | **Run `php database/migrate.php` on live**, then confirm | the pending schema changes in §7 |
| B-7 | **Upload the pending files** in §7 and confirm | everything already fixed locally |
| B-8 | **Decide whether git history is purged** (`filter-repo` / BFG — rewrites every hash, needs a force-push) | the residue of C-1 and C-2 |

**B-2 before any fallback is deleted.** There is **no `.env` loader** in the project — a `.env` file achieves
nothing; only real process environment variables reach `getenv()`. Removing a fallback first takes the site
down (D-7).

## 4. Queued — ready to start on an instruction

In the order recommended by `AUDIT_REPORT.md` §9. Each is one task with one report.

| # | Task | Finding | Notes |
| :--- | :--- | :--- | :--- |
| Q-1 | Whitelist `payment_status` / `fulfillment_status`, floor `shipping` at 0, take `gst_rate` from `PricingCalculator` | **C-4** | the highest-value code fix, and small. `OrderManager.php:296`, `:297`, `:310`, `:311` |
| Q-2 | Deny rule for `database/` in `.htaccess` | C-6 | whole-site file — keep minimal, give the owner a revert path |
| Q-3 | Guard or withdraw `api/db_audit.php` and `api/db_health.php`; rotate the published install key | C-7 | `db_audit.php` **creates 16 tables** when reached |
| Q-4 | Static "sign in again" page on the guard's throw path + exact-path allowlist | C-5 | **fail-open behaviour stays** (D-3). Not a fail-closed rewrite |
| Q-5 | Coupon cap — fix `DiscountEngine.php:80-84` **and** `OrderManager::resolveCouponDiscount()` in one commit | H-3 | cart can quote 1.5 × subtotal today |
| Q-6 | Define `handleSaveGstProfile()`, wire to `customers.gstin` via `api/auth.php` | H-5 | **offered; awaiting go-ahead.** 3 call sites, 0 definitions |
| Q-7 | Delete the shadowed copy of each of the 11 duplicated functions in `reseller.js` | H-4 | **not a `SyntaxError` — the file runs** (KI-21, corrected 2026-08-29). The last copy wins and `getWholesaleTier():840` vs `:3083` disagree on the tier thresholds. Confirm which table is intended **before** deleting — P-8 |
| Q-8 | Remove the 16 `/DT%20Brand/` prefixes from 6 admin JS files | H-6 | leave the 9 `wa.me` hits alone |
| Q-9 | Continue the fabricated-data sweep — `OrderManager::getAll():627` first, then the ~190-page admin chrome, then `admin/resellers/` segments, `product.php` review counts, `reseller.js:5133`'s `p.moq \|\| 8`, and the dead `country-picker.js` success toast | H-2, KI-3a-3e, M-6 | empty and honest, never a nicer fake (D-5) |
| Q-10 | Negative memoisation in `Database::getConnection()` | H-9, I-1 | must preserve the offline admin path (D-6) and `isMockMode()` gating (D-5); **96 files require this file** |
| Q-11 | `lifetime_spend` should respect `payment_status`; debit `outstanding_balance` | H-11 | depends on Q-1 landing first |
| Q-12 | Pre-upload check script + live smoke checklist | I-3, I-4 | the only gate this project has |

## 5. Awaiting a product decision — do not implement either way

| # | Question | Why it is a decision, not a task |
| :--- | :--- | :--- |
| P-1 | **Store settings** — add a `settings` table, or stop the UI claiming it saved? | needs a schema change either way. `admin/settings/index.php:40` says `"Saved locally!"` and writes nowhere (H-12, KI-8) |
| P-2 | **Password reset** — which mail transport, whose credentials? | there is no mail transport anywhere; the token is stored and never delivered (M-3, KI-11). Credentials make it SEC-1-adjacent |
| P-3 | **Per-product channel visibility** and **per-parcel weight/dimensions** | both need new columns (M-8, KI-19) |
| P-4 | **Curated-page bulk actions** — what should they actually do? | currently in the "reports success, does nothing" class (M-6, KI-18) |
| P-5 | **Seed rows** — which of the 3 orders / 3 customers / 2 reviews are real? | until answered, no cleanup runs. **No `DELETE` executes from this environment** (H-10, KI-1) |
| P-6 | **`admin/adminlogin.php`** — collapse into `login.php`? | a deletion needs an explicit instruction (D-9). 738 lines, zero inbound links, URL-reachable (H-8) |
| P-7 | **Token-system unification** and **`--ws-*` deduplication** | ~190 admin + 11 storefront pages, no shared layout to regression-test through (I-5, D-12) |
| P-8 | **Which reseller VIP tier thresholds are correct** — `800/450/250/50` (`reseller.js:840`, dead) or `1000+` for Tier 5 (`:3083`, live)? | both are in the file; the one a reader finds first is the one that never runs. Deleting either copy changes what customers are told they qualify for (H-4, KI-21) |

## 6. Needs live verification once the owner uploads

Everything below is **written and lint-clean, and unverified** — there is no MySQL and no browser here
(KI-22). This is the checklist to hand over; details in [TESTING.md](TESTING.md).

- one order through the admin drawer and one through `/checkout`; confirm stock decremented and
  `total_orders` / `lifetime_spend` moved
- a product round-tripped with photos + an MP4 + a pasted YouTube/Instagram link + variants + MOQ tiers, and
  the card, gallery, sizes, colours and category all correct on the storefront
- `product.php?id=9999` returns the 404 page, not a blank
- cart totals just under and just over the ₹1999 free-shipping threshold
- the three B2B pages, both empty and populated
- review moderation end to end
- every WhatsApp entry point opening `917046363528`
- the **eight dashboard widgets** agreeing with real data, and the 1W/1M/1Y pills changing the chart
- the three canvases showing their "no data yet" text when there is no data
- `/admin/` sign-in → landing **with** the trailing slash, and sign-out
- `/admin/admin.php`, `/admin/dashboard/` and both "Back to Console" links loading through the shim

## 7. Pending upload — the owner's list

Files fixed locally and **not yet confirmed uploaded**:

`DT Brand/admin/index.php` · `DT Brand/admin/admin.php` · `DT Brand/admin/Asset/js/admin.js` ·
`DT Brand/api/orders.php` · `DT Brand/admin/login.php` · `DT Brand/admin/adminlogin.php` ·
`DT Brand/src/Auth.php`

**Plus one migration run** — `php database/migrate.php` on live, for: `customers.password_hash` nullable
MODIFY; `total_orders`, `lifetime_spend`, `gstin`, `pan`, `commission_rate`, `reset_token`, `reset_expires`,
`last_login`; `order_items.variant_color` and `variant_size`; and `customer_notes`.

FTP moves files; **it never carries the database** ([CHANGELOG.md](CHANGELOG.md) §2). A `chore: sync` commit
records intent, not an upload.

## 8. How to update this file

1. **Move an item, do not delete it.** Queued → Done with the commit and date; Blocked → Queued when the
   owner answers.
2. **A half-finished task says where it stopped** — file, line, and what the next step is. A resume point is
   the whole value of this file.
3. **Close the finding too** — update `AUDIT_REPORT.md` and the `KI-n` / `SEC-n` entry in place, with the
   date. Never delete an entry; **append, never renumber.**
4. **Add a `CHANGELOG.md` entry** under `## 5. Unreleased`, dated, with `file:line`.
5. **Every item that changes a file names it for upload** in §7 (D-8).
6. **Re-date this header** whenever you touch the file.


