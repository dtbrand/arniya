<?php
declare(strict_types=1);
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/system/index.php — System Admin Suite Hub
 * DT Brand's & Jai Hanuman Tex — Section 36
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/SystemManager.php';

use DTBrand\Database;
use DTBrand\SystemManager;

$sm  = SystemManager::getInstance();
$pdo = Database::getConnection();

/* ── Health pillars ── */
$health = $sm->runHealthChecks();
$pillars = $health['pillars'] ?? [];
$overall = $health['overall'] ?? 'unknown';

/* ── Quick stats ── */
$tablesCount = 0;
$phpVer      = phpversion();
$memUsage    = number_format(memory_get_usage(true) / 1048576, 2);
$peakMem     = number_format(memory_get_peak_usage(true) / 1048576, 2);

if ($pdo !== null && !Database::isMockMode()) {
    try {
        $tablesCount = (int)$pdo->query("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE()")->fetchColumn();
    } catch (\Exception $e) { $tablesCount = 0; }
}

$migrations = $sm->getMigrationHistory();
$runCount   = count(array_filter($migrations, fn($m) => $m['status'] === 'applied'));

$active_nav    = 'system';
$active_subnav = 'index';
$page_title    = 'System Admin Suite — DT Brand\'s';

$overallClass = match($overall) {
    'pass'    => 'pass',
    'warn'    => 'warn',
    'fail'    => 'fail',
    default   => 'unknown',
};
$overallLabel = match($overall) {
    'pass'    => '100% Operational',
    'warn'    => 'Degraded — Attention Required',
    'fail'    => 'CRITICAL — Failure Detected',
    default   => 'Status Unknown',
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="DT Brand's System Admin — monitor health, settings, migrations, cron, cache, and maintenance.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/admin/system/system.css?v=<?= time() ?>">
</head>
<body class="sys-root">
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">

            <!-- Page Header -->
            <div class="adm-page-head" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:18px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex;align-items:center;gap:8px;margin:0;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.07 4.93a10 10 0 1 1-14.14 0"></path><path d="M12 2v4"></path></svg>
                        <span>System Admin Suite</span>
                        <span class="sys-health-badge <?= $overallClass ?>" style="font-size:0.67rem;"><?= htmlspecialchars($overallLabel) ?></span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0;color:#64748B;font-size:0.82rem;">Enterprise infrastructure command center — health, settings, migrations, cron, cache, storage & maintenance.</p>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <a href="/admin/system/health.php" class="sys-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                        Full Health Report
                    </a>
                    <a href="/admin/system/settings.php" class="sys-btn-gold">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="3"></circle><path d="M19.07 4.93a10 10 0 1 1-14.14 0"></path></svg>
                        System Settings
                    </a>
                </div>
            </div>

            <!-- 8-Pillar Health Grid -->
            <div class="sys-health-grid" id="sysHealthGrid">
                <?php foreach ($pillars as $p):
                    $cls = $p['status'] ?? 'unknown';
                    $iconMap = [
                        'database'    => '<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>',
                        'php'         => '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>',
                        'disk'        => '<path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>',
                        'memory'      => '<rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/>',
                        'ssl'         => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
                        'cache'       => '<polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>',
                        'queue'       => '<line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>',
                        'web'         => '<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>',
                    ];
                    $icon = $iconMap[$p['name']] ?? '<circle cx="12" cy="12" r="10"/>';
                ?>
                <div class="sys-health-card <?= $cls ?>" data-pillar="<?= htmlspecialchars($p['name']) ?>">
                    <div class="sys-health-icon <?= $cls ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><?= $icon ?></svg>
                    </div>
                    <div class="sys-health-label"><?= htmlspecialchars(ucwords(str_replace('_', ' ', $p['name']))) ?></div>
                    <div class="sys-health-value"><?= htmlspecialchars((string)($p['value'] ?? '—')) ?></div>
                    <div class="sys-health-meta">
                        Latency: <?= htmlspecialchars((string)($p['latency'] ?? '—')) ?> ms
                        <span class="sys-health-badge <?= $cls ?>" style="margin-left:6px;"><?= strtoupper($cls) ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Module Quick-Links Grid -->
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px;margin-bottom:20px;">
                <?php
                $modules = [
                    ['url'=>'/admin/system/settings.php',     'label'=>'System Settings',    'icon'=>'<circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 1 1-14.14 0"/>',                                          'badge'=>'',           'color'=>'#8A681F'],
                    ['url'=>'/admin/system/environment.php',  'label'=>'Environment',         'icon'=>'<rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/>',                 'badge'=>'',           'color'=>'#1D4ED8'],
                    ['url'=>'/admin/system/migrations.php',   'label'=>'DB Migrations',       'icon'=>'<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>', 'badge'=>$runCount.' Applied', 'color'=>'#15803D'],
                    ['url'=>'/admin/system/cache.php',        'label'=>'Cache Manager',       'icon'=>'<polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>',                               'badge'=>'',           'color'=>'#7C3AED'],
                    ['url'=>'/admin/system/storage.php',      'label'=>'Storage & Uploads',   'icon'=>'<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>', 'badge'=>'', 'color'=>'#B45309'],
                    ['url'=>'/admin/system/logs.php',         'label'=>'System Logs',         'icon'=>'<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>',                    'badge'=>'',           'color'=>'#DC2626'],
                    ['url'=>'/admin/system/cron.php',         'label'=>'Cron Scheduler',      'icon'=>'<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',                                              'badge'=>'',           'color'=>'#0891B2'],
                    ['url'=>'/admin/system/maintenance.php',  'label'=>'Maintenance Mode',    'icon'=>'<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>',  'badge'=>'',           'color'=>'#B45309'],
                    ['url'=>'/admin/system/feature-flags.php','label'=>'Feature Flags',       'icon'=>'<line x1="4" y1="9" x2="20" y2="9"/><line x1="4" y1="15" x2="20" y2="15"/><line x1="10" y1="3" x2="8" y2="21"/><line x1="16" y1="3" x2="14" y2="21"/>',                    'badge'=>'',           'color'=>'#8A681F'],
                    ['url'=>'/admin/system/backups.php',      'label'=>'Database Backups',    'icon'=>'<path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/>',                                                        'badge'=>'',           'color'=>'#15803D'],
                    ['url'=>'/admin/system/health.php',       'label'=>'Health Monitor',      'icon'=>'<path d="M22 12h-4l-3 9L9 3l-3 9H2"/>',                                                                             'badge'=>strtoupper($overall), 'color'=>$overall==='pass'?'#15803D':($overall==='warn'?'#B45309':'#DC2626')],
                    ['url'=>'/admin/system/database.php',     'label'=>'Database Tools',      'icon'=>'<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>', 'badge'=>$tablesCount.' Tables', 'color'=>'#1D4ED8'],
                ];
                foreach ($modules as $m): ?>
                <a href="<?= htmlspecialchars($m['url']) ?>" style="display:flex;flex-direction:column;gap:10px;padding:16px;background:#FFFFFF;border:1px solid #E2E8F0;border-radius:12px;text-decoration:none;transition:box-shadow .2s,transform .2s;" onmouseover="this.style.boxShadow='0 4px 18px rgba(0,0,0,0.08)';this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='';this.style.transform='';">
                    <div style="width:38px;height:38px;border-radius:9px;background:<?= htmlspecialchars($m['color']) ?>18;display:flex;align-items:center;justify-content:center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="<?= htmlspecialchars($m['color']) ?>" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><?= $m['icon'] ?></svg>
                    </div>
                    <div>
                        <div style="font-size:13px;font-weight:800;color:#111827;letter-spacing:-0.01em;"><?= htmlspecialchars($m['label']) ?></div>
                        <?php if (!empty($m['badge'])): ?>
                        <div style="font-size:10.5px;font-weight:700;color:<?= htmlspecialchars($m['color']) ?>;margin-top:2px;"><?= htmlspecialchars($m['badge']) ?></div>
                        <?php endif; ?>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Quick Stats Footer -->
            <div class="sys-card">
                <div class="sys-card-head">
                    <h3 class="sys-card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        Runtime Diagnostics
                    </h3>
                    <span style="font-size:11px;color:#94A3B8;font-weight:600;">Auto-refreshes every 30 s</span>
                </div>
                <div class="sys-card-body">
                    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;">
                        <?php
                        $diag = [
                            ['label'=>'PHP Version',       'value'=>'PHP '.$phpVer,                            'ok'=>true],
                            ['label'=>'Memory Usage',      'value'=>$memUsage.' / '.$peakMem.' MB (peak)',     'ok'=>(float)$memUsage < 128],
                            ['label'=>'DB Tables',         'value'=>$tablesCount.' tables',                    'ok'=>$tablesCount > 0],
                            ['label'=>'Migrations',        'value'=>$runCount.' applied',                      'ok'=>true],
                            ['label'=>'OPcache',           'value'=>function_exists('opcache_get_status') ? 'Enabled' : 'Disabled', 'ok'=>function_exists('opcache_get_status')],
                            ['label'=>'Server Software',   'value'=>substr($_SERVER['SERVER_SOFTWARE'] ?? 'Apache', 0, 28), 'ok'=>true],
                            ['label'=>'Timezone',          'value'=>date_default_timezone_get(),               'ok'=>true],
                            ['label'=>'Max Upload',        'value'=>ini_get('upload_max_filesize'),            'ok'=>true],
                        ];
                        foreach ($diag as $d):
                        $bg = $d['ok'] ? '#DCFCE7' : '#FEF2F2';
                        $cl = $d['ok'] ? '#15803D' : '#DC2626';
                        $bd = $d['ok'] ? '#BBF7D0' : '#FECACA';
                        ?>
                        <div style="padding:12px;background:<?= $bg ?>;border:1px solid <?= $bd ?>;border-radius:8px;">
                            <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:<?= $cl ?>;margin-bottom:4px;"><?= htmlspecialchars($d['label']) ?></div>
                            <div style="font-size:12.5px;font-weight:800;color:#111827;font-family:monospace;"><?= htmlspecialchars($d['value']) ?></div>
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
    // Periodic health refresh
    if (document.getElementById('sysHealthGrid')) {
        setInterval(sysRefreshHealth, 30000);
    }
});
</script>
</body>
</html>
