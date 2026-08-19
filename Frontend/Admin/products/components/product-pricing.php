<?php
/**
 * product-pricing.php — Multi-Tier Pricing Schedule
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head">
        <h3 class="dt-form-sec-title"><span>🏷️ Multi-Tier Pricing Schedule</span></h3>
    </div>
    <div class="dt-form-sec-body">
        <div class="adm-form-grid">
            <div class="adm-form-group">
                <label class="adm-form-label">MRP (Maximum Retail Price) ₹</label>
                <input type="number" id="pFormMrp" class="adm-form-input" placeholder="e.g. 5990" value="5990" oninput="if(typeof calcPricePreview==='function') calcPricePreview();">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">B2C Retail Selling Price ₹ *</label>
                <input type="number" id="pFormRetail" class="adm-form-input" placeholder="e.g. 4490" value="4490" oninput="if(typeof calcPricePreview==='function') calcPricePreview();">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Reseller Base Price ₹ *</label>
                <input type="number" class="adm-form-input" placeholder="e.g. 3450" value="3450">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Wholesale Price (MOQ 8+ pcs) ₹ *</label>
                <input type="number" id="pFormWholesale" class="adm-form-input" placeholder="e.g. 2850" value="2850" oninput="if(typeof calcPricePreview==='function') calcPricePreview();">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Bulk Mill Lot Price (MOQ 30+ pcs) ₹</label>
                <input type="number" class="adm-form-input" placeholder="e.g. 2650" value="2650">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Weaving Cost Price ₹</label>
                <input type="number" id="pFormCost" class="adm-form-input" placeholder="e.g. 2100" value="2100" oninput="if(typeof calcPricePreview==='function') calcPricePreview();">
            </div>
        </div>

        <div class="dt-calc-price-card">
            <div class="dt-calc-row">
                <span>Discount on MRP:</span>
                <strong id="pPrevDiscount" style="color:#15803D;">25% Off</strong>
            </div>
            <div class="dt-calc-row">
                <span>Estimated Gross Margin:</span>
                <strong id="pPrevMargin" style="color:#8A681F;">53% Margin</strong>
            </div>
            <div class="dt-calc-row">
                <span>GST Tax Slab:</span>
                <strong>5% Included (HSN 5007)</strong>
            </div>
        </div>
    </div>
</div>
