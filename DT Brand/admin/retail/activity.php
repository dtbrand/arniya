<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * activity.php — DT Brand's & Jai Hanuman Tex
 * Retail Real-Time Customer Activity Stream
 */
$page_title = "Retail Activity Stream";
$active_nav = "retail";
$active_subnav = "activity";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retail Activity - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/retail/assets/css/retail.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 18px 20px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-retail-container">
                <div class="dt-retail-head">
                    <div>
                        <h1 class="dt-retail-title">
                            <span>Retail Activity Stream</span>
                            <span class="dt-status-pill-clean emerald">Live Feed</span>
                        </h1>
                        <p class="dt-retail-subtitle">Real-time audit log of customer shopping bag changes, checkouts, and completed orders.</p>
                    </div>
                </div>

                <?php include_once __DIR__ . '/components/retail-activity.php'; ?>
            </div>

        </main>
    </div>
</div>

<script src="/admin/retail/assets/js/retail.js?v=<?php echo time(); ?>"></script>
</body>
</html>
