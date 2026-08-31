<?php
/**
 * api/whatsapp/audience.php — Broadcast audience builder
 * DT Brand's & Jai Hanuman Tex
 *
 * Returns active customers of a given type (with real phone numbers) for the
 * broadcast launcher's wa.me link generation. Admin-gated: the payload is a
 * portion of the customer contact book.
 */

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../_guard.php';

use DTBrand\Database;

dt_api_require_admin('build a WhatsApp broadcast audience');

$allowed = ['wholesale', 'reseller', 'retailer', 'retail'];
$type = strtolower(trim((string)($_GET['type'] ?? '')));
if (!in_array($type, $allowed, true)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Unknown audience type. Use: ' . implode(', ', $allowed) . '.']);
    exit;
}

$pdo = Database::getConnection();
if ($pdo === null || Database::isMockMode()) {
    http_response_code(503);
    echo json_encode(['success' => false, 'message' => 'Database unreachable.']);
    exit;
}

try {
    $customers = Database::query(
        "SELECT name, phone FROM customers
         WHERE type = ? AND status = 'active' AND phone != ''
         ORDER BY lifetime_spend DESC, id ASC
         LIMIT 500",
        [$type]
    );
    echo json_encode(['success' => true, 'type' => $type, 'count' => count($customers), 'customers' => $customers]);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}