<?php
declare(strict_types=1);
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin/components/index.php — Admin UI Component Library & Interactive Showcase
 * DT Brand's & Jai Hanuman Tex — Section 39
 * 
 * Demonstrates all 24 canonical components with zero duplicates,
 * 100% Real Vector SVG icons, Indian Rupee (₹) vector standard,
 * TailAdmin typography, and luxury gold gradient styling.
 */

require_once __DIR__ . '/../../src/UIComponent.php';

use DTBrand\UIComponent;

$active_nav = 'developer';
$active_subnav = 'components';
$page_title = 'UI Component Library — DT Brand\'s';

// Mock sample data for interactive previews
$sampleTableColumns = [
    ['key' => 'id', 'label' => 'Order ID', 'sortable' => true],
    ['key' => 'customer', 'label' => 'Retailer Name', 'sortable' => true],
    ['key' => 'items', 'label' => 'Items & Quantity'],
    ['key' => 'amount', 'label' => 'Total Valuation', 'sortable' => true, 'raw' => true],
    ['key' => 'status', 'label' => 'Status', 'raw' => true],
    ['key' => 'actions', 'label' => 'Action', 'raw' => true]
];

$sampleTableRows = [
    [
        'id' => 'ORD-9021',
        'customer' => 'Shree Balaji Sarees (Surat)',
        'items' => '120 pcs Silk Jacquard Saree',
        'amount' => '<span style="display:inline-flex; align-items:center; gap:2px; font-weight:700;">' . UIComponent::rupeeSvg(14) . ' 1,84,500</span>',
        'status' => UIComponent::statusBadge('completed', 'Paid & Dispatched'),
        'actions' => '<button type="button" class="dt-btn-pale" style="padding:4px 10px; font-size:0.75rem;" onclick="DTComponents.toast(\'Viewing Order ORD-9021\', \'info\')">View</button>'
    ],
    [
        'id' => 'ORD-9022',
        'customer' => 'Kothari Wholesale Hub (Ahmedabad)',
        'items' => '85 pcs Banarasi Zari Sarees',
        'amount' => '<span style="display:inline-flex; align-items:center; gap:2px; font-weight:700;">' . UIComponent::rupeeSvg(14) . ' 1,22,400</span>',
        'status' => UIComponent::statusBadge('pending', 'Pending Verification'),
        'actions' => '<button type="button" class="dt-btn-pale" style="padding:4px 10px; font-size:0.75rem;" onclick="DTComponents.toast(\'Viewing Order ORD-9022\', \'info\')">View</button>'
    ],
    [
        'id' => 'ORD-9023',
        'customer' => 'Gautam Textiles (Varanasi)',
        'items' => '40 pcs Organza Floral Sarees',
        'amount' => '<span style="display:inline-flex; align-items:center; gap:2px; font-weight:700;">' . UIComponent::rupeeSvg(14) . ' 58,000</span>',
        'status' => UIComponent::statusBadge('processing', 'In Production'),
        'actions' => '<button type="button" class="dt-btn-pale" style="padding:4px 10px; font-size:0.75rem;" onclick="DTComponents.toast(\'Viewing Order ORD-9023\', \'info\')">View</button>'
    ],
    [
        'id' => 'ORD-9024',
        'customer' => 'Meenakshi Fashions (Jaipur)',
        'items' => '200 pcs Cotton Blend Daily Wear',
        'amount' => '<span style="display:inline-flex; align-items:center; gap:2px; font-weight:700;">' . UIComponent::rupeeSvg(14) . ' 96,000</span>',
        'status' => UIComponent::statusBadge('cancelled', 'Order Cancelled'),
        'actions' => '<button type="button" class="dt-btn-pale" style="padding:4px 10px; font-size:0.75rem;" onclick="DTComponents.toast(\'Viewing Order ORD-9024\', \'info\')">View</button>'
    ]
];

$sampleBulkActions = [
    ['label' => 'Export Selected CSV', 'callback' => 'demoBulkExport'],
    ['label' => 'Batch Verify Stock', 'callback' => 'demoBulkVerify'],
    ['label' => 'Batch Mark Dispatched', 'callback' => 'demoBulkDispatch']
];

