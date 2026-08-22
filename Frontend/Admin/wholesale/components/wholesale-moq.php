<?php
/**
 * wholesale-moq.php — DT Brand's & Jai Hanuman Tex
 * Minimum Order Quantity & Volume Quantity Breaks Component
 */
$moq_rules = [
    ['scope' => 'Tier 1: Platinum VIP Lot MOQ', 'min_qty' => '10 pcs / design', 'min_order_val' => '₹25,000', 'desc' => 'Highest volume tier with flexible low design lot thresholds.'],
    ['scope' => 'Tier 2: Gold Distributor MOQ', 'min_qty' => '15 pcs / design', 'min_order_val' => '₹40,000', 'desc' => 'Standard wholesale distributor lot size requirement.'],
    ['scope' => 'Tier 3: Silver Bulk Partner MOQ', 'min_qty' => '20 pcs / design', 'min_order_val' => '₹50,000', 'desc' => 'Entry level bulk wholesale batch size.'],
    ['scope' => 'Category: Bridal Heavy Kanjeevaram Silk', 'min_qty' => '6 pcs / design', 'min_order_val' => '₹20,000', 'desc' => 'High-value premium silk sarees with lower piece MOQ.']
];
?>

<div class="dt-card">
    <div class="dt-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
            <h4 class="dt-card-title">Minimum Order Quantity (MOQ) &amp; Lot Sizing Rules</h4>
        </div>
        <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="window.showToast('MOQ Rule Builder Opened')">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            <span>+ Add MOQ Rule</span>
        </button>
    </div>

    <!-- Volume Breaks Strip -->
    <div style="padding:16px; border-bottom:1.5px solid #EAE5D9; background:#FAF8F4;">
        <label style="font-size:0.75rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:10px;">Configured Volume Quantity Breaks (All Wholesale Accounts)</label>
        <div style="display:flex; gap:12px; flex-wrap:wrap;">
            <div class="dt-qty-break-pill">
                <span style="font-size:0.68rem; color:#78716C; font-weight:700;">TIER 1 (10–24 pcs)</span>
                <strong style="font-size:1.1rem; color:#181512; font-weight:900;">Base Wholesale</strong>
                <small style="font-size:0.65rem; color:#15803D; font-weight:700;">Standard Tier Price</small>
            </div>
            <div class="dt-qty-break-pill">
                <span style="font-size:0.68rem; color:#78716C; font-weight:700;">TIER 2 (25–49 pcs)</span>
                <strong style="font-size:1.1rem; color:#15803D; font-weight:900;">+3% Extra Off</strong>
                <small style="font-size:0.65rem; color:#15803D; font-weight:700;">Volume Rebate</small>
            </div>
            <div class="dt-qty-break-pill">
                <span style="font-size:0.68rem; color:#78716C; font-weight:700;">TIER 3 (50–99 pcs)</span>
                <strong style="font-size:1.1rem; color:#15803D; font-weight:900;">+6% Extra Off</strong>
                <small style="font-size:0.65rem; color:#15803D; font-weight:700;">Master Lot Rebate</small>
            </div>
            <div class="dt-qty-break-pill" style="border-color:#8A681F; background:#FAF5E8;">
                <span style="font-size:0.68rem; color:#8A681F; font-weight:800;">MEGA (100+ pcs)</span>
                <strong style="font-size:1.1rem; color:#8A681F; font-weight:900;">+10% Extra Off</strong>
                <small style="font-size:0.65rem; color:#8A681F; font-weight:800;">Factory Direct</small>
            </div>
        </div>
    </div>

    <!-- MOQ Rules List -->
    <div style="padding:16px; display:flex; flex-direction:column; gap:12px;">
        <?php foreach ($moq_rules as $r): ?>
            <div class="dt-moq-rule-box">
                <div>
                    <strong style="font-size:0.86rem; color:#181512; display:block;"><?php echo htmlspecialchars($r['scope']); ?></strong>
                    <p style="font-size:0.72rem; color:#78716C; margin:3px 0 0 0;"><?php echo htmlspecialchars($r['desc']); ?></p>
                </div>
                <div style="display:flex; align-items:center; gap:12px;">
                    <span class="dt-status-pill-clean gold">MOQ: <?php echo $r['min_qty']; ?></span>
                    <span class="dt-status-pill-clean emerald">MOV: <?php echo $r['min_order_val']; ?></span>
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="openEditMoqModal('<?php echo addslashes($r['scope']); ?>', '<?php echo $r['min_qty']; ?>', '<?php echo $r['min_order_val']; ?>')">Configure</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
