<?php
/**
 * customer-tags.php — Customer Tagging Studio Component
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
?>

<!-- ══ CUSTOMER TAGGING STUDIO ══ -->
<div>
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
        <div>
            <h4 style="font-size:0.95rem; font-weight:800; color:#181512; margin:0;">Customer Tagging Studio</h4>
            <p style="font-size:0.72rem; color:#78716C; margin:2px 0 0 0;">Create and assign dynamic categorization tags to shoppers.</p>
        </div>
    </div>

    <!-- Add Tag Form -->
    <form onsubmit="addCustomerTag(event)" style="display:flex; gap:8px; margin-bottom:16px;">
        <input type="text" id="dtCustNewTagInput" class="dt-cust-search-input" style="padding-left:12px; max-width:320px;" placeholder="Create new tag (e.g. Surat Local, Saree Lover)...">
        <button type="submit" class="dt-btn dt-btn-gold dt-btn-sm">+ Create Tag</button>
    </form>

    <div style="font-size:0.72rem; font-weight:800; color:#78716C; text-transform:uppercase; margin-bottom:8px;">Popular Customer Tags</div>
    <div class="dt-cust-tags-wrap" style="gap:8px;">
        <span class="dt-cust-tag-chip gold">
            <span>VIP High-Value (312)</span>
            <button type="button" class="dt-cust-tag-remove" onclick="this.parentElement.remove()">✕</button>
        </span>
        <span class="dt-cust-tag-chip purple">
            <span>Saree Enthusiast (840)</span>
            <button type="button" class="dt-cust-tag-remove" onclick="this.parentElement.remove()">✕</button>
        </span>
        <span class="dt-cust-tag-chip green">
            <span>Frequent Buyer (1,850)</span>
            <button type="button" class="dt-cust-tag-remove" onclick="this.parentElement.remove()">✕</button>
        </span>
        <span class="dt-cust-tag-chip blue">
            <span>Bridal Lehenga (184)</span>
            <button type="button" class="dt-cust-tag-remove" onclick="this.parentElement.remove()">✕</button>
        </span>
        <span class="dt-cust-tag-chip">
            <span>Dormant > 60 Days (640)</span>
            <button type="button" class="dt-cust-tag-remove" onclick="this.parentElement.remove()">✕</button>
        </span>
    </div>
</div>
