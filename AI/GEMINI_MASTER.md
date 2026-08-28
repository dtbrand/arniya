# GEMINI MASTER

> The Gemini-specific entry point. [MASTER.md](MASTER.md) is the project brief and
> [AGENT_PROTOCOL.md](AGENT_PROTOCOL.md) is the procedure — both apply unchanged. This file covers only
> what is specific to running **Gemini CLI** (or another non-Claude agent) against this repository.
>
> The Claude equivalent is [CLAUDE_MASTER.md](CLAUDE_MASTER.md). Project facts belong in `MASTER.md`, not
> duplicated into either of these.

---

## 1. Read order for a cold start

1. `AGENTS.md` at the git root — the owner's own instructions. **They win over anything in `AI/`.**
2. [MASTER.md](MASTER.md) — what the project is, and the ten rules.
3. [AGENT_HANDOFF.md](AGENT_HANDOFF.md) → [TASK_STATE.md](TASK_STATE.md) — where the work stands.
4. The relevant brief in [agents/](agents), then the module `README.md` if one exists.

If your CLI reads a `GEMINI.md` at the project root, **point it at this tree rather than restating it** —
a second copy of the project facts will drift from the first within a week. A one-screen `GEMINI.md` that
says "read `AI/MASTER.md`, then `AI/GEMINI_MASTER.md`" is the whole requirement (D-10).

## 2. Three environment facts that break naive commands

**The git root is one level above the live tree, and both paths contain a space:**

```
/c/Users/sai/Desktop/WhatsApp CRM            <- git root; AGENTS.md and AI/ are here
/c/Users/sai/Desktop/WhatsApp CRM/DT Brand   <- the live tree
```

Quote every path. `DT Brand/`'s *contents* become `/public_html/` on live, which is why `/DT%20Brand/` in
any URL is a bug ([KNOWN_ISSUES.md](KNOWN_ISSUES.md) KI-10).

**PHP is not on `PATH`.** It is `/c/xampp/php/php.exe`, version 8.2. `php -l` alone fails.

**There is no MySQL and no network path to live.** Nothing DB-dependent can be executed here (KI-22).
Report it as unverified instead of implying a check passed.

## 3. The only verification available

```bash
/c/xampp/php/php.exe -l "DT Brand/src/OrderManager.php"
```

```bash
node --check --input-type=commonjs < "DT Brand/admin/resellers/assets/js/reseller.js"
```

Whole-tree PHP lint, from the git root:

```bash
find "DT Brand" -name '*.php' -print0 | xargs -0 -P 8 -n 1 /c/xampp/php/php.exe -l 2>&1 | grep -v "No syntax errors"
```

That is the entire toolchain. **There is no test suite** — GEN-A's `phpunit.xml`,
`playwright.config.js`, `eslint.config.js` and `.github/workflows/*` were added in one abandoned commit
and wired to nothing (D-1), and exactly **one of 835 commits** is a `test` commit
([CHANGELOG.md](CHANGELOG.md) §0). Do not run them and do not treat them as the project's strategy.
[TESTING.md](TESTING.md) describes the manual procedure that replaces them.

Keep any helper script's output **ASCII-only**; the Windows console is cp1252 and an em dash or a ₹ will
crash the script.

## 4. Searching this repository without reaching a wrong conclusion

The repository contains **three generations of the same product**, so an unscoped search returns two hits
for everything and *the wrong one is often the prettier file*. `src/Database.php` exists twice.

Two habits, both non-negotiable:

- **Scope to `DT Brand/`.** Nothing outside it is deployed.
- **Match the full path, not the basename, and exclude comments.** `assets/css/wholesale.css` appeared to
  have 29 referrers because `/admin/wholesale/assets/css/wholesale.css` contains it as a substring — the
  true count is **1**. Both apparent referrers of `assets/js/modals.js` were **comments** (D-9).

```bash
grep -rn 'assets/css/wholesale.css' "DT Brand" --include=*.php | grep -v '/admin/'
```

Also worth internalising before you delete anything: in `includes/` **the misspelled files are the live
ones** (`shophader.php`, `shopbottomfotoer.php`), and every `shared/*_modal.php` is dead **except
`size_chart_modal.php`**, which is live on six pages.

## 5. Editing conventions — match the code, do not improve it

`DT Brand/src/` is 7 classes and 4,007 lines of static methods under `namespace DTBrand;`, with **no
autoloader** — 96 files write their own `require_once __DIR__ . '/../src/Database.php';`. Add a class the
same way, and require it explicitly in dependency order at every consumer.

Do **not** introduce, inside another task: a framework, a container, an ORM, a repository layer, a front
controller, a composer autoloader, a bundler, a minifier or a CSS preprocessor. The deployment model is
file copy over FTP; a build step converts "upload the file you changed" into a release process (D-2).

Preserve the ARNIYA identity in any UI work — `Cinzel` for display, the gold `#8A681F`, the dark obsidian
palette. There are four coexisting token systems and they are **not** being unified as part of another
task (D-12). [UI_SYSTEM.md](UI_SYSTEM.md) §1-2.

## 6. Where large-context reading pays off here

A long context window is a real advantage on this codebase, because the pathology is duplication rather
than depth. Three jobs it is genuinely good at:

- **Cross-file mirror audits.** A commercial rule has one authority and several browser mirrors (D-11);
  finding a mirror that drifted needs many files open at once.
- **Whole-file JS review.** `reseller.js` is 6,032 lines and declares **11 names more than once**. The file
  parses (they are `function` declarations, not `let`/`const`), so a linter will not find the problem: the
  last copy wins and the copies **diverge** — `getWholesaleTier():840` and `:3083` use different VIP
  thresholds. Comparing two definitions 2,200 lines apart is exactly the job a large context is good at
  (KI-21).
- **Component blast-radius checks.** `admin/orders/components/order-table.php` renders 13 pages;
  `admin/Includes/adminheader.php` renders ~190.

What it does **not** license: reading a lot and then asserting a count. **Every number in this tree must be
reproducible by a command.** If you cannot produce the command, write "unverified" — that is a complete and
acceptable answer, and it is the same rule the application code follows (D-5).

## 7. Absolute limits

No `git reset --hard`, `push --force`, `clean -f`, `branch -D`, `rebase`, or history rewrite without the
owner's explicit permission, every time. No `DROP` / `TRUNCATE` / unconditioned `DELETE`, ever — not even
the three seed orders (KI-1). No file deletion without a classification and an instruction (D-9). No
credential value in any output: **file, line and variable name only** ([SECURITY.md](SECURITY.md) SEC-1).
No deployment — the owner pushes and uploads (D-8).

End every task with **TASK · ROOT CAUSE · CHANGES · TESTS · RESULT · RISKS · NEXT**, and let `NEXT` name
the exact files to upload.


