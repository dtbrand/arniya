<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * bulk-actions.php — DT Brand's & Jai Hanuman Tex
 * Retail Sticky Bulk Action Bar Component
 */
?>

<div id="retailBulkActionBar" style="display:none; position:fixed; bottom:24px; left:50%; transform:translateX(-50%); background:#181512; border:1.5px solid #D4AF37; border-radius:10px; padding:10px 18px; box-shadow:0 10px 30px rgba(0,0,0,0.5); z-index:9999; align-items:center; gap:14px;">
    <span style="color:#FAF5E8; font-size:0.8rem; font-weight:700;">
        <span id="retailBulkSelectedCount" style="color:#FFE57F; font-weight:900;">0</span> records selected
    </span>
    <div style="display:flex; align-items:center; gap:8px;">
        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="executeRetailBulkAction('export')">
            <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            <span>Export Selected</span>
        </button>
        <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="executeRetailBulkAction('segment_assign')">
            <span>Assign to Cohort</span>
        </button>
        <button type="button" class="dt-btn dt-btn-dark dt-btn-sm" onclick="document.querySelectorAll('.retail-row-checkbox').forEach(c=>c.checked=false); updateRetailBulkActionCount();">
            <span>Deselect All</span>
        </button>
    </div>
</div>
