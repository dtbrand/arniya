<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * export.php — DT Brand's & Jai Hanuman Tex
 * Reseller Data Export Studio (CSV, Excel XLS, Printable PDF Dossier)
 */
$page_title = "Reseller Export Studio";
$active_nav = "resellers";
$active_subnav = "export";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseller Export Studio - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/resellers/assets/css/resellers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/resellers/assets/css/reseller-list.css?v=<?php echo time(); ?>">
    <!-- html2canvas and jsPDF for High-DPI 1:1 PDF Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        .dt-export-format-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 12px;
        }
        .dt-export-format-card {
            background: #FFFFFF;
            border: 1.5px solid #EAE5D9;
            border-radius: 10px;
            padding: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .dt-export-format-card:hover {
            border-color: #D4AF37;
            background: #FDFBF7;
        }
        .dt-export-format-card.active {
            border-color: #8A681F;
            background: #FAF5E8;
            box-shadow: 0 0 0 1.5px #8A681F, 0 4px 12px rgba(138, 104, 31, 0.12);
        }
        .dt-export-format-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 0.85rem;
            flex-shrink: 0;
        }
        .dt-export-group-box {
            background: #FFFFFF;
            border: 1.2px solid #EAE5D9;
            border-radius: 10px;
            padding: 14px;
            display: flex;
            flex-direction: column;
            gap: 9px;
        }
        .dt-field-check-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.78rem;
            font-weight: 600;
            color: #181512;
            cursor: pointer;
        }
        .dt-field-check-label input {
            cursor: pointer;
            accent-color: #8A681F;
            width: 15px;
            height: 15px;
        }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 18px 20px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-customers-container" style="display:flex; flex-direction:column; gap:16px; margin-bottom:24px;">
                <!-- ══ TOP HEADER ══ -->
                <div class="dt-cust-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:4px;">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0; display:flex; align-items:center; gap:8px;">
                            <span>Reseller Data Export Studio</span>
                            <span class="dt-cust-badge emerald" style="font-size:0.72rem; padding:3px 8px; border-radius:6px; background:#DCFCE7; color:#15803D; border:1px solid #86EFAC; font-weight:800;">100% Export Ready</span>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Download partner rosters, GSTIN tax details, GMV purchase logs, and credit ledgers in CSV, Excel or PDF.</p>
                    </div>
                    <div class="dt-cust-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <a href="/admin/resellers/index.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            <span>Back to Resellers</span>
                        </a>
                    </div>
                </div>

                <!-- 4-Card KPI Ribbon -->
                <div class="dt-reseller-kpi-grid">
                    <div class="dt-reseller-kpi-card">
                        <div class="dt-reseller-kpi-top">
                            <span class="dt-reseller-kpi-label">Exportable Roster</span>
                            <div class="dt-reseller-kpi-icon gold">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                            </div>
                        </div>
                        <div class="dt-reseller-kpi-val">348 Partners</div>
                        <div class="dt-reseller-kpi-bot"><span style="color:#78716C;">Active B2B Database</span></div>
                    </div>

                    <div class="dt-reseller-kpi-card">
                        <div class="dt-reseller-kpi-top">
                            <span class="dt-reseller-kpi-label">Available Attributes</span>
                            <div class="dt-reseller-kpi-icon emerald">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#15803D" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path></svg>
                            </div>
                        </div>
                        <div class="dt-reseller-kpi-val">14 Fields</div>
                        <div class="dt-reseller-kpi-bot"><span style="color:#78716C;">Full Audit History</span></div>
                    </div>

                    <div class="dt-reseller-kpi-card">
                        <div class="dt-reseller-kpi-top">
                            <span class="dt-reseller-kpi-label">Supported Formats</span>
                            <div class="dt-reseller-kpi-icon blue">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#1D4ED8" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            </div>
                        </div>
                        <div class="dt-reseller-kpi-val">3 Formats</div>
                        <div class="dt-reseller-kpi-bot"><span style="color:#78716C;">CSV • XLS • PDF</span></div>
                    </div>

                    <div class="dt-reseller-kpi-card">
                        <div class="dt-reseller-kpi-top">
                            <span class="dt-reseller-kpi-label">Data Privacy</span>
                            <div class="dt-reseller-kpi-icon purple">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#7E22CE" stroke-width="2.3"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            </div>
                        </div>
                        <div class="dt-reseller-kpi-val">Staff Protected</div>
                        <div class="dt-reseller-kpi-bot"><span style="color:#78716C;">Audit Logged</span></div>
                    </div>
                </div>

                <!-- Export Wizard Card -->
                <div class="dt-card" style="padding:22px; background:#FFFFFF; border:1.5px solid #EAE5D9; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.02);">
                    <form onsubmit="handleResellerExport(event)" style="display:flex; flex-direction:column; gap:20px;">
                        
                        <!-- 1. Format Selection -->
                        <div>
                            <label style="font-size:0.78rem; font-weight:800; color:#181512; display:block; text-transform:uppercase; margin-bottom:8px;">1. Select Export Format</label>
                            <div class="dt-export-format-grid">
                                <div id="card_csv" class="dt-export-format-card active" onclick="selectExportFormat('csv', this)">
                                    <input type="radio" name="export_format" value="csv" checked style="display:none;">
                                    <div class="dt-export-format-icon" style="background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37;">CSV</div>
                                    <div>
                                        <strong style="font-size:0.85rem; color:#181512; display:block;">CSV Spreadsheet</strong>
                                        <small style="font-size:0.68rem; color:#78716C;">Universal UTF-8 text dataset</small>
                                    </div>
                                </div>

                                <div id="card_excel" class="dt-export-format-card" onclick="selectExportFormat('excel', this)">
                                    <input type="radio" name="export_format" value="excel" style="display:none;">
                                    <div class="dt-export-format-icon" style="background:#DCFCE7; color:#15803D; border:1px solid #86EFAC;">XLS</div>
                                    <div>
                                        <strong style="font-size:0.85rem; color:#181512; display:block;">Excel Workbook</strong>
                                        <small style="font-size:0.68rem; color:#78716C;">Microsoft .xls spreadsheet</small>
                                    </div>
                                </div>

                                <div id="card_pdf" class="dt-export-format-card" onclick="selectExportFormat('pdf', this)">
                                    <input type="radio" name="export_format" value="pdf" style="display:none;">
                                    <div class="dt-export-format-icon" style="background:#EFF6FF; color:#1D4ED8; border:1px solid #BFDBFE;">PDF</div>
                                    <div>
                                        <strong style="font-size:0.85rem; color:#181512; display:block;">Printable PDF</strong>
                                        <small style="font-size:0.68rem; color:#78716C;">Formatted executive dossier</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Target Scope -->
                        <div>
                            <label style="font-size:0.78rem; font-weight:800; color:#181512; display:block; text-transform:uppercase; margin-bottom:8px;">2. Audience Scope &amp; Target Cohort</label>
                            <select id="dtExportScope" class="dt-reseller-select" style="width:100%; height:40px; font-size:0.82rem; font-weight:700; background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 12px;">
                                <option value="all" selected>All Registered Resellers (348 Partners)</option>
                                <option value="approved">Approved &amp; Active Resellers (296 Partners)</option>
                                <option value="pending">Pending Applications Under Review (24 Partners)</option>
                                <option value="platinum">Platinum Elite Tier Only (42 Partners)</option>
                                <option value="credit">Resellers with Active Credit Balances (112 Partners)</option>
                            </select>
                        </div>

                        <!-- 3. Fields to Include -->
                        <div>
                            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px; margin-bottom:10px;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <label style="font-size:0.78rem; font-weight:800; color:#181512; text-transform:uppercase; margin:0;">3. Data Fields &amp; Attributes to Include</label>
                                    <span id="selectedFieldCount" style="font-size:0.7rem; font-weight:800; color:#8A681F; background:#FAF5E8; border:1px solid #D4AF37; padding:2px 8px; border-radius:6px;">14 of 14 Selected</span>
                                </div>
                                <div style="display:flex; gap:6px;">
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="toggleAllFields(true)">Select All</button>
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="toggleAllFields(false)">Clear All</button>
                                </div>
                            </div>

                            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:14px;">
                                <div class="dt-export-group-box">
                                    <strong style="font-size:0.75rem; color:#8A681F; text-transform:uppercase;">👤 Contact &amp; Identity</strong>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="id" checked onchange="updateFieldCount()"> Reseller ID (RES-XXXX)</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="name" checked onchange="updateFieldCount()"> Business / Trade Name</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="contact" checked onchange="updateFieldCount()"> Contact Person</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="phone" checked onchange="updateFieldCount()"> Phone / WhatsApp</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="email" checked onchange="updateFieldCount()"> Email Address</label>
                                </div>

                                <div class="dt-export-group-box">
                                    <strong style="font-size:0.75rem; color:#15803D; text-transform:uppercase;">💰 Commercial &amp; Credit</strong>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="tier" checked onchange="updateFieldCount()"> Margin Tier (Platinum/Gold/Silver)</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="orders" checked onchange="updateFieldCount()"> Total Sourced Orders</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="purchase" checked onchange="updateFieldCount()"> Total Purchase GMV (₹)</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="credit" checked onchange="updateFieldCount()"> Utilized Credit (₹)</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="credit_limit" checked onchange="updateFieldCount()"> Sanctioned Credit Limit (₹)</label>
                                </div>

                                <div class="dt-export-group-box">
                                    <strong style="font-size:0.75rem; color:#1D4ED8; text-transform:uppercase;">📍 Location &amp; Compliance</strong>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="city" checked onchange="updateFieldCount()"> City &amp; State</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="kyc" checked onchange="updateFieldCount()"> KYC Verification Status</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="status" checked onchange="updateFieldCount()"> Account Standing (Active/Pending)</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="joined" checked onchange="updateFieldCount()"> Joined Date</label>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:10px; border-top:1.5px solid #F1ECE1; padding-top:16px;">
                            <a href="/admin/resellers/index.php" class="dt-btn dt-btn-pale">Cancel</a>
                            <button type="submit" class="dt-btn dt-btn-gold" style="height:40px; padding:0 22px;">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#111827" stroke-width="2.8"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                <span>Generate &amp; Download File</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/resellers/assets/js/resellers.js?v=<?php echo time(); ?>"></script>
