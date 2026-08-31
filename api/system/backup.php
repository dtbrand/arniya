<?php
/**
 * api/system/backup.php — Real database snapshot endpoint
 * DT Brand's & Jai Hanuman Tex
 *
 * Backs admin/system/backups.php. That page shipped three invented snapshot
 * rows ("mysql_demodt121_auto_hourly.sql.gz — Verified SHA-256") and
 * Create/Download/Verify buttons that only raised toasts — no snapshot
 * machinery existed at all. The previous scripts/backup-database.php wrote a
 * 6-line stub file, which was worse than nothing: a fake backup is a disaster
 * recovery plan that fails on the day it is needed.
 *
 * This endpoint produces a genuine .sql dump of every table in the current
 * database (schema + rows) via PDO SHOW CREATE TABLE / SELECT, stores it in
 * the git-ignored backups/ directory, and lists what is actually on disk.
 * Actions: POST create | POST verify | GET list (default)
 */

if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
}

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../_guard.php';

use DTBrand\Database;

dt_api_require_admin('manage database backups');

// Super-admin only: a dump contains every customer row, password hash and
// order record in the business.
$sessionRole = strtolower((string)($_SESSION['admin_user']['role'] ?? ''));
if ($sessionRole !== 'super_admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Only a Super Admin may create or verify database backups.']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$backupDir = dirname(__DIR__, 2) . '/backups';
if (!is_dir($backupDir)) {
    @mkdir($backupDir, 0755, true);
}

$pdo = Database::getConnection();
if ($pdo === null || Database::isMockMode()) {
    http_response_code(503);
    echo json_encode(['success' => false, 'message' => 'Database unreachable — no snapshot possible.']);
    exit;
}

/** @return array<int,array<string,mixed>> real files on disk, newest first */
function dt_backup_list(string $dir): array
{
    $out = [];
    foreach (glob($dir . '/dt_snapshot_*.sql') ?: [] as $f) {
        $out[] = [
            'name'      => basename($f),
            'size'      => (int)filesize($f),
            'size_h'    => filesize($f) >= 1048576
                ? number_format(filesize($f) / 1048576, 2) . ' MB'
                : number_format(filesize($f) / 1024, 1) . ' KB',
            'sha256'    => hash_file('sha256', $f),
            'created'   => date('d M Y, h:i A', (int)filemtime($f)),
            'mtime'     => (int)filemtime($f),
        ];
    }
    usort($out, static fn($a, $b) => $b['mtime'] <=> $a['mtime']);
    return $out;
}

if ($method === 'POST' && ($_POST['action'] ?? '') === 'verify') {
    $name = basename(trim((string)($_POST['name'] ?? '')));
    $path = $backupDir . '/' . $name;
    if ($name === '' || !is_file($path) || strpos(realpath($path), realpath($backupDir)) !== 0) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Snapshot not found: ' . $name]);
        exit;
    }
    // A snapshot is only verifiable if it parses as SQL: check it has the
    // header, at least one CREATE TABLE, and ends complete.
    $head = (string)file_get_contents($path, false, null, 0, 4096);
    $tail = (string)file_get_contents($path, false, null, max(0, filesize($path) - 256));
    $ok = strpos($head, '-- DT Brand\'s database snapshot') === 0
        && strpos((string)file_get_contents($path), 'CREATE TABLE') !== false
        && strpos($tail, 'SET FOREIGN_KEY_CHECKS=1;') !== false;
    echo json_encode([
        'success' => $ok,
        'name' => $name,
        'message' => $ok ? 'Snapshot verified: header, schema and completion marker all present.' : 'Snapshot is corrupt or incomplete — take a fresh one.',
    ]);
    exit;
}

if ($method === 'POST' && ($_POST['action'] ?? '') === 'create') {
    @set_time_limit(300);
    try {
        $tables = $pdo->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);
        $stamp = date('Ymd_His');
        $name = 'dt_snapshot_' . $stamp . '.sql';
        $path = $backupDir . '/' . $name;

        $fh = fopen($path, 'w');
        if ($fh === false) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Could not write to the backups directory.']);
            exit;
        }
        fwrite($fh, "-- DT Brand's database snapshot\n");
        fwrite($fh, '-- Generated: ' . date('c') . "\n");
        fwrite($fh, "-- Database: " . getenv('DB_NAME') . "\n\n");
        fwrite($fh, "SET FOREIGN_KEY_CHECKS=0;\n\n");

        foreach ($tables as $table) {
            $create = $pdo->query("SHOW CREATE TABLE `" . str_replace('`', '', (string)$table) . "`")->fetch(\PDO::FETCH_NUM);
            if (!$create) continue;
            fwrite($fh, "DROP TABLE IF EXISTS `{$table}`;\n");
            fwrite($fh, $create[1] . ";\n\n");

            $stmt = $pdo->query("SELECT * FROM `{$table}`");
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $cols = '`' . implode('`, `', array_keys($row)) . '`';
                $vals = array_map(static fn($v) => $v === null ? 'NULL' : $pdo->quote((string)$v), array_values($row));
                fwrite($fh, "INSERT INTO `{$table}` ({$cols}) VALUES (" . implode(', ', $vals) . ");\n");
            }
            fwrite($fh, "\n");
        }

        fwrite($fh, "SET FOREIGN_KEY_CHECKS=1;\n");
        fclose($fh);

        echo json_encode([
            'success' => true,
            'name' => $name,
            'size' => filesize($path),
            'sha256' => hash_file('sha256', $path),
            'tables' => count($tables),
            'message' => 'Snapshot ' . $name . ' created (' . count($tables) . ' tables).',
        ]);
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Snapshot failed: ' . $e->getMessage()]);
    }
    exit;
}

// GET list — real files only.
echo json_encode([
    'success' => true,
    'count' => count(dt_backup_list($backupDir)),
    'backups' => dt_backup_list($backupDir),
]);