<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * retail.php — Retail Price & Margin View
 * DT Brand's & Jai Hanuman Tex
 *
 * Was a hardcoded "Silk Sarees — ₹2,200 cost / ₹4,490 MRP" row with a
 * toast-only Save. Shows the live retail-vs-MRP bands per category; actual
 * edits live on each product via the product editor.
 */
require_once __DIR__ . '/../../src/ProductCatalog.php';

use DTBrand\ProductCatalog;

$page_title = "B2C Retail Pricing & Markups";
$active_nav = "pricing";

$all = ProductCatalog::getAll(true);
$bands = [];
foreach ($all as $p) {
    $cat = (string)($p['category'] ?? 'Uncategorised');
    if (!isset($bands[$cat])) {
        $bands[$cat] = ['count' => 0, 'sum_mrp' => 0.0, 'sum_ret' => 0.0, 'n' => 0];
    }
    $bands[$cat]['count']++;
    $mrp = (float)($p['mrp'] ?? 0);
    $ret = (float)($p['retail_price'] ?? 0);
    if ($ret > 0) {
        $bands[$cat]['sum_ret'] += $ret;
        $bands[$cat]['sum_mrp'] += $mrp > 0 ? $mrp : $ret;
        $bands[$cat]['n']++;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B2C Retail Pricing &amp; Markups - DT Brand's Admin</title>
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
                        <span>B2C Retail Pricing &amp; Markups</span>
                        <span class="adm-badge gold"><?= count($all) ?> SKUs</span>
                    </h1>
                    <p class="adm-page-subtitle">Retail price against strike-through MRP, aggregated per category from live rows.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/pricing/" class="adm-btn-secondary">← Pricing Suite</a>
                    <a href="/admin/products/" class="adm-btn-primary" style="text-decoration:none;">Edit Product Prices</a>
                </div>
            </div>

            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Retail Price Bands by Category</span></h3>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>SKUs</th>
                                <th>Avg MRP (strike-through)</th>
                                <th>Avg Selling Price</th>
                                <th>Avg Discount Shown</th>
                                <th style="text-align:right;">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($bands)): ?>
                                <tr><td colspan="6" style="padding:20px; text-align:center; color:#64748B;">No products yet.</td></tr>
                            <?php else: ?>
                                <?php foreach ($bands as $cat => $b): ?>
                                <?php
                                    $disc = $b['n'] > 0 && $b['sum_mrp'] > 0
                                        ? round((($b['sum_mrp'] - $b['sum_ret']) / $b['sum_mrp']) * 100, 1)
                                        : null;
                                ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($cat) ?></strong></td>
                                    <td><?= (int)$b['count'] ?></td>
                                    <td><?= $b['n'] > 0 ? ('₹' . number_format($b['sum_mrp'] / $b['n'])) : '—' ?></td>
                                    <td><?= $b['n'] > 0 ? ('₹' . number_format($b['sum_ret'] / $b['n'])) : '—' ?></td>
                                    <td><?= $disc !== null ? ('<span class="adm-badge success">' . $disc . '% off</span>') : '—' ?></td>
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