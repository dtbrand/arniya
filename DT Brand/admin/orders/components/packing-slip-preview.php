<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * packing-slip-preview.php — Warehouse Packing Slip Component
 * DT Brand's & Jai Hanuman Tex
 */
$order_id = isset($order['id']) ? $order['id'] : 'DTB-001624';
$customer = isset($order['customer']) ? $order['customer'] : 'Rajesh Kumar (Vardhman Tex)';
$billing_addr = isset($order['address']['billing']) ? $order['address']['billing'] : "Shop 42, Textile Market, Ring Road, Surat, Gujarat - 395002\nGSTIN: 24AAECJ1928K1Z5 | Phone: +91 98220 19283";
$shipping_addr = isset($order['address']['shipping']) ? $order['address']['shipping'] : "Godown 12, Transport Nagar, Surat, Gujarat - 395010\nContact: +91 98220 19283";
$items = isset($order['items']) ? $order['items'] : [
    [
        'name' => 'Kanjivaram Silk Saree Pure Zari Weave', 
        'sku' => 'KNJ-001', 
        'variant' => 'Royal Ruby / 5.5m',
        'color_name' => 'Royal Ruby',
        'color_hex' => '#9B111E',
        'image' => '/assets/images/product1.png',
        'qty' => 25
    ]
];
?>
<div class="dt-doc-container">
    <!-- Clean Executive Packing Slip Header (Logo Removed) -->
    <div class="dt-doc-header" style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #8A681F; padding-bottom:14px; margin-bottom:20px;">
        <div>
            <h1 style="margin:0; font-size:22px; font-weight:800; color:#8A681F; letter-spacing:0.5px; text-transform:uppercase;">PACKING SLIP</h1>
            <div style="margin-top:4px;">
                <span style="font-size:10px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-weight:800; padding:2px 8px; border-radius:4px;">DEPOT DISPATCH MANIFEST</span>
            </div>
        </div>
        <div class="dt-doc-meta-box" style="text-align:right; font-size:11.5px;">
            <span>Order ID: <strong style="font-size:13px; color:#181512;"><?php echo $order_id; ?></strong></span>
            <span>Manifest Box: <strong style="color:#8A681F;">CTN-<?php echo substr($order_id, 4); ?></strong></span>
            <span>Dispatch Date: <strong style="color:#181512;"><?php echo $order['date'] ?? '21 Aug 2026'; ?></strong></span>
        </div>
    </div>

    <!-- 2-Column Grid: Billing Name & Company Only | Shipping Destination -->
    <div class="dt-doc-grid-2" style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
        <div class="dt-doc-address-card" style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:12px 14px; font-size:11.5px; line-height:1.5;">
            <div class="dt-doc-address-title" style="font-size:10px; font-weight:800; text-transform:uppercase; color:#8A681F; margin-bottom:4px; letter-spacing:0.5px;">Billed Customer &amp; Firm:</div>
            <strong style="font-size:14px; color:#181512; display:block;"><?php echo htmlspecialchars($order['customer_name'] ?? 'Rajesh Kumar'); ?></strong>
            <div style="font-size:12px; color:#475569; margin-top:2px;">
                Firm: <strong style="color:#181512;"><?php echo htmlspecialchars($order['company_name'] ?? 'Vardhman Tex'); ?></strong>
            </div>
            <div style="margin-top:5px;">
                <span style="font-size:9.5px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-weight:800; padding:1px 6px; border-radius:4px; display:inline-block;">Verified B2B Account</span>
            </div>
        </div>
        <div class="dt-doc-address-card" style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:12px 14px; font-size:11.5px; line-height:1.5;">
            <div class="dt-doc-address-title" style="font-size:10px; font-weight:800; text-transform:uppercase; color:#8A681F; margin-bottom:4px; letter-spacing:0.5px;">Shipping Destination (Godown):</div>
            <strong style="font-size:14px; color:#181512; display:block;"><?php echo htmlspecialchars($customer); ?></strong>
            <span style="color:#475569; font-size:12px; line-height:1.4; display:block; margin-top:2px;"><?php echo htmlspecialchars($shipping_addr); ?></span>
            <div style="font-size:11.5px; color:#181512; margin-top:4px; font-weight:700;">
                <span style="color:#8A681F; font-size:10px; font-weight:800; text-transform:uppercase;">Contact No:</span> <?php echo htmlspecialchars($order['phone'] ?? '+91 98220 19283'); ?>
            </div>
        </div>
    </div>

    <!-- Line Items Table with Real Product Thumbnail Photo & Color Swatch -->
    <table class="dt-doc-table" style="width:100%; border-collapse:collapse; margin-bottom:20px; font-size:11.5px;">
        <thead>
            <tr style="background:#181512; color:#FAF5E8;">
                <th style="padding:8px 10px; font-size:10.5px; text-transform:uppercase; text-align:left; width:30px;">#</th>
                <th style="padding:8px 10px; font-size:10.5px; text-transform:uppercase; text-align:left;">Product &amp; Description</th>
                <th style="padding:8px 10px; font-size:10.5px; text-transform:uppercase; text-align:left;">Variant &amp; Color</th>
                <th style="padding:8px 10px; font-size:10.5px; text-transform:uppercase; text-align:center;">Packed Qty</th>
                <th style="padding:8px 10px; font-size:10.5px; text-transform:uppercase; text-align:center;">QC Verified</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $idx => $it): ?>
            <tr style="border-bottom:1px solid #E2E8F0;">
                <td style="padding:10px; color:#64748B; vertical-align:middle;"><?php echo ($idx + 1); ?></td>
                <td style="padding:10px; vertical-align:middle;">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <img src="<?php echo $it['image'] ?? '/assets/images/product1.png'; ?>" onerror="this.onerror=null; this.src='/assets/images/product1.png';" alt="Product Photo" style="width:46px; height:46px; border-radius:6px; object-fit:cover; border:1px solid #E2DFD7; background:#FAF8F4; flex-shrink:0;">
                        <div>
                            <strong style="color:#181512; font-size:12.5px; line-height:1.3; display:block;"><?php echo htmlspecialchars($it['name']); ?></strong>
                            <span style="font-size:10.5px; font-family:monospace; color:#8A681F; font-weight:700;">SKU: <?php echo htmlspecialchars($it['sku']); ?></span>
                        </div>
                    </div>
                </td>
                <td style="padding:10px; vertical-align:middle;">
                    <div style="display:inline-flex; align-items:center; gap:6px; background:#FAF8F4; border:1px solid #E2DFD7; padding:4px 10px; border-radius:20px;">
                        <span style="width:12px; height:12px; border-radius:50%; background:<?php echo $it['color_hex'] ?? '#9B111E'; ?>; border:1px solid rgba(0,0,0,0.15); display:inline-block; flex-shrink:0;"></span>
                        <span style="font-weight:700; color:#181512; font-size:11px;"><?php echo htmlspecialchars($it['variant'] ?? 'Royal Ruby / 5.5m'); ?></span>
                    </div>
                </td>
                <td style="padding:10px; text-align:center; vertical-align:middle;">
                    <span style="font-weight:800; font-size:14px; color:#181512;"><?php echo $it['qty']; ?></span> <span style="font-size:11px; color:#64748B;">pcs</span>
                </td>
                <td style="padding:10px; text-align:center; vertical-align:middle;">
                    <span style="display:inline-block; font-size:10px; font-weight:800; color:#15803D; background:#DCFCE7; border:1px solid #86EFAC; padding:3px 8px; border-radius:4px;">✓ PASS (Silk Mark)</span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Footer Verification -->
    <div class="dt-doc-footer" style="border-top:1px solid #E2DFD7; padding-top:12px; font-size:10.5px; color:#64748B; display:flex; justify-content:space-between; align-items:center;">
        <div>
            QC Verification: <strong style="color:#15803D;">PASS (Silk Mark Certified)</strong> • Sealed Manifest
        </div>
        <div style="text-align:right; font-weight:700; color:#181512;">
            Warehouse Dispatch Officer
        </div>
    </div>
</div>
