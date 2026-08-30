<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * wholesale.php - DT Brand's Admin B2B Wholesale MOQ Pricing
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "B2B Wholesale MOQ Pricing";
$active_nav = "pricing";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B2B Wholesale MOQ Pricing - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
                        <span>B2B Wholesale MOQ Pricing</span>
                        <span class="adm-badge gold">Wholesale Tiers</span>
                    </h1>
                    <p class="adm-page-subtitle">Manage tiered pricing schedules based on minimum order quantities (8, 24, 50 pcs).</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/pricing/" class="adm-btn-secondary">← Back to Pricing Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>🏢 Wholesale MOQ Tiers</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('Wholesale Tiers Saved!')">Save Tiers</button>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>MOQ 8-23 pcs</th>
                            <th>MOQ 24-49 pcs</th>
                            <th>MOQ 50+ pcs</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Kanjivaram Silks</td>
                            <td><strong style="color:#8A681F;">₹2,850/pc</strong></td>
                            <td><strong style="color:#8A681F;">₹2,750/pc</strong></td>
                            <td><strong style="color:#15803D;">₹2,650/pc</strong></td>
                        </tr>
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
