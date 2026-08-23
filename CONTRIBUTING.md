# Contributing to DT Brand's & Jai Hanuman Tex

Thank you for contributing to the DT Brand's enterprise commerce platform!

## 1. Development Workflow
1. Fork / create a feature branch (`feat/feature-name` or `fix/bug-name`).
2. Follow the [AGENTS.md](AGENTS.md) and [GEMINI.md](GEMINI.md) quality rules:
   - Inter & Plus Jakarta Sans sharp typography stack
   - Indian Rupee (`₹`) SVG standard — Zero `$` icons
   - 100% styled buttons (Radiant Gold / Emerald / Obsidian)
   - Running Gold & Platinum animated focus lines on inputs
3. Ensure all automated linters and tests pass:
   ```bash
   composer test
   npm run lint:js
   npm run lint:css
   npm run format:check
   npx playwright test
   ```
4. Commit using Conventional Commits (`feat:`, `fix:`, `docs:`, `refactor:`).
5. Open a Pull Request referencing the issue.
