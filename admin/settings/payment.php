<?php
require_once __DIR__ . '/_shared.php';
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * payment.php — Payment Gateway Settings
 * DT Brand's & Jai Hanuman Tex
 *
 * Was two fabricated credential rows ("rzp_live_99482019482" /
 * "jaihanumantex@hdfcbank" — neither is a real credential) with a toast-only
 * Save. Razorpay keys genuinely live in .env (RAZORPAY_KEY_ID / SECRET /
 * WEBHOOK_SECRET) and must NOT be duplicated into the database; what belongs
 * here is the non-secret operational config: which gateway is live, the UPI
 * VPA printed on manual-payment instructions, and COD rules.
 */
require_once __DIR__ . '/_shared.php';

$page_title = "Payment Gateway Settings";
$active_nav = "settings";
$dtKeys = ['payment_gateway', 'upi_vpa', 'cod_enabled', 'cod_max_order_value', 'bank_transfer_details'];

$envFile = dirname(__DIR__, 2) . '/.env';
$razorpayConfigured = false;
$razorpayKeyHint = '';
if (is_file($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
        if (preg_match('/^RAZORPAY_KEY_ID\s*=\s*(.+)$/', trim($line), $m)) {
            $val = trim($m[1], "\"' ");
            if ($val !== '' && strpos($val, 'replace') === false && strpos($val, 'your_') === false) {
                $razorpayConfigured = true;
                $razorpayKeyHint = substr($val, 0, 8) . '…';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gateway Settings - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php
require_once __DIR__ . '/_shared.php'; echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php
require_once __DIR__ . '/_shared.php'; include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php
require_once __DIR__ . '/_shared.php'; include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Payment Gateway Settings</span>
                        <span class="adm-badge gold">Payments</span>
                    </h1>
                    <p class="adm-page-subtitle">Gateway selection and customer-facing payment instructions.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/settings/" class="adm-btn-secondary">← Back to Settings Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Razorpay API Keys (secret)</span></h3>
                    <span class="adm-badge <?= $razorpayConfigured ? 'success' : '' ?>"><?= $razorpayConfigured ? 'Configured in .env (' . htmlspecialchars($razorpayKeyHint) . ')' : 'Not configured' ?></span>
                </div>
                <p style="font-size:12px; color:#64748B; padding:0 18px 14px;">
                    Key ID / Key Secret / Webhook Secret are read from the server's <code>.env</code> file
                    (RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET, RAZORPAY_WEBHOOK_SECRET) and are deliberately not
                    editable here — storing secrets in the database would expose them in backups and exports.
                    <?php
require_once __DIR__ . '/_shared.php'; if (!$razorpayConfigured): ?><br><strong style="color:#B45309;">⚠ No live key detected — checkout falls back to offline payment instructions.</strong><?php
require_once __DIR__ . '/_shared.php'; endif; ?>
                </p>
            </div>

            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Customer Payment Options</span></h3>
                    <?php
require_once __DIR__ . '/_shared.php'; echo dt_set_save_button(); ?>
                </div>
                <div class="adm-form-grid">
                    <div class="adm-form-group">
                        <label class="adm-form-label">Primary Gateway</label>
                        <select class="adm-form-input" id="dtSet-payment_gateway">
                            <option value="razorpay" <?= dt_set('payment_gateway', 'razorpay') === 'razorpay' ? 'selected' : '' ?>>Razorpay (cards, UPI, netbanking)</option>
                            <option value="bank_transfer" <?= dt_set('payment_gateway', 'bank_transfer') === 'bank_transfer' ? 'selected' : '' ?>>Bank transfer / RTGS only</option>
                            <option value="cod" <?= dt_set('payment_gateway', 'cod') === 'cod' ? 'selected' : '' ?>>Cash on delivery only</option>
                        </select>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">UPI VPA (printed on payment instructions)</label>
                        <input type="text" class="adm-form-input" id="dtSet-upi_vpa" placeholder="e.g. jaihanumantex@upi" value="<?= htmlspecialchars(dt_set('upi_vpa', '')) ?>">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Cash on Delivery</label>
                        <select class="adm-form-input" id="dtSet-cod_enabled">
                            <option value="1" <?= dt_set('cod_enabled', '0') === '1' ? 'selected' : '' ?>>Enabled</option>
                            <option value="0" <?= dt_set('cod_enabled', '0') === '0' ? 'selected' : '' ?>>Disabled</option>
                        </select>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">COD Max Order Value (₹)</label>
                        <input type="number" min="0" class="adm-form-input" id="dtSet-cod_max_order_value" value="<?= htmlspecialchars(dt_set('cod_max_order_value', '0')) ?>">
                    </div>
                    <div class="adm-form-group full" style="grid-column:1/-1;">
                        <label class="adm-form-label">Bank Transfer Details (shown to customers choosing RTGS/NEFT)</label>
                        <input type="text" class="adm-form-input" id="dtSet-bank_transfer_details" placeholder="Account name, number, IFSC" value="<?= htmlspecialchars(dt_set('bank_transfer_details', '')) ?>">
                    </div>
                </div>
            </div>

        </main>
        <?php
require_once __DIR__ . '/_shared.php'; include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<?php
require_once __DIR__ . '/_shared.php'; echo dt_set_save_script($dtKeys); ?>
<script src="/admin/assets/js/admin.js?v=<?php
require_once __DIR__ . '/_shared.php'; echo time(); ?>"></script>
</body>
</html>