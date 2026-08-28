# AGENT HANDOFF

> Read this **second**, after [MASTER.md](MASTER.md). It is the standing brief for picking up work in
> this repository: what state the project is in, what is waiting on the owner, and the specific
> misunderstandings that have already cost time. [TASK_STATE.md](TASK_STATE.md) holds the live queue;
> this file holds the context you need to interpret it.
>
> Written 2026-08-29. Every count in it is dated, because every count in it will drift.

---

## 1. Ninety seconds of context

**ARNIYA / DT Brand's & Jai Hanuman Tex** — a saree and textile e-commerce storefront plus a very large
admin console, PHP 8.2 + MySQL on Hostinger shared hosting, deployed by FTP. Three sales channels
(retail, wholesale, reseller) with per-tier pricing. **There is no payment gateway** — orders settle
offline, and WhatsApp (`917046363528`) is the real sales channel.

**No framework, no DI, no ORM, no autoloader, no build step, no `.env` loader, no test suite.** That is a
decision, not neglect — [DECISIONS.md](DECISIONS.md) D-2. Every one of the 452 PHP files is an entry
point.

**Only `DT Brand/` is live.** Its *contents* become `/public_html/`. Two other complete generations sit
in the same repository and are not deployed. **A bare path is ambiguous** — `src/Database.php` exists
twice. Write `DT Brand/src/Database.php`, always.

**You do not deploy.** The owner pushes to GitHub and uploads by FTP. Nothing in the repository deploys
anything (D-8). So every task ends by naming the files to upload.

## 2. Where the work stands

| Phase | State |
| :--- | :--- |
| Repository audit + documentation bootstrap (`AI/`, 27 files) | **this phase** — documentation only, no application code touched |
| Dashboard analytics made live (8 widgets, real chart series, date-range filtering) | landed `a3d9e26`, **needs live verification** |
| Admin login 301 trailing-slash fix | landed `4a97896`, `31be293` |
| Order drawers, packing slips, `customers.password_hash` fix | landed `af715e6`, `dab1147` — **migration not confirmed run** |
| Credential rotation (SEC-1) | **blocked on the owner**, steps 1-3 of D-7 |
| Fabricated-data sweep | partial — ~30 sites remain, catalogued as KI-3a…3e |

**Nothing in the current documentation phase modified application code.** If you are picking up mid-phase,
that invariant is worth preserving until the phase is reported closed.

## 3. Waiting on the owner — nothing below can be done from here

| # | What is needed | Why it blocks | Reference |
| :--- | :--- | :--- | :--- |
| 1 | **Rotate the MySQL password**, set the eight env vars, confirm with a length-only probe | until then the `?: '<literal>'` fallbacks are what live actually uses, and removing one takes the site down | D-7, SEC-1 |
| 2 | **Change `ADMIN_PASSWORD` and move it to an env var** | the committed literal is a self-healing super-admin key that re-stamps the account on every sign-in and works while MySQL is down | D-6, SEC-2 |
| 3 | **Revoke the GitHub token** in the `origin` URL in `.git/config`, switch to SSH or a credential helper | a push credential in a tracked-adjacent file | SEC-1 |
| 4 | **`SHOW TABLES` and `SHOW COLUMNS` on live** | three schema authorities disagree and we cannot tell which ran. This one unanswered question is behind KI-4, KI-8 and KI-19 | [DATABASE.md](DATABASE.md) §1 |
| 5 | **Run `php database/migrate.php` on live**, then confirm | `customers.password_hash` nullable, the customer counter columns, `order_items.variant_color/variant_size`, `customer_notes` | KI-4 |
| 6 | **Upload the pending files** and confirm | a correct local fix that is not uploaded does not exist for users | D-8 |
| 7 | **Decisions**: `settings` table vs local-only settings · password-reset delivery · per-product channel visibility · per-parcel weight/dimensions · curated-page bulk actions · wiring `handleSaveGstProfile` | each needs either a schema change or a product decision | KI-7, KI-8, KI-11, KI-19 |

**Ask once, clearly, then keep working on everything that does not depend on the answer.** Items 1-3 are
the highest-value work in the repository and none of it is code.

## 4. Six misreadings that have already cost time

Each of these was believed, acted on or written down, and was wrong:

1. **A basename grep is not evidence.** `assets/css/wholesale.css` appeared to have 29 referrers because
   `/admin/wholesale/assets/css/wholesale.css` contains it as a substring. True count: **1**. Both
   apparent referrers of `assets/js/modals.js` turned out to be **comments**. Match the full path,
   exclude comments (D-9).
2. **The misspelled files in `includes/` are the live ones.** `shophader.php`, `shopbottomfotoer.php`.
   The correctly-spelled ones are dead.
