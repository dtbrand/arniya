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
<div class="dt-shipping-label-card" style="max-width:440px; margin:0 auto; background:#FFFFFF; border:2px solid #181512; border-radius:8px; padding:20px 24px; font-family:'Plus Jakarta Sans', sans-serif; box-sizing:border-box;">
    <!-- Header Block -->
    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #181512; padding-bottom:10px; margin-bottom:14px;">
        <div>
            <div style="font-size:16px; font-weight:900; letter-spacing:0.3px; color:#181512; line-height:1.2;"><?php echo strtoupper($carrier); ?></div>
            <div style="font-size:10px; font-weight:700; color:#64748B; text-transform:uppercase; letter-spacing:0.5px; margin-top:2px;">Priority B2B Surface Logistics</div>
        </div>
        <div style="text-align:right;">
            <span style="font-size:10.5px; font-weight:800; border:2px solid #181512; padding:3px 10px; border-radius:4px; background:#181512; color:#FFFFFF; letter-spacing:0.5px; display:inline-block;">PREPAID</span>
        </div>
    </div>

    <!-- Barcode Section -->
    <div style="text-align:center; padding:6px 0 10px 0;">
        <svg viewBox="0 0 320 54" width="100%" height="54" style="display:block; margin:0 auto;" preserveAspectRatio="none">
            <rect x="0" y="0" width="3" height="54" fill="#000000"/>
            <rect x="5" y="0" width="2" height="54" fill="#000000"/>
            <rect x="9" y="0" width="4" height="54" fill="#000000"/>
            <rect x="15" y="0" width="2" height="54" fill="#000000"/>
            <rect x="19" y="0" width="5" height="54" fill="#000000"/>
            <rect x="26" y="0" width="2" height="54" fill="#000000"/>
            <rect x="30" y="0" width="6" height="54" fill="#000000"/>
            <rect x="38" y="0" width="3" height="54" fill="#000000"/>
            <rect x="43" y="0" width="2" height="54" fill="#000000"/>
            <rect x="47" y="0" width="5" height="54" fill="#000000"/>
            <rect x="54" y="0" width="3" height="54" fill="#000000"/>
            <rect x="59" y="0" width="2" height="54" fill="#000000"/>
            <rect x="63" y="0" width="6" height="54" fill="#000000"/>
            <rect x="71" y="0" width="2" height="54" fill="#000000"/>
            <rect x="75" y="0" width="4" height="54" fill="#000000"/>
            <rect x="81" y="0" width="3" height="54" fill="#000000"/>
            <rect x="86" y="0" width="5" height="54" fill="#000000"/>
            <rect x="93" y="0" width="2" height="54" fill="#000000"/>
            <rect x="97" y="0" width="4" height="54" fill="#000000"/>
            <rect x="103" y="0" width="2" height="54" fill="#000000"/>
            <rect x="107" y="0" width="6" height="54" fill="#000000"/>
            <rect x="115" y="0" width="3" height="54" fill="#000000"/>
            <rect x="120" y="0" width="2" height="54" fill="#000000"/>
            <rect x="124" y="0" width="5" height="54" fill="#000000"/>
            <rect x="131" y="0" width="2" height="54" fill="#000000"/>
            <rect x="135" y="0" width="4" height="54" fill="#000000"/>
            <rect x="141" y="0" width="3" height="54" fill="#000000"/>
            <rect x="146" y="0" width="6" height="54" fill="#000000"/>
            <rect x="154" y="0" width="2" height="54" fill="#000000"/>
            <rect x="158" y="0" width="5" height="54" fill="#000000"/>
            <rect x="165" y="0" width="3" height="54" fill="#000000"/>
            <rect x="170" y="0" width="2" height="54" fill="#000000"/>
            <rect x="174" y="0" width="6" height="54" fill="#000000"/>
            <rect x="182" y="0" width="3" height="54" fill="#000000"/>
            <rect x="187" y="0" width="2" height="54" fill="#000000"/>
            <rect x="191" y="0" width="5" height="54" fill="#000000"/>
            <rect x="198" y="0" width="3" height="54" fill="#000000"/>
            <rect x="203" y="0" width="2" height="54" fill="#000000"/>
            <rect x="207" y="0" width="6" height="54" fill="#000000"/>
            <rect x="215" y="0" width="3" height="54" fill="#000000"/>
            <rect x="220" y="0" width="4" height="54" fill="#000000"/>
            <rect x="226" y="0" width="2" height="54" fill="#000000"/>
            <rect x="230" y="0" width="5" height="54" fill="#000000"/>
            <rect x="237" y="0" width="3" height="54" fill="#000000"/>
            <rect x="242" y="0" width="2" height="54" fill="#000000"/>
            <rect x="246" y="0" width="6" height="54" fill="#000000"/>
            <rect x="254" y="0" width="2" height="54" fill="#000000"/>
            <rect x="258" y="0" width="4" height="54" fill="#000000"/>
            <rect x="264" y="0" width="3" height="54" fill="#000000"/>
            <rect x="269" y="0" width="5" height="54" fill="#000000"/>
            <rect x="276" y="0" width="2" height="54" fill="#000000"/>
            <rect x="280" y="0" width="4" height="54" fill="#000000"/>
            <rect x="286" y="0" width="3" height="54" fill="#000000"/>
            <rect x="291" y="0" width="6" height="54" fill="#000000"/>
            <rect x="299" y="0" width="2" height="54" fill="#000000"/>
            <rect x="303" y="0" width="5" height="54" fill="#000000"/>
            <rect x="310" y="0" width="3" height="54" fill="#000000"/>
            <rect x="315" y="0" width="5" height="54" fill="#000000"/>
        </svg>
        <div style="font-family:monospace; font-weight:800; font-size:14px; letter-spacing:4px; color:#181512; margin-top:6px;"><?php echo $tracking_id; ?></div>
    </div>

    <!-- Order Manifest Meta Bar -->
    <div style="display:flex; justify-content:space-between; align-items:center; background:#FAF8F4; border:1px solid #E2DFD7; padding:7px 12px; margin-top:10px; border-radius:6px; font-size:11px; font-weight:700; color:#475569;">
        <span>Order Reference: <strong style="color:#181512;"><?php echo $order_id; ?></strong></span>
        <span>Consignment: <strong style="color:#181512;"><?php echo $items_count; ?> Units</strong></span>
    </div>

    <!-- Consignee Delivery Destination -->
    <div style="border-top:2px solid #181512; margin-top:14px; padding-top:10px; font-size:12px; line-height:1.45;">
        <div style="font-size:9.5px; font-weight:800; text-transform:uppercase; color:#64748B; letter-spacing:0.5px; margin-bottom:3px;">DELIVER TO (CONSIGNEE):</div>
        <div style="font-size:14px; font-weight:800; color:#181512; margin-bottom:2px;"><?php echo htmlspecialchars($customer); ?></div>
        <div style="color:#334155; font-size:11.5px;"><?php echo nl2br(htmlspecialchars($shipping_addr)); ?></div>
        <div style="color:#64748B; font-size:11px; margin-top:3px; font-weight:600;">TEL: <?php echo htmlspecialchars($phone); ?></div>
    </div>
</div>
