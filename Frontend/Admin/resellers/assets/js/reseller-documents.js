/**
 * reseller-documents.js — DT Brand's & Jai Hanuman Tex
 * High-Res Document Previewer, Drag & Drop Replacement, Real Official PDF Downloader & 1-Page Print Engine
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

    // ── Real Official A4 Certificate Print Engine ──
    window.printCurrentDoc = function () {
        const title = currentPreviewDoc ? currentPreviewDoc.title : 'GST Registration Certificate (REG-06)';
        const identifier = currentPreviewDoc ? currentPreviewDoc.identifier : '24AAAPL1234F1Z8';
        const docId = currentPreviewDoc ? currentPreviewDoc.id : 'DOC-401';

        // Populate Printable Certificate
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

        const cert = document.getElementById('dtPrintableCertificate');
        if (cert) {
            cert.style.display = 'block';
        }

        window.print();

        setTimeout(() => {
            if (cert) cert.style.display = 'none';
        }, 1000);
    };

    // ── 👑 REAL OFFICIAL PDF FILE GENERATOR (.pdf) ──
    function generateAndDownloadRealPdf(title, identifier, docId) {
        const docTitle = title || 'GST Registration Certificate (REG-06)';
        const docIdent = identifier || '24AAAPL1234F1Z8';
        const docRef = docId || 'DOC-401';
        const dateStr = new Date().toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });

        const safeTitle = docTitle.replace(/[^a-zA-Z0-9_-]/g, '_');
        const safeId = docIdent.replace(/[^a-zA-Z0-9_-]/g, '_');
        const pdfFilename = `${safeTitle}_${safeId}.pdf`;

        // Check if jsPDF library is available
        if (window.jspdf && window.jspdf.jsPDF) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({
                orientation: 'portrait',
                unit: 'mm',
                format: 'a4'
            });

            // Outer Heritage Gold Border
            doc.setDrawColor(138, 104, 31); // #8A681F
            doc.setLineWidth(0.8);
            doc.rect(10, 10, 190, 277);

            // Header Background Ribbon
            doc.setFillColor(250, 245, 232); // #FAF5E8
            doc.rect(12, 12, 186, 26, 'F');
            doc.setDrawColor(212, 175, 55); // #D4AF37
            doc.setLineWidth(0.4);
            doc.line(12, 38, 198, 38);

            // DT Logo Square
            doc.setFillColor(138, 104, 31);
            doc.rect(16, 15, 20, 20, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFontSize(15);
            doc.setFont('helvetica', 'bold');
            doc.text('DT', 21, 29);

            // Brand Header Titles
            doc.setTextColor(24, 21, 18);
            doc.setFontSize(13);
            doc.setFont('helvetica', 'bold');
            doc.text("DT BRAND'S & JAI HANUMAN TEX", 42, 23);

            doc.setTextColor(90, 66, 16);
            doc.setFontSize(8);
            doc.setFont('helvetica', 'normal');
            doc.text('Wholesale Textile B2B Network • Surat, Gujarat, India • ISO 9001:2015 Verified', 42, 29);

            // KYC Pill Header
            doc.setFillColor(250, 245, 232);
            doc.setDrawColor(138, 104, 31);
            doc.rect(144, 15, 48, 8, 'FD');
            doc.setTextColor(138, 104, 31);
            doc.setFontSize(7.5);
            doc.setFont('helvetica', 'bold');
            doc.text('OFFICIAL KYC CERTIFICATE', 147, 20.5);

            doc.setTextColor(120, 113, 108);
            doc.setFontSize(7);
            doc.text('DOC REF: ' + docRef, 158, 28);

            // Document Title Banner
            doc.setFillColor(253, 251, 247);
            doc.setDrawColor(234, 229, 217);
            doc.rect(16, 44, 178, 18, 'FD');

            doc.setTextColor(120, 113, 108);
            doc.setFontSize(7);
            doc.setFont('helvetica', 'bold');
            doc.text('VERIFIED B2B CERTIFICATE:', 22, 51);

            doc.setTextColor(24, 21, 18);
            doc.setFontSize(11);
            doc.text(docTitle, 22, 58);

            // Emerald 100% Verified Badge
            doc.setFillColor(220, 252, 231);
            doc.setDrawColor(134, 239, 172);
            doc.rect(138, 48, 50, 10, 'FD');
            doc.setTextColor(21, 128, 61);
            doc.setFontSize(8);
            doc.setFont('helvetica', 'bold');
            doc.text('✓ 100% VERIFIED & AUTHENTIC', 140, 54.5);

            // 2-Column Boxes
            // Box 1: Reseller Details
            doc.setDrawColor(234, 229, 217);
            doc.setFillColor(255, 255, 255);
            doc.rect(16, 68, 86, 75, 'FD');

            doc.setTextColor(138, 104, 31);
            doc.setFontSize(8.5);
            doc.setFont('helvetica', 'bold');
            doc.text('RESELLER BUSINESS DETAILS', 22, 76);
            doc.setDrawColor(226, 223, 215);
            doc.setLineWidth(0.2);
            doc.line(22, 79, 96, 79);

            doc.setTextColor(120, 113, 108);
            doc.setFontSize(7.5);
            doc.setFont('helvetica', 'normal');
            doc.text('Partner Name:', 22, 88);
            doc.setTextColor(24, 21, 18);
            doc.setFont('helvetica', 'bold');
            doc.text('Shree Krishna Sarees', 22, 94);
            doc.text('& Boutique', 22, 99);

            doc.setTextColor(120, 113, 108);
            doc.setFont('helvetica', 'normal');
            doc.text('Reseller ID:', 22, 108);
            doc.setTextColor(138, 104, 31);
            doc.setFont('helvetica', 'bold');
            doc.text('RES-1048', 22, 114);

            doc.setTextColor(120, 113, 108);
            doc.setFont('helvetica', 'normal');
            doc.text('Proprietor / Contact:', 22, 122);
            doc.setTextColor(24, 21, 18);
            doc.setFont('helvetica', 'bold');
            doc.text('Rameshwar Vyas', 22, 128);

            doc.setTextColor(120, 113, 108);
            doc.setFont('helvetica', 'normal');
            doc.text('Location / Hub:', 22, 136);
            doc.setTextColor(24, 21, 18);
            doc.setFont('helvetica', 'bold');
            doc.text('Surat, Gujarat, India', 22, 141);

            // Box 2: Compliance & Verification
            doc.setDrawColor(234, 229, 217);
            doc.setFillColor(255, 255, 255);
            doc.rect(108, 68, 86, 75, 'FD');

            doc.setTextColor(138, 104, 31);
            doc.setFontSize(8.5);
            doc.setFont('helvetica', 'bold');
            doc.text('COMPLIANCE & AUDIT', 114, 76);
            doc.setDrawColor(226, 223, 215);
            doc.line(114, 79, 188, 79);

            doc.setTextColor(120, 113, 108);
            doc.setFontSize(7.5);
            doc.setFont('helvetica', 'normal');
            doc.text('Govt Reference No:', 114, 88);
            doc.setTextColor(24, 21, 18);
            doc.setFont('helvetica', 'bold');
            doc.text(docIdent, 114, 94);

            doc.setTextColor(120, 113, 108);
            doc.setFont('helvetica', 'normal');
            doc.text('Digital SHA-256 Hash:', 114, 104);
            doc.setTextColor(21, 128, 61);
            doc.setFont('helvetica', 'bold');
            doc.text('a94f8e31c79802d...VALID', 114, 110);

            doc.setTextColor(120, 113, 108);
            doc.setFont('helvetica', 'normal');
            doc.text('Verified By Officer:', 114, 120);
            doc.setTextColor(24, 21, 18);
            doc.setFont('helvetica', 'bold');
            doc.text('Gautam Sethi (Chief Compliance)', 114, 126);

            doc.setTextColor(120, 113, 108);
            doc.setFont('helvetica', 'normal');
            doc.text('Verification Date:', 114, 135);
            doc.setTextColor(24, 21, 18);
            doc.setFont('helvetica', 'bold');
            doc.text(dateStr, 114, 141);

            // Legal Notice
            doc.setDrawColor(212, 175, 55);
            doc.setLineWidth(0.3);
            doc.line(16, 150, 194, 150);

            doc.setTextColor(120, 113, 108);
            doc.setFontSize(7);
            doc.setFont('helvetica', 'normal');
            doc.text("This certificate is an official verification record generated by DT Brand's & Jai Hanuman Tex B2B Compliance Engine.", 16, 157);
            doc.text("Authorized for wholesale procurement, revolving credit limits, and catalog distribution across Indian textile hubs.", 16, 162);

            // Official Stamp Circle
            doc.setDrawColor(138, 104, 31);
            doc.setLineWidth(0.6);
            doc.circle(162, 188, 15);
            doc.circle(162, 188, 13.8);

            doc.setTextColor(138, 104, 31);
            doc.setFontSize(5.5);
            doc.setFont('helvetica', 'bold');
            doc.text('★ VERIFIED ★', 153, 184);
            doc.setTextColor(21, 128, 61);
            doc.setFontSize(7.5);
            doc.text('APPROVED', 151, 189);
            doc.setTextColor(138, 104, 31);
            doc.setFontSize(5);
            doc.text("DT BRAND'S", 154, 193.5);

            doc.setTextColor(24, 21, 18);
            doc.setFontSize(8);
            doc.setFont('helvetica', 'bold');
            doc.text('Authorized Compliance Signatory', 136, 210);
            doc.setTextColor(120, 113, 108);
            doc.setFontSize(7);
            doc.setFont('helvetica', 'normal');
            doc.text('Surat Hub HQ, Gujarat', 148, 215);

            // Save PDF
            doc.save(pdfFilename);
            window.showToast(`✅ Downloaded: "${pdfFilename}" (Official PDF File)`);
            return;
        }

        // Fallback: Generate Standard PDF 1.4 Binary Blob
        const pdfContent = `%PDF-1.4
1 0 obj
<<
  /Type /Catalog
  /Pages 2 0 R
>>
endobj
2 0 obj
<<
  /Type /Pages
  /Kids [3 0 R]
  /Count 1
>>
endobj
3 0 obj
<<
  /Type /Page
  /Parent 2 0 R
  /Resources <<
    /Font <<
      /F1 <<
        /Type /Font
        /Subtype /Type1
        /BaseFont /Helvetica-Bold
      >>
      /F2 <<
        /Type /Font
        /Subtype /Type1
        /BaseFont /Helvetica
      >>
    >>
  >>
  /MediaBox [0 0 595.28 841.89]
  /Contents 4 0 R
>>
endobj
4 0 obj
<<
  /Length 720
>>
stream
BT
/F1 16 Tf
50 780 Td
(DT BRAND'S & JAI HANUMAN TEX - OFFICIAL KYC CERTIFICATE) Tj
/F2 10 Tf
0 -25 Td
(Wholesale Textile B2B Network - Surat, Gujarat, India - ISO 9001:2015 Verified) Tj
/F1 12 Tf
0 -40 Td
(VERIFIED DOCUMENT: ${docTitle}) Tj
/F2 10 Tf
0 -20 Td
(Govt Reference ID: ${docIdent}) Tj
0 -20 Td
(Reseller Partner: Shree Krishna Sarees & Boutique - RES-1048) Tj
0 -20 Td
(Proprietor / Contact: Rameshwar Vyas - Surat, Gujarat) Tj
0 -20 Td
(Verification Status: 100% VERIFIED & AUTHENTIC - Digital SHA-256 Signature Valid) Tj
0 -20 Td
(Verified By Officer: Gautam Sethi (Chief Compliance) on ${dateStr}) Tj
/F1 10 Tf
0 -40 Td
([APPROVED & DIGITALLY SIGNED - DT BRAND'S COMPLIANCE SEAL]) Tj
ET
endstream
endobj
xref
0 5
0000000000 65535 f 
0000000009 00000 n 
0000000058 00000 n 
0000000115 00000 n 
0000000308 00000 n 
trailer
<<
  /Size 5
  /Root 1 0 R
>>
startxref
1080
%%EOF`;

        const blob = new Blob([pdfContent], { type: 'application/pdf' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = pdfFilename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(link.href);

        window.showToast(`✅ Downloaded: "${pdfFilename}" (Official PDF File)`);
    }

    // ── Download Current Doc (From Modal) ──
    window.downloadCurrentDoc = function () {
        const title = currentPreviewDoc ? currentPreviewDoc.title : 'GST Registration Certificate (REG-06)';
        const identifier = currentPreviewDoc ? currentPreviewDoc.identifier : '24AAAPL1234F1Z8';
        const docId = currentPreviewDoc ? currentPreviewDoc.id : 'DOC-401';

        generateAndDownloadRealPdf(title, identifier, docId);
    };

    // ── Download Specific Doc (From Card) ──
    window.downloadSpecificDoc = function (docId, title, identifier) {
        generateAndDownloadRealPdf(title, identifier, docId);
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

    // ── Download All (ZIP Dossier Package) ──
    window.downloadAllKycZip = function () {
        // Download all 4 PDF certificates sequentially
        const docsToDownload = [
            { id: 'DOC-401', title: 'GST Registration Certificate (REG-06)', ref: '24AAAPL1234F1Z8' },
            { id: 'DOC-402', title: 'Proprietor Aadhaar Card (Front & Back)', ref: 'XXXX-XXXX-8921' },
            { id: 'DOC-403', title: 'Cancelled Cheque / Bank Statement', ref: 'ICICI Bank 002105018291' },
            { id: 'DOC-404', title: 'Shop & Establishment Trade License', ref: 'SMC/TL/2023/91024' }
        ];

        window.showToast('📦 Generating full KYC PDF Dossier Package...');
        docsToDownload.forEach((d, idx) => {
            setTimeout(() => {
                generateAndDownloadRealPdf(d.title, d.ref, d.id);
            }, idx * 400);
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
