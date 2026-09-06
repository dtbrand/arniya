<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * bulk-actions.php — Catalogue Bulk Actions Processing Component
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-cat-card" style="padding:14px; background:#FAF5E8; border:1px solid #D4AF37;">
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
        <div style="font-size:12px; font-weight:700; color:#8A681F; display:flex; align-items:center; gap:6px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
            <span>Quick Bulk Batch Controller: Select items to batch activate, feature, or reassign parent hierarchy.</span>
        </div>
        <div style="display:flex; gap:6px;">
            <button type="button" class="dt-btn-action-sm pale-gold" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Selected items marked as Featured')">Bulk Feature</button>
            <button type="button" class="dt-btn-action-sm pale-gold" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Selected items activated')">Bulk Activate</button>
            <button type="button" class="dt-btn-action-sm danger" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Selected items moved to trash')">Bulk Trash</button>
        </div>
    </div>
</div>
