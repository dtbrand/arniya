<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * retail-activity.php — DT Brand's & Jai Hanuman Tex
 * Retail Live Shopping Activity Timeline Stream Component
 */
require_once __DIR__ . '/retail-data.php';
$stream = getRetailActivityStream();
?>

<div class="dt-retail-card">
    <div class="dt-retail-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
            <h4 class="dt-retail-card-title">Real-Time Retail Activity Stream</h4>
        </div>
        <span class="dt-status-pill-clean emerald">Live Feed</span>
    </div>

    <div style="padding:16px; display:flex; flex-direction:column; gap:10px;">
        <?php foreach ($stream as $s): ?>
            <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:12px 14px; display:flex; justify-content:space-between; align-items:flex-start; gap:12px;">
                <div style="display:flex; gap:10px; align-items:flex-start;">
                    <span class="dt-status-pill-clean <?php echo $s['badge']; ?>" style="margin-top:2px;"><?php echo $s['event']; ?></span>
                    <div>
                        <strong style="color:#181512; font-size:0.8rem; display:block;"><?php echo htmlspecialchars($s['user']); ?></strong>
                        <span style="font-size:0.75rem; color:#4B5563; font-weight:500;"><?php echo htmlspecialchars($s['desc']); ?></span>
                    </div>
                </div>
                <span style="font-size:0.7rem; color:#78716C; white-space:nowrap;"><?php echo $s['time']; ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</div>
