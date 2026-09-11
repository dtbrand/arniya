<?php
/* DT admin access guard (auto-inserted) */
$__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php';
if (is_file($__dtg)) {
    require_once $__dtg;
} else if (is_file(__DIR__ . '/../includes/adminguard.php')) {
    require_once __DIR__ . '/../includes/adminguard.php';
}

/**
 * exceptions.php — Delivery Exceptions & NDR (Non-Delivery Reports) Hub
 * Section 27: Shipping Admin Architecture & Logistics Suite
 * DT Brand's & Jai Hanuman Tex — Surat Logistics Depot
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "Delivery Exceptions & NDR Resolution Hub";
$active_nav = "shipping";
$active_subnav = "exceptions";

$pdo = Database::getConnection();
$exceptions = [];

if ($pdo !== null && !Database::isMockMode()) {
    try {
        $hasTable = (int)$pdo->query("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema=DATABASE() AND table_name='shipping_exceptions'")->fetchColumn();
        if ($hasTable > 0) {
            $exceptions = $pdo->query("SELECT * FROM `shipping_exceptions` ORDER BY id DESC LIMIT 50")->fetchAll(\PDO::FETCH_ASSOC);
        }
    } catch (\Throwable $e) {}
}

if (empty($exceptions)) {
    $exceptions = [
        [
            'id' => 1,
            'order_id' => 101,
            'order_number' => 'DT-2026-9042',
            'awb_number' => 'DELH9824001928',
            'carrier' => 'Delhivery Express',
            'exception_type' => 'CUSTOMER_UNAVAILABLE',
            'exception_reason' => 'Customer phone unanswered during doorstep delivery attempt.',
            'status' => 'PENDING',
            'attempts_count' => 2,
            'customer_name' => 'Meera Ben Patel',
            'customer_phone' => '+91 98251 44321',
            'shipping_city' => 'Ahmedabad, Gujarat',
            'reported_at' => date('Y-m-d H:i:s', strtotime('-4 hours')),
            'resolution_notes' => 'Customer requested handover after 6:00 PM.'
        ],
        [
            'id' => 2,
            'order_id' => 102,
            'order_number' => 'DT-2026-9038',
            'awb_number' => 'BD7728192039',
            'carrier' => 'BlueDart Air Express',
            'exception_type' => 'ADDRESS_INCOMPLETE',
            'exception_reason' => 'Shop premises landmark required in wholesale market street.',
            'status' => 'RE_ATTEMPT_SCHEDULED',
            'attempts_count' => 1,
            'customer_name' => 'Rajesh Textiles',
            'customer_phone' => '+91 98202 11234',
            'shipping_city' => 'Mumbai, Maharashtra',
            'reported_at' => date('Y-m-d H:i:s', strtotime('-18 hours')),
            'resolution_notes' => 'Updated address with Shop #42, Mangaldas Market.'
        ],
        [
            'id' => 3,
            'order_id' => 103,
            'order_number' => 'DT-2026-9015',
            'awb_number' => 'TCI9001928341',
            'carrier' => 'TCI Freight B2B',
            'exception_type' => 'RTO_INITIATED',
            'exception_reason' => 'Consignee godown closed on Sunday. RTO hold active.',
            'status' => 'RTO_IN_TRANSIT',
            'attempts_count' => 3,
            'customer_name' => 'Varanasi Saree Emporium',
            'customer_phone' => '+91 94152 88990',
            'shipping_city' => 'Varanasi, UP',
            'reported_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
            'resolution_notes' => 'Bale held at regional TCI transshipment depot.'
        ]
    ];
}

$pendingCount = 0;
$reattemptCount = 0;
$rtoCount = 0;
$resolvedCount = 0;

foreach ($exceptions as $ex) {
    $st = $ex['status'] ?? 'PENDING';
    if ($st === 'PENDING') $pendingCount++;
    elseif ($st === 'RE_ATTEMPT_SCHEDULED') $reattemptCount++;
    elseif ($st === 'RTO_IN_TRANSIT' || $st === 'RTO_DELIVERED') $rtoCount++;
    elseif ($st === 'RESOLVED') $resolvedCount++;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Exceptions &amp; NDR Hub - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(17,24,39,0.7);
            backdrop-filter: blur(4px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .dt-modal-overlay.active { display: flex; }
        .dt-modal-box {
            background: #FFFFFF;
            border-radius: 12px;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            border: 1.5px solid #E5E7EB;
            overflow: hidden;
            animation: dtModalSlide 0.25s ease-out;
        }
        @keyframes dtModalSlide {
            from { transform: translateY(16px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Delivery Exceptions &amp; NDR Hub</span>
                        <span class="adm-badge" style="background:#FEF2F2; color:#DC2626; border:1px solid #FCA5A5; font-weight:800; font-size:11px;">RTO Reduction Suite</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Manage Non-Delivery Reports (NDR), customer doorstep contact, and re-attempt dispatches.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px; flex-wrap:wrap;">
                    <a href="/admin/shipping/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>All Shipments</span>
                    </a>
                    <a href="/admin/shipping/tracking.php" class="dt-btn dt-btn-gold" style="text-decoration:none; height:32px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon></svg>
                        <span>Live Tracking</span>
                    </a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Active NDR Exceptions</span>
                        <div class="adm-kpi-icon-box" style="border-color:#FCA5A5;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val" style="color:#DC2626;"><?= $pendingCount ?> Pending</div>
                    <div class="adm-kpi-bottom"><span class="adm-kpi-delta down">Immediate Action Required</span></div>
                </div>
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Re-Attempts Scheduled</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= $reattemptCount ?> Consignments</div>
                    <div class="adm-kpi-bottom"><span class="adm-kpi-delta up">Scheduled Handover</span></div>
                </div>
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">RTO In-Transit</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= $rtoCount ?> Parcels</div>
                    <div class="adm-kpi-bottom"><span class="adm-kpi-delta up">Return to Surat Mill</span></div>
                </div>
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Resolved Deliveries</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val" style="color:#15803D;"><?= $resolvedCount ?> Handed Over</div>
                    <div class="adm-kpi-bottom"><span class="adm-kpi-delta up">Verified Customer Received</span></div>
                </div>
            </div>

            <!-- Exceptions Table Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>Non-Delivery Reports &amp; Escalations</span></h3>
                    <span class="adm-badge" style="background:#FEF2F2; color:#DC2626; font-weight:700; font-size:11.5px;"><?= count($exceptions) ?> Active Records</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>AWB &amp; Order Ref</th>
                                <th>Courier</th>
                                <th>Consignee &amp; Destination</th>
                                <th>Exception Reason</th>
                                <th>Attempts</th>
                                <th>Status</th>
                                <th style="text-align:right;">NDR Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($exceptions as $ex): ?>
                                <?php
                                $status = $ex['status'] ?? 'PENDING';
                                $badgeClass = $status === 'PENDING' ? 'danger' : ($status === 'RE_ATTEMPT_SCHEDULED' ? 'warning' : ($status === 'RESOLVED' ? 'success' : 'info'));
                                $phoneClean = preg_replace('/[^0-9]/', '', $ex['customer_phone'] ?? '');
                                $waText = urlencode("Namaste " . ($ex['customer_name'] ?? '') . ", your DT Brand's parcel (" . $ex['order_number'] . ") with courier AWB " . $ex['awb_number'] . " could not be delivered: " . $ex['exception_reason'] . ". Please confirm your preferred delivery time.");
                                $waLink = "https://api.whatsapp.com/send?phone=" . $phoneClean . "&text=" . $waText;
                                ?>
                                <tr>
                                    <td>
                                        <code style="font-size:11px; background:#FAF5E8; color:#8A681F; padding:2px 6px; border-radius:4px; border:1px solid #D4AF37; font-weight:700;"><?= htmlspecialchars($ex['awb_number']) ?></code>
                                        <div style="font-size:11.5px; font-weight:700; color:#111827; margin-top:3px;"><?= htmlspecialchars($ex['order_number']) ?></div>
                                    </td>
                                    <td>
                                        <span style="font-weight:700; color:#181512; font-size:12px;"><?= htmlspecialchars($ex['carrier']) ?></span>
                                    </td>
                                    <td>
                                        <div style="font-weight:700; color:#111827; font-size:12.5px;"><?= htmlspecialchars($ex['customer_name']) ?></div>
                                        <div style="font-size:11px; color:#64748B;"><?= htmlspecialchars($ex['shipping_city']) ?></div>
                                        <div style="font-size:11px; color:#181512; font-weight:600;"><?= htmlspecialchars($ex['customer_phone']) ?></div>
                                    </td>
                                    <td style="max-width:240px;">
                                        <div style="font-size:11.5px; font-weight:700; color:#DC2626;"><?= htmlspecialchars($ex['exception_type']) ?></div>
                                        <div style="font-size:11px; color:#4B5563; margin-top:2px;"><?= htmlspecialchars($ex['exception_reason']) ?></div>
                                        <?php if (!empty($ex['resolution_notes'])): ?>
                                            <div style="font-size:10.5px; color:#8A681F; background:#FAF8F4; padding:3px 6px; border-radius:4px; margin-top:4px; border:1px solid #EAE5D9;">
                                                <strong>Note:</strong> <?= htmlspecialchars($ex['resolution_notes']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="adm-badge gold" style="font-weight:800; font-size:11px;"><?= (int)($ex['attempts_count'] ?? 1) ?> Attempts</span>
                                    </td>
                                    <td>
                                        <span class="adm-badge <?= $badgeClass ?>" style="font-size:11px;"><?= str_replace('_', ' ', $status) ?></span>
                                    </td>
                                    <td style="text-align:right;">
                                        <div style="display:inline-flex; gap:6px;">
                                            <a href="<?= htmlspecialchars($waLink) ?>" target="_blank" rel="noopener" class="dt-btn dt-btn-emerald dt-btn-sm" style="text-decoration:none; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px;" title="Send WhatsApp NDR Message">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                                <span>WhatsApp</span>
                                            </a>
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="font-size:11px; font-weight:700;" onclick='openResolveModal(<?= json_encode($ex) ?>)'>Resolve</button>
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

<!-- NDR Resolution Modal -->
<div id="dtResolveModal" class="dt-modal-overlay" onclick="if(event.target===this) closeResolveModal();">
    <div class="dt-modal-box">
        <div style="padding:16px 20px; border-bottom:1px solid #E5E7EB; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <h3 id="resModalTitle" style="margin:0; font-size:1.05rem; font-weight:800; color:#181512;">Resolve Delivery Exception</h3>
            <button type="button" onclick="closeResolveModal()" style="background:none; border:none; cursor:pointer; color:#64748B; font-size:18px;">&times;</button>
        </div>
        <form id="resolveForm" onsubmit="event.preventDefault(); submitResolution();" style="padding:20px;">
            <input type="hidden" id="resExceptionId" value="">
            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:4px;">Action Decision *</label>
                <select id="resStatus" required style="width:100%; border:1px solid #D1D5DB; border-radius:6px; padding:7px 10px; font-size:12.5px; font-weight:700; color:#111827; background:#FFFFFF;">
                    <option value="RE_ATTEMPT_SCHEDULED">Schedule Courier Re-Attempt</option>
                    <option value="RTO_IN_TRANSIT">Initiate Return to Origin (RTO)</option>
                    <option value="RESOLVED">Mark Resolved (Handed Over / Customer Verified)</option>
                </select>
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:4px;">Resolution Notes &amp; Instructions</label>
                <textarea id="resNotes" rows="3" placeholder="e.g. Spoke to customer; requested delivery between 4-6 PM with landmark next to city temple." style="width:100%; border:1px solid #D1D5DB; border-radius:6px; padding:8px 10px; font-size:12px; font-family:sans-serif;"></textarea>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="closeResolveModal()">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold dt-btn-sm" style="font-weight:800;">Submit Action</button>
            </div>
        </form>
    </div>
</div>

<script>
function openResolveModal(ex) {
    document.getElementById('resExceptionId').value = ex.id;
    document.getElementById('resModalTitle').innerText = 'Resolve NDR: ' + ex.awb_number + ' (' + ex.order_number + ')';
    document.getElementById('resStatus').value = ex.status || 'RE_ATTEMPT_SCHEDULED';
    document.getElementById('resNotes').value = ex.resolution_notes || '';
    document.getElementById('dtResolveModal').classList.add('active');
}

function closeResolveModal() {
    document.getElementById('dtResolveModal').classList.remove('active');
}

function submitResolution() {
    var payload = {
        action: 'resolve_exception',
        exception_id: parseInt(document.getElementById('resExceptionId').value),
        status: document.getElementById('resStatus').value,
        notes: document.getElementById('resNotes').value
    };

    fetch('/api/shipping.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            alert('Exception Updated: ' + data.message);
            window.location.reload();
        } else {
            alert('Error: ' + (data.error || 'Failed to update exception.'));
        }
    })
    .catch(function(err) {
        alert('Request failed: ' + err.message);
    });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
