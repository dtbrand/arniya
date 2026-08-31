<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admins.php — Administrator Accounts Roster
 * DT Brand's & Jai Hanuman Tex
 *
 * Was a single hardcoded "Gautam Sethi" row plus a toast-only Invite button.
 * Now lists the real staff accounts from the users table and routes account
 * creation through the working modal on users/index.php.
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "Administrator Accounts Roster";
$active_nav = "users";

$admins = [];
$pdoAdm = Database::getConnection();
if ($pdoAdm !== null && !Database::isMockMode()) {
    try {
        $admins = Database::query(
            "SELECT id, name, email, role, status, last_login
             FROM users
             ORDER BY (role = 'super_admin') DESC, id ASC"
        );
    } catch (\Throwable $e) {
        $admins = [];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Accounts Roster - DT Brand's Admin</title>
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
                        <span>Administrator Accounts Roster</span>
                        <span class="adm-badge gold"><?php echo count($admins); ?> Accounts</span>
                    </h1>
                    <p class="adm-page-subtitle">All staff accounts, highest privilege first.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/users/" class="adm-btn-secondary">← Back to Users Suite</a>
                </div>
            </div>

            <div class="adm-table-card">
                <div class="adm-table-toolbar">
                    <div><h3 style="font-size:1.05rem; font-weight:800;">Admin Accounts</h3></div>
                    <a class="adm-btn-primary" href="/admin/users/">+ Invite Admin</a>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Last Login</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($admins)): ?>
                                <tr><td colspan="5" style="padding:20px; text-align:center; color:#64748B;">No accounts on file. Add one from the Users page.</td></tr>
                            <?php else: ?>
                                <?php foreach ($admins as $a): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars((string)$a['name']) ?></strong></td>
                                    <td><?= htmlspecialchars((string)$a['email']) ?></td>
                                    <td><span class="adm-badge <?= $a['role'] === 'super_admin' ? 'gold' : 'info' ?>"><?= htmlspecialchars(ucfirst((string)$a['role'])) ?></span></td>
                                    <td><?= !empty($a['last_login']) ? htmlspecialchars(date('d M Y, h:i A', strtotime((string)$a['last_login']))) : 'Never' ?></td>
                                    <td><span class="adm-badge <?= ($a['status'] ?? '') === 'active' ? 'success' : '' ?>"><?= htmlspecialchars(ucfirst((string)$a['status'])) ?></span></td>
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
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>