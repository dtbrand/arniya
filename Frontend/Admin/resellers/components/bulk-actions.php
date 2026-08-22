<?php
/**
 * bulk-actions.php — DT Brand's & Jai Hanuman Tex
 * Floating Multi-Select Bulk Actions Bar
 */
?>

<div id="dtResellerBulkActionBar" 
     style="display:none; position:fixed; bottom:24px; left:50%; transform:translateX(-50%); background:#181512; border:1.5px solid #D4AF37; border-radius:12px; padding:10px 18px; box-shadow:0 12px 36px rgba(0,0,0,0.5); z-index:999; align-items:center; gap:14px; flex-wrap:wrap;">
    
    <div style="display:flex; align-items:center; gap:8px;">
        <span style="width:8px; height:8px; border-radius:50%; background:#D4AF37; display:inline-block;"></span>
        <strong id="dtBulkSelectedCount" style="color:#FAF5E8; font-size:0.8rem; font-weight:800;">0 Resellers Selected</strong>
    </div>

    <div style="height:20px; width:1px; background:#3D342A;"></div>

    <div style="display:flex; align-items:center; gap:8px;">
        <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="bulkApproveResellers()">
            <span>✓ Bulk Approve</span>
        </button>
        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="bulkSuspendResellers()">
            <span style="color:#DC2626;">Suspend</span>
        </button>
        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="bulkExportResellers()">
            <span>Export Selected</span>
        </button>
        <button type="button" class="dt-btn dt-btn-dark dt-btn-sm" onclick="closeBulkActionBar()" style="color:#A8A29E !important;">
            <span>✕ Cancel</span>
        </button>
    </div>
</div>
