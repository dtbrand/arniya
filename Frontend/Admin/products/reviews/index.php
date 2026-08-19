<?php
/**
 * index.php — DT Brand's Product Reviews & Customer Moderation Suite (Wholesale & Luxury Shop Standard)
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Product Reviews Moderation";
$active_nav = "products";
$active_subnav = "reviews";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Reviews ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <style>
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
    .dt-kpi-card:hover {
        border-color: #D4AF37;
        box-shadow: 0 4px 12px rgba(212,175,55,0.15);
        transform: translateY(-1px);
    }
    .dt-review-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #181512, #3D342A);
        color: #D4AF37;
        font-weight: 800;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1.5px solid #D4AF37;
        box-shadow: 0 2px 6px rgba(212,175,55,0.25);
        flex-shrink: 0;
    }
    .dt-user-img-thumb {
        width: 44px;
        height: 44px;
        object-fit: cover;
        border-radius: 6px;
        border: 1.5px solid #D4AF37;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .dt-user-img-thumb:hover {
        transform: scale(1.15);
        box-shadow: 0 4px 12px rgba(212,175,55,0.3);
    }
    .dt-btn-action-pill {
        height: 26px;
        padding: 0 8px;
        font-size: 11px;
        font-weight: 700;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .dt-btn-action-pill:hover {
        transform: translateY(-1px);
    }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 16px 20px;">

            <!-- 1. Header Toolbar with Luxury Brand Gold Styling -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Product Reviews &amp; Ratings</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:11px; padding:3px 8px;">★ 4.92 / 5.0 Average</span>
                    <span class="adm-badge" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-weight:700; font-size:11px;">1,420 Verified Reviews</span>
                </div>

                <div style="display:flex; align-items:center; gap:8px;">
                    <a href="/Frontend/Admin/products/" class="wp-button" style="height:32px; font-size:12px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:5px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Back to Products</span>
                    </a>
                    <button type="button" class="wp-button primary" onclick="openAddReviewModal()" style="background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; font-weight:800; border:1px solid #8A681F; padding:0 14px; height:32px; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Add Manual Review</span>
                    </button>
                    <button type="button" class="wp-button" onclick="if(window.exportCurrentTable) window.exportCurrentTable('dt_product_reviews'); return false;" style="height:32px; padding:0 11px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        <span>Export CSV</span>
                    </button>
                </div>
            </div>

            <!-- 2. KPI Metrics Ribbon -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:12px; margin-bottom:14px;">
                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">SATISFACTION RATING</div>
                        <div style="font-size:17px; font-weight:800; color:#181512;">4.92 / 5.0 (98.4%)</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#DCFCE7; border:1px solid #86EFAC; display:flex; align-items:center; justify-content:center; color:#15803D;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">APPROVED &amp; LIVE</div>
                        <div style="font-size:17px; font-weight:800; color:#15803D;">1,380 Reviews</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FEF3C7; border:1px solid #FCD34D; display:flex; align-items:center; justify-content:center; color:#B45309;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">PENDING MODERATION</div>
                        <div style="font-size:17px; font-weight:800; color:#B45309;">24 New Reviews</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#EFF6FF; border:1px solid #93C5FD; display:flex; align-items:center; justify-content:center; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">WITH CUSTOMER PHOTOS</div>
                        <div style="font-size:17px; font-weight:800; color:#1D4ED8;">340 Photos</div>
                    </div>
                </div>
            </div>

            <!-- 3. Status Views Filter Tabs (.subsubsub) -->
            <ul class="wp-subsubsub" style="margin-bottom:12px;">
                <li><a href="#" class="current" onclick="filterReviews(''); return false;">All <span class="count">(1,420)</span></a> <span class="sep">|</span></li>
                <li><a href="#" onclick="filterReviews('Approved'); return false;">Approved <span class="count">(1,380)</span></a> <span class="sep">|</span></li>
                <li><a href="#" onclick="filterReviews('Pending'); return false;">Pending <span class="count">(24)</span></a> <span class="sep">|</span></li>
                <li><a href="#" onclick="filterReviews('Featured'); return false;">Featured on Home <span class="count">(48)</span></a> <span class="sep">|</span></li>
                <li><a href="#" onclick="filterReviews('5.0'); return false;">5 Stars ★★★★★ <span class="count">(1,150)</span></a> <span class="sep">|</span></li>
                <li><a href="#" onclick="filterReviews('4.0'); return false;">4 Stars ★★★★☆ <span class="count">(210)</span></a> <span class="sep">|</span></li>
                <li><a href="#" onclick="filterReviews('Photo'); return false;">With Photos 📸 <span class="count">(340)</span></a></li>
            </ul>

            <!-- 4. Top Toolbar: Bulk Actions, Unclipped Filter Dropdowns & Rule-Compliant Search Input -->
            <div class="wp-tablenav" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:12px;">
                <div class="wp-tablenav-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <select class="wp-select" id="bulkReviewActionSelect" style="height:34px; font-size:12px; min-width:130px;">
                        <option value="">Bulk actions</option>
                        <option value="approve">Approve Selected</option>
                        <option value="unapprove">Unapprove (Pending)</option>
                        <option value="pin">Pin to Featured</option>
                        <option value="trash">Move to Trash</option>
                    </select>
                    <button type="button" class="wp-button" onclick="handleBulkReviewAction()" style="height:34px; font-size:12px; font-weight:600; padding:0 12px; display:inline-flex; align-items:center; gap:4px;">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Apply</span>
                    </button>

                    <!-- Unclipped Dropdowns with proper min-width -->
                    <select class="wp-select" id="filterRatingSelect" onchange="filterReviewsByRating(this.value)" style="height:34px; font-size:12px; min-width:170px;">
                        <option value="">Filter by star rating</option>
                        <option value="5.0">5 Stars (★★★★★)</option>
                        <option value="4.0">4 Stars (★★★★☆)</option>
                        <option value="3.0">3 Stars (★★★☆☆)</option>
                    </select>

                    <select class="wp-select" id="filterProductSelect" onchange="filterReviewsByProduct(this.value)" style="height:34px; font-size:12px; min-width:180px;">
                        <option value="">Filter by product</option>
                        <option value="Kanjivaram">Kanjivaram Pure Silk Saree</option>
                        <option value="Banarasi">Banarasi Brocade Saree</option>
                        <option value="Lehenga">Crimson Bridal Lehenga</option>
                        <option value="Kurti">Chanderi Kurti Set</option>
                    </select>

                    <button type="button" class="wp-button" onclick="applyReviewFilters()" style="height:34px; font-size:12px; font-weight:600; padding:0 12px; display:inline-flex; align-items:center; gap:5px;">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        <span>Filter</span>
                    </button>
                </div>

                <!-- Mandatory Left-Aligned Search Icon with 1-Tap Clear Button -->
                <div class="wp-search-box" style="display:flex; align-items:center; gap:6px;">
                    <div style="position:relative; display:inline-flex; align-items:center;">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.2" style="position:absolute; left:12px; pointer-events:none;">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" id="reviewSearchInput" class="wp-search-input" placeholder="Search customer, reviews..." style="height:34px; padding-left:36px; padding-right:28px; width:220px; font-size:12px; border:1px solid #c3c4c7; border-radius:4px; outline:none;" oninput="searchReviews(this.value); toggleReviewSearchClearBtn(this.value)">
                        <span id="reviewSearchClearBtn" onclick="clearReviewSearch()" style="position:absolute; right:8px; cursor:pointer; color:#8c8f94; font-size:13px; font-weight:700; display:none;" title="Clear search">✕</span>
                    </div>
                    <button type="button" class="wp-button primary" onclick="searchReviews(document.getElementById('reviewSearchInput').value)" style="height:34px; font-size:12px; font-weight:600; padding:0 12px;">Search Reviews</button>
                </div>
            </div>

            <!-- 5. High-Craft Reviews Table Card -->
            <div class="wp-table-card" style="background:#fff; border:1px solid #c3c4c7; border-radius:6px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <table class="wp-list-table" id="reviewsTable" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f6f7f7; border-bottom:1px solid #c3c4c7;">
                            <th style="width: 36px; text-align: center; padding:10px 8px;">
                                <input type="checkbox" onchange="toggleSelectAllReviews(this)" style="cursor:pointer; width:15px; height:15px;">
                            </th>
                            <th style="width: 190px; padding:10px 12px;">Customer</th>
                            <th style="width: 150px; padding:10px 10px;">Rating &amp; Photos</th>
                            <th style="padding:10px 12px;">Review Content &amp; Admin Reply</th>
                            <th style="width: 190px; padding:10px 10px;">Product &amp; SKU</th>
                            <th style="width: 110px; padding:10px 10px;">Status</th>
                            <th style="width: 140px; text-align: right; padding:10px 12px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="reviewsTableBody">

                        <!-- Review 1 -->
                        <tr style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                            <td style="text-align: center; padding:12px 8px; vertical-align:top;">
                                <input type="checkbox" class="review-row-check" style="cursor:pointer; width:15px; height:15px;">
                            </td>
                            <td style="padding:12px 12px; vertical-align:top;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <div class="dt-review-avatar">SR</div>
                                    <div>
                                        <strong style="font-size:13px; color:#181512; display:block;">Sunita Rao</strong>
                                        <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-size:10px; padding:1px 5px; font-weight:700;">✓ Verified Buyer</span>
                                        <small style="display:block; color:#646970; font-size:11px; margin-top:2px;">Surat, Gujarat</small>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:12px 10px; vertical-align:top;">
                                <div style="color:#D4AF37; font-size:15px; letter-spacing:1px; font-weight:700;">★★★★★</div>
                                <span style="font-size:11.5px; font-weight:700; color:#181512;">5.0 Rating</span>
                                <div style="margin-top:6px; display:flex; gap:4px;">
                                    <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" class="dt-user-img-thumb" alt="Customer Photo" title="Click to view full photo">
                                </div>
                            </td>
                            <td style="padding:12px 12px; vertical-align:top;">
                                <strong style="font-size:13px; color:#181512; display:block; margin-bottom:4px;">"Unmatched pure gold zari weave quality!"</strong>
                                <p style="font-size:12.5px; color:#2c3338; line-height:1.45; margin:0 0 8px 0;">
                                    The fabric is 100% pure zari silk and color richness is unmatched. I ordered 12 pcs lot for my boutique in Bangalore. Dispatched in 24 hours from Surat depot. Every customer loved it!
                                </p>
                                <div style="background:#FAF5E8; border-left:3px solid #D4AF37; padding:6px 10px; border-radius:0 4px 4px 0; font-size:11.5px;">
                                    <strong style="color:#8A681F;">Store Reply:</strong> <span style="color:#5A4210;">Thank you Sunita ji! Delighted to support your boutique with factory-direct Surat silk collections!</span>
                                </div>
                            </td>
                            <td style="padding:12px 10px; vertical-align:top;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:38px; height:38px; object-fit:cover; border-radius:4px; border:1px solid #c3c4c7;">
                                    <div>
                                        <a href="/Frontend/Admin/products/edit.php?id=101" style="font-size:12px; font-weight:700; color:#181512; text-decoration:none;">Kanjivaram Pure Silk Saree</a>
                                        <code style="display:block; font-size:10.5px; color:#646970;">KLN-SR-111</code>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:12px 10px; vertical-align:top;">
                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px; display:inline-flex; align-items:center; gap:4px;">
                                    <span style="width:6px; height:6px; border-radius:50%; background:#16a34a; display:inline-block;"></span>
                                    <span>Approved</span>
                                </span>
                                <span class="adm-badge gold" style="display:inline-block; margin-top:4px; font-size:10px; padding:1px 5px;">📌 Featured</span>
                            </td>
                            <td style="padding:12px 12px; vertical-align:top; text-align:right;">
                                <div style="display:flex; flex-direction:column; gap:5px; align-items:flex-end;">
                                    <button type="button" class="dt-btn-action-pill" onclick="openReplyModal('Sunita Rao', 'Kanjivaram Pure Silk Saree')" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8;">💬 Reply</button>
                                    <button type="button" class="dt-btn-action-pill" onclick="window.shareProductWhatsApp(101)" style="background:#DCFCE7; border:1px solid #86EFAC; color:#15803D;">💬 WhatsApp</button>
                                    <button type="button" class="dt-btn-action-pill" style="background:#FEF2F2; border:1px solid #FECACA; color:#DC2626;" onclick="if(window.showToast) window.showToast('Review moved to trash'); this.closest('tr').remove();">🗑️ Trash</button>
                                </div>
                            </td>
                        </tr>

                        <!-- Review 2 -->
                        <tr style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                            <td style="text-align: center; padding:12px 8px; vertical-align:top;">
                                <input type="checkbox" class="review-row-check" style="cursor:pointer; width:15px; height:15px;">
                            </td>
                            <td style="padding:12px 12px; vertical-align:top;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <div class="dt-review-avatar" style="background:#1e3a8a; color:#93c5fd; border-color:#60a5fa;">AK</div>
                                    <div>
                                        <strong style="font-size:13px; color:#181512; display:block;">Ananya Kulkarni</strong>
                                        <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-size:10px; padding:1px 5px; font-weight:700;">✓ Verified Buyer</span>
                                        <small style="display:block; color:#646970; font-size:11px; margin-top:2px;">Pune, Maharashtra</small>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:12px 10px; vertical-align:top;">
                                <div style="color:#D4AF37; font-size:15px; letter-spacing:1px; font-weight:700;">★★★★★</div>
                                <span style="font-size:11.5px; font-weight:700; color:#181512;">5.0 Rating</span>
                                <div style="margin-top:6px; display:flex; gap:4px;">
                                    <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" class="dt-user-img-thumb" alt="Customer Photo">
                                </div>
                            </td>
                            <td style="padding:12px 12px; vertical-align:top;">
                                <strong style="font-size:13px; color:#181512; display:block; margin-bottom:4px;">"Royal Banarasi Brocade Weave!"</strong>
                                <p style="font-size:12.5px; color:#2c3338; line-height:1.45; margin:0;">
                                    Looks much more premium in real than photos. The gold zari luster is authentic and soft on skin. Fast packaging and received with authentic Silk Mark tags.
                                </p>
                            </td>
                            <td style="padding:12px 10px; vertical-align:top;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" style="width:38px; height:38px; object-fit:cover; border-radius:4px; border:1px solid #c3c4c7;">
                                    <div>
                                        <a href="/Frontend/Admin/products/edit.php?id=102" style="font-size:12px; font-weight:700; color:#181512; text-decoration:none;">Banarasi Royal Brocade Saree</a>
                                        <code style="display:block; font-size:10.5px; color:#646970;">BNR-SR-204</code>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:12px 10px; vertical-align:top;">
                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px; display:inline-flex; align-items:center; gap:4px;">
                                    <span style="width:6px; height:6px; border-radius:50%; background:#16a34a; display:inline-block;"></span>
                                    <span>Approved</span>
                                </span>
                            </td>
                            <td style="padding:12px 12px; vertical-align:top; text-align:right;">
                                <div style="display:flex; flex-direction:column; gap:5px; align-items:flex-end;">
                                    <button type="button" class="dt-btn-action-pill" onclick="openReplyModal('Ananya Kulkarni', 'Banarasi Royal Brocade Saree')" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8;">💬 Reply</button>
                                    <button type="button" class="dt-btn-action-pill" onclick="window.shareProductWhatsApp(102)" style="background:#DCFCE7; border:1px solid #86EFAC; color:#15803D;">💬 WhatsApp</button>
                                    <button type="button" class="dt-btn-action-pill" style="background:#FEF2F2; border:1px solid #FECACA; color:#DC2626;" onclick="if(window.showToast) window.showToast('Review moved to trash'); this.closest('tr').remove();">🗑️ Trash</button>
                                </div>
                            </td>
                        </tr>

                        <!-- Review 3 -->
                        <tr style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                            <td style="text-align: center; padding:12px 8px; vertical-align:top;">
                                <input type="checkbox" class="review-row-check" style="cursor:pointer; width:15px; height:15px;">
                            </td>
                            <td style="padding:12px 12px; vertical-align:top;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <div class="dt-review-avatar" style="background:#831843; color:#fbcfe8; border-color:#f472b6;">PS</div>
                                    <div>
                                        <strong style="font-size:13px; color:#181512; display:block;">Pooja Sharma</strong>
                                        <span class="adm-badge" style="background:#FEF3C7; color:#B45309; font-size:10px; padding:1px 5px; font-weight:700;">New Customer</span>
                                        <small style="display:block; color:#646970; font-size:11px; margin-top:2px;">Jaipur, Rajasthan</small>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:12px 10px; vertical-align:top;">
                                <div style="color:#D4AF37; font-size:15px; letter-spacing:1px; font-weight:700;">★★★★★</div>
                                <span style="font-size:11.5px; font-weight:700; color:#181512;">5.0 Rating</span>
                            </td>
                            <td style="padding:12px 12px; vertical-align:top;">
                                <strong style="font-size:13px; color:#181512; display:block; margin-bottom:4px;">"Heavy Zardosi Bridal Masterpiece!"</strong>
                                <p style="font-size:12.5px; color:#2c3338; line-height:1.45; margin:0;">
                                    Ordered for my wedding reception. The flare and cancan layering is great. Heavy handcrafted zardosi embroidery looks royal. Worth every rupee!
                                </p>
                            </td>
                            <td style="padding:12px 10px; vertical-align:top;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <img src="/Shared/Asset/images/product3.png" onerror="this.src='/Frontend/Shop/Asset/images/product3.png';" style="width:38px; height:38px; object-fit:cover; border-radius:4px; border:1px solid #c3c4c7;">
                                    <div>
                                        <a href="/Frontend/Admin/products/edit.php?id=103" style="font-size:12px; font-weight:700; color:#181512; text-decoration:none;">Crimson Bridal Lehenga</a>
                                        <code style="display:block; font-size:10.5px; color:#646970;">BRD-LH-902</code>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:12px 10px; vertical-align:top;">
                                <span class="adm-badge" style="background:#FEF3C7; color:#B45309; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px; display:inline-flex; align-items:center; gap:4px;">
                                    <span style="width:6px; height:6px; border-radius:50%; background:#d97706; display:inline-block;"></span>
                                    <span>Pending</span>
                                </span>
                            </td>
                            <td style="padding:12px 12px; vertical-align:top; text-align:right;">
                                <div style="display:flex; flex-direction:column; gap:5px; align-items:flex-end;">
                                    <button type="button" class="dt-btn-action-pill" onclick="approveSingleReview(this)" style="background:linear-gradient(135deg, #8A681F, #D4AF37); color:#181512; border:1px solid #8A681F; font-weight:800;">✓ Approve</button>
                                    <button type="button" class="dt-btn-action-pill" onclick="openReplyModal('Pooja Sharma', 'Crimson Bridal Lehenga')" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8;">💬 Reply</button>
                                    <button type="button" class="dt-btn-action-pill" style="background:#FEF2F2; border:1px solid #FECACA; color:#DC2626;" onclick="if(window.showToast) window.showToast('Review moved to trash'); this.closest('tr').remove();">🗑️ Trash</button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <!-- 6. Bottom Toolbar & Pagination -->
            <div class="wp-tablenav" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-top:14px;">
                <div class="wp-tablenav-actions" style="display:flex; align-items:center; gap:8px;">
                    <select class="wp-select" id="bulkReviewActionSelectBottom" style="height:34px; font-size:12px; min-width:130px;">
                        <option value="">Bulk actions</option>
                        <option value="approve">Approve Selected</option>
                        <option value="trash">Move to Trash</option>
                    </select>
                    <button type="button" class="wp-button" onclick="handleBulkReviewActionBottom()" style="height:34px; font-size:12px; font-weight:600; padding:0 12px;">Apply</button>
                </div>

                <div class="wp-pagination" style="display:flex; align-items:center; gap:6px; font-size:12px;">
                    <span style="color:#646970; font-weight:600; margin-right:6px;">1,420 items</span>
                    <button type="button" class="wp-button" style="height:28px; width:28px; padding:0; display:flex; align-items:center; justify-content:center;" disabled>&laquo;</button>
                    <button type="button" class="wp-button" style="height:28px; width:28px; padding:0; display:flex; align-items:center; justify-content:center;" disabled>&lsaquo;</button>
                    <button type="button" class="wp-button" style="height:28px; width:28px; padding:0; display:flex; align-items:center; justify-content:center; background:#8A681F; color:#fff; border-color:#8A681F; font-weight:700;">1</button>
                    <button type="button" class="wp-button" style="height:28px; width:28px; padding:0; display:flex; align-items:center; justify-content:center;">2</button>
                    <button type="button" class="wp-button" style="height:28px; width:28px; padding:0; display:flex; align-items:center; justify-content:center;">3</button>
                    <span style="color:#8c8f94; padding:0 2px;">…</span>
                    <button type="button" class="wp-button" style="height:28px; width:28px; padding:0; display:flex; align-items:center; justify-content:center;">58</button>
                    <button type="button" class="wp-button" style="height:28px; width:28px; padding:0; display:flex; align-items:center; justify-content:center;">&rsaquo;</button>
                    <button type="button" class="wp-button" style="height:28px; width:28px; padding:0; display:flex; align-items:center; justify-content:center;">&raquo;</button>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: ADD MANUAL REVIEW                                 -->
<!-- ======================================================== -->
<div id="addReviewModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.75); backdrop-filter:blur(5px); z-index:9999999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:95%; max-width:600px; border-radius:10px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4); overflow:hidden; border:2px solid #D4AF37; animation:dtModalFadeIn 0.25s ease-out;">
        <div style="background:linear-gradient(135deg, #181512 0%, #2A241E 50%, #3D342A 100%); padding:14px 18px; color:#FAF5E8; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid #D4AF37;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#D4AF37" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                <h3 style="margin:0; font-size:15px; font-weight:800; color:#FAF5E8;">Add Customer Review</h3>
            </div>
            <button type="button" onclick="closeAddReviewModal()" style="background:none; border:none; color:#FAF5E8; font-size:20px; cursor:pointer;">&times;</button>
        </div>
        <div style="padding:16px 18px;">
            <div class="adm-form-grid">
                <div class="adm-form-group">
                    <label class="adm-form-label">Customer Name <span style="color:#b32d2e;">*</span></label>
                    <input type="text" id="newRevName" class="adm-form-input" placeholder="e.g. Meenakshi Sundaram">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">City / Location</label>
                    <input type="text" id="newRevCity" class="adm-form-input" placeholder="e.g. Chennai, Tamil Nadu">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Product</label>
                    <select class="adm-form-select" id="newRevProduct">
                        <option>Kanjivaram Pure Silk Saree (KLN-SR-111)</option>
                        <option>Banarasi Royal Brocade Saree (BNR-SR-204)</option>
                        <option>Crimson Bridal Lehenga (BRD-LH-902)</option>
                        <option>Chanderi Kurti Set (KRT-CH-401)</option>
                    </select>
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Rating</label>
                    <select class="adm-form-select" id="newRevRating">
                        <option value="5.0">★★★★★ (5 Stars)</option>
                        <option value="4.0">★★★★☆ (4 Stars)</option>
                        <option value="3.0">★★★☆☆ (3 Stars)</option>
                    </select>
                </div>
                <div class="adm-form-group full">
                    <label class="adm-form-label">Review Headline</label>
                    <input type="text" id="newRevHeadline" class="adm-form-input" placeholder="e.g. Pure authentic silk weave!">
                </div>
                <div class="adm-form-group full">
                    <label class="adm-form-label">Review Text</label>
                    <textarea id="newRevText" class="adm-form-textarea" rows="3" placeholder="Write the customer's detailed feedback..."></textarea>
                </div>
            </div>
        </div>
        <div style="background:#f6f7f7; padding:12px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
            <button type="button" class="wp-button" onclick="closeAddReviewModal()">Cancel</button>
            <button type="button" class="wp-button primary" onclick="submitNewReview()" style="background:linear-gradient(135deg, #8A681F 0%, #D4AF37 100%); color:#181512; font-weight:800; border:1px solid #8A681F;">+ Save &amp; Publish Review</button>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: STORE OFFICIAL REPLY                              -->
<!-- ======================================================== -->
<div id="replyReviewModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.75); backdrop-filter:blur(5px); z-index:9999999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:95%; max-width:520px; border-radius:10px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4); overflow:hidden; border:2px solid #D4AF37;">
        <div style="background:linear-gradient(135deg, #181512 0%, #2A241E 50%, #3D342A 100%); padding:14px 18px; color:#FAF5E8; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid #D4AF37;">
            <h3 style="margin:0; font-size:15px; font-weight:800; color:#FAF5E8;">Official Store Reply</h3>
            <button type="button" onclick="closeReplyModal()" style="background:none; border:none; color:#FAF5E8; font-size:20px; cursor:pointer;">&times;</button>
        </div>
        <div style="padding:16px 18px;">
            <div style="font-size:12px; margin-bottom:8px; color:#646970;">Replying to <strong id="replyCustomerName" style="color:#181512;">Sunita Rao</strong> for <strong id="replyProductName" style="color:#8A681F;">Kanjivaram Pure Silk Saree</strong>:</div>
            <textarea id="replyTextarea" class="adm-form-textarea" rows="4" placeholder="Type store reply here..."></textarea>
        </div>
        <div style="background:#f6f7f7; padding:12px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
            <button type="button" class="wp-button" onclick="closeReplyModal()">Cancel</button>
            <button type="button" class="wp-button primary" onclick="submitReply()" style="background:linear-gradient(135deg, #8A681F 0%, #D4AF37 100%); color:#181512; font-weight:800;">Publish Reply</button>
        </div>
    </div>
</div>

<script>
function toggleReviewSearchClearBtn(val) {
    const btn = document.getElementById('reviewSearchClearBtn');
    if (btn) btn.style.display = val.length > 0 ? 'inline' : 'none';
}

function clearReviewSearch() {
    const input = document.getElementById('reviewSearchInput');
    if (input) {
        input.value = '';
        toggleReviewSearchClearBtn('');
        searchReviews('');
        input.focus();
    }
}

function toggleSelectAllReviews(master) {
    const checks = document.querySelectorAll('.review-row-check');
    checks.forEach(c => c.checked = master.checked);
}

function searchReviews(q) {
    const rows = document.querySelectorAll('#reviewsTableBody tr');
    const term = (q || '').toLowerCase().trim();
    rows.forEach(r => {
        const txt = r.textContent.toLowerCase();
        r.style.display = txt.includes(term) ? '' : 'none';
    });
}

function filterReviews(status) {
    const links = document.querySelectorAll('.wp-subsubsub a');
    links.forEach(l => l.classList.remove('current'));
    if (event && event.target) {
        const targetA = event.target.closest('a');
        if (targetA) targetA.classList.add('current');
    }

    const rows = document.querySelectorAll('#reviewsTableBody tr');
    rows.forEach(r => {
        if (!status) {
            r.style.display = '';
        } else {
            const txt = r.textContent.toLowerCase();
            r.style.display = txt.includes(status.toLowerCase()) ? '' : 'none';
        }
    });
}

function filterReviewsByRating(rating) {
    const rows = document.querySelectorAll('#reviewsTableBody tr');
    rows.forEach(r => {
        if (!rating) {
            r.style.display = '';
        } else {
            const txt = r.textContent.toLowerCase();
            r.style.display = txt.includes(rating) ? '' : 'none';
        }
    });
}

function filterReviewsByProduct(prod) {
    const rows = document.querySelectorAll('#reviewsTableBody tr');
    rows.forEach(r => {
        if (!prod) {
            r.style.display = '';
        } else {
            const txt = r.textContent.toLowerCase();
            r.style.display = txt.includes(prod.toLowerCase()) ? '' : 'none';
        }
    });
}

function applyReviewFilters() {
    const rating = document.getElementById('filterRatingSelect')?.value || '';
    const prod = document.getElementById('filterProductSelect')?.value || '';
    const rows = document.querySelectorAll('#reviewsTableBody tr');
    rows.forEach(r => {
        const txt = r.textContent.toLowerCase();
        const matchesRating = !rating || txt.includes(rating);
        const matchesProd = !prod || txt.includes(prod.toLowerCase());
        r.style.display = (matchesRating && matchesProd) ? '' : 'none';
    });
    if (typeof window.showToast === 'function') window.showToast('🔍 Review filters applied');
}

function approveSingleReview(btn) {
    const td = btn.closest('tr').querySelector('td:nth-child(6)');
    if (td) {
        td.innerHTML = `
            <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px; display:inline-flex; align-items:center; gap:4px;">
                <span style="width:6px; height:6px; border-radius:50%; background:#16a34a; display:inline-block;"></span>
                <span>Approved</span>
            </span>
        `;
    }
    btn.remove();
    if (typeof window.showToast === 'function') window.showToast('✨ Review approved & published live!');
}

function handleBulkReviewAction() {
    const action = document.getElementById('bulkReviewActionSelect')?.value;
    if (!action) return;
    const selected = document.querySelectorAll('.review-row-check:checked');
    if (selected.length === 0) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Select at least one review');
        return;
    }
    if (typeof window.showToast === 'function') window.showToast(`Bulk action "${action}" applied to ${selected.length} reviews!`);
}

function handleBulkReviewActionBottom() {
    const action = document.getElementById('bulkReviewActionSelectBottom')?.value;
    if (!action) return;
    const selected = document.querySelectorAll('.review-row-check:checked');
    if (selected.length === 0) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Select at least one review');
        return;
    }
    if (typeof window.showToast === 'function') window.showToast(`Bulk action "${action}" applied to ${selected.length} reviews!`);
}

function openAddReviewModal() {
    const m = document.getElementById('addReviewModal');
    if (m) m.style.display = 'flex';
}

function closeAddReviewModal() {
    const m = document.getElementById('addReviewModal');
    if (m) m.style.display = 'none';
}

function openReplyModal(name, product) {
    document.getElementById('replyCustomerName').textContent = name;
    document.getElementById('replyProductName').textContent = product;
    document.getElementById('replyTextarea').value = `Thank you ${name}! We take pride in delivering pure Surat handcrafted textiles directly to your doorstep.`;
    const m = document.getElementById('replyReviewModal');
    if (m) m.style.display = 'flex';
}

function closeReplyModal() {
    const m = document.getElementById('replyReviewModal');
    if (m) m.style.display = 'none';
}

function submitReply() {
    closeReplyModal();
    if (typeof window.showToast === 'function') window.showToast('✨ Official store reply published!');
}

function submitNewReview() {
    const name = document.getElementById('newRevName')?.value || 'Customer';
    closeAddReviewModal();
    if (typeof window.showToast === 'function') window.showToast(`✨ Review for "${name}" published successfully!`);
}
</script>
</body>
</html>
