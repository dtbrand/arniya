<?php
/**
 * api/db_optimize.php — Optimize every table in the current database
 * DT Brand's & Jai Hanuman Tex
 *
 * Backs the "Optimize Tables" button on admin/system/database.php, which used
 * to toast "All N tables optimized & defragmented" without touching MySQL.
 */

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/_guard.php';

use DTBrand\Database;

dt_api_require_admin('optimize database tables');

$sessionRole = strtolower((string)($_SESSION['admin_user']['role'] ?? ''));
if ($sessionRole !== 'super_admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Only a Super Admin may run table optimization.']);
    exit;
}

$pdo = Database::getConnection();
if ($pdo === null || Database::isMockMode()) {
    http_response_code(503);
    echo json_encode(['success' => false, 'message' => 'Database unreachable — nothing was optimized.']);
    exit;
}

try {
    $tables = $pdo->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);
    $details = [];
    $optimized = 0;
    foreach ($tables as $table) {
        $safe = str_replace('`', '', (string)$table);
        try {
            $res = $pdo->query("OPTIMIZE TABLE `{$safe}`")->fetchAll(\PDO::FETCH_ASSOC);
            $msgTable = $res[0]['Table'] ?? $safe;
            $msgText  = $res[0]['Msg_text'] ?? 'OK';
            $details[] = $msgTable . ': ' . $msgText;
            $optimized++;
        } catch (\Throwable $e) {
            $details[] = $safe . ': skipped (' . $e->getMessage() . ')';
        }
    }
    echo json_encode([
        'success' => true,
        'optimized' => $optimized,
        'total' => count($tables),
        'details' => $details,
        'message' => "Optimized {$optimized} of " . count($tables) . " tables.",
    ]);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Optimize failed: ' . $e->getMessage()]);
}