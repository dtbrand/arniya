<?php
/**
 * admins.php — Administrator Accounts Roster & Staff Directory
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
$page_title = "Administrator Accounts Roster";
$active_nav = "users";
$current_subnav = "admins";

$users = $secManager->getAdminUsers();
$sessionRole = strtolower((string)($_SESSION['admin_user']['role'] ?? $_SESSION['admin_role'] ?? 'admin'));
$isSuper = ($sessionRole === 'super_admin');
$currentAdminId = (int)($_SESSION['admin_user']['id'] ?? 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Accounts Roster - DT Brand's Admin</title>
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
                        <span>Administrator Accounts Roster</span>
                        <span class="dt-badge gold"><?php echo count($users); ?> Accounts</span>
                    </h1>
                    <p class="adm-page-subtitle">Staff members with authorized access credentials into the administrative workspace.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px;">
                    <a href="/admin/users/" class="dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        Security Hub
                    </a>
                    <?php if ($isSuper): ?>
                    <button type="button" onclick="dtOpenModal('modalCreateUser')" class="dt-btn-gold">
                        + Invite Admin
                    </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Table Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title">Staff Credentials Directory</h3>
                    <input type="text" id="userSearchInput" onkeyup="filterUserTable()" class="dt-sec-input" style="max-width:260px;" placeholder="Search name, email, role...">
                </div>

                <div class="adm-table-responsive" style="padding:0;">
                    <table class="adm-table" id="adminUsersTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Assigned Role</th>
                                <th>Status</th>
                                <th>Active Sessions</th>
                                <th>Last Activity</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $u): ?>
                            <tr>
                                <td>
                                    <strong style="color:#111827;"><?php echo htmlspecialchars((string)$u['name']); ?></strong>
                                    <div style="font-size:0.72rem; color:#94A3B8;">ID #<?php echo (int)$u['id']; ?></div>
                                </td>
                                <td><?php echo htmlspecialchars((string)$u['email']); ?></td>
                                <td><?php echo !empty($u['phone']) ? htmlspecialchars((string)$u['phone']) : '—'; ?></td>
                                <td>
                                    <span class="dt-badge <?php echo $u['role'] === 'super_admin' ? 'gold' : ($u['role'] === 'admin' ? 'info' : 'warning'); ?>">
                                        <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', (string)$u['role']))); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="dt-badge <?php echo ($u['status'] ?? 'active') === 'active' ? 'success' : 'danger'; ?>">
                                        <?php echo htmlspecialchars(ucfirst((string)($u['status'] ?? 'active'))); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="dt-badge <?php echo ($u['active_sessions'] ?? 0) > 0 ? 'success' : 'info'; ?>">
                                        <?php echo (int)($u['active_sessions'] ?? 0); ?> Sessions
                                    </span>
                                </td>
                                <td>
                                    <div><?php echo htmlspecialchars((string)$u['timeago']); ?></div>
                                    <div style="font-size:0.72rem; color:#94A3B8;"><?php echo !empty($u['last_login']) ? date('d M Y, h:i A', strtotime((string)$u['last_login'])) : 'Never'; ?></div>
                                </td>
                                <td style="text-align:right;">
                                    <div style="display:inline-flex; gap:6px;">
                                        <?php if ($isSuper): ?>
                                        <button type="button" onclick="dtOpenEditUser(<?php echo (int)$u['id']; ?>, '<?php echo addslashes((string)$u['name']); ?>', '<?php echo addslashes((string)$u['email']); ?>', '<?php echo addslashes((string)($u['phone'] ?? '')); ?>', '<?php echo addslashes((string)$u['role']); ?>')" class="dt-btn-pale">
                                            Edit
                                        </button>
                                        <button type="button" onclick="dtOpenResetPassword(<?php echo (int)$u['id']; ?>, '<?php echo addslashes((string)$u['name']); ?>')" class="dt-btn-pale">
                                            Password
                                        </button>
                                        <button type="button" onclick="dtToggleUserStatus(<?php echo (int)$u['id']; ?>)" class="dt-btn-pale">
                                            <?php echo ($u['status'] ?? 'active') === 'active' ? 'Deactivate' : 'Activate'; ?>
                                        </button>
                                        <?php if ((int)$u['id'] !== $currentAdminId && $u['role'] !== 'super_admin'): ?>
                                        <button type="button" onclick="dtDeleteUser(<?php echo (int)$u['id']; ?>, '<?php echo addslashes((string)$u['name']); ?>')" class="dt-btn-danger">
                                            Delete
                                        </button>
                                        <?php endif; ?>
                                        <?php else: ?>
                                        <span style="font-size:0.75rem; color:#94A3B8;">Protected</span>
                                        <?php endif; ?>
                                    </div>
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

<!-- Modal: Create Admin User -->
<div id="modalCreateUser" class="dt-modal">
    <div class="dt-modal-content">
        <div class="dt-modal-header">
            <h3 class="dt-modal-title">+ Invite / Create Staff Account</h3>
            <button type="button" onclick="dtCloseModal('modalCreateUser')" class="dt-modal-close">&times;</button>
        </div>
        <form onsubmit="dtSubmitCreateUser(event)">
            <div class="dt-form-group">
                <label class="dt-form-label">Full Name</label>
                <input type="text" name="name" class="dt-sec-input" placeholder="e.g., Gautam Sethi" required>
            </div>
            <div class="dt-form-group">
                <label class="dt-form-label">Email Address</label>
                <input type="email" name="email" class="dt-sec-input" placeholder="e.g., gautam@dtbrand.in" required>
            </div>
            <div class="dt-form-group">
                <label class="dt-form-label">Phone</label>
                <input type="text" name="phone" class="dt-sec-input" placeholder="+91 88906 39215">
            </div>
            <div class="dt-form-group">
                <label class="dt-form-label">Role</label>
                <select name="role" class="dt-sec-select" required>
                    <option value="admin">Administrator</option>
                    <option value="manager">Operations Manager</option>
                    <option value="catalog_staff">Catalog Staff</option>
                    <option value="support_staff">Customer Support Staff</option>
                    <option value="super_admin">Super Admin</option>
                </select>
            </div>
            <div class="dt-form-group">
                <label class="dt-form-label">Password</label>
                <input type="password" name="password" class="dt-sec-input" minlength="8" required>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
                <button type="button" onclick="dtCloseModal('modalCreateUser')" class="dt-btn-pale">Cancel</button>
                <button type="submit" class="dt-btn-gold">Create Account</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Admin User -->
<div id="modalEditUser" class="dt-modal">
    <div class="dt-modal-content">
        <div class="dt-modal-header">
            <h3 class="dt-modal-title">Edit Staff Account</h3>
            <button type="button" onclick="dtCloseModal('modalEditUser')" class="dt-modal-close">&times;</button>
        </div>
        <form onsubmit="dtSubmitEditUser(event)">
            <input type="hidden" id="edit_user_id" name="id">
            <div class="dt-form-group">
                <label class="dt-form-label">Full Name</label>
                <input type="text" id="edit_name" name="name" class="dt-sec-input" required>
            </div>
            <div class="dt-form-group">
                <label class="dt-form-label">Email</label>
                <input type="email" id="edit_email" name="email" class="dt-sec-input" required>
            </div>
            <div class="dt-form-group">
                <label class="dt-form-label">Phone</label>
                <input type="text" id="edit_phone" name="phone" class="dt-sec-input">
            </div>
            <div class="dt-form-group">
                <label class="dt-form-label">Role</label>
                <select id="edit_role" name="role" class="dt-sec-select" required>
                    <option value="super_admin">Super Admin</option>
                    <option value="admin">Administrator</option>
                    <option value="manager">Operations Manager</option>
                    <option value="catalog_staff">Catalog Staff</option>
                    <option value="support_staff">Customer Support Staff</option>
                </select>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
                <button type="button" onclick="dtCloseModal('modalEditUser')" class="dt-btn-pale">Cancel</button>
                <button type="submit" class="dt-btn-gold">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Reset Password -->
<div id="modalResetPassword" class="dt-modal">
    <div class="dt-modal-content">
        <div class="dt-modal-header">
            <h3 class="dt-modal-title">Reset Password</h3>
            <button type="button" onclick="dtCloseModal('modalResetPassword')" class="dt-modal-close">&times;</button>
        </div>
        <form onsubmit="dtSubmitResetPassword(event)">
            <input type="hidden" id="reset_user_id" name="id">
            <p style="font-size:0.85rem; color:#475569; margin-bottom:16px;">
                Resetting password for: <strong id="reset_user_name_label"></strong>.
            </p>
            <div class="dt-form-group">
                <label class="dt-form-label">New Password (Min 8 Characters)</label>
                <input type="password" id="reset_password" name="password" class="dt-sec-input" minlength="8" required>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
                <button type="button" onclick="dtCloseModal('modalResetPassword')" class="dt-btn-pale">Cancel</button>
                <button type="submit" class="dt-btn-gold">Update Password</button>
            </div>
        </form>
    </div>
</div>

<script src="/admin/users/users.js?v=<?php echo time(); ?>"></script>
<script>
function filterUserTable() {
    var q = document.getElementById('userSearchInput').value.toLowerCase();
    var rows = document.querySelectorAll('#adminUsersTable tbody tr');
    rows.forEach(function(r) {
        var text = r.textContent.toLowerCase();
        r.style.display = text.indexOf(q) !== -1 ? '' : 'none';
    });
}
</script>
</body>
</html>