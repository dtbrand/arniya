<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * order-items.php — Order Line Items Breakdown Table Component
 * DT Brand's & Jai Hanuman Tex
 *
 * The rows come from order_items. There is no sample line any more: this used to
 * default to a 25-piece "Kanjivaram Silk Saree Pure Zari Weave" worth ₹1,12,250,
 * which was displayed whenever the page could not supply items.
 */
$items = isset($order['items']) && is_array($order['items']) ? $order['items'] : [];
$oiNoImage = '/assets/images/no-image.svg';
?>
<div class="dt-detail-card">
    <div class="dt-detail-card-head">
        <h3 class="dt-detail-card-title">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
            <span>Order Line Items (<?php echo count($items); ?>)</span>
        </h3>
    </div>
    <div class="dt-detail-card-body" style="padding:0;">
        <?php if (empty($items)): ?>
        <p style="margin:0; padding:18px; font-size:12px; color:#646970;">
            No line items are stored against this order.
        </p>
        <?php else: ?>
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
                <?php foreach ($items as $it):
                    $oiName = trim((string)($it['name'] ?? ''));
                    $oiSku = trim((string)($it['sku'] ?? ''));
                    $oiVariant = trim((string)($it['variant'] ?? ''));
                    $oiQty = (int)($it['qty'] ?? 0);
                    $oiPrice = (float)($it['price'] ?? 0);
                    $oiTotal = isset($it['total']) && (float)$it['total'] > 0
                        ? (float)$it['total']
                        : $oiPrice * $oiQty;
                    $oiImg = trim((string)($it['img'] ?? ''));
                    $oiHasImg = ($oiImg !== '' && $oiImg !== $oiNoImage);
                    $oiPid = (int)($it['product_id'] ?? 0);
                ?>
                <tr>
                    <td>
                        <div class="dt-item-prod-cell">
                            <img src="<?php echo htmlspecialchars($oiHasImg ? $oiImg : $oiNoImage); ?>" alt="<?php echo htmlspecialchars($oiName); ?>" class="dt-item-img"<?php echo $oiHasImg ? '' : ' style="opacity:.45;"'; ?>>
                            <div class="dt-item-meta">
                                <?php if ($oiPid > 0): ?>
                                <a href="/admin/products/view.php?id=<?php echo $oiPid; ?>" class="dt-item-name"><?php echo htmlspecialchars($oiName !== '' ? $oiName : 'Untitled product'); ?></a>
                                <?php else: ?>
                                <span class="dt-item-name"><?php echo htmlspecialchars($oiName !== '' ? $oiName : 'Untitled product'); ?></span>
                                <?php endif; ?>
                                <span class="dt-item-sku"><?php echo $oiSku !== '' ? 'SKU: ' . htmlspecialchars($oiSku) : 'No SKU'; ?></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?php if ($oiVariant !== ''): ?>
                        <span class="dt-item-variant-pill"><?php echo htmlspecialchars($oiVariant); ?></span>
                        <?php else: ?>
                        <span style="font-size:11px; color:#94A3B8;">Not specified</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align:center; font-weight:800; font-size:12px;">
                        <?php echo $oiQty; ?> pcs
                    </td>
                    <td style="text-align:right; font-weight:700; color:#475569;">
                        ₹<?php echo number_format($oiPrice, 2); ?>
                    </td>
                    <td style="text-align:right; font-weight:800; color:#181512; font-size:13px;">
                        ₹<?php echo number_format($oiTotal, 2); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
