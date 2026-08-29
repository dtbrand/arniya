<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * retail-sales-chart.php — DT Brand's & Jai Hanuman Tex
 * Retail Sales Velocity & Multi-Timeframe Chart Component
 */
?>

<div class="dt-retail-card">
    <div class="dt-retail-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
            <h4 class="dt-retail-card-title">Retail Sales &amp; Revenue Velocity</h4>
        </div>
        <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm dt-retail-tf-btn" data-tf="today" onclick="switchRetailDashboardTimeframe('today')">Today</button>
            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm dt-retail-tf-btn" data-tf="7d" onclick="switchRetailDashboardTimeframe('7d')">7 Days</button>
            <button type="button" class="dt-btn dt-btn-gold dt-btn-sm dt-retail-tf-btn" data-tf="30d" onclick="switchRetailDashboardTimeframe('30d')">30 Days</button>
        </div>
    </div>

    <div style="padding:16px;">
        <div id="retailSalesChartWrap" class="dt-retail-chart-wrap">
            <div class="dt-retail-chart-group">
                <span class="dt-chart-bar-val">₹12.4L</span>
                <div class="dt-retail-chart-pill" style="height:60%;"></div>
                <span class="dt-chart-bar-label">Week 1</span>
            </div>
            <div class="dt-retail-chart-group">
                <span class="dt-chart-bar-val">₹14.8L</span>
                <div class="dt-retail-chart-pill" style="height:75%;"></div>
                <span class="dt-chart-bar-label">Week 2</span>
            </div>
            <div class="dt-retail-chart-group">
                <span class="dt-chart-bar-val">₹15.2L</span>
                <div class="dt-retail-chart-pill" style="height:80%;"></div>
                <span class="dt-chart-bar-label">Week 3</span>
            </div>
            <div class="dt-retail-chart-group">
                <span class="dt-chart-bar-val" style="color:#8A681F; font-weight:900;">₹16.0L</span>
                <div class="dt-retail-chart-pill active" style="height:90%;"></div>
                <span class="dt-chart-bar-label" style="color:#8A681F; font-weight:900;">Week 4 (Peak)</span>
            </div>
        </div>
    </div>
</div>
