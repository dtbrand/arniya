<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * wholesale-activity.php — DT Brand's & Jai Hanuman Tex
 * Immutable Audit Timeline & Account Activity Feed Component (100% Dynamic)
 */
require_once __DIR__ . '/wholesale-data.php';
$whl_id = isset($_GET['id']) ? $_GET['id'] : (isset($wholesale['id']) ? $wholesale['id'] : 'WHL-8012');
$wholesale = isset($wholesale) && is_array($wholesale) ? $wholesale : getWholesalePartner($whl_id);
$activities = getWholesaleActivities($wholesale['id']);
?>

<div class="dt-card">
    <div class="dt-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
            <h4 class="dt-card-title">Immutable Wholesale Activity &amp; Audit Trail</h4>
        </div>
        <span class="dt-status-pill-clean gold">Blockchain-Grade Audit</span>
    </div>

    <div style="padding:18px; display:flex; flex-direction:column; gap:16px;">
        <?php foreach ($activities as $a): ?>
            <div style="display:flex; align-items:flex-start; gap:12px; border-left:2px solid #D4AF37; padding-left:14px; position:relative;">
                <div style="position:absolute; left:-5px; top:3px; width:8px; height:8px; border-radius:50%; background:#8A681F;"></div>
                <div style="flex:1;">
                    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
                        <strong style="font-size:0.82rem; color:#181512;"><?php echo htmlspecialchars($a['action']); ?></strong>
                        <span style="font-size:0.7rem; color:#78716C; font-weight:600;"><?php echo $a['time']; ?></span>
                    </div>
                    <div style="font-size:0.72rem; color:#78716C; margin-top:2px;">
                        Initiated by: <strong style="color:#8A681F;"><?php echo $a['actor']; ?></strong>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
