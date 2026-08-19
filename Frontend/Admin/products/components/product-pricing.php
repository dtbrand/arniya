<?php
/**
 * product-pricing.php — Pricing Studio (Price, Sale Price, Purchase Price)
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" style="color:#8A681F;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
            <span>Product Pricing</span>
        </h3>
        <span class="adm-badge gold" style="font-size:11px; padding:2px 8px;">
            ⚡ Auto-Markup Rule Active (&lt;500: +200 | 500-1200: +300 | 1200-2000: +400 | 2000+: +500)
        </span>
    </div>
    <div class="dt-form-sec-body">
        
        <!-- Only 3 Master Price Fields -->
        <div class="adm-form-grid">
            <!-- 1. Price (MRP / Regular) -->
            <div class="adm-form-group">
                <label class="adm-form-label">Price ₹ (Regular / MRP) <span style="color:#b32d2e;">*</span></label>
                <input type="number" id="pFormMrp" class="adm-form-input" placeholder="e.g. 3490" value="3490">
                <small style="color:#646970; font-size:11px; margin-top:3px; display:block;">Printed benchmark Maximum Retail Price</small>
            </div>

            <!-- 2. Sale Price (Customer Price) -->
            <div class="adm-form-group">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <label class="adm-form-label" style="margin:0;">Sale Price ₹ (Customer Price) <span style="color:#b32d2e;">*</span></label>
                    <span id="custMarkupBadge" class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10px; padding:1px 5px;">+₹500 Added</span>
                </div>
                <input type="number" id="pFormRetail" class="adm-form-input" style="font-weight:700; color:#181512;" placeholder="e.g. 2600" value="2600">
                <small id="custPriceFormulaHint" style="color:#15803D; font-size:11px; margin-top:3px; display:block;">Customer Price: Purchase ₹2,100 + ₹500</small>
            </div>

            <!-- 3. Purchase Price (Cost) -->
            <div class="adm-form-group">
                <label class="adm-form-label">Purchase Price ₹ (Weaving / Cost) <span style="color:#b32d2e;">*</span></label>
                <input type="number" id="pFormCost" class="adm-form-input" placeholder="e.g. 2100" value="2100" oninput="calculateCustomerSalePrice(this.value)">
                <small style="color:#646970; font-size:11px; margin-top:3px; display:block;">Base manufacturing / procurement cost</small>
            </div>
        </div>

        <!-- Profit Margin Summary Card -->
        <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.4); border-radius:4px; padding:10px 14px; margin-top:12px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
            <div style="font-size:12px;">
                <span style="color:#7A7266;">Estimated Gross Profit:</span>
                <strong id="marginGrossText" style="color:#15803D; margin-left:4px;">₹500 / pc (19.2% Margin)</strong>
            </div>
            <div style="font-size:12px;">
                <span style="color:#7A7266;">Customer Discount vs MRP:</span>
                <strong id="marginDiscountText" style="color:#8A681F; margin-left:4px;">25.5% Off</strong>
            </div>
            <div style="font-size:12px;">
                <span style="color:#7A7266;">GST Slab:</span>
                <strong>5% Included (HSN 5007)</strong>
            </div>
        </div>
    </div>
</div>

<script>
/**
 * Smart Customer Pricing Formula:
 * - Below 500      => +200
 * - 500 to 1200   => +300
 * - 1200 to 2000  => +400
 * - Above 2000    => +500
 */
function getCustomerMarkup(cost) {
    if (cost < 500) return 200;
    if (cost <= 1200) return 300;
    if (cost <= 2000) return 400;
    return 500;
}

function calculateCustomerSalePrice(costVal) {
    const cost = parseFloat(costVal) || 0;
    if (cost <= 0) return;

    // 1. Customer Sale Price (Auto Markup)
    const markup = getCustomerMarkup(cost);
    const salePrice = cost + markup;

    // 2. Price (MRP / Regular - approx 35% above sale price)
    const price = Math.round((salePrice * 1.35) / 10) * 10;

    // Set values into inputs
    document.getElementById('pFormRetail').value = salePrice;
    document.getElementById('pFormMrp').value = price;

    // Update hints & badges
    const badge = document.getElementById('custMarkupBadge');
    if (badge) badge.textContent = `+₹${markup} Added`;

    const hint = document.getElementById('custPriceFormulaHint');
    if (hint) hint.textContent = `Customer Price: Purchase ₹${cost.toLocaleString('en-IN')} + ₹${markup}`;

    // Update Profit Summary
    const profit = salePrice - cost;
    const profitPct = ((profit / salePrice) * 100).toFixed(1);
    document.getElementById('marginGrossText').textContent = `₹${profit} / pc (${profitPct}% Margin)`;

    const discount = price - salePrice;
    const discountPct = ((discount / price) * 100).toFixed(1);
    document.getElementById('marginDiscountText').textContent = `${discountPct}% Off (₹${discount} saved)`;
}
</script>
