<?php
/**
 * product-stats.php — 9 Product KPI Summary Metric Cards
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-summary-grid">
    <!-- 1. Total Products -->
    <div class="dt-summary-card active" onclick="if(typeof filterProductTable==='function') filterProductTable(''); window.showToast('Showing all 1,240 products');">
        <div class="dt-sum-top">
            <span class="dt-sum-icon">👗</span>
            <span class="dt-sum-trend up">↑ +14.2% MoM</span>
        </div>
        <div class="dt-sum-val">1,240</div>
        <div class="dt-sum-lbl">Total Products</div>
        <div style="font-size:0.68rem; color:#7A7266; margin-top:2px;">vs 1,085 last month</div>
    </div>

    <!-- 2. Active Products -->
    <div class="dt-summary-card" onclick="if(typeof filterProductTable==='function') filterProductTable('Active'); window.showToast('Filtering: Active Products');">
        <div class="dt-sum-top">
            <span class="dt-sum-icon">🟢</span>
            <span class="dt-sum-trend up">95.5% Live</span>
        </div>
        <div class="dt-sum-val">1,185</div>
        <div class="dt-sum-lbl">Active Products</div>
        <div style="font-size:0.68rem; color:#15803D; margin-top:2px;">Published in Shop & B2B</div>
    </div>

    <!-- 3. Draft Products -->
    <div class="dt-summary-card" onclick="if(typeof filterProductTable==='function') filterProductTable('Draft'); window.showToast('Filtering: Draft Products');">
        <div class="dt-sum-top">
            <span class="dt-sum-icon">📝</span>
            <span class="dt-sum-trend">Pending QA</span>
        </div>
        <div class="dt-sum-val">14</div>
        <div class="dt-sum-lbl">Draft Products</div>
        <div style="font-size:0.68rem; color:#7A7266; margin-top:2px;">Ready for review</div>
    </div>

    <!-- 4. Inactive Products -->
    <div class="dt-summary-card" onclick="if(typeof filterProductTable==='function') filterProductTable('Inactive'); window.showToast('Filtering: Inactive Products');">
        <div class="dt-sum-top">
            <span class="dt-sum-icon">⏸️</span>
            <span class="dt-sum-trend down">Paused</span>
        </div>
        <div class="dt-sum-val">0</div>
        <div class="dt-sum-lbl">Inactive Products</div>
        <div style="font-size:0.68rem; color:#7A7266; margin-top:2px;">Archived SKUs</div>
    </div>

    <!-- 5. Low Stock -->
    <div class="dt-summary-card" onclick="if(typeof filterProductTable==='function') filterProductTable('Low Stock'); window.showToast('Filtering: Low Stock (&lt; 5 pcs)');">
        <div class="dt-sum-top">
            <span class="dt-sum-icon">⚠️</span>
            <span class="dt-sum-trend down">&lt; 5 pcs</span>
        </div>
        <div class="dt-sum-val" style="color:#B45309;">14</div>
        <div class="dt-sum-lbl">Low Stock</div>
        <div style="font-size:0.68rem; color:#B45309; margin-top:2px;">Reorder needed</div>
    </div>

    <!-- 6. Out of Stock -->
    <div class="dt-summary-card" onclick="if(typeof filterProductTable==='function') filterProductTable('Out of Stock'); window.showToast('Filtering: Out of Stock');">
        <div class="dt-sum-top">
            <span class="dt-sum-icon">🛑</span>
            <span class="dt-sum-trend down">Restock</span>
        </div>
        <div class="dt-sum-val" style="color:#DC2626;">41</div>
        <div class="dt-sum-lbl">Out of Stock</div>
        <div style="font-size:0.68rem; color:#DC2626; margin-top:2px;">Weaving in mill</div>
    </div>

    <!-- 7. Featured Products -->
    <div class="dt-summary-card" onclick="if(typeof filterProductTable==='function') filterProductTable('Featured'); window.showToast('Filtering: Featured Products');">
        <div class="dt-sum-top">
            <span class="dt-sum-icon">⭐️</span>
            <span class="dt-sum-trend up">Top Showcase</span>
        </div>
        <div class="dt-sum-val">48</div>
        <div class="dt-sum-lbl">Featured</div>
        <div style="font-size:0.68rem; color:#8A681F; margin-top:2px;">Homepage spotlight</div>
    </div>

    <!-- 8. Best Sellers -->
    <div class="dt-summary-card" onclick="if(typeof filterProductTable==='function') filterProductTable('Best Seller'); window.showToast('Filtering: Best Sellers');">
        <div class="dt-sum-top">
            <span class="dt-sum-icon">🔥</span>
            <span class="dt-sum-trend up">High Volume</span>
        </div>
        <div class="dt-sum-val">32</div>
        <div class="dt-sum-lbl">Best Sellers</div>
        <div style="font-size:0.68rem; color:#15803D; margin-top:2px;">&gt; 100+ pcs sold</div>
    </div>

    <!-- 9. New Arrivals -->
    <div class="dt-summary-card" onclick="if(typeof filterProductTable==='function') filterProductTable('New Arrival'); window.showToast('Filtering: 2026 Drops');">
        <div class="dt-sum-top">
            <span class="dt-sum-icon">✨</span>
            <span class="dt-sum-trend up">2026 Drop</span>
        </div>
        <div class="dt-sum-val">64</div>
        <div class="dt-sum-lbl">New Arrivals</div>
        <div style="font-size:0.68rem; color:#8A681F; margin-top:2px;">Festive catalogue</div>
    </div>
</div>
