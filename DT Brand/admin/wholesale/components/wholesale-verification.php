<?php
/**
 * wholesale-verification.php — DT Brand's & Jai Hanuman Tex
 * Multi-Step KYC & Verification Stepper Component (100% Dynamic)
 */

require_once __DIR__ . '/wholesale-data.php';
$whl_id = isset($_GET['id']) ? $_GET['id'] : (isset($wholesale['id']) ? $wholesale['id'] : 'WHL-8012');
$wholesale = isset($wholesale) && is_array($wholesale) ? $wholesale : getWholesalePartner($whl_id);

$is_verified = ($wholesale['verification'] === 'Verified KYC');
$sanctioned_text = $wholesale['sanctioned_limit'] > 0 ? '₹' . number_format($wholesale['sanctioned_limit']) . ' SANCTIONED' : 'NO CREDIT ASSIGNED';
?>
<div class="dt-card">
    <div class="dt-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="<?php echo $is_verified ? '#15803D' : '#B45309'; ?>" stroke-width="2.3"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
            <h4 class="dt-card-title">KYC &amp; Business Verification Audit</h4>
        </div>
        <span class="dt-status-pill-clean <?php echo $wholesale['verification_badge']; ?>">
            <?php echo $is_verified ? '100% COMPLIANT' : 'AUDIT PENDING'; ?>
        </span>
    </div>

    <div style="padding:18px; display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:14px;">
        <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:12px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                <strong style="font-size:0.75rem; color:#181512;">1. GSTIN Portal Check</strong>
                <span class="dt-status-pill-clean <?php echo $is_verified ? 'emerald' : 'amber'; ?>" style="font-size:0.62rem;"><?php echo $is_verified ? 'PASSED' : 'UNDER REVIEW'; ?></span>
            </div>
            <p style="font-size:0.68rem; color:#78716C; margin:0;">Active taxpayer: <code style="font-family:monospace; color:#8A681F;"><?php echo $wholesale['gstin']; ?></code> (<?php echo $wholesale['state']; ?> Ward).</p>
        </div>

        <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:12px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                <strong style="font-size:0.75rem; color:#181512;">2. Identity Verification</strong>
                <span class="dt-status-pill-clean <?php echo $is_verified ? 'emerald' : 'amber'; ?>" style="font-size:0.62rem;"><?php echo $is_verified ? 'PASSED' : 'PENDING'; ?></span>
            </div>
            <p style="font-size:0.68rem; color:#78716C; margin:0;">Authorized Person: <strong><?php echo htmlspecialchars($wholesale['contact']); ?></strong> (PAN: <?php echo $wholesale['pan']; ?>).</p>
        </div>

        <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:12px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                <strong style="font-size:0.75rem; color:#181512;">3. Warehouse Physical Check</strong>
                <span class="dt-status-pill-clean <?php echo $is_verified ? 'emerald' : 'amber'; ?>" style="font-size:0.62rem;"><?php echo $is_verified ? 'PASSED' : 'DISPATCH CHECK'; ?></span>
            </div>
            <p style="font-size:0.68rem; color:#78716C; margin:0;"><?php echo htmlspecialchars($wholesale['city']); ?> hub audited for wholesale logistics.</p>
        </div>

        <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:12px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                <strong style="font-size:0.75rem; color:#181512;">4. Credit Underwriting</strong>
                <span class="dt-status-pill-clean <?php echo $wholesale['credit_badge']; ?>" style="font-size:0.62rem;"><?php echo $sanctioned_text; ?></span>
            </div>
            <p style="font-size:0.68rem; color:#78716C; margin:0;">Settlement Terms: <strong><?php echo $wholesale['payment_terms']; ?></strong>.</p>
        </div>
    </div>
</div>
