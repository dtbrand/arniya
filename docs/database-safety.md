# DT Brand's Database Safety & Migration Governance Standard

## 1. Core Principles

- **Zero Destructive Production Operations**: `DROP TABLE`, `TRUNCATE`, and destructive column removals are strictly forbidden on production.
- **Mandatory Pre-Migration Backup**: Before applying any schema update or large data modification, an instant snapshot must be verified via `scripts/backup-database.php`.
- **Dry-Run Validation**: Every migration must be tested via dry-run simulation before execution.

## 2. Migration Protocol

1. **Local Authoring**: Write idempotent SQL scripts inside `database/migrations/YYYY_MM_DD_HHMMSS_description.sql`.
2. **Schema Verification**: Validate constraints, indexes, data types, and foreign key rules.
3. **Staging Execution**: Run on staging replica to measure query execution time and lock contention.
4. **Rollback Plan**: Every migration script must have an accompanying rollback procedure.

## 3. Disaster Recovery & Rollback

- In the event of a migration anomaly, immediately execute the rollback SQL or restore from the pre-migration snapshot.
- Verify table row counts and checksums post-restore.
