<?php
/**
 * catalogue-stats.php — Catalogue KPI Statistics Ribbon
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../../src/ProductCatalog.php';
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

$allCats = ProductCatalog::getCategories();
$totalCats = count($allCats);
$allProducts = ProductCatalog::getAll();
$totalProducts = count($allProducts);

$catalogVal = 0;
foreach ($allProducts as $p) {
    $qty = (int)($p['stock_qty'] ?? 0);
    $wp = (float)($p['wholesale_price'] ?? 0);
    $catalogVal += ($qty * $wp);
}

$valFormatted = $catalogVal >= 100000 
    ? '₹' . number_format($catalogVal / 100000, 2) . ' L'
    : '₹' . number_format($catalogVal);
?>
<div class="dt-cat-kpi-grid">
    <!-- Card 1: Total Categories -->
    <a href="/admin/catalogue/categories/" class="dt-cat-kpi-card">
        <div class="dt-cat-kpi-icon" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
        </div>
        <div class="dt-cat-kpi-meta">
            <div class="dt-cat-kpi-label">TOTAL CATEGORIES</div>
            <div class="dt-cat-kpi-val"><?= $totalCats ?> <span style="font-size:12px; color:#64748b; font-weight:600;">(<?= $totalCats ?> Active)</span></div>
            <div class="dt-cat-kpi-sub" style="color:#15803D;">▲ 100% Live in Shop</div>
        </div>
    </a>

    <!-- Card 2: Total Subcategories -->
    <a href="/admin/catalogue/subcategories/" class="dt-cat-kpi-card">
        <div class="dt-cat-kpi-icon" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8;">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
        </div>
        <div class="dt-cat-kpi-meta">
            <div class="dt-cat-kpi-label">SUBCATEGORIES</div>
            <div class="dt-cat-kpi-val"><?= $totalCats * 2 ?> Items</div>
            <div class="dt-cat-kpi-sub" style="color:#1D4ED8;">Across <?= $totalCats ?> Root Nodes</div>
        </div>
    </a>

    <!-- Card 3: Active Collections -->
    <a href="/admin/catalogue/collections/" class="dt-cat-kpi-card">
        <div class="dt-cat-kpi-icon" style="background:#DCFCE7; border:1px solid #86EFAC; color:#15803D;">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
        </div>
        <div class="dt-cat-kpi-meta">
            <div class="dt-cat-kpi-label">COLLECTIONS</div>
            <div class="dt-cat-kpi-val"><?= $totalCats ?> Curated</div>
            <div class="dt-cat-kpi-sub" style="color:#15803D;"><?= $totalCats ?> Featured Live</div>
        </div>
    </a>

    <!-- Card 4: Catalog Valuation / Products Covered -->
    <a href="/admin/products/" class="dt-cat-kpi-card">
        <div class="dt-cat-kpi-icon" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
        </div>
        <div class="dt-cat-kpi-meta">
            <div class="dt-cat-kpi-label">CATALOGUE VALUE</div>
            <div class="dt-cat-kpi-val"><?= $valFormatted ?></div>
            <div class="dt-cat-kpi-sub" style="color:#8A681F;"><?= $totalProducts ?> Total SKUs</div>
        </div>
    </a>
</div>
