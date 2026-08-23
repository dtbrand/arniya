# OpenID Connect (OIDC) Cloud Authentication Architecture

## 1. Overview

GitHub Actions supports OpenID Connect (OIDC) to securely exchange ephemeral tokens with cloud providers (AWS, GCP, Azure, Cloudflare) without hardcoding long-lived access keys.

## 2. Configuration Pattern

```yaml
permissions:
  id-token: write
  contents: read

steps:
  - name: Authenticate with Cloud Provider via OIDC
    uses: aws-actions/configure-aws-credentials@v4 # or google-github-actions/auth
    with:
      role-to-assume: arn:aws:iam::123456789012:role/GitHubActionRole
      aws-region: ap-south-1
```

## 3. Trust Policy

The cloud IAM role trust policy must restrict access to:

- `sub`: `repo:dtbrand/arniya:ref:refs/heads/main`
- `aud`: `https://token.actions.githubusercontent.com`
