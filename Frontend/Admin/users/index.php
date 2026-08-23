<?php
/**
 * index.php - DT Brand's Admin Users Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Admin Users & Role Permissions";
$active_nav = "users";
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
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Admin Users & Role Permissions</span>
                        <span class="adm-badge gold">Super Admin</span>
                    </h1>
                    <p class="adm-page-subtitle">Manage administrator credentials, warehouse manager logins, and staff permissions.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Super Admins</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">2 Accounts</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Full Unrestricted Access</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Staff / Managers</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">4 Accounts</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Warehouse & Dispatch Roles</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Active Sessions</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">1 Active</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Current Admin Gautam</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Security Status</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">2FA Active</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Encrypted Auth Tokens</span>
                    </div>
                </div>
            </div>

            <!-- Module Specific Interactive Content -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Administrator & Staff Roster</span></h3>
                    <button class="adm-btn-primary" onclick="window.showToast('Opening User Invite Modal...')">+ Add Admin User</button>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Admin Name</th>
                                <th>Email Address</th>
                                <th>Role & Permissions</th>
                                <th>Last Login</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Gautam Sethi</strong><br><small style="color:#8A681F;">Primary Owner</small></td>
                                <td>gautam@jaihanumantex.in</td>
                                <td><span class="adm-badge gold">Super Admin (All Modules)</span></td>
                                <td>Just Now</td>
                                <td><span class="adm-badge success">Active</span></td>
                                <td><button class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('Editing Permissions...')">Edit</button></td>
                            </tr>
                            <tr>
                                <td><strong>Surat Dispatch Manager</strong></td>
                                <td>dispatch@jaihanumantex.in</td>
                                <td><span class="adm-badge info">Orders & Logistics Only</span></td>
                                <td>2 hours ago</td>
                                <td><span class="adm-badge success">Active</span></td>
                                <td><button class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('Editing Permissions...')">Edit</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
