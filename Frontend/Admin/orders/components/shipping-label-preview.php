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
$weight = isset($order['weight']) ? $order['weight'] : '18.5 Kg';
$items_count = isset($order['items_count']) ? $order['items_count'] : 25;
?>
<div class="dt-shipping-label-card">
    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #000; padding-bottom:8px; margin-bottom:10px;">
        <div>
            <strong style="font-size:16px; letter-spacing:1px; color:#000;"><?php echo strtoupper($carrier); ?></strong><br>
            <small style="color:#64748B; font-weight:700;">PRIORITY B2B SURFACE CONSIGNMENT</small>
        </div>
        <div style="text-align:right;">
            <span style="font-size:10px; font-weight:800; border:1.5px solid #000; padding:2px 8px; border-radius:3px; background:#000; color:#FFF;">PREPAID</span>
        </div>
    </div>

    <!-- Barcode Box -->
    <div style="text-align:center;">
        <div class="dt-label-barcode"></div>
        <span style="font-family:monospace; font-weight:800; font-size:13px; letter-spacing:2px;"><?php echo $tracking_id; ?></span>
    </div>

    <!-- Weight & Manifest Specs -->
    <div style="display:flex; justify-content:space-between; background:#F8FAFC; border:1px solid #E2E8F0; padding:6px 10px; margin-top:10px; border-radius:4px; font-size:11px; font-weight:700;">
        <span>Order: <strong><?php echo $order_id; ?></strong></span>
        <span>Items: <strong><?php echo $items_count; ?> Pcs</strong></span>
        <span>Weight: <strong><?php echo $weight; ?></strong></span>
    </div>

    <div style="border-top:1.5px solid #000; margin-top:10px; padding-top:8px; font-size:12px; line-height:1.4;">
        <div style="font-size:10px; font-weight:800; text-transform:uppercase; color:#64748B;">DELIVER TO (CONSIGNEE):</div>
        <strong style="font-size:13px; color:#000;"><?php echo htmlspecialchars($customer); ?></strong><br>
        <?php echo nl2br(htmlspecialchars($shipping_addr)); ?><br>
        <strong>Tel: <?php echo htmlspecialchars($phone); ?></strong>
    </div>

    <div style="border-top:1px dashed #CBD5E1; margin-top:10px; padding-top:6px; font-size:10px; color:#475569;">
        <strong>FROM (SHIPPER):</strong> DT Brand's &amp; Jai Hanuman Tex, Surat Central Textile Depot, Ring Road, Surat (GJ) - 395002 • Care: +91 98251 00000
    </div>
</div>
