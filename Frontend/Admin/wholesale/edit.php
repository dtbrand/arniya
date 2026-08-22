<?php
/**
 * edit.php — DT Brand's & Jai Hanuman Tex
 * Wholesale Account & Commercial Terms Editor
 */
$page_title = "Edit Wholesale Account";
$active_nav = "wholesalers";
$active_subnav = "all";

$whl_id = isset($_GET['id']) ? $_GET['id'] : 'new';
$is_new = ($whl_id === 'new');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $is_new ? 'Add Wholesale Account' : 'Edit ' . $whl_id; ?> - DT Brand's Admin</title>
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
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
                    <div>
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0;">
                            <?php echo $is_new ? '+ Add New Wholesale Account' : 'Edit Wholesale Profile (' . $whl_id . ')'; ?>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Configure corporate legal identity, credit terms, and assigned wholesale margin tiers.</p>
                    </div>
                    <a href="/Frontend/Admin/wholesale/index.php" class="dt-btn dt-btn-pale dt-btn-sm">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Cancel &amp; Return</span>
                    </a>
                </div>

                <div class="dt-card" style="padding:22px;">
                    <form onsubmit="event.preventDefault(); window.showToast('✅ Wholesale profile saved successfully!'); setTimeout(()=>window.location.href='/Frontend/Admin/wholesale/index.php', 600);" style="display:flex; flex-direction:column; gap:18px;">
                        
                        <!-- 1. Identity -->
                        <div style="border-bottom:1.5px solid #F1ECE1; padding-bottom:16px;">
                            <label style="font-size:0.75rem; font-weight:800; color:#8A681F; text-transform:uppercase; display:block; margin-bottom:10px;">1. Business Identity &amp; Registration</label>
                            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:12px;">
                                <div>
                                    <label style="font-size:0.72rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Trade / Brand Name *</label>
                                    <input type="text" class="dt-wholesale-input" value="<?php echo $is_new ? '' : 'Shree Balaji Textile Emporium'; ?>" required style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 10px; font-size:0.8rem; box-sizing:border-box;">
                                </div>
                                <div>
                                    <label style="font-size:0.72rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Legal Registered Entity Name</label>
                                    <input type="text" class="dt-wholesale-input" value="<?php echo $is_new ? '' : 'Shree Balaji Silk Mills Pvt Ltd'; ?>" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 10px; font-size:0.8rem; box-sizing:border-box;">
                                </div>
                                <div>
                                    <label style="font-size:0.72rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">GSTIN Tax Number *</label>
                                    <input type="text" class="dt-wholesale-input" value="<?php echo $is_new ? '' : '24AAAPL1234F1Z8'; ?>" required style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 10px; font-size:0.8rem; font-family:monospace; box-sizing:border-box;">
                                </div>
                            </div>
                        </div>

                        <!-- 2. Contact -->
                        <div style="border-bottom:1.5px solid #F1ECE1; padding-bottom:16px;">
                            <label style="font-size:0.75rem; font-weight:800; color:#15803D; text-transform:uppercase; display:block; margin-bottom:10px;">2. Commercial Contacts</label>
                            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:12px;">
                                <div>
                                    <label style="font-size:0.72rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Authorized Contact Person *</label>
                                    <input type="text" class="dt-wholesale-input" value="<?php echo $is_new ? '' : 'Rameshwar Agarwal'; ?>" required style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 10px; font-size:0.8rem; box-sizing:border-box;">
                                </div>
                                <div>
                                    <label style="font-size:0.72rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Primary Email *</label>
                                    <input type="email" class="dt-wholesale-input" value="<?php echo $is_new ? '' : 'balaji.textiles.surat@gmail.com'; ?>" required style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 10px; font-size:0.8rem; box-sizing:border-box;">
                                </div>
                                <div>
                                    <label style="font-size:0.72rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">WhatsApp / Phone Number *</label>
                                    <input type="text" class="dt-wholesale-input" value="<?php echo $is_new ? '' : '+91 98251 44321'; ?>" required style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 10px; font-size:0.8rem; box-sizing:border-box;">
                                </div>
                            </div>
                        </div>

                        <!-- 3. Commercial Tier & Credit -->
                        <div>
                            <label style="font-size:0.75rem; font-weight:800; color:#1D4ED8; text-transform:uppercase; display:block; margin-bottom:10px;">3. Wholesale Pricing Tier &amp; Credit Terms</label>
                            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:12px;">
                                <div>
                                    <label style="font-size:0.72rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Assigned Margin Tier</label>
                                    <select class="dt-wholesale-select" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.8rem; font-weight:700;">
                                        <option selected>Platinum Wholesale (35% Off)</option>
                                        <option>Gold Distributor (28% Off)</option>
                                        <option>Silver Bulk Partner (20% Off)</option>
                                        <option>Bronze Starter (12% Off)</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size:0.72rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Payment Terms</label>
                                    <select class="dt-wholesale-select" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.8rem; font-weight:700;">
                                        <option selected>Net 30 Days</option>
                                        <option>Net 45 Days</option>
                                        <option>Net 15 Days</option>
                                        <option>Advance 50%</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size:0.72rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Sanctioned Credit Headroom (₹)</label>
                                    <input type="number" value="<?php echo $is_new ? '200000' : '500000'; ?>" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.8rem; font-weight:800; padding:0 10px; box-sizing:border-box;">
                                </div>
                            </div>
                        </div>

                        <div style="display:flex; justify-content:flex-end; gap:8px; border-top:1.5px solid #F1ECE1; padding-top:16px;">
                            <a href="/Frontend/Admin/wholesale/index.php" class="dt-btn dt-btn-pale">Cancel</a>
                            <button type="submit" class="dt-btn dt-btn-gold" style="height:38px; padding:0 20px;">
                                <span>Save Wholesale Profile</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/wholesale/assets/js/wholesale.js?v=<?php echo time(); ?>"></script>
</body>
</html>
