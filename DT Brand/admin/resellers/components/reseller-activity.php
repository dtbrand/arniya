<?php
/**
 * reseller-activity.php — DT Brand's & Jai Hanuman Tex
 * Reseller Audit Trail & Activity Log Component
 */
$activities = [
    [
        'action' => 'Bulk Order Dispatched',
        'details' => 'Order #ORD-9842 containing 4 Kanjivaram Sarees dispatched via Bluedart Tracking #BLU99412',
        'actor' => 'Warehouse Bot (Surat)',
        'time' => '20 Aug 2026, 04:30 PM'
    ],
    [
        'action' => 'Credit Settlement Recorded',
        'details' => 'Received NEFT transfer of ₹50,000 from ICICI Bank (UTR: ICIC00984124)',
        'actor' => 'Staff Rajesh',
        'time' => '15 Aug 2026, 11:15 AM'
    ],
    [
        'action' => 'Tier Upgraded to Platinum Elite',
        'details' => 'Automatic elevation to Platinum Elite due to crossing ₹5,00,000 GMV threshold',
        'actor' => 'VIP Tier Engine',
        'time' => '01 Aug 2026, 09:00 AM'
    ],
    [
        'action' => 'KYC Documents Verified',
        'details' => 'GST Registration Certificate and Proprietor Aadhaar card approved & signed',
        'actor' => 'Admin Gautam',
        'time' => '12 Nov 2025, 02:40 PM'
    ],
    [
        'action' => 'Reseller Application Submitted',
        'details' => 'Submitted online onboarding form with Surat wholesale trade license',
        'actor' => 'Rameshwar Vyas (Applicant)',
        'time' => '12 Nov 2025, 01:10 PM'
    ]
];
?>

<div class="dt-card" style="padding:18px;">
    <h4 class="dt-card-title" style="margin-bottom:16px;">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
        <span>Audit Trail &amp; Activity Timeline</span>
    </h4>

    <div style="display:flex; flex-direction:column; gap:12px;">
        <?php foreach ($activities as $a): ?>
            <div style="display:flex; gap:12px; align-items:flex-start; padding-bottom:12px; border-bottom:1px solid #F1ECE1;">
                <div style="width:10px; height:10px; border-radius:50%; background:#8A681F; margin-top:5px; flex-shrink:0; box-shadow:0 0 6px rgba(138,104,31,0.4);"></div>
                <div style="flex:1;">
                    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:6px;">
                        <strong style="font-size:0.82rem; color:#181512;"><?php echo htmlspecialchars($a['action']); ?></strong>
                        <span style="font-size:0.68rem; color:#78716C;"><?php echo $a['time']; ?></span>
                    </div>
                    <p style="font-size:0.75rem; color:#4B5563; margin:3px 0 0 0;"><?php echo htmlspecialchars($a['details']); ?></p>
                    <small style="font-size:0.68rem; color:#8A681F; font-weight:700; display:block; margin-top:2px;">By <?php echo htmlspecialchars($a['actor']); ?></small>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
