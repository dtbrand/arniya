<?php
/**
 * product-filters.php — Advanced Multi-Select Filters Bar
 *
 * The category/brand dropdowns used to be hard-coded demo lists with
 * invented counts ("Silk Sarees (420)", "DT Signature (680)"). They are now
 * rendered from the live categories and product_brands tables when this
 * component is included from a page that has connected the database. The
 * "Save Filter" preset button is gone — it only raised a toast and there is
 * no presets feature behind it (logged in AI/KNOWN_ISSUES.md if wanted).
 */
?>
<div class="dt-filters-bar">
    <select class="dt-filter-pill-select" id="dtFilterCategory" onchange="if(typeof filterProductTable==='function') filterProductTable(this.value);">
        <option value="all">All Categories</option>
        <?php if (!empty($filterCategoriesList)): ?>
            <?php foreach ($filterCategoriesList as $fc): ?>
                <option value="<?= htmlspecialchars((string)$fc['name']) ?>"><?= htmlspecialchars((string)$fc['name']) ?> (<?= (int)($fc['cnt'] ?? 0) ?>)</option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>

    <select class="dt-filter-pill-select" id="dtFilterSubcategory" onchange="if(typeof filterProductTable==='function') filterProductTable(this.value);">
        <option value="all">All Subcategories</option>
        <?php if (!empty($filterSubcategoriesList)): ?>
            <?php foreach ($filterSubcategoriesList as $fs): ?>
                <option value="<?= htmlspecialchars((string)$fs['name']) ?>"><?= htmlspecialchars((string)$fs['name']) ?></option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>

    <select class="dt-filter-pill-select" id="dtFilterBrand" onchange="if(typeof filterProductTable==='function') filterProductTable(this.value);">
        <option value="all">All Brands</option>
        <?php if (!empty($filterBrandsList)): ?>
            <?php foreach ($filterBrandsList as $fb): ?>
                <option value="<?= htmlspecialchars((string)$fb['name']) ?>"><?= htmlspecialchars((string)$fb['name']) ?> (<?= (int)($fb['cnt'] ?? 0) ?>)</option>
            <?php endforeach; ?>
        <?php endif; ?>
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
</div>