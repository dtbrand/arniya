<?php
/**
 * pricing.php — DT Brand's & Jai Hanuman Tex
 * Reseller Tiered Pricing, MOQ & Margin Configuration Studio
 */
$page_title = "Reseller Pricing & Tier Studio";
$active_nav = "resellers";
$active_subnav = "pricing";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiered Pricing &amp; Margins - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/resellers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/reseller-pricing.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/reseller-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 18px 20px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-customers-container" style="display:flex; flex-direction:column; gap:16px; margin-bottom:24px;">
                <!-- ══ TOP HEADER ══ -->
                <div class="dt-cust-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:4px;">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0; display:flex; align-items:center; gap:8px;">
                            <span>Tiered Pricing &amp; Partner Margins</span>
                            <span class="dt-cust-badge gold" style="font-size:0.72rem; padding:3px 8px; border-radius:6px; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; font-weight:800;">4 Active Tier Levels</span>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Manage discount structures (10% to 30% OFF), MOQ rules, and monthly volume commitments.</p>
                    </div>
                    <div class="dt-cust-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <a href="/Frontend/Admin/resellers/index.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            <span>Back to Resellers</span>
                        </a>
                        <button type="button" class="dt-btn dt-btn-gold" onclick="openAddSkuOverrideModal()">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>Add SKU Override</span>
                        </button>
                    </div>
                </div>

                <!-- ══ PRICING & MARGIN MATRIX COMPONENT ══ -->
                <?php include_once __DIR__ . '/components/reseller-pricing.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     INTERACTIVE MODALS FOR PRICING STUDIO
══════════════════════════════════════════════════════════════ -->

<!-- 1. Switch Tier Confirmation Modal -->
<div id="dtSwitchTierModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:14px; width:95%; max-width:480px; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Confirm Partner Tier Change</strong>
            </div>
            <button type="button" onclick="closePricingModal('dtSwitchTierModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <div class="dt-modal-body" style="padding:18px; display:flex; flex-direction:column; gap:12px;">
            <p style="font-size:0.85rem; color:#181512; margin:0; line-height:1.5;">
                Are you sure you want to change this reseller's pricing tier to <strong id="switchTargetTierName" style="color:#8A681F;">Gold Partner</strong>?
            </p>
            <div style="background:#FAF8F4; padding:12px; border-radius:8px; border:1px solid #EAE5D9;">
                <span style="font-size:0.7rem; color:#78716C; font-weight:700;">NEW MARGIN DISCOUNT:</span>
                <strong id="switchTargetTierDisc" style="font-size:1rem; color:#15803D; display:block; font-weight:900;">22% OFF MRP</strong>
                <small style="color:#78716C; font-size:0.72rem;">MOQ and monthly targets will automatically adjust across active B2B orders.</small>
            </div>
        </div>

        <div class="dt-modal-foot" style="padding:14px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:flex-end; gap:8px; background:#FAF8F4;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="closePricingModal('dtSwitchTierModal')">Cancel</button>
            <button type="button" class="dt-btn dt-btn-gold" onclick="executeTierSwitch()">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Confirm &amp; Update Tier</span>
            </button>
        </div>
    </div>
</div>

<!-- 2. Configure Tier Parameters Modal -->
<div id="dtEditTierModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:14px; width:95%; max-width:520px; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Configure Tier Margin Rules</strong>
            </div>
            <button type="button" onclick="closePricingModal('dtEditTierModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <form onsubmit="saveTierConfig(event)">
            <input type="hidden" id="editTierId">
            <div class="dt-modal-body" style="padding:18px; display:flex; flex-direction:column; gap:12px;">
                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Tier Name</label>
                    <input type="text" id="editTierName" class="dt-cust-search-input" style="width:100%; height:38px;" readonly>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Discount % OFF MRP *</label>
                        <input type="number" id="editTierDisc" class="dt-cust-search-input" style="width:100%; height:38px;" min="1" max="90" required>
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Min. Order Qty (MOQ) *</label>
                        <input type="text" id="editTierMoq" class="dt-cust-search-input" style="width:100%; height:38px;" required>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Monthly Volume Target</label>
                        <input type="text" id="editTierMov" class="dt-cust-search-input" style="width:100%; height:38px;" required>
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">B2B Credit Window</label>
                        <input type="text" id="editTierCredit" class="dt-cust-search-input" style="width:100%; height:38px;" required>
                    </div>
                </div>
            </div>

            <div class="dt-modal-foot" style="padding:14px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:flex-end; gap:8px; background:#FAF8F4;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closePricingModal('dtEditTierModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Save Tier Parameters</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 3. Edit Category Margin Modal -->
