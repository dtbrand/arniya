<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * edit.php — DT Brand's & Jai Hanuman Tex
 * Reseller Profile Editor & New Reseller Onboarding
 */
$is_new = (isset($_GET['action']) && $_GET['action'] === 'new') || !isset($_GET['id']);
$reseller_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : 'RES-1048';
$page_title = $is_new ? "Add New Reseller Partner" : "Edit Reseller Profile - " . $reseller_id;
$active_nav = "resellers";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - DT Brand's Admin</title>
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
                        <h1 style="font-size:1.35rem; font-weight:900; color:#181512; margin:0;">
                            <?php echo $is_new ? "Onboard New Reseller Partner" : "Edit Reseller Account (" . $reseller_id . ")"; ?>
                        </h1>
                        <p style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">
                            Configure business profile, contact details, assigned margin tier, and credit limit.
                        </p>
                    </div>
                    <a href="/admin/resellers/index.php" class="dt-btn dt-btn-pale">← Back to Resellers Directory</a>
                </div>

                <div class="dt-card" style="padding:22px;">
                    <form onsubmit="saveResellerProfile(event)" id="dtResellerProfileForm" data-editing="true">
                        <input type="hidden" name="action" value="<?php echo $is_new ? 'create' : 'update'; ?>">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($reseller_id); ?>">
                        <input type="hidden" name="type" value="reseller">

                        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:16px; margin-bottom:20px;">
                            <!-- Business Name -->
                            <div>
                                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Business / Trade Name *</label>
                                <input type="text" name="name" class="dt-input-field" value="<?php echo $is_new ? '' : 'Shree Krishna Sarees & Boutique'; ?>" placeholder="e.g. Shree Krishna Sarees" required style="width:100%; height:38px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.82rem; font-weight:700; box-sizing:border-box;">
                            </div>

                            <!-- Contact Person -->
                            <div>
                                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Contact Person / Proprietor *</label>
                                <input type="text" name="contact" class="dt-input-field" value="<?php echo $is_new ? '' : 'Rameshwar Vyas'; ?>" placeholder="e.g. Rameshwar Vyas" required style="width:100%; height:38px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.82rem; font-weight:700; box-sizing:border-box;">
                            </div>

                            <!-- Phone -->
                            <div>
                                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">WhatsApp / Phone Number *</label>
                                <input type="tel" name="phone" class="dt-input-field" value="<?php echo $is_new ? '' : '+91 70463 63528'; ?>" placeholder="+91 70463 63528" required style="width:100%; height:38px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.82rem; font-weight:700; box-sizing:border-box;">
                            </div>

                            <!-- Email -->
                            <div>
                                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Business Email *</label>
                                <input type="email" name="email" class="dt-input-field" value="<?php echo $is_new ? '' : 'krishna.boutique@gmail.com'; ?>" placeholder="name@business.com" required style="width:100%; height:38px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.82rem; font-weight:700; box-sizing:border-box;">
                            </div>

                            <!-- GSTIN -->
                            <div>
                                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">GSTIN Tax Number</label>
                                <input type="text" name="gstin" class="dt-input-field" value="<?php echo $is_new ? '' : '24AAAPL1234F1Z8'; ?>" placeholder="24AAAPL1234F1Z8" style="width:100%; height:38px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.82rem; font-family:monospace; box-sizing:border-box;">
                            </div>

                            <!-- Assigned Tier -->
                            <div>
                                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Reseller Margin Tier *</label>
                                <select name="tier" class="dt-reseller-select" style="width:100%; height:38px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.82rem; font-weight:700; box-sizing:border-box;">
                                    <option value="Platinum" <?php echo !$is_new ? 'selected' : ''; ?>>Platinum Elite (30% Margin • ₹1,50,000 Credit)</option>
                                    <option value="Gold">Gold Partner (22% Margin • ₹1,00,000 Credit)</option>
                                    <option value="Silver">Silver Growth (15% Margin • ₹50,000 Credit)</option>
                                    <option value="Bronze">Bronze Starter (10% Margin • Cash Only)</option>
                                </select>
                            </div>

                            <!-- City & State -->
                            <div>
                                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">City &amp; State *</label>
                                <input type="text" name="city" class="dt-input-field" value="<?php echo $is_new ? '' : 'Surat, Gujarat'; ?>" placeholder="Surat, Gujarat" required style="width:100%; height:38px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.82rem; box-sizing:border-box;">
                            </div>

                            <!-- Account Status -->
                            <div>
                                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Account Status *</label>
                                <select name="status" class="dt-reseller-select" style="width:100%; height:38px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.82rem; font-weight:700; box-sizing:border-box;">
                                    <option value="Active" selected>Active Partner</option>
                                    <option value="Pending">Pending Review</option>
                                    <option value="Suspended">Suspended</option>
                                </select>
                            </div>
                        </div>

                        <!-- Form Action Buttons -->
                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:10px; border-top:1.5px solid #F1ECE1; padding-top:16px;">
                            <a href="/admin/resellers/index.php" class="dt-btn dt-btn-pale">Cancel</a>
                            <button type="submit" class="dt-btn dt-btn-gold" style="height:40px; padding:0 22px;">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#111827" stroke-width="2.8"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                                <span>Save Reseller Profile</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/resellers/assets/js/resellers.js?v=<?php echo time(); ?>"></script>
<script src="/admin/resellers/assets/js/reseller-view.js?v=<?php echo time(); ?>"></script>
<script>
function saveResellerProfile(e) {
    e.preventDefault();
    const form = document.getElementById('dtResellerProfileForm');
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
                window.location.href = '/admin/resellers/index.php';
            }, 600);
        } else {
            alert('Error: ' + (data.message || 'Could not save reseller account.'));
        }
    })
    .catch(err => {
        alert('Network error while saving reseller account.');
    });
}
</script>
</body>
</html>
