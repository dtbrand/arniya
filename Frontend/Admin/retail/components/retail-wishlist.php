<?php
/**
 * retail-wishlist.php — DT Brand's & Jai Hanuman Tex
 * Retail Customer Wishlist Demand & Popularity Index Component
 */
require_once __DIR__ . '/retail-data.php';
$wishlist = getRetailWishlistItems();
?>

<div class="dt-retail-card">
    <div class="dt-retail-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
            <h4 class="dt-retail-card-title">Customer Wishlist Popularity &amp; Buying Intent</h4>
        </div>
        <span class="dt-status-pill-clean gold">1,427 Total Saved Items</span>
    </div>

    <div style="overflow-x:auto; width:100%;">
        <table class="dt-retail-table">
            <thead>
                <tr>
                    <th>Product &amp; SKU</th>
                    <th>Category</th>
                    <th style="text-align:right;">Retail Price (₹)</th>
                    <th style="text-align:right;">Wishlist Adds</th>
                    <th style="text-align:right;">Current Stock</th>
                    <th style="text-align:right;">Wishlist-to-Order Conv.</th>
                    <th>Demand Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($wishlist as $w): ?>
                    <tr>
                        <td>
                            <strong style="color:#181512; font-size:0.8rem; display:block;"><?php echo htmlspecialchars($w['name']); ?></strong>
                            <span style="font-family:monospace; font-size:0.7rem; color:#8A681F; font-weight:800;"><?php echo $w['sku']; ?></span>
                        </td>
                        <td style="font-size:0.75rem; color:#78716C;"><?php echo $w['category']; ?></td>
                        <td style="text-align:right; font-weight:900; color:#181512; font-size:0.85rem;">₹<?php echo number_format($w['price']); ?></td>
                        <td style="text-align:right; font-weight:800; color:#8A681F;"><?php echo $w['wishlist_count']; ?> times</td>
                        <td style="text-align:right; font-weight:700; color:#181512;"><?php echo $w['stock']; ?> pcs</td>
                        <td style="text-align:right; font-weight:800; color:#15803D;"><?php echo $w['conv_rate']; ?></td>
                        <td><span class="dt-status-pill-clean <?php echo $w['badge']; ?>"><?php echo $w['status']; ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
