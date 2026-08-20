<?php
/**
 * shipping-label.php — Courier Shipping Label Page
 * DT Brand's & Jai Hanuman Tex
 */
$order_id = isset($_GET['id']) ? trim($_GET['id']) : 'DTB-001624';

$order = [
    'id' => $order_id,
    'carrier' => 'VRL Logistics',
    'tracking_id' => 'VRL-SURAT-99821',
    'customer' => 'Rajesh Kumar (Vardhman Tex)',
    'phone' => '+91 98220 19283',
    'address' => [
        'shipping' => "Godown 12, Transport Nagar, Surat, Gujarat - 395010"
    ]
];

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
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/orders/assets/css/orders.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/orders/assets/css/documents.css?v=<?php echo time(); ?>">
</head>
<body style="background:#F1F5F9; padding:24px 0;">

<div class="dt-doc-actions-bar" style="max-width:440px; margin:0 auto 16px auto; display:flex; justify-content:space-between; align-items:center;">
    <a href="/Frontend/Admin/orders/view.php?id=<?php echo $order['id']; ?>" class="dt-btn dt-btn-pale">← Back to Order</a>
    <button type="button" class="dt-btn dt-btn-gold" onclick="window.DT_DOCS.printDoc()">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
        <span>Print Label</span>
    </button>
</div>

<?php include __DIR__ . '/components/shipping-label-preview.php'; ?>

<script src="/Frontend/Admin/orders/assets/js/orders.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/orders/assets/js/documents.js?v=<?php echo time(); ?>"></script>
</body>
</html>
