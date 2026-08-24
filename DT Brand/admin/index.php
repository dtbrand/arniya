<?php
/**
 * DT Brand/admin/index.php — Master Executive Admin Console
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ProductCatalog.php';
require_once __DIR__ . '/../src/OrderManager.php';
require_once __DIR__ . '/../src/CustomerManager.php';

use DTBrand\ProductCatalog;
use DTBrand\OrderManager;
use DTBrand\CustomerManager;
use DTBrand\Database;

$products = ProductCatalog::getAll();
$categories = ProductCatalog::getCategoriesWithDetails();
$orders = OrderManager::getAll(['limit' => 10]);
$customers = CustomerManager::getAll();

$totalInventoryValuation = array_reduce($products, function($sum, $p) {
    return $sum + (($p['stock_qty'] ?? 50) * ($p['wholesale_price'] ?? 1000));
}, 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Admin Executive Console &bull; DT Brand's &bull; Jai Hanuman Tex</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="/DT Brand/assets/css/main.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/DT Brand/assets/css/header.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/DT Brand/assets/css/modals.css?v=<?= time() ?>">

    <style>
        body { background: #F8FAFC; color: #1E293B; }
        .dt-adm-header {
            background: #181512;
            color: #FAF5E8;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #D4AF37;
        }
        .dt-adm-title-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .dt-adm-title-wrap h1 { font-size: 1.15rem; font-weight: 800; color: #FFFFFF; }
        .dt-adm-nav { display: flex; align-items: center; gap: 8px; }
        .dt-adm-nav-link {
            color: #CBD5E1;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .dt-adm-nav-link:hover, .dt-adm-nav-link.active {
            background: rgba(212, 175, 55, 0.2);
            color: #FFE699;
        }

        .dt-adm-container {
            max-width: 1440px;
            margin: 24px auto;
            padding: 0 20px;
        }
        .dt-kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .dt-kpi-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 18px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .dt-kpi-val { font-size: 1.6rem; font-weight: 800; color: #0F172A; }
        .dt-kpi-lbl { font-size: 0.75rem; font-weight: 600; color: #64748B; margin-top: 2px; }
        .dt-kpi-icon {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            background: #FAF5E8;
            border: 1px solid #D4AF37;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: #8A681F;
        }

        .dt-adm-table-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            margin-bottom: 24px;
        }
        .dt-adm-table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .dt-adm-table-title { font-size: 1.1rem; font-weight: 800; color: #0F172A; }
        .dt-adm-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.84rem;
            min-width: 780px;
        }
        .dt-adm-table th {
            background: #F8FAFC;
            padding: 10px 14px;
            text-align: left;
            font-weight: 700;
            color: #475569;
            border-bottom: 1.5px solid #E2E8F0;
        }
        .dt-adm-table td {
            padding: 10px 14px;
            border-bottom: 1px solid #F1F5F9;
            vertical-align: middle;
        }
    </style>
</head>
<body>

    <!-- Executive Admin Header -->
    <header class="dt-adm-header">
        <div class="dt-adm-title-wrap">
            <a href="/DT Brand/" style="text-decoration:none;">
                <img src="/Shared/Asset/images/logo.png" onerror="this.src='/Frontend/Shop/Asset/images/logo.png';" alt="DT Brand's" style="height:28px;" />
            </a>
            <h1>Executive Management Console</h1>
        </div>
        <nav class="dt-adm-nav">
            <a href="/DT Brand/admin/" class="dt-adm-nav-link active">Dashboard</a>
            <a href="/DT Brand/admin/products.php" class="dt-adm-nav-link">Products (<?= count($products) ?>)</a>
            <a href="/DT Brand/admin/categories.php" class="dt-adm-nav-link">Categories (<?= count($categories) ?>)</a>
            <a href="/DT Brand/admin/orders.php" class="dt-adm-nav-link">Orders</a>
            <a href="/DT Brand/" class="dt-btn-pale" target="_blank" style="padding:4px 10px; font-size:0.75rem;">View Live Store &rarr;</a>
        </nav>
    </header>

    <main class="dt-adm-container">
        
        <!-- 4-Card KPI Ribbon -->
        <div class="dt-kpi-grid">
            <div class="dt-kpi-card">
                <div>
                    <div class="dt-kpi-val"><?= count($products) ?></div>
                    <div class="dt-kpi-lbl">Active Mill SKUs</div>
                </div>
                <div class="dt-kpi-icon">📦</div>
            </div>
            <div class="dt-kpi-card">
                <div>
                    <div class="dt-kpi-val"><?= count($categories) ?></div>
                    <div class="dt-kpi-lbl">Active Categories</div>
                </div>
                <div class="dt-kpi-icon">🗂️</div>
            </div>
            <div class="dt-kpi-card">
                <div>
                    <div class="dt-kpi-val">₹<?= number_format($totalInventoryValuation) ?></div>
                    <div class="dt-kpi-lbl">Total Inventory Valuation</div>
                </div>
                <div class="dt-kpi-icon">₹</div>
            </div>
            <div class="dt-kpi-card">
                <div>
                    <div class="dt-kpi-val"><?= count($customers) ?></div>
                    <div class="dt-kpi-lbl">Verified Wholesale / Resellers</div>
                </div>
                <div class="dt-kpi-icon">🤝</div>
            </div>
        </div>

        <!-- Master Products Inventory Table -->
        <div class="dt-adm-table-card">
            <div class="dt-adm-table-header">
                <h3 class="dt-adm-table-title">Live Product Inventory</h3>
                <div style="display:flex; gap:8px;">
                    <a href="/DT Brand/admin/products.php" class="dt-btn-gold" style="font-size:0.78rem;">
                        <span>+ Add New Product</span>
                    </a>
                </div>
            </div>

            <div style="overflow-x:auto;">
                <table class="dt-adm-table">
                    <thead>
                        <tr>
                            <th>Product Details</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Retail Price</th>
                            <th>Wholesale Price</th>
                            <th>Reseller Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                        <tr>
                            <td>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <img src="<?= htmlspecialchars($p['image']) ?>" alt="Product" style="width:36px; height:46px; border-radius:4px; object-fit:cover;" />
                                    <div>
                                        <div style="font-weight:700; color:#0F172A;"><?= htmlspecialchars($p['name']) ?></div>
                                        <div style="font-size:0.7rem; color:#64748B;"><?= htmlspecialchars($p['fabric'] ?? 'Pure Silk') ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><code><?= htmlspecialchars($p['sku']) ?></code></td>
                            <td><?= htmlspecialchars($p['category']) ?></td>
                            <td><strong style="color:#0F172A;">₹<?= number_format($p['price']) ?></strong></td>
                            <td><strong style="color:#8A681F;">₹<?= number_format($p['wholesale_price']) ?></strong></td>
                            <td><strong style="color:#15803D;">₹<?= number_format($p['reseller_price']) ?></strong></td>
                            <td><?= $p['stock_qty'] ?? 50 ?> Pcs</td>
                            <td>
                                <span class="dt-trust-tag" style="background:#DCFCE7; color:#15803D; padding:2px 6px; font-size:0.7rem;">In Stock</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>
</html>
