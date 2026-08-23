# GitHub Rulesets & Branch Protection Architecture

## 1. Branch Ruleset Targets

- **Target Branches:** `main`, `production`, `release/*`

## 2. Enforcement Rules

1. **Pull Request Required:** Direct commits to `main` and `production` are restricted.
2. **Required Approvals:** Minimum 1 peer review approval from designated CODEOWNERS.
3. **Required Status Checks:**
   - `PHP Quality, Static Analysis & Unit Tests` (must pass)
   - `Frontend Linters, Formatting & Playwright UI` (must pass)
   - `CodeQL Static Security Analysis` (must pass)
4. **Block Force Pushing:** `force_push: false` strictly enforced.
5. **Block Deletions:** `deletion: false` strictly enforced.
6. **Linear Git History:** Require linear merge / squash commits.
