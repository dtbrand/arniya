# DT Brand's Automated UI Regression Testing Framework

## 1. Overview

The UI Regression System uses Playwright and axe-core to prevent accidental regressions during code updates.

## 2. Test Execution

```bash
npm run test:ui
# or
npx playwright test tests/e2e/ui-regression.spec.js
```

## 3. Verified UI Standards

- Left sidebar active states and hover indicators
- 100% styled action buttons (Radiant Gold, Obsidian Hero, Emerald WhatsApp, Pale Gold)
- Form inputs Gold & Platinum animated focus lines
- Desktop, Tablet, and Mobile auto-sizing grids with zero horizontal overflow
- Verified Rupee (`₹`) SVG rendering across all price cards
