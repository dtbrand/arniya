<?php
/**
 * pending.php - DT Brand's Admin Reseller Approval Queue
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Reseller Approval Queue";
$active_nav = "resellers";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseller Approval Queue - DT Brand's Admin</title>
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
                        <span>Reseller Approval Queue</span>
                        <span class="adm-badge gold">8 Pending</span>
                    </h1>
                    <p class="adm-page-subtitle">Review social boutique seller signups and store identity verification.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/resellers/" class="adm-btn-secondary">← Back to Resellers Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800;">Pending Reseller Applications</h3></div>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Reseller Name</th>
                            <th>Boutique Brand</th>
                            <th>Instagram / WhatsApp</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Priya Sharma</td>
                            <td>Priya Saree Collections</td>
                            <td>@priya_sarees_jaipur</td>
                            <td><button class="adm-btn-primary adm-btn-sm" onclick="window.showToast('Reseller Approved!')">✓ Approve Reseller</button></td>
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
