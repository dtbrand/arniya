<?php
/**
 * shipping-label-preview.php — Courier Shipping Label Component
 * DT Brand's & Jai Hanuman Tex
 */
$order_id = isset($order['id']) ? $order['id'] : 'DTB-001624';
$carrier = isset($order['carrier']) ? $order['carrier'] : 'VRL Logistics Depot';
$tracking_id = isset($order['tracking_id']) ? $order['tracking_id'] : 'VRL-99821';
$customer = isset($order['customer']) ? $order['customer'] : 'Rajesh Kumar (Vardhman Tex)';
$shipping_addr = isset($order['address']['shipping']) ? $order['address']['shipping'] : 'Shop 42, Textile Market, Ring Road, Surat, Gujarat - 395002';
$phone = isset($order['phone']) ? $order['phone'] : '+91 98220 19283';
$items_count = isset($order['items_count']) ? $order['items_count'] : 25;
?>
<div class="dt-shipping-label-card">
    <!-- Header Block -->
    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #181512; padding-bottom:8px; margin-bottom:12px;">
        <div>
            <div style="font-size:17px; font-weight:800; letter-spacing:0.5px; color:#181512;"><?php echo strtoupper($carrier); ?></div>
            <div style="font-size:10px; font-weight:700; color:#64748B; text-transform:uppercase; letter-spacing:0.5px;">Priority B2B Surface Logistics</div>
        </div>
        <div style="text-align:right;">
            <span style="font-size:10.5px; font-weight:800; border:2px solid #181512; padding:3px 10px; border-radius:4px; background:#181512; color:#FFFFFF; letter-spacing:0.5px;">PREPAID</span>
        </div>
    </div>

    <!-- Barcode Section -->
    <div style="text-align:center; padding:4px 0;">
        <div class="dt-label-barcode"></div>
        <div style="font-family:monospace; font-weight:800; font-size:14px; letter-spacing:3px; color:#181512; margin-top:4px;"><?php echo $tracking_id; ?></div>
    </div>

    <!-- Order Manifest Meta Bar -->
    <div style="display:flex; justify-content:space-between; align-items:center; background:#FAF8F4; border:1px solid #E2DFD7; padding:6px 12px; margin-top:10px; border-radius:4px; font-size:11px; font-weight:700; color:#475569;">
        <span>Order Reference: <strong style="color:#181512;"><?php echo $order_id; ?></strong></span>
        <span>Consignment: <strong style="color:#181512;"><?php echo $items_count; ?> Units</strong></span>
    </div>

    <!-- Consignee Delivery Destination -->
    <div style="border-top:2px solid #181512; margin-top:12px; padding-top:10px; font-size:12px; line-height:1.45;">
        <div style="font-size:9.5px; font-weight:800; text-transform:uppercase; color:#64748B; letter-spacing:0.5px; margin-bottom:3px;">DELIVER TO (CONSIGNEE):</div>
        <div style="font-size:14px; font-weight:800; color:#181512; margin-bottom:2px;"><?php echo htmlspecialchars($customer); ?></div>
        <div style="color:#334155; font-size:11.5px;"><?php echo nl2br(htmlspecialchars($shipping_addr)); ?></div>
    </div>
</div>
