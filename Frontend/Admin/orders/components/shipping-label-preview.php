<?php
/**
 * shipping-label-preview.php — Meesho / Courier Standard Shipping Label Component
 * DT Brand's & Jai Hanuman Tex
 */
$order_id = isset($order['id']) ? $order['id'] : 'DTB-001624';
$carrier = isset($order['carrier']) ? $order['carrier'] : 'Surat Central Depot Express';
$tracking_id = isset($order['tracking_id']) ? $order['tracking_id'] : 'VRL-99821';
$customer = isset($order['customer']) ? $order['customer'] : 'Rajesh Kumar (Vardhman Tex)';
$shipping_addr = isset($order['address']['shipping']) ? $order['address']['shipping'] : 'Shop 42, Textile Market, Ring Road, Surat, Gujarat - 395002';
$phone = isset($order['phone']) ? $order['phone'] : '+91 98220 19283';
$items_count = isset($order['items_count']) ? $order['items_count'] : 25;
$items_summary = isset($order['items_summary']) ? $order['items_summary'] : 'Kanjivaram Pure Silk Zari Weave Saree';
$size = isset($order['size']) ? $order['size'] : 'Free Size (6.3m with Blouse)';
$sku = isset($order['sku']) ? $order['sku'] : 'DTB-KANJI-' . substr($order_id, -4);
?>
<div class="dt-shipping-label-card" style="max-width:440px; margin:0 auto; background:#FFFFFF; border:2.5px solid #181512; border-radius:8px; padding:16px 20px; font-family:'Plus Jakarta Sans', sans-serif; box-sizing:border-box;">
    <!-- Header Block -->
    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #181512; padding-bottom:8px; margin-bottom:10px;">
        <div>
            <div style="font-size:16px; font-weight:900; letter-spacing:0.3px; color:#181512; line-height:1.2;"><?php echo strtoupper($carrier); ?></div>
            <div style="font-size:9.5px; font-weight:700; color:#64748B; text-transform:uppercase; letter-spacing:0.5px; margin-top:2px;">SURAT HUB / DOCK 1 • B2B SURFACE LOGISTICS</div>
        </div>
        <div style="text-align:right;">
            <span style="font-size:10.5px; font-weight:800; border:2px solid #181512; padding:3px 10px; border-radius:4px; background:#181512; color:#FFFFFF; letter-spacing:0.5px; display:inline-block;">PREPAID</span>
        </div>
    </div>

    <!-- Barcode Section -->
    <div style="text-align:center; padding:4px 0 6px 0; width:100%;">
        <svg viewBox="0 0 450 50" width="100%" height="50" style="display:block; margin:0 auto; width:100%;" preserveAspectRatio="none">
            <rect x="0" y="0" width="4" height="50" fill="#000000"/>
            <rect x="7" y="0" width="3" height="50" fill="#000000"/>
            <rect x="13" y="0" width="5" height="50" fill="#000000"/>
            <rect x="21" y="0" width="3" height="50" fill="#000000"/>
            <rect x="27" y="0" width="7" height="50" fill="#000000"/>
            <rect x="37" y="0" width="3" height="50" fill="#000000"/>
            <rect x="43" y="0" width="8" height="50" fill="#000000"/>
            <rect x="54" y="0" width="4" height="50" fill="#000000"/>
            <rect x="61" y="0" width="3" height="50" fill="#000000"/>
            <rect x="67" y="0" width="7" height="50" fill="#000000"/>
            <rect x="77" y="0" width="4" height="50" fill="#000000"/>
            <rect x="84" y="0" width="3" height="50" fill="#000000"/>
            <rect x="90" y="0" width="8" height="50" fill="#000000"/>
            <rect x="101" y="0" width="3" height="50" fill="#000000"/>
            <rect x="107" y="0" width="5" height="50" fill="#000000"/>
            <rect x="115" y="0" width="4" height="50" fill="#000000"/>
            <rect x="122" y="0" width="7" height="50" fill="#000000"/>
            <rect x="132" y="0" width="3" height="50" fill="#000000"/>
            <rect x="138" y="0" width="5" height="50" fill="#000000"/>
            <rect x="146" y="0" width="3" height="50" fill="#000000"/>
            <rect x="152" y="0" width="8" height="50" fill="#000000"/>
            <rect x="163" y="0" width="4" height="50" fill="#000000"/>
            <rect x="170" y="0" width="3" height="50" fill="#000000"/>
            <rect x="176" y="0" width="7" height="50" fill="#000000"/>
            <rect x="186" y="0" width="3" height="50" fill="#000000"/>
            <rect x="192" y="0" width="5" height="50" fill="#000000"/>
            <rect x="200" y="0" width="4" height="50" fill="#000000"/>
            <rect x="207" y="0" width="8" height="50" fill="#000000"/>
            <rect x="218" y="0" width="3" height="50" fill="#000000"/>
            <rect x="224" y="0" width="7" height="50" fill="#000000"/>
            <rect x="234" y="0" width="4" height="50" fill="#000000"/>
            <rect x="241" y="0" width="3" height="50" fill="#000000"/>
            <rect x="247" y="0" width="8" height="50" fill="#000000"/>
            <rect x="258" y="0" width="4" height="50" fill="#000000"/>
            <rect x="265" y="0" width="3" height="50" fill="#000000"/>
            <rect x="271" y="0" width="7" height="50" fill="#000000"/>
            <rect x="281" y="0" width="4" height="50" fill="#000000"/>
            <rect x="288" y="0" width="3" height="50" fill="#000000"/>
            <rect x="294" y="0" width="8" height="50" fill="#000000"/>
            <rect x="305" y="0" width="4" height="50" fill="#000000"/>
            <rect x="312" y="0" width="5" height="50" fill="#000000"/>
            <rect x="320" y="0" width="3" height="50" fill="#000000"/>
            <rect x="326" y="0" width="7" height="50" fill="#000000"/>
            <rect x="336" y="0" width="4" height="50" fill="#000000"/>
            <rect x="343" y="0" width="3" height="50" fill="#000000"/>
            <rect x="349" y="0" width="8" height="50" fill="#000000"/>
            <rect x="360" y="0" width="3" height="50" fill="#000000"/>
            <rect x="366" y="0" width="5" height="50" fill="#000000"/>
            <rect x="374" y="0" width="4" height="50" fill="#000000"/>
            <rect x="381" y="0" width="7" height="50" fill="#000000"/>
            <rect x="391" y="0" width="3" height="50" fill="#000000"/>
            <rect x="397" y="0" width="5" height="50" fill="#000000"/>
            <rect x="405" y="0" width="4" height="50" fill="#000000"/>
            <rect x="412" y="0" width="8" height="50" fill="#000000"/>
            <rect x="423" y="0" width="3" height="50" fill="#000000"/>
            <rect x="429" y="0" width="7" height="50" fill="#000000"/>
            <rect x="439" y="0" width="4" height="50" fill="#000000"/>
            <rect x="445" y="0" width="5" height="50" fill="#000000"/>
        </svg>
        <div style="font-family:monospace; font-weight:800; font-size:14.5px; letter-spacing:5px; color:#181512; margin-top:4px;">AWB: <?php echo $tracking_id; ?></div>
    </div>

    <!-- Consignee Delivery Destination -->
    <div style="border-top:2px solid #181512; border-bottom:2px solid #181512; padding:8px 0; margin-bottom:8px; font-size:12px; line-height:1.4;">
        <div style="font-size:9px; font-weight:800; text-transform:uppercase; color:#64748B; letter-spacing:0.5px; margin-bottom:2px;">DELIVER TO (CONSIGNEE):</div>
        <div style="font-size:14px; font-weight:800; color:#181512; margin-bottom:2px;"><?php echo htmlspecialchars($customer); ?></div>
        <div style="color:#334155; font-size:11.5px;"><?php echo nl2br(htmlspecialchars($shipping_addr)); ?></div>
    </div>

    <!-- Product SKU & Size Table (Meesho Format) -->
    <table style="width:100%; border-collapse:collapse; margin-bottom:8px; font-size:11px;">
        <thead>
            <tr style="background:#FAF8F4; border:1px solid #E2DFD7; text-align:left; color:#475569;">
                <th style="padding:4px 6px; font-weight:800;">ITEM / SKU</th>
                <th style="padding:4px 6px; font-weight:800; text-align:center;">SIZE</th>
                <th style="padding:4px 6px; font-weight:800; text-align:center;">QTY</th>
            </tr>
        </thead>
        <tbody>
            <tr style="border-bottom:1px solid #E2DFD7;">
                <td style="padding:5px 6px;">
                    <div style="font-weight:800; color:#181512;"><?php echo htmlspecialchars($items_summary); ?></div>
                    <div style="font-size:9.5px; color:#64748B; font-family:monospace;">SKU: <?php echo htmlspecialchars($sku); ?></div>
                </td>
                <td style="padding:5px 6px; text-align:center; font-weight:800; color:#8A681F; white-space:nowrap;">
                    <?php echo htmlspecialchars($size); ?>
                </td>
                <td style="padding:5px 6px; text-align:center; font-weight:900; color:#181512;">
                    <?php echo $items_count; ?>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Order Reference & QC Verification -->
    <div style="display:flex; justify-content:space-between; align-items:center; font-size:11px; color:#475569; border-top:1px solid #E2DFD7; padding-top:6px; font-weight:700;">
        <div>Order Reference: <strong style="color:#181512;"><?php echo $order_id; ?></strong></div>
        <div style="border:1px solid #181512; padding:2px 8px; border-radius:3px; color:#181512; font-weight:800; font-size:9.5px; text-align:center;">
            QC PASS • SILK MARK
        </div>
    </div>
</div>
