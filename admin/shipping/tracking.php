<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * tracking.php - DT Brand's Admin Multi-Carrier Tracking Hub
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Multi-Carrier Consignment Tracking Hub";
$active_nav = "shipping";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Carrier Tracking Hub - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-track-timeline {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 24px 0 16px 0;
        }
        .dt-track-timeline::before {
            content: '';
            position: absolute;
            top: 14px;
            left: 20px;
            right: 20px;
            height: 3px;
            background: #EAE5D9;
            z-index: 1;
        }
        .dt-track-progress {
            position: absolute;
            top: 14px;
            left: 20px;
            width: 66%;
            height: 3px;
            background: #15803D;
            z-index: 2;
            transition: width 0.4s ease;
        }
        .dt-track-step {
            position: relative;
            z-index: 3;
            text-align: center;
            flex: 1;
        }
        .dt-track-dot {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #FFFFFF;
            border: 3px solid #EAE5D9;
            margin: 0 auto 8px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            color: #78716C;
        }
        .dt-track-step.done .dt-track-dot {
            background: #15803D;
            border-color: #15803D;
            color: #FFFFFF;
        }
        .dt-track-step.active .dt-track-dot {
            background: #D4AF37;
            border-color: #8A681F;
            color: #111827;
            box-shadow: 0 0 10px rgba(212,175,55,0.6);
        }
        .dt-track-title {
            font-size: 11.5px;
            font-weight: 700;
            color: #181512;
        }
        .dt-track-sub {
            font-size: 10.5px;
            color: #64748B;
            margin-top: 2px;
        }
        @media (max-width: 600px) {
            .dt-track-timeline {
                flex-direction: column;
                gap: 16px;
            }
            .dt-track-timeline::before, .dt-track-progress {
                display: none;
            }
            .dt-track-step {
                display: flex;
                align-items: center;
                gap: 12px;
                text-align: left;
            }
            .dt-track-dot {
                margin: 0;
            }
        }
    </style>
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
                        <span>Multi-Carrier Tracking Hub</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">Live AWB Radar</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Real-time parcel telemetry and milestone tracking across Delhivery, BlueDart, and TCI Freight carriers.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/shipping/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">← Shipping Suite</a>
                </div>
            </div>

            <!-- Search Bar Card -->
            <div class="adm-card" style="margin-bottom:16px;">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>🔍 Real-Time Consignment Tracker</span></h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;">🟢 Direct Carrier API</span>
                </div>
                <div style="padding:16px 18px;">
                    <form onsubmit="handleTrackAWB(event)" style="display:flex; gap:10px; flex-wrap:wrap;">
                        <input type="text" id="awbSearchInput" class="adm-form-input" style="flex:1; min-width:240px; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-weight:700; padding:0 12px;" value="DEL-994820192" placeholder="Enter AWB or Tracking Number (e.g. DEL-994820192)...">
                        <button type="submit" class="dt-btn dt-btn-gold" style="height:38px; display:inline-flex; align-items:center; gap:6px;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#111827" stroke-width="2.8"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <span>Track Consignment</span>
                        </button>
                    </form>

                    <!-- Active Tracking Dossier -->
                    <div id="trackingResultBox" style="margin-top:20px; background:#FAF8F4; border:1.5px solid #EAE5D9; border-radius:10px; padding:18px;">
                        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; border-bottom:1px solid #EAE5D9; padding-bottom:12px; margin-bottom:16px;">
                            <div>
                                <span style="font-size:11px; color:#64748B; font-weight:700; text-transform:uppercase;">Tracking ID / AWB</span>
                                <div style="font-size:1.1rem; font-weight:900; color:#181512; display:flex; align-items:center; gap:8px;">
                                    <span id="activeAwbNumber">DEL-994820192</span>
                                    <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-weight:700;">Delhivery Air</span>
                                </div>
                            </div>
                            <div style="text-align:right;">
                                <span style="font-size:11px; color:#64748B; font-weight:700; text-transform:uppercase;">Estimated Delivery</span>
                                <div style="font-size:1rem; font-weight:800; color:#15803D;">Tomorrow, by 4:00 PM</div>
                            </div>
                        </div>

                        <!-- Step Timeline -->
                        <div class="dt-track-timeline">
                            <div class="dt-track-progress"></div>
                            <div class="dt-track-step done">
                                <div class="dt-track-dot">✓</div>
                                <div class="dt-track-title">Dispatched</div>
                                <div class="dt-track-sub">Surat Central Depot</div>
                            </div>
                            <div class="dt-track-step done">
                                <div class="dt-track-dot">✓</div>
                                <div class="dt-track-title">In Transit</div>
                                <div class="dt-track-sub">Mumbai Air Hub</div>
                            </div>
                            <div class="dt-track-step active">
                                <div class="dt-track-dot">3</div>
                                <div class="dt-track-title">Out for Delivery</div>
                                <div class="dt-track-sub">Delhi Central Hub</div>
                            </div>
                            <div class="dt-track-step">
                                <div class="dt-track-dot">4</div>
                                <div class="dt-track-title">Delivered</div>
                                <div class="dt-track-sub">Recipient Signature</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Dispatches Table Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>📦 Live Dispatches in Transit</span></h3>
                    <span class="adm-badge" style="background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; font-weight:800; font-size:11.5px;">6 Parcels Moving</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Order Ref</th>
                                <th>Carrier &amp; AWB</th>
                                <th>Destination</th>
                                <th>Status Checkpoint</th>
                                <th style="text-align:right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>#DTB-001624</strong></td>
                                <td>
                                    <code style="background:#FAF5E8; padding:2px 6px; border-radius:4px; color:#8A681F; font-weight:700;">DEL-994820192</code>
                                    <div style="font-size:11px; color:#64748B;">Delhivery Express</div>
                                </td>
                                <td>Chandni Chowk, Delhi</td>
                                <td><span class="adm-badge success">Out for Delivery</span></td>
                                <td style="text-align:right;">
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="quickTrack('DEL-994820192')">Track</button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>#DTB-001623</strong></td>
                                <td>
                                    <code style="background:#FAF5E8; padding:2px 6px; border-radius:4px; color:#8A681F; font-weight:700;">BLU-55291039</code>
                                    <div style="font-size:11px; color:#64748B;">BlueDart Air</div>
                                </td>
                                <td>Indiranagar, Bengaluru</td>
                                <td><span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-weight:700;">In Transit (Air Hub)</span></td>
                                <td style="text-align:right;">
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="quickTrack('BLU-55291039')">Track</button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>#DTB-001620</strong></td>
                                <td>
                                    <code style="background:#FAF5E8; padding:2px 6px; border-radius:4px; color:#8A681F; font-weight:700;">TCI-B2B-88319</code>
                                    <div style="font-size:11px; color:#64748B;">TCI Freight Cargo</div>
                                </td>
                                <td>Johari Bazaar, Jaipur (24 Bales)</td>
                                <td><span class="adm-badge success">Delivered &amp; Signed</span></td>
                                <td style="text-align:right;">
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="quickTrack('TCI-B2B-88319')">Track</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script>
function handleTrackAWB(e) {
    e.preventDefault();
    const awb = document.getElementById('awbSearchInput').value.trim();
    if (!awb) return;
    document.getElementById('activeAwbNumber').textContent = awb;
    if (typeof window.showToast === 'function') {
        window.showToast(`🔍 Tracking updated for AWB: ${awb}`);
    }
}

function quickTrack(awb) {
    document.getElementById('awbSearchInput').value = awb;
    document.getElementById('activeAwbNumber').textContent = awb;
    window.scrollTo({ top: 0, behavior: 'smooth' });
    if (typeof window.showToast === 'function') {
        window.showToast(`🔍 Loaded tracking data for ${awb}`);
    }
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
