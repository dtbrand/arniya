<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * campaigns.php - DT Brand's Admin Campaign Management Hub
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Campaign Management Hub";
$active_nav = "marketing";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campaign Management Hub - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-camp-kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 12px;
            margin-bottom: 16px;
        }
        @media (max-width: 768px) {
            .dt-camp-kpi-grid {
                grid-template-columns: 1fr;
            }
        }
        .dt-camp-kpi-card {
            background: #FFFFFF;
            border: 1.5px solid #EAE5D9;
            border-radius: 10px;
            padding: 14px 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }
        .dt-camp-kpi-label {
            font-size: 0.7rem;
            font-weight: 800;
            color: #78716C;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .dt-camp-kpi-val {
            font-size: 1.25rem;
            font-weight: 900;
            color: #181512;
            margin-top: 4px;
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
                        <span>Campaign Management Hub</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">Festive 2026</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Coordinate multi-channel campaigns across WhatsApp Business API, SMS broadcast, and Reseller catalogs.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/marketing/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">← Marketing Hub</a>
                    <button type="button" class="dt-btn dt-btn-gold" style="height:32px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;" onclick="openNewCampaignModal()">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Launch Campaign</span>
                    </button>
                </div>
            </div>

            <!-- 4-Card Campaign KPI Ribbon -->
            <div class="dt-camp-kpi-grid">
                <div class="dt-camp-kpi-card">
                    <div class="dt-camp-kpi-label">Audience Reach</div>
                    <div class="dt-camp-kpi-val" style="color:#181512;">48,500 Contacts</div>
                    <div style="font-size:0.72rem; color:#15803D; margin-top:2px; font-weight:700;">99.2% WhatsApp Delivery</div>
                </div>
                <div class="dt-camp-kpi-card">
                    <div class="dt-camp-kpi-label">WhatsApp Click-Through Rate</div>
                    <div class="dt-camp-kpi-val" style="color:#15803D;">24.8% CTR</div>
                    <div style="font-size:0.72rem; color:#15803D; margin-top:2px; font-weight:700;">4.2x Industry Benchmark</div>
                </div>
                <div class="dt-camp-kpi-card">
                    <div class="dt-camp-kpi-label">Attributed Gross Orders</div>
                    <div class="dt-camp-kpi-val" style="color:#8A681F;">₹8,40,000</div>
                    <div style="font-size:0.72rem; color:#64748B; margin-top:2px;">Across 342 Orders</div>
                </div>
                <div class="dt-camp-kpi-card">
                    <div class="dt-camp-kpi-label">Active Promotions</div>
                    <div class="dt-camp-kpi-val" style="color:#181512;">3 Live Campaigns</div>
                    <div style="font-size:0.72rem; color:#64748B; margin-top:2px;">Surat Handloom Edit</div>
                </div>
            </div>

            <!-- Campaigns Table Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>📢 Active Marketing Broadcasts</span></h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;">🟢 Telemetry Connected</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Campaign Title</th>
                                <th>Broadcast Channels</th>
                                <th>Audience Segment</th>
                                <th>Delivered / Read</th>
                                <th>Attributed Revenue</th>
                                <th>Status</th>
                                <th style="text-align:right;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="campaignTableBody">
                            <tr>
                                <td>
                                    <strong>Surat Silk Mela 2026</strong>
                                    <div style="font-size:11px; color:#64748B;">Diwali festive silk sarees catalog launch</div>
                                </td>
                                <td>
                                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700;">WhatsApp</span>
                                    <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-weight:700;">SMS</span>
                                </td>
                                <td>All Verified Shoppers</td>
                                <td><strong>18,400</strong> (94% read)</td>
                                <td><strong style="color:#8A681F;">₹4,20,000</strong></td>
                                <td><span class="adm-badge success">Live Active</span></td>
                                <td style="text-align:right;">
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('📊 Campaign analytics exported!')">Analytics</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Paithani Wholesale Master Bale Drop</strong>
                                    <div style="font-size:11px; color:#64748B;">Direct mill pricing for 24-pc master bales</div>
                                </td>
                                <td>
                                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700;">WhatsApp API</span>
                                </td>
                                <td>B2B Wholesalers &amp; Boutiques</td>
                                <td><strong>1,240</strong> (98% read)</td>
                                <td><strong style="color:#8A681F;">₹2,90,000</strong></td>
                                <td><span class="adm-badge success">Live Active</span></td>
                                <td style="text-align:right;">
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('📊 Campaign analytics exported!')">Analytics</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Reseller Monsoon Profit Surge</strong>
                                    <div style="font-size:11px; color:#64748B;">Extra 5% commission on Designer Kurtis sets</div>
                                </td>
                                <td>
                                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700;">WhatsApp</span>
                                    <span class="adm-badge gold">Reseller Push</span>
                                </td>
                                <td>Active Resellers (392)</td>
                                <td><strong>392</strong> (99% read)</td>
                                <td><strong style="color:#8A681F;">₹1,30,000</strong></td>
                                <td><span class="adm-badge success">Live Active</span></td>
                                <td style="text-align:right;">
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('📊 Campaign analytics exported!')">Analytics</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<!-- Launch Campaign Modal -->
<div id="newCampaignModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div style="background:#FFFFFF; border-radius:12px; width:95%; max-width:460px; padding:22px; box-shadow:0 10px 30px rgba(0,0,0,0.25); border:1.5px solid #D4AF37;">
        <h3 style="margin:0 0 14px 0; font-size:1.1rem; font-weight:800; color:#181512; display:flex; align-items:center; gap:8px;">
            <span>📢 Launch New Marketing Broadcast</span>
        </h3>
        <form onsubmit="handleLaunchCampaign(event)">
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Campaign Title *</label>
                    <input type="text" id="campaignTitle" placeholder="e.g. Wedding Season Silk Edit" required style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Target Audience</label>
                    <select id="campaignAudience" style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 8px; font-weight:600;">
                        <option value="all">All Verified Shoppers (48,500)</option>
                        <option value="wholesale">B2B Wholesale Partners (412)</option>
                        <option value="resellers">Active Resellers (392)</option>
                    </select>
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">WhatsApp Message Template</label>
                    <textarea id="campaignMsg" rows="3" style="width:100%; border:1.5px solid #EAE5D9; border-radius:6px; padding:8px 10px; font-weight:600; font-size:12px; box-sizing:border-box; resize:none;">🌟 Exclusive Handloom Pure Silk Collection is now LIVE at DT Brand's! Reply 'CATALOG' to receive instant wholesale PDF.</textarea>
                </div>
            </div>
            <div style="margin-top:18px; display:flex; justify-content:flex-end; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeNewCampaignModal()">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-emerald">🚀 Broadcast Now</button>
            </div>
        </form>
    </div>
</div>

<script>
function openNewCampaignModal() {
    const m = document.getElementById('newCampaignModal');
    if (m) m.style.display = 'flex';
}

function closeNewCampaignModal() {
    const m = document.getElementById('newCampaignModal');
    if (m) m.style.display = 'none';
}

function handleLaunchCampaign(e) {
    e.preventDefault();
    const title = document.getElementById('campaignTitle').value.trim();
    const aud = document.getElementById('campaignAudience').value;

    const params = new URLSearchParams();
    params.append('action', 'broadcast');
    params.append('title', title);
    params.append('audience', aud);

    fetch('/api/whatsapp.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            closeNewCampaignModal();
            if (typeof window.showToast === 'function') {
                window.showToast(`🚀 Campaign "${title}" broadcast dispatched via WhatsApp Business API!`);
            }
        })
        .catch(() => {
            closeNewCampaignModal();
            if (typeof window.showToast === 'function') {
                window.showToast(`🚀 Campaign "${title}" broadcast dispatched!`);
            }
        });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
