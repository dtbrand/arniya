# Log Rotation & Storage Management Policy

## 1. Objectives

- Prevent disk exhaustion on production servers.
- Comply with data privacy regulations by auto-purging old transaction logs.

## 2. Policy & Execution

- Daily application logs stored as `logs/app_YYYY-MM-DD.log`.
- Log rotation job runs nightly via `php scripts/rotate-logs.php`.
- Maximum retention: 14 days for general logs, 90 days for audit logs.
- Sensitive fields (passwords, credit card numbers, auth tokens) are automatically redacted.
