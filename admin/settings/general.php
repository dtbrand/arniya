<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * general.php — General Store Settings
 * DT Brand's & Jai Hanuman Tex
 *
 * Was two readonly inputs and a Save button that only toasted. Values now
 * load from the `settings` table and Save persists through api/settings.php
 * (super-admin gated). Currency and timezone remain fixed to the store's
 * real configuration (INR / Asia/Kolkata is baked into the codebase), so the
 * editable fields are the ones the code actually honours.
 */
require_once __DIR__ . '/_shared.php';

$page_title = "General Store Settings";
$active_nav = "settings";
$dtKeys = ['store_title', 'store_tagline', 'support_phone', 'support_email', 'order_prefix'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>General Store Settings - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>General Store Settings</span>
                        <span class="adm-badge gold">Store Config</span>
                    </h1>
                    <p class="adm-page-subtitle">Store identity and customer-facing contact details.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/settings/" class="adm-btn-secondary">← Back to Settings Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>General</span></h3>
                    <?php echo dt_set_save_button(); ?>
                </div>
                <div class="adm-form-grid">
                    <div class="adm-form-group">
                        <label class="adm-form-label">Store Title</label>
                        <input type="text" class="adm-form-input" id="dtSet-store_title" value="<?= htmlspecialchars(dt_set('store_title', "DT Brand's (Jai Hanuman Tex)")) ?>">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Store Tagline</label>
                        <input type="text" class="adm-form-input" id="dtSet-store_tagline" value="<?= htmlspecialchars(dt_set('store_tagline', 'Premium Ethnic Wear, Reseller & Wholesale Hub')) ?>">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Support WhatsApp Number</label>
                        <input type="text" class="adm-form-input" id="dtSet-support_phone" value="<?= htmlspecialchars(dt_set('support_phone', '917046363528')) ?>">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Support Email</label>
                        <input type="email" class="adm-form-input" id="dtSet-support_email" value="<?= htmlspecialchars(dt_set('support_email', 'admin@jaihanumantex.in')) ?>">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Order Number Prefix</label>
                        <input type="text" class="adm-form-input" id="dtSet-order_prefix" value="<?= htmlspecialchars(dt_set('order_prefix', 'DT-ORD-')) ?>">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Currency &amp; Timezone</label>
                        <input type="text" class="adm-form-input" value="INR (₹) · Asia/Kolkata (IST)" readonly>
                    </div>
                </div>
                <?php if (!$dtSettingsLive): ?>
                <p style="font-size:11.5px; color:#B45309; padding:0 18px 12px;">⚠ Database unreachable — values shown are defaults and cannot be saved right now.</p>
                <?php endif; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<?php echo dt_set_save_script($dtKeys); ?>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>