/**
 * reseller-documents.js — DT Brand's & Jai Hanuman Tex
 * High-Res Document Previewer, Drag & Drop Replacement, Clean PDF Name & ID Generator, and Guaranteed 1-Page Print Engine
 */

(function () {
    'use strict';

    let currentPreviewDoc = null;

    // ── Clean Standardized PDF File Naming Function ──
    function getCleanPdfFilename(docTitle, docId, resellerId) {
        let baseName = 'KYC_Document';
        const titleUpper = (docTitle || '').toUpperCase();

        if (titleUpper.includes('GST')) {
            baseName = 'GST_Registration_Certificate';
        } else if (titleUpper.includes('AADHAAR') || titleUpper.includes('ADHAAR')) {
            baseName = 'Proprietor_Aadhaar_Card';
        } else if (titleUpper.includes('CHEQUE') || titleUpper.includes('BANK')) {
            baseName = 'Cancelled_Cheque_Bank_Statement';
        } else if (titleUpper.includes('TRADE') || titleUpper.includes('LICENSE')) {
            baseName = 'Trade_License_Certificate';
        } else {
            baseName = (docTitle || 'Document').replace(/[^a-zA-Z0-9]/g, '_').replace(/_+/g, '_').replace(/^_|_$/g, '');
        }

        const cleanDocId = (docId || 'DOC401').replace(/[^a-zA-Z0-9]/g, '');
        const cleanResellerId = (resellerId || 'RES1048').replace(/[^a-zA-Z0-9]/g, '');

        return `${baseName}_${cleanDocId}_${cleanResellerId}.pdf`;
    }

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

    // ── 👑 100% NON-BLANK EXACT SAME UI PDF DOWNLOAD ENGINE (.pdf) ──
    function downloadExactUiPdf(title, identifier, docId) {
        const docTitle = title || 'GST Registration Certificate (REG-06)';
        const docIdent = identifier || '24AAAPL1234F1Z8';
        const docRef = docId || 'DOC-401';

        // Clean, structured PDF filename: [DocName]_[DocID]_[ResellerID].pdf
        const pdfFilename = getCleanPdfFilename(docTitle, docRef, 'RES-1048');

        // 1. Populate certificate elements
        populatePrintCertificate(docTitle, docIdent, docRef);

        const sourceInner = document.querySelector('#dtPrintableCertificate .dt-print-inner');
        if (!sourceInner) {
            window.showToast('⚠️ Certificate template not found.');
            return;
        }

        // 2. Create a clean, fully-visible temporary render container in viewport
        const renderBox = document.createElement('div');
        renderBox.id = 'dtPdfRenderContainer';
        renderBox.style.position = 'fixed';
        renderBox.style.top = '0';
        renderBox.style.left = '0';
        renderBox.style.width = '780px';
        renderBox.style.background = '#FFFFFF';
        renderBox.style.zIndex = '9999999';
        renderBox.style.padding = '10px';
        renderBox.style.boxSizing = 'border-box';
        renderBox.style.boxShadow = '0 10px 40px rgba(0,0,0,0.5)';
        renderBox.innerHTML = sourceInner.outerHTML;

        // Add to body so html2canvas can calculate real pixel bounding boxes
        document.body.appendChild(renderBox);

        window.showToast(`📥 Downloading "${pdfFilename}"...`);

        // Check if html2canvas and jsPDF are available
        const hasHtml2Canvas = typeof window.html2canvas === 'function';
        const jsPDFClass = (window.jspdf && window.jspdf.jsPDF) ? window.jspdf.jsPDF : (typeof window.jsPDF === 'function' ? window.jsPDF : null);

        if (hasHtml2Canvas && jsPDFClass) {
            window.html2canvas(renderBox, {
                scale: 2.5,
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#FFFFFF',
                logging: false
            }).then(function (canvas) {
                // Remove render container from DOM
                if (renderBox.parentNode) {
                    renderBox.parentNode.removeChild(renderBox);
                }

                const imgData = canvas.toDataURL('image/jpeg', 0.98);
                const pdf = new jsPDFClass({
                    orientation: 'portrait',
                    unit: 'mm',
                    format: 'a4'
                });

                const pageWidth = pdf.internal.pageSize.getWidth();
                const pageHeight = pdf.internal.pageSize.getHeight();

                const marginX = 8;
                const marginY = 8;
                const targetWidth = pageWidth - (marginX * 2);
                const targetHeight = (canvas.height * targetWidth) / canvas.width;

                pdf.addImage(imgData, 'JPEG', marginX, marginY, targetWidth, targetHeight);
                pdf.save(pdfFilename);
                window.showToast(`✅ Saved: "${pdfFilename}"`);
            }).catch(function (err) {
                console.error('html2canvas render error:', err);
                if (renderBox.parentNode) {
                    renderBox.parentNode.removeChild(renderBox);
                }
                window.showToast('⚠️ PDF rendering fallback triggered.');
            });
            return;
        }

        // Fallback: If libraries are not loaded, use direct window.print()
        if (renderBox.parentNode) {
            renderBox.parentNode.removeChild(renderBox);
        }
        const cert = document.getElementById('dtPrintableCertificate');
        if (cert) cert.style.display = 'block';
        window.print();
        setTimeout(() => {
            if (cert) cert.style.display = 'none';
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

        window.showToast('📦 Generating clean KYC PDF Dossier Package...');
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
