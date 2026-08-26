<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

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
    <!-- Letterhead Header with Real Brand Logo -->
    <div class="dt-doc-header" style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #8A681F; padding-bottom:16px; margin-bottom:20px;">
        <div style="display:flex; align-items:center; gap:16px;">
            <img src="/assets/images/logo.png" onerror="this.onerror=null; this.src='/assets/images/logo.png';" alt="DT Brand's Logo" style="height:54px; width:auto; max-width:180px; object-fit:contain; display:block; flex-shrink:0;">
            <div>
                <h2 class="dt-doc-brand-title" style="margin:0; font-size:20px; font-weight:800; color:#181512; letter-spacing:-0.02em; line-height:1.2;">DT BRAND'S &amp; JAI HANUMAN TEX</h2>
                <div class="dt-doc-brand-subtitle" style="font-size:11px; color:#64748B; margin-top:3px; line-height:1.35;">
                    Surat Central Textile Depot, Ring Road, Surat, Gujarat - 395002<br>
                    GSTIN: <strong>24AAECJ1928K1Z5</strong> • Silk Mark Certified Wholesale Handlooms
                </div>
            </div>
        </div>
        <div class="dt-doc-meta-box">
            <span class="dt-doc-meta-title" style="font-size:17px; font-weight:800; color:#8A681F; letter-spacing:0.5px;">TAX INVOICE</span>
            <div><span style="font-size:9.5px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-weight:800; padding:1px 6px; border-radius:4px;">ORIGINAL FOR RECIPIENT</span></div>
            <span style="margin-top:2px;">Invoice No: <strong>INV-<?php echo substr($order_id, 4); ?>-2026</strong></span>
            <span>Order ID: <strong><?php echo $order_id; ?></strong></span>
            <span>Date: <strong><?php echo $inv_date; ?></strong></span>
        </div>
    </div>

    <!-- 2-Column Address Cards -->
    <div class="dt-doc-grid-2" style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
        <div class="dt-doc-address-card" style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:12px 14px; font-size:11.5px; line-height:1.5;">
            <div class="dt-doc-address-title" style="font-size:10px; font-weight:800; text-transform:uppercase; color:#8A681F; margin-bottom:4px;">Billed To (Customer):</div>
            <strong style="font-size:13px; color:#181512;"><?php echo htmlspecialchars($customer); ?></strong><br>
            <?php echo nl2br(htmlspecialchars($billing_addr)); ?>
        </div>
        <div class="dt-doc-address-card" style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:12px 14px; font-size:11.5px; line-height:1.5;">
            <div class="dt-doc-address-title" style="font-size:10px; font-weight:800; text-transform:uppercase; color:#8A681F; margin-bottom:4px;">Shipped Destination (Godown):</div>
            <strong style="font-size:13px; color:#181512;"><?php echo htmlspecialchars($customer); ?></strong><br>
            <?php echo nl2br(htmlspecialchars($shipping_addr)); ?>
        </div>
    </div>

    <!-- Items Table -->
    <table class="dt-doc-table" style="width:100%; border-collapse:collapse; margin-bottom:16px; font-size:11.5px;">
        <thead>
            <tr style="background:#181512; color:#FAF5E8;">
                <th style="padding:8px 10px; font-size:10.5px; text-transform:uppercase; text-align:left;">#</th>
                <th style="padding:8px 10px; font-size:10.5px; text-transform:uppercase; text-align:left;">Item Description</th>
                <th style="padding:8px 10px; font-size:10.5px; text-transform:uppercase; text-align:center;">HSN Code</th>
                <th style="padding:8px 10px; font-size:10.5px; text-transform:uppercase; text-align:center;">Qty</th>
                <th style="padding:8px 10px; font-size:10.5px; text-transform:uppercase; text-align:right;">Rate (₹)</th>
                <th style="padding:8px 10px; font-size:10.5px; text-transform:uppercase; text-align:right;">Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $idx => $it): ?>
            <tr style="border-bottom:1px solid #E2E8F0;">
                <td style="padding:10px; color:#64748B; vertical-align:middle;"><?php echo ($idx + 1); ?></td>
                <td style="padding:10px; vertical-align:middle;">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <img src="<?php echo $it['image'] ?? '/assets/images/product1.png'; ?>" onerror="this.onerror=null; this.src='/assets/images/product1.png';" alt="Product Photo" style="width:42px; height:42px; border-radius:6px; object-fit:cover; border:1px solid #E2DFD7; background:#FAF8F4; flex-shrink:0;">
                        <div>
                            <strong style="color:#181512; font-size:12.5px; line-height:1.3; display:block;"><?php echo htmlspecialchars($it['name']); ?></strong>
                            <div style="display:flex; align-items:center; gap:8px; margin-top:2px;">
                                <span style="font-size:10px; color:#8A681F; font-weight:700; font-family:monospace;">SKU: <?php echo htmlspecialchars($it['sku']); ?></span>
                                <span style="display:inline-flex; align-items:center; gap:4px; font-size:10px; color:#475569; background:#FAF8F4; padding:1px 6px; border-radius:4px; border:1px solid #E2DFD7;">
                                    <span style="width:8px; height:8px; border-radius:50%; background:#9B111E; display:inline-block;"></span>
                                    <span>Royal Ruby</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </td>
                <td style="padding:10px; text-align:center; font-family:monospace; color:#475569; vertical-align:middle;">5007</td>
                <td style="padding:10px; text-align:center; font-weight:800; font-size:12px; vertical-align:middle;"><?php echo $it['qty']; ?> pcs</td>
                <td style="padding:10px; text-align:right; font-weight:600; vertical-align:middle;">₹<?php echo number_format($it['price']); ?></td>
                <td style="padding:10px; text-align:right; font-weight:800; color:#181512; vertical-align:middle;">₹<?php echo number_format($it['price'] * $it['qty']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Payment Strip & Totals Grid -->
    <div style="display:grid; grid-template-columns:1fr auto; gap:20px; align-items:start; margin-bottom:20px;">
        <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:12px 14px; font-size:11px; line-height:1.5;">
            <div style="font-size:10px; font-weight:800; text-transform:uppercase; color:#8A681F; margin-bottom:3px;">Settlement &amp; Bank Clearance:</div>
            <strong>Payment Mode:</strong> Bank Wire / RTGS Direct Settlement<br>
            <strong>Bank A/c:</strong> ICICI Bank Corporate • <strong>IFSC:</strong> ICIC0000982<br>
            <strong>Settlement Status:</strong> <span style="color:#15803D; font-weight:800;">PAID &amp; CLEARED (UTR-9821039812)</span>
        </div>

        <div class="dt-doc-totals-wrap" style="min-width:280px;">
            <table class="dt-doc-totals" style="width:100%; border-collapse:collapse; font-size:11.5px;">
                <tr>
                    <td style="padding:4px 8px; color:#64748B;">Item Subtotal:</td>
                    <td style="padding:4px 8px; text-align:right; font-weight:700;">₹<?php echo number_format($subtotal); ?></td>
                </tr>
                <tr>
                    <td style="padding:4px 8px; color:#64748B;">SGST (2.5%):</td>
                    <td style="padding:4px 8px; text-align:right; color:#181512;">+ ₹<?php echo number_format($tax_gst / 2); ?></td>
                </tr>
                <tr>
                    <td style="padding:4px 8px; color:#64748B;">CGST (2.5%):</td>
                    <td style="padding:4px 8px; text-align:right; color:#181512;">+ ₹<?php echo number_format($tax_gst / 2); ?></td>
                </tr>
                <tr>
                    <td style="padding:4px 8px; color:#64748B;">Depot Freight:</td>
                    <td style="padding:4px 8px; text-align:right; color:#15803D; font-weight:700;">FREE (Surat Central)</td>
                </tr>
                <tr class="total-row" style="background:#FAF5E8; border-top:2px solid #8A681F; border-bottom:2px solid #8A681F;">
                    <td style="padding:8px; font-weight:800; font-size:13px; color:#181512;">Grand Total:</td>
                    <td style="padding:8px; text-align:right; font-weight:800; font-size:15px; color:#8A681F;">₹<?php echo number_format($grand_total); ?></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Authorized Signatory Stamp Footer -->
    <div class="dt-doc-footer" style="border-top:1px solid #E2DFD7; padding-top:12px; font-size:10px; color:#64748B; display:flex; justify-content:space-between; align-items:center;">
        <div>
            This is a computer-generated GST Tax Invoice from DT Brand's &amp; Jai Hanuman Tex Surat Central Depot.<br>
            Direct Central Inquiries: accounts@jaihanumantex.in • Helpline: +91 98251 00000
        </div>
        <div style="text-align:right; font-weight:700; color:#181512;">
            Authorized Accounting Signatory<br>
            <span style="font-weight:400; font-size:9px; color:#8A681F;">Surat Central Depot Dock HQ</span>
        </div>
    </div>
</div>
