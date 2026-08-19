<?php
/**
 * product-pricing.php — Ultra-Clean Pricing Studio (Price, Sale Price, Purchase Price)
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" style="color:#8A681F;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
            <span>Product Pricing</span>
        </h3>
    </div>
    <div class="dt-form-sec-body">
        <div class="adm-form-grid">
            <!-- 1. Price -->
            <div class="adm-form-group">
                <label class="adm-form-label">Price ₹ <span style="color:#b32d2e;">*</span></label>
                <input type="number" id="pFormMrp" class="adm-form-input" placeholder="e.g. 1490" value="1490">
            </div>

            <!-- 2. Sale Price -->
            <div class="adm-form-group">
                <label class="adm-form-label">Sale Price ₹ <span style="color:#b32d2e;">*</span></label>
                <input type="number" id="pFormRetail" class="adm-form-input" style="font-weight:700; color:#181512;" placeholder="e.g. 1100" value="1100">
            </div>

            <!-- 3. Purchase Price -->
            <div class="adm-form-group">
                <label class="adm-form-label">Purchase Price ₹ <span style="color:#b32d2e;">*</span></label>
                <input type="number" id="pFormCost" class="adm-form-input" placeholder="e.g. 800" value="800" oninput="calculateCustomerSalePrice(this.value)">
            </div>
        </div>

        <!-- Margin Summary Card -->
        <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.4); border-radius:4px; padding:10px 14px; margin-top:12px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
            <div style="font-size:12px;">
                <span style="color:#7A7266;">Estimated Gross Profit:</span>
                <strong id="marginGrossText" style="color:#15803D; margin-left:4px;">₹300 / pc (27.3% Margin)</strong>
            </div>
            <div style="font-size:12px;">
                <span style="color:#7A7266;">Customer Discount:</span>
                <strong id="marginDiscountText" style="color:#8A681F; margin-left:4px;">26.2% Off (₹390 saved)</strong>
            </div>
            <div style="font-size:12px;">
                <span style="color:#7A7266;">GST Slab:</span>
                <strong>5% Included (HSN 5007)</strong>
            </div>
        </div>
    </div>
</div>

<script>
function getCustomerMarkup(cost) {
    if (cost < 500) return 200;
    if (cost <= 1200) return 300;
    if (cost <= 2000) return 400;
    return 500;
}

function calculateCustomerSalePrice(costVal) {
    const cost = parseFloat(costVal) || 0;
    if (cost <= 0) return;

    const markup = getCustomerMarkup(cost);
    const salePrice = cost + markup;
    const price = Math.round((salePrice * 1.35) / 10) * 10;

    document.getElementById('pFormRetail').value = salePrice;
    document.getElementById('pFormMrp').value = price;

    const profit = salePrice - cost;
    const profitPct = ((profit / salePrice) * 100).toFixed(1);
    document.getElementById('marginGrossText').textContent = `₹${profit} / pc (${profitPct}% Margin)`;

    const discount = price - salePrice;
    const discountPct = ((discount / price) * 100).toFixed(1);
    document.getElementById('marginDiscountText').textContent = `${discountPct}% Off (₹${discount} saved)`;
}
</script>
