<?php
/**
 * export.php — DT Brand's & Jai Hanuman Tex
 * Wholesale Multi-Format Data Exporter (CSV, Excel XLS, Executive PDF Dossier)
 */
$page_title = "Wholesale Data Export Studio";
$active_nav = "wholesalers";
$active_subnav = "export";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wholesale Export Studio - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/wholesale/assets/css/wholesale.css?v=<?php echo time(); ?>">
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

            <div class="dt-wholesale-container">
                <div class="dt-cust-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:4px;">
                    <div>
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0; display:flex; align-items:center; gap:8px;">
                            <span>Wholesale Data Export Studio</span>
                            <span class="dt-cust-badge emerald" style="font-size:0.72rem; padding:3px 8px; border-radius:6px; background:#DCFCE7; color:#15803D; border:1px solid #86EFAC; font-weight:800;">100% Export Ready</span>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Export B2B partner rosters, GSTIN tax details, purchase totals, and revolving credit ledger summaries.</p>
                    </div>
                </div>

                <div class="dt-card" style="padding:22px;">
                    <form onsubmit="handleWholesaleExport(event)" style="display:flex; flex-direction:column; gap:20px;">
                        
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
                            <select id="dtWhlExportScope" class="dt-wholesale-select" style="width:100%; height:40px; font-size:0.82rem; font-weight:700; background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 12px;">
                                <option value="all" selected>All Registered Wholesalers (124 Accounts)</option>
                                <option value="approved">Approved &amp; Active Wholesalers (98 Accounts)</option>
                                <option value="pending">Pending Applications Under Review (14 Accounts)</option>
                                <option value="platinum">Platinum Wholesale VIP Tier Only (28 Accounts)</option>
                                <option value="credit">Wholesalers with Active Revolving Credit (64 Accounts)</option>
                            </select>
                        </div>

                        <!-- 3. Fields to Include -->
                        <div>
                            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px; margin-bottom:10px;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <label style="font-size:0.78rem; font-weight:800; color:#181512; text-transform:uppercase; margin:0;">3. Data Fields &amp; Attributes to Include</label>
                                    <span id="selectedWhlFieldCount" style="font-size:0.7rem; font-weight:800; color:#8A681F; background:#FAF5E8; border:1px solid #D4AF37; padding:2px 8px; border-radius:6px;">14 of 14 Selected</span>
                                </div>
                                <div style="display:flex; gap:6px;">
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="toggleAllWhlFields(true)">Select All</button>
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="toggleAllWhlFields(false)">Clear All</button>
                                </div>
                            </div>

                            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:14px;">
                                <div class="dt-export-group-box">
                                    <strong style="font-size:0.75rem; color:#8A681F; text-transform:uppercase;">👤 Legal Identity &amp; Tax</strong>
                                    <label class="dt-field-check-label"><input type="checkbox" name="whl_fields[]" value="id" checked onchange="updateWhlFieldCount()"> Wholesale ID (WHL-XXXX)</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="whl_fields[]" value="name" checked onchange="updateWhlFieldCount()"> Business / Trade Name</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="whl_fields[]" value="legal_name" checked onchange="updateWhlFieldCount()"> Legal Entity Name</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="whl_fields[]" value="gstin" checked onchange="updateWhlFieldCount()"> GSTIN Tax Number</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="whl_fields[]" value="contact" checked onchange="updateWhlFieldCount()"> Contact Person</label>
                                </div>

                                <div class="dt-export-group-box">
                                    <strong style="font-size:0.75rem; color:#15803D; text-transform:uppercase;">💰 Commercial &amp; Credit</strong>
                                    <label class="dt-field-check-label"><input type="checkbox" name="whl_fields[]" value="tier" checked onchange="updateWhlFieldCount()"> Wholesale Tier</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="whl_fields[]" value="orders" checked onchange="updateWhlFieldCount()"> Total Sourced Orders</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="whl_fields[]" value="purchase" checked onchange="updateWhlFieldCount()"> Total Purchase GMV (₹)</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="whl_fields[]" value="credit" checked onchange="updateWhlFieldCount()"> Utilized Credit (₹)</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="whl_fields[]" value="credit_limit" checked onchange="updateWhlFieldCount()"> Sanctioned Credit Limit (₹)</label>
                                </div>

                                <div class="dt-export-group-box">
                                    <strong style="font-size:0.75rem; color:#1D4ED8; text-transform:uppercase;">📍 Contact &amp; Compliance</strong>
                                    <label class="dt-field-check-label"><input type="checkbox" name="whl_fields[]" value="city" checked onchange="updateWhlFieldCount()"> City &amp; State</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="whl_fields[]" value="phone" checked onchange="updateWhlFieldCount()"> Phone / WhatsApp</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="whl_fields[]" value="kyc" checked onchange="updateWhlFieldCount()"> KYC Status</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="whl_fields[]" value="status" checked onchange="updateWhlFieldCount()"> Account Standing</label>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:10px; border-top:1.5px solid #F1ECE1; padding-top:16px;">
                            <a href="/Frontend/Admin/wholesale/index.php" class="dt-btn dt-btn-pale">Cancel</a>
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

