# Database Backup & Retention Policy

## 1. Schedule

- **Hourly Automated Snapshots:** Managed via Hostinger CPanel / MySQL automatic backup runner.
- **Pre-Deploy Snapshots:** Executed via `scripts/backup-database.php` prior to any code or schema deployment.

## 2. Retention Policy

- Hourly snapshots retained for 72 hours
- Daily snapshots retained for 30 days
- Monthly snapshots retained for 1 year
- Stored across secondary off-site encrypted storage.
