# ARNIYA — AI MASTER INDEX

> Entry point for every AI agent and human engineer working on this repository.
> Read this file first. It tells you what is true, what is dangerous, and which
> document answers your question.
>
> Repository: `dtbrand/arniya` · Brand: **ARNIYA / DT Brand's & Jai Hanuman Tex**
> Live site: `https://jaihanumantex.in` · Bootstrap authored: 2026-08-29

---

## 1. The 30-second orientation

| Question | Answer |
| :--- | :--- |
| Where is the code that is actually live? | `DT Brand/` — that directory's contents are the web root `/public_html/` on Hostinger. |
| What is `Frontend/`, root `admin/`, root `api/`, root `src/`? | A **frozen previous generation** (last touched 2026-08-25). Not deployed. Do not edit. |
| What is root `app/`, `bootstrap/`, `public/`, `tests/`, `.github/`? | A **one-shot enterprise scaffold** (2026-08-24) that was never wired to the live app. |
| Stack | PHP 8.2, PDO/MySQL, no framework, no build step, vanilla JS, hand-written CSS. |
| Database | MySQL on Hostinger. **18 tables.** The name, user and password are credentials — referenced by file, line and variable name only ([SECURITY.md](SECURITY.md) SEC-1), never reproduced in this tree. See [DATABASE.md](DATABASE.md). |
| Deployment | Manual. Owner commits to GitHub and uploads by FTP. No CI deploy. See [DEPLOYMENT.md](DEPLOYMENT.md). |
| Who deploys? | **The repository owner, never an agent.** Agents edit local files and report an upload list. |

## 2. Non-negotiables

1. **Understand before modifying.** Read the file and its callers. Never guess at a fix.
2. **Never blindly delete or rewrite.** Prove a file is a duplicate or dead first, classify it
   (see [FILE_OWNERSHIP.md](FILE_OWNERSHIP.md)), and if you are not certain, record it in
   [KNOWN_ISSUES.md](KNOWN_ISSUES.md) instead of removing it.
3. **Stay in scope.** "Fix login" touches login and its real dependencies. Nothing else.
4. **Root cause first.** If a new error appears after your fix, do not stack another patch.
   Return to the first failure and trace from the beginning. See [ERROR_RECOVERY.md](ERROR_RECOVERY.md).
5. **Database safety.** No `DROP`, no `TRUNCATE`, no unconditioned `DELETE`, no destructive
   `ALTER` without explicit written authorisation plus an impact analysis.
6. **No fabricated data.** Never ship an invented order, customer, SKU, price or statistic that
   renders as if it came from the database. An honest empty state is always correct; a fake
   number is always a bug. This is the single most common defect class in this codebase.
7. **No secrets in commits.** See the CRITICAL findings in [SECURITY.md](SECURITY.md).
8. **Preserve the brand.** Colours, typography, buttons and iconography are fixed by
   [`AGENTS.md`](../AGENTS.md) and [UI_SYSTEM.md](UI_SYSTEM.md). Do not redesign.
9. **Test what you change,** and say exactly what you verified and what you could not.
10. **End every task with the report format** in [AGENT_PROTOCOL.md](AGENT_PROTOCOL.md).

## 3. Priority order when requirements conflict

```
existing working business logic
  > the user's explicit request
    > security
      > data integrity
        > existing architecture
          > UI/UX consistency
            > performance
              > maintainability
                > cleanup
                  > new improvements
```

## 4. Document index

