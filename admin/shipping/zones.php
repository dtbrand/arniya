<?php
/* DT admin access guard (auto-inserted) */
$__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php';
if (is_file($__dtg)) {
    require_once $__dtg;
} else if (is_file(__DIR__ . '/../includes/adminguard.php')) {
    require_once __DIR__ . '/../includes/adminguard.php';
}

/**
 * zones.php — Geographic Shipping Zones, States, Cities & Pincodes
 * Section 27: Shipping Admin Architecture & Logistics Suite
 * DT Brand's & Jai Hanuman Tex — Surat Logistics Depot
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "Geographic Shipping Zones & Pincodes";
$active_nav = "shipping";
$active_subnav = "zones";

$pdo = Database::getConnection();
$zones = [];

$defaultZones = [
    [
        'id' => 1,
        'zone_code' => 'zone_a',
        'zone_name' => 'Zone A — Gujarat Intra-State & Surat Depot',
        'state_names' => 'Gujarat, Daman & Diu, Dadra & Nagar Haveli',
        'city_names' => 'Surat, Ahmedabad, Vadodara, Rajkot, Bhavnagar',
        'pincode_prefixes' => '36, 37, 38, 39',
        'base_rate' => 40.00,
        'per_unit_rate' => 20.00,
        'free_threshold' => 999.00,
        'sla' => '24–48 Hours',
        'is_active' => 1
    ],
    [
        'id' => 2,
        'zone_code' => 'zone_b',
        'zone_name' => 'Zone B — Tier-1 Metro Corridor',
        'state_names' => 'Maharashtra, Delhi, Karnataka, Telangana, Tamil Nadu, West Bengal',
        'city_names' => 'Mumbai, Delhi NCR, Bengaluru, Hyderabad, Chennai, Kolkata',
        'pincode_prefixes' => '11, 12, 13, 40, 41, 42, 43, 44, 50, 56, 60, 70',
        'base_rate' => 60.00,
        'per_unit_rate' => 30.00,
        'free_threshold' => 1499.00,
        'sla' => '2–3 Days',
        'is_active' => 1
    ],
    [
        'id' => 3,
        'zone_code' => 'zone_c',
        'zone_name' => 'Zone C — Rest of India (Air / Express Surface)',
        'state_names' => 'Rajasthan, Madhya Pradesh, Uttar Pradesh, Punjab, Haryana, Kerala, Odisha, Bihar',
        'city_names' => 'Jaipur, Indore, Lucknow, Chandigarh, Kochi, Bhubaneswar, Patna',
        'pincode_prefixes' => '14–17, 20–28, 30–34, 45–49, 67–69, 75–77, 80–85',
        'base_rate' => 80.00,
        'per_unit_rate' => 40.00,
        'free_threshold' => 1999.00,
        'sla' => '3–5 Days',
        'is_active' => 1
    ],
    [
        'id' => 4,
        'zone_code' => 'zone_d',
        'zone_name' => 'Zone D — Special Regions & Hill Tracts',
        'state_names' => 'Assam, Meghalaya, Manipur, Mizoram, Nagaland, Tripura, Arunachal Pradesh, Jammu & Kashmir, Ladakh',
        'city_names' => 'Guwahati, Shillong, Imphal, Srinagar, Jammu, Leh',
        'pincode_prefixes' => '18, 19, 78, 79',
        'base_rate' => 120.00,
        'per_unit_rate' => 60.00,
        'free_threshold' => 2999.00,
        'sla' => '5–7 Days',
        'is_active' => 1
    ],
    [
        'id' => 5,
        'zone_code' => 'wholesale_b2b',
        'zone_name' => 'Wholesale Master B2B Bales (>20 kg)',
        'state_names' => 'All India Freight Transport Corridors',
        'city_names' => 'All Commercial Mill Hubs via TCI Freight / V-Trans Express',
        'pincode_prefixes' => 'ALL (National B2B Transport)',
        'base_rate' => 18.00,
        'per_unit_rate' => 18.00,
        'free_threshold' => 25000.00,
        'sla' => '3–6 Days Regional',
        'is_active' => 1
    ]
];

$zones = $defaultZones;
if ($pdo !== null && !Database::isMockMode()) {
    try {
        $hasTable = (int)$pdo->query("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema=DATABASE() AND table_name='shipping_zones'")->fetchColumn();
        if ($hasTable > 0) {
            $rows = $pdo->query("SELECT * FROM `shipping_zones` ORDER BY id ASC")->fetchAll(\PDO::FETCH_ASSOC);
            if (!empty($rows)) {
                $zones = $rows;
            }
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
    <title>Geographic Shipping Zones &amp; Pincodes - DT Brand's Admin</title>
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
            max-width: 580px;
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
                        <span>Geographic Shipping Zones &amp; Coverage</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">Pincode Mapping</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Manage delivery zones, mapped states, key commercial city hubs, and 6-digit Indian pincode coverage.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px; flex-wrap:wrap;">
                    <a href="/admin/shipping/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>All Shipments</span>
                    </a>
                    <a href="/admin/shipping/rates.php" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                        <span>Rate Matrix</span>
                    </a>
                    <button type="button" class="dt-btn dt-btn-gold" style="height:32px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;" onclick="openZoneModal()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add New Zone</span>
                    </button>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Configured Zones</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= count($zones) ?> Active Zones</div>
                    <div class="adm-kpi-bottom"><span class="adm-kpi-delta up">All-India Slabs</span></div>
                </div>
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Origin Depot Hub</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">Surat (395002)</div>
                    <div class="adm-kpi-bottom"><span class="adm-kpi-delta up">Mill District Central</span></div>
                </div>
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Pincode Reach</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">19,000+ Codes</div>
                    <div class="adm-kpi-bottom"><span class="adm-kpi-delta up">Delhivery + BlueDart + DTDC</span></div>
                </div>
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">B2B Heavy Cargo</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">TCI Bales (>20kg)</div>
                    <div class="adm-kpi-bottom"><span class="adm-kpi-delta up">Wholesale Transport</span></div>
                </div>
            </div>

            <!-- Instant Pincode Diagnostic Tool -->
            <div class="adm-card" style="margin-bottom:18px;">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span style="display:inline-flex; align-items:center; gap:6px;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>Instant Pincode Zone &amp; Serviceability Tester</span></h3>
                    <span class="adm-badge gold">Live Route Engine</span>
                </div>
                <div style="padding:14px 18px; background:#FAF8F4; display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <div style="position:relative; width:220px;">
                        <input type="text" id="testPincodeInput" maxlength="6" placeholder="Enter 6-digit Pincode (e.g. 395002)" style="width:100%; border:1px solid #D1D5DB; border-radius:6px; padding:7px 10px 7px 30px; font-size:12.5px; font-weight:700;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2.2" style="position:absolute; left:9px; top:9px; pointer-events:none;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    </div>
                    <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="checkPincodeServiceability()" style="font-weight:800;">Check Route</button>
                    <div id="pincodeCheckResult" style="font-size:12px; font-weight:700; color:#181512; margin-left:8px;"></div>
                </div>
            </div>

            <!-- Zones Table Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>Geographic Zone Architecture</span></h3>
                    <span class="adm-badge success"><?= count($zones) ?> Zones Operational</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Zone Code &amp; Title</th>
                                <th>States Mapped</th>
                                <th>Major City Hubs</th>
                                <th>Pincode Prefixes</th>
                                <th>Base Freight</th>
                                <th>Free Threshold</th>
                                <th>Delivery SLA</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($zones as $z): ?>
                                <tr>
                                    <td>
                                        <div style="font-weight:800; color:#181512; font-size:13px;"><?= htmlspecialchars($z['zone_name']) ?></div>
                                        <code style="font-size:11px; background:#FAF5E8; color:#8A681F; padding:2px 5px; border-radius:4px; border:1px solid #D4AF37; font-weight:700;"><?= htmlspecialchars($z['zone_code']) ?></code>
                                    </td>
                                    <td style="max-width:220px; font-size:12px; color:#4B5563;">
                                        <?= htmlspecialchars($z['state_names'] ?? '') ?>
                                    </td>
                                    <td style="max-width:200px; font-size:12px; color:#181512; font-weight:600;">
                                        <?= htmlspecialchars($z['city_names'] ?? '') ?>
                                    </td>
                                    <td>
                                        <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-weight:700; font-size:11px;"><?= htmlspecialchars($z['pincode_prefixes'] ?? 'ALL') ?></span>
                                    </td>
                                    <td>
                                        <div style="font-weight:700; color:#111827; font-size:12.5px; display:inline-flex; align-items:center; gap:2px;">
                                            <?= $rupeeSvg ?> <?= number_format((float)($z['base_rate'] ?? 0), 2) ?>
                                        </div>
                                        <div style="font-size:10.5px; color:#64748B;">+<?= $rupeeSvg ?> <?= number_format((float)($z['per_unit_rate'] ?? 0), 2) ?>/slab</div>
                                    </td>
                                    <td>
                                        <div style="font-weight:700; color:#15803D; font-size:12.5px; display:inline-flex; align-items:center; gap:2px;">
                                            <?= $rupeeSvg ?> <?= number_format((float)($z['free_threshold'] ?? 0), 2) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="adm-badge" style="background:#FAF5E8; color:#8A681F; font-weight:700; font-size:11px;"><?= htmlspecialchars($z['sla'] ?? '2–4 Days') ?></span>
                                    </td>
                                    <td style="text-align:right;">
                                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="font-size:11px; font-weight:700;" onclick='editZoneData(<?= json_encode($z) ?>)'>Edit</button>
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

<!-- Zone Add / Edit Modal -->
<div id="dtZoneModal" class="dt-modal-overlay" onclick="if(event.target===this) closeZoneModal();">
    <div class="dt-modal-box">
        <div style="padding:16px 20px; border-bottom:1px solid #E5E7EB; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <h3 id="zoneModalTitle" style="margin:0; font-size:1.05rem; font-weight:800; color:#181512;">Add Shipping Zone</h3>
            <button type="button" onclick="closeZoneModal()" style="background:none; border:none; cursor:pointer; color:#64748B; font-size:18px;">&times;</button>
        </div>
        <form id="zoneForm" onsubmit="event.preventDefault(); saveZone();" style="padding:20px;">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:4px;">Zone Code *</label>
                    <input type="text" id="zCode" required placeholder="e.g. zone_e" style="width:100%; border:1px solid #D1D5DB; border-radius:6px; padding:7px 10px; font-size:12.5px; font-weight:700;">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:4px;">Zone Name *</label>
                    <input type="text" id="zName" required placeholder="e.g. Zone E — Coastal Hubs" style="width:100%; border:1px solid #D1D5DB; border-radius:6px; padding:7px 10px; font-size:12.5px;">
                </div>
            </div>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:4px;">Mapped States (Comma separated)</label>
                <input type="text" id="zStates" placeholder="e.g. Goa, Pondicherry, Andaman" style="width:100%; border:1px solid #D1D5DB; border-radius:6px; padding:7px 10px; font-size:12.5px;">
            </div>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:4px;">Key City Hubs (Comma separated)</label>
                <input type="text" id="zCities" placeholder="e.g. Panaji, Vasco, Port Blair" style="width:100%; border:1px solid #D1D5DB; border-radius:6px; padding:7px 10px; font-size:12.5px;">
            </div>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:4px;">Pincode Prefix Ranges (e.g. 40, 60, 74)</label>
                <input type="text" id="zPincodes" placeholder="e.g. 40, 60" style="width:100%; border:1px solid #D1D5DB; border-radius:6px; padding:7px 10px; font-size:12.5px;">
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px; margin-bottom:14px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:4px;">Base Rate (₹)</label>
                    <input type="number" step="0.5" id="zBase" required value="50.00" style="width:100%; border:1px solid #D1D5DB; border-radius:6px; padding:7px 10px; font-size:12.5px; font-weight:700;">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:4px;">Per-Slab (₹)</label>
                    <input type="number" step="0.5" id="zPerUnit" required value="25.00" style="width:100%; border:1px solid #D1D5DB; border-radius:6px; padding:7px 10px; font-size:12.5px; font-weight:700;">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:4px;">Free Above (₹)</label>
                    <input type="number" step="1" id="zFree" required value="1499" style="width:100%; border:1px solid #D1D5DB; border-radius:6px; padding:7px 10px; font-size:12.5px; font-weight:700;">
                </div>
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:4px;">Delivery SLA</label>
                <input type="text" id="zSla" required value="2–4 Days" style="width:100%; border:1px solid #D1D5DB; border-radius:6px; padding:7px 10px; font-size:12.5px;">
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="closeZoneModal()">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold dt-btn-sm" style="font-weight:800;">Save Zone</button>
            </div>
        </form>
    </div>
</div>

<script>
function openZoneModal() {
    document.getElementById('zoneModalTitle').innerText = 'Add New Shipping Zone';
    document.getElementById('zCode').value = '';
    document.getElementById('zCode').readOnly = false;
    document.getElementById('zName').value = '';
    document.getElementById('zStates').value = '';
    document.getElementById('zCities').value = '';
    document.getElementById('zPincodes').value = '';
    document.getElementById('zBase').value = '50.00';
    document.getElementById('zPerUnit').value = '25.00';
    document.getElementById('zFree').value = '1499';
    document.getElementById('zSla').value = '2–4 Days';
    document.getElementById('dtZoneModal').classList.add('active');
}

function editZoneData(z) {
    document.getElementById('zoneModalTitle').innerText = 'Edit Shipping Zone: ' + z.zone_code;
    document.getElementById('zCode').value = z.zone_code;
    document.getElementById('zCode').readOnly = true;
    document.getElementById('zName').value = z.zone_name;
    document.getElementById('zStates').value = z.state_names || '';
    document.getElementById('zCities').value = z.city_names || '';
    document.getElementById('zPincodes').value = z.pincode_prefixes || '';
    document.getElementById('zBase').value = z.base_rate;
    document.getElementById('zPerUnit').value = z.per_unit_rate;
    document.getElementById('zFree').value = z.free_threshold;
    document.getElementById('zSla').value = z.sla || '2–4 Days';
    document.getElementById('dtZoneModal').classList.add('active');
}

function closeZoneModal() {
    document.getElementById('dtZoneModal').classList.remove('active');
}

function saveZone() {
    var payload = {
        action: 'save_zone',
        zone_code: document.getElementById('zCode').value,
        zone_name: document.getElementById('zName').value,
        state_names: document.getElementById('zStates').value,
        city_names: document.getElementById('zCities').value,
        pincode_prefixes: document.getElementById('zPincodes').value,
        base_rate: parseFloat(document.getElementById('zBase').value) || 0,
        per_unit_rate: parseFloat(document.getElementById('zPerUnit').value) || 0,
        free_threshold: parseFloat(document.getElementById('zFree').value) || 0,
        sla: document.getElementById('zSla').value,
        is_active: 1
    };

    fetch('/api/shipping.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            alert('Shipping Zone Saved: ' + data.message);
            window.location.reload();
        } else {
            alert('Error: ' + (data.error || 'Failed to save zone.'));
        }
    })
    .catch(function(err) {
        alert('Request failed: ' + err.message);
    });
}

function checkPincodeServiceability() {
    var pin = document.getElementById('testPincodeInput').value.trim();
    var resEl = document.getElementById('pincodeCheckResult');
    if (!/^[1-9][0-9]{5}$/.test(pin)) {
        resEl.style.color = '#DC2626';
        resEl.innerText = 'Please enter a valid 6-digit Indian pincode.';
        return;
    }

    resEl.style.color = '#64748B';
    resEl.innerText = 'Checking routing...';

    fetch('/api/shipping.php?action=check_pincode&pincode=' + encodeURIComponent(pin))
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            resEl.style.color = '#15803D';
            resEl.innerHTML = 'Serviceable: ' + data.state + ' (' + data.region + ') | Est: ' + data.estimated_days + ' Days (' + data.estimated_delivery_date + ') | Couriers: ' + data.supported_couriers.join(', ');
        } else {
            resEl.style.color = '#DC2626';
            resEl.innerText = data.error || 'Pincode check failed.';
        }
    })
    .catch(function(err) {
        resEl.style.color = '#DC2626';
        resEl.innerText = 'Service check error: ' + err.message;
    });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
