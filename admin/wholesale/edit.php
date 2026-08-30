<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * edit.php — DT Brand's & Jai Hanuman Tex
 * Wholesale Account & Commercial Terms Editor (100% Dynamic)
 */
$page_title = "Edit Wholesale Account";
$active_nav = "wholesalers";
$active_subnav = "all";

require_once __DIR__ . '/components/wholesale-data.php';

$whl_id = isset($_GET['id']) ? $_GET['id'] : 'new';
$is_new = ($whl_id === 'new');
$partner = $is_new ? [
    'id' => 'WHL-NEW',
    'name' => '',
    'legal_name' => '',
    'gstin' => '',
    'contact' => '',
    'email' => '',
    'phone' => '',
    'tier_raw' => 'gold distributor',
    'payment_terms' => 'Net 30 Days',
    'sanctioned_limit' => 200000
] : getWholesalePartner($whl_id);
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
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/wholesale/assets/css/wholesale.css?v=<?php echo time(); ?>">
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
                            <?php echo $is_new ? 'Add New Wholesale Account' : 'Edit Wholesale Profile (' . $whl_id . ')'; ?>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Configure corporate legal identity, credit terms, and assigned wholesale margin tiers.</p>
                    </div>
                    <a href="/admin/wholesale/index.php" class="dt-btn dt-btn-pale dt-btn-sm">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Cancel &amp; Return</span>
                    </a>
                </div>

                <div class="dt-card" style="padding:22px;">
                    <form id="wholesaleEditForm" onsubmit="handleWholesaleFormSubmit(event)" style="display:flex; flex-direction:column; gap:18px;">
                        <input type="hidden" name="action" value="<?php echo $is_new ? 'create' : 'update'; ?>">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($whl_id); ?>">
                        <input type="hidden" name="type" value="wholesale">
                        
                        <!-- 1. Identity -->
                        <div style="border-bottom:1.5px solid #F1ECE1; padding-bottom:16px;">
                            <label style="font-size:0.75rem; font-weight:800; color:#8A681F; text-transform:uppercase; display:block; margin-bottom:10px;">1. Business Identity &amp; Registration</label>
                            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:12px;">
                                <div>
                                    <label style="font-size:0.72rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Trade / Brand Name *</label>
                                    <input type="text" name="name" class="dt-wholesale-input" value="<?php echo htmlspecialchars($partner['name']); ?>" required style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 10px; font-size:0.8rem; box-sizing:border-box;" placeholder="e.g. Surat Silks Hub">
                                </div>
                                <div>
                                    <label style="font-size:0.72rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Legal Registered Entity Name</label>
                                    <input type="text" name="legal_name" class="dt-wholesale-input" value="<?php echo htmlspecialchars($partner['legal_name'] ?? ''); ?>" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 10px; font-size:0.8rem; box-sizing:border-box;" placeholder="e.g. Surat Silks Pvt Ltd">
                                </div>
                                <div>
                                    <label style="font-size:0.72rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">GSTIN Tax Number *</label>
                                    <input type="text" name="gstin" class="dt-wholesale-input" value="<?php echo htmlspecialchars($partner['gstin'] ?? ''); ?>" required style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 10px; font-size:0.8rem; font-family:monospace; box-sizing:border-box;" placeholder="24AAAPL1234F1Z8">
                                </div>
                            </div>
                        </div>

                        <!-- 2. Contact -->
                        <div style="border-bottom:1.5px solid #F1ECE1; padding-bottom:16px;">
                            <label style="font-size:0.75rem; font-weight:800; color:#15803D; text-transform:uppercase; display:block; margin-bottom:10px;">2. Commercial Contacts</label>
                            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:12px;">
                                <div>
                                    <label style="font-size:0.72rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Authorized Contact Person *</label>
                                    <input type="text" name="contact" class="dt-wholesale-input" value="<?php echo htmlspecialchars($partner['contact'] ?? ''); ?>" required style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 10px; font-size:0.8rem; box-sizing:border-box;">
                                </div>
                                <div>
                                    <label style="font-size:0.72rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Primary Email *</label>
                                    <input type="email" name="email" class="dt-wholesale-input" value="<?php echo htmlspecialchars($partner['email'] ?? ''); ?>" required style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 10px; font-size:0.8rem; box-sizing:border-box;">
                                </div>
                                <div>
                                    <label style="font-size:0.72rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">WhatsApp / Phone Number *</label>
                                    <input type="text" name="phone" class="dt-wholesale-input" value="<?php echo htmlspecialchars($partner['phone'] ?? ''); ?>" required style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 10px; font-size:0.8rem; box-sizing:border-box;">
                                </div>
                            </div>
                        </div>

                        <!-- 3. Commercial Tier & Credit -->
                        <div>
                            <label style="font-size:0.75rem; font-weight:800; color:#1D4ED8; text-transform:uppercase; display:block; margin-bottom:10px;">3. Wholesale Pricing Tier &amp; Credit Terms</label>
                            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:12px;">
                                <div>
                                    <label style="font-size:0.72rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Assigned Margin Tier</label>
                                    <select name="tier" class="dt-wholesale-select" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.8rem; font-weight:700;">
                                        <option <?php echo (isset($partner['tier_raw']) && $partner['tier_raw'] === 'platinum wholesale') ? 'selected' : ''; ?>>Platinum Wholesale (35% Off)</option>
                                        <option <?php echo (isset($partner['tier_raw']) && $partner['tier_raw'] === 'gold distributor') ? 'selected' : ''; ?>>Gold Distributor (28% Off)</option>
                                        <option <?php echo (isset($partner['tier_raw']) && $partner['tier_raw'] === 'silver bulk partner') ? 'selected' : ''; ?>>Silver Bulk Partner (20% Off)</option>
                                        <option <?php echo (isset($partner['tier_raw']) && $partner['tier_raw'] === 'bronze starter') ? 'selected' : ''; ?>>Bronze Starter (12% Off)</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size:0.72rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Payment Terms</label>
                                    <select name="payment_terms" class="dt-wholesale-select" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.8rem; font-weight:700;">
                                        <option <?php echo (isset($partner['payment_terms']) && strpos($partner['payment_terms'], '30') !== false) ? 'selected' : ''; ?>>Net 30 Days</option>
                                        <option <?php echo (isset($partner['payment_terms']) && strpos($partner['payment_terms'], '45') !== false) ? 'selected' : ''; ?>>Net 45 Days</option>
                                        <option <?php echo (isset($partner['payment_terms']) && strpos($partner['payment_terms'], '15') !== false) ? 'selected' : ''; ?>>Net 15 Days</option>
                                        <option <?php echo (isset($partner['payment_terms']) && strpos($partner['payment_terms'], '50') !== false) ? 'selected' : ''; ?>>Advance 50%</option>
                                        <option <?php echo (isset($partner['payment_terms']) && (strpos($partner['payment_terms'], 'Prepaid') !== false || strpos($partner['payment_terms'], 'Proforma') !== false)) ? 'selected' : ''; ?>>Prepaid / Proforma</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size:0.72rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Sanctioned Credit Limit (₹)</label>
                                    <input type="number" name="credit_limit" value="<?php echo htmlspecialchars($partner['sanctioned_limit'] ?? 200000); ?>" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.8rem; font-weight:800; padding:0 10px; box-sizing:border-box;">
                                </div>
                            </div>
                        </div>

                        <div style="display:flex; justify-content:flex-end; gap:8px; border-top:1.5px solid #F1ECE1; padding-top:16px;">
                            <a href="/admin/wholesale/index.php" class="dt-btn dt-btn-pale">Cancel</a>
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

<script src="/admin/wholesale/assets/js/wholesale.js?v=<?php echo time(); ?>"></script>
<script>
function handleWholesaleFormSubmit(e) {
    e.preventDefault();
    const form = document.getElementById('wholesaleEditForm');
    const formData = new FormData(form);

    fetch('/api/customers.php', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            if (typeof window.showToast === 'function') {
                window.showToast('✅ ' + data.message);
            }
            setTimeout(() => {
                window.location.href = '/admin/wholesale/index.php';
            }, 600);
        } else {
            alert('Error: ' + (data.message || 'Could not save wholesale account.'));
        }
    })
    .catch(err => {
        alert('Network error while saving wholesale account.');
    });
}
</script>
</body>
</html>
