/**
 * product-form.js — Add / Edit Product: live calculations, SEO preview, real save
 * DT Brand's & Jai Hanuman Tex
 *
 * The saver used to invent whatever the admin had not typed — mrp 6500, retail
 * 4899, wholesale 1399, stock 50, category 'Silk Sarees', fabric 'Pure Mulberry
 * Silk', image '/assets/images/product1.png' — so a half-filled form produced a
 * product making specific claims nobody had made. It also posted the cover
 * photo as a base64 data URL (the `includes('://')` test does not match
 * "data:image/png;base64,..."), which truncated into a permanently broken image
 * path, and its .catch() toasted "Product saved successfully!" when the request
 * had failed outright.
 *
 * Media and variants now come from the two collectors that own that state:
 * window.dtCollectMedia() and window.dtCollectVariants().
 */
(function () {
    'use strict';

    function val(id) {
        var el = document.getElementById(id);
        return el ? String(el.value == null ? '' : el.value).trim() : '';
    }

    function num(id) {
        var v = parseFloat(val(id));
        return isFinite(v) ? v : 0;
    }

    function toast(msg) {
        if (typeof window.showToast === 'function') { window.showToast(msg); }
        else { alert(msg); }
    }

    window.calcPricePreview = function () {
        var mrp = num('pFormMrp');
        var trade = num('pFormRetail');
        var cust = num('pFormCustomerPrice');
        var saleDisc = num('pFormSalePrice');
        var wholesale = num('pFormWholesale');
        var reseller = num('pFormReseller');

        var effTrade = Math.max(0, trade - saleDisc);
        var baseCust = cust > 0 ? cust : trade;
        var effCust = Math.max(0, baseCust - saleDisc);
        var effWholesale = wholesale > 0 ? Math.max(0, wholesale - saleDisc) : effTrade;
        var effReseller = reseller > 0 ? Math.max(0, reseller - saleDisc) : effTrade;
        var boutiqueMargin = Math.max(0, effCust - effTrade);
        var marginPct = effCust > 0 ? Math.round((boutiqueMargin / effCust) * 100) : 0;

        var elCustPrice = document.getElementById('dispCustPrice');
        var elCustSub = document.getElementById('dispCustSub');
        var elRetPrice = document.getElementById('dispRetailerPrice');
        var elRetSub = document.getElementById('dispRetailerSub');
        var elResPrice = document.getElementById('dispResellerPrice');
        var elResSub = document.getElementById('dispResellerSub');
        var elWhsPrice = document.getElementById('dispWholesalePrice');
        var elWhsSub = document.getElementById('dispWholesaleSub');
        var elBoutiqueMargin = document.getElementById('dispBoutiqueMargin');
        var elMarginPercent = document.getElementById('dispMarginPercent');
        var elBadge = document.getElementById('pPrevDiscountBadge');

        if (elCustPrice) elCustPrice.textContent = '₹' + effCust.toLocaleString('en-IN');
        if (elCustSub) elCustSub.textContent = saleDisc > 0 ? ('Save ₹' + saleDisc + ' Sale') : (mrp > effCust ? ('MRP ₹' + mrp.toLocaleString('en-IN')) : 'Standard Consumer Rate');

        if (elRetPrice) elRetPrice.textContent = '₹' + effTrade.toLocaleString('en-IN');
        if (elRetSub) elRetSub.textContent = saleDisc > 0 ? ('Base ₹' + trade + ' − ₹' + saleDisc) : 'B2B Trade Rate';

        if (elResPrice) elResPrice.textContent = '₹' + effReseller.toLocaleString('en-IN');
        if (elResSub) elResSub.textContent = reseller > 0 ? 'Custom Reseller Rate' : 'B2B Trade Rate';

        if (elWhsPrice) elWhsPrice.textContent = '₹' + effWholesale.toLocaleString('en-IN');
        if (elWhsSub) elWhsSub.textContent = wholesale > 0 ? 'Custom Bulk Rate' : 'B2B Trade Rate';

        if (elBoutiqueMargin) elBoutiqueMargin.textContent = '₹' + boutiqueMargin.toLocaleString('en-IN') + '/pc';
        if (elMarginPercent) elMarginPercent.textContent = marginPct + '% Profit Margin';

        if (elBadge) {
            if (saleDisc > 0) {
                elBadge.textContent = '₹' + saleDisc + ' Flat Discount Active';
                elBadge.style.background = '#FCD34D';
                elBadge.style.color = '#78350F';
            } else if (mrp > effCust && mrp > 0) {
                elBadge.textContent = Math.round(((mrp - effCust) / mrp) * 100) + '% Off MRP';
                elBadge.style.background = '#E6CA65';
                elBadge.style.color = '#181512';
            } else {
                elBadge.textContent = 'Standard Rate';
                elBadge.style.background = '#E2E8F0';
                elBadge.style.color = '#334155';
            }
        }
    };
    window.updateGoogleSeoPreview = function () {
        var name = val('pFormName');
        // The meta title / description / keyword boxes were removed: products has
        // no column for them. The preview reads the fields Google would actually
        // see — the page title and the product description.
        var title = val('pFormSeoTitle') || name;
        var desc = val('pFormSeoDesc') || val('pFormDesc');
        var slug = val('pFormSlug') || slugify(name);

        var gTitle = document.getElementById('dtGoogleTitlePreview');
        var gUrl = document.getElementById('dtGoogleUrlPreview');
        var gDesc = document.getElementById('dtGoogleDescPreview');

        // The preview is a preview of THIS product. It used to fall back to a
        // generic marketing sentence about silk sarees, so an empty SEO
        // description looked filled in.
        if (gTitle) { gTitle.textContent = title ? title + " | DT Brand's" : 'Product title not set'; }
        if (gUrl) { gUrl.textContent = 'https://jaihanumantex.in/product/' + (slug || '...'); }
        if (gDesc) { gDesc.textContent = desc ? desc.slice(0, 160) : 'No description yet — Google will pick its own snippet.'; }
    };

    function slugify(s) {
        return String(s || '').toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
    }
    /** Optional field: sent only when the input exists and the admin filled it. */
    function addIf(payload, key, id) {
        var el = document.getElementById(id);
        if (!el) { return; }
        var v = String(el.value == null ? '' : el.value).trim();
        if (v !== '') { payload[key] = v; }
    }

    function checkedIf(payload, key, id) {
        var el = document.getElementById(id);
        if (el) { payload[key] = el.checked ? 1 : 0; }
    }

    window.saveProductToDatabase = function (isDraft, customId) {
        var title = val('pFormName');
        if (!title) {
            toast('Enter a product title before saving.');
            var nameEl = document.getElementById('pFormName');
            if (nameEl) { nameEl.focus(); }
            return;
        }

        var retail = num('pFormRetail');
        if (retail <= 0) {
            // No invented 4899 fallback: a product with no price cannot be sold.
            toast('Enter the retail selling price before saving.');
            var rEl = document.getElementById('pFormRetail');
            if (rEl) { rEl.focus(); }
            return;
        }

        var urlParams = new URLSearchParams(window.location.search);
        var productId = customId
            || parseInt(val('pFormId'), 10)
            || parseInt(urlParams.get('id'), 10)
            || 0;
        var isUpdate = (productId > 0 && window.location.pathname.indexOf('edit.php') !== -1);

        var media = (typeof window.dtCollectMedia === 'function')
            ? window.dtCollectMedia()
            : null;

        if (media && media.pending > 0) {
            toast(media.pending + ' file(s) are still uploading. Wait for them to finish, then save.');
            return;
        }
        var variantsPending = (typeof window.dtVariantsPending === 'function')
            ? window.dtVariantsPending() : 0;
        if (variantsPending > 0) {
            toast('A variant photo is still uploading. Wait for it to finish, then save.');
            return;
        }

        var variants = (typeof window.dtCollectVariants === 'function')
            ? window.dtCollectVariants()
            : null;

        // Draft is a real status value in the products ENUM, so "Save Draft"
        // and the Stock Status select write to the same column.
        var status = isDraft ? 'draft' : (val('pFormStockStatus') || 'in_stock');
        var radSelling = document.querySelector('input[name="pFormSellingType"]:checked');
        var sellingType = radSelling ? String(radSelling.value).trim() : 'single_piece';

        var payload = {
            action: isUpdate ? 'update' : 'create',
            title: title,
            retail_price: retail,
            status: status,
            selling_type: (sellingType === 'full_set') ? 'full_set' : 'single_piece',
            // stock_qty is sent even when blank: blank means zero units, not
            // "leave whatever was there". It used to be saved as 50.
            stock_qty: Math.max(0, Math.round(num('pFormStock'))),
            slug: val('pFormSlug') || slugify(title)
        };
        // Media and variant keys are sent only when their collectors are on the
        // page. ProductCatalog replaces the stored rows whenever it sees one of
        // these keys, so a page that failed to load its gallery script must not
        // post empty arrays — that would delete every photo of the product.
        if (media) {
            payload.primary_image = media.primary_image || '';
            payload.gallery = media.gallery || [];
            payload.videos = media.videos || [];
            payload.embeds = media.embeds || [];
        }
        // An empty variants array is meaningful: it means the admin deleted every
        // row. An absent key leaves the stored rows alone.
        if (variants !== null) { payload.variants = variants; }
        if (isUpdate) { payload.id = productId; }

        // Everything below is optional. An empty box is left out of the payload
        // entirely rather than sent as a guess, so ProductCatalog keeps the
        // column NULL instead of storing a claim the admin never made.
        if (payload.selling_type === 'single_piece') {
            addIf(payload, 'customer_price', 'pFormCustomerPrice');
        } else {
            payload.customer_price = null;
        }
        addIf(payload, 'sku', 'pFormSku');
        addIf(payload, 'category', 'pFormCat');
        addIf(payload, 'fabric', 'pFormFabric');
        addIf(payload, 'weave', 'pFormWeave');
        addIf(payload, 'description', 'pFormDesc');
        addIf(payload, 'mrp', 'pFormMrp');
        addIf(payload, 'sale_price', 'pFormSalePrice');
        addIf(payload, 'wholesale_price', 'pFormWholesale');
        addIf(payload, 'reseller_price', 'pFormReseller');
        addIf(payload, 'badge', 'pFormBadge');
        addIf(payload, 'blouse_piece', 'pFormBlouse');
        addIf(payload, 'pallu_style', 'pFormPallu');
        addIf(payload, 'zari_type', 'pFormZari');
        addIf(payload, 'occasion', 'pFormOccasion');
        addIf(payload, 'moq_single', 'pFormMoqSingle');
        addIf(payload, 'moq_half_set', 'pFormMoqHalf');
        addIf(payload, 'moq_full_set', 'pFormMoqFull');
        addIf(payload, 'moq_master_bale', 'pFormMoqBale');
        // No meta_title / meta_description / meta_keywords keys are posted: those
        // columns do not exist, so the boxes were removed from the SEO section
        // rather than left looking saved. The slug above is real and is stored.
        checkedIf(payload, 'is_featured', 'pFormFeatured');
        checkedIf(payload, 'is_bestseller', 'pFormBestseller');
        var btns = document.querySelectorAll('[data-dt-save]');
        for (var i = 0; i < btns.length; i++) { btns[i].disabled = true; }
        function release() {
            for (var j = 0; j < btns.length; j++) { btns[j].disabled = false; }
        }

        // JSON, not FormData: api/products.php merges the decoded JSON body over
        // $_POST, and only that path keeps gallery/videos/embeds/variants as
        // arrays instead of flattening them to the string "Array".
        dtPostProduct(payload).then(function (res) {
            release();
            toast(res.message || (isUpdate ? 'Product updated.' : 'Product created.'));
            var goId = isUpdate ? productId : (res.id || res.product_id || 0);
            if (!isUpdate && goId > 0) {
                setTimeout(function () { window.location.href = 'edit.php?id=' + goId; }, 700);
            }
        }).catch(function (err) {
            release();
            // The old handler ran toast('Product saved successfully!') from inside
            // .catch(), so a rejected request reported a save.
            toast(err && err.message ? err.message : 'The product was not saved.');
        });
    };

    /** Shared POST: rejects unless the server actually reports success. */
    function dtPostProduct(payload) {
        return fetch('/api/products.php', {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify(payload)
        }).then(function (r) {
            return r.json().catch(function () {
                throw new Error((r.status === 401 || r.status === 403)
                    ? 'You are signed out of the admin — sign in again and retry.'
                    : 'The server did not return a valid response (HTTP ' + r.status + ').');
            });
        }).then(function (res) {
            if (!res || res.success !== true) {
                throw new Error((res && res.message) ? res.message : 'The server rejected the request.');
            }
            return res;
        });
    }

    if (typeof window.calcPricePreview === 'function') {
        setTimeout(window.calcPricePreview, 60);
    }
// DT_MARK_F5
})();
