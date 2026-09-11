<?php
declare(strict_types=1);
/* DT admin access guard */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/system/cache.php — Cache & OPcache Manager
 * DT Brand's & Jai Hanuman Tex — Section 36
 */
require_once __DIR__ . '/../../src/SystemManager.php';
use DTBrand\SystemManager;

$sm         = SystemManager::getInstance();
$cacheStats = $sm->getCacheStats();
$csrf       = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(16));
$_SESSION['csrf_token'] = $csrf;

$active_nav    = 'system';
$active_subnav = 'cache';
$page_title    = 'Cache Manager — DT Brand\'s';

/* ── OPcache data ── */
$opcStatus = function_exists('opcache_get_status') ? opcache_get_status(false) : null;
$opcEnabled = !empty($opcStatus['opcache_enabled']);
$opcHitRate = 0;
if ($opcEnabled && isset($opcStatus['opcache_statistics'])) {
    $s = $opcStatus['opcache_statistics'];
    $total = ($s['hits'] ?? 0) + ($s['misses'] ?? 0);
    $opcHitRate = $total > 0 ? round(($s['hits'] / $total) * 100, 1) : 0;
    $opcFiles   = $s['num_cached_scripts'] ?? 0;
    $opcKeys    = $s['num_cached_keys'] ?? 0;
}
$opcMemUsed  = $opcEnabled && isset($opcStatus['memory_usage']) ? round($opcStatus['memory_usage']['used_memory'] / 1048576, 2) : 0;
$opcMemFree  = $opcEnabled && isset($opcStatus['memory_usage']) ? round($opcStatus['memory_usage']['free_memory'] / 1048576, 2) : 0;
$opcMemTotal = $opcMemUsed + $opcMemFree;
$opcMemPct   = $opcMemTotal > 0 ? round(($opcMemUsed / $opcMemTotal) * 100) : 0;
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
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                        Cache & OPcache Manager
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0;color:#64748B;font-size:.82rem;">Purge OPcache bytecode, application cache, and view live hit-rate statistics.</p>
                </div>
                <a href="/admin/system/" class="sys-btn-pale">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="15 18 9 12 15 6"/></svg>
                    Suite
                </a>
            </div>

            <!-- OPcache Stats Grid -->
            <div class="sys-health-grid" style="margin-bottom:20px;">
                <div class="sys-health-card <?= $opcEnabled ? 'pass' : 'fail' ?>">
                    <div class="sys-health-icon <?= $opcEnabled ? 'pass' : 'fail' ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                    </div>
                    <div class="sys-health-label">OPcache Status</div>
                    <div class="sys-health-value"><?= $opcEnabled ? 'Active' : 'Disabled' ?></div>
                    <div class="sys-health-meta">PHP OPcache Bytecode</div>
                </div>
                <div class="sys-health-card <?= $opcHitRate >= 80 ? 'pass' : ($opcHitRate >= 50 ? 'warn' : 'unknown') ?>">
                    <div class="sys-health-icon <?= $opcHitRate >= 80 ? 'pass' : 'warn' ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    </div>
                    <div class="sys-health-label">Hit Rate</div>
                    <div class="sys-health-value"><?= $opcHitRate ?>%</div>
                    <div class="sys-health-meta"><?= ($opcFiles ?? 0) ?> scripts cached</div>
                </div>
                <div class="sys-health-card <?= $opcMemPct < 80 ? 'pass' : 'warn' ?>">
                    <div class="sys-health-icon <?= $opcMemPct < 80 ? 'pass' : 'warn' ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/></svg>
                    </div>
                    <div class="sys-health-label">OPcache Memory</div>
                    <div class="sys-health-value"><?= $opcMemUsed ?> MB</div>
                    <div class="sys-health-meta"><?= $opcMemPct ?>% of <?= $opcMemTotal ?> MB used</div>
                </div>
                <div class="sys-health-card pass">
                    <div class="sys-health-icon pass">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                    </div>
                    <div class="sys-health-label">PHP Memory Usage</div>
                    <div class="sys-health-value"><?= number_format(memory_get_usage(true)/1048576,2) ?> MB</div>
                    <div class="sys-health-meta">Peak: <?= number_format(memory_get_peak_usage(true)/1048576,2) ?> MB</div>
                </div>
            </div>

            <!-- OPcache Memory Bar -->
            <?php if ($opcEnabled): ?>
            <div class="sys-card" style="margin-bottom:16px;">
                <div class="sys-card-head">
                    <h3 class="sys-card-title">OPcache Memory Utilization</h3>
                    <span style="font-size:12px;font-weight:700;color:#8A681F;"><?= $opcMemPct ?>% Used</span>
                </div>
                <div class="sys-card-body">
                    <div class="sys-storage-bar-wrap" style="height:10px;margin-bottom:8px;">
                        <div class="sys-storage-bar <?= $opcMemPct >= 90 ? 'danger' : ($opcMemPct >= 70 ? 'warn' : '') ?>" data-pct="<?= $opcMemPct ?>"></div>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:11.5px;color:#64748B;font-weight:600;">
                        <span>Used: <?= $opcMemUsed ?> MB</span>
                        <span>Free: <?= $opcMemFree ?> MB</span>
                        <span>Total: <?= $opcMemTotal ?> MB</span>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Purge Actions -->
            <div class="sys-card">
                <div class="sys-card-head">
                    <h3 class="sys-card-title">Cache Purge Operations</h3>
                </div>
                <div class="sys-card-body" style="padding:0;">
                    <?php
                    $actions = [
                        ['type'=>'opcache',    'label'=>'OPcache Bytecode Cache',     'desc'=>'Resets the PHP bytecode cache. PHP will recompile all scripts on next request.', 'icon'=>'<polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>',  'safe'=>true],
                        ['type'=>'app',        'label'=>'Application Cache',           'desc'=>'Clears all cached product/order/customer data stored in the temp directory.', 'icon'=>'<path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>',  'safe'=>true],
                        ['type'=>'sessions',   'label'=>'Expired PHP Sessions',        'desc'=>'Removes all expired session files from the session storage directory.', 'icon'=>'<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>', 'safe'=>true],
                        ['type'=>'all',        'label'=>'Full Cache Flush (All)',       'desc'=>'Clears OPcache + application cache + expired sessions simultaneously.', 'icon'=>'<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>',  'safe'=>true],
                    ];
                    foreach ($actions as $a): ?>
                    <div class="sys-list-item">
                        <div class="sys-list-icon" style="background:#EFF6FF;color:#1D4ED8;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><?= $a['icon'] ?></svg>
                        </div>
                        <div class="sys-list-body">
                            <div class="sys-list-name"><?= htmlspecialchars($a['label']) ?></div>
                            <div class="sys-list-meta"><?= htmlspecialchars($a['desc']) ?></div>
                        </div>
                        <div class="sys-list-actions">
                            <button class="sys-btn-pale" onclick="sysPurgeCache('<?= $a['type'] ?>')">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                                Purge
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Cache Headers Info -->
            <div class="sys-card" style="margin-top:16px;">
                <div class="sys-card-head">
                    <h3 class="sys-card-title">HTTP Cache Configuration</h3>
                </div>
                <div class="sys-card-body">
                    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:12px;">
                        <?php
                        $cacheConfig = [
                            ['label'=>'Static Assets TTL',   'value'=>($cacheStats['static_ttl'] ?? '30 days'),       'ok'=>true],
                            ['label'=>'Gzip Compression',    'value'=>($cacheStats['gzip'] ?? 'Enabled'),             'ok'=>true],
                            ['label'=>'Brotli Compression',  'value'=>($cacheStats['brotli'] ?? 'Available'),         'ok'=>true],
                            ['label'=>'Browser Cache',       'value'=>($cacheStats['browser_cache'] ?? 'Active'),     'ok'=>true],
                        ];
                        foreach ($cacheConfig as $cc):
                        $bg = $cc['ok'] ? '#DCFCE7' : '#FEF2F2';
                        $cl = $cc['ok'] ? '#15803D' : '#DC2626';
                        $bd = $cc['ok'] ? '#BBF7D0' : '#FECACA';
                        ?>
                        <div style="padding:12px;background:<?= $bg ?>;border:1px solid <?= $bd ?>;border-radius:8px;">
                            <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:<?= $cl ?>;margin-bottom:4px;"><?= htmlspecialchars($cc['label']) ?></div>
                            <div style="font-size:13px;font-weight:800;color:#111827;"><?= htmlspecialchars($cc['value']) ?></div>
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
        setTimeout(() => { bar.style.width = pct + '%'; }, 150);
    });
});
</script>
</body>
</html>
