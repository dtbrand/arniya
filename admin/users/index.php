<?php
/**
 * index.php — Master Admin Security, Staff Accounts & Access Control Console
 * DT Brand's & Jai Hanuman Tex — Live Production Architecture
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
$page_title = "Admin Security & Staff Access Console";
$active_nav = "users";
$current_subnav = "users";

$overview = $secManager->getSecurityOverview();
$users = $secManager->getAdminUsers();
$roles = $secManager->getRoles();

$sessionRole = strtolower((string)($_SESSION['admin_user']['role'] ?? $_SESSION['admin_role'] ?? 'admin'));
$isSuper = ($sessionRole === 'super_admin');
$currentAdminId = (int)($_SESSION['admin_user']['id'] ?? 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Security & Staff Access - DT Brand's Admin</title>
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
            
            <!-- Page Header -->
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Admin Security &amp; Staff Access</span>
                        <span class="dt-badge gold"><?php echo $isSuper ? 'Super Admin' : ucfirst($sessionRole); ?></span>
                    </h1>
                    <p class="adm-page-subtitle">Governance of administrator credentials, granular role matrices, active sessions, and security audits.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px; align-items:center;">
                    <a href="/admin/users/login-audit.php" class="dt-btn-pale">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        Login Audit
                    </a>
                    <?php if ($isSuper): ?>
                    <button type="button" onclick="dtOpenModal('modalCreateUser')" class="dt-btn-gold">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        + Create Staff Account
                    </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- KPI Summary Ribbon -->
            <div class="dt-kpi-grid">
                <div class="dt-kpi-card gold-border">
                    <div>
                        <div class="dt-kpi-title">Staff Accounts</div>
                        <div class="dt-kpi-value"><?php echo (int)$overview['total_staff']; ?></div>
                        <div class="dt-kpi-sub">
                            <span class="dt-badge success"><?php echo (int)$overview['active_staff']; ?> Active</span>
                            <span>&bull; <?php echo (int)$overview['super_admin_count']; ?> Super Admin</span>
                        </div>
                    </div>
                    <div class="dt-kpi-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                </div>

                <div class="dt-kpi-card emerald-border">
                    <div>
                        <div class="dt-kpi-title">Active Sessions</div>
                        <div class="dt-kpi-value"><?php echo (int)$overview['active_sessions']; ?></div>
                        <div class="dt-kpi-sub">
                            <span style="color:#15803D; font-weight:700;">Live Device Handshakes</span>
                        </div>
                    </div>
                    <div class="dt-kpi-icon" style="background:#DCFCE7; color:#15803D;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                    </div>
                </div>

                <div class="dt-kpi-card amber-border">
                    <div>
                        <div class="dt-kpi-title">24h Sign-Ins</div>
                        <div class="dt-kpi-value"><?php echo (int)$overview['signins_24h']; ?></div>
                        <div class="dt-kpi-sub">
                            <span style="color:#B45309; font-weight:700;"><?php echo (int)$overview['failed_attempts_24h']; ?> Failed Attempts</span>
                        </div>
                    </div>
                    <div class="dt-kpi-icon" style="background:#FEF3C7; color:#B45309;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                    </div>
                </div>

                <div class="dt-kpi-card crimson-border">
                    <div>
                        <div class="dt-kpi-title">Security Health</div>
                        <div class="dt-kpi-value"><?php echo (int)$overview['health_score']; ?>%</div>
                        <div class="dt-kpi-sub">
                            <span class="dt-badge <?php echo $overview['health_score'] >= 90 ? 'success' : 'warning'; ?>"><?php echo htmlspecialchars($overview['status_label']); ?></span>
                        </div>
                    </div>
                    <div class="dt-kpi-icon" style="background:#FEF2F2; color:#DC2626;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Quick Navigation Hub -->
            <div class="dt-nav-cards-grid">
                <a href="/admin/users/admins.php" class="dt-nav-card">
                    <div class="dt-nav-card-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <div class="dt-nav-card-title">Admin Users</div>
                    <div class="dt-nav-card-desc">Manage staff credentials, emails, phones, and invitations.</div>
                </a>

                <a href="/admin/users/roles.php" class="dt-nav-card">
                    <div class="dt-nav-card-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    </div>
                    <div class="dt-nav-card-title">Admin Roles</div>
                    <div class="dt-nav-card-desc">Define privilege tiers, operational scopes, and role hierarchies.</div>
                </a>

                <a href="/admin/users/permissions.php" class="dt-nav-card">
                    <div class="dt-nav-card-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    </div>
                    <div class="dt-nav-card-title">Permissions Matrix</div>
                    <div class="dt-nav-card-desc">Granular matrix of 16 permission actions across 14 modules.</div>
                </a>

                <a href="/admin/users/sessions.php" class="dt-nav-card">
                    <div class="dt-nav-card-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                    </div>
                    <div class="dt-nav-card-title">Active Sessions</div>
                    <div class="dt-nav-card-desc">Real-time device sessions with instant 1-click revocation.</div>
                </a>

                <a href="/admin/users/login-audit.php" class="dt-nav-card">
                    <div class="dt-nav-card-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                    </div>
                    <div class="dt-nav-card-title">Login Audit</div>
                    <div class="dt-nav-card-desc">Chronological login attempts, failure reasons, and IP logs.</div>
                </a>

                <a href="/admin/users/security-events.php" class="dt-nav-card">
                    <div class="dt-nav-card-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    </div>
                    <div class="dt-nav-card-title">Security Events</div>
                    <div class="dt-nav-card-desc">High-priority alerts, policy changes, and tamper detection.</div>
                </a>
            </div>

            <!-- Staff Accounts Roster Table -->
            <div class="adm-card" style="margin-bottom:24px;">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <h3 class="adm-card-title">
                            <span>Administrator &amp; Staff Accounts Roster</span>
                            <span class="dt-badge gold"><?php echo count($users); ?> Accounts</span>
                        </h3>
                        <p style="font-size:0.75rem; color:#64748B; margin-top:2px;">Live authenticated users enrolled in the system authentication engine.</p>
                    </div>
                    <?php if ($isSuper): ?>
                    <button type="button" onclick="dtOpenModal('modalCreateUser')" class="dt-btn-gold">
                        + Add Staff
                    </button>
                    <?php endif; ?>
                </div>

                <div class="adm-table-responsive" style="padding:0;">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Staff Member</th>
                                <th>Contact Details</th>
                                <th>Role Privilege</th>
                                <th>Status</th>
                                <th>Active Sessions</th>
                                <th>Last Activity</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($users)): ?>
                            <tr><td colspan="7" style="text-align:center; padding:24px; color:#64748B;">No staff accounts found.</td></tr>
                            <?php else: ?>
                            <?php foreach ($users as $u): ?>
                            <tr>
                                <td>
                                    <div style="font-weight:800; color:#111827; font-size:0.92rem;"><?php echo htmlspecialchars((string)$u['name']); ?></div>
                                    <div style="font-size:0.74rem; color:#64748B;">ID #<?php echo (int)$u['id']; ?></div>
                                </td>
                                <td>
                                    <div style="font-weight:600; color:#1F2937;"><?php echo htmlspecialchars((string)$u['email']); ?></div>
                                    <div style="font-size:0.74rem; color:#64748B;"><?php echo !empty($u['phone']) ? htmlspecialchars((string)$u['phone']) : 'No phone linked'; ?></div>
                                </td>
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
                                        <?php echo (int)($u['active_sessions'] ?? 0); ?> Active
                                    </span>
                                </td>
                                <td>
                                    <div style="font-weight:600; font-size:0.82rem; color:#334155;"><?php echo htmlspecialchars((string)$u['timeago']); ?></div>
                                    <div style="font-size:0.72rem; color:#94A3B8;"><?php echo !empty($u['last_login']) ? date('d M Y, h:i A', strtotime((string)$u['last_login'])) : 'Never signed in'; ?></div>
                                </td>
                                <td style="text-align:right;">
                                    <div style="display:inline-flex; gap:6px; align-items:center;">
                                        <?php if ($isSuper): ?>
                                        <button type="button" onclick="dtOpenEditUser(<?php echo (int)$u['id']; ?>, '<?php echo addslashes((string)$u['name']); ?>', '<?php echo addslashes((string)$u['email']); ?>', '<?php echo addslashes((string)($u['phone'] ?? '')); ?>', '<?php echo addslashes((string)$u['role']); ?>')" class="dt-btn-pale" title="Edit Profile">
                                            Edit
                                        </button>
                                        <button type="button" onclick="dtOpenResetPassword(<?php echo (int)$u['id']; ?>, '<?php echo addslashes((string)$u['name']); ?>')" class="dt-btn-pale" title="Reset Password">
                                            Password
                                        </button>
                                        <button type="button" onclick="dtToggleUserStatus(<?php echo (int)$u['id']; ?>)" class="dt-btn-pale" title="Toggle Status">
                                            <?php echo ($u['status'] ?? 'active') === 'active' ? 'Deactivate' : 'Activate'; ?>
                                        </button>
                                        <?php if ((int)$u['id'] !== $currentAdminId && $u['role'] !== 'super_admin'): ?>
                                        <button type="button" onclick="dtDeleteUser(<?php echo (int)$u['id']; ?>, '<?php echo addslashes((string)$u['name']); ?>')" class="dt-btn-danger" title="Delete Account">
                                            Delete
                                        </button>
                                        <?php endif; ?>
                                        <?php else: ?>
                                        <span style="font-size:0.75rem; color:#94A3B8; font-style:italic;">Protected</span>
                                        <?php endif; ?>
                                    </div>
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
                <input type="text" name="name" class="dt-sec-input" placeholder="e.g., Rajesh Mehta" required>
            </div>
            <div class="dt-form-group">
                <label class="dt-form-label">Official Email Address</label>
                <input type="email" name="email" class="dt-sec-input" placeholder="e.g., rajesh@dtbrand.in" required>
            </div>
            <div class="dt-form-group">
                <label class="dt-form-label">Phone Number (Optional)</label>
                <input type="text" name="phone" class="dt-sec-input" placeholder="+91 98251 00000">
            </div>
            <div class="dt-form-group">
                <label class="dt-form-label">Assigned Role</label>
                <select name="role" class="dt-sec-select" required>
                    <option value="admin">Administrator (Catalog & Orders)</option>
                    <option value="manager">Operations Manager (Dispatch & Inventory)</option>
                    <option value="catalog_staff">Catalog Staff (Products & Media)</option>
                    <option value="support_staff">Customer Support Staff (Concierge)</option>
                    <option value="super_admin">Super Admin (Master Unrestricted)</option>
                </select>
            </div>
            <div class="dt-form-group">
                <label class="dt-form-label">Initial Password (Min 8 Characters)</label>
                <input type="password" name="password" class="dt-sec-input" placeholder="••••••••••••" minlength="8" required>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px;">
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
                <label class="dt-form-label">Official Email</label>
                <input type="email" id="edit_email" name="email" class="dt-sec-input" required>
            </div>
            <div class="dt-form-group">
                <label class="dt-form-label">Phone Number</label>
                <input type="text" id="edit_phone" name="phone" class="dt-sec-input">
            </div>
            <div class="dt-form-group">
                <label class="dt-form-label">Assigned Role</label>
                <select id="edit_role" name="role" class="dt-sec-select" required>
                    <option value="super_admin">Super Admin</option>
                    <option value="admin">Administrator</option>
                    <option value="manager">Operations Manager</option>
                    <option value="catalog_staff">Catalog Staff</option>
                    <option value="support_staff">Customer Support Staff</option>
                </select>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px;">
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
            <h3 class="dt-modal-title">Reset Staff Password</h3>
            <button type="button" onclick="dtCloseModal('modalResetPassword')" class="dt-modal-close">&times;</button>
        </div>
        <form onsubmit="dtSubmitResetPassword(event)">
            <input type="hidden" id="reset_user_id" name="id">
            <p style="font-size:0.85rem; color:#475569; margin-bottom:16px;">
                Resetting password for: <strong id="reset_user_name_label" style="color:#111827;"></strong>.
                All active sessions for this account will be automatically terminated.
            </p>
            <div class="dt-form-group">
                <label class="dt-form-label">New Password (Min 8 Characters)</label>
                <input type="password" id="reset_password" name="password" class="dt-sec-input" minlength="8" placeholder="••••••••••••" required>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px;">
                <button type="button" onclick="dtCloseModal('modalResetPassword')" class="dt-btn-pale">Cancel</button>
                <button type="submit" class="dt-btn-gold">Set New Password</button>
            </div>
        </form>
    </div>
</div>

<script src="/admin/users/users.js?v=<?php echo time(); ?>"></script>
</body>
</html>