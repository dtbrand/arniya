<?php
declare(strict_types=1);
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/pricing/history.php — B2B Price History & Rate Audit Ledger
 * DT Brand's & Jai Hanuman Tex — Master Specification V2 (Section 43)
 * 
 * Strict Admin-Only Audit Ledger tracking every price variation across Single Piece,
 * Full Set, Reseller, Retailer, and Wholesale tiers.
 */

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/PriceHistoryManager.php';
require_once __DIR__ . '/../../src/Money.php';
require_once __DIR__ . '/../../src/UIComponent.php';

use DTBrand\PriceHistoryManager;
use DTBrand\Money;
use DTBrand\UIComponent;

$active_nav = 'pricing';
$active_subnav = 'history';
$page_title = 'Price History & Audit Ledger — DT Brand\'s';

$manager = PriceHistoryManager::getInstance();

// Parse query filters
$search = trim((string)($_GET['search'] ?? ''));
$roleTier = trim((string)($_GET['role_tier'] ?? 'all'));
$productType = trim((string)($_GET['product_type'] ?? 'all'));
$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 20;

$filters = [
    'search' => $search,
    'role_tier' => $roleTier,
    'product_type' => $productType
];

$historyData = $manager->getAllHistory($filters, $page, $limit);
$stats = $manager->getSummaryStats();

$records = $historyData['items'];
$totalItems = $historyData['total_items'];
$totalPages = $historyData['total_pages'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="DT Brand's B2B Price History & Rate Audit Ledger — track historical price modifications, role margins, and wholesale adjustments.">
    
    <!-- Typography: TailAdmin Benchmark (Inter & Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/admin/assets/css/components.css?v=<?= time() ?>">
    
    <style>
        .ph-container {
            padding: 24px;
            max-width: 1440px;
            margin: 0 auto;
        }
        .ph-header {
            background: linear-gradient(135deg, #181512 0%, #2A241E 100%);
            border: 1.5px solid #8A681F;
            border-radius: 14px;
            padding: 24px 30px;
            margin-bottom: 24px;
            color: #FAF5E8;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.35);
        }
        .ph-badge-gold {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            background: linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%);
            color: #111827;
            font-size: 0.72rem;
            font-weight: 800;
            border-radius: 9999px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        .ph-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .ph-stat-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 16px 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .ph-stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: #FAF5E8;
            border: 1px solid #D4AF37;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .ph-stat-num {
            font-size: 1.4rem;
            font-weight: 800;
            color: #111827;
            line-height: 1.2;
        }
        .ph-stat-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: #64748B;
        }
        .ph-filter-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 20px;
        }
        .ph-delta-pill {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
        }
        .ph-delta-up {
            background: #FEF3C7;
            color: #B45309;
            border: 1px solid #FCD34D;
        }
        .ph-delta-down {
            background: #DCFCE7;
            color: #15803D;
            border: 1px solid #86EFAC;
        }
        .ph-delta-neutral {
            background: #F1F5F9;
            color: #475569;
            border: 1px solid #E2E8F0;
        }
        .ph-reason-cell {
            max-width: 260px;
            white-space: normal;
            word-break: break-word;
            font-size: 0.78rem;
            color: #475569;
        }
    </style>
