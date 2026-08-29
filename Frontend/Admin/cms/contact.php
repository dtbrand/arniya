<?php
/**
 * contact.php - DT Brand's Admin Contact & Showroom Info Editor
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Contact & Showroom Info Editor";
$active_nav = "cms";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact & Showroom Info Editor - DT Brand's Admin</title>
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
                        <span>Contact & Showroom Info Editor</span>
                        <span class="adm-badge gold">CMS Page</span>
                    </h1>
                    <p class="adm-page-subtitle">Update Surat showroom address, WhatsApp customer care number, and email addresses.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/cms/" class="adm-btn-secondary">← Back to Cms Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>📍 Showroom & Contact Details</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('Contact Info Saved!')">Save Info</button>
            </div>
            <div class="adm-form-grid">
                <div class="adm-form-group">
                    <label class="adm-form-label">Showroom Address</label>
                    <input type="text" class="adm-form-input" value="Ring Road Textile Market, Surat, Gujarat - 395002">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">WhatsApp Helpline</label>
                    <input type="text" class="adm-form-input" value="+91 70463 63528">
                </div>
            </div>
        </div>
        
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
