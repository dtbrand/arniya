<?php
/**
 * reseller-verification.php — DT Brand's & Jai Hanuman Tex
 * 4-Stage Verification Checklist Component
 */
$stages = [
    [
        'name' => '1. Identity Verification',
        'sub' => 'Aadhaar / Passport & Proprietor Photo',
        'status' => 'Verified',
        'verifier' => 'Admin Gautam (Surat Hub)',
        'date' => '12 Nov 2025'
    ],
    [
        'name' => '2. Business & Tax Verification',
        'sub' => 'GSTIN Portal Cross-Check & Trade License',
        'status' => 'Verified',
        'verifier' => 'Compliance Bot v2',
        'date' => '12 Nov 2025'
    ],
    [
        'name' => '3. Bank Account & Settlement Verification',
        'sub' => 'Penny Drop & Name Match on Cancelled Cheque',
        'status' => 'Verified',
        'verifier' => 'ICICI Payouts Gateway',
        'date' => '13 Nov 2025'
    ],
    [
        'name' => '4. Physical Address / Shop Location',
        'sub' => 'Surat Textile Market Ground Verification',
        'status' => 'Verified',
        'verifier' => 'Field Executive Rajesh',
        'date' => '15 Nov 2025'
    ]
];
?>

<div class="dt-card" style="padding:18px;">
    <h4 class="dt-card-title" style="margin-bottom:16px;">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#15803D" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        <span>4-Stage Onboarding Verification Audit</span>
    </h4>

    <div style="display:flex; flex-direction:column; gap:12px;">
        <?php foreach ($stages as $s): ?>
            <div style="background:#FAF8F4; border:1.2px solid #EAE5D9; border-radius:10px; padding:12px 16px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
                <div>
                    <strong style="font-size:0.85rem; color:#181512; display:block;"><?php echo $s['name']; ?></strong>
                    <small style="font-size:0.72rem; color:#78716C;"><?php echo $s['sub']; ?></small>
                </div>
                <div style="display:flex; align-items:center; gap:10px;">
                    <div style="text-align:right;">
                        <span class="dt-reseller-badge emerald">✓ <?php echo $s['status']; ?></span>
                        <div style="font-size:0.65rem; color:#78716C; margin-top:2px;">By <?php echo $s['verifier']; ?> on <?php echo $s['date']; ?></div>
                    </div>
                    <div style="display:flex; align-items:center; gap:4px;">
                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="verifyKycStage('<?php echo $s['name']; ?>')">Re-Verify</button>
                        <button type="button" class="dt-btn dt-btn-rose dt-btn-sm" onclick="rejectKycStage('<?php echo $s['name']; ?>')">Reject</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
