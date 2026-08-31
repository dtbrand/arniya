<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * roles.php — Role & Permission Reference
 * DT Brand's & Jai Hanuman Tex
 *
 * The previous page displayed a three-line description and a "Save Roles"
 * button whose only behaviour was a toast — the schema has no editable
 * permission table, so nothing could have been saved. This page now shows
 * the four roles the `users.role` ENUM actually supports, lists how many
 * live accounts hold each, and states honestly what each role can do in
 * this application (including the API-level super_admin gate).
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "Role & Granular Permission Matrix";
$active_nav = "users";

$roleCounts = ['super_admin' => 0, 'admin' => 0, 'manager' => 0, 'staff' => 0];
$pdoRoles = Database::getConnection();
if ($pdoRoles !== null && !Database::isMockMode()) {
    try {
        foreach (Database::query('SELECT role, COUNT(*) AS c FROM users GROUP BY role') as $r) {
            if (array_key_exists($r['role'], $roleCounts)) {
                $roleCounts[$r['role']] = (int)$r['c'];
            }
        }
    } catch (\Throwable $e) {
    }
}

$roles = [
    [
        'key' => 'super_admin', 'label' => 'Super Admin', 'count' => $roleCounts['super_admin'],
        'scope' => 'Everything, plus staff management',
        'can' => ['All modules below', 'Create / edit / delete staff accounts (api/users.php)', 'Reset staff passwords', 'Cannot be demoted or deleted while it is the last super_admin'],
    ],
    [
        'key' => 'admin', 'label' => 'Administrator', 'count' => $roleCounts['admin'],
        'scope' => 'All commerce modules',
        'can' => ['Products, catalogue, orders, customers, reviews', 'Media uploads and CSV import/export', 'Cannot manage staff accounts (read-only roster)'],
    ],
    [
        'key' => 'manager', 'label' => 'Manager', 'count' => $roleCounts['manager'],
        'scope' => 'Operations focus',
        'can' => ['Orders, inventory, shipping workflows', 'Customer directory access', 'Cannot manage staff accounts'],
    ],
    [
        'key' => 'staff', 'label' => 'Staff', 'count' => $roleCounts['staff'],
        'scope' => 'Day-to-day desk',
        'can' => ['Order processing and status updates', 'Customer lookup and WhatsApp connect', 'Cannot manage staff accounts'],
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role & Permission Matrix - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
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
                        <span>Role &amp; Permission Matrix</span>
                        <span class="adm-badge gold">Reference</span>
                    </h1>
                    <p class="adm-page-subtitle">The four roles the application enforces, and who holds them right now.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/users/" class="adm-btn-secondary">← Back to Users Suite</a>
                </div>
            </div>

            <?php foreach ($roles as $r): ?>
            <div class="adm-card" style="margin-bottom:14px;">
                <div class="adm-card-head">
                    <h3 class="adm-card-title">
                        <span><?= htmlspecialchars($r['label']) ?></span>
                        <span class="adm-badge <?= $r['key'] === 'super_admin' ? 'gold' : 'info' ?>"><?= (int)$r['count'] ?> account<?= $r['count'] === 1 ? '' : 's' ?></span>
                    </h3>
                    <span style="font-size:11.5px; color:#78716C; font-weight:700;"><?= htmlspecialchars($r['scope']) ?></span>
                </div>
                <div style="padding:12px 18px 16px;">
                    <ul style="margin:0; padding-left:18px; font-size:12.5px; color:#2c3338; line-height:1.7;">
                        <?php foreach ($r['can'] as $c): ?><li><?= htmlspecialchars($c) ?></li><?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endforeach; ?>

            <p style="font-size:11.5px; color:#94A3B8;">Role assignments are set per account on the <a href="/admin/users/" style="color:#8A681F;">Users</a> page by a Super Admin. There is no separate editable permission table — this page reflects exactly what the code enforces.</p>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>