3. **"Dead" was wrong four times.** `assets/css/main.css` and `header.css` are linked by three admin
   pages; `shared/quickview.php` is live on six storefront pages; `shared/size_chart_modal.php` is live
   on six *despite* every other `*_modal.php` being dead.
4. **`gst_rate: -100` is not an exploit.** `PricingCalculator::calculateGst()` throws on a negative rate
   (`:27-29`) and `api/orders.php:227` returns 500 with no row written. The real holes are `gst_rate: 0`,
   negative `shipping`, and `payment_status` defaulting to `'paid'` — SEC-5.
5. **A commit subject overstates what landed, consistently.** `0f01c6c` claims settings persist "directly
   to MySQL settings table"; **there is no `settings` table.** `378f926` claims "100 % dynamic"; the admin
   chrome still ships fabricated values onto ~190 pages. The sweeps were real, the "all" was
   aspirational — [CHANGELOG.md](CHANGELOG.md) §3.
6. **`reseller.js` is not dead.** The 11 duplicate declarations were called a `SyntaxError` that killed all
   351 KB. They are duplicate **`function`** declarations, which are legal; the file parses, and the
   `SyntaxError` only appears under `node --check --input-type=module` — semantics that apply to nothing in
   this repository (`reseller.php:4044` uses a plain `<script src>`; there is no `type="module"` anywhere in
   `DT Brand/`). The genuine bug is that the shadowed copies **diverge** — KI-21, H-4.

## 5. Traps that are load-bearing, not trivia

- **Mock mode hides outages.** `Database::query()` returns `[]` for an empty table *and* for a dead
  database, and `getConnection()` has no negative memoisation — so an outage presents as a **hang**, not
  an error. Check `api/health.php` first (`ERROR_RECOVERY.md` §3).
- **The two guards are asymmetric on purpose.** `api/_guard.php` fails closed; `adminguard.php` fails
  open. Do not unify them (D-3).
- **Order creation is public on purpose**, and the server re-derives every value that touches money.
  `unit_price`, `total_amount` and `channel` must never come from the request (D-4).
- **One authority per commercial rule**, and the browser copies are mirrors that must follow — freight in
  `config/shipping.php`, GST in `PricingCalculator`, tier price via `priceColumnFor()`, lot minimums in
  the `moq_*` columns, coupons in the `coupons` table (D-11). `1999` is also a coupon minimum twice, a
  demo price twice and a `z-index` three times — do not "fix" those.
- **Editing one component touches many pages.** `admin/orders/components/order-table.php` renders 13
  status pages; `admin/Includes/adminheader.php` renders ~190.
- **A function declared twice is not an error — it is a silent shadow.** `reseller.js` declares 11 names
  more than once in 6,032 lines; the last one wins and the file parses fine. Two copies of
  `getWholesaleTier()` disagree on the VIP thresholds (`:840` dead, `:3083` live), so an edit made in the
  obvious place does nothing (KI-21). A duplicate `let`/`const`/`class` *would* be a fatal `SyntaxError` —
  that is a different bug, and `reseller.js` does not have it.
- **No cache-busting anywhere.** Hard-reload before believing that a CSS or JS fix did not work.

## 6. Handing off — what to leave behind

Write these four things, in this order, before you stop:

1. **The end-of-task report** — TASK · ROOT CAUSE · CHANGES · TESTS · RESULT · RISKS · NEXT
   ([AGENT_PROTOCOL.md](AGENT_PROTOCOL.md) §8). `NEXT` must name the upload list in full paths.
2. **A `CHANGELOG.md` entry** under `## 5. Unreleased`, dated, with `file:line`.
3. **`TASK_STATE.md` updated** — what is done, what is in flight and *where it stopped*, what is blocked
   and on whom. A half-finished file must say which line it stops at.
4. **Any new finding as a numbered entry** — `KI-n` in `KNOWN_ISSUES.md`, `SEC-n` in `SECURITY.md`, a new
   `D-n` only if the owner actually decided something. **Append, never renumber.**

And two things not to leave behind: an uncommitted mystery (say what is in the working tree), and a claim
you did not verify (mark it unverified — there is no MySQL here, and saying so costs nothing).

## 7. If you are the *first* agent in a new session

Read in this order and you will not need anything else: [MASTER.md](MASTER.md) →
this file → [TASK_STATE.md](TASK_STATE.md) → the domain brief in [agents/](agents) for what you are about
to touch → the module `README.md` if there is one.

Then, before the first edit, run the two cheap checks that catch most of what goes wrong here:

```bash
git -C "/c/Users/sai/Desktop/WhatsApp CRM" status --short
git -C "/c/Users/sai/Desktop/WhatsApp CRM" log --oneline -8
```

An unexpected working-tree change means a previous session stopped mid-task; find out where before adding
to it.


