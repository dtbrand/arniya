<?php
/**
 * shipping-label-preview.php — Courier Shipping Label Component
 * DT Brand's & Jai Hanuman Tex
 */
$order_id = isset($order['id']) ? $order['id'] : 'DTB-001624';
$carrier = isset($order['carrier']) ? $order['carrier'] : 'VRL Logistics';
$tracking_id = isset($order['tracking_id']) ? $order['tracking_id'] : 'VRL-SURAT-99821';
$customer = isset($order['customer']) ? $order['customer'] : 'Rajesh Kumar (Vardhman Tex)';
$shipping_addr = isset($order['address']['shipping']) ? $order['address']['shipping'] : 'Godown 12, Transport Nagar, Surat, Gujarat - 395010';
$phone = isset($order['phone']) ? $order['phone'] : '+91 98220 19283';
?>
<div class="dt-shipping-label-card">
    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #000; padding-bottom:8px; margin-bottom:10px;">
        <div>
            <strong style="font-size:16px; letter-spacing:1px;"><?php echo strtoupper($carrier); ?></strong><br>
            <small style="color:#64748B;">PRIORITY B2B SURFACE</small>
        </div>
        <div style="text-align:right;">
            <span style="font-size:10px; font-weight:800; border:1.5px solid #000; padding:2px 6px; border-radius:3px;">PREPAID</span>
        </div>
    </div>

    <!-- Barcode Box -->
    <div style="text-align:center;">
        <div class="dt-label-barcode"></div>
        <span style="font-family:monospace; font-weight:800; font-size:13px; letter-spacing:2px;"><?php echo $tracking_id; ?></span>
    </div>

    <div style="border-top:1.5px solid #000; margin-top:12px; padding-top:8px; font-size:12px; line-height:1.4;">
        <div style="font-size:10px; font-weight:800; text-transform:uppercase; color:#64748B;">DELIVER TO (CONSIGNEE):</div>
        <strong style="font-size:13px;"><?php echo htmlspecialchars($customer); ?></strong><br>
        <?php echo nl2br(htmlspecialchars($shipping_addr)); ?><br>
        <strong>Tel: <?php echo htmlspecialchars($phone); ?></strong>
    </div>

    <div style="border-top:1px dashed #CBD5E1; margin-top:10px; padding-top:6px; font-size:10.5px; color:#475569;">
        <strong>FROM (SHIPPER):</strong> DT Brand's &amp; Jai Hanuman Tex, Central Depot, Ring Road, Surat (GJ) - 395002 • Care: +91 98251 00000
    </div>
</div>
