# GitHub Secrets Architecture & Governance

## 1. Repository Secrets

- `FTP_HOST`: Production FTP server IP/Hostname (`147.93.99.134`)
- `FTP_USERNAME`: Production FTP user (`u602484543.jaihanumantex.in`)
- `FTP_PASSWORD`: Production FTP password (Managed in GitHub Secrets only)
- `GH_PAT`: Fine-grained Personal Access Token for automation and releases

## 2. Environment Secrets (`production`)

- `PROD_DB_HOST`: MySQL host endpoint
- `PROD_DB_USER`: Production database username
- `PROD_DB_PASS`: Production database password
- `PROD_DB_NAME`: Production database name (`u602484543_arniya`)

## 3. Secret Safety Mandates

- NEVER commit secrets or credentials directly into code or configuration files.
- Mask all secret outputs in CI/CD logs.
- Rotate sensitive secrets every 90 days.
