<?php
declare(strict_types=1);
/* DT admin access guard */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/system/logs.php — System Log Viewer (Live Tail)
 * DT Brand's & Jai Hanuman Tex — Section 36
 */
require_once __DIR__ . '/../../src/SystemManager.php';
use DTBrand\SystemManager;

$sm   = SystemManager::getInstance();
$csrf = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(16));
$_SESSION['csrf_token'] = $csrf;

$level  = trim((string)($_GET['level'] ?? ''));
$limit  = min(200, max(10, (int)($_GET['limit'] ?? 100)));
$search = trim((string)($_GET['q'] ?? ''));

$logs = $sm->getSystemLogs($level ?: null, $limit, $search ?: null);

$active_nav    = 'system';
$active_subnav = 'logs';
$page_title    = 'System Logs — DT Brand\'s';
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
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        System Logs
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0;color:#64748B;font-size:.82rem;">Application event log viewer with live tail, level filtering, and search.</p>
                </div>
                <div style="display:flex;gap:8px;">
                    <button class="sys-btn-danger" onclick="sysDangerAction('logs_flush','Flush All System Logs')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                        Flush Logs
                    </button>
                    <a href="/admin/system/" class="sys-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="15 18 9 12 15 6"/></svg>
                        Suite
                    </a>
                </div>
            </div>

            <!-- Filter Bar -->
            <div class="sys-filter-row">
                <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap;flex:1;">
                    <input type="text" name="q" class="sys-input" placeholder="Search message…" value="<?= htmlspecialchars($search) ?>">
                    <select name="level" class="sys-select">
                        <option value="">All Levels</option>
                        <?php foreach (['debug','info','warning','error','critical','success'] as $lv): ?>
                        <option value="<?= $lv ?>" <?= $level === $lv ? 'selected' : '' ?>><?= ucfirst($lv) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="limit" class="sys-select">
                        <?php foreach ([25,50,100,200] as $lim): ?>
                        <option value="<?= $lim ?>" <?= $limit === $lim ? 'selected' : '' ?>><?= $lim ?> rows</option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="sys-btn-gold">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Filter
                    </button>
                </form>
                <!-- Live Tail Toggle -->
                <button class="sys-btn-emerald" id="tailBtn" onclick="toggleTail()">
                    <span class="sys-live-dot"></span>
                    Start Live Tail
                </button>
            </div>

            <!-- Log Table -->
            <div class="sys-card">
                <div class="sys-card-head">
                    <h3 class="sys-card-title">
                        <span class="sys-live-dot" id="tailDot" style="display:none;"></span>
                        Log Entries (<?= count($logs) ?> shown)
                    </h3>
                    <span style="font-size:11px;color:#94A3B8;font-weight:600;">Retention: <?= htmlspecialchars($sm->getSetting('security', 'log_retention_days', '90')) ?> days</span>
                </div>
                <div class="sys-table-wrap">
                    <table class="sys-table" id="sysLogTable">
                        <thead>
                            <tr>
                                <th style="width:140px;">Timestamp</th>
                                <th style="width:80px;">Level</th>
                                <th style="width:100px;">Channel</th>
                                <th>Message</th>
                                <th style="width:100px;">Context</th>
                            </tr>
                        </thead>
                        <tbody id="sysLogTbody">
                        <?php if (empty($logs)): ?>
                            <tr><td colspan="5" style="padding:24px;text-align:center;color:#94A3B8;font-size:13px;">No log entries match the current filter.</td></tr>
                        <?php else: ?>
                        <?php foreach ($logs as $log):
                            $lvl = $log['level'] ?? 'info';
                            $lvlClass = match($lvl) {
                                'error','critical' => 'sys-lvl-error',
                                'warning'          => 'sys-lvl-warning',
                                'info'             => 'sys-lvl-info',
                                'debug'            => 'sys-lvl-debug',
                                'success'          => 'sys-lvl-success',
                                default            => 'sys-lvl-info',
                            };
                            $ctx = $log['context'] ?? null;
                            $ctxStr = is_array($ctx) ? json_encode($ctx, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : (is_string($ctx) ? $ctx : '');
                        ?>
                        <tr>
                            <td class="mono" style="white-space:nowrap;font-size:11px;"><?= htmlspecialchars($log['created_at'] ?? '') ?></td>
                            <td><span class="sys-lvl <?= $lvlClass ?>"><?= strtoupper($lvl) ?></span></td>
                            <td class="mono" style="font-size:11px;color:#64748B;"><?= htmlspecialchars($log['channel'] ?? 'system') ?></td>
                            <td style="font-size:12.5px;color:#1F2937;word-break:break-word;"><?= htmlspecialchars($log['message'] ?? '') ?></td>
                            <td>
                                <?php if (!empty($ctxStr) && $ctxStr !== '[]'): ?>
                                <button onclick="this.closest('tr').querySelector('.ctx-row').classList.toggle('hidden')" class="sys-btn-pale" style="padding:3px 8px;font-size:10.5px;">JSON</button>
                                <div class="ctx-row hidden" style="font-family:monospace;font-size:10.5px;color:#475569;word-break:break-all;max-width:260px;margin-top:4px;"><?= htmlspecialchars($ctxStr) ?></div>
                                <?php else: ?>—<?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Terminal Live Output (hidden until tail is active) -->
            <div class="sys-card" id="tailCard" style="display:none;margin-top:16px;">
                <div class="sys-card-head">
                    <h3 class="sys-card-title">
                        <span class="sys-live-dot"></span>
                        Live Tail — Streaming
                    </h3>
                    <button class="sys-btn-danger" onclick="sysStopLogTail();document.getElementById('tailCard').style.display='none';" style="font-size:11px;">Stop</button>
                </div>
                <div class="sys-card-body" style="padding:0;">
                    <pre class="sys-log-pre" id="sysLogOutput">(Awaiting log entries…)</pre>
                </div>
            </div>

            <!-- Danger Modal (re-auth for flush) -->
            <div id="sysDangerModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);z-index:99999;align-items:center;justify-content:center;">
                <div style="background:#FFFFFF;border-radius:14px;padding:28px;max-width:440px;width:90%;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
                    <h3 style="font-size:16px;font-weight:800;color:#DC2626;margin:0 0 6px;display:flex;align-items:center;gap:8px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        Confirm Dangerous Operation
                    </h3>
                    <p style="font-size:13px;color:#64748B;margin:0 0 16px;" id="sysDangerLabel">Flush All System Logs</p>
                    <form method="POST" action="/api/system.php" id="sysDangerForm">
                        <input type="hidden" name="action" id="sysDangerAction">
                        <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
                        <div class="sys-field" style="margin-bottom:14px;">
                            <label class="sys-field-label">Confirm your admin password</label>
                            <input type="password" name="password" id="sysDangerPwd" class="sys-input" autocomplete="current-password" required>
                        </div>
                        <div style="display:flex;gap:8px;justify-content:flex-end;">
                            <button type="button" class="sys-btn-pale" onclick="sysCloseDangerModal()">Cancel</button>
                            <button type="submit" class="sys-btn-danger">Confirm &amp; Execute</button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?= time() ?>"></script>
<script src="/admin/system/system.js?v=<?= time() ?>"></script>
<script>
let tailActive = false;
function toggleTail() {
    tailActive = !tailActive;
    const btn  = document.getElementById('tailBtn');
    const dot  = document.getElementById('tailDot');
    const card = document.getElementById('tailCard');
    if (tailActive) {
        btn.textContent = 'Stop Live Tail';
        dot.style.display = 'inline-block';
        card.style.display = 'block';
        sysStartLogTail('<?= htmlspecialchars($level) ?>');
    } else {
        btn.innerHTML = '<span class="sys-live-dot"></span> Start Live Tail';
        dot.style.display = 'none';
        card.style.display = 'none';
        sysStopLogTail();
    }
}
</script>
</body>
</html>
