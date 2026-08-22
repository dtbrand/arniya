<?php
/**
 * reseller-pricing.php — DT Brand's & Jai Hanuman Tex
 * Tiered Pricing Matrix, Margin Calculator, Category Rules & SKU Overrides
 */
$tiers = [
    [
        'id' => 'tier-platinum',
        'name' => 'Platinum Elite',
        'badge' => 'platinum',
        'discount' => '30%',
        'discount_val' => '30',
        'moq' => '10 Pcs / Lot',
        'mov' => '₹50,000 / Mo',
        'credit' => '₹1,50,000 (30 Days)',
        'current' => true,
        'icon' => '<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>'
    ],
    [
        'id' => 'tier-gold',
        'name' => 'Gold Partner',
        'badge' => 'gold-tier',
        'discount' => '22%',
        'discount_val' => '22',
        'moq' => '6 Pcs / Lot',
        'mov' => '₹25,000 / Mo',
        'credit' => '₹1,00,000 (21 Days)',
        'current' => false,
        'icon' => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>'
    ],
    [
        'id' => 'tier-silver',
        'name' => 'Silver Growth',
        'badge' => 'silver',
        'discount' => '15%',
        'discount_val' => '15',
        'moq' => '4 Pcs / Lot',
        'mov' => '₹10,000 / Mo',
        'credit' => '₹50,000 (14 Days)',
        'current' => false,
        'icon' => '<circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>'
    ],
    [
        'id' => 'tier-bronze',
        'name' => 'Bronze Starter',
        'badge' => 'bronze',
        'discount' => '10%',
        'discount_val' => '10',
        'moq' => '2 Pcs / Lot',
        'mov' => '₹0 / Mo',
        'credit' => 'Cash / Prepaid Only',
        'current' => false,
        'icon' => '<rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line>'
    ]
];

$category_margins = [
    ['cat' => 'Banarasi Katan Silk Sarees', 'base_mrp' => '₹4,500', 'reseller_rate' => '₹3,150', 'margin' => '30% OFF', 'min_lot' => '10 Pcs', 'status' => 'Active Tier Rule'],
    ['cat' => 'Pure Soft Kanjivaram Sarees', 'base_mrp' => '₹6,800', 'reseller_rate' => '₹4,760', 'margin' => '30% OFF', 'min_lot' => '8 Pcs', 'status' => 'Active Tier Rule'],
    ['cat' => 'Chanderi & Organza Designer', 'base_mrp' => '₹2,950', 'reseller_rate' => '₹2,065', 'margin' => '30% OFF', 'min_lot' => '12 Pcs', 'status' => 'Active Tier Rule'],
    ['cat' => 'Surat Daily Wear Printed Sarees', 'base_mrp' => '₹1,250', 'reseller_rate' => '₹875', 'margin' => '30% OFF', 'min_lot' => '20 Pcs', 'status' => 'Active Tier Rule'],
    ['cat' => 'Bridal Silk & Zari Lehengas', 'base_mrp' => '₹14,500', 'reseller_rate' => '₹9,800', 'margin' => '32.4% (Custom Boost)', 'min_lot' => '4 Pcs', 'status' => 'Special Override']
];

$sku_overrides = [
    ['sku' => 'KLN-SR-101', 'name' => 'Royal Meenakari Banarasi Saree', 'mrp' => '₹5,200', 'special_rate' => '₹3,400', 'custom_moq' => '6 Pcs', 'rule' => 'Festive Volume Deal', 'status' => 'Active'],
    ['sku' => 'KLN-SR-102', 'name' => 'Gold Zari Kanjivaram Bridal Saree', 'mrp' => '₹8,500', 'special_rate' => '₹5,700', 'custom_moq' => '4 Pcs', 'rule' => 'Wedding Season B2B Promo', 'status' => 'Active'],
    ['sku' => 'KLN-SR-108', 'name' => 'Pure Organza Floral Digital Saree', 'mrp' => '₹3,100', 'special_rate' => '₹2,050', 'custom_moq' => '10 Pcs', 'rule' => 'Fast Stock Clearance', 'status' => 'Active']
];
?>

<!-- ══ SECTION TABS ══ -->
<div class="dt-pricing-tab-nav">
    <button type="button" class="dt-pricing-tab-btn active" onclick="switchPricingTab('tiersTab', this)">
        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
        <span>4-Tier Master Matrix</span>
    </button>
    <button type="button" class="dt-pricing-tab-btn" onclick="switchPricingTab('categoryTab', this)">
        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
        <span>Category Margin Matrix</span>
    </button>
    <button type="button" class="dt-pricing-tab-btn" onclick="switchPricingTab('skuTab', this)">
        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
        <span>SKU Price Overrides</span>
    </button>
</div>

<!-- ══════════════════════════════════════════════════════════════
     TAB 1: 4-TIER MASTER MATRIX CARDS
