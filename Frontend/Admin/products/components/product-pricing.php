<?php
/**
 * product-pricing.php — Multi-Tier Pricing Schedule
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
            <span>Multi-Tier Pricing Schedule</span>
        </h3>
    </div>
    <div class="dt-form-sec-body">
        <div class="adm-form-grid">
            <div class="adm-form-group">
                <label class="adm-form-label">MRP (Maximum Retail Price) ₹</label>
                <input type="number" id="pFormMrp" class="adm-form-input" placeholder="e.g. 5990" value="5990" oninput="if(typeof calcPricePreview==='function') calcPricePreview();">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">B2C Retail Selling Price ₹ <span style="color:#b32d2e;">*</span></label>
                <input type="number" id="pFormRetail" class="adm-form-input" placeholder="e.g. 4490" value="4490" oninput="if(typeof calcPricePreview==='function') calcPricePreview();">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Reseller Base Price ₹ <span style="color:#b32d2e;">*</span></label>
                <input type="number" class="adm-form-input" placeholder="e.g. 3450" value="3450">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Wholesale Price (MOQ 8+ pcs) ₹ <span style="color:#b32d2e;">*</span></label>
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

        <div class="dt-calc-price-card" style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.4); border-radius:4px; padding:10px; margin-top:10px;">
            <div class="dt-calc-row" style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px;">
                <span>Discount on MRP:</span>
                <strong id="pPrevDiscount" style="color:#15803D;">25% Off</strong>
            </div>
            <div class="dt-calc-row" style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px;">
                <span>Estimated Gross Margin:</span>
                <strong id="pPrevMargin" style="color:#8A681F;">53% Margin</strong>
            </div>
            <div class="dt-calc-row" style="display:flex; justify-content:space-between; font-size:12px;">
                <span>GST Tax Slab:</span>
                <strong>5% Included (HSN 5007)</strong>
            </div>
        </div>
    </div>
</div>
