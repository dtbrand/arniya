<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * reviews/index.php — DT Brand's Product Reviews & Customer Moderation Suite
 * Wholesale Dashboard & Luxury Shop Standard
 * DT Brand's & Jai Hanuman Tex
 *
 * The previous revision shipped six invented reviews ("Sunita Rao", "Ananya
 * Kulkarni", …) with fabricated KPIs ("4.92/5.0, 1,420 Verified Reviews") and
 * buttons that only fired toasts: Approve/Trash/Bulk/Add/Reply all mutated the
 * DOM and claimed success. Every row now comes from the live `reviews` table
 * and every action POSTs to /api/reviews.php, which is admin-guarded and
 * reports the real row count.
 */
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\Database;

$page_title = "Product Reviews Moderation";
$active_nav = "products";
$active_subnav = "reviews";

$reviews_list = [];
$counts = ['all' => 0, 'approved' => 0, 'pending' => 0, 'rejected' => 0];
$avgRating = null;

$pdoRev = Database::getConnection();
if ($pdoRev !== null && !Database::isMockMode()) {
    try {
        $reviews_list = Database::query(
            'SELECT r.*, p.title AS product_title, p.sku AS product_sku
             FROM reviews r
             LEFT JOIN products p ON r.product_id = p.id
             ORDER BY r.id DESC
             LIMIT 200'
        );
        $row = Database::fetchOne(
            "SELECT
                COUNT(*) AS total,
                SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approved,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending,
                SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) AS rejected,
                AVG(CASE WHEN status = 'approved' THEN rating END) AS avg_rating
             FROM reviews"
        );
        if ($row) {
            $counts['all'] = (int)($row['total'] ?? 0);
            $counts['approved'] = (int)($row['approved'] ?? 0);
            $counts['pending'] = (int)($row['pending'] ?? 0);
            $counts['rejected'] = (int)($row['rejected'] ?? 0);
            $avgRating = $row['avg_rating'] !== null ? round((float)$row['avg_rating'], 2) : null;
        }
    } catch (\Throwable $e) {
        $reviews_list = [];
    }
}

