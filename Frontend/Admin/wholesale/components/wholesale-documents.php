<?php
/**
 * wholesale-documents.php — DT Brand's & Jai Hanuman Tex
 * Encrypted Document Vault & Compliance Certificates Component
 */
$docs = [
    [
        'id' => 'DOC-WHL-401',
        'title' => 'GST Registration Certificate',
        'type' => 'Tax Compliance (Form GST REG-06)',
        'uploaded' => '14 Oct 2024',
        'expiry' => 'Lifetime',
        'status' => 'Verified',
        'badge' => 'emerald'
    ],
    [
        'id' => 'DOC-WHL-402',
        'title' => 'Certificate of Incorporation (MCA)',
        'type' => 'Legal Entity Proof (RoC Gujarat)',
        'uploaded' => '14 Oct 2024',
        'expiry' => 'Permanent',
        'status' => 'Verified',
        'badge' => 'emerald'
    ],
    [
        'id' => 'DOC-WHL-403',
        'title' => 'Director PAN & Aadhaar KYC',
        'type' => 'Proprietor Identity Proof',
        'uploaded' => '15 Oct 2024',
        'expiry' => 'Valid',
        'status' => 'Verified',
        'badge' => 'emerald'
    ],
    [
        'id' => 'DOC-WHL-404',
        'title' => 'Bank Mandate & Cancelled Cheque',
        'type' => 'Commercial Bank Clearance (HDFC Bank)',
        'uploaded' => '16 Oct 2024',
        'expiry' => 'Audited',
        'status' => 'Verified',
        'badge' => 'emerald'
    ]
];
?>

<div class="dt-card">
    <div class="dt-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
            <h4 class="dt-card-title">Encrypted Wholesale Document Vault</h4>
        </div>
        <div style="display:flex; align-items:center; gap:8px;">
            <input type="file" id="wholesaleDocFileInput" style="display:none;" onchange="onDocumentFileSelected(this)">
            <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="triggerDocumentUpload()">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>+ Upload Certificate</span>
            </button>
        </div>
    </div>

    <div style="overflow-x:auto; width:100%;">
        <table class="dt-wholesale-table">
            <thead>
                <tr>
                    <th style="white-space:nowrap;">Document ID</th>
                    <th style="white-space:nowrap;">Document Name</th>
                    <th style="white-space:nowrap;">Category / Type</th>
                    <th style="white-space:nowrap;">Uploaded Date</th>
                    <th style="white-space:nowrap;">Verification Status</th>
                    <th style="text-align:right; white-space:nowrap;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($docs as $d): ?>
                    <tr style="border-bottom:1px solid #F1ECE1;">
                        <td style="font-family:monospace; font-weight:800; color:#8A681F; white-space:nowrap;"><?php echo $d['id']; ?></td>
                        <td style="font-weight:800; color:#181512; white-space:nowrap;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                <span><?php echo htmlspecialchars($d['title']); ?></span>
                            </div>
                        </td>
                        <td style="color:#78716C; font-size:0.75rem; white-space:nowrap;"><?php echo $d['type']; ?></td>
                        <td style="color:#78716C; font-size:0.72rem; white-space:nowrap;"><?php echo $d['uploaded']; ?></td>
                        <td style="white-space:nowrap;">
                            <span id="docStatusBadge_<?php echo $d['id']; ?>" class="dt-status-pill-clean <?php echo $d['badge']; ?>">
                                ✓ <?php echo strtoupper($d['status']); ?>
                            </span>
                        </td>
                        <td style="text-align:right; white-space:nowrap;">
                            <div style="display:flex; justify-content:flex-end; gap:6px;">
                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="previewKycDocument('<?php echo addslashes($d['title']); ?>', '<?php echo $d['id']; ?>', '<?php echo addslashes($d['type']); ?>')">
                                    <span>Preview</span>
                                </button>
                                <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="downloadKycDocumentPdf('<?php echo addslashes($d['title']); ?>', '<?php echo $d['id']; ?>', 'WHL-8012')">
                                    <span>Download</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
