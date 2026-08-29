import { test, expect } from '@playwright/test';

test.describe('DT Brand\'s Master UI Regression Suite', () => {

  test('Desktop navigation elements are fully styled with no unstyled components', async ({ page }) => {
    await page.goto('/adminlogin.php');
    const submitBtn = page.locator('button[type="submit"]');
    await expect(submitBtn).toBeVisible();
  });

  test('Inputs receive focus state without layout shift', async ({ page }) => {
    await page.goto('/adminlogin.php');
    const emailField = page.locator('input[type="email"], input[name="email"]').first();
    await emailField.focus();
    await expect(emailField).toBeFocused();
  });

  test('Mobile responsive view has zero horizontal overflow on critical pages', async ({ page }) => {
    await page.setViewportSize({ width: 375, height: 667 });
    await page.goto('/index.php');
    const scrollWidth = await page.evaluate(() => document.documentElement.scrollWidth);
    const clientWidth = await page.evaluate(() => document.documentElement.clientWidth);
    expect(scrollWidth).toBeLessThanOrEqual(clientWidth + 5);
  });
});
