<?php
/* DT admin access guard (auto-inserted) */
$__dtg = __DIR__ . '/../includes/adminguard.php';
if (!is_file($__dtg)) {
    $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php';
}
if (is_file($__dtg)) require_once $__dtg;

/**
 * index.php - DT Brand's Master Reviews & Moderation Hub
 * Section 30 (Reviews Admin)
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/ProductCatalog.php';
require_once __DIR__ . '/../../src/ReviewManager.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;
use DTBrand\ReviewManager;

$page_title = "Customer Reviews & Moderation Hub";
$active_nav = "reviews";
$active_subnav = "all";

// Filters from Query Parameters
$filterStatus = trim($_GET['status'] ?? 'all');
$filterProductId = (int)($_GET['product_id'] ?? 0);
$filterRating = (int)($_GET['rating'] ?? 0);
$filterSearch = trim($_GET['search'] ?? '');

$filterParams = [
    'limit' => 150
];
if ($filterStatus !== 'all' && $filterStatus !== '') {
    $filterParams['status'] = $filterStatus;
}
if ($filterProductId > 0) {
    $filterParams['product_id'] = $filterProductId;
}
if ($filterRating > 0) {
    $filterParams['rating'] = $filterRating;
}
if ($filterSearch !== '') {
    $filterParams['search'] = $filterSearch;
}

$reviewsList = ReviewManager::getReviews($filterParams);
$stats = ReviewManager::getReviewStats();
$allProducts = ProductCatalog::getAll(true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reviews &amp; Moderation Hub - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-star-fill { fill: #D4AF37; stroke: #8A681F; }
        .dt-star-empty { fill: #E2E8F0; stroke: #CBD5E1; }
        .dt-rev-card { border: 1px solid #E2E8F0; border-radius: 10px; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .dt-filter-bar { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; background: #F8FAFC; border: 1px solid #E2E8F0; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; }
        .dt-filter-input { height: 36px; padding: 0 12px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 13px; color: #1E293B; background: #FFF; outline: none; }
        .dt-filter-input:focus { border-color: #8A681F; box-shadow: 0 0 0 2px rgba(138,104,31,0.2); }
        .dt-modal-backdrop { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15,23,42,0.6); z-index: 9999; backdrop-filter: blur(4px); align-items: center; justify-content: center; }
        .dt-modal-backdrop.active { display: flex; }
        .dt-modal-box { background: #FFF; border-radius: 12px; width: 95%; max-width: 680px; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2); border: 1px solid #E2E8F0; }
        .dt-modal-header { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid #E2E8F0; background: #FAF5E8; border-radius: 12px 12px 0 0; }
        .dt-modal-body { padding: 20px; }
        .dt-modal-footer { display: flex; justify-content: flex-end; gap: 8px; padding: 16px 20px; border-top: 1px solid #E2E8F0; background: #F8FAFC; border-radius: 0 0 12px 12px; }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <!-- Page Header -->
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Customer Reviews &amp; Moderation Hub</span>
                        <span class="adm-badge gold" style="display:inline-flex; align-items:center; gap:4px;">
                            <span><?= number_format($stats['avg_rating'], 1) ?></span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="#D4AF37" stroke="#8A681F" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            <span>(<?= (int)$stats['total'] ?> Reviews)</span>
                        </span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Audit authentic customer testimonials, 5-star ratings, verified buyer badges, and publish official store replies.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/reviews/pending.php" class="dt-btn dt-btn-gold" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:700; height:34px; padding:0 14px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <span>Pending Queue (<?= (int)$stats['pending'] ?>)</span>
                    </a>
                    <a href="/admin/reviews/audit.php" class="dt-btn dt-btn-pale" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:700; height:34px; padding:0 12px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span>Moderation Audit</span>
                    </a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Average Star Rating</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="#8A681F" stroke="#8A681F" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= number_format($stats['avg_rating'], 1) ?> / 5.0</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up"><?= (int)$stats['approved'] ?> Published Live</span>
                    </div>
                </div>

                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Pending Moderation</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= (int)$stats['pending'] ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta <?= $stats['pending'] > 0 ? 'down' : 'up' ?>">
                            <?= $stats['pending'] > 0 ? 'Requires Verification' : 'Queue Cleared' ?>
                        </span>
                    </div>
                </div>

                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">5-Star Testimonials</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= (int)$stats['five_star'] ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">High Customer Loyalty</span>
                    </div>
                </div>

                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Verified Buyers &amp; Replies</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= number_format($stats['verified_percentage'], 1) ?>%</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up"><?= (int)$stats['replied_count'] ?> Official Store Replies</span>
                    </div>
                </div>
            </div>

            <!-- Filter & Search Toolbar -->
            <form method="GET" action="/admin/reviews/" class="dt-filter-bar">
                <!-- Status Filter -->
                <select name="status" class="dt-filter-input" onchange="this.form.submit()">
                    <option value="all" <?= $filterStatus === 'all' ? 'selected' : '' ?>>All Statuses (<?= (int)$stats['total'] ?>)</option>
                    <option value="pending" <?= $filterStatus === 'pending' ? 'selected' : '' ?>>Pending Verification (<?= (int)$stats['pending'] ?>)</option>
                    <option value="approved" <?= $filterStatus === 'approved' ? 'selected' : '' ?>>Approved &amp; Live (<?= (int)$stats['approved'] ?>)</option>
                    <option value="flagged" <?= $filterStatus === 'flagged' ? 'selected' : '' ?>>Flagged / Support (<?= (int)$stats['flagged'] ?>)</option>
                    <option value="rejected" <?= $filterStatus === 'rejected' ? 'selected' : '' ?>>Rejected / Spam (<?= (int)$stats['rejected'] ?>)</option>
                </select>

                <!-- Product Filter -->
                <select name="product_id" class="dt-filter-input" style="max-width:240px;" onchange="this.form.submit()">
                    <option value="0">All Products / SKUs</option>
                    <?php foreach ($allProducts as $p): ?>
                        <option value="<?= (int)$p['id'] ?>" <?= $filterProductId === (int)$p['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($p['title']) ?> (SKU: <?= htmlspecialchars($p['sku'] ?? 'N/A') ?>)
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Rating Filter -->
                <select name="rating" class="dt-filter-input" onchange="this.form.submit()">
                    <option value="0">All Star Ratings</option>
                    <option value="5" <?= $filterRating === 5 ? 'selected' : '' ?>>5 Stars Only</option>
                    <option value="4" <?= $filterRating === 4 ? 'selected' : '' ?>>4 Stars Only</option>
                    <option value="3" <?= $filterRating === 3 ? 'selected' : '' ?>>3 Stars Only</option>
                    <option value="2" <?= $filterRating === 2 ? 'selected' : '' ?>>2 Stars Only</option>
                    <option value="1" <?= $filterRating === 1 ? 'selected' : '' ?>>1 Star Only</option>
                </select>

                <!-- Search Input -->
                <div style="position:relative; flex:1; min-width:200px;">
                    <input type="text" name="search" class="dt-filter-input" style="width:100%;" placeholder="Search customer, title, feedback, city..." value="<?= htmlspecialchars($filterSearch) ?>">
                </div>

                <button type="submit" class="dt-btn dt-btn-gold" style="height:36px; padding:0 14px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <span>Filter</span>
                </button>

                <?php if ($filterStatus !== 'all' || $filterProductId > 0 || $filterRating > 0 || $filterSearch !== ''): ?>
                    <a href="/admin/reviews/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:36px; padding:0 12px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:4px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        <span>Reset</span>
                    </a>
                <?php endif; ?>
            </form>

            <!-- Reviews Master Table -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title">
                        <span style="display:inline-flex; align-items:center; gap:6px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            <span>Customer Reviews (<?= count($reviewsList) ?> records)</span>
                        </span>
                    </h3>
                    <div style="display:flex; gap:6px;">
                        <span class="adm-badge" style="background:#FAF5E8; color:#705114; border:1px solid #D4AF37;">
                            Real-Time Synced
                        </span>
                    </div>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Customer &amp; Location</th>
                                <th>Product Details</th>
                                <th>Rating Stars</th>
                                <th>Feedback &amp; Store Reply</th>
                                <th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($reviewsList)): ?>
                                <tr>
                                    <td colspan="6" style="text-align:center; padding:36px; color:#64748B;">
                                        <div style="font-weight:700; font-size:14px; margin-bottom:4px;">No customer reviews match your filter</div>
                                        <div style="font-size:12px;">Try adjusting status, rating, or search parameters above.</div>
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php foreach ($reviewsList as $rev): ?>
                                <?php
                                $rId = (int)$rev['id'];
                                $rStatus = $rev['status'] ?? 'pending';
                                $badgeClass = 'warning';
                                $badgeText = 'Pending Moderation';
                                if ($rStatus === 'approved') {
                                    $badgeClass = 'success';
                                    $badgeText = 'Approved & Live';
                                } elseif ($rStatus === 'flagged') {
                                    $badgeClass = 'warning';
                                    $badgeText = 'Flagged / Support';
                                } elseif ($rStatus === 'rejected') {
                                    $badgeClass = 'danger';
                                    $badgeText = 'Rejected / Hidden';
                                }
                                $isVerified = !empty($rev['verified_buyer']);
                                $hasReply = !empty($rev['store_reply']);
                                ?>
                                <tr id="revRow_<?= $rId ?>">
                                    <td>
                                        <div style="font-weight:700; color:#111827; display:flex; align-items:center; gap:4px;">
                                            <span><?= htmlspecialchars($rev['customer_name'] ?? 'Buyer') ?></span>
                                            <?php if ($isVerified): ?>
                                                <span title="Verified Handloom Buyer" style="display:inline-flex; align-items:center; color:#15803D;">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div style="font-size:11px; color:#64748B; margin-top:2px;">
                                            <span><?= htmlspecialchars($rev['city'] ?? 'India') ?></span>
                                            &bull;
                                            <span><?= date('d M Y, h:i A', strtotime($rev['created_at'] ?? 'now')) ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-weight:600; color:#1F2937; font-size:12.5px;">
                                            <?= htmlspecialchars($rev['product_title'] ?? 'Handloom Saree') ?>
                                        </div>
                                        <div style="font-size:11px; color:#8A681F; font-weight:700; margin-top:2px;">
                                            SKU: <?= htmlspecialchars($rev['product_sku'] ?? ('PROD-' . (int)($rev['product_id'] ?? 1))) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display:inline-flex; align-items:center; gap:2px;">
                                            <?php for ($si = 1; $si <= 5; $si++): ?>
                                                <svg width="12" height="12" viewBox="0 0 24 24" class="<?= $si <= (int)($rev['rating'] ?? 5) ? 'dt-star-fill' : 'dt-star-empty' ?>" stroke-width="1.2">
                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                </svg>
                                            <?php endfor; ?>
                                            <span style="font-weight:800; font-size:11px; color:#111827; margin-left:3px;">(<?= (int)($rev['rating'] ?? 5) ?>.0)</span>
                                        </div>
                                    </td>
                                    <td style="max-width:320px;">
                                        <?php if (!empty($rev['review_title'])): ?>
                                            <div style="font-weight:700; font-size:12px; color:#111827; margin-bottom:2px;">
                                                <?= htmlspecialchars($rev['review_title']) ?>
                                            </div>
                                        <?php endif; ?>
                                        <div style="font-size:12px; color:#334155; line-height:1.4;">
                                            &ldquo;<?= htmlspecialchars(mb_strimwidth($rev['review_text'] ?? '', 0, 110, '...')) ?>&rdquo;
                                        </div>
                                        <?php if ($hasReply): ?>
                                            <div style="margin-top:6px; background:#FAF5E8; border-left:3px solid #8A681F; padding:4px 8px; border-radius:3px; font-size:11px; color:#705114;">
                                                <strong>DT Brand's:</strong> <?= htmlspecialchars(mb_strimwidth($rev['store_reply'], 0, 75, '...')) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="adm-badge <?= $badgeClass ?>" id="badgeStatus_<?= $rId ?>"><?= $badgeText ?></span>
                                    </td>
                                    <td style="text-align:right;">
                                        <div style="display:inline-flex; gap:4px;">
                                            <!-- Inspect Modal Button -->
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px;" onclick="openReviewInspector(<?= $rId ?>)" title="View Full Review &amp; Reply">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                <span>Inspect</span>
                                            </button>

                                            <?php if ($rStatus === 'pending'): ?>
                                                <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px;" onclick="dtModerateReview(<?= $rId ?>, 'approve')" title="Approve &amp; Publish">
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                    <span>Approve</span>
                                                </button>
                                            <?php endif; ?>

                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="color:#DC2626; border-color:#FECACA; background:#FEF2F2;" onclick="dtModerateReview(<?= $rId ?>, 'delete')" title="Delete Review">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ══ Inspector & Store Reply Modal ══ -->
<div class="dt-modal-backdrop" id="reviewInspectorModal">
    <div class="dt-modal-box">
        <div class="dt-modal-header">
            <h3 style="margin:0; font-size:15px; font-weight:800; color:#181512; display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                <span>Review Moderation Inspector</span>
            </h3>
            <button type="button" onclick="closeReviewInspector()" style="background:none; border:none; cursor:pointer; color:#64748B;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <div class="dt-modal-body" id="inspectorContent">
            <div style="text-align:center; padding:30px; color:#64748B;">Loading review details...</div>
        </div>
        <div class="dt-modal-footer">
            <button type="button" class="dt-btn dt-btn-pale" onclick="closeReviewInspector()">Close</button>
        </div>
    </div>
</div>

<script>
function toast(m, type) {
    if (typeof window.showToast === 'function') window.showToast(m, type);
    else console.warn(m);
}

function dtModerateReview(id, action, reason = '') {
    if (action === 'delete' && !confirm('Permanently delete this customer review? This action will be logged in the audit ledger.')) {
        return;
    }

    const params = new URLSearchParams();
    params.append('action', action);
    params.append('id', id);
    if (reason) params.append('reason', reason);

    fetch('/api/reviews.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            if (!data || !data.success) {
                toast('Could not update review: ' + ((data && data.message) ? data.message : 'Please try again.'));
                return;
            }

            const row = document.getElementById('revRow_' + id);
            if (action === 'delete') {
                if (row) row.remove();
                toast('Review permanently deleted from database.');
                closeReviewInspector();
                return;
            }

            const badge = document.getElementById('badgeStatus_' + id);
            if (badge) {
                if (action === 'approve') {
                    badge.className = 'adm-badge success';
                    badge.innerText = 'Approved & Live';
                } else if (action === 'reject') {
                    badge.className = 'adm-badge danger';
                    badge.innerText = 'Rejected / Hidden';
                } else if (action === 'flag') {
                    badge.className = 'adm-badge warning';
                    badge.innerText = 'Flagged / Support';
                }
            }
            toast(data.message || 'Review updated successfully.');
            if (document.getElementById('reviewInspectorModal').classList.contains('active')) {
                openReviewInspector(id);
            }
        })
        .catch(() => {
            toast('Network error — the review was not updated.');
        });
}

function openReviewInspector(id) {
    const modal = document.getElementById('reviewInspectorModal');
    const content = document.getElementById('inspectorContent');
    modal.classList.add('active');
    content.innerHTML = '<div style="text-align:center; padding:30px; color:#64748B;">Loading review details...</div>';

    fetch('/api/reviews.php?action=inspect&id=' + id)
        .then(res => res.json())
        .then(data => {
            if (!data || !data.success || !data.review) {
                content.innerHTML = '<div style="color:#DC2626; padding:20px;">Could not load review information.</div>';
                return;
            }

            const r = data.review;
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                starsHtml += `<svg width="14" height="14" viewBox="0 0 24 24" class="${i <= (r.rating || 5) ? 'dt-star-fill' : 'dt-star-empty'}" stroke-width="1.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>`;
            }

            content.innerHTML = `
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:14px; padding-bottom:12px; border-bottom:1px solid #E2E8F0;">
                    <div>
                        <h4 style="margin:0 0 4px 0; font-size:15px; color:#111827;">${escapeHtml(r.customer_name || 'Customer')}</h4>
                        <div style="font-size:12px; color:#64748B;">
                            ${escapeHtml(r.customer_email || 'No email')} &bull; ${escapeHtml(r.customer_phone || 'No phone')} &bull; ${escapeHtml(r.city || 'India')}
                        </div>
                    </div>
                    <div style="text-align:right;">
                        <span class="adm-badge ${r.status === 'approved' ? 'success' : (r.status === 'rejected' ? 'danger' : 'warning')}">${escapeHtml(r.status.toUpperCase())}</span>
                        <div style="font-size:11px; color:#64748B; margin-top:4px;">${escapeHtml(r.created_at || '')}</div>
                    </div>
                </div>

                <div style="margin-bottom:14px;">
                    <div style="font-size:11.5px; font-weight:700; color:#8A681F; text-transform:uppercase; margin-bottom:4px;">Product Reviewed</div>
                    <div style="font-weight:700; color:#111827; font-size:13px;">${escapeHtml(r.product_title || ('Product #' + r.product_id))}</div>
                    <div style="display:flex; align-items:center; gap:4px; margin-top:6px;">
                        ${starsHtml}
                        <span style="font-weight:800; font-size:12px; color:#111827; margin-left:4px;">${r.rating}.0 / 5.0</span>
                    </div>
                </div>

                <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:12px; margin-bottom:16px;">
                    <div style="font-weight:800; font-size:13px; color:#111827; margin-bottom:4px;">${escapeHtml(r.review_title || 'Customer Testimonial')}</div>
                    <div style="font-size:13px; color:#334155; line-height:1.5;">${escapeHtml(r.review_text || '')}</div>
                </div>

                <!-- Store Reply Section -->
                <div style="margin-top:16px; border-top:1px solid #E2E8F0; padding-top:14px;">
                    <div style="font-size:12px; font-weight:800; color:#181512; margin-bottom:6px; display:flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        <span>Official Store Reply (Shown on Live PDP)</span>
                    </div>
                    <textarea id="storeReplyInput_${r.id}" rows="3" style="width:100%; border:1px solid #CBD5E1; border-radius:6px; padding:8px; font-size:12.5px; color:#1E293B; font-family:inherit; outline:none;" placeholder="Write official brand response to this customer...">${escapeHtml(r.store_reply || '')}</textarea>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:8px;">
                        <span style="font-size:11px; color:#64748B;">
                            ${r.store_replied_at ? 'Last replied: ' + escapeHtml(r.store_replied_at) + ' by ' + escapeHtml(r.store_replied_by || 'Admin') : 'No reply published yet'}
                        </span>
                        <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="submitStoreReply(${r.id})">
                            <span>Publish Store Reply</span>
                        </button>
                    </div>
                </div>

                <!-- Quick Moderation Buttons in Modal -->
                <div style="display:flex; gap:8px; margin-top:20px; padding-top:14px; border-top:1px solid #E2E8F0;">
                    <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" onclick="dtModerateReview(${r.id}, 'approve')">Approve Live</button>
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="dtModerateReview(${r.id}, 'unpublish')">Move to Pending</button>
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="color:#B45309;" onclick="promptFlagReview(${r.id})">Flag Ticket</button>
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="color:#DC2626;" onclick="promptRejectReview(${r.id})">Reject / Spam</button>
                </div>
            `;
        })
        .catch(() => {
            content.innerHTML = '<div style="color:#DC2626; padding:20px;">Network error loading review.</div>';
        });
}

function closeReviewInspector() {
    document.getElementById('reviewInspectorModal').classList.remove('active');
}

function submitStoreReply(id) {
    const input = document.getElementById('storeReplyInput_' + id);
    if (!input) return;
    const reply = input.value.trim();
    if (!reply) {
        toast('Store reply text cannot be empty.');
        return;
    }

    const params = new URLSearchParams();
    params.append('action', 'reply');
    params.append('id', id);
    params.append('reply', reply);

    fetch('/api/reviews.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            if (!data || !data.success) {
                toast('Could not publish reply: ' + ((data && data.message) ? data.message : 'Please try again.'));
                return;
            }
            toast('Store reply published live successfully!');
            openReviewInspector(id);
        })
        .catch(() => {
            toast('Network error — store reply not saved.');
        });
}

function promptRejectReview(id) {
    const reason = prompt('Please enter rejection reason (e.g., spam, offensive language, competitor link):', 'Spam / promotional content');
    if (reason !== null) {
        dtModerateReview(id, 'reject', reason);
    }
}

function promptFlagReview(id) {
    const reason = prompt('Please enter flag reason (e.g., customer exchange pending, delivery query):', 'Customer support ticket opened');
    if (reason !== null) {
        dtModerateReview(id, 'flag', reason);
    }
}

function escapeHtml(text) {
    if (!text) return '';
    return String(text)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
