<?php
declare(strict_types=1);
/* DT admin access guard */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/system/database.php — Database Tools & Inspector
 * DT Brand's & Jai Hanuman Tex — Section 36
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/SystemManager.php';

use DTBrand\Database;
use DTBrand\SystemManager;

$sm   = SystemManager::getInstance();
$pdo  = Database::getConnection();
$csrf = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(16));
$_SESSION['csrf_token'] = $csrf;

$tables = [];
$dbSize = 0;
$dbName = '';

if ($pdo !== null && !Database::isMockMode()) {
    try {
        $dbName = (string)$pdo->query("SELECT DATABASE()")->fetchColumn();
        $rows = $pdo->query("
            SELECT table_name, table_rows, data_length, index_length, data_free,
                   create_time, update_time, engine, table_collation
            FROM information_schema.tables
            WHERE table_schema = DATABASE()
            ORDER BY data_length + index_length DESC
        ")->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($rows as $r) {
            $sz = (int)($r['data_length'] ?? 0) + (int)($r['index_length'] ?? 0);
            $dbSize += $sz;
            $tables[] = array_merge($r, ['total_size' => $sz]);
        }
    } catch (\Exception $e) { $tables = []; }
}

function fmtB(int $b): string {
    if ($b >= 1048576) return round($b/1048576,2).' MB';
    if ($b >= 1024)    return round($b/1024,2).' KB';
    return $b.' B';
}

