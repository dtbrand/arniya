# Master Branch Protection Standard

## Protection Hierarchy

1. `main` Branch:
   - Requires PR before merging
   - Requires status checks to pass before merging
   - Dismiss stale pull request approvals when new commits are pushed
   - Require review from Code Owners
   - Do not allow bypassing the above settings

2. Deployment Gate:
   - Merges to `main` trigger CI pipeline
   - Deployment to production requires approved tag or manual workflow dispatch approval
