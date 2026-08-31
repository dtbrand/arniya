<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * leads.php — WhatsApp Inquiries & CRM Leads Hub
 * DT Brand's & Jai Hanuman Tex
 *
 * Previously one invented lead row ("Rajesh Kumar — 50 pcs Kanjivaram lot")
 * with a chat button that only toasted. This page now shows real trade
 * sign-ups and customers who have actual orders — people the team genuinely
 * needs to contact — each with a working wa.me deep link.
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "WhatsApp Inquiries & CRM Leads";
$active_nav = "whatsapp";

$leads = [];
$pdoLead = Database::getConnection();
if ($pdoLead !== null && !Database::isMockMode()) {
    try {
        // Real outreach targets: pending trade applications first (they asked
        // to be contacted), then active accounts by lifetime value.
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

$typeLabels = [
    'wholesale' => 'Wholesale B2B',
    'reseller'  => 'Reseller',
    'retailer'  => 'Retailer / Boutique',
    'retail'    => 'Retail Shopper',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Inquiries &amp; CRM Leads - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Incoming Leads &amp; Outreach Hub</span>
                        <span class="adm-badge gold"><?php echo count($leads); ?> Contacts</span>
                    </h1>
                    <p class="adm-page-subtitle">Pending trade applications first, then active accounts by value — every chat button is a live wa.me link.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/whatsapp/" class="adm-btn-secondary">← Back to Whatsapp Suite</a>
                </div>
            </div>

            <div class="adm-table-card">
                <div class="adm-table-toolbar">
                    <div><h3 style="font-size:1.05rem; font-weight:800;">Contacts</h3></div>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Contact</th>
                                <th>Type</th>
                                <th>Standing</th>
                                <th>Registered</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($leads)): ?>
                                <tr><td colspan="5" style="padding:22px; text-align:center; color:#64748B;">No customer contacts yet. Leads appear here as trade applications and customers register.</td></tr>
                            <?php else: ?>
                                <?php foreach ($leads as $l):
                                    $phone = preg_replace('/[^0-9]/', '', (string)$l['phone']);
                                    if (strlen($phone) === 10) $phone = '91' . $phone;
                                    $isPending = (($l['status'] ?? '') === 'pending');
                                    $msg = 'Namaste ' . $l['name'] . ' ji! ' . ($isPending
                                        ? 'Thank you for your ' . $typeLabels[$l['type']] . ' application at DT Brand\'s — our team is verifying your trade details.'
                                        : 'This is DT Brand\'s Surat depot with your account update.');
                                ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars((string)$l['name']) ?></strong><br>
                                        <small style="color:#78716C;"><?= htmlspecialchars((string)$l['phone']) ?></small>
                                    </td>
                                    <td><span class="adm-badge <?= $l['type'] === 'retail' ? 'info' : 'gold' ?>"><?= htmlspecialchars($typeLabels[(string)$l['type']] ?? (string)$l['type']) ?></span></td>
                                    <td>
                                        <?php if ($isPending): ?>
                                            <span class="adm-badge" style="background:#FEF3C7; color:#B45309;">Awaiting approval — contact now</span>
                                        <?php else: ?>
                                            <span class="adm-badge success">Active</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars(date('d M Y', strtotime((string)$l['created_at']))) ?></td>
                                    <td>
                                        <a class="adm-action-btn wa" style="text-decoration:none;" target="_blank" rel="noopener"
                                           href="https://wa.me/<?= htmlspecialchars($phone) ?>?text=<?= rawurlencode($msg) ?>"
                                           title="Open WhatsApp chat">💬</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
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