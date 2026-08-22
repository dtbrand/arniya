<?php
/**
 * reseller-segments.php — DT Brand's & Jai Hanuman Tex
 * Reseller Cohorts & Performance Clusters Component
 */
$segments = [
    [
        'name' => 'Elite Power Resellers',
        'sub' => 'GMV ≥ ₹5 Lakhs / Quarter • MOQ ≥ 10 Pcs',
        'count' => '42 Partners',
        'margin' => '30% Margin',
        'color' => 'gold'
    ],
    [
        'name' => 'High-Frequency Dropshippers',
        'sub' => 'Orders ≥ 20 / Month • Fast Delivery Required',
        'count' => '94 Partners',
        'margin' => '22% Margin',
        'color' => 'emerald'
    ],
    [
        'name' => 'Emerging Social Boutique Sellers',
        'sub' => 'Instagram / WhatsApp Community Commerce',
        'count' => '160 Partners',
        'margin' => '15% Margin',
        'color' => 'blue'
    ],
    [
        'name' => 'Credit Watch & Dormant',
        'sub' => 'No orders in last 45 days or near credit limit',
        'count' => '52 Partners',
        'margin' => 'Review Needed',
        'color' => 'amber'
    ]
];
?>

<div class="dt-card" style="padding:18px;">
    <div class="dt-card-head" style="margin-bottom:14px;">
        <h4 class="dt-card-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            <span>Reseller Performance Cohorts &amp; Segments</span>
        </h4>
        <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="window.showToast('Segment creator opened')">+ New Segment</button>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:12px;">
        <?php foreach ($segments as $s): ?>
            <div style="background:#FAF8F4; border:1.2px solid #EAE5D9; border-radius:10px; padding:14px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                    <strong style="font-size:0.85rem; color:#181512;"><?php echo htmlspecialchars($s['name']); ?></strong>
                    <span class="dt-reseller-badge <?php echo $s['color']; ?>"><?php echo $s['count']; ?></span>
                </div>
                <p style="font-size:0.72rem; color:#78716C; margin:0 0 10px 0;"><?php echo htmlspecialchars($s['sub']); ?></p>
                <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid #EAE5D9; padding-top:8px;">
                    <span style="font-size:0.72rem; font-weight:800; color:#8A681F;"><?php echo $s['margin']; ?></span>
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('Segment targeted')">View Cohort</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
