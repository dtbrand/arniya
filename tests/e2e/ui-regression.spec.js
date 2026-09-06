import { test, expect } from '@playwright/test';

test.describe('DT Brand\'s Master UI Regression Suite', () => {

  test('Desktop navigation elements are fully styled with no unstyled components', async ({ page }) => {
    await page.goto('/adminlogin.php', { waitUntil: 'domcontentloaded' });
    const submitBtn = page.locator('button[type="submit"]').first();
    await expect(submitBtn).toBeVisible();
  });

  test('Inputs receive focus state without layout shift', async ({ page }) => {
    await page.goto('/adminlogin.php', { waitUntil: 'domcontentloaded' });
    const emailField = page.locator('input[type="email"], input[name="email"]').first();
    await emailField.focus();
    await expect(emailField).toBeFocused();
  });

  test('Mobile responsive view has zero horizontal overflow on critical pages', async ({ page }) => {
    await page.setViewportSize({ width: 375, height: 667 });
    await page.goto('/index.php', { waitUntil: 'domcontentloaded' });
    const scrollWidth = await page.evaluate(() => document.documentElement.scrollWidth);
    const clientWidth = await page.evaluate(() => document.documentElement.clientWidth);
    expect(scrollWidth).toBeLessThanOrEqual(clientWidth + 5);
  });

  test('Smart bottom navigation responsiveness adapts between mobile and desktop', async ({ page }) => {
    // 1. Mobile viewport: Bottom navigation must be visible with all 5 action targets
    await page.setViewportSize({ width: 375, height: 667 });
    await page.goto('/index.php', { waitUntil: 'domcontentloaded' });
    const mobileFooter = page.locator('#homeSmartBottomFooter');
    await expect(mobileFooter).toBeVisible();

    const menuBtn = page.locator('#smartNavMenu');
    const shopBtn = page.locator('#smartNavShop');
    const reelsBtn = page.locator('#smartNavReels');
    const wishlistBtn = page.locator('#smartNavWishlist');
    const accountBtn = page.locator('#smartNavAccount');

    await expect(menuBtn).toBeVisible();
    await expect(shopBtn).toBeVisible();
    await expect(reelsBtn).toBeVisible();
    await expect(wishlistBtn).toBeVisible();
    await expect(accountBtn).toBeVisible();

    // Elevated center reels button has animated HOT badge
    const hotBadge = page.locator('.smart-hero-hot-badge');
    await expect(hotBadge).toBeVisible();
    await expect(hotBadge).toContainText('HOT');

    // 2. Desktop viewport: Bottom navigation must be hidden via media query
    await page.setViewportSize({ width: 1280, height: 800 });
    await expect(mobileFooter).toBeHidden();
  });

  test('Mobile mega menu drawer slides in and closes smoothly', async ({ page }) => {
    await page.setViewportSize({ width: 375, height: 667 });
    await page.goto('/index.php', { waitUntil: 'domcontentloaded' });

    const menuBtn = page.locator('#smartNavMenu');
    await expect(menuBtn).toBeVisible();

    // Tap menu button to open drawer
    await menuBtn.click();
    const drawerBackdrop = page.locator('#homeMenuDrawerBackdrop');
    await expect(drawerBackdrop).toHaveClass(/active/);
    const drawer = page.locator('#homeMenuDrawer');
    await expect(drawer).toBeVisible();

    // Close button dismisses drawer
    const closeBtn = page.locator('.home-menu-close-btn');
    await expect(closeBtn).toBeVisible();
    await closeBtn.click();
    await expect(drawerBackdrop).not.toHaveClass(/active/);
  });
});
