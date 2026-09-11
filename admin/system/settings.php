<?php
declare(strict_types=1);
/* DT admin access guard */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/system/settings.php — Global System Configuration
 * DT Brand's & Jai Hanuman Tex — Section 36
 */
require_once __DIR__ . '/../../src/SystemManager.php';
use DTBrand\SystemManager;

$sm   = SystemManager::getInstance();
$csrf = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(16));
$_SESSION['csrf_token'] = $csrf;

$flash   = '';
$flashType = 'success';

/* ── Handle POST saves ── */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['section'])) {
    $section  = (string)$_POST['section'];
    $payload  = $_POST;
    unset($payload['section'], $payload['_csrf']);
    $ok = $sm->saveSettings($section, $payload, (string)($_POST['_csrf'] ?? ''));
    $flash     = $ok ? 'Settings saved successfully.' : 'Save failed — invalid token or permission denied.';
    $flashType = $ok ? 'success' : 'error';
}

/* ── Load all settings ── */
$settings = $sm->getSettings() ?? [];
$g  = $settings['general']           ?? [];
$m  = $settings['mail']              ?? [];
$s  = $settings['seo']               ?? [];
$b  = $settings['b2b']               ?? [];
$pm = $settings['payments']          ?? [];
$sc = $settings['security']          ?? [];
$no = $settings['notifications_settings'] ?? [];

$active_nav    = 'system';
$active_subnav = 'settings';
$page_title    = 'System Settings — DT Brand\'s';

