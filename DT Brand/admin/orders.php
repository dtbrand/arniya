<?php
/**
 * DT Brand/admin/orders.php — Orders & Fulfillment Desk
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/OrderManager.php';

use DTBrand\OrderManager;
use DTBrand\Database;

$orders = OrderManager::getAll(['limit' => 50]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Orders Management &bull; DT Brand's Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="/DT Brand/assets/css/main.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/DT Brand/assets/css/header.css?v=<?= time() ?>">

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
        .dt-adm-nav-link { color: #CBD5E1; font-size: 0.82rem; font-weight: 600; padding: 6px 12px; border-radius: 6px; text-decoration: none; }
        .dt-adm-nav-link:hover, .dt-adm-nav-link.active { background: rgba(212, 175, 55, 0.2); color: #FFE699; }
        .dt-adm-container { max-width: 1440px; margin: 24px auto; padding: 0 20px; }
        .dt-adm-table-card { background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 10px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .dt-adm-table { width: 100%; border-collapse: collapse; font-size: 0.84rem; min-width: 780px; }
        .dt-adm-table th { background: #F8FAFC; padding: 10px 14px; text-align: left; font-weight: 700; color: #475569; border-bottom: 1.5px solid #E2E8F0; }
        .dt-adm-table td { padding: 10px 14px; border-bottom: 1px solid #F1F5F9; vertical-align: middle; }
    </style>
</head>
<body>

    <header class="dt-adm-header">
        <div style="display:flex; align-items:center; gap:12px;">
            <a href="/DT Brand/admin/"><img src="/Shared/Asset/images/logo.png" onerror="this.src='/Frontend/Shop/Asset/images/logo.png';" alt="DT Brand's" style="height:28px;" /></a>
            <h1 style="font-size:1.15rem; font-weight:800; color:#FFFFFF;">Orders Management</h1>
        </div>
        <nav style="display:flex; align-items:center; gap:8px;">
            <a href="/DT Brand/admin/" class="dt-adm-nav-link">Dashboard</a>
            <a href="/DT Brand/admin/products.php" class="dt-adm-nav-link">Products</a>
            <a href="/DT Brand/admin/categories.php" class="dt-adm-nav-link">Categories</a>
            <a href="/DT Brand/admin/orders.php" class="dt-adm-nav-link active">Orders (<?= count($orders) ?>)</a>
        </nav>
    </header>

    <main class="dt-adm-container">
        
        <div class="dt-adm-table-card">
            <h3 style="font-size:1.05rem; font-weight:800; color:#0F172A; margin-bottom:16px;">Customer & Wholesale Orders</h3>
            <div style="overflow-x:auto;">
                <table class="dt-adm-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer / Contact</th>
                            <th>Channel</th>
                            <th>Items</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Fulfillment</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($orders)): ?>
                        <tr><td colspan="8" style="text-align:center; padding:20px; color:#64748B;">No orders recorded yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($orders as $o): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($o['order_number']) ?></strong></td>
                                <td>
                                    <div style="font-weight:700; color:#0F172A;"><?= htmlspecialchars($o['customer_name']) ?></div>
                                    <div style="font-size:0.72rem; color:#64748B;"><?= htmlspecialchars($o['customer_phone']) ?></div>
                                </td>
                                <td>
                                    <span class="dt-trust-tag"><?= strtoupper($o['channel']) ?></span>
                                </td>
                                <td><?= count($o['items']) ?> Items</td>
                                <td><strong style="color:#8A681F;">₹<?= number_format($o['total_amount']) ?></strong></td>
                                <td>
                                    <span class="dt-trust-tag" style="background:#DCFCE7; color:#15803D;"><?= ucfirst($o['payment_status']) ?> (<?= strtoupper($o['payment_method']) ?>)</span>
                                </td>
                                <td>
                                    <span class="dt-trust-tag" style="background:#EFF6FF; color:#1D4ED8;"><?= ucfirst($o['fulfillment_status']) ?></span>
                                </td>
                                <td><?= date('d M Y, h:i A', strtotime($o['created_at'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>
</html>