<div id="dtEditCategoryMarginModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:14px; width:95%; max-width:520px; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Configure Category Margin</strong>
            </div>
            <button type="button" onclick="closePricingModal('dtEditCategoryMarginModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <form onsubmit="saveCategoryMargin(event)">
            <input type="hidden" id="editCatRowId">
            <input type="hidden" id="editCatBaseMrp">
            <div class="dt-modal-body" style="padding:18px; display:flex; flex-direction:column; gap:12px;">
                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Saree Category</label>
                    <input type="text" id="editCatName" class="dt-cust-search-input" style="width:100%; height:38px; font-weight:800; background:#FAF8F4;" readonly>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Reseller Discount % *</label>
                        <input type="number" id="editCatMargin" class="dt-cust-search-input" style="width:100%; height:38px;" min="1" max="90" oninput="updateLiveNetPriceCalc()" required>
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Calculated Net Price</label>
                        <div id="editCatNetPriceDisplay" style="height:38px; background:#FAF5E8; border:1px solid #D4AF37; border-radius:8px; display:flex; align-items:center; padding:0 12px; font-size:1rem; font-weight:900; color:#15803D;">
                            ₹3,150
                        </div>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Min. Lot Quantity *</label>
                        <input type="text" id="editCatMinLot" class="dt-cust-search-input" style="width:100%; height:38px;" required>
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Rule Application</label>
                        <select id="editCatRuleType" class="dt-cust-select" style="width:100%; height:38px; border-radius:8px;">
                            <option value="Default">✓ Active Tier Default Rule</option>
                            <option value="Special">★ Special Category Boost</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="dt-modal-foot" style="padding:14px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:flex-end; gap:8px; background:#FAF8F4;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closePricingModal('dtEditCategoryMarginModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Save Category Margin</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 4. Add SKU Override Modal -->
<div id="dtAddSkuModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:14px; width:95%; max-width:520px; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <strong id="skuModalTitle" style="font-size:0.95rem; font-weight:800; color:#181512;">Add SKU-Specific Price Override</strong>
            </div>
            <button type="button" onclick="closePricingModal('dtAddSkuModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <form onsubmit="saveNewSkuOverride(event)">
            <div class="dt-modal-body" style="padding:18px; display:flex; flex-direction:column; gap:12px;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">SKU Code *</label>
                        <input type="text" id="skuCodeInput" class="dt-cust-search-input" style="width:100%; height:38px;" placeholder="e.g. KLN-SR-205" required>
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Base Catalog MRP</label>
                        <input type="text" id="skuMrpInput" class="dt-cust-search-input" style="width:100%; height:38px;" placeholder="e.g. ₹5,500">
                    </div>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Product Name *</label>
                    <input type="text" id="skuNameInput" class="dt-cust-search-input" style="width:100%; height:38px;" placeholder="e.g. Pure Tissue Silk Zari Saree" required>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Special Reseller Rate *</label>
                        <input type="text" id="skuSpecialRateInput" class="dt-cust-search-input" style="width:100%; height:38px;" placeholder="e.g. ₹3,600" required>
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Custom MOQ</label>
                        <input type="text" id="skuMoqInput" class="dt-cust-search-input" style="width:100%; height:38px;" placeholder="e.g. 5 Pcs">
                    </div>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Deal Campaign / Reason</label>
                    <input type="text" id="skuRuleInput" class="dt-cust-search-input" style="width:100%; height:38px;" placeholder="e.g. Diwali Flash Wholesale Deal">
                </div>
            </div>

            <div class="dt-modal-foot" style="padding:14px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:flex-end; gap:8px; background:#FAF8F4;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closePricingModal('dtAddSkuModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Save SKU Rule</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script src="/Frontend/Admin/resellers/assets/js/resellers.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/resellers/assets/js/reseller-pricing.js?v=<?php echo time(); ?>"></script>
</body>
</html>
