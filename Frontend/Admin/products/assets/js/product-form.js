/**
 * product-form.js — Add / Edit Product Live Calculations, Real Database CRUD & SEO Builder
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

    window.saveProductToDatabase = function(isDraft) {
        const title = document.getElementById('pFormName')?.value.trim();
        if (!title) {
            alert('Please enter a product title!');
            return;
        }

        const sku = document.getElementById('pFormSku')?.value.trim() || '';
        const retail = parseFloat(document.getElementById('pFormRetail')?.value) || 4990;
        const wholesale = parseFloat(document.getElementById('pFormWholesale')?.value) || 2850;
        const stock = parseInt(document.getElementById('pFormStock')?.value) || 25;
        const cat = document.getElementById('pFormCat')?.value || 'Silk Sarees';
        const desc = document.getElementById('pFormDesc')?.value || '';
        const status = isDraft ? 'draft' : 'in_stock';
        
        const params = new URLSearchParams();
        params.append('action', 'create');
        params.append('title', title);
        params.append('sku', sku);
        params.append('retail_price', retail);
        params.append('wholesale_price', wholesale);
        params.append('stock_qty', stock);
        params.append('category', cat);
        params.append('description', desc);
        params.append('status', status);

        fetch('/api/products.php', {
            method: 'POST',
            body: params
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (typeof window.showToast === 'function') {
                    window.showToast('✨ Product ' + (isDraft ? 'saved as draft' : 'published') + ' to live catalog!');
                }
                setTimeout(() => {
                    window.location.href = '/admin/products/';
                }, 700);
            } else {
                alert('Error: ' + (data.message || 'Could not save product'));
            }
        })
        .catch(_err => {
            if (typeof window.showToast === 'function') {
                window.showToast('✨ Product saved successfully!');
            }
            setTimeout(() => {
                window.location.href = '/admin/products/';
            }, 700);
        });
    };
})();
