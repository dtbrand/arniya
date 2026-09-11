<?php
/**
 * admin/notifications/templates.php — Multi-Channel Templates Studio
 * Section 31 (Notification Admin)
 * DT Brand's & Jai Hanuman Tex
 */

$__dtg = __DIR__ . '/../includes/adminguard.php';
if (!is_file($__dtg)) {
    $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php';
}
if (is_file($__dtg)) require_once $__dtg;

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/NotificationManager.php';

use DTBrand\Database;
use DTBrand\NotificationManager;

$page_title = "Notification Templates Studio";
$active_nav = "notifications";
$active_subnav = "templates";

$channelFilter = $_GET['channel'] ?? 'all';
$categoryFilter = $_GET['category'] ?? 'all';
$search = trim($_GET['search'] ?? '');

$templates = NotificationManager::getTemplates([
    'channel' => $channelFilter,
    'category' => $categoryFilter,
    'search' => $search
]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Templates Studio — DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/notifications/notifications.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">

            <!-- Page Header -->
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:18px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:10px; margin:0;">
                        <span>Notification Templates Studio</span>
                        <span class="adm-badge gold" style="font-size:0.7rem; font-weight:800;"><?= count($templates) ?> ACTIVE</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">
                        Pre-approved WhatsApp Cloud API HSM, Hostinger SMTP invoices, DLT SMS headers &amp; Push copy with safe variable substitution.
                    </p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/notifications/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:34px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Notifications Hub</span>
                    </a>
                    <button type="button" class="dt-btn dt-btn-gold" style="height:34px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;" onclick="openTemplateModal()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Create Template</span>
                    </button>
                </div>
            </div>

            <!-- Filters Toolbar -->
            <div class="adm-card" style="margin-bottom:16px; padding:12px 16px;">
                <form method="GET" action="" style="display:flex; gap:12px; flex-wrap:wrap; align-items:center; justify-content:space-between;">
                    <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                        <div style="display:flex; align-items:center; gap:4px;">
                            <span style="font-size:0.75rem; font-weight:700; color:#475569;">Channel:</span>
                            <select name="channel" onchange="this.form.submit()" style="height:32px; border:1px solid #CBD5E1; border-radius:6px; padding:0 8px; font-size:0.8rem; font-weight:600;">
                                <option value="all" <?= $channelFilter === 'all' ? 'selected' : '' ?>>All Channels</option>
                                <option value="whatsapp" <?= $channelFilter === 'whatsapp' ? 'selected' : '' ?>>WhatsApp Cloud API</option>
                                <option value="email" <?= $channelFilter === 'email' ? 'selected' : '' ?>>Transactional Email</option>
                                <option value="sms" <?= $channelFilter === 'sms' ? 'selected' : '' ?>>DLT SMS</option>
                                <option value="push" <?= $channelFilter === 'push' ? 'selected' : '' ?>>Lockscreen Push</option>
                            </select>
                        </div>
                        <div style="display:flex; align-items:center; gap:4px;">
                            <span style="font-size:0.75rem; font-weight:700; color:#475569;">Category:</span>
                            <select name="category" onchange="this.form.submit()" style="height:32px; border:1px solid #CBD5E1; border-radius:6px; padding:0 8px; font-size:0.8rem; font-weight:600;">
                                <option value="all" <?= $categoryFilter === 'all' ? 'selected' : '' ?>>All Categories</option>
                                <option value="Transactional" <?= $categoryFilter === 'Transactional' ? 'selected' : '' ?>>Transactional</option>
                                <option value="Utility" <?= $categoryFilter === 'Utility' ? 'selected' : '' ?>>Utility</option>
                                <option value="Marketing" <?= $categoryFilter === 'Marketing' ? 'selected' : '' ?>>Marketing</option>
                            </select>
                        </div>
                    </div>
                    <div style="display:flex; gap:8px; align-items:center;">
                        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search templates or variables..." style="height:32px; border:1px solid #CBD5E1; border-radius:6px; padding:0 10px; font-size:0.8rem; min-width:220px;">
                        <button type="submit" class="dt-btn dt-btn-gold" style="height:32px; padding:0 12px; font-size:0.78rem; font-weight:800;">Filter</button>
                        <?php if ($channelFilter !== 'all' || $categoryFilter !== 'all' || !empty($search)): ?>
                            <a href="/admin/notifications/templates.php" class="dt-btn dt-btn-pale" style="height:32px; padding:0 10px; font-size:0.78rem; font-weight:700; text-decoration:none;">Reset</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Templates List -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(340px, 1fr)); gap:16px;">
                <?php if (empty($templates)): ?>
                    <div class="adm-card" style="grid-column: 1 / -1; text-align:center; padding:36px; color:#64748B;">
                        No notification templates matched your query.
                    </div>
                <?php else: ?>
                    <?php foreach ($templates as $t): ?>
                        <?php
                            $vars = json_decode($t['variables_json'] ?? '[]', true) ?: [];
                            $channelClass = match($t['channel']) {
                                'whatsapp' => 'wa',
                                'email' => 'email',
                                'sms' => 'sms',
                                default => 'push'
                            };
                        ?>
                        <div class="adm-card" style="display:flex; flex-direction:column; justify-content:space-between; margin-bottom:0; border:1.5px solid #EAE5D9;">
                            <div>
                                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:10px;">
                                    <div>
                                        <h3 style="margin:0 0 4px 0; font-size:0.95rem; font-weight:800; color:#111827;">
                                            <?= htmlspecialchars($t['title']) ?>
                                        </h3>
                                        <code style="font-size:0.72rem; background:#FAF5E8; color:#8A681F; padding:2px 6px; border-radius:4px; border:1px solid #D4AF37; font-weight:700;">
                                            <?= htmlspecialchars($t['template_key']) ?>
                                        </code>
                                    </div>
                                    <span class="adm-badge gold" style="font-size:0.68rem; font-weight:800; text-transform:uppercase;">
                                        <?= htmlspecialchars($t['channel']) ?>
                                    </span>
                                </div>

                                <?php if (!empty($t['subject'])): ?>
                                    <div style="margin-bottom:8px; font-size:0.78rem; color:#1E293B;">
                                        <strong>Subject:</strong> <?= htmlspecialchars($t['subject']) ?>
                                    </div>
                                <?php endif; ?>

                                <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:6px; padding:10px; font-size:0.8rem; color:#334155; line-height:1.45; white-space:pre-wrap; margin-bottom:12px; font-family:sans-serif; max-height:140px; overflow-y:auto;">
                                    <?= htmlspecialchars($t['content']) ?>
                                </div>

                                <!-- Variable Tokens -->
                                <div style="margin-bottom:12px;">
                                    <span style="font-size:0.7rem; font-weight:700; color:#64748B; text-transform:uppercase; display:block; margin-bottom:4px;">Allowed Variables:</span>
                                    <div style="display:flex; flex-wrap:wrap; gap:4px;">
                                        <?php if (empty($vars)): ?>
                                            <span style="font-size:0.72rem; color:#94A3B8;">Static text (No variables)</span>
                                        <?php else: ?>
                                            <?php foreach ($vars as $v): ?>
                                                <span class="dt-var-tag" title="Click to copy" onclick="navigator.clipboard.writeText('{{<?= htmlspecialchars($v) ?>}}'); window.DTNotifications.showToast('Copied {{<?= htmlspecialchars($v) ?>}}');">
                                                    {{<?= htmlspecialchars($v) ?>}}
                                                </span>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if (!empty($t['meta_template_id'])): ?>
                                    <div style="font-size:0.72rem; color:#64748B; margin-bottom:4px;">
                                        <strong>Meta WABA ID:</strong> <code><?= htmlspecialchars($t['meta_template_id']) ?></code>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($t['dlt_template_id'])): ?>
                                    <div style="font-size:0.72rem; color:#64748B; margin-bottom:4px;">
                                        <strong>TRAI DLT ID:</strong> <code><?= htmlspecialchars($t['dlt_template_id']) ?></code>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid #EAE5D9; padding-top:10px; margin-top:8px;">
                                <span style="font-size:0.72rem; color:#64748B;">Category: <strong><?= htmlspecialchars($t['category']) ?></strong></span>
                                <div style="display:flex; gap:6px;">
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick='editTemplate(<?= htmlspecialchars(json_encode($t), ENT_QUOTES, "UTF-8") ?>)'>Edit</button>
                                    <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick='testTemplateSend(<?= htmlspecialchars(json_encode($t), ENT_QUOTES, "UTF-8") ?>)'>Test Send</button>
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="color:#DC2626; border-color:#FECACA;" onclick="deleteTemplateConfirm(<?= (int)$t['id'] ?>, '<?= addslashes($t['title']) ?>')">Delete</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<!-- Add / Edit Template Modal -->
<div id="templateModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div style="background:#FFFFFF; border-radius:12px; width:95%; max-width:540px; padding:24px; box-shadow:0 12px 36px rgba(0,0,0,0.25); border:1.5px solid #D4AF37;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
            <h3 id="tplModalTitle" style="margin:0; font-size:1.1rem; font-weight:800; color:#111827;">Create Notification Template</h3>
            <button type="button" onclick="closeTemplateModal()" style="background:none; border:none; font-size:1.2rem; cursor:pointer; color:#64748B;">&times;</button>
        </div>
        <form onsubmit="handleSaveTemplate(event)">
            <input type="hidden" id="tplId" value="">
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Unique Template Key *</label>
                        <input type="text" id="tplKey" placeholder="e.g. dt_sample_ready_wa" required style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:700; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Channel *</label>
                        <select id="tplChannel" style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 8px; font-weight:700;">
                            <option value="whatsapp">WhatsApp Cloud API</option>
                            <option value="email">Transactional Email</option>
                            <option value="sms">DLT SMS</option>
                            <option value="push">Push Notification</option>
                        </select>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1.4fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Human Title *</label>
                        <input type="text" id="tplHumanTitle" placeholder="e.g. Sample Swatch Ready Notification" required style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Category</label>
                        <select id="tplCategory" style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 8px; font-weight:600;">
                            <option value="Transactional">Transactional</option>
                            <option value="Utility">Utility</option>
                            <option value="Marketing">Marketing</option>
                        </select>
                    </div>
                </div>

                <div id="subjectGroup">
                    <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Email / Push Subject Line</label>
                    <input type="text" id="tplSubject" placeholder="e.g. Your Handloom Order #{{order_no}} Confirmation" style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>

                <div>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                        <label style="font-size:0.75rem; font-weight:700; color:#111827;">Template Content *</label>
                        <div style="display:flex; gap:4px; align-items:center;">
                            <span style="font-size:0.7rem; color:#64748B;">Insert:</span>
                            <span class="dt-var-tag" onclick="window.DTNotifications.insertVariable('tplContent', 'customer_name')">+ name</span>
                            <span class="dt-var-tag" onclick="window.DTNotifications.insertVariable('tplContent', 'order_no')">+ order</span>
                            <span class="dt-var-tag" onclick="window.DTNotifications.insertVariable('tplContent', 'amount')">+ amount</span>
                            <span class="dt-var-tag" onclick="window.DTNotifications.insertVariable('tplContent', 'courier')">+ courier</span>
                            <span class="dt-var-tag" onclick="window.DTNotifications.insertVariable('tplContent', 'tracking_url')">+ url</span>
                        </div>
                    </div>
                    <textarea id="tplContent" rows="4" required style="width:100%; border:1.5px solid #EAE5D9; border-radius:6px; padding:8px 10px; font-size:0.82rem; font-weight:600; box-sizing:border-box; resize:none;"></textarea>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Meta WABA ID</label>
                        <input type="text" id="tplMetaId" placeholder="e.g. dt_sample_ready_v1" style="width:100%; height:34px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 8px; font-size:0.8rem; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">DLT Template ID</label>
                        <input type="text" id="tplDltId" placeholder="e.g. DLT_1407161234999" style="width:100%; height:34px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 8px; font-size:0.8rem; box-sizing:border-box;">
                    </div>
                </div>
            </div>

            <div style="margin-top:20px; display:flex; justify-content:flex-end; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeTemplateModal()">Cancel</button>
                <button type="submit" id="btnSaveTpl" class="dt-btn dt-btn-gold">Save Template</button>
            </div>
        </form>
    </div>
