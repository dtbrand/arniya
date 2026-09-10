<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * product-pricing.php — Master Price Matrix & Role Preview Studio
 * Section 6, 17, 18, 19 & 21 — DT Brand's & Jai Hanuman Tex V2 Master Specification
 */
$fmt = static function ($v) {
    return (isset($v) && (float)$v > 0) ? (string)(float)$v : '';
};
$isFullSetMode = ($pfSellingType ?? 'single_piece') === 'full_set';
?>
<div class="dt-form-section" id="dtPricingStudioSection">
    <div class="dt-form-sec-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
        <h3 class="dt-form-sec-title" style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" style="color:#8A681F;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
            <span>Master Price Matrix Studio</span>
        </h3>
        <div style="display:flex; align-items:center; gap:6px;">
            <span id="dtPricingModeBadge" style="font-size:10px; font-weight:800; color:#8A681F; background:#FAF5E8; border:1px solid #D4AF37; padding:2px 8px; border-radius:4px; text-transform:uppercase; letter-spacing:0.3px;">
                <?= $isFullSetMode ? 'Full Set Catalog Matrix' : 'Single Piece Matrix' ?>
            </span>
        </div>
    </div>
    <div class="dt-form-sec-body" style="display:flex; flex-direction:column; gap:14px;">

        <!-- ═══════════════════════════════════════════════════════════
             1. SINGLE PIECE PRICE MATRIX (Sections 17 & 18)
        ════════════════════════════════════════════════════════════ -->
        <div id="pGroupSinglePieceMatrix" style="<?php echo $isFullSetMode ? 'display:none;' : ''; ?> display:flex; flex-direction:column; gap:12px;">

            <!-- A. Guest & Retail Customer Tier -->
            <div style="background:#FAF8F5; border:1px solid #EAE5D9; border-radius:8px; padding:12px 14px;">
                <div style="font-size:11px; font-weight:800; color:#15803D; text-transform:uppercase; letter-spacing:0.4px; margin-bottom:10px; display:flex; align-items:center; justify-content:space-between;">
                    <span style="display:flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#15803D" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span>1. Guest &amp; Retail Customer Tier</span>
                    </span>
                    <span style="font-size:9.5px; font-weight:800; color:#15803D; background:#DCFCE7; padding:1px 6px; border-radius:3px;">Consumer Shopping Rate</span>
                </div>
                <div class="adm-form-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:12px;">
                    <!-- Customer Regular Price -->
                    <div class="adm-form-group">
                        <label class="adm-form-label" for="pFormCustomerPrice" style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:4px;">
                            <span style="font-weight:700; color:#15803D;">Customer Price (&#8377;)</span>
                            <span style="font-size:9px; font-weight:700; color:#64748B;">Standard Retail</span>
                        </label>
                        <input type="number" min="0" step="1" id="pFormCustomerPrice" class="adm-form-input" style="font-weight:700; color:#15803D; font-size:13px;"
                               placeholder="e.g. 800"
                               value="<?php echo htmlspecialchars($fmt($prod['customer_price'] ?? null)); ?>"
                               oninput="if (window.calcPricePreview) window.calcPricePreview();">
                        <small style="font-size:10px; color:#64748B;">Consumer shopping price. Defaults to Retail Price if empty.</small>
                    </div>

                    <!-- Customer Sale Price -->
                    <div class="adm-form-group">
                        <label class="adm-form-label" for="pFormCustomerSalePrice" style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:4px;">
                            <span style="font-weight:700; color:#15803D;">Customer Sale Price (&#8377;)</span>
                            <span style="font-size:9px; font-weight:800; color:#15803D; background:#DCFCE7; padding:1px 6px; border-radius:3px;">Sale Offer</span>
                        </label>
                        <input type="number" min="0" step="1" id="pFormCustomerSalePrice" class="adm-form-input" style="font-weight:700; color:#15803D; font-size:13px;"
                               placeholder="e.g. 750"
                               value="<?php echo htmlspecialchars($fmt($prod['customer_sale_price'] ?? null)); ?>"
                               oninput="if (window.calcPricePreview) window.calcPricePreview();">
                        <small style="font-size:10px; color:#64748B;">Special discounted retail offer price (supersedes flat discount).</small>
                    </div>
                </div>
            </div>

            <!-- B. Retailer (Boutique) Tier & Trade Base -->
            <div style="background:#FAF8F5; border:1px solid #EAE5D9; border-radius:8px; padding:12px 14px;">
                <div style="font-size:11px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.4px; margin-bottom:10px; display:flex; align-items:center; justify-content:space-between;">
                    <span style="display:flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>2. Retailer (Boutique / Shop) Tier &bull; Master B2B Base</span>
                    </span>
                    <span style="font-size:9.5px; font-weight:800; color:#8A681F; background:#FAF5E8; border:1px solid #D4AF37; padding:1px 6px; border-radius:3px;">Trade Anchor</span>
                </div>
                <div class="adm-form-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:12px;">
                    <!-- Retailer Price / Price (Required) -->
                    <div class="adm-form-group">
                        <label class="adm-form-label" for="pFormRetail" style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:4px;">
                            <span style="font-weight:800; color:#181512;">Retailer Price (&#8377;) <span style="color:#DC2626;">*</span></span>
                            <span style="font-size:9px; font-weight:800; color:#8A681F; background:#FAF5E8; border:1px solid #D4AF37; padding:1px 6px; border-radius:3px;">Master Root</span>
                        </label>
                        <input type="number" min="0" step="1" id="pFormRetail" class="adm-form-input" style="font-weight:800; color:#181512; font-size:13px;"
                               placeholder="e.g. 500" required
                               value="<?php echo htmlspecialchars($fmt($prod['retail_price'] ?? ($prod['price'] ?? null))); ?>"
                               oninput="if (window.calcPricePreview) window.calcPricePreview();">
                        <small style="font-size:10px; color:#64748B;">Standard boutique procurement price &amp; master catalog base.</small>
                    </div>

                    <!-- Retailer Sale Price (Explicit) -->
                    <div class="adm-form-group">
                        <label class="adm-form-label" for="pFormRetailerSalePrice" style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:4px;">
                            <span style="font-weight:700; color:#B45309;">Retailer Sale Price (&#8377;)</span>
                            <span style="font-size:9px; font-weight:800; color:#B45309; background:#FEF3C7; padding:1px 6px; border-radius:3px;">B2B Offer</span>
                        </label>
                        <input type="number" min="0" step="1" id="pFormRetailerSalePrice" class="adm-form-input" style="font-weight:700; color:#B45309; font-size:13px;"
                               placeholder="e.g. 450"
                               value="<?php echo htmlspecialchars($fmt($prod['retailer_sale_price'] ?? null)); ?>"
                               oninput="if (window.calcPricePreview) window.calcPricePreview();">
                        <small style="font-size:10px; color:#64748B;">Explicit promotional rate for Retailers (leave blank to use flat discount).</small>
                    </div>

                    <!-- Flat Sale Discount -->
                    <div class="adm-form-group">
                        <label class="adm-form-label" for="pFormSalePrice" style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:4px;">
                            <span style="font-weight:700; color:#B45309;">Flat Sale Deduction (&#8377;)</span>
                            <span style="font-size:9px; font-weight:800; color:#B45309; background:#FEF3C7; padding:1px 6px; border-radius:3px;">Less Amount</span>
                        </label>
                        <input type="number" min="0" step="1" id="pFormSalePrice" class="adm-form-input" style="font-weight:700; color:#B45309; font-size:13px;"
                               placeholder="e.g. 50"
                               value="<?php echo htmlspecialchars($fmt($prod['sale_price'] ?? null)); ?>"
                               oninput="if (window.calcPricePreview) window.calcPricePreview();">
                        <small style="font-size:10px; color:#64748B;">Fallback flat deduction deducted from trade tiers without explicit sale price.</small>
                    </div>
                </div>
            </div>

            <!-- C. Reseller Tier -->
            <div style="background:#FAF8F5; border:1px solid #EAE5D9; border-radius:8px; padding:12px 14px;">
                <div style="font-size:11px; font-weight:800; color:#705114; text-transform:uppercase; letter-spacing:0.4px; margin-bottom:10px; display:flex; align-items:center; justify-content:space-between;">
                    <span style="display:flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#705114" stroke-width="2.2"><path d="M16 16v1a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v1"></path><path d="M18 8h4a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-4"></path><circle cx="8" cy="18" r="2"></circle><circle cx="18" cy="18" r="2"></circle></svg>
                        <span>3. Reseller Tier (Dropshippers / Social Resellers)</span>
                    </span>
                    <span style="font-size:9.5px; font-weight:700; color:#705114; background:#FAF5E8; border:1px solid #D4AF37; padding:1px 6px; border-radius:3px;">Dropship Rate</span>
                </div>
                <div class="adm-form-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:12px;">
                    <!-- Reseller Price -->
                    <div class="adm-form-group">
                        <label class="adm-form-label" for="pFormResellerPrice" style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:4px;">
                            <span style="font-weight:700; color:#705114;">Reseller Price (&#8377;)</span>
                            <span style="font-size:9px; font-weight:700; color:#64748B;">Base Reseller</span>
                        </label>
                        <input type="number" min="0" step="1" id="pFormResellerPrice" class="adm-form-input" style="font-weight:700; color:#705114; font-size:13px;"
                               placeholder="e.g. 450 (defaults to Retail Price)"
                               value="<?php echo htmlspecialchars($fmt($prod['reseller_price'] ?? null)); ?>"
                               oninput="if (window.calcPricePreview) window.calcPricePreview();">
                        <small style="font-size:10px; color:#64748B;">Reseller dropship rate. Defaults to Retailer Price if blank.</small>
                    </div>

                    <!-- Reseller Sale Price -->
                    <div class="adm-form-group">
                        <label class="adm-form-label" for="pFormResellerSalePrice" style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:4px;">
                            <span style="font-weight:700; color:#B45309;">Reseller Sale Price (&#8377;)</span>
                            <span style="font-size:9px; font-weight:800; color:#B45309; background:#FEF3C7; padding:1px 6px; border-radius:3px;">Sale Offer</span>
                        </label>
                        <input type="number" min="0" step="1" id="pFormResellerSalePrice" class="adm-form-input" style="font-weight:700; color:#B45309; font-size:13px;"
                               placeholder="e.g. 400"
                               value="<?php echo htmlspecialchars($fmt($prod['reseller_sale_price'] ?? null)); ?>"
                               oninput="if (window.calcPricePreview) window.calcPricePreview();">
                        <small style="font-size:10px; color:#64748B;">Explicit promotional rate for verified Resellers.</small>
                    </div>
                </div>
            </div>

            <!-- D. Wholesaler Tier -->
            <div style="background:#FAF8F5; border:1px solid #EAE5D9; border-radius:8px; padding:12px 14px;">
                <div style="font-size:11px; font-weight:800; color:#181512; text-transform:uppercase; letter-spacing:0.4px; margin-bottom:10px; display:flex; align-items:center; justify-content:space-between;">
                    <span style="display:flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#181512" stroke-width="2.2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                        <span>4. Wholesaler Tier (Bulk Volume MCQ)</span>
                    </span>
                    <span style="font-size:9.5px; font-weight:800; color:#181512; background:#E2E8F0; padding:1px 6px; border-radius:3px;">Bulk Lot Rate</span>
                </div>
                <div class="adm-form-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:12px;">
                    <!-- Wholesale Price -->
                    <div class="adm-form-group">
                        <label class="adm-form-label" for="pFormWholesalePrice" style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:4px;">
                            <span style="font-weight:700; color:#181512;">Wholesale Price (&#8377;)</span>
                            <span style="font-size:9px; font-weight:700; color:#64748B;">Base Wholesale</span>
                        </label>
                        <input type="number" min="0" step="1" id="pFormWholesalePrice" class="adm-form-input" style="font-weight:700; color:#181512; font-size:13px;"
                               placeholder="e.g. 400 (defaults to Retail Price)"
                               value="<?php echo htmlspecialchars($fmt($prod['wholesale_price'] ?? null)); ?>"
                               oninput="if (window.calcPricePreview) window.calcPricePreview();">
                        <small style="font-size:10px; color:#64748B;">Per-piece rate for Wholesaler MCQ lots. Defaults to Retailer Price if blank.</small>
                    </div>

                    <!-- Wholesale Sale Price -->
                    <div class="adm-form-group">
                        <label class="adm-form-label" for="pFormWholesaleSalePrice" style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:4px;">
                            <span style="font-weight:700; color:#B45309;">Wholesale Sale Price (&#8377;)</span>
                            <span style="font-size:9px; font-weight:800; color:#B45309; background:#FEF3C7; padding:1px 6px; border-radius:3px;">Sale Offer</span>
                        </label>
                        <input type="number" min="0" step="1" id="pFormWholesaleSalePrice" class="adm-form-input" style="font-weight:700; color:#B45309; font-size:13px;"
                               placeholder="e.g. 350"
                               value="<?php echo htmlspecialchars($fmt($prod['wholesale_sale_price'] ?? null)); ?>"
                               oninput="if (window.calcPricePreview) window.calcPricePreview();">
                        <small style="font-size:10px; color:#64748B;">Explicit promotional lot rate for verified Wholesalers.</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════════════
             2. FULL SET PRICE MATRIX (Sections 17 & 18)
        ════════════════════════════════════════════════════════════ -->
        <div id="pGroupFullSetMatrix" style="<?php echo $isFullSetMode ? 'display:flex;' : 'display:none;'; ?> flex-direction:column; gap:12px;">
            <!-- Notice Banner -->
            <div style="background:#FFFBEB; border:1.5px solid #FCD34D; border-radius:8px; padding:10px 14px;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#B45309" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    <div>
                        <div style="font-size:11.5px; font-weight:800; color:#92400E;">B2B Full Set Trade-Only Rule Active (Section 17)</div>
                        <div style="font-size:10.5px; color:#78350F; margin-top:2px;">
                            Full Sets are sold exclusively in complete lots to verified <strong>Retailers (Boutique)</strong> and <strong>Wholesalers</strong>.
                            Customer (Guest) and Reseller access is strictly trade-blocked with zero price leakage.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blocked Tiers Indicator -->
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                <div style="background:#F1F5F9; border:1px dashed #CBD5E1; border-radius:6px; padding:8px 12px; display:flex; align-items:center; justify-content:space-between; opacity:0.8;">
                    <span style="font-size:11px; font-weight:700; color:#64748B;">Guest / Customer</span>
                    <span style="font-size:9.5px; font-weight:800; color:#DC2626; background:#FEE2E2; padding:2px 6px; border-radius:3px;">BLOCKED (Trade Only)</span>
                </div>
                <div style="background:#F1F5F9; border:1px dashed #CBD5E1; border-radius:6px; padding:8px 12px; display:flex; align-items:center; justify-content:space-between; opacity:0.8;">
                    <span style="font-size:11px; font-weight:700; color:#64748B;">Reseller</span>
                    <span style="font-size:9.5px; font-weight:800; color:#DC2626; background:#FEE2E2; padding:2px 6px; border-radius:3px;">BLOCKED (Trade Only)</span>
                </div>
            </div>

            <!-- Full Set Trade Inputs Grid -->
            <div class="adm-form-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:12px;">
                <!-- Full Set Retailer Price -->
                <div class="adm-form-group">
                    <label class="adm-form-label" for="pFormFullSetRetailerPrice" style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:4px;">
                        <span style="font-weight:800; color:#8A681F;">Full Set Retailer Price (&#8377;) <span style="color:#DC2626;">*</span></span>
                        <span style="font-size:9px; font-weight:800; color:#8A681F; background:#FAF5E8; border:1px solid #D4AF37; padding:1px 6px; border-radius:3px;">Per Piece</span>
                    </label>
                    <input type="number" min="0" step="1" id="pFormFullSetRetailerPrice" class="adm-form-input" style="font-weight:800; color:#181512; font-size:13px;"
                           placeholder="e.g. 600"
                           value="<?php echo htmlspecialchars($fmt($prod['full_set_retailer_price'] ?? ($prod['retail_price'] ?? null))); ?>"
                           oninput="if (window.calcPricePreview) window.calcPricePreview();">
                    <small style="font-size:10px; color:#64748B;">Per-piece rate charged to Boutique Retailers for the entire set.</small>
                </div>

                <!-- Full Set Retailer Sale Price / Discount -->
                <div class="adm-form-group">
                    <label class="adm-form-label" for="pFormFullSetRetailerSalePrice" style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:4px;">
                        <span style="font-weight:700; color:#B45309;">Retailer Set Sale Price (&#8377;)</span>
                        <span style="font-size:9px; font-weight:800; color:#B45309; background:#FEF3C7; padding:1px 6px; border-radius:3px;">Offer Rate</span>
                    </label>
                    <input type="number" min="0" step="1" id="pFormFullSetRetailerSalePrice" class="adm-form-input" style="font-weight:700; color:#B45309; font-size:13px;"
                           placeholder="e.g. 580"
                           value="<?php echo htmlspecialchars($fmt($prod['full_set_retailer_sale_price'] ?? null)); ?>"
                           oninput="if (window.calcPricePreview) window.calcPricePreview();">
                    <small style="font-size:10px; color:#64748B;">Promotional per-piece set rate for Retailers.</small>
                </div>

                <!-- Full Set Wholesale Price -->
                <div class="adm-form-group">
                    <label class="adm-form-label" for="pFormFullSetWholesalePrice" style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:4px;">
                        <span style="font-weight:800; color:#181512;">Full Set Wholesale Price (&#8377;)</span>
                        <span style="font-size:9px; font-weight:800; color:#181512; background:#E2E8F0; padding:1px 6px; border-radius:3px;">Bulk Rate</span>
                    </label>
                    <input type="number" min="0" step="1" id="pFormFullSetWholesalePrice" class="adm-form-input" style="font-weight:800; color:#181512; font-size:13px;"
                           placeholder="e.g. 520"
                           value="<?php echo htmlspecialchars($fmt($prod['full_set_wholesale_price'] ?? ($prod['wholesale_price'] ?? null))); ?>"
                           oninput="if (window.calcPricePreview) window.calcPricePreview();">
                    <small style="font-size:10px; color:#64748B;">Per-piece volume rate charged to Wholesalers for full lot orders.</small>
                </div>

                <!-- Full Set Wholesale Sale Price -->
                <div class="adm-form-group">
                    <label class="adm-form-label" for="pFormFullSetWholesaleSalePrice" style="display:flex; justify-content:space-between; align-items:center; width:100%; margin-bottom:4px;">
                        <span style="font-weight:700; color:#B45309;">Wholesale Set Sale Price (&#8377;)</span>
                        <span style="font-size:9px; font-weight:800; color:#B45309; background:#FEF3C7; padding:1px 6px; border-radius:3px;">Offer Rate</span>
                    </label>
                    <input type="number" min="0" step="1" id="pFormFullSetWholesaleSalePrice" class="adm-form-input" style="font-weight:700; color:#B45309; font-size:13px;"
                           placeholder="e.g. 500"
                           value="<?php echo htmlspecialchars($fmt($prod['full_set_wholesale_sale_price'] ?? null)); ?>"
                           oninput="if (window.calcPricePreview) window.calcPricePreview();">
                    <small style="font-size:10px; color:#64748B;">Promotional per-piece set rate for Wholesalers.</small>
                </div>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════════════
             3. SECTION 19: INTERACTIVE ROLE PREVIEW STUDIO
        ════════════════════════════════════════════════════════════ -->
        <div style="background:#FAF8F5; border:1.5px solid #D4AF37; border-radius:8px; padding:12px 14px;">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:10px;">
                <div style="font-size:11px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.4px; display:flex; align-items:center; gap:6px;">
                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    <span>Storefront Role Preview (Section 19)</span>
                </div>
                <div style="font-size:10px; color:#64748B;">Read-only visual preview as seen by user tiers</div>
            </div>

            <!-- Role Tabs Bar -->
            <div style="display:flex; gap:6px; flex-wrap:wrap; margin-bottom:12px;" id="dtRolePreviewTabs">
                <button type="button" class="dt-role-tab active" data-role="guest" onclick="window.dtSelectPreviewRole('guest')" style="padding:6px 14px; border-radius:6px; font-size:11px; font-weight:800; cursor:pointer; border:1px solid #8A681F; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; transition:all 0.2s;">
                    Guest
                </button>
                <button type="button" class="dt-role-tab" data-role="customer" onclick="window.dtSelectPreviewRole('customer')" style="padding:6px 14px; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer; border:1px solid #D4AF37; background:#FAF5E8; color:#705114; transition:all 0.2s;">
                    Customer
                </button>
                <button type="button" class="dt-role-tab" data-role="retailer" onclick="window.dtSelectPreviewRole('retailer')" style="padding:6px 14px; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer; border:1px solid #D4AF37; background:#FAF5E8; color:#705114; transition:all 0.2s;">
                    Retailer (Boutique)
                </button>
                <button type="button" class="dt-role-tab" data-role="reseller" onclick="window.dtSelectPreviewRole('reseller')" style="padding:6px 14px; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer; border:1px solid #D4AF37; background:#FAF5E8; color:#705114; transition:all 0.2s;">
                    Reseller
                </button>
                <button type="button" class="dt-role-tab" data-role="wholesale" onclick="window.dtSelectPreviewRole('wholesale')" style="padding:6px 14px; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer; border:1px solid #D4AF37; background:#FAF5E8; color:#705114; transition:all 0.2s;">
                    Wholesaler
                </button>
            </div>

            <!-- Active Role Preview Card -->
            <div id="dtActiveRolePreviewCard" style="background:#181512; border:1px solid #8A681F; border-radius:8px; padding:12px 16px; color:#FAF5E8;">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:8px; border-bottom:1px solid rgba(212,175,55,0.25); padding-bottom:8px;">
                    <div>
                        <span id="dtPrevRoleTitle" style="font-size:12px; font-weight:800; color:#FAF5E8; letter-spacing:0.3px;">Guest Storefront View</span>
                        <span id="dtPrevAccessStatus" style="margin-left:8px; font-size:9.5px; font-weight:800; padding:2px 8px; border-radius:3px; background:#DCFCE7; color:#15803D;">Single Piece Available</span>
                    </div>
                    <div id="dtPrevDiscountPill" style="font-size:10px; font-weight:800; color:#181512; background:#E6CA65; padding:2px 8px; border-radius:4px;">
                        Standard Price
                    </div>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <div>
                        <div style="font-size:10px; font-weight:700; color:#A1A1AA; text-transform:uppercase;">Effective Visible Price</div>
                        <div style="display:flex; align-items:baseline; gap:8px; margin-top:2px;">
                            <span id="dtPrevEffectivePrice" style="font-size:22px; font-weight:800; color:#34D399; letter-spacing:-0.5px;">&#8377;0</span>
                            <span id="dtPrevBasePriceStrike" style="font-size:13px; color:#94A3B8; text-decoration:line-through; display:none;">&#8377;0</span>
                        </div>
                        <div id="dtPrevSubtitle" style="font-size:10px; color:#CBD5E1; margin-top:2px;">Consumer checkout rate</div>
                    </div>

                    <div style="text-align:right;">
                        <div style="font-size:10px; font-weight:700; color:#A1A1AA; text-transform:uppercase;">Margin / Savings Metric</div>
                        <div id="dtPrevMarginValue" style="font-size:16px; font-weight:800; color:#FCD34D; margin-top:2px;">&#8377;0/pc</div>
                        <div id="dtPrevMarginPercent" style="font-size:10px; color:#FDE68A;">0% Advantage</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════════════
             4. SECTION 21: WHOLESALER MCQ ADMIN TOOL
        ════════════════════════════════════════════════════════════ -->
        <div id="dtWholesalerMcqTool" style="background:#FAF8F5; border:1px solid #EAE5D9; border-radius:8px; padding:12px 14px;">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:10px;">
                <div style="font-size:11px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.4px; display:flex; align-items:center; gap:6px;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                    <span>Wholesaler Minimum Color/Size Commitment Quantity (MCQ) Tool (Section 21)</span>
                </div>
                <span id="dtMcqModeTag" style="font-size:9.5px; font-weight:800; color:#8A681F; background:#FAF5E8; border:1px solid #D4AF37; padding:2px 8px; border-radius:4px;">
                    Formula: Available Colors &times; Available Sizes
                </span>
            </div>

            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(160px, 1fr)); gap:10px; margin-bottom:10px;">
                <div style="background:#fff; border:1px solid #E2E8F0; border-radius:6px; padding:8px 10px;">
                    <div style="font-size:9.5px; font-weight:700; color:#64748B; text-transform:uppercase;">Available Colors</div>
                    <div id="dtMcqColorsCount" style="font-size:16px; font-weight:800; color:#181512; margin-top:2px;">1</div>
                    <div style="font-size:9px; color:#94A3B8;">Active Colorways</div>
                </div>

                <div style="background:#fff; border:1px solid #E2E8F0; border-radius:6px; padding:8px 10px;">
                    <div style="font-size:9.5px; font-weight:700; color:#64748B; text-transform:uppercase;">Available Sizes</div>
                    <div id="dtMcqSizesCount" style="font-size:16px; font-weight:800; color:#181512; margin-top:2px;">1</div>
                    <div style="font-size:9px; color:#94A3B8;">Free Size / Fitted</div>
                </div>

                <div style="background:#FAF5E8; border:1.2px solid #D4AF37; border-radius:6px; padding:8px 10px;">
                    <div style="font-size:9.5px; font-weight:800; color:#8A681F; text-transform:uppercase;">Wholesaler MCQ</div>
                    <div id="dtMcqTotalPieces" style="font-size:16px; font-weight:800; color:#8A681F; margin-top:2px;">1 Piece</div>
                    <div id="dtMcqFormulaText" style="font-size:9px; font-weight:700; color:#705114;">1 &times; 1 = 1 pc</div>
                </div>

                <div style="background:#DCFCE7; border:1px solid #16A34A; border-radius:6px; padding:8px 10px;">
                    <div style="font-size:9.5px; font-weight:800; color:#15803D; text-transform:uppercase;">Min Lot Value</div>
                    <div id="dtMcqLotTotalValue" style="font-size:16px; font-weight:800; color:#15803D; margin-top:2px;">&#8377;0</div>
                    <div id="dtMcqLotSub" style="font-size:9px; color:#166534;">Wholesale Order Minimum</div>
                </div>
            </div>

            <!-- Combinations Chips List -->
            <div>
                <div style="font-size:10px; font-weight:700; color:#64748B; margin-bottom:6px; text-transform:uppercase;">Sellable Color-Size Combinations in Lot:</div>
                <div id="dtMcqCombinationsList" style="display:flex; flex-wrap:wrap; gap:6px;">
                    <span style="font-size:10px; color:#94A3B8; background:#fff; border:1px solid #E2E8F0; padding:2px 8px; border-radius:4px;">No variants configured</span>
                </div>
            </div>
        </div>

    </div>
</div>
