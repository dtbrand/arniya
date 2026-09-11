<?php
declare(strict_types=1);
/* DT admin access guard */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/system/storage.php — Storage & File Upload Inspector
 * DT Brand's & Jai Hanuman Tex — Section 36
 */
require_once __DIR__ . '/../../src/SystemManager.php';
use DTBrand\SystemManager;

$sm      = SystemManager::getInstance();
$storage = $sm->getStorageInfo();

$active_nav    = 'system';
$active_subnav = 'storage';
$page_title    = 'Storage & Uploads — DT Brand\'s';

/* ── Format bytes helper ── */
function fmtBytes(int $bytes): string {
    if ($bytes >= 1073741824) return round($bytes / 1073741824, 2) . ' GB';
    if ($bytes >= 1048576)    return round($bytes / 1048576, 2)    . ' MB';
    if ($bytes >= 1024)       return round($bytes / 1024, 2)       . ' KB';
    return $bytes . ' B';
}

/* ── Disk usage ── */
$docRoot  = $_SERVER['DOCUMENT_ROOT'] ?? '/var/www/html';
$diskFree  = disk_free_space($docRoot);
$diskTotal = disk_total_space($docRoot);
$diskUsed  = $diskFree !== false && $diskTotal !== false ? $diskTotal - $diskFree : 0;
$diskPct   = ($diskTotal > 0 && $diskFree !== false) ? round(($diskUsed / $diskTotal) * 100) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/admin/system/system.css?v=<?= time() ?>">
</head>
<body class="sys-root">
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">

            <div class="adm-page-head" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:18px;">
                <div>
                    <h1 class="adm-page-title" style="display:flex;align-items:center;gap:8px;margin:0;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        Storage &amp; Uploads
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0;color:#64748B;font-size:.82rem;">Disk usage, upload directory analysis, and PHP upload limits.</p>
                </div>
                <a href="/admin/system/" class="sys-btn-pale">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="15 18 9 12 15 6"/></svg>
                    Suite
                </a>
            </div>

            <!-- Disk Usage Header -->
            <div class="sys-card" style="margin-bottom:16px;">
                <div class="sys-card-head">
                    <h3 class="sys-card-title">Disk Usage Overview</h3>
                    <span class="sys-health-badge <?= $diskPct >= 90 ? 'fail' : ($diskPct >= 70 ? 'warn' : 'pass') ?>">
                        <?= $diskPct ?>% Used
                    </span>
                </div>
                <div class="sys-card-body">
                    <div class="sys-storage-bar-wrap" style="height:12px;margin-bottom:10px;">
                        <div class="sys-storage-bar <?= $diskPct >= 90 ? 'danger' : ($diskPct >= 70 ? 'warn' : '') ?>" data-pct="<?= $diskPct ?>"></div>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:12px;color:#64748B;font-weight:600;flex-wrap:wrap;gap:8px;">
                        <span>Used: <strong style="color:#111827;"><?= fmtBytes((int)$diskUsed) ?></strong></span>
                        <span>Free: <strong style="color:#15803D;"><?= fmtBytes((int)$diskFree) ?></strong></span>
                        <span>Total: <strong style="color:#111827;"><?= fmtBytes((int)$diskTotal) ?></strong></span>
                    </div>
                </div>
            </div>

            <!-- Directory Breakdown -->
            <div class="sys-card" style="margin-bottom:16px;">
                <div class="sys-card-head">
                    <h3 class="sys-card-title">Upload Directory Analysis</h3>
                </div>
                <div class="sys-table-wrap">
                    <table class="sys-table">
                        <thead>
                            <tr>
                                <th>Directory</th>
                                <th>Path</th>
                                <th>File Count</th>
                                <th>Size</th>
                                <th>Writable</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $dirs = [
                            ['label' => 'Product Images',    'path' => 'assets/images/products'],
                            ['label' => 'Banner Images',     'path' => 'assets/images/banners'],
                            ['label' => 'Category Images',   'path' => 'assets/images/categories'],
                            ['label' => 'Media Uploads',     'path' => 'assets/uploads'],
                            ['label' => 'DB Backups',        'path' => 'backups'],
                            ['label' => 'Cache / Temp',      'path' => 'cache'],
                        ];
                        foreach ($dirs as $d):
                            $full = rtrim($docRoot, '/') . '/' . trim($d['path'], '/');
                            $exists   = is_dir($full);
                            $writable = $exists && is_writable($full);
                            $fileCount = 0;
                            $size = 0;
                            if ($exists) {
                                $rit = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($full, FilesystemIterator::SKIP_DOTS));
                                foreach ($rit as $f) { $fileCount++; $size += $f->getSize(); }
                            }
                            $maxPct = $diskTotal > 0 ? round(($size / $diskTotal) * 100, 2) : 0;
                        ?>
                        <tr>
                            <td style="font-weight:700;color:#1F2937;"><?= htmlspecialchars($d['label']) ?></td>
                            <td class="mono" style="font-size:11px;color:#64748B;">/<?= htmlspecialchars($d['path']) ?></td>
                            <td><?= $exists ? number_format($fileCount) : '—' ?></td>
                            <td>
                                <?= $exists ? htmlspecialchars(fmtBytes($size)) : '—' ?>
                                <?php if ($exists && $maxPct > 0): ?>
                                <div style="margin-top:3px;width:80px;height:4px;background:#E2E8F0;border-radius:99px;overflow:hidden;">
                                    <div style="height:100%;width:<?= min(100, $maxPct * 10) ?>%;background:#D4AF37;border-radius:99px;"></div>
                                </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!$exists): ?>
                                <span class="sys-health-badge" style="background:#F1F5F9;color:#64748B;">Missing</span>
                                <?php elseif ($writable): ?>
                                <span class="sys-health-badge pass">Writable</span>
                                <?php else: ?>
                                <span class="sys-health-badge fail">Read-Only</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Upload Config -->
            <div class="sys-card">
                <div class="sys-card-head">
                    <h3 class="sys-card-title">PHP Upload Configuration</h3>
                </div>
                <div class="sys-card-body">
                    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px;">
                        <?php
                        $uploadConfig = [
                            ['label'=>'upload_max_filesize',    'value'=>ini_get('upload_max_filesize'),   'ok'=>true],
                            ['label'=>'post_max_size',          'value'=>ini_get('post_max_size'),         'ok'=>true],
                            ['label'=>'max_file_uploads',       'value'=>ini_get('max_file_uploads'),      'ok'=>true],
                            ['label'=>'file_uploads',           'value'=>ini_get('file_uploads') ? 'On' : 'Off', 'ok'=>(bool)ini_get('file_uploads')],
                            ['label'=>'upload_tmp_dir',         'value'=>ini_get('upload_tmp_dir') ?: sys_get_temp_dir(), 'ok'=>is_writable(ini_get('upload_tmp_dir') ?: sys_get_temp_dir())],
                            ['label'=>'max_execution_time',     'value'=>ini_get('max_execution_time').'s',  'ok'=>(int)ini_get('max_execution_time') >= 30],
                        ];
                        foreach ($uploadConfig as $uc):
                        $bg = $uc['ok'] ? '#DCFCE7' : '#FEF2F2';
                        $cl = $uc['ok'] ? '#15803D' : '#DC2626';
                        $bd = $uc['ok'] ? '#BBF7D0' : '#FECACA';
                        ?>
                        <div style="padding:12px;background:<?= $bg ?>;border:1px solid <?= $bd ?>;border-radius:8px;">
                            <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:<?= $cl ?>;margin-bottom:3px;font-family:monospace;"><?= htmlspecialchars($uc['label']) ?></div>
                            <div style="font-size:13px;font-weight:800;color:#111827;font-family:monospace;"><?= htmlspecialchars($uc['value']) ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?= time() ?>"></script>
<script src="/admin/system/system.js?v=<?= time() ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.sys-storage-bar[data-pct]').forEach(bar => {
        const pct = parseFloat(bar.dataset.pct);
        bar.style.width = '0%';
        setTimeout(() => { bar.style.width = pct + '%'; }, 200);
    });
});
</script>
</body>
</html>
