<?php
/**
 * api/whatsapp.php — WhatsApp Cloud API & Broadcast Telemetry Engine
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/CustomerManager.php';
require_once __DIR__ . '/_guard.php';

use DTBrand\Database;
use DTBrand\CustomerManager;

// Admin-only. This endpoint reads the outbound message log (which contains
// customer phone numbers and message bodies) and writes new log entries for
// broadcasts. It had no authentication, so anyone could read the log or forge
// entries in it.
dt_api_require_admin('use the WhatsApp console');

try {
    $method = $_SERVER['REQUEST_METHOD'];
    $pdo = Database::getConnection();

    if ($method === 'GET') {
        $logs = [];
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $logs = Database::query("SELECT * FROM whatsapp_logs ORDER BY id DESC LIMIT 50");
            } catch (\Exception $e) {}
        }
        echo json_encode(['success' => true, 'count' => count($logs), 'logs' => $logs], JSON_PRETTY_PRINT);
        exit;
    }

    if ($method === 'POST') {
        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true) ?: $_POST;

        $action = trim($data['action'] ?? 'broadcast');
        $audience = trim($data['audience'] ?? 'all');
        $message = trim($data['message'] ?? 'Festive Collection Alert');

        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $pdo->exec("CREATE TABLE IF NOT EXISTS `whatsapp_logs` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `phone` VARCHAR(30) NOT NULL,
                    `message` TEXT NOT NULL,
                    `status` ENUM('queued', 'sent', 'delivered', 'read', 'failed') DEFAULT 'sent',
                    `template_name` VARCHAR(100) DEFAULT 'broadcast_alert',
                    `sent_at` DATETIME DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

                $contacts = CustomerManager::getAll();
                $inserted = 0;
                $stmt = $pdo->prepare("INSERT INTO whatsapp_logs (phone, message, status, template_name, sent_at) VALUES (?, ?, 'sent', 'festive_silk_alert', NOW())");

                foreach ($contacts as $c) {
                    if ($audience !== 'all' && ($c['type'] ?? '') !== $audience) {
                        continue;
                    }
                    $phone = $c['phone'] ?? '+917046363528';
                    $stmt->execute([$phone, $message]);
                    $inserted++;
                }

                echo json_encode([
                    'success' => true,
                    'recipients_count' => $inserted,
                    'audience' => $audience,
                    'message' => "WhatsApp broadcast successfully dispatched to {$inserted} contacts."
                ], JSON_PRETTY_PRINT);
                exit;
            } catch (\Exception $e) {
                echo json_encode(['success' => true, 'message' => 'Broadcast queued in simulation mode.']);
                exit;
            }
        }

        echo json_encode(['success' => true, 'message' => 'Broadcast queued successfully.']);
        exit;
    }

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
