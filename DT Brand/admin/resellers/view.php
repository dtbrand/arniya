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
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/resellers/assets/css/resellers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/resellers/assets/css/reseller-view.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/resellers/assets/css/reseller-business.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/resellers/assets/css/reseller-documents.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/resellers/assets/css/reseller-pricing.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/resellers/assets/css/reseller-credit.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/resellers/assets/css/reseller-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-customers-container" style="display:flex; flex-direction:column; gap:14px;">
                <!-- Navigation Breadcrumb & Actions -->
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <a href="/admin/resellers/index.php" class="dt-btn dt-btn-pale">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Back to Resellers Directory</span>
                    </a>
                    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <a href="https://wa.me/919825144321?text=Namaste%20Rameshwar%20ji,%20greetings%20from%20DT%20Brand's%20Wholesale%20Hub!" target="_blank" class="dt-btn dt-btn-emerald">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="#FFFFFF"><path d="M17.472 14.382c-.301-.15-1.781-.878-2.057-.978-.276-.1-.476-.15-.676.15-.2.3-.776.978-.952 1.178-.175.2-.351.225-.652.075-.301-.15-1.27-.468-2.42-1.493-.895-.798-1.5-1.784-1.676-2.084-.175-.3-.019-.462.132-.612.136-.135.301-.35.452-.525.15-.175.2-.3.301-.5.101-.2.05-.375-.025-.525-.075-.15-.676-1.63-.927-2.234-.244-.588-.492-.508-.676-.518l-.576-.01c-.2 0-.526.075-.802.375-.276.3-1.053 1.029-1.053 2.508s1.078 2.906 1.228 3.106c.15.2 2.122 3.24 5.141 4.544.718.31 1.279.496 1.716.635.722.23 1.378.197 1.897.12.578-.087 1.781-.728 2.032-1.431.25-.703.25-1.305.175-1.43-.075-.126-.276-.201-.577-.351zM12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.978-1.406C8.423 21.498 10.155 22 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"></path></svg>
                            <span>WhatsApp Connect</span>
                        </a>
                        <a href="/admin/resellers/edit.php?id=<?php echo $reseller['id']; ?>" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            <span>Edit Reseller</span>
                        </a>
                        <button type="button" class="dt-btn dt-btn-gold" onclick="openCreditAdjustmentModal('<?php echo $reseller['id']; ?>', <?php echo $reseller['credit_limit']; ?>, <?php echo $reseller['credit']; ?>)">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.4"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                            <span>Adjust Credit</span>
                        </button>
                    </div>
                </div>

                <!-- 1. Luxury Gold Hero Glass Banner -->
                <?php include_once __DIR__ . '/components/reseller-profile.php'; ?>

                <!-- 2. Profile Tabs (100% Real Vector SVG Icons Standard) -->
                <div class="dt-reseller-nav-tabs">
                    <button type="button" class="dt-reseller-tab-link active" onclick="switchResellerTab('business', this)">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                        <span>Business &amp; GST</span>
                    </button>
                    
                    <button type="button" class="dt-reseller-tab-link" onclick="switchResellerTab('kyc', this)">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        <span>KYC &amp; Verification</span>
                        <span class="dt-cust-pill-count" style="background:#DCFCE7; color:#15803D;">✓</span>
                    </button>

                    <button type="button" class="dt-reseller-tab-link" onclick="switchResellerTab('orders', this)">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        <span>Orders (142)</span>
                    </button>

                    <button type="button" class="dt-reseller-tab-link" onclick="switchResellerTab('pricing', this)">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <span>Tier &amp; Margins</span>
                    </button>

                    <button type="button" class="dt-reseller-tab-link" onclick="switchResellerTab('credit', this)">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        <span>Credit Wallet</span>
                    </button>

                    <button type="button" class="dt-reseller-tab-link" onclick="switchResellerTab('commissions', this)">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                        <span>Commissions &amp; Payouts</span>
                    </button>

                    <button type="button" class="dt-reseller-tab-link" onclick="switchResellerTab('activity', this)">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <span>Activity Log</span>
                    </button>

                    <button type="button" class="dt-reseller-tab-link" onclick="switchResellerTab('notes', this)">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        <span>Notes &amp; Tags</span>
                    </button>
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

<!-- Credit Adjustment Modal -->
<?php include_once __DIR__ . '/components/reseller-status.php'; ?>

<script src="/admin/resellers/assets/js/resellers.js?v=<?php echo time(); ?>"></script>
<script src="/admin/resellers/assets/js/reseller-view.js?v=<?php echo time(); ?>"></script>
<script src="/admin/resellers/assets/js/reseller-credit.js?v=<?php echo time(); ?>"></script>
<script src="/admin/resellers/assets/js/reseller-status.js?v=<?php echo time(); ?>"></script>

</body>
</html>
