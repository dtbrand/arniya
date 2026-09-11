<?php
declare(strict_types=1);
/* DT admin access guard */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/system/environment.php — PHP, Server & Extension Environment Inspector
 * DT Brand's & Jai Hanuman Tex — Section 36
 */
require_once __DIR__ . '/../../src/SystemManager.php';
use DTBrand\SystemManager;

$sm  = SystemManager::getInstance();
$env = $sm->getEnvironmentInfo();

$active_nav    = 'system';
$active_subnav = 'environment';
$page_title    = 'Server Environment — DT Brand\'s';

/* ── Helper: requirement check ── */
function envCheck(string $label, mixed $val, mixed $required, string $mode = 'ge'): array {
    $pass = match($mode) {
        'ge'  => (float)$val >= (float)$required,
        'eq'  => $val === $required,
        'set' => !empty($val) && $val !== '0' && $val !== 'Off',
        'ext' => extension_loaded((string)$required),
        default => true,
    };
    return ['label' => $label, 'val' => $val, 'required' => $required, 'pass' => $pass];
}

$reqs = [
    envCheck('PHP Version',                 PHP_VERSION,                       '8.1',    'ge'),
    envCheck('OPcache Extension',           function_exists('opcache_reset') ? 'Enabled' : 'Disabled', 'opcache', 'ext'),
    envCheck('PDO MySQL Extension',         class_exists('PDO') && in_array('mysql', \PDO::getAvailableDrivers()) ? 'Enabled' : 'Missing', 'pdo_mysql', 'ext'),
    envCheck('cURL Extension',              extension_loaded('curl')   ? 'Enabled' : 'Missing', 'curl',   'ext'),
    envCheck('GD / Imagick',               (extension_loaded('gd') || extension_loaded('imagick')) ? 'Enabled' : 'Missing', 'gd', 'ext'),
    envCheck('JSON Extension',              extension_loaded('json')  ? 'Enabled' : 'Missing', 'json',   'ext'),
    envCheck('mbstring Extension',          extension_loaded('mbstring') ? 'Enabled' : 'Missing', 'mbstring', 'ext'),
    envCheck('openssl Extension',           extension_loaded('openssl') ? 'Enabled' : 'Missing', 'openssl', 'ext'),
    envCheck('zip Extension',               extension_loaded('zip')   ? 'Enabled' : 'Missing', 'zip',    'ext'),
    envCheck('Memory Limit',               ini_get('memory_limit'),            '128M',   'ge'),
    envCheck('Upload Max Filesize',        ini_get('upload_max_filesize'),     '32M',    'ge'),
    envCheck('Post Max Size',              ini_get('post_max_size'),           '32M',    'ge'),
    envCheck('Max Execution Time',         (string)((int)ini_get('max_execution_time') >= 60 ? ini_get('max_execution_time') : ini_get('max_execution_time')), '60', 'ge'),
    envCheck('Display Errors',             ini_get('display_errors') ? 'On' : 'Off',    'Off',    'eq'),
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
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg>
                        Server Environment
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0;color:#64748B;font-size:.82rem;">PHP runtime, server software, loaded extensions, and INI configuration requirements.</p>
                </div>
                <a href="/admin/system/" class="sys-btn-pale">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="15 18 9 12 15 6"/></svg>
                    Back to Suite
                </a>
            </div>

            <!-- Requirements Grid -->
            <div class="sys-card">
                <div class="sys-card-head">
                    <h3 class="sys-card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        PHP & Extension Requirements
                    </h3>
                    <?php $fails = count(array_filter($reqs, fn($r) => !$r['pass'])); ?>
                    <span class="sys-health-badge <?= $fails === 0 ? 'pass' : 'fail' ?>">
                        <?= $fails === 0 ? 'All Passed' : $fails . ' Failed' ?>
                    </span>
                </div>
                <div class="sys-table-wrap">
                    <table class="sys-table">
                        <thead>
                            <tr>
                                <th>Requirement</th>
                                <th>Required</th>
                                <th>Current Value</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($reqs as $r): ?>
                            <tr>
                                <td style="font-weight:700;color:#1F2937;"><?= htmlspecialchars($r['label']) ?></td>
                                <td class="mono"><?= htmlspecialchars((string)$r['required']) ?></td>
                                <td class="mono"><?= htmlspecialchars((string)$r['val']) ?></td>
                                <td>
                                    <?php if ($r['pass']): ?>
                                    <span class="sys-health-badge pass">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8"><polyline points="20 6 9 17 4 12"/></svg>
                                        Pass
                                    </span>
                                    <?php else: ?>
                                    <span class="sys-health-badge fail">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                        Fail
                                    </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Full Environment Info -->
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:16px;margin-top:16px;">
                <!-- Server Info -->
                <div class="sys-card">
                    <div class="sys-card-head">
                        <h3 class="sys-card-title">Server Information</h3>
                    </div>
                    <div class="sys-card-body" style="padding:0;">
                        <?php
                        $server = [
                            'OS'                   => $env['os']            ?? PHP_OS_FAMILY,
                            'Server Software'      => $env['web_server']    ?? ($_SERVER['SERVER_SOFTWARE'] ?? 'Apache'),
                            'PHP Version'          => PHP_VERSION,
                            'PHP SAPI'             => PHP_SAPI,
                            'Server Name'          => $_SERVER['SERVER_NAME'] ?? 'localhost',
                            'Document Root'        => $_SERVER['DOCUMENT_ROOT'] ?? '/',
                            'Default Timezone'     => date_default_timezone_get(),
                            'Current Server Time'  => date('Y-m-d H:i:s T'),
                        ];
                        foreach ($server as $k => $v): ?>
                        <div class="sys-list-item" style="padding:10px 16px;">
                            <div class="sys-list-body">
                                <div class="sys-list-name" style="font-size:12px;"><?= htmlspecialchars($k) ?></div>
                                <div class="sys-list-meta"><?= htmlspecialchars($v) ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- PHP INI Values -->
                <div class="sys-card">
                    <div class="sys-card-head">
                        <h3 class="sys-card-title">PHP INI Values</h3>
                    </div>
                    <div class="sys-card-body" style="padding:0;">
                        <?php
                        $ini = [
                            'memory_limit'          => ini_get('memory_limit'),
                            'upload_max_filesize'   => ini_get('upload_max_filesize'),
                            'post_max_size'         => ini_get('post_max_size'),
                            'max_execution_time'    => ini_get('max_execution_time') . 's',
                            'max_input_time'        => ini_get('max_input_time') . 's',
                            'max_file_uploads'      => ini_get('max_file_uploads'),
                            'default_charset'       => ini_get('default_charset'),
                            'date.timezone'         => ini_get('date.timezone'),
                            'display_errors'        => ini_get('display_errors') ? 'On' : 'Off',
                            'log_errors'            => ini_get('log_errors') ? 'On' : 'Off',
                            'error_log'             => ini_get('error_log') ?: '(system default)',
                        ];
                        foreach ($ini as $k => $v): ?>
                        <div class="sys-list-item" style="padding:10px 16px;">
                            <div class="sys-list-body">
                                <div class="sys-list-name" style="font-size:11.5px;font-family:monospace;"><?= htmlspecialchars($k) ?></div>
                                <div class="sys-list-meta"><?= htmlspecialchars($v) ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Loaded Extensions -->
            <div class="sys-card" style="margin-top:16px;">
                <div class="sys-card-head">
                    <h3 class="sys-card-title">Loaded PHP Extensions (<?= count(get_loaded_extensions()) ?>)</h3>
                </div>
                <div class="sys-card-body">
                    <div style="display:flex;flex-wrap:wrap;gap:6px;">
                        <?php foreach (get_loaded_extensions() as $ext): ?>
                        <span style="display:inline-block;padding:3px 10px;background:#F1F5F9;border:1px solid #E2E8F0;border-radius:6px;font-size:11.5px;font-weight:600;color:#374151;font-family:monospace;"><?= htmlspecialchars($ext) ?></span>
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
</body>
</html>