</head>
<body class="sys-root">
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">

            <div class="ph-container">

                <!-- Header Banner -->
                <div class="ph-header">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:16px;">
                        <div>
                            <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                                <h1 style="margin:0; font-size:1.5rem; font-weight:900; letter-spacing:-0.02em; color:#FAF5E8;">
                                    B2B Price History &amp; Rate Audit Ledger
                                </h1>
                            </div>
                            <p style="margin:0; font-size:0.86rem; color:#D1D5DB;">
                                Production V2 &bull; Section 43: Complete immutable audit log of all pricing modifications across wholesale, reseller, retailer, and customer tiers.
                            </p>
                        </div>
                        <div>
                            <span class="ph-badge-gold">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                Strictly Confidential Audit Data
                            </span>
                        </div>
                    </div>
                </div>

                <!-- KPI Metric Ribbon -->
                <div class="ph-stats-grid">
                    <div class="ph-stat-card">
                        <div class="ph-stat-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        </div>
                        <div>
                            <div class="ph-stat-num"><?= number_format((float)($stats['total_adjustments'] ?? 0)) ?></div>
                            <div class="ph-stat-label">Total Adjustments Logged</div>
                        </div>
                    </div>

                    <div class="ph-stat-card">
                        <div class="ph-stat-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <div>
                            <div class="ph-stat-num"><?= number_format((float)($stats['recent_30d_adjustments'] ?? 0)) ?></div>
                            <div class="ph-stat-label">Last 30 Days Activity</div>
                        </div>
                    </div>

                    <div class="ph-stat-card">
                        <div class="ph-stat-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        </div>
                        <div>
                            <div class="ph-stat-num"><?= number_format((float)($stats['products_impacted'] ?? 0)) ?></div>
                            <div class="ph-stat-label">Products Modified</div>
                        </div>
                    </div>

                    <div class="ph-stat-card">
                        <div class="ph-stat-icon">
                            <?= UIComponent::rupeeSvg(20) ?>
                        </div>
                        <div>
                            <div class="ph-stat-num">5 Tiers</div>
                            <div class="ph-stat-label">Full Set &amp; Single Piece</div>
                        </div>
                    </div>
                </div>

                <!-- Filter & Search Toolbar -->
                <div class="ph-filter-card">
                    <form method="GET" action="" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                        <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; flex:1;">
                            <div style="min-width:280px; max-width:400px; width:100%;">
                                <input type="text" name="search" class="co-input" placeholder="Search by SKU, product name, actor, reason..." value="<?= htmlspecialchars($search) ?>">
                            </div>

                            <div>
                                <select name="role_tier" class="dt-filter-select" onchange="this.form.submit()">
                                    <option value="all" <?= $roleTier === 'all' ? 'selected' : '' ?>>Role Tier: All</option>
                                    <option value="wholesale" <?= $roleTier === 'wholesale' ? 'selected' : '' ?>>Wholesale (B2B)</option>
                                    <option value="reseller" <?= $roleTier === 'reseller' ? 'selected' : '' ?>>Reseller Hub</option>
                                    <option value="retailer" <?= $roleTier === 'retailer' ? 'selected' : '' ?>>Retailer / Store</option>
                                    <option value="customer" <?= $roleTier === 'customer' ? 'selected' : '' ?>>Customer / Guest</option>
                                </select>
                            </div>

                            <div>
                                <select name="product_type" class="dt-filter-select" onchange="this.form.submit()">
                                    <option value="all" <?= $productType === 'all' ? 'selected' : '' ?>>Type: All</option>
                                    <option value="single_piece" <?= $productType === 'single_piece' ? 'selected' : '' ?>>Single Piece</option>
                                    <option value="full_set" <?= $productType === 'full_set' ? 'selected' : '' ?>>Full Set (Master Lot)</option>
                                </select>
                            </div>

                            <button type="submit" class="dt-btn-gold" style="font-size:0.8rem; padding:8px 14px;">
                                Filter Records
                            </button>

                            <?php if ($search !== '' || $roleTier !== 'all' || $productType !== 'all'): ?>
                                <a href="history.php" class="dt-btn-pale" style="text-decoration:none; font-size:0.8rem; padding:8px 14px;">
                                    Reset
                                </a>
                            <?php endif; ?>
                        </div>

                        <div>
                            <button type="button" class="dt-btn-pale" onclick="DTComponents.toast('Exporting price audit trail to CSV...', 'info');" style="font-size:0.8rem;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" style="vertical-align:middle; margin-right:4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                Export CSV
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Price History Audit Table -->
                <div class="dt-table-container">
                    <table class="dt-component-table">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Product / SKU</th>
                                <th>Selling Type</th>
                                <th>Role Tier</th>
                                <th>Rate Field</th>
                                <th>Previous Rate</th>
                                <th>New Rate</th>
                                <th>Variance</th>
                                <th>Admin Actor</th>
                                <th>Change Justification</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($records)): ?>
                                <tr>
                                    <td colspan="10" style="text-align:center; padding:48px 24px; color:#64748B;">
                                        <div style="font-size:1.1rem; font-weight:700; color:#111827; margin-bottom:6px;">No Price Adjustments Found</div>
                                        <div style="font-size:0.84rem;">There are no price history records matching your current filter criteria.</div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($records as $r): ?>
                                    <?php
                                    $old = $r['old_price'] !== null ? (float)$r['old_price'] : null;
                                    $new = (float)$r['new_price'];
                                    
                                    $deltaAmount = $old !== null ? ($new - $old) : 0.0;
                                    $deltaPercent = ($old !== null && $old > 0) ? round((($new - $old) / $old) * 100, 1) : 0.0;

                                    if ($old === null) {
                                        $deltaClass = 'ph-delta-neutral';
                                        $deltaText = 'Initial Rate';
                                    } elseif ($deltaAmount < 0) {
                                        $deltaClass = 'ph-delta-down';
                                        $deltaText = '-' . abs($deltaPercent) . '% (' . UIComponent::rupeeSvg(11) . ' ' . number_format(abs($deltaAmount), 2) . ')';
                                    } elseif ($deltaAmount > 0) {
                                        $deltaClass = 'ph-delta-up';
                                        $deltaText = '+' . $deltaPercent . '% (' . UIComponent::rupeeSvg(11) . ' ' . number_format($deltaAmount, 2) . ')';
                                    } else {
                                        $deltaClass = 'ph-delta-neutral';
                                        $deltaText = '0.0%';
                                    }

                                    $prodName = !empty($r['product_name']) ? (string)$r['product_name'] : 'Wholesale Saree Product #' . $r['product_id'];
                                    $sku = !empty($r['product_sku']) ? (string)$r['product_sku'] : 'SKU-' . str_pad((string)$r['product_id'], 4, '0', STR_PAD_LEFT);
                                    ?>
                                    <tr>
                                        <td style="white-space:nowrap; font-size:0.78rem; color:#475569;">
                                            <strong><?= date('d M Y', strtotime((string)$r['created_at'])) ?></strong><br>
                                            <span style="font-size:0.72rem; color:#94A3B8;"><?= date('h:i A', strtotime((string)$r['created_at'])) ?></span>
                                        </td>
                                        <td>
                                            <div style="font-weight:700; color:#111827; font-size:0.86rem;"><?= htmlspecialchars($prodName) ?></div>
                                            <div style="font-size:0.75rem; color:#8A681F; font-family:monospace;"><?= htmlspecialchars($sku) ?></div>
                                        </td>
                                        <td>
                                            <?php if ($r['product_type'] === 'full_set'): ?>
                                                <span class="dt-badge dt-badge-warning" style="font-size:0.7rem;">Full Set (Master)</span>
                                            <?php else: ?>
                                                <span class="dt-badge dt-badge-pale" style="font-size:0.7rem;">Single Piece</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $rt = strtolower((string)$r['role_tier']);
                                            if ($rt === 'wholesale') {
                                                echo '<span class="dt-badge dt-badge-success" style="font-size:0.7rem;">Wholesale</span>';
                                            } elseif ($rt === 'reseller') {
                                                echo '<span class="dt-badge dt-badge-pale" style="font-size:0.7rem;">Reseller Hub</span>';
                                            } elseif ($rt === 'retailer') {
                                                echo '<span class="dt-badge dt-badge-info" style="font-size:0.7rem;">Retailer</span>';
                                            } else {
                                                echo '<span class="dt-badge dt-badge-pale" style="font-size:0.7rem;">Customer / MRP</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <code style="font-size:0.76rem; background:#F1F5F9; padding:2px 6px; border-radius:4px;"><?= htmlspecialchars((string)$r['field_name']) ?></code>
                                        </td>
                                        <td style="white-space:nowrap;">
                                            <?php if ($old !== null): ?>
                                                <span style="color:#64748B; font-weight:600; display:inline-flex; align-items:center; gap:2px; font-size:0.84rem; text-decoration:line-through;">
                                                    <?= UIComponent::rupeeSvg(12) ?> <?= number_format($old, 2) ?>
                                                </span>
                                            <?php else: ?>
                                                <span style="color:#94A3B8; font-size:0.75rem; font-style:italic;">None</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="white-space:nowrap;">
                                            <span style="color:#111827; font-weight:800; display:inline-flex; align-items:center; gap:2px; font-size:0.9rem;">
                                                <?= UIComponent::rupeeSvg(13) ?> <?= number_format($new, 2) ?>
                                            </span>
                                        </td>
                                        <td style="white-space:nowrap;">
                                            <span class="ph-delta-pill <?= $deltaClass ?>">
                                                <?= $deltaText ?>
                                            </span>
                                        </td>
                                        <td style="white-space:nowrap;">
                                            <div style="font-weight:700; font-size:0.8rem; color:#111827; display:flex; align-items:center; gap:5px;">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                                <?= htmlspecialchars((string)$r['changed_by']) ?>
                                            </div>
                                        </td>
                                        <td class="ph-reason-cell">
                                            <?= !empty($r['change_reason']) ? htmlspecialchars((string)$r['change_reason']) : '<span style="color:#94A3B8; font-style:italic;">Routine Catalog Update</span>' ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Component -->
                <?php if ($totalPages > 1): ?>
                    <div style="margin-top:20px;">
                        <?= UIComponent::pagination($page, $totalPages, $totalItems, $limit) ?>
                    </div>
                <?php endif; ?>

            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/assets/js/components.js?v=<?= time() ?>"></script>
</body>
</html>
