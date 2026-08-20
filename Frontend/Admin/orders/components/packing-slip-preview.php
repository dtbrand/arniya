<?php
/**
 * packing-slip-preview.php — Warehouse Packing Slip Component
 * DT Brand's & Jai Hanuman Tex
 */
$order_id = isset($order['id']) ? $order['id'] : 'DTB-001624';
$customer = isset($order['customer']) ? $order['customer'] : 'Rajesh Kumar (Vardhman Tex)';
$shipping_addr = isset($order['address']['shipping']) ? $order['address']['shipping'] : 'Godown 12, Transport Nagar, Surat, Gujarat - 395010';
$items = isset($order['items']) ? $order['items'] : [
    ['name' => 'Kanjivaram Silk Saree Pure Zari Weave', 'sku' => 'KNJ-001', 'variant' => 'Royal Ruby / 5.5m', 'qty' => 25]
];
?>
<div class="dt-doc-container">
    <div class="dt-doc-header">
        <div>
            <h2 class="dt-doc-brand-title">DT BRAND'S WAREHOUSE</h2>
            <div class="dt-doc-brand-subtitle">Surat Central Depot Dispatch Floor</div>
        </div>
        <div class="dt-doc-meta-box">
            <span class="dt-doc-meta-title">PACKING SLIP</span>
            <span>Order ID: <strong><?php echo $order_id; ?></strong></span>
            <span>Manifest Box: <strong>CTN-<?php echo substr($order_id, 4); ?></strong></span>
        </div>
    </div>

    <div class="dt-doc-address-card" style="margin-bottom:20px;">
        <div class="dt-doc-address-title">Shipment Destination:</div>
        <strong><?php echo htmlspecialchars($customer); ?></strong><br>
        <?php echo nl2br(htmlspecialchars($shipping_addr)); ?>
    </div>

    <table class="dt-doc-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Item &amp; Description</th>
                <th>SKU</th>
                <th>Variant / Color</th>
                <th style="text-align:center;">Packed Qty</th>
                <th style="text-align:center;">QC Verified</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $idx => $it): ?>
            <tr>
                <td><?php echo ($idx + 1); ?></td>
                <td><strong><?php echo htmlspecialchars($it['name']); ?></strong></td>
                <td style="font-family:monospace;"><?php echo htmlspecialchars($it['sku']); ?></td>
                <td><?php echo htmlspecialchars($it['variant'] ?? 'Standard'); ?></td>
                <td style="text-align:center; font-weight:800; font-size:13px;"><?php echo $it['qty']; ?> pcs</td>
                <td style="text-align:center; font-weight:700; color:#15803D;">[ ✓ PASS ]</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="dt-doc-footer">
        Packer ID: <strong>SURAT-WH-04</strong> • QC Inspected: <strong>PASS (Silk Mark Verified)</strong>
    </div>
</div>
