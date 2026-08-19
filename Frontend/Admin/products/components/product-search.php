<?php
/**
 * product-search.php — Debounced Product Search with Left Icon & Clear Button
 */
?>
<div class="dt-search-wrap">
    <svg class="dt-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
    </svg>
    <input type="text" id="dtProductSearch" class="dt-search-input" placeholder="Search by product name, SKU (e.g. KLN-SR-111), barcode, category, brand..." oninput="if(typeof filterProductTable==='function') filterProductTable(this.value);" autocomplete="off">
    <button type="button" id="dtProductSearchClear" class="dt-search-clear" onclick="document.getElementById('dtProductSearch').value=''; if(typeof filterProductTable==='function') filterProductTable('');">✕</button>

    <!-- Search Suggestions Dropdown -->
    <div class="dt-search-suggestions" id="dtSearchSuggestions">
        <div style="padding:6px 12px; font-size:0.7rem; font-weight:800; color:#7A7266; text-transform:uppercase;">Recent Searches</div>
        <div class="dt-suggestion-item" onclick="document.getElementById('dtProductSearch').value='Kanjivaram'; filterProductTable('Kanjivaram');">
            <span>🔍 Kanjivaram Pure Silk</span>
            <small style="color:#8A681F;">Sarees</small>
        </div>
        <div class="dt-suggestion-item" onclick="document.getElementById('dtProductSearch').value='KLN-SR-111'; filterProductTable('KLN-SR-111');">
            <span>🏷️ SKU: KLN-SR-111</span>
            <small style="color:#8A681F;">Silk Zari Saree</small>
        </div>
        <div class="dt-suggestion-item" onclick="document.getElementById('dtProductSearch').value='Banarasi'; filterProductTable('Banarasi');">
            <span>✨ Banarasi Brocade Weave</span>
            <small style="color:#8A681F;">Brocade</small>
        </div>
    </div>
</div>
