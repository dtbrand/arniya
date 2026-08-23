<?php
/**
 * retail.php - DT Brand's Admin B2C Retail Pricing & Markups
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "B2C Retail Pricing & Markups";
$active_nav = "pricing";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B2C Retail Pricing & Markups - DT Brand's Admin</title>
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
                        <span>B2C Retail Pricing & Markups</span>
                        <span class="adm-badge gold">Retail MRP</span>
                    </h1>
                    <p class="adm-page-subtitle">Configure strike-through pricing, retail markups, and festival discounts.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/pricing/" class="adm-btn-secondary">← Back to Pricing Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>🏷️ Retail Price Markups</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('Retail Pricing Updated!')">Save Prices</button>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Cost Price</th>
                            <th>Retail MRP</th>
                            <th>Gross Margin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Silk Sarees</td>
                            <td>₹2,200</td>
                            <td><strong>₹4,490</strong></td>
                            <td><span class="adm-badge success">51.0% Margin</span></td>
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
