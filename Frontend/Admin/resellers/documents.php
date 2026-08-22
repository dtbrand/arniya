<?php
/**
 * documents.php — DT Brand's & Jai Hanuman Tex
 * Reseller Document Vault
 */
$page_title = "Reseller Document Vault";
$active_nav = "resellers";
$active_subnav = "documents";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Vault - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/resellers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/reseller-documents.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/reseller-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 18px 20px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-customers-container" style="display:flex; flex-direction:column; gap:16px; margin-bottom:24px;">
                <!-- ══ TOP HEADER & BREADCRUMB ══ -->
                <div class="dt-cust-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:4px;">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0; display:flex; align-items:center; gap:8px;">
                            <span>Reseller Document Vault</span>
                            <span class="dt-cust-badge gold" style="font-size:0.72rem; padding:3px 8px; border-radius:6px; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; font-weight:800;">Secure File Storage</span>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Manage GSTIN certificates, Aadhaar identity cards, trade licenses, and bank cheques.</p>
                    </div>
                    <div class="dt-cust-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <a href="/Frontend/Admin/resellers/index.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            <span>Back to Resellers</span>
                        </a>
                        <a href="/Frontend/Admin/resellers/verification.php" class="dt-btn dt-btn-gold">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.3"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            <span>KYC Studio</span>
                        </a>
                    </div>
                </div>

                <!-- ══ 2x2 BALANCED DOCUMENT CARDS COMPONENT ══ -->
                <?php include_once __DIR__ . '/components/reseller-documents.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     INTERACTIVE MODALS FOR DOCUMENT VAULT
══════════════════════════════════════════════════════════════ -->

<!-- 1. Live High-Res Document Preview Modal -->
<div id="dtPreviewDocModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:14px; width:95%; max-width:650px; max-height:90vh; display:flex; flex-direction:column; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                <strong id="previewModalTitle" style="font-size:0.95rem; font-weight:800; color:#181512;">Document Preview</strong>
            </div>
            <button type="button" onclick="closeKycModal('dtPreviewDocModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <div class="dt-modal-body" style="padding:18px; overflow-y:auto; display:flex; flex-direction:column; gap:14px;">
            <div id="previewMockupContainer" style="background:#F4F1EA; border:1.5px solid #D4AF37; border-radius:10px; padding:24px; text-align:center; min-height:220px; display:flex; flex-direction:column; align-items:center; justify-content:center; position:relative;">
                <div style="position:absolute; top:12px; right:12px;">
                    <span class="dt-reseller-badge emerald" style="font-size:0.7rem; font-weight:800;">✓ 256-BIT VERIFIED</span>
                </div>
                <div style="width:64px; height:64px; border-radius:12px; background:#FAF5E8; border:2px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F; margin-bottom:12px;">
                    <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                </div>
                <strong id="previewDocMainTitle" style="font-size:1.05rem; color:#181512; font-weight:900; margin-bottom:4px;">GST Registration Certificate</strong>
                <p id="previewDocIdentifier" style="font-family:monospace; font-size:0.85rem; color:#8A681F; font-weight:800; margin:0 0 10px 0;">24AAAPL1234F1Z8</p>
                <span style="font-size:0.75rem; color:#78716C;">Issued by Govt of India • Verified by Compliance Engine</span>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; font-size:0.78rem;">
                <div style="background:#FAF8F4; padding:10px 12px; border-radius:8px; border:1px solid #EAE5D9;">
                    <span style="color:#78716C; display:block; font-size:0.7rem; font-weight:700;">DIGITAL SIGNATURE:</span>
                    <strong style="color:#15803D;">✓ SHA-256 Valid &amp; Authentic</strong>
                </div>
                <div style="background:#FAF8F4; padding:10px 12px; border-radius:8px; border:1px solid #EAE5D9;">
                    <span style="color:#78716C; display:block; font-size:0.7rem; font-weight:700;">AUDIT TIMESTAMP:</span>
                    <strong style="color:#181512;">12 Nov 2025, 14:32 IST</strong>
                </div>
            </div>
        </div>

        <div class="dt-modal-foot" style="padding:14px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="printCurrentDoc()">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                <span>Print Document</span>
            </button>
            <div style="display:flex; align-items:center; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeKycModal('dtPreviewDocModal')">Close</button>
                <button type="button" class="dt-btn dt-btn-gold" onclick="downloadCurrentDoc()">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Download Original</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 2. Document Replacement / Upload Modal -->