$sampleFilters = [
    ['key' => 'status', 'label' => 'Status', 'options' => ['completed' => 'Paid & Dispatched', 'pending' => 'Pending Verification', 'processing' => 'In Production', 'cancelled' => 'Cancelled']],
    ['key' => 'category', 'label' => 'Category', 'options' => ['silk' => 'Silk Sarees', 'cotton' => 'Cotton Blend', 'banarasi' => 'Banarasi Zari']],
    ['key' => 'tier', 'label' => 'Retailer Tier', 'options' => ['platinum' => 'Platinum Wholesale', 'gold' => 'Gold Partner', 'silver' => 'Silver Reseller']]
];

$samplePriceMatrix = [
    ['tier' => '1 - 10 pcs', 'moq' => 1, 'wholesale_price' => 1450, 'retail_mrp' => 2499, 'margin' => '42%'],
    ['tier' => '11 - 50 pcs', 'moq' => 11, 'wholesale_price' => 1290, 'retail_mrp' => 2499, 'margin' => '48%'],
    ['tier' => '51 - 200 pcs', 'moq' => 51, 'wholesale_price' => 1150, 'retail_mrp' => 2499, 'margin' => '54%'],
    ['tier' => '201+ pcs (Master Lot)', 'moq' => 201, 'wholesale_price' => 999, 'retail_mrp' => 2499, 'margin' => '60%']
];

$sampleVariants = [
    ['sku' => 'JHT-SLK-01-RED', 'color' => 'Royal Crimson Red', 'size' => 'Free Size (6.3m with blouse)', 'stock' => 140, 'price' => 1450],
    ['sku' => 'JHT-SLK-01-GLD', 'color' => 'Heritage Antique Gold', 'size' => 'Free Size (6.3m with blouse)', 'stock' => 85, 'price' => 1450],
    ['sku' => 'JHT-SLK-01-EMR', 'color' => 'Emerald Peacock Green', 'size' => 'Free Size (6.3m with blouse)', 'stock' => 210, 'price' => 1450],
    ['sku' => 'JHT-SLK-01-NVY', 'color' => 'Deep Midnight Navy', 'size' => 'Free Size (6.3m with blouse)', 'stock' => 18, 'price' => 1450]
];

$sampleTimeline = [
    ['title' => 'Wholesale Order Created', 'time' => '10 mins ago', 'desc' => 'Retailer selected 120 pcs Silk Jacquard Saree (ORD-9021)', 'type' => 'success'],
    ['title' => 'Direct UPI Payment Captured', 'time' => '8 mins ago', 'desc' => 'UTR 425983719402 verified via NPCI Gateway. Stock locked.', 'type' => 'success'],
    ['title' => 'Inventory Decrement Executed', 'time' => '7 mins ago', 'desc' => '120 units safely decremented from Surat Master Warehouse.', 'type' => 'info'],
    ['title' => 'WhatsApp B2B Confirmation Sent', 'time' => '6 mins ago', 'desc' => 'Luxury itemized digital receipt dispatched to +91 98251 00000.', 'type' => 'info']
];

$sampleActivity = [
    ['user' => 'Gautam (Admin)', 'action' => 'updated wholesale price tier for Banarasi Collection', 'time' => '14 mins ago'],
    ['user' => 'System Engine', 'action' => 'executed automated hourly route & database latency audit', 'time' => '28 mins ago'],
    ['user' => 'Sunil (Operations)', 'action' => 'dispatched Master Consignment TRK-88910 to Bangalore Hub', 'time' => '1 hour ago']
];

