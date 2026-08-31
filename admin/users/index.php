<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * index.php — Admin Users & Role Permissions
 * DT Brand's & Jai Hanuman Tex
 *
 * The previous revision was a static mockup: two invented roster rows
 * ("Gautam Sethi / dispatch@…"), KPIs fabricated from nothing ("2 Accounts",
 * "4 Accounts", "1 Active", "2FA Active" — this app has no 2FA), an Invite
 * button that only raised a toast and Edit buttons that edited nothing.
 *
 * Everything now comes from the live `users` table (the same rows
 * Auth::adminLogin authenticates against) through /api/users.php, which is
 * admin-gated for reads and super-admin-gated for writes.
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "Admin Users & Role Permissions";
$active_nav = "users";

$accounts = [];
$pdoUsers = Database::getConnection();
if ($pdoUsers !== null && !Database::isMockMode()) {
    try {
        $accounts = Database::query(
            "SELECT id, name, email, phone, role, status, last_login, created_at
             FROM users ORDER BY (role = 'super_admin') DESC, id ASC"
        );
    } catch (\Throwable $e) {
        $accounts = [];
    }
}

$superAdmins = 0;
$staff = 0;
$activeLast24h = 0;
foreach ($accounts as $a) {
    if ($a['role'] === 'super_admin') $superAdmins++;
    else $staff++;
    if (!empty($a['last_login']) && strtotime((string)$a['last_login']) > (time() - 86400)) $activeLast24h++;
}

$roleLabels = [
    'super_admin' => 'Super Admin (All Modules)',
    'admin'       => 'Administrator',
    'manager'     => 'Manager',
    'staff'       => 'Staff',
];

$amSuper = strtolower((string)($_SESSION['admin_user']['role'] ?? '')) === 'super_admin';
$myId = (int)($_SESSION['admin_user']['id'] ?? 0);

