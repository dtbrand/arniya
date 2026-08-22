<?php
/**
 * verification.php — DT Brand's & Jai Hanuman Tex
 * Reseller KYC & Verification Studio
 */
$page_title = "Reseller KYC & Verification Studio";
$active_nav = "resellers";
$active_subnav = "verification";

$reseller = [
    'id' => 'RES-1048',
    'name' => 'Shree Krishna Sarees & Boutique',
    'contact' => 'Rameshwar Vyas',
    'phone' => '+91 98251 44321',
    'city' => 'Surat, Gujarat',
    'tier' => 'Platinum Elite',
    'status' => 'Active',
    'kyc_status' => 'Verified (4/4 Completed)'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KYC &amp; Verification - DT Brand's Admin</title>
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
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-customers-container" style="display:flex; flex-direction:column; gap:16px; margin-bottom:24px;">
                <!-- ══ TOP BREADCRUMB & HEADER ══ -->
                <div class="dt-cust-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0; display:flex; align-items:center; gap:8px;">
                            <span>Reseller KYC &amp; Verification Studio</span>
                            <span class="dt-cust-badge emerald" style="font-size:0.72rem; padding:3px 8px; border-radius:6px; background:#DCFCE7; color:#15803D; border:1px solid #86EFAC; font-weight:800;">100% Compliance</span>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Inspect Aadhaar, GSTIN certificates, and physical shop verifications for all B2B partners.</p>
                    </div>
                    <div class="dt-cust-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <a href="/Frontend/Admin/resellers/index.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            <span>Back to Resellers Directory</span>
                        </a>
                        <a href="https://wa.me/919825144321?text=Namaste%20Rameshwar%20ji,%20your%20KYC%20verification%20is%20100%%20approved%20at%20DT%20Brand's!" target="_blank" class="dt-btn dt-btn-emerald">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="#FFFFFF"><path d="M17.472 14.382c-.301-.15-1.781-.878-2.057-.978-.276-.1-.476-.15-.676.15-.2.3-.776.978-.952 1.178-.175.2-.351.225-.652.075-.301-.15-1.27-.468-2.42-1.493-.895-.798-1.5-1.784-1.676-2.084-.175-.3-.019-.462.132-.612.136-.135.301-.35.452-.525.15-.175.2-.3.301-.5.101-.2.05-.375-.025-.525-.075-.15-.676-1.63-.927-2.234-.244-.588-.492-.508-.676-.518l-.576-.01c-.2 0-.526.075-.802.375-.276.3-1.053 1.029-1.053 2.508s1.078 2.906 1.228 3.106c.15.2 2.122 3.24 5.141 4.544.718.31 1.279.496 1.716.635.722.23 1.378.197 1.897.12.578-.087 1.781-.728 2.032-1.431.25-.703.25-1.305.175-1.43-.075-.126-.276-.201-.577-.351zM12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.978-1.406C8.423 21.498 10.155 22 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"></path></svg>
                            <span>WhatsApp Partner</span>
                        </a>
                        <a href="/Frontend/Admin/resellers/documents.php" class="dt-btn dt-btn-gold">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                            <span>Document Vault</span>
                        </a>
                    </div>
                </div>

                <!-- ══ PARTNER SUMMARY HERO RIBBON ══ -->
                <div class="dt-hero-luxury-card" style="padding:16px 20px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:14px;">
                    <div style="display:flex; align-items:center; gap:14px;">
                        <div style="width:48px; height:48px; border-radius:10px; background:linear-gradient(135deg, #FFE57F, #D4AF37); color:#111827; font-weight:900; font-size:1.25rem; display:flex; align-items:center; justify-content:center; border:2px solid #FFFFFF; box-shadow:0 4px 12px rgba(0,0,0,0.35);">
                            S
                        </div>
                        <div>
                            <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                                <strong style="font-size:1.15rem; color:#FFFFFF; font-weight:900; text-shadow:0 2px 4px rgba(0,0,0,0.8);"><?php echo $reseller['name']; ?></strong>
                                <span class="dt-tier-badge gold-tier" style="font-size:0.68rem; padding:2px 7px;">★ <?php echo $reseller['tier']; ?></span>
                                <span class="dt-reseller-badge emerald" style="font-size:0.68rem;">● <?php echo $reseller['status']; ?></span>
                            </div>
                            <div style="font-size:0.75rem; color:#FEE685; font-weight:700; margin-top:2px;">
                                Partner ID: #<?php echo $reseller['id']; ?> • Contact: <?php echo $reseller['contact']; ?> (<?php echo $reseller['phone']; ?>) • Location: <?php echo $reseller['city']; ?>
                            </div>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div style="text-align:right;">
                            <span style="font-size:0.65rem; color:#F5ECCE; text-transform:uppercase; font-weight:800; display:block;">Overall Compliance</span>
                            <strong style="font-size:1.1rem; color:#34D399; font-weight:900;">100% (4/4 Complete)</strong>
                        </div>
                        <button type="button" class="dt-btn dt-btn-gold" style="font-weight:800; height:34px;" onclick="downloadFullDossierPdf()">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Download Full Dossier</span>
                        </button>
                    </div>
                </div>

                <!-- ══ 4-STAGE ONBOARDING VERIFICATION AUDIT ══ -->
                <?php include_once __DIR__ . '/components/reseller-verification.php'; ?>

                <!-- ══ DOCUMENT VAULT CARDS ══ -->
                <?php include_once __DIR__ . '/components/reseller-documents.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     INTERACTIVE MODALS FOR NEXT-LEVEL VERIFICATION
══════════════════════════════════════════════════════════════ -->

<!-- 1. Live Document Preview Modal -->
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

<!-- 2. Re-Audit Stage Modal -->
<div id="dtAuditStageModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:14px; width:95%; max-width:520px; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#15803D" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Re-Verify KYC Stage</strong>
            </div>
            <button type="button" onclick="closeKycModal('dtAuditStageModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <form onsubmit="confirmStageAudit(event)">
            <input type="hidden" id="auditStageId">
            <div class="dt-modal-body" style="padding:18px; display:flex; flex-direction:column; gap:12px;">
                <div style="background:#FAF8F4; padding:12px 14px; border-radius:8px; border:1px solid #EAE5D9;">
                    <span style="font-size:0.7rem; color:#78716C; font-weight:700;">STAGE UNDER AUDIT:</span>
                    <strong id="auditStageTitle" style="font-size:0.95rem; color:#181512; display:block; font-weight:800;">1. Identity Verification</strong>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Verification Decision *</label>
                    <select id="auditDecisionSelect" class="dt-cust-select" style="width:100%; height:38px; border-radius:8px;">
                        <option value="Verified">✓ Verified &amp; Digitally Signed (Passed)</option>
                        <option value="Pending">● Pending Further Documentation</option>
                        <option value="Under Review">⏱️ Under Ground Review (Hub Hold)</option>
                    </select>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Auditor Remarks / Memo</label>
                    <textarea id="auditRemarksText" class="dt-cust-search-input" rows="3" style="width:100%; height:auto; padding:8px 12px; border-radius:8px;" placeholder="e.g. Cross-verified with GST portal v2.4, matched legal trade name."></textarea>
                </div>
            </div>

            <div class="dt-modal-foot" style="padding:14px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:flex-end; gap:8px; background:#FAF8F4;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeKycModal('dtAuditStageModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Save Audit Decision</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 3. Reject KYC Stage Modal -->
<div id="dtRejectStageModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #DC2626; border-radius:14px; width:95%; max-width:520px; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FEF2F2;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#DC2626" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#991B1B;">Reject KYC Compliance Stage</strong>
            </div>
            <button type="button" onclick="closeKycModal('dtRejectStageModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <form onsubmit="confirmStageRejection(event)">
            <input type="hidden" id="rejectStageId">
            <div class="dt-modal-body" style="padding:18px; display:flex; flex-direction:column; gap:12px;">
                <div style="background:#FAF8F4; padding:12px 14px; border-radius:8px; border:1px solid #EAE5D9;">
                    <span style="font-size:0.7rem; color:#78716C; font-weight:700;">STAGE BEING REJECTED:</span>
                    <strong id="rejectStageTitle" style="font-size:0.95rem; color:#181512; display:block; font-weight:800;">1. Identity Verification</strong>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Select Preset Reason</label>
                    <div style="display:flex; flex-wrap:wrap; gap:6px; margin-bottom:8px;">
                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="setRejectReason('Uploaded photo is blurry / unreadable.')">Blurry Photo</button>
                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="setRejectReason('GSTIN trade name does not match applicant ID.')">Name Mismatch</button>
                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="setRejectReason('Bank penny drop failed / invalid IFSC code.')">Bank IFSC Error</button>
                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="setRejectReason('Physical boutique location could not be verified on ground.')">Location Mismatch</button>
                    </div>
                    <textarea id="rejectReasonText" class="dt-cust-search-input" rows="3" style="width:100%; height:auto; padding:8px 12px; border-radius:8px;" placeholder="Specify detailed rejection reason sent to reseller..."></textarea>
                </div>

                <label style="display:flex; align-items:center; gap:8px; font-size:0.75rem; font-weight:700; color:#181512; cursor:pointer;">
                    <input type="checkbox" id="sendWhatsAppRejectNotice" checked style="accent-color:#15803D;">
                    <span>Send instant WhatsApp notice to partner with re-upload link</span>
                </label>
            </div>

            <div class="dt-modal-foot" style="padding:14px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:flex-end; gap:8px; background:#FAF8F4;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeKycModal('dtRejectStageModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-pale" style="background:#DC2626; color:#FFFFFF; border-color:#B91C1C; font-weight:800;">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#FFFFFF" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    <span>Reject &amp; Notify Partner</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 4. Document Replacement / Upload Modal -->
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
     👑 REAL OFFICIAL FULL-PAGE A4 PRINTABLE CERTIFICATE TEMPLATE
══════════════════════════════════════════════════════════════ -->
<div id="dtPrintableCertificate" style="display:none;">
    <div style="border: 2.5px solid #8A681F; padding: 28px 32px; border-radius: 10px; position: relative; background: #FFFFFF; font-family: 'Inter', 'Plus Jakarta Sans', sans-serif;">
        
        <!-- Official Header with DT Brand's & Jai Hanuman Tex Branding -->
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #8A681F; padding-bottom: 18px; margin-bottom: 22px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 52px; height: 52px; border-radius: 8px; background: #8A681F; color: #FFFFFF; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; font-weight: 900;">
                    DT
                </div>
                <div>
                    <h2 style="font-size: 1.35rem; font-weight: 900; color: #181512; margin: 0; text-transform: uppercase; letter-spacing: 0.02em;">DT BRAND'S &amp; JAI HANUMAN TEX</h2>
                    <p style="font-size: 0.76rem; color: #5A4210; margin: 2px 0 0 0; font-weight: 700;">Wholesale Textile B2B Network • Surat, Gujarat, India • ISO 9001:2015 Verified</p>
                </div>
            </div>
            <div style="text-align: right;">
                <div style="background: #FAF5E8; border: 1.5px solid #8A681F; color: #8A681F; font-size: 0.75rem; font-weight: 800; padding: 5px 12px; border-radius: 6px; display: inline-block; text-transform: uppercase;">
                    Official KYC Certificate
                </div>
                <div style="font-size: 0.72rem; color: #78716C; margin-top: 5px; font-family: monospace; font-weight: 700;">DOC REF: <span id="printCertDocRef">DOC-401</span></div>
            </div>
        </div>

        <!-- Document Title Banner -->
        <div style="background: #FDFBF7; border: 1.5px solid #EAE5D9; border-radius: 8px; padding: 14px 20px; margin-bottom: 22px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span style="font-size: 0.7rem; color: #78716C; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em;">VERIFIED B2B CERTIFICATE:</span>
                <h3 id="printCertDocTitle" style="font-size: 1.15rem; font-weight: 900; color: #181512; margin: 3px 0 0 0;">GST Registration Certificate (REG-06)</h3>
            </div>
            <div style="background: #DCFCE7; color: #15803D; border: 1.5px solid #86EFAC; font-size: 0.82rem; font-weight: 900; padding: 6px 14px; border-radius: 6px;">
                ✓ 100% VERIFIED &amp; AUTHENTIC
            </div>
        </div>

        <!-- 2-Column Details Table -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 24px;">
            <!-- Partner Identity Details -->
            <div style="border: 1.5px solid #EAE5D9; border-radius: 8px; padding: 16px;">
                <div style="font-size: 0.78rem; font-weight: 800; color: #8A681F; text-transform: uppercase; margin-bottom: 12px; border-bottom: 1px dashed #E2DFD7; padding-bottom: 6px;">
                    Reseller Business Details
                </div>
                <table style="width: 100%; font-size: 0.8rem; border-collapse: collapse;">
                    <tr>
                        <td style="color: #78716C; padding: 5px 0; font-weight: 600;">Partner Name:</td>
                        <td style="color: #181512; padding: 5px 0; font-weight: 800; text-align: right;" id="printCertPartnerName">Shree Krishna Sarees &amp; Boutique</td>
                    </tr>
                    <tr>
                        <td style="color: #78716C; padding: 5px 0; font-weight: 600;">Reseller ID:</td>
                        <td style="color: #8A681F; padding: 5px 0; font-weight: 800; font-family: monospace; text-align: right;">RES-1048</td>
                    </tr>
                    <tr>
                        <td style="color: #78716C; padding: 5px 0; font-weight: 600;">Proprietor / Contact:</td>
                        <td style="color: #181512; padding: 5px 0; font-weight: 700; text-align: right;">Rameshwar Vyas</td>
                    </tr>
                    <tr>
                        <td style="color: #78716C; padding: 5px 0; font-weight: 600;">Registered City / Hub:</td>
                        <td style="color: #181512; padding: 5px 0; font-weight: 700; text-align: right;">Surat, Gujarat</td>
                    </tr>
                </table>
            </div>

            <!-- Verification & Compliance Audit -->
            <div style="border: 1.5px solid #EAE5D9; border-radius: 8px; padding: 16px;">
                <div style="font-size: 0.78rem; font-weight: 800; color: #8A681F; text-transform: uppercase; margin-bottom: 12px; border-bottom: 1px dashed #E2DFD7; padding-bottom: 6px;">
                    Compliance &amp; Verification Audit
                </div>
                <table style="width: 100%; font-size: 0.8rem; border-collapse: collapse;">
                    <tr>
                        <td style="color: #78716C; padding: 5px 0; font-weight: 600;">Govt Reference No:</td>
                        <td style="color: #181512; padding: 5px 0; font-weight: 800; font-family: monospace; text-align: right;" id="printCertGovtRef">24AAAPL1234F1Z8</td>
                    </tr>
                    <tr>
                        <td style="color: #78716C; padding: 5px 0; font-weight: 600;">Digital SHA-256 Hash:</td>
                        <td style="color: #15803D; padding: 5px 0; font-weight: 800; font-family: monospace; font-size: 0.72rem; text-align: right;">a94f8e31c79802d</td>
                    </tr>
                    <tr>
                        <td style="color: #78716C; padding: 5px 0; font-weight: 600;">Verified By Officer:</td>
                        <td style="color: #181512; padding: 5px 0; font-weight: 700; text-align: right;">Gautam Sethi (Chief Compliance)</td>
                    </tr>
                    <tr>
                        <td style="color: #78716C; padding: 5px 0; font-weight: 600;">Verification Date:</td>
                        <td style="color: #181512; padding: 5px 0; font-weight: 700; text-align: right;" id="printCertDate">12 Nov 2025</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Official Sign-off & Stamp Section -->
        <div style="display: flex; justify-content: space-between; align-items: flex-end; border-top: 1.5px dashed #D4AF37; padding-top: 20px; margin-top: 24px;">
            <div>
                <div style="font-size: 0.72rem; color: #78716C; font-weight: 600; line-height: 1.5; max-width: 360px;">
                    This certificate is an official verification record generated by DT Brand's &amp; Jai Hanuman Tex B2B Compliance Engine. Valid for authorized reseller procurement, revolving credit, and wholesale catalog distribution.
                </div>
            </div>
            <div style="text-align: center;">
                <div style="width: 86px; height: 86px; border: 2.5px solid #8A681F; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #8A681F; font-size: 0.62rem; font-weight: 900; text-transform: uppercase; margin: 0 auto 6px auto; transform: rotate(-8deg);">
                    <span>★ VERIFIED ★</span>
                    <span style="font-size: 0.8rem; color: #15803D; font-weight: 900;">APPROVED</span>
                    <span>DT BRAND'S</span>
                </div>
                <div style="font-size: 0.78rem; font-weight: 800; color: #181512;">Authorized Compliance Signatory</div>
                <div style="font-size: 0.7rem; color: #78716C;">Surat Hub HQ, Gujarat</div>
            </div>
        </div>
    </div>
</div>

<script src="/Frontend/Admin/resellers/assets/js/resellers.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/resellers/assets/js/reseller-verification.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/resellers/assets/js/reseller-documents.js?v=<?php echo time(); ?>"></script>
</body>
</html>
