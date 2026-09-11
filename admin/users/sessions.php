<?php
/**
 * sessions.php — Active Admin Sessions & Device Handshake Console
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
$page_title = "Active Admin Sessions & Security Devices";
$active_nav = "users";
$current_subnav = "sessions";

$sessions = $secManager->getActiveSessions();
$sessionRole = strtolower((string)($_SESSION['admin_user']['role'] ?? $_SESSION['admin_role'] ?? 'admin'));
$isSuper = ($sessionRole === 'super_admin');
$currentSessionId = session_id();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Admin Sessions - DT Brand's Admin</title>
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
                        <span>Active Admin Sessions &amp; Handshakes</span>
                        <span class="dt-badge success"><?php echo count($sessions); ?> Live Devices</span>
                    </h1>
                    <p class="adm-page-subtitle">Real-time inspection of active browser sessions, IP origins, and immediate device revocation.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px;">
                    <a href="/admin/users/" class="dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        Security Hub
                    </a>
                    <button type="button" onclick="dtRevokeAllOtherSessions()" class="dt-btn-danger">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        Revoke All Other Sessions
                    </button>
                </div>
            </div>

            <!-- Sessions List Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title">Live Handshake Devices</h3>
                    <span style="font-size:0.75rem; color:#64748B;">Revoking a session invalidates the authentication token immediately.</span>
                </div>

                <div style="padding:16px 20px;">
                    <?php if (empty($sessions)): ?>
                    <div style="text-align:center; padding:32px; color:#64748B;">No active sessions found.</div>
                    <?php else: ?>
                    <?php foreach ($sessions as $s): ?>
                    <div class="dt-session-row <?php echo !empty($s['is_current']) ? 'current' : ''; ?>">
                        <div class="dt-session-info">
                            <div class="dt-session-device-icon">
                                <?php if (($s['device_type'] ?? '') === 'mobile'): ?>
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                                <?php elseif (($s['device_type'] ?? '') === 'tablet'): ?>
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                                <?php else: ?>
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                                <?php endif; ?>
                            </div>
                            <div>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <strong style="font-size:0.95rem; color:#111827;"><?php echo htmlspecialchars((string)$s['user_name']); ?></strong>
                                    <span class="dt-badge <?php echo $s['role'] === 'super_admin' ? 'gold' : 'info'; ?>">
                                        <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', (string)$s['role']))); ?>
                                    </span>
                                    <?php if (!empty($s['is_current'])): ?>
                                    <span class="dt-badge success" style="font-size:0.68rem;">Current Session</span>
                                    <?php endif; ?>
                                </div>
                                <div style="font-size:0.78rem; color:#64748B; margin-top:3px; display:flex; gap:12px; flex-wrap:wrap;">
                                    <span><strong>Browser:</strong> <?php echo htmlspecialchars((string)($s['browser'] ?? 'Browser')); ?></span>
                                    <span><strong>IP:</strong> <?php echo htmlspecialchars((string)$s['ip_address']); ?></span>
                                    <span><strong>Location:</strong> <?php echo htmlspecialchars((string)($s['location'] ?? 'India')); ?></span>
                                    <span><strong>Active:</strong> <?php echo htmlspecialchars((string)$s['timeago']); ?></span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <?php if (!empty($s['is_current'])): ?>
                            <span style="font-size:0.75rem; color:#15803D; font-weight:700; padding:6px 12px; background:#DCFCE7; border-radius:6px;">Active Handshake</span>
                            <?php else: ?>
                            <button type="button" onclick="dtRevokeSession('<?php echo htmlspecialchars((string)$s['session_id']); ?>')" class="dt-btn-danger">
                                Revoke Session
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Session Hygiene Notice -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title">Session Hygiene &amp; Security Controls</h3>
                </div>
                <div style="padding:16px 20px; font-size:0.83rem; color:#475569; line-height:1.6;">
                    Sessions remain active for 24 hours of idle timeout or until explicit logout/revocation.
                    Password modifications automatically invalidate all concurrent sessions across all devices for that administrator account.
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/users/users.js?v=<?php echo time(); ?>"></script>
</body>
</html>
