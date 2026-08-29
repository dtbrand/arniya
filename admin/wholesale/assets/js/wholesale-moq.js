/**
 * wholesale-moq.js
 */

(function () {
    'use strict';

    window.openEditMoqModal = function (ruleName, currentMoq, currentMov) {
        document.getElementById('editMoqRuleName').innerText = ruleName;
        document.getElementById('editMoqQtyInput').value = currentMoq;
        document.getElementById('editMoqMovInput').value = currentMov;
        window.openWholesaleModal('dtEditMoqModal');
    };

    window.submitEditMoq = function (event) {
        if (event) event.preventDefault();
        const name = document.getElementById('editMoqRuleName').innerText;
        window.closeWholesaleModal('dtEditMoqModal');
        window.showToast(`✅ MOQ Rule "${name}" updated!`);
    };

})();
