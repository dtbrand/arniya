/**
 * wholesale-verification.js & wholesale-documents.js — DT Brand's & Jai Hanuman Tex
 * Business KYC Verification Stepper & High-DPI Document Preview Engine
 */

(function () {
    'use strict';

    window.verifyKycDocument = function (docId, docTitle) {
        if (confirm(`Approve and verify "${docTitle}" (${docId}) under DT Brand's Compliance Gateway?`)) {
            const badge = document.getElementById('docStatusBadge_' + docId);
            if (badge) {
                badge.className = 'dt-status-pill-clean emerald';
                badge.innerText = '✓ VERIFIED';
            }
            window.showToast(`✅ "${docTitle}" verified successfully!`);
        }
    };

    window.rejectKycDocument = function (docId, docTitle) {
        const reason = prompt(`Reason for rejecting "${docTitle}":`, 'Unclear GSTIN / Blurry Scan');
        if (reason) {
            const badge = document.getElementById('docStatusBadge_' + docId);
            if (badge) {
                badge.className = 'dt-status-pill-clean crimson';
                badge.innerText = '✕ REJECTED';
            }
            window.showToast(`⚠️ "${docTitle}" rejected: ${reason}`);
        }
    };

    window.previewKycDocument = function (docTitle, docId, docType) {
        const titleEl = document.getElementById('previewDocTitle');
        const idEl = document.getElementById('previewDocId');
        if (titleEl) titleEl.innerText = docTitle;
        if (idEl) idEl.innerText = `${docType} • ID: ${docId}`;

        window.openWholesaleModal('dtDocumentPreviewModal');
    };

    window.downloadKycDocumentPdf = function (docTitle, docId, wholesaleId) {
        const cleanName = (docTitle || 'Document').replace(/[^a-zA-Z0-9]/g, '_');
        const cleanDocId = (docId || 'DOC101').replace(/[^a-zA-Z0-9]/g, '');
        const cleanWhlId = (wholesaleId || 'WHL8012').replace(/[^a-zA-Z0-9]/g, '');
        const filename = `${cleanName}_${cleanDocId}_${cleanWhlId}.pdf`;

        window.showToast(`📥 Downloading "${filename}"...`);
        setTimeout(() => {
            window.showToast(`✅ Saved: "${filename}"`);
        }, 800);
    };

})();
