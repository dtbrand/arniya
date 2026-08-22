<?php
/**
 * wholesale-tier.php — DT Brand's & Jai Hanuman Tex
 * Tier Benefit Matrix & Commercial Qualification Rules
 */
$tiers = [
    [
        'name' => 'Platinum Wholesale',
        'discount' => '35% Flat Off',
        'badge' => 'gold',
        'min_gmv' => '₹10,00,000 / Quarter',
        'moq' => '10 pcs / design',
        'payment_terms' => 'Net 30 / Net 45 Days',
        'credit_limit' => 'Up to ₹5,00,000',
        'partners_count' => 28,
        'featured' => true
    ],
    [
        'name' => 'Gold Distributor',
        'discount' => '28% Flat Off',
        'badge' => 'emerald',
        'min_gmv' => '₹5,00,000 / Quarter',
        'moq' => '15 pcs / design',
        'payment_terms' => 'Net 15 Days',
        'credit_limit' => 'Up to ₹2,00,000',
        'partners_count' => 46,
        'featured' => false
    ],
    [
        'name' => 'Silver Bulk Partner',
        'discount' => '20% Flat Off',
        'badge' => 'blue',
        'min_gmv' => '₹2,00,000 / Quarter',
        'moq' => '20 pcs / design',
        'payment_terms' => 'Advance 50% / COD',
        'credit_limit' => 'Up to ₹50,000',
        'partners_count' => 38,
        'featured' => false
    ],
    [
        'name' => 'Bronze Wholesale Starter',
        'discount' => '12% Flat Off',
        'badge' => 'amber',
        'min_gmv' => '₹50,000 Initial',
        'moq' => '25 pcs / design',
        'payment_terms' => '100% Prepaid / RTGS',
        'credit_limit' => 'No Credit (Prepaid)',
        'partners_count' => 12,
        'featured' => false
    ]
];
?>

<div class="dt-tiers-matrix-grid">
    <?php foreach ($tiers as $t): ?>
        <div class="dt-tier-card <?php echo $t['featured'] ? 'platinum' : ''; ?>">
            <div>
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
                    <div>
                        <h4 style="font-size:0.95rem; font-weight:900; color:#181512; margin:0;"><?php echo $t['name']; ?></h4>
                        <span class="dt-status-pill-clean <?php echo $t['badge']; ?>" style="margin-top:4px;"><?php echo $t['partners_count']; ?> Partners Enrolled</span>
                    </div>
                    <?php if ($t['featured']): ?>
                        <span class="dt-status-pill-clean gold">VIP HIGHEST MARGIN</span>
                    <?php endif; ?>
                </div>

                <div style="margin:14px 0; background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:12px; text-align:center;">
                    <div style="font-size:0.7rem; color:#78716C; font-weight:800; text-transform:uppercase;">COMMERCIAL MARGIN</div>
                    <div style="font-size:1.4rem; font-weight:900; color:#15803D;"><?php echo $t['discount']; ?></div>
                </div>

                <div style="display:flex; flex-direction:column; gap:8px; font-size:0.75rem;">
                    <div class="dt-tier-benefit-item">
                        <span style="color:#78716C;">Min GMV Velocity:</span>
                        <strong style="color:#181512; margin-left:auto;"><?php echo $t['min_gmv']; ?></strong>
                    </div>
                    <div class="dt-tier-benefit-item">
                        <span style="color:#78716C;">Design Lot MOQ:</span>
                        <strong style="color:#181512; margin-left:auto;"><?php echo $t['moq']; ?></strong>
                    </div>
                    <div class="dt-tier-benefit-item">
                        <span style="color:#78716C;">Payment Terms:</span>
                        <strong style="color:#181512; margin-left:auto;"><?php echo $t['payment_terms']; ?></strong>
                    </div>
                    <div class="dt-tier-benefit-item">
                        <span style="color:#78716C;">Credit Limit:</span>
                        <strong style="color:#8A681F; margin-left:auto;"><?php echo $t['credit_limit']; ?></strong>
                    </div>
                </div>
            </div>

            <div style="margin-top:14px; border-top:1px solid #F1ECE1; padding-top:12px; display:flex; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="flex:1;" onclick="openEditTierModal('<?php echo addslashes($t['name']); ?>', '<?php echo $t['discount']; ?>', '<?php echo $t['min_gmv']; ?>', '<?php echo $t['moq']; ?>')">
                    <span>Edit Tier</span>
                </button>
                <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="window.showToast('Partners in <?php echo addslashes($t['name']); ?> loaded')">
                    <span>View Partners</span>
                </button>
            </div>
        </div>
    <?php endforeach; ?>
</div>
