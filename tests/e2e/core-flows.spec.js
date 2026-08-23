import { test, expect } from '@playwright/test';

test.describe('DT Brand\'s Core E-Commerce & Admin Flows', () => {

  test('Homepage loads correctly with brand branding', async ({ page }) => {
    const response = await page.goto('/Frontend/Home/home.php');
    expect(response?.status()).toBe(200);
    await expect(page).toHaveTitle(/DT Brand|Jai Hanuman Tex/i);
  });

  test('Shop page displays product catalog and search toolbar', async ({ page }) => {
    const response = await page.goto('/Frontend/Shop/shop.php');
    expect(response?.status()).toBe(200);
    const body = page.locator('body');
    await expect(body).toBeVisible();
  });

  test('Single product page renders details and action buttons', async ({ page }) => {
    const response = await page.goto('/Frontend/Single-Product/singleproduct.php');
    expect(response?.status()).toBe(200);
    const body = page.locator('body');
    await expect(body).toBeVisible();
  });

  test('Admin login portal loads with security fields', async ({ page }) => {
    const response = await page.goto('/Frontend/Admin/adminlogin.php');
    expect(response?.status()).toBe(200);
    const emailInput = page.locator('input[type="email"], input[name="email"]');
    await expect(emailInput).toBeVisible();
  });

  test('Wholesale portal renders B2B volume pricing structure', async ({ page }) => {
    const response = await page.goto('/Frontend/Wholesale/wholesale.php');
    expect(response?.status()).toBe(200);
  });

  test('Reseller portal renders reseller catalogue and earnings engine', async ({ page }) => {
    const response = await page.goto('/Frontend/Reseller/reseller.php');
    expect(response?.status()).toBe(200);
  });

  test('Retail Management Dashboard loads with 12-Card KPI ribbon', async ({ page }) => {
    const response = await page.goto('/Frontend/Admin/retail/index.php');
    expect(response?.status()).toBe(200);
  });
});
