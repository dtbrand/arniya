<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * wholesale-notes.php — DT Brand's & Jai Hanuman Tex
 * Wholesale Account Notes & Commercial Memorandums
 */
?>
<div class="dt-card">
    <div class="dt-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            <h4 class="dt-card-title">Commercial Memorandums &amp; Notes</h4>
        </div>
    </div>

    <div style="padding:16px; display:flex; flex-direction:column; gap:12px;">
        <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:12px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                <span class="dt-status-pill-clean gold" style="font-size:0.65rem;">IMPORTANT</span>
                <span style="font-size:0.68rem; color:#78716C;">15 Aug 2026</span>
            </div>
            <p style="font-size:0.75rem; color:#181512; margin:0; font-weight:600;">Partner is requesting an additional ₹2,00,000 credit limit bump before Diwali season rush. Payment track record has been 100% clean across 64 batches.</p>
            <small style="color:#8A681F; font-size:0.68rem; font-weight:700; margin-top:4px; display:block;">— Added by Gautam V. (Senior Merchant)</small>
        </div>

        <form onsubmit="event.preventDefault(); window.showToast('✓ Note saved to partner dossier');" style="display:flex; flex-direction:column; gap:8px;">
            <textarea class="dt-wholesale-textarea" rows="2" placeholder="Add confidential internal note..." style="width:100%; padding:8px 10px; font-size:0.75rem; border:1.2px solid #EAE5D9; border-radius:8px; box-sizing:border-box;"></textarea>
            <div style="display:flex; justify-content:flex-end;">
                <button type="submit" class="dt-btn dt-btn-gold dt-btn-sm">+ Save Note</button>
            </div>
        </form>
    </div>
</div>
