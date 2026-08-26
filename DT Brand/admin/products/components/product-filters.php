<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * product-filters.php — Advanced Multi-Select Filters Bar
 */
?>
<div class="dt-filters-bar">
    <select class="dt-filter-pill-select" id="dtFilterCategory" onchange="if(typeof filterProductTable==='function') filterProductTable(this.value);">
        <option value="all">All Categories</option>
        <option value="Silk Sarees">Silk Sarees (420)</option>
        <option value="Banarasi">Banarasi Brocade (280)</option>
        <option value="Bridal Lehengas">Bridal Lehengas (160)</option>
        <option value="Designer Kurtis">Designer Kurtis (240)</option>
        <option value="Dress Materials">Dress Materials (140)</option>
    </select>

    <select class="dt-filter-pill-select" id="dtFilterSubcategory" onchange="if(typeof filterProductTable==='function') filterProductTable(this.value);">
        <option value="all">All Subcategories</option>
        <option value="Kanjivaram">Kanjivaram Silk</option>
        <option value="Paithani">Paithani Zari</option>
        <option value="Mysore">Mysore Crepe</option>
    </select>

    <select class="dt-filter-pill-select" id="dtFilterBrand" onchange="if(typeof filterProductTable==='function') filterProductTable(this.value);">
        <option value="all">All Brands</option>
        <option value="DT Signature">DT Signature (680)</option>
        <option value="Arniya Heritage">Arniya Heritage (420)</option>
        <option value="DT Couture">DT Couture (140)</option>
    </select>

    <select class="dt-filter-pill-select" id="dtFilterStock" onchange="if(typeof filterProductTable==='function') filterProductTable(this.value);">
        <option value="all">All Stock Status</option>
        <option value="In Stock">In Stock (&gt; 10 pcs)</option>
        <option value="Low Stock">Low Stock (&lt; 5 pcs)</option>
        <option value="Out of Stock">Out of Stock</option>
    </select>

    <select class="dt-filter-pill-select" id="dtFilterPrice" onchange="if(typeof filterProductTable==='function') filterProductTable(this.value);">
        <option value="all">Price Range</option>
        <option value="Under 2000">Under ₹2,000</option>
        <option value="2000-5000">₹2,000 – ₹5,000</option>
        <option value="Above 5000">Above ₹5,000</option>
    </select>

    <select class="dt-filter-pill-select" id="dtFilterSort" onchange="if(typeof sortProductTable==='function') sortProductTable(this.value);">
        <option value="newest">Sort: Newest First</option>
        <option value="oldest">Sort: Oldest First</option>
        <option value="name_asc">Name: A – Z</option>
        <option value="name_desc">Name: Z – A</option>
        <option value="price_low">Price: Low – High</option>
        <option value="price_high">Price: High – Low</option>
        <option value="stock_high">Stock: High – Low</option>
        <option value="rating_high">Highest Rated ★</option>
    </select>

    <button type="button" class="adm-btn-secondary" style="height:34px; padding:0 12px; font-size:0.75rem;" onclick="if(typeof resetFilters==='function') resetFilters();">↺ Reset</button>
    <button type="button" class="adm-btn-secondary" style="height:34px; padding:0 12px; font-size:0.75rem;" onclick="window.showToast('💾 Saved current filter preset to My Saved Filters!');">💾 Save Filter</button>
</div>