══════════════════════════════════════════════════════════════ -->
<div id="tiersTab" class="dt-pricing-tab-pane" style="display:block;">
    <div class="dt-pricing-grid">
        <?php foreach ($tiers as $t): ?>
            <div id="<?php echo $t['id']; ?>" class="dt-tier-card <?php echo $t['current'] ? 'current' : ''; ?>">
                <!-- Tier Card Header -->
                <div class="dt-tier-head">
                    <span class="dt-tier-badge <?php echo $t['badge']; ?>">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><?php echo $t['icon']; ?></svg>
                        <span class="tier-name-label"><?php echo $t['name']; ?></span>
                    </span>
                    <div class="tier-current-indicator">
                        <?php if ($t['current']): ?>
                            <span class="dt-doc-status-badge" style="background:#DCFCE7; color:#15803D; border-color:#86EFAC; font-size:0.7rem;">
                                ✓ CURRENT TIER
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Discount Margin Strip -->
                <div>
                    <span style="font-size:0.68rem; color:#78716C; font-weight:800; text-transform:uppercase; letter-spacing:0.04em;">Partner Discount Margin</span>
                    <div class="dt-tier-discount-pill"><span class="tier-disc-val"><?php echo $t['discount']; ?></span> OFF MRP</div>
                </div>

                <!-- Metric Details -->
                <div class="dt-tier-metric-box">
                    <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.78rem;">
                        <span style="color:#78716C; font-weight:600;">Min. Order Qty (MOQ):</span>
                        <strong class="tier-moq-val" style="color:#181512;"><?php echo $t['moq']; ?></strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.78rem;">
                        <span style="color:#78716C; font-weight:600;">Monthly Volume Target:</span>
                        <strong class="tier-mov-val" style="color:#181512;"><?php echo $t['mov']; ?></strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.78rem;">
                        <span style="color:#78716C; font-weight:600;">B2B Credit Window:</span>
                        <strong class="tier-credit-val" style="color:#8A681F; font-weight:800;"><?php echo $t['credit']; ?></strong>
                    </div>
                </div>

                <!-- Card Actions -->
                <div style="margin-top:auto; padding-top:12px; display:flex; flex-direction:column; gap:8px;">
                    <div class="tier-action-slot">
                        <?php if ($t['current']): ?>
                            <button type="button" class="dt-btn dt-btn-dark tier-btn-switch" style="width:100%; font-weight:800;" disabled>
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#FAF5E8" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <span>Active Tier Assigned</span>
                            </button>
                        <?php else: ?>
                            <button type="button" class="dt-btn dt-btn-pale tier-btn-switch" style="width:100%;" onclick="openSwitchTierConfirmation('<?php echo $t['id']; ?>', '<?php echo addslashes($t['name']); ?>', '<?php echo $t['discount_val']; ?>')">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                <span>Switch to <?php echo $t['name']; ?></span>
                            </button>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="width:100%; border-style:dashed; color:#78716C; font-size:0.72rem;" onclick="openEditTierModal('<?php echo $t['id']; ?>', '<?php echo addslashes($t['name']); ?>', '<?php echo $t['discount_val']; ?>', '<?php echo addslashes($t['moq']); ?>', '<?php echo addslashes($t['mov']); ?>', '<?php echo addslashes($t['credit']); ?>')">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        <span>Configure Rules</span>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     TAB 2: CATEGORY MARGIN MATRIX