<script>
let currentFormat = 'csv';

const mockResellerDataset = [
    { id: "RES-1048", name: "Arniya Silk Heritage", contact: "Rameshwar Vyas", phone: "+91 70463 63528", email: "krishna.boutique@gmail.com", tier: "Platinum", orders: 142, purchase: 845000, credit: 65000, credit_limit: 150000, city: "Surat, Gujarat", kyc: "Verified", status: "Active", joined: "2025-11-12" },
    { id: "RES-1050", name: "Royal Banarasi Heritage", contact: "Anand Sharma", phone: "+91 70463 63528", email: "anand.banaras@yahoo.com", tier: "Platinum", orders: 110, purchase: 590000, credit: 42000, credit_limit: 150000, city: "Varanasi, UP", kyc: "Verified", status: "Active", joined: "2025-12-04" },
    { id: "RES-1049", name: "Surat Fab Sarees Hub", contact: "Ketan Jain", phone: "+91 70463 63528", email: "surat.fabrics@gmail.com", tier: "Gold", orders: 88, purchase: 380000, credit: 28000, credit_limit: 100000, city: "Surat, Gujarat", kyc: "Verified", status: "Active", joined: "2026-01-10" },
    { id: "RES-1052", name: "Jaipur Block Handloom Hub", contact: "Pooja Agarwal", phone: "+91 70463 63528", email: "jaipur.handlooms@outlook.com", tier: "Gold", orders: 64, purchase: 240000, credit: 15000, credit_limit: 80000, city: "Jaipur, Rajasthan", kyc: "Verified", status: "Active", joined: "2026-02-14" },
    { id: "RES-1051", name: "Kanchipuram Silk Palace", contact: "Murugan Selvam", phone: "+91 70463 63528", email: "kanchipuram.palace@gmail.com", tier: "Silver", orders: 32, purchase: 165000, credit: 0, credit_limit: 50000, city: "Chennai, Tamil Nadu", kyc: "Verified", status: "Active", joined: "2026-03-20" },
    { id: "RES-1053", name: "Kolkata Silk Emporium", contact: "Debabrata Sen", phone: "+91 70463 63528", email: "kolkata.silks@rediffmail.com", tier: "Bronze", orders: 8, purchase: 38000, credit: 50000, credit_limit: 50000, city: "Kolkata, West Bengal", kyc: "Verified", status: "Active", joined: "2026-04-15" },
    { id: "RES-1054", name: "Mahalaxmi Fashion Hub", contact: "Suresh Patel", phone: "+91 70463 63528", email: "mahalaxmi.fashion@gmail.com", tier: "Bronze", orders: 0, purchase: 0, credit: 0, credit_limit: 25000, city: "Rajkot, Gujarat", kyc: "Needs Review", status: "Pending", joined: "2026-08-20" },
    { id: "RES-1055", name: "Gitanjali Sarees Hub", contact: "Amitabh Roy", phone: "+91 70463 63528", email: "gitanjali.hub@rediffmail.com", tier: "Silver", orders: 0, purchase: 0, credit: 0, credit_limit: 50000, city: "Siliguri, West Bengal", kyc: "Pending", status: "Pending", joined: "2026-08-21" }
];

