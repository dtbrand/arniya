<?php
/**
 * rates.php - DT Brand's Admin Shipping Rates & Pincode Matrix
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Shipping Rates & Pincode Matrix";
$active_nav = "shipping";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Rates & Pincode Matrix - DT Brand's Admin</title>
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
                        <span>Shipping Rates & Pincode Matrix</span>
                        <span class="adm-badge gold">Zone Rates</span>
                    </h1>
                    <p class="adm-page-subtitle">Define freight rates based on delivery zone, weight slabs, and order value.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/shipping/" class="adm-btn-secondary">← Back to Shipping Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>📦 Shipping Rate Slabs</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('Shipping Slabs Saved!')">Save Rates</button>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Zone</th>
                            <th>First 500g</th>
                            <th>Addl 500g</th>
                            <th>Free Shipping Threshold</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Zone A (Gujarat / Local)</td>
                            <td>₹40</td>
                            <td>₹20</td>
                            <td>Orders > ₹999</td>
                        </tr>
                        <tr>
                            <td>Zone B (Metro Cities)</td>
                            <td>₹60</td>
                            <td>₹30</td>
                            <td>Orders > ₹1,999</td>
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