$active_nav    = 'system';
$active_subnav = 'database';
$page_title    = 'Database Tools — DT Brand\'s';
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
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
                        Database Tools
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0;color:#64748B;font-size:.82rem;">Table inspector, size analysis, and one-click OPTIMIZE for all InnoDB tables.</p>
                </div>
                <div style="display:flex;gap:8px;">
                    <button class="sys-btn-gold" onclick="sysDbOptimize()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        Optimize All Tables
                    </button>
                    <a href="/admin/system/" class="sys-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="15 18 9 12 15 6"/></svg>
                        Suite
                    </a>
                </div>
            </div>

            <!-- Connection Stats -->
            <div class="sys-health-grid" style="margin-bottom:20px;">
                <div class="sys-health-card <?= $pdo !== null ? 'pass' : 'fail' ?>">
                    <div class="sys-health-icon <?= $pdo !== null ? 'pass' : 'fail' ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
                    </div>
                    <div class="sys-health-label">Connection</div>
                    <div class="sys-health-value"><?= $pdo !== null ? 'Active' : 'Failed' ?></div>
                    <div class="sys-health-meta">MySQL PDO Driver</div>
                </div>
                <div class="sys-health-card pass">
                    <div class="sys-health-icon pass">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <div class="sys-health-label">Database Name</div>
                    <div class="sys-health-value" style="font-size:11px;font-family:monospace;"><?= htmlspecialchars($dbName ?: 'N/A') ?></div>
                    <div class="sys-health-meta">Active schema</div>
                </div>
                <div class="sys-health-card pass">
                    <div class="sys-health-icon pass">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/></svg>
                    </div>
                    <div class="sys-health-label">Tables</div>
                    <div class="sys-health-value"><?= count($tables) ?></div>
                    <div class="sys-health-meta">All table types</div>
                </div>
                <div class="sys-health-card pass">
                    <div class="sys-health-icon pass">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <div class="sys-health-label">Total DB Size</div>
                    <div class="sys-health-value"><?= fmtB($dbSize) ?></div>
                    <div class="sys-health-meta">Data + indexes</div>
                </div>
            </div>

            <!-- Table Inspector -->
            <div class="sys-card">
                <div class="sys-card-head">
                    <h3 class="sys-card-title">Table Inspector</h3>
                    <input type="text" id="tableSearch" class="sys-input" placeholder="Filter tables…"
                        oninput="filterTables()" style="width:180px;padding:5px 10px;font-size:12px;">
                </div>
                <div class="sys-table-wrap">
                    <table class="sys-table" id="dbTableList">
                        <thead>
                            <tr>
                                <th>Table Name</th>
                                <th>Engine</th>
                                <th>Rows</th>
                                <th>Data</th>
                                <th>Index</th>
                                <th>Fragments</th>
                                <th>Collation</th>
                                <th>Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($tables)): ?>
                            <tr><td colspan="8" style="padding:24px;text-align:center;color:#94A3B8;font-size:13px;">No tables found or DB connection unavailable.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($tables as $t):
                            $frag = (int)($t['data_free'] ?? 0);
                        ?>
                        <tr class="db-table-row">
                            <td class="mono" style="font-weight:700;color:#1F2937;"><?= htmlspecialchars($t['table_name']) ?></td>
                            <td><span class="sys-health-badge" style="background:#EFF6FF;color:#1D4ED8;font-size:.6rem;"><?= htmlspecialchars($t['engine'] ?? 'InnoDB') ?></span></td>
                            <td class="mono"><?= number_format((int)($t['table_rows'] ?? 0)) ?></td>
                            <td class="mono"><?= fmtB((int)($t['data_length'] ?? 0)) ?></td>
                            <td class="mono"><?= fmtB((int)($t['index_length'] ?? 0)) ?></td>
                            <td>
                                <?php if ($frag > 0): ?>
                                <span class="sys-health-badge warn" style="font-size:.6rem;"><?= fmtB($frag) ?></span>
                                <?php else: ?>
                                <span style="font-size:11px;color:#15803D;font-weight:700;">Clean</span>
                                <?php endif; ?>
                            </td>
                            <td style="font-size:11px;color:#64748B;font-family:monospace;"><?= htmlspecialchars(str_replace('_', ' ', $t['table_collation'] ?? '')) ?></td>
                            <td class="mono" style="font-size:11px;"><?= htmlspecialchars(!empty($t['update_time']) ? substr($t['update_time'], 0, 16) : '—') ?></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MySQL Server Variables -->
            <?php if ($pdo !== null): ?>
            <div class="sys-card" style="margin-top:16px;">
                <div class="sys-card-head"><h3 class="sys-card-title">MySQL Server Variables</h3></div>
                <div class="sys-card-body">
                    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:10px;">
                    <?php
                    try {
                        $vRows = $pdo->query("SHOW VARIABLES WHERE Variable_name IN ('version','version_comment','max_connections','max_allowed_packet','innodb_buffer_pool_size','character_set_server','collation_server','time_zone')")->fetchAll(\PDO::FETCH_KEY_PAIR);
                    } catch (\Exception $e) { $vRows = []; }
                    foreach ($vRows as $vk => $vv):
                        $display = is_numeric($vv) && (int)$vv > 1048576 ? fmtB((int)$vv) : $vv;
                    ?>
                    <div style="padding:10px 12px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:8px;">
                        <div style="font-size:10px;font-weight:700;text-transform:uppercase;color:#64748B;font-family:monospace;margin-bottom:3px;"><?= htmlspecialchars($vk) ?></div>
                        <div style="font-size:12.5px;font-weight:800;color:#111827;font-family:monospace;"><?= htmlspecialchars($display) ?></div>
                    </div>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?= time() ?>"></script>
<script src="/admin/system/system.js?v=<?= time() ?>"></script>
<script>
function filterTables() {
    const q = document.getElementById('tableSearch').value.toLowerCase();
    document.querySelectorAll('#dbTableList .db-table-row').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}
async function sysDbOptimize() {
    if (!confirm('Run OPTIMIZE TABLE on all tables? Tables may be briefly locked.')) return;
    try {
        const data = await sysPost('/api/system.php', { action: 'db_optimize', _csrf: '<?= htmlspecialchars($csrf) ?>' });
        sysToast(data.message || 'Done.', data.success ? 'success' : 'error');
        if (data.success) setTimeout(() => location.reload(), 2000);
    } catch(e) { sysToast('Optimize failed.', 'error'); }
}
</script>
</body>
</html>