function sv(array $arr, string $key, string $default = ''): string {
    return htmlspecialchars((string)($arr[$key] ?? $default));
}
function sc(array $arr, string $key): bool {
    return !empty($arr[$key]) && $arr[$key] !== '0';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/admin/system/system.css?v=<?= time() ?>">
</head>
<body class="sys-root">
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">

            <div class="adm-page-head" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:18px;">
                <div>
                    <h1 class="adm-page-title" style="display:flex;align-items:center;gap:8px;margin:0;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 1 1-14.14 0"/></svg>
                        System Settings
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0;color:#64748B;font-size:0.82rem;">Configure site identity, email, SEO defaults, B2B rules, payment keys & security policies.</p>
                </div>
                <a href="/admin/system/" class="sys-btn-pale">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="15 18 9 12 15 6"/></svg>
                    Back to Suite
                </a>
            </div>

            <?php if ($flash): ?>
            <div class="sys-flash <?= $flashType ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <?= htmlspecialchars($flash) ?>
            </div>
            <?php endif; ?>

            <!-- Section Tabs -->
            <div class="sys-tab-bar">
                <?php
                $tabs = [
                    ['id'=>'general',   'label'=>'General',       'icon'=>'<circle cx="12" cy="12" r="10"/>'],
                    ['id'=>'mail',      'label'=>'Email / SMTP',   'icon'=>'<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>'],
                    ['id'=>'seo',       'label'=>'SEO Defaults',   'icon'=>'<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>'],
                    ['id'=>'b2b',       'label'=>'B2B Rules',      'icon'=>'<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>'],
                    ['id'=>'payments',  'label'=>'Payments',       'icon'=>'<rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>'],
                    ['id'=>'security',  'label'=>'Security',       'icon'=>'<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>'],
                ];
                foreach ($tabs as $t): ?>
                <button class="sys-tab-btn" data-tab="<?= $t['id'] ?>" onclick="sysTab('<?= $t['id'] ?>')">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><?= $t['icon'] ?></svg>
                    <?= $t['label'] ?>
                </button>
                <?php endforeach; ?>
            </div>

            <!-- GENERAL -->
            <div class="sys-tab-pane" id="sys-pane-general">
                <form id="sysForm-general" method="POST">
                    <input type="hidden" name="section" value="general">
                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
                    <div class="sys-card">
                        <div class="sys-card-head">
                            <h3 class="sys-card-title">Site Identity & Branding</h3>
                            <button type="button" class="sys-btn-gold" data-save-btn onclick="sysSaveSettings('general')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                Save Changes
                            </button>
                        </div>
                        <div class="sys-card-body">
                            <div class="sys-settings-grid">
                                <div class="sys-field">
                                    <label class="sys-field-label">Site Name</label>
                                    <input type="text" name="site_name" class="sys-input" value="<?= sv($g, 'site_name', 'DT Brand\'s & Jai Hanuman Tex') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Tagline</label>
                                    <input type="text" name="tagline" class="sys-input" value="<?= sv($g, 'tagline', 'Wholesale Ethnic Wear — Since 2005') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Admin Email</label>
                                    <input type="email" name="admin_email" class="sys-input" value="<?= sv($g, 'admin_email', 'admin@jaihanumantex.in') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Support Phone</label>
                                    <input type="text" name="support_phone" class="sys-input" value="<?= sv($g, 'support_phone', '+91 70463 63528') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">WhatsApp Number (International)</label>
                                    <input type="text" name="whatsapp_number" class="sys-input" value="<?= sv($g, 'whatsapp_number', '917046363528') ?>">
                                    <span class="sys-field-hint">Used for WhatsApp Pay deep links. Format: 91XXXXXXXXXX</span>
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">UPI VPA (Primary)</label>
                                    <input type="text" name="upi_vpa" class="sys-input" value="<?= sv($g, 'upi_vpa', '917046363528@okaxis') ?>">
                                </div>
                                <div class="sys-field" style="grid-column:1/-1;">
                                    <label class="sys-field-label">Business Address</label>
                                    <textarea name="business_address" class="sys-textarea"><?= sv($g, 'business_address', '') ?></textarea>
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Currency</label>
                                    <select name="currency" class="sys-select">
                                        <option value="INR" <?= sv($g,'currency','INR')==='INR'?'selected':'' ?>>INR — Indian Rupee (₹)</option>
                                        <option value="USD" <?= sv($g,'currency','INR')==='USD'?'selected':'' ?>>USD — US Dollar</option>
                                    </select>
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Default Timezone</label>
                                    <select name="timezone" class="sys-select">
                                        <option value="Asia/Kolkata" <?= sv($g,'timezone','Asia/Kolkata')==='Asia/Kolkata'?'selected':'' ?>>Asia/Kolkata (IST)</option>
                                        <option value="UTC">UTC</option>
                                    </select>
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Items Per Page (Admin Tables)</label>
                                    <input type="number" name="items_per_page" class="sys-input" min="10" max="200" value="<?= sv($g,'items_per_page','50') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Toggles -->
                    <div class="sys-card">
                        <div class="sys-card-head"><h3 class="sys-card-title">Site Mode</h3></div>
                        <div class="sys-card-body">
                            <?php
                            $toggles = [
                                ['name'=>'enable_registration',  'label'=>'Customer Self-Registration',    'desc'=>'Allow new customers to create accounts on the storefront.'],
                                ['name'=>'enable_reviews',        'label'=>'Product Reviews',               'desc'=>'Show public product reviews; new reviews queue for moderation.'],
                                ['name'=>'enable_wishlist',       'label'=>'Wishlist Feature',              'desc'=>'Customers can save items to wishlists.'],
                                ['name'=>'enable_catalogue_mode', 'label'=>'Catalogue-Only Mode',           'desc'=>'Hides prices & checkout; site becomes a browse-only catalogue.'],
                                ['name'=>'debug_mode',            'label'=>'Debug Mode',                   'desc'=>'Enables verbose error output. NEVER enable on production.'],
                            ];
                            foreach ($toggles as $t): ?>
                            <div class="sys-toggle-row">
                                <div class="sys-toggle-info">
                                    <div class="sys-toggle-name"><?= htmlspecialchars($t['label']) ?></div>
                                    <div class="sys-toggle-desc"><?= htmlspecialchars($t['desc']) ?></div>
                                </div>
                                <label class="sys-toggle">
                                    <input type="checkbox" name="<?= $t['name'] ?>" value="1" <?= sc($g, $t['name']) ? 'checked' : '' ?>>
                                    <span class="sys-toggle-slider"></span>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </form>
            </div>

            <!-- MAIL -->
            <div class="sys-tab-pane" id="sys-pane-mail">
                <form id="sysForm-mail" method="POST">
                    <input type="hidden" name="section" value="mail">
                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
                    <div class="sys-card">
                        <div class="sys-card-head">
                            <h3 class="sys-card-title">SMTP Outgoing Mail Configuration</h3>
                            <button type="button" class="sys-btn-gold" data-save-btn onclick="sysSaveSettings('mail')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/></svg>
                                Save SMTP Config
                            </button>
                        </div>
                        <div class="sys-card-body">
                            <div class="sys-settings-grid">
                                <div class="sys-field">
                                    <label class="sys-field-label">SMTP Host</label>
                                    <input type="text" name="smtp_host" class="sys-input" value="<?= sv($m,'smtp_host','smtp.hostinger.com') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">SMTP Port</label>
                                    <select name="smtp_port" class="sys-select">
                                        <option value="587" <?= sv($m,'smtp_port','587')==='587'?'selected':'' ?>>587 (STARTTLS)</option>
                                        <option value="465" <?= sv($m,'smtp_port','587')==='465'?'selected':'' ?>>465 (SSL)</option>
                                        <option value="25" <?= sv($m,'smtp_port','587')==='25'?'selected':'' ?>>25 (Plain)</option>
                                    </select>
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">SMTP Username</label>
                                    <input type="email" name="smtp_username" class="sys-input" value="<?= sv($m,'smtp_username','') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">SMTP Password</label>
                                    <input type="password" name="smtp_password" class="sys-input" value="" placeholder="Enter to update (leave blank to keep)">
                                    <span class="sys-field-hint">Stored encrypted. Leave blank to keep the existing password.</span>
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">From Name</label>
                                    <input type="text" name="mail_from_name" class="sys-input" value="<?= sv($m,'mail_from_name','DT Brand\'s') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">From Email</label>
                                    <input type="email" name="mail_from_email" class="sys-input" value="<?= sv($m,'mail_from_email','noreply@jaihanumantex.in') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Encryption</label>
                                    <select name="smtp_encryption" class="sys-select">
                                        <option value="tls" <?= sv($m,'smtp_encryption','tls')==='tls'?'selected':'' ?>>TLS / STARTTLS</option>
                                        <option value="ssl">SSL</option>
                                        <option value="none">None</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- SEO -->
            <div class="sys-tab-pane" id="sys-pane-seo">
                <form id="sysForm-seo" method="POST">
                    <input type="hidden" name="section" value="seo">
                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
                    <div class="sys-card">
                        <div class="sys-card-head">
                            <h3 class="sys-card-title">SEO & Meta Defaults</h3>
                            <button type="button" class="sys-btn-gold" data-save-btn onclick="sysSaveSettings('seo')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/></svg>
                                Save SEO Settings
                            </button>
                        </div>
                        <div class="sys-card-body">
                            <div class="sys-settings-grid">
                                <div class="sys-field" style="grid-column:1/-1;">
                                    <label class="sys-field-label">Default Meta Title</label>
                                    <input type="text" name="meta_title" class="sys-input" value="<?= sv($s,'meta_title','DT Brand\'s — Premium Wholesale Ethnic Wear') ?>" maxlength="70">
                                    <span class="sys-field-hint">Recommended: 50–70 characters.</span>
                                </div>
                                <div class="sys-field" style="grid-column:1/-1;">
                                    <label class="sys-field-label">Default Meta Description</label>
                                    <textarea name="meta_description" class="sys-textarea" maxlength="160"><?= sv($s,'meta_description','') ?></textarea>
                                    <span class="sys-field-hint">Recommended: 120–160 characters.</span>
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Meta Keywords</label>
                                    <input type="text" name="meta_keywords" class="sys-input" value="<?= sv($s,'meta_keywords','') ?>">
                                    <span class="sys-field-hint">Comma-separated. Minimal SEO impact today.</span>
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Google Analytics ID</label>
                                    <input type="text" name="ga_id" class="sys-input" placeholder="G-XXXXXXXXXX" value="<?= sv($s,'ga_id','') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Google Search Console Verification</label>
                                    <input type="text" name="gsc_verification" class="sys-input" value="<?= sv($s,'gsc_verification','') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Robots.txt Directive</label>
                                    <select name="robots" class="sys-select">
                                        <option value="index,follow" <?= sv($s,'robots','index,follow')==='index,follow'?'selected':'' ?>>index, follow (recommended)</option>
                                        <option value="noindex,nofollow">noindex, nofollow (staging)</option>
                                        <option value="noindex,follow">noindex, follow</option>
                                    </select>
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Open Graph Image URL</label>
                                    <input type="url" name="og_image" class="sys-input" value="<?= sv($s,'og_image','') ?>" placeholder="https://jaihanumantex.in/assets/og.jpg">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- B2B -->
            <div class="sys-tab-pane" id="sys-pane-b2b">
                <form id="sysForm-b2b" method="POST">
                    <input type="hidden" name="section" value="b2b">
                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
                    <div class="sys-card">
                        <div class="sys-card-head">
                            <h3 class="sys-card-title">B2B Wholesale & Reseller Rules</h3>
                            <button type="button" class="sys-btn-gold" data-save-btn onclick="sysSaveSettings('b2b')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/></svg>
                                Save B2B Config
                            </button>
                        </div>
                        <div class="sys-card-body">
                            <div class="sys-settings-grid">
                                <div class="sys-field">
                                    <label class="sys-field-label">Minimum Wholesale Order (₹)</label>
                                    <input type="number" name="min_wholesale_order" class="sys-input" min="0" value="<?= sv($b,'min_wholesale_order','5000') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Minimum Reseller Order (₹)</label>
                                    <input type="number" name="min_reseller_order" class="sys-input" min="0" value="<?= sv($b,'min_reseller_order','2000') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">COD Minimum Order (₹)</label>
                                    <input type="number" name="cod_min_order" class="sys-input" min="0" value="<?= sv($b,'cod_min_order','500') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">COD Maximum Order (₹)</label>
                                    <input type="number" name="cod_max_order" class="sys-input" min="0" value="<?= sv($b,'cod_max_order','25000') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">COD Handling Fee (₹)</label>
                                    <input type="number" name="cod_fee" class="sys-input" min="0" value="<?= sv($b,'cod_fee','50') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Default Reseller Commission (%)</label>
                                    <input type="number" name="reseller_commission_pct" class="sys-input" min="0" max="50" step="0.5" value="<?= sv($b,'reseller_commission_pct','10') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Credit Period (Days)</label>
                                    <input type="number" name="credit_period_days" class="sys-input" min="0" value="<?= sv($b,'credit_period_days','30') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Low Stock Threshold (Units)</label>
                                    <input type="number" name="low_stock_threshold" class="sys-input" min="1" value="<?= sv($b,'low_stock_threshold','10') ?>">
                                </div>
                            </div>
                            <div class="sys-section-head">Approval Workflow</div>
                            <?php
                            $btToggles = [
                                ['name'=>'auto_approve_wholesale', 'label'=>'Auto-Approve Wholesale Accounts',  'desc'=>'Skip manual approval for new wholesale registrations.'],
                                ['name'=>'auto_approve_reseller',  'label'=>'Auto-Approve Reseller Accounts',   'desc'=>'Skip manual approval for new reseller registrations.'],
                                ['name'=>'require_gst_wholesale',  'label'=>'Require GSTIN for Wholesale',      'desc'=>'Block wholesale account creation without a valid GSTIN.'],
                                ['name'=>'require_pan_reseller',   'label'=>'Require PAN for Resellers',        'desc'=>'Block reseller account creation without a PAN number.'],
                            ];
                            foreach ($btToggles as $t): ?>
                            <div class="sys-toggle-row">
                                <div class="sys-toggle-info">
                                    <div class="sys-toggle-name"><?= htmlspecialchars($t['label']) ?></div>
                                    <div class="sys-toggle-desc"><?= htmlspecialchars($t['desc']) ?></div>
                                </div>
                                <label class="sys-toggle">
                                    <input type="checkbox" name="<?= $t['name'] ?>" value="1" <?= sc($b, $t['name']) ? 'checked' : '' ?>>
                                    <span class="sys-toggle-slider"></span>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </form>
            </div>

            <!-- PAYMENTS -->
            <div class="sys-tab-pane" id="sys-pane-payments">
                <form id="sysForm-payments" method="POST">
                    <input type="hidden" name="section" value="payments">
                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
                    <div class="sys-card">
                        <div class="sys-card-head">
                            <h3 class="sys-card-title">Multi-Gateway Payment Configuration</h3>
                            <button type="button" class="sys-btn-gold" data-save-btn onclick="sysSaveSettings('payments')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/></svg>
                                Save Payment Config
                            </button>
                        </div>
                        <div class="sys-card-body">
                            <div class="sys-section-head">Razorpay</div>
                            <div class="sys-settings-grid">
                                <div class="sys-field">
                                    <label class="sys-field-label">Razorpay Key ID</label>
                                    <input type="text" name="razorpay_key_id" class="sys-input" value="<?= sv($pm,'razorpay_key_id','') ?>" placeholder="rzp_live_...">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Razorpay Key Secret</label>
                                    <input type="password" name="razorpay_key_secret" class="sys-input" placeholder="Leave blank to keep existing">
                                    <span class="sys-field-hint">Stored encrypted. Leave blank to keep the existing secret.</span>
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Razorpay Webhook Secret</label>
                                    <input type="password" name="razorpay_webhook_secret" class="sys-input" placeholder="Leave blank to keep existing">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Razorpay Mode</label>
                                    <select name="razorpay_mode" class="sys-select">
                                        <option value="live" <?= sv($pm,'razorpay_mode','live')==='live'?'selected':'' ?>>Live</option>
                                        <option value="test" <?= sv($pm,'razorpay_mode','live')==='test'?'selected':'' ?>>Test</option>
                                    </select>
                                </div>
                            </div>
                            <div class="sys-section-head" style="margin-top:16px;">Cashfree</div>
                            <div class="sys-settings-grid">
                                <div class="sys-field">
                                    <label class="sys-field-label">Cashfree App ID</label>
                                    <input type="text" name="cashfree_app_id" class="sys-input" value="<?= sv($pm,'cashfree_app_id','') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Cashfree Secret Key</label>
                                    <input type="password" name="cashfree_secret" class="sys-input" placeholder="Leave blank to keep existing">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Cashfree Mode</label>
                                    <select name="cashfree_mode" class="sys-select">
                                        <option value="production" <?= sv($pm,'cashfree_mode','production')==='production'?'selected':'' ?>>Production</option>
                                        <option value="sandbox">Sandbox</option>
                                    </select>
                                </div>
                            </div>
                            <div class="sys-section-head" style="margin-top:16px;">UPI Settings</div>
                            <div class="sys-settings-grid">
                                <div class="sys-field">
                                    <label class="sys-field-label">Primary UPI VPA</label>
                                    <input type="text" name="upi_vpa_primary" class="sys-input" value="<?= sv($pm,'upi_vpa_primary','917046363528@okaxis') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">UPI MCC Code</label>
                                    <input type="text" name="upi_mcc" class="sys-input" value="<?= sv($pm,'upi_mcc','5691') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">UPI QR Expiry (minutes)</label>
                                    <input type="number" name="upi_qr_expiry_min" class="sys-input" min="1" max="60" value="<?= sv($pm,'upi_qr_expiry_min','5') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- SECURITY -->
            <div class="sys-tab-pane" id="sys-pane-security">
                <form id="sysForm-security" method="POST">
                    <input type="hidden" name="section" value="security">
                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
                    <div class="sys-card">
                        <div class="sys-card-head">
                            <h3 class="sys-card-title">Security & Access Policies</h3>
                            <button type="button" class="sys-btn-gold" data-save-btn onclick="sysSaveSettings('security')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/></svg>
                                Save Security Config
                            </button>
                        </div>
                        <div class="sys-card-body">
                            <div class="sys-settings-grid">
                                <div class="sys-field">
                                    <label class="sys-field-label">Session Timeout (minutes)</label>
                                    <input type="number" name="session_timeout" class="sys-input" min="5" max="1440" value="<?= sv($sc,'session_timeout','120') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Max Failed Login Attempts</label>
                                    <input type="number" name="max_login_attempts" class="sys-input" min="3" max="20" value="<?= sv($sc,'max_login_attempts','5') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Account Lockout Duration (minutes)</label>
                                    <input type="number" name="lockout_duration" class="sys-input" min="1" value="<?= sv($sc,'lockout_duration','15') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Password Minimum Length</label>
                                    <input type="number" name="min_password_length" class="sys-input" min="8" max="32" value="<?= sv($sc,'min_password_length','8') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">Audit Log Retention (days)</label>
                                    <input type="number" name="audit_retention_days" class="sys-input" min="30" value="<?= sv($sc,'audit_retention_days','365') ?>">
                                </div>
                                <div class="sys-field">
                                    <label class="sys-field-label">System Log Retention (days)</label>
                                    <input type="number" name="log_retention_days" class="sys-input" min="7" value="<?= sv($sc,'log_retention_days','90') ?>">
                                </div>
                            </div>
                            <div class="sys-section-head" style="margin-top:16px;">Security Hardening</div>
                            <?php
                            $secToggles = [
                                ['name'=>'force_https',       'label'=>'Force HTTPS',                    'desc'=>'Redirect all HTTP traffic to HTTPS.'],
                                ['name'=>'enable_2fa',        'label'=>'Two-Factor Auth (Admin)',         'desc'=>'Require TOTP/email OTP for admin logins.'],
                                ['name'=>'ip_whitelist',      'label'=>'Admin IP Whitelist',              'desc'=>'Only allow admin access from whitelisted IPs.'],
                                ['name'=>'rate_limit_api',    'label'=>'API Rate Limiting',               'desc'=>'Throttle API endpoints to prevent abuse.'],
                                ['name'=>'log_all_requests',  'label'=>'Log All Admin Requests',          'desc'=>'Verbose audit of every admin page load (high disk usage).'],
                            ];
                            foreach ($secToggles as $t): ?>
                            <div class="sys-toggle-row">
                                <div class="sys-toggle-info">
                                    <div class="sys-toggle-name"><?= htmlspecialchars($t['label']) ?></div>
                                    <div class="sys-toggle-desc"><?= htmlspecialchars($t['desc']) ?></div>
                                </div>
                                <label class="sys-toggle">
                                    <input type="checkbox" name="<?= $t['name'] ?>" value="1" <?= sc($sc, $t['name']) ? 'checked' : '' ?>>
                                    <span class="sys-toggle-slider"></span>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </form>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?= time() ?>"></script>
<script src="/admin/system/system.js?v=<?= time() ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Activate first tab
    const first = document.querySelector('.sys-tab-btn');
    if (first) sysTab(first.dataset.tab);
});
</script>
</body>
</html>
