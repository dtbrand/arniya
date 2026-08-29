<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * retail-checkout.php — DT Brand's & Jai Hanuman Tex
 * Retail 7-Step Checkout Funnel Diagnostics Component
 */
require_once __DIR__ . '/retail-data.php';
$funnel = getRetailCheckoutFunnel();
?>

<div class="dt-retail-card">
    <div class="dt-retail-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
            <h4 class="dt-retail-card-title">7-Step Retail Checkout Funnel Analysis</h4>
        </div>
        <span class="dt-status-pill-clean emerald">Overall 33.5% Conversion</span>
    </div>

    <div style="padding:16px;">
        <div class="dt-funnel-step-list">
            <?php foreach ($funnel as $f): ?>
                <div class="dt-funnel-step-item">
                    <div class="dt-funnel-step-header">
                        <strong style="color:#181512;"><?php echo htmlspecialchars($f['step']); ?></strong>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="font-weight:900; color:#181512;"><?php echo $f['count']; ?> (<?php echo $f['pct']; ?>)</span>
                            <?php if ($f['drop'] !== '—'): ?>
                                <span class="dt-status-pill-clean crimson"><?php echo $f['drop']; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="dt-funnel-progress-wrap">
                        <div class="dt-funnel-progress-bar" style="width:<?php echo $f['pct']; ?>; background:<?php echo $f['color']; ?>;"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
