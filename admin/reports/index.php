<?php
/**
 * index.php — DT Brand's & Jai Hanuman Tex Master Business Intelligence & Analytics Hub
 * Section 33: Reports / Analytics & Export Suite
 */

/* DT admin access guard */
$__dtg = __DIR__ . '/../includes/adminguard.php';
if (!is_file($__dtg)) {
    $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php';
}
if (is_file($__dtg)) {
    require_once $__dtg;
}

require_once __DIR__ . '/../../src/ReportManager.php';
use DTBrand\ReportManager;

$range = isset($_GET['range']) ? trim($_GET['range']) : 'all';
$kpis = ReportManager::getSummaryKpis($range);
$sales = ReportManager::getSalesReport($range);

$page_title = "Business Intelligence & Analytics Hub";
$active_nav = "reports";
$current_subnav = "reports";

// Real Indian Rupee SVG Vector
$rupeeSvg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1.5px; display:inline-block;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> — DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/admin/reports/reports.css?v=<?= time() ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            
            <!-- Page Header -->
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Business Intelligence &amp; Analytics Hub</span>
                        <span class="dt-badge gold">Live Engine</span>
                    </h1>
                    <p class="adm-page-subtitle">Unified reporting suite covering sales, orders, wholesale revenue, inventory valuation, role distribution, payments, carriers, and returns.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px; align-items:center;">
                    <a href="/admin/reports/export.php" class="dt-btn dt-btn-pale">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Export Studio
                    </a>
                    <button type="button" class="dt-btn dt-btn-gold dt-print-trigger">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                        Print Executive Summary
                    </button>
                </div>
            </div>

            <!-- Filter Toolbar -->
            <div class="dt-report-toolbar">
                <div class="dt-report-toolbar-left">
                    <span style="font-size:0.8rem; font-weight:700; color:#64748B;">Time Window:</span>
                    <div class="dt-report-pill-group">
                        <button type="button" class="dt-report-pill <?= $range === 'all' ? 'active' : '' ?>" data-range="all">All Time</button>
                        <button type="button" class="dt-report-pill <?= $range === 'today' ? 'active' : '' ?>" data-range="today">Today</button>
                        <button type="button" class="dt-report-pill <?= $range === '7d' ? 'active' : '' ?>" data-range="7d">Last 7 Days</button>
                        <button type="button" class="dt-report-pill <?= $range === '30d' ? 'active' : '' ?>" data-range="30d">Last 30 Days</button>
                        <button type="button" class="dt-report-pill <?= $range === 'mtd' ? 'active' : '' ?>" data-range="mtd">This Month</button>
                        <button type="button" class="dt-report-pill <?= $range === 'ytd' ? 'active' : '' ?>" data-range="ytd">This Year</button>
                    </div>
                </div>
                <div class="dt-report-toolbar-right">
                    <button type="button" class="dt-btn dt-btn-pale" data-export-type="sales" data-export-format="csv" style="padding:6px 12px; font-size:0.75rem;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        Download CSV
                    </button>
                    <button type="button" class="dt-btn dt-btn-gold" data-export-type="sales" data-export-format="excel" style="padding:6px 12px; font-size:0.75rem;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                        Download Excel
                    </button>
                </div>
            </div>

            <!-- Master KPI Ribbon Grid -->
            <div class="dt-report-kpi-grid">
                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Gross Revenue</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= $rupeeSvg ?> <?= number_format($kpis['gross_revenue']) ?></div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge emerald"><?= $kpis['total_orders'] ?> Orders</span>
                        <span>AOV: <?= $rupeeSvg ?> <?= number_format($kpis['aov']) ?></span>
                    </div>
                </div>

                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Net Retained Profit</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= $rupeeSvg ?> <?= number_format($kpis['net_profit']) ?></div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge gold">27.0% Net Margin</span>
                        <span>Gross: <?= $rupeeSvg ?> <?= number_format($kpis['gross_profit']) ?></span>
                    </div>
                </div>

                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">GST Tax Provision</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= $rupeeSvg ?> <?= number_format($kpis['gst_collected']) ?></div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge blue">5% Textile Rate</span>
                        <span>GSTR-1 Ready</span>
                    </div>
                </div>

                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Returns &amp; Refunds</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= $kpis['return_rate'] ?>%</div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge crimson"><?= $kpis['total_returns'] ?> Returns</span>
                        <span><?= $rupeeSvg ?> <?= number_format($kpis['refund_amount']) ?></span>
                    </div>
                </div>
            </div>

            <!-- Section 33 Comprehensive Reports Grid (12 Reports) -->
            <div class="adm-card" style="margin-bottom:24px;">
                <div class="adm-card-head" style="border-bottom:1px solid #E2E8F0; padding:16px 20px;">
                    <h2 class="adm-card-title" style="font-size:1.1rem; font-weight:800; color:#111827;">
                        <span>All Reports &amp; Intelligence Modules</span>
                    </h2>
                </div>
                <div style="padding:20px;">
                    <div class="dt-report-cards-grid">
                        
                        <!-- 1. Sales & Channel -->
                        <a href="/admin/reports/sales.php" class="dt-report-nav-card">
                            <div class="dt-report-nav-top">
                                <div class="dt-report-nav-icon-wrap">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                                </div>
                                <div>
                                    <div class="dt-report-nav-title">Sales &amp; Channel Analytics</div>
                                    <div class="dt-report-nav-desc">Breakdown of gross sales across D2C, Wholesale, Retailer, and Reseller channels.</div>
                                </div>
                            </div>
                            <div class="dt-report-nav-bottom">
                                <span class="dt-report-nav-badge dt-badge gold">4 Channels</span>
                                <span class="dt-report-nav-arrow">View Report <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></span>
                            </div>
                        </a>

                        <!-- 2. Orders Funnel -->
                        <a href="/admin/reports/orders.php" class="dt-report-nav-card">
                            <div class="dt-report-nav-top">
                                <div class="dt-report-nav-icon-wrap">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                </div>
                                <div>
                                    <div class="dt-report-nav-title">Orders Funnel &amp; Velocity</div>
                                    <div class="dt-report-nav-desc">Fulfillment turnaround, delivery SLAs, processing stages, and cancellation rates.</div>
                                </div>
                            </div>
                            <div class="dt-report-nav-bottom">
                                <span class="dt-report-nav-badge dt-badge blue"><?= $kpis['total_orders'] ?> Orders</span>
                                <span class="dt-report-nav-arrow">View Report <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></span>
                            </div>
                        </a>

                        <!-- 3. Revenue & P&L -->
                        <a href="/admin/reports/revenue.php" class="dt-report-nav-card">
                            <div class="dt-report-nav-top">
                                <div class="dt-report-nav-icon-wrap">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                                </div>
                                <div>
                                    <div class="dt-report-nav-title">Revenue &amp; P&amp;L Statement</div>
                                    <div class="dt-report-nav-desc">Cost of Goods Sold (Raw Silk, Zari, Wages), Gross Profit, and EBITDA Net Retained surplus.</div>
                                </div>
                            </div>
                            <div class="dt-report-nav-bottom">
                                <span class="dt-report-nav-badge dt-badge emerald">P&amp;L Ledger</span>
                                <span class="dt-report-nav-arrow">View Report <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></span>
                            </div>
                        </a>

                        <!-- 4. Products Performance -->
                        <a href="/admin/reports/products.php" class="dt-report-nav-card">
                            <div class="dt-report-nav-top">
                                <div class="dt-report-nav-icon-wrap">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                                </div>
                                <div>
                                    <div class="dt-report-nav-title">Product Sales Performance</div>
                                    <div class="dt-report-nav-desc">Top sellers by units and GMV, velocity ranking (Fast vs Slow), and unit gross margins.</div>
                                </div>
                            </div>
                            <div class="dt-report-nav-bottom">
                                <span class="dt-report-nav-badge dt-badge gold"><?= $kpis['total_products'] ?> Products</span>
                                <span class="dt-report-nav-arrow">View Report <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></span>
                            </div>
                        </a>

                        <!-- 5. Categories & Margins -->
                        <a href="/admin/reports/categories.php" class="dt-report-nav-card">
                            <div class="dt-report-nav-top">
                                <div class="dt-report-nav-icon-wrap">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                                </div>
                                <div>
                                    <div class="dt-report-nav-title">Category Sales &amp; Margins</div>
                                    <div class="dt-report-nav-desc">Silk Sarees, Kurtis, Lehengas, and Festive wear revenue share and volume distribution.</div>
                                </div>
                            </div>
                            <div class="dt-report-nav-bottom">
                                <span class="dt-report-nav-badge dt-badge blue">Category Share</span>
                                <span class="dt-report-nav-arrow">View Report <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></span>
                            </div>
                        </a>

                        <!-- 6. Inventory Valuation -->
                        <a href="/admin/reports/inventory.php" class="dt-report-nav-card">
                            <div class="dt-report-nav-top">
                                <div class="dt-report-nav-icon-wrap">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                </div>
                                <div>
                                    <div class="dt-report-nav-title">Inventory Valuation &amp; Stock</div>
                                    <div class="dt-report-nav-desc">Stock asset valuation at wholesale cost vs retail MRP, reorder alerts, and dead stock risk.</div>
                                </div>
                            </div>
                            <div class="dt-report-nav-bottom">
                                <span class="dt-report-nav-badge dt-badge amber"><?= $kpis['low_stock_count'] ?> Low Stock</span>
                                <span class="dt-report-nav-arrow">View Report <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></span>
                            </div>
                        </a>

                        <!-- 7. Customers & LTV -->
                        <a href="/admin/reports/customers.php" class="dt-report-nav-card">
                            <div class="dt-report-nav-top">
                                <div class="dt-report-nav-icon-wrap">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                </div>
                                <div>
                                    <div class="dt-report-nav-title">Customers &amp; Lifetime Value</div>
                                    <div class="dt-report-nav-desc">Top 50 spenders, customer retention, repeat purchase rates, and geographic spread across India.</div>
                                </div>
                            </div>
                            <div class="dt-report-nav-bottom">
                                <span class="dt-report-nav-badge dt-badge emerald"><?= $kpis['total_customers'] ?> Buyers</span>
                                <span class="dt-report-nav-arrow">View Report <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></span>
                            </div>
                        </a>

                        <!-- 8. Role Distribution -->
                        <a href="/admin/reports/roles.php" class="dt-report-nav-card">
                            <div class="dt-report-nav-top">
                                <div class="dt-report-nav-icon-wrap">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
                                </div>
                                <div>
                                    <div class="dt-report-nav-title">Role Distribution Analytics</div>
                                    <div class="dt-report-nav-desc">Guest vs Customer vs Retailer vs Reseller vs Wholesaler revenue and order contribution.</div>
                                </div>
                            </div>
                            <div class="dt-report-nav-bottom">
                                <span class="dt-report-nav-badge dt-badge gold">5 Official Roles</span>
                                <span class="dt-report-nav-arrow">View Report <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></span>
                            </div>
                        </a>

                        <!-- 9. Payment Gateways -->
                        <a href="/admin/reports/payments.php" class="dt-report-nav-card">
                            <div class="dt-report-nav-top">
                                <div class="dt-report-nav-icon-wrap">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                </div>
                                <div>
                                    <div class="dt-report-nav-title">Payment Gateways &amp; Settlement</div>
                                    <div class="dt-report-nav-desc">Instant UPI, Razorpay, Cashfree, COD, and wire transfer volumes, fees, and settlements.</div>
                                </div>
                            </div>
                            <div class="dt-report-nav-bottom">
                                <span class="dt-report-nav-badge dt-badge emerald">Multi-Gateway</span>
                                <span class="dt-report-nav-arrow">View Report <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></span>
                            </div>
                        </a>

                        <!-- 10. Shipping Logistics -->
                        <a href="/admin/reports/shipping.php" class="dt-report-nav-card">
                            <div class="dt-report-nav-top">
                                <div class="dt-report-nav-icon-wrap">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                </div>
                                <div>
                                    <div class="dt-report-nav-title">Shipping &amp; Carrier Logistics</div>
                                    <div class="dt-report-nav-desc">Delhivery Express, BlueDart Air Cargo, and TCI Freight transit times, delivery SLAs, and RTOs.</div>
                                </div>
                            </div>
                            <div class="dt-report-nav-bottom">
                                <span class="dt-report-nav-badge dt-badge blue">3 Carriers</span>
                                <span class="dt-report-nav-arrow">View Report <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></span>
                            </div>
                        </a>

                        <!-- 11. Coupons & Discounts -->
                        <a href="/admin/reports/coupons.php" class="dt-report-nav-card">
                            <div class="dt-report-nav-top">
                                <div class="dt-report-nav-icon-wrap">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                                </div>
                                <div>
                                    <div class="dt-report-nav-title">Coupons &amp; Discount Efficiency</div>
                                    <div class="dt-report-nav-desc">Coupon redemption frequency, total discount disbursed, GMV generated, and campaign ROI.</div>
                                </div>
                            </div>
                            <div class="dt-report-nav-bottom">
                                <span class="dt-report-nav-badge dt-badge gold">Campaign ROI</span>
                                <span class="dt-report-nav-arrow">View Report <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></span>
                            </div>
                        </a>

                        <!-- 12. Returns & Refunds -->
                        <a href="/admin/reports/returns.php" class="dt-report-nav-card">
                            <div class="dt-report-nav-top">
                                <div class="dt-report-nav-icon-wrap">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                                </div>
                                <div>
                                    <div class="dt-report-nav-title">Returns, Exchanges &amp; Refunds</div>
                                    <div class="dt-report-nav-desc">Return rate %, refund volume, defect vs size misfit analysis, and replacement turnaround.</div>
                                </div>
                            </div>
                            <div class="dt-report-nav-bottom">
                                <span class="dt-report-nav-badge dt-badge crimson"><?= $kpis['total_returns'] ?> Cases</span>
                                <span class="dt-report-nav-arrow">View Report <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg></span>
                            </div>
                        </a>

                    </div>
                </div>
            </div>

            <!-- Quick Channel Comparison Table -->
            <div class="dt-report-table-card">
                <div class="dt-report-table-header">
                    <div class="dt-report-table-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        <span>Channel Sales Performance Breakdown</span>
                    </div>
                    <a href="/admin/reports/sales.php" class="dt-btn dt-btn-pale" style="padding:4px 10px; font-size:0.75rem;">Full Channel Analytics</a>
                </div>
                <div class="adm-table-responsive" style="overflow-x:auto;">
                    <table class="dt-report-table">
                        <thead>
                            <tr>
                                <th>Sales Channel</th>
                                <th style="text-align:center;">Orders</th>
                                <th style="text-align:right;">Gross Revenue</th>
                                <th style="text-align:right;">Average Order Value</th>
                                <th style="text-align:center;">Revenue Share</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sales['channels'] as $code => $ch): ?>
                            <tr>
                                <td>
                                    <div style="font-weight:700; color:#111827;"><?= htmlspecialchars($ch['name']) ?></div>
                                    <div style="font-size:0.75rem; color:#64748B;">Channel Key: <?= htmlspecialchars($code) ?></div>
                                </td>
                                <td style="text-align:center; font-weight:700;"><?= number_format($ch['count']) ?></td>
                                <td style="text-align:right; font-weight:800; color:#111827;"><?= $rupeeSvg ?> <?= number_format($ch['revenue']) ?></td>
                                <td style="text-align:right; color:#475569;"><?= $rupeeSvg ?> <?= number_format($ch['aov']) ?></td>
                                <td style="text-align:center;">
                                    <div style="display:flex; align-items:center; gap:8px; justify-content:center;">
                                        <div class="dt-progress-bar-wrap" style="width:70px;">
                                            <div class="dt-progress-bar-fill" style="width:<?= $ch['share'] ?>%; background:<?= $ch['color'] ?>;"></div>
                                        </div>
                                        <span style="font-size:0.78rem; font-weight:800;"><?= $ch['share'] ?>%</span>
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
<script src="/admin/assets/js/admin.js?v=<?= time() ?>"></script>
<script src="/admin/reports/reports.js?v=<?= time() ?>"></script>
</body>
</html>
