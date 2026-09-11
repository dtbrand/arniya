<?php
/**
 * roles.php — Admin Roles & Privilege Hierarchy Manager
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
$page_title = "Admin Roles & Privilege Hierarchy";
$active_nav = "users";
$current_subnav = "roles";

$roles = $secManager->getRoles();
$sessionRole = strtolower((string)($_SESSION['admin_user']['role'] ?? $_SESSION['admin_role'] ?? 'admin'));
$isSuper = ($sessionRole === 'super_admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Roles & Privilege Hierarchy - DT Brand's Admin</title>
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
                        <span>Admin Roles &amp; Hierarchy</span>
                        <span class="dt-badge gold"><?php echo count($roles); ?> Standard Roles</span>
                    </h1>
                    <p class="adm-page-subtitle">Separation of administrative responsibilities, operational domains, and staff scopes.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px;">
                    <a href="/admin/users/" class="dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        Security Hub
                    </a>
                    <a href="/admin/users/permissions.php" class="dt-btn-gold">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        Permissions Matrix Studio
                    </a>
                </div>
            </div>

            <!-- Role Cards Grid -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:18px; margin-bottom:24px;">
                <?php foreach ($roles as $r): ?>
                <div class="adm-card" style="margin-bottom:0; display:flex; flex-direction:column; justify-content:space-between;">
                    <div style="padding:20px;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                            <div>
                                <h3 style="font-size:1.1rem; font-weight:800; color:#111827; margin:0 0 4px 0;">
                                    <?php echo htmlspecialchars($r['name']); ?>
                                </h3>
                                <span class="dt-badge <?php echo $r['slug'] === 'super_admin' ? 'gold' : 'info'; ?>">
                                    <?php echo htmlspecialchars($r['slug']); ?>
                                </span>
                            </div>
                            <span class="dt-badge success" style="font-size:0.8rem; padding:4px 10px;">
                                <?php echo (int)$r['user_count']; ?> Account<?php echo $r['user_count'] === 1 ? '' : 's'; ?>
                            </span>
                        </div>

                        <p style="font-size:0.83rem; color:#475569; line-height:1.5; margin:0 0 14px 0;">
                            <?php echo htmlspecialchars($r['description']); ?>
                        </p>

                        <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:6px; padding:10px 12px; margin-bottom:14px;">
                            <div style="font-size:0.72rem; font-weight:700; color:#64748B; text-transform:uppercase; letter-spacing:0.04em;">Operational Scope</div>
                            <div style="font-size:0.85rem; font-weight:700; color:#1E293B; margin-top:2px;">
                                <?php echo htmlspecialchars($r['scope']); ?>
                            </div>
                        </div>
                    </div>

                    <div style="border-top:1px solid #F1F5F9; padding:12px 20px; background:#FAFAFA; border-radius:0 0 12px 12px; display:flex; justify-content:space-between; align-items:center;">
                        <a href="/admin/users/admins.php" style="font-size:0.8rem; font-weight:700; color:#64748B; text-decoration:none;">
                            View Assigned Staff &rarr;
                        </a>
                        <a href="/admin/users/permissions.php?role=<?php echo urlencode($r['slug']); ?>" class="dt-btn-pale" style="padding:4px 10px; font-size:0.78rem;">
                            Configure Permissions
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Role Governance Guidelines -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title">Enterprise Role Hierarchy &amp; Compliance Standard</h3>
                </div>
                <div style="padding:16px 20px; font-size:0.85rem; color:#334155; line-height:1.6;">
                    <ul style="margin:0; padding-left:20px;">
                        <li><strong>Super Admin Explicit Bypass</strong>: The master owner credentials retain permanent global read/write access across all modules without exception.</li>
                        <li><strong>Zero Elevation Escalation</strong>: Staff and operations logins cannot modify permissions, elevate other staff accounts, or access server integration secrets.</li>
                        <li><strong>Separation of Duties</strong>: Wholesaler catalog management, physical stock adjustments, and accounting refunds are partitioned to maintain strict audit integrity.</li>
                    </ul>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/users/users.js?v=<?php echo time(); ?>"></script>
</body>
</html>