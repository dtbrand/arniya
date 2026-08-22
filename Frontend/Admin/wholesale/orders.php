<?php
/**
 * orders.php — DT Brand's & Jai Hanuman Tex
 * Wholesale Sourcing Orders & Bulk POs Directory (100% Dynamic)
 */
$page_title = "Wholesale Orders";
$active_nav = "wholesalers";
$active_subnav = "orders";

require_once __DIR__ . '/components/wholesale-data.php';

$whl_id = isset($_GET['id']) ? $_GET['id'] : null;
$wholesale = $whl_id ? getWholesalePartner($whl_id) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $wholesale ? htmlspecialchars($wholesale['id'] . ' Orders - ' . $wholesale['name']) : 'Wholesale Orders'; ?> - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/wholesale/assets/css/wholesale.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 18px 20px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-wholesale-container">
                <!-- Top Breadcrumb & Return Nav -->
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <a href="/Frontend/Admin/wholesale/index.php" class="dt-btn dt-btn-pale dt-btn-sm">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            <span>All Wholesalers</span>
                        </a>
                        <?php if ($wholesale): ?>
                            <a href="/Frontend/Admin/wholesale/view.php?id=<?php echo $wholesale['id']; ?>" class="dt-btn dt-btn-pale dt-btn-sm">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span>Back to <?php echo htmlspecialchars($wholesale['id']); ?> Dossier</span>
                            </a>
                        <?php endif; ?>
                    </div>
                    <?php if ($wholesale): ?>
                        <div style="display:flex; gap:8px;">
                            <a href="/Frontend/Admin/wholesale/edit.php?id=<?php echo $wholesale['id']; ?>" class="dt-btn dt-btn-pale dt-btn-sm">
                                <span>Edit Profile</span>
                            </a>
                            <a href="/Frontend/Admin/wholesale/credit.php?id=<?php echo $wholesale['id']; ?>" class="dt-btn dt-btn-gold dt-btn-sm">
                                <span>Credit Hub</span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="dt-cust-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:4px;">
                    <div>
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0; display:flex; align-items:center; gap:8px;">
                            <span><?php echo $wholesale ? htmlspecialchars($wholesale['name']) . ' — Orders & Dispatches' : 'Wholesale Purchase Orders & Dispatches'; ?></span>
                            <?php if ($wholesale): ?>
                                <span class="dt-status-pill-clean <?php echo $wholesale['tier_badge']; ?>"><?php echo $wholesale['tier_short']; ?></span>
                            <?php else: ?>
                                <span class="dt-cust-badge gold" style="font-size:0.72rem; padding:3px 8px; border-radius:6px; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; font-weight:800;">412 Orders This Month</span>
                            <?php endif; ?>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">
                            <?php echo $wholesale ? 'Commercial purchase orders, revolving credit debits, and fulfillment tracking for ' . htmlspecialchars($wholesale['legal_name']) . '.' : 'Bulk saree purchase orders, revolving credit debits, and warehouse dispatch fulfillment tracking across all B2B accounts.'; ?>
                        </p>
                    </div>
                </div>

                <?php include __DIR__ . '/components/wholesale-orders.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/wholesale/assets/js/wholesale.js?v=<?php echo time(); ?>"></script>
</body>
</html>