══════════════════════════════════════════════════════════════ -->
<div id="categoryTab" class="dt-pricing-tab-pane" style="display:none;">
    <div class="dt-card" style="background:#FFFFFF; border:1.5px solid #EAE5D9; border-radius:12px; padding:18px; box-shadow:0 2px 10px rgba(0,0,0,0.02);">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
            <div>
                <strong style="font-size:0.95rem; color:#181512;">Fabric &amp; Category Margin Matrix</strong>
                <p style="font-size:0.75rem; color:#78716C; margin:2px 0 0 0;">Automatic net price computation across major wholesale saree lines.</p>
            </div>
            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('✓ Category margins synchronized with catalog base MRP')">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                <span>Recalculate All</span>
            </button>
        </div>

        <div style="overflow-x:auto;">
            <table class="dt-resellers-table" style="width:100%; border-collapse:collapse; font-size:0.8rem;">
                <thead>
                    <tr style="background:#FAF8F4; border-bottom:1.5px solid #EAE5D9;">
                        <th style="padding:10px 14px; text-align:left; font-weight:800; color:#181512;">Saree Category</th>
                        <th style="padding:10px 14px; text-align:left; font-weight:800; color:#181512;">Avg Catalog MRP</th>
                        <th style="padding:10px 14px; text-align:left; font-weight:800; color:#181512;">Reseller Net Price</th>
                        <th style="padding:10px 14px; text-align:left; font-weight:800; color:#181512;">Active Margin</th>
                        <th style="padding:10px 14px; text-align:left; font-weight:800; color:#181512;">Min Lot</th>
                        <th style="padding:10px 14px; text-align:left; font-weight:800; color:#181512;">Rule Status</th>
                        <th style="padding:10px 14px; text-align:right; font-weight:800; color:#181512;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($category_margins as $cm): ?>
                        <tr style="border-bottom:1px solid #F3EFE6;">
                            <td style="padding:12px 14px; font-weight:700; color:#181512;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <div style="width:28px; height:28px; border-radius:6px; background:#FAF5E8; color:#8A681F; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:0.75rem;">
                                        SC
                                    </div>
                                    <span><?php echo $cm['cat']; ?></span>
                                </div>
                            </td>
                            <td style="padding:12px 14px; color:#78716C; font-weight:600;"><?php echo $cm['base_mrp']; ?></td>
                            <td style="padding:12px 14px; color:#15803D; font-weight:800; font-size:0.85rem;"><?php echo $cm['reseller_rate']; ?></td>
                            <td style="padding:12px 14px;">
                                <span class="dt-reseller-badge gold" style="font-size:0.72rem; font-weight:800;"><?php echo $cm['margin']; ?></span>
                            </td>
                            <td style="padding:12px 14px; color:#181512; font-weight:600;"><?php echo $cm['min_lot']; ?></td>
                            <td style="padding:12px 14px;">
                                <span class="dt-reseller-badge emerald" style="font-size:0.7rem; font-weight:800;">✓ <?php echo $cm['status']; ?></span>
                            </td>
                            <td style="padding:12px 14px; text-align:right;">
                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('⚙️ Editing custom margin for <?php echo addslashes($cm['cat']); ?>')">
                                    <span>Edit</span>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     TAB 3: SKU PRICE OVERRIDES
══════════════════════════════════════════════════════════════ -->
<div id="skuTab" class="dt-pricing-tab-pane" style="display:none;">
    <div class="dt-card" style="background:#FFFFFF; border:1.5px solid #EAE5D9; border-radius:12px; padding:18px; box-shadow:0 2px 10px rgba(0,0,0,0.02);">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
            <div>
                <strong style="font-size:0.95rem; color:#181512;">SKU-Specific Deal &amp; Special Rates</strong>
                <p style="font-size:0.75rem; color:#78716C; margin:2px 0 0 0;">Overrides base tier discounts for specific premium sarees or seasonal campaigns.</p>
            </div>
            <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="openAddSkuOverrideModal()">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>+ Add SKU Override</span>
            </button>
        </div>

        <div style="overflow-x:auto;">
            <table class="dt-resellers-table" style="width:100%; border-collapse:collapse; font-size:0.8rem;">
                <thead>
                    <tr style="background:#FAF8F4; border-bottom:1.5px solid #EAE5D9;">
                        <th style="padding:10px 14px; text-align:left; font-weight:800; color:#181512;">SKU Code</th>
                        <th style="padding:10px 14px; text-align:left; font-weight:800; color:#181512;">Product Name</th>
                        <th style="padding:10px 14px; text-align:left; font-weight:800; color:#181512;">Base MRP</th>
                        <th style="padding:10px 14px; text-align:left; font-weight:800; color:#181512;">Special Reseller Rate</th>
                        <th style="padding:10px 14px; text-align:left; font-weight:800; color:#181512;">Custom MOQ</th>
                        <th style="padding:10px 14px; text-align:left; font-weight:800; color:#181512;">Deal Campaign</th>
                        <th style="padding:10px 14px; text-align:right; font-weight:800; color:#181512;">Action</th>
                    </tr>
                </thead>
                <tbody id="skuOverrideTbody">
                    <?php foreach ($sku_overrides as $so): ?>
                        <tr style="border-bottom:1px solid #F3EFE6;">
                            <td style="padding:12px 14px; font-family:monospace; font-weight:800; color:#8A681F;"><?php echo $so['sku']; ?></td>
                            <td style="padding:12px 14px; font-weight:700; color:#181512;"><?php echo $so['name']; ?></td>
                            <td style="padding:12px 14px; color:#78716C; text-decoration:line-through;"><?php echo $so['mrp']; ?></td>
                            <td style="padding:12px 14px; color:#15803D; font-weight:900; font-size:0.88rem;"><?php echo $so['special_rate']; ?></td>
                            <td style="padding:12px 14px; font-weight:700; color:#181512;"><?php echo $so['custom_moq']; ?></td>
                            <td style="padding:12px 14px;">
                                <span class="dt-reseller-badge gold" style="font-size:0.7rem; font-weight:800;"><?php echo $so['rule']; ?></span>
                            </td>
                            <td style="padding:12px 14px; text-align:right;">
                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="color:#DC2626; border-color:#FECACA;" onclick="removeSkuOverride(this, '<?php echo $so['sku']; ?>')">
                                    <span>Remove</span>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
