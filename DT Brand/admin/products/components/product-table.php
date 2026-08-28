<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * product-table.php — High-Density Desktop Data Table with Real Database Data
 * DT Brand's & Jai Hanuman Tex
 *
 * Removed from every row:
 *   - a Brand column that always printed "DT Signature" (products has no brand
 *     column, and there is no brands table);
 *   - an image fallback that cycled /assets/images/product1..8.png by product
 *     id, so a product with no photo borrowed a stock saree photo;
 *   - "MOQ: 8 pcs", "50 in stock", "4.9 ★" and "(85)" defaults, which showed
 *     stock and ratings for products that had none.
 *
 * getAll(true) is used for the default list because this is an admin table and
 * drafts must be visible here.
 */
$productsList = isset($productsList) && is_array($productsList) ? $productsList : \DTBrand\ProductCatalog::getAll(true);
$ptNoImage = \DTBrand\ProductCatalog::NO_IMAGE;
?>
<div class="dt-table-wrap" style="overflow-x: auto; width: 100%; box-sizing: border-box;">
    <table class="dt-data-table" id="dtProductMasterTable" style="width: 100%; border-collapse: collapse; font-size: 12px;">
        <thead>
            <tr>
                <th style="width:26px; text-align:center; padding: 6px 4px;">
                    <input type="checkbox" onchange="window.toggleBulkSelectAll(this)" style="cursor:pointer;" title="Select All">
                </th>
                <th style="width:38px; padding: 6px 4px;">Image</th>
                <th style="padding: 6px 6px; white-space: nowrap;">Product Name &amp; SKU</th>
                <th style="padding: 6px 6px; white-space: nowrap;">Category</th>
                <th style="padding: 6px 6px; white-space: nowrap;">Price</th>
                <th style="padding: 6px 6px; white-space: nowrap;">Wholesale</th>
                <th style="padding: 6px 6px; white-space: nowrap;">Stock</th>
                <th style="padding: 6px 6px; white-space: nowrap;">Rating</th>
                <th style="padding: 6px 6px; white-space: nowrap;">Status</th>
                <th style="padding: 6px 6px; text-align:right; white-space: nowrap;">Actions</th>
            </tr>
        </thead>
        <tbody id="dtProductTableBody">
            <?php foreach ($productsList as $p): ?>
            <?php
                $pTitle = (string)($p['title'] ?? ($p['name'] ?? ''));
                $pHasPhoto = !empty($p['has_photo']) || (!empty($p['image']) && $p['image'] !== $ptNoImage);
                $pImg = $pHasPhoto ? (string)$p['image'] : $ptNoImage;
                $pStatus = $p['status'] ?? 'in_stock';
                $badgeClass = ($pStatus === 'in_stock' || $pStatus === 'active') ? 'success' : ($pStatus === 'draft' ? 'warning' : 'danger');
                $statusLabel = ($pStatus === 'in_stock' || $pStatus === 'active') ? 'Active' : ucfirst(str_replace('_', ' ', (string)$pStatus));
                $pRetail = (float)($p['retail_price'] ?? ($p['price'] ?? 0));
                $pMrp = (float)($p['mrp'] ?? ($p['old_price'] ?? 0));
                $pWholesale = (float)($p['wholesale_price'] ?? 0);
                $pMoq = (int)($p['moq'] ?? 0);
                $pStock = (int)($p['stock_qty'] ?? 0);
                $pRating = (float)($p['rating'] ?? 0);
                $pReviews = (int)($p['reviews_count'] ?? 0);
                $pVideoCount = count((array)($p['videos'] ?? [])) + count((array)($p['embeds'] ?? []));
                $pGalleryCount = count((array)($p['images'] ?? []));
            ?>
            <tr data-product-id="<?= (int)$p['id'] ?>">
                <td style="text-align:center; padding: 6px 4px;">
                    <input type="checkbox" class="dt-prod-row-check" value="<?= (int)$p['id'] ?>" onchange="window.handleRowSelect()" style="cursor:pointer;">
                </td>
                <td style="padding: 6px 4px;">
                    <img src="<?= htmlspecialchars($pImg) ?>" class="dt-prod-img" alt="<?= htmlspecialchars($pTitle) ?>" title="<?= $pHasPhoto ? (int)$pGalleryCount . ' photo(s)' : 'No photo uploaded' ?><?= $pVideoCount > 0 ? ', ' . (int)$pVideoCount . ' video(s)' : '' ?>" style="width:36px; height:48px; object-fit:cover; border-radius:4px; border:1px solid #ddd; <?= $pHasPhoto ? '' : 'opacity:.55;' ?>">
                </td>
                <td style="padding: 6px 6px;">
                    <a href="/admin/products/view.php?id=<?= (int)$p['id'] ?>" class="dt-prod-info-name" style="font-weight:600; color:#2271b1; text-decoration:none; display:block; max-width:200px; font-size:12.5px; line-height:1.25;"><?= htmlspecialchars($pTitle) ?></a>
                    <span class="dt-prod-info-sku" style="font-size:11px; color:#646970; display:block;">SKU: <?= htmlspecialchars((string)($p['sku'] ?? '')) ?: '<em>none</em>' ?><?= $pVideoCount > 0 ? ' &bull; <span title="Has video" style="color:#8A681F;">video</span>' : '' ?></span>
                </td>
                <td style="padding: 6px 6px; white-space:nowrap;"><strong><?= htmlspecialchars((string)($p['category'] ?? '')) ?: '<span style="color:#a7aaad;font-weight:600;">Uncategorised</span>' ?></strong></td>
                <td style="padding: 6px 6px; white-space:nowrap;">
                    <?php if ($pRetail > 0): ?>
                        <strong style="color:#181512;">&#8377;<?= number_format($pRetail) ?></strong>
                        <?php if ($pMrp > $pRetail): ?>
                        <del style="color:#7A7266; font-size:11px; margin-left:2px;">&#8377;<?= number_format($pMrp) ?></del>
                        <?php endif; ?>
                    <?php else: ?>
                        <span style="color:#DC2626; font-size:11px; font-weight:700;">No price</span>
                    <?php endif; ?>
                </td>
                <td style="padding: 6px 6px; white-space:nowrap;">
                    <?php if ($pWholesale > 0): ?>
                        <strong style="color:#8A681F;">&#8377;<?= number_format($pWholesale) ?>/pc</strong><br>
                        <small style="color:#7A7266; font-size:10.5px;"><?= $pMoq > 0 ? 'MOQ: ' . $pMoq . ' pcs' : 'MOQ not set' ?></small>
                    <?php else: ?>
                        <span style="color:#a7aaad; font-size:11px;">Not set</span>
                    <?php endif; ?>
                </td>
                <td style="padding: 6px 6px; white-space:nowrap;"><strong style="color:<?= $pStock > 0 ? '#15803D' : '#DC2626' ?>;"><?= $pStock ?> in stock</strong></td>
                <td style="padding: 6px 6px; white-space:nowrap;">
                    <?php if ($pReviews > 0): ?>
                        <span style="color:#F59E0B; font-weight:800;"><?= number_format($pRating, 1) ?> &#9733;</span> <small style="color:#7A7266;">(<?= $pReviews ?>)</small>
                    <?php else: ?>
                        <small style="color:#a7aaad;">No reviews</small>
                    <?php endif; ?>
                </td>
                <td style="padding: 6px 6px; white-space:nowrap;"><span class="adm-badge <?= $badgeClass ?>"><?= $statusLabel ?></span></td>
                <td style="text-align:right; padding: 6px 6px; white-space:nowrap;">
                    <div class="adm-action-btn-group" style="display:inline-flex; align-items:center; gap:3px;">
                        <a href="/admin/products/view.php?id=<?= $p['id'] ?>" class="adm-action-btn" title="View Details">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </a>
                        <a href="/admin/products/edit.php?id=<?= $p['id'] ?>" class="adm-action-btn" title="Edit">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </a>
                        <a href="/admin/products/duplicate.php?id=<?= $p['id'] ?>" class="adm-action-btn" title="Duplicate / Copy SKU">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        </a>
                        <button type="button" class="adm-action-btn" title="Delete" onclick="window.trashProductRow(<?= $p['id'] ?>, this)">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#DC2626" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        </button>
                        <button type="button" class="adm-action-btn wa" title="Share via WhatsApp" onclick="window.shareProductWhatsApp(<?= $p['id'] ?>)">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
