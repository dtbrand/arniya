<?php
/**
 * permissions.php — Granular Role-Permission Matrix Studio
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
$page_title = "Granular Role-Permission Matrix Studio";
$active_nav = "users";
$current_subnav = "permissions";

$roles = $secManager->getRoles();
$currentRoleSlug = strtolower(trim((string)($_GET['role'] ?? 'admin')));
$roleSlugs = array_column($roles, 'slug');
if (!in_array($currentRoleSlug, $roleSlugs, true)) {
    $currentRoleSlug = 'admin';
}

$modules = AdminSecurityManager::MODULES;
$actions = AdminSecurityManager::ACTIONS;
$assignedPerms = $secManager->getRolePermissions($currentRoleSlug);

$sessionRole = strtolower((string)($_SESSION['admin_user']['role'] ?? $_SESSION['admin_role'] ?? 'admin'));
$isSuper = ($sessionRole === 'super_admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Granular Permissions Matrix - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/users/users.css?v=<?php echo time(); ?>">
    <style>
    .dt-role-tab {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 18px;
        background: #FFFFFF;
        border: 1px solid #CBD5E1;
        border-radius: 8px 8px 0 0;
        font-weight: 700;
        font-size: 0.85rem;
        color: #475569;
        text-decoration: none;
        transition: all 0.2s ease;
        margin-right: 4px;
    }
    .dt-role-tab:hover {
        background: #F8FAFC;
        color: #111827;
    }
    .dt-role-tab.active {
        background: #FFFFFF;
        border-color: #D4AF37;
        border-bottom: 2px solid #FFFFFF;
        color: #8A681F;
        position: relative;
        z-index: 2;
        box-shadow: 0 -2px 6px rgba(212, 175, 55, 0.1);
    }
    </style>
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
                        <span>Granular Permissions Matrix Studio</span>
                        <span class="dt-badge gold">16 Actions &times; 14 Modules</span>
                    </h1>
                    <p class="adm-page-subtitle">Configure exact module action authorizations for each administrative role tier.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px;">
                    <a href="/admin/users/roles.php" class="dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        Roles Roster
                    </a>
                    <?php if ($isSuper && $currentRoleSlug !== 'super_admin'): ?>
                    <button type="button" id="btnSavePerms" onclick="dtSavePermissionsMatrix('<?php echo htmlspecialchars($currentRoleSlug); ?>')" class="dt-btn-gold">
                        Save Permission Matrix
                    </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Role Selector Tabs -->
            <div style="display:flex; border-bottom:1px solid #CBD5E1; margin-bottom:-1px; overflow-x:auto;">
                <?php foreach ($roles as $r): ?>
                <a href="?role=<?php echo urlencode($r['slug']); ?>" class="dt-role-tab <?php echo $currentRoleSlug === $r['slug'] ? 'active' : ''; ?>">
                    <?php echo htmlspecialchars($r['name']); ?>
                    <span class="dt-badge <?php echo $r['slug'] === 'super_admin' ? 'gold' : 'info'; ?>" style="font-size:0.7rem; padding:1px 6px;">
                        <?php echo (int)$r['user_count']; ?>
                    </span>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Permission Matrix Container -->
            <div class="adm-card" style="border-radius:0 8px 8px 8px; border-top-color:#D4AF37;">
                
                <!-- Notice Banner -->
                <div style="padding:14px 20px; background:#FAF5E8; border-bottom:1px solid #E6CA65; display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <strong style="color:#705114; font-size:0.9rem;">
                            Role Scope: <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $currentRoleSlug))); ?>
                        </strong>
                        <div style="font-size:0.76rem; color:#8A681F; margin-top:2px;">
                            <?php if ($currentRoleSlug === 'super_admin'): ?>
                            Super Admin possesses global permanent authorization across all actions. Matrix is read-only bypass.
                            <?php else: ?>
                            Toggle authorized capabilities for this role below. Changes apply across all staff holding this tier.
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($currentRoleSlug !== 'super_admin' && $isSuper): ?>
                    <div style="display:flex; gap:8px;">
                        <button type="button" onclick="dtToggleAllPermissions(true)" class="dt-btn-pale" style="font-size:0.75rem; padding:4px 10px;">Select All</button>
                        <button type="button" onclick="dtToggleAllPermissions(false)" class="dt-btn-pale" style="font-size:0.75rem; padding:4px 10px;">Clear All</button>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Matrix Table -->
                <div class="adm-table-responsive" style="padding:0; max-height:600px; overflow-y:auto;">
                    <table class="dt-perm-table">
                        <thead>
                            <tr>
                                <th style="min-width:180px;">Module Area</th>
                                <?php foreach ($actions as $act => $actDesc): ?>
                                <th style="min-width:75px;" title="<?php echo htmlspecialchars($actDesc); ?>">
                                    <div style="text-transform:capitalize;"><?php echo str_replace('_', ' ', $act); ?></div>
                                </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($modules as $mod => $modName): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($modName); ?></strong>
                                    <div style="font-size:0.7rem; color:#94A3B8;"><?php echo htmlspecialchars($mod); ?></div>
                                </td>
                                <?php foreach ($actions as $act => $actDesc): ?>
                                <?php 
                                    $isAllowed = false;
                                    if ($currentRoleSlug === 'super_admin') {
                                        $isAllowed = true;
                                    } elseif (isset($assignedPerms[$mod]) && in_array($act, $assignedPerms[$mod], true)) {
                                        $isAllowed = true;
                                    }
                                    $isDisabled = ($currentRoleSlug === 'super_admin' || !$isSuper);
                                ?>
                                <td>
                                    <input type="checkbox" 
                                           class="dt-perm-checkbox" 
                                           data-module="<?php echo htmlspecialchars($mod); ?>" 
                                           data-action="<?php echo htmlspecialchars($act); ?>"
                                           <?php echo $isAllowed ? 'checked' : ''; ?>
                                           <?php echo $isDisabled ? 'disabled' : ''; ?>
                                           title="<?php echo htmlspecialchars("{$act} on {$mod}"); ?>">
                                </td>
                                <?php endforeach; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Bottom Action Bar -->
                <?php if ($currentRoleSlug !== 'super_admin' && $isSuper): ?>
                <div style="padding:16px 20px; background:#FAFAFA; border-top:1px solid #E2E8F0; display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:0.78rem; color:#64748B;">
                        Policy enforcement is immediate upon saving. Logged-in staff will adopt new authorizations dynamically.
                    </span>
                    <button type="button" onclick="dtSavePermissionsMatrix('<?php echo htmlspecialchars($currentRoleSlug); ?>')" class="dt-btn-gold">
                        Save Permission Matrix
                    </button>
                </div>
                <?php endif; ?>

            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/users/users.js?v=<?php echo time(); ?>"></script>
</body>
</html>
