<?php
/**
 * reseller-verification.php — DT Brand's & Jai Hanuman Tex
 * 4-Stage Verification Checklist Component & Audit Controls
 */
$stages = [
    [
        'id' => 'stage-identity',
        'name' => '1. Identity Verification',
        'sub' => 'Aadhaar / Passport & Proprietor Photo Match',
        'status' => 'Verified',
        'verifier' => 'Admin Gautam (Surat Hub)',
        'date' => '12 Nov 2025',
        'icon' => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>'
    ],
    [
        'id' => 'stage-tax',
        'name' => '2. Business & Tax Verification',
        'sub' => 'GSTIN Portal Cross-Check & Trade License Validation',
        'status' => 'Verified',
        'verifier' => 'Compliance Bot v2',
        'date' => '12 Nov 2025',
        'icon' => '<rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>'
    ],
    [
        'id' => 'stage-bank',
        'name' => '3. Bank Account & Settlement Verification',
        'sub' => 'Penny Drop & Name Match on Cancelled Cheque',
        'status' => 'Verified',
        'verifier' => 'ICICI Payouts Gateway',
        'date' => '13 Nov 2025',
        'icon' => '<rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line>'
    ],
    [
        'id' => 'stage-location',
        'name' => '4. Physical Address / Shop Location',
        'sub' => 'Surat Textile Market Ground Verification & Geo-Tag',
        'status' => 'Verified',
        'verifier' => 'Field Executive Rajesh',
        'date' => '15 Nov 2025',
        'icon' => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>'
    ]
];
?>

<div class="dt-card" style="background:#FFFFFF; border:1.5px solid #EAE5D9; border-radius:12px; padding:20px; box-shadow:0 4px 16px rgba(0,0,0,0.03);">
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:18px; border-bottom:1px solid #F3EFE6; padding-bottom:14px;">
        <div style="display:flex; align-items:center; gap:10px;">
            <div style="width:36px; height:36px; border-radius:8px; background:#FAF5E8; border:1.2px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>
            <div>
                <h4 style="font-size:1rem; font-weight:800; color:#181512; margin:0;">4-Stage Onboarding Verification Audit</h4>
                <p style="font-size:0.75rem; color:#78716C; margin:2px 0 0 0;">Mandatory compliance gate for B2B wholesale access and revolving credit approval.</p>
            </div>
        </div>
        <div style="display:flex; align-items:center; gap:8px;">
            <span class="dt-cust-badge" style="background:#DCFCE7; color:#15803D; border:1px solid #86EFAC; font-weight:800; font-size:0.75rem; padding:4px 10px; border-radius:6px;">
                ✓ 4 of 4 Verified (100%)
            </span>
            <button type="button" class="dt-btn dt-btn-gold" style="height:32px; font-size:0.75rem; padding:0 12px;" onclick="approveAllKycStages()">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <span>Approve All KYC</span>
            </button>
        </div>
    </div>

    <!-- 4-Stage Cards Grid -->
    <div style="display:flex; flex-direction:column; gap:10px;">
        <?php foreach ($stages as $s): ?>
            <div id="<?php echo $s['id']; ?>" class="dt-audit-row" style="background:#FAF8F4; border:1.2px solid #EAE5D9; border-radius:10px; padding:14px 16px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; transition:all 0.2s ease;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="width:34px; height:34px; border-radius:8px; background:#FFFFFF; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F; flex-shrink:0;">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><?php echo $s['icon']; ?></svg>
                    </div>
                    <div>
                        <strong class="stage-title" style="font-size:0.86rem; color:#181512; display:block; font-weight:800;"><?php echo $s['name']; ?></strong>
                        <small style="font-size:0.72rem; color:#78716C; font-weight:600;"><?php echo $s['sub']; ?></small>
                    </div>
                </div>

                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="text-align:right;">
                        <span class="stage-status-badge dt-reseller-badge emerald" style="font-size:0.72rem; font-weight:800;">✓ <?php echo $s['status']; ?></span>
                        <div class="stage-audit-meta" style="font-size:0.68rem; color:#78716C; margin-top:2px; font-weight:600;">By <?php echo $s['verifier']; ?> on <?php echo $s['date']; ?></div>
                    </div>

                    <div style="display:flex; align-items:center; gap:6px;">
                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="openAuditModal('<?php echo $s['id']; ?>', '<?php echo addslashes($s['name']); ?>')">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            <span>Re-Verify</span>
                        </button>
                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="color:#DC2626; border-color:#FECACA;" onclick="openRejectModal('<?php echo $s['id']; ?>', '<?php echo addslashes($s['name']); ?>')">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                            <span>Reject</span>
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
