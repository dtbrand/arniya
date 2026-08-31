<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * bulk-actions.php — Catalogue Bulk Actions Processing Component
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-cat-card" style="padding:14px; background:#FAF5E8; border:1px solid #D4AF37;">
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
        <div style="font-size:12px; font-weight:700; color:#8A681F;">
            ⚡ Quick Bulk Batch Controller: Select items to batch activate, feature, or reassign parent hierarchy.
        </div>
        <div style="display:flex; gap:6px;">
            <button type="button" class="dt-btn-action-sm pale-gold" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Selected items marked as Featured')">Bulk Feature</button>
            <button type="button" class="dt-btn-action-sm pale-gold" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Selected items activated')">Bulk Activate</button>
            <button type="button" class="dt-btn-action-sm danger" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Selected items moved to trash')">Bulk Trash</button>
        </div>
    </div>
</div>
