<?php
/**
 * product-search.php — Search Input with Left-Aligned Icon, Clear Button & Debounce
 */
?>
<div class="dt-search-wrap">
    <svg class="dt-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
    </svg>
    <input type="text" id="dtProductSearch" class="dt-search-input" placeholder="Search by name, SKU (e.g. KLN-SR-111), category, brand..." oninput="window.filterProductTable(this.value)">
    <button type="button" id="dtProductSearchClear" class="dt-search-clear" onclick="document.getElementById('dtProductSearch').value=''; window.filterProductTable('');">✕</button>
</div>
