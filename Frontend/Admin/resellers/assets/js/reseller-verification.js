/**
 * reseller-verification.js — KYC Verification Actions
 */

(function () {
    'use strict';

    window.verifyKycStage = function (stageName) {
        window.showToast(`✓ KYC Stage "${stageName}" marked as Verified & Signed`);
    };

    window.rejectKycStage = function (stageName) {
        const reason = prompt(`Reason for rejecting ${stageName}:`, 'Document unreadable / mismatch');
        if (reason) {
            window.showToast(`KYC Stage "${stageName}" rejected: ${reason}`);
        }
    };

})();
