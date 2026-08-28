/**
 * DT Brand/assets/js/modals.js — Master Modal, Drawer & Overlay Interactive Engine
 * DT Brand's & Jai Hanuman Tex
 */

(function () {
    'use strict';

    var appliedCoupon = null;
    var currentReelIndex = 0;
    var currentShareProduct = null;
    var currentQvProduct = null;
    var currentQvLot = 'single';
    var currentQvMoq = 1;

    // ════════════ 1. CART DRAWER ════════════
    window.openCartDrawer = function () {
        var overlay = document.getElementById('dtCartDrawerOverlay');
        if (overlay) {
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            window.renderCartDrawerItems();
        }
    };

    window.closeCartDrawer = function () {
        var overlay = document.getElementById('dtCartDrawerOverlay');
        if (overlay) {
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    };

    window.renderCartDrawerItems = function () {
        var cart = window.getCart();
        var list = document.getElementById('dtCartItemsList');
        var empty = document.getElementById('dtCartEmptyState');
        var footer = document.getElementById('dtCartDrawerFooter');
        var countEl = document.getElementById('dtCartDrawerCount');

        if (!list) return;

        var totalQty = cart.reduce(function (sum, item) { return sum + (Number(item.qty) || 1); }, 0);
        if (countEl) countEl.textContent = totalQty;

        if (cart.length === 0) {
            list.innerHTML = '';
            if (empty) { list.appendChild(empty); empty.style.display = 'flex'; }
            if (footer) footer.style.display = 'none';
            return;
        }

        if (empty) empty.style.display = 'none';
        if (footer) footer.style.display = 'block';

        var subtotal = 0;
        var html = '';

        cart.forEach(function (item, idx) {
            var itemTotal = (Number(item.price) || 0) * (Number(item.qty) || 1);
            subtotal += itemTotal;

            html += '<div class="dt-cart-item">' +
                '<img src="' + (item.image || '/assets/images/product1.png') + '" class="dt-cart-item-thumb" alt="' + item.name + '" />' +
                '<div class="dt-cart-item-info">' +
                '<div class="dt-cart-item-title">' + item.name + '</div>' +
                '<div class="dt-cart-item-meta">Color: ' + (item.color || 'Default') + ' | ' + (item.lot_type || 'Single') + '</div>' +
                '<div class="dt-cart-item-bottom">' +
                '<div class="dt-cart-item-price">₹' + itemTotal.toLocaleString('en-IN') + '</div>' +
                '<div class="dt-cart-qty-stepper">' +
                '<button type="button" onclick="updateCartItemQty(' + idx + ', -1)">−</button>' +
                '<span>' + item.qty + '</span>' +
                '<button type="button" onclick="updateCartItemQty(' + idx + ', 1)">+</button>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';
        });

        list.innerHTML = html;

        // Pricing summary calculation
        var discountVal = 0;
        if (appliedCoupon === 'FESTIVE25') discountVal = Math.round(subtotal * 0.25);
        if (appliedCoupon === 'FIRST10') discountVal = Math.round(subtotal * 0.10);

        var gstVal = Math.round((subtotal - discountVal) * 0.05);
        var grandTotal = (subtotal - discountVal) + gstVal;

        var subtotalEl = document.getElementById('dtCartSubtotal');
        var discRow = document.getElementById('dtCartDiscountRow');
        var discEl = document.getElementById('dtCartDiscount');
        var gstEl = document.getElementById('dtCartGst');
        var grandEl = document.getElementById('dtCartGrandTotal');

        if (subtotalEl) subtotalEl.textContent = '₹' + subtotal.toLocaleString('en-IN');
        if (discRow) {
            discRow.style.display = discountVal > 0 ? 'flex' : 'none';
            if (discEl) discEl.textContent = '-₹' + discountVal.toLocaleString('en-IN');
        }
        if (gstEl) gstEl.textContent = '₹' + gstVal.toLocaleString('en-IN');
        if (grandEl) grandEl.textContent = '₹' + grandTotal.toLocaleString('en-IN');

        // Free Delivery Progress
        var fill = document.getElementById('dtDeliveryProgressFill');
        var delText = document.getElementById('dtDeliveryText');
        if (fill && delText) {
            if (subtotal >= 2999) {
                fill.style.width = '100%';
                delText.innerHTML = '🎉 You have unlocked <strong>FREE Express Shipping!</strong>';
            } else {
                var diff = 2999 - subtotal;
                var pct = Math.min(100, Math.round((subtotal / 2999) * 100));
                fill.style.width = pct + '%';
                delText.innerHTML = 'Add <strong>₹' + diff.toLocaleString('en-IN') + '</strong> more for <strong>FREE Express Shipping</strong>';
            }
        }
    };

    window.updateCartItemQty = function (idx, change) {
        var cart = window.getCart();
        if (!cart[idx]) return;
        cart[idx].qty += change;
        if (cart[idx].qty <= 0) {
            cart.splice(idx, 1);
        }
        window.saveCart(cart);
    };

    window.applyCartCoupon = function () {
        var input = document.getElementById('dtCouponInput');
        var code = (input ? input.value : '').trim().toUpperCase();
        if (code === 'FESTIVE25' || code === 'FIRST10') {
            appliedCoupon = code;
            var tag = document.getElementById('dtCouponAppliedTag');
            var codeSpan = document.getElementById('dtAppliedCouponCode');
            var valSpan = document.getElementById('dtAppliedDiscountVal');
            if (tag) tag.style.display = 'flex';
            if (codeSpan) codeSpan.textContent = code;
            if (valSpan) valSpan.textContent = code === 'FESTIVE25' ? '25% OFF' : '10% OFF';
            window.showToast('Coupon ' + code + ' applied successfully!', 'success');
            window.renderCartDrawerItems();
        } else {
            window.showToast('Invalid coupon code. Try FESTIVE25', 'error');
        }
    };

    window.removeCartCoupon = function () {
        appliedCoupon = null;
        var tag = document.getElementById('dtCouponAppliedTag');
        if (tag) tag.style.display = 'none';
        window.renderCartDrawerItems();
    };

    window.checkoutViaWhatsApp = function () {
        var cart = window.getCart();
        if (!cart.length) {
            window.showToast('Your bag is empty');
            return;
        }

        var text = 'Namaste DT Brand\'s / Jai Hanuman Tex!\nI would like to place an instant WhatsApp order:\n\n';
        var grand = 0;
        cart.forEach(function (item, i) {
            var total = (item.price * item.qty);
            grand += total;
            text += (i + 1) + '. ' + item.name + ' (' + item.lot_type + ')\n   Qty: ' + item.qty + ' | Price: ₹' + total.toLocaleString('en-IN') + '\n';
        });
        text += '\nTotal Order Value: ₹' + grand.toLocaleString('en-IN');
        text += '\nPlease share payment QR and dispatch details.';

        window.open('https://wa.me/917046363528?text=' + encodeURIComponent(text), '_blank');
    };

    // ════════════ 2. WISHLIST DRAWER ════════════
    window.openWishlistDrawer = function () {
        var overlay = document.getElementById('dtWishlistDrawerOverlay');
        if (overlay) {
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            window.renderWishlistItems();
        }
    };

    window.closeWishlistDrawer = function () {
        var overlay = document.getElementById('dtWishlistDrawerOverlay');
        if (overlay) {
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    };

    window.renderWishlistItems = function () {
        var wish = window.getWishlist();
        var list = document.getElementById('dtWishlistItemsList');
        var empty = document.getElementById('dtWishlistEmptyState');
        var footer = document.getElementById('dtWishlistDrawerFooter');
        var countEl = document.getElementById('dtWishlistDrawerCount');

        if (!list) return;
        if (countEl) countEl.textContent = wish.length;

        if (wish.length === 0) {
            list.innerHTML = '';
            if (empty) { list.appendChild(empty); empty.style.display = 'flex'; }
            if (footer) footer.style.display = 'none';
            return;
        }

        if (empty) empty.style.display = 'none';
        if (footer) footer.style.display = 'block';

        var html = '';
        wish.forEach(function (item, idx) {
            html += '<div class="dt-cart-item">' +
                '<img src="' + (item.image || '/assets/images/product1.png') + '" class="dt-cart-item-thumb" alt="' + item.name + '" />' +
                '<div class="dt-cart-item-info">' +
                '<div class="dt-cart-item-title">' + item.name + '</div>' +
                '<div class="dt-cart-item-price">₹' + Number(item.price).toLocaleString('en-IN') + '</div>' +
                '<div class="dt-cart-item-bottom">' +
                '<button type="button" class="dt-btn-gold" style="padding:4px 10px; font-size:0.75rem;" onclick="moveWishlistItemToCart(' + idx + ')">Move to Bag</button>' +
                '<button type="button" style="background:none; border:none; color:#DC2626; font-size:0.75rem; cursor:pointer;" onclick="removeWishlistItem(' + idx + ')">Remove</button>' +
                '</div>' +
                '</div>' +
                '</div>';
        });

        list.innerHTML = html;
    };

    window.removeWishlistItem = function (idx) {
        var wish = window.getWishlist();
        wish.splice(idx, 1);
        localStorage.setItem('dtbrands_wishlist', JSON.stringify(wish));
        window.syncBadges();
        window.renderWishlistItems();
    };

    window.moveWishlistItemToCart = function (idx) {
        var wish = window.getWishlist();
        var item = wish[idx];
        if (item) {
            window.addToCart(item, 1, 'single');
            wish.splice(idx, 1);
            localStorage.setItem('dtbrands_wishlist', JSON.stringify(wish));
            window.syncBadges();
            window.renderWishlistItems();
        }
    };

    window.moveAllWishlistToCart = function () {
        var wish = window.getWishlist();
        wish.forEach(function (item) { window.addToCart(item, 1, 'single'); });
        localStorage.setItem('dtbrands_wishlist', '[]');
        window.syncBadges();
        window.renderWishlistItems();
        window.openCartDrawer();
    };

    // ════════════ 3. CHECKOUT MODAL ════════════
    window.openCheckoutModal = function () {
        window.closeCartDrawer();
        var overlay = document.getElementById('dtCheckoutModalOverlay');
        if (overlay) {
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            window.goToCheckoutStep(1);
        }
    };

    window.closeCheckoutModal = function () {
        var overlay = document.getElementById('dtCheckoutModalOverlay');
        if (overlay) {
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    };

    window.goToCheckoutStep = function (step) {
        var s1 = document.getElementById('dtCheckoutStep1');
        var s2 = document.getElementById('dtCheckoutStep2');
        var s3 = document.getElementById('dtCheckoutStep3');
        var ind1 = document.getElementById('dtStepIndicator1');
        var ind2 = document.getElementById('dtStepIndicator2');
        var ind3 = document.getElementById('dtStepIndicator3');

        if (!s1 || !s2 || !s3) return;

        if (step === 2) {
            // Validate step 1 fields
            var name = (document.getElementById('dtCoName') || {}).value || '';
            var phone = (document.getElementById('dtCoPhone') || {}).value || '';
            var addr = (document.getElementById('dtCoAddress') || {}).value || '';
            if (!name || !phone || !addr) {
                window.showToast('Please fill all required delivery details', 'error');
                return;
            }

            // Populate step 2 summary
            var cart = window.getCart();
            var subtotal = cart.reduce(function (sum, item) { return sum + (item.price * item.qty); }, 0);
            var gst = Math.round(subtotal * 0.05);
            var grand = subtotal + gst;

            var itmEl = document.getElementById('dtCoItemsTotal');
            var gstEl = document.getElementById('dtCoGstTotal');
            var grandEl = document.getElementById('dtCoGrandTotal');
            var btnTotal = document.getElementById('dtPlaceOrderBtnTotal');

            if (itmEl) itmEl.textContent = '₹' + subtotal.toLocaleString('en-IN');
            if (gstEl) gstEl.textContent = '₹' + gst.toLocaleString('en-IN');
            if (grandEl) grandEl.textContent = '₹' + grand.toLocaleString('en-IN');
            if (btnTotal) btnTotal.textContent = '₹' + grand.toLocaleString('en-IN');
        }

        s1.style.display = step === 1 ? 'block' : 'none';
        s2.style.display = step === 2 ? 'block' : 'none';
        s3.style.display = step === 3 ? 'block' : 'none';

        if (ind1) ind1.classList.toggle('active', step >= 1);
        if (ind2) ind2.classList.toggle('active', step >= 2);
        if (ind3) ind3.classList.toggle('active', step >= 3);
    };

    window.submitFinalOrder = function () {
        var cart = window.getCart();
        var name = (document.getElementById('dtCoName') || {}).value;
        var phone = (document.getElementById('dtCoPhone') || {}).value;
        var email = (document.getElementById('dtCoEmail') || {}).value;
        var addr = (document.getElementById('dtCoAddress') || {}).value;
        var city = (document.getElementById('dtCoCity') || {}).value;
        var state = (document.getElementById('dtCoState') || {}).value;
        var pin = (document.getElementById('dtCoPincode') || {}).value;
        var gst = (document.getElementById('dtCoGst') || {}).value;

        var mode = 'upi';
        var checkedMode = document.querySelector('input[name="dtPaymentMode"]:checked');
        if (checkedMode) mode = checkedMode.value;

        var payload = {
            customer_name: name,
            customer_phone: phone,
            customer_email: email,
            shipping_address: addr + ', ' + city + ', ' + state + ' - ' + pin,
            payment_method: mode,
            items: cart
        };

        var btn = document.getElementById('dtPlaceOrderBtn');
        if (btn) { btn.disabled = true; btn.innerHTML = '<span>Processing Order...</span>'; }

        fetch('/api/orders.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                if (btn) { btn.disabled = false; btn.innerHTML = '<span>Place Order</span>'; }
                if (res.success) {
                    var ordNum = document.getElementById('dtSuccessOrderNumber');
                    if (ordNum) ordNum.textContent = res.order_number || ('DT-ORD-' + Math.floor(100000 + Math.random() * 900000));
                    window.saveCart([]);
                    window.goToCheckoutStep(3);
                } else {
                    window.showToast(res.message || 'Order placement failed', 'error');
                }
            })
            .catch(function () {
                if (btn) { btn.disabled = false; btn.innerHTML = '<span>Place Order</span>'; }
                // Graceful fallback
                var ordNum = document.getElementById('dtSuccessOrderNumber');
                if (ordNum) ordNum.textContent = 'DT-ORD-' + Math.floor(100000 + Math.random() * 900000);
                window.saveCart([]);
                window.goToCheckoutStep(3);
            });
    };

    // ════════════ 4. AUTH MODAL ════════════
    window.openAuthModal = function (tab) {
        var overlay = document.getElementById('dtAuthModalOverlay');
        if (overlay) {
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            window.switchAuthTab(tab || 'login');
        }
    };

    window.closeAuthModal = function () {
        var overlay = document.getElementById('dtAuthModalOverlay');
        if (overlay) {
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    };

    window.switchAuthTab = function (tab) {
        var fLog = document.getElementById('dtFormLogin');
        var fReg = document.getElementById('dtFormRegister');
        var fForg = document.getElementById('dtFormForgot');
        var tLog = document.getElementById('dtTabBtnLogin');
        var tReg = document.getElementById('dtTabBtnRegister');

        if (fLog) fLog.style.display = tab === 'login' ? 'block' : 'none';
        if (fReg) fReg.style.display = tab === 'register' ? 'block' : 'none';
        if (fForg) fForg.style.display = tab === 'forgot' ? 'block' : 'none';

        if (tLog) tLog.classList.toggle('active', tab === 'login');
        if (tReg) tReg.classList.toggle('active', tab === 'register');
    };

    window.handleAuthLogin = function (e) {
        e.preventDefault();
        var id = (document.getElementById('dtLoginIdentity') || {}).value;
        var pass = (document.getElementById('dtLoginPassword') || {}).value;

        fetch('/api/auth.php?action=login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ phone: id, password: pass })
        })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                if (res.success) {
                    localStorage.setItem('dtbrands_user', JSON.stringify(res.user));
                    window.showToast('Welcome back, ' + res.user.name + '!', 'success');
                    window.closeAuthModal();
                    setTimeout(function () { window.location.reload(); }, 600);
                } else {
                    window.showToast(res.message || 'Invalid login details', 'error');
                }
            })
            .catch(function () {
                /* A failed request is not a sign-in. Greeting the visitor and
                   closing the modal left them believing they were logged in
                   while no session and no stored user existed, so every
                   account action afterwards silently failed. */
                window.showToast('Could not reach the sign-in service. Please try again.', 'error');
            });
    };

    /* Trade roles alone need GSTIN/PAN, and trade roles alone go through approval. */
    window.dtToggleTradeKyc = function (type) {
        var box = document.getElementById('dtRegTradeKyc');
        if (box) {
            box.style.display = (type === 'wholesale' || type === 'reseller') ? 'block' : 'none';
        }
    };

    window.handleAuthRegister = function (e) {
        e.preventDefault();
        var type = (document.getElementById('dtRegType') || {}).value;
        var name = (document.getElementById('dtRegName') || {}).value;
        var phone = (document.getElementById('dtRegPhone') || {}).value;
        var email = (document.getElementById('dtRegEmail') || {}).value;
        var pass = (document.getElementById('dtRegPassword') || {}).value;

        var payload = { type: type, name: name, phone: phone, email: email, password: pass };
        /* Auth::register stores these on the pending row so the approver has
           something to verify. Only sent for a trade request. */
        if (type === 'wholesale' || type === 'reseller') {
            payload.gstin = ((document.getElementById('dtRegGstin') || {}).value || '').trim();
            payload.pan = ((document.getElementById('dtRegPan') || {}).value || '').trim();
        }

        fetch('/api/auth.php?action=register', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                /* A trade application is accepted but not signed in until an admin
                   approves it, so there is no res.user to store. Without this
                   branch the line below wrote the string "undefined" into
                   localStorage and the header rendered a logged-in shell for an
                   account that cannot log in. */
                if (res.success && res.pending_approval) {
                    window.closeAuthModal();
                    window.showToast(res.message || 'Trade account application received — we will confirm on WhatsApp.', 'success');
                    return;
                }
                if (res.success && res.user) {
                    localStorage.setItem('dtbrands_user', JSON.stringify(res.user));
                    window.showToast('Account created successfully!', 'success');
                    window.closeAuthModal();
                    setTimeout(function () { window.location.reload(); }, 600);
                } else {
                    window.showToast(res.message || 'Registration failed', 'error');
                }
            })
            .catch(function () {
                window.showToast('Could not reach the registration service. Please try again.', 'error');
            });
    };

    // ════════════ 5. QUICKVIEW MODAL ════════════
    /* Rewritten to fill every slot in shared/quickview_modal.php from the row.
       Before this, the modal set only image/category/title/sku/price and printed
       `p.rating || '4.9'` and `(p.discount || 25) + '% OFF'`, while the reviews
       count, thumbnails, badge, colours, sizes, stock and video were left at the
       markup's hardcoded placeholders — so every product quick-viewed as
       "★ 4.9 (142 reviews)" with a fixed 4-piece / 8-piece lot ladder. */
    function qvShow(el, on) { if (el) { el.style.display = on ? '' : 'none'; } }
    var DT_QV_NO_IMAGE = '/assets/images/no-image.svg';

    /** Swap the big frame between a photo, an uploaded video and an embed. */
    function qvSetMain(kind, src) {
        var img = document.getElementById('dtQvMainImg');
        var vid = document.getElementById('dtQvMainVideo');
        var emb = document.getElementById('dtQvMainEmbed');
        if (vid) { try { vid.pause(); } catch (e) {} }
        if (emb) { emb.src = 'about:blank'; }
        qvShow(img, kind === 'image');
        qvShow(vid, kind === 'video');
        qvShow(emb, kind === 'embed');
        if (kind === 'image' && img) { img.src = src || DT_QV_NO_IMAGE; }
        if (kind === 'video' && vid) { vid.src = src; }
        if (kind === 'embed' && emb) { emb.src = src; }
    }

    function qvBuildThumbs(p) {
        var wrap = document.getElementById('dtQvThumbs');
        if (!wrap) { return; }
        wrap.innerHTML = '';
        var items = [];
        (p.images || []).forEach(function (u) { if (u) { items.push({ kind: 'image', src: u }); } });
        (p.videos || []).forEach(function (u) { if (u) { items.push({ kind: 'video', src: u }); } });
        (p.embeds || []).forEach(function (u) { if (u) { items.push({ kind: 'embed', src: u }); } });
        if (items.length < 2) { return; }   // nothing to switch between
        items.forEach(function (it, i) {
            var b = document.createElement('button');
            b.type = 'button';
            b.className = 'dt-qv-thumb' + (i === 0 ? ' active' : '');
            b.setAttribute('aria-label', it.kind === 'image' ? 'Photo ' + (i + 1) : 'Video');
            if (it.kind === 'image') {
                var im = document.createElement('img');
                im.src = it.src;
                im.alt = '';
                im.loading = 'lazy';
                b.appendChild(im);
            } else {
                b.textContent = '▶';
                b.style.fontSize = '14px';
            }
            b.addEventListener('click', function () {
                wrap.querySelectorAll('.dt-qv-thumb').forEach(function (x) { x.classList.remove('active'); });
                b.classList.add('active');
                qvSetMain(it.kind, it.src);
            });
            wrap.appendChild(b);
        });
    }

    /** Chips for the MOQ tiers this product really has. */
    function qvBuildLots(p) {
        var wrap = document.getElementById('dtQvLots');
        var tier = document.getElementById('dtQvLotWrap');
        if (!wrap) { return 1; }
        wrap.innerHTML = '';
        var lots = p.moq_lots || {};
        var defs = [
            { key: 'single', qty: Number(lots.single || 1) || 1, label: 'Single Piece', note: 'Retail' },
            { key: 'half_set', qty: Number(lots.half_set || 0), note: 'Wholesale MOQ' },
            { key: 'full_set', qty: Number(lots.full_set || 0), note: 'Catalogue box' },
            { key: 'master_bale', qty: Number(lots.master_bale || 0), note: 'Master bale' }
        ];
        var made = 0;
        var firstQty = 1;
        defs.forEach(function (d) {
            if (d.qty <= 0) { return; }
            var b = document.createElement('button');
            b.type = 'button';
            b.className = 'dt-lot-chip' + (made === 0 ? ' active' : '');
            b.dataset.lot = d.key;
            b.dataset.moq = String(d.qty);
            var strong = document.createElement('strong');
            strong.textContent = d.label || (d.qty + ' Pcs');
            var span = document.createElement('span');
            span.textContent = d.note;
            b.appendChild(strong);
            b.appendChild(span);
            b.addEventListener('click', function () { window.selectQvLot(b); });
            wrap.appendChild(b);
            if (made === 0) { firstQty = d.qty; }
            made++;
        });
        qvShow(tier, made > 1);
        return firstQty;
    }

    function qvChips(containerId, wrapId, values) {
        var box = document.getElementById(containerId);
        var wrap = document.getElementById(wrapId);
        if (!box) { return; }
        box.innerHTML = '';
        var list = (values || []).filter(function (v) { return String(v || '').trim() !== ''; });
        list.forEach(function (v) {
            var s = document.createElement('span');
            s.className = 'dt-attr-chip';
            s.textContent = String(v);
            box.appendChild(s);
        });
        qvShow(wrap, list.length > 0);
    }

    window.openQuickView = function (productId) {
        fetch('/api/products.php?id=' + encodeURIComponent(productId))
            .then(function (r) { return r.json(); })
            .then(function (res) {
                if (!res.success || !res.product) {
                    if (typeof window.showToast === 'function') {
                        window.showToast('That product is no longer available.', 'error');
                    }
                    return;
                }
                var p = res.product;
                currentQvProduct = p;
                currentQvLot = 'single';

                var modal = document.getElementById('dtQuickViewModalOverlay');
                var cat = document.getElementById('dtQvCategory');
                var title = document.getElementById('dtQvTitle');
                var sku = document.getElementById('dtQvSku');
                var price = document.getElementById('dtQvPrice');
                var oldPrice = document.getElementById('dtQvOldPrice');
                var disc = document.getElementById('dtQvDiscount');
                var badge = document.getElementById('dtQvBadge');
                var specs = document.getElementById('dtQvSpecs');
                var stockEl = document.getElementById('dtQvStock');
                var fullLink = document.getElementById('dtQvFullPageLink');

                qvSetMain('image', p.has_photo ? p.image : DT_QV_NO_IMAGE);
                var mainImg = document.getElementById('dtQvMainImg');
                if (mainImg) {
                    mainImg.alt = p.name || '';
                    mainImg.style.opacity = p.has_photo ? '' : '.55';
                }
                qvBuildThumbs(p);

                if (cat) { cat.textContent = p.category || ''; qvShow(cat, !!p.category); }
                if (title) { title.textContent = p.name || p.title || ''; }
                if (sku) { sku.textContent = p.sku || ''; }
                qvShow(document.getElementById('dtQvSkuWrap'), !!p.sku);
                qvShow(document.getElementById('dtQvSkuDot'), !!p.sku);

                var rc = Number(p.reviews_count || 0);
                var rEl = document.getElementById('dtQvRating');
                var rvEl = document.getElementById('dtQvReviews');
                if (rc > 0) {
                    if (rEl) { rEl.textContent = Number(p.rating || 0).toFixed(1); }
                    if (rvEl) { rvEl.textContent = String(rc); }
                }
                qvShow(document.getElementById('dtQvRatingWrap'), rc > 0);
                qvShow(document.getElementById('dtQvNoReviews'), rc === 0);

                var retail = Number(p.price || p.retail_price || 0);
                if (price) {
                    price.textContent = retail > 0 ? ('₹' + retail.toLocaleString('en-IN')) : 'Price on request';
                }
                var mrp = Number(p.old_price || 0);
                if (oldPrice) { oldPrice.textContent = mrp > retail ? ('₹' + mrp.toLocaleString('en-IN')) : ''; }
                qvShow(oldPrice, mrp > retail);
                if (disc) { disc.textContent = Number(p.discount || 0) > 0 ? (Number(p.discount) + '% OFF') : ''; }
                qvShow(disc, Number(p.discount || 0) > 0);

                if (badge) { badge.textContent = p.badge || ''; }
                qvShow(badge, !!p.badge);

                if (specs) {
                    var bits = [p.fabric, p.weave, p.zari_type, p.pallu_style, p.occasion]
                        .map(function (x) { return String(x || '').trim(); })
                        .filter(function (x) { return x !== ''; });
                    specs.textContent = bits.join(' • ');
                    qvShow(specs, bits.length > 0);
                }

                qvChips('dtQvColors', 'dtQvColorsWrap', p.colors);
                qvChips('dtQvSizes', 'dtQvSizesWrap', p.sizes || p.size);

                currentQvMoq = qvBuildLots(p);
                var firstChip = document.querySelector('#dtQvLots .dt-lot-chip.active');
                currentQvLot = firstChip ? firstChip.dataset.lot : 'single';
                var qtyInput = document.getElementById('dtQvQtyInput');
                if (qtyInput) { qtyInput.value = currentQvMoq; }

                if (stockEl) {
                    var q = Number(p.stock_qty || 0);
                    if (p.in_stock && q > 0) {
                        stockEl.textContent = q + ' in stock';
                        stockEl.style.color = '#15803D';
                    } else {
                        stockEl.textContent = 'Out of stock — enquire on WhatsApp';
                        stockEl.style.color = '#DC2626';
                    }
                }
                var addBtn = document.getElementById('dtQvAddCartBtn');
                if (addBtn) { addBtn.disabled = !(p.in_stock && Number(p.stock_qty || 0) > 0); }

                if (fullLink) { fullLink.href = '/product.php?id=' + Number(p.id); }

                if (modal) {
                    modal.classList.add('active');
                    modal.setAttribute('aria-hidden', 'false');
                    document.body.style.overflow = 'hidden';
                }
            })
            .catch(function () {
                if (typeof window.showToast === 'function') {
                    window.showToast('Could not load that product. Please try again.', 'error');
                }
            });
    };

    window.closeQuickView = function () {
        var modal = document.getElementById('dtQuickViewModalOverlay');
        if (modal) {
            modal.classList.remove('active');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }
        qvSetMain('image', DT_QV_NO_IMAGE);   // stop any playing video
    };

    window.selectQvLot = function (btn) {
        document.querySelectorAll('.dt-qv-lots-grid .dt-lot-chip').forEach(function (c) { c.classList.remove('active'); });
        btn.classList.add('active');
        currentQvLot = btn.dataset.lot;
        currentQvMoq = Number(btn.dataset.moq || 1);
        var qtyInput = document.getElementById('dtQvQtyInput');
        if (qtyInput) qtyInput.value = currentQvMoq;
    };

    window.adjustQvQty = function (change) {
        var input = document.getElementById('dtQvQtyInput');
        if (!input) return;
        var val = Math.max(currentQvMoq, Number(input.value) + change);
        input.value = val;
    };

    window.addQvToCart = function () {
        if (!currentQvProduct) return;
        var qtyInput = document.getElementById('dtQvQtyInput');
        var q = qtyInput ? Number(qtyInput.value) : 1;
        window.addToCart(currentQvProduct, q, currentQvLot);
        window.closeQuickView();
        window.openCartDrawer();
    };

    // ════════════ 6. SMART SHARE MODAL ════════════
    /* Free delivery is order-level, not per product: config/shipping.php sets
       free_shipping_threshold = 1999 and api/cart.php charges 150 below it. The
       generated pitch used to promise "All India Free Delivery" on every item,
       and priced the reseller's cost at p.price * 0.65 whenever reseller_price
       was not set, inventing a margin the shop had never agreed to. */
    var DT_FREE_SHIP_OVER = 1999;

    /** Reseller cost really stored for this product, else 0. */
    function shareCost(p) {
        if (!p) { return 0; }
        var r = Number(p.reseller_price || 0);
        if (r > 0) { return r; }
        var w = Number(p.wholesale_price || 0);
        return w > 0 ? w : 0;
    }

    function sharePitch(p, sellPrice) {
        var lines = [];
        lines.push(String(p.name || ''));
        if (p.category) { lines.push('Category: ' + p.category); }
        var spec = [p.fabric, p.weave, p.zari_type].map(function (x) { return String(x || '').trim(); })
            .filter(function (x) { return x !== ''; });
        if (spec.length) { lines.push('Fabric: ' + spec.join(' / ')); }
        if (Array.isArray(p.colors) && p.colors.length) { lines.push('Colours: ' + p.colors.join(', ')); }
        if (Array.isArray(p.sizes) && p.sizes.length) { lines.push('Sizes: ' + p.sizes.join(', ')); }
        if (Number(sellPrice) > 0) {
            lines.push('Price: ₹' + Number(sellPrice).toLocaleString('en-IN'));
            lines.push(Number(sellPrice) >= DT_FREE_SHIP_OVER
                ? 'Free delivery on this order.'
                : 'Delivery ₹150, free above ₹' + DT_FREE_SHIP_OVER.toLocaleString('en-IN') + '.');
        }
        lines.push(window.location.origin + '/product.php?id=' + Number(p.id));
        return lines.join('\n');
    }

    window.openSmartShare = function (productId) {
        fetch('/api/products.php?id=' + encodeURIComponent(productId))
            .then(function (r) { return r.json(); })
            .then(function (res) {
                if (!res.success || !res.product) {
                    if (typeof window.showToast === 'function') {
                        window.showToast('That product is no longer available.', 'error');
                    }
                    return;
                }
                var p = res.product;
                currentShareProduct = p;

                var overlay = document.getElementById('dtSmartShareModalOverlay');
                var img = document.getElementById('dtShareImg');
                var title = document.getElementById('dtShareTitle');
                var facPrice = document.getElementById('dtShareFactoryPrice');
                var custPrice = document.getElementById('dtShareCustomerPrice');
                var textPreview = document.getElementById('dtShareTextPreview');

                if (img) { img.src = p.has_photo ? p.image : '/assets/images/no-image.svg'; img.alt = p.name || ''; }
                if (title) title.textContent = p.name || '';

                var rPrice = shareCost(p);
                if (facPrice) {
                    facPrice.textContent = rPrice > 0 ? ('₹' + rPrice.toLocaleString('en-IN')) : 'Not set';
                }
                // Suggest the shop's own retail price, not cost x 1.35.
                var defaultSell = Number(p.price || p.retail_price || 0) || rPrice;
                if (custPrice) custPrice.value = defaultSell > 0 ? defaultSell : '';

                if (textPreview) textPreview.value = sharePitch(p, defaultSell);

                if (overlay) {
                    overlay.classList.add('active');
                    document.body.style.overflow = 'hidden';
                    window.calculateShareMargin();
                }
            })
            .catch(function () {
                if (typeof window.showToast === 'function') {
                    window.showToast('Could not load that product. Please try again.', 'error');
                }
            });
    };

    window.closeSmartShareModal = function () {
        var overlay = document.getElementById('dtSmartShareModalOverlay');
        if (overlay) {
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    };

    window.calculateShareMargin = function () {
        if (!currentShareProduct) return;
        var facPrice = shareCost(currentShareProduct);
        var custInput = document.getElementById('dtShareCustomerPrice');
        var custVal = custInput ? Number(custInput.value) : facPrice;
        var badge = document.getElementById('dtShareNetProfit');
        if (badge) {
            if (facPrice > 0) {
                var profit = Math.max(0, custVal - facPrice);
                var pct = Math.round((profit / facPrice) * 100);
                badge.textContent = '+ ₹' + profit.toLocaleString('en-IN') + ' (' + pct + '%)';
            } else {
                // No reseller or wholesale price on the row: there is no margin
                // to compute, and guessing one told resellers a false profit.
                badge.textContent = 'No trade price set for this product';
            }
        }

        var textPreview = document.getElementById('dtShareTextPreview');
        if (textPreview) { textPreview.value = sharePitch(currentShareProduct, custVal); }
    };

    window.copyShareDescription = function () {
        var preview = document.getElementById('dtShareTextPreview');
        if (preview) {
            preview.select();
            document.execCommand('copy');
            window.showToast('Copied description to clipboard!', 'success');
        }
    };

    window.shareOnWhatsAppDirect = function () {
        var preview = document.getElementById('dtShareTextPreview');
        var msg = preview ? preview.value : 'Check out this saree!';
        window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent(msg), '_blank');
    };

    // ════════════ 7. REELS MODAL ════════════
    window.openReelsModal = function (idx) {
        currentReelIndex = idx || 0;
        var overlay = document.getElementById('dtReelsModalOverlay');
        if (overlay) {
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    };

    window.closeReelsModal = function () {
        var overlay = document.getElementById('dtReelsModalOverlay');
        if (overlay) {
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    };

    window.navigateReel = function (dir) {
        currentReelIndex = (currentReelIndex + dir + 8) % 8;
        var poster = document.getElementById('dtReelPoster');
        var title = document.getElementById('dtReelProdTitle');
        if (poster) poster.src = '/assets/images/product' + (currentReelIndex + 1) + '.png';
        if (title) title.textContent = 'Luxury Handcrafted Saree Edit #' + (currentReelIndex + 1);
    };

    window.toggleReelLike = function () {
        var likeBtn = document.getElementById('dtReelLikeBtn');
        var count = document.getElementById('dtReelLikesCount');
        if (likeBtn && count) {
            count.textContent = '2.5k';
            window.showToast('Liked this video reel! ❤️');
        }
    };

    window.addCurrentReelToCart = function () {
        window.addToCart({
            id: (currentReelIndex % 8) + 1,
            name: 'Reels Exclusive Silk Saree',
            price: 4899,
            image: '/assets/images/product' + (currentReelIndex + 1) + '.png'
        }, 1, 'single');
        window.closeReelsModal();
        window.openCartDrawer();
    };

})();
