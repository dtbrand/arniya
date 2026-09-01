<?php
require_once __DIR__ . '/_shared.php';
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * company.php — Company & Legal Business Profile
 * DT Brand's & Jai Hanuman Tex
 *
 * Was two fake inputs (including a fabricated GSTIN "24AAACV1234F1Z5") and a
 * toast-only Save. Values now load from and persist to the `settings` table
 * via api/settings.php. The GSTIN field starts EMPTY — a legal tax number
 * must never ship as a plausible-looking placeholder.
 */
require_once __DIR__ . '/_shared.php';

$page_title = "Company & Legal Business Profile";
$active_nav = "settings";
$dtKeys = ['company_legal_name', 'company_gstin', 'company_pan', 'company_address', 'company_state', 'company_pincode'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company & Legal Business Profile - DT Brand's Admin</title>
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
                        <span>Company &amp; Legal Business Profile</span>
                        <span class="adm-badge gold">Legal Entity</span>
                    </h1>
                    <p class="adm-page-subtitle">Registered business identity used on GST invoices and B2B paperwork.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/settings/" class="adm-btn-secondary">← Back to Settings Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Legal Company Information</span></h3>
                    <?php
require_once __DIR__ . '/_shared.php'; echo dt_set_save_button(); ?>
                </div>
                <div class="adm-form-grid">
                    <div class="adm-form-group">
                        <label class="adm-form-label">Legal Business Name *</label>
                        <input type="text" class="adm-form-input" id="dtSet-company_legal_name" required value="<?= htmlspecialchars(dt_set('company_legal_name', 'Jai Hanuman Tex (DT Brand\'s)')) ?>">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">GSTIN <span style="color:#B45309; font-weight:700;">(required for B2B invoicing)</span></label>
                        <input type="text" class="adm-form-input" id="dtSet-company_gstin" maxlength="15" placeholder="e.g. 24ABCDE1234F1Z5 — leave blank only if not yet registered" value="<?= htmlspecialchars(dt_set('company_gstin', '')) ?>">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">PAN</label>
                        <input type="text" class="adm-form-input" id="dtSet-company_pan" maxlength="10" value="<?= htmlspecialchars(dt_set('company_pan', '')) ?>">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Registered Address</label>
                        <input type="text" class="adm-form-input" id="dtSet-company_address" value="<?= htmlspecialchars(dt_set('company_address', '')) ?>">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">State</label>
                        <input type="text" class="adm-form-input" id="dtSet-company_state" value="<?= htmlspecialchars(dt_set('company_state', 'Gujarat')) ?>">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">PIN Code</label>
                        <input type="text" class="adm-form-input" id="dtSet-company_pincode" maxlength="6" value="<?= htmlspecialchars(dt_set('company_pincode', '')) ?>">
                    </div>
                </div>
                <?php
require_once __DIR__ . '/_shared.php'; if (dt_set('company_gstin', '') === ''): ?>
                <p style="font-size:11.5px; color:#B45309; padding:0 18px 12px;">⚠ No GSTIN on file — B2B order invoices will print without a tax number until it is saved here.</p>
                <?php
require_once __DIR__ . '/_shared.php'; endif; ?>
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