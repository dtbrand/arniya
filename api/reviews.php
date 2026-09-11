<?php
/**
 * api/reviews.php — Customer Reviews & Rating Moderation API
 * Section 30 (Reviews Admin)
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/cors.php';
cors_json();

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ReviewManager.php';
require_once __DIR__ . '/_guard.php';

use DTBrand\Database;
use DTBrand\ReviewManager;

try {
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $action = trim($_GET['action'] ?? '');

    // ─────────────────────────────────────────────────────────────
    // 1. GET ENDPOINTS
    // ─────────────────────────────────────────────────────────────
    if ($method === 'GET') {
        // A. Statistics Endpoint
        if ($action === 'stats') {
            $stats = ReviewManager::getReviewStats();
            echo json_encode(['success' => true, 'stats' => $stats], JSON_PRETTY_PRINT);
            exit;
        }

        // B. Audit Logs Endpoint (Admin Only)
        if ($action === 'audit') {
            dt_api_require_admin('view review audit logs');
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;
            $revId = isset($_GET['review_id']) ? (int)$_GET['review_id'] : null;
            $logs = ReviewManager::getAuditLogs($limit, $revId);
            echo json_encode(['success' => true, 'count' => count($logs), 'logs' => $logs], JSON_PRETTY_PRINT);
            exit;
        }

        // C. Single Review Inspector
        if ($action === 'inspect') {
            $id = (int)($_GET['id'] ?? 0);
            if ($id <= 0) {
                if (!headers_sent()) http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Valid review ID is required.']);
                exit;
            }
            $review = ReviewManager::getReviewById($id);
            if (!$review) {
                if (!headers_sent()) http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Review not found.']);
                exit;
            }
            echo json_encode(['success' => true, 'review' => $review], JSON_PRETTY_PRINT);
            exit;
        }

        // D. Filtered Review List (Supports Admin All/Pending/Rejected or Public Approved)
        $productId = (int)($_GET['product_id'] ?? 0);
        $rating = (int)($_GET['rating'] ?? 0);
        $statusParam = trim($_GET['status'] ?? '');
        $search = trim($_GET['search'] ?? '');
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;
        $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

        $isAdmin = dt_api_is_admin();

        $filters = [
            'limit' => $limit,
            'offset' => $offset
        ];

        if ($productId > 0) {
            $filters['product_id'] = $productId;
        }
        if ($rating > 0) {
            $filters['rating'] = $rating;
        }
        if ($search !== '') {
            $filters['search'] = $search;
        }

        if ($isAdmin && $statusParam !== '') {
            $filters['status'] = $statusParam;
        } else {
            // Public visitors only see approved reviews
            $filters['status'] = 'approved';
        }

        $reviews = ReviewManager::getReviews($filters);

        echo json_encode([
            'success' => true,
            'count' => count($reviews),
            'reviews' => $reviews
        ], JSON_PRETTY_PRINT);
        exit;
    }

    // ─────────────────────────────────────────────────────────────
    // 2. POST ENDPOINTS (Moderation, Replies & Submissions)
    // ─────────────────────────────────────────────────────────────
    if ($method === 'POST') {
        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true) ?: $_POST;

        $postAction = trim($data['action'] ?? '');
        $reviewId = (int)($data['id'] ?? ($data['review_id'] ?? 0));
        $reason = trim((string)($data['reason'] ?? ($data['notes'] ?? '')));
        $adminUser = $_SESSION['admin_user']['username'] ?? ($_SESSION['admin_user']['email'] ?? 'admin');

        // A. Store Reply Action
        if ($postAction === 'reply') {
            dt_api_require_admin('reply to reviews');

            if ($reviewId <= 0) {
                if (!headers_sent()) http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'A valid review id is required.']);
                exit;
            }

            $reply = trim((string)($data['reply'] ?? ''));
            if ($reply === '') {
                if (!headers_sent()) http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Reply text cannot be empty.']);
                exit;
            }

            $ok = ReviewManager::saveStoreReply($reviewId, $reply, $adminUser);
            if (!$ok) {
                if (!headers_sent()) http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Could not save the store reply.']);
                exit;
            }

            echo json_encode([
                'success' => true,
                'id' => $reviewId,
                'message' => 'Store reply published successfully.'
            ]);
            exit;
        }

        // B. Batch Moderation (Approve or Reject Multiple)
        if (in_array($postAction, ['batch_approve', 'batch_reject'], true)) {
            dt_api_require_admin('moderate reviews');
            $ids = $data['ids'] ?? [];
            if (!is_array($ids) || empty($ids)) {
                if (!headers_sent()) http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Array of review IDs is required.']);
                exit;
            }

            $targetStatus = $postAction === 'batch_approve' ? 'approved' : 'rejected';
            $affected = ReviewManager::batchModerate($ids, $targetStatus, $adminUser, $reason ?: 'Batch action');

            echo json_encode([
                'success' => true,
                'affected' => $affected,
                'message' => "$affected review(s) $targetStatus successfully."
            ]);
            exit;
        }

        // C. Single Moderation Actions
        if (in_array($postAction, ['approve', 'reject', 'flag', 'unpublish', 'delete'], true)) {
            dt_api_require_admin('moderate reviews');

            if ($reviewId <= 0) {
                if (!headers_sent()) http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'A valid review id is required.']);
                exit;
            }

            if ($postAction === 'delete') {
                $ok = ReviewManager::deleteReview($reviewId, $adminUser, $reason ?: 'Deleted by admin');
                $verb = 'deleted';
            } elseif ($postAction === 'approve') {
                $ok = ReviewManager::moderateReview($reviewId, 'approved', $adminUser, $reason ?: 'Approved by moderator');
                $verb = 'approved';
            } elseif ($postAction === 'unpublish') {
                $ok = ReviewManager::moderateReview($reviewId, 'pending', $adminUser, $reason ?: 'Unpublished from storefront');
                $verb = 'unpublished';
            } elseif ($postAction === 'flag') {
                $ok = ReviewManager::moderateReview($reviewId, 'flagged', $adminUser, $reason ?: 'Flagged for inspection');
                $verb = 'flagged';
            } else {
                $ok = ReviewManager::moderateReview($reviewId, 'rejected', $adminUser, $reason ?: 'Rejected by moderator');
                $verb = 'rejected';
            }

            if (!$ok) {
                if (!headers_sent()) http_response_code(500);
                echo json_encode(['success' => false, 'message' => "Could not update the review."]);
                exit;
            }

            echo json_encode([
                'success' => true,
                'id' => $reviewId,
                'message' => 'Review ' . $verb . ' successfully.'
            ]);
            exit;
        }

        // D. Customer Review Submission (Public or Admin Console)
        $text = trim((string)($data['review_text'] ?? ($data['text'] ?? ($data['comment'] ?? ''))));
        if (empty($text)) {
            if (!headers_sent()) http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Review text cannot be empty.']);
            exit;
        }

        $isAdmin = dt_api_is_admin();

        $created = ReviewManager::createReview($data, $isAdmin);

        echo json_encode([
            'success' => true,
            'id' => $created['id'],
            'status' => $created['status'],
            'message' => $isAdmin
                ? 'Review published.'
                : 'Thank you! Your review has been submitted and will appear once our team has checked it.'
        ]);
        exit;
    }

    if (!headers_sent()) http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);

} catch (\Throwable $e) {
    if (!headers_sent()) http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
