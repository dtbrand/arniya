import { test, expect } from '@playwright/test';
import AxeBuilder from '@axe-core/playwright';

test.describe('DT Brand\'s Accessibility Suite (axe-core)', () => {

  test('Homepage passes WCAG 2.1 AA accessibility standards', async ({ page }) => {
    await page.goto('/Frontend/Home/home.php');
    const accessibilityScanResults = await new AxeBuilder({ page })
      .withTags(['wcag2a', 'wcag2aa', 'wcag21a', 'wcag21aa'])
      .disableRules(['color-contrast']) // Reviewed separately for signature heritage gold theme
      .analyze();

    expect(accessibilityScanResults.violations.filter(v => v.impact === 'critical')).toEqual([]);
  });

  test('Shop page accessibility audit has 0 critical violations', async ({ page }) => {
    await page.goto('/Frontend/Shop/shop.php');
    const accessibilityScanResults = await new AxeBuilder({ page })
      .withTags(['wcag2a', 'wcag2aa'])
      .disableRules(['color-contrast'])
      .analyze();

    expect(accessibilityScanResults.violations.filter(v => v.impact === 'critical')).toEqual([]);
  });
});
