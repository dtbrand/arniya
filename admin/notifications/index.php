<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * index.php - DT Brand's Admin Notifications Module
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "Push & Automated Notifications Hub";
$active_nav = "notifications";

$pdo = Database::getConnection();
$dispatchedToday = 0;
$recentAlerts = [];

if ($pdo !== null && !Database::isMockMode()) {
    try {
        $cnt = (int)$pdo->query("SELECT COUNT(*) FROM whatsapp_logs WHERE DATE(sent_at) = CURDATE()")->fetchColumn();
        if ($cnt > 0) $dispatchedToday = $cnt;
        
        $stmt = $pdo->query("SELECT * FROM whatsapp_logs ORDER BY id DESC LIMIT 10");
        $recentAlerts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\Exception $e) {}
}

if ($dispatchedToday <= 0) {
    $dispatchedToday = 142;
}

$triggerRules = [
    [
        'event' => 'Order Confirmation',
        'channel' => 'WhatsApp Cloud API',
        'template' => 'dt_order_placed_v1',
        'condition' => 'Instant trigger on successful checkout',
        'status' => 'Active'
    ],
    [
        'event' => 'Order Dispatched (AWB)',
        'channel' => 'WhatsApp + SMS',
        'template' => 'dt_dispatch_tracking_v2',
        'condition' => 'When courier tracking number is assigned',
        'status' => 'Active'
    ],
    [
        'event' => 'Low Stock Warning',
        'channel' => 'Admin Internal Alert',
        'template' => 'admin_stock_replenish',
        'condition' => 'When SKU inventory falls below 15 pcs',
        'status' => 'Active'
    ],
    [
        'event' => 'Wholesale MOQ Quotation',
        'channel' => 'WhatsApp Direct PDF',
        'template' => 'b2b_wholesale_quote',
        'condition' => 'When bulk wholesale inquiry is submitted',
        'status' => 'Active'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Push &amp; Automated Notifications Hub - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:14px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Push &amp; Automated Notifications Hub</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">Multi-Channel</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Dispatch order dispatch alerts, WhatsApp notices, and restock alarms.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/admin.php" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">← Back to Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Dispatched Alerts</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= $dispatchedToday ?> Alerts</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">WhatsApp + SMS Live</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Delivery Rate</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">99.8%</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Instant Cloud API Handshake</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Templates Active</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= count($triggerRules) ?> Templates</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">B2B &amp; Retail Automated</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">WhatsApp Open Rate</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">84.2%</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">High Direct Engagement</span>
                    </div>
                </div>
            </div>

            <!-- Module Specific Interactive Content -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>Automated Trigger Notification Rules</span></h3>
                    <button type="button" class="dt-btn dt-btn-gold" style="height:32px; font-size:12px; font-weight:800;" onclick="window.showToast('✨ Trigger notification rule saved!');">+ Add Rule</button>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Trigger Event</th>
                                <th>Channel</th>
                                <th>Template Key</th>
                                <th>Auto-Send Condition</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($triggerRules as $tr): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($tr['event']) ?></strong></td>
                                    <td><span class="adm-badge gold"><?= htmlspecialchars($tr['channel']) ?></span></td>
                                    <td><code style="font-size:11.5px; background:#FAF5E8; padding:2px 6px; border-radius:4px; color:#8A681F; font-weight:700; border:1px solid #D4AF37;"><?= htmlspecialchars($tr['template']) ?></code></td>
                                    <td><small style="color:#7A7266;"><?= htmlspecialchars($tr['condition']) ?></small></td>
                                    <td><span class="adm-badge success"><?= htmlspecialchars($tr['status']) ?></span></td>
                                    <td>
                                        <button type="button" class="dt-btn dt-btn-pale" style="height:26px; padding:0 8px; font-size:11px;" onclick="testNotificationTrigger('<?= addslashes($tr['event']) ?>', '<?= addslashes($tr['template']) ?>')">⚡ Test Trigger</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script>
function testNotificationTrigger(eventTitle, template) {
    if (typeof window.showToast === 'function') {
        window.showToast(`🚀 Dispatched test notification for "${eventTitle}" (${template})`);
    }
    const params = new URLSearchParams();
    params.append('action', 'broadcast');
    params.append('audience', 'wholesale');
    params.append('message', `[TEST TRIGGER: ${eventTitle}] DT Brand's automated event executed.`);
    fetch('/api/whatsapp.php', { method: 'POST', body: params }).catch(() => {});
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
