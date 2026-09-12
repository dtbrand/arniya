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

    function toast(msg, type) {
        if (typeof window.showToast === 'function') { window.showToast(msg, type); }
        else { console.warn(msg); }
    }

    window.dtCurrentPreviewRole = 'guest';

    window.dtSelectPreviewRole = function (role) {
        window.dtCurrentPreviewRole = role || 'guest';
        var tabs = document.querySelectorAll('#dtRolePreviewTabs .dt-role-tab');
        for (var i = 0; i < tabs.length; i++) {
            var btn = tabs[i];
            var btnRole = btn.getAttribute('data-role');
            if (btnRole === window.dtCurrentPreviewRole) {
                btn.classList.add('active');
                btn.style.background = 'linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%)';
                btn.style.color = '#111827';
                btn.style.border = '1px solid #8A681F';
                btn.style.fontWeight = '800';
            } else {
                btn.classList.remove('active');
                btn.style.background = '#FAF5E8';
                btn.style.color = '#705114';
                btn.style.border = '1px solid #D4AF37';
                btn.style.fontWeight = '700';
            }
        }
        if (typeof window.calcPricePreview === 'function') {
            window.calcPricePreview();
        }
    };

    window.calcPricePreview = function () {
        var radSelling = document.querySelector('input[name="pFormSellingType"]:checked');
        var isFullSet = (radSelling && radSelling.value === 'full_set');

        // Inputs
        var retail = num('pFormRetail');
        var retSale = num('pFormRetailerSalePrice');
        var cust = num('pFormCustomerPrice');
        var custSale = num('pFormCustomerSalePrice');
        var res = num('pFormResellerPrice');
        var resSale = num('pFormResellerSalePrice');
        var whs = num('pFormWholesalePrice');
        var whsSale = num('pFormWholesaleSalePrice');
        var saleDisc = num('pFormSalePrice');

        var fsRet = num('pFormFullSetRetailerPrice');
        var fsRetSale = num('pFormFullSetRetailerSalePrice');
        var fsWhs = num('pFormFullSetWholesalePrice');
        var fsWhsSale = num('pFormFullSetWholesaleSalePrice');

        // Defaults and base resolution
        var baseRetail = retail > 0 ? retail : 0;
        var baseCust = cust > 0 ? cust : baseRetail;
        var baseRes = res > 0 ? res : baseRetail;
        var baseWhs = whs > 0 ? whs : baseRetail;

        var baseFsRet = fsRet > 0 ? fsRet : baseRetail;
        var baseFsWhs = fsWhs > 0 ? fsWhs : baseFsRet;

        // Effective single piece prices
        var effCust = custSale > 0 ? custSale : Math.max(0, baseCust - saleDisc);
        var effRet = retSale > 0 ? retSale : Math.max(0, baseRetail - saleDisc);
        var effRes = resSale > 0 ? resSale : Math.max(0, baseRes - saleDisc);
        var effWhs = whsSale > 0 ? whsSale : Math.max(0, baseWhs - saleDisc);

        // Effective full set prices
        var effFsRet = fsRetSale > 0 ? fsRetSale : Math.max(0, baseFsRet - saleDisc);
        var effFsWhs = fsWhsSale > 0 ? fsWhsSale : Math.max(0, baseFsWhs - saleDisc);

        // Active role
        var activeRole = window.dtCurrentPreviewRole || 'guest';

        // Elements
        var elTitle = document.getElementById('dtPrevRoleTitle');
        var elAccess = document.getElementById('dtPrevAccessStatus');
        var elPill = document.getElementById('dtPrevDiscountPill');
        var elEffPrice = document.getElementById('dtPrevEffectivePrice');
        var elStrikePrice = document.getElementById('dtPrevBasePriceStrike');
        var elSub = document.getElementById('dtPrevSubtitle');
        var elMarginVal = document.getElementById('dtPrevMarginValue');
        var elMarginPct = document.getElementById('dtPrevMarginPercent');

        if (isFullSet) {
            // FULL SET MODE: Customer & Reseller blocked; Retailer & Wholesaler authorized
            if (activeRole === 'guest' || activeRole === 'customer') {
                if (elTitle) elTitle.textContent = (activeRole === 'guest' ? 'Guest' : 'Customer') + ' View — Trade Blocked';
                if (elAccess) {
                    elAccess.textContent = 'BLOCKED (Trade Only)';
                    elAccess.style.background = '#FEE2E2';
                    elAccess.style.color = '#DC2626';
                }
                if (elPill) {
                    elPill.textContent = 'Trade Only';
                    elPill.style.background = '#FEE2E2';
                    elPill.style.color = '#DC2626';
                }
                if (elEffPrice) {
                    elEffPrice.textContent = 'Access Restricted';
                    elEffPrice.style.color = '#94A3B8';
                    elEffPrice.style.fontSize = '16px';
                }
                if (elStrikePrice) { elStrikePrice.style.display = 'none'; }
                if (elSub) elSub.textContent = 'Full Sets are sold exclusively in complete lots to verified B2B Retailers & Wholesalers.';
                if (elMarginVal) { elMarginVal.textContent = 'N/A'; elMarginVal.style.color = '#94A3B8'; }
                if (elMarginPct) elMarginPct.textContent = 'Trade restricted';
            } else if (activeRole === 'reseller') {
                if (elTitle) elTitle.textContent = 'Reseller View — Trade Blocked';
                if (elAccess) {
                    elAccess.textContent = 'BLOCKED (Trade Only)';
                    elAccess.style.background = '#FEE2E2';
                    elAccess.style.color = '#DC2626';
                }
                if (elPill) {
                    elPill.textContent = 'Single Piece Only';
                    elPill.style.background = '#FEE2E2';
                    elPill.style.color = '#DC2626';
                }
                if (elEffPrice) {
                    elEffPrice.textContent = 'Access Restricted';
                    elEffPrice.style.color = '#94A3B8';
                    elEffPrice.style.fontSize = '16px';
                }
                if (elStrikePrice) { elStrikePrice.style.display = 'none'; }
                if (elSub) elSub.textContent = 'Resellers sell single pieces with doorstep dropship. Full sets are restricted to storefront boutiques.';
                if (elMarginVal) { elMarginVal.textContent = 'N/A'; elMarginVal.style.color = '#94A3B8'; }
                if (elMarginPct) elMarginPct.textContent = 'Trade restricted';
            } else if (activeRole === 'retailer') {
                if (elTitle) elTitle.textContent = 'Retailer (Boutique) Storefront View';
                if (elAccess) {
                    elAccess.textContent = 'Full Set Authorized';
                    elAccess.style.background = '#DCFCE7';
                    elAccess.style.color = '#15803D';
                }
                if (elPill) {
                    elPill.textContent = (fsRetSale > 0 || saleDisc > 0) ? 'Discount Active' : 'Full Set Rate';
                    elPill.style.background = (fsRetSale > 0 || saleDisc > 0) ? '#FCD34D' : '#FAF5E8';
                    elPill.style.color = (fsRetSale > 0 || saleDisc > 0) ? '#78350F' : '#8A681F';
                }
                if (elEffPrice) {
                    elEffPrice.textContent = '₹' + effFsRet.toLocaleString('en-IN') + ' /pc';
                    elEffPrice.style.color = '#34D399';
                    elEffPrice.style.fontSize = '22px';
                }
                if (elStrikePrice) {
                    if (baseFsRet > effFsRet) {
                        elStrikePrice.textContent = '₹' + baseFsRet.toLocaleString('en-IN');
                        elStrikePrice.style.display = 'inline';
                    } else {
                        elStrikePrice.style.display = 'none';
                    }
                }
                if (elSub) elSub.textContent = 'Per-piece rate charged for the complete set lot';
                var retMargin = Math.max(0, baseCust - effFsRet);
                var retPct = baseCust > 0 ? Math.round((retMargin / baseCust) * 100) : 0;
                if (elMarginVal) { elMarginVal.textContent = '₹' + retMargin.toLocaleString('en-IN') + '/pc'; elMarginVal.style.color = '#FCD34D'; }
                if (elMarginPct) elMarginPct.textContent = retPct + '% Margin Advantage';
            } else if (activeRole === 'wholesale') {
                if (elTitle) elTitle.textContent = 'Wholesaler Storefront View';
                if (elAccess) {
                    elAccess.textContent = 'Bulk Lot Authorized';
                    elAccess.style.background = '#DCFCE7';
                    elAccess.style.color = '#15803D';
                }
                if (elPill) {
                    elPill.textContent = (fsWhsSale > 0 || saleDisc > 0) ? 'Bulk Offer Active' : 'Bulk Lot Rate';
                    elPill.style.background = (fsWhsSale > 0 || saleDisc > 0) ? '#FCD34D' : '#FAF5E8';
                    elPill.style.color = (fsWhsSale > 0 || saleDisc > 0) ? '#78350F' : '#8A681F';
                }
                if (elEffPrice) {
                    elEffPrice.textContent = '₹' + effFsWhs.toLocaleString('en-IN') + ' /pc';
                    elEffPrice.style.color = '#34D399';
                    elEffPrice.style.fontSize = '22px';
                }
                if (elStrikePrice) {
                    if (baseFsWhs > effFsWhs) {
                        elStrikePrice.textContent = '₹' + baseFsWhs.toLocaleString('en-IN');
                        elStrikePrice.style.display = 'inline';
                    } else {
                        elStrikePrice.style.display = 'none';
                    }
                }
                if (elSub) elSub.textContent = 'Wholesaler master lot volume rate';
                var whsMargin = Math.max(0, baseCust - effFsWhs);
                var whsPct = baseCust > 0 ? Math.round((whsMargin / baseCust) * 100) : 0;
                if (elMarginVal) { elMarginVal.textContent = '₹' + whsMargin.toLocaleString('en-IN') + '/pc'; elMarginVal.style.color = '#FCD34D'; }
                if (elMarginPct) elMarginPct.textContent = whsPct + '% Volume Advantage';
            }
        } else {
            // SINGLE PIECE MODE: All tiers authorized with their distinct pricing
            if (activeRole === 'guest' || activeRole === 'customer') {
                if (elTitle) elTitle.textContent = (activeRole === 'guest' ? 'Guest' : 'Customer') + ' Storefront View';
                if (elAccess) {
                    elAccess.textContent = 'Consumer Rate';
                    elAccess.style.background = '#DCFCE7';
                    elAccess.style.color = '#15803D';
                }
                if (elPill) {
                    elPill.textContent = (custSale > 0 || saleDisc > 0) ? 'Special Offer' : 'Standard Rate';
                    elPill.style.background = (custSale > 0 || saleDisc > 0) ? '#FCD34D' : '#E2E8F0';
                    elPill.style.color = (custSale > 0 || saleDisc > 0) ? '#78350F' : '#334155';
                }
                if (elEffPrice) {
                    elEffPrice.textContent = '₹' + effCust.toLocaleString('en-IN');
                    elEffPrice.style.color = '#34D399';
                    elEffPrice.style.fontSize = '22px';
                }
                if (elStrikePrice) {
                    if (baseCust > effCust) {
                        elStrikePrice.textContent = '₹' + baseCust.toLocaleString('en-IN');
                        elStrikePrice.style.display = 'inline';
                    } else {
                        elStrikePrice.style.display = 'none';
                    }
                }
                if (elSub) elSub.textContent = 'Consumer retail checkout price';
                var cSavings = Math.max(0, baseCust - effCust);
                if (elMarginVal) { elMarginVal.textContent = cSavings > 0 ? ('Save ₹' + cSavings.toLocaleString('en-IN')) : 'Regular MRP'; elMarginVal.style.color = '#FCD34D'; }
                if (elMarginPct) elMarginPct.textContent = cSavings > 0 ? (Math.round((cSavings / baseCust) * 100) + '% Customer Savings') : 'Standard Price';
            } else if (activeRole === 'retailer') {
                if (elTitle) elTitle.textContent = 'Retailer (Boutique) Storefront View';
                if (elAccess) {
                    elAccess.textContent = 'B2B Trade Authorized';
                    elAccess.style.background = '#DCFCE7';
                    elAccess.style.color = '#15803D';
                }
                if (elPill) {
                    elPill.textContent = (retSale > 0 || saleDisc > 0) ? 'Trade Offer' : 'B2B Trade Rate';
                    elPill.style.background = (retSale > 0 || saleDisc > 0) ? '#FCD34D' : '#FAF5E8';
                    elPill.style.color = (retSale > 0 || saleDisc > 0) ? '#78350F' : '#8A681F';
                }
                if (elEffPrice) {
                    elEffPrice.textContent = '₹' + effRet.toLocaleString('en-IN');
                    elEffPrice.style.color = '#34D399';
                    elEffPrice.style.fontSize = '22px';
                }
                if (elStrikePrice) {
                    if (baseRetail > effRet) {
                        elStrikePrice.textContent = '₹' + baseRetail.toLocaleString('en-IN');
                        elStrikePrice.style.display = 'inline';
                    } else {
                        elStrikePrice.style.display = 'none';
                    }
                }
                if (elSub) elSub.textContent = 'Boutique single piece trade rate';
                var rMargin = Math.max(0, effCust - effRet);
                var rPct = effCust > 0 ? Math.round((rMargin / effCust) * 100) : 0;
                if (elMarginVal) { elMarginVal.textContent = '₹' + rMargin.toLocaleString('en-IN') + '/pc'; elMarginVal.style.color = '#FCD34D'; }
                if (elMarginPct) elMarginPct.textContent = rPct + '% Boutique Profit Margin';
            } else if (activeRole === 'reseller') {
                if (elTitle) elTitle.textContent = 'Reseller Storefront View';
                if (elAccess) {
                    elAccess.textContent = 'Dropship Authorized';
                    elAccess.style.background = '#DCFCE7';
                    elAccess.style.color = '#15803D';
                }
                if (elPill) {
                    elPill.textContent = (resSale > 0 || saleDisc > 0) ? 'Dropship Offer' : 'Reseller Rate';
                    elPill.style.background = (resSale > 0 || saleDisc > 0) ? '#FCD34D' : '#FAF5E8';
                    elPill.style.color = (resSale > 0 || saleDisc > 0) ? '#78350F' : '#8A681F';
                }
                if (elEffPrice) {
                    elEffPrice.textContent = '₹' + effRes.toLocaleString('en-IN');
                    elEffPrice.style.color = '#34D399';
                    elEffPrice.style.fontSize = '22px';
                }
                if (elStrikePrice) {
                    if (baseRes > effRes) {
                        elStrikePrice.textContent = '₹' + baseRes.toLocaleString('en-IN');
                        elStrikePrice.style.display = 'inline';
                    } else {
                        elStrikePrice.style.display = 'none';
                    }
                }
                if (elSub) elSub.textContent = 'Reseller dropship per-piece price';
                var resMargin = Math.max(0, effCust - effRes);
                var resPct = effCust > 0 ? Math.round((resMargin / effCust) * 100) : 0;
                if (elMarginVal) { elMarginVal.textContent = '₹' + resMargin.toLocaleString('en-IN') + '/pc'; elMarginVal.style.color = '#FCD34D'; }
                if (elMarginPct) elMarginPct.textContent = resPct + '% Dropship Margin';
            } else if (activeRole === 'wholesale') {
                if (elTitle) elTitle.textContent = 'Wholesaler Storefront View';
                if (elAccess) {
                    elAccess.textContent = 'Bulk MOQ Authorized';
                    elAccess.style.background = '#DCFCE7';
                    elAccess.style.color = '#15803D';
                }
                if (elPill) {
                    elPill.textContent = (whsSale > 0 || saleDisc > 0) ? 'Wholesale Offer' : 'Wholesale MOQ Rate';
                    elPill.style.background = (whsSale > 0 || saleDisc > 0) ? '#FCD34D' : '#FAF5E8';
                    elPill.style.color = (whsSale > 0 || saleDisc > 0) ? '#78350F' : '#8A681F';
                }
                if (elEffPrice) {
                    elEffPrice.textContent = '₹' + effWhs.toLocaleString('en-IN');
                    elEffPrice.style.color = '#34D399';
                    elEffPrice.style.fontSize = '22px';
                }
                if (elStrikePrice) {
                    if (baseWhs > effWhs) {
                        elStrikePrice.textContent = '₹' + baseWhs.toLocaleString('en-IN');
                        elStrikePrice.style.display = 'inline';
                    } else {
                        elStrikePrice.style.display = 'none';
                    }
                }
                if (elSub) elSub.textContent = 'Per-piece rate for Wholesaler MOQ commitments';
                var wMargin = Math.max(0, effCust - effWhs);
                var wPct = effCust > 0 ? Math.round((wMargin / effCust) * 100) : 0;
                if (elMarginVal) { elMarginVal.textContent = '₹' + wMargin.toLocaleString('en-IN') + '/pc'; elMarginVal.style.color = '#FCD34D'; }
                if (elMarginPct) elMarginPct.textContent = wPct + '% Wholesale Advantage';
            }
        }

        // Section 21: Wholesaler MCQ Admin Tool Live Calculation
        var vRows = document.querySelectorAll('#dtVariantRows tr[data-vrow]');
        var colorsMap = {};
        var sizesMap = {};
        var comboList = [];

        for (var vi = 0; vi < vRows.length; vi++) {
            var vr = vRows[vi];
            var vcol = (vr.getAttribute('data-vcolour') || '').trim();
            var vsz = (vr.getAttribute('data-vsize') || '').trim();
            if (vcol) { colorsMap[vcol.toLowerCase()] = vcol; }
            if (vsz) { sizesMap[vsz.toLowerCase()] = vsz; }
            if (vcol || vsz) {
                comboList.push({
                    colour: vcol || 'Standard',
                    size: vsz || 'Free Size'
                });
            }
        }

        var colCount = Object.keys(colorsMap).length || 1;
        var szCount = Object.keys(sizesMap).length || 1;
        var mcqPieces = (comboList.length > 0) ? comboList.length : (colCount * szCount);
        var lotRate = isFullSet ? (effFsWhs > 0 ? effFsWhs : effFsRet) : (effWhs > 0 ? effWhs : effRet);
        var lotValue = mcqPieces * lotRate;

        var elMcqCol = document.getElementById('dtMcqColorsCount');
        var elMcqSz = document.getElementById('dtMcqSizesCount');
        var elMcqPcs = document.getElementById('dtMcqTotalPieces');
        var elMcqFormula = document.getElementById('dtMcqFormulaText');
        var elMcqVal = document.getElementById('dtMcqLotTotalValue');
        var elMcqSub = document.getElementById('dtMcqLotSub');
        var elMcqChips = document.getElementById('dtMcqCombinationsList');

        if (elMcqCol) elMcqCol.textContent = colCount;
        if (elMcqSz) elMcqSz.textContent = szCount;
        if (elMcqPcs) elMcqPcs.textContent = mcqPieces + (mcqPieces === 1 ? ' Piece' : ' Pieces');
        if (elMcqFormula) elMcqFormula.textContent = colCount + ' \u00d7 ' + szCount + ' = ' + mcqPieces + ' pcs';
        if (elMcqVal) elMcqVal.textContent = '₹' + lotValue.toLocaleString('en-IN');
        if (elMcqSub) elMcqSub.textContent = isFullSet ? 'Full Set Lot Minimum' : 'Wholesale MOQ Lot Minimum';

        if (elMcqChips) {
            if (!comboList.length) {
                elMcqChips.innerHTML = '<span style="font-size:10px; color:#94A3B8; background:#fff; border:1px solid #E2E8F0; padding:2px 8px; border-radius:4px;">No variants configured yet (defaults to 1 lot piece)</span>';
            } else {
                elMcqChips.innerHTML = comboList.map(function (c) {
                    return '<span style="font-size:10px; font-weight:700; color:#181512; background:#fff; border:1px solid #D4AF37; padding:2px 8px; border-radius:4px; display:inline-flex; align-items:center; gap:4px;">'
                        + '<span style="color:#16A34A; font-weight:800;">&#10003;</span> '
                        + String(c.colour).replace(/[&<>"']/g, '') + ' / ' + String(c.size).replace(/[&<>"']/g, '')
                        + '</span>';
                }).join('');
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

        var radSelling = document.querySelector('input[name="pFormSellingType"]:checked');
        var sellingType = radSelling ? String(radSelling.value).trim() : 'single_piece';

        var retail = num('pFormRetail');
        if (sellingType === 'full_set') {
            if (retail <= 0) {
                retail = num('pFormFullSetRetailerPrice') || num('pFormFullSetWholesalePrice');
            }
            if (retail <= 0) {
                toast('Enter the Full Set Retailer Price before saving.');
                var fsEl = document.getElementById('pFormFullSetRetailerPrice');
                if (fsEl) { fsEl.focus(); }
                return;
            }
        } else {
            if (retail <= 0) {
                // No invented 4899 fallback: a product with no price cannot be sold.
                toast('Enter the retail selling price before saving.');
                var rEl = document.getElementById('pFormRetail');
                if (rEl) { rEl.focus(); }
                return;
            }
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
        radSelling = document.querySelector('input[name="pFormSellingType"]:checked');
        sellingType = radSelling ? String(radSelling.value).trim() : 'single_piece';

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

        // Full price matrix mapping for single piece and full set
        if (payload.selling_type === 'single_piece') {
            payload.customer_price = val('pFormCustomerPrice') ? num('pFormCustomerPrice') : null;
            payload.customer_sale_price = val('pFormCustomerSalePrice') ? num('pFormCustomerSalePrice') : null;
            payload.retailer_sale_price = val('pFormRetailerSalePrice') ? num('pFormRetailerSalePrice') : null;
            payload.reseller_price = val('pFormResellerPrice') ? num('pFormResellerPrice') : null;
            payload.reseller_sale_price = val('pFormResellerSalePrice') ? num('pFormResellerSalePrice') : null;
            payload.wholesale_price = val('pFormWholesalePrice') ? num('pFormWholesalePrice') : null;
            payload.wholesale_sale_price = val('pFormWholesaleSalePrice') ? num('pFormWholesaleSalePrice') : null;
            payload.full_set_retailer_price = null;
            payload.full_set_retailer_sale_price = null;
            payload.full_set_wholesale_price = null;
            payload.full_set_wholesale_sale_price = null;
        } else {
            payload.customer_price = null;
            payload.customer_sale_price = null;
            payload.retailer_sale_price = null;
            payload.reseller_price = null;
            payload.reseller_sale_price = null;
            payload.wholesale_price = null;
            payload.wholesale_sale_price = null;
            payload.full_set_retailer_price = val('pFormFullSetRetailerPrice') ? num('pFormFullSetRetailerPrice') : null;
            payload.full_set_retailer_sale_price = val('pFormFullSetRetailerSalePrice') ? num('pFormFullSetRetailerSalePrice') : null;
            payload.full_set_wholesale_price = val('pFormFullSetWholesalePrice') ? num('pFormFullSetWholesalePrice') : null;
            payload.full_set_wholesale_sale_price = val('pFormFullSetWholesaleSalePrice') ? num('pFormFullSetWholesaleSalePrice') : null;
        }
        payload.sale_price = val('pFormSalePrice') ? num('pFormSalePrice') : 0;
        payload.mrp = null;

        addIf(payload, 'sku', 'pFormSku');
        addIf(payload, 'category', 'pFormCat');
        addIf(payload, 'fabric', 'pFormFabric');
        addIf(payload, 'weave', 'pFormWeave');
        addIf(payload, 'description', 'pFormDesc');
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
