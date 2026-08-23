# Automated GitHub Releases & Changelog Standard

## 1. Conventional Commits Standard

All commits must follow Conventional Commits formatting:

- `feat(module): description` -> Triggers minor version bump (`1.1.0`)
- `fix(module): description` -> Triggers patch version bump (`1.0.1`)
- `feat(module)!: breaking change` -> Triggers major version bump (`2.0.0`)

## 2. Release Generation

Release Please reads commits on `main` and creates a Release PR with auto-generated release notes, categorized changelogs, migration notices, and version tags.
