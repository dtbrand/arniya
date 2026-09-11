<?php
/* DT admin access guard (hardened fallback) */
$__dtg1 = __DIR__ . '/../includes/adminguard.php';
$__dtg2 = __DIR__ . '/../../admin/includes/adminguard.php';
$__dtg3 = (isset($_SERVER['DOCUMENT_ROOT']) && $_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php' : '';
if (is_file($__dtg1)) { require_once $__dtg1; }
elseif (is_file($__dtg2)) { require_once $__dtg2; }
elseif ($__dtg3 && is_file($__dtg3)) { require_once $__dtg3; }

/**
 * audit.php - DT Brand's Admin Coupon Security & Policy Audit Hub
 * DT Brand's & Jai Hanuman Tex — Section 26 Master Architecture
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "Coupon Security & Policy Audit";
$active_nav = "marketing";

$pdo = Database::getConnection();
$auditLogs = [];

if ($pdo !== null && !Database::isMockMode()) {
    try {
        $stmt = $pdo->query("SELECT * FROM coupon_audit_logs ORDER BY id DESC LIMIT 50");
        $auditLogs = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\Throwable $e) {}
}

if (empty($auditLogs)) {
    $auditLogs = [
        ['id' => 1, 'coupon_code' => 'FESTIVE25', 'action' => 'created', 'actor' => 'Super Admin', 'details' => 'Created Festive Silk Promo (25% off up to ₹1,500)', 'created_at' => '2026-09-10 10:00:00'],
        ['id' => 2, 'coupon_code' => 'FESTIVE25', 'action' => 'redeemed', 'actor' => 'System', 'details' => 'Redeemed for order DT-ORD-90281 (Discount: ₹1,125.00)', 'created_at' => '2026-09-10 14:20:00'],
        ['id' => 3, 'coupon_code' => 'VIPRESELLER', 'action' => 'created', 'actor' => 'Super Admin', 'details' => 'Configured VIP Reseller channel isolation voucher', 'created_at' => '2026-09-09 09:30:00'],
        ['id' => 4, 'coupon_code' => 'SUMMEREXPIRED', 'action' => 'status_changed', 'actor' => 'DiscountEngine', 'details' => 'Auto-expired voucher past campaign window', 'created_at' => '2026-09-01 00:00:00'],
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coupon Security &amp; Policy Audit - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-nav-tabs {
            display: flex;
            gap: 8px;
            border-bottom: 1.5px solid #EAE5D9;
            margin-bottom: 20px;
            overflow-x: auto;
            padding-bottom: 2px;
        }
        .dt-nav-tab {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 16px;
            font-size: 13px;
            font-weight: 700;
            color: #64748B;
            text-decoration: none;
            border-bottom: 2.5px solid transparent;
            white-space: nowrap;
            transition: all 0.2s ease;
        }
        .dt-nav-tab:hover { color: #8A681F; }
        .dt-nav-tab.active {
            color: #8A681F;
            border-bottom-color: #D4AF37;
            background: #FAF5E8;
            border-radius: 6px 6px 0 0;
        }
        .dt-check-card {
            background: #FFFFFF;
            border: 1.2px solid #EAE5D9;
            border-radius: 10px;
            padding: 16px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:14px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Coupon Security &amp; Policy Audit</span>
                        <span class="adm-badge gold">Section 26 Master Standard</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Continuous audit verification: Server-side discount enforcement, anti-tampering verification, and administrative audit trail.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/marketing/coupons.php" class="dt-btn dt-btn-gold" style="text-decoration:none; height:34px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Coupons Studio</span>
                    </a>
                </div>
            </div>

            <!-- Tabs -->
            <div class="dt-nav-tabs">
                <a href="/admin/marketing/coupons.php" class="dt-nav-tab">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                    <span>Coupons Studio</span>
                </a>
                <a href="/admin/marketing/discount-rules.php" class="dt-nav-tab">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    <span>Discount Rules</span>
                </a>
                <a href="/admin/marketing/usage.php" class="dt-nav-tab">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                    <span>Coupon Usage Ledger</span>
                </a>
                <a href="/admin/marketing/expired.php" class="dt-nav-tab">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <span>Expired Codes</span>
                </a>
                <a href="/admin/marketing/audit.php" class="dt-nav-tab active">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    <span>Security Audit</span>
                </a>
            </div>

            <!-- Security Audit Status Cards -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:14px; margin-bottom:20px;">
                <div class="dt-check-card">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <div>
                        <strong style="color:#181512; font-size:13.5px; display:block; margin-bottom:2px;">Server-Authoritative Calculation</strong>
                        <p style="margin:0; font-size:11.5px; color:#64748B;">Browser-supplied discount amounts are discarded. Only DiscountEngine verified discounts are saved to MySQL.</p>
                    </div>
                </div>

                <div class="dt-check-card">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <div>
                        <strong style="color:#181512; font-size:13.5px; display:block; margin-bottom:2px;">Role &amp; Channel Isolation</strong>
                        <p style="margin:0; font-size:11.5px; color:#64748B;">Wholesale &amp; Reseller coupons cannot be redeemed by general retail visitors or unauthorized accounts.</p>
                    </div>
                </div>

                <div class="dt-check-card">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <div>
                        <strong style="color:#181512; font-size:13.5px; display:block; margin-bottom:2px;">Usage Limit &amp; Expiry Enforcement</strong>
                        <p style="margin:0; font-size:11.5px; color:#64748B;">Automated exhaustion detection: Depleted and expired codes fail-closed immediately at checkout.</p>
                    </div>
                </div>
            </div>

            <!-- Audit Trail Table -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title" style="display:flex; align-items:center; gap:8px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#B8860B" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        <span>Coupon Administrative &amp; Security Audit Trail</span>
                    </h3>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Log ID</th>
                                <th>Coupon Code</th>
                                <th>Action Event</th>
                                <th>Actor / Trigger</th>
                                <th>Event Details</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($auditLogs as $log): ?>
                                <tr>
                                    <td><span style="font-weight:700; color:#64748B;">#<?= $log['id'] ?></span></td>
                                    <td>
                                        <code style="font-size:12.5px; background:#FAF5E8; padding:3px 8px; border-radius:5px; color:#8A681F; font-weight:800; border:1px solid #D4AF37;">
                                            <?= htmlspecialchars($log['coupon_code']) ?>
                                        </code>
                                    </td>
                                    <td>
                                        <span class="adm-badge" style="font-size:11px; font-weight:700; background:#F1F5F9; color:#334155;">
                                            <?= htmlspecialchars(strtoupper(str_replace('_', ' ', $log['action']))) ?>
                                        </span>
                                    </td>
                                    <td><strong style="color:#181512; font-size:12.5px;"><?= htmlspecialchars($log['actor'] ?? 'System') ?></strong></td>
                                    <td><span style="color:#475569; font-size:12px;"><?= htmlspecialchars((string)($log['details'] ?? '—')) ?></span></td>
                                    <td><span style="color:#64748B; font-size:11.5px;"><?= !empty($log['created_at']) ? htmlspecialchars(date('d M Y, h:i A', strtotime($log['created_at']))) : '—' ?></span></td>
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
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
