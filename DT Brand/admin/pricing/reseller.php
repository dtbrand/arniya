<?php
/**
 * reseller.php - DT Brand's Admin Reseller Margin Allocations
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Reseller Margin Allocations";
$active_nav = "pricing";
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
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
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
                        <span>Reseller Margin Allocations</span>
                        <span class="adm-badge gold">Reseller Tiers</span>
                    </h1>
                    <p class="adm-page-subtitle">Define base prices for boutique social sellers and commission structures.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/DT%20Brand/admin/pricing/" class="adm-btn-secondary">← Back to Pricing Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>🤝 Reseller Pricing Schedule</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('Reseller Margins Saved!')">Save Margins</button>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Reseller Base Price</th>
                            <th>Suggested Retail</th>
                            <th>Reseller Margin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Kanjivaram Silks</td>
                            <td>₹3,450</td>
                            <td>₹4,490</td>
                            <td><strong style="color:#15803D;">₹1,040 / pc</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/DT%20Brand/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
