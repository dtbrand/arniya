<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * product-pricing.php — Pricing Studio (B2B Trade vs. Customer & Less-Amount Sale Discount)
 * DT Brand's & Jai Hanuman Tex — Master Wholesale & Retail Standard
 */
$fmt = static function ($v) {
    return (isset($v) && (float)$v > 0) ? (string)(float)$v : '';
};
$isFullSetMode = ($pfSellingType ?? 'single_piece') === 'full_set';
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
    <div class="dt-form-sec-body" style="display:flex; flex-direction:column; gap:12px;">

        <!-- ══ 1. B2B TRADE CHANNEL PRICING ══ -->
        <div style="background:#FAF8F5; border:1px solid #EAE5D9; border-radius:8px; padding:12px 14px;">
            <div style="font-size:11px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.4px; margin-bottom:10px; display:flex; align-items:center; gap:6px;">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                <span>B2B Trade Channel Pricing (Retailer &bull; Wholesaler &bull; Reseller)</span>
            </div>

            <div class="adm-form-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:12px;">
                <!-- 1. B2B Trade Base Price -->
                <div class="adm-form-group">
                    <label class="adm-form-label" for="pFormRetail" style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:4px;">
                        <span style="font-weight:800; white-space:nowrap;" id="pLabelRetailText"><?= $isFullSetMode ? 'Full Set Price &#8377;' : 'Price &#8377;' ?> <span style="color:#DC2626;">*</span></span>
                        <span id="pBadgeRetail" style="font-size:9.5px; font-weight:800; color:#8A681F; background:#FAF5E8; border:1px solid #D4AF37; padding:1px 6px; border-radius:3px; white-space:nowrap; text-transform:none;">
                            <?= $isFullSetMode ? 'Retailer &amp; Wholesaler Rate' : 'B2B Trade Rate' ?>
                        </span>
                    </label>
                    <input type="number" min="0" step="1" id="pFormRetail" class="adm-form-input" style="font-weight:800; color:#181512; font-size:13px;"
                           placeholder="e.g. 500" required
                           value="<?php echo htmlspecialchars($fmt($prod['retail_price'] ?? ($prod['price'] ?? null))); ?>"
                           oninput="if (window.calcPricePreview) window.calcPricePreview();">
                    <small style="font-size:10px; color:#64748B;" id="pHelpRetail">
                        <?= $isFullSetMode ? 'Master rate for Boutique Retailers and Wholesalers.' : 'Master B2B trade rate for Retailers (Boutique), Wholesalers &amp; Resellers.' ?>
                    </small>
                </div>

                <!-- 2. Sale Price Discount (Flat Less Amount) -->
                <div class="adm-form-group">
                    <label class="adm-form-label" for="pFormSalePrice" style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:4px;">
                        <span style="font-weight:700; color:#B45309; white-space:nowrap;">Sale Discount &#8377;</span>
                        <span style="font-size:9.5px; font-weight:800; color:#B45309; background:#FEF3C7; padding:1px 6px; border-radius:3px; white-space:nowrap; text-transform:none;">Flat Less</span>
                    </label>
                    <input type="number" min="0" step="1" id="pFormSalePrice" class="adm-form-input" style="font-weight:700; color:#B45309;"
                           placeholder="e.g. 50 (deducts ₹50 off)"
                           value="<?php echo htmlspecialchars($fmt($prod['sale_price'] ?? null)); ?>"
                           oninput="if (window.calcPricePreview) window.calcPricePreview();">
                    <small style="font-size:10px; color:#64748B;">Flat deduction deducted from B2B Trade &amp; Customer Price.</small>
                </div>
            </div>
        </div>

        <!-- ══ 2. RETAIL CONSUMER PRICING & MRP VALUATION ══ -->
        <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:12px 14px;">
            <div style="font-size:11px; font-weight:800; color:#1E293B; text-transform:uppercase; letter-spacing:0.4px; margin-bottom:10px; display:flex; align-items:center; gap:6px;">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#15803D" stroke-width="2.2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                <span>Retail Consumer Pricing &amp; Struck-Through MRP</span>
            </div>

            <!-- Full Set Notice Banner -->
            <div id="pGroupFullSetPriceNote" style="<?php echo $isFullSetMode ? '' : 'display:none;'; ?> margin-bottom:10px; background:#FFFBEB; border:1px solid #FCD34D; border-radius:6px; padding:8px 12px;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#B45309" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <span style="font-size:11px; font-weight:700; color:#92400E;">Full Set Mode Active: Retail Customer &amp; Reseller access is disabled. Full Sets are sold exclusively to Retailers (Boutique) and Wholesalers at B2B Trade pricing.</span>
                </div>
            </div>

            <div class="adm-form-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(230px, 1fr)); gap:12px;">
                <!-- 5. Customer Price (For Guest & Retail End Consumers) -->
                <div class="adm-form-group" id="pGroupCustomerPrice" style="<?php echo $isFullSetMode ? 'display:none;' : ''; ?>">
                    <label class="adm-form-label" for="pFormCustomerPrice" style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:4px;">
                        <span style="font-weight:700; color:#15803D; white-space:nowrap;">Customer Price &#8377;</span>
                        <span style="font-size:9.5px; font-weight:800; color:#15803D; background:#DCFCE7; padding:1px 6px; border-radius:3px; white-space:nowrap; text-transform:none;">Guest &amp; End Consumer</span>
                    </label>
                    <input type="number" min="0" step="1" id="pFormCustomerPrice" class="adm-form-input" style="font-weight:700; color:#15803D; font-size:13px;"
                           placeholder="e.g. 800"
                           value="<?php echo htmlspecialchars($fmt($prod['customer_price'] ?? null)); ?>"
                           <?php echo $isFullSetMode ? 'disabled' : ''; ?>
                           oninput="if (window.calcPricePreview) window.calcPricePreview();">
                    <small style="font-size:10px; color:#64748B;">Customer shopping price. Defaults to Trade Price if blank.</small>
                </div>

                <!-- 6. Customer Sale Price (For Guest & Retail End Consumers) -->
                <div class="adm-form-group" id="pGroupCustomerSalePrice" style="<?php echo $isFullSetMode ? 'display:none;' : ''; ?>">
                    <label class="adm-form-label" for="pFormCustomerSalePrice" style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:4px;">
                        <span style="font-weight:700; color:#15803D; white-space:nowrap;">Customer Sale Price &#8377;</span>
                        <span style="font-size:9.5px; font-weight:800; color:#15803D; background:#DCFCE7; padding:1px 6px; border-radius:3px; white-space:nowrap; text-transform:none;">Retail Sale Offer</span>
                    </label>
                    <input type="number" min="0" step="1" id="pFormCustomerSalePrice" class="adm-form-input" style="font-weight:700; color:#15803D; font-size:13px;"
                           placeholder="e.g. 750"
                           value="<?php echo htmlspecialchars($fmt($prod['customer_sale_price'] ?? null)); ?>"
                           <?php echo $isFullSetMode ? 'disabled' : ''; ?>
                           oninput="if (window.calcPricePreview) window.calcPricePreview();">
                    <small style="font-size:10px; color:#64748B;">Special discounted retail price. Precedes flat discount if set.</small>
                </div>

                <!-- 7. MRP (Maximum Retail Struck-through Price) -->
                <div class="adm-form-group">
                    <label class="adm-form-label" for="pFormMrp" style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:4px;">
                        <span style="font-weight:700; white-space:nowrap;">MRP &#8377;</span>
                        <span style="font-size:9.5px; font-weight:700; color:#64748B; background:#F1F5F9; padding:1px 6px; border-radius:3px; white-space:nowrap; text-transform:none;">Struck-Through</span>
                    </label>
                    <input type="number" min="0" step="1" id="pFormMrp" class="adm-form-input" placeholder="e.g. 1200"
                           value="<?php echo htmlspecialchars($fmt($prod['mrp'] ?? null)); ?>"
                           oninput="if (window.calcPricePreview) window.calcPricePreview();">
                    <small style="font-size:10px; color:#64748B;">Shown with strike-through for discount badge.</small>
                </div>
            </div>
        </div>

        <!-- ══ 3. LIVE 5-ROLE REAL-TIME VALUATION & MARGIN RIBBON ══ -->
        <div id="dtLiveRolePricingBreakdown" style="background:linear-gradient(135deg, #181512 0%, #2A241E 100%); border:1.5px solid #D4AF37; border-radius:8px; padding:10px 14px; color:#FAF5E8; box-shadow:0 3px 12px rgba(0,0,0,0.25);">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; border-bottom:1px solid rgba(212,175,55,0.25); padding-bottom:8px; margin-bottom:10px;">
                <div style="display:flex; align-items:center; gap:6px;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#D4AF37" stroke-width="2.4"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                    <span style="font-size:11.5px; font-weight:800; color:#FAF5E8; letter-spacing:0.2px;">LIVE 5-ROLE PRICE &amp; MARGIN BREAKDOWN</span>
                </div>
                <div id="pPrevDiscountBadge" style="font-size:10.5px; font-weight:800; color:#181512; background:#E6CA65; padding:2px 8px; border-radius:4px;">
                    Standard Rate
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
