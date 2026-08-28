# AGENT BRIEFS

> Twelve domain briefs. Each one is a working brief for a change in that domain — the files it owns, the
> facts that are load-bearing, the traps that have already cost time, and the verification that is actually
> available. They are written to be handed to a subagent whole.
>
> They do **not** restate the project. Read [MASTER.md](../MASTER.md) and
> [AGENT_PROTOCOL.md](../AGENT_PROTOCOL.md) first; a brief assumes both.

---

| Brief | Owns | Read alongside |
| :--- | :--- | :--- |
| [frontend.md](frontend.md) | the 11 storefront pages, `includes/`, `shared/`, storefront JS | [FRONTEND.md](../FRONTEND.md) |
| [backend.md](backend.md) | `src/` — 7 classes, 4,007 lines — and `config/` | [BACKEND.md](../BACKEND.md) |
| [api.md](api.md) | `api/` — 22 flat files, no router | [API.md](../API.md) |
| [database.md](database.md) | the schema, the migrator, every SQL statement | [DATABASE.md](../DATABASE.md) |
| [admin.md](admin.md) | `admin/` — 542 files, 26 modules | [ADMIN.md](../ADMIN.md) |
| [security.md](security.md) | the whole tree, through one lens | [SECURITY.md](../SECURITY.md) |
| [testing.md](testing.md) | verification, with no suite and no MySQL | [TESTING.md](../TESTING.md) |
| [performance.md](performance.md) | page weight, query count, connection behaviour | [PERFORMANCE.md](../PERFORMANCE.md) |
| [ui-ux.md](ui-ux.md) | tokens, typography, icons, CSS — 87 files | [UI_SYSTEM.md](../UI_SYSTEM.md) |
| [devops.md](devops.md) | `.htaccess`, deployment, env vars, git | [DEPLOYMENT.md](../DEPLOYMENT.md) |
| [cleanup.md](cleanup.md) | dead code, duplicates, fabricated data | [FILE_OWNERSHIP.md](../FILE_OWNERSHIP.md) §10 |
| [integration.md](integration.md) | WhatsApp, and what only looks like it exists | [INTEGRATIONS.md](../INTEGRATIONS.md) |

**Files with two owners need two briefs.** `src/OrderManager.php` (backend + api + database + security),
`src/Auth.php` (backend + security + admin), `api/orders.php` (api + admin + frontend),
`admin/Includes/adminheader.php` (admin + ui-ux + cleanup), `assets/css/main.css` and `header.css`
(frontend + admin), `config/shipping.php` (backend + business logic), `shared/quickview.php` (frontend +
business logic). The full list is [FILE_OWNERSHIP.md](../FILE_OWNERSHIP.md) §9.

**Six facts every brief assumes**, so none of them repeats it:

1. Only `DT Brand/` is live; `src/Database.php` exists twice; always write the full prefixed path (D-1).
2. No framework, DI, ORM, autoloader, build step or `.env` loader — by decision (D-2).
3. **The owner deploys.** Every task ends with the files to upload (D-8).
4. `/c/xampp/php/php.exe -l` and `node --check` are the only checks. **No MySQL here** (KI-22).
5. Show nothing rather than a plausible value (D-5).
6. Verify a reference by **full path**, excluding comments — a basename grep has been wrong three times (D-9).
