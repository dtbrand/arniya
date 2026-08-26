<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * customer-notes.php — Internal Staff Notes & Action Items
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
?>

<!-- ══ INTERNAL STAFF NOTES & MEMO PANEL ══ -->
<div class="dt-cust-notes-stream">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:4px;">
        <h4 style="font-size:0.9rem; font-weight:800; color:#181512; margin:0;">Internal Staff Notes</h4>
        <span style="font-size:0.7rem; color:#78716C;">Visible to Admin & Support Staff only</span>
    </div>

    <!-- Add Note Box -->
    <form onsubmit="addCustomerQuickNote(event)" style="display:flex; flex-direction:column; gap:8px; margin-bottom:12px;">
        <textarea id="dtCustNewNoteText" class="dt-cust-search-input" style="height:64px; resize:none; padding-left:12px;" placeholder="Write an internal customer memo (e.g. VIP client, preferred delivery time 4-6 PM)..."></textarea>
        <div style="display:flex; align-items:center; justify-content:space-between;">
            <label style="display:inline-flex; align-items:center; gap:6px; font-size:0.72rem; font-weight:700; color:#181512; cursor:pointer;">
                <input type="checkbox" id="dtCustNoteImportantChk">
                <span>Mark as Important Note</span>
            </label>
            <button type="submit" class="dt-btn dt-btn-gold dt-btn-sm">+ Save Staff Note</button>
        </div>
    </form>

    <!-- Notes Stream -->
    <div id="dtCustNotesStream" style="display:flex; flex-direction:column; gap:8px;">
        <div class="dt-cust-note-card important">
            <div class="dt-cust-note-head">
                <span>Gautam S. (Admin) • 04 Mar 2026</span>
                <span class="dt-status-pill suspended" style="font-size:0.6rem; padding:1px 5px;">★ Urgent Note</span>
            </div>
            <div class="dt-cust-note-body">
                Customer prefers premium gold gift packaging for all wedding sari orders. Always dispatch with DT Brand's silk mark certificate.
            </div>
        </div>

        <div class="dt-cust-note-card">
            <div class="dt-cust-note-head">
                <span>Support Team • 18 Jan 2026</span>
                <span style="font-size:0.65rem; color:#78716C;">General Note</span>
            </div>
            <div class="dt-cust-note-body">
                Confirmed WhatsApp phone number. Delivery address verified with landmark opposite Rohini Metro Station.
            </div>
        </div>
    </div>
</div>
