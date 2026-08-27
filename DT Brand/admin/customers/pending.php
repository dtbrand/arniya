<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * pending.php — Trade Account Approval Queue
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 *
 * Wholesale and reseller signups are recorded with status='pending' by
 * Auth::register and cannot sign in (Auth::login only accepts status='active')
 * until someone here approves them. Without this screen those applications
 * would sit in the customers table unseen, so a genuine trade buyer would
 * simply never get access.
 *
 * This page is rendered from the live customers table rather than the shared
 * JS-populated customer table, because an approval queue has to show exactly
 * what is really waiting — not a paginated sample.
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "Trade Account Approvals";
$active_nav = "customers";
$active_subnav = "pending";

$pendingRows = [];
$loadError = '';

$pdo = Database::getConnection();
if ($pdo === null || Database::isMockMode()) {
    $loadError = 'The customer database is unavailable, so pending applications cannot be listed right now.';
} else {
    try {
        $stmt = $pdo->query("
            SELECT `id`, `name`, `phone`, `email`, `type`, `city`, `state`,
                   `gstin`, `pan`, `created_at`
            FROM `customers`
            WHERE `status` = 'pending'
            ORDER BY `created_at` DESC
        ");
        $pendingRows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\Exception $e) {
        $loadError = 'Could not read pending applications: ' . $e->getMessage();
    }
}

$pendingCount = count($pendingRows);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> &lsaquo; DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customer-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-customers-container">
                <div class="dt-cust-head">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title">
                            <span>Trade Account Approvals</span>
                            <span class="dt-cust-badge <?php echo $pendingCount > 0 ? 'amber' : 'green'; ?>">
                                <?php echo $pendingCount; ?> Awaiting Review
                            </span>
                        </h1>
                        <p class="dt-cust-subtitle">
                            Wholesale and reseller applications. Approving an account activates it and grants that tier's
                            pricing on every future order, so verify the GSTIN before approving.
                        </p>
                    </div>
                    <div class="dt-cust-actions">
                        <a href="/admin/customers/index.php" class="dt-btn dt-btn-pale">&larr; All Customers</a>
                    </div>
                </div>

                <?php if ($loadError !== ''): ?>
                    <div style="background:#FEF2F2; border:1px solid #FECACA; color:#B91C1C; padding:12px 14px; border-radius:8px; font-size:13px; font-weight:700; margin-bottom:14px;">
                        <?= htmlspecialchars($loadError) ?>
                    </div>
                <?php endif; ?>

                <div class="dt-cust-table-wrap">
                    <table class="dt-cust-table">
                        <thead>
                            <tr>
                                <th>Applicant</th>
                                <th>Contact</th>
                                <th>Requested Tier</th>
                                <th>GSTIN / PAN</th>
                                <th>Location</th>
                                <th>Applied</th>
                                <th style="text-align:right;">Decision</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if ($pendingCount === 0 && $loadError === ''): ?>
                            <tr>
                                <td colspan="7" style="text-align:center; padding:40px; color:#8C8478; font-weight:700;">
                                    No trade applications are waiting for review.
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach ($pendingRows as $row): ?>
                            <?php
                                $rid = (int)$row['id'];
                                $tier = strtolower((string)($row['type'] ?? 'retail'));
                                $tierLabel = $tier === 'wholesale' ? 'Wholesale' : ($tier === 'reseller' ? 'Reseller' : 'Retail');
                                $gstin = trim((string)($row['gstin'] ?? ''));
                                $pan = trim((string)($row['pan'] ?? ''));
                                $place = trim(trim((string)($row['city'] ?? '')) . ', ' . trim((string)($row['state'] ?? '')), ', ');
                                $applied = !empty($row['created_at']) ? date('d M Y, g:i a', strtotime((string)$row['created_at'])) : '—';
                            ?>
                            <tr id="pendingRow_<?= $rid ?>">
                                <td>
                                    <strong style="font-size:13px;"><?= htmlspecialchars((string)$row['name']) ?></strong>
                                    <div style="font-size:11px; color:#8C8478;">Customer #<?= $rid ?></div>
                                </td>
                                <td style="font-size:12px;">
                                    <div><?= htmlspecialchars((string)$row['phone']) ?></div>
                                    <?php if (!empty($row['email'])): ?>
                                        <div style="color:#8C8478;"><?= htmlspecialchars((string)$row['email']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="adm-badge gold" style="font-size:0.68rem;"><?= htmlspecialchars($tierLabel) ?></span>
                                </td>
                                <td style="font-size:12px;">
                                    <?php if ($gstin !== '' || $pan !== ''): ?>
                                        <?php if ($gstin !== ''): ?><div>GSTIN: <?= htmlspecialchars($gstin) ?></div><?php endif; ?>
                                        <?php if ($pan !== ''): ?><div style="color:#8C8478;">PAN: <?= htmlspecialchars($pan) ?></div><?php endif; ?>
                                    <?php else: ?>
                                        <span style="color:#B45309; font-weight:700;">Not supplied &mdash; verify manually</span>
                                    <?php endif; ?>
                                </td>
                                <td style="font-size:12px;"><?= htmlspecialchars($place !== '' ? $place : '—') ?></td>
                                <td style="font-size:12px; color:#8C8478;"><?= htmlspecialchars($applied) ?></td>
                                <td style="text-align:right; white-space:nowrap;">
                                    <button type="button" class="dt-btn dt-btn-gold" style="height:28px; font-size:11.5px; font-weight:800;"
                                            onclick="dtDecideTradeAccount(<?= $rid ?>, 'active', '<?= htmlspecialchars(addslashes((string)$row['name']), ENT_QUOTES) ?>', '<?= htmlspecialchars($tierLabel, ENT_QUOTES) ?>')">
                                        Approve
                                    </button>
                                    <button type="button" class="dt-btn dt-btn-pale" style="height:28px; font-size:11.5px; font-weight:700; color:#b32d2e; border-color:#fca5a5;"
                                            onclick="dtDecideTradeAccount(<?= $rid ?>, 'suspended', '<?= htmlspecialchars(addslashes((string)$row['name']), ENT_QUOTES) ?>', '<?= htmlspecialchars($tierLabel, ENT_QUOTES) ?>')">
                                        Reject
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
<script>
/* Approving flips customers.status to 'active', which is what actually unlocks
   the requested tier: Auth::login accepts only active accounts, and
   OrderManager::resolveChannel grants wholesale/reseller pricing only while the
   row is active. The requested tier already sits in customers.type, so nothing
   else needs changing.

   The row is only removed once the server confirms the change — a rejected or
   failed request must not look like a completed approval. */
function dtDecideTradeAccount(id, newStatus, name, tierLabel) {
    var approving = (newStatus === 'active');
    var question = approving
        ? 'Approve ' + name + ' for ' + tierLabel + ' pricing? They will be able to sign in and buy at ' + tierLabel.toLowerCase() + ' rates.'
        : 'Reject ' + name + '\'s ' + tierLabel + ' application? The account will be suspended and cannot sign in.';
    if (!confirm(question)) return;

    var params = new URLSearchParams();
    params.append('action', 'update_status');
    params.append('id', id);
    params.append('status', newStatus);

    fetch('/api/customers.php', { method: 'POST', body: params })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (data && data.success) {
                var row = document.getElementById('pendingRow_' + id);
                if (row) row.remove();
                dtApprovalToast(approving
                    ? '✓ ' + name + ' approved for ' + tierLabel + ' pricing.'
                    : '✓ ' + name + '\'s application was rejected.');
                dtRefreshPendingCount();
            } else {
                dtApprovalToast('⚠ ' + ((data && data.message) || 'Could not update this application.'));
            }
        })
        .catch(function () {
            dtApprovalToast('⚠ Network error — nothing was changed. Please try again.');
        });
}

function dtApprovalToast(message) {
    if (typeof window.showToast === 'function') {
        window.showToast(message);
    } else {
        alert(message);
    }
}

/* Keep the header badge honest after a decision. */
function dtRefreshPendingCount() {
    var remaining = document.querySelectorAll('tr[id^="pendingRow_"]').length;
    var badge = document.querySelector('.dt-cust-badge');
    if (badge) {
        badge.textContent = remaining + ' Awaiting Review';
        badge.className = 'dt-cust-badge ' + (remaining > 0 ? 'amber' : 'green');
    }
    if (remaining === 0) {
        var tbody = document.querySelector('.dt-cust-table tbody');
        if (tbody && !tbody.querySelector('td[colspan]')) {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:40px; color:#8C8478; font-weight:700;">No trade applications are waiting for review.</td></tr>';
        }
    }
}
</script>
</body>
</html>
