<?php
declare(strict_types=1);
/* DT admin access guard */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/system/health.php — Full System Health Monitor
 * DT Brand's & Jai Hanuman Tex — Section 36
 */
require_once __DIR__ . '/../../src/SystemManager.php';
use DTBrand\SystemManager;

$sm        = SystemManager::getInstance();
$health    = $sm->runHealthChecks();
$pillars   = $health['pillars']    ?? [];
$overall   = $health['overall']    ?? 'unknown';
$checkedAt = $health['checked_at'] ?? date('Y-m-d H:i:s');

$active_nav    = 'system';
$active_subnav = 'health';
$page_title    = 'System Health Monitor — DT Brand\'s';

$overallClass = match($overall) { 'pass' => 'pass', 'warn' => 'warn', 'fail' => 'fail', default => 'unknown' };
$passCount    = count(array_filter($pillars, fn($p) => ($p['status'] ?? '') === 'pass'));
$warnCount    = count(array_filter($pillars, fn($p) => ($p['status'] ?? '') === 'warn'));
$failCount    = count(array_filter($pillars, fn($p) => ($p['status'] ?? '') === 'fail'));

$iconMap = [
    'database' => '<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>',
    'php'      => '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>',
    'disk'     => '<path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>',
    'memory'   => '<rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/>',
    'ssl'      => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
    'cache'    => '<polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>',
    'queue'    => '<line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/>',
    'web'      => '<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>',
];
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
    <style>
    .sys-overall-banner { display:flex;align-items:center;gap:16px;padding:20px 24px;border-radius:14px;margin-bottom:20px; }
    .sys-overall-banner.pass { background:linear-gradient(135deg,#DCFCE7,#BBF7D0);border:1.5px solid #86EFAC; }
    .sys-overall-banner.warn { background:linear-gradient(135deg,#FEF3C7,#FDE68A);border:1.5px solid #FCD34D; }
    .sys-overall-banner.fail { background:linear-gradient(135deg,#FEF2F2,#FECACA);border:1.5px solid #FCA5A5; }
    .sys-latency-bar-outer { height:6px;background:#E2E8F0;border-radius:99px;overflow:hidden;margin-top:6px; }
    .sys-latency-bar-inner { height:100%;border-radius:99px;transition:width .6s ease; }
    </style>
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
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                        System Health Monitor
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0;color:#64748B;font-size:.82rem;">Full 8-pillar infrastructure health check with latency benchmarks.</p>
                </div>
                <div style="display:flex;gap:8px;">
                    <button class="sys-btn-gold" onclick="sysRefreshHealth()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                        Refresh Now
                    </button>
                    <a href="/admin/system/" class="sys-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="15 18 9 12 15 6"/></svg>
                        Suite
                    </a>
                </div>
            </div>

            <!-- Overall Banner -->
            <div class="sys-overall-banner <?= $overallClass ?>">
                <div style="width:52px;height:52px;border-radius:14px;background:rgba(255,255,255,.6);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <?php if ($overall === 'pass'): ?>
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.4"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <?php elseif ($overall === 'warn'): ?>
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="2.4"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <?php else: ?>
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.4"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    <?php endif; ?>
                </div>
                <div style="flex:1;">
                    <div style="font-size:17px;font-weight:900;color:#111827;letter-spacing:-.02em;margin-bottom:4px;">
                        <?= match($overall) {
                            'pass'  => '100% Operational — All Systems Go',
                            'warn'  => 'Degraded Performance — Attention Required',
                            'fail'  => 'CRITICAL FAILURE — Immediate Action Required',
                            default => 'Health Status Unknown'
                        } ?>
                    </div>
                    <div style="font-size:12px;color:#475569;font-weight:500;">
                        Last checked: <?= htmlspecialchars($checkedAt) ?>
                        &nbsp;|&nbsp;
                        <span style="color:#15803D;font-weight:700;"><?= $passCount ?> Passed</span>
                        <?php if ($warnCount > 0): ?>&nbsp;|&nbsp;<span style="color:#B45309;font-weight:700;"><?= $warnCount ?> Warning</span><?php endif; ?>
                        <?php if ($failCount > 0): ?>&nbsp;|&nbsp;<span style="color:#DC2626;font-weight:700;"><?= $failCount ?> Failed</span><?php endif; ?>
                    </div>
                </div>
                <div id="healthLastRefresh" style="font-size:10.5px;color:#94A3B8;font-weight:600;white-space:nowrap;">Auto-refresh: 30s</div>
            </div>

            <!-- Detailed Pillar Cards -->
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:16px;margin-bottom:20px;" id="sysHealthGrid">
                <?php foreach ($pillars as $p):
                    $cls      = $p['status'] ?? 'unknown';
                    $latency  = (int)($p['latency'] ?? 0);
                    $latPct   = min(100, round(($latency / 500) * 100));
                    $latColor = $latency < 50 ? '#15803D' : ($latency < 200 ? '#D4AF37' : '#DC2626');
                    $icon     = $iconMap[$p['name']] ?? '<circle cx="12" cy="12" r="10"/>';
                    $bdColor  = match($cls) { 'pass'=>'#86EFAC', 'warn'=>'#FCD34D', 'fail'=>'#FCA5A5', default=>'#E2E8F0' };
                    $bgColor  = match($cls) { 'pass'=>'#F0FDF4', 'warn'=>'#FFFBEB', 'fail'=>'#FFF5F5', default=>'#F8FAFC' };
                ?>
                <div style="background:<?= $bgColor ?>;border:1.5px solid <?= $bdColor ?>;border-radius:14px;padding:18px;">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div class="sys-health-icon <?= $cls ?>" style="width:38px;height:38px;border-radius:10px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><?= $icon ?></svg>
                            </div>
                            <div>
                                <div style="font-size:14px;font-weight:800;color:#111827;letter-spacing:-.01em;"><?= htmlspecialchars(ucwords(str_replace('_',' ',$p['name']))) ?></div>
                                <div style="font-size:11px;color:#64748B;font-weight:600;margin-top:1px;"><?= htmlspecialchars($p['description'] ?? '') ?></div>
                            </div>
                        </div>
                        <span class="sys-health-badge <?= $cls ?>" style="flex-shrink:0;"><?= strtoupper($cls) ?></span>
                    </div>

                    <div style="font-size:22px;font-weight:900;color:#111827;font-family:monospace;margin-bottom:4px;"><?= htmlspecialchars((string)($p['value'] ?? '—')) ?></div>
                    <?php if (!empty($p['threshold'])): ?>
                    <div style="font-size:11px;color:#64748B;margin-bottom:4px;">Threshold: <?= htmlspecialchars((string)$p['threshold']) ?></div>
                    <?php endif; ?>

                    <div style="display:flex;align-items:center;justify-content:space-between;margin-top:8px;">
                        <div style="font-size:10.5px;color:#94A3B8;font-weight:600;">Response time</div>
                        <div style="font-size:11px;font-weight:800;color:<?= $latColor ?>;"><?= $latency ?> ms</div>
                    </div>
                    <div class="sys-latency-bar-outer">
                        <div class="sys-latency-bar-inner" style="width:<?= $latPct ?>%;background:<?= $latColor ?>;"></div>
                    </div>

                    <?php if (!empty($p['error'])): ?>
                    <div style="margin-top:10px;padding:8px 10px;background:#FEF2F2;border:1px solid #FECACA;border-radius:7px;font-size:11px;color:#DC2626;font-weight:600;">
                        <?= htmlspecialchars($p['error']) ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                <?php if (empty($pillars)): ?>
                <div style="grid-column:1/-1;padding:40px;text-align:center;color:#94A3B8;font-size:13px;">No health pillar data returned.</div>
                <?php endif; ?>
            </div>

            <!-- History placeholder -->
            <div class="sys-card">
                <div class="sys-card-head">
                    <h3 class="sys-card-title">Health History Tracking</h3>
                </div>
                <div class="sys-card-body" style="padding:28px;text-align:center;color:#94A3B8;font-size:12.5px;">
                    History tracking requires the <code>system_health_log</code> table from migration v36.<br>
                    Once available, 24-hour sparklines will appear here.
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
    setInterval(async function() {
        try {
            const data = await sysGet('/api/system.php?action=health');
            if (data && data.pillars) {
                document.getElementById('healthLastRefresh').textContent = 'Refreshed: ' + new Date().toLocaleTimeString();
            }
        } catch(e) {}
    }, 30000);
});
</script>
</body>
</html>
