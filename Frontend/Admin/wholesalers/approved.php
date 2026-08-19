<?php
/**
 * approved.php - DT Brand's Admin Active VIP Wholesalers Roster
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Active VIP Wholesalers Roster";
$active_nav = "wholesalers";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active VIP Wholesalers Roster - DT Brand's Admin</title>
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
                        <span>Active VIP Wholesalers Roster</span>
                        <span class="adm-badge gold">46 Active</span>
                    </h1>
                    <p class="adm-page-subtitle">Master directory of verified B2B textile buyers with customized trade terms.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/wholesalers/" class="adm-btn-secondary">← Back to Wholesalers Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800;">Approved Wholesaler Roster</h3></div>
                <button class="adm-btn-secondary" onclick="window.showToast('Exporting Wholesalers Directory CSV...')">📥 Export CSV</button>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Business Name</th>
                            <th>Contact</th>
                            <th>GSTIN</th>
                            <th>Trade Tier</th>
                            <th>Total B2B Spend</th>
                            <th>Direct WA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Vardhman Textiles</strong></td>
                            <td>Rajesh Kumar (Surat)</td>
                            <td><code>24AAACV1234F1Z5</code></td>
                            <td><span class="adm-badge gold">Tier 1 VIP</span></td>
                            <td><strong>₹8,45,000</strong></td>
                            <td><button class="adm-action-btn wa" onclick="window.showToast('WhatsApp Chat Opened!')">💬</button></td>
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
