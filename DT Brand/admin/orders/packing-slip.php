<?php
/**
 * packing-slip.php — Warehouse Packing Slip Page
 * DT Brand's & Jai Hanuman Tex
 */
$order_id = isset($_GET['id']) ? trim($_GET['id']) : 'DTB-001624';

$order = [
    'id' => $order_id,
    'date' => '21 Aug 2026',
    'customer' => 'Rajesh Kumar (Vardhman Tex)',
    'customer_name' => 'Rajesh Kumar',
    'company_name' => 'Vardhman Tex',
    'phone' => '+91 98220 19283',
    'address' => [
        'shipping' => "Godown 12, Transport Nagar, Surat, Gujarat - 395010"
    ],
    'items' => [
        [
            'name' => 'Kanjivaram Silk Saree Pure Zari Weave',
            'sku' => 'KNJ-001',
            'variant' => 'Royal Ruby / 5.5m',
            'color_name' => 'Royal Ruby',
            'color_hex' => '#9B111E',
            'image' => '/Shared/Asset/images/product1.png',
            'qty' => 25
        ]
    ]
];

$page_title = "Packing Slip " . $order['id'];
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
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/orders/assets/css/orders.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/orders/assets/css/documents.css?v=<?php echo time(); ?>">
</head>
<body style="background:#F1F5F9; padding:24px 0;">

<div class="dt-doc-actions-bar" style="max-width:860px; margin:0 auto 16px auto; display:flex; justify-content:space-between; align-items:center;">
    <a href="/DT%20Brand/admin/orders/view.php?id=<?php echo $order['id']; ?>" class="dt-btn dt-btn-pale">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        <span>Back to Order</span>
    </a>
    <button type="button" class="dt-btn dt-btn-gold" onclick="window.DT_DOCS.printDoc()">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
        <span>Print Packing Slip</span>
    </button>
</div>

<?php include __DIR__ . '/components/packing-slip-preview.php'; ?>

<script src="/DT%20Brand/admin/orders/assets/js/orders.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/orders/assets/js/documents.js?v=<?php echo time(); ?>"></script>
</body>
</html>
