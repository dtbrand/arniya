<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * leads.php - DT Brand's Admin WhatsApp Inquiries & CRM Leads Hub
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "WhatsApp Inquiries & CRM Leads Hub";
$active_nav = "whatsapp";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Inquiries & CRM Leads Hub - DT Brand's Admin</title>
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
                        <span>WhatsApp Inquiries & CRM Leads Hub</span>
                        <span class="adm-badge gold">842 Leads</span>
                    </h1>
                    <p class="adm-page-subtitle">Manage incoming customer WhatsApp chats, inquiries, and conversion statuses.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/whatsapp/" class="adm-btn-secondary">← Back to Whatsapp Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800;">Incoming Leads Hub</h3></div>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Contact</th>
                            <th>Inquiry Topic</th>
                            <th>Channel</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Rajesh Kumar (+91 98220 19283)</td>
                            <td>50 pcs Kanjivaram Silk lot pricing</td>
                            <td><span class="adm-badge gold">Wholesale B2B</span></td>
                            <td><button class="adm-action-btn wa" onclick="window.showToast('Opening Chat...')">💬</button></td>
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
