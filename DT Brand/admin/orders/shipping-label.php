<?php
/**
 * shipping-label.php — Courier Shipping Label Page
 * DT Brand's & Jai Hanuman Tex
 */
$order_id = isset($_GET['id']) ? trim($_GET['id']) : 'DTB-001624';

$all_labels = [
    'DTB-001624' => [
        'id' => 'DTB-001624',
        'carrier' => 'Surat Central Depot Express',
        'tracking_id' => 'VRL-99821',
        'customer' => 'Rajesh Kumar (Vardhman Tex)',
        'phone' => '+91 98220 19283',
        'items_count' => 25,
        'items_summary' => 'Kanjivaram Pure Silk Zari Weave Saree',
        'size' => 'Free Size (6.3m with Blouse)',
        'sku' => 'DTB-KANJI-1624',
        'weight' => '18.5 Kg (2 Master Cartons)',
        'address' => [
            'shipping' => "Shop 42, Textile Market, Ring Road, Surat, Gujarat - 395002"
        ]
    ],
    'DTB-001623' => [
        'id' => 'DTB-001623',
        'carrier' => 'BlueDart Express Air',
        'tracking_id' => 'BD-88291',
        'customer' => 'Pooja Sharma',
        'phone' => '+91 98765 43210',
        'items_count' => 1,
        'items_summary' => 'Banarasi Georgette Handloom Saree',
        'size' => 'Free Size (6.3m)',
        'sku' => 'DTB-BAN-1623',
        'weight' => '0.8 Kg (Pouch Pack)',
        'address' => [
            'shipping' => "Flat 402, Lotus Heights, Andheri West, Mumbai, Maharashtra - 400053"
        ]
    ],
    'DTB-001622' => [
        'id' => 'DTB-001622',
        'carrier' => 'DTDC Priority Cargo',
        'tracking_id' => 'DTDC-4491',
        'customer' => 'Surat Central Saree Depot (Direct Consignment)',
        'phone' => '+91 98250 88771',
        'items_count' => 10,
        'items_summary' => 'Chanderi Cotton Silk Resham Border Saree',
        'size' => 'Free Size (Unstitched Blouse)',
        'sku' => 'DTB-CHAN-1622',
        'weight' => '7.5 Kg (1 Heavy Carton)',
        'address' => [
            'shipping' => "Godown B, Transport Nagar, Ring Road, Surat, Gujarat - 395010"
        ]
    ]
];

$order = isset($all_labels[$order_id]) ? $all_labels[$order_id] : [
    'id' => $order_id,
    'carrier' => 'Surat Central Depot Express',
    'tracking_id' => 'SCT-' . substr($order_id, -5),
    'customer' => 'Wholesale Consignee (Surat Depot)',
    'phone' => '+91 98220 19283',
    'items_count' => 15,
    'items_summary' => 'Kanjivaram Pure Silk Zari Weave Saree',
    'size' => 'Free Size (6.3m with Blouse)',
    'sku' => 'DTB-KANJI-' . substr($order_id, -4),
    'weight' => '12.0 Kg',
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
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/orders/assets/css/orders.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/orders/assets/css/documents.css?v=<?php echo time(); ?>">
</head>
<body style="background:#F1F5F9; padding:24px 0;">

<div class="dt-doc-actions-bar" style="max-width:440px; margin:0 auto 16px auto; display:flex; justify-content:space-between; align-items:center;">
    <a href="/DT%20Brand/admin/orders/view.php?id=<?php echo $order['id']; ?>" class="dt-btn dt-btn-pale">← Back to Order</a>
    <button type="button" class="dt-btn dt-btn-gold" onclick="window.DT_DOCS.printDoc()">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
        <span>Print Label</span>
    </button>
</div>

<?php include __DIR__ . '/components/shipping-label-preview.php'; ?>

<script src="/DT%20Brand/admin/orders/assets/js/orders.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/orders/assets/js/documents.js?v=<?php echo time(); ?>"></script>
</body>
</html>
