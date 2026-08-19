<?php
/**
 * pending.php - DT Brand's Admin Pending Dispatch Orders
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Pending Dispatch Orders";
$active_nav = "orders";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Dispatch Orders - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
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
                        <span>Pending Dispatch Orders</span>
                        <span class="adm-badge gold">18 Pending</span>
                    </h1>
                    <p class="adm-page-subtitle">Orders requiring picking, inspection, packaging, and courier manifest attachment.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/orders/" class="adm-btn-secondary">← Back to Orders Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800;">Pending Dispatch Queue</h3></div>
                <button class="adm-btn-primary" onclick="window.showToast('Generating Picklists for Surat Warehouse...')">📄 Generate Picklists</button>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Buyer & City</th>
                            <th>Items</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>#ORD-9843</strong><br><small style="color:#7A7266;">15 mins ago</small></td>
                            <td>Ananya Boutique (Jaipur, RJ)</td>
                            <td>Bridal Lehenga (Qty: 2)</td>
                            <td><strong>₹23,000</strong></td>
                            <td><span class="adm-badge success">Paid (Bank Wire)</span></td>
                            <td><button class="adm-btn-primary adm-btn-sm" onclick="window.showToast('Order moved to Packing!')">📦 Pack Order</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