| Document | Answers |
| :--- | :--- |
| [PROJECT_MEMORY.md](PROJECT_MEMORY.md) | Durable facts an agent must not re-derive. Read this second. |
| [ARCHITECTURE.md](ARCHITECTURE.md) | How the three generations relate, request lifecycle, layering. |
| [PROJECT_MAP.md](PROJECT_MAP.md) | Directory-by-directory map with file counts and ownership. |
| [DATABASE.md](DATABASE.md) | Authoritative 18-table schema, migration reality, code-vs-schema drift. |
| [API.md](API.md) | All 22 endpoints, auth matrix, contract drift. |
| [BACKEND.md](BACKEND.md) | `DT Brand/src/` classes, connection engine, mock-mode hazard. |
| [FRONTEND.md](FRONTEND.md) | Storefront pages, asset graph, dead assets, client state. |
| [ADMIN.md](ADMIN.md) | 26 admin modules, guard coverage, real-vs-fake classification. |
| [BUSINESS_LOGIC.md](BUSINESS_LOGIC.md) | Pricing, GST, MOQ lots, channels, order lifecycle. |
| [UI_SYSTEM.md](UI_SYSTEM.md) | Design tokens, button classes, focus animation — pointer to `AGENTS.md`. |
| [SECURITY.md](SECURITY.md) | Secrets, authn/authz, CSRF, uploads, headers. Start with the CRITICALs. |
| [PERFORMANCE.md](PERFORMANCE.md) | Page weight, query patterns, the `time()` cache-buster problem. |
| [TESTING.md](TESTING.md) | What can actually be verified on a Windows dev box today, with commands. |
| [DEPLOYMENT.md](DEPLOYMENT.md) | FTP reality, upload lists, migration runs, rollback. |
| [INTEGRATIONS.md](INTEGRATIONS.md) | WhatsApp, Razorpay, couriers, mail, Sentry — configured vs implemented. |
| [FILE_OWNERSHIP.md](FILE_OWNERSHIP.md) | Who owns what, duplication classification rules. |
| [KNOWN_ISSUES.md](KNOWN_ISSUES.md) | Open defects and uncertain files. Never delete an entry to "fix" it. |
| [AUDIT_REPORT.md](AUDIT_REPORT.md) | Bootstrap audit, Critical → Improvement. |
| [DECISIONS.md](DECISIONS.md) | Architecture decision records. |
| [CHANGELOG.md](CHANGELOG.md) | What changed, when, by whom. |
| [TASK_STATE.md](TASK_STATE.md) | Live task ledger. Update it as you work. |
| [ERROR_RECOVERY.md](ERROR_RECOVERY.md) | The trace-from-first-failure protocol. |
| [AGENT_PROTOCOL.md](AGENT_PROTOCOL.md) | Workflow, orchestration, mandatory report format. |
| [AGENT_HANDOFF.md](AGENT_HANDOFF.md) | How to hand work to the next agent or session. |
| [CLAUDE_MASTER.md](CLAUDE_MASTER.md) | Claude-specific operating instructions. |
| [GEMINI_MASTER.md](GEMINI_MASTER.md) | Gemini-specific operating instructions. |
| [agents/](agents/) | Twelve specialist role briefs. |

## 5. Truth hierarchy — what to believe when documents disagree

1. **The code and the schema file**, read today. Highest authority.
2. **This `AI/` tree**, which cites `path:line` for every claim.
3. [`AGENTS.md`](../AGENTS.md) — authoritative for **process, design system and UI rules**.
4. [`GEMINI.md`](../GEMINI.md), [`CONTRIBUTING.md`](../CONTRIBUTING.md), [`docs/`](../docs/) — partly aspirational.
5. [`MASTER_ARCHITECTURE_AUDIT.md`](../MASTER_ARCHITECTURE_AUDIT.md) — **known to be inaccurate.**
   It claims 21 tables including `brands`, `attributes`, `settings`, `activity_logs`, `wallets`,
   `wallet_transactions`, `quotations`, `order_status_history` that the live schema does not create,
   and modal filenames that do not exist. Treat it as a wish list, not a description.

## 6. Verified quick facts

- Tracked files: **983 PHP, 213 JS, 171 CSS, 50 MD, 9 SQL, 7 YML, 3 .htaccess**.
- `DT Brand/` holds **452 tracked PHP files**; `DT Brand/admin/` alone holds **362**.
- Admin guard coverage: **358 of 362** admin PHP files include `admin/Includes/adminguard.php`;
  the four that do not are the login/logout endpoints, which is correct.
- Git root is `C:\Users\sai\Desktop\WhatsApp CRM` — **one level above** `DT Brand/`. Pathspecs in
  `git diff` must be prefixed `DT Brand/` or run from the root.
