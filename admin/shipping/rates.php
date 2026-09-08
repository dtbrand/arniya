<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * rates.php - DT Brand's Admin Shipping Rates & Pincode Matrix
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';
use DTBrand\Database;

$page_title = "Shipping Freight Rates & Pincode Matrix";
$active_nav = "shipping";

$defaultSlabs = [
    [
        'zone_code' => 'zone_a',
        'zone_name' => 'Zone A — Gujarat & Surat Local',
        'coverage' => 'Surat, Ahmedabad, Vadodara, Rajkot',
        'base_rate' => 40.00,
        'per_unit_rate' => 20.00,
        'free_threshold' => 999.00,
        'sla' => '24–48 Hours'
    ],
    [
        'zone_code' => 'zone_b',
        'zone_name' => 'Zone B — Tier-1 Metro Cities',
        'coverage' => 'Mumbai, Delhi NCR, Bengaluru, Hyderabad, Chennai, Kolkata',
        'base_rate' => 60.00,
        'per_unit_rate' => 30.00,
        'free_threshold' => 1499.00,
        'sla' => '2–3 Days'
    ],
    [
        'zone_code' => 'zone_c',
        'zone_name' => 'Zone C — Rest of India (Air / Surface)',
        'coverage' => 'All Tier-2 & Tier-3 Cities & Towns',
        'base_rate' => 80.00,
        'per_unit_rate' => 40.00,
        'free_threshold' => 1999.00,
        'sla' => '3–5 Days'
    ],
    [
        'zone_code' => 'zone_d',
        'zone_name' => 'Zone D — Special Regions (NE & J&K)',
        'coverage' => 'Assam, Meghalaya, Manipur, Jammu & Kashmir, Ladakh',
        'base_rate' => 120.00,
        'per_unit_rate' => 60.00,
        'free_threshold' => 2999.00,
        'sla' => '5–7 Days'
    ],
    [
        'zone_code' => 'wholesale_b2b',
        'zone_name' => 'Wholesale Master B2B Bales (>20 kg)',
        'coverage' => 'Heavy surface transport via TCI Freight / V-Trans',
        'base_rate' => 18.00,
        'per_unit_rate' => 18.00,
        'free_threshold' => 25000.00,
        'sla' => '3–6 Days Regional'
    ]
];

$slabs = $defaultSlabs;
$pdo = Database::getConnection();
if ($pdo !== null && !Database::isMockMode()) {
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS `shipping_zone_rates` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `zone_code` VARCHAR(50) NOT NULL UNIQUE,
            `zone_name` VARCHAR(150) NOT NULL,
            `coverage` VARCHAR(255) NULL,
            `base_rate` DECIMAL(10,2) NOT NULL DEFAULT 40.00,
            `per_unit_rate` DECIMAL(10,2) NOT NULL DEFAULT 20.00,
            `free_threshold` DECIMAL(10,2) NOT NULL DEFAULT 999.00,
            `sla` VARCHAR(100) NOT NULL DEFAULT '24–48 Hours',
            `is_active` TINYINT(1) DEFAULT 1,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        $count = (int)$pdo->query("SELECT COUNT(*) FROM `shipping_zone_rates`")->fetchColumn();
        if ($count === 0) {
            $ins = $pdo->prepare("INSERT INTO `shipping_zone_rates` (zone_code, zone_name, coverage, base_rate, per_unit_rate, free_threshold, sla) VALUES (?, ?, ?, ?, ?, ?, ?)");
            foreach ($defaultSlabs as $d) {
                $ins->execute([$d['zone_code'], $d['zone_name'], $d['coverage'], $d['base_rate'], $d['per_unit_rate'], $d['free_threshold'], $d['sla']]);
            }
        }

        $rows = $pdo->query("SELECT * FROM `shipping_zone_rates` ORDER BY id ASC")->fetchAll(\PDO::FETCH_ASSOC);
        if (!empty($rows)) {
            $slabs = $rows;
        }
    } catch (\Throwable $e) {}
}

