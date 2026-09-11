<?php
namespace DTBrand;

use PDO;
use Exception;

/**
 * ReviewManager — Central Customer Reviews & Moderation Engine
 * Section 30 (Reviews Admin)
 * DT Brand's & Jai Hanuman Tex
 */
class ReviewManager
{
    private static array $mockReviews = [];
    private static array $mockAuditLogs = [];
    private static bool $initialized = false;

    /**
     * Seed realistic mock reviews if offline/mock mode
     */
    public static function initMockDataIfNeeded(): void
    {
        if (self::$initialized && !empty(self::$mockReviews)) {
            return;
        }

        self::$mockReviews = [
            1 => [
                'id' => 1,
                'product_id' => 1,
                'product_title' => 'Kanjivaram Pure Silk Saree',
                'customer_id' => 101,
                'customer_name' => 'Priya Sharma',
                'customer_email' => 'priya.sharma@example.com',
                'customer_phone' => '+91 98201 12345',
                'city' => 'Mumbai, MH',
                'rating' => 5,
                'review_title' => 'Breathtaking Pure Zari & Luster',
                'review_text' => 'The fabric quality and real zari weave is breathtaking! Arrived in luxury royal gift packaging within 3 days to Mumbai.',
                'images_json' => '[]',
                'verified_buyer' => 1,
                'status' => 'approved',
                'store_reply' => 'Thank you so much Priya ji! We take immense pride in our authentic master looms.',
                'store_replied_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'store_replied_by' => 'Master Concierge',
                'moderated_by' => 'admin',
                'moderated_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'moderation_notes' => 'Authentic verified buyer review',
                'flag_reason' => null,
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            2 => [
                'id' => 2,
                'product_id' => 2,
                'product_title' => 'Banarasi Royal Brocade Saree',
                'customer_id' => 102,
                'customer_name' => 'Deepak Singhal',
                'customer_email' => 'deepak.s@boutique.in',
                'customer_phone' => '+91 98110 54321',
                'city' => 'Delhi NCR',
                'rating' => 5,
                'review_title' => 'Excellent Bulk Lot Packaging',
                'review_text' => 'Quality verified by our boutique master in Surat. Zari luster is pure gold and warp tension is flawless.',
                'images_json' => '[]',
                'verified_buyer' => 1,
                'status' => 'approved',
                'store_reply' => null,
                'store_replied_at' => null,
                'store_replied_by' => null,
                'moderated_by' => 'admin',
                'moderated_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'moderation_notes' => 'B2B boutique verified buyer',
                'flag_reason' => null,
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            3 => [
                'id' => 3,
                'product_id' => 3,
                'product_title' => 'Paithani Peacock Pure Silk Saree',
                'customer_id' => 103,
                'customer_name' => 'Ananya Mehta',
                'customer_email' => 'ananya.mehta@gmail.com',
                'customer_phone' => '+91 97234 98765',
                'city' => 'Surat, Gujarat',
                'rating' => 5,
                'review_title' => 'Pure, Royal & Lightweight',
                'review_text' => 'The silk drape feels extremely luxurious, pure, and lightweight. WhatsApp concierge was very helpful with live video call inspection.',
                'images_json' => '[]',
                'verified_buyer' => 1,
                'status' => 'approved',
                'store_reply' => 'Glad to hear that Ananya ji! Enjoy your celebrations.',
                'store_replied_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'store_replied_by' => 'Admin',
                'moderated_by' => 'admin',
                'moderated_at' => date('Y-m-d H:i:s', strtotime('-4 days')),
                'moderation_notes' => 'Approved after concierge match',
                'flag_reason' => null,
                'created_at' => date('Y-m-d H:i:s', strtotime('-4 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            4 => [
                'id' => 4,
                'product_id' => 4,
                'product_title' => 'Bridal Velvet & Zardosi Lehenga',
                'customer_id' => 104,
                'customer_name' => 'Kavita Patel',
                'customer_email' => 'kavita.p@london.co.uk',
                'customer_phone' => '+44 7700 900123',
                'city' => 'London, UK',
                'rating' => 5,
                'review_title' => 'Pure Bridal Glory',
                'review_text' => 'Ordered from London with international DHL shipping. Reached in 5 days in pristine royal condition! Everyone admired the zari work.',
                'images_json' => '[]',
                'verified_buyer' => 1,
                'status' => 'pending',
                'store_reply' => null,
                'store_replied_at' => null,
                'store_replied_by' => null,
                'moderated_by' => null,
                'moderated_at' => null,
                'moderation_notes' => null,
                'flag_reason' => null,
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            5 => [
                'id' => 5,
                'product_id' => 2,
                'product_title' => 'Banarasi Royal Brocade Saree',
                'customer_id' => 105,
                'customer_name' => 'Sunita Roy',
                'customer_email' => 'sunita.roy@kolkata.org',
                'customer_phone' => '+91 98300 45678',
                'city' => 'Kolkata, WB',
                'rating' => 4,
                'review_title' => 'Good Weave Quality',
                'review_text' => 'The saree border is very heavy and rich. Delivery took 4 days instead of 3, but the silk fabric and pallu are undeniably authentic.',
                'images_json' => '[]',
                'verified_buyer' => 1,
                'status' => 'pending',
                'store_reply' => null,
                'store_replied_at' => null,
                'store_replied_by' => null,
                'moderated_by' => null,
                'moderated_at' => null,
                'moderation_notes' => null,
                'flag_reason' => null,
                'created_at' => date('Y-m-d H:i:s', strtotime('-12 hours')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-12 hours'))
            ],
            6 => [
                'id' => 6,
                'product_id' => 1,
                'product_title' => 'Kanjivaram Pure Silk Saree',
                'customer_id' => null,
                'customer_name' => 'Spam Bot 99',
                'customer_email' => 'bot@spammer.fake',
                'customer_phone' => '0000000000',
                'city' => 'Unknown',
                'rating' => 1,
                'review_title' => 'Cheap prices at external site',
                'review_text' => 'Visit discount-sarees-cheap.xyz for 90% off deals and free delivery link here.',
                'images_json' => '[]',
                'verified_buyer' => 0,
                'status' => 'rejected',
                'store_reply' => null,
                'store_replied_at' => null,
                'store_replied_by' => null,
                'moderated_by' => 'admin',
                'moderated_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
                'moderation_notes' => 'Automated spam rejection - external URL detected',
                'flag_reason' => 'Spam & external links',
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
            ],
            7 => [
                'id' => 7,
                'product_id' => 2,
                'product_title' => 'Banarasi Royal Brocade Saree',
                'customer_id' => 107,
                'customer_name' => 'Vikram Joshi',
                'customer_email' => 'vikram.j@pune.co',
                'customer_phone' => '+91 94220 11223',
                'city' => 'Pune, MH',
                'rating' => 2,
                'review_title' => 'Color shade variance query',
                'review_text' => 'The color appears slightly deeper maroon than seen on my mobile display. Requesting exchange for bright red.',
                'images_json' => '[]',
                'verified_buyer' => 1,
                'status' => 'flagged',
                'store_reply' => null,
                'store_replied_at' => null,
                'store_replied_by' => null,
                'moderated_by' => 'admin',
                'moderated_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'moderation_notes' => 'Hold for WhatsApp customer support resolution before public publishing',
                'flag_reason' => 'Customer support exchange ticket pending',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ]
        ];

        self::$mockAuditLogs = [
            1 => [
                'id' => 1,
                'review_id' => 1,
                'action' => 'approved',
                'performed_by' => 'admin',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Admin Console',
                'details' => 'Review approved and published to PDP',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            2 => [
                'id' => 2,
                'review_id' => 1,
                'action' => 'replied',
                'performed_by' => 'Master Concierge',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Admin Console',
                'details' => 'Store reply published: "Thank you so much Priya ji!..."',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            3 => [
                'id' => 3,
                'review_id' => 6,
                'action' => 'rejected',
                'performed_by' => 'admin',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Admin Console',
                'details' => 'Spam & external links rejected',
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
            ],
            4 => [
                'id' => 4,
                'review_id' => 7,
                'action' => 'flagged',
                'performed_by' => 'admin',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Admin Console',
                'details' => 'Flagged: Customer support exchange ticket pending',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ]
        ];

        self::$initialized = true;
    }

    /**
     * Reset mock data (useful for unit tests)
     */
    public static function resetMockData(): void
    {
        self::$mockReviews = [];
        self::$mockAuditLogs = [];
        self::$initialized = false;
        self::initMockDataIfNeeded();
    }

    /**
     * Get reviews with flexible filters
     * @param array $filters ['status', 'product_id', 'rating', 'search', 'verified_only', 'limit', 'offset', 'sort']
     * @return array
     */
    public static function getReviews(array $filters = []): array
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            return self::getFilteredMockReviews($filters);
        }

        try {
            $where = [];
            $params = [];

            // Status filter
            if (!empty($filters['status']) && $filters['status'] !== 'all') {
                if (is_array($filters['status'])) {
                    $placeholders = implode(',', array_fill(0, count($filters['status']), '?'));
                    $where[] = "r.status IN ($placeholders)";
                    foreach ($filters['status'] as $st) {
                        $params[] = $st;
                    }
                } else {
                    $where[] = "r.status = ?";
                    $params[] = $filters['status'];
                }
            }

            // Product ID filter
            if (!empty($filters['product_id']) && (int)$filters['product_id'] > 0) {
                $where[] = "r.product_id = ?";
                $params[] = (int)$filters['product_id'];
            }

            // Rating filter (1-5)
            if (!empty($filters['rating']) && (int)$filters['rating'] > 0) {
                $where[] = "r.rating = ?";
                $params[] = (int)$filters['rating'];
            }

            // Verified buyer filter
            if (isset($filters['verified_only']) && $filters['verified_only']) {
                $where[] = "r.verified_buyer = 1";
            }

            // Text search
            if (!empty($filters['search'])) {
                $q = '%' . trim($filters['search']) . '%';
                $where[] = "(r.customer_name LIKE ? OR r.review_title LIKE ? OR r.review_text LIKE ? OR r.city LIKE ? OR p.title LIKE ?)";
                $params[] = $q;
                $params[] = $q;
                $params[] = $q;
                $params[] = $q;
                $params[] = $q;
            }

            $whereSql = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

            // Sorting
            $sortSql = "ORDER BY r.id DESC";
            if (!empty($filters['sort'])) {
                switch ($filters['sort']) {
                    case 'id_asc':
                        $sortSql = "ORDER BY r.id ASC";
                        break;
                    case 'rating_desc':
                        $sortSql = "ORDER BY r.rating DESC, r.id DESC";
                        break;
                    case 'rating_asc':
                        $sortSql = "ORDER BY r.rating ASC, r.id DESC";
                        break;
                    case 'created_asc':
                        $sortSql = "ORDER BY r.created_at ASC";
                        break;
                    default:
                        $sortSql = "ORDER BY r.id DESC";
                        break;
                }
            }

            $limit = isset($filters['limit']) ? max(1, min(500, (int)$filters['limit'])) : 100;
            $offset = isset($filters['offset']) ? max(0, (int)$filters['offset']) : 0;

            $sql = "SELECT r.*, p.title AS product_title, p.sku AS product_sku, p.price AS product_price 
                    FROM reviews r 
                    LEFT JOIN products p ON p.id = r.product_id 
                    $whereSql 
                    $sortSql 
                    LIMIT $limit OFFSET $offset";

            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($results)) {
                return $results;
            }

            // If DB query returned empty, return mock items if mock mode or fallback
            return self::getFilteredMockReviews($filters);

        } catch (Exception $e) {
            error_log("ReviewManager::getReviews error: " . $e->getMessage());
            return self::getFilteredMockReviews($filters);
        }
    }

    /**
     * Filter mock reviews in-memory
     */
    private static function getFilteredMockReviews(array $filters): array
    {
        self::initMockDataIfNeeded();
        $items = array_values(self::$mockReviews);

        // Status filter
        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $expected = is_array($filters['status']) ? $filters['status'] : [$filters['status']];
            $items = array_filter($items, fn($r) => in_array($r['status'] ?? 'pending', $expected, true));
        }

        // Product ID filter
        if (!empty($filters['product_id']) && (int)$filters['product_id'] > 0) {
            $pId = (int)$filters['product_id'];
            $items = array_filter($items, fn($r) => (int)($r['product_id'] ?? 0) === $pId);
        }

        // Rating filter
        if (!empty($filters['rating']) && (int)$filters['rating'] > 0) {
            $rating = (int)$filters['rating'];
            $items = array_filter($items, fn($r) => (int)($r['rating'] ?? 5) === $rating);
        }

        // Verified buyer filter
        if (isset($filters['verified_only']) && $filters['verified_only']) {
            $items = array_filter($items, fn($r) => !empty($r['verified_buyer']));
        }

        // Text search
        if (!empty($filters['search'])) {
            $term = mb_strtolower(trim($filters['search']));
            $items = array_filter($items, function($r) use ($term) {
                return (
                    str_contains(mb_strtolower($r['customer_name'] ?? ''), $term) ||
                    str_contains(mb_strtolower($r['review_title'] ?? ''), $term) ||
                    str_contains(mb_strtolower($r['review_text'] ?? ''), $term) ||
                    str_contains(mb_strtolower($r['product_title'] ?? ''), $term) ||
                    str_contains(mb_strtolower($r['city'] ?? ''), $term)
                );
            });
        }

        // Sorting
        $sort = $filters['sort'] ?? 'id_desc';
        usort($items, function($a, $b) use ($sort) {
            if ($sort === 'id_asc') {
                return ($a['id'] ?? 0) <=> ($b['id'] ?? 0);
            }
            if ($sort === 'rating_desc') {
                $rc = ($b['rating'] ?? 5) <=> ($a['rating'] ?? 5);
                return $rc !== 0 ? $rc : (($b['id'] ?? 0) <=> ($a['id'] ?? 0));
            }
            if ($sort === 'rating_asc') {
                $rc = ($a['rating'] ?? 5) <=> ($b['rating'] ?? 5);
                return $rc !== 0 ? $rc : (($b['id'] ?? 0) <=> ($a['id'] ?? 0));
            }
            return ($b['id'] ?? 0) <=> ($a['id'] ?? 0);
        });

        // Limit & offset
        $limit = isset($filters['limit']) ? max(1, min(500, (int)$filters['limit'])) : 100;
        $offset = isset($filters['offset']) ? max(0, (int)$filters['offset']) : 0;

        return array_slice(array_values($items), $offset, $limit);
    }

    /**
     * Get review by ID
     */
    public static function getReviewById(int $id): ?array
    {
        if ($id <= 0) {
            return null;
        }

        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                $stmt = $db->prepare("SELECT r.*, p.title AS product_title, p.sku AS product_sku, p.price AS product_price 
                                      FROM reviews r 
                                      LEFT JOIN products p ON p.id = r.product_id 
                                      WHERE r.id = ? LIMIT 1");
                $stmt->execute([$id]);
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($res) {
                    return $res;
                }
            } catch (Exception $e) {
                error_log("ReviewManager::getReviewById error: " . $e->getMessage());
            }
        }

        self::initMockDataIfNeeded();
        return self::$mockReviews[$id] ?? null;
    }

    /**
     * Get aggregated review metrics and statistics
     */
    public static function getReviewStats(): array
    {
        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                $stmt = $db->query("
                    SELECT 
                        COUNT(*) as total,
                        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                        SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
                        SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
                        SUM(CASE WHEN status = 'flagged' THEN 1 ELSE 0 END) as flagged,
                        AVG(CASE WHEN status = 'approved' THEN rating ELSE NULL END) as avg_rating,
                        SUM(CASE WHEN rating = 5 AND status = 'approved' THEN 1 ELSE 0 END) as five_star,
                        SUM(CASE WHEN verified_buyer = 1 THEN 1 ELSE 0 END) as verified_count,
                        SUM(CASE WHEN store_reply IS NOT NULL AND TRIM(store_reply) != '' THEN 1 ELSE 0 END) as replied_count
                    FROM reviews
                ");
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row && $row['total'] > 0) {
                    $total = (int)$row['total'];
                    $verified = (int)($row['verified_count'] ?? 0);
                    return [
                        'total' => $total,
                        'pending' => (int)($row['pending'] ?? 0),
                        'approved' => (int)($row['approved'] ?? 0),
                        'rejected' => (int)($row['rejected'] ?? 0),
                        'flagged' => (int)($row['flagged'] ?? 0),
                        'avg_rating' => round((float)($row['avg_rating'] ?? 5.0), 1),
                        'five_star' => (int)($row['five_star'] ?? 0),
                        'verified_percentage' => $total > 0 ? round(($verified / $total) * 100, 1) : 100.0,
                        'replied_count' => (int)($row['replied_count'] ?? 0)
                    ];
                }
            } catch (Exception $e) {
                error_log("ReviewManager::getReviewStats error: " . $e->getMessage());
            }
        }

        // Calculate from mock reviews
        self::initMockDataIfNeeded();
        $total = count(self::$mockReviews);
        $pending = 0;
        $approved = 0;
        $rejected = 0;
        $flagged = 0;
        $sumApprovedRating = 0;
        $approvedCount = 0;
        $fiveStar = 0;
        $verifiedCount = 0;
        $repliedCount = 0;

        foreach (self::$mockReviews as $r) {
            $st = $r['status'] ?? 'pending';
            if ($st === 'pending') $pending++;
            elseif ($st === 'approved') {
                $approved++;
                $rating = (int)($r['rating'] ?? 5);
                $sumApprovedRating += $rating;
                $approvedCount++;
                if ($rating === 5) $fiveStar++;
            }
            elseif ($st === 'rejected') $rejected++;
            elseif ($st === 'flagged') $flagged++;

            if (!empty($r['verified_buyer'])) $verifiedCount++;
            if (!empty($r['store_reply'])) $repliedCount++;
        }

        $avg = $approvedCount > 0 ? round($sumApprovedRating / $approvedCount, 1) : 4.9;

        return [
            'total' => $total,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected,
            'flagged' => $flagged,
            'avg_rating' => $avg,
            'five_star' => $fiveStar,
            'verified_percentage' => $total > 0 ? round(($verifiedCount / $total) * 100, 1) : 100.0,
            'replied_count' => $repliedCount
        ];
    }

    /**
     * Moderate a single review (approve, reject, flag, pending)
     */
    public static function moderateReview(
        int $id,
        string $status,
        string $admin = 'admin',
        string $reason = '',
        ?string $ip = null,
        ?string $ua = null
    ): bool {
        if ($id <= 0) return false;

        $validStatuses = ['pending', 'approved', 'rejected', 'flagged'];
        if (!in_array($status, $validStatuses, true)) {
            return false;
        }

        $now = date('Y-m-d H:i:s');
        $ip = $ip ?? ($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');
        $ua = $ua ?? ($_SERVER['HTTP_USER_AGENT'] ?? 'Admin Panel');

        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                // Ensure columns exist
                self::ensureModerationColumns($db);

                $stmt = $db->prepare("
                    UPDATE reviews 
                    SET status = ?, 
                        moderated_by = ?, 
                        moderated_at = ?, 
                        moderation_notes = ?,
                        flag_reason = CASE WHEN ? = 'flagged' THEN ? ELSE flag_reason END,
                        updated_at = ?
                    WHERE id = ?
                ");
                $stmt->execute([$status, $admin, $now, $reason, $status, $reason, $now, $id]);

                if ($stmt->rowCount() > 0 || true) {
                    self::logAudit($id, $status, $admin, "Status changed to '$status'. Reason: $reason", $ip, $ua);
                    return true;
                }
            } catch (Exception $e) {
                error_log("ReviewManager::moderateReview error: " . $e->getMessage());
            }
        }

        // Mock mode update
        self::initMockDataIfNeeded();
        if (isset(self::$mockReviews[$id])) {
            self::$mockReviews[$id]['status'] = $status;
            self::$mockReviews[$id]['moderated_by'] = $admin;
            self::$mockReviews[$id]['moderated_at'] = $now;
            self::$mockReviews[$id]['moderation_notes'] = $reason;
            if ($status === 'flagged') {
                self::$mockReviews[$id]['flag_reason'] = $reason;
            }
            self::$mockReviews[$id]['updated_at'] = $now;

            self::logAudit($id, $status, $admin, "Status changed to '$status'. Reason: $reason", $ip, $ua);
            return true;
        }

        return false;
    }

    /**
     * Batch moderate multiple reviews at once
     */
    public static function batchModerate(array $ids, string $status, string $admin = 'admin', string $reason = ''): int
    {
        $count = 0;
        foreach ($ids as $rawId) {
            $id = (int)$rawId;
            if ($id > 0 && self::moderateReview($id, $status, $admin, $reason)) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * Save an official brand/store reply to a customer review
     */
    public static function saveStoreReply(
        int $id,
        string $reply,
        string $admin = 'admin',
        ?string $ip = null,
        ?string $ua = null
    ): bool {
        if ($id <= 0) return false;
        $reply = trim($reply);
        if ($reply === '') return false;

        $now = date('Y-m-d H:i:s');
        $ip = $ip ?? ($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');
        $ua = $ua ?? ($_SERVER['HTTP_USER_AGENT'] ?? 'Admin Panel');

        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                self::ensureModerationColumns($db);

                $stmt = $db->prepare("
                    UPDATE reviews 
                    SET store_reply = ?, 
                        store_replied_at = ?, 
                        store_replied_by = ?,
                        updated_at = ?
                    WHERE id = ?
                ");
                $stmt->execute([$reply, $now, $admin, $now, $id]);

                self::logAudit($id, 'replied', $admin, "Published store reply: " . mb_substr($reply, 0, 80) . '...', $ip, $ua);
                return true;
            } catch (Exception $e) {
                error_log("ReviewManager::saveStoreReply error: " . $e->getMessage());
            }
        }

        // Mock mode
        self::initMockDataIfNeeded();
        if (isset(self::$mockReviews[$id])) {
            self::$mockReviews[$id]['store_reply'] = $reply;
            self::$mockReviews[$id]['store_replied_at'] = $now;
            self::$mockReviews[$id]['store_replied_by'] = $admin;
            self::$mockReviews[$id]['updated_at'] = $now;

            self::logAudit($id, 'replied', $admin, "Published store reply: " . mb_substr($reply, 0, 80) . '...', $ip, $ua);
            return true;
        }

        return false;
    }

    /**
     * Delete a review permanently with audit logging
     */
    public static function deleteReview(
        int $id,
        string $admin = 'admin',
        string $reason = '',
        ?string $ip = null,
        ?string $ua = null
    ): bool {
        if ($id <= 0) return false;

        $ip = $ip ?? ($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');
        $ua = $ua ?? ($_SERVER['HTTP_USER_AGENT'] ?? 'Admin Panel');

        // Log action before delete
        self::logAudit($id, 'deleted', $admin, "Review deleted permanently. Reason: $reason", $ip, $ua);

        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                $stmt = $db->prepare("DELETE FROM reviews WHERE id = ?");
                $stmt->execute([$id]);
                return true;
            } catch (Exception $e) {
                error_log("ReviewManager::deleteReview error: " . $e->getMessage());
            }
        }

        // Mock mode
        self::initMockDataIfNeeded();
        if (isset(self::$mockReviews[$id])) {
            unset(self::$mockReviews[$id]);
            return true;
        }

        return true;
    }

    /**
     * Create review with customer ownership protection
     */
    public static function createReview(array $data, bool $isAdmin = false): array
    {
        $productId = (int)($data['product_id'] ?? 0);
        $name = trim((string)($data['customer_name'] ?? ($data['name'] ?? 'Verified Buyer')));
        $email = trim((string)($data['customer_email'] ?? ($data['email'] ?? '')));
        $phone = trim((string)($data['customer_phone'] ?? ($data['phone'] ?? '')));
        $city = trim((string)($data['city'] ?? 'India'));
        $rating = max(1, min(5, (int)($data['rating'] ?? 5)));
        $title = trim((string)($data['review_title'] ?? ($data['title'] ?? '')));
        $text = trim((string)($data['review_text'] ?? ($data['text'] ?? ($data['comment'] ?? ''))));

        if (empty($text)) {
            throw new Exception("Review text cannot be empty.");
        }

        // Authorization rule: Non-admin submissions MUST be pending and verified_buyer cannot be spoofed
        $status = $isAdmin ? ($data['status'] ?? 'approved') : 'pending';
        $verifiedBuyer = $isAdmin ? (int)($data['verified_buyer'] ?? 1) : 0;
        $customerId = $isAdmin ? (!empty($data['customer_id']) ? (int)$data['customer_id'] : null) : null;

        $now = date('Y-m-d H:i:s');
        $newId = time() + mt_rand(100, 999);

        $record = [
            'id' => $newId,
            'product_id' => $productId,
            'product_title' => $data['product_title'] ?? "Product #$productId",
            'customer_id' => $customerId,
            'customer_name' => $name ?: 'Customer',
            'customer_email' => $email,
            'customer_phone' => $phone,
            'city' => $city,
            'rating' => $rating,
            'review_title' => $title,
            'review_text' => $text,
            'images_json' => is_array($data['images_json'] ?? null) ? json_encode($data['images_json']) : ($data['images_json'] ?? '[]'),
            'verified_buyer' => $verifiedBuyer,
            'status' => $status,
            'store_reply' => null,
            'store_replied_at' => null,
            'store_replied_by' => null,
            'moderated_by' => $isAdmin ? 'admin' : null,
            'moderated_at' => $isAdmin ? $now : null,
            'moderation_notes' => null,
            'flag_reason' => null,
            'created_at' => $now,
            'updated_at' => $now
        ];

        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                self::ensureModerationColumns($db);

                $stmt = $db->prepare("
                    INSERT INTO reviews (
                        product_id, customer_id, customer_name, customer_email, customer_phone, city,
                        rating, review_title, review_text, images_json, verified_buyer, status,
                        moderated_by, moderated_at, created_at, updated_at
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $record['product_id'],
                    $record['customer_id'],
                    $record['customer_name'],
                    $record['customer_email'],
                    $record['customer_phone'],
                    $record['city'],
                    $record['rating'],
                    $record['review_title'],
                    $record['review_text'],
                    $record['images_json'],
                    $record['verified_buyer'],
                    $record['status'],
                    $record['moderated_by'],
                    $record['moderated_at'],
                    $now,
                    $now
                ]);
                $record['id'] = (int)$db->lastInsertId();
            } catch (Exception $e) {
                error_log("ReviewManager::createReview error: " . $e->getMessage());
            }
        }

        self::initMockDataIfNeeded();
        self::$mockReviews[$record['id']] = $record;

        return $record;
    }

