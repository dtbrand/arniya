<?php
/**
 * product-search.php — Debounced Product Search with Left SVG Icon & Clear Button
 */
?>
<div class="dt-search-wrap">
    <svg class="dt-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
    </svg>
    <input type="text" id="dtProductSearch" class="dt-search-input" placeholder="Search by product name, SKU (e.g. KLN-SR-111), barcode, category, brand..." oninput="if(typeof filterProductTable==='function') filterProductTable(this.value);" autocomplete="off">
    <button type="button" id="dtProductSearchClear" class="dt-search-clear" onclick="document.getElementById('dtProductSearch').value=''; if(typeof filterProductTable==='function') filterProductTable('');">✕</button>

    <!-- Search Suggestions Dropdown with Crisp SVGs -->
    <div class="dt-search-suggestions" id="dtSearchSuggestions">
        <div style="padding:6px 12px; font-size:0.7rem; font-weight:800; color:#7A7266; text-transform:uppercase; letter-spacing:0.04em;">Recent Searches</div>
        <div class="dt-suggestion-item" onclick="document.getElementById('dtProductSearch').value='Kanjivaram'; filterProductTable('Kanjivaram');">
            <span style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <span>Kanjivaram Pure Silk</span>
            </span>
            <small style="color:#8A681F; font-weight:700;">Silk Sarees</small>
        </div>
        <div class="dt-suggestion-item" onclick="document.getElementById('dtProductSearch').value='KLN-SR-111'; filterProductTable('KLN-SR-111');">
            <span style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><circle cx="7.5" cy="7.5" r="1.5"></circle></svg>
                <span>SKU: KLN-SR-111</span>
            </span>
            <small style="color:#8A681F; font-weight:700;">Gold Zari</small>
        </div>
        <div class="dt-suggestion-item" onclick="document.getElementById('dtProductSearch').value='Banarasi'; filterProductTable('Banarasi');">
            <span style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                <span>Banarasi Brocade Weave</span>
            </span>
            <small style="color:#8A681F; font-weight:700;">Brocade</small>
        </div>
    </div>
</div>
