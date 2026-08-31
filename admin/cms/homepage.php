<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * homepage.php - DT Brand's Admin Homepage Layout & Section Manager
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Homepage Layout & Section Manager";
$active_nav = "cms";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Layout & Section Manager - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Homepage Layout & Section Manager</span>
                        <span class="adm-badge gold">Page Builder</span>
                    </h1>
                    <p class="adm-page-subtitle">Arrange featured collections, trending reels, and customer testimonials.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/cms/" class="adm-btn-secondary">← Back to Cms Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>📱 Homepage Sections Manager</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('Homepage Layout Saved!')">Save Layout</button>
            </div>
            <p>1. Hero Slider Banner (Festive Silk Mela)<br>2. Featured Categories (Pure Silk, Banarasi, Lehengas)<br>3. Wholesale B2B Banner<br>4. Trending Products Carousel</p>
        </div>
        
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
