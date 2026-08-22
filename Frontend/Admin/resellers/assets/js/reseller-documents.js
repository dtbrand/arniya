/**
 * reseller-documents.js — Document Viewer & Replacement Dispatch
 */

(function () {
    'use strict';

    window.previewResellerDoc = function (docName, docUrl) {
        window.showToast(`📄 Opening preview for ${docName}...`);
    };

    window.approveResellerDoc = function (docId, docName) {
        window.showToast(`✓ Document "${docName}" approved and verified`);
    };

    window.requestDocReplacement = function (docId, docName) {
        const msg = prompt(`Request replacement for ${docName}. Enter message for reseller:`, 'Please re-upload clear photo of GST certificate.');
        if (msg) {
            window.showToast(`Notification sent to reseller requesting replacement for "${docName}"`);
        }
    };

})();
