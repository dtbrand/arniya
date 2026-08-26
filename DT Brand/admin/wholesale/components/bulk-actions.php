<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * bulk-actions.php — DT Brand's & Jai Hanuman Tex
 * Multi-Row Bulk Action Bar Component
 */
?>
<div id="dtWholesaleBulkBar" style="display:none; padding:10px 18px; background:linear-gradient(135deg, #181512 0%, #2A241E 100%); color:#FFFFFF; border-bottom:1.5px solid #8A681F; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
    <div style="display:flex; align-items:center; gap:8px; font-size:0.78rem; font-weight:800;">
        <span style="color:#FFE57F;"><span id="wholesaleSelectedCount">0</span> Wholesalers Selected</span>
    </div>

    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
        <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" onclick="executeWholesaleBulkAction('approve')">
            <span>Approve Selected</span>
        </button>
        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="executeWholesaleBulkAction('assign-tier')">
            <span>Assign Tier</span>
        </button>
        <button type="button" class="dt-btn dt-btn-danger dt-btn-sm" onclick="executeWholesaleBulkAction('suspend')">
            <span>Suspend Selected</span>
        </button>
        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="executeWholesaleBulkAction('export')">
            <span>Export Selected</span>
        </button>
    </div>
</div>
