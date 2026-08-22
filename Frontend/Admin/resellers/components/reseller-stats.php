<?php
/**
 * reseller-stats.php — DT Brand's & Jai Hanuman Tex
 * 8-Card Master Executive KPI Ribbon for Reseller Management
 */
$kpis = [
    [
        'label' => 'Total Resellers',
        'val' => '348',
        'sub' => 'Across 22 States',
        'status' => 'all',
        'color' => 'gold',
        'icon' => '<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>'
    ],
    [
        'label' => 'Pending Applications',
        'val' => '24',
        'sub' => 'Needs Staff Review',
        'status' => 'pending',
        'color' => 'amber',
        'icon' => '<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#B45309" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>'
    ],
    [
        'label' => 'Approved Partners',
        'val' => '296',
        'sub' => 'Active Ordering',
        'status' => 'approved',
        'color' => 'emerald',
        'icon' => '<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#15803D" stroke-width="2.3"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>'
    ],
    [
        'label' => 'Rejected',
        'val' => '16',
        'sub' => 'KYC / Ineligible',
        'status' => 'rejected',
        'color' => 'rose',
        'icon' => '<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#DC2626" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>'
    ],
    [
        'label' => 'Suspended',
        'val' => '12',
        'sub' => 'Credit / Compliance',
        'status' => 'suspended',
        'color' => 'purple',
        'icon' => '<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#7E22CE" stroke-width="2.3"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>'
    ],
    [
        'label' => 'Orders This Month',
        'val' => '842',
        'sub' => '+18.4% MoM Velocity',
        'status' => 'orders',
        'color' => 'blue',
        'icon' => '<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#1D4ED8" stroke-width="2.3"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>'
    ],
    [
        'label' => 'Reseller GMV Volume',
        'val' => '₹48.6L',
        'sub' => 'Gross Partner Sales',
        'status' => 'revenue',
        'color' => 'gold',
        'icon' => '<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>'
    ],
    [
        'label' => 'Outstanding Credit',
        'val' => '₹8.42L',
        'sub' => 'Within Safe Limit',
        'status' => 'credit',
        'color' => 'amber',
        'icon' => '<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#B45309" stroke-width="2.3"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>'
    ]
];
?>

<div class="dt-reseller-kpi-grid">
    <?php foreach ($kpis as $kpi): ?>
        <div class="dt-reseller-kpi-card" data-status="<?php echo $kpi['status']; ?>" onclick="if(typeof filterResellersByStatus==='function'){ filterResellersByStatus('<?php echo $kpi['status']; ?>', this); }">
            <div class="dt-reseller-kpi-top">
                <span class="dt-reseller-kpi-label"><?php echo $kpi['label']; ?></span>
                <div class="dt-reseller-kpi-icon <?php echo $kpi['color']; ?>">
                    <?php echo $kpi['icon']; ?>
                </div>
            </div>
            <div class="dt-reseller-kpi-val"><?php echo $kpi['val']; ?></div>
            <div class="dt-reseller-kpi-bot">
                <span style="color:#78716C;"><?php echo $kpi['sub']; ?></span>
            </div>
        </div>
    <?php endforeach; ?>
</div>
