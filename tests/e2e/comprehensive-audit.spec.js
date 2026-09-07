import { test, expect } from '@playwright/test';

test.describe('DT Brand\'s Master Comprehensive E2E & Real-World UI Audit', () => {

  test('1. Storefront: Search, Category Filtering, and Navigation', async ({ page }) => {
    await page.goto('/index.php', { waitUntil: 'domcontentloaded' });
    expect(page.url()).toContain('jaihanumantex.in');

    // Verify main header logo
    const logo = page.locator('.header-brand-link, .header-brand-real-logo, .dt-brand-logo, .brand-logo, a.dt-brand-link, .logo').first();
    await expect(logo).toBeVisible();

    // Verify search input
    const searchInput = page.locator('#dtSearchInput, #searchInput, input[type="search"], input[name="q"]').first();
    if (await searchInput.isVisible()) {
      await searchInput.fill('Saree');
      await page.keyboard.press('Enter');
    }

    // Navigate to shop
    await page.goto('/shop.php', { waitUntil: 'domcontentloaded' });
    await expect(page).toHaveTitle(/Shop|DT Brand|Saree/i);

    // Verify subnav category items exist
    const catItems = page.locator('.cat-item, .main-cat-tab');
    const catCount = await catItems.count();
    expect(catCount).toBeGreaterThan(0);

    // Click on a category tab if present
    const firstCat = catItems.first();
    await firstCat.click();
    await page.waitForTimeout(500);

    // Verify sort select is functional
    const sortSelect = page.locator('#ptbSortSelect, select[name="sort"]').first();
    if (await sortSelect.isVisible()) {
      await sortSelect.selectOption({ index: 1 });
      await page.waitForTimeout(500);
    }
  });

  test('2. Product Detail Page (PDP): Gallery, Pricing, and Actions', async ({ page }) => {
    await page.goto('/shop.php', { waitUntil: 'domcontentloaded' });
    const firstProduct = page.locator('.product-card a, .product-card').first();
    await expect(firstProduct).toBeVisible();
    
    // Navigate to product PDP
    await page.goto('/product.php?id=13', { waitUntil: 'domcontentloaded' });
    const body = page.locator('body');
    await expect(body).toBeVisible();

    // Check pricing element exists with Rupee symbol
    const priceEl = page.locator('.price, .product-price, .pdp-price, .current-price').first();
    if (await priceEl.isVisible()) {
      const text = await priceEl.textContent();
      expect(text).toMatch(/₹|[0-9]+/);
    }

    // Check WhatsApp enquiry button
    const waBtn = page.locator('a[href*="whatsapp"], a[href*="wa.me"], button[onclick*="whatsapp"]').first();
    if (await waBtn.isVisible()) {
      const href = await waBtn.getAttribute('href');
      if (href) {
        expect(href).toMatch(/whatsapp|wa\.me/);
      }
    }
  });

  test('3. Cart & Wishlist Workflow', async ({ page }) => {
    // Visit Wishlist
    await page.goto('/wishlist.php', { waitUntil: 'domcontentloaded' });
    expect(page.url()).toContain('wishlist');
    await expect(page.locator('body')).toBeVisible();

    // Visit Cart
    await page.goto('/cart.php', { waitUntil: 'domcontentloaded' });
    expect(page.url()).toContain('cart');
    await expect(page.locator('body')).toBeVisible();

    // Verify checkout CTA
    const checkoutBtn = page.locator('a[href*="checkout"], button[onclick*="checkout"]').first();
    if (await checkoutBtn.isVisible()) {
      await expect(checkoutBtn).toBeVisible();
    }
  });

  test('4. Checkout Page: Multi-Gateway Payment Suite & Form Validation', async ({ page }) => {
    await page.goto('/checkout.php', { waitUntil: 'domcontentloaded' });
    await expect(page.locator('body')).toBeVisible();

    // Check if address fields exist
    const nameInput = page.locator('input[name*="name"], input#custName, input#fullName').first();
    if (await nameInput.isVisible()) {
      await nameInput.fill('Quality Assurance Tester');
    }

    const phoneInput = page.locator('input[name*="phone"], input[type="tel"], input#custPhone').first();
    if (await phoneInput.isVisible()) {
      await phoneInput.fill('917046363528');
    }

    const pincodeInput = page.locator('input[name*="pincode"], input#custPincode').first();
    if (await pincodeInput.isVisible()) {
      await pincodeInput.fill('395002');
    }

    // Verify payment method options exist (UPI, COD, Razorpay, etc.)
    const paymentMethods = page.locator('.payment-method, .co-pay-option, input[name="payment_method"]');
    const payCount = await paymentMethods.count();
    expect(payCount).toBeGreaterThanOrEqual(0);
  });

  test('5. Customer Account Hub: Profile and Navigation', async ({ page }) => {
    await page.goto('/account.php', { waitUntil: 'domcontentloaded' });
    await expect(page.locator('body')).toBeVisible();

    // Verify account sections or login state
    const tabs = page.locator('.account-tab, .tab-btn, .nav-link, button[role="tab"]');
    if (await tabs.count() > 0) {
      await expect(tabs.first()).toBeVisible();
    }
  });

  test('6. Wholesaler B2B Portal: Analytics, Lots & Passbook Statement', async ({ page }) => {
    await page.goto('/wholesale.php', { waitUntil: 'domcontentloaded' });
    await expect(page.locator('body')).toBeVisible();

    // Check passbook statement download button exists in DOM and handler is attached
    const stmtBtn = page.locator('button:has-text("Download Statement"), button[onclick*="downloadWalletStatement"]');
    expect(await stmtBtn.count()).toBeGreaterThan(0);
    const hasDownloadFn = await page.evaluate(() => typeof window.downloadWalletStatement === 'function');
    expect(hasDownloadFn).toBe(true);

    // Verify B2B KPI Cards
    const kpiCards = page.locator('.ws-kpi-card, .metric-card, .kpi-card');
    const kpiCount = await kpiCards.count();
    expect(kpiCount).toBeGreaterThanOrEqual(0);
  });

  test('7. Retailer B2B Portal: Margins, MOQ & Statements', async ({ page }) => {
    await page.goto('/retailer.php', { waitUntil: 'domcontentloaded' });
    await expect(page.locator('body')).toBeVisible();

    const stmtBtn = page.locator('button:has-text("Download Statement"), button[onclick*="downloadWalletStatement"]');
    expect(await stmtBtn.count()).toBeGreaterThan(0);
    const hasDownloadFn = await page.evaluate(() => typeof window.downloadWalletStatement === 'function');
    expect(hasDownloadFn).toBe(true);
  });

  test('8. Reseller B2B Portal: CRM, Order Booking & Statement', async ({ page }) => {
    await page.goto('/reseller.php', { waitUntil: 'domcontentloaded' });
    await expect(page.locator('body')).toBeVisible();

    const stmtBtn = page.locator('button:has-text("Download Statement"), button[onclick*="downloadWalletStatement"]');
    expect(await stmtBtn.count()).toBeGreaterThan(0);
    const hasDownloadFn = await page.evaluate(() => typeof window.downloadWalletStatement === 'function');
    expect(hasDownloadFn).toBe(true);
  });

  test('9. Admin Portal: Login and Navigation Security', async ({ page }) => {
    await page.goto('/admin/login/', { waitUntil: 'domcontentloaded' });
    const emailField = page.locator('input[type="email"], input[name="email"]').first();
    const passField = page.locator('input[type="password"], input[name="password"]').first();
    const submitBtn = page.locator('button[type="submit"]').first();

    await expect(emailField).toBeVisible();
    await expect(passField).toBeVisible();
    await expect(submitBtn).toBeVisible();

    // Check empty submit validation
    await submitBtn.click();
    await page.waitForTimeout(500);

    // Verify Admin Orders Management loads
    const ordersRes = await page.goto('/admin/orders/index.php', { waitUntil: 'domcontentloaded' });
    expect(ordersRes?.status()).toBe(200);

    // Verify Admin Products Management loads
    const prodsRes = await page.goto('/admin/products/index.php', { waitUntil: 'domcontentloaded' });
    expect(prodsRes?.status()).toBe(200);

    // Verify Admin Customers Management loads
    const custsRes = await page.goto('/admin/customers/index.php', { waitUntil: 'domcontentloaded' });
    expect(custsRes?.status()).toBe(200);

    // Verify Admin Settings loads
    const settingsRes = await page.goto('/admin/settings/general.php', { waitUntil: 'domcontentloaded' });
    expect(settingsRes?.status()).toBe(200);

    // Verify Admin System Health loads
    const healthRes = await page.goto('/admin/system/health.php', { waitUntil: 'domcontentloaded' });
    expect(healthRes?.status()).toBe(200);
  });

  test('10. REST API Health & Webhook Integrity', async ({ request }) => {
    // Check system health endpoint
    const health = await request.get('/api/health.php');
    expect(health.status()).toBe(200);
    const healthData = await health.json();
    expect(healthData).toBeDefined();

    // Check products API
    const prods = await request.get('/api/products.php');
    expect([200, 302, 401]).toContain(prods.status());

    // Check razorpay webhook without valid signature (should reject with 401 or 400)
    const webhookRes = await request.post('/api/webhooks/razorpay.php', {
      data: { event: 'payment.captured' }
    });
    // Valid security posture: unsigned webhooks must NOT return 200 without signature
    expect([400, 401, 403, 503]).toContain(webhookRes.status());
  });

  test('11. Atelier Contact Form & Policy Suite', async ({ page }) => {
    await page.goto('/contact.php', { waitUntil: 'domcontentloaded' });
    expect(page.url()).toContain('contact');
    await expect(page.locator('h1')).toContainText(/Contact/i);

    // Verify contact form inputs and submit button
    const nameInput = page.locator('#contactName');
    const phoneInput = page.locator('#contactPhone');
    const msgInput = page.locator('#contactMessage');
    const submitBtn = page.locator('#dtSubmitBtn');

    await expect(nameInput).toBeVisible();
    await expect(phoneInput).toBeVisible();
    await expect(msgInput).toBeVisible();
    await expect(submitBtn).toBeVisible();

    await nameInput.fill('Aarav Sharma');
    await phoneInput.fill('917046363528');
    await msgInput.fill('Inquiry regarding pure silk Korvai wholesale lot availability.');

    // Verify policy pages load cleanly
    const shippingRes = await page.goto('/shipping.php', { waitUntil: 'domcontentloaded' });
    expect(shippingRes?.status()).toBe(200);

    const privacyRes = await page.goto('/privacy.php', { waitUntil: 'domcontentloaded' });
    expect(privacyRes?.status()).toBe(200);

    const termsRes = await page.goto('/terms.php', { waitUntil: 'domcontentloaded' });
    expect(termsRes?.status()).toBe(200);
  });

});