function selectExportFormat(fmt, el) {
    currentFormat = fmt;
    document.querySelectorAll('.dt-export-format-card').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
    const radio = el.querySelector('input[type="radio"]');
    if (radio) radio.checked = true;
}

function updateFieldCount() {
    const total = document.querySelectorAll('input[name="fields[]"]').length;
    const checked = document.querySelectorAll('input[name="fields[]"]:checked').length;
    const countEl = document.getElementById('selectedFieldCount');
    if (countEl) countEl.innerText = `${checked} of ${total} Selected`;
}

function toggleAllFields(check) {
    document.querySelectorAll('input[name="fields[]"]').forEach(cb => cb.checked = check);
    updateFieldCount();
}

function getSelectedFields() {
    const checked = [];
    document.querySelectorAll('input[name="fields[]"]:checked').forEach(cb => checked.push(cb.value));
    return checked.length ? checked : ['id', 'name', 'contact', 'phone', 'tier', 'purchase', 'credit', 'status'];
}

function handleResellerExport(e) {
    if (e) e.preventDefault();
    const scope = document.getElementById('dtExportScope').value;
    const selectedFields = getSelectedFields();

    let records = mockResellerDataset;
    if (scope === 'approved') records = mockResellerDataset.filter(r => r.status === 'Active');
    else if (scope === 'pending') records = mockResellerDataset.filter(r => r.status === 'Pending');
    else if (scope === 'platinum') records = mockResellerDataset.filter(r => r.tier === 'Platinum');
    else if (scope === 'credit') records = mockResellerDataset.filter(r => r.credit > 0);

    const todayStr = new Date().toISOString().slice(0, 10);

    if (window.showToast) {
        window.showToast(`⏳ Generating ${currentFormat.toUpperCase()} file for "${scope}" cohort...`);
    }

    setTimeout(() => {
        if (currentFormat === 'csv') downloadCsv(records, selectedFields, todayStr);
        else if (currentFormat === 'excel') downloadExcel(records, selectedFields, todayStr);
        else if (currentFormat === 'pdf') downloadPdfDossier(records, selectedFields, todayStr);
    }, 400);
}

