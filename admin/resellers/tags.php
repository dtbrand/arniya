<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * tags.php — DT Brand's & Jai Hanuman Tex
 * Reseller Tagging & Classification Studio
 */
$page_title = "Reseller Tags Studio";
$active_nav = "resellers";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseller Tags - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/resellers/assets/css/resellers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/resellers/assets/css/reseller-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">

            <div class="dt-resellers-container">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <h1 style="font-size:1.35rem; font-weight:900; color:#181512; margin:0;">Reseller Dynamic Tagging Studio</h1>
                            <span class="dt-reseller-badge gold">Classification Engine</span>
                        </div>
                        <p style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Create and assign dynamic categorization tags to organize resellers across boutique profiles.</p>
                    </div>
                    <a href="/admin/resellers/index.php" class="dt-btn dt-btn-pale">← Back to Resellers Directory</a>
                </div>

                <?php include_once __DIR__ . '/components/reseller-tags.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/resellers/assets/js/resellers.js?v=<?php echo time(); ?>"></script>
</body>
</html>
