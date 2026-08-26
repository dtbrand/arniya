<?php
/**
 * index.php - DT Brand's Admin Pricing Module
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/ProductCatalog.php';
require_once __DIR__ . '/../../src/PricingCalculator.php';
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\PricingCalculator;
use DTBrand\Database;

$page_title = "Multi-Tier Price & Margin Matrix";
$active_nav = "pricing";

$categories = ProductCatalog::getCategoriesWithDetails();
$allProducts = ProductCatalog::getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Tier Price &amp; Margin Matrix - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Multi-Tier Price &amp; Margin Matrix</span>
                        <span class="adm-badge gold"><?= count($categories) ?> Active Categories</span>
                    </h1>
                    <p class="adm-page-subtitle">Define customized wholesale MOQ pricing, reseller margins, and bulk tier configurations directly connected to product catalogs.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Wholesale Discount</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">35% - 45%</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">On MOQs of 8-24 pcs</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Reseller Margin Pool</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">12% - 18%</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Earned Per Piece</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Active Categories</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= count($categories) ?> Lines</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Live Database Taxonomies</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Bulk Lot Discount</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">Extra 5% - 8%</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Orders &gt; 50 pcs</span>
                    </div>
                </div>
            </div>

            <!-- Module Specific Interactive Content -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Tier Pricing Configuration Matrix</span></h3>
                    <button class="adm-btn-primary" onclick="window.showToast('✨ Price Matrix updated &amp; synchronized!')">Update Price Matrix</button>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Category Taxonomy</th>
                                <th>Avg Retail MRP</th>
                                <th>Reseller Tier Price</th>
                                <th>Wholesale MOQ (8+ pcs)</th>
                                <th>Bulk Master Bale (30+ pcs)</th>
                                <th>Target Margin Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $cat): ?>
                                <?php
                                $cSlug = $cat['slug'] ?? '';
                                $catProducts = array_filter($allProducts, function($p) use ($cSlug) {
                                    return ($p['category'] ?? '') === $cSlug;
                                });
                                $pCount = count($catProducts);
                                $sumMrp = 0; $sumPrice = 0;
                                foreach ($catProducts as $cp) {
                                    $sumMrp += (float)($cp['mrp'] ?? 0);
                                    $sumPrice += (float)($cp['price'] ?? 0);
                                }
                                $avgMrp = $pCount > 0 ? round($sumMrp / $pCount) : 4990;
                                $avgPrice = $pCount > 0 ? round($sumPrice / $pCount) : 3490;
                                $resellerPrice = round($avgPrice * 0.88);
                                $wholesalePrice = round($avgPrice * 0.72);
                                $bulkPrice = round($avgPrice * 0.65);
                                $margin = round((($avgPrice - $wholesalePrice) / $avgPrice) * 100, 1);
                                ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($cat['name'] ?? 'Category') ?></strong><br>
                                        <small style="color:#7A7266;"><?= $cat['products_count'] ?? $pCount ?> Active SKUs</small>
                                    </td>
                                    <td>₹<?= number_format($avgMrp) ?> / pc</td>
                                    <td><strong style="color:#7E22CE;">₹<?= number_format($resellerPrice) ?> / pc</strong></td>
                                    <td><strong style="color:#8A681F;">₹<?= number_format($wholesalePrice) ?> / pc</strong></td>
                                    <td><strong style="color:#15803D;">₹<?= number_format($bulkPrice) ?> / pc</strong></td>
                                    <td><span class="adm-badge success"><?= $margin ?>% Margin</span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
