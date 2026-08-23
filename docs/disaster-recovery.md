# DT Brand's & Jai Hanuman Tex — Disaster Recovery Runbook

## 1. Incident Escalation Levels

- **P1 (System Down):** Complete loss of website or checkout. Recovery SLA: < 15 minutes.
- **P2 (Degraded Performance):** Slow response times, third-party API timeout. Recovery SLA: < 1 hour.
- **P3 (Minor Issue):** Non-blocking UI glitch or reporting error. Recovery SLA: < 24 hours.

## 2. Emergency Recovery Steps

1. **Declare Incident:** Notify lead architect and lock production deployments (`deployment freeze`).
2. **Diagnose Source:** Check `/health.php` and `scripts/uptime-check.php`.
3. **Rollback if Caused by Deploy:** Deploy previous build artifact via FTP / GitHub Actions.
4. **Database Restoration:** If database corruption occurred, execute `php scripts/restore-test.php` and apply snapshot.
5. **Post-Recovery Verification:** Run `php scripts/smoke-test.php` and confirm 100% test pass.
6. **Lift Deployment Freeze & Postmortem:** File incident report in `docs/incidents/`.
