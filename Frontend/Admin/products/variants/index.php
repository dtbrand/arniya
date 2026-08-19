<?php
$page_title = "Variants Matrix";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Variants Matrix — DT Brand's Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/variants.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="dt-prod-header">
                <div class="dt-prod-title-group">
                    <h1><span>Variant Matrix &amp; Stock Combination</span></h1>
                    <p>Color, Size and Fabric variation matrix across all catalogue items.</p>
                </div>
                <div class="dt-prod-actions">
                    <a href="/Frontend/Admin/products/" class="adm-btn-secondary">← Back to Products</a>
                </div>
            </div>
            <div class="adm-table-card">
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Master Product</th>
                                <th>Variant SKU</th>
                                <th>Color / Size</th>
                                <th>Retail (₹)</th>
                                <th>Wholesale (₹)</th>
                                <th>Stock</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Kanjivaram Pure Silk Saree</strong></td>
                                <td><code>KLN-SR-111-RED</code></td>
                                <td>Crimson Red / Free Size</td>
                                <td>₹4,490</td>
                                <td>₹2,850</td>
                                <td>18 units</td>
                                <td><span class="adm-badge success">In Stock</span></td>
                            </tr>
                            <tr>
                                <td><strong>Kanjivaram Pure Silk Saree</strong></td>
                                <td><code>KLN-SR-111-GRN</code></td>
                                <td>Bottle Green / Free Size</td>
                                <td>₹4,490</td>
                                <td>₹2,850</td>
                                <td>15 units</td>
                                <td><span class="adm-badge success">In Stock</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