<script src="/Frontend/Admin/wholesale/assets/js/wholesale.js?v=<?php echo time(); ?>"></script>
<script>
let currentWhlFormat = 'csv';

const mockWholesaleDataset = [
    { id: "WHL-8012", name: "Shree Balaji Textile Emporium", legal_name: "Shree Balaji Silk Mills Pvt Ltd", gstin: "24AAAPL1234F1Z8", contact: "Rameshwar Agarwal", phone: "+91 98251 44321", tier: "Platinum Wholesale", orders: 64, purchase: 2450000, credit: 210000, credit_limit: 500000, city: "Surat, Gujarat", kyc: "Verified", status: "Active" },
    { id: "WHL-8013", name: "Varanasi Weaves & Silks Syndicate", legal_name: "Varanasi Weaves Wholesale Hub LLP", gstin: "09AAACV5678B1Z2", contact: "Mukesh Chourasia", phone: "+91 98765 88990", tier: "Platinum Wholesale", orders: 48, purchase: 1890000, credit: 120000, credit_limit: 300000, city: "Varanasi, UP", kyc: "Verified", status: "Active" },
    { id: "WHL-8014", name: "Jaipur Royal Saree Distributors", legal_name: "Royal Saree Hub Rajasthan", gstin: "08AAACR9012D1Z5", contact: "Dinesh Shekhawat", phone: "+91 94280 22334", tier: "Gold Distributor", orders: 36, purchase: 1240000, credit: 120000, credit_limit: 200000, city: "Jaipur, Rajasthan", kyc: "Verified", status: "Active" },
    { id: "WHL-8015", name: "Kanchipuram Silk Stockists", legal_name: "Kanchi Handloom Stockists Ltd", gstin: "33AAACK3456E1Z9", contact: "S. Rajagopalan", phone: "+91 91234 55667", tier: "Silver Bulk Partner", orders: 18, purchase: 680000, credit: 0, credit_limit: 50000, city: "Chennai, Tamil Nadu", kyc: "Verified", status: "Active" },
    { id: "WHL-8016", name: "Mahalaxmi Silk House Rajkot", legal_name: "Mahalaxmi Enterprise", gstin: "24AAAPM7890H1Z1", contact: "Pravin Solanki", phone: "+91 98980 11223", tier: "Bronze Starter", orders: 0, purchase: 0, credit: 0, credit_limit: 0, city: "Rajkot, Gujarat", kyc: "Pending Review", status: "Pending" },
    { id: "WHL-8017", name: "Kolkata Saree Emporium Hub", legal_name: "Kolkata Silk Syndicate", gstin: "19AAACK1122F1Z3", contact: "Subhashish Ghosh", phone: "+91 98310 99887", tier: "Silver Bulk Partner", orders: 12, purchase: 450000, credit: 100000, credit_limit: 100000, city: "Kolkata, West Bengal", kyc: "Verified", status: "Suspended" }
];

function selectExportFormat(fmt, el) {
    currentWhlFormat = fmt;
    document.querySelectorAll('.dt-export-format-card').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
    const radio = el.querySelector('input[type="radio"]');
    if (radio) radio.checked = true;
}

function updateWhlFieldCount() {
    const total = document.querySelectorAll('input[name="whl_fields[]"]').length;
    const checked = document.querySelectorAll('input[name="whl_fields[]"]:checked').length;
    const countEl = document.getElementById('selectedWhlFieldCount');
    if (countEl) countEl.innerText = `${checked} of ${total} Selected`;
}

function toggleAllWhlFields(check) {
    document.querySelectorAll('input[name="whl_fields[]"]').forEach(cb => cb.checked = check);
    updateWhlFieldCount();
}

function getSelectedWhlFields() {
    const checked = [];
    document.querySelectorAll('input[name="whl_fields[]"]:checked').forEach(cb => checked.push(cb.value));
    return checked.length ? checked : ['id', 'name', 'gstin', 'contact', 'phone', 'tier', 'purchase', 'credit', 'status'];
}