$sampleApiResponse = [
    'status' => 'success',
    'timestamp' => '2026-09-13T00:15:00+05:30',
    'endpoint' => '/api/developer.php?action=health',
    'response_time_ms' => 4.2,
    'data' => [
        'database' => ['status' => 'healthy', 'driver' => 'MySQL PDO', 'ping_ms' => 0.8],
        'cache' => ['status' => 'healthy', 'hits' => 14209, 'misses' => 241],
        'queue' => ['status' => 'idle', 'pending_jobs' => 0, 'completed_today' => 389],
        'currency_standard' => 'INR (₹ Indian Rupee)',
        'security_guards' => ['csrf' => true, 'session_guard' => true, 'strict_types' => true]
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="DT Brand's & Jai Hanuman Tex — Master 24-Component Admin UI Library & Interactive Showcase.">
    
    <!-- Typography: TailAdmin Benchmark (Inter & Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/admin/assets/css/components.css?v=<?= time() ?>">
    
    <style>
        .cmp-showcase-wrap {
            padding: 24px;
            max-width: 1400px;
            margin: 0 auto;
        }
        .cmp-header {
            background: linear-gradient(135deg, #181512 0%, #2A241E 100%);
            border: 1.5px solid #8A681F;
            border-radius: 14px;
            padding: 24px 30px;
            margin-bottom: 24px;
            color: #FAF5E8;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.35);
        }
        .cmp-badge-gold {
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
        .cmp-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }
        .cmp-stat-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 16px 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .cmp-stat-icon {
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
        .cmp-stat-num {
            font-size: 1.4rem;
            font-weight: 800;
            color: #111827;
            line-height: 1.2;
        }
        .cmp-stat-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: #64748B;
        }
        .cmp-section-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 32px 0 16px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #FAF5E8;
        }
        .cmp-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            transition: border-color 0.2s;
        }
        .cmp-card:hover {
            border-color: #D4AF37;
        }
        .cmp-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 18px;
            padding-bottom: 14px;
            border-bottom: 1px solid #F1F5F9;
        }
        .cmp-card-header h3 {
            margin: 0 0 4px 0;
            font-size: 1.05rem;
            font-weight: 800;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .cmp-card-header p {
            margin: 0;
            font-size: 0.8rem;
            color: #64748B;
        }
        .cmp-copy-btn {
            font-size: 0.72rem;
            padding: 4px 10px;
        }
        .cmp-demo-box {
            padding: 18px;
            background: #FAFAFA;
            border: 1px dashed #CBD5E1;
            border-radius: 8px;
            margin-top: 12px;
        }
    </style>
</head>
<body class="sys-root">
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">

            <div class="cmp-showcase-wrap">

                <!-- Header Banner -->
                <div class="cmp-header">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:16px;">
                        <div>
                            <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="2.2">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="3" y1="9" x2="21" y2="9"></line>
                                    <line x1="9" y1="21" x2="9" y2="9"></line>
                                </svg>
                                <h1 style="margin:0; font-size:1.5rem; font-weight:900; letter-spacing:-0.02em; color:#FAF5E8;">
                                    Admin UI Component Library &amp; Design System
                                </h1>
                            </div>
                            <p style="margin:0; font-size:0.86rem; color:#D1D5DB;">
                                Production V2 &bull; Section 39: 24 Canonical UI Components with TailAdmin Typography, 100% Real Vector SVGs, and Indian Rupee Standard.
                            </p>
                        </div>
                        <div>
                            <span class="cmp-badge-gold">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                24 Components &bull; 0 Emojis
                            </span>
                        </div>
                    </div>
                </div>

                <!-- KPI Metric Ribbon -->
                <div class="cmp-stats-grid">
                    <div class="cmp-stat-card">
                        <div class="cmp-stat-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg>
                        </div>
                        <div>
                            <div class="cmp-stat-num">24</div>
                            <div class="cmp-stat-label">Canonical Components</div>
                        </div>
                    </div>

                    <div class="cmp-stat-card">
                        <div class="cmp-stat-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                        <div>
                            <div class="cmp-stat-num">100%</div>
                            <div class="cmp-stat-label">Real Vector SVG Standard</div>
                        </div>
                    </div>

                    <div class="cmp-stat-card">
                        <div class="cmp-stat-icon">
                            <?= UIComponent::rupeeSvg(20) ?>
                        </div>
                        <div>
                            <div class="cmp-stat-num">&#8377; INR</div>
                            <div class="cmp-stat-label">Real Rupee Vector SVG</div>
                        </div>
                    </div>

                    <div class="cmp-stat-card">
                        <div class="cmp-stat-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path></svg>
                        </div>
                        <div>
                            <div class="cmp-stat-num">0 Duplicates</div>
                            <div class="cmp-stat-label">Unified Architecture</div>
                        </div>
                    </div>
                </div>

                <!-- Live Interactive Navigation Tabs -->
                <div class="cmp-card" style="padding:16px 20px;">
                    <div style="margin-bottom:12px; font-weight:700; font-size:0.85rem; color:#475569;">
                        Quick Explorer:
                    </div>
                    <?= UIComponent::tabs([
                        ['id' => 'sec-tables', 'label' => '1. Tables, Search & Filters (1-5, 24)'],
                        ['id' => 'sec-dialogs', 'label' => '2. Modals, Drawers & Dialogs (6-8)'],
                        ['id' => 'sec-pricing', 'label' => '3. Pricing & Variants (11-13)'],
                        ['id' => 'sec-feedback', 'label' => '4. Feedback, Feeds & Status (9-10, 14-20)'],
                        ['id' => 'sec-telemetry', 'label' => '5. JSON, API & Date Pickers (21-23)']
                    ], 'sec-tables') ?>
                </div>

                <!-- ========================================== -->
                <!-- GROUP 1: TABLES, SEARCH, FILTERS & BULK BAR -->
                <!-- ========================================== -->
                <div id="tab-sec-tables" class="dt-tab-pane" data-tab-content="sec-tables">
                    
                    <div class="cmp-section-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M3 3h18v18H3zM3 9h18M9 21V9"></path></svg>
                        <span>Group 1: Data Tables, Search, Filter Bars &amp; Bulk Actions</span>
                    </div>

                    <!-- 1. DataTable + 24. BulkActionBar -->
                    <div class="cmp-card">
                        <div class="cmp-card-header">
                            <div>
                                <h3>#1. DataTable &amp; #24. BulkActionBar</h3>
                                <p>Selectable rows, sortable column headers, TailAdmin responsive styling, and floating multi-action execution bar.</p>
                            </div>
                            <button type="button" class="dt-btn-pale cmp-copy-btn" onclick="DTComponents.copyToClipboard('UIComponent::dataTable($cols, $rows, [\'selectable\' => true, \'id\' => \'orders-table\']);\nUIComponent::bulkActionBar(\'orders-table\', $actions);', 'Copied Table snippet')">Copy PHP Snippet</button>
                        </div>

                        <!-- Live Search & Filter Bar Demonstration -->
                        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:14px;">
                            <div style="flex:1; min-width:280px; max-width:400px;">
                                <?= UIComponent::searchBox('demo-search-input', 'Search records by retailer or order ID...', '') ?>
                            </div>
                            <div>
                                <button type="button" class="dt-btn-pale" onclick="DTComponents.openDrawer('demo-filter-drawer')">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" style="vertical-align:middle; margin-right:4px;"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                                    Advanced Filters
                                </button>
                            </div>
                        </div>

                        <!-- FilterBar Component (#3) -->
                        <div style="margin-bottom:14px;">
                            <?= UIComponent::filterBar($sampleFilters, ['status' => 'all']) ?>
                        </div>

                        <!-- DataTable Component (#1) -->
                        <?= UIComponent::dataTable($sampleTableColumns, $sampleTableRows, ['selectable' => true, 'id' => 'demo-orders-table']) ?>

                        <!-- BulkActionBar Component (#24) -->
                        <?= UIComponent::bulkActionBar('demo-orders-table', $sampleBulkActions) ?>

                        <!-- Pagination Component (#5) -->
                        <?= UIComponent::pagination(1, 8, 192, 25) ?>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- GROUP 2: MODALS, DRAWERS & DIALOGS -->
                <!-- ========================================== -->
                <div id="tab-sec-dialogs" class="dt-tab-pane" data-tab-content="sec-dialogs" style="display:none;">
                    <div class="cmp-section-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="3" x2="9" y2="21"></line></svg>
                        <span>Group 2: Modals, Drawers &amp; Confirmation Dialogs</span>
                    </div>

                    <!-- 6. Modal + 7. ConfirmationDialog + 8. Drawer -->
                    <div class="cmp-card">
                        <div class="cmp-card-header">
                            <div>
                                <h3>#6. Modal, #7. ConfirmationDialog &amp; #8. Drawer</h3>
                                <p>Accessible overlays with ESC key closing, backdrop click dismissal, focus trap, and phrase-typing verification.</p>
                            </div>
                        </div>

                        <div style="display:flex; gap:12px; flex-wrap:wrap;">
                            <button type="button" class="dt-btn-gold" onclick="DTComponents.openModal('demo-standard-modal')">
                                Open Standard Modal
                            </button>

                            <button type="button" class="dt-btn-pale" style="border-color:#DC2626; color:#DC2626;" onclick="DTComponents.openModal('demo-danger-dialog')">
                                Open Destructive Confirmation
                            </button>

                            <button type="button" class="dt-btn-pale" onclick="DTComponents.openDrawer('demo-side-drawer')">
                                Open Side Slide-in Drawer
                            </button>

                            <button type="button" class="dt-btn-pale" onclick="DTComponents.openDrawer('demo-filter-drawer')">
                                Open Filter Drawer
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- GROUP 3: PRICING, VARIANTS & MEDIA UPLOADER -->
                <!-- ========================================== -->
                <div id="tab-sec-pricing" class="dt-tab-pane" data-tab-content="sec-pricing" style="display:none;">
                    <div class="cmp-section-title">
                        <?= UIComponent::rupeeSvg(20) ?>
                        <span style="margin-left:6px;">Group 3: Wholesale Price Matrix, Variant Grid &amp; Media Uploader</span>
                    </div>

                    <!-- 11. PriceMatrix -->
                    <div class="cmp-card">
                        <div class="cmp-card-header">
                            <div>
                                <h3>#11. PriceMatrix Component</h3>
                                <p>Wholesale tiered pricing, Minimum Order Quantities (MOQ), MRP, and profit margins with Indian Rupee (₹) SVG.</p>
                            </div>
                            <button type="button" class="dt-btn-pale cmp-copy-btn" onclick="DTComponents.copyToClipboard('UIComponent::priceMatrix($tiers);', 'Copied PriceMatrix snippet')">Copy PHP Snippet</button>
                        </div>
                        <?= UIComponent::priceMatrix($samplePriceMatrix) ?>
                    </div>

                    <!-- 12. VariantGrid -->
                    <div class="cmp-card">
                        <div class="cmp-card-header">
                            <div>
                                <h3>#12. VariantGrid Component</h3>
                                <p>Multi-SKU inventory matrix displaying colors, sizes, stock levels, and wholesale rate tiers.</p>
                            </div>
                            <button type="button" class="dt-btn-pale cmp-copy-btn" onclick="DTComponents.copyToClipboard('UIComponent::variantGrid($variants);', 'Copied VariantGrid snippet')">Copy PHP Snippet</button>
                        </div>
                        <?= UIComponent::variantGrid($sampleVariants) ?>
                    </div>

                    <!-- 13. MediaUploader -->
                    <div class="cmp-card">
                        <div class="cmp-card-header">
                            <div>
                                <h3>#13. MediaUploader Component</h3>
                                <p>Drag-and-drop file upload with live thumbnail rendering and multi-file selection support.</p>
                            </div>
                            <button type="button" class="dt-btn-pale cmp-copy-btn" onclick="DTComponents.copyToClipboard('UIComponent::mediaUploader(\'product-gallery\', [\'maxFiles\' => 5]);', 'Copied MediaUploader snippet')">Copy PHP Snippet</button>
                        </div>
                        <?= UIComponent::mediaUploader('demo-uploader', ['maxFiles' => 5, 'accept' => 'image/jpeg,image/png,image/webp']) ?>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- GROUP 4: FEEDBACK, FEEDS, STATUS & FORMS -->
                <!-- ========================================== -->
                <div id="tab-sec-feedback" class="dt-tab-pane" data-tab-content="sec-feedback" style="display:none;">
                    <div class="cmp-section-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                        <span>Group 4: Feedback, Activity Feeds, Status Badges &amp; Skeletons</span>
                    </div>

                    <!-- 14. StatusBadge -->
                    <div class="cmp-card">
                        <div class="cmp-card-header">
                            <div>
                                <h3>#14. StatusBadge Component</h3>
                                <p>Standardized state badges for orders, inventory, verification, and payments.</p>
                            </div>
                        </div>
                        <div style="display:flex; gap:12px; flex-wrap:wrap; align-items:center;">
                            <?= UIComponent::statusBadge('completed', 'Completed') ?>
                            <?= UIComponent::statusBadge('pending', 'Pending Review') ?>
                            <?= UIComponent::statusBadge('processing', 'In Production') ?>
                            <?= UIComponent::statusBadge('cancelled', 'Order Cancelled') ?>
                            <?= UIComponent::statusBadge('active', 'Active Retailer') ?>
                            <?= UIComponent::statusBadge('inactive', 'Suspended') ?>
                        </div>
                    </div>

                    <!-- 17. Toast Notifications -->
                    <div class="cmp-card">
                        <div class="cmp-card-header">
                            <div>
                                <h3>#17. Toast Notification Micro-System</h3>
                                <p>Client-side toast triggers with auto-dismissal, SVG status vectors, and luxury gold accents.</p>
                            </div>
                        </div>
                        <div style="display:flex; gap:12px; flex-wrap:wrap;">
                            <button type="button" class="dt-btn-emerald" onclick="DTComponents.toast('Order ORD-9021 confirmed &amp; inventory locked successfully!', 'success')">
                                Trigger Success Toast
                            </button>
                            <button type="button" class="dt-btn-pale" style="border-color:#B45309; color:#B45309;" onclick="DTComponents.toast('Warning: Surat warehouse stock is below safety threshold (12 pcs remaining)', 'warning')">
                                Trigger Warning Toast
                            </button>
                            <button type="button" class="dt-btn-pale" style="border-color:#DC2626; color:#DC2626;" onclick="DTComponents.toast('Payment Gateway Error: Bank UTR signature mismatch.', 'danger')">
                                Trigger Danger Toast
                            </button>
                            <button type="button" class="dt-btn-pale" onclick="DTComponents.toast('Export job started. Your report will be ready in 15 seconds.', 'info')">
                                Trigger Info Toast
                            </button>
                        </div>
                    </div>

                    <!-- 15. AuditTimeline & 16. ActivityFeed -->
                    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap:20px;">
                        <div class="cmp-card">
                            <div class="cmp-card-header">
                                <div>
                                    <h3>#15. AuditTimeline Component</h3>
                                    <p>Chronological transaction trail with SVG status nodes.</p>
                                </div>
                            </div>
                            <?= UIComponent::auditTimeline($sampleTimeline) ?>
                        </div>

                        <div class="cmp-card">
                            <div class="cmp-card-header">
                                <div>
                                    <h3>#16. ActivityFeed Component</h3>
                                    <p>Real-time audit log of team actions and automated jobs.</p>
                                </div>
                            </div>
                            <?= UIComponent::activityFeed($sampleActivity) ?>
                        </div>
                    </div>

                    <!-- 18. ErrorPanel & 19. EmptyState & 20. LoadingSkeleton -->
                    <div class="cmp-card">
                        <div class="cmp-card-header">
                            <div>
                                <h3>#18. ErrorPanel, #19. EmptyState &amp; #20. LoadingSkeleton</h3>
                                <p>High-polish error, empty, and loading states for resilience.</p>
                            </div>
                        </div>

                        <?= UIComponent::errorPanel('Webhook Signature Failed', 'Razorpay HMAC signature verification could not be authenticated. Client IP logged to audit table.', '#') ?>

                        <div style="margin:20px 0;">
                            <?= UIComponent::emptyState('No Wholesale Shipments Found', 'There are no active dispatches matching your current filter criteria.', '+ Create Shipment', '#') ?>
                        </div>

                        <div style="margin-top:20px;">
                            <div style="font-weight:700; font-size:0.85rem; color:#475569; margin-bottom:8px;">Table Loading Skeleton:</div>
                            <?= UIComponent::loadingSkeleton('table', 3) ?>
                        </div>
                    </div>

                    <!-- 10. FormSection Component -->
                    <div class="cmp-card">
                        <div class="cmp-card-header">
                            <div>
                                <h3>#10. FormSection Component</h3>
                                <p>Standardized form layout container with luxury gold focus line and structured headings.</p>
                            </div>
                        </div>
                        <?php
                        $formFields = '
                        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:14px;">
                            <div>
                                <label style="display:block; font-size:0.82rem; font-weight:700; color:#111827; margin-bottom:4px;">Lot Identifier</label>
                                <input type="text" class="co-input" value="LOT-2026-BANARASI-09" readonly>
                            </div>
                            <div>
                                <label style="display:block; font-size:0.82rem; font-weight:700; color:#111827; margin-bottom:4px;">Master Fabric Weave</label>
                                <input type="text" class="co-input" value="Pure Katan Silk Jacquard">
                            </div>
                        </div>';
                        echo UIComponent::formSection('Product Specification Matrix', 'Core fabric identity and wholesale batch classification parameters.', $formFields);
                        ?>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- GROUP 5: TELEMETRY, API & DATE PICKERS -->
                <!-- ========================================== -->
                <div id="tab-sec-telemetry" class="dt-tab-pane" data-tab-content="sec-telemetry" style="display:none;">
                    <div class="cmp-section-title">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
                        <span>Group 5: Telemetry, JSON Response Viewers &amp; Date Range Pickers</span>
                    </div>

                    <!-- 23. DateRangePicker -->
                    <div class="cmp-card">
                        <div class="cmp-card-header">
                            <div>
                                <h3>#23. DateRangePicker Component</h3>
                                <p>Quick preset pills (Today, Yesterday, Last 7 Days, Last 30 Days, This Month) for rapid analytics filtering.</p>
                            </div>
                        </div>
                        <?= UIComponent::dateRangePicker('demo-daterange', '30days') ?>
                    </div>

                    <!-- 21. APIResponseViewer & 22. JSONViewer -->
                    <div class="cmp-card">
                        <div class="cmp-card-header">
                            <div>
                                <h3>#21. APIResponseViewer &amp; #22. JSONViewer</h3>
                                <p>Dark obsidian terminal card with JSON formatting, syntax clarity, and 1-click clipboard copy.</p>
                            </div>
                        </div>
                        <?= UIComponent::apiResponseViewer($sampleApiResponse, 'API Telemetry / Health Payload') ?>
                    </div>
                </div>

            </div>

            <!-- Modals & Drawers Rendered in DOM -->
            <?= UIComponent::modal(
                'demo-standard-modal',
                'Wholesale Lot Allocation Details',
                '<p style="margin:0 0 12px 0; color:#334155; font-size:0.88rem;">This dialog demonstrates the standard modal component with backdrop blur, keyboard ESC dismissal, and luxury gold border accent.</p><div style="background:#FAF5E8; padding:12px; border-radius:8px; border:1px solid #D4AF37; font-size:0.82rem; color:#705114;"><strong>Production Note:</strong> All modals automatically trap focus and release body scrolling upon close.</div>',
                '<button type="button" class="dt-btn-pale" onclick="DTComponents.closeModal(\'demo-standard-modal\')">Close</button><button type="button" class="dt-btn-gold" onclick="DTComponents.toast(\'Changes saved successfully!\', \'success\'); DTComponents.closeModal(\'demo-standard-modal\')">Save Changes</button>'
            ) ?>

            <?= UIComponent::confirmationDialog(
                'demo-danger-dialog',
                'Confirm Permanent Wholesale Lot Deletion',
                'Warning: Deleting this wholesale batch will permanently purge all linked inventory reservations and historical barcodes. This action cannot be undone.',
                'Permanently Delete Lot',
                'DELETE'
            ) ?>

            <?= UIComponent::drawer(
                'demo-side-drawer',
                'Retailer Account Inspector',
                '<p style="color:#334155; font-size:0.88rem;">Detailed profile inspection panel sliding smoothly from the right with zero layout distortion.</p><div style="margin-top:14px;"><label style="font-size:0.8rem; font-weight:700;">Retailer Credit Limit</label><p style="font-size:1.1rem; font-weight:800; color:#15803D; margin:4px 0 0 0; display:flex; align-items:center; gap:2px;">' . UIComponent::rupeeSvg(16) . ' 5,00,000</p></div>'
            ) ?>

            <?= UIComponent::filterDrawer(
                'demo-filter-drawer',
                'Refine Wholesale Orders',
                '<div style="display:flex; flex-direction:column; gap:14px;">
                    <div>
                        <label style="display:block; font-size:0.82rem; font-weight:700; margin-bottom:4px;">Minimum Order Value</label>
                        <input type="number" class="co-input" placeholder="e.g. 50000">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.82rem; font-weight:700; margin-bottom:4px;">Dispatch Zone</label>
                        <select class="dt-filter-select" style="width:100%;">
                            <option value="all">All Zones</option>
                            <option value="surat">Surat Master Hub</option>
                            <option value="mumbai">Mumbai Express</option>
                            <option value="delhi">Delhi NCR</option>
                        </select>
                    </div>
                </div>'
            ) ?>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/assets/js/components.js?v=<?= time() ?>"></script>
<script>
    // Live Search Filter Integration for Demo
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('demo-search-input');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                DTComponents.filterTable('demo-orders-table', this.value);
            });
        }
    });

    // Demo Bulk Action Handlers
    function demoBulkExport(tableId) {
        const count = document.getElementById(tableId + '-selected-count').textContent;
        DTComponents.toast(`Exporting ${count} selected records to CSV...`, 'success');
    }

    function demoBulkVerify(tableId) {
        const count = document.getElementById(tableId + '-selected-count').textContent;
        DTComponents.toast(`Verified warehouse stock for ${count} orders.`, 'info');
    }

    function demoBulkDispatch(tableId) {
        const count = document.getElementById(tableId + '-selected-count').textContent;
        DTComponents.toast(`Marked ${count} orders as dispatched!`, 'success');
        DTComponents.clearSelection(tableId);
    }
</script>
</body>
</html>
