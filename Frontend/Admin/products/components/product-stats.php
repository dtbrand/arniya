<?php
/**
 * product-stats.php — 9 Summary KPI Metric Cards
 */
?>
<div class="dt-summary-grid">
    <div class="dt-summary-card active" onclick="window.showToast('Filtering: All Products')">
        <div class="dt-sum-top">
            <span class="dt-sum-icon">👗</span>
            <span class="dt-sum-trend up">1,240 Total</span>
        </div>
        <div class="dt-sum-val">1,240</div>
        <div class="dt-sum-lbl">Total Products</div>
    </div>
    <div class="dt-summary-card" onclick="window.showToast('Filtering: Active Products')">
        <div class="dt-sum-top">
            <span class="dt-sum-icon">🟢</span>
            <span class="dt-sum-trend up">95.5%</span>
        </div>
        <div class="dt-sum-val">1,185</div>
        <div class="dt-sum-lbl">Active Products</div>
    </div>
    <div class="dt-summary-card" onclick="window.showToast('Filtering: Draft Products')">
        <div class="dt-sum-top">
            <span class="dt-sum-icon">📝</span>
            <span class="dt-sum-trend">Pending</span>
        </div>
        <div class="dt-sum-val">14</div>
        <div class="dt-sum-lbl">Draft Products</div>
    </div>
    <div class="dt-summary-card" onclick="window.showToast('Filtering: Inactive Products')">
        <div class="dt-sum-top">
            <span class="dt-sum-icon">⏸️</span>
            <span class="dt-sum-trend down">Paused</span>
        </div>
        <div class="dt-sum-val">0</div>
        <div class="dt-sum-lbl">Inactive</div>
    </div>
    <div class="dt-summary-card" onclick="window.showToast('Filtering: Low Stock')">
        <div class="dt-sum-top">
            <span class="dt-sum-icon">⚠️</span>
            <span class="dt-sum-trend down">&lt; 5 pcs</span>
        </div>
        <div class="dt-sum-val">14</div>
        <div class="dt-sum-lbl">Low Stock</div>
    </div>
    <div class="dt-summary-card" onclick="window.showToast('Filtering: Out of Stock')">
        <div class="dt-sum-top">
            <span class="dt-sum-icon">🛑</span>
            <span class="dt-sum-trend down">Restock</span>
        </div>
        <div class="dt-sum-val">41</div>
        <div class="dt-sum-lbl">Out of Stock</div>
    </div>
    <div class="dt-summary-card" onclick="window.showToast('Filtering: Featured Products')">
        <div class="dt-sum-top">
            <span class="dt-sum-icon">⭐️</span>
            <span class="dt-sum-trend up">Top Pick</span>
        </div>
        <div class="dt-sum-val">48</div>
        <div class="dt-sum-lbl">Featured</div>
    </div>
    <div class="dt-summary-card" onclick="window.showToast('Filtering: Best Sellers')">
        <div class="dt-sum-top">
            <span class="dt-sum-icon">🔥</span>
            <span class="dt-sum-trend up">High Volume</span>
        </div>
        <div class="dt-sum-val">32</div>
        <div class="dt-sum-lbl">Best Sellers</div>
    </div>
    <div class="dt-summary-card" onclick="window.showToast('Filtering: New Arrivals')">
        <div class="dt-sum-top">
            <span class="dt-sum-icon">✨</span>
            <span class="dt-sum-trend up">2026 Drop</span>
        </div>
        <div class="dt-sum-val">64</div>
        <div class="dt-sum-lbl">New Arrivals</div>
    </div>
</div>
