<?php
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
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/resellers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/reseller-list.css?v=<?php echo time(); ?>">
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
            box-shadow: 0 0 0 1px #8A681F, 0 4px 12px rgba(138, 104, 31, 0.12);
        }
        .dt-export-format-icon {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
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
            gap: 8px;
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
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">

            <div class="dt-resellers-container">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <h1 style="font-size:1.35rem; font-weight:900; color:#181512; margin:0;">Reseller Data Export Studio</h1>
                            <span class="dt-reseller-badge emerald">100% Export Ready</span>
                        </div>
                        <p style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Download partner rosters, GSTIN tax details, GMV purchase logs, and credit ledgers in CSV, Excel or PDF.</p>
                    </div>
                    <a href="/Frontend/Admin/resellers/index.php" class="dt-btn dt-btn-pale">← Back to Resellers Directory</a>
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
                        <div class="dt-reseller-kpi-val">15 Fields</div>
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
                        <div class="dt-reseller-kpi-bot"><span style="color:#78716C;">CSV • XLSX • PDF</span></div>
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
                <div class="dt-card" style="padding:22px;">
                    <form onsubmit="handleResellerExport(event)" style="display:flex; flex-direction:column; gap:20px;">
                        
                        <!-- 1. Format Selection -->
                        <div>
                            <label style="font-size:0.78rem; font-weight:800; color:#181512; display:block; text-transform:uppercase; margin-bottom:8px;">1. Select Export Format</label>
                            <div class="dt-export-format-grid">
                                <div class="dt-export-format-card active" onclick="selectExportFormat('csv', this)">
                                    <input type="radio" name="export_format" value="csv" checked style="display:none;">
                                    <div class="dt-export-format-icon" style="background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37;">CSV</div>
                                    <div>
                                        <strong style="font-size:0.85rem; color:#181512; display:block;">CSV Spreadsheet</strong>
                                        <small style="font-size:0.68rem; color:#78716C;">Universal UTF-8 text dataset</small>
                                    </div>
                                </div>

                                <div class="dt-export-format-card" onclick="selectExportFormat('excel', this)">
                                    <input type="radio" name="export_format" value="excel" style="display:none;">
                                    <div class="dt-export-format-icon" style="background:#DCFCE7; color:#15803D; border:1px solid #86EFAC;">XLS</div>
                                    <div>
                                        <strong style="font-size:0.85rem; color:#181512; display:block;">Excel Workbook</strong>
                                        <small style="font-size:0.68rem; color:#78716C;">Microsoft .xls spreadsheet</small>
                                    </div>
                                </div>

                                <div class="dt-export-format-card" onclick="selectExportFormat('pdf', this)">
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
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                                <label style="font-size:0.78rem; font-weight:800; color:#181512; text-transform:uppercase; margin:0;">3. Data Fields &amp; Attributes to Include</label>
                                <div style="display:flex; gap:6px;">
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="toggleAllFields(true)">Select All</button>
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="toggleAllFields(false)">Clear All</button>
                                </div>
                            </div>

                            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:14px;">
                                <div class="dt-export-group-box">
                                    <strong style="font-size:0.75rem; color:#8A681F; text-transform:uppercase;">👤 Contact &amp; Identity</strong>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="id" checked> Reseller ID (RES-XXXX)</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="name" checked> Business / Trade Name</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="contact" checked> Contact Person</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="phone" checked> Phone / WhatsApp</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="email" checked> Email Address</label>
                                </div>

                                <div class="dt-export-group-box">
                                    <strong style="font-size:0.75rem; color:#15803D; text-transform:uppercase;">💰 Commercial &amp; Credit</strong>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="tier" checked> Margin Tier (Platinum/Gold/Silver)</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="orders" checked> Total Sourced Orders</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="purchase" checked> Total Purchase GMV (₹)</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="credit" checked> Utilized Credit (₹)</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="credit_limit" checked> Sanctioned Credit Limit (₹)</label>
                                </div>

                                <div class="dt-export-group-box">
                                    <strong style="font-size:0.75rem; color:#1D4ED8; text-transform:uppercase;">📍 Location &amp; Compliance</strong>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="city" checked> City &amp; State</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="kyc" checked> KYC Verification Status</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="status" checked> Account Standing (Active/Pending)</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="joined" checked> Joined Date</label>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:10px; border-top:1.5px solid #F1ECE1; padding-top:16px;">
                            <a href="/Frontend/Admin/resellers/index.php" class="dt-btn dt-btn-pale">Cancel</a>
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

<script src="/Frontend/Admin/resellers/assets/js/resellers.js?v=<?php echo time(); ?>"></script>
<script>
let currentFormat = 'csv';

const mockResellerDataset = [
    { id: "RES-1048", name: "Shree Krishna Sarees & Boutique", contact: "Rameshwar Vyas", phone: "+91 98251 44321", email: "krishna.boutique@gmail.com", tier: "Platinum", orders: 142, purchase: 845000, credit: 65000, credit_limit: 150000, city: "Surat, Gujarat", kyc: "Verified", status: "Active", joined: "2025-11-12" },
    { id: "RES-1047", name: "Ananya Designer Studio", contact: "Ananya Sharma", phone: "+91 98765 43210", email: "ananya.studio@yahoo.com", tier: "Gold", orders: 88, purchase: 520000, credit: 42000, credit_limit: 100000, city: "Jaipur, Rajasthan", kyc: "Verified", status: "Active", joined: "2025-12-04" },
    { id: "RES-1046", name: "Vardhman Silk Emporium", contact: "Ketan Jain", phone: "+91 94280 11223", email: "vardhman.silks@gmail.com", tier: "Gold", orders: 64, purchase: 380000, credit: 28000, credit_limit: 80000, city: "Ahmedabad, Gujarat", kyc: "Verified", status: "Active", joined: "2026-01-10" },
    { id: "RES-1045", name: "Royal Heritage Silks", contact: "Pooja Agarwal", phone: "+91 91234 56789", email: "royal.silks@outlook.com", tier: "Silver", orders: 32, purchase: 195000, credit: 15000, credit_limit: 50000, city: "Indore, Madhya Pradesh", kyc: "Verified", status: "Active", joined: "2026-02-14" },
    { id: "RES-1044", name: "Mahalaxmi Fashion Hub", contact: "Suresh Patel", phone: "+91 98980 99887", email: "mahalaxmi.fashion@gmail.com", tier: "Bronze", orders: 0, purchase: 0, credit: 0, credit_limit: 25000, city: "Rajkot, Gujarat", kyc: "Needs Review", status: "Pending", joined: "2026-08-20" },
    { id: "RES-1043", name: "Gitanjali Sarees Kolkata", contact: "Debabrata Sen", phone: "+91 98310 12345", email: "gitanjali.sarees@rediffmail.com", tier: "Silver", orders: 0, purchase: 0, credit: 0, credit_limit: 50000, city: "Kolkata, West Bengal", kyc: "Pending", status: "Pending", joined: "2026-08-21" },
    { id: "RES-1042", name: "Kavita Dress Materials", contact: "Kavita Choudhary", phone: "+91 98200 44556", email: "kavita.dress@gmail.com", tier: "Silver", orders: 18, purchase: 98000, credit: 78000, credit_limit: 50000, city: "Mumbai, Maharashtra", kyc: "Verified", status: "Suspended", joined: "2026-03-01" },
    { id: "RES-1041", name: "Apex Textiles Agency", contact: "Vikas Malhotra", phone: "+91 98111 22334", email: "apex.textiles@ukexport.com", tier: "Bronze", orders: 0, purchase: 0, credit: 0, credit_limit: 0, city: "Delhi, NCR", kyc: "Rejected", status: "Rejected", joined: "2026-08-15" }
];

function selectExportFormat(fmt, el) {
    currentFormat = fmt;
    document.querySelectorAll('.dt-export-format-card').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
    const radio = el.querySelector('input[type="radio"]');
    if (radio) radio.checked = true;
}

function toggleAllFields(check) {
    document.querySelectorAll('input[name="fields[]"]').forEach(cb => cb.checked = check);
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

    window.showToast(`⏳ Generating ${currentFormat.toUpperCase()} file for "${scope}" cohort...`);

    setTimeout(() => {
        if (currentFormat === 'csv') downloadCsv(records, selectedFields);
        else if (currentFormat === 'excel') downloadExcel(records, selectedFields);
        else if (currentFormat === 'pdf') printPdfDossier(records, selectedFields);
    }, 600);
}

function downloadCsv(records, fields) {
    const fieldMap = { id: "Reseller ID", name: "Business Name", contact: "Contact Person", phone: "Phone", email: "Email", tier: "Tier", orders: "Orders", purchase: "GMV Purchase (INR)", credit: "Used Credit (INR)", credit_limit: "Credit Limit (INR)", city: "City", kyc: "KYC Status", status: "Account Status", joined: "Joined Date" };
    const headers = fields.map(f => `"${fieldMap[f] || f}"`).join(",");
    const rows = records.map(r => fields.map(f => `"${(r[f] !== undefined ? r[f] : '').toString().replace(/"/g, '""')}"`).join(","));
    const csvData = "\uFEFF" + headers + "\n" + rows.join("\n");
    const blob = new Blob([csvData], { type: "text/csv;charset=utf-8;" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = `DT_Brands_Resellers_Export_${new Date().toISOString().slice(0, 10)}.csv`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    window.showToast("✓ CSV Export complete! File downloaded successfully.");
}

function downloadExcel(records, fields) {
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
    link.download = `DT_Brands_Resellers_Report_${new Date().toISOString().slice(0, 10)}.xls`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    window.showToast("✓ Excel Workbook downloaded successfully!");
}

function printPdfDossier(records, fields) {
    const printWin = window.open('', '_blank', 'width=900,height=700');
    if (!printWin) return;
    const fieldMap = { id: "Reseller ID", name: "Business Name", contact: "Contact", phone: "Phone", tier: "Tier", orders: "Orders", purchase: "GMV (₹)", credit: "Credit (₹)", city: "City", status: "Status" };
    let html = `<!DOCTYPE html><html><head><title>DT Brand's — Reseller Dossier</title><style>body{font-family:'Plus Jakarta Sans',sans-serif;padding:20px;color:#181512;}table{width:100%;border-collapse:collapse;font-size:11px;}th{background:#FAF5E8;color:#8A681F;text-align:left;padding:8px;border-bottom:1.5px solid #D4AF37;}td{padding:8px;border-bottom:1px solid #F1ECE1;}@page{size:landscape;margin:12mm;}</style></head><body><h2>👑 DT BRAND'S & JAI HANUMAN TEX — RESELLER DOSSIER</h2><p>Export Date: ${new Date().toLocaleDateString()} | Total Records: ${records.length}</p><table><thead><tr>`;
    fields.forEach(f => html += `<th>${fieldMap[f] || f}</th>`);
    html += `</tr></thead><tbody>`;
    records.forEach(r => {
        html += `<tr>`;
        fields.forEach(f => html += `<td>${r[f] !== undefined ? r[f] : ''}</td>`);
        html += `</tr>`;
    });
    html += `</tbody></table><script>window.onload=function(){window.print();};<\/script></body></html>`;
    printWin.document.open();
    printWin.document.write(html);
    printWin.document.close();
    window.showToast("✓ Printable PDF Dossier generated and print preview opened!");
}
</script>
</body>
</html>