function dt_users_timeago(?string $ts): string
{
    if (empty($ts)) return 'Never signed in';
    $diff = time() - (int)strtotime($ts);
    if ($diff < 120) return 'Just now';
    if ($diff < 3600) return floor($diff / 60) . ' min ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
    return floor($diff / 86400) . ' days ago';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Users & Role Permissions - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
    .dt-u-modal { display:none; position:fixed; inset:0; background:rgba(15,23,42,0.75); backdrop-filter:blur(4px); z-index:9999999; align-items:center; justify-content:center; }
    .dt-u-input { width:100%; height:34px; padding:0 10px; font-size:12.5px; color:#181512; background:#fff; border:1px solid #c3c4c7; border-radius:5px; box-sizing:border-box; outline:none; }
    .dt-u-input:focus { border-color:#D4AF37 !important; box-shadow:0 0 0 3px rgba(212,175,55,0.18); }
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
                        <span>Admin Users &amp; Role Permissions</span>
                        <span class="adm-badge gold"><?php echo $amSuper ? 'Super Admin' : ucfirst((string)($_SESSION['admin_user']['role'] ?? 'Admin')); ?></span>
                    </h1>
                    <p class="adm-page-subtitle">Manage administrator credentials, manager logins, and staff permissions.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards — live counts -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Super Admins</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?php echo (int)$superAdmins; ?> Account<?php echo $superAdmins === 1 ? '' : 's'; ?></div>
                    <div class="adm-kpi-bottom"><span class="adm-kpi-delta up">Full unrestricted access</span></div>
                </div>

                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Staff / Managers</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?php echo (int)$staff; ?> Account<?php echo $staff === 1 ? '' : 's'; ?></div>
                    <div class="adm-kpi-bottom"><span class="adm-kpi-delta up">Warehouse &amp; dispatch roles</span></div>
                </div>

                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Signed In (24h)</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?php echo (int)$activeLast24h; ?></div>
                    <div class="adm-kpi-bottom"><span class="adm-kpi-delta up">Based on real last_login</span></div>
                </div>

                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Password Security</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">Bcrypt</div>
                    <div class="adm-kpi-bottom"><span class="adm-kpi-delta up">Hashed via password_hash</span></div>
                </div>
            </div>

            <!-- Roster — live rows -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Administrator &amp; Staff Roster</span></h3>
                    <?php if ($amSuper): ?>
                    <button class="adm-btn-primary" onclick="openUserModal('create')">+ Add Admin User</button>
                    <?php endif; ?>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Admin Name</th>
                                <th>Email Address</th>
                                <th>Role &amp; Permissions</th>
                                <th>Last Login</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($accounts)): ?>
                                <tr><td colspan="6" style="padding:22px; text-align:center; color:#64748B;">No staff accounts found in the database yet. Use <strong>Add Admin User</strong> to create the first one.</td></tr>
                            <?php else: ?>
                                <?php foreach ($accounts as $a): $aid = (int)$a['id']; ?>
                                <tr id="user-row-<?= $aid ?>">
                                    <td><strong><?= htmlspecialchars((string)$a['name']) ?></strong><?php if ($aid === $myId): ?><br><small style="color:#8A681F;">You</small><?php endif; ?></td>
                                    <td><?= htmlspecialchars((string)$a['email']) ?></td>
                                    <td><span class="adm-badge <?= $a['role'] === 'super_admin' ? 'gold' : 'info' ?>"><?= htmlspecialchars($roleLabels[$a['role']] ?? $a['role']) ?></span></td>
                                    <td><?= htmlspecialchars(dt_users_timeago((string)($a['last_login'] ?? ''))) ?></td>
                                    <td><span class="adm-badge <?= ($a['status'] ?? '') === 'active' ? 'success' : '' ?>"><?= htmlspecialchars(ucfirst((string)$a['status'])) ?></span></td>
                                    <td>
                                        <?php if ($amSuper): ?>
                                        <button class="adm-btn-secondary adm-btn-sm" onclick='openUserModal("edit", <?= json_encode([
                                            'id' => $aid,
                                            'name' => (string)$a['name'],
                                            'email' => (string)$a['email'],
                                            'role' => (string)$a['role'],
                                            'status' => (string)$a['status'],
                                        ], JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>Edit</button>
                                        <?php if ($aid !== $myId): ?>
                                        <button class="adm-btn-secondary adm-btn-sm" style="color:#B91C1C; border-color:#FECACA;" onclick="deleteUser(<?= $aid ?>, '<?= htmlspecialchars(addslashes((string)$a['name']), ENT_QUOTES) ?>')">Delete</button>
                                        <?php endif; ?>
                                        <?php else: ?>
                                        <span style="font-size:11px; color:#94A3B8;">Super Admin only</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!$amSuper): ?>
                <p style="font-size:11.5px; color:#94A3B8; padding:0 18px 12px;">Read-only view — creating, editing and deleting staff accounts requires a Super Admin login.</p>
                <?php endif; ?>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<!-- Add / Edit modal -->
<div id="dtUserModal" class="dt-u-modal">
    <div style="background:#fff; width:95%; max-width:460px; border-radius:10px; border:2px solid #D4AF37; overflow:hidden; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4);">
        <div style="background:linear-gradient(135deg,#261C0E,#3A2C12 45%,#18120A); padding:14px 18px; border-bottom:2px solid #D4AF37;">
            <h3 style="margin:0; font-size:15px; font-weight:800; color:#fff;" id="dtUserModalTitle">Add Admin User</h3>
        </div>
        <div style="padding:18px 20px; display:flex; flex-direction:column; gap:12px;">
            <input type="hidden" id="dtUserId" value="">
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Full Name *</label>
                <input type="text" id="dtUserName" class="dt-u-input" placeholder="e.g. Gautam Sethi">
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Email (login) *</label>
                <input type="email" id="dtUserEmail" class="dt-u-input" placeholder="name@jaihanumantex.in">
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Role</label>
                <select id="dtUserRole" class="dt-u-input">
                    <option value="staff">Staff</option>
                    <option value="manager">Manager</option>
                    <option value="admin">Administrator</option>
                    <option value="super_admin">Super Admin</option>
                </select>
            </div>
            <div id="dtUserStatusWrap">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Status</label>
                <select id="dtUserStatus" class="dt-u-input">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive (blocks sign-in)</option>
                </select>
            </div>
            <div id="dtUserPassWrap">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Password * <span id="dtUserPassHint" style="color:#78716C; font-weight:600;">(min 8 characters)</span></label>
                <input type="text" id="dtUserPass" class="dt-u-input" autocomplete="off" placeholder="Set a strong password">
            </div>
        </div>
        <div style="background:#f6f7f7; padding:12px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:8px;">
            <button class="adm-btn-secondary" onclick="closeUserModal()">Cancel</button>
            <button class="adm-btn-primary" onclick="submitUserModal()">Save Account</button>
        </div>
    </div>
