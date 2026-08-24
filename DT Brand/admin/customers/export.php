<?php
/**
 * export.php — Customer Export Studio (CSV / Excel / PDF)
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
$page_title = "Customer Export Studio";
$active_nav = "customers";
$active_subnav = "export";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/customers/assets/css/customers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/customers/assets/css/customer-list.css?v=<?php echo time(); ?>">
    <style>
        .dt-export-format-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            background: #FFFFFF;
            border: 1.5px solid #EAE5D9;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            user-select: none;
        }
        .dt-export-format-card:hover {
            border-color: #D4AF37;
            background: #FAF8F4;
            transform: translateY(-1px);
        }
        .dt-export-format-card.active {
            border-color: #B8860B;
            background: #FAF5E8;
            box-shadow: 0 4px 12px rgba(184, 134, 11, 0.15);
        }
        .dt-export-format-icon {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1rem;
            font-weight: 900;
        }
        .dt-export-group-box {
            background: #FAF8F4;
            border: 1.2px solid #EAE5D9;
            border-radius: 10px;
            padding: 14px 16px;
        }
        .dt-field-check-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.76rem;
            font-weight: 700;
            color: #181512;
            cursor: pointer;
            padding: 4px 0;
        }
        .dt-field-check-label input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: #8A681F;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-customers-container" style="display:flex; flex-direction:column; gap:16px;">
                <!-- Page Header -->
                <div class="dt-cust-head">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title">
                            <span>Customer Export Studio</span>
                            <span class="dt-cust-badge gold">Data Reports</span>
                        </h1>
                        <p class="dt-cust-subtitle">Generate custom downloadable CSV spreadsheets, Microsoft Excel workbooks, or formatted PDF dossiers.</p>
                    </div>
                    <div class="dt-cust-actions">
                        <a href="/DT%20Brand/admin/customers/index.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                            <span>All Customers</span>
                        </a>
                        <button type="button" class="dt-btn dt-btn-gold" onclick="triggerQuickCsvDownload()">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Quick CSV Export</span>
                        </button>
                    </div>
                </div>

                <!-- 4-Card Master KPI Ribbon -->
                <div class="dt-cust-kpi-grid" style="grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));">
                    <!-- Card 1: Total Base -->
                    <div class="dt-cust-kpi-card active">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">TOTAL EXPORTABLE BASE</span>
                            <div class="dt-cust-kpi-icon gold">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val" style="color:#8A681F;">4,820</div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta">100% CRM Verified</span>
                            <span style="color:#78716C;">Active Database</span>
                        </div>
                    </div>

                    <!-- Card 2: Attributes -->
                    <div class="dt-cust-kpi-card">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">AVAILABLE ATTRIBUTES</span>
                            <div class="dt-cust-kpi-icon emerald">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val" style="color:#15803D;">18 Fields</div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta">Demographics &amp; Orders</span>
                            <span style="color:#15803D; font-weight:800;">Full Audit</span>
                        </div>
                    </div>

                    <!-- Card 3: Formats -->
                    <div class="dt-cust-kpi-card">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">SUPPORTED FORMATS</span>
                            <div class="dt-cust-kpi-icon purple">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val">3 Formats</div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta">CSV • XLSX • PDF</span>
                            <span style="color:#78716C;">Instant Stream</span>
                        </div>
                    </div>

                    <!-- Card 4: Security -->
                    <div class="dt-cust-kpi-card">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">DATA SECURITY</span>
                            <div class="dt-cust-kpi-icon gold">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val" style="color:#181512; font-size:1.2rem;">Encrypted</div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta">Audit Logged</span>
                            <span style="color:#78716C;">Staff Protected</span>
                        </div>
                    </div>
                </div>

                <!-- Export Wizard Card -->
                <div class="dt-card" style="max-width:920px; width:100%; margin:0 auto; padding:22px 26px;">
                    <div class="dt-card-head" style="margin-bottom:18px; border-bottom:1.2px solid #F1ECE1; padding-bottom:12px;">
                        <div>
                            <h3 class="dt-card-title">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                <span>Configure Customer Export Parameters</span>
                            </h3>
                            <p style="font-size:0.75rem; color:#78716C; margin:3px 0 0 0;">Customize audience segments, export format, and attributes to generate tailored reports.</p>
                        </div>
                    </div>

                    <form id="dtExportForm" onsubmit="handleCustomerExport(event)" style="display:flex; flex-direction:column; gap:20px;">
                        <!-- 1. Select Export Format -->
                        <div>
                            <label style="font-size:0.78rem; font-weight:800; color:#181512; display:block; text-transform:uppercase; letter-spacing:0.03em; margin-bottom:10px;">1. Select Export File Format</label>
                            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:12px;">
                                <!-- CSV -->
                                <div class="dt-export-format-card active" onclick="selectExportFormat('csv', this)">
                                    <input type="radio" name="export_format" value="csv" checked style="display:none;">
                                    <div class="dt-export-format-icon" style="background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37;">
                                        CSV
                                    </div>
                                    <div>
                                        <strong style="font-size:0.85rem; color:#181512; display:block;">CSV Spreadsheet</strong>
                                        <small style="font-size:0.68rem; color:#78716C;">Universal UTF-8 text dataset</small>
                                    </div>
                                </div>

                                <!-- Excel -->
                                <div class="dt-export-format-card" onclick="selectExportFormat('excel', this)">
                                    <input type="radio" name="export_format" value="excel" style="display:none;">
                                    <div class="dt-export-format-icon" style="background:#DCFCE7; color:#15803D; border:1px solid #86EFAC;">
                                        XLS
                                    </div>
                                    <div>
                                        <strong style="font-size:0.85rem; color:#181512; display:block;">Excel Workbook</strong>
                                        <small style="font-size:0.68rem; color:#78716C;">Microsoft .xlsx spreadsheet</small>
                                    </div>
                                </div>

                                <!-- PDF -->
                                <div class="dt-export-format-card" onclick="selectExportFormat('pdf', this)">
                                    <input type="radio" name="export_format" value="pdf" style="display:none;">
                                    <div class="dt-export-format-icon" style="background:#EFF6FF; color:#1D4ED8; border:1px solid #BFDBFE;">
                                        PDF
                                    </div>
                                    <div>
                                        <strong style="font-size:0.85rem; color:#181512; display:block;">Printable PDF</strong>
                                        <small style="font-size:0.68rem; color:#78716C;">Formatted executive dossier</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Audience Scope -->
                        <div>
                            <label style="font-size:0.78rem; font-weight:800; color:#181512; display:block; text-transform:uppercase; letter-spacing:0.03em; margin-bottom:8px;">2. Audience Scope &amp; Target Cohort</label>
                            <select id="dtExportAudienceScope" class="dt-cust-select" style="width:100%; height:40px; font-size:0.82rem; font-weight:700; background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:8px;">
                                <option value="all" selected>All Registered Customers (4,820 Shoppers)</option>
                                <option value="vip">VIP High-Value Spenders (312 Shoppers • LTV ≥ ₹25,000)</option>
                                <option value="frequent">Frequent Repeat Buyers (1,850 Shoppers • Orders ≥ 3)</option>
                                <option value="gujarat">Gujarat &amp; Surat Hub Shoppers (1,240 Shoppers)</option>
                                <option value="nri">International &amp; NRI Global Buyers (486 Shoppers)</option>
                                <option value="wholesale">B2B Wholesale Lot Orderers (748 Shoppers)</option>
                                <option value="dormant">Dormant Shoppers &gt; 60 Days (640 Shoppers)</option>
                            </select>
                        </div>

                        <!-- 3. Fields & Attributes to Include -->
                        <div>
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; flex-wrap:wrap; gap:8px;">
                                <label style="font-size:0.78rem; font-weight:800; color:#181512; text-transform:uppercase; letter-spacing:0.03em; margin:0;">3. Data Fields &amp; Attributes to Include</label>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="padding:2px 8px; font-size:0.68rem;" onclick="toggleAllFields(true)">Select All</button>
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="padding:2px 8px; font-size:0.68rem;" onclick="toggleAllFields(false)">Clear All</button>
                                </div>
                            </div>

                            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:14px;">
                                <!-- Group A: Identity & Contact -->
                                <div class="dt-export-group-box">
                                    <strong style="font-size:0.75rem; color:#8A681F; text-transform:uppercase; display:block; margin-bottom:8px;">👤 Contact &amp; Identity</strong>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="id" checked> Customer ID (CUST-XXXX)</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="name" checked> Full Name</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="phone" checked> WhatsApp / Phone Number</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="email" checked> Email Address</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="tier" checked> Standing Tier (VIP / Regular)</label>
                                </div>

                                <!-- Group B: Commerce & Financials -->
                                <div class="dt-export-group-box">
                                    <strong style="font-size:0.75rem; color:#15803D; text-transform:uppercase; display:block; margin-bottom:8px;">💰 Orders &amp; Financials</strong>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="spend" checked> Lifetime Spend (₹)</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="orders" checked> Total Completed Orders</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="aov" checked> Average Order Value (AOV)</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="last_order" checked> Last Purchase Date</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="joined" checked> Registration Date</label>
                                </div>

                                <!-- Group C: Location & CRM -->
                                <div class="dt-export-group-box">
                                    <strong style="font-size:0.75rem; color:#1D4ED8; text-transform:uppercase; display:block; margin-bottom:8px;">📍 Location &amp; CRM Flags</strong>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="city" checked> City &amp; State</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="country" checked> Country &amp; Dial Code</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="pincode" checked> Postal Pincode</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="tags" checked> Assigned Tags</label>
                                    <label class="dt-field-check-label"><input type="checkbox" name="fields[]" value="status" checked> Account Status (Active / VIP)</label>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Export Summary Bar -->
                        <div style="background:#FAF8F4; border:1.2px solid #EAE5D9; border-radius:10px; padding:12px 16px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
                            <div style="font-size:0.75rem; color:#181512;">
                                <strong>Estimated Output:</strong> <span id="dtExportEstimate">CSV File (~340 KB) • 4,820 Records</span>
                            </div>
                            <span class="dt-cust-badge emerald" style="font-size:0.65rem;">● Server Memory Stream Ready</span>
                        </div>

                        <!-- 5. Form Actions -->
                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:10px; border-top:1.5px solid #F1ECE1; padding-top:16px;">
                            <a href="/DT%20Brand/admin/customers/index.php" class="dt-btn dt-btn-pale">Cancel</a>
                            <button type="submit" class="dt-btn dt-btn-gold" style="display:inline-flex; align-items:center; gap:8px; padding:0 22px; height:40px;">
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

<script src="/DT%20Brand/admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
<script>
let currentFormat = 'csv';

// Mock Customer Master Database
const mockCustomers = [
    { id: "CUST-1042", name: "Ramesh Patel", phone: "+91 98251 44321", email: "ramesh.patel@gmail.com", tier: "VIP Champion", spend: 48500, orders: 6, aov: 8083, last_order: "2026-08-20", joined: "2025-11-12", city: "Surat", state: "Gujarat", country: "India (+91)", pincode: "395002", tags: "Frequent Buyer; Surat Hub", status: "Active" },
    { id: "CUST-1041", name: "Priya Sharma", phone: "+91 98765 43210", email: "priya.s@yahoo.com", tier: "Active Shopper", spend: 32400, orders: 4, aov: 8100, last_order: "2026-08-18", joined: "2025-12-05", city: "Ahmedabad", state: "Gujarat", country: "India (+91)", pincode: "380001", tags: "Saree Enthusiast", status: "Active" },
    { id: "CUST-1040", name: "Ananya Verma", phone: "+91 91234 56789", email: "ananya.v@outlook.com", tier: "Active Shopper", spend: 24800, orders: 3, aov: 8266, last_order: "2026-08-15", joined: "2026-01-10", city: "Mumbai", state: "Maharashtra", country: "India (+91)", pincode: "400001", tags: "Bridal Lehenga", status: "Active" },
    { id: "CUST-1039", name: "Suresh Mehta", phone: "+91 94280 11223", email: "suresh.m@gmail.com", tier: "VIP Champion", spend: 64200, orders: 8, aov: 8025, last_order: "2026-08-14", joined: "2025-11-20", city: "Rajkot", state: "Gujarat", country: "India (+91)", pincode: "360001", tags: "B2B Wholesale Buyer", status: "Active" },
    { id: "CUST-1038", name: "Meera Joshi", phone: "+91 98980 99887", email: "meera.j@gmail.com", tier: "Active Shopper", spend: 12600, orders: 2, aov: 6300, last_order: "2026-08-10", joined: "2026-02-14", city: "Vadodara", state: "Gujarat", country: "India (+91)", pincode: "390001", tags: "Festive Silk Seeker", status: "Active" },
    { id: "CUST-1037", name: "Rajesh Gupta", phone: "+91 98111 22334", email: "rajesh.g@rediffmail.com", tier: "Active Shopper", spend: 18900, orders: 3, aov: 6300, last_order: "2026-08-05", joined: "2026-02-28", city: "Delhi", state: "Delhi", country: "India (+91)", pincode: "110001", tags: "COD Verified", status: "Active" },
    { id: "CUST-1036", name: "Kavita Singhania", phone: "+91 98200 44556", email: "kavita.s@gmail.com", tier: "VIP Champion", spend: 85000, orders: 12, aov: 7083, last_order: "2026-08-01", joined: "2025-11-01", city: "Jaipur", state: "Rajasthan", country: "India (+91)", pincode: "302001", tags: "High-Value VIP; Saree Enthusiast", status: "Active" },
    { id: "CUST-1035", name: "Vikram Malhotra", phone: "+44 7911 123456", email: "vikram.m@ukexport.com", tier: "VIP Champion", spend: 96000, orders: 5, aov: 19200, last_order: "2026-07-28", joined: "2025-12-18", city: "London", state: "Greater London", country: "United Kingdom (+44)", pincode: "SW1A 1AA", tags: "NRI Global Exporter", status: "Active" }
];

function selectExportFormat(fmt, el) {
    currentFormat = fmt;
    document.querySelectorAll('.dt-export-format-card').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
    const radio = el.querySelector('input[type="radio"]');
    if (radio) radio.checked = true;

    const est = document.getElementById('dtExportEstimate');
    if (est) {
        if (fmt === 'csv') est.innerText = 'CSV Spreadsheet (~340 KB) • 4,820 Records';
        else if (fmt === 'excel') est.innerText = 'Excel XLSX Workbook (~820 KB) • 4,820 Records';
        else if (fmt === 'pdf') est.innerText = 'Printable PDF Dossier (~2.4 MB) • 4,820 Records';
    }
}

function toggleAllFields(check) {
    document.querySelectorAll('input[name="fields[]"]').forEach(cb => cb.checked = check);
}

function getSelectedFields() {
    const checked = [];
    document.querySelectorAll('input[name="fields[]"]:checked').forEach(cb => checked.push(cb.value));
    return checked.length ? checked : ['id', 'name', 'phone', 'email', 'spend', 'orders', 'city', 'tags'];
}

function filterCustomersByScope(scope) {
    if (scope === 'vip') return mockCustomers.filter(c => c.tier === 'VIP Champion' || c.spend >= 25000);
    if (scope === 'frequent') return mockCustomers.filter(c => c.orders >= 3);
    if (scope === 'gujarat') return mockCustomers.filter(c => c.state === 'Gujarat');
    if (scope === 'nri') return mockCustomers.filter(c => c.country !== 'India (+91)');
    if (scope === 'wholesale') return mockCustomers.filter(c => c.tags.includes('Wholesale') || c.spend >= 50000);
    if (scope === 'dormant') return mockCustomers.filter(c => c.status === 'Inactive');
    return mockCustomers;
}

function handleCustomerExport(e) {
    if (e) e.preventDefault();
    const scope = document.getElementById('dtExportAudienceScope').value;
    const selectedFields = getSelectedFields();
    const records = filterCustomersByScope(scope);

    window.showToast(`⏳ Generating ${currentFormat.toUpperCase()} file for "${scope}" cohort...`);

    setTimeout(() => {
        if (currentFormat === 'csv') {
            downloadCsvFile(records, selectedFields);
        } else if (currentFormat === 'excel') {
            downloadExcelFile(records, selectedFields);
        } else if (currentFormat === 'pdf') {
            generatePdfDossier(records, selectedFields);
        }
    }, 600);
}

function triggerQuickCsvDownload() {
    currentFormat = 'csv';
    handleCustomerExport();
}

// ── 1. CSV Generator ──
function downloadCsvFile(records, fields) {
    const fieldMap = {
        id: "Customer ID", name: "Full Name", phone: "Phone Number", email: "Email Address",
        tier: "Standing Tier", spend: "Lifetime Spend (INR)", orders: "Total Orders",
        aov: "Average Order Value (INR)", last_order: "Last Purchase Date", joined: "Joined Date",
        city: "City", state: "State", country: "Country", pincode: "Postal Code",
        tags: "Assigned Tags", status: "Account Status"
    };

    const headers = fields.map(f => `"${fieldMap[f] || f}"`).join(",");
    const rows = records.map(r => {
        return fields.map(f => `"${(r[f] !== undefined ? r[f] : '').toString().replace(/"/g, '""')}"`).join(",");
    });

    const csvData = "\uFEFF" + headers + "\n" + rows.join("\n");
    const blob = new Blob([csvData], { type: "text/csv;charset=utf-8;" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = `DT_Brands_Customers_Export_${new Date().toISOString().slice(0, 10)}.csv`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    window.showToast("✓ CSV Export complete! File downloaded successfully.");
}

// ── 2. Excel Workbook (.xls XML/HTML) Generator ──
function downloadExcelFile(records, fields) {
    const fieldMap = {
        id: "Customer ID", name: "Full Name", phone: "Phone Number", email: "Email Address",
        tier: "Standing Tier", spend: "Lifetime Spend (₹)", orders: "Total Orders",
        aov: "AOV (₹)", last_order: "Last Purchase Date", joined: "Joined Date",
        city: "City", state: "State", country: "Country", pincode: "Postal Code",
        tags: "Assigned Tags", status: "Account Status"
    };

    let tableHtml = `<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
    <head><meta charset="utf-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Customers</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->
    <style>
        th { background-color: #B8860B; color: #FFFFFF; font-weight: bold; padding: 10px; border: 1px solid #8A681F; }
        td { padding: 8px; border: 1px solid #EAE5D9; font-family: 'Segoe UI', Arial, sans-serif; font-size: 11pt; }
        .currency { color: #8A681F; font-weight: bold; }
        .vip { background-color: #FAF5E8; color: #8A681F; font-weight: bold; }
    </style></head><body>
    <h2>DT Brand's & Jai Hanuman Tex — Customer Master Report</h2>
    <p>Generated on: ${new Date().toLocaleString()} | Total Records: ${records.length}</p>
    <table><thead><tr>`;

    fields.forEach(f => {
        tableHtml += `<th>${fieldMap[f] || f}</th>`;
    });
    tableHtml += `</tr></thead><tbody>`;

    records.forEach(r => {
        tableHtml += `<tr>`;
        fields.forEach(f => {
            let val = r[f] !== undefined ? r[f] : '';
            if (f === 'spend' || f === 'aov') {
                tableHtml += `<td class="currency">₹${Number(val).toLocaleString()}</td>`;
            } else if (f === 'tier' && val.includes('VIP')) {
                tableHtml += `<td class="vip">${val}</td>`;
            } else {
                tableHtml += `<td>${val}</td>`;
            }
        });
        tableHtml += `</tr>`;
    });

    tableHtml += `</tbody></table></body></html>`;

    const blob = new Blob([tableHtml], { type: "application/vnd.ms-excel;charset=utf-8" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = `DT_Brands_Customers_Report_${new Date().toISOString().slice(0, 10)}.xls`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    window.showToast("✓ Excel Workbook downloaded successfully!");
}

// ── 3. Printable PDF Dossier Generator ──
function generatePdfDossier(records, fields) {
    const fieldMap = {
        id: "Customer ID", name: "Full Name", phone: "Phone Number", email: "Email",
        tier: "Tier", spend: "LTV (₹)", orders: "Orders", aov: "AOV",
        city: "City", state: "State", tags: "Tags", status: "Status"
    };

    const printWin = window.open('', '_blank', 'width=900,height=700');
    if (!printWin) {
        window.showToast('⚠️ Popups blocked. Please allow popups for PDF printing.');
        return;
    }

    let printHtml = `<!DOCTYPE html>
    <html>
    <head>
        <title>DT Brand's — Customer Dossier Report</title>
        <style>
            body { font-family: 'Plus Jakarta Sans', Arial, sans-serif; padding: 24px; color: #181512; }
            .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #8A681F; padding-bottom: 14px; margin-bottom: 20px; }
            .logo { font-size: 20px; font-weight: 900; color: #8A681F; }
            .meta { font-size: 11px; color: #78716C; text-align: right; }
            .kpi-strip { display: flex; gap: 12px; margin-bottom: 20px; }
            .kpi-box { flex: 1; padding: 10px; border: 1px solid #EAE5D9; border-radius: 8px; background: #FAF8F4; text-align: center; }
            .kpi-val { font-size: 16px; font-weight: 900; color: #8A681F; }
            .kpi-lbl { font-size: 9px; font-weight: 800; color: #78716C; text-transform: uppercase; }
            table { width: 100%; border-collapse: collapse; font-size: 11px; }
            th { background: #FAF5E8; color: #8A681F; text-align: left; padding: 8px; border-bottom: 1.5px solid #D4AF37; font-weight: 800; }
            td { padding: 8px; border-bottom: 1px solid #F1ECE1; }
            .vip-pill { display: inline-block; padding: 2px 6px; border-radius: 10px; background: #FAF5E8; color: #8A681F; font-weight: bold; border: 1px solid #D4AF37; font-size: 9px; }
            @media print {
                body { padding: 0; }
                @page { size: landscape; margin: 12mm; }
            }
        </style>
    </head>
    <body>
        <div class="header">
            <div>
                <div class="logo">👑 DT BRAND'S &amp; JAI HANUMAN TEX</div>
                <div style="font-size:12px; font-weight:700; color:#181512; margin-top:2px;">Official Customer Executive Dossier</div>
            </div>
            <div class="meta">
                <div><strong>Export Date:</strong> ${new Date().toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' })}</div>
                <div><strong>Records Exported:</strong> ${records.length} Shoppers</div>
            </div>
        </div>

        <div class="kpi-strip">
            <div class="kpi-box">
                <div class="kpi-val">${records.length}</div>
                <div class="kpi-lbl">Target Shoppers</div>
            </div>
            <div class="kpi-box">
                <div class="kpi-val">₹${records.reduce((acc, r) => acc + (r.spend || 0), 0).toLocaleString()}</div>
                <div class="kpi-lbl">Aggregate LTV</div>
            </div>
            <div class="kpi-box">
                <div class="kpi-val">${records.reduce((acc, r) => acc + (r.orders || 0), 0)}</div>
                <div class="kpi-lbl">Total Completed Orders</div>
            </div>
            <div class="kpi-box">
                <div class="kpi-val">100%</div>
                <div class="kpi-lbl">CRM Verified</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>`;

    fields.forEach(f => {
        printHtml += `<th>${fieldMap[f] || f}</th>`;
    });
    printHtml += `</tr></thead><tbody>`;

    records.forEach(r => {
        printHtml += `<tr>`;
        fields.forEach(f => {
            let val = r[f] !== undefined ? r[f] : '';
            if (f === 'spend' || f === 'aov') {
                printHtml += `<td style="font-weight:bold; color:#8A681F;">₹${Number(val).toLocaleString()}</td>`;
            } else if (f === 'tier' && val.includes('VIP')) {
                printHtml += `<td><span class="vip-pill">${val}</span></td>`;
            } else {
                printHtml += `<td>${val}</td>`;
            }
        });
        printHtml += `</tr>`;
    });

    printHtml += `</tbody></table>
        <div style="margin-top:24px; font-size:10px; color:#78716C; text-align:center; border-top:1px solid #EAE5D9; padding-top:10px;">
            Confidential &amp; Proprietary • DT Brand's &amp; Jai Hanuman Tex Management Suite
        </div>
        <script>
            window.onload = function() {
                window.print();
            };
        <\/script>
    </body>
    </html>`;

    printWin.document.open();
    printWin.document.write(printHtml);
    printWin.document.close();

    window.showToast("✓ Printable PDF Dossier generated and print preview opened!");
}
</script>
</body>
</html>