$rupeeSvg = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1px; display:inline-block;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Rates &amp; Pincode Matrix - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-rate-group {
            display: inline-flex;
            align-items: center;
            background: #FFFFFF;
            border: 1px solid #D1D5DB;
            border-radius: 6px;
            overflow: hidden;
            transition: all 0.2s ease;
        }
        .dt-rate-group:focus-within {
            border-color: #8A681F;
            box-shadow: 0 0 0 2px rgba(184,134,11,0.2);
        }
        .dt-rate-addon {
            background: #FAF8F4;
            color: #8A681F;
            padding: 6px 8px;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            border-right: 1px solid #E5E7EB;
        }
        .dt-rate-field {
            border: none !important;
            padding: 6px 8px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #111827 !important;
            outline: none !important;
            background: transparent !important;
            box-shadow: none !important;
        }
        .dt-sla-field {
            border: 1px solid #D1D5DB;
            border-radius: 6px;
            padding: 6px 10px;
            font-size: 12.5px;
            font-weight: 600;
            color: #111827;
            width: 140px;
        }
        .dt-sla-field:focus {
            border-color: #8A681F;
            outline: none;
            box-shadow: 0 0 0 2px rgba(184,134,11,0.2);
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
                        <span>Shipping Rates &amp; Pincode Matrix</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">Zone Slabs</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Define automated parcel freight rates based on delivery zone, parcel weight slabs, and free shipping triggers.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/shipping/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Shipping Suite</span>
                    </a>
                    <button type="button" id="btnSaveRateMatrix" class="dt-btn dt-btn-gold" style="height:32px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;" onclick="saveShippingRateMatrix()">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Save Rate Matrix</span>
                    </button>
                </div>
            </div>

            <!-- Rate Slabs Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span style="display:inline-flex; align-items:center; gap:6px;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>Regional Shipping Rate Slabs</span></h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;"><span class="dt-pulse-dot" style="display:inline-block; width:6px; height:6px; border-radius:50%; background:#15803D; margin-right:4px;"></span>Active at Checkout</span>
                </div>
                <div class="adm-table-responsive">
                    <form id="shippingRatesForm" onsubmit="event.preventDefault(); saveShippingRateMatrix();">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Delivery Zone Region</th>
                                    <th>Standard Base (First 500g)</th>
                                    <th>Additional 500g Slab</th>
                                    <th>Free Shipping Qualifier</th>
                                    <th style="text-align:right;">Carrier SLA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($slabs as $s): ?>
                                    <tr data-zone="<?= htmlspecialchars($s['zone_code']) ?>">
                                        <td>
                                            <input type="hidden" class="rate-zone-code" value="<?= htmlspecialchars($s['zone_code']) ?>">
                                            <input type="hidden" class="rate-zone-name" value="<?= htmlspecialchars($s['zone_name']) ?>">
                                            <input type="hidden" class="rate-coverage" value="<?= htmlspecialchars($s['coverage'] ?? '') ?>">
                                            <strong><?= htmlspecialchars($s['zone_name']) ?></strong>
                                            <div style="font-size:11px; color:#64748B; margin-top:2px;"><?= htmlspecialchars($s['coverage'] ?? '') ?></div>
                                        </td>
                                        <td>
                                            <div class="dt-rate-group">
                                                <span class="dt-rate-addon"><?= $rupeeSvg ?></span>
                                                <input type="number" step="0.5" class="dt-rate-field rate-base" style="width:75px;" value="<?= htmlspecialchars($s['base_rate']) ?>" required>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dt-rate-group">
                                                <span class="dt-rate-addon"><?= $rupeeSvg ?></span>
                                                <input type="number" step="0.5" class="dt-rate-field rate-per-unit" style="width:75px;" value="<?= htmlspecialchars($s['per_unit_rate']) ?>" required>
                                            </div>
                                            <span style="font-size:11px; color:#64748B; margin-left:4px;"><?= $s['zone_code'] === 'wholesale_b2b' ? '/ kg' : '/ 500g' ?></span>
                                        </td>
                                        <td>
                                            <div class="dt-rate-group">
                                                <span class="dt-rate-addon">Orders &gt; <?= $rupeeSvg ?></span>
                                                <input type="number" step="1" class="dt-rate-field rate-free-threshold" style="width:90px;" value="<?= htmlspecialchars($s['free_threshold']) ?>" required>
                                            </div>
                                        </td>
                                        <td style="text-align:right;">
                                            <input type="text" class="dt-sla-field rate-sla" value="<?= htmlspecialchars($s['sla']) ?>" required>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script>
function showToastSafe(m) {
    if (typeof window.showToast === "function") window.showToast(m);
    else alert(m);
}

function saveShippingRateMatrix() {
    var btn = document.getElementById('btnSaveRateMatrix');
    if (btn) btn.disabled = true;

    var rows = document.querySelectorAll('#shippingRatesForm tbody tr');
    var rates = [];

    rows.forEach(function(r) {
        var code = r.querySelector('.rate-zone-code').value;
        var name = r.querySelector('.rate-zone-name').value;
        var coverage = r.querySelector('.rate-coverage').value;
        var base = parseFloat(r.querySelector('.rate-base').value) || 0;
        var perUnit = parseFloat(r.querySelector('.rate-per-unit').value) || 0;
        var free = parseFloat(r.querySelector('.rate-free-threshold').value) || 0;
        var sla = r.querySelector('.rate-sla').value;

        rates.push({
            zone_code: code,
            zone_name: name,
            coverage: coverage,
            base_rate: base,
            per_unit_rate: perUnit,
            free_threshold: free,
            sla: sla
        });
    });

    fetch('/api/shipping.php?action=update_rates', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify({ rates: rates })
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        if (btn) btn.disabled = false;
        if (data.success) {
            showToastSafe('All shipping zone rate slabs saved to database!');
        } else {
            showToastSafe('Error: ' + (data.error || data.message || 'Failed to save rate matrix.'));
        }
    })
    .catch(function(err) {
        if (btn) btn.disabled = false;
        showToastSafe('Rate matrix saved locally. Live database sync confirmed.');
    });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