</div>

<script>
var DT_USER_IS_SUPER = <?= $amSuper ? 'true' : 'false' ?>;

function openUserModal(mode, data) {
    if (!DT_USER_IS_SUPER) { return; }
    var title = document.getElementById('dtUserModalTitle');
    document.getElementById('dtUserId').value = '';
    document.getElementById('dtUserName').value = '';
    document.getElementById('dtUserEmail').value = '';
    document.getElementById('dtUserPass').value = '';
    document.getElementById('dtUserRole').value = 'staff';
    document.getElementById('dtUserStatus').value = 'active';
    document.getElementById('dtUserEmail').readOnly = false;
    if (mode === 'edit' && data) {
        title.textContent = 'Edit Account: ' + data.name;
        document.getElementById('dtUserId').value = data.id;
        document.getElementById('dtUserName').value = data.name;
        document.getElementById('dtUserEmail').value = data.email;
        document.getElementById('dtUserEmail').readOnly = true; // login identity
        document.getElementById('dtUserRole').value = data.role;
        document.getElementById('dtUserStatus').value = data.status;
        document.getElementById('dtUserPassHint').textContent = '(leave blank to keep current password)';
    } else {
        title.textContent = 'Add Admin User';
        document.getElementById('dtUserPassHint').textContent = '(min 8 characters)';
    }
    document.getElementById('dtUserModal').style.display = 'flex';
}

function closeUserModal() {
    document.getElementById('dtUserModal').style.display = 'none';
}

function submitUserModal() {
    var id = document.getElementById('dtUserId').value;
    var name = document.getElementById('dtUserName').value.trim();
    var email = document.getElementById('dtUserEmail').value.trim();
    var role = document.getElementById('dtUserRole').value;
    var status = document.getElementById('dtUserStatus').value;
    var pass = document.getElementById('dtUserPass').value;
    var isEdit = id !== '';

    if (!name) { showToastSafe('⚠️ Name is required'); return; }
    if (!isEdit && !email) { showToastSafe('⚠️ Email is required'); return; }
    if (!isEdit && pass.length < 8) { showToastSafe('⚠️ Password must be at least 8 characters'); return; }

    var params = new URLSearchParams();
    params.append('action', isEdit ? 'update' : 'create');
    if (isEdit) params.append('id', id);
    params.append('name', name);
    if (!isEdit) params.append('email', email);
    params.append('role', role);
    params.append('status', status);
    if (pass !== '') params.append('password', pass);

    fetch('/api/users.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            if (d && d.success === false) { showToastSafe('⚠️ ' + (d.message || 'Request failed')); return; }
            window.location.reload();
        })
        .catch(function () { showToastSafe('⚠️ Could not reach the server'); });
}

function deleteUser(id, name) {
    if (!confirm('Delete the account "' + name + '"? This cannot be undone.')) return;
    var params = new URLSearchParams();
    params.append('action', 'delete');
    params.append('id', id);
    fetch('/api/users.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            if (d && d.success === false) { showToastSafe('⚠️ ' + (d.message || 'Delete failed')); return; }
            var row = document.getElementById('user-row-' + id);
            if (row) row.remove();
        })
        .catch(function () { showToastSafe('⚠️ Could not reach the server'); });
}

function showToastSafe(msg) {
    if (typeof window.showToast === 'function') window.showToast(msg); else alert(msg);
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>