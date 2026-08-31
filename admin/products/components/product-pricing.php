<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * product-pricing.php — Pricing Studio (B2B Trade vs. Customer & Less-Amount Sale Discount)
 * DT Brand's & Jai Hanuman Tex — Master Wholesale & Retail Standard
 */
$fmt = static function ($v) {
    return (isset($v) && (float)$v > 0) ? (string)(float)$v : '';
};
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head" style="display:flex; justify-content:space-between; align-items:center;">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.4" style="color:#8A681F;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
            <span>Product Pricing Studio</span>
        </h3>
        <span style="font-size:10px; font-weight:700; color:#8A681F; background:#FAF5E8; border:1px solid #D4AF37; padding:2px 8px; border-radius:4px;">
            B2B Trade &amp; Customer Matrix
        </span>
    </div>
    <div class="dt-form-sec-body">
        <div class="adm-form-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(210px, 1fr)); gap:12px;">
            
            <!-- 1. B2B Trade Base Price (Price Column) -->
            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormRetail">
                    Price &#8377; <span style="font-size:10px; font-weight:800; color:#8A681F;">(B2B Trade / Retailer / Reseller)</span> <span style="color:#b32d2e;">*</span>
                </label>
                <input type="number" min="0" step="1" id="pFormRetail" class="adm-form-input" style="font-weight:800; color:#181512; font-size:13px;"
                       placeholder="e.g. 500" required
                       value="<?php echo htmlspecialchars($fmt($prod['retail_price'] ?? ($prod['price'] ?? null))); ?>"
                       oninput="if (window.calcPricePreview) window.calcPricePreview();">
                <small style="font-size:10px; color:#64748B;">For Retailers (Boutique &amp; Small Shop), Resellers &amp; Wholesalers.</small>
            </div>

            <!-- 2. Customer Price (For Guest & Retail End Consumers) -->
            <div class="adm-form-group" id="pGroupCustomerPrice" style="<?php echo ($pfSellingType ?? 'single_piece') === 'full_set' ? 'display:none;' : ''; ?>">
                <label class="adm-form-label" for="pFormCustomerPrice">
                    Customer Price &#8377; <span style="font-size:10px; font-weight:800; color:#15803D;">(Guest &amp; End Consumer)</span>
                </label>
                <input type="number" min="0" step="1" id="pFormCustomerPrice" class="adm-form-input" style="font-weight:700; color:#15803D; font-size:13px;"
                       placeholder="e.g. 800"
                       value="<?php echo htmlspecialchars($fmt($prod['customer_price'] ?? null)); ?>"
                       <?php echo ($pfSellingType ?? 'single_piece') === 'full_set' ? 'disabled' : ''; ?>
                       oninput="if (window.calcPricePreview) window.calcPricePreview();">
                <small style="font-size:10px; color:#64748B;">Customer-facing shopping price. If blank, uses Trade Price.</small>
            </div>

            <!-- 3. Sale Price Discount (Flat Less Amount: 20, 30, 50, 100) -->
            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormSalePrice">
                    Sale Price Discount &#8377; <span style="font-size:10px; font-weight:700; color:#B45309;">(Flat Less Amount)</span>
                </label>
                <input type="number" min="0" step="1" id="pFormSalePrice" class="adm-form-input" style="font-weight:700; color:#B45309;"
                       placeholder="e.g. 50 (deducts ₹50 off)"
                       value="<?php echo htmlspecialchars($fmt($prod['sale_price'] ?? null)); ?>"
                       oninput="if (window.calcPricePreview) window.calcPricePreview();">
                <small style="font-size:10px; color:#64748B;">Flat deduction deducted from Price and Customer Price.</small>
            </div>

            <!-- 4. MRP (Maximum Retail Struck-through Price) -->
            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormMrp">MRP &#8377; <span style="font-size:10px; font-weight:500; color:#64748B;">(Struck-through)</span></label>
                <input type="number" min="0" step="1" id="pFormMrp" class="adm-form-input" placeholder="e.g. 1200"
                       value="<?php echo htmlspecialchars($fmt($prod['mrp'] ?? null)); ?>"
                       oninput="if (window.calcPricePreview) window.calcPricePreview();">
                <small style="font-size:10px; color:#64748B;">Shown with strike-through for discount badge.</small>
            </div>

            <!-- 5. Wholesale Bulk Tier (Optional) -->
            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormWholesale">Wholesale Bulk Tier &#8377; <span style="font-size:10px; color:#64748B;">(Optional)</span></label>
                <input type="number" min="0" step="1" id="pFormWholesale" class="adm-form-input" placeholder="e.g. 480"
                       value="<?php echo htmlspecialchars($fmt($prod['wholesale_price'] ?? null)); ?>"
                       oninput="if (window.calcPricePreview) window.calcPricePreview();">
                <small style="font-size:10px; color:#64748B;">Bulk lots rate. Defaults to B2B Price if blank.</small>
            </div>

            <!-- 6. Reseller Tier (Optional) -->
            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormReseller">Reseller Tier &#8377; <span style="font-size:10px; color:#64748B;">(Optional)</span></label>
                <input type="number" min="0" step="1" id="pFormReseller" class="adm-form-input" placeholder="e.g. 500"
                       value="<?php echo htmlspecialchars($fmt($prod['reseller_price'] ?? null)); ?>"
                       oninput="if (window.calcPricePreview) window.calcPricePreview();">
                <small style="font-size:10px; color:#64748B;">Dropship reseller rate. Defaults to B2B Price if blank.</small>
            </div>
        </div>

        <!-- Full Set Notice Banner -->
        <div id="pGroupFullSetPriceNote" style="<?php echo ($pfSellingType ?? 'single_piece') === 'full_set' ? '' : 'display:none;'; ?> margin-top:10px; background:#FFFBEB; border:1px solid #FCD34D; border-radius:6px; padding:8px 12px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#B45309" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <span style="font-size:11px; font-weight:700; color:#92400E;">Full Set Mode Active: Customer Price is disabled. Full Sets are sold exclusively to Retailers (Boutique) and Wholesalers at Trade pricing.</span>
            </div>
        </div>

        <!-- ══ 5-ROLE REAL-TIME LIVE VALUATION & MARGIN RIBBON ══ -->
        <div id="dtLiveRolePricingBreakdown" style="margin-top:12px; background:linear-gradient(135deg, #181512 0%, #2A241E 100%); border:1.5px solid #D4AF37; border-radius:8px; padding:10px 14px; color:#FAF5E8; box-shadow:0 3px 12px rgba(0,0,0,0.25);">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; border-bottom:1px solid rgba(212,175,55,0.25); padding-bottom:8px; margin-bottom:10px;">
                <div style="display:flex; align-items:center; gap:6px;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#D4AF37" stroke-width="2.4"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                    <span style="font-size:11.5px; font-weight:800; color:#FAF5E8; letter-spacing:0.2px;">LIVE 5-ROLE PRICE &amp; MARGIN BREAKDOWN</span>
                </div>
                <div id="pPrevDiscountBadge" style="font-size:10.5px; font-weight:800; color:#181512; background:#E6CA65; padding:2px 8px; border-radius:4px;">
                    Regular Rate
                </div>
            </div>

            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(140px, 1fr)); gap:10px; align-items:center;">
                <!-- 1. Customer / Guest -->
                <div style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); border-radius:6px; padding:8px 10px;">
                    <div style="font-size:9.5px; font-weight:700; color:#A1A1AA; text-transform:uppercase;">Customer &amp; Guest</div>
                    <div id="dispCustPrice" style="font-size:15px; font-weight:800; color:#34D399; margin-top:2px;">&#8377;0</div>
                    <div id="dispCustSub" style="font-size:9.5px; color:#D1D5DB;">No discount</div>
                </div>

                <!-- 2. Retailer (Boutique / Small Shop) -->
                <div style="background:rgba(212,175,55,0.12); border:1.2px solid #D4AF37; border-radius:6px; padding:8px 10px;">
                    <div style="font-size:9.5px; font-weight:800; color:#FCD34D; text-transform:uppercase;">Retailer (Boutique)</div>
                    <div id="dispRetailerPrice" style="font-size:15px; font-weight:800; color:#FCD34D; margin-top:2px;">&#8377;0</div>
                    <div id="dispRetailerSub" style="font-size:9.5px; color:#FAF5E8;">B2B Trade Rate</div>
                </div>

                <!-- 3. Reseller -->
                <div style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); border-radius:6px; padding:8px 10px;">
                    <div style="font-size:9.5px; font-weight:700; color:#A1A1AA; text-transform:uppercase;">Reseller</div>
                    <div id="dispResellerPrice" style="font-size:15px; font-weight:800; color:#FAF5E8; margin-top:2px;">&#8377;0</div>
                    <div id="dispResellerSub" style="font-size:9.5px; color:#D1D5DB;">Dropship Rate</div>
                </div>

                <!-- 4. Wholesaler -->
                <div style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); border-radius:6px; padding:8px 10px;">
                    <div style="font-size:9.5px; font-weight:700; color:#A1A1AA; text-transform:uppercase;">Wholesaler</div>
                    <div id="dispWholesalePrice" style="font-size:15px; font-weight:800; color:#FAF5E8; margin-top:2px;">&#8377;0</div>
                    <div id="dispWholesaleSub" style="font-size:9.5px; color:#D1D5DB;">Bulk Lot Rate</div>
                </div>

                <!-- 5. Boutique / Retailer Profit Margin -->
                <div style="background:rgba(16,185,129,0.15); border:1px solid #10B981; border-radius:6px; padding:8px 10px;">
                    <div style="font-size:9.5px; font-weight:800; color:#6EE7B7; text-transform:uppercase;">Boutique Margin</div>
                    <div id="dispBoutiqueMargin" style="font-size:15px; font-weight:800; color:#6EE7B7; margin-top:2px;">&#8377;0/pc</div>
                    <div id="dispMarginPercent" style="font-size:9.5px; color:#A7F3D0;">0% Margin</div>
                </div>
            </div>
        </div>
    </div>
</div>