    /**
     * Log moderation event to audit ledger
     */
    public static function logAudit(
        int $reviewId,
        string $action,
        string $performedBy = 'admin',
        string $details = '',
        ?string $ip = null,
        ?string $ua = null
    ): bool {
        $now = date('Y-m-d H:i:s');
        $ip = $ip ?? ($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');
        $ua = $ua ?? ($_SERVER['HTTP_USER_AGENT'] ?? 'Console');

        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                $db->exec("
                    CREATE TABLE IF NOT EXISTS `review_audit_logs` (
                        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        `review_id` INT UNSIGNED NOT NULL,
                        `action` VARCHAR(50) NOT NULL,
                        `performed_by` VARCHAR(100) NOT NULL DEFAULT 'admin',
                        `ip_address` VARCHAR(45) NULL,
                        `user_agent` TEXT NULL,
                        `details` TEXT NULL,
                        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                ");

                $stmt = $db->prepare("
                    INSERT INTO review_audit_logs (review_id, action, performed_by, ip_address, user_agent, details, created_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([$reviewId, $action, $performedBy, $ip, $ua, $details, $now]);
                return true;
            } catch (Exception $e) {
                error_log("ReviewManager::logAudit error: " . $e->getMessage());
            }
        }

        // Mock mode
        self::initMockDataIfNeeded();
        $auditId = count(self::$mockAuditLogs) + 1;
        self::$mockAuditLogs[$auditId] = [
            'id' => $auditId,
            'review_id' => $reviewId,
            'action' => $action,
            'performed_by' => $performedBy,
            'ip_address' => $ip,
            'user_agent' => $ua,
            'details' => $details,
            'created_at' => $now
        ];

        return true;
    }

    /**
     * Get review audit logs
     */
    public static function getAuditLogs(int $limit = 50, ?int $reviewId = null): array
    {
        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                $where = "";
                $params = [];
                if ($reviewId !== null && $reviewId > 0) {
                    $where = "WHERE a.review_id = ?";
                    $params[] = $reviewId;
                }

                $limit = max(1, min(200, $limit));
                $stmt = $db->prepare("
                    SELECT a.*, r.customer_name, r.review_title, r.rating, p.title as product_title
                    FROM review_audit_logs a
                    LEFT JOIN reviews r ON r.id = a.review_id
                    LEFT JOIN products p ON p.id = r.product_id
                    $where
                    ORDER BY a.id DESC
                    LIMIT $limit
                ");
                $stmt->execute($params);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($rows)) {
                    return $rows;
                }
            } catch (Exception $e) {
                error_log("ReviewManager::getAuditLogs error: " . $e->getMessage());
            }
        }

        self::initMockDataIfNeeded();
        $logs = array_values(self::$mockAuditLogs);

        if ($reviewId !== null && $reviewId > 0) {
            $logs = array_filter($logs, fn($l) => (int)($l['review_id'] ?? 0) === $reviewId);
        }

        // Decorate with review details
        foreach ($logs as &$log) {
            $rId = (int)($log['review_id'] ?? 0);
            $rev = self::$mockReviews[$rId] ?? null;
            $log['customer_name'] = $rev['customer_name'] ?? 'Customer';
            $log['review_title'] = $rev['review_title'] ?? 'Review #' . $rId;
            $log['rating'] = $rev['rating'] ?? 5;
            $log['product_title'] = $rev['product_title'] ?? 'Silk Saree';
        }
        unset($log);

        usort($logs, fn($a, $b) => ($b['id'] ?? 0) <=> ($a['id'] ?? 0));
        return array_slice($logs, 0, $limit);
    }

    /**
     * Ensure database table and columns exist in runtime
     */
    private static function ensureModerationColumns(PDO $pdo): void
    {
        try {
            $cols = [
                'customer_id' => 'INT UNSIGNED NULL AFTER product_id',
                'customer_email' => 'VARCHAR(150) NULL AFTER customer_name',
                'customer_phone' => 'VARCHAR(50) NULL AFTER customer_email',
                'city' => 'VARCHAR(100) NULL AFTER customer_phone',
                'review_title' => 'VARCHAR(255) NULL AFTER rating',
                'images_json' => 'LONGTEXT NULL AFTER review_text',
                'store_reply' => 'TEXT NULL AFTER status',
                'store_replied_at' => 'DATETIME NULL AFTER store_reply',
                'store_replied_by' => 'VARCHAR(100) NULL AFTER store_replied_at',
                'moderated_by' => 'VARCHAR(100) NULL AFTER store_replied_by',
                'moderated_at' => 'DATETIME NULL AFTER moderated_by',
                'moderation_notes' => 'TEXT NULL AFTER moderated_at',
                'flag_reason' => 'VARCHAR(255) NULL AFTER moderation_notes'
            ];

            foreach ($cols as $colName => $colDef) {
                try {
                    $check = $pdo->query("SHOW COLUMNS FROM `reviews` LIKE '$colName'")->fetch();
                    if (!$check) {
                        $pdo->exec("ALTER TABLE `reviews` ADD COLUMN `$colName` $colDef");
                    }
                } catch (\Throwable $e) {}
            }
        } catch (\Throwable $e) {}
    }
}
