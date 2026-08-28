---
description: Autonomous Agent Protocol — Task lifecycle, scope discipline, root cause first
---

# 🤖 DT Brand's Autonomous Agent Execution Protocol

Based on [AI/AGENT_PROTOCOL.md](file:///c:/Users/sai/Desktop/WhatsApp%20CRM/AI/AGENT_PROTOCOL.md):

## 1. The 6-Stage Task Lifecycle (Mandatory Order)
UNDERSTAND ➔ LOCATE ➔ PLAN ➔ CHANGE ➔ VERIFY ➔ REPORT

1. **UNDERSTAND**: Restate the request in one sentence. Understand Hindi/Hinglish instructions and auto-correct typos silently. Write 100% professional English in code, UI, and commits.
2. **LOCATE**: Locate files by full absolute path, not basename. Read the file before modifying it.
3. **PLAN**: Name every file to be changed and anticipate side-effects.
4. **CHANGE**: Make the smallest correct change matching existing surrounding style (
amespace DTBrand;, static methods, parameterized PDO).
5. **VERIFY**: Lint with PHP CLI (php -l), check for 0 undefined variables and 0 syntax errors. Run automated tests where applicable.
6. **REPORT**: Deliver concise summaries with Triple-Sync verification status.

## 2. Strict Scope Discipline
- **No silent narrowing**: Never skip requested features or leave half-baked stubs.
- **No silent widening**: Do not rewrite unrelated files or change color themes without explicit request.
- **Root cause first**: Always trace from the original error.
