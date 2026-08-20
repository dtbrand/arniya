<?php
/**
 * order-stats.php — 4-Card Executive KPI Ribbon + Interactive Status Flow Pills
 * DT Brand's & Jai Hanuman Tex — Master Wholesale Architecture
 */
$active_status_key = isset($active_status_key) ? $active_status_key : 'all';

// Status Counts Model
$status_pills = [
    ['key' => 'all', 'label' => 'All Orders', 'count' => '1,624', 'url' => '/Frontend/Admin/orders/index.php', 'icon' => '<rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect>'],
    ['key' => 'pending', 'label' => 'Pending', 'count' => '18', 'url' => '/Frontend/Admin/orders/pending.php', 'icon' => '<circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>'],
    ['key' => 'confirmed', 'label' => 'Confirmed', 'count' => '42', 'url' => '/Frontend/Admin/orders/confirmed.php', 'icon' => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>'],
    ['key' => 'processing', 'label' => 'Processing', 'count' => '24', 'url' => '/Frontend/Admin/orders/processing.php', 'icon' => '<polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>'],
    ['key' => 'packed', 'label' => 'Packed', 'count' => '15', 'url' => '/Frontend/Admin/orders/packed.php', 'icon' => '<polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline>'],
    ['key' => 'shipped', 'label' => 'In Transit / Shipped', 'count' => '84', 'url' => '/Frontend/Admin/orders/shipped.php', 'icon' => '<rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle>'],
    ['key' => 'out_for_delivery', 'label' => 'Out For Delivery', 'count' => '32', 'url' => '/Frontend/Admin/orders/out-for-delivery.php', 'icon' => '<circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline>'],
    ['key' => 'delivered', 'label' => 'Delivered', 'count' => '1,542', 'url' => '/Frontend/Admin/orders/delivered.php', 'icon' => '<path d="M20 6L9 17l-5-5"></path>'],
    ['key' => 'cancelled', 'label' => 'Cancelled', 'count' => '14', 'url' => '/Frontend/Admin/orders/cancelled.php', 'icon' => '<circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line>'],
    ['key' => 'failed', 'label' => 'Failed', 'count' => '3', 'url' => '/Frontend/Admin/orders/failed.php', 'icon' => '<circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line>'],
    ['key' => 'returned', 'label' => 'RMA Returns', 'count' => '8', 'url' => '/Frontend/Admin/orders/returned.php', 'icon' => '<polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>'],
    ['key' => 'refunded', 'label' => 'Refunds Ledger', 'count' => '6', 'url' => '/Frontend/Admin/orders/refunded.php', 'icon' => '<path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path>']
];
?>

<!-- ══ TIER 1: 4-CARD MASTER EXECUTIVE KPI RIBBON (STRICT DT BRAND'S STANDARD) ══ -->
<div class="dt-master-kpi-grid">
    <!-- Card 1: Total Orders -->
    <a href="/Frontend/Admin/orders/index.php" class="dt-master-kpi-card <?php echo ($active_status_key === 'all') ? 'active' : ''; ?>">
        <div class="dt-kpi-header">
            <span class="dt-kpi-tag">TOTAL ORDERS</span>
            <div class="dt-kpi-icon-pill gold">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3">
                    <rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect>
                </svg>
            </div>
        </div>
        <div class="dt-kpi-number-wrap">
            <span class="dt-kpi-main-number">1,624</span>
            <span class="dt-kpi-trend-pill up">↑ +14.6%</span>
        </div>
        <div class="dt-kpi-footer">
            <span>Wholesale + Retail Consignments</span>
            <span class="dt-kpi-arrow">→</span>
        </div>
    </a>

    <!-- Card 2: Active Fulfillment -->
    <a href="/Frontend/Admin/orders/pending.php" class="dt-master-kpi-card <?php echo (in_array($active_status_key, ['pending', 'processing', 'confirmed', 'packed'])) ? 'active' : ''; ?>">
        <div class="dt-kpi-header">
            <span class="dt-kpi-tag">PENDING &amp; PROCESSING</span>
            <div class="dt-kpi-icon-pill amber">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3">
                    <circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
        </div>
        <div class="dt-kpi-number-wrap">
            <span class="dt-kpi-main-number">42</span>
            <span class="dt-kpi-trend-pill amber">18 Action Req.</span>
        </div>
        <div class="dt-kpi-footer">
            <span>24 In Prep • 15 Ready to Pack</span>
            <span class="dt-kpi-arrow">→</span>
        </div>
    </a>

    <!-- Card 3: Logistics & In-Transit -->
    <a href="/Frontend/Admin/orders/shipped.php" class="dt-master-kpi-card <?php echo (in_array($active_status_key, ['shipped', 'out_for_delivery'])) ? 'active' : ''; ?>">
        <div class="dt-kpi-header">
            <span class="dt-kpi-tag">IN TRANSIT &amp; DISPATCH</span>
            <div class="dt-kpi-icon-pill blue">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3">
                    <rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle>
                </svg>
            </div>
        </div>
        <div class="dt-kpi-number-wrap">
            <span class="dt-kpi-main-number">116</span>
            <span class="dt-kpi-trend-pill blue">32 Out Today</span>
        </div>
        <div class="dt-kpi-footer">
            <span>84 In Transit (VRL, BlueDart, DLV)</span>
            <span class="dt-kpi-arrow">→</span>
        </div>
    </a>

    <!-- Card 4: Delivered & Settled -->
    <a href="/Frontend/Admin/orders/delivered.php" class="dt-master-kpi-card <?php echo ($active_status_key === 'delivered') ? 'active' : ''; ?>">
        <div class="dt-kpi-header">
            <span class="dt-kpi-tag">DELIVERED &amp; COMPLETED</span>
            <div class="dt-kpi-icon-pill emerald">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3">
                    <path d="M20 6L9 17l-5-5"></path>
                </svg>
            </div>
        </div>
        <div class="dt-kpi-number-wrap">
            <span class="dt-kpi-main-number">1,542</span>
            <span class="dt-kpi-trend-pill emerald">94.9% Delivered</span>
        </div>
        <div class="dt-kpi-footer">
            <span style="display:inline-flex; align-items:center; gap:2px;">
                <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="#15803D" stroke-width="2.4"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                <strong>₹1.84 Cr Settled Valuation</strong>
            </span>
            <span class="dt-kpi-arrow">→</span>
        </div>
    </a>
</div>

<!-- ══ TIER 2: INTERACTIVE FULFILLMENT STATUS FLOW BAR ══ -->
<div class="dt-status-flow-container" style="display:flex; align-items:center; gap:8px; background:#FFFFFF; border:1px solid #E2DFD7; border-radius:10px; padding:6px 8px; box-shadow:0 2px 6px rgba(0,0,0,0.02); margin-bottom:12px;">
    <!-- Left Scroll Stepper Button -->
    <button type="button" class="dt-flow-scroll-btn left" onclick="window.DT_ORDER_LIST.scrollStatusFlow(-1)" title="Scroll Left" style="flex-shrink:0; width:28px; height:28px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; display:flex; align-items:center; justify-content:center; cursor:pointer;">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
    </button>

    <!-- Horizontal Smooth Flow Stream -->
    <div class="dt-status-flow-scroll" style="flex:1; min-width:0; display:flex; align-items:center; gap:8px; overflow-x:auto; scroll-behavior:smooth; -webkit-overflow-scrolling:touch; padding:2px 0;">
        <?php foreach ($status_pills as $sp): ?>
        <a href="<?php echo $sp['url']; ?>" class="dt-flow-pill <?php echo ($active_status_key === $sp['key']) ? 'active' : ''; ?> dt-pill-<?php echo $sp['key']; ?>" data-status="<?php echo $sp['key']; ?>" onclick="window.DT_ORDER_LIST.selectStatusPill('<?php echo $sp['key']; ?>', this, event)">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><?php echo $sp['icon']; ?></svg>
            <span class="dt-flow-label"><?php echo $sp['label']; ?></span>
            <span class="dt-flow-count"><?php echo $sp['count']; ?></span>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- Right Scroll Stepper Button -->
    <button type="button" class="dt-flow-scroll-btn right" onclick="window.DT_ORDER_LIST.scrollStatusFlow(1)" title="Scroll Right" style="flex-shrink:0; width:28px; height:28px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; display:flex; align-items:center; justify-content:center; cursor:pointer;">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
    </button>
</div>
