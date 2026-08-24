<?php
/**
 * campaigns.php - DT Brand's Admin Campaign Management Hub
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Campaign Management Hub";
$active_nav = "marketing";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campaign Management Hub - DT Brand's Admin</title>
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
                        <span>Campaign Management Hub</span>
                        <span class="adm-badge gold">Festive 2026</span>
                    </h1>
                    <p class="adm-page-subtitle">Coordinate multi-channel campaigns across WhatsApp, Instagram, and SMS.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/marketing/" class="adm-btn-secondary">← Back to Marketing Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800;">Active Marketing Campaigns</h3></div>
                <button class="adm-btn-primary" onclick="window.showToast('Campaign Launched!')">+ New Campaign</button>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Campaign Name</th>
                            <th>Channels</th>
                            <th>Reach</th>
                            <th>Conversions</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Surat Silk Mela 2026</strong></td>
                            <td>WhatsApp + Social</td>
                            <td><strong>4,820 buyers</strong></td>
                            <td><strong>₹6.84L GMV</strong></td>
                            <td><span class="adm-badge success">Live</span></td>
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
