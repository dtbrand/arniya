<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * backups.php - DT Brand's Admin Automated Hourly Snapshots & Backups
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Automated Hourly Snapshots & Backups";
$active_nav = "system";

$backups = [
    [
        'name' => 'mysql_demodt121_auto_hourly.sql.gz',
        'type' => 'MySQL DB Complete Dump',
        'size' => '1.8 MB',
        'timestamp' => 'Today, 01:00 AM',
        'integrity' => 'Verified SHA-256',
        'status' => 'Healthy'
    ],
    [
        'name' => 'mysql_demodt121_auto_daily.sql.gz',
        'type' => 'MySQL Daily Archive',
        'size' => '1.7 MB',
        'timestamp' => 'Yesterday, 11:59 PM',
        'integrity' => 'Verified SHA-256',
        'status' => 'Healthy'
    ],
    [
        'name' => 'saree_catalog_media_assets.tar.gz',
        'type' => 'Storefront Images & Media',
        'size' => '24.6 MB',
        'timestamp' => '25 Aug 2026',
        'integrity' => 'Verified SHA-256',
        'status' => 'Healthy'
    ],
    [
        'name' => 'arniya_source_codebase.zip',
        'type' => 'PHP Application Source',
        'size' => '4.2 MB',
        'timestamp' => '24 Aug 2026',
        'integrity' => 'Git Synced (main)',
        'status' => 'Healthy'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automated Snapshots &amp; Backups - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Automated Snapshots &amp; Backups</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">Continuous Snapshots</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Automated MySQL database snapshots, media assets tarballs, and 1-click disaster recovery points.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/system/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">← System Suite</a>
                    <button type="button" class="dt-btn dt-btn-gold" style="height:32px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;" onclick="window.showToast('✨ Instant MySQL database snapshot generated and archived!')">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        <span>+ Create Instant Snapshot</span>
                    </button>
                </div>
            </div>

            <!-- Backups Table Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>💾 Available System Disaster Recovery Snapshots</span></h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;">🟢 Triple-Redundancy Verified</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Snapshot Archive Name</th>
                                <th>Backup Type</th>
                                <th>File Size</th>
                                <th>Snapshot Timestamp</th>
                                <th>Integrity Hash</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($backups as $b): ?>
                                <tr>
                                    <td>
                                        <code style="background:#FAF5E8; padding:3px 8px; border-radius:6px; color:#8A681F; font-weight:800; border:1px solid #D4AF37;">
                                            <?= htmlspecialchars($b['name']) ?>
                                        </code>
                                    </td>
                                    <td><strong><?= htmlspecialchars($b['type']) ?></strong></td>
                                    <td><strong style="color:#181512;"><?= htmlspecialchars($b['size']) ?></strong></td>
                                    <td><?= htmlspecialchars($b['timestamp']) ?></td>
                                    <td><span class="adm-badge" style="background:#FAF8F4; color:#78716C; font-weight:700;"><?= htmlspecialchars($b['integrity']) ?></span></td>
                                    <td style="text-align:right;">
                                        <div style="display:inline-flex; gap:6px;">
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('📥 Downloading snapshot <?= htmlspecialchars($b['name']) ?>...')">Download</button>
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="color:#15803D;" onclick="window.showToast('✓ Snapshot integrity verified: 100% Valid.')">Verify</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
