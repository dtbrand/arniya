<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * product-pricing.php — Ultra-Clean Minimalist Pricing Studio
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
                <input type="number" id="pFormMrp" class="adm-form-input" placeholder="e.g. 1000" value="<?php echo isset($prod['mrp']) ? (float)$prod['mrp'] : 1000; ?>">
            </div>

            <!-- 2. Sale Price -->
            <div class="adm-form-group">
                <label class="adm-form-label">Sale Price ₹ <span style="color:#b32d2e;">*</span></label>
                <input type="number" id="pFormRetail" class="adm-form-input" style="font-weight:700; color:#181512;" placeholder="e.g. 900" value="<?php echo isset($prod['retail_price']) ? (float)$prod['retail_price'] : 900; ?>">
            </div>

            <!-- 3. Purchase Price -->
            <div class="adm-form-group">
                <label class="adm-form-label">Purchase Price ₹ <span style="color:#b32d2e;">*</span></label>
                <input type="number" id="pFormCost" class="adm-form-input" placeholder="e.g. 800" value="<?php echo isset($prod['wholesale_price']) ? (float)$prod['wholesale_price'] : 800; ?>" oninput="calculateCustomerSalePrice(this.value)">
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
    const price = Math.round((salePrice * 1.25) / 10) * 10;

    document.getElementById('pFormRetail').value = salePrice;
    document.getElementById('pFormMrp').value = price;
}
</script>
