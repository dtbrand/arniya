<?php
/**
 * reseller-documents.php — DT Brand's & Jai Hanuman Tex
 * Reseller KYC Document Vault Component
 */
$docs = [
    [
        'id' => 'DOC-401',
        'title' => 'GST Registration Certificate (REG-06)',
        'type' => 'Tax Document',
        'date' => '12 Nov 2025',
        'status' => 'Verified',
        'size' => '1.4 MB (PDF)'
    ],
    [
        'id' => 'DOC-402',
        'title' => 'Proprietor Aadhaar Card (Front & Back)',
        'type' => 'Identity Proof',
        'date' => '12 Nov 2025',
        'status' => 'Verified',
        'size' => '2.1 MB (JPG)'
    ],
    [
        'id' => 'DOC-403',
        'title' => 'Cancelled Cheque / Bank Statement',
        'type' => 'Bank Proof',
        'date' => '13 Nov 2025',
        'status' => 'Verified',
        'size' => '980 KB (PDF)'
    ],
    [
        'id' => 'DOC-404',
        'title' => 'Shop & Establishment Trade License',
        'type' => 'Business Proof',
        'date' => '15 Nov 2025',
        'status' => 'Verified',
        'size' => '1.8 MB (PDF)'
    ]
];
?>

<div class="dt-docs-grid">
    <?php foreach ($docs as $d): ?>
        <div class="dt-doc-card">
            <div class="dt-doc-head">
                <div style="display:flex; align-items:center; gap:10px;">
                    <div class="dt-doc-icon">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                    </div>
                    <div>
                        <strong style="font-size:0.82rem; color:#181512; display:block;"><?php echo htmlspecialchars($d['title']); ?></strong>
                        <small style="color:#78716C; font-size:0.68rem;"><?php echo $d['type']; ?> • <?php echo $d['size']; ?></small>
                    </div>
                </div>
                <span class="dt-reseller-badge emerald">✓ <?php echo $d['status']; ?></span>
            </div>

            <div style="display:flex; align-items:center; justify-content:space-between; border-top:1px solid #F1ECE1; padding-top:10px; margin-top:4px;">
                <span style="font-size:0.68rem; color:#78716C;">Uploaded: <?php echo $d['date']; ?></span>
                <div style="display:flex; align-items:center; gap:6px;">
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="previewResellerDoc('<?php echo $d['title']; ?>')">View</button>
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="requestDocReplacement('<?php echo $d['id']; ?>', '<?php echo $d['title']; ?>')">Replace</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
