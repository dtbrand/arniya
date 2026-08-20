<?php
/**
 * invoice-preview.php — B2B GST Tax Invoice Preview Component
 * DT Brand's & Jai Hanuman Tex
 */
$order_id = isset($order['id']) ? $order['id'] : 'DTB-001624';
$inv_date = isset($order['date']) ? $order['date'] : '21 Aug 2026';
$customer = isset($order['customer']) ? $order['customer'] : 'Rajesh Kumar (Vardhman Tex)';
$billing_addr = isset($order['address']['billing']) ? $order['address']['billing'] : 'Shop 42, Textile Market, Ring Road, Surat, Gujarat - 395002';
$shipping_addr = isset($order['address']['shipping']) ? $order['address']['shipping'] : 'Godown 12, Transport Nagar, Surat, Gujarat - 395010';
$items = isset($order['items']) ? $order['items'] : [
    ['name' => 'Kanjivaram Silk Saree Pure Zari Weave', 'sku' => 'KNJ-001', 'qty' => 25, 'price' => 4490]
];
$subtotal = isset($order['amount']) ? $order['amount'] : 112250;
$tax_gst = round($subtotal * 0.05);
$grand_total = $subtotal + $tax_gst;
?>
<div class="dt-doc-container">
    <div class="dt-doc-header">
        <div>
            <h2 class="dt-doc-brand-title">DT BRAND'S &amp; JAI HANUMAN TEX</h2>
            <div class="dt-doc-brand-subtitle">
                Surat Central Textile Depot, Ring Road, Surat, Gujarat - 395002<br>
                GSTIN: <strong>24AAECJ1928K1Z5</strong> • Silk Mark Certified Handlooms
            </div>
        </div>
        <div class="dt-doc-meta-box">
            <span class="dt-doc-meta-title">TAX INVOICE</span>
            <span>Invoice No: <strong>INV-<?php echo substr($order_id, 4); ?>-2026</strong></span>
            <span>Order ID: <strong><?php echo $order_id; ?></strong></span>
            <span>Date: <strong><?php echo $inv_date; ?></strong></span>
        </div>
    </div>

    <div class="dt-doc-grid-2">
        <div class="dt-doc-address-card">
            <div class="dt-doc-address-title">Billed To (Customer):</div>
            <strong><?php echo htmlspecialchars($customer); ?></strong><br>
            <?php echo nl2br(htmlspecialchars($billing_addr)); ?>
        </div>
        <div class="dt-doc-address-card">
            <div class="dt-doc-address-title">Shipped Destination (Godown):</div>
            <strong><?php echo htmlspecialchars($customer); ?></strong><br>
            <?php echo nl2br(htmlspecialchars($shipping_addr)); ?>
        </div>
    </div>

    <table class="dt-doc-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Item Description</th>
                <th>HSN Code</th>
                <th style="text-align:center;">Qty</th>
                <th style="text-align:right;">Rate (₹)</th>
                <th style="text-align:right;">Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $idx => $it): ?>
            <tr>
                <td><?php echo ($idx + 1); ?></td>
                <td>
                    <strong><?php echo htmlspecialchars($it['name']); ?></strong><br>
                    <small style="color:#64748B;">SKU: <?php echo htmlspecialchars($it['sku']); ?></small>
                </td>
                <td>5007</td>
                <td style="text-align:center; font-weight:700;"><?php echo $it['qty']; ?></td>
                <td style="text-align:right;">₹<?php echo number_format($it['price']); ?></td>
                <td style="text-align:right; font-weight:700;">₹<?php echo number_format($it['price'] * $it['qty']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="dt-doc-totals-wrap">
        <table class="dt-doc-totals">
            <tr>
                <td style="color:#64748B;">Subtotal:</td>
                <td style="text-align:right; font-weight:700;">₹<?php echo number_format($subtotal); ?></td>
            </tr>
            <tr>
                <td style="color:#64748B;">SGST (2.5%):</td>
                <td style="text-align:right;">₹<?php echo number_format($tax_gst / 2); ?></td>
            </tr>
            <tr>
                <td style="color:#64748B;">CGST (2.5%):</td>
                <td style="text-align:right;">₹<?php echo number_format($tax_gst / 2); ?></td>
            </tr>
            <tr class="total-row">
                <td>Grand Total:</td>
                <td style="text-align:right; color:#8A681F;">₹<?php echo number_format($grand_total); ?></td>
            </tr>
        </table>
    </div>

    <div class="dt-doc-footer">
        This is a computer-generated GST tax invoice for DT Brand's &amp; Jai Hanuman Tex Surat Wholesale Depot. No signature required.
    </div>
</div>
