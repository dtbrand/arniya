<?php
/**
 * wholesale-tags.php — DT Brand's & Jai Hanuman Tex
 * Wholesale Account Badges & Tagging Manager
 */
?>
<div class="dt-card">
    <div class="dt-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
            <h4 class="dt-card-title">Commercial Tags &amp; Badges</h4>
        </div>
    </div>

    <div style="padding:16px; display:flex; flex-direction:column; gap:12px;">
        <div style="display:flex; flex-wrap:wrap; gap:8px;">
            <span class="dt-status-pill-clean gold">VIP Mega Sourcing</span>
            <span class="dt-status-pill-clean emerald">100% On-Time NEFT</span>
            <span class="dt-status-pill-clean blue">Pure Silk Specialist</span>
            <span class="dt-status-pill-clean gold">Surat Central Hub</span>
        </div>

        <div style="display:flex; gap:8px; margin-top:6px;">
            <input type="text" id="newWholesaleTagInput" placeholder="Add new commercial tag..." style="flex:1; height:32px; font-size:0.75rem; border:1.2px solid #EAE5D9; border-radius:6px; padding:0 8px;">
            <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="window.showToast('✓ Tag assigned to account');">+ Tag</button>
        </div>
    </div>
</div>
