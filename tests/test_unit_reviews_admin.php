<?php
/**
 * test_unit_reviews_admin.php — Comprehensive Unit Test Suite for Section 30 Reviews Admin
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ReviewManager.php';

use DTBrand\Database;
use DTBrand\ReviewManager;

class ReviewsAdminUnitTest
{
    private int $assertions = 0;
    private int $passed = 0;
    private int $failed = 0;

    public function run(): void
    {
        echo "========================================================\n";
        echo "  DT BRAND'S REVIEWS ADMIN (SECTION 30) UNIT TEST SUITE \n";
        echo "========================================================\n\n";

        // Reset mock data to known state
        ReviewManager::resetMockData();

        $this->testMockDataInitialization();
        $this->testGetReviewById();
        $this->testFilterByStatus();
        $this->testFilterByProductAndRating();
        $this->testFilterBySearchTerm();
        $this->testReviewStats();
        $this->testModerationStateTransitions();
        $this->testStoreReplyPublishing();
        $this->testBatchModeration();
        $this->testAuditTrailLogging();
        $this->testReviewOwnershipSafeguards();
        $this->testDualRelativeAdminguardOnAdminPages();
        $this->testRealVectorSvgStandardNoEmojis();
        $this->testRupeeCurrencyMandateNoDollarSigns();

        echo "\n--------------------------------------------------------\n";
        echo "RESULTS: {$this->assertions} Assertions | {$this->passed} Passed | {$this->failed} Failed\n";
        echo "--------------------------------------------------------\n";

        if ($this->failed > 0) {
            exit(1);
        }
    }

    private function assert(bool $condition, string $description): void
    {
        $this->assertions++;
        if ($condition) {
            $this->passed++;
            echo "  [PASS] {$description}\n";
        } else {
            $this->failed++;
            echo "  [FAIL] {$description}\n";
        }
    }

    private function testMockDataInitialization(): void
    {
        echo "1. Testing Mock Data & Review Retrieval...\n";
        $reviews = ReviewManager::getReviews();
        $this->assert(!empty($reviews), "ReviewManager returns seeded reviews in fallback/mock mode");
        $this->assert(count($reviews) >= 7, "Seed contains all review statuses (approved, pending, rejected, flagged)");
    }

    private function testGetReviewById(): void
    {
        echo "\n2. Testing Single Review Lookup...\n";
        $rev1 = ReviewManager::getReviewById(1);
        $this->assert($rev1 !== null, "Review #1 exists");
        $this->assert(($rev1['customer_name'] ?? '') === 'Priya Sharma', "Review #1 customer name is Priya Sharma");
        $this->assert((int)($rev1['rating'] ?? 0) === 5, "Review #1 rating is 5 stars");
        $this->assert(($rev1['status'] ?? '') === 'approved', "Review #1 status is approved");

        $nonExistent = ReviewManager::getReviewById(999999);
        $this->assert($nonExistent === null, "Non-existent review ID returns null");
    }

    private function testFilterByStatus(): void
    {
        echo "\n3. Testing Status Filtering...\n";
        $pending = ReviewManager::getReviews(['status' => 'pending']);
        $this->assert(!empty($pending), "Pending filter returns pending reviews");
        foreach ($pending as $r) {
            $this->assert(($r['status'] ?? '') === 'pending', "Review #{$r['id']} has status pending");
        }

        $approved = ReviewManager::getReviews(['status' => 'approved']);
        $this->assert(!empty($approved), "Approved filter returns approved reviews");
        foreach ($approved as $r) {
            $this->assert(($r['status'] ?? '') === 'approved', "Review #{$r['id']} has status approved");
        }

        $rejected = ReviewManager::getReviews(['status' => 'rejected']);
        $this->assert(!empty($rejected), "Rejected filter returns rejected reviews");
        foreach ($rejected as $r) {
            $this->assert(($r['status'] ?? '') === 'rejected', "Review #{$r['id']} has status rejected");
        }
    }

    private function testFilterByProductAndRating(): void
    {
        echo "\n4. Testing Product & Star Rating Filtering...\n";
        $prod1Reviews = ReviewManager::getReviews(['product_id' => 1]);
        $this->assert(!empty($prod1Reviews), "Product #1 returns matching reviews");
        foreach ($prod1Reviews as $r) {
            $this->assert((int)$r['product_id'] === 1, "Review product_id matches 1");
        }

        $fiveStars = ReviewManager::getReviews(['rating' => 5]);
        $this->assert(!empty($fiveStars), "Rating 5 filter returns 5-star reviews");
        foreach ($fiveStars as $r) {
            $this->assert((int)$r['rating'] === 5, "Review has 5 stars");
        }
    }

    private function testFilterBySearchTerm(): void
    {
        echo "\n5. Testing Live Search Filtering...\n";
        $searchPriya = ReviewManager::getReviews(['search' => 'Priya']);
        $this->assert(count($searchPriya) >= 1, "Search for 'Priya' finds matching review");
        $this->assert(str_contains($searchPriya[0]['customer_name'] ?? '', 'Priya'), "Result contains customer name Priya");

        $searchZari = ReviewManager::getReviews(['search' => 'zari']);
        $this->assert(!empty($searchZari), "Search for 'zari' finds reviews mentioning zari in review text or title");
    }

    private function testReviewStats(): void
    {
        echo "\n6. Testing Review Statistics & KPI Aggregates...\n";
        $stats = ReviewManager::getReviewStats();
        $this->assert(isset($stats['total']) && $stats['total'] >= 7, "Total review count is accurate");
        $this->assert(isset($stats['pending']) && $stats['pending'] >= 2, "Pending moderation count is accurate");
        $this->assert(isset($stats['approved']) && $stats['approved'] >= 3, "Approved count is accurate");
        $this->assert(isset($stats['avg_rating']) && $stats['avg_rating'] >= 4.0, "Average star rating is >= 4.0");
        $this->assert(isset($stats['five_star']) && $stats['five_star'] >= 3, "5-star testimonials count is accurate");
        $this->assert(isset($stats['replied_count']) && $stats['replied_count'] >= 1, "Store replied count is tracked");
    }

    private function testModerationStateTransitions(): void
    {
        echo "\n7. Testing Moderation State Transitions...\n";
        // Approve review #4 (was pending)
        $okApprove = ReviewManager::moderateReview(4, 'approved', 'test_moderator', 'Verified by test');
        $this->assert($okApprove, "Review #4 successfully approved");
        $rev4 = ReviewManager::getReviewById(4);
        $this->assert(($rev4['status'] ?? '') === 'approved', "Review #4 status transitioned to approved");
        $this->assert(($rev4['moderated_by'] ?? '') === 'test_moderator', "Review #4 moderated_by set to test_moderator");

        // Reject review #5
        $okReject = ReviewManager::moderateReview(5, 'rejected', 'test_moderator', 'Test reject reason');
        $this->assert($okReject, "Review #5 successfully rejected");
        $rev5 = ReviewManager::getReviewById(5);
        $this->assert(($rev5['status'] ?? '') === 'rejected', "Review #5 status transitioned to rejected");

        // Flag review #2
        $okFlag = ReviewManager::moderateReview(2, 'flagged', 'test_moderator', 'Exchange investigation');
        $this->assert($okFlag, "Review #2 successfully flagged");
        $rev2 = ReviewManager::getReviewById(2);
        $this->assert(($rev2['status'] ?? '') === 'flagged', "Review #2 status transitioned to flagged");
        $this->assert(($rev2['flag_reason'] ?? '') === 'Exchange investigation', "Review #2 flag_reason recorded");

        // Invalid status rejected
        $okInvalid = ReviewManager::moderateReview(2, 'invalid_status');
        $this->assert(!$okInvalid, "Invalid status change is rejected by ReviewManager");
    }

    private function testStoreReplyPublishing(): void
    {
        echo "\n8. Testing Official Store Reply Publishing...\n";
        $okReply = ReviewManager::saveStoreReply(2, 'Thank you Deepak ji! Your bulk orders are always packaged with high care.', 'DT Executive');
        $this->assert($okReply, "Store reply successfully published for Review #2");

        $rev2 = ReviewManager::getReviewById(2);
        $this->assert(!empty($rev2['store_reply']), "Review #2 store_reply is saved");
        $this->assert(str_contains($rev2['store_reply'], 'Deepak ji'), "Review #2 store_reply content matches");
        $this->assert(($rev2['store_replied_by'] ?? '') === 'DT Executive', "Review #2 store_replied_by is DT Executive");

        // Empty reply rejected
        $okEmpty = ReviewManager::saveStoreReply(2, '   ');
        $this->assert(!$okEmpty, "Empty store reply is rejected");
    }

    private function testBatchModeration(): void
    {
        echo "\n9. Testing Batch Moderation...\n";
        ReviewManager::resetMockData();
        $affected = ReviewManager::batchModerate([4, 5], 'approved', 'batch_admin', 'Bulk verified batch');
        $this->assert($affected === 2, "Batch moderate affected 2 reviews");

        $rev4 = ReviewManager::getReviewById(4);
        $rev5 = ReviewManager::getReviewById(5);
        $this->assert(($rev4['status'] ?? '') === 'approved', "Batch review #4 status is approved");
        $this->assert(($rev5['status'] ?? '') === 'approved', "Batch review #5 status is approved");
    }

    private function testAuditTrailLogging(): void
    {
        echo "\n10. Testing Moderation Audit Trail Logging...\n";
        $logs = ReviewManager::getAuditLogs(20);
        $this->assert(!empty($logs), "Audit logs are retrieved");
        $firstLog = $logs[0];
        $this->assert(isset($firstLog['action']), "Audit log contains action field");
        $this->assert(isset($firstLog['performed_by']), "Audit log contains performed_by field");
        $this->assert(isset($firstLog['created_at']), "Audit log contains created_at timestamp");
    }

    private function testReviewOwnershipSafeguards(): void
    {
        echo "\n11. Testing Review Ownership & Submission Safeguards...\n";
        // Public submission must be forced to pending and cannot inject verified_buyer=1
        $publicSubmission = [
            'product_id' => 1,
            'name' => 'Hacker Tamperer',
            'rating' => 5,
            'review_title' => 'Spoofed Five Star',
            'review_text' => 'Attempting to inject verified_buyer and approved status directly without admin rights.',
            'verified_buyer' => 1,
            'status' => 'approved',
            'customer_id' => 999
        ];

        $created = ReviewManager::createReview($publicSubmission, false); // isAdmin = false
        $this->assert(($created['status'] ?? '') === 'pending', "Public submission is strictly held as 'pending'");
        $this->assert((int)($created['verified_buyer'] ?? 0) === 0, "Public submission cannot forge verified_buyer flag");
        $this->assert($created['customer_id'] === null, "Public submission cannot forge arbitrary customer_id");

        // Empty text throws exception
        $threw = false;
        try {
            ReviewManager::createReview(['product_id' => 1, 'text' => ''], false);
        } catch (\Throwable $e) {
            $threw = true;
        }
        $this->assert($threw, "Empty review text throws an exception");
    }

    private function testDualRelativeAdminguardOnAdminPages(): void
    {
        echo "\n12. Testing Dual Relative Adminguard Fallback on Admin Pages...\n";
        $pages = [
            __DIR__ . '/../admin/reviews/index.php',
            __DIR__ . '/../admin/reviews/pending.php',
            __DIR__ . '/../admin/reviews/approved.php',
            __DIR__ . '/../admin/reviews/rejected.php',
            __DIR__ . '/../admin/reviews/audit.php'
        ];

        foreach ($pages as $p) {
            $basename = basename($p);
            $this->assert(file_exists($p), "File admin/reviews/{$basename} exists");
            $content = file_get_contents($p);
            $hasGuard = str_contains($content, 'adminguard.php');
            $hasRelativeCheck = str_contains($content, "is_file(\$__dtg)");
            $this->assert($hasGuard && $hasRelativeCheck, "admin/reviews/{$basename} implements dual relative adminguard check");
        }
    }

    private function testRealVectorSvgStandardNoEmojis(): void
    {
        echo "\n13. Testing 100% Real Vector SVG Standard & Zero Emojis...\n";
        $pages = [
            __DIR__ . '/../admin/reviews/index.php',
            __DIR__ . '/../admin/reviews/pending.php',
            __DIR__ . '/../admin/reviews/approved.php',
            __DIR__ . '/../admin/reviews/rejected.php',
            __DIR__ . '/../admin/reviews/audit.php'
        ];

        // Unicode emoji regex pattern
        $emojiPattern = '/[\x{1F300}-\x{1F9FF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}]/u';

        foreach ($pages as $p) {
            $basename = basename($p);
            $content = file_get_contents($p);
            $hasSvg = str_contains($content, '<svg');
            $this->assert($hasSvg, "admin/reviews/{$basename} uses inline SVG vector graphics");

            $hasEmoji = preg_match($emojiPattern, $content);
            $this->assert(!$hasEmoji, "admin/reviews/{$basename} contains ZERO emojis (100% Real Vector SVG standard)");
        }
    }

    private function testRupeeCurrencyMandateNoDollarSigns(): void
    {
        echo "\n14. Testing Indian Rupee Standard (Zero Dollar Signs)...\n";
        $pages = [
            __DIR__ . '/../admin/reviews/index.php',
            __DIR__ . '/../admin/reviews/pending.php',
            __DIR__ . '/../admin/reviews/approved.php',
            __DIR__ . '/../admin/reviews/rejected.php',
            __DIR__ . '/../admin/reviews/audit.php'
        ];

        foreach ($pages as $p) {
            $basename = basename($p);
            $content = file_get_contents($p);
            // Search for isolated dollar signs in UI labels e.g. "$ " or "$[0-9]"
            $dollarInUi = preg_match('/(?<!\\\$)\\\$[0-9]+/', $content) || preg_match('/&dollar;/', $content);
            $this->assert(!$dollarInUi, "admin/reviews/{$basename} contains ZERO raw dollar signs in price display");
        }
    }
}

// Execute test suite
$test = new ReviewsAdminUnitTest();
$test->run();