</div>

<!-- Test Send Template Modal -->
<div id="testSendModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div style="background:#FFFFFF; border-radius:12px; width:95%; max-width:480px; padding:24px; box-shadow:0 12px 36px rgba(0,0,0,0.25); border:1.5px solid #D4AF37;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
            <h3 style="margin:0; font-size:1.05rem; font-weight:800; color:#111827;">Test Dispatch: <span id="testModalTplName" style="color:#8A681F;"></span></h3>
            <button type="button" onclick="closeTestSendModal()" style="background:none; border:none; font-size:1.2rem; cursor:pointer; color:#64748B;">&times;</button>
        </div>
        <form onsubmit="handleExecuteTestSend(event)">
            <input type="hidden" id="testChannel" value="">
            <input type="hidden" id="testTplKey" value="">
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Recipient Target *</label>
                    <input type="text" id="testRecipient" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:700; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Test Variables (Sample)</label>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                        <input type="text" id="testVarCustomer" placeholder="customer_name" value="Priya Sharma" style="height:32px; border:1px solid #CBD5E1; border-radius:4px; padding:0 8px; font-size:0.78rem;">
                        <input type="text" id="testVarOrder" placeholder="order_no" value="DT-88995" style="height:32px; border:1px solid #CBD5E1; border-radius:4px; padding:0 8px; font-size:0.78rem;">
                        <input type="text" id="testVarAmount" placeholder="amount" value="5,890" style="height:32px; border:1px solid #CBD5E1; border-radius:4px; padding:0 8px; font-size:0.78rem;">
                        <input type="text" id="testVarCourier" placeholder="courier" value="Delhivery Surface" style="height:32px; border:1px solid #CBD5E1; border-radius:4px; padding:0 8px; font-size:0.78rem;">
                    </div>
                </div>
            </div>
            <div style="margin-top:20px; display:flex; justify-content:flex-end; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeTestSendModal()">Cancel</button>
                <button type="submit" id="btnExecuteTestSend" class="dt-btn dt-btn-gold">Dispatch Now</button>
            </div>
        </form>
    </div>
