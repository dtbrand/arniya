<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * methods.php - DT Brand's Admin Courier Partners & Methods
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Courier Partners & Logistics Integrations";
$active_nav = "shipping";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Partners &amp; Methods - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-courier-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 16px;
        }
        .dt-courier-card {
            border: 1.5px solid #EAE5D9;
            border-radius: 10px;
            padding: 16px 18px;
            background: #FFFFFF;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .dt-courier-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(184,134,11,0.08);
            border-color: #D4AF37;
        }

        /* Courier Modal Styles */
        .dt-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(17,24,39,0.7);
            backdrop-filter: blur(4px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .dt-modal-overlay.active {
            display: flex;
        }
        .dt-modal-box {
            background: #FFFFFF;
            border-radius: 12px;
            width: 100%;
            max-width: 540px;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
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
                        <span>Courier Partners &amp; Methods</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">4 Integrated Logistics APIs</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Manage automated AWB dispatch generation, pickup scheduling, and webhook tracking sync.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/shipping/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Shipping Suite</span>
                    </a>
                    <a href="/admin/shipping/rates.php" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <span>Rate Matrix</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </a>
                </div>
            </div>

            <!-- Courier Cards Grid -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span style="display:inline-flex; align-items:center; gap:6px;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>Active Logistics Carrier Integrations</span></h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;"><span class="dt-pulse-dot" style="display:inline-block; width:6px; height:6px; border-radius:50%; background:#15803D; margin-right:4px;"></span>Auto-Pickup Scheduling</span>
                </div>
                <div class="dt-courier-grid" style="padding:16px 18px;">
                    <!-- Delhivery -->
                    <div class="dt-courier-card">
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <h4 style="margin:0; font-size:1.05rem; font-weight:800; color:#181512;">Delhivery Express</h4>
                                <span class="adm-badge success">Live API</span>
                            </div>
                            <p style="font-size:0.82rem; color:#64748B; margin:0 0 12px 0;">Air &amp; Surface parcel delivery across 19,000+ pincodes across India. Auto-AWB generation enabled.</p>
                            <div style="font-size:11.5px; color:#181512; font-weight:600; background:#FAF8F4; padding:6px 10px; border-radius:6px; margin-bottom:12px;">
                                SLA: 2–4 Business Days | COD Supported
                            </div>
                        </div>
                        <div style="display:flex; justify-content:flex-end; gap:6px;">
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="testCourierWebhook('delhivery', this)">Test Webhook</button>
                            <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="openCourierConfig('delhivery', 'Delhivery Express', 'DELHIVERY_API_TOKEN', 'https://track.delhivery.com/api/v1/')">Configure</button>
                        </div>
                    </div>

                    <!-- BlueDart -->
                    <div class="dt-courier-card">
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <h4 style="margin:0; font-size:1.05rem; font-weight:800; color:#181512;">BlueDart Air Express</h4>
                                <span class="adm-badge success">Live API</span>
                            </div>
                            <p style="font-size:0.82rem; color:#64748B; margin:0 0 12px 0;">Premium overnight air shipping for high-value pure zari and bridal wedding collections.</p>
                            <div style="font-size:11.5px; color:#181512; font-weight:600; background:#FAF8F4; padding:6px 10px; border-radius:6px; margin-bottom:12px;">
                                SLA: 24–48 Hours Metro | High Security
                            </div>
                        </div>
                        <div style="display:flex; justify-content:flex-end; gap:6px;">
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="testCourierWebhook('bluedart', this)">Test Webhook</button>
                            <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="openCourierConfig('bluedart', 'BlueDart Air Express', 'BLUEDART_CLIENT_ID / BLUEDART_SECRET', 'https://api.bluedart.com/servlet/RoutingServlet')">Configure</button>
                        </div>
                    </div>

                    <!-- TCI Freight -->
                    <div class="dt-courier-card">
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <h4 style="margin:0; font-size:1.05rem; font-weight:800; color:#181512;">TCI Freight B2B Cargo</h4>
                                <span class="adm-badge gold" style="font-weight:800;">Wholesale Bales</span>
                            </div>
                            <p style="font-size:0.82rem; color:#64748B; margin:0 0 12px 0;">Dedicated surface transport for heavy wholesale master bales and boutique carton consignments (&gt;25 kg).</p>
                            <div style="font-size:11.5px; color:#181512; font-weight:600; background:#FAF8F4; padding:6px 10px; border-radius:6px; margin-bottom:12px;">
                                SLA: 3–6 Days Regional | Pallet Tracking
                            </div>
                        </div>
                        <div style="display:flex; justify-content:flex-end; gap:6px;">
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="testCourierWebhook('tci', this)">Test Webhook</button>
                            <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="openCourierConfig('tci', 'TCI Freight B2B Cargo', 'TCI_ACCOUNT_ID / TCI_API_KEY', 'https://tcil.com/tcil/tracking.html')">Configure</button>
                        </div>
                    </div>

                    <!-- DTDC Express -->
                    <div class="dt-courier-card">
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <h4 style="margin:0; font-size:1.05rem; font-weight:800; color:#181512;">DTDC Express Logistics</h4>
                                <span class="adm-badge success">Live API</span>
                            </div>
                            <p style="font-size:0.82rem; color:#64748B; margin:0 0 12px 0;">Extensive domestic reach for tier-2/3 retail parcels and regional dispatch centers.</p>
                            <div style="font-size:11.5px; color:#181512; font-weight:600; background:#FAF8F4; padding:6px 10px; border-radius:6px; margin-bottom:12px;">
                                SLA: 2–5 Days Domestic | Pincode Coverage
                            </div>
                        </div>
                        <div style="display:flex; justify-content:flex-end; gap:6px;">
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="testCourierWebhook('delhivery', this)">Test Webhook</button>
                            <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="openCourierConfig('dtdc', 'DTDC Express Logistics', 'DTDC_API_KEY / DTDC_CUSTOMER_CODE', 'https://tracking.dtdc.com/ct糙/track')">Configure</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<!-- Courier Configuration Modal -->
<div id="dtCourierConfigModal" class="dt-modal-overlay" onclick="if(event.target===this) closeCourierConfig();">
    <div class="dt-modal-box">
        <div style="padding:16px 20px; border-bottom:1px solid #E5E7EB; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                <h3 id="cfgModalTitle" style="margin:0; font-size:1.05rem; font-weight:800; color:#181512;">Logistics Carrier Config</h3>
            </div>
            <button type="button" onclick="closeCourierConfig()" style="background:none; border:none; cursor:pointer; color:#64748B; padding:4px; display:flex;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <div style="padding:20px;">
            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:4px;">Inbound Push Webhook URL (For Real-time Status Sync)</label>
                <div style="display:flex; gap:6px;">
                    <input type="text" id="cfgWebhookUrl" readonly style="flex:1; background:#F9FAFB; border:1px solid #D1D5DB; border-radius:6px; padding:7px 10px; font-size:12px; font-family:monospace; color:#1F2937;" value="">
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="copyWebhookUrl()">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        <span>Copy</span>
                    </button>
                </div>
                <div style="font-size:11px; color:#64748B; margin-top:3px;">Paste this URL into your courier portal to receive automated dispatch, out for delivery, and delivery events.</div>
            </div>

            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:4px;">Required Environment Keys (.env)</label>
                <div id="cfgEnvVars" style="background:#FAF8F4; border:1px solid #E5E7EB; border-radius:6px; padding:8px 12px; font-family:monospace; font-size:12px; color:#8A681F; font-weight:700;">
                    DELHIVERY_API_TOKEN
                </div>
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:4px;">Carrier API Endpoint</label>
                <input type="text" id="cfgEndpoint" readonly style="width:100%; background:#F9FAFB; border:1px solid #D1D5DB; border-radius:6px; padding:7px 10px; font-size:12px; font-family:monospace; color:#4B5563;" value="">
            </div>

            <div id="cfgTestResult" style="display:none; padding:10px; border-radius:6px; font-size:12px; margin-bottom:16px;"></div>

            <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid #E5E7EB; padding-top:14px;">
                <button type="button" id="cfgBtnTest" class="dt-btn dt-btn-pale" style="height:32px; font-size:12px; font-weight:700;" onclick="testModalWebhook()">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                    <span>Ping Webhook</span>
                </button>
                <button type="button" class="dt-btn dt-btn-gold" style="height:32px; font-size:12px; font-weight:800;" onclick="closeCourierConfig()">Done</button>
            </div>
        </div>
    </div>
</div>

<script>
var currentCourierKey = 'delhivery';

function showToastSafe(m) { 
    if (typeof window.showToast === "function") window.showToast(m); 
    else alert(m); 
}

function openCourierConfig(key, title, envVars, endpoint) {
    currentCourierKey = key;
    document.getElementById('cfgModalTitle').textContent = title + ' Configuration';
    document.getElementById('cfgEnvVars').textContent = envVars;
    document.getElementById('cfgEndpoint').value = endpoint;
    
    var webhookRoute = key === 'dtdc' ? 'delhivery' : key;
    var host = window.location.origin;
    document.getElementById('cfgWebhookUrl').value = host + '/api/webhooks/' + webhookRoute + '.php';

    var resDiv = document.getElementById('cfgTestResult');
    resDiv.style.display = 'none';

    document.getElementById('dtCourierConfigModal').classList.add('active');
}

function closeCourierConfig() {
    document.getElementById('dtCourierConfigModal').classList.remove('active');
}

function copyWebhookUrl() {
    var url = document.getElementById('cfgWebhookUrl').value;
    navigator.clipboard.writeText(url).then(function() {
        showToastSafe('Webhook URL copied to clipboard!');
    }).catch(function() {
        showToastSafe('Copy failed: ' + url);
    });
}

function testModalWebhook() {
    var btn = document.getElementById('cfgBtnTest');
    btn.disabled = true;
    var courier = currentCourierKey === 'dtdc' ? 'delhivery' : currentCourierKey;

    var resDiv = document.getElementById('cfgTestResult');
    resDiv.style.display = 'block';
    resDiv.style.background = '#F3F4F6';
    resDiv.style.color = '#374151';
    resDiv.textContent = 'Pinging webhook route...';

    fetch("/api/shipping/test.php?courier=" + encodeURIComponent(courier), { credentials: "same-origin" })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            btn.disabled = false;
            if (d.success) {
                resDiv.style.background = '#DCFCE7';
                resDiv.style.color = '#15803D';
                resDiv.textContent = 'Success: Webhook route active and reachable (HTTP ' + d.http_code + ')';
            } else {
                resDiv.style.background = '#FEF2F2';
                resDiv.style.color = '#DC2626';
                resDiv.textContent = 'Notice: ' + (d.message || ('HTTP ' + d.http_code));
            }
        })
        .catch(function () {
            btn.disabled = false;
            resDiv.style.background = '#FEF2F2';
            resDiv.style.color = '#DC2626';
            resDiv.textContent = 'Could not reach webhook endpoint probe.';
        });
}

function testCourierWebhook(courier, btn) {
    btn.disabled = true;
    fetch("/api/shipping/test.php?courier=" + encodeURIComponent(courier), { credentials: "same-origin" })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            btn.disabled = false;
            var msg = d.message || ("HTTP " + d.http_code);
            showToastSafe((d.success ? "Active: " : "Notice: ") + msg);
        })
        .catch(function () { btn.disabled = false; showToastSafe("Could not reach /api/shipping/test.php"); });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
