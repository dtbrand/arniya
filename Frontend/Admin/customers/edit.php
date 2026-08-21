<?php
/**
 * edit.php — Edit Customer Profile & Preferences
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
$customer_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : 'CUST-1042';
$page_title = "Edit Customer #" . $customer_id;
$active_nav = "customers";
$active_subnav = "edit";
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
                            <span>Edit Customer Profile</span>
                            <span class="dt-cust-badge gold">#<?php echo $customer_id; ?></span>
                        </h1>
                        <p class="dt-cust-subtitle">Update contact details, account tier, and assigned tags. Password management is handled via secure reset links.</p>
                    </div>
                    <div class="dt-cust-actions">
                        <a href="/Frontend/Admin/customers/view.php?id=<?php echo $customer_id; ?>" class="dt-btn dt-btn-pale">← View Dossier</a>
                    </div>
                </div>

                <!-- Edit Customer Form Card -->
                <div class="dt-card" style="max-width:800px; margin:0 auto; width:100%;">
                    <form onsubmit="event.preventDefault(); window.showToast('✓ Customer Profile Saved!'); setTimeout(() => window.location.href='/Frontend/Admin/customers/view.php?id=<?php echo $customer_id; ?>', 1000);" style="display:flex; flex-direction:column; gap:14px;">
                        
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                            <div>
                                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">First Name</label>
                                <input type="text" class="dt-cust-search-input" style="padding-left:12px;" value="Pooja" required>
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Last Name</label>
                                <input type="text" class="dt-cust-search-input" style="padding-left:12px;" value="Sharma">
                            </div>
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                            <div>
                                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Mobile Phone</label>
                                <input type="tel" class="dt-cust-search-input" style="padding-left:12px;" value="+91 98110 29381" required>
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Email Address</label>
                                <input type="email" class="dt-cust-search-input" style="padding-left:12px;" value="pooja.sharma92@gmail.com">
                            </div>
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                            <div>
                                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Account Status</label>
                                <select class="dt-cust-select" style="width:100%;">
                                    <option value="active" selected>Active Verified</option>
                                    <option value="inactive">Inactive / Dormant</option>
                                    <option value="suspended">Suspended</option>
                                </select>
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Customer Tier</label>
                                <select class="dt-cust-select" style="width:100%;">
                                    <option value="vip" selected>VIP High-Value</option>
                                    <option value="regular">Regular Shopper</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Security &amp; Password</label>
                            <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:10px 12px; display:flex; align-items:center; justify-content:space-between;">
                                <span style="font-size:0.72rem; color:#78716C;">Passwords are securely encrypted. Send reset link directly to customer.</span>
                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('✓ Password reset link sent to pooja.sharma92@gmail.com')">Dispatch Reset Link</button>
                            </div>
                        </div>

                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:8px; border-top:1.5px solid #F1ECE1; padding-top:14px;">
                            <a href="/Frontend/Admin/customers/view.php?id=<?php echo $customer_id; ?>" class="dt-btn dt-btn-pale">Cancel</a>
                            <button type="submit" class="dt-btn dt-btn-gold">Save Changes</button>
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
