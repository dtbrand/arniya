<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * reseller-tags.php — DT Brand's & Jai Hanuman Tex
 * Reseller Dynamic Tagging & Classification Studio
 */
$tags = [
    ['name' => 'Surat Hub Leader', 'color' => 'gold', 'count' => 48],
    ['name' => 'High-GMV Star', 'color' => 'emerald', 'count' => 36],
    ['name' => 'Fast Dropshipper', 'color' => 'blue', 'count' => 84],
    ['name' => 'Wedding Season Bulk', 'color' => 'purple', 'count' => 52],
    ['name' => 'Zero-Default Credit', 'color' => 'emerald', 'count' => 112],
    ['name' => 'KYC Verified', 'color' => 'gold', 'count' => 296]
];
?>

<div class="dt-card" style="padding:18px;">
    <div class="dt-card-head" style="margin-bottom:14px;">
        <h4 class="dt-card-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.5"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
            <span>Active Reseller Tags &amp; Classification</span>
        </h4>
        <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="window.showToast('Tag creator opened')">+ Create Tag</button>
    </div>

    <div style="display:flex; flex-wrap:wrap; gap:8px;">
        <?php foreach ($tags as $t): ?>
            <div style="display:inline-flex; align-items:center; gap:6px; background:#FAF5E8; border:1px solid #D4AF37; border-radius:20px; padding:4px 12px; font-size:0.75rem; font-weight:700; color:#8A681F;">
                <span>🏷️ <?php echo htmlspecialchars($t['name']); ?></span>
                <span style="background:#8A681F; color:#FFFFFF; border-radius:10px; padding:1px 6px; font-size:0.65rem;"><?php echo $t['count']; ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</div>
