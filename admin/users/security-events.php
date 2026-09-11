<?php
/**
 * security-events.php — Security Events, Forensics & Threat Intelligence
 * DT Brand's & Jai Hanuman Tex
 * Section 34: Admin Users / Roles / Permissions
 */

$__dtg = __DIR__ . '/../includes/adminguard.php';
if (!is_file($__dtg)) {
    $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php';
}
if (is_file($__dtg)) require_once $__dtg;

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/AdminSecurityManager.php';

use DTBrand\AdminSecurityManager;

$secManager = AdminSecurityManager::getInstance();
$page_title = "Security Events & Threat Intelligence";
$active_nav = "users";
$current_subnav = "security-events";

$categoryFilter = trim((string)($_GET['category'] ?? 'all'));
$severityFilter = trim((string)($_GET['severity'] ?? 'all'));

$filters = [
    'category' => $categoryFilter,
    'severity' => $severityFilter,
    'limit'    => 100
];

$events = $secManager->getSecurityEvents($filters);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Events & Threat Intelligence - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/users/users.css?v=<?php echo time(); ?>">
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
                        <span>Security Events &amp; Threat Intelligence</span>
                        <span class="dt-badge gold"><?php echo count($events); ?> Logged Events</span>
                    </h1>
                    <p class="adm-page-subtitle">Real-time telemetry of policy alterations, credential modifications, and potential security anomalies.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px;">
                    <a href="/admin/users/" class="dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        Security Hub
                    </a>
                    <a href="/api/admin_security.php?action=export_logs&type=events&format=csv" class="dt-btn-gold">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Export CSV
                    </a>
                </div>
            </div>

            <!-- Filter Toolbar Card -->
            <div class="adm-card" style="margin-bottom:20px;">
                <form method="GET" style="padding:14px 20px; display:flex; gap:14px; align-items:center; flex-wrap:wrap;">
                    <div style="min-width:180px;">
                        <label style="display:block; font-size:0.72rem; font-weight:700; color:#64748B; margin-bottom:4px; text-transform:uppercase;">Severity</label>
                        <select name="severity" class="dt-sec-select" onchange="this.form.submit()">
                            <option value="all" <?php echo $severityFilter === 'all' ? 'selected' : ''; ?>>All Severities</option>
                            <option value="info" <?php echo $severityFilter === 'info' ? 'selected' : ''; ?>>Info</option>
                            <option value="warning" <?php echo $severityFilter === 'warning' ? 'selected' : ''; ?>>Warning</option>
                            <option value="critical" <?php echo $severityFilter === 'critical' ? 'selected' : ''; ?>>Critical</option>
                        </select>
                    </div>
                    <div style="min-width:200px;">
                        <label style="display:block; font-size:0.72rem; font-weight:700; color:#64748B; margin-bottom:4px; text-transform:uppercase;">Category</label>
                        <select name="category" class="dt-sec-select" onchange="this.form.submit()">
                            <option value="all" <?php echo $categoryFilter === 'all' ? 'selected' : ''; ?>>All Categories</option>
                            <option value="auth" <?php echo $categoryFilter === 'auth' ? 'selected' : ''; ?>>Authentication</option>
                            <option value="security_policy" <?php echo $categoryFilter === 'security_policy' ? 'selected' : ''; ?>>Security Policy</option>
                            <option value="session_revoked" <?php echo $categoryFilter === 'session_revoked' ? 'selected' : ''; ?>>Session Revocation</option>
                            <option value="role_changed" <?php echo $categoryFilter === 'role_changed' ? 'selected' : ''; ?>>Role Alteration</option>
                            <option value="password_changed" <?php echo $categoryFilter === 'password_changed' ? 'selected' : ''; ?>>Password Alteration</option>
                            <option value="account_created" <?php echo $categoryFilter === 'account_created' ? 'selected' : ''; ?>>Account Creation</option>
                            <option value="account_deactivated" <?php echo $categoryFilter === 'account_deactivated' ? 'selected' : ''; ?>>Account Deactivation</option>
                            <option value="brute_force_alert" <?php echo $categoryFilter === 'brute_force_alert' ? 'selected' : ''; ?>>Brute Force Detection</option>
                            <option value="sensitive_export" <?php echo $categoryFilter === 'sensitive_export' ? 'selected' : ''; ?>>Sensitive Export</option>
                        </select>
                    </div>
                    <div style="margin-top:18px;">
                        <button type="submit" class="dt-btn-gold">Apply</button>
                        <?php if ($severityFilter !== 'all' || $categoryFilter !== 'all'): ?>
                        <a href="/admin/users/security-events.php" class="dt-btn-pale" style="margin-left:6px;">Reset</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Events Ledger Card -->
            <div class="adm-card">
                <div class="adm-table-responsive" style="padding:0;">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Category &amp; Severity</th>
                                <th>Description &amp; Context</th>
                                <th>Responsible Actor</th>
                                <th>Client IP</th>
                                <th style="text-align:right;">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($events)): ?>
                            <tr><td colspan="5" style="text-align:center; padding:28px; color:#64748B;">No security events found matching criteria.</td></tr>
                            <?php else: ?>
                            <?php foreach ($events as $e): ?>
                            <tr>
                                <td>
                                    <div style="display:flex; align-items:center; gap:6px;">
                                        <span class="dt-badge <?php echo $e['severity'] === 'critical' ? 'danger' : ($e['severity'] === 'warning' ? 'warning' : 'info'); ?>">
                                            <?php echo strtoupper((string)$e['severity']); ?>
                                        </span>
                                        <span style="font-size:0.75rem; font-weight:700; color:#334155;">
                                            <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', (string)$e['category']))); ?>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight:700; color:#111827; font-size:0.86rem;">
                                        <?php echo htmlspecialchars((string)$e['description']); ?>
                                    </div>
                                    <?php if (!empty($e['meta'])): ?>
                                    <div style="font-size:0.72rem; color:#64748B; margin-top:2px;">
                                        <code><?php echo htmlspecialchars(json_encode($e['meta'], JSON_UNESCAPED_SLASHES)); ?></code>
                                    </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="font-weight:700; color:#1F2937; font-size:0.82rem;">
                                        <?php echo htmlspecialchars((string)$e['actor_name']); ?>
                                    </div>
                                    <?php if (!empty($e['actor_id'])): ?>
                                    <div style="font-size:0.7rem; color:#94A3B8;">User #<?php echo (int)$e['actor_id']; ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <code style="background:#F1F5F9; padding:2px 6px; border-radius:4px; font-size:0.8rem; color:#334155;">
                                        <?php echo htmlspecialchars((string)$e['ip_address']); ?>
                                    </code>
                                </td>
                                <td style="text-align:right;">
                                    <div style="font-weight:600; font-size:0.82rem; color:#1F2937;"><?php echo htmlspecialchars((string)$e['timeago']); ?></div>
                                    <div style="font-size:0.72rem; color:#94A3B8;"><?php echo date('d M Y, h:i A', strtotime((string)$e['created_at'])); ?></div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/users/users.js?v=<?php echo time(); ?>"></script>
</body>
</html>
