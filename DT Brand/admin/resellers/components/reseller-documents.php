<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * reseller-documents.php — DT Brand's & Jai Hanuman Tex
 * Reseller KYC Document Vault Component & Live Preview Triggers
 */
$docs = [
    [
        'id' => 'DOC-401',
        'title' => 'GST Registration Certificate (REG-06)',
        'type' => 'Tax Document',
        'date' => '12 Nov 2025',
        'status' => 'Verified',
        'size' => '1.4 MB (PDF)',
        'file_format' => 'PDF',
        'format_class' => 'pdf',
        'identifier' => '24AAAPL1234F1Z8'
    ],
    [
        'id' => 'DOC-402',
        'title' => 'Proprietor Aadhaar Card (Front & Back)',
        'type' => 'Identity Proof',
        'date' => '12 Nov 2025',
        'status' => 'Verified',
        'size' => '2.1 MB (JPG)',
        'file_format' => 'JPG',
        'format_class' => 'jpg',
        'identifier' => 'XXXX-XXXX-8921'
    ],
    [
        'id' => 'DOC-403',
        'title' => 'Cancelled Cheque / Bank Statement',
        'type' => 'Bank Proof',
        'date' => '13 Nov 2025',
        'status' => 'Verified',
        'size' => '980 KB (PDF)',
        'file_format' => 'PDF',
        'format_class' => 'pdf',
        'identifier' => 'ICICI Bank • A/C: 002105018291'
    ],
    [
        'id' => 'DOC-404',
        'title' => 'Shop & Establishment Trade License',
        'type' => 'Business Proof',
        'date' => '15 Nov 2025',
        'status' => 'Verified',
        'size' => '1.8 MB (PDF)',
        'file_format' => 'PDF',
        'format_class' => 'pdf',
        'identifier' => 'SMC/TL/2023/91024'
    ]
];
?>

<div class="dt-card" style="background:#FFFFFF; border:1.5px solid #EAE5D9; border-radius:12px; padding:20px; box-shadow:0 4px 16px rgba(0,0,0,0.03);">
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:18px; border-bottom:1px solid #F3EFE6; padding-bottom:14px;">
        <div style="display:flex; align-items:center; gap:10px;">
            <div style="width:38px; height:38px; border-radius:8px; background:#FAF5E8; border:1.2px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F; flex-shrink:0;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
            </div>
            <div>
                <h4 style="font-size:1rem; font-weight:800; color:#181512; margin:0;">Encrypted Document Vault</h4>
                <p style="font-size:0.75rem; color:#78716C; margin:2px 0 0 0;">256-bit encrypted KYC certificates with real-time preview, replacement, and PDF download.</p>
            </div>
        </div>
        <div style="display:flex; align-items:center; gap:8px;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="downloadAllKycZip()">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                <span>Download All (ZIP)</span>
            </button>
            <button type="button" class="dt-btn dt-btn-gold" onclick="openUploadNewDocModal()">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>+ Upload Document</span>
            </button>
        </div>
    </div>

    <!-- ══ 2x2 BALANCED DOCUMENT GRID ══ -->
    <div class="dt-docs-grid">
        <?php foreach ($docs as $d): ?>
            <div id="<?php echo $d['id']; ?>" class="dt-doc-card">
                <div>
                    <!-- Card Top Info -->
                    <div class="dt-doc-head">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div class="dt-doc-icon-badge <?php echo $d['format_class']; ?>">
                                <?php echo $d['file_format']; ?>
                            </div>
                            <div>
                                <strong class="doc-title" style="font-size:0.9rem; color:#181512; display:block; font-weight:800; line-height:1.3;"><?php echo htmlspecialchars($d['title']); ?></strong>
                                <small style="color:#78716C; font-size:0.72rem; font-weight:600;"><?php echo $d['type']; ?> • <?php echo $d['size']; ?></small>
                            </div>
                        </div>
                        <span class="dt-doc-status-badge">
                            ✓ Verified
                        </span>
                    </div>

                    <!-- Reference Number Strip -->
                    <div class="dt-doc-ref-box" style="margin-top:12px;">
                        <span style="font-size:0.7rem; color:#78716C; font-weight:800; text-transform:uppercase;">Reference ID:</span>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <strong style="font-family:monospace; color:#8A681F; font-size:0.82rem; font-weight:800;"><?php echo $d['identifier']; ?></strong>
                            <button type="button" onclick="copyToClipboard('<?php echo $d['identifier']; ?>', 'Reference ID')" style="background:none; border:none; color:#1D4ED8; font-size:0.7rem; font-weight:700; cursor:pointer; padding:0;" title="Copy Reference">Copy</button>
                        </div>
                    </div>
                </div>

                <!-- Card Footer Actions -->
                <div class="dt-doc-foot">
                    <span class="doc-date" style="font-size:0.72rem; color:#78716C; font-weight:600;">Uploaded: <?php echo $d['date']; ?></span>
                    <div style="display:flex; align-items:center; gap:6px;">
                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="previewResellerDoc('<?php echo $d['id']; ?>', '<?php echo addslashes($d['title']); ?>', '<?php echo $d['identifier']; ?>', '<?php echo $d['file_format']; ?>')">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            <span>View</span>
                        </button>
                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="downloadSpecificDoc('<?php echo $d['id']; ?>', '<?php echo addslashes($d['title']); ?>', '<?php echo $d['identifier']; ?>')">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Download</span>
                        </button>
                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="openReplaceDocModal('<?php echo $d['id']; ?>', '<?php echo addslashes($d['title']); ?>')">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            <span>Replace</span>
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
