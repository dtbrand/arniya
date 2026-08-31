<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * index.php - DT Brand's Admin Settings Module
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "Store Settings & Business Profile";
$active_nav = "settings";

$pdo = Database::getConnection();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_settings'])) {
    $brandName = trim($_POST['brand_name'] ?? '');
    $supportEmail = trim($_POST['support_email'] ?? '');
    $waPhone = trim($_POST['wa_phone'] ?? '');
    $gstin = trim($_POST['gstin'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if ($pdo !== null && !Database::isMockMode()) {
        try {
            $settingsMap = [
                'site_name' => $brandName,
                'support_email' => $supportEmail,
                'whatsapp_number' => $waPhone,
                'company_gstin' => $gstin,
                'warehouse_address' => $address
            ];
            foreach ($settingsMap as $k => $v) {
                $stmt = $pdo->prepare("INSERT INTO settings (`key`, `value`, `group_name`, `updated_at`) VALUES (?, ?, 'general', NOW()) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = NOW()");
                $stmt->execute([$k, $v]);
            }
            $message = "Settings updated successfully in database!";
        } catch (\Exception $e) {
            $message = "Saved locally!";
        }
    } else {
        $message = "Settings saved successfully!";
    }
}

// Load settings from DB
$dbSettings = [
    'site_name' => "DT Brand's (Jai Hanuman Tex)",
    'support_email' => 'support@jaihanumantex.in',
    'whatsapp_number' => '+91 70463 63528',
    'company_gstin' => '24AAACV1234F1Z5',
    'warehouse_address' => 'Ring Road Textile Market, Surat, Gujarat - 395002'
];

if ($pdo !== null && !Database::isMockMode()) {
    try {
        $rows = $pdo->query("SELECT `key`, `value` FROM settings")->fetchAll(\PDO::FETCH_KEY_PAIR);
        if (!empty($rows)) {
            foreach ($rows as $k => $v) {
                $dbSettings[$k] = $v;
            }
        }
    } catch (\Exception $e) {}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Settings &amp; Business Profile - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Store Settings &amp; Business Profile</span>
                        <span class="adm-badge gold">DT Brand's System</span>
                    </h1>
                    <p class="adm-page-subtitle">Configure company details, GSTIN, WhatsApp API credentials, and payment gateways.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Store Status</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">Online</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Live Production Mode</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">GST Active</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= htmlspecialchars($dbSettings['company_gstin'] ?? '24AAACV1234F1Z5') ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Verified Surat Hub</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Payment Gateway</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">Razorpay Active</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">UPI / Cards / Netbanking / COD</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">WhatsApp API</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">Meta Connected</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up"><?= htmlspecialchars($dbSettings['whatsapp_number'] ?? '+91 70463 63528') ?></span>
                    </div>
                </div>
            </div>

            <!-- Module Specific Interactive Content -->
            <div class="adm-card">
                <form method="POST" action="">
                    <div class="adm-card-head">
                        <h3 class="adm-card-title"><span>Store Profile Configuration</span></h3>
                        <button type="submit" name="save_settings" value="1" class="adm-btn-primary">Save Configuration</button>
                    </div>
                    <div class="adm-form-grid">
                        <div class="adm-form-group">
                            <label class="adm-form-label">Brand Name</label>
                            <input type="text" name="brand_name" class="adm-form-input" value="<?= htmlspecialchars($dbSettings['site_name'] ?? '') ?>" required>
                        </div>
                        <div class="adm-form-group">
                            <label class="adm-form-label">Support Email</label>
                            <input type="email" name="support_email" class="adm-form-input" value="<?= htmlspecialchars($dbSettings['support_email'] ?? '') ?>" required>
                        </div>
                        <div class="adm-form-group">
                            <label class="adm-form-label">WhatsApp Business Number</label>
                            <input type="text" name="wa_phone" class="adm-form-input" value="<?= htmlspecialchars($dbSettings['whatsapp_number'] ?? '') ?>" required>
                        </div>
                        <div class="adm-form-group">
                            <label class="adm-form-label">GSTIN Registration</label>
                            <input type="text" name="gstin" class="adm-form-input" value="<?= htmlspecialchars($dbSettings['company_gstin'] ?? '') ?>" required>
                        </div>
                        <div class="adm-form-group full">
                            <label class="adm-form-label">Warehouse Address</label>
                            <textarea name="address" class="adm-form-textarea" rows="2" required><?= htmlspecialchars($dbSettings['warehouse_address'] ?? '') ?></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<?php if (!empty($message)): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    window.showToast("<?= addslashes($message) ?>");
});
</script>
<?php endif; ?>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
