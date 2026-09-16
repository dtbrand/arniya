<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * leads.php — DT Brand's & Jai Hanuman Tex WhatsApp CRM Leads & Outreach Pipeline
 * Interactive Trade Verification & 1-Click WhatsApp Outreach Studio
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "WhatsApp Inquiries & CRM Leads";
$active_nav = "whatsapp";
$current_subnav = "leads";

$leads = [];
$pdoLead = Database::getConnection();
if ($pdoLead !== null && !Database::isMockMode()) {
    try {
        $leads = Database::query(
            "SELECT id, name, phone, type, status,
                    COALESCE(credit_limit, 0) AS credit_limit,
                    COALESCE(lifetime_spend, 0) AS lifetime_spend,
                    created_at,
                    CASE WHEN status = 'pending' THEN 0 ELSE 1 END AS prio
             FROM customers
             WHERE phone != ''
             ORDER BY prio ASC, created_at DESC
             LIMIT 100"
        );
    } catch (\Throwable $e) {
        $leads = [];
    }
}

if (empty($leads)) {
    $leads = [
        ['id' => 201, 'name' => 'Surat Weaves Mart (Master Depot)', 'phone' => '919820112345', 'type' => 'wholesale', 'status' => 'pending', 'credit_limit' => 1000000, 'lifetime_spend' => 0, 'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours'))],
        ['id' => 202, 'name' => 'Royal Heritage Silks', 'phone' => '919825123456', 'type' => 'wholesale', 'status' => 'active', 'credit_limit' => 500000, 'lifetime_spend' => 380000, 'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))],
        ['id' => 203, 'name' => 'Ankita Fashion Boutique', 'phone' => '919879198765', 'type' => 'reseller', 'status' => 'pending', 'credit_limit' => 200000, 'lifetime_spend' => 0, 'created_at' => date('Y-m-d H:i:s', strtotime('-5 hours'))],
        ['id' => 204, 'name' => 'Suhani Saree Kendra', 'phone' => '919723498765', 'type' => 'reseller', 'status' => 'active', 'credit_limit' => 150000, 'lifetime_spend' => 95000, 'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))],
        ['id' => 205, 'name' => 'Kavita Gupta', 'phone' => '919811223344', 'type' => 'retail', 'status' => 'active', 'credit_limit' => 0, 'lifetime_spend' => 16500, 'created_at' => date('Y-m-d H:i:s', strtotime('-4 days'))]
    ];
}

$typeLabels = [
    'wholesale' => 'Wholesale VIP Partner',
    'reseller'  => 'Authorized Reseller',
    'retailer'  => 'Retail Boutique Owner',
    'retail'    => 'Retail Direct Shopper',
];

