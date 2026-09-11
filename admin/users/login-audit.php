<?php
/**
 * login-audit.php — Administrative Login Audit Ledger & Brute-Force Monitor
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
$page_title = "Admin Login Audit Ledger";
$active_nav = "users";
$current_subnav = "login-audit";

$statusFilter = trim((string)($_GET['status'] ?? 'all'));
$searchQuery = trim((string)($_GET['search'] ?? ''));

$filters = [
    'status' => $statusFilter,
    'search' => $searchQuery,
    'limit'  => 100
];

$logins = $secManager->getLoginAudit($filters);
$stats = $secManager->getLoginStats();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Audit Ledger - DT Brand's Admin</title>
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
                        <span>Admin Login Audit Ledger</span>
                        <span class="dt-badge gold"><?php echo (int)$stats['total']; ?> Total Records</span>
                    </h1>
                    <p class="adm-page-subtitle">Chronological ledger of administrative authentication handshakes, failures, and threat forensics.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px;">
                    <a href="/admin/users/" class="dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        Security Hub
                    </a>
                    <a href="/api/admin_security.php?action=export_logs&type=login&format=csv" class="dt-btn-gold">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Export CSV
                    </a>
                </div>
            </div>

            <!-- Mini KPI Cards -->
            <div class="dt-kpi-grid" style="margin-bottom:20px;">
                <div class="dt-kpi-card emerald-border" style="padding:16px;">
                    <div>
                        <div class="dt-kpi-title">24h Successful Logins</div>
                        <div class="dt-kpi-value" style="font-size:1.4rem; color:#15803D;"><?php echo (int)$stats['success_24h']; ?></div>
                    </div>
                </div>
                <div class="dt-kpi-card crimson-border" style="padding:16px;">
                    <div>
                        <div class="dt-kpi-title">24h Failed Attempts</div>
                        <div class="dt-kpi-value" style="font-size:1.4rem; color:#DC2626;"><?php echo (int)$stats['failed_24h']; ?></div>
                    </div>
                </div>
                <div class="dt-kpi-card gold-border" style="padding:16px;">
                    <div>
                        <div class="dt-kpi-title">Unique IP Addresses</div>
                        <div class="dt-kpi-value" style="font-size:1.4rem; color:#8A681F;"><?php echo (int)$stats['unique_ips_24h']; ?></div>
                    </div>
                </div>
            </div>

            <!-- Filter Toolbar Card -->
            <div class="adm-card" style="margin-bottom:20px;">
                <form method="GET" style="padding:14px 20px; display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
                    <div style="flex:1; min-width:220px;">
                        <input type="text" name="search" value="<?php echo htmlspecialchars($searchQuery); ?>" class="dt-sec-input" placeholder="Filter identity email or IP address...">
                    </div>
                    <div style="min-width:160px;">
                        <select name="status" class="dt-sec-select" onchange="this.form.submit()">
                            <option value="all" <?php echo $statusFilter === 'all' ? 'selected' : ''; ?>>All Outcomes</option>
                            <option value="success" <?php echo $statusFilter === 'success' ? 'selected' : ''; ?>>Success Only</option>
                            <option value="failed_password" <?php echo $statusFilter === 'failed_password' ? 'selected' : ''; ?>>Failed Password</option>
                            <option value="account_inactive" <?php echo $statusFilter === 'account_inactive' ? 'selected' : ''; ?>>Account Inactive</option>
                            <option value="user_not_found" <?php echo $statusFilter === 'user_not_found' ? 'selected' : ''; ?>>User Not Found</option>
                        </select>
                    </div>
                    <button type="submit" class="dt-btn-gold">Filter</button>
                    <?php if ($statusFilter !== 'all' || $searchQuery !== ''): ?>
                    <a href="/admin/users/login-audit.php" class="dt-btn-pale">Reset</a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Audit Table Card -->
            <div class="adm-card">
                <div class="adm-table-responsive" style="padding:0;">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Identity Attempted</th>
                                <th>Authentication Outcome</th>
                                <th>Failure Reason</th>
                                <th>Origin IP</th>
                                <th>Client Environment</th>
                                <th style="text-align:right;">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($logins)): ?>
                            <tr><td colspan="6" style="text-align:center; padding:28px; color:#64748B;">No login records found matching criteria.</td></tr>
                            <?php else: ?>
                            <?php foreach ($logins as $l): ?>
                            <tr>
                                <td>
                                    <strong style="color:#111827;"><?php echo htmlspecialchars((string)$l['attempted_identity']); ?></strong>
                                    <?php if (!empty($l['user_id'])): ?>
                                    <span style="font-size:0.72rem; color:#64748B; margin-left:4px;">(ID #<?php echo (int)$l['user_id']; ?>)</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($l['status'] === 'success'): ?>
                                    <span class="dt-badge success">Authorized</span>
                                    <?php elseif ($l['status'] === 'failed_password'): ?>
                                    <span class="dt-badge danger">Bad Password</span>
                                    <?php elseif ($l['status'] === 'account_inactive'): ?>
                                    <span class="dt-badge warning">Deactivated</span>
                                    <?php else: ?>
                                    <span class="dt-badge info"><?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', (string)$l['status']))); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td style="font-size:0.8rem; color:#64748B;">
                                    <?php echo !empty($l['failure_reason']) ? htmlspecialchars((string)$l['failure_reason']) : '—'; ?>
                                </td>
                                <td>
                                    <code style="background:#F1F5F9; padding:2px 6px; border-radius:4px; font-size:0.8rem; color:#334155;">
                                        <?php echo htmlspecialchars((string)$l['ip_address']); ?>
                                    </code>
                                </td>
                                <td style="font-size:0.8rem; color:#475569;">
                                    <?php echo htmlspecialchars((string)($l['browser'] ?? 'Browser')); ?>
                                </td>
                                <td style="text-align:right;">
                                    <div style="font-weight:600; font-size:0.82rem; color:#1F2937;"><?php echo htmlspecialchars((string)$l['timeago']); ?></div>
                                    <div style="font-size:0.72rem; color:#94A3B8;"><?php echo date('d M Y, h:i A', strtotime((string)$l['created_at'])); ?></div>
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
