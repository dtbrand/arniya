# DT Brand's Automated & Manual Rollback Strategy

## 1. Rollback Trigger Conditions

- Smoke test failure (`scripts/smoke-test.php` returns exit code 1)
- 5xx error rate exceeds 1% in first 5 minutes post-deploy
- Critical business logic regression in cart, wholesale pricing, or checkout

## 2. Fast Rollback Procedure

1. **Immediate Traffic Halt / Reversion:**
   - Deploy last known stable release artifact from GitHub Actions / build releases: `dtbrand-release-last-stable.zip`
   - Re-sync files via FTP / deploy script to Hostinger `/public_html`
2. **Database Verification:**
   - Schema is backward compatible by default.
   - If a non-backward-compatible migration occurred, restore the pre-migration snapshot via `scripts/restore-test.php`.
3. **Post-Rollback Verification:**
   - Re-run `php scripts/smoke-test.php`.
   - Verify health endpoint at `https://jaihanumantex.in/health.php`.
