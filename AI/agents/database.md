# AGENT BRIEF · DATABASE

> **Scope:** `DT Brand/database/` — the schema, the migrator and the migration files — plus every SQL
> statement anywhere in the tree. The classes that issue them are [backend.md](backend.md).
>
> Read with [DATABASE.md](../DATABASE.md) and [KNOWN_ISSUES.md](../KNOWN_ISSUES.md) KI-1, KI-2, KI-4.

---

## 1. There is exactly one authority, and three files that look like one

| File | What it actually is |
| :--- | :--- |
| **`database/arniya_master_production.sql`** | **the live schema + every seed row. 18 tables.** The only authority |
| `database/migrate.php` | the migrator the owner runs on live — it executes **that one file and nothing else** |
| `database/migrations/2026_08_25_production_upgrade.sql` | **never runs.** Its columns are phantom |
| `database/migrations/2026_08_23_000001_create_initial_schema.sql` | GEN-A era, never adopted |
| `database/migrations/2026_08_24_000001_full_production_schema.sql` | GEN-A era, never adopted |
| `database/schema.sql` · `database/seeders.sql` | earlier drafts |

**The trap is that `migrate.php::status()` lists all three migration files as `PENDING_OR_APPLIED`**, so it
reads as though they ran. They did not. Any "Unknown column" on live that you can find in the repository is
almost always this (KI-4).

```bash
grep -c 'CREATE TABLE' "DT Brand/database/arniya_master_production.sql"
```

**Which of these has actually run on live is unresolved** and needs `SHOW TABLES` from the owner. That one
unanswered question is behind KI-4, KI-8 and KI-19. Until it is answered, treat
`arniya_master_production.sql` as the truth and any column found only elsewhere as absent.

`arniya_master_production.sql` is also **web-served with no deny rule** — SEC-4.

## 2. Absolute prohibitions

1. **No `DROP`. No `TRUNCATE`. No `DELETE` without a `WHERE`.** No exceptions, no "just the demo rows" —
   the `id IN (1,2,3)` seed cleanup in KI-1 is deliberately unrun for exactly this reason.
2. **No schema change without the owner's explicit authorisation and a written impact analysis**, and
   every schema change ships with the instruction to run `php database/migrate.php` on live. FTP does not
   carry the database ([DEPLOYMENT.md](../DEPLOYMENT.md)).
3. **No credential value in any output** — file, line and variable name only. Fallbacks live at
   `src/Database.php:23-27`, `config/database.php:16`, `database/migrate.php:20-24` and `:162`,
   `api/db_health.php:31-34` (SEC-1), and none may be removed before the owner confirms the env vars
   resolve (D-7).
4. **`api/db_audit.php` creates 16 tables** when run, and `api/db_health.php` seeds rows. Neither is a
   read-only diagnostic; treat both as write paths (KI-2).

## 3. Query rules that are specific to this schema

1. **`!=` is NULL-unsafe** and several status columns are nullable. Write
   `COALESCE(\`fulfillment_status\`, 'unfulfilled') <> 'cancelled'`, not `fulfillment_status != 'cancelled'`
   — the second silently drops every NULL row from a revenue total.
2. **Whitelist every ENUM before writing it.** Outside strict mode MySQL coerces an unknown value to `''`
   and `execute()` still returns `true`: a silent blank reported as success. `CustomerManager` does this at
   `:132`, `:139`, `:239-244`, `:315`.
3. **Disambiguate `rowCount() === 0`.** It means *either* "no such row" *or* "the value already matched".
   Only the second is success — `CustomerManager:264-270`, `:329-337`, `:361-367`.
4. **Never interpolate a column or table name.** Fixed whitelist, as in `priceColumnFor()`
   (`OrderManager.php:118-127`).
5. **`[]` is ambiguous.** `Database::query()` returns it for an empty table and for a dead database. Gate on
   `$db !== null && !Database::isMockMode()` before treating an empty result as a fact (D-5).
6. **A status filter must use the real ENUM.** `ProductCatalog::PUBLIC_STATUSES` is
   `in_stock,low_stock,out_of_stock`. Filtering on `status != 'trash'` passes **everything**, because
   `trash` is not in the ENUM — that is how drafts reach the storefront.

## 4. Tables that exist and are never written, and one that does not exist at all

- **`wishlist_items` is never written** (KI-5) and **`addresses` is never written** (KI-6) — the features
  that appear to use them store state in the browser.
- **There is no `settings` table.** `admin/settings/index.php:40` reports `"Saved locally!"` for a write
  that lands nowhere, and commit `0f01c6c` claims the opposite (KI-8).
- Several admin features are blocked on schema that does not exist — per-product channel visibility,
  per-parcel weight and dimensions (KI-19). Report them; do not add columns to make them work.

## 5. If a write went wrong

**Stop.** Do not issue a compensating `UPDATE` — that is a second unverified write on unknown state. Report
the statement, the parameters, the table and the row count. A recovery that mutates data needs the owner's
explicit authorisation **and** a dump taken first, and the owner runs it.
[ERROR_RECOVERY.md](../ERROR_RECOVERY.md) §5.

Remember the blast radius of one order write: it decrements stock (`OrderManager.php:453`) and increments
`total_orders` / `lifetime_spend` (`:456-466`). A mistaken order also moves inventory and customer lifetime
value.

## 6. Verification

```bash
/c/xampp/php/php.exe -l "DT Brand/database/migrate.php"
```

**There is no MySQL in this environment.** No query, migration, index or constraint can be executed here —
nothing in this domain is runtime-verifiable (KI-22). Say that plainly, hand the owner the exact SQL to run,
and ask for the output rather than assuming it.

