<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * wholesale.php — Wholesale MOQ & Tier Price View
 * DT Brand's & Jai Hanuman Tex
 *
 * Was one invented category row ("Kanjivaram Silks — ₹2,850 / ₹2,750 /
 * ₹2,650") and a Save Tiers button that only toasted. Tier pricing is stored
 * per-product (wholesale_price + moq_half_set / moq_full_set /
 * moq_master_bale columns), not per-category, so this page now shows the
 * real aggregate view and routes edits to the product editor where the
 * actual write path lives (ProductCatalog::update via /api/products.php).
 */
require_once __DIR__ . '/../../src/ProductCatalog.php';

use DTBrand\ProductCatalog;

$page_title = "Wholesale MOQ Tiers";
$active_nav = "pricing";

$all = ProductCatalog::getAll(true);

// Aggregate the real per-product trade prices into category bands.
$bands = [];
foreach ($all as $p) {
    $cat = (string)($p['category'] ?? 'Uncategorised');
    if (!isset($bands[$cat])) {
        $bands[$cat] = ['count' => 0, 'sum_ws' => 0.0, 'sum_ws_full' => 0.0, 'n_full' => 0];
    }
    $bands[$cat]['count']++;
    $ws = (float)($p['wholesale_price'] ?? 0);
    if ($ws > 0) {
        $bands[$cat]['sum_ws'] += $ws;
        $bands[$cat]['n_full']++;
        $fs = (float)($p['full_set_price'] ?? 0);
        $bands[$cat]['sum_ws_full'] += $fs > 0 ? $fs : $ws;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wholesale MOQ Tiers - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Wholesale MOQ Tiers</span>
                        <span class="adm-badge gold"><?= count($all) ?> SKUs</span>
                    </h1>
                    <p class="adm-page-subtitle">Trade pricing is stored per product — this is the live aggregate view.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/pricing/" class="adm-btn-secondary">← Pricing Suite</a>
                    <a href="/admin/products/" class="adm-btn-primary" style="text-decoration:none;">Edit Product Prices</a>
                </div>
            </div>

            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Trade Price Bands by Category</span></h3>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>SKUs</th>
                                <th>Avg Wholesale (8+ pcs)</th>
                                <th>Avg Full-Set (24+ pcs)</th>
                                <th style="text-align:right;">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($bands)): ?>
                                <tr><td colspan="5" style="padding:20px; text-align:center; color:#64748B;">No products yet. Add products to see trade price bands.</td></tr>
                            <?php else: ?>
                                <?php foreach ($bands as $cat => $b): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($cat) ?></strong></td>
                                    <td><?= (int)$b['count'] ?></td>
                                    <td><strong style="color:#8A681F;"><?= $b['n_full'] > 0 ? ('₹' . number_format($b['sum_ws'] / $b['n_full']) . ' / pc') : '—' ?></strong></td>
                                    <td><strong style="color:#15803D;"><?= $b['n_full'] > 0 ? ('₹' . number_format($b['sum_ws_full'] / $b['n_full']) . ' / pc') : '—' ?></strong></td>
                                    <td style="text-align:right;"><a class="adm-btn-secondary adm-btn-sm" style="text-decoration:none;" href="/admin/products/">Open Products</a></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>