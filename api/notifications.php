<?php
/**
 * api/notifications.php — Multi-Channel Notification Engine REST API
 * Section 31 (Notification Admin)
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/cors.php';
cors_json();

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($method === 'OPTIONS') {
    if (!headers_sent()) {
        http_response_code(200);
    }
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/../src/NotificationManager.php';

use DTBrand\Database;
use DTBrand\Auth;
use DTBrand\NotificationManager;

try {
    $pdo = Database::getConnection();

    $rawInput = file_get_contents('php://input');
    $jsonData = json_decode($rawInput, true) ?: [];
    $data = !empty($jsonData) ? $jsonData : $_POST;
    $action = $data['action'] ?? ($_GET['action'] ?? '');

    // ─────────────────────────────────────────────────────────────
    // 1. SECTION 31 NOTIFICATION MANAGER ADMIN ACTIONS
    // ─────────────────────────────────────────────────────────────

    // AGGREGATE STATS
    if ($action === 'stats') {
        $stats = NotificationManager::getNotificationStats();
        echo json_encode(['success' => true, 'stats' => $stats]);
        exit;
    }

    // LIST TEMPLATES
    if ($action === 'templates') {
        $filters = [
            'channel' => $data['channel'] ?? ($_GET['channel'] ?? 'all'),
            'category' => $data['category'] ?? ($_GET['category'] ?? 'all'),
            'search' => $data['search'] ?? ($_GET['search'] ?? ''),
        ];
        $templates = NotificationManager::getTemplates($filters);
        echo json_encode(['success' => true, 'templates' => $templates]);
        exit;
    }

    // SAVE / UPDATE TEMPLATE
    if ($action === 'save_template') {
        $saved = NotificationManager::saveTemplate($data);
        if ($saved) {
            echo json_encode(['success' => true, 'message' => 'Template saved successfully']);
        } else {
            if (!headers_sent()) http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Template key, title, and content are required']);
        }
        exit;
    }

    // DELETE TEMPLATE
    if ($action === 'delete_template') {
        $id = (int)($data['id'] ?? ($_GET['id'] ?? 0));
        $deleted = NotificationManager::deleteTemplate($id);
        echo json_encode(['success' => $deleted, 'message' => $deleted ? 'Template deleted' : 'Failed to delete template']);
        exit;
    }

    // SEND NOTIFICATION / TEST DISPATCH
    if ($action === 'send_test' || $action === 'dispatch') {
        $channel = trim((string)($data['channel'] ?? 'whatsapp'));
        $recipient = trim((string)($data['recipient'] ?? ''));
        $templateKey = trim((string)($data['template_key'] ?? ($data['content'] ?? '')));
        $variables = is_array($data['variables'] ?? null) ? $data['variables'] : (json_decode($data['variables'] ?? '[]', true) ?: []);
        $options = [
            'subject' => $data['subject'] ?? null,
            'recipient_name' => $data['recipient_name'] ?? null,
            'order_id' => !empty($data['order_id']) ? (int)$data['order_id'] : null,
            'provider' => $data['provider'] ?? null,
            'simulate_fail' => !empty($data['simulate_fail'])
        ];

        if (empty($recipient) || empty($templateKey)) {
            if (!headers_sent()) http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Recipient and template/content are required']);
            exit;
        }

        $result = NotificationManager::sendNotification($channel, $recipient, $templateKey, $variables, $options);
        echo json_encode($result);
        exit;
    }

    // SINGLE MESSAGE RETRY
    if ($action === 'retry') {
        $logId = (int)($data['log_id'] ?? ($_GET['log_id'] ?? 0));
        $result = NotificationManager::retryMessage($logId);
        echo json_encode($result);
        exit;
    }

    // BATCH MESSAGE RETRY
    if ($action === 'batch_retry') {
        $logIds = is_array($data['log_ids'] ?? null) ? $data['log_ids'] : (json_decode($data['log_ids'] ?? '[]', true) ?: []);
        $result = NotificationManager::batchRetry($logIds);
        echo json_encode($result);
        exit;
    }

    // DELIVERY LOGS
    if ($action === 'logs') {
        $filters = [
            'channel' => $data['channel'] ?? ($_GET['channel'] ?? 'all'),
            'status' => $data['status'] ?? ($_GET['status'] ?? 'all'),
            'recipient' => $data['recipient'] ?? ($_GET['recipient'] ?? ''),
            'search' => $data['search'] ?? ($_GET['search'] ?? ''),
            'limit' => (int)($data['limit'] ?? ($_GET['limit'] ?? 50)),
            'offset' => (int)($data['offset'] ?? ($_GET['offset'] ?? 0)),
        ];
        $logs = NotificationManager::getLogs($filters);
        echo json_encode(['success' => true, 'logs' => $logs]);
        exit;
    }

    // FAILED MESSAGES (DEAD-LETTER QUEUE)
    if ($action === 'failed') {
        $filters = [
            'channel' => $data['channel'] ?? ($_GET['channel'] ?? 'all'),
            'search' => $data['search'] ?? ($_GET['search'] ?? ''),
            'limit' => (int)($data['limit'] ?? ($_GET['limit'] ?? 50)),
        ];
        $failed = NotificationManager::getFailedMessages($filters);
        echo json_encode(['success' => true, 'failed_messages' => $failed]);
        exit;
    }

    // PROVIDERS (MANDATORY SECRET MASKING)
    if ($action === 'providers') {
        $providers = NotificationManager::getProviders();
        echo json_encode(['success' => true, 'providers' => $providers]);
        exit;
    }

    // TEST PROVIDER CONNECTIVITY
    if ($action === 'test_provider') {
        $providerKey = trim((string)($data['provider_key'] ?? ($_GET['provider_key'] ?? '')));
        if (empty($providerKey)) {
            if (!headers_sent()) http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Provider key required']);
            exit;
        }
        $result = NotificationManager::testProvider($providerKey);
        echo json_encode($result);
        exit;
    }

    // ─────────────────────────────────────────────────────────────
    // 2. EXISTING USER NOTIFICATION ACTIONS (BELL & IN-APP)
    // ─────────────────────────────────────────────────────────────

    // MARK IN-APP NOTIFICATION AS READ
    if ($action === 'mark_read') {
        $id = (int)($data['id'] ?? ($_GET['id'] ?? 0));
        if ($pdo !== null && !Database::isMockMode()) {
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

    // CREATE IN-APP NOTIFICATION
    if ($action === 'create') {
        $title = trim((string)($data['title'] ?? ''));
        $message = trim((string)($data['message'] ?? ''));
        $type = trim((string)($data['type'] ?? 'info'));
        $link = trim((string)($data['link'] ?? ''));
        $userId = !empty($data['user_id']) ? (int)$data['user_id'] : null;
        $customerId = !empty($data['customer_id']) ? (int)$data['customer_id'] : null;

        if (empty($title) || empty($message)) {
            if (!headers_sent()) http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Title and message are required']);
            exit;
        }

        $notifId = 0;
        if ($pdo !== null && !Database::isMockMode()) {
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

    // DELETE IN-APP NOTIFICATION
    if ($action === 'delete') {
        $id = (int)($data['id'] ?? ($_GET['id'] ?? 0));
        if ($id > 0 && $pdo !== null && !Database::isMockMode()) {
            $stmt = $pdo->prepare("DELETE FROM notifications WHERE id = ?");
            $stmt->execute([$id]);
        }
        echo json_encode(['success' => true, 'message' => 'Notification deleted']);
        exit;
    }

    // ─────────────────────────────────────────────────────────────
    // 3. DEFAULT GET FEED (BELL / HEADER POLLING)
    // ─────────────────────────────────────────────────────────────
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
    if (!headers_sent()) http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Notification error: ' . $e->getMessage()]);
    exit;
}
