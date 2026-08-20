<?php
/**
 * order-stats.php — 12-Card Responsive KPI Metrics Ribbon
 * DT Brand's & Jai Hanuman Tex
 */
$kpis = [
    ['key' => 'all', 'label' => 'Total Orders', 'val' => '1,624', 'badge' => '↑ +14.6%', 'badge_cls' => 'up', 'icon' => '<rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect>', 'url' => '/Frontend/Admin/orders/index.php'],
    ['key' => 'pending', 'label' => 'Pending', 'val' => '18', 'badge' => 'Needs Action', 'badge_cls' => 'pending', 'icon' => '<circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>', 'url' => '/Frontend/Admin/orders/pending.php'],
    ['key' => 'confirmed', 'label' => 'Confirmed', 'val' => '42', 'badge' => 'Verified', 'badge_cls' => 'up', 'icon' => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>', 'url' => '/Frontend/Admin/orders/confirmed.php'],
    ['key' => 'processing', 'label' => 'Processing', 'val' => '24', 'badge' => 'In Prep', 'badge_cls' => 'up', 'icon' => '<polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>', 'url' => '/Frontend/Admin/orders/processing.php'],
    ['key' => 'packed', 'label' => 'Packed', 'val' => '15', 'badge' => 'Ready to Ship', 'badge_cls' => 'up', 'icon' => '<polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline>', 'url' => '/Frontend/Admin/orders/packed.php'],
    ['key' => 'shipped', 'label' => 'Shipped', 'val' => '84', 'badge' => 'In Transit', 'badge_cls' => 'up', 'icon' => '<rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle>', 'url' => '/Frontend/Admin/orders/shipped.php'],
    ['key' => 'out_for_delivery', 'label' => 'Out For Delivery', 'val' => '32', 'badge' => 'Today', 'badge_cls' => 'up', 'icon' => '<circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline>', 'url' => '/Frontend/Admin/orders/out-for-delivery.php'],
    ['key' => 'delivered', 'label' => 'Delivered', 'val' => '1,542', 'badge' => '94.9%', 'badge_cls' => 'up', 'icon' => '<path d="M20 6L9 17l-5-5"></path>', 'url' => '/Frontend/Admin/orders/delivered.php'],
    ['key' => 'cancelled', 'label' => 'Cancelled', 'val' => '14', 'badge' => '0.8%', 'badge_cls' => 'danger', 'icon' => '<circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line>', 'url' => '/Frontend/Admin/orders/cancelled.php'],
    ['key' => 'failed', 'label' => 'Failed', 'val' => '3', 'badge' => 'Payment Err', 'badge_cls' => 'danger', 'icon' => '<circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line>', 'url' => '/Frontend/Admin/orders/failed.php'],
    ['key' => 'returned', 'label' => 'Returned', 'val' => '8', 'badge' => 'Inspection', 'badge_cls' => 'pending', 'icon' => '<polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>', 'url' => '/Frontend/Admin/orders/returned.php'],
    ['key' => 'refunded', 'label' => 'Refunded', 'val' => '6', 'badge' => 'Credit Note', 'badge_cls' => 'pending', 'icon' => '<path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path>', 'url' => '/Frontend/Admin/orders/refunded.php']
];

$active_status_key = isset($active_status_key) ? $active_status_key : 'all';
?>
<!-- ══ 12-Card Responsive KPI Metrics Ribbon ══ -->
<div class="dt-orders-kpi-grid">
    <?php foreach ($kpis as $k): ?>
    <a href="<?php echo $k['url']; ?>" class="dt-kpi-card <?php echo ($active_status_key === $k['key']) ? 'active' : ''; ?>">
        <div class="dt-kpi-top">
            <span class="dt-kpi-label"><?php echo $k['label']; ?></span>
            <div class="dt-kpi-icon-wrap">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2"><?php echo $k['icon']; ?></svg>
            </div>
        </div>
        <div class="dt-kpi-val"><?php echo $k['val']; ?></div>
        <div class="dt-kpi-bottom">
            <span class="dt-kpi-badge <?php echo $k['badge_cls']; ?>"><?php echo $k['badge']; ?></span>
            <span style="font-size:10px; color:#94a3b8;">View List →</span>
        </div>
    </a>
    <?php endforeach; ?>
</div>
