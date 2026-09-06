<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * shipping-label.php — Courier Shipping Label Page
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/OrderManager.php';

use DTBrand\Database;
use DTBrand\OrderManager;

$order_id = isset($_GET['id']) ? trim($_GET['id']) : '';
$rawOrder = null;

if (!empty($order_id)) {
    $rawOrder = OrderManager::getOrderDetails($order_id);
}

if (!$rawOrder) {
    $recentOrders = OrderManager::getAll();
    if (!empty($recentOrders[0]['id'])) {
        $rawOrder = OrderManager::getOrderDetails($recentOrders[0]['id']);
    }
}

if ($rawOrder) {
    $totalQty = 0;
    $firstItemTitle = 'Handloom Pure Silk Saree';
    $firstSku = 'DT-SR';
    if (!empty($rawOrder['items']) && is_array($rawOrder['items'])) {
        foreach ($rawOrder['items'] as $it) {
            $totalQty += (int)($it['quantity'] ?? 1);
        }
        if (!empty($rawOrder['items'][0])) {
            $firstItemTitle = $rawOrder['items'][0]['product_title'] ?? $firstItemTitle;
            $firstSku = $rawOrder['items'][0]['sku'] ?? $firstSku;
        }
    }
    $totalQty = max(1, $totalQty);
    $summary = $firstItemTitle . ($totalQty > 1 ? " (Total {$totalQty} pcs)" : "");

    $order = [
        'id'            => $rawOrder['order_number'] ?? ('DTB-' . str_pad($rawOrder['id'], 6, '0', STR_PAD_LEFT)),
        'carrier'       => !empty($rawOrder['courier_name']) ? $rawOrder['courier_name'] : 'Surat Central Depot Express',
        'tracking_id'   => !empty($rawOrder['tracking_number']) ? $rawOrder['tracking_number'] : '-',
        'customer'      => $rawOrder['customer_name'] ?? 'Direct Customer',
        'phone'         => !empty($rawOrder['customer_phone']) ? $rawOrder['customer_phone'] : '+91 70463 63528',
        'items_count'   => $totalQty,
        'items_summary' => $summary,
        'size'          => 'Free Size (6.3m with Blouse)',
        'sku'           => $firstSku,
        'weight'        => round($totalQty * 0.75, 1) . ' Kg',
        'address'       => [
            'shipping'  => !empty($rawOrder['shipping_address']) ? $rawOrder['shipping_address'] : "Textile Market, Ring Road, Surat, Gujarat - 395002"
        ]
    ];
} else {
    $order = [
        'id'            => '—',
        'carrier'       => 'Surat Central Depot Express',
        'tracking_id'   => '—',
        'customer'      => 'No Order Found',
        'phone'         => '+91 70463 63528',
        'items_count'   => 0,
        'items_summary' => 'No items recorded',
        'size'          => '—',
        'sku'           => '—',
        'weight'        => '0.0 Kg',
        'address'       => [
            'shipping'  => "Surat Central Textile Depot, Ring Road, Surat, Gujarat - 395002"
        ]
    ];
}

$page_title = "Shipping Label " . $order['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> ‹ DT Brand's</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/orders.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/documents.css?v=<?php echo time(); ?>">
</head>
<body style="background:#F1F5F9; padding:24px 0;">

<div class="dt-doc-actions-bar" style="max-width:440px; margin:0 auto 16px auto; display:flex; justify-content:space-between; align-items:center;">
    <a href="/admin/orders/view.php?id=<?php echo $order['id']; ?>" class="dt-btn dt-btn-pale"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="margin-right:4px;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>Back to Order</a>
    <button type="button" class="dt-btn dt-btn-gold" onclick="window.DT_DOCS.printDoc()">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
        <span>Print Label</span>
    </button>
</div>

<?php include __DIR__ . '/components/shipping-label-preview.php'; ?>

<script src="/admin/orders/assets/js/orders.js?v=<?php echo time(); ?>"></script>
<script src="/admin/orders/assets/js/documents.js?v=<?php echo time(); ?>"></script>
</body>
</html>
