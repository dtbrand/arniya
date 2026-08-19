/**
 * product-form.js — Add / Edit Product Live Calculations & SEO Builder
 */
(function() {
    'use strict';

    window.calcPricePreview = function() {
        const mrp = parseFloat(document.getElementById('pFormMrp')?.value) || 0;
        const retail = parseFloat(document.getElementById('pFormRetail')?.value) || 0;
        const wholesale = parseFloat(document.getElementById('pFormWholesale')?.value) || 0;
        const cost = parseFloat(document.getElementById('pFormCost')?.value) || (wholesale * 0.7);

        const discountPct = mrp > 0 ? Math.round(((mrp - retail) / mrp) * 100) : 0;
        const grossMargin = retail > 0 ? Math.round(((retail - cost) / retail) * 100) : 0;

        const discEl = document.getElementById('pPrevDiscount');
        const marginEl = document.getElementById('pPrevMargin');
        if (discEl) discEl.textContent = discountPct + '% Off';
        if (marginEl) marginEl.textContent = grossMargin + '% Gross Margin';
    };

    window.updateGoogleSeoPreview = function() {
        const title = document.getElementById('pFormSeoTitle')?.value || document.getElementById('pFormName')?.value || "Product Title — DT Brand's";
        const desc = document.getElementById('pFormSeoDesc')?.value || "Explore authentic Pure Silk Sarees, Banarasi Brocades & Lehengas handcrafted in Surat at DT Brand's.";
        const slug = document.getElementById('pFormSlug')?.value || 'product-url-slug';

        const gTitle = document.getElementById('dtGoogleTitlePreview');
        const gUrl = document.getElementById('dtGoogleUrlPreview');
        const gDesc = document.getElementById('dtGoogleDescPreview');

        if (gTitle) gTitle.textContent = title + " | DT Brand's Luxury Ethnic";
        if (gUrl) gUrl.textContent = 'https://jaihanumantex.in/product/' + slug;
        if (gDesc) gDesc.textContent = desc;
    };
})();
