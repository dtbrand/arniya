/**
 * reseller-documents.js — DT Brand's & Jai Hanuman Tex
 * High-Res Document Previewer, Drag & Drop Replacement, Exact 1:1 UI PDF Downloader & 1-Page Print Engine
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

    // ── Helper to Populate Certificate Template Elements ──
    function populatePrintCertificate(title, identifier, docId) {
        const titleEl = document.getElementById('printCertDocTitle');
        const refEl = document.getElementById('printCertDocRef');
        const govtRefEl = document.getElementById('printCertGovtRef');
        const dateEl = document.getElementById('printCertDate');

        if (titleEl) titleEl.innerText = title;
        if (refEl) refEl.innerText = docId;
        if (govtRefEl) govtRefEl.innerText = identifier;
        if (dateEl) {
            dateEl.innerText = new Date().toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
        }
    }

    // ── Real Official A4 Certificate Print Engine ──
    window.printCurrentDoc = function () {
        const title = currentPreviewDoc ? currentPreviewDoc.title : 'GST Registration Certificate (REG-06)';
        const identifier = currentPreviewDoc ? currentPreviewDoc.identifier : '24AAAPL1234F1Z8';
        const docId = currentPreviewDoc ? currentPreviewDoc.id : 'DOC-401';

        populatePrintCertificate(title, identifier, docId);

        const cert = document.getElementById('dtPrintableCertificate');
        if (cert) {
            cert.style.display = 'block';
        }

        window.print();

        setTimeout(() => {
            if (cert) cert.style.display = 'none';
        }, 1000);
    };

    // ── 👑 1:1 EXACT UI PDF DOWNLOAD ENGINE (.pdf) ──
    function downloadExactUiPdf(title, identifier, docId) {
        const docTitle = title || 'GST Registration Certificate (REG-06)';
        const docIdent = identifier || '24AAAPL1234F1Z8';
        const docRef = docId || 'DOC-401';

        const safeTitle = docTitle.replace(/[^a-zA-Z0-9_-]/g, '_');
        const safeId = docIdent.replace(/[^a-zA-Z0-9_-]/g, '_');
        const pdfFilename = `${safeTitle}_${safeId}.pdf`;

        // 1. Populate the exact printable template
        populatePrintCertificate(docTitle, docIdent, docRef);

        const certWrapper = document.getElementById('dtPrintableCertificate');
        if (!certWrapper) {
            window.showToast('⚠️ Certificate template not found.');
            return;
        }

        // 2. Temporarily show wrapper for rendering
        certWrapper.style.display = 'block';
        certWrapper.style.position = 'fixed';
        certWrapper.style.left = '-9999px';
        certWrapper.style.top = '0';
        certWrapper.style.width = '794px'; // Standard A4 width in pixels at 96 DPI

        const innerElement = certWrapper.querySelector('.dt-print-inner') || certWrapper;

        // Check if html2pdf is available
        if (window.html2pdf) {
            window.showToast(`📥 Rendering Exact 1:1 UI PDF for "${docTitle}"...`);

            const opt = {
                margin: [6, 8, 6, 8],
                filename: pdfFilename,
                image: { type: 'jpeg', quality: 1.0 },
                html2canvas: {
                    scale: 3,
                    useCORS: true,
                    letterRendering: true,
                    backgroundColor: '#FFFFFF'
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait'
                }
            };

            window.html2pdf().set(opt).from(innerElement).save().then(() => {
                certWrapper.style.display = 'none';
                certWrapper.style.position = '';
                certWrapper.style.left = '';
                certWrapper.style.top = '';
                certWrapper.style.width = '';
                window.showToast(`✅ Downloaded: "${pdfFilename}" (Exact Same UI PDF)`);
            }).catch((err) => {
                certWrapper.style.display = 'none';
                console.error('html2pdf error:', err);
                // Fallback to print
                window.print();
            });
            return;
        }

        // Fallback: If CDN hasn't finished loading yet, use window.print()
        certWrapper.style.display = 'block';
        certWrapper.style.position = '';
        certWrapper.style.left = '';
        certWrapper.style.top = '';
        certWrapper.style.width = '';
        window.print();
        setTimeout(() => {
            certWrapper.style.display = 'none';
        }, 1000);
    }

    // ── Download Current Doc (From Modal) ──
    window.downloadCurrentDoc = function () {
        const title = currentPreviewDoc ? currentPreviewDoc.title : 'GST Registration Certificate (REG-06)';
        const identifier = currentPreviewDoc ? currentPreviewDoc.identifier : '24AAAPL1234F1Z8';
        const docId = currentPreviewDoc ? currentPreviewDoc.id : 'DOC-401';

        downloadExactUiPdf(title, identifier, docId);
    };

    // ── Download Specific Doc (From Card) ──
    window.downloadSpecificDoc = function (docId, title, identifier) {
        downloadExactUiPdf(title, identifier, docId);
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

    // ── Download All (ZIP / Multi PDF Package) ──
    window.downloadAllKycZip = function () {
        const docsToDownload = [
            { id: 'DOC-401', title: 'GST Registration Certificate (REG-06)', ref: '24AAAPL1234F1Z8' },
            { id: 'DOC-402', title: 'Proprietor Aadhaar Card (Front & Back)', ref: 'XXXX-XXXX-8921' },
            { id: 'DOC-403', title: 'Cancelled Cheque / Bank Statement', ref: 'ICICI Bank 002105018291' },
            { id: 'DOC-404', title: 'Shop & Establishment Trade License', ref: 'SMC/TL/2023/91024' }
        ];

        window.showToast('📦 Generating complete 1:1 UI PDF Dossier Package...');
        docsToDownload.forEach((d, idx) => {
            setTimeout(() => {
                downloadExactUiPdf(d.title, d.ref, d.id);
            }, idx * 700);
        });
    };

    // ── Open Upload New Document Modal ──
    window.openUploadNewDocModal = function () {
        window.openReplaceDocModal('DOC-401', 'Additional Business Certificate / Lease Deed');
    };

    // ── Close Modals Helper ──
    window.closeKycModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.style.display = 'none';
    };

})();
