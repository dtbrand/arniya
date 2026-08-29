<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * templates.php - DT Brand's Admin Notification Message Templates
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Notification Message Templates";
$active_nav = "notifications";

$templates = [
    [
        'name' => 'dt_order_placed_v1',
        'category' => 'Utility',
        'channel' => 'WhatsApp Cloud API',
        'variables' => '{{customer_name}}, {{order_id}}, {{amount}}',
        'trigger' => 'Instant Checkout Success',
        'status' => 'Meta Approved'
    ],
    [
        'name' => 'dt_dispatch_tracking_v2',
        'category' => 'Utility',
        'channel' => 'WhatsApp + SMS',
        'variables' => '{{customer_name}}, {{courier}}, {{awb}}, {{tracking_url}}',
        'trigger' => 'Order AWB Assignment',
        'status' => 'Meta Approved'
    ],
    [
        'name' => 'dt_b2b_wholesale_quote',
        'category' => 'Marketing',
        'channel' => 'WhatsApp Direct PDF',
        'variables' => '{{merchant_name}}, {{bale_qty}}, {{pdf_link}}',
        'trigger' => 'B2B Wholesale Inquiry',
        'status' => 'Meta Approved'
    ],
    [
        'name' => 'dt_reseller_payout_approved',
        'category' => 'Utility',
        'channel' => 'WhatsApp API',
        'variables' => '{{reseller_name}}, {{amount}}, {{payout_ref}}',
        'trigger' => 'Admin Reseller Payout Batch',
        'status' => 'Meta Approved'
    ],
    [
        'name' => 'admin_stock_replenish',
        'category' => 'Internal Alert',
        'channel' => 'Admin Direct SMS',
        'variables' => '{{sku}}, {{remaining_qty}}',
        'trigger' => 'Stock Falls < 15 pcs',
        'status' => 'Active'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Message Templates - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Notification Message Templates</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;"><?= count($templates) ?> Cloud API Templates</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Manage pre-approved WhatsApp Cloud API HSM templates, message variables, and automated triggers.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/notifications/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">← Notifications Hub</a>
                    <button type="button" class="dt-btn dt-btn-gold" style="height:32px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;" onclick="openNewTemplateModal()">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Register Template</span>
                    </button>
                </div>
            </div>

            <!-- Templates Table Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>📜 Pre-Approved WhatsApp &amp; SMS Templates</span></h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;">🟢 Meta Cloud Synchronized</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Template Key</th>
                                <th>Category</th>
                                <th>Delivery Channel</th>
                                <th>Dynamic Payload Variables</th>
                                <th>Lifecycle Trigger</th>
                                <th>Meta Status</th>
                                <th style="text-align:right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($templates as $t): ?>
                                <tr>
                                    <td>
                                        <code style="background:#FAF5E8; padding:3px 8px; border-radius:6px; color:#8A681F; font-weight:800; border:1px solid #D4AF37;">
                                            <?= htmlspecialchars($t['name']) ?>
                                        </code>
                                    </td>
                                    <td><span class="adm-badge" style="background:#F5F5F4; color:#57534E; font-weight:700;"><?= htmlspecialchars($t['category']) ?></span></td>
                                    <td>
                                        <strong style="color:#181512; font-size:12px;"><?= htmlspecialchars($t['channel']) ?></strong>
                                    </td>
                                    <td>
                                        <span style="font-size:11.5px; color:#64748B;"><?= htmlspecialchars($t['variables']) ?></span>
                                    </td>
                                    <td>
                                        <span style="font-size:12px; color:#181512; font-weight:600;"><?= htmlspecialchars($t['trigger']) ?></span>
                                    </td>
                                    <td>
                                        <span class="adm-badge success"><?= htmlspecialchars($t['status']) ?></span>
                                    </td>
                                    <td style="text-align:right;">
                                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('Testing sample dispatch with template <?= htmlspecialchars($t['name']) ?>...')">Test Send</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- Register Template Modal -->
<div id="newTemplateModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div style="background:#FFFFFF; border-radius:12px; width:95%; max-width:480px; padding:22px; box-shadow:0 10px 30px rgba(0,0,0,0.25); border:1.5px solid #D4AF37;">
        <h3 style="margin:0 0 14px 0; font-size:1.1rem; font-weight:800; color:#181512; display:flex; align-items:center; gap:8px;">
            <span>📜 Register Meta WhatsApp Template</span>
        </h3>
        <form onsubmit="handleRegisterTemplate(event)">
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Template Technical Name *</label>
                    <input type="text" id="tplName" placeholder="e.g. dt_payment_receipt_v1" required style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:700; box-sizing:border-box;">
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Category</label>
                        <select style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 8px; font-weight:600;">
                            <option>Utility</option>
                            <option>Marketing</option>
                            <option>Authentication</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Language</label>
                        <select style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 8px; font-weight:600;">
                            <option>English (en)</option>
                            <option>Hindi (hi)</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Template Body Text</label>
                    <textarea rows="3" placeholder="Hello {{1}}, your order {{2}} has been confirmed..." required style="width:100%; border:1.5px solid #EAE5D9; border-radius:6px; padding:8px 10px; font-weight:600; font-size:12px; box-sizing:border-box; resize:none;"></textarea>
                </div>
            </div>
            <div style="margin-top:18px; display:flex; justify-content:flex-end; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeNewTemplateModal()">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">Submit to Meta</button>
            </div>
        </form>
    </div>
</div>

<script>
function openNewTemplateModal() {
    const m = document.getElementById('newTemplateModal');
    if (m) m.style.display = 'flex';
}

function closeNewTemplateModal() {
    const m = document.getElementById('newTemplateModal');
    if (m) m.style.display = 'none';
}

function handleRegisterTemplate(e) {
    e.preventDefault();
    const name = document.getElementById('tplName').value.trim();
    closeNewTemplateModal();
    if (typeof window.showToast === 'function') {
        window.showToast(`✨ Template "${name}" submitted to Meta Cloud API!`);
    }
}
</script>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
