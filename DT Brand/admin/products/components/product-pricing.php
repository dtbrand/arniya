<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * product-pricing.php — Pricing Studio
 * DT Brand's & Jai Hanuman Tex
 *
 * products holds four price columns: mrp, retail_price, wholesale_price and
 * reseller_price. This section used to expose only three inputs - Price, Sale
 * Price and "Purchase Price" - so wholesale_price was fed a cost figure and
 * reseller_price had no field at all: the saver read #pFormWholesale and
 * #pFormReseller, which did not exist on any page, and fell back to a hardcoded
 * 1399 and retail x 0.70 for every product ever added.
 *
 * There is no cost column in the schema, so a purchase price cannot be stored;
 * the markup helper below uses it as a live calculator input only and it is
 * never saved.
 */
$fmt = static function ($v) {
    return (isset($v) && (float)$v > 0) ? (string)(float)$v : '';
};
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
            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormMrp">MRP &#8377;</label>
                <input type="number" min="0" step="1" id="pFormMrp" class="adm-form-input" placeholder="e.g. 6500"
                       value="<?php echo htmlspecialchars($fmt($prod['mrp'] ?? null)); ?>"
                       oninput="if (window.calcPricePreview) window.calcPricePreview();">
                <small style="font-size:10.5px; color:#646970;">Struck-through price. Leave blank for no discount badge.</small>
            </div>

            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormRetail">Retail Selling Price &#8377; <span style="color:#b32d2e;">*</span></label>
                <input type="number" min="0" step="1" id="pFormRetail" class="adm-form-input" style="font-weight:700; color:#181512;"
                       placeholder="e.g. 4899" required
                       value="<?php echo htmlspecialchars($fmt($prod['retail_price'] ?? null)); ?>"
                       oninput="if (window.calcPricePreview) window.calcPricePreview();">
                <small style="font-size:10.5px; color:#646970;">What a retail customer pays.</small>
            </div>
            <div class="adm-form-group" id="pGroupCustomerPrice" style="<?php echo ($pfSellingType ?? 'single_piece') === 'full_set' ? 'display:none;' : ''; ?>">
                <label class="adm-form-label" for="pFormCustomerPrice">Customer Price &#8377; <span style="font-size:10.5px; color:#8A681F; font-weight:700;">(Single Piece)</span></label>
                <input type="number" min="0" step="1" id="pFormCustomerPrice" class="adm-form-input" placeholder="e.g. 4899"
                       value="<?php echo htmlspecialchars($fmt($prod['customer_price'] ?? null)); ?>"
                       <?php echo ($pfSellingType ?? 'single_piece') === 'full_set' ? 'disabled' : ''; ?>
                       oninput="if (window.calcPricePreview) window.calcPricePreview();">
                <small style="font-size:10.5px; color:#646970;">Customer-facing price for Guest &amp; Retail Customer. Blank falls back to Retail Selling Price.</small>
            </div>

            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormWholesale">Wholesale Price &#8377;</label>
                <input type="number" min="0" step="1" id="pFormWholesale" class="adm-form-input" placeholder="e.g. 1399"
                       value="<?php echo htmlspecialchars($fmt($prod['wholesale_price'] ?? null)); ?>"
                       oninput="if (window.calcPricePreview) window.calcPricePreview();">
                <small style="font-size:10.5px; color:#646970;">Shown to approved wholesale accounts. Blank means no trade discount.</small>
            </div>

            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormReseller">Reseller Price &#8377;</label>
                <input type="number" min="0" step="1" id="pFormReseller" class="adm-form-input" placeholder="e.g. 2100"
                       value="<?php echo htmlspecialchars($fmt($prod['reseller_price'] ?? null)); ?>"
                       oninput="if (window.calcPricePreview) window.calcPricePreview();">
                <small style="font-size:10.5px; color:#646970;">Shown to approved resellers. Blank means no reseller discount.</small>
            </div>

            <div class="adm-form-group full" id="pGroupFullSetPriceNote" style="<?php echo ($pfSellingType ?? 'single_piece') === 'full_set' ? '' : 'display:none;'; ?> background:#FFFBEB; border:1px solid #FCD34D; border-radius:6px; padding:10px 14px;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#B45309" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <span style="font-size:11.5px; font-weight:700; color:#92400E;">Full Set Selling Mode Active: Customer Price is disabled. Full Set is exclusively sold to Retailers and Wholesalers at Wholesale/Trade pricing.</span>
                </div>
            </div>

            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormCost">Purchase Cost &#8377; <span style="font-weight:400; color:#646970;">(calculator only)</span></label>
                <input type="number" min="0" step="1" id="pFormCost" class="adm-form-input" placeholder="e.g. 800"
                       oninput="dtSuggestFromCost(this.value)">
                <small style="font-size:10.5px; color:#646970;">The schema has no cost column, so this is not saved. It only suggests prices below.</small>
            </div>

            <div class="adm-form-group">
                <label class="adm-form-label">Live margin</label>
                <div style="display:flex; gap:10px; align-items:center; padding:9px 0;">
                    <span id="pPrevDiscount" style="font-size:11.5px; font-weight:800; color:#8A681F;">0% Off</span>
                    <span id="pPrevMargin" style="font-size:11.5px; font-weight:700; color:#646970;">Margin needs a cost</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
/** Surat trade markup ladder, kept from the original pricing helper. */
function dtCustomerMarkup(cost) {
    if (cost < 500) { return 200; }
    if (cost <= 1200) { return 300; }
    if (cost <= 2000) { return 400; }
    return 500;
}

/**
 * Suggest prices from a purchase cost. Only empty fields are filled: the old
 * version overwrote whatever the admin had already typed into Price and Sale
 * Price on every keystroke in the cost box.
 */
function dtSuggestFromCost(costVal) {
    var cost = parseFloat(costVal) || 0;
    if (cost <= 0) { return; }

    var sale = cost + dtCustomerMarkup(cost);
    var mrp = Math.round((sale * 1.25) / 10) * 10;
    var retailEl = document.getElementById('pFormRetail');
    var mrpEl = document.getElementById('pFormMrp');

    if (retailEl && !retailEl.value) { retailEl.value = sale; }
    if (mrpEl && !mrpEl.value) { mrpEl.value = mrp; }
    if (window.calcPricePreview) { window.calcPricePreview(); }
}

// The AI-paste helper in product-form.php calls this name.
window.calculateCustomerSalePrice = dtSuggestFromCost;
</script>