function handleWholesaleExport(e) {
    if (e) e.preventDefault();
    const scope = document.getElementById('dtWhlExportScope').value;
    const selectedFields = getSelectedWhlFields();

    let records = mockWholesaleDataset;
    if (scope === 'approved') records = mockWholesaleDataset.filter(r => r.status === 'Active');
    else if (scope === 'pending') records = mockWholesaleDataset.filter(r => r.status === 'Pending');
    else if (scope === 'platinum') records = mockWholesaleDataset.filter(r => r.tier.includes('Platinum'));
    else if (scope === 'credit') records = mockWholesaleDataset.filter(r => r.credit > 0);

    const todayStr = new Date().toISOString().slice(0, 10);

    if (window.showToast) {
        window.showToast(`⏳ Generating ${currentWhlFormat.toUpperCase()} file for "${scope}" cohort...`);
    }

    setTimeout(() => {
        if (currentWhlFormat === 'csv') downloadWhlCsv(records, selectedFields, todayStr);
        else if (currentWhlFormat === 'excel') downloadWhlExcel(records, selectedFields, todayStr);
        else if (currentWhlFormat === 'pdf') downloadWhlPdfDossier(records, selectedFields, todayStr);
    }, 400);
}

function downloadWhlCsv(records, fields, dateStr) {
    const fieldMap = { id: "Wholesale ID", name: "Trade Name", legal_name: "Legal Entity", gstin: "GSTIN", contact: "Contact Person", phone: "Phone", tier: "Tier", orders: "Orders", purchase: "GMV Purchase (INR)", credit: "Used Credit (INR)", credit_limit: "Credit Limit (INR)", city: "City", kyc: "KYC Status", status: "Account Status" };
    const headers = fields.map(f => `"${fieldMap[f] || f}"`).join(",");
    const rows = records.map(r => fields.map(f => `"${(r[f] !== undefined ? r[f] : '').toString().replace(/"/g, '""')}"`).join(","));
    const csvData = "\uFEFF" + headers + "\n" + rows.join("\n");
    const blob = new Blob([csvData], { type: "text/csv;charset=utf-8;" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = `DT_Brands_Wholesale_Master_Export_${dateStr}.csv`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    if (window.showToast) window.showToast("✅ CSV Export complete! File downloaded.");
}

function downloadWhlExcel(records, fields, dateStr) {
    const fieldMap = { id: "Wholesale ID", name: "Trade Name", legal_name: "Legal Entity", gstin: "GSTIN", contact: "Contact Person", phone: "Phone", tier: "Tier", orders: "Orders", purchase: "GMV (₹)", credit: "Credit (₹)", credit_limit: "Limit (₹)", city: "City", kyc: "KYC", status: "Status" };
    let tableHtml = `<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta charset="utf-8"><style>th{background-color:#B8860B;color:#FFFFFF;font-weight:bold;padding:8px;border:1px solid #8A681F;}td{padding:6px;border:1px solid #EAE5D9;font-family:'Segoe UI',sans-serif;}</style></head><body><h2>DT Brand's & Jai Hanuman Tex — Wholesale Master Report</h2><table><thead><tr>`;
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
    link.download = `DT_Brands_Wholesale_Master_Export_${dateStr}.xls`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    if (window.showToast) window.showToast("✅ Excel Workbook downloaded successfully!");
}

function downloadWhlPdfDossier(records, fields, dateStr) {
    const fieldMap = { id: "Wholesale ID", name: "Trade Name", legal_name: "Legal Entity", gstin: "GSTIN", contact: "Contact", phone: "Phone", tier: "Tier", orders: "Orders", purchase: "GMV (₹)", credit: "Credit (₹)", credit_limit: "Limit (₹)", city: "City", kyc: "KYC", status: "Status" };

    const dossierContainer = document.createElement('div');
    dossierContainer.id = 'dtWhlDossierPdfRender';
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
                <h2 style="font-size:18px; margin:2px 0 0 0; font-weight:900;">Wholesale Corporate Master Dossier</h2>
                <small style="font-size:10px; color:#F5ECCE;">Export Date: ${dateStr} • Total Accounts Exported: ${records.length}</small>
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
            <span>🔒 Confidential Wholesale Corporate Dossier • ISO 9001:2015</span>
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
            pdf.save(`DT_Brands_Wholesale_Master_Export_${dateStr}.pdf`);
            if (window.showToast) window.showToast("✅ Wholesale PDF Dossier downloaded successfully!");
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
