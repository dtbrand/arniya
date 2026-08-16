---
description: Browser Preview Rule — Only open browser/agent preview when explicitly requested by user
---

# Browser Preview Rule

- **DO NOT** automatically launch `browser_subagent` or open browser previews upon making code changes.
- **ONLY** open browser preview / browser subagent when the user explicitly requests it (e.g. "preview karo", "browser me check karo", "open preview", "test in browser").
- For all other tasks, perform syntax validation (e.g. PHP CLI linting `php -l`), commit and push to git, and report results concisely without popping up the browser.
