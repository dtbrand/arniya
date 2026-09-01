<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * invoice.php — Printable B2B GST Invoice Page
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/OrderManager.php';

use DTBrand\Database;
use DTBrand\OrderManager;

$order_id = isset($_GET['id']) ? trim($_GET['id']) : 'DTB-001624';
$rawOrder = null;

if (!empty($order_id)) {
    $rawOrder = OrderManager::getOrderDetails($order_id);
}

if ($rawOrder) {
    $parsedItems = [];
    foreach ($rawOrder['items'] as $it) {
        $parsedItems[] = [
            'name'  => $it['product_title'] ?? 'Handloom Silk Saree',
            'sku'   => $it['sku'] ?? 'DT-SR',
            'qty'   => (int)($it['quantity'] ?? 1),
            'price' => (float)($it['unit_price'] ?? 0),
            'image' => $it['primary_image'] ?? '/assets/images/product1.png',
            'variant' => trim(($it['variant_color'] ?? '') . ' ' . ($it['variant_size'] ?? ''))
        ];
    }

    $order = [
        'id' => $rawOrder['order_number'] ?? ('DTB-' . str_pad($rawOrder['id'], 6, '0', STR_PAD_LEFT)),
        'date' => !empty($rawOrder['created_at']) ? date('d M Y', strtotime($rawOrder['created_at'])) : date('d M Y'),
        'customer' => $rawOrder['customer_name'] ?? 'Direct Customer',
        'amount' => (float)($rawOrder['subtotal'] ?? $rawOrder['total_amount'] ?? 0),
        'total_amount' => (float)($rawOrder['total_amount'] ?? 0),
        'gst_amount' => (float)($rawOrder['gst_amount'] ?? round(((float)($rawOrder['total_amount'] ?? 0)) * 0.05)),
        'payment_status' => $rawOrder['payment_status'] ?? 'paid',
        'payment_method' => $rawOrder['payment_method'] ?? 'UPI / Bank Wire',
        'address' => [
            'billing' => !empty($rawOrder['shipping_address']) ? $rawOrder['shipping_address'] : "Textile Market, Ring Road, Surat, Gujarat - 395002",
            'shipping' => !empty($rawOrder['shipping_address']) ? $rawOrder['shipping_address'] : "Godown 12, Transport Nagar, Surat, Gujarat - 395010"
        ],
        'items' => !empty($parsedItems) ? $parsedItems : [
            ['name' => 'Handloom Pure Silk Saree', 'sku' => 'DT-SR-001', 'qty' => 1, 'price' => (float)($rawOrder['total_amount'] ?? 0), 'image' => '/assets/images/product1.png']
        ]
    ];
} else {
    $order = [
        'id' => $order_id,
        'date' => date('d M Y'),
        'customer' => 'Rajesh Kumar (Vardhman Tex)',
        'amount' => 112250,
        'total_amount' => 117862.5,
        'gst_amount' => 5612.5,
        'payment_status' => 'paid',
        'payment_method' => 'Bank Wire / RTGS',
        'address' => [
            'billing' => "Shop 42, Textile Market, Ring Road, Surat, Gujarat - 395002\nGSTIN: 24AAECJ1928K1Z5",
            'shipping' => "Godown 12, Transport Nagar, Surat, Gujarat - 395010"
        ],
        'items' => [
            ['name' => 'Kanjivaram Silk Saree Pure Zari Weave', 'sku' => 'KNJ-001', 'qty' => 25, 'price' => 4490, 'image' => '/assets/images/product1.png']
        ]
    ];
}

$page_title = "Invoice " . $order['id'];
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

<!-- Document Actions Bar -->
<div class="dt-doc-actions-bar" style="max-width:860px; margin:0 auto 16px auto; display:flex; justify-content:space-between; align-items:center;">
    <a href="/admin/orders/view.php?id=<?php echo $order['id']; ?>" class="dt-btn dt-btn-pale">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        <span>Back to Order</span>
    </a>
    <div style="display:flex; gap:8px;">
        <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_DOCS.downloadPdf('Invoice', '<?php echo $order['id']; ?>')">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            <span>Download PDF</span>
        </button>
        <button type="button" class="dt-btn dt-btn-gold" onclick="window.DT_DOCS.printDoc()">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            <span>Print Invoice</span>
        </button>
    </div>
</div>

<!-- Invoice Layout Partial -->
<?php include __DIR__ . '/components/invoice-preview.php'; ?>

<script src="/admin/orders/assets/js/orders.js?v=<?php echo time(); ?>"></script>
<script src="/admin/orders/assets/js/documents.js?v=<?php echo time(); ?>"></script>
</body>
</html>
