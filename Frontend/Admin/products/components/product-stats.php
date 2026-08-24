<?php
/**
 * product-stats.php — 9 Product Dynamic KPI Metric Cards with Crisp Vector SVG Icons
 * DT Brand's & Jai Hanuman Tex
 */
$prods = isset($productsList) && is_array($productsList) ? $productsList : \DTBrand\ProductCatalog::getAll();
$totalCount = count($prods);
$activeCount = 0;
$draftCount = 0;
$inactiveCount = 0;
$lowStockCount = 0;
$outOfStockCount = 0;
$featuredCount = 0;
$bestSellerCount = 0;
$newArrivalCount = 0;

foreach ($prods as $p) {
    $st = strtolower($p['status'] ?? 'in_stock');
    $qty = isset($p['stock_qty']) ? (int)$p['stock_qty'] : 0;
    
    if ($st === 'in_stock' || $st === 'active' || $st === 'published') {
        $activeCount++;
    } elseif ($st === 'draft') {
        $draftCount++;
    } else {
        $inactiveCount++;
    }

    if ($qty <= 0) {
        $outOfStockCount++;
    } elseif ($qty < 10) {
        $lowStockCount++;
    }

    if (!empty($p['is_featured']) || ($p['rating'] ?? 0) >= 4.9) $featuredCount++;
    if (!empty($p['is_best_seller']) || ($p['orders_count'] ?? 0) > 10) $bestSellerCount++;
    if (!empty($p['is_new_arrival'])) $newArrivalCount++;
}
?>
<div class="dt-summary-grid">
    <!-- 1. Total Products -->
    <div class="dt-summary-card active" onclick="if(typeof filterProductTable==='function') filterProductTable(''); window.showToast('Showing all <?= $totalCount ?> catalog products');">
        <div class="dt-sum-top">
            <div class="dt-kpi-icon-box gold">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
            </div>
            <span class="dt-sum-trend up">Live Database</span>
        </div>
        <div class="dt-sum-val"><?= number_format($totalCount) ?></div>
        <div class="dt-sum-lbl">Total Products</div>
        <div style="font-size:0.65rem; color:#7A7266; margin-top:2px;">Live MySQL SKUs</div>
    </div>

    <!-- 2. Active Products -->
    <div class="dt-summary-card" onclick="if(typeof filterProductTable==='function') filterProductTable('Active'); window.showToast('Filtering: Active Products');">
        <div class="dt-sum-top">
            <div class="dt-kpi-icon-box green">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>
            <span class="dt-sum-trend up"><?= $totalCount > 0 ? round(($activeCount / $totalCount) * 100) : 100 ?>% Live</span>
        </div>
        <div class="dt-sum-val"><?= number_format($activeCount) ?></div>
        <div class="dt-sum-lbl">Active Products</div>
        <div style="font-size:0.65rem; color:#15803D; margin-top:2px;">In Shop &amp; B2B</div>
    </div>

    <!-- 3. Draft Products -->
    <div class="dt-summary-card" onclick="if(typeof filterProductTable==='function') filterProductTable('Draft'); window.showToast('Filtering: Draft Products');">
        <div class="dt-sum-top">
            <div class="dt-kpi-icon-box blue">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            </div>
            <span class="dt-sum-trend" style="background:#F1F5F9; color:#475569;">Review</span>
        </div>
        <div class="dt-sum-val"><?= number_format($draftCount) ?></div>
        <div class="dt-sum-lbl">Draft Products</div>
        <div style="font-size:0.65rem; color:#7A7266; margin-top:2px;">Pending QA</div>
    </div>

    <!-- 4. Inactive Products -->
    <div class="dt-summary-card" onclick="if(typeof filterProductTable==='function') filterProductTable('Inactive'); window.showToast('Filtering: Inactive Products');">
        <div class="dt-sum-top">
            <div class="dt-kpi-icon-box slate">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="10" y1="15" x2="10" y2="9"></line><line x1="14" y1="15" x2="14" y2="9"></line></svg>
            </div>
            <span class="dt-sum-trend" style="background:#F1F5F9; color:#475569;">Paused</span>
        </div>
        <div class="dt-sum-val"><?= number_format($inactiveCount) ?></div>
        <div class="dt-sum-lbl">Inactive</div>
        <div style="font-size:0.65rem; color:#7A7266; margin-top:2px;">Archived SKUs</div>
    </div>

    <!-- 5. Low Stock -->
    <div class="dt-summary-card" onclick="if(typeof filterProductTable==='function') filterProductTable('Low Stock'); window.showToast('Filtering: Low Stock (< 10 pcs)');">
        <div class="dt-sum-top">
            <div class="dt-kpi-icon-box amber">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
            </div>
            <span class="dt-sum-trend down">&lt; 10 pcs</span>
        </div>
        <div class="dt-sum-val" style="color:#B45309;"><?= number_format($lowStockCount) ?></div>
        <div class="dt-sum-lbl">Low Stock</div>
        <div style="font-size:0.65rem; color:#B45309; margin-top:2px;">Reorder needed</div>
    </div>

    <!-- 6. Out of Stock -->
    <div class="dt-summary-card" onclick="if(typeof filterProductTable==='function') filterProductTable('Out of Stock'); window.showToast('Filtering: Out of Stock');">
        <div class="dt-sum-top">
            <div class="dt-kpi-icon-box red">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>
            </div>
            <span class="dt-sum-trend down">Restock</span>
        </div>
        <div class="dt-sum-val" style="color:#DC2626;"><?= number_format($outOfStockCount) ?></div>
        <div class="dt-sum-lbl">Out of Stock</div>
        <div style="font-size:0.65rem; color:#DC2626; margin-top:2px;">Weaving in mill</div>
    </div>

    <!-- 7. Featured Products -->
    <div class="dt-summary-card" onclick="if(typeof filterProductTable==='function') filterProductTable('Featured'); window.showToast('Filtering: Featured Products');">
        <div class="dt-sum-top">
            <div class="dt-kpi-icon-box gold">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
            </div>
            <span class="dt-sum-trend up">Top Spot</span>
        </div>
        <div class="dt-sum-val"><?= number_format($featuredCount) ?></div>
        <div class="dt-sum-lbl">Featured</div>
        <div style="font-size:0.65rem; color:#8A681F; margin-top:2px;">Homepage show</div>
    </div>

    <!-- 8. Best Sellers -->
    <div class="dt-summary-card" onclick="if(typeof filterProductTable==='function') filterProductTable('Best Seller'); window.showToast('Filtering: Best Sellers');">
        <div class="dt-sum-top">
            <div class="dt-kpi-icon-box purple">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>
            </div>
            <span class="dt-sum-trend up">High Vol</span>
        </div>
        <div class="dt-sum-val"><?= number_format($bestSellerCount) ?></div>
        <div class="dt-sum-lbl">Best Sellers</div>
        <div style="font-size:0.65rem; color:#15803D; margin-top:2px;">Top selling lots</div>
    </div>

    <!-- 9. New Arrivals -->
    <div class="dt-summary-card" onclick="if(typeof filterProductTable==='function') filterProductTable('New Arrival'); window.showToast('Filtering: 2026 Drops');">
        <div class="dt-sum-top">
            <div class="dt-kpi-icon-box rose">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15 8 21 9 17 14 18 20 12 17 6 20 7 14 3 9 9 8 12 2"></polygon></svg>
            </div>
            <span class="dt-sum-trend up">2026 Drop</span>
        </div>
        <div class="dt-sum-val"><?= number_format($newArrivalCount) ?></div>
        <div class="dt-sum-lbl">New Arrivals</div>
        <div style="font-size:0.65rem; color:#8A681F; margin-top:2px;">Festive catalog</div>
    </div>
</div>