$pendingCount = count(array_filter($leads, fn($l) => ($l['status'] ?? '') === 'pending'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp CRM Leads &amp; Outreach Hub — DT Brand's &amp; Jai Hanuman Tex</title>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#8A681F">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?= @filemtime(__DIR__ . '/../assets/css/admin.css') ?: '3.2.1' ?>">
    <link rel="stylesheet" href="/admin/whatsapp/whatsapp.css?v=<?= @filemtime(__DIR__ . '/whatsapp.css') ?: '3.2.1' ?>">
</head>
<body class="wa-suite">
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">

            <!-- Page Header -->
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:14px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                        <span>WhatsApp CRM Leads &amp; Outreach Pipeline</span>
                        <span class="adm-badge gold" style="font-weight:800;"><?= count($leads) ?> Total Leads</span>
                        <?php if ($pendingCount > 0): ?>
                            <span class="adm-badge" style="background:#FEF3C7; color:#B45309; font-weight:800;"><?= $pendingCount ?> Pending Approval</span>
                        <?php endif; ?>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Real-time trade applications, wholesale buyer verification, and 1-click personalized WhatsApp outreach.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/whatsapp/" class="wa-btn-pale" style="text-decoration:none;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Concierge Hub</span>
                    </a>
                </div>
            </div>

            <!-- Unified WhatsApp Tabs -->
            <div style="display:flex; gap:6px; overflow-x:auto; margin-bottom:16px; padding-bottom:4px; border-bottom:1px solid #E2E8F0;">
                <a href="/admin/whatsapp/" class="wa-btn-pale" style="padding:6px 12px; font-size:12px;">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    <span>Concierge Hub</span>
                </a>
                <a href="/admin/whatsapp/broadcast.php" class="wa-btn-pale" style="padding:6px 12px; font-size:12px;">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                    <span>Broadcast Studio</span>
                </a>
                <a href="/admin/whatsapp/leads.php" class="wa-btn-emerald" style="padding:6px 12px; font-size:12px;">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                    <span>Lead Pipeline</span>
                </a>
                <a href="/admin/whatsapp/templates.php" class="wa-btn-pale" style="padding:6px 12px; font-size:12px;">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                    <span>Message Templates &amp; HSM</span>
                </a>
                <a href="/admin/whatsapp/templates.php?tab=gateway" class="wa-btn-pale" style="padding:6px 12px; font-size:12px;">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    <span>Cloud API Gateway</span>
                </a>
            </div>

            <!-- Leads Table Card -->
            <div class="adm-card" style="background:#fff; border:1px solid #E2E8F0; border-radius:10px; padding:16px;">
                <div class="adm-table-toolbar" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:14px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <input type="text" id="leadSearchInput" placeholder="Search by name or mobile..." class="wa-input" style="height:36px; border:1px solid #CBD5E1; border-radius:6px; padding:0 12px; font-size:12.5px; width:260px;" oninput="filterLeads()">
                        <select id="leadTypeFilter" class="wa-select" style="height:36px; border:1px solid #CBD5E1; border-radius:6px; padding:0 10px; font-size:12.5px;" onchange="filterLeads()">
                            <option value="all">All Trade Tiers</option>
                            <option value="pending">Pending Approval Only</option>
                            <option value="wholesale">Wholesale VIP</option>
                            <option value="reseller">Resellers</option>
                            <option value="retail">Retail Shoppers</option>
                        </select>
                    </div>
                    <span style="font-size:12px; color:#64748B;">Priority order: Pending applications first &bull; Instant WhatsApp connect</span>
                </div>

                <div class="adm-table-responsive">
                    <table class="adm-table" id="leadsTable">
                        <thead>
                            <tr>
                                <th>Contact &amp; Mill Partner</th>
                                <th>Trade Tier</th>
                                <th>Verification Standing</th>
                                <th>Lifetime Value</th>
                                <th>Registered</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leads as $l):
                                $phone = preg_replace('/[^0-9]/', '', (string)$l['phone']);
                                if (strlen($phone) === 10) $phone = '91' . $phone;
                                $isPending = (($l['status'] ?? '') === 'pending');
                                $cType = (string)($l['type'] ?? 'wholesale');
                                $cName = (string)($l['name'] ?? 'Buyer');
                                $leadId = (int)$l['id'];
                                $spend = (float)($l['lifetime_spend'] ?? 0);

                                $waText = rawurlencode("Namaste {$cName} ji! DT Brand's & Jai Hanuman Tex Surat depot is here with our latest wholesale pure silk catalog. How may we assist your bulk purchase today?");
                            ?>
                            <tr class="lead-row" data-name="<?= htmlspecialchars(strtolower($cName)) ?>" data-phone="<?= htmlspecialchars($phone) ?>" data-type="<?= htmlspecialchars($cType) ?>" data-pending="<?= $isPending ? '1' : '0' ?>">
                                <td>
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <div style="width:30px; height:30px; border-radius:50%; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:12px;">
                                            <?= strtoupper(substr($cName, 0, 1)) ?>
                                        </div>
                                        <div>
                                            <strong style="color:#111827; font-size:13px;"><?= htmlspecialchars($cName) ?></strong>
                                            <div style="font-size:11.5px; color:#64748B; font-weight:600;">+<?= htmlspecialchars($phone) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="adm-badge <?= $cType === 'retail' ? 'info' : 'gold' ?>">
                                        <?= htmlspecialchars($typeLabels[$cType] ?? ucfirst($cType)) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($isPending): ?>
                                        <span class="adm-badge" style="background:#FEF3C7; color:#B45309; font-weight:700;">Awaiting Approval</span>
                                    <?php else: ?>
                                        <span class="adm-badge success" style="font-weight:700;">Verified Active</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span style="font-weight:700; color:#111827; display:inline-flex; align-items:center; gap:2px;">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                                        <?= number_format($spend) ?>
                                    </span>
                                </td>
                                <td style="font-size:12px; color:#64748B;">
                                    <?= htmlspecialchars(date('d M Y', strtotime((string)$l['created_at']))) ?>
                                </td>
                                <td style="text-align:right;">
                                    <div style="display:inline-flex; align-items:center; gap:6px;">
                                        <?php if ($isPending): ?>
                                            <button type="button" class="wa-btn-pale" style="padding:4px 8px; font-size:11px;" onclick="DTWhatsApp.updateLeadStatus(<?= $leadId ?>, 'active', this)">Approve</button>
                                        <?php endif; ?>
                                        <a href="https://wa.me/<?= htmlspecialchars($phone) ?>?text=<?= $waText ?>" target="_blank" rel="noopener" class="wa-btn-emerald" style="padding:4px 9px; font-size:11px;" title="1-Click WhatsApp Direct Chat">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                            <span>Chat</span>
                                        </a>
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

<script src="/admin/assets/js/admin.js?v=<?= @filemtime(__DIR__ . '/../assets/js/admin.js') ?: '3.2.1' ?>"></script>
<script src="/admin/whatsapp/whatsapp.js?v=<?= @filemtime(__DIR__ . '/whatsapp.js') ?: '3.2.1' ?>"></script>
<script>
function filterLeads() {
    const q = (document.getElementById('leadSearchInput')?.value || '').toLowerCase().trim();
    const type = document.getElementById('leadTypeFilter')?.value || 'all';
    const rows = document.querySelectorAll('.lead-row');

    rows.forEach(r => {
        const name = r.getAttribute('data-name') || '';
        const phone = r.getAttribute('data-phone') || '';
        const rType = r.getAttribute('data-type') || '';
        const isPending = r.getAttribute('data-pending') === '1';

        let matchText = !q || name.includes(q) || phone.includes(q);
        let matchType = true;
        if (type === 'pending') matchType = isPending;
        else if (type !== 'all') matchType = (rType === type);

        r.style.display = (matchText && matchType) ? '' : 'none';
    });
}
</script>
</body>
</html>