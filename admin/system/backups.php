<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * backups.php — Database Snapshots & Backups
 * DT Brand's & Jai Hanuman Tex
 *
 * Previously listed three invented snapshot archives ("auto_hourly.sql.gz —
 * Verified SHA-256") with Create/Download/Verify buttons that only raised
 * toasts — and no backup machinery existed behind them. The page now lists
 * the real contents of backups/ and Create/Verify hit the super-admin gated
 * api/system/backup.php, which produces a genuine full-database SQL dump.
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "Database Snapshots & Backups";
$active_nav = "system";

$backupDir = dirname(__DIR__, 2) . '/backups';
$backups = [];
if (is_dir($backupDir)) {
    foreach (glob($backupDir . '/dt_snapshot_*.sql') ?: [] as $f) {
        $backups[] = [
            'name' => basename($f),
            'size_h' => filesize($f) >= 1048576
                ? number_format(filesize($f) / 1048576, 2) . ' MB'
                : number_format(filesize($f) / 1024, 1) . ' KB',
            'created' => date('d M Y, h:i A', (int)filemtime($f)),
            'mtime' => (int)filemtime($f),
        ];
    }
}
usort($backups, static fn($a, $b) => $b['mtime'] <=> $a['mtime']);

$amSuper = strtolower((string)($_SESSION['admin_user']['role'] ?? '')) === 'super_admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Snapshots &amp; Backups - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
    .dt-bk-log { background:#0F172A; color:#93C5FD; font-family:monospace; font-size:11px; padding:10px 12px; border-radius:6px; margin-top:10px; white-space:pre-wrap; display:none; }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Database Snapshots &amp; Backups</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;"><?php echo count($backups); ?> On Disk</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Full-schema + rows SQL dumps of the live database, written to the server's backups/ directory.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/system/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">← System Suite</a>
                    <?php if ($amSuper): ?>
                    <button type="button" id="dtBkCreate" class="dt-btn dt-btn-gold" style="height:32px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;" onclick="createSnapshot(this)">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        <span>+ Create Snapshot Now</span>
                    </button>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!$amSuper): ?>
            <p style="font-size:12px; color:#B45309; font-weight:700; margin-bottom:12px;">Super Admin login required to create or verify snapshots.</p>
            <?php endif; ?>

            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>Available Snapshots</span></h3>
                    <span class="adm-badge" style="background:#FAF8F4; color:#78716C; font-weight:700; font-size:11.5px;">backups/ on the web server</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Snapshot File</th>
                                <th>Size</th>
                                <th>Created</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($backups)): ?>
                                <tr><td colspan="4" style="padding:22px; text-align:center; color:#64748B;">No snapshots yet<?php echo $amSuper ? ' — click <strong>Create Snapshot Now</strong> to take the first full dump.' : '.'; ?></td></tr>
                            <?php else: ?>
                                <?php foreach ($backups as $b): ?>
                                <tr>
                                    <td><code style="background:#FAF5E8; padding:3px 8px; border-radius:6px; color:#8A681F; font-weight:800; border:1px solid #D4AF37;"><?= htmlspecialchars($b['name']) ?></code></td>
                                    <td><strong><?= htmlspecialchars($b['size_h']) ?></strong></td>
                                    <td><?= htmlspecialchars($b['created']) ?></td>
                                    <td style="text-align:right;">
                                        <div style="display:inline-flex; gap:6px;">
                                            <a class="dt-btn dt-btn-pale dt-btn-sm" style="text-decoration:none;" href="/backups/<?= htmlspecialchars($b['name']) ?>" download>Download</a>
                                            <?php if ($amSuper): ?>
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="color:#15803D;" onclick="verifySnapshot('<?= htmlspecialchars(addslashes($b['name'])) ?>', this)">Verify</button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div id="dtBkLog" class="dt-bk-log"></div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script>
function dtBkLogShow(msg) {
    var el = document.getElementById('dtBkLog');
    el.style.display = 'block';
    el.textContent += msg + "\n";
}
function createSnapshot(btn) {
    btn.disabled = true;
    document.getElementById('dtBkLog').textContent = '';
    dtBkLogShow('Dumping all tables (schema + rows)… this can take a minute on a large catalogue.');
    var params = new URLSearchParams();
    params.append('action', 'create');
    fetch('/api/system/backup.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            btn.disabled = false;
            if (d && d.success === false) { dtBkLogShow('FAILED: ' + (d.message || 'unknown error')); return; }
            dtBkLogShow('OK ' + d.message);
            dtBkLogShow('sha256: ' + d.sha256);
            setTimeout(function () { window.location.reload(); }, 900);
        })
        .catch(function () { btn.disabled = false; dtBkLogShow('FAILED: could not reach the server'); });
}
function verifySnapshot(name, btn) {
    btn.disabled = true;
    var params = new URLSearchParams();
    params.append('action', 'verify');
    params.append('name', name);
    fetch('/api/system/backup.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            btn.disabled = false;
            if (typeof window.showToast === 'function') {
                window.showToast((d.success ? 'OK ' : '! ') + d.message);
            } else {
                alert(d.message);
            }
        })
        .catch(function () { btn.disabled = false; });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>