function downloadCsv(records, fields, dateStr) {
    const fieldMap = { id: "Reseller ID", name: "Business Name", contact: "Contact Person", phone: "Phone", email: "Email", tier: "Tier", orders: "Orders", purchase: "GMV Purchase (INR)", credit: "Used Credit (INR)", credit_limit: "Credit Limit (INR)", city: "City", kyc: "KYC Status", status: "Account Status", joined: "Joined Date" };
    const headers = fields.map(f => `"${fieldMap[f] || f}"`).join(",");
    const rows = records.map(r => fields.map(f => `"${(r[f] !== undefined ? r[f] : '').toString().replace(/"/g, '""')}"`).join(","));
    const csvData = "\uFEFF" + headers + "\n" + rows.join("\n");
    const blob = new Blob([csvData], { type: "text/csv;charset=utf-8;" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = `DT_Brands_Reseller_Master_Export_${dateStr}.csv`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    if (window.showToast) window.showToast("✅ CSV Export complete! File downloaded.");
}

function downloadExcel(records, fields, dateStr) {
    const fieldMap = { id: "Reseller ID", name: "Business Name", contact: "Contact Person", phone: "Phone", email: "Email", tier: "Tier", orders: "Orders", purchase: "GMV (₹)", credit: "Used Credit (₹)", credit_limit: "Limit (₹)", city: "City", kyc: "KYC", status: "Status", joined: "Joined" };
    let tableHtml = `<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta charset="utf-8"><style>th{background-color:#B8860B;color:#FFFFFF;font-weight:bold;padding:8px;border:1px solid #8A681F;}td{padding:6px;border:1px solid #EAE5D9;font-family:'Segoe UI',sans-serif;}</style></head><body><h2>DT Brand's & Jai Hanuman Tex — Reseller Master Report</h2><table><thead><tr>`;
    fields.forEach(f => tableHtml += `<th>${fieldMap[f] || f}</th>`);
    tableHtml += `</tr></thead><tbody>`;
    records.forEach(r => {
        tableHtml += `<tr>`;
        fields.forEach(f => tableHtml += `<td>${r[f] !== undefined ? r[f] : ''}</td>`);
        tableHtml += `</tr>`;
    });
    tableHtml += `</tbody></table></body></html>`;
    const blob = new Blob([tableHtml], { type: "application/vnd.ms-excel;charset=utf-8" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = `DT_Brands_Reseller_Master_Export_${dateStr}.xls`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    if (window.showToast) window.showToast("✅ Excel Workbook downloaded successfully!");
}

function downloadPdfDossier(records, fields, dateStr) {
    const fieldMap = { id: "Reseller ID", name: "Business Name", contact: "Contact", phone: "Phone", email: "Email", tier: "Tier", orders: "Orders", purchase: "GMV (₹)", credit: "Credit (₹)", credit_limit: "Limit (₹)", city: "City", kyc: "KYC", status: "Status", joined: "Joined" };

    const dossierContainer = document.createElement('div');
    dossierContainer.id = 'dtDossierPdfRender';
    dossierContainer.style.position = 'fixed';
    dossierContainer.style.top = '0';
    dossierContainer.style.left = '0';
    dossierContainer.style.width = '1000px';
    dossierContainer.style.background = '#FFFFFF';
    dossierContainer.style.padding = '24px';
    dossierContainer.style.zIndex = '9999999';
    dossierContainer.style.fontFamily = "'Plus Jakarta Sans', sans-serif";
    dossierContainer.style.color = '#181512';
    dossierContainer.style.boxSizing = 'border-box';

    let tableRows = '';
    records.forEach(r => {
        tableRows += `<tr style="border-bottom:1px solid #EAE5D9;">`;
        fields.forEach(f => {
            let val = r[f] !== undefined ? r[f] : '';
            if (f === 'purchase' || f === 'credit' || f === 'credit_limit') val = '₹' + Number(val).toLocaleString('en-IN');
            tableRows += `<td style="padding:8px 10px; font-size:11px; white-space:nowrap;">${val}</td>`;
        });
        tableRows += `</tr>`;
    });

    dossierContainer.innerHTML = `
        <div style="background:linear-gradient(135deg, #181512, #2A241E); padding:16px 20px; border-radius:10px; border:1px solid #8A681F; color:#FFFFFF; display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <div>
                <div style="font-size:10px; color:#FFE57F; font-weight:800; text-transform:uppercase;">DT BRAND'S & JAI HANUMAN TEX</div>
                <h2 style="font-size:18px; margin:2px 0 0 0; font-weight:900;">B2B Wholesale Reseller Master Dossier</h2>
                <small style="font-size:10px; color:#F5ECCE;">Export Date: ${dateStr} • Total Partners Exported: ${records.length}</small>
            </div>
            <div style="text-align:right;">
                <span style="background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; padding:4px 8px; border-radius:6px; font-size:10px; font-weight:800;">OFFICIAL AUDIT COPY</span>
            </div>
        </div>
        <table style="width:100%; border-collapse:collapse; font-size:11px;">
            <thead>
                <tr style="background:#FAF8F4; border-bottom:1.5px solid #D4AF37;">
                    ${fields.map(f => `<th style="padding:8px 10px; font-weight:800; color:#8A681F; text-align:left; white-space:nowrap;">${fieldMap[f] || f}</th>`).join('')}
                </tr>
            </thead>
            <tbody>
                ${tableRows}
            </tbody>
        </table>
        <div style="margin-top:16px; border-top:1px solid #EAE5D9; padding-top:8px; display:flex; justify-content:space-between; font-size:10px; color:#78716C;">
            <span>🔒 Confidential Reseller Network Report • ISO 9001:2015</span>
            <span>Surat Wholesale Central Ledger</span>
        </div>
    `;

    document.body.appendChild(dossierContainer);

    const hasHtml2Canvas = typeof window.html2canvas === 'function';
    const jsPDFClass = (window.jspdf && window.jspdf.jsPDF) ? window.jspdf.jsPDF : (typeof window.jsPDF === 'function' ? window.jsPDF : null);

    if (hasHtml2Canvas && jsPDFClass) {
        window.html2canvas(dossierContainer, {
            scale: 2,
            useCORS: true,
            allowTaint: true,
            backgroundColor: '#FFFFFF',
            logging: false
        }).then(function (canvas) {
            if (dossierContainer.parentNode) dossierContainer.parentNode.removeChild(dossierContainer);
            const imgData = canvas.toDataURL('image/jpeg', 0.98);
            const pdf = new jsPDFClass({
                orientation: 'landscape',
                unit: 'mm',
                format: 'a4'
            });

            const pageWidth = pdf.internal.pageSize.getWidth();
            const marginX = 8;
            const marginY = 8;
            const targetWidth = pageWidth - (marginX * 2);
            const targetHeight = (canvas.height * targetWidth) / canvas.width;

            pdf.addImage(imgData, 'JPEG', marginX, marginY, targetWidth, targetHeight);
            pdf.save(`DT_Brands_Reseller_Master_Export_${dateStr}.pdf`);
            if (window.showToast) window.showToast("✅ PDF Dossier downloaded successfully!");
        }).catch(function (err) {
            console.error('PDF export error:', err);
            if (dossierContainer.parentNode) dossierContainer.parentNode.removeChild(dossierContainer);
        });
        return;
    }

    if (dossierContainer.parentNode) dossierContainer.parentNode.removeChild(dossierContainer);
    window.print();
}
</script>
</body>
</html>
