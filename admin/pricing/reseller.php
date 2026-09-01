<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * reseller.php — Reseller Margin View
 * DT Brand's & Jai Hanuman Tex
 *
 * Was a hardcoded margin table with a toast-only Save. Reseller pricing is
 * the per-product `reseller_price` column; this page shows the live
 * category-band aggregate and routes edits to the product editor.
 */
require_once __DIR__ . '/../../src/ProductCatalog.php';

use DTBrand\ProductCatalog;

$page_title = "Reseller Margin Allocations";
$active_nav = "pricing";

$all = ProductCatalog::getAll(true);
$bands = [];
foreach ($all as $p) {
    $cat = (string)($p['category'] ?? 'Uncategorised');
    if (!isset($bands[$cat])) {
        $bands[$cat] = ['count' => 0, 'sum_ret' => 0.0, 'sum_res' => 0.0, 'n' => 0];
    }
    $bands[$cat]['count']++;
    $ret = (float)($p['retail_price'] ?? 0);
    $res = (float)($p['reseller_price'] ?? 0);
    if ($ret > 0 && $res > 0) {
        $bands[$cat]['sum_ret'] += $ret;
        $bands[$cat]['sum_res'] += $res;
        $bands[$cat]['n']++;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseller Margin Allocations - DT Brand's Admin</title>
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
                        <span>Reseller Margin Allocations</span>
                        <span class="adm-badge gold"><?= count($all) ?> SKUs</span>
                    </h1>
                    <p class="adm-page-subtitle">Reseller price vs retail price, aggregated per category from live rows.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/pricing/" class="adm-btn-secondary">← Pricing Suite</a>
                    <a href="/admin/products/" class="adm-btn-primary" style="text-decoration:none;">Edit Product Prices</a>
                </div>
            </div>

            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Reseller Margin Bands by Category</span></h3>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>SKUs</th>
                                <th>Avg Retail</th>
                                <th>Avg Reseller</th>
                                <th>Avg Reseller Margin</th>
                                <th style="text-align:right;">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($bands)): ?>
                                <tr><td colspan="6" style="padding:20px; text-align:center; color:#64748B;">No products yet.</td></tr>
                            <?php else: ?>
                                <?php foreach ($bands as $cat => $b): ?>
                                <?php
                                    $margin = $b['n'] > 0
                                        ? round((($b['sum_ret'] - $b['sum_res']) / $b['sum_ret']) * 100, 1)
                                        : null;
                                ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($cat) ?></strong></td>
                                    <td><?= (int)$b['count'] ?></td>
                                    <td><?= $b['n'] > 0 ? ('₹' . number_format($b['sum_ret'] / $b['n'])) : '—' ?></td>
                                    <td><?= $b['n'] > 0 ? ('₹' . number_format($b['sum_res'] / $b['n'])) : '—' ?></td>
                                    <td><?= $margin !== null ? ('<span class="adm-badge success">' . $margin . '%</span>') : '—' ?></td>
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