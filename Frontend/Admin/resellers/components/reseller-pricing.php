<?php
/**
 * reseller-pricing.php — DT Brand's & Jai Hanuman Tex
 * Reseller Tiered Pricing, Margins & MOQ Configuration Component
 */
$tiers = [
    [
        'name' => 'Platinum Elite',
        'badge' => 'platinum',
        'discount' => '30%',
        'moq' => '10 Pcs / Lot',
        'mov' => '₹50,000 / Mo',
        'credit' => '₹1,50,000 (30 Days)',
        'current' => true
    ],
    [
        'name' => 'Gold Partner',
        'badge' => 'gold-tier',
        'discount' => '22%',
        'moq' => '6 Pcs / Lot',
        'mov' => '₹25,000 / Mo',
        'credit' => '₹1,00,000 (21 Days)',
        'current' => false
    ],
    [
        'name' => 'Silver Growth',
        'badge' => 'silver',
        'discount' => '15%',
        'moq' => '4 Pcs / Lot',
        'mov' => '₹10,000 / Mo',
        'credit' => '₹50,000 (14 Days)',
        'current' => false
    ],
    [
        'name' => 'Bronze Starter',
        'badge' => 'bronze',
        'discount' => '10%',
        'moq' => '2 Pcs / Lot',
        'mov' => '₹0 / Mo',
        'credit' => 'Cash / Prepaid Only',
        'current' => false
    ]
];
?>

<div class="dt-pricing-grid">
    <?php foreach ($tiers as $t): ?>
        <div class="dt-tier-card <?php echo $t['current'] ? 'current' : ''; ?>">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <span class="dt-tier-badge <?php echo $t['badge']; ?>">★ <?php echo $t['name']; ?></span>
                <?php if ($t['current']): ?>
                    <span class="dt-reseller-badge emerald">Current Tier</span>
                <?php endif; ?>
            </div>

            <div>
                <div style="font-size:0.68rem; color:#78716C; font-weight:700; text-transform:uppercase;">Partner Discount Margin</div>
                <div class="dt-tier-discount-pill"><?php echo $t['discount']; ?> OFF MRP</div>
            </div>

            <div style="border-top:1px solid #F1ECE1; padding-top:10px; display:flex; flex-direction:column; gap:6px;">
                <div class="dt-info-row">
                    <span class="dt-info-lbl">Min. Order Qty (MOQ)</span>
                    <span class="dt-info-val"><?php echo $t['moq']; ?></span>
                </div>
                <div class="dt-info-row">
                    <span class="dt-info-lbl">Monthly Volume Target</span>
                    <span class="dt-info-val"><?php echo $t['mov']; ?></span>
                </div>
                <div class="dt-info-row">
                    <span class="dt-info-lbl">B2B Credit Window</span>
                    <span class="dt-info-val" style="color:#8A681F; font-weight:800;"><?php echo $t['credit']; ?></span>
                </div>
            </div>

            <div style="margin-top:auto; padding-top:10px;">
                <?php if ($t['current']): ?>
                    <button type="button" class="dt-btn dt-btn-dark" style="width:100%;" disabled>Active Tier Assigned</button>
                <?php else: ?>
                    <button type="button" class="dt-btn dt-btn-pale" style="width:100%;" onclick="assignResellerTier('<?php echo $t['name']; ?>', '<?php echo str_replace('%', '', $t['discount']); ?>')">Switch to <?php echo $t['name']; ?></button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