<div id="dtReplaceDocModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:14px; width:95%; max-width:520px; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Upload / Replace KYC Certificate</strong>
            </div>
            <button type="button" onclick="closeKycModal('dtReplaceDocModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <form onsubmit="confirmDocReplacement(event)">
            <input type="hidden" id="replaceDocId">
            <div class="dt-modal-body" style="padding:18px; display:flex; flex-direction:column; gap:12px;">
                <div style="background:#FAF8F4; padding:12px 14px; border-radius:8px; border:1px solid #EAE5D9;">
                    <span style="font-size:0.7rem; color:#78716C; font-weight:700;">TARGET DOCUMENT:</span>
                    <strong id="replaceDocTitle" style="font-size:0.95rem; color:#181512; display:block; font-weight:800;">GST Registration Certificate</strong>
                </div>

                <!-- Drag & Drop Zone -->
                <div id="dropZoneDoc" style="border:2px dashed #D4AF37; border-radius:10px; padding:24px 16px; text-align:center; background:#FDFBF7; cursor:pointer;" onclick="document.getElementById('fileDocInput').click()">
                    <input type="file" id="fileDocInput" style="display:none;" accept=".pdf,.jpg,.jpeg,.png" onchange="handleDocFileSelection(this)">
                    <div style="width:40px; height:40px; border-radius:50%; background:#FAF5E8; color:#8A681F; display:inline-flex; align-items:center; justify-content:center; margin-bottom:8px;">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                    </div>
                    <strong id="selectedFileName" style="display:block; font-size:0.85rem; color:#181512; font-weight:800;">Click to browse or drop file here</strong>
                    <small style="color:#78716C; font-size:0.7rem;">Supported formats: PDF, JPG, PNG (Max: 10 MB)</small>
                </div>
            </div>

            <div class="dt-modal-foot" style="padding:14px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:flex-end; gap:8px; background:#FAF8F4;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeKycModal('dtReplaceDocModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Upload &amp; Verify File</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     👑 REAL OFFICIAL FULL-PAGE A4 PRINTABLE CERTIFICATE TEMPLATE (STRICT 1-PAGE)