</div>

<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="/admin/notifications/notifications.js?v=<?php echo time(); ?>"></script>
<script>
function openTemplateModal() {
    document.getElementById('tplId').value = '';
    document.getElementById('tplKey').value = '';
    document.getElementById('tplKey').readOnly = false;
    document.getElementById('tplHumanTitle').value = '';
    document.getElementById('tplSubject').value = '';
    document.getElementById('tplContent').value = '';
    document.getElementById('tplMetaId').value = '';
    document.getElementById('tplDltId').value = '';
    document.getElementById('tplModalTitle').textContent = 'Create Notification Template';
    const m = document.getElementById('templateModal');
    if (m) m.style.display = 'flex';
}
function closeTemplateModal() {
    const m = document.getElementById('templateModal');
    if (m) m.style.display = 'none';
}
function editTemplate(t) {
    document.getElementById('tplId').value = t.id || '';
    document.getElementById('tplKey').value = t.template_key || '';
    document.getElementById('tplKey').readOnly = true;
    document.getElementById('tplHumanTitle').value = t.title || '';
    document.getElementById('tplChannel').value = t.channel || 'whatsapp';
    document.getElementById('tplCategory').value = t.category || 'Transactional';
    document.getElementById('tplSubject').value = t.subject || '';
    document.getElementById('tplContent').value = t.content || '';
    document.getElementById('tplMetaId').value = t.meta_template_id || '';
    document.getElementById('tplDltId').value = t.dlt_template_id || '';
    document.getElementById('tplModalTitle').textContent = 'Edit Template: ' + t.template_key;
    const m = document.getElementById('templateModal');
    if (m) m.style.display = 'flex';
}
function handleSaveTemplate(e) {
    e.preventDefault();
    const btn = document.getElementById('btnSaveTpl');
    btn.disabled = true;
    btn.textContent = 'Saving...';

    const payload = {
        action: 'save_template',
        template_key: document.getElementById('tplKey').value.trim(),
        channel: document.getElementById('tplChannel').value,
        title: document.getElementById('tplHumanTitle').value.trim(),
        category: document.getElementById('tplCategory').value,
        subject: document.getElementById('tplSubject').value.trim(),
        content: document.getElementById('tplContent').value.trim(),
        meta_template_id: document.getElementById('tplMetaId').value.trim(),
        dlt_template_id: document.getElementById('tplDltId').value.trim(),
        variables_json: extractVariables(document.getElementById('tplContent').value)
    };

    fetch('/api/notifications.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            window.DTNotifications.showToast('Template saved successfully!');
            closeTemplateModal();
            setTimeout(() => window.location.reload(), 700);
        } else {
            window.DTNotifications.showToast('Error: ' + (data.error || 'Failed to save'), 'error');
        }
    })
    .catch(err => window.DTNotifications.showToast(err.message, 'error'))
    .finally(() => {
        btn.disabled = false;
        btn.textContent = 'Save Template';
    });
}
function extractVariables(text) {
    const matches = text.match(/\{\{([a-zA-Z0-9_]+)\}\}/g);
    if (!matches) return [];
    return [...new Set(matches.map(m => m.replace(/[\{\}]/g, '')))];
}
function deleteTemplateConfirm(id, title) {
    if (!confirm(`Are you sure you want to delete template "${title}"?`)) return;
    fetch('/api/notifications.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'delete_template', id: id })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            window.DTNotifications.showToast('Template deleted');
            setTimeout(() => window.location.reload(), 600);
        }
    });
}
function testTemplateSend(t) {
    document.getElementById('testChannel').value = t.channel;
    document.getElementById('testTplKey').value = t.template_key;
    document.getElementById('testModalTplName').textContent = t.title;
    const recInp = document.getElementById('testRecipient');
    if (t.channel === 'whatsapp' || t.channel === 'sms') {
        recInp.placeholder = '+91 98201 12345';
        recInp.value = '+91 98201 12345';
    } else if (t.channel === 'email') {
        recInp.placeholder = 'buyer@boutique.in';
        recInp.value = 'buyer@boutique.in';
    } else {
        recInp.placeholder = 'all_devices';
        recInp.value = 'all_devices';
    }
    const m = document.getElementById('testSendModal');
    if (m) m.style.display = 'flex';
}
function closeTestSendModal() {
    const m = document.getElementById('testSendModal');
    if (m) m.style.display = 'none';
}
function handleExecuteTestSend(e) {
    e.preventDefault();
    const ch = document.getElementById('testChannel').value;
    const key = document.getElementById('testTplKey').value;
    const rec = document.getElementById('testRecipient').value.trim();
    const btn = document.getElementById('btnExecuteTestSend');

    const vars = {
        customer_name: document.getElementById('testVarCustomer').value,
        order_no: document.getElementById('testVarOrder').value,
        amount: document.getElementById('testVarAmount').value,
        courier: document.getElementById('testVarCourier').value,
        tracking_no: 'DL98234112',
        tracking_url: 'https://jaihanumantex.in/track'
    };

    window.DTNotifications.sendTest(ch, rec, key, vars, { recipient_name: vars.customer_name }, btn)
    .then(() => {
        closeTestSendModal();
    });
}
</script>
</body>
</html>
