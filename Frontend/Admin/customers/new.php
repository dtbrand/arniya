<?php
/**
 * new.php — New Customer Registrations & Add Customer Form
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
$page_title = "New Customer Registrations";
$active_nav = "customers";
$active_subnav = "new";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customer-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-customers-container">
                <div class="dt-cust-head">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title">
                            <span>Add New Customer Account</span>
                            <span class="dt-cust-badge purple">Manual Entry</span>
                        </h1>
                        <p class="dt-cust-subtitle">Create a direct retail customer account with verified phone and address details.</p>
                    </div>
                    <div class="dt-cust-actions">
                        <a href="/Frontend/Admin/customers/index.php" class="dt-btn dt-btn-pale">← Back to Directory</a>
                    </div>
                </div>

                <!-- Add Customer Form Card -->
                <div class="dt-card" style="max-width:800px; margin:0 auto; width:100%;">
                    <div class="dt-card-head" style="border-bottom:1.5px solid #F1ECE1; padding-bottom:10px;">
                        <h3 class="dt-card-title">Customer Personal &amp; Contact Information</h3>
                    </div>

                    <form onsubmit="event.preventDefault(); window.showToast('✓ Customer Account Created Successfully!'); setTimeout(() => window.location.href='/Frontend/Admin/customers/index.php', 1200);" style="display:flex; flex-direction:column; gap:14px; margin-top:10px;">
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                            <div>
                                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">First Name <span style="color:#DC2626;">*</span></label>
                                <input type="text" class="dt-cust-search-input" style="padding-left:12px;" placeholder="e.g. Radhika" required>
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Last Name</label>
                                <input type="text" class="dt-cust-search-input" style="padding-left:12px;" placeholder="e.g. Verma">
                            </div>
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                            <div>
                                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Mobile Phone Number <span style="color:#DC2626;">*</span></label>
                                <input type="tel" class="dt-cust-search-input" style="padding-left:12px;" placeholder="+91 98XXX XXXXX" required>
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Email Address</label>
                                <input type="email" class="dt-cust-search-input" style="padding-left:12px;" placeholder="radhika@example.com">
                            </div>
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                            <div>
                                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Customer Type</label>
                                <select class="dt-cust-select" style="width:100%;">
                                    <option value="retail_verified">Direct Retail Shopper</option>
                                    <option value="vip">VIP Premium Shopper</option>
                                </select>
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">City / State</label>
                                <input type="text" class="dt-cust-search-input" style="padding-left:12px;" placeholder="e.g. Surat, Gujarat">
                            </div>
                        </div>

                        <div>
                            <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Primary Shipping Address</label>
                            <textarea class="dt-cust-search-input" style="height:60px; resize:none; padding-left:12px;" placeholder="Street address, building, apartment, landmark..."></textarea>
                        </div>

                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:8px; border-top:1.5px solid #F1ECE1; padding-top:14px;">
                            <a href="/Frontend/Admin/customers/index.php" class="dt-btn dt-btn-pale">Cancel</a>
                            <button type="submit" class="dt-btn dt-btn-gold">+ Save &amp; Create Customer</button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
</body>
</html>
