<?php
/**
 * product-filters.php — Advanced Multi-Filter Selector Bar
 */
?>
<div class="dt-filters-bar">
    <select class="dt-filter-pill-select" onchange="window.filterProductTable(this.value)">
        <option value="all">All Categories</option>
        <option value="Silk Sarees">Silk Sarees</option>
        <option value="Banarasi">Banarasi Brocade</option>
        <option value="Bridal Lehengas">Bridal Lehengas</option>
        <option value="Designer Kurtis">Designer Kurtis</option>
        <option value="Dress Materials">Dress Materials</option>
    </select>

    <select class="dt-filter-pill-select" onchange="window.filterProductTable(this.value)">
        <option value="all">All Brands</option>
        <option value="DT Signature">DT Signature</option>
        <option value="Arniya Heritage">Arniya Heritage</option>
        <option value="DT Couture">DT Couture</option>
        <option value="DT Prêt">DT Prêt</option>
    </select>

    <select class="dt-filter-pill-select" onchange="window.filterProductTable(this.value)">
        <option value="all">All Stock Status</option>
        <option value="In Stock">In Stock (&gt; 10 pcs)</option>
        <option value="Low Stock">Low Stock (&lt; 5 pcs)</option>
        <option value="Out of Stock">Out of Stock</option>
    </select>

    <select class="dt-filter-pill-select" onchange="window.filterProductTable(this.value)">
        <option value="all">All Price Ranges</option>
        <option value="Under 2000">Under ₹2,000</option>
        <option value="2000-5000">₹2,000 – ₹5,000</option>
        <option value="Above 5000">Above ₹5,000</option>
    </select>

    <select class="dt-filter-pill-select" onchange="window.filterProductTable(this.value)">
        <option value="all">Product Visibility</option>
        <option value="Featured">Featured</option>
        <option value="Best Seller">Best Seller</option>
        <option value="New Arrival">New Arrival</option>
    </select>

    <button type="button" class="adm-btn-secondary" style="height:34px; padding:0 12px; font-size:0.75rem;" onclick="window.resetFilters()">↺ Reset</button>
    <button type="button" class="adm-btn-secondary" style="height:34px; padding:0 12px; font-size:0.75rem;" onclick="window.showToast('Filter preset saved to My Saved Filters!')">💾 Save Filter</button>
</div>
