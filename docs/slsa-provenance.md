# SLSA (Supply-chain Levels for Software Artifacts) Framework Standard

## 1. SLSA Level 2 / 3 Compliance Strategy

- **Source Integrity:** All changes originate from cryptographically verified Git commits via GitHub PRs with required CODEOWNERS approvals.
- **Build Service:** Build artifacts are produced deterministically inside isolated GitHub Actions runners (`ubuntu-latest`).
- **Provenance Generation:** Build artifacts receive tamper-evident cryptographic attestations signed by GitHub OIDC tokens.
- **Dependency Pinning:** Dependencies and Actions are pinned to immutable commit SHAs.
