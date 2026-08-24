<?php
/**
 * templates.php - DT Brand's Admin Notification Message Templates
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Notification Message Templates";
$active_nav = "notifications";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Message Templates - DT Brand's Admin</title>
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
                        <span>Notification Message Templates</span>
                        <span class="adm-badge gold">14 Templates</span>
                    </h1>
                    <p class="adm-page-subtitle">Manage pre-approved WhatsApp Cloud API and SMS notification templates.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/notifications/" class="adm-btn-secondary">← Back to Notifications Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800;">Message Templates</h3></div>
                <button class="adm-btn-primary" onclick="window.showToast('Template Builder...')">+ New Template</button>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Template Name</th>
                            <th>Channel</th>
                            <th>Trigger</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>order_dispatch_v2</code></td>
                            <td>WhatsApp</td>
                            <td>Order Dispatched with AWB</td>
                            <td><span class="adm-badge success">Meta Approved</span></td>
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
