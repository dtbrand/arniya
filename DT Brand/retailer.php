<?php
/**
 * DT Brand/retailer.php — Retailer Ordering Desk & Showroom Bulk Portal
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/ProductCatalog.php';

use DTBrand\ProductCatalog;

$products = ProductCatalog::getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="Retailer showroom and boutique bulk ordering desk — Fast repeat orders, showroom sample sets, GST invoices at DT Brand's." />
    <title>Retailer & Showroom Desk &bull; DT Brand's &bull; Jai Hanuman Tex</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="/assets/css/main.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/header.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/shop.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/modals.css?v=<?= time() ?>">

    <style>
        .dt-retailer-hero {
            background: linear-gradient(135deg, #181512 0%, #2A241E 100%);
            border-bottom: 2px solid #D4AF37;
            padding: 36px 20px;
            color: #FAF5E8;
            text-align: center;
        }
        .dt-retailer-title { font-size: 1.8rem; font-weight: 800; color: #FFFFFF; margin-bottom: 6px; }
        .dt-retailer-sub { font-size: 0.9rem; color: #E2E8F0; max-width: 600px; margin: 0 auto 16px; }
        
        .dt-quick-order-table {
            width: 100%;
            border-collapse: collapse;
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        }
        .dt-quick-order-table th {
            background: #FAF8F4;
            padding: 12px 16px;
            text-align: left;
            font-size: 0.8rem;
            font-weight: 800;
            color: #705114;
            border-bottom: 1.5px solid #E5E7EB;
        }
        .dt-quick-order-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #F3F4F6;
            font-size: 0.85rem;
            vertical-align: middle;
        }
        .dt-table-prod-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .dt-table-prod-img {
            width: 48px;
            height: 60px;
            border-radius: 4px;
            object-fit: cover;
        }
    </style>
</head>
<body>

    <!-- Master Header with Amazon-Style Search & Attached Gold Subnav -->
    <?php include_once __DIR__ . '/includes/header.php'; ?>

    <header class="dt-retailer-hero">
        <span class="dt-btn-pale" style="margin-bottom:10px; display:inline-block; font-size:0.72rem;">🏪 SHOWROOM & BOUTIQUE DESK</span>
        <h1 class="dt-retailer-title">Retailer Quick Order Matrix</h1>
        <p class="dt-retailer-sub">Select quantities across catalog designs in one single page for instant showroom restocking.</p>
    </header>

    <main style="max-width:1280px; margin:30px auto; padding:0 20px;">

        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
            <h2 style="font-size:1.2rem; font-weight:800; color:#111827;">Quick Stocking Grid</h2>
            <button type="button" class="dt-btn-gold" onclick="addSelectedRetailerToCart()">
                <span>Add Selected Items to Bag &rarr;</span>
            </button>
        </div>

        <div style="overflow-x:auto;">
            <table class="dt-quick-order-table">
                <thead>
                    <tr>
                        <th style="width:40px;">Select</th>
                        <th>Product & Fabric</th>
                        <th>SKU</th>
                        <th>Wholesale Price</th>
                        <th>Showroom MRP</th>
                        <th style="width:120px;">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $idx => $p): ?>
                    <tr>
                        <td>
                            <input type="checkbox" class="dt-retailer-check" data-idx="<?= $idx ?>" checked />
                        </td>
                        <td>
                            <div class="dt-table-prod-info">
                                <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="dt-table-prod-img" />
                                <div>
                                    <div style="font-weight:700; color:#111827;"><?= htmlspecialchars($p['name']) ?></div>
                                    <div style="font-size:0.72rem; color:#6B7280;"><?= htmlspecialchars($p['fabric'] ?? 'Pure Silk') ?> &bull; <?= htmlspecialchars($p['category']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td><strong><?= htmlspecialchars($p['sku']) ?></strong></td>
                        <td><strong style="color:#8A681F;">₹<?= number_format($p['wholesale_price']) ?></strong></td>
                        <td><span style="color:#9CA3AF; text-decoration:line-through;">₹<?= number_format($p['mrp']) ?></span></td>
                        <td>
                            <input type="number" class="dt-input-field dt-retailer-qty" data-idx="<?= $idx ?>" value="4" min="1" style="width:70px; text-align:center; height:32px;" />
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </main>

    <!-- Master Footer -->
    <?php include_once __DIR__ . '/includes/footer.php'; ?>

    <!-- Mobile Floating Bottom App Bar -->
    <?php include_once __DIR__ . '/includes/mobile_bottom_nav.php'; ?>

    <!-- Shared Modals (Cart, Wishlist, Checkout, Auth, QuickView, SmartShare, Reels) -->
    <?php include_once __DIR__ . '/shared/cart_drawer.php'; ?>
    <?php include_once __DIR__ . '/shared/wishlist_drawer.php'; ?>
    <?php include_once __DIR__ . '/shared/checkout_modal.php'; ?>
    <?php include_once __DIR__ . '/shared/auth_modal.php'; ?>
    <?php include_once __DIR__ . '/shared/quickview_modal.php'; ?>
    <?php include_once __DIR__ . '/shared/smart_share_modal.php'; ?>
    <?php include_once __DIR__ . '/shared/reels_modal.php'; ?>

    <!-- Master Scripts -->
    <script src="/assets/js/core.js?v=<?= time() ?>"></script>
    <script src="/assets/js/header.js?v=<?= time() ?>"></script>
    <script src="/assets/js/modals.js?v=<?= time() ?>"></script>

    <script>
        var retailerProducts = <?= json_encode(array_values($products)) ?>;

        function addSelectedRetailerToCart() {
            var checks = document.querySelectorAll('.dt-retailer-check:checked');
            if (!checks.length) {
                window.showToast('Please select at least one item');
                return;
            }

            var count = 0;
            checks.forEach(function (chk) {
                var idx = Number(chk.dataset.idx);
                var qtyInput = document.querySelector('.dt-retailer-qty[data-idx="' + idx + '"]');
                var q = qtyInput ? Math.max(1, Number(qtyInput.value)) : 4;
                var p = retailerProducts[idx];
                if (p) {
                    var prodCopy = Object.assign({}, p, { price: p.wholesale_price });
                    window.addToCart(prodCopy, q, 'half_set');
                    count++;
                }
            });

            window.showToast('Added ' + count + ' wholesale items to bag', 'cart');
            window.openCartDrawer();
        }
    </script>

</body>
</html>