══════════════════════════════════════════════════════════════ -->
<div id="dtPrintableCertificate" style="display:none;">
    <div class="dt-print-inner" style="border: 2px solid #8A681F; padding: 18px 22px; border-radius: 8px; position: relative; background: #FFFFFF; font-family: 'Inter', 'Plus Jakarta Sans', sans-serif; box-sizing: border-box;">
        
        <!-- Official Header with DT Brand's & Jai Hanuman Tex Branding -->
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #8A681F; padding-bottom: 12px; margin-bottom: 14px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 44px; height: 44px; border-radius: 6px; background: #8A681F; color: #FFFFFF; display: flex; align-items: center; justify-content: center; font-size: 1.35rem; font-weight: 900; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
                    DT
                </div>
                <div>
                    <h2 style="font-size: 1.15rem; font-weight: 900; color: #181512; margin: 0; text-transform: uppercase; letter-spacing: 0.02em;">DT BRAND'S &amp; JAI HANUMAN TEX</h2>
                    <p style="font-size: 0.72rem; color: #5A4210; margin: 2px 0 0 0; font-weight: 700;">Wholesale Textile B2B Network • Surat, Gujarat, India • ISO 9001:2015 Verified</p>
                </div>
            </div>
            <div style="text-align: right;">
                <div style="background: #FAF5E8; border: 1.5px solid #8A681F; color: #8A681F; font-size: 0.7rem; font-weight: 800; padding: 3px 10px; border-radius: 5px; display: inline-block; text-transform: uppercase; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
                    Official KYC Certificate
                </div>
                <div style="font-size: 0.68rem; color: #78716C; margin-top: 3px; font-family: monospace; font-weight: 700;">DOC REF: <span id="printCertDocRef">DOC-401</span></div>
            </div>
        </div>

        <!-- Document Title Banner -->
        <div style="background: #FDFBF7; border: 1.2px solid #EAE5D9; border-radius: 6px; padding: 10px 14px; margin-bottom: 14px; display: flex; justify-content: space-between; align-items: center; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
            <div>
                <span style="font-size: 0.65rem; color: #78716C; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em;">VERIFIED B2B CERTIFICATE:</span>
                <h3 id="printCertDocTitle" style="font-size: 1rem; font-weight: 900; color: #181512; margin: 1px 0 0 0;">GST Registration Certificate (REG-06)</h3>
            </div>
            <div style="background: #DCFCE7; color: #15803D; border: 1.2px solid #86EFAC; font-size: 0.75rem; font-weight: 900; padding: 4px 10px; border-radius: 5px; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
                ✓ 100% VERIFIED &amp; AUTHENTIC
            </div>
        </div>

        <!-- 2-Column Details Table -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
            <!-- Partner Identity Details -->
            <div style="border: 1.2px solid #EAE5D9; border-radius: 6px; padding: 12px;">
                <div style="font-size: 0.72rem; font-weight: 800; color: #8A681F; text-transform: uppercase; margin-bottom: 8px; border-bottom: 1px dashed #E2DFD7; padding-bottom: 4px;">
                    Reseller Business Details
                </div>
                <table style="width: 100%; font-size: 0.75rem; border-collapse: collapse;">
                    <tr>
                        <td style="color: #78716C; padding: 3px 0; font-weight: 600;">Partner Name:</td>
                        <td style="color: #181512; padding: 3px 0; font-weight: 800; text-align: right;" id="printCertPartnerName">Shree Krishna Sarees &amp; Boutique</td>
                    </tr>
                    <tr>
                        <td style="color: #78716C; padding: 3px 0; font-weight: 600;">Reseller ID:</td>
                        <td style="color: #8A681F; padding: 3px 0; font-weight: 800; font-family: monospace; text-align: right;">RES-1048</td>
                    </tr>
                    <tr>
                        <td style="color: #78716C; padding: 3px 0; font-weight: 600;">Proprietor / Contact:</td>
                        <td style="color: #181512; padding: 3px 0; font-weight: 700; text-align: right;">Rameshwar Vyas</td>
                    </tr>
                    <tr>
                        <td style="color: #78716C; padding: 3px 0; font-weight: 600;">Registered City / Hub:</td>
                        <td style="color: #181512; padding: 3px 0; font-weight: 700; text-align: right;">Surat, Gujarat</td>
                    </tr>
                </table>
            </div>

            <!-- Verification & Compliance Audit -->
            <div style="border: 1.2px solid #EAE5D9; border-radius: 6px; padding: 12px;">
                <div style="font-size: 0.72rem; font-weight: 800; color: #8A681F; text-transform: uppercase; margin-bottom: 8px; border-bottom: 1px dashed #E2DFD7; padding-bottom: 4px;">
                    Compliance &amp; Verification Audit
                </div>
                <table style="width: 100%; font-size: 0.75rem; border-collapse: collapse;">
                    <tr>
                        <td style="color: #78716C; padding: 3px 0; font-weight: 600;">Govt Reference No:</td>
                        <td style="color: #181512; padding: 3px 0; font-weight: 800; font-family: monospace; text-align: right;" id="printCertGovtRef">24AAAPL1234F1Z8</td>
                    </tr>
                    <tr>
                        <td style="color: #78716C; padding: 3px 0; font-weight: 600;">Digital SHA-256 Hash:</td>
                        <td style="color: #15803D; padding: 3px 0; font-weight: 800; font-family: monospace; font-size: 0.68rem; text-align: right;">a94f8e31c79802d</td>
                    </tr>
                    <tr>
                        <td style="color: #78716C; padding: 3px 0; font-weight: 600;">Verified By Officer:</td>
                        <td style="color: #181512; padding: 3px 0; font-weight: 700; text-align: right;">Gautam Sethi (Chief Compliance)</td>
                    </tr>
                    <tr>
                        <td style="color: #78716C; padding: 3px 0; font-weight: 600;">Verification Date:</td>
                        <td style="color: #181512; padding: 3px 0; font-weight: 700; text-align: right;" id="printCertDate">12 Nov 2025</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Official Sign-off & Stamp Section -->
        <div style="display: flex; justify-content: space-between; align-items: flex-end; border-top: 1.2px dashed #D4AF37; padding-top: 12px; margin-top: 14px;">
            <div>
                <div style="font-size: 0.68rem; color: #78716C; font-weight: 600; line-height: 1.4; max-width: 340px;">
                    This certificate is an official verification record generated by DT Brand's &amp; Jai Hanuman Tex B2B Compliance Engine. Valid for authorized reseller procurement, revolving credit, and wholesale catalog distribution.
                </div>
            </div>
            <div style="text-align: center;">
                <div style="width: 68px; height: 68px; border: 2px solid #8A681F; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #8A681F; font-size: 0.55rem; font-weight: 900; text-transform: uppercase; margin: 0 auto 4px auto; transform: rotate(-8deg); -webkit-print-color-adjust: exact; print-color-adjust: exact;">
                    <span>★ VERIFIED ★</span>
                    <span style="font-size: 0.72rem; color: #15803D; font-weight: 900;">APPROVED</span>
                    <span>DT BRAND'S</span>
                </div>
                <div style="font-size: 0.74rem; font-weight: 800; color: #181512;">Authorized Compliance Signatory</div>
                <div style="font-size: 0.65rem; color: #78716C;">Surat Hub HQ, Gujarat</div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="/Frontend/Admin/resellers/assets/js/resellers.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/resellers/assets/js/reseller-documents.js?v=<?php echo time(); ?>"></script>
</body>
</html>
