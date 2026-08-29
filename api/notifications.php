<?php
/**
 * api/notifications.php — Real-Time Admin & Customer Notification Feed REST API
 * DT Brand's & Jai Hanuman Tex
 */

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
}

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Auth.php';

use DTBrand\Database;
use DTBrand\Auth;

try {
    $pdo = Database::getConnection();

    // ── 1. WRITE ACTIONS (POST / DELETE) ──
    if ($method === 'POST' || $method === 'DELETE') {
        $rawInput = file_get_contents('php://input');
        $jsonData = json_decode($rawInput, true) ?: [];
        $data = !empty($jsonData) ? $jsonData : $_POST;
        $action = $data['action'] ?? ($_GET['action'] ?? 'mark_read');

        // MARK NOTIFICATION AS READ
        if ($action === 'mark_read') {
            $id = (int)($data['id'] ?? ($_GET['id'] ?? 0));
            if ($pdo !== null) {
                if ($id > 0) {
                    $stmt = $pdo->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
                    $stmt->execute([$id]);
                } else {
                    $pdo->exec("UPDATE notifications SET is_read = 1 WHERE is_read = 0");
                }
            }
            echo json_encode(['success' => true, 'message' => 'Notifications marked as read']);
            exit;
        }

        // CREATE NEW NOTIFICATION
        if ($action === 'create') {
            $title = trim((string)($data['title'] ?? ''));
            $message = trim((string)($data['message'] ?? ''));
            $type = trim((string)($data['type'] ?? 'info'));
            $link = trim((string)($data['link'] ?? ''));
            $userId = !empty($data['user_id']) ? (int)$data['user_id'] : null;
            $customerId = !empty($data['customer_id']) ? (int)$data['customer_id'] : null;

            if (empty($title) || empty($message)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Title and message are required']);
                exit;
            }

            $notifId = 0;
            if ($pdo !== null) {
                $stmt = $pdo->prepare("
                    INSERT INTO notifications (user_id, customer_id, type, title, message, link, is_read, created_at)
                    VALUES (?, ?, ?, ?, ?, ?, 0, NOW())
                ");
                $stmt->execute([$userId, $customerId, $type, $title, $message, $link]);
                $notifId = (int)$pdo->lastInsertId();
            }

            echo json_encode([
                'success' => true,
                'notification_id' => $notifId,
                'message' => 'Notification created successfully'
            ]);
            exit;
        }

        // DELETE NOTIFICATION
        if ($action === 'delete') {
            $id = (int)($data['id'] ?? ($_GET['id'] ?? 0));
            if ($id > 0 && $pdo !== null) {
                $stmt = $pdo->prepare("DELETE FROM notifications WHERE id = ?");
                $stmt->execute([$id]);
            }
            echo json_encode(['success' => true, 'message' => 'Notification deleted']);
            exit;
        }
    }

    // ── 2. READ ACTIONS (GET) ──
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
    $unreadOnly = !empty($_GET['unread_only']);

    $notifications = [];
    $unreadCount = 0;

    if ($pdo !== null && !Database::isMockMode()) {
        $whereSql = $unreadOnly ? "WHERE is_read = 0" : "";
        $stmt = $pdo->prepare("SELECT * FROM notifications {$whereSql} ORDER BY id DESC LIMIT ?");
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        $notifications = $stmt->fetchAll() ?: [];

        $cntRow = $pdo->query("SELECT COUNT(*) as unread FROM notifications WHERE is_read = 0")->fetch();
        $unreadCount = (int)($cntRow['unread'] ?? 0);
    } else {
        $notifications = [
            [
                'id' => 1,
                'type' => 'order',
                'title' => 'New Wholesale Order #DT-88921',
                'message' => 'Shree Balaji Sarees (Ahmedabad) placed a wholesale bale order of ₹45,000.',
                'link' => '/admin/orders/view.php?id=1',
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s', strtotime('-15 minutes'))
            ],
            [
                'id' => 2,
                'type' => 'inventory',
                'title' => 'Low Stock Alert: Kanjivaram Brocade',
                'message' => 'SKU: KLN-SR-111 has only 3 physical pieces left in Surat Loom Depot.',
                'link' => '/admin/products/variants/',
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 hour'))
            ]
        ];
        $unreadCount = 2;
    }

    echo json_encode([
        'success' => true,
        'unread_count' => $unreadCount,
        'notifications' => $notifications
    ], JSON_PRETTY_PRINT);
    exit;

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Notification error: ' . $e->getMessage()]);
    exit;
}
