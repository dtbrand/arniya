<?php
/**
 * view.php — DT Brand's & Jai Hanuman Tex
 * Reseller 360° Executive Profile Hub
 */
$reseller_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : 'RES-1048';
$page_title = "Reseller Profile - " . $reseller_id;
$active_nav = "resellers";

$reseller = [
    'id' => $reseller_id,
    'name' => 'Shree Krishna Sarees & Boutique',
    'contact' => 'Rameshwar Vyas',
    'email' => 'krishna.boutique@gmail.com',
    'phone' => '+91 98251 44321',
    'city' => 'Surat',
    'state' => 'Gujarat',
    'pincode' => '395002',
    'tier' => 'Platinum',
    'status' => 'Active',
    'kyc' => 'Verified',
    'orders' => 142,
    'purchase' => 845000,
    'credit' => 65000,
    'credit_limit' => 150000,
    'joined' => '2025-11-12'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $reseller['name']; ?> (<?php echo $reseller['id']; ?>) - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/resellers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/reseller-view.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/reseller-business.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/reseller-documents.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/reseller-pricing.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/reseller-credit.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/reseller-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">

            <div class="dt-resellers-container">
                <!-- Navigation Breadcrumb & Actions -->
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <a href="/Frontend/Admin/resellers/index.php" class="dt-btn dt-btn-pale">← Back to Resellers Directory</a>
                    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <a href="/Frontend/Admin/resellers/edit.php?id=<?php echo $reseller['id']; ?>" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#705114" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            <span>Edit Reseller</span>
                        </a>
                        <button type="button" class="dt-btn dt-btn-gold" onclick="openCreditAdjustmentModal('<?php echo $reseller['id']; ?>', <?php echo $reseller['credit_limit']; ?>, <?php echo $reseller['credit']; ?>)">
                            <span>Adjust Credit</span>
                        </button>
                    </div>
                </div>

                <!-- 1. Luxury Gold Hero Glass Banner -->
                <?php include_once __DIR__ . '/components/reseller-profile.php'; ?>

                <!-- 2. Profile Tabs -->
                <div class="dt-reseller-nav-tabs">
                    <button type="button" class="dt-reseller-tab-link active" onclick="switchResellerTab('business', this)">🏢 Business &amp; GST</button>
                    <button type="button" class="dt-reseller-tab-link" onclick="switchResellerTab('kyc', this)">🔒 KYC &amp; Verification</button>
                    <button type="button" class="dt-reseller-tab-link" onclick="switchResellerTab('orders', this)">🛍️ Orders (142)</button>
                    <button type="button" class="dt-reseller-tab-link" onclick="switchResellerTab('pricing', this)">★ Tier &amp; Margins</button>
                    <button type="button" class="dt-reseller-tab-link" onclick="switchResellerTab('credit', this)">💳 Credit Wallet</button>
                    <button type="button" class="dt-reseller-tab-link" onclick="switchResellerTab('commissions', this)">💰 Commissions &amp; Payouts</button>
                    <button type="button" class="dt-reseller-tab-link" onclick="switchResellerTab('activity', this)">⏱️ Activity Log</button>
                    <button type="button" class="dt-reseller-tab-link" onclick="switchResellerTab('notes', this)">📝 Notes &amp; Tags</button>
                </div>

                <!-- Tab Panes -->
                <div id="tabPane-business" class="dt-reseller-tab-pane" style="display:block;">
                    <?php include_once __DIR__ . '/components/reseller-business.php'; ?>
                </div>

                <div id="tabPane-kyc" class="dt-reseller-tab-pane" style="display:none;">
                    <div style="display:flex; flex-direction:column; gap:16px;">
                        <?php include_once __DIR__ . '/components/reseller-verification.php'; ?>
                        <?php include_once __DIR__ . '/components/reseller-documents.php'; ?>
                    </div>
                </div>

                <div id="tabPane-orders" class="dt-reseller-tab-pane" style="display:none;">
                    <?php include_once __DIR__ . '/components/reseller-orders.php'; ?>
                </div>

                <div id="tabPane-pricing" class="dt-reseller-tab-pane" style="display:none;">
                    <?php include_once __DIR__ . '/components/reseller-pricing.php'; ?>
                </div>

                <div id="tabPane-credit" class="dt-reseller-tab-pane" style="display:none;">
                    <?php include_once __DIR__ . '/components/reseller-credit.php'; ?>
                </div>

                <div id="tabPane-commissions" class="dt-reseller-tab-pane" style="display:none;">
                    <?php include_once __DIR__ . '/components/reseller-commission.php'; ?>
                </div>

                <div id="tabPane-activity" class="dt-reseller-tab-pane" style="display:none;">
                    <?php include_once __DIR__ . '/components/reseller-activity.php'; ?>
                </div>

                <div id="tabPane-notes" class="dt-reseller-tab-pane" style="display:none;">
                    <div style="display:flex; flex-direction:column; gap:16px;">
                        <?php include_once __DIR__ . '/components/reseller-notes.php'; ?>
                        <?php include_once __DIR__ . '/components/reseller-tags.php'; ?>
                    </div>
                </div>

            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<?php include_once __DIR__ . '/components/reseller-status.php'; ?>
<script src="/Frontend/Admin/resellers/assets/js/resellers.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/resellers/assets/js/reseller-view.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/resellers/assets/js/reseller-credit.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/resellers/assets/js/reseller-verification.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/resellers/assets/js/reseller-documents.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/resellers/assets/js/reseller-pricing.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/resellers/assets/js/reseller-commission.js?v=<?php echo time(); ?>"></script>

</body>
</html>
