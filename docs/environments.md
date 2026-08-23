# Staging & Production Deployment Environments

## 1. Staging Environment (`staging`)

- **Host:** `staging.jaihanumantex.in`
- **Database:** `u602484543_arniya_staging`
- **Purpose:** Pre-production regression testing, UX verification, automated E2E test runs.
- **Protection Rules:** Auto-deployed from `main` after CI passes.

## 2. Production Environment (`production`)

- **Host:** `jaihanumantex.in` (147.93.99.134)
- **Database:** `u602484543_arniya`
- **Purpose:** Live customer, wholesale partner, and reseller traffic.
- **Protection Rules:**
  - Mandatory manual approval from `@dtbrand`
  - Restrict deployments to protected release tags / `main`
  - Mandatory pre-deploy snapshot creation
  - Automated post-deploy smoke testing
