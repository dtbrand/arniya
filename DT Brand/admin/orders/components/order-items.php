<?php
/**
 * order-items.php — Order Line Items Breakdown Table Component
 * DT Brand's & Jai Hanuman Tex
 */
$items = isset($order['items']) ? $order['items'] : [
    [
        'name' => 'Kanjivaram Silk Saree Pure Zari Weave',
        'sku' => 'KNJ-001',
        'variant' => 'Royal Ruby / 5.5m + Blouse',
        'qty' => 25,
        'price' => 4490,
        'tax' => 1122.50,
        'total' => 112250,
        'img' => '/assets/images/product1.png'
    ]
];
?>
<div class="dt-detail-card">
    <div class="dt-detail-card-head">
        <h3 class="dt-detail-card-title">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
            <span>Order Line Items (<?php echo count($items); ?> SKUs)</span>
        </h3>
    </div>
    <div class="dt-detail-card-body" style="padding:0;">
        <table class="dt-item-table">
            <thead>
                <tr>
                    <th>Product &amp; SKU</th>
                    <th>Variant</th>
                    <th style="text-align:center;">Qty</th>
                    <th style="text-align:right;">Unit Price</th>
                    <th style="text-align:right;">Total (₹)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $it): ?>
                <tr>
                    <td>
                        <div class="dt-item-prod-cell">
                            <img src="<?php echo htmlspecialchars($it['img'] ?? '/assets/images/product1.png'); ?>" onerror="this.src='/assets/images/product1.png';" alt="<?php echo htmlspecialchars($it['name']); ?>" class="dt-item-img">
                            <div class="dt-item-meta">
                                <a href="/admin/products/" class="dt-item-name"><?php echo htmlspecialchars($it['name']); ?></a>
                                <span class="dt-item-sku">SKU: <?php echo htmlspecialchars($it['sku']); ?></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="dt-item-variant-pill"><?php echo htmlspecialchars($it['variant']); ?></span>
                    </td>
                    <td style="text-align:center; font-weight:800; font-size:12px;">
                        <?php echo $it['qty']; ?> pcs
                    </td>
                    <td style="text-align:right; font-weight:700; color:#475569;">
                        ₹<?php echo number_format($it['price']); ?>
                    </td>
                    <td style="text-align:right; font-weight:800; color:#181512; font-size:13px;">
                        ₹<?php echo number_format($it['price'] * $it['qty']); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
