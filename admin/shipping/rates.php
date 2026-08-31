<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * rates.php - DT Brand's Admin Shipping Rates & Pincode Matrix
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Shipping Freight Rates & Pincode Matrix";
$active_nav = "shipping";
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
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
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
                    <a href="/admin/shipping/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">← Shipping Suite</a>
                    <button type="button" class="dt-btn dt-btn-gold" style="height:32px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;" onclick="window.showToast('✨ All shipping zone rate slabs saved to database!')">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Save Rate Matrix</span>
                    </button>
                </div>
            </div>

            <!-- Rate Slabs Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>📦 Regional Shipping Rate Slabs</span></h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;">🟢 Active at Checkout</span>
                </div>
                <div class="adm-table-responsive">
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
                            <tr>
                                <td>
                                    <strong>Zone A — Gujarat &amp; Surat Local</strong>
                                    <div style="font-size:11px; color:#64748B;">Surat, Ahmedabad, Vadodara, Rajkot</div>
                                </td>
                                <td><strong>₹40</strong></td>
                                <td>₹20 / 500g</td>
                                <td><span class="adm-badge success">Orders &gt; ₹999</span></td>
                                <td style="text-align:right; font-weight:600; color:#181512;">24–48 Hours</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Zone B — Tier-1 Metro Cities</strong>
                                    <div style="font-size:11px; color:#64748B;">Mumbai, Delhi NCR, Bengaluru, Hyderabad, Chennai, Kolkata</div>
                                </td>
                                <td><strong>₹60</strong></td>
                                <td>₹30 / 500g</td>
                                <td><span class="adm-badge success">Orders &gt; ₹1,499</span></td>
                                <td style="text-align:right; font-weight:600; color:#181512;">2–3 Days</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Zone C — Rest of India (Air / Surface)</strong>
                                    <div style="font-size:11px; color:#64748B;">All Tier-2 &amp; Tier-3 Cities &amp; Towns</div>
                                </td>
                                <td><strong>₹80</strong></td>
                                <td>₹40 / 500g</td>
                                <td><span class="adm-badge success">Orders &gt; ₹1,999</span></td>
                                <td style="text-align:right; font-weight:600; color:#181512;">3–5 Days</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Zone D — Special Regions (NE &amp; J&amp;K)</strong>
                                    <div style="font-size:11px; color:#64748B;">Assam, Meghalaya, Manipur, Jammu &amp; Kashmir, Ladakh</div>
                                </td>
                                <td><strong>₹120</strong></td>
                                <td>₹60 / 500g</td>
                                <td><span class="adm-badge success">Orders &gt; ₹2,999</span></td>
                                <td style="text-align:right; font-weight:600; color:#181512;">5–7 Days</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Wholesale Master B2B Bales (&gt;20 kg)</strong>
                                    <div style="font-size:11px; color:#64748B;">Heavy surface transport via TCI Freight / V-Trans</div>
                                </td>
                                <td><strong>₹18 / kg</strong></td>
                                <td>Flat per kg weight</td>
                                <td><span class="adm-badge gold" style="font-weight:800;">Free on &gt; ₹25,000</span></td>
                                <td style="text-align:right; font-weight:600; color:#181512;">3–6 Days Regional</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
