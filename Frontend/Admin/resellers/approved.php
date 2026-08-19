<?php
/**
 * approved.php - DT Brand's Admin Approved Resellers Network
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Approved Resellers Network";
$active_nav = "resellers";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Resellers Network - DT Brand's Admin</title>
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
                        <span>Approved Resellers Network</span>
                        <span class="adm-badge gold">348 Active</span>
                    </h1>
                    <p class="adm-page-subtitle">Directory of active boutique sellers, earned commissions, and total volume.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/resellers/" class="adm-btn-secondary">← Back to Resellers Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800;">Active Reseller Network</h3></div>
                <button class="adm-btn-secondary" onclick="window.showToast('Exporting Resellers CSV...')">📥 Export CSV</button>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Reseller</th>
                            <th>Store</th>
                            <th>Total Sold</th>
                            <th>Total Commission</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Ananya Roy</td>
                            <td>Ananya Boutique (Jaipur)</td>
                            <td><strong>142 pcs</strong></td>
                            <td><strong style="color:#15803D;">₹42,600</strong></td>
                            <td><button class="adm-action-btn wa" onclick="window.showToast('Opening WhatsApp...')">💬</button></td>
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