$avgText = $avgRating !== null ? number_format($avgRating, 2) . ' / 5.0' : '—';
$statusFilter = trim((string)($_GET['status'] ?? ''));
if ($statusFilter !== '' && in_array(strtolower($statusFilter), ['approved', 'pending', 'rejected'], true)) {
    $reviews_list = array_values(array_filter($reviews_list, static function (array $r) use ($statusFilter): bool {
        return strtolower((string)($r['status'] ?? '')) === strtolower($statusFilter);
    }));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Reviews &amp; Ratings ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <style>
    .dt-kpi-ribbon {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
        margin-bottom: 12px;
    }
    @media (max-width: 1024px) { .dt-kpi-ribbon { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px) { .dt-kpi-ribbon { grid-template-columns: 1fr; } }
    .dt-kpi-card {
        background: #fff;
        border: 1px solid rgba(212,175,55,0.4);
        border-radius: 8px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        transition: all 0.2s ease;
    }
    .dt-kpi-card:hover { border-color: #D4AF37; }
    .dt-review-avatar {
        width: 38px; height: 38px; border-radius: 50%;
        background: linear-gradient(135deg, #181512, #3D342A);
        color: #D4AF37; font-weight: 800; font-size: 13px;
        display: flex; align-items: center; justify-content: center;
        border: 1.5px solid #D4AF37; flex-shrink: 0;
    }
    .dt-action-pill {
        height: 28px; padding: 0 9px; font-size: 11.5px; font-weight: 700;
        border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;
        cursor: pointer; text-decoration: none; transition: all 0.15s ease; border: 1px solid transparent;
    }
    .dt-action-pill:hover { transform: translateY(-1px); }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 16px 20px;">

            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Product Reviews &amp; Ratings</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:11px; padding:3px 8px;">★ <?php echo htmlspecialchars($avgText); ?> Average</span>
                    <span class="adm-badge" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-weight:700; font-size:11px;"><?php echo (int)$counts['approved']; ?> Approved</span>
                </div>

                <div style="display:flex; align-items:center; gap:8px;">
                    <a href="/admin/products/" class="wp-button" style="height:32px; font-size:12px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:5px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Back to Products</span>
                    </a>
                    <button type="button" class="wp-button primary" onclick="openAddReviewModal()" style="background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; font-weight:800; border:1px solid #8A681F; padding:0 14px; height:32px; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add Manual Review</span>
                    </button>
                </div>
            </div>

            <!-- 2. KPI Metrics Ribbon — live counts -->
            <div class="dt-kpi-ribbon">
                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">SATISFACTION RATING</div>
                        <div style="font-size:17px; font-weight:800; color:#181512;"><?php echo htmlspecialchars($avgText); ?></div>
                    </div>
                </div>
                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#DCFCE7; border:1px solid #86EFAC; display:flex; align-items:center; justify-content:center; color:#15803D;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">APPROVED &amp; LIVE</div>
                        <div style="font-size:17px; font-weight:800; color:#15803D;"><?php echo (int)$counts['approved']; ?> Reviews</div>
                    </div>
                </div>
                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FEF3C7; border:1px solid #FCD34D; display:flex; align-items:center; justify-content:center; color:#B45309;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">PENDING MODERATION</div>
                        <div style="font-size:17px; font-weight:800; color:#B45309;"><?php echo (int)$counts['pending']; ?> Waiting</div>
                    </div>
                </div>
                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FEE2E2; border:1px solid #FCA5A5; display:flex; align-items:center; justify-content:center; color:#B91C1C;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">REJECTED</div>
                        <div style="font-size:17px; font-weight:800; color:#B91C1C;"><?php echo (int)$counts['rejected']; ?></div>
                    </div>
                </div>
            </div>

            <!-- 3. Status filter tabs -->
            <ul class="wp-subsubsub" style="margin-bottom:12px;">
                <li><a href="/admin/products/reviews/" class="<?php echo $statusFilter === '' ? 'current' : ''; ?>">All <span class="count">(<?php echo (int)$counts['all']; ?>)</span></a> <span class="sep">|</span></li>
                <li><a href="/admin/products/reviews/?status=approved" class="<?php echo strtolower($statusFilter) === 'approved' ? 'current' : ''; ?>">Approved <span class="count">(<?php echo (int)$counts['approved']; ?>)</span></a> <span class="sep">|</span></li>
                <li><a href="/admin/products/reviews/?status=pending" class="<?php echo strtolower($statusFilter) === 'pending' ? 'current' : ''; ?>">Pending <span class="count">(<?php echo (int)$counts['pending']; ?>)</span></a> <span class="sep">|</span></li>
                <li><a href="/admin/products/reviews/?status=rejected" class="<?php echo strtolower($statusFilter) === 'rejected' ? 'current' : ''; ?>">Rejected <span class="count">(<?php echo (int)$counts['rejected']; ?>)</span></a></li>
            </ul>

            <!-- 4. Bulk actions toolbar -->
            <div class="wp-tablenav" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:12px;">
                <div class="wp-tablenav-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <select class="wp-select" id="bulkReviewActionSelect" style="height:34px; font-size:12px; min-width:150px;">
                        <option value="">Bulk actions</option>
                        <option value="approve">Approve Selected</option>
                        <option value="reject">Reject Selected</option>
                        <option value="delete">Delete Selected</option>
                    </select>
                    <button type="button" class="wp-button" onclick="handleBulkReviewAction()" style="height:34px; font-size:12px; font-weight:700; padding:0 12px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Apply</button>
                </div>
                <div class="wp-search-box" style="display:flex; align-items:center; gap:6px;">
                    <input type="text" id="reviewSearchInput" class="wp-search-input" placeholder="Search customer, review text..." style="height:34px; padding-left:12px; width:220px; font-size:12px; border:1px solid #c3c4c7; border-radius:4px; outline:none;" oninput="searchReviews(this.value)">
                    <button type="button" class="wp-button primary" style="height:34px; font-size:12px; font-weight:800; padding:0 14px; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; border:1px solid #8A681F;">Search Reviews</button>
                </div>
            </div>

            <!-- 5. Reviews Table -->
            <div class="wp-table-card" style="background:#fff; border:1px solid #c3c4c7; border-radius:6px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <table class="wp-list-table" id="reviewsTable" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f6f7f7; border-bottom:1px solid #c3c4c7;">
                            <th style="width:36px; text-align:center; padding:10px 8px;"><input type="checkbox" onchange="toggleSelectAllReviews(this)" style="cursor:pointer;"></th>
                            <th style="width:190px; padding:10px 12px;">Customer</th>
                            <th style="width:110px; padding:10px 10px;">Rating</th>
                            <th style="padding:10px 12px;">Review &amp; Store Reply</th>
                            <th style="width:190px; padding:10px 10px;">Product</th>
                            <th style="width:110px; padding:10px 10px;">Status</th>
                            <th style="width:150px; text-align:right; padding:10px 12px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="reviewsTableBody">
                    <?php if (empty($reviews_list)): ?>
                        <tr><td colspan="7" style="padding:24px; text-align:center; color:#64748B;">No reviews<?php echo $statusFilter !== '' ? ' with status "' . htmlspecialchars($statusFilter) . '"' : ''; ?> yet. Customer reviews submitted on the product page land here for moderation.</td></tr>
                    <?php else: ?>
                        <?php foreach ($reviews_list as $rev): ?>
                        <?php
                            $rid = (int)$rev['id'];
                            $stars = max(1, min(5, (int)($rev['rating'] ?? 5)));
                            $initials = strtoupper(substr(preg_replace('/\s+/', '', (string)($rev['customer_name'] ?? 'C')), 0, 2));
                            $status = strtolower((string)($rev['status'] ?? 'pending'));
                        ?>
                        <tr id="review-row-<?= $rid ?>" data-status="<?= htmlspecialchars($status) ?>" style="border-bottom:1px solid #f0f0f1;">
                            <td style="text-align:center; padding:12px 8px; vertical-align:top;">
                                <input type="checkbox" class="review-row-check" value="<?= $rid ?>" style="cursor:pointer;">
                            </td>
                            <td style="padding:12px 12px; vertical-align:top;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <div class="dt-review-avatar"><?= htmlspecialchars($initials) ?></div>
                                    <div>
                                        <strong style="font-size:13px; color:#181512; display:block;"><?= htmlspecialchars((string)($rev['customer_name'] ?? 'Customer')) ?></strong>
                                        <?php if (!empty($rev['verified_buyer'])): ?>
                                        <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-size:10px; padding:1px 5px; font-weight:700;">✓ Verified Buyer</span>
                                        <?php endif; ?>
                                        <small style="display:block; color:#646970; font-size:11px; margin-top:2px;"><?= htmlspecialchars(substr((string)($rev['created_at'] ?? ''), 0, 16)) ?></small>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:12px 10px; vertical-align:top;">
                                <div style="color:#D4AF37; font-size:15px; letter-spacing:1px; font-weight:700;"><?= str_repeat('★', $stars) . str_repeat('☆', 5 - $stars) ?></div>
                                <span style="font-size:11.5px; font-weight:700; color:#181512;"><?= $stars ?>.0 Rating</span>
                            </td>
                            <td style="padding:12px 12px; vertical-align:top;">
                                <?php if (!empty($rev['review_title'])): ?>
                                <strong style="font-size:13px; color:#181512; display:block; margin-bottom:4px;">"<?= htmlspecialchars((string)$rev['review_title']) ?>"</strong>
                                <?php endif; ?>
                                <p style="font-size:12.5px; color:#2c3338; line-height:1.45; margin:0 0 8px 0;"><?= htmlspecialchars((string)($rev['review_text'] ?? '')) ?></p>
                                <?php if (!empty($rev['store_reply'])): ?>
                                <div style="background:#FAF5E8; border-left:3px solid #D4AF37; padding:6px 10px; border-radius:0 4px 4px 0; font-size:11.5px;">
                                    <strong style="color:#8A681F;">Store Reply:</strong> <span style="color:#5A4210;"><?= htmlspecialchars((string)$rev['store_reply']) ?></span>
                                </div>
                                <?php endif; ?>
                            </td>
                            <td style="padding:12px 10px; vertical-align:top;">
                                <a href="/admin/products/edit.php?id=<?= (int)($rev['product_id'] ?? 0) ?>" style="font-size:12px; font-weight:700; color:#181512; text-decoration:none;"><?= htmlspecialchars((string)($rev['product_title'] ?? ('Product #' . ($rev['product_id'] ?? '—')))) ?></a>
                                <code style="display:block; font-size:10.5px; color:#8A681F; font-weight:700;"><?= htmlspecialchars((string)($rev['product_sku'] ?? '')) ?></code>
                            </td>
                            <td style="padding:12px 10px; vertical-align:top;">
                                <?php if ($status === 'approved'): ?>
                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px;">Approved</span>
                                <?php elseif ($status === 'pending'): ?>
                                <span class="adm-badge" style="background:#FEF3C7; color:#B45309; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px;">Pending</span>
                                <?php else: ?>
                                <span class="adm-badge" style="background:#FEE2E2; color:#B91C1C; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px;">Rejected</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding:12px 12px; vertical-align:top; text-align:right;">
                                <div style="display:flex; flex-direction:column; gap:5px; align-items:flex-end;">
                                    <?php if ($status !== 'approved'): ?>
                                    <button type="button" class="dt-action-pill" style="background:#DCFCE7; border-color:#86EFAC; color:#15803D;" onclick="moderateReview(<?= $rid ?>, 'approve')">
                                        <span>Approve</span>
                                    </button>
                                    <?php endif; ?>
                                    <button type="button" class="dt-action-pill" style="background:#EFF6FF; border-color:#93C5FD; color:#1D4ED8;" onclick="openReplyModal(<?= $rid ?>, '<?= htmlspecialchars(addslashes((string)($rev['customer_name'] ?? ''))) ?>')">
                                        <span>Reply</span>
                                    </button>
                                    <button type="button" class="dt-action-pill" style="background:#FEF2F2; border-color:#FECACA; color:#DC2626;" onclick="moderateReview(<?= $rid ?>, 'delete')">
                                        <span>Trash</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </main>
        <?php include_once __DIR__ . '/../../includes/adminfooter.php'; ?>
    </div>
</div>

<!-- MODAL: ADD MANUAL REVIEW -->
<div id="addReviewModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.75); backdrop-filter:blur(5px); z-index:9999999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:95%; max-width:540px; border-radius:10px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4); overflow:hidden; border:2px solid #D4AF37;">
        <div style="background:linear-gradient(135deg, #261C0E 0%, #3A2C12 40%, #18120A 100%); padding:14px 18px; color:#FAF5E8; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid #D4AF37;">
            <h3 style="margin:0; font-size:15px; font-weight:800; color:#FFFFFF;">Add Verified Customer Review</h3>
            <button type="button" onclick="closeAddReviewModal()" style="background:none; border:none; color:#FFE57F; font-size:22px; cursor:pointer;">&times;</button>
        </div>
        <div style="padding:18px 20px;">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Customer Name <span style="color:#b32d2e;">*</span></label>
                    <input type="text" id="revCustName" placeholder="e.g. Pooja Sharma" style="width:100%; height:34px; padding:0 10px; font-size:12.5px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Product ID <span style="color:#b32d2e;">*</span></label>
                    <input type="number" id="revProductId" placeholder="e.g. 12" style="width:100%; height:34px; padding:0 10px; font-size:12.5px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;">
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Rating Stars</label>
                    <select id="revStars" style="width:100%; height:34px; padding:0 10px; font-size:12.5px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;">
                        <option value="5">★★★★★ 5.0 (Excellent)</option>
                        <option value="4">★★★★☆ 4.0 (Very Good)</option>
                        <option value="3">★★★☆☆ 3.0 (Average)</option>
                        <option value="2">★★☆☆☆ 2.0 (Poor)</option>
                        <option value="1">★☆☆☆☆ 1.0 (Bad)</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Buyer Status</label>
                    <select id="revVerified" style="width:100%; height:34px; padding:0 10px; font-size:12.5px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;">
                        <option value="1">Verified Wholesale Buyer</option>
                        <option value="0">General Customer</option>
                    </select>
                </div>
            </div>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Review Headline</label>
                <input type="text" id="revHeadline" placeholder="e.g. Master craftsmanship and rich gold luster" style="width:100%; height:34px; padding:0 10px; font-size:12.5px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;">
            </div>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Review Detailed Feedback <span style="color:#b32d2e;">*</span></label>
                <textarea id="revComment" rows="3" placeholder="Write the customer's detailed experience..." style="width:100%; padding:8px 10px; font-size:12px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;"></textarea>
            </div>
        </div>
        <div style="background:#f6f7f7; padding:12px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
            <button type="button" class="wp-button" onclick="closeAddReviewModal()" style="height:32px; font-size:12px; font-weight:700; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Cancel</button>
            <button type="button" class="wp-button primary" onclick="submitNewReview()" style="height:32px; font-size:12px; font-weight:800; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; border:1px solid #8A681F;">+ Save Review</button>
        </div>
    </div>
</div>

<!-- MODAL: REPLY TO CUSTOMER -->
<div id="replyReviewModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.75); backdrop-filter:blur(5px); z-index:9999999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:95%; max-width:500px; border-radius:10px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4); overflow:hidden; border:2px solid #D4AF37;">
        <div style="background:linear-gradient(135deg, #261C0E 0%, #3A2C12 40%, #18120A 100%); padding:14px 18px; color:#FAF5E8; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid #D4AF37;">
            <h3 style="margin:0; font-size:15px; font-weight:800; color:#FFFFFF;" id="replyModalTitle">Store Official Reply</h3>
            <button type="button" onclick="closeReplyModal()" style="background:none; border:none; color:#FFE57F; font-size:22px; cursor:pointer;">&times;</button>
        </div>
        <div style="padding:18px 20px;">
            <p style="font-size:12.5px; color:#646970; margin-top:0; margin-bottom:10px;" id="replyTargetText">Replying to customer review...</p>
            <input type="hidden" id="replyReviewId" value="">
            <textarea id="replyContent" rows="4" placeholder="Write store's official response to display on product page..." style="width:100%; padding:8px 10px; font-size:12.5px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;"></textarea>
        </div>
        <div style="background:#f6f7f7; padding:12px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
            <button type="button" class="wp-button" onclick="closeReplyModal()" style="height:32px; font-size:12px; font-weight:700; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Cancel</button>
            <button type="button" class="wp-button primary" onclick="submitReply()" style="height:32px; font-size:12px; font-weight:800; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; border:1px solid #8A681F;">Publish Store Reply</button>
        </div>
    </div>
</div>

<script>
function searchReviews(q) {
    const term = (q || '').toLowerCase().trim();
    document.querySelectorAll('#reviewsTableBody tr').forEach(r => {
        r.style.display = r.textContent.toLowerCase().includes(term) ? '' : 'none';
    });
}

function toggleSelectAllReviews(master) {
    document.querySelectorAll('.review-row-check').forEach(c => { c.checked = master.checked; });
}

function moderateReview(id, action) {
    if (action === 'delete' && !confirm('Permanently delete review #' + id + '?')) return;
    const params = new URLSearchParams();
    params.append('action', action);
    params.append('id', id);
    fetch('/api/reviews.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(r => r.json())
        .then(data => {
            if (data && data.success === false) {
                if (typeof window.showToast === 'function') window.showToast('⚠️ ' + (data.message || 'Action failed'));
                return;
            }
            const row = document.getElementById('review-row-' + id);
            if (row) row.remove();
            if (typeof window.showToast === 'function') window.showToast('✓ Review ' + action + 'd successfully');
            setTimeout(() => window.location.reload(), 400);
        })
        .catch(() => {
            if (typeof window.showToast === 'function') window.showToast('⚠️ Could not reach the server');
        });
}

function handleBulkReviewAction() {
    const action = document.getElementById('bulkReviewActionSelect')?.value;
    if (!action) return;
    const ids = Array.from(document.querySelectorAll('.review-row-check:checked')).map(c => c.value);
    if (ids.length === 0) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Select at least one review');
        return;
    }
    if (action === 'delete' && !confirm('Delete ' + ids.length + ' reviews permanently?')) return;

    let done = 0;
    ids.forEach(id => {
        const params = new URLSearchParams();
        params.append('action', action === 'unapprove' ? 'reject' : action);
        params.append('id', id);
        fetch('/api/reviews.php', { method: 'POST', body: params, credentials: 'same-origin' })
            .then(() => { if (++done === ids.length) window.location.reload(); })
            .catch(() => { if (++done === ids.length) window.location.reload(); });
    });
}

function openAddReviewModal() {
    const m = document.getElementById('addReviewModal');
    if (m) m.style.display = 'flex';
}

function closeAddReviewModal() {
    const m = document.getElementById('addReviewModal');
    if (m) m.style.display = 'none';
}

function submitNewReview() {
    const name = document.getElementById('revCustName').value.trim();
    const productId = parseInt(document.getElementById('revProductId').value, 10);
    const text = document.getElementById('revComment').value.trim();
    if (!name || !productId || !text) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Name, product id and review text are required');
        return;
    }
    const params = new URLSearchParams();
    params.append('product_id', productId);
    params.append('name', name);
    params.append('rating', document.getElementById('revStars').value);
    params.append('review_title', document.getElementById('revHeadline').value.trim());
    params.append('review_text', text);
    params.append('verified_buyer', document.getElementById('revVerified').value);
    fetch('/api/reviews.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(r => r.json())
        .then(() => { window.location.reload(); })
        .catch(() => window.location.reload());
}

function openReplyModal(id, cust) {
    document.getElementById('replyReviewId').value = id;
    document.getElementById('replyTargetText').textContent = 'Replying to review #' + id + ' by ' + cust;
    const m = document.getElementById('replyReviewModal');
    if (m) m.style.display = 'flex';
}

function closeReplyModal() {
    const m = document.getElementById('replyReviewModal');
    if (m) m.style.display = 'none';
}

function submitReply() {
    const id = document.getElementById('replyReviewId').value;
    const reply = document.getElementById('replyContent').value.trim();
    if (!reply) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Write a reply first');
        return;
    }
    const params = new URLSearchParams();
    params.append('action', 'reply');
    params.append('id', id);
    params.append('reply', reply);
    fetch('/api/reviews.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(r => r.json())
        .then(() => window.location.reload())
        .catch(() => window.location.reload());
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>