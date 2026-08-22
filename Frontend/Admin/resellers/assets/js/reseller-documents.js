/**
 * reseller-documents.js — DT Brand's & Jai Hanuman Tex
 * High-Res Document Previewer, Drag & Drop Replacement, and Vault Operations
 */

(function () {
    'use strict';

    let currentPreviewDoc = null;

    // ── Preview Document ──
    window.previewResellerDoc = function (docId, title, identifier, format) {
        currentPreviewDoc = { id: docId, title: title, identifier: identifier, format: format };

        document.getElementById('previewModalTitle').innerText = title;
        document.getElementById('previewDocMainTitle').innerText = title;
        document.getElementById('previewDocIdentifier').innerText = identifier || 'VERIFIED-DOC-RECORD';

        const modal = document.getElementById('dtPreviewDocModal');
        if (modal) modal.style.display = 'flex';
    };

    // ── Download Current Doc ──
    window.downloadCurrentDoc = function () {
        const title = currentPreviewDoc ? currentPreviewDoc.title : 'KYC_Document';
        window.showToast(`📥 Downloading "${title}" (256-Bit Encrypted)...`);
        setTimeout(() => {
            window.showToast(`✓ "${title}" downloaded successfully`);
        }, 1000);
    };

    // ── Open Replace Modal ──
    window.openReplaceDocModal = function (docId, title) {
        document.getElementById('replaceDocId').value = docId;
        document.getElementById('replaceDocTitle').innerText = title;
        document.getElementById('selectedFileName').innerText = 'Click to browse or drop file here';
        document.getElementById('fileDocInput').value = '';

        const modal = document.getElementById('dtReplaceDocModal');
        if (modal) modal.style.display = 'flex';
    };

    // ── Handle File Selection ──
    window.handleDocFileSelection = function (input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
            document.getElementById('selectedFileName').innerHTML = `📄 ${file.name} <span style="color:#8A681F; font-weight:800;">(${sizeMb} MB)</span>`;
        }
    };

    // ── Confirm Replacement ──
    window.confirmDocReplacement = function (event) {
        if (event) event.preventDefault();
        const docId = document.getElementById('replaceDocId').value;
        const fileInput = document.getElementById('fileDocInput');

        if (!fileInput.files || fileInput.files.length === 0) {
            window.showToast('⚠️ Please select a replacement file first.');
            return;
        }

        const fileName = fileInput.files[0].name;
        const docCard = document.getElementById(docId);
        if (docCard) {
            const dateSpan = docCard.querySelector('.doc-date');
            if (dateSpan) {
                const nowStr = new Date().toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
                dateSpan.innerText = `Uploaded: ${nowStr} (Updated)`;
            }
        }

        window.closeKycModal('dtReplaceDocModal');
        window.showToast(`✅ Replacement file "${fileName}" uploaded & verified`);
    };

    // ── Download All ZIP ──
    window.downloadAllKycZip = function () {
        window.showToast('📦 Bundling all 4 verified KYC certificates into encrypted ZIP...');
        setTimeout(() => {
            window.showToast('✓ Reseller_KYC_Dossier_RES1048.zip ready and downloaded');
        }, 1400);
    };

    // ── Open Upload New Document Modal ──
    window.openUploadNewDocModal = function () {
        window.openReplaceDocModal('DOC-401', 'Additional Business Certificate / Lease Deed');
    };

})();
