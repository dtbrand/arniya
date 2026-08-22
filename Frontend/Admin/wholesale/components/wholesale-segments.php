<?php
/**
 * wholesale-segments.php — DT Brand's & Jai Hanuman Tex
 * Wholesale Performance Segments & Cohorts Component
 */
$segments = [
    [
        'id' => 'SEG-01',
        'name' => 'Mega Volume Wholesalers (GMV > ₹20L)',
        'partners' => 24,
        'share' => '48% of GMV',
        'criteria' => 'Orders > 40 • Avg AOV > ₹35,000 • 100% On-time Settle',
        'badge' => 'gold'
    ],
    [
        'id' => 'SEG-02',
        'name' => 'High-Frequency Regional Stockists',
        'partners' => 42,
        'share' => '32% of GMV',
        'criteria' => 'Re-order cycle < 14 days • Net 30 terms',
        'badge' => 'emerald'
    ],
    [
        'id' => 'SEG-03',
        'name' => 'Seasonal Festive Buyers',
        'partners' => 38,
        'share' => '15% of GMV',
        'criteria' => 'Q3 / Q4 Festive peak sourcing only',
        'badge' => 'blue'
    ],
    [
        'id' => 'SEG-04',
        'name' => 'Credit Watch & Dormant Accounts',
        'partners' => 20,
        'share' => '5% of GMV',
        'criteria' => 'No purchase in 60+ days OR Overdue balance',
        'badge' => 'crimson'
    ]
];
?>

<div class="dt-card">
    <div class="dt-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
            <h4 class="dt-card-title">Dynamic Wholesale Cohorts &amp; Performance Segments</h4>
        </div>
        <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="window.showToast('Segment Creator Opened')">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            <span>+ Create Cohort</span>
        </button>
    </div>

    <div style="padding:16px; display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:14px;">
        <?php foreach ($segments as $s): ?>
            <div style="background:#FFFFFF; border:1.5px solid #EAE5D9; border-radius:10px; padding:14px; display:flex; flex-direction:column; justify-content:space-between; gap:10px;">
                <div>
                    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                        <strong style="font-size:0.86rem; color:#181512;"><?php echo htmlspecialchars($s['name']); ?></strong>
                        <span class="dt-status-pill-clean <?php echo $s['badge']; ?>"><?php echo $s['partners']; ?> Accounts</span>
                    </div>
                    <div style="font-size:0.7rem; color:#78716C; margin-top:6px;">
                        Revenue Share: <strong style="color:#15803D;"><?php echo $s['share']; ?></strong>
                    </div>
                    <p style="font-size:0.72rem; color:#78716C; margin:6px 0 0 0; background:#FAF8F4; padding:6px 8px; border-radius:6px;">
                        <?php echo htmlspecialchars($s['criteria']); ?>
                    </p>
                </div>

                <div style="border-top:1px solid #F1ECE1; padding-top:8px; display:flex; justify-content:space-between; align-items:center;">
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('Cohort partners loaded')">View Accounts</button>
                    <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" onclick="window.showToast('WhatsApp Broadcast Triggered for Segment')">WhatsApp Broadcast</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
