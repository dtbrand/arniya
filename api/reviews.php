<?php
/**
 * api/reviews.php — Customer Reviews & Rating Engine
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
require_once __DIR__ . '/_guard.php';

use DTBrand\Database;

try {
    $method = $_SERVER['REQUEST_METHOD'];
    $productId = (int)($_GET['product_id'] ?? 0);

    if ($method === 'GET') {
        $reviews = [];
        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            if ($productId > 0) {
                $reviews = Database::query("SELECT * FROM reviews WHERE product_id = ? AND status = 'approved' ORDER BY id DESC", [$productId]);
            } else {
                $reviews = Database::query("SELECT * FROM reviews WHERE status = 'approved' ORDER BY id DESC LIMIT 20");
            }
        }

        // No invented reviews. This used to return three hardcoded testimonials
        // ("Priya Sharma", "Ananya Mehta", "Dr. Radhika Iyer") whenever the table
        // was empty, which showed shoppers fabricated social proof for products
        // nobody had reviewed. An empty list is the truth; the storefront should
        // render its "no reviews yet" state.
        echo json_encode(['success' => true, 'count' => count($reviews), 'reviews' => $reviews], JSON_PRETTY_PRINT);
        exit;
    }

    if ($method === 'POST') {
        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true) ?: $_POST;

        $action = trim($data['action'] ?? '');
        $reviewId = (int)($data['id'] ?? 0);
        $pdo = Database::getConnection();

        // Moderation is admin-only. Without this, any visitor could approve
        // their own review, reject a genuine one, or delete the whole table's
        // worth of feedback one id at a time.
        if ($action === 'reply') {
            dt_api_require_admin('reply to reviews');

            if ($reviewId <= 0) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'A valid review id is required.']);
                exit;
            }
            $reply = trim((string)($data['reply'] ?? ''));
            if ($reply === '') {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Reply text cannot be empty.']);
                exit;
            }
            if ($pdo === null || Database::isMockMode()) {
                http_response_code(503);
                echo json_encode(['success' => false, 'message' => 'Database unavailable — the reply was not saved.']);
                exit;
            }
            // store_reply must exist; older installs get it on first use.
            try {
                $col = $pdo->query("SHOW COLUMNS FROM reviews LIKE 'store_reply'")->fetch();
                if (!$col) {
                    $pdo->exec("ALTER TABLE reviews ADD COLUMN store_reply TEXT NULL AFTER review_text");
                }
                $stmt = $pdo->prepare("UPDATE reviews SET store_reply = ? WHERE id = ?");
                $stmt->execute([$reply, $reviewId]);
            } catch (\Throwable $e) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Could not save the reply: ' . $e->getMessage()]);
                exit;
            }
            if ($stmt->rowCount() === 0) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'No review found with id ' . $reviewId . '.']);
                exit;
            }
            echo json_encode(['success' => true, 'id' => $reviewId, 'message' => 'Store reply published.']);
            exit;
        }

        if (in_array($action, ['delete', 'approve', 'reject', 'unpublish'], true)) {
            dt_api_require_admin('moderate reviews');

            if ($reviewId <= 0) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'A valid review id is required.']);
                exit;
            }
            if ($pdo === null || Database::isMockMode()) {
                http_response_code(503);
                echo json_encode(['success' => false, 'message' => 'Database unavailable — the review was not changed.']);
                exit;
            }

            // Report what actually happened. These branches used to swallow the
            // exception and answer "deleted successfully" regardless.
            try {
                if ($action === 'delete') {
                    $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = ?");
                    $stmt->execute([$reviewId]);
                    $verb = 'deleted';
                } elseif ($action === 'approve') {
                    $stmt = $pdo->prepare("UPDATE reviews SET status = 'approved' WHERE id = ?");
                    $stmt->execute([$reviewId]);
                    $verb = 'approved';
                } else {
                    $stmt = $pdo->prepare("UPDATE reviews SET status = 'rejected' WHERE id = ?");
                    $stmt->execute([$reviewId]);
                    $verb = 'rejected';
                }
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Could not update the review: ' . $e->getMessage()]);
                exit;
            }

            if ($stmt->rowCount() === 0) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'No review found with id ' . $reviewId . '.']);
                exit;
            }

            echo json_encode(['success' => true, 'id' => $reviewId, 'message' => 'Review ' . $verb . ' successfully.']);
            exit;
        }

        $pId = (int)($data['product_id'] ?? 0);
        $name = trim($data['name'] ?? 'Verified Buyer');
        $rating = max(1, min(5, (int)($data['rating'] ?? 5)));
        $text = trim($data['review_text'] ?? ($data['text'] ?? ''));
        $title = trim($data['review_title'] ?? ($data['title'] ?? ''));

        if (empty($text)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Review text cannot be empty.']);
            exit;
        }

        // A review submitted by an admin from the console is published straight
        // away. A review submitted by the public goes into the moderation queue
        // that admin/reviews/pending.php already exists to work through, and is
        // NOT stamped verified_buyer.
        //
        // Previously every anonymous POST was inserted as
        // `verified_buyer = 1, status = 'approved'` — so anyone could publish
        // unlimited five-star reviews on any product, each labelled as coming
        // from a verified buyer, without ever passing moderation.
        $isAdmin = dt_api_is_admin();
        $status = $isAdmin ? 'approved' : 'pending';
        $verified = $isAdmin ? 1 : 0;

        if ($name === '') {
            $name = 'Customer';
        }

        if ($pdo === null || Database::isMockMode()) {
            http_response_code(503);
            echo json_encode(['success' => false, 'message' => 'We could not save your review right now. Please try again shortly.']);
            exit;
        }

        $ok = Database::execute(
            "INSERT INTO reviews (product_id, customer_name, rating, review_title, review_text, verified_buyer, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())",
            [$pId, $name, $rating, $title, $text, $verified, $status]
        );
        if (!$ok) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Could not save your review right now. Please try again.']);
            exit;
        }

        echo json_encode([
            'success' => true,
            'status'  => $status,
            'message' => $isAdmin
                ? 'Review published.'
                : 'Thank you! Your review has been submitted and will appear once our team has checked it.'
        ]);
        exit;
    }

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
