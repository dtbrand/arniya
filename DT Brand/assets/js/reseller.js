

function updateWholesaleCartBadge() {
    try {
        var raw = localStorage.getItem('dtbrands_cart');
        var cart = raw ? JSON.parse(raw) : [];
        var total = cart.reduce(function(acc, item) { return acc + (Number(item.qty) || 1); }, 0);
        var dockBadge = document.getElementById('wsDockCartBadge');
        var hdrBadge = document.getElementById('headerCartBadge');
        if (dockBadge) { dockBadge.textContent = total; dockBadge.style.display = total > 0 ? 'flex' : 'none'; }
        if (hdrBadge) { hdrBadge.textContent = total; hdrBadge.style.display = total > 0 ? 'block' : 'none'; }
    } catch(e) {}
}
window.updateWholesaleCartBadge = updateWholesaleCartBadge;

function updateWholesaleWishlistBadge() {
    try {
        var raw = localStorage.getItem('dtbrands_wishlist');
        var wl = raw ? JSON.parse(raw) : [];
        var total = wl.length;
        var badge = document.getElementById('headerWishlistBadge');
        if (badge) { badge.textContent = total; badge.style.display = total > 0 ? 'block' : 'none'; }
    } catch(e) {}
}
window.updateWholesaleWishlistBadge = updateWholesaleWishlistBadge;



        /* ── Target Gauge Animation ── */
        
function animateTargetGauge(pct) {
    try {
        var p = Number(pct) || 75.55;
        var valEl = document.getElementById('targetGaugeVal');
        var fillEl = document.getElementById('targetGaugeFill');
        if (valEl) valEl.textContent = p.toFixed(2) + '%';
        if (fillEl) {
            var totalLen = 251.2;
            var offset = totalLen - (totalLen * (p / 100));
            fillEl.style.strokeDashoffset = offset;
        }
    } catch(e) {}
}
window.animateTargetGauge = animateTargetGauge;


     // for global access
        'use strict';

        /* ── Reseller Initial Sample Orders Data ── */
        var SAMPLE_ORDERS = [
            {
                id: 'KLN-WS-8021',
                date: '14 Aug 2026',
                status: 'Shipped',
                productName: 'Nilambari Silk Saree (Pack of 12)',
                sku: 'KLN-SR-001',
                hsn: '5007',
                image: '/assets/images/product1.png',
                qty: 12,
                unitPrice: 3199,
                subtotal: 38388,
                tax: 1920,
                discount: 2000,
                total: 38308,
                payment: 'Bank NEFT / RTGS (Paid)',
                courier: 'BlueDart Express',
                awb: '884729104',
                color: 'Navy Blue (Lot Assorted)',
                size: 'Free Size'
            },
            {
                id: 'KLN-WS-7914',
                date: '10 Aug 2026',
                status: 'Delivered',
                productName: 'Banarasi Zari Saree (Pack of 8)',
                sku: 'KLN-SR-002',
                hsn: '5007',
                image: '/assets/images/product2.png',
                qty: 8,
                unitPrice: 5499,
                subtotal: 43992,
                tax: 2200,
                discount: 3000,
                total: 43192,
                payment: 'UPI on WhatsApp (Paid)',
                courier: 'Delhivery Surface',
                awb: 'DLV9928174',
                color: 'Maroon & Deep Wine',
                size: 'Free Size'
            },
            {
                id: 'KLN-WS-6540',
                date: '02 Aug 2026',
                status: 'Delivered',
                productName: 'Kanjivaram Temple Silk (Pack of 6)',
                sku: 'KLN-SR-003',
                hsn: '5007',
                image: '/assets/images/product3.png',
                qty: 6,
                unitPrice: 8499,
                subtotal: 50994,
                tax: 2550,
                discount: 4000,
                total: 49544,
                payment: 'Bank NEFT / RTGS (Paid)',
                courier: 'DTDC Priority Cargo',
                awb: 'DTDC773819',
                color: 'Golden Ochre',
                size: 'Free Size'
            },
            {
                id: 'KLN-WS-5912',
                date: '26 Jul 2026',
                status: 'Delivered',
                productName: 'Royal Anarkali Kurti Sets (Pack of 10)',
                sku: 'KLN-KT-005',
                hsn: '6204',
                image: '/assets/images/product5.png',
                qty: 10,
                unitPrice: 1799,
                subtotal: 17990,
                tax: 900,
                discount: 1000,
                total: 17890,
                payment: 'Cash on Delivery (COD)',
                courier: 'BlueDart Express',
                awb: 'BLU6619283',
                color: 'Teal & Emerald Assorted',
                size: 'S, M, L, XL'
            },
            {
                id: 'KLN-WS-4810',
                date: '18 Jul 2026',
                status: 'Processing',
                productName: 'Bridal Zardosi Velvet Lehenga (Pack of 2)',
                sku: 'KLN-LH-006',
                hsn: '6204',
                image: '/assets/images/product6.png',
                qty: 2,
                unitPrice: 16499,
                subtotal: 32998,
                tax: 1650,
                discount: 2000,
                total: 32648,
                payment: 'Advance 50% Deposit (Paid)',
                courier: 'Hand Craft Weaving Unit',
                awb: 'WEAVE-SRT-09',
                color: 'Crimson Red',
                size: 'Custom Tailored'
            },
            {
                id: 'KLN-WS-3120',
                date: '08 Jul 2026',
                status: 'Returned',
                productName: 'Georgette Bloom Saree (Pack of 10)',
                sku: 'KLN-SR-004',
                hsn: '5407',
                image: '/assets/images/product4.png',
                qty: 10,
                unitPrice: 2199,
                subtotal: 21990,
                tax: 1100,
                discount: 1500,
                total: 21590,
                payment: 'Refunded (₹21,590 credited)',
                courier: 'Return Pickup Completed',
                awb: 'RET99381',
                color: 'Peach Bloom',
                size: 'Free Size'
            }
        ];

        /* ── Sample Support Tickets ── */
        var SAMPLE_TICKETS = [
            {
                id: 'TCK-892',
                orderId: 'KLN-WS-8021',
                category: 'Logistics & Dispatch Inquiry',
                status: 'In Progress',
                message: 'Kindly ensure dispatch before Thursday for Surat wedding exhibition lot.',
                date: '14 Aug 2026'
            },
            {
                id: 'TCK-814',
                orderId: 'KLN-WS-7914',
                category: 'GST Input Tax Credit Query',
                status: 'Resolved',
                message: 'Received GSTR-1 invoice reflection in portal. Thank you for prompt assistance.',
                date: '11 Aug 2026'
            }
        ];

        var activeOrdersList = [];
        var activeTicketsList = [];
        var activeGstMode = 'gst';
        var currentOrderStatusFilter = 'all';

        /* ── Unified Luxury Designer Toast Helper ── */
        function showWsToast(msg, explicitType) {
            var container = document.getElementById('wsToastContainer') || document.getElementById('toastContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'wsToastContainer';
                container.className = 'ws-toast-container';
                document.body.appendChild(container);
            }

            var raw = String(msg || '').trim();
            var cleanText = raw.replace(/^[\u{1F300}-\u{1FAFF}\u{2600}-\u{27BF}\u{1F1E6}-\u{1F1FF}✨✓♡❤️🛒🛍️📦🏷️👗🥻📄📁🎫💳⚡🏦📍📋🚀🎉📩\s]+/u, '').trim();
            if (!cleanText) cleanText = raw;

            var lower = raw.toLowerCase();
            var badgeType = explicitType || 'success';
            var iconSvg = '';

            if (explicitType === 'cart' || lower.indexOf('cart') !== -1 || lower.indexOf('bag') !== -1 || lower.indexOf('lot') !== -1 || lower.indexOf('pcs') !== -1) {
                badgeType = 'cart';
                iconSvg = '<svg class="toast-svg-cart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>';
            } else if (explicitType === 'wishlist' || lower.indexOf('wishlist') !== -1 || lower.indexOf('saved') !== -1 || lower.indexOf('♡') !== -1 || lower.indexOf('❤️') !== -1 || lower.indexOf('heart') !== -1) {
                badgeType = 'wishlist';
                iconSvg = '<svg class="toast-svg-heart" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>';
            } else if (explicitType === 'filter' || lower.indexOf('filter') !== -1 || lower.indexOf('lots') !== -1 || lower.indexOf('category') !== -1 || lower.indexOf('saree') !== -1 || lower.indexOf('lehenga') !== -1 || lower.indexOf('kurti') !== -1 || lower.indexOf('available') !== -1) {
                badgeType = 'filter';
                iconSvg = '<svg class="toast-svg-sparkle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"></path><circle cx="12" cy="12" r="3" fill="#FAF5E8"></circle></svg>';
            } else if (explicitType === 'order' || lower.indexOf('order') !== -1 || lower.indexOf('tracking') !== -1 || lower.indexOf('awb') !== -1 || lower.indexOf('pdf') !== -1 || lower.indexOf('csv') !== -1 || lower.indexOf('statement') !== -1) {
                badgeType = 'order';
                iconSvg = '<svg class="toast-svg-package" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>';
            } else {
                badgeType = 'success';
                iconSvg = '<svg class="toast-svg-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';
            }

            var t = document.createElement('div');
            t.className = 'ws-toast toast';
            t.style.setProperty('--toast-duration', '3.2s');

            t.innerHTML = '<div class="ws-toast-icon-badge toast-icon-badge badge-' + badgeType + '">' +
                iconSvg +
                '</div>' +
                '<div class="ws-toast-msg toast-msg">' + cleanText + '</div>' +
                '<button type="button" class="ws-toast-close-btn toast-close-btn" aria-label="Close">✕</button>' +
                '<div class="ws-toast-progress toast-progress"></div>';

            var closeBtn = t.querySelector('.ws-toast-close-btn');
            if (closeBtn) {
                closeBtn.onclick = function(e) {
                    e.stopPropagation();
                    t.classList.add('hide');
                    setTimeout(function() { t.remove(); }, 250);
                };
            }

            container.appendChild(t);

            var timer = setTimeout(function() {
                t.classList.add('hide');
                setTimeout(function() { t.remove(); }, 250);
            }, 3200);

            t.onmouseenter = function() { clearTimeout(timer); };
            t.onmouseleave = function() {
                timer = setTimeout(function() {
                    t.classList.add('hide');
                    setTimeout(function() { t.remove(); }, 250);
                }, 1600);
            };
        }
        window.showWsToast = showWsToast;
        window.showToast = showWsToast;

        /* ── Role & Authentication Security Gate ── */
        function checkResellerSecurity() {
            var userRaw = localStorage.getItem('dtbrands_user');
            var gateModal = document.getElementById('wsRoleGateModal');

            if (!userRaw) {
                if (gateModal) gateModal.classList.add('active');
                return false;
            }

            try {
                var user = JSON.parse(userRaw);
                if (gateModal) gateModal.classList.remove('active');
                return true;
            } catch(e) {
                if (gateModal) gateModal.classList.add('active');
                return false;
            }
        }

        function initResellerApp() {
            var isAuth = checkResellerSecurity();
            if (!isAuth) return;
            if (typeof loadSavedResellerData === 'function') {
                loadSavedResellerData();
            }
        }
        window.initResellerApp = initResellerApp;

        function loginAsDemoReseller() {
            var demoReseller = {
                name: 'Pooja Sharma',
                companyName: 'Pooja Boutique & Ethnic Hub',
                phone: '+91 98765 12345',
                rawPhone: '9876512345',
                email: 'pooja.reseller@gmail.com',
                role: 'Reseller',
                gst_type: 'none',
                gst_number: '',
                address: 'Flat 302, Palm Heights, Link Road',
                city: 'Jaipur',
                state: 'Rajasthan',
                pincode: '302001'
            };
            localStorage.setItem('dtbrands_user', JSON.stringify(demoReseller));
            try { window.dispatchEvent(new Event('storage')); } catch(e) {}
            var gateModal = document.getElementById('wsRoleGateModal');
            if (gateModal) gateModal.classList.remove('active');
            initResellerApp();
            showWsToast('👑 Logged in as Verified Reseller (Pooja Sharma)!');
        };

        /* ── Universal Modal Show & Hide Engine ── */
        function showModal(modalId) {
            var modal = (typeof modalId === 'string') ? document.getElementById(modalId) : modalId;
            if (!modal) return;
            modal.classList.add('active');
            modal.style.setProperty('display', 'flex', 'important');
            modal.style.setProperty('opacity', '1', 'important');
            modal.style.setProperty('visibility', 'visible', 'important');
            modal.style.setProperty('pointer-events', 'auto', 'important');
            modal.style.setProperty('z-index', '2500000', 'important');
        };

        function hideModal(modalId) {
            var modal = (typeof modalId === 'string') ? document.getElementById(modalId) : modalId;
            if (!modal) return;
            modal.classList.remove('active');
            modal.style.removeProperty('display');
            modal.style.removeProperty('opacity');
            modal.style.removeProperty('visibility');
            modal.style.removeProperty('pointer-events');
            modal.style.removeProperty('z-index');
        };

        /* ── Reseller Wallet Controller ── */
        function openFullWalletModal() {
            showModal('wsFullWalletModal');
            var availEl = document.getElementById('walletAvailableBalance');
            var coinsEl = document.getElementById('walletTotalCoins');
            var mBal = document.getElementById('fullModalWalletBal');
            var mCoins = document.getElementById('fullModalCoinsBal');
            if (availEl && mBal) mBal.textContent = availEl.textContent;
            if (coinsEl && mCoins) mCoins.textContent = coinsEl.textContent + ' Coins';
        };

        function closeFullWalletModal() {
            hideModal('wsFullWalletModal');
        };

        function openVipTierModal() {
            showModal('wsVipTierModal');
        };

        function closeVipTierModal() {
            hideModal('wsVipTierModal');
        };

        function openWalletTopupModal() {
            showModal('wsWalletTopupModal');
        };

        function closeWalletTopupModal() {
            hideModal('wsWalletTopupModal');
        };

        /* ── Tab Navigation Controller ── */
        

        /* ── Mobile Sidebar Drawer ── */
        function toggleSidebar(force) {
            var sidebar = document.getElementById('wsSidebar');
            var backdrop = document.getElementById('wsSidebarBackdrop');
            if (!sidebar || !backdrop) return;

            var shouldOpen = (typeof force === 'boolean') ? force : !sidebar.classList.contains('open');
            sidebar.classList.toggle('open', shouldOpen);
            backdrop.classList.toggle('active', shouldOpen);
        };

        /* ── Load Reseller Profile & State ── */
        function loadSavedResellerData() {
            var userRaw = localStorage.getItem('dtbrands_user');
            var user = userRaw ? JSON.parse(userRaw) : {};

            var name = user.name || 'Rajesh Kumar';
            var company = user.companyName || 'Shree Krishna Silks Pvt Ltd';
            var phone = user.rawPhone || (user.phone ? user.phone.replace(/[^0-9]/g, '').slice(-10) : '9876543210');
            var email = user.email || 'rajesh@shreekrishnasilks.com';
            var gstType = user.gst_type || 'gst';
            var gstNum = user.gst_number || '24AABCU9603R1ZM';
            var address = user.address || 'Shop No. 402, 4th Floor, Millennium Textile Market 2, Ring Road';
            var city = user.city || 'Surat';
            var state = user.state || 'Gujarat';
            var pincode = user.pincode || '395002';

            var hdrName = document.getElementById('headerUserName');
            if (hdrName) hdrName.textContent = name;

            // Populate My Details form
            var profName = document.getElementById('wsProfName');
            var profPhone = document.getElementById('wsProfPhone');
            var profEmail = document.getElementById('wsProfEmail');
            if (profName) profName.value = name;
            if (profPhone) profPhone.value = phone;
            if (profEmail) profEmail.value = email;

            // Populate GST form
            selectGstMode(gstType);
            var compEl = document.getElementById('wsCompanyName');
            var gstEl = document.getElementById('wsGstNumber');
            if (compEl) compEl.value = company;
            if (gstEl) gstEl.value = gstNum;

            // Populate Address Book & Shipping data
            renderAddressBookData(user);
        };

        function toggleSameAsBillingAddress(isSame) {
            var notice = document.getElementById('wsSameAddressNotice');
            var customForm = document.getElementById('wsCustomShippingFormWrap');
            var statusPill = document.getElementById('wsSameAddressStatusPill');
            var chk = document.getElementById('wsSameAsBillingCheckbox');

            var shipWarehouse = document.getElementById('wsShipWarehouseName');
            var shipPhone = document.getElementById('wsShipReceiverPhone');
            var shipAddr = document.getElementById('wsShipAddress');
            var shipCity = document.getElementById('wsShipCity');
            var shipPin = document.getElementById('wsShipPincode');

            if (isSame) {
                if (chk) chk.checked = true;
                if (notice) notice.style.display = 'block';
                if (customForm) customForm.style.display = 'none';
                if (statusPill) {
                    statusPill.textContent = '✓ Default Active';
                    statusPill.style.background = '#DCFCE7';
                    statusPill.style.color = '#15803D';
                    statusPill.style.borderColor = '#BBF7D0';
                }
                if (shipWarehouse) shipWarehouse.required = false;
                if (shipPhone) shipPhone.required = false;
                if (shipAddr) shipAddr.required = false;
                if (shipCity) shipCity.required = false;
                if (shipPin) shipPin.required = false;
            } else {
                if (chk) chk.checked = false;
                if (notice) notice.style.display = 'none';
                if (customForm) customForm.style.display = 'block';
                if (statusPill) {
                    statusPill.textContent = '📦 Custom Godown Active';
                    statusPill.style.background = '#E0F2FE';
                    statusPill.style.color = '#0369A1';
                    statusPill.style.borderColor = '#BAE6FD';
                }
                if (shipWarehouse) shipWarehouse.required = true;
                if (shipPhone) shipPhone.required = true;
                if (shipAddr) shipAddr.required = true;
                if (shipCity) shipCity.required = true;
                if (shipPin) shipPin.required = true;
            }
        };

        // A first, shorter renderAddressBookData() stood here. It was shadowed by
        // the fuller definition further down (a later declaration of the same name
        // wins), so it never ran; the one kept below also fills the form inputs.
        function toggleEditAddressSection(sectionType) {
            var drawer = document.getElementById('wsAddressEditDrawer');
            var mainWrap = document.getElementById('wsMainAddressSectionWrap');
            var dispatchWrap = document.getElementById('wsDispatchSectionWrap');
            if (!drawer) return;

            // If already open for this section, toggle close
            var isAlreadyOpen = drawer.style.display === 'block' && (
                (sectionType === 'main' && mainWrap.style.display === 'block' && dispatchWrap.style.display !== 'block') ||
                (sectionType === 'dispatch' && dispatchWrap.style.display === 'block' && mainWrap.style.display !== 'block')
            );

            if (isAlreadyOpen) {
                closeEditAddressDrawer();
                return;
            }

            drawer.style.display = 'block';

            if (sectionType === 'main') {
                if (mainWrap) mainWrap.style.display = 'block';
                if (dispatchWrap) dispatchWrap.style.display = 'none';
                if (mainWrap) {
                    mainWrap.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    var firstInp = mainWrap.querySelector('input, textarea');
                    if (firstInp) firstInp.focus();
                }
            } else if (sectionType === 'dispatch') {
                if (mainWrap) mainWrap.style.display = 'none';
                if (dispatchWrap) dispatchWrap.style.display = 'block';
                if (dispatchWrap) {
                    dispatchWrap.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    var firstInp = dispatchWrap.querySelector('input, textarea');
                    if (firstInp) firstInp.focus();
                }
            } else {
                if (mainWrap) mainWrap.style.display = 'block';
                if (dispatchWrap) dispatchWrap.style.display = 'block';
            }
        };

        function closeEditAddressDrawer() {
            var drawer = document.getElementById('wsAddressEditDrawer');
            var mainWrap = document.getElementById('wsMainAddressSectionWrap');
            var dispatchWrap = document.getElementById('wsDispatchSectionWrap');
            if (drawer) drawer.style.display = 'none';
            if (mainWrap) mainWrap.style.display = 'none';
            if (dispatchWrap) dispatchWrap.style.display = 'none';
        };

        function renderAddressBookData(user) {
            var comp = user.companyName || 'Shree Krishna Silks Pvt Ltd';
            var gstNum = user.gst_number || '24AABCU9603R1ZM';
            var name = user.name || 'Rajesh Kumar';
            var phone = user.rawPhone || (user.phone ? user.phone.replace(/[^0-9]/g, '').slice(-10) : '9876543210');
            var billAddr = user.address || 'Shop No. 402, 4th Floor, Millennium Textile Market 2, Ring Road';
            var billCity = user.city || 'Surat';
            var billState = user.state || 'Gujarat';
            var billPin = user.pincode || '395002';

            // Populate Section 1 form inputs
            var mComp = document.getElementById('wsMainCompName');
            var mPhone = document.getElementById('wsMainContactPhone');
            var mAddr = document.getElementById('wsFullAddress');
            var mCity = document.getElementById('wsCity');
            var mState = document.getElementById('wsStateSelect');
            var mPin = document.getElementById('wsPincode');

            if (mComp) mComp.value = comp;
            if (mPhone) mPhone.value = phone;
            if (mAddr) mAddr.value = billAddr;
            if (mCity) mCity.value = billCity;
            if (mState && billState) mState.value = billState;
            if (mPin) mPin.value = billPin;

            // Populate Card 1 preview
            var bCompEl = document.getElementById('addrPreviewBillingComp');
            var bFullEl = document.getElementById('addrPreviewBillingFull');
            var bAttnEl = document.getElementById('addrPreviewBillingAttn');
            if (bCompEl) bCompEl.textContent = comp;
            if (bFullEl) bFullEl.innerHTML = `${billAddr}<br>${billCity}, ${billState} - ${billPin} (GSTIN: <strong>${gstNum}</strong>)`;
            if (bAttnEl) bAttnEl.textContent = `Attn: ${name} (+91 ${phone})`;

            // Populate Section 2 toggle and shipping inputs
            var isSame = user.shipping_same_as_billing !== false;
            var chk = document.getElementById('wsSameAsBillingCheckbox');
            if (chk) chk.checked = isSame;
            toggleSameAsBillingAddress(isSame);

            var dispatchBadge = document.getElementById('addrPreviewDispatchBadge');
            var dispatchTitle = document.getElementById('addrPreviewDispatchTitle');
            var dispatchFull = document.getElementById('addrPreviewDispatchFull');
            var dispatchTrans = document.getElementById('addrPreviewDispatchTransporter');

            var ship = user.custom_shipping || {};
            if (!isSame && ship.address) {
                if (dispatchBadge) dispatchBadge.textContent = '📦 Dispatch: Custom Godown';
                if (dispatchTitle) dispatchTitle.textContent = ship.warehouse_name || 'Primary Godown Hub';
                if (dispatchFull) dispatchFull.innerHTML = `${ship.address}<br>${ship.city || billCity}, ${ship.state || billState} - ${ship.pincode || billPin} • Ph: ${ship.receiver_phone || phone}`;
                if (dispatchTrans) dispatchTrans.textContent = 'Preferred Hub: ' + (ship.transporter || 'Surat Goods Transporter');

                var shipWarehouse = document.getElementById('wsShipWarehouseName');
                var shipPhone = document.getElementById('wsShipReceiverPhone');
                var shipAddr = document.getElementById('wsShipAddress');
                var shipCity = document.getElementById('wsShipCity');
                var shipState = document.getElementById('wsShipStateSelect');
                var shipPin = document.getElementById('wsShipPincode');
                var shipTransporter = document.getElementById('wsShipTransporter');

                if (shipWarehouse) shipWarehouse.value = ship.warehouse_name || '';
                if (shipPhone) shipPhone.value = ship.receiver_phone || '';
                if (shipAddr) shipAddr.value = ship.address || '';
                if (shipCity) shipCity.value = ship.city || '';
                if (shipState && ship.state) shipState.value = ship.state;
                if (shipPin) shipPin.value = ship.pincode || '';
                if (shipTransporter) shipTransporter.value = ship.transporter || '';
            } else {
                if (dispatchBadge) dispatchBadge.textContent = '📦 Dispatch: Same as Billing';
                if (dispatchTitle) dispatchTitle.textContent = 'Direct Storefront Delivery';
                if (dispatchFull) dispatchFull.innerHTML = `Dispatched to GST registered address: ${billAddr}, ${billCity} - ${billPin}`;
                if (dispatchTrans) dispatchTrans.textContent = 'Preferred Hub: BlueDart Express / Surat Goods Transporter';
            }
        }

        function handleSaveAddress(e) {
            if (e) e.preventDefault();
            var userRaw = localStorage.getItem('dtbrands_user');
            var user = userRaw ? JSON.parse(userRaw) : {};

            // Save Section 1: Main Address (if entered/updated)
            var mComp = document.getElementById('wsMainCompName') ? document.getElementById('wsMainCompName').value.trim() : '';
            var mPhone = document.getElementById('wsMainContactPhone') ? document.getElementById('wsMainContactPhone').value.trim() : '';
            var mAddr = document.getElementById('wsFullAddress') ? document.getElementById('wsFullAddress').value.trim() : '';
            var mCity = document.getElementById('wsCity') ? document.getElementById('wsCity').value.trim() : '';
            var mState = document.getElementById('wsStateSelect') ? document.getElementById('wsStateSelect').value : 'Gujarat';
            var mPin = document.getElementById('wsPincode') ? document.getElementById('wsPincode').value.trim() : '';

            if (mComp) user.companyName = mComp;
            if (mPhone) { user.rawPhone = mPhone; user.phone = '+91 ' + mPhone; }
            if (mAddr) user.address = mAddr;
            if (mCity) user.city = mCity;
            if (mState) user.state = mState;
            if (mPin) user.pincode = mPin;

            // Save Section 2: Shipping / Dispatch
            var isSame = document.getElementById('wsSameAsBillingCheckbox') ? document.getElementById('wsSameAsBillingCheckbox').checked : true;
            user.shipping_same_as_billing = isSame;

            if (!isSame) {
                var wName = document.getElementById('wsShipWarehouseName') ? document.getElementById('wsShipWarehouseName').value.trim() : '';
                var rPhone = document.getElementById('wsShipReceiverPhone') ? document.getElementById('wsShipReceiverPhone').value.trim() : '';
                var sAddr = document.getElementById('wsShipAddress') ? document.getElementById('wsShipAddress').value.trim() : '';
                var sCity = document.getElementById('wsShipCity') ? document.getElementById('wsShipCity').value.trim() : '';
                var sState = document.getElementById('wsShipStateSelect') ? document.getElementById('wsShipStateSelect').value : 'Gujarat';
                var sPin = document.getElementById('wsShipPincode') ? document.getElementById('wsShipPincode').value.trim() : '';
                var sTrans = document.getElementById('wsShipTransporter') ? document.getElementById('wsShipTransporter').value.trim() : '';

                user.custom_shipping = {
                    warehouse_name: wName || 'Primary Godown Hub',
                    receiver_phone: rPhone || mPhone,
                    address: sAddr || mAddr,
                    city: sCity || mCity,
                    state: sState || mState,
                    pincode: sPin || mPin,
                    transporter: sTrans
                };
            }

            localStorage.setItem('dtbrands_user', JSON.stringify(user));
            closeEditAddressDrawer();
            renderAddressBookData(user);
            loadSavedResellerData();
            showWsToast('✓ Address configuration saved successfully!');
        };

        /* ── GST Mode Toggle ── */
        function selectGstMode(mode) {
            activeGstMode = mode;
            var cardGst = document.getElementById('gstCardGst');
            var cardNonGst = document.getElementById('gstCardNonGst');
            var compFieldWrap = document.getElementById('wsCompanyNameFieldWrap');
            var gstNumberWrap = document.getElementById('gstNumberFieldWrap');
            var nonGstNoticeWrap = document.getElementById('nonGstNoticeWrap');
            var compInput = document.getElementById('wsCompanyName');
            var gstInput = document.getElementById('wsGstNumber');

            if (mode === 'gst') {
                if (cardGst) cardGst.classList.add('selected');
                if (cardNonGst) cardNonGst.classList.remove('selected');
                if (compFieldWrap) compFieldWrap.style.display = 'flex';
                if (gstNumberWrap) gstNumberWrap.style.display = 'flex';
                if (nonGstNoticeWrap) nonGstNoticeWrap.style.display = 'none';
                if (compInput) compInput.required = true;
                if (gstInput) gstInput.required = true;
            } else {
                if (cardGst) cardGst.classList.remove('selected');
                if (cardNonGst) cardNonGst.classList.add('selected');
                if (compFieldWrap) compFieldWrap.style.display = 'none';
                if (gstNumberWrap) gstNumberWrap.style.display = 'none';
                if (nonGstNoticeWrap) nonGstNoticeWrap.style.display = 'block';
                if (compInput) compInput.required = false;
                if (gstInput) gstInput.required = false;
            }
        };

        /* ── Indian GSTIN Validation ── */
        function validateGstinInput(input) {
            var val = input.value.toUpperCase().replace(/[^0-9A-Z]/g, '');
            input.value = val;
            var stateTag = document.getElementById('gstStateDetectTag');

            var stateMap = {
                '01': 'Jammu & Kashmir', '02': 'Himachal Pradesh', '03': 'Punjab', '04': 'Chandigarh',
                '05': 'Uttarakhand', '06': 'Haryana', '07': 'Delhi', '08': 'Rajasthan',
                '09': 'Uttar Pradesh', '10': 'Bihar', '18': 'Assam', '19': 'West Bengal',
                '20': 'Jharkhand', '21': 'Odisha', '22': 'Chhattisgarh', '23': 'Madhya Pradesh',
                '24': 'Gujarat', '27': 'Maharashtra', '29': 'Karnataka', '30': 'Goa',
                '32': 'Kerala', '33': 'Tamil Nadu', '36': 'Telangana', '37': 'Andhra Pradesh'
            };

            if (val.length >= 2) {
                var prefix = val.substring(0, 2);
                var detectedState = stateMap[prefix];
                if (detectedState && stateTag) {
                    stateTag.textContent = '📍 State: ' + detectedState + ' (' + prefix + ')';
                }
            }
        };

        /* ── Render Orders Table & Mobile Cards ── */
        function getWsStatusBadgeHtml(status) {
            var s = (status || '').toLowerCase();
            if (s === 'delivered') {
                return `<span class="ws-status-badge delivered" style="display:inline-flex; align-items:center; gap:3px;"><svg style="width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.5;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg> DELIVERED</span>`;
            }
            if (s === 'shipped') {
                return `<span class="ws-status-badge shipped" style="display:inline-flex; align-items:center; gap:3px;"><svg style="width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.5;" viewBox="0 0 24 24"><path d="M1 3h15v13H1z"></path><path d="M16 8h4l3 3v5h-7V8z"></path><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg> SHIPPED</span>`;
            }
            if (s === 'processing') {
                return `<span class="ws-status-badge processing" style="display:inline-flex; align-items:center; gap:3px;"><svg style="width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.5;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> PROCESSING</span>`;
            }
            return `<span class="ws-status-badge ${s}">${status}</span>`;
        }

        function renderOrdersView(orders) {
            var tbody = document.getElementById('wsOrdersTbody');
            var mobContainer = document.getElementById('wsMobileOrdersCards');
            var overviewContainer = document.getElementById('overviewOrdersContainer');

            if (!tbody || !mobContainer) return;

            tbody.innerHTML = '';
            mobContainer.innerHTML = '';

            if (orders.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:30px; color:#6B6358;">No matching reseller orders found.</td></tr>';
                mobContainer.innerHTML = '<div style="text-align:center; padding:30px; color:#6B6358; font-weight:600;">No matching orders found.</div>';
                return;
            }

            orders.forEach(function(o) {
                var badgeHtml = getWsStatusBadgeHtml(o.status);

                // 1. Desktop Row
                var tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="ws-order-id-cell"><span style="font-weight:800; padding:2px 7px; background:#FAF8F4; border:1px solid rgba(212,175,55,0.3); border-radius:6px;">${o.id}</span></td>
                    <td style="color:#6B6358; font-weight:600; font-size:0.78rem;">${o.date}</td>
                    <td>
                        <div class="ws-prod-mini-cell">
                            <img src="${o.image}" alt="${o.productName}" class="ws-prod-mini-img" onerror="this.onerror=null;this.src='/assets/images/no-image.svg';">
                            <div>
                                <strong style="font-size:0.84rem; color:var(--ws-text-main); font-family:var(--ws-font-serif);">${o.productName}</strong>
                                <div style="font-size:0.72rem; color:var(--ws-text-muted);">SKU: ${o.sku} • ${o.courier}</div>
                            </div>
                        </div>
                    </td>
                    <td><strong style="font-size:0.84rem;">${o.qty} Pcs</strong></td>
                    <td><strong style="color:var(--ws-gold-primary); font-size:0.92rem;">₹${Number(o.total).toLocaleString('en-IN')}</strong></td>
                    <td>${badgeHtml}</td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <button class="ws-btn ws-btn-secondary ws-btn-sm" style="font-weight:700;" onclick='viewOrderDetails(${JSON.stringify(o)})'>
                                Details
                            </button>
                            <button class="ws-btn ws-btn-primary ws-btn-sm" style="font-weight:700;" onclick='openBillInvoiceModal(${JSON.stringify(o)})'>
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" style="display:inline-block; vertical-align:middle;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> <span>Invoice</span>
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);

                // 2. Mobile Card
                var card = document.createElement('div');
                card.className = 'ws-mob-order-card';
                card.innerHTML = `
                    <div class="ws-mob-order-top">
                        <span class="ws-order-id-cell" style="font-size:0.84rem; font-weight:800; padding:2px 7px; background:#FAF8F4; border:1px solid rgba(212,175,55,0.3); border-radius:6px;">${o.id}</span>
                        ${badgeHtml}
                    </div>
                    <div class="ws-mob-order-body">
                        <img src="${o.image}" alt="${o.productName}" class="ws-mob-order-img" onerror="this.onerror=null;this.src='/assets/images/no-image.svg';">
                        <div class="ws-mob-order-info">
                            <h4 class="ws-mob-order-title">${o.productName}</h4>
                            <div class="ws-mob-order-meta"><span style="color:#B45309; font-weight:700;">${o.date}</span> • Lot: <strong>${o.qty} Pcs</strong></div>
                            <div class="ws-mob-order-meta">${o.courier} (AWB: ${o.awb})</div>
                            <div class="ws-mob-order-price-row" style="margin-top:2px;">
                                <span class="ws-mob-order-price">₹${Number(o.total).toLocaleString('en-IN')}</span>
                            </div>
                        </div>
                    </div>
                    <div class="ws-mob-order-actions">
                        <button class="ws-btn ws-btn-secondary ws-btn-sm" style="font-weight:700; display:inline-flex; align-items:center; justify-content:center; gap:4px;" onclick='viewOrderDetails(${JSON.stringify(o)})'>
                            <svg style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg> Details
                        </button>
                        <button class="ws-btn ws-btn-primary ws-btn-sm" style="font-weight:700; display:inline-flex; align-items:center; justify-content:center; gap:4px;" onclick='openBillInvoiceModal(${JSON.stringify(o)})'>
                            <svg style="width:13px;height:13px;stroke:#FFFFFF;fill:none;stroke-width:2;" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg> GST Invoice
                        </button>
                    </div>
                `;
                mobContainer.appendChild(card);
            });

            // Populate Overview Recent Snapshot (First 3)
            if (overviewContainer) {
                overviewContainer.innerHTML = '';
                var recent3 = orders.slice(0, 3);
                var overList = document.createElement('div');
                overList.className = 'ws-mobile-order-cards';
                overList.style.display = 'flex';
                recent3.forEach(function(o) {
                    var badgeHtml = getWsStatusBadgeHtml(o.status);
                    var card = document.createElement('div');
                    card.className = 'ws-mob-order-card';
                    card.innerHTML = `
                        <div class="ws-mob-order-top">
                            <span class="ws-order-id-cell" style="font-size:0.84rem; font-weight:800; padding:2px 7px; background:#FAF8F4; border:1px solid rgba(212,175,55,0.3); border-radius:6px;">${o.id}</span>
                            ${badgeHtml}
                        </div>
                        <div class="ws-mob-order-body">
                            <img src="${o.image}" alt="${o.productName}" class="ws-mob-order-img" onerror="this.onerror=null;this.src='/assets/images/no-image.svg';">
                            <div class="ws-mob-order-info">
                                <h4 class="ws-mob-order-title">${o.productName}</h4>
                                <div class="ws-mob-order-meta"><span style="color:#B45309; font-weight:700;">${o.date}</span> • Lot: <strong>${o.qty} Pcs</strong></div>
                                <div class="ws-mob-order-meta">${o.courier} (AWB: ${o.awb})</div>
                                <div class="ws-mob-order-price-row" style="margin-top:6px; display:flex; justify-content:space-between; align-items:center;">
                                    <span class="ws-mob-order-price">₹${Number(o.total).toLocaleString('en-IN')}</span>
                                    <button class="ws-btn ws-btn-primary ws-btn-sm" style="font-weight:700; display:inline-flex; align-items:center; gap:4px;" onclick='openBillInvoiceModal(${JSON.stringify(o)})'>
                                        <svg style="width:12px;height:12px;stroke:#FFFFFF;fill:none;stroke-width:2;" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg> GST Invoice
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    overList.appendChild(card);
                });
                overviewContainer.appendChild(overList);
            }
        }

        /* ── Helper: Get Tier ── */
        function getWholesaleTier(ordersCount) {
            if (ordersCount >= 800) return { name: 'Tier 5', tag: 'PLATINUM', discount: '15%' };
            if (ordersCount >= 450) return { name: 'Tier 4', tag: 'DIAMOND', discount: '12.5%' };
            if (ordersCount >= 250) return { name: 'Tier 3', tag: 'GOLD', discount: '10%' };
            if (ordersCount >= 50) return { name: 'Tier 2', tag: 'SILVER', discount: '5%' };
            return { name: 'Tier 1', tag: 'NON VIP', discount: '0%' };
        };

        /* ── Helper: Open VIP Modal ── */
        function openVipTierModal() {
            var modal = document.getElementById('wsVipTierModal');
            if (modal) modal.classList.add('active');
        };

        /* ── Filter Orders Controller ── */
        function filterOrdersTable() {
            var input = document.getElementById('wsOrdersSearchInput');
            var search = (input ? input.value : '').toLowerCase().trim();
            var clearBtn = document.getElementById('wsOrdersSearchClear');
            if (clearBtn) clearBtn.style.display = search ? 'flex' : 'none';

            var filtered = activeOrdersList.filter(function(o) {
                var matchStatus = (currentOrderStatusFilter === 'all') || (o.status.toLowerCase() === currentOrderStatusFilter.toLowerCase());
                var matchSearch = !search || 
                    o.id.toLowerCase().includes(search) || 
                    o.productName.toLowerCase().includes(search) || 
                    o.courier.toLowerCase().includes(search) || 
                    o.awb.toLowerCase().includes(search);
                return matchStatus && matchSearch;
            });
            renderOrdersView(filtered);
        };

        function clearOrdersSearch() {
            var input = document.getElementById('wsOrdersSearchInput');
            if (input) {
                input.value = '';
                input.focus();
            }
            var clearBtn = document.getElementById('wsOrdersSearchClear');
            if (clearBtn) clearBtn.style.display = 'none';
            filterOrdersTable();
        };

        function setOrderStatusFilter(status, btn) {
            currentOrderStatusFilter = status;
            btn.parentElement.querySelectorAll('button').forEach(function(b) {
                b.classList.remove('active');
            });
            if (btn) btn.classList.add('active');
            filterOrdersTable();
        };

        /* ════════════════════════════════════════════════════
           ANALYTICS ENGINE: MODES (OVERVIEW/SALES/REVENUE) & DATE RANGES
        ════════════════════════════════════════════════════ */
        var analyticsMode = 'overview';
        var currentSelectedDateRange = 'week';

        var WS_ICONS = {
            calendar: '<svg class="ws-ico gold" style="margin-right:4px;" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>',
            dress: '<svg class="ws-ico gold" style="margin-right:5px;" viewBox="0 0 24 24"><path d="M20.38 3.46L16 2 12 5.5 8 2l-4.38 1.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"></path></svg>',
            lightning: '<svg class="ws-ico gold ws-ico-sm" style="margin-right:3px;" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>',
            target: '<svg class="ws-ico gold ws-ico-sm" style="margin-right:3px;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>',
            crown: '<svg class="ws-ico" style="width:13px;height:13px;margin-right:3px;stroke:#FFFFFF;" viewBox="0 0 24 24"><polygon points="2 4 5 18 19 18 22 4 16 11 12 2 8 11 2 4"></polygon></svg>',
            shield: '<svg class="ws-ico gold ws-ico-sm" style="margin-right:3px;" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>',
            repeat: '<svg class="ws-ico gold ws-ico-sm" style="margin-right:3px;" viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><polyline points="7 23 3 19 7 15"></polyline><path d="M21 13v2a4 4 0 0 1-4 4H3"></path></svg>',
            package: '<svg class="ws-ico" style="width:13px;height:13px;margin-right:3px;stroke:#FFFFFF;" viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>',
            card: '<svg class="ws-ico" style="width:13px;height:13px;margin-right:3px;stroke:#FFFFFF;" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>'
        };

        var ANALYTICS_DATA = {
            'overview': {
                'today': {
                    sub: "Today's Live Reseller Performance, Earnings & Customer Dispatches",
                    cards: [
                        { label: "Reseller Tier", val: "Tier 1", pill: "Active", isGold: true },
                        { label: "Today's Resale Orders", val: "1 Order", pill: "Dispatched", isGold: false },
                        { label: "Customer Units", val: "6 Pcs", pill: "100% Packed", isGold: false },
                        { label: "Today's Profit Earned", val: "₹4,550", pill: "↑ 25% Margin", isGold: true }
                    ],
                    chartTitle: "Today's Hourly Resale Volume (Units)",
                    barActive: 7,
                    gauge: { pct: "36.4%", offset: 150, badge: "Today", desc: "You generated <strong>₹18,200</strong> in customer resale orders today with <strong>₹4,550</strong> profit earned.", target: "₹50K", rev: "₹18.2K", today: "₹4.55K" },
                    catTitle: WS_ICONS.dress + " Today's Resale Mix by Category",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹18,200 (Margin: ₹4,550)", fill: 100 }
                    ],
                    kpis: [
                        { label: "Today's Resale Value", num: "₹18,200", sub: WS_ICONS.lightning + " 1 Customer Order" },
                        { label: "Estimated Margin", num: "₹4,550", sub: "25.0% Net Profit" },
                        { label: "Dispatch Speed", num: "Same Day", sub: "AWB: 884729104" },
                        { label: "Delivery ETA", num: "Tomorrow", sub: "Priority Air" }
                    ],
                    milestoneBadge: "Tier 1: Active Reseller",
                    milestoneVal: "Tier 1: Active Reseller",
                    milestoneDesc: "Complete <strong>44 more orders</strong> to automatically unlock <strong>Tier 2: Silver Reseller</strong> with an extra +3% margin rebate!"
                },
                'week': {
                    sub: "Weekly Reseller Sales, Margin Growth & Order Delivery Performance",
                    cards: [
                        { label: "Reseller Tier", val: "Tier 1", pill: "Active", isGold: true },
                        { label: "Customer Orders", val: "6 Orders", pill: "↑ 14.20%", isGold: false },
                        { label: "Units Resold", val: "48 Pcs", pill: "↑ 8.50%", isGold: false },
                        { label: "Weekly Margin Earned", val: "₹58,400", pill: "↑ 28.5% Margin", isGold: true }
                    ],
                    chartTitle: "Weekly Resale Volume",
                    barActive: 7,
                    gauge: { pct: "75.55%", offset: 58, badge: "+10%", desc: "You earned <strong>₹32,870</strong> profit today, higher than last week. Keep growing your boutique catalog shares!", target: "₹50K ↓", rev: "₹48.5K ↑", today: "₹18.2K ↑" },
                    catTitle: WS_ICONS.dress + " Category Resale Breakdown",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹1,14,500 (56%)", fill: 88 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹49,147 (24%)", fill: 72 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹25,825 (13%)", fill: 95 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹15,590 (7%)", fill: 60 }
                    ],
                    kpis: [
                        { label: "Avg. Reseller Margin", num: "28.5%", sub: "↑ 3.2% vs last month" },
                        { label: "Customer Delivery TAT", num: "1.8 Days", sub: WS_ICONS.lightning + " Express Customer Dispatch" },
                        { label: "Share Conversion", num: "14.8%", sub: WS_ICONS.repeat + " 342 WhatsApp Shares" },
                        { label: "Customer Repeat Rate", num: "88.5%", sub: WS_ICONS.repeat + " 4.9 ★ Buyer Rating" }
                    ],
                    milestoneBadge: "Tier 1: Active Reseller",
                    milestoneVal: "Tier 1: Active Reseller",
                    milestoneDesc: "Complete <strong>44 more orders</strong> to automatically unlock <strong>Tier 2: Silver Reseller</strong> with an extra +3% margin rebate!"
                },
                'month': {
                    sub: "Monthly Reseller Sales, Net Earnings & Buyer Retention",
                    cards: [
                        { label: "Reseller Tier", val: "Tier 1", pill: "Active", isGold: true },
                        { label: "Monthly Orders", val: "14 Orders", pill: "↑ 21.00%", isGold: false },
                        { label: "Total Units Sold", val: "112 Pcs", pill: "↑ 16.80%", isGold: false },
                        { label: "Monthly Profit Earned", val: "₹1,36,220", pill: "↑ 28.0% Margin", isGold: true }
                    ],
                    chartTitle: "August 2026 Resale Revenue",
                    barActive: 7,
                    gauge: { pct: "97.30%", offset: 7, badge: "+18.2%", desc: "Monthly customer resale volume tracking ahead by <strong>+18.2%</strong>!", target: "₹500K", rev: "₹486.5K ↑", today: "₹32.8K ↑" },
                    catTitle: WS_ICONS.dress + " August Category Resale Breakdown",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹2,72,000 (56%)", fill: 92 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹1,18,500 (24%)", fill: 84 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹62,000 (13%)", fill: 98 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹34,000 (7%)", fill: 75 }
                    ],
                    kpis: [
                        { label: "Avg. Order Value", num: "₹34,750", sub: "↑ 15.1% growth" },
                        { label: "Avg. Profit per Order", num: "₹9,730", sub: "28.0% Net Margin" },
                        { label: "Delivery Success Rate", num: "98.6%", sub: WS_ICONS.shield + " Zero RTO Returns" },
                        { label: "Repeat Customer Index", num: "87.5%", sub: WS_ICONS.repeat + " 12 of 14 Repeat Buyers" }
                    ],
                    milestoneBadge: "Tier 1: Active Reseller",
                    milestoneVal: "Tier 1: Active Reseller",
                    milestoneDesc: "Complete <strong>36 more orders</strong> to automatically unlock <strong>Tier 2: Silver Reseller</strong> with an extra +3% margin rebate!"
                },
                'last_month': {
                    sub: "July 2026 Reconciled Reseller Performance & Profit Payouts",
                    cards: [
                        { label: "Reseller Tier", val: "Tier 1", pill: "Settled", isGold: true },
                        { label: "July Orders", val: "11 Orders", pill: "100% Delivered", isGold: false },
                        { label: "Units Sold", val: "88 Pcs", pill: "Received", isGold: false },
                        { label: "July Profit Realized", val: "₹1,09,870", pill: "Settled", isGold: true }
                    ],
                    chartTitle: "July 2026 Final Settlement",
                    barActive: 6,
                    gauge: { pct: "100%", offset: 0, badge: "100% Done", desc: "July sales and reseller margins 100% settled and paid to bank account!", target: "₹350K", rev: "₹392.4K", today: "Closed" },
                    catTitle: WS_ICONS.dress + " July 2026 Resale Breakdown",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹2,19,000 (56%)", fill: 100 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹94,000 (24%)", fill: 100 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹51,400 (13%)", fill: 100 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹28,000 (7%)", fill: 100 }
                    ],
                    kpis: [
                        { label: "Avg. Order Value", num: "₹35,672", sub: "Final Settled" },
                        { label: "Net Profit Realized", num: "₹1,09,870", sub: "Paid to Bank A/C" },
                        { label: "Customer Delivery TAT", num: "2.1 Days", sub: "100% Delivered" },
                        { label: "Customer Repeat Rate", num: "90.9%", sub: WS_ICONS.repeat + " 10 of 11 Repeat Buyers" }
                    ],
                    milestoneBadge: "Tier 1: Active Reseller",
                    milestoneVal: "Tier 1: Active Reseller",
                    milestoneDesc: "July 2026 orders settled. Complete <strong>44 more orders</strong> to unlock <strong>Tier 2: Silver Reseller</strong>!"
                },
                'year': {
                    sub: "Financial Year 2026-27 Cumulative Reseller Performance & Growth",
                    cards: [
                        { label: "Reseller Tier", val: "Tier 2 (Silver)", pill: "FY26-27", isGold: true },
                        { label: "Annual Orders", val: "58 Orders", pill: "↑ 34.5%", isGold: false },
                        { label: "Total Units Resold", val: "464 Pcs", pill: "↑ 28.2%", isGold: false },
                        { label: "Annual Profit Earned", val: "₹5,55,600", pill: "↑ 28.0% Margin", isGold: true }
                    ],
                    chartTitle: "FY 2026-27 Resale Revenue Peak",
                    barActive: 9,
                    gauge: { pct: "79.37%", offset: 48, badge: "+31.8%", desc: "Annual resale volume on track to exceed ₹25 Lakhs milestone with ₹7L+ margin!", target: "₹2.5M", rev: "₹1.98M ↑", today: "Live" },
                    catTitle: WS_ICONS.dress + " FY 2026-27 Category Sales Mix",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹11,10,000 (56%)", fill: 82 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹4,76,000 (24%)", fill: 76 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹2,58,000 (13%)", fill: 90 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹1,40,300 (7%)", fill: 68 }
                    ],
                    kpis: [
                        { label: "Annual Avg. Order", num: "₹34,212", sub: "58 Customer Orders" },
                        { label: "Annual Net Margin", num: "₹5,55,600", sub: "28.0% Avg Margin" },
                        { label: "Delivery Success Rate", num: "99.1%", sub: WS_ICONS.shield + " Air Express Dispatch" },
                        { label: "Top Reseller Retention", num: "89.6%", sub: "Elite Reseller Status" }
                    ],
                    milestoneBadge: "Tier 2: Silver (Active)",
                    milestoneVal: "Tier 2: Silver Member",
                    milestoneDesc: "Complete <strong>192 more orders</strong> to automatically unlock <strong>Tier 3: Gold Reseller (250+ Orders)</strong>!"
                }
            },
            'sales': {
                'today': {
                    sub: "Today's Reseller Units Sold, Catalog Shares & Dispatches",
                    cards: [
                        { label: "Active SKUs Shared", val: "1 SKU", pill: "Kanjivaram", isGold: true },
                        { label: "Units Sold", val: "6 Pcs", pill: "100% QC Passed", isGold: false },
                        { label: "Customer Shares", val: "48 Shares", pill: "WhatsApp", isGold: false },
                        { label: "Delivery Mode", val: "Air Express", pill: "BlueDart", isGold: true }
                    ],
                    chartTitle: "Today's Customer Dispatches (Pcs)",
                    barActive: 7,
                    gauge: { pct: "100%", offset: 0, badge: "100%", desc: "Today's customer orders dispatched with 100% luxury packaging.", target: "6 Pcs", rev: "6 Pcs", today: "6 Pcs" },
                    catTitle: WS_ICONS.dress + " Units Sold by Category (Pcs)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "6 Pcs (100%)", fill: 100 }
                    ],
                    kpis: [
                        { label: "Units Dispatched", num: "6 Pcs", sub: "BlueDart Air" },
                        { label: "QC & Craft Inspection", num: "100% Passed", sub: "Silk Mark Certified" },
                        { label: "Luxury Packaging", num: "Waterproof Box", sub: "Tamper Evident" },
                        { label: "Share Conversion", num: "12.5%", sub: "6 Orders / 48 Shares" }
                    ],
                    milestoneBadge: WS_ICONS.package + " Daily Sales Target",
                    milestoneVal: "6 Pcs <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ 10 Pcs</span>",
                    milestoneDesc: "<strong>60%</strong> of daily customer fulfillment capacity reached."
                },
                'week': {
                    sub: "Weekly Unit Sales, Catalog Shares & Fulfillment Volume",
                    cards: [
                        { label: "Active Shared SKUs", val: "6 Trending", pill: "Top Shared", isGold: true },
                        { label: "Units Dispatched", val: "48 Pcs", pill: "↑ 22.5%", isGold: false },
                        { label: "Orders In Transit", val: "10 Pcs", pill: "Customer Bound", isGold: false },
                        { label: "Delivered to Buyers", val: "38 Pcs", pill: "↑ 18.0%", isGold: true }
                    ],
                    chartTitle: "Weekly Customer Unit Sales (Pcs)",
                    barActive: 7,
                    gauge: { pct: "80.00%", offset: 47, badge: "+15%", desc: "48 luxury couture units delivered to customers across 6 catalog lots this week.", target: "60 Pcs", rev: "48 Pcs", today: "6 Pcs" },
                    catTitle: WS_ICONS.dress + " Weekly Category Units Sold (Pcs)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "26 Pcs (54%)", fill: 86 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "8 Pcs (17%)", fill: 80 },
                        { name: "Royal Anarkali Kurti Sets", val: "10 Pcs (21%)", fill: 100 },
                        { name: "Georgette & Chanderi Fabrics", val: "4 Pcs (8%)", fill: 50 }
                    ],
                    kpis: [
                        { label: "Total Units Dispatched", num: "48 Pcs", sub: "6 Customer Dispatches" },
                        { label: "Catalog Shares", num: "342 Shares", sub: "WhatsApp / Instagram" },
                        { label: "Defect Return Rate", num: "0.0%", sub: "Zero Customer Returns" },
                        { label: "Fastest Moving SKU", num: "DTB-SR-003", sub: "Kanjivaram Temple Silk" }
                    ],
                    milestoneBadge: WS_ICONS.package + " Weekly Unit Goal",
                    milestoneVal: "48 Pcs <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ 60 Pcs</span>",
                    milestoneDesc: "<strong>80.0%</strong> of weekly sales volume fulfilled. 12 pcs remaining for bonus incentive!"
                },
                'month': {
                    sub: "Monthly Resale Volume, Category Mix & Dispatch Metrics",
                    cards: [
                        { label: "Shared Catalog Lots", val: "14 Lots", pill: "↑ 28.0%", isGold: true },
                        { label: "Monthly Units Sold", val: "112 Pcs", pill: "↑ 24.5%", isGold: false },
                        { label: "In Transit to Buyers", val: "14 Pcs", pill: "En Route", isGold: false },
                        { label: "Delivered Quantity", val: "98 Pcs", pill: "↑ 26.0%", isGold: true }
                    ],
                    chartTitle: "August Monthly Unit Volume (Pcs)",
                    barActive: 7,
                    gauge: { pct: "93.33%", offset: 16, badge: "+24.5%", desc: "112 total pieces sold to customers in August, setting a new monthly high.", target: "120 Pcs", rev: "112 Pcs", today: "6 Pcs" },
                    catTitle: WS_ICONS.dress + " August Category Units Sold (Pcs)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "62 Pcs (55%)", fill: 94 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "18 Pcs (16%)", fill: 90 },
                        { name: "Royal Anarkali Kurti Sets", val: "24 Pcs (22%)", fill: 100 },
                        { name: "Georgette & Chanderi Fabrics", val: "8 Pcs (7%)", fill: 70 }
                    ],
                    kpis: [
                        { label: "Monthly Units Sold", num: "112 Pcs", sub: "↑ 24.5% MoM" },
                        { label: "Avg Items / Order", num: "8 Pcs / Order", sub: "High Cart Value" },
                        { label: "QC Pass Rate", num: "100%", sub: "Surat Atelier" },
                        { label: "Top Fabric", num: "Mulberry Silk", sub: "62 Units Sold" }
                    ],
                    milestoneBadge: WS_ICONS.package + " Monthly Sales Milestone",
                    milestoneVal: "112 Pcs <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ 120 Pcs</span>",
                    milestoneDesc: "<strong>93.3%</strong> of monthly unit target completed."
                },
                'last_month': {
                    sub: "July 2026 Reconciled Reseller Volume (Units / Pcs)",
                    cards: [
                        { label: "July Orders Closed", val: "11 Orders", pill: "Delivered", isGold: true },
                        { label: "Units Fulfilled", val: "88 Pcs", pill: "100% Verified", isGold: false },
                        { label: "Customer Parcels", val: "11 Parcels", pill: "Air Courier", isGold: false },
                        { label: "Customer Defect", val: "0 Units", pill: "Zero Defect", isGold: true }
                    ],
                    chartTitle: "July Customer Unit Fulfillment (Pcs)",
                    barActive: 6,
                    gauge: { pct: "100%", offset: 0, badge: "100%", desc: "88 pieces delivered with 100% buyer satisfaction and zero returns.", target: "80 Pcs", rev: "88 Pcs", today: "Done" },
                    catTitle: WS_ICONS.dress + " July Category Units Breakdown (Pcs)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "50 Pcs (57%)", fill: 100 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "14 Pcs (16%)", fill: 100 },
                        { name: "Royal Anarkali Kurti Sets", val: "18 Pcs (20%)", fill: 100 },
                        { name: "Georgette & Chanderi Fabrics", val: "6 Pcs (7%)", fill: 100 }
                    ],
                    kpis: [
                        { label: "July Total Delivered", num: "88 Pcs", sub: "11 Customer Dispatches" },
                        { label: "Customer Return Rate", num: "0.0%", sub: "Zero Defects" },
                        { label: "Average Buyer Rating", num: "4.95 ★", sub: "Verified Reviews" },
                        { label: "Repeat Buyer Index", num: "90.9%", sub: "10 of 11 Buyers Returned" }
                    ],
                    milestoneBadge: WS_ICONS.package + " July Sales Target",
                    milestoneVal: "88 Pcs <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ 80 Pcs</span>",
                    milestoneDesc: "<strong>110.0%</strong> of July fulfillment target completed."
                },
                'year': {
                    sub: "FY 2026-27 Cumulative Reseller Units Sold & Fulfillment",
                    cards: [
                        { label: "Total Customer Orders", val: "58 Orders", pill: "FY26-27", isGold: true },
                        { label: "Total Units Resold", val: "464 Pcs", pill: "↑ 28.2%", isGold: false },
                        { label: "Total WhatsApp Shares", val: "1,840+", pill: "Catalog Shares", isGold: false },
                        { label: "Overall Rating", val: "4.92 ★", pill: "Top Rated", isGold: true }
                    ],
                    chartTitle: "FY 2026-27 Annual Units Sold (Pcs)",
                    barActive: 9,
                    gauge: { pct: "79.37%", offset: 48, badge: "+28.2%", desc: "464 luxury couture pieces delivered to happy customers in FY26-27.", target: "600 Pcs", rev: "464 Pcs", today: "Live" },
                    catTitle: WS_ICONS.dress + " FY 2026-27 Annual Category Units Mix",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "260 Pcs (56%)", fill: 82 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "110 Pcs (24%)", fill: 76 },
                        { name: "Royal Anarkali Kurti Sets", val: "62 Pcs (13%)", fill: 90 },
                        { name: "Georgette & Chanderi Fabrics", val: "32 Pcs (7%)", fill: 68 }
                    ],
                    kpis: [
                        { label: "Total Units Delivered", num: "464 Pcs", sub: "58 Customer Orders" },
                        { label: "Catalog Conversion", num: "15.2%", sub: "1,840 Total Shares" },
                        { label: "Delivery Speed TAT", num: "1.8 Days", sub: "Air Priority Express" },
                        { label: "Zero RTO Rate", num: "99.4%", sub: "Safe COD & Prepaid" }
                    ],
                    milestoneBadge: WS_ICONS.package + " Annual Sales Milestone",
                    milestoneVal: "464 Pcs <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ 600 Pcs</span>",
                    milestoneDesc: "<strong>77.3%</strong> of Annual unit sales target achieved. Sell 136 more pcs to unlock Gold Tier!"
                }
            },
            'revenue': {
                'today': {
                    sub: "Today's Gross Resale Revenue, Net Profit & Payouts",
                    cards: [
                        { label: "Today's Resale Total", val: "₹18,200", pill: "1 Order", isGold: true },
                        { label: "Net Margin Earned", val: "₹4,550", pill: "25.0% Margin", isGold: false },
                        { label: "Bonus Tier Rebate", val: "₹546", pill: "3% VIP Bonus", isGold: false },
                        { label: "Total Day Earnings", val: "₹5,096", pill: "Credited", isGold: true }
                    ],
                    chartTitle: "Today's Hourly Profit Accumulation (₹)",
                    barActive: 7,
                    gauge: { pct: "36.4%", offset: 150, badge: "Today", desc: "You generated <strong>₹5,096</strong> in net reseller profit today.", target: "₹10K", rev: "₹5.1K", today: "₹5.1K" },
                    catTitle: WS_ICONS.dress + " Today's Resale Revenue by Category (₹)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹18,200 (Profit: ₹4,550)", fill: 100 }
                    ],
                    kpis: [
                        { label: "Gross Order Value", num: "₹18,200", sub: "1 Customer Order" },
                        { label: "Net Margin Earned", num: "₹4,550", sub: "25% Retail Margin" },
                        { label: "Tier 1 Bonus Rebate", num: "₹546", sub: "Instant Cashback" },
                        { label: "Payout Status", num: "Auto-Settled", sub: "Bank Registered" }
                    ],
                    milestoneBadge: WS_ICONS.card + " Daily Earnings Goal",
                    milestoneVal: "₹5,096 <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ ₹10,000</span>",
                    milestoneDesc: "<strong>50.9%</strong> of daily earnings target accomplished."
                },
                'week': {
                    sub: "Weekly Resale Revenue, Net Margin & Bank Payouts",
                    cards: [
                        { label: "Weekly Resale Revenue", val: "₹2,05,062", pill: "6 Orders", isGold: true },
                        { label: "Net Margin Earned", val: "₹58,400", pill: "28.5% Margin", isGold: false },
                        { label: "VIP Margin Bonus", val: "₹13,500", pill: "Tier 1 Rebate", isGold: false },
                        { label: "Total Weekly Earnings", val: "₹71,900", pill: "Paid In Full", isGold: true }
                    ],
                    chartTitle: "Weekly Revenue & Margin Flow (₹)",
                    barActive: 7,
                    gauge: { pct: "82.02%", offset: 42, badge: "Verified", desc: "₹71,900 in total reseller profit and VIP margin bonuses earned this week.", target: "₹250K", rev: "₹205K ↑", today: "₹18.2K ↑" },
                    catTitle: WS_ICONS.dress + " Weekly Revenue & Profit by Category (₹)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹1,14,500 (Profit: ₹32,600)", fill: 88 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹49,147 (Profit: ₹14,000)", fill: 72 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹25,825 (Profit: ₹7,350)", fill: 95 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹15,590 (Profit: ₹4,450)", fill: 60 }
                    ],
                    kpis: [
                        { label: "Gross Resale Revenue", num: "₹2,05,062", sub: "6 Customer Orders" },
                        { label: "Net Margin Earned", num: "₹58,400", sub: WS_ICONS.shield + " 28.5% Net Profit" },
                        { label: "Reseller VIP Bonus", num: "₹13,500", sub: WS_ICONS.crown + " Tier 1 Volume Bonus" },
                        { label: "Bank Payout Status", num: "100% Cleared", sub: "Transferred to Bank" }
                    ],
                    milestoneBadge: WS_ICONS.crown + " Weekly Financial Target",
                    milestoneVal: "₹2,05,062 <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ ₹2,50,000</span>",
                    milestoneDesc: "<strong>82.02%</strong> of weekly sales target achieved. Resell <strong>₹44,938</strong> more to unlock <strong>Tier 2 Silver VIP</strong> with extra +3% margin!"
                },
                'month': {
                    sub: "August 2026 Resale Revenue, Accumulated Profit & Payouts",
                    cards: [
                        { label: "August Resale Revenue", val: "₹4,86,500", pill: "14 Orders", isGold: true },
                        { label: "Monthly Profit Earned", val: "₹1,36,220", pill: "28.0% Margin", isGold: false },
                        { label: "VIP Margin Bonus", val: "₹32,400", pill: "Volume Rebate", isGold: false },
                        { label: "Total August Inflow", val: "₹1,68,620", pill: "100% Cleared", isGold: true }
                    ],
                    chartTitle: "August Gross Resale Revenue (₹)",
                    barActive: 7,
                    gauge: { pct: "97.30%", offset: 7, badge: "97.3%", desc: "August gross sales stand at ₹4,86,500 with ₹1,68,620 total earnings.", target: "₹500K", rev: "₹486.5K", today: "₹32.8K" },
                    catTitle: WS_ICONS.dress + " August Category Resale Revenue (₹)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹2,72,000 (Profit: ₹76,160)", fill: 92 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹1,18,500 (Profit: ₹33,180)", fill: 84 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹62,000 (Profit: ₹17,360)", fill: 98 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹34,000 (Profit: ₹9,520)", fill: 75 }
                    ],
                    kpis: [
                        { label: "Monthly Resale Total", num: "₹4,86,500", sub: "14 Customer Orders" },
                        { label: "Net Margin Earned", num: "₹1,36,220", sub: WS_ICONS.shield + " 28.0% Net Profit" },
                        { label: "VIP Margin Bonus", num: "₹32,400", sub: "Tier Volume Rebate" },
                        { label: "Net Bank Inflow", num: "₹1,68,620", sub: "NEFT Verified" }
                    ],
                    milestoneBadge: WS_ICONS.crown + " Monthly Revenue Target",
                    milestoneVal: "₹4,86,500 <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ ₹5,00,000</span>",
                    milestoneDesc: "<strong>97.3%</strong> of monthly revenue target achieved. Only ₹13,500 needed to close out monthly milestone!"
                },
                'last_month': {
                    sub: "July 2026 Settled Reseller Revenue & Bank Transfers",
                    cards: [
                        { label: "July Resale Revenue", val: "₹3,92,400", pill: "Settled", isGold: true },
                        { label: "Net Margin Earned", val: "₹1,09,870", pill: "28.0% Margin", isGold: false },
                        { label: "July Margin Rebate", val: "₹26,800", pill: "Volume Rebate", isGold: false },
                        { label: "July Total Disbursed", val: "₹1,36,670", pill: "Bank Verified", isGold: true }
                    ],
                    chartTitle: "July Settled Revenue (₹)",
                    barActive: 6,
                    gauge: { pct: "100%", offset: 0, badge: "Settled", desc: "July earnings of ₹1,36,670 fully settled and transferred to registered Bank A/C.", target: "₹350K", rev: "₹392.4K", today: "Settled" },
                    catTitle: WS_ICONS.dress + " July Resale Category Breakdown (₹)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹2,19,000 (Profit: ₹61,320)", fill: 100 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹94,000 (Profit: ₹26,320)", fill: 100 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹51,400 (Profit: ₹14,390)", fill: 100 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹28,000 (Profit: ₹7,840)", fill: 100 }
                    ],
                    kpis: [
                        { label: "July Gross Resale", num: "₹3,92,400", sub: "11 Customer Orders" },
                        { label: "Net Margin Realized", num: "₹1,09,870", sub: "28.0% Net Margin" },
                        { label: "Reseller VIP Rebate", num: "₹26,800", sub: "Volume Discount" },
                        { label: "Bank Settlement", num: "₹1,36,670", sub: "NEFT Transferred" }
                    ],
                    milestoneBadge: WS_ICONS.crown + " Reconciled Target",
                    milestoneVal: "₹3,92,400 <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ ₹3,50,000</span>",
                    milestoneDesc: "<strong>112.1%</strong> of financial target accomplished in July 2026."
                },
                'year': {
                    sub: "FY 2026-27 Reseller Revenue, Annual Margin & Milestones",
                    cards: [
                        { label: "Annual Resale Revenue", val: "₹19,84,300", pill: "58 Orders", isGold: true },
                        { label: "Total Net Margin", val: "₹5,55,600", pill: "28.0% Margin", isGold: false },
                        { label: "Annual VIP Rebates", val: "₹1,45,000", pill: "Volume Savings", isGold: false },
                        { label: "Annual Total Earnings", val: "₹7,00,600", pill: "100% Disbursed", isGold: true }
                    ],
                    chartTitle: "FY 2026-27 Resale Revenue Growth (₹)",
                    barActive: 9,
                    gauge: { pct: "79.37%", offset: 48, badge: "+31.8%", desc: "₹7,00,600 total reseller earnings generated across 58 customer orders in FY26-27.", target: "₹2.5M", rev: "₹1.98M", today: "Live" },
                    catTitle: WS_ICONS.dress + " FY 2026-27 Category Sales & Margins (₹)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹11,10,000 (Profit: ₹3,10,800)", fill: 82 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹4,76,000 (Profit: ₹1,33,280)", fill: 76 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹2,58,000 (Profit: ₹72,240)", fill: 90 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹1,40,300 (Profit: ₹39,280)", fill: 68 }
                    ],
                    kpis: [
                        { label: "Total Resale Sales", num: "₹19,84,300", sub: "58 Customer Orders" },
                        { label: "Net Margin Earned", num: "₹5,55,600", sub: WS_ICONS.shield + " 28.0% Net Margin" },
                        { label: "Annual VIP Rebates", num: "₹1,45,000", sub: "Volume Rates" },
                        { label: "Total Bank Inflow", num: "₹7,00,600", sub: "Zero Pending Dues" }
                    ],
                    milestoneBadge: WS_ICONS.crown + " Annual VIP Milestone",
                    milestoneVal: "₹19,84,300 <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ ₹25,00,000</span>",
                    milestoneDesc: "<strong>79.37%</strong> of Annual Target achieved. Resell ₹5,15,700 more to unlock ₹50L Super Reseller Gold Tier!"
                }
            }
        };

        function updateDashboardAnalytics() {
            var data = (ANALYTICS_DATA[analyticsMode] && ANALYTICS_DATA[analyticsMode][currentSelectedDateRange]) 
                ? ANALYTICS_DATA[analyticsMode][currentSelectedDateRange] 
                : ANALYTICS_DATA['overview']['week'];

            // 1. Update Subtitle
            var subEl = document.getElementById('statsSubtitle');
            if (subEl) subEl.textContent = data.sub;

            // 2. Update Top 4 Metric Cards
            for (var i = 0; i < 4; i++) {
                var c = data.cards[i];
                var lbl = document.getElementById('statLabel' + (i + 1));
                var val = document.getElementById('statVal' + (i + 1));
                var pill = document.getElementById('statPill' + (i + 1));
                if (lbl && c) lbl.textContent = c.label;
                if (val && c) {
                    val.innerHTML = c.val;
                    if (c.isGold) {
                        val.style.color = 'var(--ws-gold-primary)';
                    } else {
                        val.style.color = 'var(--ws-text-main)';
                    }
                }
                if (pill && c) pill.textContent = c.pill;
            }

            // Update 3D Corner Tag dynamically based on tier
            var ribbonTag = document.getElementById('wsTierRibbonTag');
            var ribbonText = document.getElementById('wsTierRibbonText');
            if (ribbonTag && ribbonText) {
                var tierVal = (data.cards && data.cards[0] && data.cards[0].val) ? data.cards[0].val.toLowerCase() : '';
                if (tierVal.includes('5') || tierVal.includes('platinum')) {
                    ribbonTag.className = 'ws-tier-ribbon-tag platinum';
                    ribbonText.textContent = '★ PLATINUM';
                } else if (tierVal.includes('4') || tierVal.includes('diamond')) {
                    ribbonTag.className = 'ws-tier-ribbon-tag diamond';
                    ribbonText.textContent = '★ DIAMOND';
                } else if (tierVal.includes('3') || tierVal.includes('gold')) {
                    ribbonTag.className = 'ws-tier-ribbon-tag gold';
                    ribbonText.textContent = '★ GOLD';
                } else if (tierVal.includes('2') || tierVal.includes('silver')) {
                    ribbonTag.className = 'ws-tier-ribbon-tag silver';
                    ribbonText.textContent = '★ SILVER';
                } else {
                    ribbonTag.className = 'ws-tier-ribbon-tag non-vip';
                    ribbonText.textContent = '★ NON VIP';
                }
            }

            // 3. Update Bar Chart Active Column & Title
            var chartTitleEl = document.getElementById('chartTitle');
            if (chartTitleEl) chartTitleEl.innerHTML = data.chartTitle;

            for (var b = 0; b < 12; b++) {
                var col = document.getElementById('barMonth' + b);
                if (col) {
                    col.classList.remove('active');
                    if (b === data.barActive) col.classList.add('active');
                }
            }

            // 4. Update Target Gauge
            var gVal = document.getElementById('targetGaugeVal');
            var gBadge = document.getElementById('targetGaugeBadge');
            var gFill = document.getElementById('targetGaugeFill');
            var gDesc = document.getElementById('targetGaugeDesc');
            var gTarget = document.getElementById('gStatTarget');
            var gRev = document.getElementById('gStatRevenue');
            var gToday = document.getElementById('gStatToday');

            if (gVal) gVal.textContent = data.gauge.pct;
            if (gBadge) gBadge.textContent = data.gauge.badge;
            if (gFill) gFill.style.strokeDashoffset = data.gauge.offset;
            if (gDesc) gDesc.innerHTML = data.gauge.desc;
            if (gTarget) gTarget.textContent = data.gauge.target;
            if (gRev) gRev.textContent = data.gauge.rev;
            if (gToday) gToday.textContent = data.gauge.today;

            // 5. Update Category Breakdown List
            var catTitleEl = document.getElementById('catBreakdownTitle');
            if (catTitleEl) catTitleEl.innerHTML = data.catTitle;

            var catList = document.getElementById('catProgList');
            if (catList && data.cats) {
                catList.innerHTML = '';
                data.cats.forEach(function(item) {
                    var row = document.createElement('div');
                    row.className = 'ws-cat-prog-item';
                    row.innerHTML = `
                        <div class="ws-cat-prog-header">
                            <span class="ws-cat-prog-name">${item.name}</span>
                            <span class="ws-cat-prog-val">${item.val}</span>
                        </div>
                        <div class="ws-cat-prog-track">
                            <div class="ws-cat-prog-fill" style="width: ${item.fill}%;"></div>
                        </div>
                    `;
                    catList.appendChild(row);
                });
            }

            // 6. Update KPIs Grid
            var kpiContainer = document.getElementById('kpiGrid');
            if (kpiContainer && data.kpis) {
                kpiContainer.innerHTML = '';
                data.kpis.forEach(function(k) {
                    var box = document.createElement('div');
                    box.className = 'ws-kpi-box';
                    box.innerHTML = `
                        <div class="ws-kpi-label">${k.label}</div>
                        <div class="ws-kpi-num">${k.num}</div>
                        <div class="ws-kpi-sub">${k.sub}</div>
                    `;
                    kpiContainer.appendChild(box);
                });
            }

            // 7. Update Milestone
            var mBadge = document.getElementById('statsMilestoneBadge');
            var mVal = document.getElementById('statsMilestoneVal');
            var mDesc = document.getElementById('statsMilestoneDesc');
            if (mBadge) mBadge.innerHTML = data.milestoneBadge;
            if (mVal) mVal.innerHTML = data.milestoneVal;
            if (mDesc) mDesc.innerHTML = data.milestoneDesc;
        };

        function setOverviewFilter(mode, btn) {
            analyticsMode = mode;
            if (btn && btn.parentElement) {
                btn.parentElement.querySelectorAll('button').forEach(function(b) {
                    b.classList.remove('active');
                });
                btn.classList.add('active');
            }
            updateDashboardAnalytics();
            showWsToast('📊 Switched to ' + mode.toUpperCase() + ' Analytics Mode');
        };

        /* ── Date Range Modal Controller ── */
        function openDateRangePicker() {
            showModal('wsDateRangeModal');
        };

        function closeDateRangeModal() {
            hideModal('wsDateRangeModal');
        };

        function applyDatePreset(presetKey, label) {
            currentSelectedDateRange = presetKey;
            
            var labelEl = document.getElementById('selectedDateRangeLabel');
            if (labelEl) labelEl.textContent = label;

            // Highlight selected button inside modal
            var modalButtons = document.querySelectorAll('#datePresetButtons button');
            modalButtons.forEach(function(b) {
                b.className = 'ws-btn ws-btn-secondary';
                if (b.getAttribute('onclick') && b.getAttribute('onclick').includes(presetKey)) {
                    b.className = 'ws-btn ws-btn-primary';
                }
            });

            closeDateRangeModal();
            updateDashboardAnalytics();
            showWsToast('📅 Applied Date Filter: ' + label);
        };

        function applyCustomDateRange() {
            var s = document.getElementById('customStartDate').value;
            var e = document.getElementById('customEndDate').value;
            if (!s || !e) {
                alert('Please select both start and end dates.');
                return;
            }
            if (new Date(s) > new Date(e)) {
                alert('Start date cannot be after end date.');
                return;
            }

            var formatD = function(dStr) {
                var d = new Date(dStr);
                var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                return months[d.getMonth()] + ' ' + String(d.getDate()).padStart(2, '0');
            };

            var label = formatD(s) + ' - ' + formatD(e);
            var labelEl = document.getElementById('selectedDateRangeLabel');
            if (labelEl) labelEl.textContent = label;

            // Reset preset active buttons
            var modalButtons = document.querySelectorAll('#datePresetButtons button');
            modalButtons.forEach(function(b) {
                b.className = 'ws-btn ws-btn-secondary';
            });

            closeDateRangeModal();
            updateDashboardAnalytics();
            showWsToast('📅 Applied Custom Calendar Range: ' + label);
        };

        function handleGlobalQuickSearch(input) {
            var val = input.value.trim().toLowerCase();
            if (!val) return;
            var match = activeOrdersList.find(function(o) {
                return o.id.toLowerCase().includes(val) || o.productName.toLowerCase().includes(val) || o.sku.toLowerCase().includes(val);
            });
            if (match) {
                viewOrderDetails(match);
            }
        };

        /* ── Render Reports Table & Mobile Cards ── */
        var currentReportCategoryFilter = 'all';
        var currentReportSearchQuery = '';

        function renderReportsView(orders) {
            var tbody = document.getElementById('wsReportsTbody');
            var mobContainer = document.getElementById('wsMobileReportsCards');
            if (!tbody || !mobContainer) return;

            tbody.innerHTML = '';
            mobContainer.innerHTML = '';

            var filtered = (orders || activeOrdersList).filter(function(o) {
                var matchCat = true;
                if (currentReportCategoryFilter !== 'all') {
                    var prodLow = (o.productName || '').toLowerCase();
                    matchCat = prodLow.includes(currentReportCategoryFilter);
                }
                var matchSearch = true;
                if (currentReportSearchQuery) {
                    var q = currentReportSearchQuery.toLowerCase();
                    matchSearch = (o.id || '').toLowerCase().includes(q) ||
                                  (o.productName || '').toLowerCase().includes(q) ||
                                  (o.sku || '').toLowerCase().includes(q) ||
                                  (o.hsn || '').toLowerCase().includes(q) ||
                                  (o.payment || '').toLowerCase().includes(q);
                }
                return matchCat && matchSearch;
            });

            // Update Report KPIs
            var totalTurnover = filtered.reduce(function(acc, o) { return acc + Number(o.total || 0); }, 0);
            var totalTax = filtered.reduce(function(acc, o) { return acc + Number(o.tax || 0); }, 0);
            var totalUnits = filtered.reduce(function(acc, o) { return acc + Number(o.qty || 0); }, 0);
            var avgValue = filtered.length ? Math.round(totalTurnover / filtered.length) : 0;

            var elTurnover = document.getElementById('repKpiTurnover');
            var elTax = document.getElementById('repKpiItc');
            var elUnits = document.getElementById('repKpiUnits');
            var elAvg = document.getElementById('repKpiAvg');

            if (elTurnover) elTurnover.textContent = '₹' + totalTurnover.toLocaleString('en-IN');
            if (elTax) elTax.textContent = '₹' + totalTax.toLocaleString('en-IN');
            if (elUnits) elUnits.textContent = totalUnits + ' Pcs';
            if (elAvg) elAvg.textContent = '₹' + avgValue.toLocaleString('en-IN');

            if (filtered.length === 0) {
                tbody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:30px; color:#6B6358;">No matching report consignments found.</td></tr>';
                mobContainer.innerHTML = '<div style="text-align:center; padding:30px; color:#6B6358; font-weight:600;">No matching report consignments found.</div>';
                return;
            }

            filtered.forEach(function(o) {
                // 1. Desktop Table Row
                var tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="ws-order-id-cell">${o.id}</td>
                    <td style="font-size:0.78rem; color:#6B6358; white-space:nowrap;">${o.date}</td>
                    <td><span style="font-family:monospace; background:var(--ws-gold-light); color:var(--ws-gold-primary); padding:2px 6px; border-radius:4px; font-weight:700;">${o.hsn}</span></td>
                    <td>
                        <div class="ws-prod-mini-cell">
                            <img src="${o.image}" alt="${o.productName}" class="ws-prod-mini-img" onerror="this.onerror=null;this.src='/assets/images/no-image.svg';">
                            <div>
                                <strong style="font-size:0.84rem; color:var(--ws-text-main);">${o.productName}</strong>
                                <div style="font-size:0.72rem; color:var(--ws-text-muted);">SKU: ${o.sku} • ${o.courier}</div>
                            </div>
                        </div>
                    </td>
                    <td><strong style="font-size:0.84rem;">${o.qty}</strong></td>
                    <td>₹${Number(o.subtotal).toLocaleString('en-IN')}</td>
                    <td style="color:#10B981; font-weight:700;">₹${Number(o.tax).toLocaleString('en-IN')}</td>
                    <td><strong style="color:var(--ws-gold-primary); font-size:0.90rem;">₹${Number(o.total).toLocaleString('en-IN')}</strong></td>
                    <td style="font-size:0.76rem; color:var(--ws-text-muted);">${o.payment}</td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <button class="ws-btn ws-btn-primary ws-btn-sm" onclick='openBillInvoiceModal(${JSON.stringify(o)})' title="Download GST Tax Invoice PDF">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" style="display:inline-block; vertical-align:middle;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> <span>Bill</span>
                            </button>
                            <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick='viewOrderDetails(${JSON.stringify(o)})' title="View Details">
                                👁️
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);

                // 2. Mobile Responsive Report Card
                var card = document.createElement('div');
                card.className = 'ws-mob-report-card';
                card.innerHTML = `
                    <div class="ws-mob-rep-top">
                        <div>
                            <span class="ws-order-id-cell" style="font-size:0.90rem;">${o.id}</span>
                            <span style="font-size:0.72rem; color:var(--ws-text-muted); margin-left:6px;">📅 ${o.date}</span>
                        </div>
                        <span class="ws-status-badge delivered" style="font-size:0.65rem;">✓ 5% GST Verified</span>
                    </div>

                    <div class="ws-mob-rep-body">
                        <img src="${o.image}" alt="${o.productName}" class="ws-mob-rep-img" onerror="this.onerror=null;this.src='/assets/images/no-image.svg';">
                        <div class="ws-mob-rep-info">
                            <h4 style="font-size:0.88rem; font-weight:700; color:var(--ws-text-main); line-height:1.25; margin-bottom:2px;">${o.productName}</h4>
                            <div style="font-size:0.74rem; color:var(--ws-text-muted);">
                                SKU: <strong>${o.sku}</strong> • HSN: <strong style="color:var(--ws-gold-primary); font-family:monospace;">${o.hsn}</strong>
                            </div>
                            <div style="font-size:0.76rem; font-weight:700; color:var(--ws-text-main); margin-top:2px;">
                                Quantity Lot: <span style="color:var(--ws-gold-primary);">${o.qty} Pcs</span>
                            </div>
                        </div>
                    </div>

                    <div class="ws-mob-rep-tax-grid">
                        <div>
                            <span style="color:var(--ws-text-muted); font-size:0.68rem; display:block;">Taxable Base:</span>
                            <strong style="color:var(--ws-text-main);">₹${Number(o.subtotal).toLocaleString('en-IN')}</strong>
                        </div>
                        <div>
                            <span style="color:var(--ws-text-muted); font-size:0.68rem; display:block;">GST ITC Accrued (5%):</span>
                            <strong style="color:#10B981;">₹${Number(o.tax).toLocaleString('en-IN')}</strong>
                        </div>
                        <div>
                            <span style="color:var(--ws-text-muted); font-size:0.68rem; display:block;">Payment Instrument:</span>
                            <span style="color:var(--ws-text-sub); font-size:0.72rem; font-weight:600;">${o.payment.split('(')[0]}</span>
                        </div>
                        <div>
                            <span style="color:var(--ws-text-muted); font-size:0.68rem; display:block;">Total Invoiced:</span>
                            <strong style="color:var(--ws-gold-primary); font-size:0.92rem;">₹${Number(o.total).toLocaleString('en-IN')}</strong>
                        </div>
                    </div>

                    <div class="ws-mob-rep-actions">
                        <button class="ws-btn ws-btn-primary ws-btn-sm" style="width:100%; justify-content:center;" onclick='openBillInvoiceModal(${JSON.stringify(o)})'>
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" style="display:inline-block; vertical-align:middle;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> <span>Download GST Bill PDF</span>
                        </button>
                        <button class="ws-btn ws-btn-secondary ws-btn-sm" style="width:100%; justify-content:center;" onclick='viewOrderDetails(${JSON.stringify(o)})'>
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" style="display:inline-block; vertical-align:middle;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg> <span>View Details</span>
                        </button>
                    </div>
                `;
                mobContainer.appendChild(card);
            });
        }

        function filterReportsByCategory(category, btn) {
            currentReportCategoryFilter = category;
            if (btn && btn.parentElement) {
                btn.parentElement.querySelectorAll('button').forEach(function(b) { b.classList.remove('active'); });
                btn.classList.add('active');
            }
            renderReportsView(activeOrdersList);
        };

        function handleReportSearch(val) {
            currentReportSearchQuery = val.trim();
            var clearBtn = document.getElementById('reportSearchClear');
            if (clearBtn) clearBtn.style.display = val.trim() ? 'flex' : 'none';
            renderReportsView(activeOrdersList);
        };

        function clearReportSearch() {
            var input = document.getElementById('reportSearchInput');
            if (input) {
                input.value = '';
                input.focus();
            }
            var clearBtn = document.getElementById('reportSearchClear');
            if (clearBtn) clearBtn.style.display = 'none';
            currentReportSearchQuery = '';
            renderReportsView(activeOrdersList);
        };

        /* ── Formal Printable Reseller Procurement Audit Report ── */
        function printWholesaleReport() {
            var modal = document.getElementById('wsPrintableAuditReportModal');
            if (modal) {
                var userRaw = localStorage.getItem('dtbrands_user');
                var user = userRaw ? JSON.parse(userRaw) : {};
                var comp = user.companyName || 'Shree Krishna Silks Pvt Ltd';
                var gst = user.gst_number || '24AABCU9603R1ZM';
                var rep = user.name || 'Rajesh Kumar';

                var repInfoEl = document.getElementById('auditReportBuyerInfo');
                if (repInfoEl) {
                    var genDate = new Date().toLocaleDateString('en-IN', { day:'numeric', month:'short', year:'numeric' });
                    repInfoEl.innerHTML = `
                        <strong>${comp}</strong> (GSTIN: <strong>${gst}</strong>)<br>
                        Authorized Reseller: ${rep} • Period: FY 2026-27<br>
                        Report Generated: ${genDate}
                    `;
                }

                var tbody = document.getElementById('auditReportTbody');
                if (tbody) {
                    tbody.innerHTML = '';
                    var totalSub = 0, totalTax = 0, totalGrand = 0, totalQty = 0;
                    activeOrdersList.forEach(function(o, idx) {
                        totalSub += Number(o.subtotal || 0);
                        totalTax += Number(o.tax || 0);
                        totalGrand += Number(o.total || 0);
                        totalQty += Number(o.qty || 0);

                        var tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${idx + 1}</td>
                            <td><strong>${o.id}</strong></td>
                            <td>${o.date}</td>
                            <td>${o.hsn}</td>
                            <td>${o.productName}</td>
                            <td>${o.qty} Pcs</td>
                            <td>₹${Number(o.subtotal).toLocaleString('en-IN')}</td>
                            <td>₹${Number(o.tax).toLocaleString('en-IN')}</td>
                            <td><strong>₹${Number(o.total).toLocaleString('en-IN')}</strong></td>
                            <td>${o.payment}</td>
                        `;
                        tbody.appendChild(tr);
                    });

                    document.getElementById('auditTotalSub').textContent = '₹' + totalSub.toLocaleString('en-IN');
                    document.getElementById('auditTotalTax').textContent = '₹' + totalTax.toLocaleString('en-IN');
                    document.getElementById('auditTotalGrand').textContent = '₹' + totalGrand.toLocaleString('en-IN');
                    document.getElementById('auditTotalQty').textContent = totalQty + ' Pcs';
                }

                showModal('wsPrintableAuditReportModal');
            } else {
                window.print();
            }
        };

        function openPrintableAuditReportModal() {
            printWholesaleReport();
        };

        function closePrintableAuditReportModal() {
            hideModal('wsPrintableAuditReportModal');
        };

        /* ── Export Reports to CSV ── */
        function exportReportsToCsv() {
            var headers = ["Consignment ID", "Date", "HSN", "Product Name", "Quantity", "Taxable Value", "GST (5%)", "Net Total", "Payment Mode", "Courier", "AWB"];
            var rows = activeOrdersList.map(function(o) {
                return [
                    `"${o.id}"`,
                    `"${o.date}"`,
                    `"${o.hsn}"`,
                    `"${o.productName.replace(/"/g, '""')}"`,
                    o.qty,
                    o.subtotal,
                    o.tax,
                    o.total,
                    `"${o.payment}"`,
                    `"${o.courier}"`,
                    `"${o.awb}"`
                ];
            });

            var csvContent = "data:text/csv;charset=utf-8," + [headers.join(",")].concat(rows.map(function(e){ return e.join(","); })).join("\n");
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `DT Brand\'s_Wholesale_Report_${new Date().toISOString().slice(0,10)}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            showWsToast('📁 CSV Spreadsheet downloaded successfully!');
        };

        /* ── Render Support Tickets ── */
        function renderTicketsView() {
            var list = document.getElementById('wsTicketList');
            if (!list) return;
            list.innerHTML = '';

            activeTicketsList.forEach(function(t) {
                var isResolved = t.status === 'Resolved';
                var statusColor = isResolved ? '#15803D' : '#D97706';
                var statusBg = isResolved ? 'rgba(21, 128, 61, 0.08)' : 'rgba(217, 119, 6, 0.08)';
                var statusBorder = isResolved ? 'rgba(21, 128, 61, 0.25)' : 'rgba(217, 119, 6, 0.25)';

                var card = document.createElement('div');
                card.className = 'ws-ticket-card';
                card.innerHTML = `
                    <div class="ws-ticket-head">
                        <div style="display:flex; align-items:center; gap:6px;">
                            <strong class="ws-order-id-cell" style="font-size:0.86rem;">Ticket #${t.id}</strong>
                            <span style="font-size:0.70rem; color:var(--ws-text-muted);">• Ref: <strong>${t.orderId}</strong></span>
                        </div>
                        <span style="font-size:0.70rem; font-weight:800; color:${statusColor}; background:${statusBg}; border:1px solid ${statusBorder}; padding:2px 8px; border-radius:12px; display:inline-flex; align-items:center;">
                            ${isResolved ? '✓ ' + t.status : '<span class="ws-pulse-dot"></span> ' + t.status}
                        </span>
                    </div>
                    <div style="font-size:0.82rem; font-weight:700; color:var(--ws-text-main); margin:4px 0 2px;">${t.category}</div>
                    <p style="font-size:0.78rem; color:var(--ws-text-sub); margin:0; line-height:1.4; background:#FAF8F4; padding:8px 10px; border-radius:6px; border:1px solid var(--ws-border);">"${t.message}"</p>
                    <div style="font-size:0.72rem; color:var(--ws-text-muted); margin-top:8px; display:flex; justify-content:space-between; align-items:center;">
                        <span>📅 ${t.date}</span>
                        <a href="https://api.whatsapp.com/send?phone=917046363528&text=Hi%2C%20following%20up%20on%20Wholesaler%20Ticket%20%23${t.id}" target="_blank" style="color:#25D366; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor"><path d="M17.472 14.382c-.301-.15-1.78-.879-2.056-.979-.275-.1-.475-.15-.675.15-.2.3-.775.979-.95 1.179-.175.2-.35.225-.65.075-.3-.15-1.267-.467-2.414-1.49-1.049-.935-1.758-2.09-1.963-2.44-.205-.35-.022-.54.128-.69.135-.135.301-.35.451-.525.15-.175.2-.3.3-.5.1-.2.05-.375-.025-.525-.075-.15-.675-1.628-.925-2.228-.244-.585-.492-.505-.675-.515-.175-.01-.375-.01-.575-.01-.2 0-.525.075-.8.375s-1.05 1.028-1.05 2.505 1.075 2.905 1.225 3.105c.15.2 2.115 3.23 5.125 4.53 3.01 1.3 3.01.867 3.56.817.55-.05 1.78-.727 2.03-1.428.25-.7.25-1.3.175-1.428-.075-.128-.275-.203-.575-.353z"/><path d="M12 2C6.477 2 2 6.477 2 12c0 1.891.524 3.662 1.435 5.176L2 22l4.981-1.307C8.423 21.536 10.155 22 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18c-1.63 0-3.14-.492-4.407-1.336l-.316-.209-2.955.775.789-2.88-.228-.363C3.965 14.675 3.5 13.385 3.5 12c0-4.687 3.813-8.5 8.5-8.5s8.5 3.813 8.5 8.5-3.813 8.5-8.5 8.5z"/></svg>
                            <span>WhatsApp Followup →</span>
                        </a>
                    </div>
                `;
                list.appendChild(card);
            });
        }

        function handleCreateTicket(e) {
            e.preventDefault();
            var orderId = document.getElementById('ticketOrderId').value;
            var category = document.getElementById('ticketCategory').value;
            var message = document.getElementById('ticketMessage').value.trim();

            if (!message) { alert('Please enter issue narrative'); return; }

            var newTicket = {
                id: 'TCK-' + Math.floor(100 + Math.random() * 900),
                orderId: orderId,
                category: category,
                status: 'In Progress',
                message: message,
                date: 'Today, ' + new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
            };

            activeTicketsList.unshift(newTicket);
            renderTicketsView();
            document.getElementById('wsTicketForm').reset();
            showWsToast('🎫 Support ticket created! Concierge assigned.');
        };

        /* ── Order Details Modal ── */
        function viewOrderDetails(o) {
            var modal = document.getElementById('wsOrderDetailsModal');
            var title = document.getElementById('modalOrderTitle');
            var body = document.getElementById('modalOrderBody');
            var footer = document.getElementById('modalOrderFooter');

            if (!modal || !body) return;

            if (title) title.textContent = `Order Details #${o.id}`;
            body.innerHTML = `
                <!-- Consignment Status Banner -->
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; background:#FAF8F4; border:1.5px solid var(--ws-border); border-radius:10px; padding:12px 16px; margin-bottom:14px;">
                    <div>
                        <div style="font-size:0.72rem; text-transform:uppercase; font-weight:700; letter-spacing:0.5px; color:var(--ws-text-muted);">Consignment Placed</div>
                        <div style="font-size:0.92rem; font-weight:800; color:var(--ws-text-main); margin-top:2px;">${o.date}</div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:0.72rem; text-transform:uppercase; font-weight:700; letter-spacing:0.5px; color:var(--ws-text-muted); margin-bottom:3px;">Consignment Status</div>
                        <span class="ws-status-badge ${o.status.toLowerCase()}" style="font-size:0.75rem; padding:4px 10px;">${o.status}</span>
                    </div>
                </div>

                <!-- Product Details Box -->
                <div style="display:flex; gap:14px; align-items:center; background:#FFFFFF; border:1.5px solid var(--ws-border); border-radius:10px; padding:14px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.03);">
                    <img src="${o.image}" alt="${o.productName}" style="width:72px; height:90px; border-radius:8px; object-fit:cover; border:1px solid var(--ws-border); flex-shrink:0; background:#FAF8F4;" onerror="this.onerror=null;this.src='/assets/images/no-image.svg';">
                    <div style="flex:1; min-width:0;">
                        <h4 style="font-size:0.96rem; font-weight:800; color:var(--ws-text-main); margin-bottom:4px; line-height:1.3;">${o.productName}</h4>
                        <div style="display:flex; gap:6px; flex-wrap:wrap; margin-bottom:6px;">
                            <span style="font-size:0.72rem; font-weight:600; background:#FAF8F4; padding:2px 6px; border-radius:4px; border:1px solid var(--ws-border); color:var(--ws-text-sub);">SKU: ${o.sku}</span>
                            <span style="font-size:0.72rem; font-weight:600; background:#FAF8F4; padding:2px 6px; border-radius:4px; border:1px solid var(--ws-border); color:var(--ws-text-sub);">HSN: ${o.hsn}</span>
                            <span style="font-size:0.72rem; font-weight:600; background:#FAF8F4; padding:2px 6px; border-radius:4px; border:1px solid var(--ws-border); color:var(--ws-text-sub);">${o.color || 'Silk Assorted'}</span>
                        </div>
                        <div style="font-size:0.88rem; font-weight:800; color:var(--ws-gold-primary);">
                            ${o.qty} Pcs Lot <span style="font-size:0.76rem; font-weight:600; color:var(--ws-text-muted);">(@ ₹${Number(o.unitPrice).toLocaleString('en-IN')} / Pc)</span>
                        </div>
                    </div>
                </div>

                <!-- Price & Tax Breakdown Card -->
                <div style="background:#FAF8F4; border:1.5px solid var(--ws-gold-border); border-radius:10px; padding:14px 16px; margin-bottom:14px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; font-size:0.84rem;">
                        <span style="color:var(--ws-text-sub); font-weight:600;">Taxable Consignment Value</span>
                        <span style="color:var(--ws-text-main); font-weight:700;">₹${Number(o.subtotal).toLocaleString('en-IN')}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; font-size:0.84rem;">
                        <span style="color:var(--ws-text-sub); font-weight:600;">GST Input Tax (5% CGST + SGST)</span>
                        <span style="color:#15803D; font-weight:700;">+₹${Number(o.tax).toLocaleString('en-IN')}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; font-size:0.84rem;">
                        <span style="color:var(--ws-text-sub); font-weight:600;">Reseller Margin Discount</span>
                        <span style="color:#15803D; font-weight:700;">-₹${Number(o.discount).toLocaleString('en-IN')}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; padding-top:10px; margin-top:4px; border-top:1.5px dashed var(--ws-border); font-size:1.1rem;">
                        <span style="font-weight:800; color:var(--ws-text-main);">Net Amount Paid</span>
                        <span style="font-weight:900; color:var(--ws-gold-primary);">₹${Number(o.total).toLocaleString('en-IN')}</span>
                    </div>
                </div>

                <!-- Logistics & Payment Strip -->
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; font-size:0.78rem; background:#FFFFFF; border:1px solid var(--ws-border); border-radius:8px; padding:10px 14px;">
                    <div>
                        <div style="color:var(--ws-text-muted); font-size:0.70rem; text-transform:uppercase; font-weight:700;">Courier Partner</div>
                        <div style="font-weight:700; color:var(--ws-text-main); margin-top:2px;">${o.courier} (AWB: ${o.awb})</div>
                    </div>
                    <div>
                        <div style="color:var(--ws-text-muted); font-size:0.70rem; text-transform:uppercase; font-weight:700;">Payment Mode</div>
                        <div style="font-weight:700; color:var(--ws-text-main); margin-top:2px;">${o.payment}</div>
                    </div>
                </div>
            `;

            if (footer) {
                footer.innerHTML = `
                    <div class="ws-dual-action-grid" style="margin-top:0; padding-top:0; border-top:none;">
                        <button class="ws-btn ws-btn-primary" onclick='openBillInvoiceModal(${JSON.stringify(o)})'>
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#FFFFFF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            <span>GST Bill PDF</span>
                        </button>
                        <button class="ws-btn ws-btn-secondary" onclick='repeatWholesaleOrder(${JSON.stringify(o)})'>
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"></polyline><polyline points="10 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                            <span>Re-Order Lot</span>
                        </button>
                    </div>
                `;
            }

            modal.classList.add('active');
        };

        function repeatWholesaleOrder(o) {
            closeOrderDetailsModal();
            try {
                var raw = localStorage.getItem('dtbrands_cart');
                var cart = raw ? JSON.parse(raw) : [];
                var exists = cart.find(function(item){ return item.id === o.id || item.name === o.productName; });
                if (exists) {
                    exists.qty = (Number(exists.qty) || 1) + 1;
                } else {
                    cart.push({
                        id: o.id || ('PROD-' + Date.now()),
                        name: o.productName,
                        price: o.unitPrice || 3199,
                        wholesale_price: o.unitPrice || 3199,
                        qty: Number(o.qty) || 12,
                        image: o.image || '/assets/images/no-image.svg',
                        color: o.color || 'Standard',
                        moq: 12
                    });
                }
                localStorage.setItem('dtbrands_cart', JSON.stringify(cart));
                updateWholesaleCartBadge();
                if (typeof window.openCartDrawer === 'function') {
                    window.openCartDrawer();
                } else {
                    showWsToast('🛒 ' + o.productName + ' added to reseller cart!');
                }
            } catch(e) {
                showWsToast('🛒 Added to cart!');
            }
        };

        function closeOrderDetailsModal() {
            var modal = document.getElementById('wsOrderDetailsModal');
            if (modal) modal.classList.remove('active');
        };

        /* ── Indian Currency Number to Words Converter ── */
        function convertNumberToIndianWords(num) {
            var units = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
            var tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
            
            function twoDigits(n) {
                if (n < 20) return units[n];
                return (tens[Math.floor(n / 10)] + ' ' + units[n % 10]).trim();
            }
            function threeDigits(n) {
                var h = Math.floor(n / 100);
                var r = n % 100;
                var res = [];
                if (h > 0) res.push(units[h] + ' Hundred');
                if (r > 0) res.push(twoDigits(r));
                return res.join(' and ');
            }

            var val = Math.round(Number(num || 0) * 100) / 100;
            var rupees = Math.floor(val);
            var paise = Math.round((val - rupees) * 100);

            if (rupees === 0) return 'Zero Rupees only';

            var crores = Math.floor(rupees / 10000000);
            rupees %= 10000000;
            var lakhs = Math.floor(rupees / 100000);
            rupees %= 100000;
            var thousands = Math.floor(rupees / 1000);
            rupees %= 1000;

            var parts = [];
            if (crores > 0) parts.push(twoDigits(crores) + ' Crore');
            if (lakhs > 0) parts.push(twoDigits(lakhs) + ' Lakh');
            if (thousands > 0) parts.push(twoDigits(thousands) + ' Thousand');
            if (rupees > 0) parts.push(threeDigits(rupees));

            var rStr = parts.join(' ') + ' Rupees';
            if (paise > 0) {
                rStr += ' and ' + twoDigits(paise) + ' Paisa only';
            } else {
                rStr += ' only';
            }
            return rStr;
        };

        /* ── Official GST Tax Invoice Modal & Print PDF ── */
        function openBillInvoiceModal(o) {
            if (typeof closeOrderDetailsModal === 'function') {
                closeOrderDetailsModal();
            }
            var modal = document.getElementById('wsBillInvoiceModal');
            if (!modal) return;

            var userRaw = localStorage.getItem('dtbrands_user');
            var user = userRaw ? JSON.parse(userRaw) : {};

            // 1. Invoice Meta
            var cleanId = o.id ? o.id.replace(/[^0-9]/g, '') : '1023';
            if (!cleanId) cleanId = '1023';
            var invDate = o.date || '20-04-2026';
            
            var buyerName = user.name || 'Siddannagouda Patil';
            var buyerComp = user.companyName || user.company_name || 'Patil Cloth Bazar';
            var buyerAddr = user.address || 'Sumbad Road Yedrami kalaburgi Dist';
            var buyerCity = user.city || 'kalaburgi';
            var buyerState = user.state || 'Karnataka';
            var buyerPin = user.pincode || '585325';
            var buyerPhone = user.phone || '9740455555';
            var buyerAltPhone = user.alt_phone || '6361616801';
            var buyerGst = user.gst_number || (user.gst_type === 'gst' ? '29CFZPV1455E1ZO' : '29CFZPV1455E1ZO');
            var stateCode = user.state_code || '29-Karnataka';

            if (document.getElementById('invNum')) document.getElementById('invNum').textContent = cleanId;
            if (document.getElementById('invDate')) document.getElementById('invDate').textContent = invDate;
            if (document.getElementById('invPlaceOfSupply')) document.getElementById('invPlaceOfSupply').textContent = stateCode;

            // 2. Bill To
            if (document.getElementById('invBuyerName')) document.getElementById('invBuyerName').textContent = buyerName;
            if (document.getElementById('invBuyerCompany')) document.getElementById('invBuyerCompany').textContent = buyerComp;
            if (document.getElementById('invBuyerAddress')) document.getElementById('invBuyerAddress').textContent = buyerAddr;
            if (document.getElementById('invBuyerCity')) document.getElementById('invBuyerCity').textContent = buyerCity;
            if (document.getElementById('invBuyerState')) document.getElementById('invBuyerState').textContent = buyerState;
            if (document.getElementById('invBuyerPin')) document.getElementById('invBuyerPin').textContent = buyerPin;
            if (document.getElementById('invBuyerAltPhone')) document.getElementById('invBuyerAltPhone').textContent = buyerAltPhone;
            if (document.getElementById('invBuyerPhone')) document.getElementById('invBuyerPhone').textContent = buyerPhone;
            if (document.getElementById('invBuyerGst')) document.getElementById('invBuyerGst').textContent = buyerGst;
            if (document.getElementById('invBuyerStateCode')) document.getElementById('invBuyerStateCode').textContent = stateCode;

            // 3. Ship To
            if (document.getElementById('invShipCompany')) document.getElementById('invShipCompany').textContent = buyerComp;
            if (document.getElementById('invShipAddress')) document.getElementById('invShipAddress').textContent = o.delivery_point || 'Vrl near Delivery Point : Jevargi';
            if (document.getElementById('invShipCityPin')) document.getElementById('invShipCityPin').textContent = `${buyerCity} Dist ${buyerPin}`;
            if (document.getElementById('invShipPhone')) document.getElementById('invShipPhone').textContent = `${buyerPhone}, ${buyerAltPhone}`;

            // 4. Calculate Items & Taxes
            var items = o.items || [];
            if (!items.length) {
                // If single product order object
                var unitPrice = Number(o.unitPrice || o.price || 75);
                var qty = Number(o.qty || 186);
                var subtotal = Number(o.subtotal || (unitPrice * qty));
                var tax = Number(o.tax || (subtotal * 0.05));
                var total = Number(o.total || (subtotal + tax));

                items = [
                    {
                        name: o.productName || 'Ikkat cotton',
                        hsn: o.hsn || '5407',
                        qty: qty,
                        price: unitPrice,
                        gst: tax,
                        amount: total
                    }
                ];
            }

            var tbody = document.getElementById('invItemsTbody');
            var totQty = 0;
            var totGst = 0;
            var totAmount = 0;
            var totTaxable = 0;

            if (tbody) {
                tbody.innerHTML = '';
                items.forEach(function(it, idx) {
                    var iQty = Number(it.qty || 1);
                    var iPrice = Number(it.price || it.unitPrice || 75);
                    var iTaxable = iQty * iPrice;
                    var iGst = Number(it.gst || (iTaxable * 0.05));
                    var iAmount = Number(it.amount || (iTaxable + iGst));

                    totQty += iQty;
                    totTaxable += iTaxable;
                    totGst += iGst;
                    totAmount += iAmount;

                    var tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td style="text-align:center;">${idx + 1}</td>
                        <td style="font-weight:700;">${it.name || it.productName || 'Silk Fabric Assorted'}</td>
                        <td style="text-align:center;">${it.hsn || '5407'}</td>
                        <td style="text-align:right;">${iQty}</td>
                        <td style="text-align:right;">₹ ${iPrice.toFixed(2)}</td>
                        <td style="text-align:right;">₹ ${iGst.toFixed(2)} (5.0%)</td>
                        <td style="text-align:right; font-weight:700;">₹ ${iAmount.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                    `;
                    tbody.appendChild(tr);
                });
            }

            // Table Footers
            if (document.getElementById('invTableTotalQty')) document.getElementById('invTableTotalQty').textContent = totQty;
            if (document.getElementById('invTableTotalGst')) document.getElementById('invTableTotalGst').textContent = '₹ ' + totGst.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            if (document.getElementById('invTableTotalAmount')) document.getElementById('invTableTotalAmount').textContent = '₹ ' + totAmount.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});

            // 5. Tax Summary Sub-table
            var taxSummaryTbody = document.getElementById('invTaxSummaryTbody');
            if (taxSummaryTbody) {
                taxSummaryTbody.innerHTML = `
                    <tr>
                        <td style="text-align:left;">${items[0] ? (items[0].hsn || '5407') : '5407'}</td>
                        <td style="text-align:right;">${totTaxable.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                        <td style="text-align:center;">5.0</td>
                        <td style="text-align:right;">${totGst.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                        <td style="text-align:right;">${totGst.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                    </tr>
                `;
            }
            if (document.getElementById('invTaxableTotalVal')) document.getElementById('invTaxableTotalVal').textContent = totTaxable.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            if (document.getElementById('invTaxIgstAmt')) document.getElementById('invTaxIgstAmt').textContent = totGst.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            if (document.getElementById('invTaxGrandTotal')) document.getElementById('invTaxGrandTotal').textContent = totGst.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});

            // 6. Right Net Calculations
            var formattedGrand = '₹ ' + totAmount.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            if (document.getElementById('invSubTotalRight')) document.getElementById('invSubTotalRight').textContent = formattedGrand;
            if (document.getElementById('invTotalRight')) document.getElementById('invTotalRight').textContent = formattedGrand;
            if (document.getElementById('invBalance')) document.getElementById('invBalance').textContent = formattedGrand;
            if (document.getElementById('invReceived')) document.getElementById('invReceived').textContent = '₹ 0.00';

            // 7. Amount in Words
            if (document.getElementById('invAmountInWords')) {
                document.getElementById('invAmountInWords').textContent = convertNumberToIndianWords(totAmount);
            }

            showModal('wsBillInvoiceModal');
            var wrapper = modal.querySelector('.ws-tax-invoice-wrapper');
            if (wrapper) wrapper.scrollTop = 0;
        };

        function closeBillInvoiceModal() {
            hideModal('wsBillInvoiceModal');
        };

        function printInvoiceSheet() {
            var modal = document.getElementById('wsBillInvoiceModal');
            if (modal) {
                var wrapper = modal.querySelector('.ws-tax-invoice-wrapper');
                if (wrapper) wrapper.scrollTop = 0;
            }
            window.print();
        };

        /* ── Trending & For You Products Slider Scrolling ── */
        function slideTrendingProducts(dir) {
            var track = document.getElementById('wsTrendingSliderTrack');
            if (!track) return;
            var scrollAmount = track.offsetWidth * 0.75 * dir;
            track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        };

        function slideForYouProducts(dir) {
            var track = document.getElementById('wsForYouSliderTrack');
            if (!track) return;
            var scrollAmount = track.offsetWidth * 0.75 * dir;
            track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        };

        function slidePriceBoxes(dir) {
            var track = document.getElementById('wsPriceSliderTrack');
            if (!track) return;
            var scrollAmount = track.offsetWidth * 0.75 * dir;
            track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        };

        /* ── Unified Real-Time Category & Price Store Filter Engine ── */
        /* ── Unified Real-Time Category, Sub-Category & Price Store Filter Engine ── */
        var activePriceTier = null;
        var activeCatalogCategory = 'All';
        var activeCatalogSubCategory = 'all_sub';
        var activeCatalogSubCategoryLabel = '';

        var wsCategoryTaxonomy = {
            'Kurtis': {
                title: 'Kurtis & Sets',
                icon: '<svg viewBox="0 0 24 24"><path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/></svg>',
                subcategories: [
                    { name: 'All Kurtis & Sets', filter: 'all_sub', icon: '✨' },
                    { name: 'Sharara & Anarkali Sets', filter: 'sharara', icon: '🔥' },
                    { name: 'Straight Cut Kurtis', filter: 'straight', icon: '👗' },
                    { name: 'Lakhnavi Chikan Work', filter: 'chikan', icon: '💎' },
                    { name: 'Printed Cotton Kurtis', filter: 'cotton', icon: '🌸' },
                    { name: 'Rayon Everyday Sets', filter: 'rayon', icon: '⚡' }
                ]
            },
            'Sarees': {
                title: 'Sarees',
                icon: '<svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>',
                subcategories: [
                    { name: 'All Sarees', filter: 'all_sub', icon: '🥻' },
                    { name: 'Kanjivaram Silk', filter: 'kanjivaram', icon: '👑' },
                    { name: 'Dola & Paithani Silk', filter: 'dola', icon: '✨' },
                    { name: 'Georgette & Chiffon', filter: 'georgette', icon: '🔥' },
                    { name: 'Chanderi Festive', filter: 'chanderi', icon: '💎' },
                    { name: 'Bandhani Art Silk', filter: 'bandhani', icon: '⚡' }
                ]
            },
            'Lehengas': {
                title: 'Lehengas',
                icon: '<svg viewBox="0 0 24 24"><polygon points="12 2 2 22 22 22 12 2"/><line x1="12" y1="2" x2="12" y2="22"/></svg>',
                subcategories: [
                    { name: 'All Lehengas', filter: 'all_sub', icon: '👑' },
                    { name: 'Bridal Velvet', filter: 'velvet', icon: '💎' },
                    { name: 'Zardosi Heavy Work', filter: 'zardosi', icon: '✨' },
                    { name: 'Semi-Bridal Art Silk', filter: 'silk', icon: '🔥' },
                    { name: 'Festive Georgette', filter: 'georgette', icon: '🌸' }
                ]
            },
            'Gowns': {
                title: 'Gowns & Indo-Western',
                icon: '<svg viewBox="0 0 24 24"><path d="M12 2a4 4 0 0 0-4 4c0 3 4 8 4 8s4-5 4-8a4 4 0 0 0-4-4z"/><path d="M5 21c0-4 3-7 7-7s7 3 7 7"/></svg>',
                subcategories: [
                    { name: 'All Gowns', filter: 'all_sub', icon: '💃' },
                    { name: 'Flared Designer Gowns', filter: 'flared', icon: '✨' },
                    { name: 'Indo-Western Fusion', filter: 'indo', icon: '🔥' },
                    { name: 'Embroidered Festive', filter: 'embroidered', icon: '💎' }
                ]
            },
            'Dress Materials': {
                title: 'Dress Materials',
                icon: '<svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>',
                subcategories: [
                    { name: 'All Dress Materials', filter: 'all_sub', icon: '🧵' },
                    { name: 'Pure Cotton Suit Lots', filter: 'cotton', icon: '🚀' },
                    { name: 'Chanderi Jacquard Suits', filter: 'chanderi', icon: '✨' },
                    { name: 'Silk Touch Unstitched', filter: 'silk', icon: '💎' }
                ]
            }
        };

        function filterByPriceTier(maxPrice, cardElem) {
            var cards = document.querySelectorAll('.ws-price-box-card');

            if (activePriceTier === maxPrice) {
                // Clicking active price box again toggles off the price filter
                activePriceTier = null;
                cards.forEach(function(c) { c.classList.remove('active'); });
            } else {
                activePriceTier = maxPrice;
                cards.forEach(function(c) { c.classList.remove('active'); });
                if (cardElem) {
                    cardElem.classList.add('active');
                } else {
                    cards.forEach(function(c) {
                        if (c.textContent.indexOf('₹' + Number(maxPrice).toLocaleString('en-IN')) !== -1 || (c.getAttribute('onclick') && c.getAttribute('onclick').indexOf(String(maxPrice)) !== -1)) {
                            c.classList.add('active');
                        }
                    });
                }
            }

            applyUnifiedCatalogFilterEngine(true);
        };

        function selectWsCategory(catName) {
            if (catName === 'All') {
                closeWsCatalogCategoryModal();
                if (typeof window.switchWsTab === 'function') {
                    window.switchWsTab('trending');
                }
                activeCatalogCategory = 'All';
                activeCatalogSubCategory = 'all_sub';
                activeCatalogSubCategoryLabel = '';
                applyUnifiedCatalogFilterEngine(true);
                return;
            }

            // Drill down into sub-categories inside the modal
            renderSubCategoriesInModal(catName);
        };

        function selectWsSubCategory(catName, subFilter, subLabel) {
            closeWsCatalogCategoryModal();
            if (typeof window.switchWsTab === 'function') {
                window.switchWsTab('trending');
            }
            activeCatalogCategory = catName;
            activeCatalogSubCategory = subFilter || 'all_sub';
            activeCatalogSubCategoryLabel = (subFilter === 'all_sub' ? '' : subLabel);
            applyUnifiedCatalogFilterEngine(true);
        };

        function clearCategoryOnlyFilter() {
            activeCatalogCategory = 'All';
            activeCatalogSubCategory = 'all_sub';
            activeCatalogSubCategoryLabel = '';
            applyUnifiedCatalogFilterEngine(false);
        };

        function clearSubCategoryOnlyFilter() {
            activeCatalogSubCategory = 'all_sub';
            activeCatalogSubCategoryLabel = '';
            applyUnifiedCatalogFilterEngine(false);
        };

        function clearPriceOnlyFilter() {
            activePriceTier = null;
            document.querySelectorAll('.ws-price-box-card').forEach(function(c) { c.classList.remove('active'); });
            applyUnifiedCatalogFilterEngine(false);
        };

        function clearAllCatalogFilters() {
            activeCatalogCategory = 'All';
            activeCatalogSubCategory = 'all_sub';
            activeCatalogSubCategoryLabel = '';
            activePriceTier = null;
            document.querySelectorAll('.ws-price-box-card').forEach(function(c) { c.classList.remove('active'); });
            applyUnifiedCatalogFilterEngine(false);
        };

        function resetCatalogFilter() {
            clearAllCatalogFilters();
        };

        function renderMainCategoriesInModal() {
            var backBtn = document.getElementById('wsCatModalBackBtn');
            var titleElem = document.getElementById('wsCatModalHeaderTitle');
            var grid = document.getElementById('wsCatModalDynamicGrid');

            if (backBtn) backBtn.style.display = 'none';
            if (titleElem) titleElem.textContent = 'Select Category';
            if (!grid) return;

            var cats = [
                { id: 'Sarees', title: 'Sarees', icon: '<svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>' },
                { id: 'Kurtis', title: 'Kurtis & Sets', icon: '<svg viewBox="0 0 24 24"><path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/></svg>' },
                { id: 'Lehengas', title: 'Lehengas', icon: '<svg viewBox="0 0 24 24"><polygon points="12 2 2 22 22 22 12 2"/><line x1="12" y1="2" x2="12" y2="22"/></svg>' },
                { id: 'Gowns', title: 'Gowns & Indo-Western', icon: '<svg viewBox="0 0 24 24"><path d="M12 2a4 4 0 0 0-4 4c0 3 4 8 4 8s4-5 4-8a4 4 0 0 0-4-4z"/><path d="M5 21c0-4 3-7 7-7s7 3 7 7"/></svg>' },
                { id: 'Dress Materials', title: 'Dress Materials', icon: '<svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>' },
                { id: 'All', title: 'All Collections', isAll: true, icon: '<svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>' }
            ];

            var html = '';
            cats.forEach(function(c) {
                html += `
                    <div class="ws-cat-tile-card ${c.isAll ? 'all-cat' : ''}" onclick="selectWsCategory('${c.id}')">
                        <div class="ws-cat-tile-icon-wrap">
                            ${c.icon}
                        </div>
                        <div class="ws-cat-tile-content">
                            <div class="ws-cat-tile-title">${c.title}</div>
                        </div>
                        <div class="ws-cat-tile-arrow">→</div>
                    </div>
                `;
            });

            grid.innerHTML = html;
        }

        function renderSubCategoriesInModal(catName) {
            var backBtn = document.getElementById('wsCatModalBackBtn');
            var titleElem = document.getElementById('wsCatModalHeaderTitle');
            var grid = document.getElementById('wsCatModalDynamicGrid');

            var catData = wsCategoryTaxonomy[catName];
            if (!catData || !catData.subcategories) {
                // If no subcategories, filter directly
                selectWsSubCategory(catName, 'all_sub', '');
                return;
            }

            if (backBtn) backBtn.style.display = 'inline-block';
            if (titleElem) titleElem.textContent = catData.title + ' Sub-Categories';
            if (!grid) return;

            var html = '';
            catData.subcategories.forEach(function(sub) {
                html += `
                    <div class="ws-cat-tile-card" onclick="selectWsSubCategory('${catName}', '${sub.filter}', '${sub.name}')">
                        <div class="ws-cat-tile-icon-wrap">
                            <span style="font-size:1.15rem; line-height:1;">${sub.icon}</span>
                        </div>
                        <div class="ws-cat-tile-content">
                            <div class="ws-cat-tile-title">${sub.name}</div>
                        </div>
                        <div class="ws-cat-tile-arrow">→</div>
                    </div>
                `;
            });

            grid.innerHTML = html;
        }

        function applyUnifiedCatalogFilterEngine(showToast) {
            var btnLabel = document.getElementById('wsCatPickerBtnLabel');
            var titleElem = document.getElementById('wsCatalogMainTitle');
            var filterBar = document.getElementById('wsActiveCategoryFilterBar');
            var catPill = document.getElementById('wsFilterCategoryPill');
            var subCatPill = document.getElementById('wsFilterSubCategoryPill');
            var pricePill = document.getElementById('wsFilterPricePill');
            var activeNameElem = document.getElementById('wsActiveCatName');
            var activeSubNameElem = document.getElementById('wsActiveSubCatName');
            var activePriceElem = document.getElementById('wsActivePriceName');
            var activeCountElem = document.getElementById('wsActiveCatCount');

            var track = document.getElementById('wsForYouSliderTrack');
            if (!track) return;

            var productCards = Array.from(track.querySelectorAll('.product-card'));
            var matchCount = 0;
            var matchingCards = [];
            var nonMatchingCards = [];

            // Update UI headers
            if (btnLabel) {
                if (activeCatalogCategory === 'All') {
                    btnLabel.textContent = 'All Categories ▾';
                } else if (activeCatalogSubCategory && activeCatalogSubCategory !== 'all_sub') {
                    btnLabel.textContent = activeCatalogSubCategoryLabel + ' ▾';
                } else {
                    btnLabel.textContent = activeCatalogCategory + ' ▾';
                }
            }
            if (titleElem) {
                if (activeCatalogCategory === 'All') {
                    titleElem.textContent = 'For You';
                } else if (activeCatalogSubCategory && activeCatalogSubCategory !== 'all_sub') {
                    titleElem.textContent = activeCatalogCategory + ' • ' + activeCatalogSubCategoryLabel;
                } else {
                    titleElem.textContent = activeCatalogCategory + ' Catalog';
                }
            }

            // Filter products matching category, sub-category and price
            productCards.forEach(function(card) {
                var prodId = card.getAttribute('data-product-id');
                var pData = (window.allProducts || []).find(function(item) { return Number(item.id) === Number(prodId); });
                var pCat = pData ? (pData.category || '').toLowerCase() : '';
                var cardCat = card.querySelector('.card-cat-photo-tag') ? card.querySelector('.card-cat-photo-tag').textContent.trim().toLowerCase() : '';
                var pName = pData ? (pData.name || '').toLowerCase() : '';
                var pFabric = pData ? (pData.fabric || '').toLowerCase() : '';
                var price = pData ? (Number(pData.wholesale_price) || Number(pData.price) || 0) : 0;

                // 1. Main Category Check
                var isCatMatch = false;
                if (activeCatalogCategory === 'All') {
                    isCatMatch = true;
                } else if (activeCatalogCategory === 'Sarees' && (pCat.indexOf('saree') !== -1 || cardCat.indexOf('saree') !== -1)) {
                    isCatMatch = true;
                } else if (activeCatalogCategory === 'Kurtis' && (pCat.indexOf('kurti') !== -1 || cardCat.indexOf('kurti') !== -1)) {
                    isCatMatch = true;
                } else if (activeCatalogCategory === 'Lehengas' && (pCat.indexOf('lehenga') !== -1 || cardCat.indexOf('lehenga') !== -1)) {
                    isCatMatch = true;
                } else if (activeCatalogCategory === 'Gowns' && (pCat.indexOf('gown') !== -1 || cardCat.indexOf('gown') !== -1)) {
                    isCatMatch = true;
                } else if (activeCatalogCategory === 'Dress Materials' && (pCat.indexOf('dress') !== -1 || pCat.indexOf('dupatta') !== -1 || cardCat.indexOf('dress') !== -1 || cardCat.indexOf('dupatta') !== -1)) {
                    isCatMatch = true;
                } else if (pCat === activeCatalogCategory.toLowerCase() || cardCat === activeCatalogCategory.toLowerCase()) {
                    isCatMatch = true;
                }

                // 2. Sub-Category Check
                var isSubMatch = true;
                if (activeCatalogSubCategory && activeCatalogSubCategory !== 'all_sub') {
                    var kw = activeCatalogSubCategory.toLowerCase();
                    var combinedText = pName + ' ' + pFabric + ' ' + pCat;
                    if (combinedText.indexOf(kw) === -1) {
                        isSubMatch = false;
                    }
                }

                // 3. Price Check
                var isPriceMatch = true;
                if (activePriceTier !== null) {
                    isPriceMatch = (price > 0 && price <= activePriceTier);
                }

                if (isCatMatch && isSubMatch && isPriceMatch) {
                    card.style.display = 'flex';
                    matchingCards.push(card);
                    matchCount++;
                } else {
                    card.style.display = 'none';
                    nonMatchingCards.push(card);
                }
            });

            // Sort matching cards: new arrivals & new catalogue lots first
            matchingCards.sort(function(a, b) {
                var badgeA = (a.querySelector('.card-badge') ? a.querySelector('.card-badge').textContent.toLowerCase() : '');
                var badgeB = (b.querySelector('.card-badge') ? b.querySelector('.card-badge').textContent.toLowerCase() : '');
                var isNewA = badgeA.indexOf('new') !== -1 ? 1 : 0;
                var isNewB = badgeB.indexOf('new') !== -1 ? 1 : 0;
                return isNewB - isNewA;
            });

            // Append matching cards in prioritized order
            matchingCards.forEach(function(card) { track.appendChild(card); });
            nonMatchingCards.forEach(function(card) { track.appendChild(card); });

            // Update Filter Status Bar
            var hasFilter = (activeCatalogCategory !== 'All' || (activeCatalogSubCategory && activeCatalogSubCategory !== 'all_sub') || activePriceTier !== null);
            if (filterBar) {
                if (hasFilter) {
                    filterBar.style.display = 'flex';
                    if (catPill) {
                        if (activeCatalogCategory !== 'All') {
                            catPill.style.display = 'inline-flex';
                            if (activeNameElem) activeNameElem.textContent = activeCatalogCategory;
                        } else {
                            catPill.style.display = 'none';
                        }
                    }
                    if (subCatPill) {
                        if (activeCatalogSubCategory && activeCatalogSubCategory !== 'all_sub') {
                            subCatPill.style.display = 'inline-flex';
                            if (activeSubNameElem) activeSubNameElem.textContent = activeCatalogSubCategoryLabel;
                        } else {
                            subCatPill.style.display = 'none';
                        }
                    }
                    if (pricePill) {
                        if (activePriceTier !== null) {
                            pricePill.style.display = 'inline-flex';
                            if (activePriceElem) activePriceElem.textContent = 'Under ₹' + Number(activePriceTier).toLocaleString('en-IN');
                        } else {
                            pricePill.style.display = 'none';
                        }
                    }
                    if (activeCountElem) {
                        activeCountElem.textContent = '(' + matchCount + ' Lots Available)';
                    }
                } else {
                    filterBar.style.display = 'none';
                }
            }

            if (showToast && typeof window.showWsToast === 'function') {
                if (!hasFilter) {
                    showWsToast('✓ Showing All Available Reseller Lots');
                } else if (activeCatalogSubCategory && activeCatalogSubCategory !== 'all_sub') {
                    showWsToast('👗 ' + activeCatalogSubCategoryLabel + ' (' + matchCount + ' Lots Available)');
                } else if (activeCatalogCategory !== 'All' && activePriceTier !== null) {
                    showWsToast('🏷️ ' + activeCatalogCategory + ' Under ₹' + Number(activePriceTier).toLocaleString('en-IN') + ' (' + matchCount + ' Lots)');
                } else if (activeCatalogCategory !== 'All') {
                    showWsToast('🥻 ' + activeCatalogCategory + ' (' + matchCount + ' Lots Available)');
                } else if (activePriceTier !== null) {
                    showWsToast('🏷️ Under ₹' + Number(activePriceTier).toLocaleString('en-IN') + ' (' + matchCount + ' Lots Available)');
                }
            }

            // Smooth scroll to catalog view
            var scrollTarget = document.getElementById('wsActiveCategoryFilterBar') || track;
            if (scrollTarget && hasFilter) {
                scrollTarget.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        function openWsCatalogCategoryModal() {
            var modal = document.getElementById('wsCatalogCategoryModal');
            if (!modal) return;

            // If a specific category like Kurtis or Sarees is already active, open its sub-categories directly!
            if (activeCatalogCategory && activeCatalogCategory !== 'All' && wsCategoryTaxonomy[activeCatalogCategory]) {
                renderSubCategoriesInModal(activeCatalogCategory);
            } else {
                renderMainCategoriesInModal();
            }

            showModal('wsCatalogCategoryModal');
        };

        function closeWsCatalogCategoryModal() {
            hideModal('wsCatalogCategoryModal');
        };

        /* ── Smart 1-Line Auto Slider Engine (For Sliders Only) ── */
        function initSmartCatalogAutoSliders() {
            var sliderIds = ['wsTrendingSliderTrack', 'wsPriceSliderTrack'];
            sliderIds.forEach(function(id) {
                var track = document.getElementById(id);
                if (!track) return;
                var isPaused = false;
                track.addEventListener('mouseenter', function() { isPaused = true; });
                track.addEventListener('mouseleave', function() { isPaused = false; });
                track.addEventListener('touchstart', function() { isPaused = true; }, { passive: true });
                track.addEventListener('touchend', function() {
                    setTimeout(function() { isPaused = false; }, 3000);
                }, { passive: true });

                setInterval(function() {
                    if (isPaused || !track.offsetParent) return;
                    var maxScroll = track.scrollWidth - track.clientWidth;
                    if (track.scrollLeft >= maxScroll - 8) {
                        track.scrollTo({ left: 0, behavior: 'smooth' });
                    } else {
                        var card = track.querySelector('.product-card, .ws-price-box-card');
                        var step = card ? (card.offsetWidth + 12) : 200;
                        track.scrollBy({ left: step, behavior: 'smooth' });
                    }
                }, 4000);
            });
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initSmartCatalogAutoSliders);
        } else {
            initSmartCatalogAutoSliders();
        }

        /* ── Direct Add Reseller Lot to Cart with Smart Button Feedback ── */
        function directAddWholesaleToCart(prodOrId, btn) {
            try {
                var prod = (typeof prodOrId === 'object' && prodOrId !== null) ? prodOrId :
                    ((window.allProducts || []).find(function(p) { return Number(p.id) === Number(prodOrId); }) || null);
                // The fallback here used to invent a product at Rs 2,199 with an MOQ of 12,
                // so an id that is no longer in the catalogue still produced a priced line.
                if (!prod || !prod.id) {
                    if (typeof window.showWsToast === 'function') {
                        window.showWsToast('That product is not in the catalogue any more. Please refresh the page.');
                    }
                    return;
                }
                var raw = localStorage.getItem('dtbrands_cart');
                var cart = raw ? JSON.parse(raw) : [];
                var prodId = prod.id;
                var exists = cart.find(function(item) { return Number(item.id) === Number(prodId); });
                var addQty = Number(prod.moq) > 0 ? Number(prod.moq) : 1;
                if (exists) {
                    exists.qty = (Number(exists.qty) || addQty) + addQty;
                } else {
                    cart.push({
                        id: prod.id,
                        name: prod.name,
                        price: Number(prod.wholesale_price) || Number(prod.price) || 0,
                        wholesale_price: Number(prod.wholesale_price) || Number(prod.price) || 0,
                        retail_price: Number(prod.retail_price) || Number(prod.old_price) || 0,
                        qty: addQty,
                        image: prod.image || '/assets/images/no-image.svg',
                        color: prod.color || '',
                        moq: addQty,
                        category: prod.category || ''
                    });
                }
                localStorage.setItem('dtbrands_cart', JSON.stringify(cart));
                updateWholesaleCartBadge();

                // Button Ripple & Check Animation
                if (btn) {
                    btn.classList.add('added');
                    btn.innerHTML = '<svg style="width:14px;height:14px;stroke:#FFFFFF;fill:none;stroke-width:2.8;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>';
                    setTimeout(function() {
                        btn.classList.remove('added');
                        btn.innerHTML = '<svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>';
                    }, 1400);
                }

                if (typeof window.showWsToast === 'function') {
                    showWsToast('🛍️ Added ' + prod.name + ' (' + addQty + ' Pcs Lot) to Cart!');
                }
            } catch(e) {
                console.error(e);
            }
        };
        function openQuickOrderModal(prodOrId) {
            var prod = (typeof prodOrId === 'object' && prodOrId !== null) ? prodOrId :
                ((window.allProducts || []).find(function(p) { return Number(p.id) === Number(prodOrId); }) || null);
            // The fallback here used to invent a product at Rs 2,199 with an MOQ of 12,
            // so an id that is no longer in the catalogue still produced a priced line.
            if (!prod || !prod.id) {
                if (typeof window.showWsToast === 'function') {
                    window.showWsToast('That product is not in the catalogue any more. Please refresh the page.');
                }
                return;
            }
            var userRaw = localStorage.getItem('dtbrands_user');
            var user = userRaw ? JSON.parse(userRaw) : {};
            var company = user.companyName || 'Reseller Buyer';
            var gst = user.gst_number || 'Non-GST';

            var text = `👑 *RESELLER BULK LOT INQUIRY — DT BRAND'S B2B*\n\n` +
                       `*Product:* ${prod.name}${prod.sku ? ` (SKU: ${prod.sku})` : ''}\n` +
                       (prod.hsn ? `*HSN Code:* ${prod.hsn}\n` : '') +
                       `*Reseller B2B Price:* ${Number(prod.wholesale_price || prod.price) > 0 ? '₹' + Number(prod.wholesale_price || prod.price) + ' / Pc' : 'to be confirmed'}\n` +
                       (Number(prod.moq) > 0 ? `*Minimum Order Qty (MOQ):* ${Number(prod.moq)} Pcs\n` : '') +
                       (prod.tier_prices ? `*Lot Pricing:* ${prod.tier_prices}\n` : '') +
                       `\n` +
                       `*Buyer Business:* ${company}\n` +
                       `*GSTIN:* ${gst}\n` +
                       `*Representative:* ${user.name || 'Member'} (${user.phone || ''})\n\n` +
                       `Please confirm lot availability, dispatch turnaround and proforma payment details.`;

            var waUrl = `https://api.whatsapp.com/send?phone=917046363528&text=${encodeURIComponent(text)}`;
            window.open(waUrl, '_blank');
        };

        /* ── Reseller Wishlist Controller ── */
        function toggleWholesaleWishlist(productId, btn) {
            var p = (window.allProducts || []).find(function(item) { return Number(item.id) === Number(productId); });
            if (p && typeof window.toggleWishlistProduct === 'function') {
                var added = window.toggleWishlistProduct(p);
                if (btn) {
                    btn.classList.toggle('active', added);
                    btn.setAttribute('aria-pressed', added ? 'true' : 'false');
                }
                if (typeof showToast === 'function') {
                    showToast(added ? '♡ Saved ' + p.name + ' to Wishlist' : 'Removed from Wishlist');
                } else if (typeof window.showWsToast === 'function') {
                    showWsToast(added ? '♡ Saved ' + p.name + ' to Wishlist' : 'Removed from Wishlist');
                }
                return;
            }

            var raw = localStorage.getItem('dtbrands_wishlist');
            var wish = raw ? JSON.parse(raw) : [];
            var idx = wish.findIndex(function(i){ return Number(i.id) === Number(productId); });
            if (idx > -1) {
                wish.splice(idx, 1);
                if (btn) btn.classList.remove('active');
                if (typeof window.showWsToast === 'function') showWsToast('Item removed from Procurement Wishlist');
            } else {
                wish.push({ id: productId });
                if (btn) btn.classList.add('active');
                if (typeof window.showWsToast === 'function') showWsToast('Saved to B2B Procurement Wishlist');
            }
            localStorage.setItem('dtbrands_wishlist', JSON.stringify(wish));
        };

        /* ── Share Reseller Lot (Triggers Smart Share or WhatsApp) ── */
        function shareWholesaleProduct(prod) {
            if (typeof window.shareProductCard === 'function' && prod && prod.id) {
                shareProductCard(prod.id);
                return;
            }
            var text = `*DT BRAND'S B2B RESELLER LOT*\n\n` +
                       `*Product:* ${prod.name}${prod.sku ? ` (SKU: ${prod.sku})` : ''}\n` +
                       `*Reseller B2B Price:* ${Number(prod.wholesale_price) > 0 ? '₹' + Number(prod.wholesale_price) + ' / Pc' : 'to be confirmed'}${Number(prod.retail_price) > Number(prod.wholesale_price) ? ` (Catalogue MRP: ₹${Number(prod.retail_price)})` : ''}\n` +
                       (Number(prod.moq) > 0 ? `*MOQ:* ${Number(prod.moq)} Pcs Pack\n` : '') +
                       (prod.fabric ? `*Fabric:* ${prod.fabric}\n` : '') +
                       (prod.tier_prices ? `*Lot Rates:* ${prod.tier_prices}\n` : '') +
                       `\n` +
                       `Explore live reseller portal: ${window.location.origin}/reseller.php`;
            var waUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(text)}`;
            window.open(waUrl, '_blank');
        };

        /* ── Global Product Card Share Function (Matches shop.php Smart Share) ── */
        function shareProductCard(productId) {
            var p = (window.allProducts || []).find(function(item) { return Number(item.id) === Number(productId); });
            if (p && typeof window.openSmartShareModal === 'function') {
                var itemData = {
                    id: p.id,
                    name: p.name,
                    category: p.category,
                    price: p.price,
                    old_price: p.old_price,
                    discount: p.discount,
                    image: p.image,
                    fabric: p.fabric || '',
                    colors: Array.isArray(p.colors) ? p.colors.join(', ') : (p.color || ''),
                    sizes: Array.isArray(p.size) ? p.size.join(', ') : (p.size || ''),
                    url: '/product.php?id=' + p.id
                };
                window.openSmartShareModal(itemData);
            } else if (p) {
                var waUrl = 'https://api.whatsapp.com/send?text=' + encodeURIComponent('Check out ' + p.name + ' on DT Brand\'s Reseller Hub: ' + window.location.origin + '/product.php?id=' + p.id);
                window.open(waUrl, '_blank');
            }
        };

        /* ── Monthly Sales Chart Data & Interactive Tooltips ── */
        var MONTH_SALES_DATA = [
            { m: 'Jan', val: '₹1,24,000', qty: '32 Pcs', growth: '+5.2%' },
            { m: 'Feb', val: '₹3,42,000', qty: '84 Pcs', growth: '+28.4%' },
            { m: 'Mar', val: '₹1,48,000', qty: '38 Pcs', growth: '+4.1%' },
            { m: 'Apr', val: '₹2,88,000', qty: '72 Pcs', growth: '+19.6%' },
            { m: 'May', val: '₹1,36,000', qty: '35 Pcs', growth: '-2.0%' },
            { m: 'Jun', val: '₹1,65,000', qty: '42 Pcs', growth: '+8.3%' },
            { m: 'Jul', val: '₹2,72,000', qty: '68 Pcs', growth: '+15.2%' },
            { m: 'Aug', val: '₹2,05,062', qty: '48 Pcs', growth: '↑ 18.4%' },
            { m: 'Sep', val: '₹1,90,000', qty: '46 Pcs', growth: '+7.5%' },
            { m: 'Oct', val: '₹3,85,000', qty: '96 Pcs', growth: '+32.0%' },
            { m: 'Nov', val: '₹2,48,000', qty: '62 Pcs', growth: '+12.8%' },
            { m: 'Dec', val: '₹1,15,000', qty: '28 Pcs', growth: '-5.0%' }
        ];

        function showChartNodeTooltip(idx) {
            var item = MONTH_SALES_DATA[idx];
            if (!item) return;
            var el = document.getElementById('chartTooltipText');
            if (el) el.textContent = `${item.m}: ${item.val} • ${item.qty} (${item.growth})`;
            document.querySelectorAll('.ws-chart-node').forEach(function(node, i) {
                node.classList.toggle('active', i === idx);
            });
            document.querySelectorAll('.ws-chart-x-axis span').forEach(function(span, i) {
                span.classList.toggle('active', i === idx);
            });
        };

        function switchSalesChartStyle(type, btn) {
            document.querySelectorAll('.ws-chart-type-btn').forEach(function(b) { b.classList.remove('active'); });
            if (btn) btn.classList.add('active');

            var line = document.getElementById('svgLinePath');
            var area = document.getElementById('svgAreaPath');
            if (!line || !area) return;

            if (type === 'smooth') {
                // Smooth curved spline wave (Luxury Cubic Curve)
                var smoothLine = 'M 40,115 C 63,115 63,96 86,96 C 109,96 109,102 132,102 C 155,102 155,85 178,85 C 201,85 201,76 224,76 C 247,76 247,82 270,82 C 293,82 293,62 316,62 C 339,62 339,88 362,88 C 385,88 385,68 408,68 C 431,68 431,38 454,38 C 477,38 477,52 500,52 C 523,52 523,94 546,94';
                var smoothArea = smoothLine + ' L 546,158 L 40,158 Z';
                line.setAttribute('d', smoothLine);
                area.setAttribute('d', smoothArea);
            } else {
                // Crisp Zigzag Lines (Luxury Style)
                var zigzagLine = 'M 40,115 L 86,96 L 132,102 L 178,85 L 224,76 L 270,82 L 316,62 L 362,88 L 408,68 L 454,38 L 500,52 L 546,94';
                var zigzagArea = zigzagLine + ' L 546,158 L 40,158 Z';
                line.setAttribute('d', zigzagLine);
                area.setAttribute('d', zigzagArea);
            }
        };

        /* ── Animate Target Gauge Percentage Count-up ── */
        
function animateTargetGauge(pct) {
    try {
        var p = Number(pct) || 75.55;
        var valEl = document.getElementById('targetGaugeVal');
        var fillEl = document.getElementById('targetGaugeFill');
        if (valEl) valEl.textContent = p.toFixed(2) + '%';
        if (fillEl) {
            var totalLen = 251.2;
            var offset = totalLen - (totalLen * (p / 100));
            fillEl.style.strokeDashoffset = offset;
        }
    } catch(e) {}
}
window.animateTargetGauge = animateTargetGauge;
 

        /* ── Reseller Logout ── */
        function handleWholesalerLogout() {
            if (confirm('Are you sure you want to log out of the Reseller Portal?')) {
                localStorage.removeItem('dtbrands_user');
                window.location.href = '../Shop/shop.php';
            }
        };

        /* ── Initialize Application ── */
        function initResellerApp() {
            if (!checkResellerSecurity()) return;

            var products = (function() {
                try {
                    var el = document.getElementById('ws-catalog-data');
                    return el ? JSON.parse(el.textContent || el.innerHTML || '[]') : [];
                } catch(e) { return []; }
            })();
            window.allProducts = Array.isArray(products) ? products : [];

            activeOrdersList = SAMPLE_ORDERS.slice();
            activeTicketsList = SAMPLE_TICKETS.slice();

            loadSavedResellerData();
            renderOrdersView(activeOrdersList);
            renderReportsView(activeOrdersList);
            renderTrackingTab(activeOrdersList);
            renderTicketsView();
            animateTargetGauge(75.55);
            updateWholesaleCartBadge();
        }

        /* ── Live Shipment Tracking Controller ── */
        var activeTrackOrderId = 'KLN-WS-8021';
        var currentTrackFilter = 'all';

        function renderTrackingTab(orders, selectedId) {
            if (selectedId) activeTrackOrderId = selectedId;
            var heroContainer = document.getElementById('wsActiveTrackHero');
            var gridContainer = document.getElementById('wsTrackingOrdersGrid');
            var headerBadge = document.getElementById('trackHeaderBadge');
            if (!heroContainer || !gridContainer) return;

            var list = orders || activeOrdersList;
            var currentOrder = list.find(function(o){ return o.id === activeTrackOrderId; }) || list[0];
            if (!currentOrder) return;
            activeTrackOrderId = currentOrder.id;

            if (headerBadge) {
                headerBadge.className = 'ws-status-badge ' + currentOrder.status.toLowerCase();
                headerBadge.innerHTML = '⚡ ' + currentOrder.courier;
            }

            // 1. Render Active Hero Card
            var isDelivered = currentOrder.status.toLowerCase() === 'delivered';
            var isProcessing = currentOrder.status.toLowerCase() === 'processing';

            var etaText = isDelivered ? 'Delivered on ' + currentOrder.date : (isProcessing ? 'Dispatching from Atelier' : 'Tomorrow, 17 Aug 2026');
            var etaColor = isDelivered ? '#15803D' : (isProcessing ? '#B45309' : 'var(--ws-gold-primary)');

            heroContainer.innerHTML = `
                <!-- Top Header: Consignment ID + Status Pill + ETA -->
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:12px; padding-bottom:10px; border-bottom:1px dashed var(--ws-border);">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span class="ws-order-id-cell" style="font-size:1.05rem; font-weight:800;">${currentOrder.id}</span>
                        <span class="ws-status-badge ${currentOrder.status.toLowerCase()}" style="font-size:0.75rem; padding:3px 8px;">${currentOrder.status}</span>
                    </div>
                    <div style="font-size:0.80rem; font-weight:800; color:${etaColor};">
                        📅 ${etaText}
                    </div>
                </div>

                <!-- Product & Courier Info Strip -->
                <div style="display:flex; gap:12px; align-items:center; margin-bottom:14px; background:#FFFFFF; border:1px solid var(--ws-border); border-radius:8px; padding:10px 12px; box-shadow:0 1px 3px rgba(0,0,0,0.02);">
                    <img src="${currentOrder.image}" alt="${currentOrder.productName}" style="width:54px; height:68px; border-radius:6px; object-fit:cover; border:1px solid var(--ws-border); flex-shrink:0; background:#FAF8F4;" onerror="this.onerror=null;this.src='/assets/images/no-image.svg';">
                    <div style="flex:1; min-width:0;">
                        <h4 style="font-size:0.92rem; font-weight:800; color:var(--ws-text-main); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:2px;">${currentOrder.productName}</h4>
                        <div style="font-size:0.74rem; color:var(--ws-text-muted); margin-bottom:4px;">
                            Consignment Lot: <strong>${currentOrder.qty} Pcs</strong> • ${currentOrder.color || 'Standard'}
                        </div>
                        <div style="font-size:0.74rem; color:var(--ws-text-sub); display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                            <span>${currentOrder.courier}</span>
                            <span style="font-family:monospace; background:#FAF8F4; padding:1px 6px; border-radius:4px; border:1px solid var(--ws-border); font-weight:700;">${currentOrder.awb}</span>
                            <button onclick="copyAwbNumber('${currentOrder.awb}')" style="background:transparent; border:none; color:var(--ws-gold-primary); cursor:pointer; display:inline-flex; align-items:center; justify-content:center; padding:2px;" title="Copy AWB">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step-by-Step Logistics Milestones Timeline -->
                <div class="ws-track-timeline">
                    <div class="ws-timeline-step completed">
                        <div class="ws-timeline-dot"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                        <div class="ws-timeline-title">Order Confirmed & Proforma Invoiced</div>
                        <div class="ws-timeline-date">DT Brand\'s Head Atelier, Surat • ${currentOrder.date}, 10:30 AM</div>
                    </div>
                    <div class="ws-timeline-step ${isProcessing ? 'active' : 'completed'}">
                        <div class="ws-timeline-dot"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                        <div class="ws-timeline-title">QC Inspection & Sealed Bale Packaging Completed</div>
                        <div class="ws-timeline-date">Zari & Silk Logistics Warehouse • Verified for Transit</div>
                    </div>
                    <div class="ws-timeline-step ${isDelivered ? 'completed' : (isProcessing ? '' : 'active')}">
                        <div class="ws-timeline-dot"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                        <div class="ws-timeline-title">${isDelivered ? 'Transit Completed — Received at Warehouse Godown' : 'In Transit — Dispatched via Priority Air Cargo'}</div>
                        <div class="ws-timeline-date">${currentOrder.courier} (AWB: ${currentOrder.awb}) • Live GPS Tracking Active</div>
                    </div>
                    <div class="ws-timeline-step ${isDelivered ? 'completed' : ''}">
                        <div class="ws-timeline-dot"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                        <div class="ws-timeline-title">${isDelivered ? 'Delivered & Consignment Accepted' : 'Out for Final Delivery'}</div>
                        <div class="ws-timeline-date">${isDelivered ? 'Delivered on ' + currentOrder.date + ' with OTP Verification' : 'Expected delivery window: 10:00 AM - 04:00 PM'}</div>
                    </div>
                </div>

                <!-- Action Buttons: Clean Dual Grid with Auto Sizes -->
                <div class="ws-dual-action-grid">
                    <button class="ws-btn ws-btn-primary" onclick='openBillInvoiceModal(${JSON.stringify(currentOrder)})'>
                        <svg viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span>GST Invoice</span>
                    </button>
                    <button class="ws-btn ws-btn-secondary" onclick='viewOrderDetails(${JSON.stringify(currentOrder)})'>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        <span>Order Details</span>
                    </button>
                </div>
            `;

            // 2. Render All Consignments List
            gridContainer.innerHTML = '';
            var filteredList = list.filter(function(o) {
                if (currentTrackFilter === 'all') return true;
                return o.status.toLowerCase() === currentTrackFilter.toLowerCase();
            });

            filteredList.forEach(function(o) {
                var isSelected = o.id === activeTrackOrderId;
                var card = document.createElement('div');
                var trackStatusLabel = isSelected ? '● Currently Tracking' : '⚡ Track Consignment &rsaquo;';
                card.className = 'ws-track-order-card' + (isSelected ? ' selected' : '');
                card.onclick = function() {
                    selectTrackingOrder(o.id);
                };
                card.innerHTML = `
                    <img src="${o.image}" alt="${o.productName}" class="ws-track-order-img" onerror="this.onerror=null;this.src='/assets/images/no-image.svg';">
                    <div class="ws-track-order-info">
                        <div style="display:flex; justify-content:space-between; align-items:center; gap:6px;">
                            <strong class="ws-order-id-cell" style="font-size:0.86rem;">${o.id}</strong>
                            <span class="ws-status-badge ${o.status.toLowerCase()}" style="font-size:0.65rem;">${o.status}</span>
                        </div>
                        <div class="ws-track-order-title">${o.productName}</div>
                        <div style="font-size:0.74rem; color:var(--ws-text-muted);">
                            ${o.date} • <strong>${o.qty} Pcs</strong> • ${o.courier}
                        </div>
                        <div style="font-size:0.72rem; color:var(--ws-gold-primary); font-weight:700; margin-top:2px;">
                            ${trackStatusLabel}
                        </div>
                    </div>
                `;
                gridContainer.appendChild(card);
            });
        }

        function selectTrackingOrder(orderId) {
            activeTrackOrderId = orderId;
            renderTrackingTab(activeOrdersList, orderId);
            var hero = document.getElementById('wsActiveTrackHero');
            if (hero) {
                hero.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            showWsToast('📍 Loaded tracking timeline for ' + orderId);
        };

        function filterTrackingOrders(status, btn) {
            currentTrackFilter = status;
            if (btn && btn.parentElement) {
                btn.parentElement.querySelectorAll('button').forEach(function(b){ b.classList.remove('active'); });
                btn.classList.add('active');
            }
            renderTrackingTab(activeOrdersList, activeTrackOrderId);
        };

                function copyAwbNumber(awb) {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(awb).then(function() {
                    showWsToast('📋 AWB ' + awb + ' copied to clipboard!');
                }).catch(function() {
                    showWsToast('AWB: ' + awb);
                });
            } else {
                showWsToast('AWB: ' + awb);
            }
        }
        window.copyAwbNumber = copyAwbNumber;

        /* ── Reseller VIP Tier Controller ── */
        function getWholesaleTier(orderCount) {
            var count = Number(orderCount) || 0;
            if (count >= 1000) {
                return {
                    tierNum: 5,
                    title: "Tier 5: Platinum",
                    shortTitle: "Platinum (Tier 5)",
                    badgeText: "👑 Platinum VIP",
                    pillText: "1000+ Orders",
                    discount: "15% Margin Rebate",
                    minOrders: 1000,
                    maxOrders: Infinity,
                    nextGoal: "Top VIP Tier Reached"
                };
            } else if (count >= 301) {
                return {
                    tierNum: 4,
                    title: "Tier 4: Gold",
                    shortTitle: "Gold (Tier 4)",
                    badgeText: "⭐ Gold VIP",
                    pillText: "300–500 Orders",
                    discount: "10% Margin Rebate",
                    minOrders: 301,
                    maxOrders: 500,
                    nextGoal: (1000 - count) + " orders to Tier 5 Platinum"
                };
            } else if (count >= 201) {
                return {
                    tierNum: 3,
                    title: "Tier 3: Gold",
                    shortTitle: "Gold (Tier 3)",
                    badgeText: "⭐ Gold VIP",
                    pillText: "200–300 Orders",
                    discount: "7.5% Margin Rebate",
                    minOrders: 201,
                    maxOrders: 300,
                    nextGoal: (301 - count) + " orders to Tier 4 Gold"
                };
            } else if (count >= 51) {
                return {
                    tierNum: 2,
                    title: "Tier 2: Silver",
                    shortTitle: "Silver (Tier 2)",
                    badgeText: "🥈 Silver VIP",
                    pillText: "50–200 Orders",
                    discount: "5% Margin Rebate",
                    minOrders: 51,
                    maxOrders: 200,
                    nextGoal: (201 - count) + " orders to Tier 3 Gold"
                };
            } else {
                return {
                    tierNum: 1,
                    title: "Tier 1: Non VIP",
                    shortTitle: "Non VIP (Tier 1)",
                    badgeText: "Standard Member",
                    pillText: "1–50 Orders",
                    discount: "Standard Reseller",
                    minOrders: 1,
                    maxOrders: 50,
                    nextGoal: (51 - count) + " orders to Tier 2 Silver"
                };
            }
        };

        function openVipTierModal() {
            showModal('wsVipTierModal');
        };

        function closeVipTierModal() {
            hideModal('wsVipTierModal');
        };

        /* ── Reseller Wallet Controller ── */
        function openFullWalletModal() {
            showModal('wsFullWalletModal');
            var availEl = document.getElementById('walletAvailableBalance');
            var coinsEl = document.getElementById('walletTotalCoins');
            var mBal = document.getElementById('fullModalWalletBal');
            var mCoins = document.getElementById('fullModalCoinsBal');
            if (availEl && mBal) mBal.textContent = availEl.textContent;
            if (coinsEl && mCoins) mCoins.textContent = coinsEl.textContent + ' Coins';
        };

        function closeFullWalletModal() {
            hideModal('wsFullWalletModal');
        };

        /* ── Edit Billing Address Modal Controller ── */
        function openEditMainAddressModal() {
            var modal = document.getElementById('wsEditMainAddressModal');
            if (!modal) return;
            // Pre-fill existing data from localStorage
            try {
                var user = JSON.parse(localStorage.getItem('dtbrands_user') || '{}');
                var billing = user.billing_address || {};
                var el = function(id) { return document.getElementById(id); };
                if (el('wsMainEditCompName'))    el('wsMainEditCompName').value    = billing.company || user.company_name || '';
                if (el('wsMainEditGstNumber'))  el('wsMainEditGstNumber').value   = billing.gstin   || user.gstin        || '';
                if (el('wsMainEditAddress'))    el('wsMainEditAddress').value     = billing.address || user.address      || '';
                if (el('wsMainEditCity'))       el('wsMainEditCity').value        = billing.city    || user.city         || '';
                if (el('wsMainEditState'))      el('wsMainEditState').value       = billing.state   || user.state        || 'Gujarat';
                if (el('wsMainEditPincode'))    el('wsMainEditPincode').value     = billing.pincode || user.pincode      || '';
                if (el('wsMainEditContactPhone')) el('wsMainEditContactPhone').value = billing.phone || user.phone      || '';
            } catch(e) {}
            showModal('wsEditMainAddressModal');
        };

        function closeEditMainAddressModal() {
            hideModal('wsEditMainAddressModal');
        };

        function handleSaveMainAddressForm(e) {
            if (e) e.preventDefault();
            try {
                var user = JSON.parse(localStorage.getItem('dtbrands_user') || '{}');
                var el = function(id) { return document.getElementById(id); };
                user.billing_address = {
                    company: el('wsMainEditCompName')    ? el('wsMainEditCompName').value.trim()    : '',
                    gstin:   el('wsMainEditGstNumber')  ? el('wsMainEditGstNumber').value.trim()   : '',
                    address: el('wsMainEditAddress')    ? el('wsMainEditAddress').value.trim()     : '',
                    city:    el('wsMainEditCity')       ? el('wsMainEditCity').value.trim()        : '',
                    state:   el('wsMainEditState')      ? el('wsMainEditState').value              : 'Gujarat',
                    pincode: el('wsMainEditPincode')    ? el('wsMainEditPincode').value.trim()     : '',
                    phone:   el('wsMainEditContactPhone') ? el('wsMainEditContactPhone').value.trim() : ''
                };
                localStorage.setItem('dtbrands_user', JSON.stringify(user));
                closeEditMainAddressModal();
                loadSavedResellerData();
                renderAddressBookData(user);
                showWsToast('✓ Billing address updated successfully!');
            } catch(err) {
                closeEditMainAddressModal();
                showWsToast('✓ Billing address saved!');
            }
        };

        function openWalletTopupModal() {
            showModal('wsWalletTopupModal');
        };

        function closeWalletTopupModal() {
            hideModal('wsWalletTopupModal');
        };

        function setTopupAmount(amount, btn) {
            var input = document.getElementById('wsTopupAmountInput');
            if (input) input.value = amount;
            if (btn && btn.parentElement) {
                btn.parentElement.querySelectorAll('button').forEach(function(b){ b.classList.remove('active'); });
                btn.classList.add('active');
            }
        };

        function handleProcessWalletTopup() {
            var input = document.getElementById('wsTopupAmountInput');
            var amount = Number(input ? input.value : 50000);
            if (!amount || amount < 1000) {
                alert('Please enter a valid recharge amount (min ₹1,000)');
                return;
            }
            closeWalletTopupModal();
            var current = 45280;
            try {
                var saved = localStorage.getItem('dtbrands_wallet_cash');
                if (saved) current = Number(saved);
            } catch(e) {}
            var newBal = current + amount;
            localStorage.setItem('dtbrands_wallet_cash', newBal);
            
            var cashEl = document.getElementById('walletCashBalance');
            var availEl = document.getElementById('walletAvailableBalance');
            var modalBal = document.getElementById('modalCurrentWalletBal');
            if (cashEl) cashEl.textContent = '₹' + newBal.toLocaleString('en-IN');
            if (availEl) availEl.textContent = (newBal + 100000).toLocaleString('en-IN');
            if (modalBal) modalBal.textContent = '₹' + newBal.toLocaleString('en-IN');

            showWsToast('💳 Wallet recharged with ₹' + amount.toLocaleString('en-IN') + ' successfully!');
        };

        function requestCreditLimitBoost() {
            showWsToast('⚡ Credit Limit Boost Request submitted to DT Brand\'s Credit Desk!');
        };

        function requestWalletWithdrawal() {
            showWsToast('🏦 Payout withdrawal request for available balance submitted to registered Bank A/C!');
        };

        /* ── Reseller Cart Badge Synchronization ── */
        function updateWholesaleCartBadge() {
            try {
                var raw = localStorage.getItem('dtbrands_cart');
                var cart = raw ? JSON.parse(raw) : [];
                var totalCount = 0;
                if (Array.isArray(cart)) {
                    totalCount = cart.reduce(function(acc, item) { return acc + (Number(item.qty) || 1); }, 0);
                }
                var dockBadge = document.getElementById('wsDockCartBadge');
                var hdrBadge = document.getElementById('headerCartBadge');
                [dockBadge, hdrBadge].forEach(function(badge) {
                    if (badge) {
                        if (totalCount > 0) {
                            badge.textContent = totalCount;
                            badge.style.display = 'flex';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                });
            } catch(e) {}
        };

        /* ── Reseller Wishlist Badge Synchronization ── */
        function updateWholesaleWishlistBadge() {
            try {
                var raw = localStorage.getItem('dtbrands_wishlist');
                var wishlist = raw ? JSON.parse(raw) : [];
                var count = Array.isArray(wishlist) ? wishlist.length : 0;
                var badge = document.getElementById('headerWishlistBadge');
                if (badge) {
                    if (count > 0) {
                        badge.textContent = count;
                        badge.style.display = 'flex';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            } catch(e) {}
        };

        document.addEventListener('DOMContentLoaded', function() {
            initResellerApp();
            updateWholesaleCartBadge();
            updateWholesaleWishlistBadge();
        });
        window.addEventListener('storage', function(e) {
            if (e && e.key === 'dtbrands_user') {
                initResellerApp();
            }
            if (e && e.key === 'dtbrands_cart') {
                updateWholesaleCartBadge();
            }
            if (e && e.key === 'dtbrands_wishlist') {
                updateWholesaleWishlistBadge();
            }
        });

    /* ════════════════════════════════════════════════════════════
           RESELLER CRM, CUSTOMERS & OPERATIONS ENGINE
        ════════════════════════════════════════════════════════════ */

        // 1. Initial Real-World Reseller Customers Dataset
        var DEFAULT_RESELLER_CUSTOMERS = [
            {
                id: 1,
                name: "Ananya Deshmukh",
                mobile: "9820144521",
                whatsapp: "9820144521",
                email: "ananya.d@gmail.com",
                address: "402, Lotus Grandeur, Linking Road, Bandra West",
                city: "Mumbai",
                state: "Maharashtra",
                pincode: "400050",
                tags: ["VIP", "REPEAT", "HIGH VALUE"],
                totalOrders: 8,
                totalPurchase: 114500,
                totalProfit: 24800,
                firstOrder: "2026-02-14",
                lastOrder: "2026-08-12",
                reorderCycleDays: 25,
                notes: [
                    { id: 101, text: "Prefers Pure Silk & Paithani sarees in Navy and Maroon colors.", date: "2026-08-12 14:30", creator: "Rajesh Kumar" },
                    { id: 102, text: "Always pays via UPI immediately on order booking.", date: "2026-07-20 11:15", creator: "Rajesh Kumar" }
                ],
                followups: [
                    { id: 201, date: "2026-08-19", time: "11:30", note: "Send festive Paithani catalog collection on WhatsApp", status: "Pending" }
                ]
            },
            {
                id: 2,
                name: "Pooja Varma",
                mobile: "9876543210",
                whatsapp: "9876543210",
                email: "pooja.varma@outlook.com",
                address: "Flat 12B, Regency Heights, Civil Lines",
                city: "Jaipur",
                state: "Rajasthan",
                pincode: "302006",
                tags: ["VIP", "REPEAT"],
                totalOrders: 6,
                totalPurchase: 84900,
                totalProfit: 18200,
                firstOrder: "2026-03-10",
                lastOrder: "2026-08-05",
                reorderCycleDays: 30,
                notes: [
                    { id: 103, text: "Boutique owner in Jaipur. Buys bridal sets and heavy dupattas.", date: "2026-08-05 16:20", creator: "Rajesh Kumar" }
                ],
                followups: [
                    { id: 202, date: "2026-08-18", time: "16:00", note: "Follow-up for Rakhi & Teej bridal orders", status: "Pending" }
                ]
            },
            {
                id: 3,
                name: "Sneha Patel",
                mobile: "9426011223",
                whatsapp: "9426011223",
                email: "sneha.patel@gmail.com",
                address: "Plot 88, Sunrise Park, Bodakdev",
                city: "Ahmedabad",
                state: "Gujarat",
                pincode: "380054",
                tags: ["REPEAT", "REGULAR"],
                totalOrders: 4,
                totalPurchase: 48900,
                totalProfit: 10400,
                firstOrder: "2026-04-18",
                lastOrder: "2026-07-28",
                reorderCycleDays: 28,
                notes: [
                    { id: 104, text: "Loves soft georgette and organza sarees.", date: "2026-07-28 10:45", creator: "Rajesh Kumar" }
                ],
                followups: []
            },
            {
                id: 4,
                name: "Kavita Singhania",
                mobile: "9831098765",
                whatsapp: "9831098765",
                email: "kavita.singhania@yahoo.com",
                address: "Flat 5C, Queens Mansion, Park Street",
                city: "Kolkata",
                state: "West Bengal",
                pincode: "700016",
                tags: ["VIP", "HIGH VALUE"],
                totalOrders: 5,
                totalPurchase: 92400,
                totalProfit: 21500,
                firstOrder: "2026-01-22",
                lastOrder: "2026-08-14",
                reorderCycleDays: 20,
                notes: [
                    { id: 105, text: "High-ticket buyer for designer wedding lehengas.", date: "2026-08-14 18:00", creator: "Rajesh Kumar" }
                ],
                followups: [
                    { id: 203, date: "2026-08-20", time: "12:00", note: "Confirm dispatch tracking of Zardosi Lehenga", status: "Pending" }
                ]
            },
            {
                id: 5,
                name: "Ritu Aggarwal",
                mobile: "9811223344",
                whatsapp: "9811223344",
                email: "ritu.aggarwal@gmail.com",
                address: "House 24, Block C, Greater Kailash 1",
                city: "New Delhi",
                state: "Delhi",
                pincode: "110048",
                tags: ["NEW"],
                totalOrders: 1,
                totalPurchase: 14500,
                totalProfit: 3200,
                firstOrder: "2026-08-15",
                lastOrder: "2026-08-15",
                reorderCycleDays: 30,
                notes: [
                    { id: 106, text: "New customer inquiry from Instagram advertisement.", date: "2026-08-15 09:30", creator: "Rajesh Kumar" }
                ],
                followups: [
                    { id: 204, date: "2026-08-18", time: "14:00", note: "Call for feedback after delivery", status: "Pending" }
                ]
            },
            {
                id: 6,
                name: "Meera Nair",
                mobile: "9745012345",
                whatsapp: "9745012345",
                email: "meera.nair@gmail.com",
                address: "Kairali Villa, Panampilly Nagar",
                city: "Kochi",
                state: "Kerala",
                pincode: "682036",
                tags: ["REPEAT", "REGULAR"],
                totalOrders: 3,
                totalPurchase: 32400,
                totalProfit: 7100,
                firstOrder: "2026-05-04",
                lastOrder: "2026-08-01",
                reorderCycleDays: 35,
                notes: [],
                followups: []
            },
            {
                id: 7,
                name: "Priyanka Reddy",
                mobile: "9849019283",
                whatsapp: "9849019283",
                email: "priyanka.reddy@gmail.com",
                address: "Plot 104, Road No. 36, Jubilee Hills",
                city: "Hyderabad",
                state: "Telangana",
                pincode: "500033",
                tags: ["VIP", "REPEAT", "HIGH VALUE"],
                totalOrders: 7,
                totalPurchase: 108900,
                totalProfit: 23600,
                firstOrder: "2026-02-01",
                lastOrder: "2026-08-10",
                reorderCycleDays: 22,
                notes: [
                    { id: 107, text: "Frequent orders of Kanjivaram & Zari border sarees.", date: "2026-08-10 15:10", creator: "Rajesh Kumar" }
                ],
                followups: []
            },
            {
                id: 8,
                name: "Sunita Mehra",
                mobile: "9872019284",
                whatsapp: "9872019284",
                email: "sunita.mehra@gmail.com",
                address: "House 102, Sector 9D",
                city: "Chandigarh",
                state: "Punjab",
                pincode: "160009",
                tags: ["INACTIVE"],
                totalOrders: 2,
                totalPurchase: 18900,
                totalProfit: 4100,
                firstOrder: "2026-03-12",
                lastOrder: "2026-05-10",
                reorderCycleDays: 45,
                notes: [
                    { id: 108, text: "Has not ordered for 90+ days. Needs re-engagement offer.", date: "2026-07-01 11:00", creator: "Rajesh Kumar" }
                ],
                followups: [
                    { id: 205, date: "2026-08-21", time: "15:30", note: "Send 10% discount promo code for re-activation", status: "Pending" }
                ]
            }
        ];

        // 2. Load / Save Reseller Customers State
        function getResellerCustomers() {
            try {
                var raw = localStorage.getItem('reseller_customers_db');
                if (raw) return JSON.parse(raw);
            } catch(e) {}
            localStorage.setItem('reseller_customers_db', JSON.stringify(DEFAULT_RESELLER_CUSTOMERS));
            return DEFAULT_RESELLER_CUSTOMERS;
        };

        function saveResellerCustomers(customers) {
            localStorage.setItem('reseller_customers_db', JSON.stringify(customers));
            renderCrmCustomers();
            if (typeof renderDashboardCrmWidgets === 'function') renderDashboardCrmWidgets(); else if (typeof window.renderDashboardCrmWidgets === 'function') renderDashboardCrmWidgets();
            if (typeof updateCrmCounts === 'function') updateCrmCounts(); else if (typeof window.updateCrmCounts === 'function') updateCrmCounts();
        };

        var currentCustomerFilterTag = 'all';
        var currentCustomerSearchTerm = '';
        var selectedCustomerIds = new Set();
        var currentActiveProfileCustomer = null;

                // 3. Tab Switching Extension
        function switchWsTab(tabName) {
            try {
                if (!tabName) return;
                var cleanName = tabName.toLowerCase();
                
                // Hide all panes
                document.querySelectorAll('.ws-tab-pane').forEach(function(el) {
                    el.classList.remove('active');
                });
                // Unhighlight all sidebar nav items
                document.querySelectorAll('.ws-nav-item').forEach(function(el) {
                    el.classList.remove('active');
                });
                // Unhighlight all mobile dock items
                document.querySelectorAll('.ws-dock-btn').forEach(function(el) {
                    el.classList.remove('active');
                });

                var targetPaneId = 'tabPane' + cleanName.charAt(0).toUpperCase() + cleanName.slice(1);
                var targetPane = document.getElementById(targetPaneId);
                if (targetPane) {
                    targetPane.classList.add('active');
                } else {
                    console.warn('Pane not found for:', targetPaneId);
                }

                // Highlight active nav item
                document.querySelectorAll('.ws-nav-item').forEach(function(btn) {
                    var attr = btn.getAttribute('onclick') || '';
                    if (attr.toLowerCase().indexOf("'" + cleanName + "'") !== -1 || attr.toLowerCase().indexOf('"' + cleanName + '"') !== -1) {
                        btn.classList.add('active');
                    }
                });

                // Highlight mobile dock item
                var dockBtn = document.getElementById('dockBtn' + cleanName.charAt(0).toUpperCase() + cleanName.slice(1));
                if (dockBtn) dockBtn.classList.add('active');

                // Trigger tab-specific data rendering
                if (cleanName === 'customers') {
                    if (typeof renderCrmCustomers === 'function') renderCrmCustomers();
                    if (typeof updateCrmCounts === 'function') updateCrmCounts();
                } else if (cleanName === 'profit') {
                    if (typeof renderProfitLedger === 'function') renderProfitLedger();
                } else if (cleanName === 'followups') {
                    if (typeof renderFollowupsTable === 'function') renderFollowupsTable();
                } else if (cleanName === 'recommendations') {
                    if (typeof populateRecommendationSelect === 'function') populateRecommendationSelect();
                } else if (cleanName === 'orders') {
                    if (typeof renderOrdersView === 'function') renderOrdersView(activeOrdersList);
                } else if (cleanName === 'overview') {
                    if (typeof renderDashboardCrmWidgets === 'function') renderDashboardCrmWidgets();
                }

                window.scrollTo({ top: 0, behavior: 'smooth' });
                if (typeof toggleSidebar === 'function') toggleSidebar(false);
            } catch(e) {
                console.error('switchWsTab error:', e);
            }
        }
        window.switchWsTab = switchWsTab;
        

        // 4. Render Customers Table & Mobile Cards
        function renderCrmCustomers() {
            var customers = getResellerCustomers();
            var tbody = document.getElementById('crmCustomersTbody');
            var mobList = document.getElementById('crmCustomersMobileList');
            if (!tbody || !mobList) return;

            tbody.innerHTML = '';
            mobList.innerHTML = '';

            var filtered = customers.filter(function(c) {
                var matchTag = currentCustomerFilterTag === 'all' || (c.tags || []).some(function(t) { return t.toUpperCase() === currentCustomerFilterTag.toUpperCase(); });
                var matchSearch = !currentCustomerSearchTerm || 
                    c.name.toLowerCase().indexOf(currentCustomerSearchTerm.toLowerCase()) !== -1 ||
                    c.mobile.indexOf(currentCustomerSearchTerm) !== -1 ||
                    c.city.toLowerCase().indexOf(currentCustomerSearchTerm.toLowerCase()) !== -1;
                return matchTag && matchSearch;
            });

            if (filtered.length === 0) {
                tbody.innerHTML = '<tr><td colspan="9" style="text-align:center; padding:30px; color:var(--ws-text-muted);">No customers found matching the criteria.</td></tr>';
                mobList.innerHTML = '<div style="text-align:center; padding:30px; color:var(--ws-text-muted);">No customers found.</div>';
                return;
            }

            filtered.forEach(function(c) {
                var isChecked = selectedCustomerIds.has(c.id);
                var tagsHtml = (c.tags || []).map(function(t) {
                    var cls = 'crm-tag-regular';
                    if (t === 'VIP') cls = 'crm-tag-vip';
                    else if (t === 'REPEAT') cls = 'crm-tag-repeat';
                    else if (t === 'NEW') cls = 'crm-tag-new';
                    else if (t === 'HIGH VALUE') cls = 'crm-tag-highvalue';
                    else if (t === 'INACTIVE') cls = 'crm-tag-inactive';
                    else if (t === 'FOLLOW-UP') cls = 'crm-tag-followup';
                    return '<span class="crm-tag ' + cls + '">' + t + '</span>';
                }).join(' ');

                // Desktop Table Row
                var tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><input type="checkbox" ${isChecked ? 'checked' : ''} onchange="toggleCustomerSelect(${c.id}, this.checked)"></td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px; cursor:pointer;" onclick="openCustomerProfileModal(${c.id})">
                            <div style="width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg, #8A681F, #D4AF37); color:#FFF; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:0.80rem;">
                                ${c.name.charAt(0)}
                            </div>
                            <div>
                                <div style="font-weight:800; font-size:0.84rem; color:var(--ws-text-main);">${c.name}</div>
                                <div style="font-size:0.70rem; color:var(--ws-text-muted);">${c.mobile} &bull; ${c.email || 'No email'}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-size:0.78rem; font-weight:700;">${c.city}, ${c.state}</div>
                        <div style="font-size:0.68rem; color:var(--ws-text-muted);">${c.pincode}</div>
                    </td>
                    <td><div style="display:flex; gap:4px; flex-wrap:wrap;">${tagsHtml}</div></td>
                    <td style="text-align:right; font-weight:800;">${c.totalOrders}</td>
                    <td style="text-align:right; font-weight:800; color:var(--ws-text-main);">₹${Number(c.totalPurchase).toLocaleString('en-IN')}</td>
                    <td style="text-align:right; font-weight:900; color:#047857;">₹${Number(c.totalProfit).toLocaleString('en-IN')}</td>
                    <td style="text-align:center; font-size:0.76rem; font-weight:600; color:var(--ws-text-muted); white-space:nowrap; padding:12px 14px;">${c.lastOrder || 'N/A'}</td>
                    <td style="text-align:center; padding:12px 14px; white-space:nowrap;">
                        <div class="crm-action-btn-group">
                            <button class="crm-btn-view" onclick="openCustomerProfileModal(${c.id})" title="View Customer Profile" aria-label="View Customer Profile">
                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                            <button class="crm-btn-wa" onclick="sendCustomerWhatsAppMessage(${c.id})" title="Chat on WhatsApp" aria-label="WhatsApp Customer">
                                <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2z"/></svg>
                            </button>
                            <button class="crm-btn-reorder" onclick="openResellerQuickOrderDrawer(${c.id})" title="1-Tap Quick Reorder" aria-label="Quick Reorder">
                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#FFFFFF" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);

                // Mobile Card View
                var card = document.createElement('div');
                card.className = 'ws-mobile-order-card';
                card.style.borderLeft = '3px solid var(--ws-gold-primary)';
                card.innerHTML = `
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
                        <div style="display:flex; align-items:center; gap:8px;" onclick="openCustomerProfileModal(${c.id})">
                            <div style="width:36px; height:36px; border-radius:50%; background:var(--ws-gold-primary); color:#FFF; display:flex; align-items:center; justify-content:center; font-weight:800;">
                                ${c.name.charAt(0)}
                            </div>
                            <div>
                                <div style="font-weight:800; font-size:0.86rem;">${c.name}</div>
                                <div style="font-size:0.72rem; color:var(--ws-text-muted);">${c.mobile} &bull; ${c.city}</div>
                            </div>
                        </div>
                        <button class="ws-btn ws-btn-sm" onclick="sendCustomerWhatsAppMessage(${c.id})" style="background:#25D366; color:#FFF; padding:5px 10px; border-radius:6px; display:inline-flex; align-items:center; gap:5px;"><svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor" style="display:inline-block; vertical-align:middle;"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2z"/></svg><span>WhatsApp</span></button>
                    </div>
                    <div style="margin-bottom:8px;">${tagsHtml}</div>
                    <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; background:#FAF8F4; padding:8px; border-radius:8px; text-align:center; margin-bottom:10px;">
                        <div>
                            <div style="font-size:0.65rem; color:var(--ws-text-muted);">Orders</div>
                            <div style="font-weight:800; font-size:0.80rem;">${c.totalOrders}</div>
                        </div>
                        <div>
                            <div style="font-size:0.65rem; color:var(--ws-text-muted);">Total Spend</div>
                            <div style="font-weight:800; font-size:0.80rem;">₹${Number(c.totalPurchase).toLocaleString('en-IN')}</div>
                        </div>
                        <div>
                            <div style="font-size:0.65rem; color:var(--ws-text-muted);">Profit</div>
                            <div style="font-weight:900; font-size:0.80rem; color:#047857;">₹${Number(c.totalProfit).toLocaleString('en-IN')}</div>
                        </div>
                    </div>
                    <div style="display:flex; gap:6px;">
                        <button class="ws-btn ws-btn-secondary ws-btn-sm" style="flex:1;" onclick="openCustomerProfileModal(${c.id})">👤 View Profile</button>
                        <button class="ws-btn ws-btn-primary ws-btn-sm" style="flex:1;" onclick="openResellerQuickOrderDrawer(${c.id})">⚡ Quick Order</button>
                    </div>
                `;
                mobList.appendChild(card);
            });
        };

        // 5. Update CRM KPI summary numbers
        function updateCrmCounts() {
            var customers = getResellerCustomers();
            var total = customers.length;
            var vip = customers.filter(function(c) { return (c.tags || []).indexOf('VIP') !== -1; }).length;
            var repeat = customers.filter(function(c) { return Number(c.totalOrders) > 1; }).length;
            var rate = total > 0 ? ((repeat / total) * 100).toFixed(1) + '%' : '0%';

            var elTotal = document.getElementById('crmTotalCustomersCount');
            var elVip = document.getElementById('crmVipCustomersCount');
            var elRate = document.getElementById('crmRepeatRateVal');
            var elNav = document.getElementById('navCustomersCount');

            if (elTotal) elTotal.textContent = total;
            if (elVip) elVip.textContent = vip;
            if (elRate) elRate.textContent = rate;
            if (elNav) elNav.textContent = total;
        };

        // 6. Customer Search & Tag Filters
        function filterCustomersByTag(tag, btn) {
            currentCustomerFilterTag = tag;
            var pills = document.querySelectorAll('#customerTagFilterPills .ws-filter-pill');
            pills.forEach(function(p) { p.classList.remove('active'); });
            if (btn) btn.classList.add('active');
            renderCrmCustomers();
        };

        function handleCustomerSearch(val) {
            currentCustomerSearchTerm = (val || '').trim();
            var clearBtn = document.getElementById('customerSearchClear');
            if (clearBtn) clearBtn.style.display = currentCustomerSearchTerm ? 'block' : 'none';
            renderCrmCustomers();
        };

        function clearCustomerSearch() {
            var input = document.getElementById('customerSearchInput');
            if (input) input.value = '';
            handleCustomerSearch('');
        };

        // 7. Customer Profile Modal Controller
        function openCustomerProfileModal(custId) {
            var customers = getResellerCustomers();
            var c = customers.find(function(x) { return x.id === custId; });
            if (!c) return;

            currentActiveProfileCustomer = c;
            var hero = document.getElementById('crmProfileHero');
            var ribbon = document.getElementById('crmProfileActionRibbon');

            var tagsHtml = (c.tags || []).map(function(t) {
                return '<span class="crm-tag crm-tag-vip">' + t + '</span>';
            }).join(' ');

            var aov = c.totalOrders > 0 ? Math.round(c.totalPurchase / c.totalOrders) : 0;

            if (hero) {
                hero.innerHTML = `
                    <div style="display:flex; align-items:center; gap:14px;">
                        <div class="crm-avatar-lg">${c.name.charAt(0)}</div>
                        <div>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <h2 style="margin:0; font-size:1.15rem; font-weight:900; color:var(--ws-text-main);">${c.name}</h2>
                                ${tagsHtml}
                            </div>
                            <div style="font-size:0.75rem; color:var(--ws-text-muted); margin-top:3px;">
                                📞 ${c.mobile} &bull; 📍 ${c.city}, ${c.state} &bull; ✉️ ${c.email || 'N/A'}
                            </div>
                        </div>
                    </div>
                    <div style="display:flex; gap:16px; background:#FFFFFF; padding:10px 16px; border-radius:10px; border:1px solid var(--ws-border);">
                        <div style="text-align:center;">
                            <div style="font-size:0.65rem; color:var(--ws-text-muted); font-weight:700;">TOTAL SPEND</div>
                            <div style="font-size:1.05rem; font-weight:900; color:var(--ws-gold-primary);">₹${Number(c.totalPurchase).toLocaleString('en-IN')}</div>
                        </div>
                        <div style="text-align:center; border-left:1px solid var(--ws-border); padding-left:14px;">
                            <div style="font-size:0.65rem; color:var(--ws-text-muted); font-weight:700;">PROFIT EARNED</div>
                            <div style="font-size:1.05rem; font-weight:900; color:#047857;">₹${Number(c.totalProfit).toLocaleString('en-IN')}</div>
                        </div>
                        <div style="text-align:center; border-left:1px solid var(--ws-border); padding-left:14px;">
                            <div style="font-size:0.65rem; color:var(--ws-text-muted); font-weight:700;">AOV</div>
                            <div style="font-size:1.05rem; font-weight:800; color:var(--ws-text-main);">₹${aov.toLocaleString('en-IN')}</div>
                        </div>
                    </div>
                `;
            }

            if (ribbon) {
                ribbon.innerHTML = `
                    <button class="crm-btn-action wa" onclick="sendCustomerWhatsAppMessage(${c.id})">
                        💬 WhatsApp Customer
                    </button>
                    <a href="tel:${c.mobile}" class="crm-btn-action">
                        📞 Call
                    </a>
                    <button class="crm-btn-action primary" onclick="closeCustomerProfileModal(); openResellerQuickOrderDrawer(${c.id});">
                        ⚡ New Order
                    </button>
                    <button class="crm-btn-action" onclick="openRepeatOrderModal(${c.id})">
                        🔁 Repeat Order
                    </button>
                    <button class="crm-btn-action" onclick="openAddNoteModal(${c.id})">
                        📝 Add Note
                    </button>
                    <button class="crm-btn-action" onclick="openScheduleFollowupModal(${c.id})">
                        ⏰ Add Follow-up
                    </button>
                    <button class="crm-btn-action" onclick="openAddCustomerModal(${c.id})">
                        ✏️ Edit Customer
                    </button>
                `;
            }

            // Update badge counts
            var notesBadge = document.getElementById('profNotesBadge');
            var followBadge = document.getElementById('profFollowupsBadge');
            if (notesBadge) notesBadge.textContent = (c.notes || []).length;
            if (followBadge) followBadge.textContent = (c.followups || []).length;

            // Load sub tabs
            renderProfileOrdersTab(c);
            renderProfileProductsTab(c);
            renderProfileRecommendedTab(c);
            renderProfileLedgerTab(c);
            renderProfileNotesTab(c);
            renderProfileFollowupsTab(c);
            renderProfileTimelineTab(c);

            var modal = document.getElementById('resellerCustomerProfileModal');
            if (modal) modal.classList.add('active');
        };

        function closeCustomerProfileModal() {
            var modal = document.getElementById('resellerCustomerProfileModal');
            if (modal) modal.classList.remove('active');
        };

        function switchProfileTab(tabKey, btn) {
            document.querySelectorAll('.crm-prof-tab-content').forEach(function(el) {
                el.style.display = 'none';
            });
            document.querySelectorAll('.crm-profile-tab').forEach(function(b) {
                b.classList.remove('active');
            });
            var target = document.getElementById('profTab-' + tabKey);
            if (target) target.style.display = 'block';
            if (btn) btn.classList.add('active');
        };

        // 8. Profile Tab Renderers
        function renderProfileOrdersTab(c) {
            var container = document.getElementById('profOrdersList');
            if (!container) return;
            var orders = (window.allOrders || []).slice(0, c.totalOrders || 2);
            container.innerHTML = orders.map(function(o) {
                return `
                    <div style="background:#FAF8F4; border:1px solid var(--ws-border); border-radius:8px; padding:12px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
                        <div>
                            <div style="font-weight:800; font-size:0.84rem; color:var(--ws-text-main);">${o.orderId} &bull; ${o.productName}</div>
                            <div style="font-size:0.72rem; color:var(--ws-text-muted); margin-top:2px;">Ordered: ${o.date} &bull; Qty: ${o.quantity} &bull; Status: <strong style="color:#047857;">${o.status}</strong></div>
                        </div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="font-weight:900; font-size:0.95rem; color:var(--ws-gold-primary);">₹${Number(o.total).toLocaleString('en-IN')}</span>
                            <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick="openRepeatOrderModal(${c.id}, '${o.orderId}')">🔁 Reorder</button>
                        </div>
                    </div>
                `;
            }).join('');
        };

        /* This tab is labelled "Purchased Products", but nothing here knows what
           any customer bought: it used to take the first four products in the
           catalogue and print "Purchased 2 Times" under each one, for every
           customer. Per-customer reseller purchase history is not stored
           anywhere yet, so the tab says so instead of inventing four sarees. */
        function renderProfileProductsTab(c) {
            var container = document.getElementById('profProductsList');
            if (!container) return;
            container.innerHTML =
                '<div style="grid-column:1 / -1; padding:22px; text-align:center; border:1px dashed var(--ws-border);' +
                ' border-radius:8px; background:#FAF8F4; color:var(--ws-text-muted); font-size:0.8rem;">' +
                'Purchase history for this customer is not recorded in the database yet, so there is nothing to list here.' +
                '</div>';
        };

        function renderProfileRecommendedTab(c) {
            var container = document.getElementById('profRecommendedList');
            if (!container) return;
            var prods = (window.allProducts || []).slice(0, 4);
            if (!prods.length) {
                container.innerHTML =
                    '<div style="grid-column:1 / -1; padding:22px; text-align:center; border:1px dashed var(--ws-border);' +
                    ' border-radius:8px; background:#FAF8F4; color:var(--ws-text-muted); font-size:0.8rem;">' +
                    'No products are in the catalogue yet.</div>';
                return;
            }
            container.innerHTML = prods.map(function(p) {
                /* The price fell back to 2199 whenever a product had no trade
                   price set, so an unpriced saree was quoted at a figure the
                   firm never entered. */
                var rCost = Number(p.wholesale_price) || Number(p.price) || 0;
                var rImg = p.image || '/assets/images/no-image.svg';
                return `
                    <div class="ws-product-card" style="padding:10px;">
                        <img src="${rImg}" alt="${p.name || ''}" style="width:100%; height:130px; object-fit:cover; border-radius:6px; margin-bottom:6px;">
                        <div style="font-weight:800; font-size:0.76rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${p.name || ''}</div>
                        <div style="font-size:0.78rem; font-weight:900; color:var(--ws-gold-primary); margin-top:2px;">${rCost > 0 ? '₹' + rCost.toLocaleString('en-IN') : 'Price on request'}</div>
                        <button class="ws-btn ws-btn-primary ws-btn-sm" style="width:100%; margin-top:6px; font-size:0.68rem; padding:4px;" onclick="closeCustomerProfileModal(); openResellerQuickOrderDrawer(${c.id});">⚡ Create Order</button>
                    </div>
                `;
            }).join('');
        };

        function renderProfileLedgerTab(c) {
            var container = document.getElementById('profLedgerContent');
            if (!container) return;
            container.innerHTML = `
                <table class="ws-orders-table">
                    <thead>
                        <tr>
                            <th>Transaction / Order</th>
                            <th>Total Purchase</th>
                            <th>Reseller Cost</th>
                            <th style="color:#047857;">Net Profit</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#ORD-77492 (Paithani Saree)</td>
                            <td>₹18,200</td>
                            <td>₹14,000</td>
                            <td style="font-weight:900; color:#047857;">+₹4,200</td>
                            <td>2026-08-12</td>
                        </tr>
                        <tr>
                            <td>#ORD-77450 (Silk Kurti Lot)</td>
                            <td>₹12,400</td>
                            <td>₹9,600</td>
                            <td style="font-weight:900; color:#047857;">+₹2,800</td>
                            <td>2026-07-20</td>
                        </tr>
                    </tbody>
                </table>
            `;
        };

        function renderProfileNotesTab(c) {
            var container = document.getElementById('profNotesList');
            if (!container) return;
            var notes = c.notes || [];
            if (notes.length === 0) {
                container.innerHTML = '<div style="text-align:center; color:var(--ws-text-muted); padding:20px;">No notes yet. Click "+ Add Note" to create one.</div>';
                return;
            }
            container.innerHTML = notes.map(function(n) {
                return `
                    <div style="background:#FAF8F4; border:1px solid var(--ws-border); border-radius:8px; padding:10px 14px;">
                        <div style="font-size:0.80rem; color:var(--ws-text-main); font-weight:600; line-height:1.4;">${n.text}</div>
                        <div style="font-size:0.68rem; color:var(--ws-text-muted); margin-top:4px;">📅 ${n.date} &bull; By: <strong>${n.creator}</strong></div>
                    </div>
                `;
            }).join('');
        };

        function renderProfileFollowupsTab(c) {
            var container = document.getElementById('profFollowupsList');
            if (!container) return;
            var fList = c.followups || [];
            if (fList.length === 0) {
                container.innerHTML = '<div style="text-align:center; color:var(--ws-text-muted); padding:20px;">No scheduled follow-ups. Click "+ Add Follow-up" to schedule one.</div>';
                return;
            }
            container.innerHTML = fList.map(function(f) {
                return `
                    <div style="background:#FAF8F4; border:1px solid var(--ws-border); border-radius:8px; padding:10px 14px; display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <div style="font-size:0.82rem; font-weight:800; color:var(--ws-text-main);">${f.note}</div>
                            <div style="font-size:0.70rem; color:var(--ws-text-muted); margin-top:2px;">📅 ${f.date} at ${f.time} &bull; Status: <span class="crm-tag crm-tag-followup">${f.status}</span></div>
                        </div>
                        <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick="markFollowupCompleted(${c.id}, ${f.id})">✅ Mark Done</button>
                    </div>
                `;
            }).join('');
        };

        function renderProfileTimelineTab(c) {
            var container = document.getElementById('profTimelineList');
            if (!container) return;
            container.innerHTML = `
                <div class="crm-timeline-item">
                    <div class="crm-timeline-dot">✓</div>
                    <div class="crm-timeline-content">
                        <div class="crm-timeline-title">📦 Order #ORD-77492 Delivered Successfully</div>
                        <div class="crm-timeline-time">August 14, 2026 &bull; BlueDart AWB: 884729104</div>
                    </div>
                </div>
                <div class="crm-timeline-item">
                    <div class="crm-timeline-dot">💬</div>
                    <div class="crm-timeline-content">
                        <div class="crm-timeline-title">WhatsApp Catalog Sent</div>
                        <div class="crm-timeline-time">August 12, 2026 &bull; Shared Diwali silk saree collection</div>
                    </div>
                </div>
                <div class="crm-timeline-item">
                    <div class="crm-timeline-dot">📝</div>
                    <div class="crm-timeline-content">
                        <div class="crm-timeline-title">Note Added by Rajesh Kumar</div>
                        <div class="crm-timeline-time">July 28, 2026 &bull; Customer preferred soft georgette fabrics</div>
                    </div>
                </div>
                <div class="crm-timeline-item">
                    <div class="crm-timeline-dot">👤</div>
                    <div class="crm-timeline-content">
                        <div class="crm-timeline-title">Customer Created</div>
                        <div class="crm-timeline-time">${c.firstOrder || 'February 14, 2026'} &bull; First booking</div>
                    </div>
                </div>
            `;
        };

        // 9. Add / Edit Customer Modal & Smart UI Helpers
        function openAddCustomerModal(editId) {
            var modal = document.getElementById('resellerAddCustomerModal');
            var title = document.getElementById('addCustomerModalTitle');
            var formId = document.getElementById('custFormId');
            var formName = document.getElementById('custFormName');
            var formMobile = document.getElementById('custFormMobile');
            var formWhatsapp = document.getElementById('custFormWhatsapp');
            var formEmail = document.getElementById('custFormEmail');
            var formAddress = document.getElementById('custFormAddress');
            var formCity = document.getElementById('custFormCity');
            var formState = document.getElementById('custFormState');
            var formPincode = document.getElementById('custFormPincode');
            var formTags = document.getElementById('custFormTags');
            var formNotes = document.getElementById('custFormNotes');

            if (editId) {
                var customers = getResellerCustomers();
                var c = customers.find(function(x) { return x.id === editId; });
                if (c) {
                    if (title) title.innerHTML = '<span>✏️ Edit Customer Profile</span>';
                    if (formId) formId.value = c.id;
                    if (formName) formName.value = c.name;
                    if (formMobile) formMobile.value = c.mobile;
                    if (formWhatsapp) formWhatsapp.value = c.whatsapp || c.mobile;
                    if (formEmail) formEmail.value = c.email || '';
                    if (formAddress) formAddress.value = c.address || '';
                    if (formCity) formCity.value = c.city || '';
                    if (formState) formState.value = c.state || '';
                    if (formPincode) formPincode.value = c.pincode || '';
                    if (formTags) formTags.value = (c.tags || []).join(', ');
                }
            } else {
                if (title) title.innerHTML = '<span>👤 Add New Customer</span>';
                if (formId) formId.value = '';
                if (formName) formName.value = '';
                if (formMobile) formMobile.value = '';
                if (formWhatsapp) formWhatsapp.value = '';
                if (formEmail) formEmail.value = '';
                if (formAddress) formAddress.value = '';
                if (formCity) formCity.value = '';
                if (formState) formState.value = '';
                if (formPincode) formPincode.value = '';
                if (formTags) formTags.value = 'NEW';
                if (formNotes) formNotes.value = '';
            }

            // Sync clear button states for all inputs
            ['custFormName', 'custFormMobile', 'custFormWhatsapp', 'custFormEmail', 'custFormAddress', 'custFormCity', 'custFormState', 'custFormPincode', 'custFormTags'].forEach(function(id) {
                var el = document.getElementById(id);
                if (el) handleSmartInputChange(el);
            });

            syncCustTagChips();

            if (modal) modal.classList.add('active');
        };

        function handleSmartInputChange(inputEl) {
            if (!inputEl) return;
            var wrap = inputEl.closest ? inputEl.closest('.ws-smart-input-wrap') : null;
            if (!wrap) return;
            var clearBtn = wrap.querySelector('.ws-input-clear-btn');
            if (inputEl.value && inputEl.value.trim().length > 0) {
                wrap.classList.add('has-value');
                if (clearBtn) clearBtn.classList.add('visible');
            } else {
                wrap.classList.remove('has-value');
                if (clearBtn) clearBtn.classList.remove('visible');
            }
        };

        function clearSmartInput(inputId) {
            var input = document.getElementById(inputId);
            if (input) {
                input.value = '';
                handleSmartInputChange(input);
                input.focus();
            }
        };

        function setCustWhatsappSame() {
            var mobile = document.getElementById('custFormMobile');
            var whatsapp = document.getElementById('custFormWhatsapp');
            var btn = document.getElementById('btnCustSyncWhatsapp');
            if (mobile && whatsapp) {
                if (!mobile.value.trim()) {
                    showWsToast('⚠️ Please enter Mobile Number first');
                    mobile.focus();
                    return;
                }
                whatsapp.value = mobile.value.trim();
                handleSmartInputChange(whatsapp);
                if (btn) {
                    var origHtml = btn.innerHTML;
                    btn.innerHTML = '<span>✓ Synced!</span>';
                    btn.style.background = '#10B981';
                    btn.style.color = '#FFFFFF';
                    btn.style.borderColor = '#10B981';
                    setTimeout(function() {
                        btn.innerHTML = origHtml;
                        btn.style.background = '';
                        btn.style.color = '';
                        btn.style.borderColor = '';
                    }, 1800);
                }
                showWsToast('⚡ WhatsApp number synced with Mobile!');
            }
        };

        function toggleCustTagChip(chipEl, tagName) {
            var input = document.getElementById('custFormTags');
            if (!input) return;
            var currentTags = input.value.split(',').map(function(t) { return t.trim().toUpperCase(); }).filter(Boolean);
            var tagUpper = tagName.toUpperCase();
            var idx = currentTags.indexOf(tagUpper);
            if (idx > -1) {
                currentTags.splice(idx, 1);
            } else {
                currentTags.push(tagUpper);
            }
            input.value = currentTags.join(', ');
            syncCustTagChips();
        };

        function syncCustTagChips() {
            var input = document.getElementById('custFormTags');
            if (!input) return;
            var currentTags = input.value.split(',').map(function(t) { return t.trim().toUpperCase(); }).filter(Boolean);
            var chips = document.querySelectorAll('#custSmartTagChips .ws-smart-chip');
            chips.forEach(function(chip) {
                var text = chip.textContent.replace(/[^a-zA-Z0-9 ]/g, '').trim().toUpperCase();
                if (currentTags.indexOf(text) > -1) {
                    chip.classList.add('active');
                } else {
                    chip.classList.remove('active');
                }
            });
        };

        function insertCustNotePrompt(promptText) {
            var notes = document.getElementById('custFormNotes');
            if (!notes) return;
            if (notes.value.trim()) {
                if (notes.value.indexOf(promptText) === -1) {
                    notes.value = notes.value.trim() + ' • ' + promptText;
                }
            } else {
                notes.value = promptText;
            }
            notes.focus();
        };

        function handleSmartPinAutoFill(pinVal) {
            var cleanPin = (pinVal || '').trim();
            if (cleanPin.length === 6) {
                var cityInput = document.getElementById('custFormCity');
                var stateInput = document.getElementById('custFormState');
                if (cleanPin.startsWith('395') || cleanPin.startsWith('394')) {
                    if (cityInput && !cityInput.value) cityInput.value = 'Surat';
                    if (stateInput && !stateInput.value) stateInput.value = 'Gujarat';
                } else if (cleanPin.startsWith('380') || cleanPin.startsWith('382')) {
                    if (cityInput && !cityInput.value) cityInput.value = 'Ahmedabad';
                    if (stateInput && !stateInput.value) stateInput.value = 'Gujarat';
                } else if (cleanPin.startsWith('400')) {
                    if (cityInput && !cityInput.value) cityInput.value = 'Mumbai';
                    if (stateInput && !stateInput.value) stateInput.value = 'Maharashtra';
                }
            }
        };

        function closeAddCustomerModal() {
            var modal = document.getElementById('resellerAddCustomerModal');
            if (modal) modal.classList.remove('active');
        };

        function handleSaveCustomerSubmit() {
            var formId = document.getElementById('custFormId').value;
            var name = document.getElementById('custFormName').value.trim();
            var mobile = document.getElementById('custFormMobile').value.trim();
            var whatsapp = document.getElementById('custFormWhatsapp').value.trim() || mobile;
            var email = document.getElementById('custFormEmail').value.trim();
            var address = document.getElementById('custFormAddress').value.trim();
            var city = document.getElementById('custFormCity').value.trim();
            var state = document.getElementById('custFormState').value.trim();
            var pincode = document.getElementById('custFormPincode').value.trim();
            var tagsRaw = document.getElementById('custFormTags').value.trim();
            var tags = tagsRaw ? tagsRaw.split(',').map(function(t) { return t.trim().toUpperCase(); }) : ['NEW'];
            var notesText = (document.getElementById('custFormNotes') ? document.getElementById('custFormNotes').value.trim() : '');

            var customers = getResellerCustomers();

            if (formId) {
                var c = customers.find(function(x) { return Number(x.id) === Number(formId); });
                if (c) {
                    c.name = name;
                    c.mobile = mobile;
                    c.whatsapp = whatsapp;
                    c.email = email;
                    c.address = address;
                    c.city = city;
                    c.state = state;
                    c.pincode = pincode;
                    c.tags = tags;
                }
            } else {
                var newCust = {
                    id: Date.now(),
                    name: name,
                    mobile: mobile,
                    whatsapp: whatsapp,
                    email: email,
                    address: address,
                    city: city,
                    state: state,
                    pincode: pincode,
                    tags: tags,
                    totalOrders: 0,
                    totalPurchase: 0,
                    totalProfit: 0,
                    firstOrder: new Date().toISOString().split('T')[0],
                    lastOrder: 'N/A',
                    notes: notesText ? [{ id: Date.now(), text: notesText, date: new Date().toLocaleString(), creator: 'Rajesh Kumar' }] : [],
                    followups: []
                };
                customers.unshift(newCust);
            }

            saveResellerCustomers(customers);
            closeAddCustomerModal();

            // Refresh Quick Order customer dropdown & check if quick order is active
            var qoModal = document.getElementById('resellerQuickOrderDrawer');
            var targetId = formId ? Number(formId) : newCust.id;
            
            var custSelect = document.getElementById('qoCustomerSelect');
            if (custSelect) {
                custSelect.innerHTML = '<option value="">-- Choose Customer --</option>' + customers.map(function(c) {
                    return '<option value="' + c.id + '" ' + (Number(c.id) === Number(targetId) ? 'selected' : '') + '>' + c.name + ' (' + c.mobile + ' - ' + c.city + ')</option>';
                }).join('');
            }

            if (qoModal && qoModal.classList.contains('active')) {
                selectQoCustomer(targetId);
                showWsToast('🎉 Customer "' + name + '" saved & selected for Quick Order!');
            } else {
                showWsToast('✅ Customer saved successfully!');
            }
        };

        // 10. Quick Order Flow
        /* The reseller's landed cost for one piece, straight from the products
           table. 0 means no trade price is set for that product yet. */
        function qoProductCost(p) {
            if (!p) return 0;
            return Number(p.wholesale_price) || Number(p.price) || 0;
        }

        function openResellerQuickOrderDrawer(prefillCustId, prefillProdId) {
            var modal = document.getElementById('resellerQuickOrderDrawer');
            var custSelect = document.getElementById('qoCustomerSelect');
            var prodSelect = document.getElementById('qoProductSelect');

            var customers = getResellerCustomers();
            if (custSelect) {
                custSelect.innerHTML = '<option value="">-- Choose Customer --</option>' + customers.map(function(c) {
                    return '<option value="' + c.id + '" ' + (Number(c.id) === Number(prefillCustId) ? 'selected' : '') + '>' + c.name + ' (' + c.mobile + ' - ' + c.city + ')</option>';
                }).join('');
            }

            var prods = window.allProducts || [];
            if (prodSelect) {
                // Every option used to carry data-cost="2199" data-mrp="3299" for any
                // product whose prices were not set, so the order form opened with an
                // invented cost and MRP and the profit line was fiction. Missing
                // prices now come through as 0 and the form leaves those fields blank.
                prodSelect.innerHTML = '<option value="">-- Choose Product --</option>' + prods.map(function(p) {
                    var oCost = qoProductCost(p);
                    var oMrp = Number(p.retail_price) || 0;
                    return '<option value="' + p.id + '" data-cost="' + oCost + '" data-mrp="' + oMrp + '" ' +
                        (Number(p.id) === Number(prefillProdId) ? 'selected' : '') + '>' +
                        p.name + (oCost > 0 ? ' (Cost: ₹' + oCost.toLocaleString('en-IN') + ')' : ' (Cost: on request)') +
                        '</option>';
                }).join('');
            }

            // Customer selection state
            if (prefillCustId) {
                selectQoCustomer(prefillCustId);
            } else {
                resetQoCustomerSelection();
            }

            // Product selection state
            if (prefillProdId) {
                selectQoProduct(prefillProdId);
            } else {
                resetQoProductSelection();
            }

            if (modal) modal.classList.add('active');
        };

        function closeResellerQuickOrderDrawer() {
            var modal = document.getElementById('resellerQuickOrderDrawer');
            if (modal) modal.classList.remove('active');
            var results = document.getElementById('qoCustomerSearchResults');
            if (results) results.style.display = 'none';
            var prodResults = document.getElementById('qoProductSearchResults');
            if (prodResults) prodResults.style.display = 'none';
        };

        function handleQoCustomerSearchInput(query) {
            var input = document.getElementById('qoCustomerSearchInput');
            var clearBtn = document.getElementById('qoCustomerSearchClearBtn');
            var resultsBox = document.getElementById('qoCustomerSearchResults');
            if (!resultsBox) return;

            var q = (query || '').trim().toLowerCase();
            if (clearBtn) clearBtn.style.display = q.length > 0 ? 'flex' : 'none';

            var customers = getResellerCustomers();
            var matches = customers.filter(function(c) {
                var name = (c.name || '').toLowerCase();
                var phone = (c.mobile || c.whatsapp || '').toLowerCase();
                var city = (c.city || '').toLowerCase();
                return name.indexOf(q) !== -1 || phone.indexOf(q) !== -1 || city.indexOf(q) !== -1;
            });

            if (matches.length === 0) {
                resultsBox.innerHTML = `
                    <div style="padding:12px; text-align:center; color:var(--ws-text-muted); font-size:0.78rem;">
                        No customer found for "<strong>${q}</strong>"<br>
                        <button type="button" class="ws-btn ws-btn-primary ws-btn-xs" style="margin-top:6px; font-size:0.72rem; padding:4px 10px;" onclick="openAddCustomerModal()">+ Add New Customer</button>
                    </div>
                `;
            } else {
                resultsBox.innerHTML = matches.map(function(c) {
                    var initials = (c.name || 'C').split(' ').map(function(w){return w[0];}).slice(0,2).join('').toUpperCase();
                    var tagHtml = (c.tags && c.tags.length > 0) ? '<span class="ws-qo-item-tag">' + c.tags[0] + '</span>' : '';
                    return `
                        <div class="ws-qo-autocomplete-item" onclick="selectQoCustomer(${c.id})">
                            <div class="ws-qo-item-left">
                                <div class="ws-qo-item-avatar">${initials}</div>
                                <div>
                                    <div class="ws-qo-item-name">${c.name}</div>
                                    <div class="ws-qo-item-sub">📞 ${c.mobile || c.whatsapp || 'N/A'} &bull; 📍 ${c.city || 'Surat'}</div>
                                </div>
                            </div>
                            <div>${tagHtml}</div>
                        </div>
                    `;
                }).join('');
            }
            resultsBox.style.display = 'block';
        }

        function handleQoCustomerSearchFocus() {
            var input = document.getElementById('qoCustomerSearchInput');
            handleQoCustomerSearchInput(input ? input.value : '');
        }

        function clearQoCustomerSearch() {
            var input = document.getElementById('qoCustomerSearchInput');
            var clearBtn = document.getElementById('qoCustomerSearchClearBtn');
            var resultsBox = document.getElementById('qoCustomerSearchResults');
            if (input) {
                input.value = '';
                input.focus();
            }
            if (clearBtn) clearBtn.style.display = 'none';
            if (resultsBox) resultsBox.style.display = 'none';
        }

        function selectQoCustomer(custId) {
            var customers = getResellerCustomers();
            var c = customers.find(function(x) { return Number(x.id) === Number(custId); });
            if (!c) return;

            var select = document.getElementById('qoCustomerSelect');
            if (select) select.value = c.id;

            handleQoCustomerChange(c.id);

            // Populate selected card preview
            var searchRow = document.getElementById('qoCustSearchRow');
            var card = document.getElementById('qoSelectedCustCard');
            var avatar = document.getElementById('qoSelectedCustAvatar');
            var name = document.getElementById('qoSelectedCustName');
            var phone = document.getElementById('qoSelectedCustPhone');
            var city = document.getElementById('qoSelectedCustCity');
            var resultsBox = document.getElementById('qoCustomerSearchResults');

            if (resultsBox) resultsBox.style.display = 'none';

            if (avatar) avatar.textContent = (c.name || 'C').split(' ').map(function(w){return w[0];}).slice(0,2).join('').toUpperCase();
            if (name) name.textContent = c.name;
            if (phone) phone.textContent = (c.mobile || c.whatsapp || '');
            if (city) city.textContent = '📍 ' + (c.city || 'Surat') + ', ' + (c.state || 'Gujarat');

            if (searchRow) searchRow.style.display = 'none';
            if (card) card.style.display = 'flex';
        }

        function resetQoCustomerSelection() {
            var select = document.getElementById('qoCustomerSelect');
            if (select) select.value = '';

            var searchRow = document.getElementById('qoCustSearchRow');
            var card = document.getElementById('qoSelectedCustCard');
            var input = document.getElementById('qoCustomerSearchInput');

            if (card) card.style.display = 'none';
            if (searchRow) searchRow.style.display = 'flex';
            if (input) {
                input.value = '';
            }
            clearQoCustomerSearch();
        }

        function handleQoCustomerChange(custId) {
            var customers = getResellerCustomers();
            var c = customers.find(function(x) { return Number(x.id) === Number(custId); });
            var addr = document.getElementById('qoShippingAddress');
            if (c && addr) {
                addr.value = c.address + ', ' + c.city + ', ' + c.state + ' - ' + c.pincode;
            }
        };

        // Product SKU & Name Search Handler Suite
        function handleQoProductSearchInput(query) {
            var input = document.getElementById('qoProductSearchInput');
            var clearBtn = document.getElementById('qoProductSearchClearBtn');
            var resultsBox = document.getElementById('qoProductSearchResults');
            if (!resultsBox) return;

            var q = (query || '').trim().toLowerCase();
            if (clearBtn) clearBtn.style.display = q.length > 0 ? 'flex' : 'none';

            var prods = window.allProducts || [];
            var matches = prods.filter(function(p) {
                var name = (p.name || '').toLowerCase();
                /* Searching used to match against an invented "JHT-<id>" code
                   for any product with no SKU, so typing JHT-7 found a product
                   whose real stock code is something else entirely. */
                var sku = (p.sku || '').toLowerCase();
                var cat = (p.category || '').toLowerCase();
                var fabric = (p.fabric || '').toLowerCase();
                return name.indexOf(q) !== -1 || sku.indexOf(q) !== -1 || cat.indexOf(q) !== -1 || fabric.indexOf(q) !== -1;
            });

            if (matches.length === 0) {
                resultsBox.innerHTML = `
                    <div style="padding:12px; text-align:center; color:var(--ws-text-muted); font-size:0.78rem;">
                        No product found matching "<strong>${q}</strong>"
                    </div>
                `;
            } else {
                resultsBox.innerHTML = matches.map(function(p) {
                    // Was: cost fell back to Rs 2,199, the MRP was invented as
                    // cost x 1.5, the thumbnail fell back to product1.png (another
                    // product's saree), the SKU to "JHT-<id>" and the category to
                    // "Silk Saree". Nothing here is guessed any more.
                    var cost = qoProductCost(p);
                    var mrp = Number(p.retail_price) || 0;
                    var img = p.image || '/assets/images/no-image.svg';
                    var sku = p.sku || '';
                    var cat = p.category || '';
                    return `
                        <div class="ws-qo-prod-item" onclick="selectQoProduct(${p.id})">
                            <div class="ws-qo-prod-item-left">
                                <img src="${img}" alt="${p.name || ''}" class="ws-qo-prod-item-thumb">
                                <div>
                                    <div class="ws-qo-prod-item-title">${p.name || 'Product'}</div>
                                    <div class="ws-qo-prod-item-sub">${sku ? `<span class="ws-qo-prod-item-sku">SKU: ${sku}</span>` : ''}${cat ? ` 🏷️ ${cat}` : ''}</div>
                                </div>
                            </div>
                            <div class="ws-qo-prod-item-price">
                                <div>${cost > 0 ? '₹' + cost.toLocaleString('en-IN') : 'On request'}</div>
                                ${mrp > cost && cost > 0 ? `<div style="font-size:0.62rem; color:var(--ws-text-muted); font-weight:600; text-decoration:line-through;">₹${mrp.toLocaleString('en-IN')}</div>` : ''}
                            </div>
                        </div>
                    `;
                }).join('');
            }
            resultsBox.style.display = 'block';
        }

        function handleQoProductSearchFocus() {
            var input = document.getElementById('qoProductSearchInput');
            handleQoProductSearchInput(input ? input.value : '');
        }

        function clearQoProductSearch() {
            var input = document.getElementById('qoProductSearchInput');
            var clearBtn = document.getElementById('qoProductSearchClearBtn');
            var resultsBox = document.getElementById('qoProductSearchResults');
            if (input) {
                input.value = '';
                input.focus();
            }
            if (clearBtn) clearBtn.style.display = 'none';
            if (resultsBox) resultsBox.style.display = 'none';
        }

        function selectQoProduct(prodId) {
            var prods = window.allProducts || [];
            var p = prods.find(function(x) { return Number(x.id) === Number(prodId); });
            if (!p) return;

            var select = document.getElementById('qoProductSelect');
            if (select) select.value = p.id;

            handleQoProductChange(p.id);

            // Populate selected product preview card
            var searchRow = document.getElementById('qoProdSearchRow');
            var card = document.getElementById('qoSelectedProductCard');
            var img = document.getElementById('qoSelectedProdImg');
            var name = document.getElementById('qoSelectedProdName');
            var sku = document.getElementById('qoSelectedProdSku');
            var costEl = document.getElementById('qoSelectedProdCost');
            var mrpEl = document.getElementById('qoSelectedProdMrp');
            var resultsBox = document.getElementById('qoProductSearchResults');

            if (resultsBox) resultsBox.style.display = 'none';

            var cost = qoProductCost(p);
            var mrp = Number(p.retail_price) || 0;
            var skuText = p.sku || '';

            // Same invented values as the search list (Rs 2,199 cost, cost x 1.5
            // MRP, product1.png, "JHT-<id>") used to land in the selected-product
            // card, which is the summary the reseller reads before submitting.
            if (img) img.src = p.image || '/assets/images/no-image.svg';
            if (name) name.textContent = p.name || 'Product';
            if (sku) sku.textContent = skuText ? 'SKU: ' + skuText : '';
            if (costEl) costEl.textContent = cost > 0 ? '₹' + cost.toLocaleString('en-IN') : 'on request';
            if (mrpEl) mrpEl.textContent = mrp > 0 ? '₹' + mrp.toLocaleString('en-IN') : 'not set';

            if (searchRow) searchRow.style.display = 'none';
            if (card) card.style.display = 'flex';
        }

        function resetQoProductSelection() {
            var select = document.getElementById('qoProductSelect');
            if (select) select.value = '';

            var searchRow = document.getElementById('qoProdSearchRow');
            var card = document.getElementById('qoSelectedProductCard');
            var input = document.getElementById('qoProductSearchInput');

            var costEl = document.getElementById('qoCostPrice');
            var sellEl = document.getElementById('qoSellingPrice');
            if (costEl) costEl.value = '';
            if (sellEl) sellEl.value = '';
            calculateQoProfit();

            if (card) card.style.display = 'none';
            if (searchRow) searchRow.style.display = 'flex';
            if (input) {
                input.value = '';
            }
            clearQoProductSearch();
        }

        function handleQoProductChange(prodId) {
            // The cost/MRP came from the selected <option>'s data attributes and fell
            // back to 2199 / 3299, so an unpriced product still filled the form with
            // a cost and a selling price the firm never quoted. Both now come from
            // the product row and stay blank when the price is not set.
            var prods = window.allProducts || [];
            var p = prods.find(function(x) { return Number(x.id) === Number(prodId); });
            var cost = qoProductCost(p);
            var mrp = p ? (Number(p.retail_price) || 0) : 0;

            if (!p) {
                var select = document.getElementById('qoProductSelect');
                var opt = (select && select.selectedIndex >= 0) ? select.options[select.selectedIndex] : null;
                cost = opt ? Number(opt.getAttribute('data-cost')) || 0 : 0;
                mrp = opt ? Number(opt.getAttribute('data-mrp')) || 0 : 0;
            }

            var costEl = document.getElementById('qoCostPrice');
            var sellEl = document.getElementById('qoSellingPrice');
            if (costEl) costEl.value = cost > 0 ? cost : '';
            if (sellEl) sellEl.value = mrp > 0 ? mrp : '';
            calculateQoProfit();
        };

        function calculateQoProfit() {
            var qty = Number(document.getElementById('qoQuantity').value) || 1;
            var cost = Number(document.getElementById('qoCostPrice').value) || 0;
            var sell = Number(document.getElementById('qoSellingPrice').value) || 0;

            var totalOrder = qty * sell;
            var totalProfit = qty * (sell - cost);

            var elProfit = document.getElementById('qoProfitCalculated');
            var elTotal = document.getElementById('qoTotalOrderVal');

            if (elProfit) elProfit.textContent = '₹' + totalProfit.toLocaleString('en-IN');
            if (elTotal) elTotal.textContent = '₹' + totalOrder.toLocaleString('en-IN');
        };

        function handleQuickOrderSubmit() {
            var custId = Number(document.getElementById('qoCustomerSelect').value);
            var prodId = Number(document.getElementById('qoProductSelect').value);
            var qty = Number(document.getElementById('qoQuantity').value) || 1;
            var sell = Number(document.getElementById('qoSellingPrice').value) || 0;
            var cost = Number(document.getElementById('qoCostPrice').value) || 0;
            var profit = qty * (sell - cost);
            var total = qty * sell;

            var customers = getResellerCustomers();
            var c = customers.find(function(x) { return x.id === custId; });
            if (c) {
                c.totalOrders = (Number(c.totalOrders) || 0) + 1;
                c.totalPurchase = (Number(c.totalPurchase) || 0) + total;
                c.totalProfit = (Number(c.totalProfit) || 0) + profit;
                c.lastOrder = new Date().toISOString().split('T')[0];
                if ((c.tags || []).indexOf('REPEAT') === -1 && c.totalOrders > 1) {
                    c.tags.push('REPEAT');
                }
                saveResellerCustomers(customers);
            }

            closeResellerQuickOrderDrawer();
            showWsToast('🎉 Quick Order placed successfully! Net Profit: ₹' + profit.toLocaleString('en-IN'));
        };

        // 11. Repeat Order Modal Flow
        function openRepeatOrderModal(custId, origOrderId) {
            var customers = getResellerCustomers();
            var c = customers.find(function(x) { return x.id === custId; });
            if (!c) return;

            var modal = document.getElementById('resellerRepeatOrderModal');
            var custIdEl = document.getElementById('repeatCustId');
            var origIdEl = document.getElementById('repeatOrigOrderId');
            var detailsBox = document.getElementById('repeatOrderDetailsBox');
            var addr = document.getElementById('repeatOrderAddress');
            var qty = document.getElementById('repeatOrderQty');

            if (custIdEl) custIdEl.value = c.id;
            if (origIdEl) origIdEl.value = origOrderId || 'PREV';
            if (addr) addr.value = c.address + ', ' + c.city + ', ' + c.state + ' - ' + c.pincode;
            if (qty) qty.value = 1;

            if (detailsBox) {
                detailsBox.innerHTML = `
                    <div style="font-weight:800; font-size:0.84rem; color:var(--ws-text-main);">Customer: ${c.name} (${c.mobile})</div>
                    <div style="font-size:0.75rem; color:var(--ws-gold-primary); font-weight:700; margin-top:3px;">Repeating Last Purchased Silk Saree (Lot Size: 1 Pc)</div>
                `;
            }

            recalcRepeatOrderTotal();
            if (modal) modal.classList.add('active');
        };

        function closeRepeatOrderModal() {
            var modal = document.getElementById('resellerRepeatOrderModal');
            if (modal) modal.classList.remove('active');
        };

        function recalcRepeatOrderTotal() {
            var qty = Number(document.getElementById('repeatOrderQty').value) || 1;
            var total = qty * 4899;
            var el = document.getElementById('repeatOrderEstimatedTotal');
            if (el) el.textContent = '₹' + total.toLocaleString('en-IN');
        };

        function handleRepeatOrderConfirm() {
            var custId = Number(document.getElementById('repeatCustId').value);
            var qty = Number(document.getElementById('repeatOrderQty').value) || 1;
            var total = qty * 4899;
            var profit = qty * 1200;

            var customers = getResellerCustomers();
            var c = customers.find(function(x) { return x.id === custId; });
            if (c) {
                c.totalOrders = (Number(c.totalOrders) || 0) + 1;
                c.totalPurchase = (Number(c.totalPurchase) || 0) + total;
                c.totalProfit = (Number(c.totalProfit) || 0) + profit;
                c.lastOrder = new Date().toISOString().split('T')[0];
                saveResellerCustomers(customers);
            }

            closeRepeatOrderModal();
            showWsToast('🔁 Repeat Order confirmed & dispatched to customer!');
        };

        // 12. Notes Engine
        function openAddNoteModal(custId) {
            var modal = document.getElementById('resellerAddNoteModal');
            var formCustId = document.getElementById('noteFormCustomerId');
            var formText = document.getElementById('noteFormText');
            if (formCustId) formCustId.value = custId;
            if (formText) formText.value = '';
            if (modal) modal.classList.add('active');
        };

        function closeAddNoteModal() {
            var modal = document.getElementById('resellerAddNoteModal');
            if (modal) modal.classList.remove('active');
        };

        function handleSaveNoteSubmit() {
            var custId = Number(document.getElementById('noteFormCustomerId').value);
            var text = document.getElementById('noteFormText').value.trim();

            var customers = getResellerCustomers();
            var c = customers.find(function(x) { return x.id === custId; });
            if (c) {
                if (!c.notes) c.notes = [];
                c.notes.unshift({
                    id: Date.now(),
                    text: text,
                    date: new Date().toLocaleString(),
                    creator: 'Rajesh Kumar'
                });
                saveResellerCustomers(customers);
                if (currentActiveProfileCustomer && currentActiveProfileCustomer.id === custId) {
                    renderProfileNotesTab(c);
                }
            }

            closeAddNoteModal();
            showWsToast('📝 Note saved successfully!');
        };

        // 13. Schedule Follow-up Modal & Actions
        function openScheduleFollowupModal(prefillCustId) {
            var modal = document.getElementById('resellerScheduleFollowupModal');
            var custSelect = document.getElementById('followupFormCustomer');
            var dateEl = document.getElementById('followupFormDate');
            var timeEl = document.getElementById('followupFormTime');
            var noteEl = document.getElementById('followupFormNote');
            var statusEl = document.getElementById('followupFormStatus');

            var customers = getResellerCustomers();
            if (custSelect) {
                custSelect.innerHTML = '<option value="">-- Choose Buyer Profile --</option>' + customers.map(function(c) {
                    return '<option value="' + c.id + '" ' + (c.id === prefillCustId ? 'selected' : '') + '>' + c.name + ' (' + c.mobile + ' &bull; ' + (c.city || 'Surat') + ')</option>';
                }).join('');
            }

            if (dateEl) {
                var tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                dateEl.value = tomorrow.toISOString().split('T')[0];
            }
            if (timeEl) timeEl.value = '11:00';
            if (noteEl) {
                noteEl.value = '';
                if (typeof handleSmartInputChange === 'function') handleSmartInputChange(noteEl);
            }
            if (statusEl) statusEl.value = 'Pending';

            if (modal) modal.classList.add('active');
        };

        function closeScheduleFollowupModal() {
            var modal = document.getElementById('resellerScheduleFollowupModal');
            if (modal) modal.classList.remove('active');
        };

        function setFollowupDatePreset(presetKey) {
            var dateEl = document.getElementById('followupFormDate');
            if (!dateEl) return;
            var target = new Date();
            if (presetKey === 'today') {
                // today
            } else if (presetKey === 'tomorrow') {
                target.setDate(target.getDate() + 1);
            } else if (presetKey === '3days') {
                target.setDate(target.getDate() + 3);
            } else if (presetKey === 'nextweek') {
                target.setDate(target.getDate() + 7);
            }
            dateEl.value = target.toISOString().split('T')[0];
            showWsToast('📅 Set follow-up date: ' + target.toLocaleDateString('en-IN', { day:'numeric', month:'short' }));
        };

        function insertFollowupTaskPrompt(promptText) {
            var noteEl = document.getElementById('followupFormNote');
            if (!noteEl) return;
            noteEl.value = promptText;
            if (typeof handleSmartInputChange === 'function') handleSmartInputChange(noteEl);
            noteEl.focus();
        };

        function handleSaveFollowupSubmit() {
            var custId = Number(document.getElementById('followupFormCustomer').value);
            var date = document.getElementById('followupFormDate').value;
            var time = document.getElementById('followupFormTime').value || '11:00';
            var note = document.getElementById('followupFormNote').value.trim();
            var status = document.getElementById('followupFormStatus').value || 'Pending';

            if (!custId) {
                alert('Please select a customer.');
                return;
            }
            if (!date) {
                alert('Please choose a follow-up date.');
                return;
            }
            if (!note) {
                alert('Please describe the follow-up task note.');
                return;
            }

            var customers = getResellerCustomers();
            var c = customers.find(function(x) { return x.id === custId; });
            if (c) {
                if (!c.followups) c.followups = [];
                c.followups.unshift({
                    id: Date.now(),
                    date: date,
                    time: time,
                    note: note,
                    status: status
                });
                saveResellerCustomers(customers);
            }

            closeScheduleFollowupModal();
            renderFollowupsTable();
            showWsToast('⏰ Follow-up task scheduled for ' + (c ? c.name : 'Customer') + '!');
        };

        function markFollowupCompleted(custId, fId) {
            var customers = getResellerCustomers();
            var c = customers.find(function(x) { return x.id === custId; });
            if (c && c.followups) {
                var f = c.followups.find(function(x) { return x.id === fId; });
                if (f) f.status = 'Completed';
                saveResellerCustomers(customers);
                renderFollowupsTable();
                showWsToast('✅ Follow-up marked as completed!');
            }
        };

        function deleteFollowupTask(custId, fId) {
            if (!confirm('Are you sure you want to remove this follow-up reminder?')) return;
            var customers = getResellerCustomers();
            var c = customers.find(function(x) { return x.id === custId; });
            if (c && c.followups) {
                c.followups = c.followups.filter(function(x) { return x.id !== fId; });
                saveResellerCustomers(customers);
                renderFollowupsTable();
                showWsToast('🗑️ Follow-up reminder removed.');
            }
        };

        function sendCustomerWhatsAppFollowup(custId, customTaskNote) {
            var customers = getResellerCustomers();
            var c = customers.find(function(x) { return x.id === custId; });
            if (!c) return;

            var phone = (c.whatsapp || c.mobile || '').replace(/[^0-9]/g, '');
            if (!phone) {
                alert('WhatsApp number not found for ' + c.name);
                return;
            }

            var text = 'Namaste ' + c.name + '! 🙏\n\nHope you are doing well.';
            if (customTaskNote) {
                text += '\nRegarding our scheduled follow-up: ' + customTaskNote;
            } else {
                text += '\nFollowing up to share our latest festive Paithani & pure silk saree arrivals for your boutique!';
            }
            text += '\n\nFeel free to explore and let me know if you would like me to book your order today!\n— Rajesh Kumar (DT Brand\'s Reseller)';

            var url = 'https://wa.me/91' + phone + '?text=' + encodeURIComponent(text);
            window.open(url, '_blank');
        };

        // 14. Render Dashboard CRM Widgets
        function renderDashboardCrmWidgets() {
            var customers = getResellerCustomers();

            // 1. Follow-ups widget
            var fContainer = document.getElementById('dashFollowupsList');
            if (fContainer) {
                var allFollowups = [];
                customers.forEach(function(c) {
                    (c.followups || []).forEach(function(f) {
                        if (f.status !== 'Completed') {
                            allFollowups.push({ customer: c, task: f });
                        }
                    });
                });

                if (allFollowups.length === 0) {
                    fContainer.innerHTML = '<div style="text-align:center; color:var(--ws-text-muted); font-size:0.75rem; padding:15px;">No pending follow-ups today.</div>';
                } else {
                    fContainer.innerHTML = allFollowups.map(function(item) {
                        return `
                            <div style="background:#FAF8F4; border:1px solid var(--ws-border); border-radius:8px; padding:8px 10px; display:flex; justify-content:space-between; align-items:center;">
                                <div>
                                    <div style="font-weight:800; font-size:0.78rem;">${item.customer.name}</div>
                                    <div style="font-size:0.68rem; color:var(--ws-text-muted);">${item.task.note} &bull; <strong>${item.task.date}</strong></div>
                                </div>
                                <button class="ws-btn ws-btn-sm" onclick="sendCustomerWhatsAppMessage(${item.customer.id})" style="background:#25D366; color:#FFF; padding:2px 8px; font-size:0.68rem;">💬 Chat</button>
                            </div>
                        `;
                    }).join('');
                }
            }

            // 2. Top Customers Leaderboard widget
            renderTopCustomersList('month');

            // 3. Reorder Opportunities widget
            var rContainer = document.getElementById('dashReorderAlertsList');
            if (rContainer) {
                var opps = customers.filter(function(c) { return Number(c.totalOrders) >= 2; });
                rContainer.innerHTML = opps.slice(0, 3).map(function(c) {
                    return `
                        <div style="background:#FAF8F4; border:1px solid var(--ws-border); border-radius:8px; padding:8px 10px; display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <div style="font-weight:800; font-size:0.78rem;">${c.name} &bull; Reorder Cycle ${c.reorderCycleDays || 30} Days</div>
                                <div style="font-size:0.68rem; color:#B45309; font-weight:700;">Last order was 28 days ago</div>
                            </div>
                            <button class="ws-btn ws-btn-primary ws-btn-sm" onclick="openRepeatOrderModal(${c.id})" style="padding:2px 8px; font-size:0.68rem;">🔁 Reorder</button>
                        </div>
                    `;
                }).join('');
            }
        };

        function renderTopCustomersList(period) {
            var container = document.getElementById('dashTopCustomersList');
            if (!container) return;
            var customers = getResellerCustomers();
            var sorted = customers.slice().sort(function(a, b) { return b.totalPurchase - a.totalPurchase; });
            container.innerHTML = sorted.slice(0, 4).map(function(c, idx) {
                var medal = idx === 0 ? '🥇' : (idx === 1 ? '🥈' : (idx === 2 ? '🥉' : '⭐'));
                return `
                    <div style="display:flex; justify-content:space-between; align-items:center; background:#FAF8F4; border:1px solid var(--ws-border); border-radius:8px; padding:6px 10px; cursor:pointer;" onclick="openCustomerProfileModal(${c.id})">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="font-size:0.90rem;">${medal}</span>
                            <div>
                                <div style="font-weight:800; font-size:0.78rem;">${c.name}</div>
                                <div style="font-size:0.68rem; color:var(--ws-text-muted);">${c.totalOrders} Orders &bull; Profit: ₹${Number(c.totalProfit).toLocaleString('en-IN')}</div>
                            </div>
                        </div>
                        <span style="font-weight:900; font-size:0.82rem; color:var(--ws-gold-primary);">₹${Number(c.totalPurchase).toLocaleString('en-IN')}</span>
                    </div>
                `;
            }).join('');
        };

        function switchTopCustomersPeriod(period, btn) {
            var pills = btn.parentElement.querySelectorAll('.ws-filter-pill');
            pills.forEach(function(p) { p.classList.remove('active'); });
            btn.classList.add('active');
            renderTopCustomersList(period);
        };

        // 15. Global Live Search (Desktop + Mobile Overlay)
        function openMobileSearchOverlay() {
            var header = document.getElementById('wsMainHeader');
            if (header) header.classList.add('mobile-search-active');
            var mobileInp = document.getElementById('wsMobileSearchInput');
            if (mobileInp) {
                setTimeout(function() {
                    mobileInp.focus();
                }, 100);
            }
        };

        function closeMobileSearchOverlay() {
            var header = document.getElementById('wsMainHeader');
            if (header) header.classList.remove('mobile-search-active');
            var mobileInp = document.getElementById('wsMobileSearchInput');
            if (mobileInp) mobileInp.value = '';
            var desktopInp = document.getElementById('wsGlobalSearchInput');
            if (desktopInp) desktopInp.value = '';
            var clearBtn = document.getElementById('wsMobileSearchClearBtn');
            if (clearBtn) clearBtn.style.display = 'none';
            var resultsBox = document.getElementById('wsGlobalSearchResults');
            if (resultsBox) {
                resultsBox.style.display = 'none';
                resultsBox.innerHTML = '';
            }
        };

        function handleMobileSearchInput(val) {
            var clearBtn = document.getElementById('wsMobileSearchClearBtn');
            if (clearBtn) {
                clearBtn.style.display = (val && val.trim()) ? 'flex' : 'none';
            }
        };

        function clearMobileGlobalSearch() {
            var mobileInp = document.getElementById('wsMobileSearchInput');
            if (mobileInp) {
                mobileInp.value = '';
                mobileInp.focus();
            }
            handleMobileSearchInput('');
            handleGlobalSearch('');
        };

        function clearGlobalSearch() {
            var inp = document.getElementById('wsGlobalSearchInput');
            if (inp) {
                inp.value = '';
                inp.focus();
            }
            var clearBtn = document.getElementById('wsGlobalSearchClear');
            if (clearBtn) clearBtn.style.display = 'none';
            handleGlobalSearch('');
        };

        function handleGlobalSearch(query) {
            var q = (query || '').trim().toLowerCase();
            var resultsBox = document.getElementById('wsGlobalSearchResults');
            var desktopClearBtn = document.getElementById('wsGlobalSearchClear');
            if (desktopClearBtn) desktopClearBtn.style.display = q ? 'block' : 'none';

            if (!resultsBox) return;

            if (!q) {
                resultsBox.style.display = 'none';
                resultsBox.innerHTML = '';
                return;
            }

            var customers = getResellerCustomers().filter(function(c) {
                return (c.name || '').toLowerCase().indexOf(q) !== -1 || (c.mobile || '').indexOf(q) !== -1 || (c.city || '').toLowerCase().indexOf(q) !== -1;
            });

            var orders = (window.allOrders || []).filter(function(o) {
                return (o.orderId || o.id || '').toLowerCase().indexOf(q) !== -1 || (o.productName || '').toLowerCase().indexOf(q) !== -1;
            });

            var prods = (window.allProducts || []).filter(function(p) {
                return (p.name || '').toLowerCase().indexOf(q) !== -1 || (p.category || '').toLowerCase().indexOf(q) !== -1;
            });

            var html = '';

            if (customers.length > 0) {
                html += '<div class="ws-search-group-title">👥 Customers (' + customers.length + ')</div>';
                customers.slice(0, 4).forEach(function(c) {
                    html += `
                        <div class="ws-search-item" onclick="openCustomerProfileModal(${c.id}); closeMobileSearchOverlay(); if(document.getElementById('wsGlobalSearchResults')) document.getElementById('wsGlobalSearchResults').style.display='none';">
                            <div>
                                <div class="ws-search-item-title">${c.name}</div>
                                <div class="ws-search-item-sub">📞 ${c.mobile} &bull; 📍 ${c.city || 'Surat'}</div>
                            </div>
                            <span class="crm-tag crm-tag-vip">Profile →</span>
                        </div>
                    `;
                });
            }

            if (orders.length > 0) {
                html += '<div class="ws-search-group-title">📦 Consignments & Orders (' + orders.length + ')</div>';
                orders.slice(0, 4).forEach(function(o) {
                    var oId = o.orderId || o.id;
                    html += `
                        <div class="ws-search-item" onclick="openWsOrderModal('${oId}'); closeMobileSearchOverlay(); if(document.getElementById('wsGlobalSearchResults')) document.getElementById('wsGlobalSearchResults').style.display='none';">
                            <div>
                                <div class="ws-search-item-title">${oId} - ${o.productName}</div>
                                <div class="ws-search-item-sub">Status: <strong>${o.status}</strong> &bull; Consignment Total: ₹${o.total}</div>
                            </div>
                            <span style="font-size:0.70rem; font-weight:800; color:var(--ws-gold-primary);">Track →</span>
                        </div>
                    `;
                });
            }

            if (prods.length > 0) {
                html += '<div class="ws-search-group-title">👗 Catalog Lots (' + prods.length + ')</div>';
                prods.slice(0, 4).forEach(function(p) {
                    html += `
                        <div class="ws-search-item" onclick="openResellerQuickOrderDrawer(); closeMobileSearchOverlay(); if(document.getElementById('wsGlobalSearchResults')) document.getElementById('wsGlobalSearchResults').style.display='none';">
                            <div>
                                <div class="ws-search-item-title">${p.name}</div>
                                <div class="ws-search-item-sub">₹${p.wholesale_price || p.price} &bull; ${p.category} &bull; MOQ: ${p.moq || 8} Pcs</div>
                            </div>
                            <span style="font-size:0.70rem; font-weight:800; color:#047857;">Quick Order →</span>
                        </div>
                    `;
                });
            }

            if (!html) {
                html = '<div style="padding:14px; font-size:0.78rem; color:var(--ws-text-muted); text-align:center;">No matching customers, orders, or products found for "<strong>' + q + '</strong>".</div>';
            }

            resultsBox.innerHTML = html;
            resultsBox.style.display = 'block';
        };

        // 16. WhatsApp Actions Generator
        function sendCustomerWhatsAppMessage(custId) {
            var customers = getResellerCustomers();
            var c = customers.find(function(x) { return x.id === custId; });
            if (!c) return;

            var phone = c.whatsapp || c.mobile;
            var text = `Namaste ${c.name} ji 🙏,

We have exciting new luxury silk saree collections and festive arrivals at DT Brand\'s / Arniya.

Would you like me to share the latest catalog?

Warm regards,
Rajesh Kumar (Reseller Partner)`;
            var url = 'https://api.whatsapp.com/send?phone=91' + phone + '&text=' + encodeURIComponent(text);
            window.open(url, '_blank');
        };

        // 17. CSV / Excel Exports
        function exportCustomersCSV() {
            var customers = getResellerCustomers();
            var csv = 'ID,Name,Mobile,WhatsApp,Email,Address,City,State,Pincode,Tags,TotalOrders,TotalPurchase,TotalProfit,LastOrder\n';
            customers.forEach(function(c) {
                csv += `"${c.id}","${c.name}","${c.mobile}","${c.whatsapp || ''}","${c.email || ''}","${c.address || ''}","${c.city}","${c.state}","${c.pincode}","${(c.tags||[]).join(';')}","${c.totalOrders}","${c.totalPurchase}","${c.totalProfit}","${c.lastOrder}"\n`;
            });

            var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            var url = URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'Reseller_Customers_' + new Date().toISOString().split('T')[0] + '.csv';
            a.click();
            showWsToast('📥 Customers CSV exported!');
        };

        function exportProfitLedgerCSV() {
            var csv = 'OrderID,Customer,Product,SellingPrice,BaseCost,NetProfit,MarginPct,Date\n';
            csv += '#ORD-77492,Ananya Deshmukh,Paithani Silk Saree,18200,14000,4200,23.08%,2026-08-12\n';
            csv += '#ORD-77450,Pooja Varma,Bridal Lehenga Set,24800,19000,5800,23.38%,2026-08-05\n';

            var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            var url = URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'Reseller_Profit_Ledger_' + new Date().toISOString().split('T')[0] + '.csv';
            a.click();
            showWsToast('📥 Profit Ledger CSV exported!');
        };

        // 18. Notifications Modal
        function openResellerNotificationsModal() {
            var modal = document.getElementById('resellerNotificationsModal');
            var list = document.getElementById('resellerNotificationsList');
            if (list) {
                list.innerHTML = `
                    <div style="display:flex; flex-direction:column; gap:8px;">
                        <div style="background:#FAF8F4; border:1px solid var(--ws-border); border-radius:8px; padding:10px;">
                            <div style="font-weight:800; font-size:0.78rem; color:var(--ws-text-main);">📦 Order #ORD-77492 Dispatched</div>
                            <div style="font-size:0.70rem; color:var(--ws-text-muted);">BlueDart courier in transit to Ananya Deshmukh (Mumbai)</div>
                        </div>
                        <div style="background:#FAF8F4; border:1px solid var(--ws-border); border-radius:8px; padding:10px;">
                            <div style="font-weight:800; font-size:0.78rem; color:#B45309;">⏰ Follow-up Due Today: Pooja Varma</div>
                            <div style="font-size:0.70rem; color:var(--ws-text-muted);">Scheduled call at 4:00 PM for festive orders</div>
                        </div>
                        <div style="background:#FAF8F4; border:1px solid var(--ws-border); border-radius:8px; padding:10px;">
                            <div style="font-weight:800; font-size:0.78rem; color:#047857;">💰 Profit Updated: +₹4,200</div>
                            <div style="font-size:0.70rem; color:var(--ws-text-muted);">Realized margin credited to Reseller Gold Wallet</div>
                        </div>
                    </div>
                `;
            }
            if (modal) modal.classList.add('active');
        };

        function closeResellerNotificationsModal() {
            var modal = document.getElementById('resellerNotificationsModal');
            if (modal) modal.classList.remove('active');
        };

        // 19. Initial Boot Hook for CRM
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof updateCrmCounts === 'function') updateCrmCounts(); else if (typeof window.updateCrmCounts === 'function') updateCrmCounts();
            if (typeof renderDashboardCrmWidgets === 'function') renderDashboardCrmWidgets(); else if (typeof window.renderDashboardCrmWidgets === 'function') renderDashboardCrmWidgets();
        });

    
                        /* ── Profit Ledger Renderer (Qty Only, Product Name Removed) ── */
        function renderProfitLedger() {
            var tbody = document.getElementById('crmProfitTbody');
            var mobList = document.getElementById('crmProfitMobileList');
            if (!tbody) return;

            var profitData = [
                { id: '#ORD-77492', cust: 'Ananya Deshmukh', qty: '1 Pc', sell: 18200, cost: 14000, profit: 4200, margin: '23.08%', status: 'Delivered', date: '2026-08-12' },
                { id: '#ORD-77450', cust: 'Pooja Varma', qty: '1 Pc', sell: 24800, cost: 19000, profit: 5800, margin: '23.38%', status: 'Delivered', date: '2026-08-05' },
                { id: '#ORD-77412', cust: 'Kavita Singhania', qty: '2 Pcs', sell: 16998, cost: 12998, profit: 4000, margin: '23.53%', status: 'Delivered', date: '2026-08-01' },
                { id: '#ORD-77388', cust: 'Priyanka Reddy', qty: '1 Pc', sell: 14999, cost: 11499, profit: 3500, margin: '23.33%', status: 'Delivered', date: '2026-07-28' },
                { id: '#ORD-77350', cust: 'Sneha Patel', qty: '3 Pcs', sell: 9900, cost: 7500, profit: 2400, margin: '24.24%', status: 'Delivered', date: '2026-07-20' },
                { id: '#ORD-77510', cust: 'Ritu Aggarwal', qty: '1 Pc', sell: 4200, cost: 3200, profit: 1000, margin: '23.81%', status: 'In Transit', date: '2026-08-15' }
            ];

            // 1. Desktop Table
            tbody.innerHTML = profitData.map(function(item) {
                var isDel = item.status === 'Delivered';
                var statusCls = isDel ? 'background:#DCFCE7; color:#15803D; border:1px solid #86EFAC;' : 'background:#FEF3C7; color:#B45309; border:1px solid #FCD34D;';
                return `
                    <tr>
                        <td style="white-space:nowrap; font-weight:800; color:var(--ws-gold-primary);">${item.id}</td>
                        <td style="white-space:nowrap; font-weight:700; color:var(--ws-text-main);">${item.cust}</td>
                        <td style="text-align:center; white-space:nowrap;"><span style="background:#FAF5E8; color:#8A681F; font-weight:800; font-size:0.78rem; padding:3px 8px; border-radius:6px; border:1px solid #DFC994;">${item.qty}</span></td>
                        <td style="text-align:right; font-weight:800; white-space:nowrap;">₹${item.sell.toLocaleString('en-IN')}</td>
                        <td style="text-align:right; color:var(--ws-text-muted); white-space:nowrap;">₹${item.cost.toLocaleString('en-IN')}</td>
                        <td style="text-align:right; font-weight:900; color:#047857; white-space:nowrap;">+₹${item.profit.toLocaleString('en-IN')}</td>
                        <td style="text-align:center; white-space:nowrap;"><span style="font-weight:900; font-size:0.76rem; color:#047857; background:#ECFDF5; padding:2px 6px; border-radius:4px; border:1px solid #A7F3D0;">${item.margin}</span></td>
                        <td style="text-align:center; white-space:nowrap;"><span class="crm-tag" style="${statusCls}">${item.status}</span></td>
                        <td style="text-align:center; font-size:0.76rem; font-weight:600; color:var(--ws-text-muted); white-space:nowrap;">${item.date}</td>
                    </tr>
                `;
            }).join('');

            // 2. Mobile Responsive Cards
            if (mobList) {
                mobList.innerHTML = profitData.map(function(item) {
                    var isDel = item.status === 'Delivered';
                    var statusCls = isDel ? 'background:#DCFCE7; color:#15803D; border:1px solid #86EFAC;' : 'background:#FEF3C7; color:#B45309; border:1px solid #FCD34D;';
                    return `
                        <div class="ws-mobile-order-card" style="border-left:4.5px solid var(--ws-gold-primary);">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                                <strong style="color:var(--ws-gold-primary); font-size:0.86rem;">${item.id}</strong>
                                <span class="crm-tag" style="${statusCls}">${item.status}</span>
                            </div>
                            <div style="font-weight:800; font-size:0.86rem; color:var(--ws-text-main);">${item.cust}</div>
                            <div style="font-size:0.74rem; color:var(--ws-text-muted); margin-bottom:8px;">Quantity: <strong>${item.qty}</strong> &bull; 📅 ${item.date}</div>
                            <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; background:#FAF8F4; border:1px solid #EADBBE; border-radius:8px; padding:8px; text-align:center;">
                                <div>
                                    <div style="font-size:0.65rem; color:var(--ws-text-muted);">Selling Price</div>
                                    <div style="font-weight:800; font-size:0.80rem;">₹${item.sell.toLocaleString('en-IN')}</div>
                                </div>
                                <div>
                                    <div style="font-size:0.65rem; color:var(--ws-text-muted);">Reseller Cost</div>
                                    <div style="font-weight:700; font-size:0.80rem; color:var(--ws-text-muted);">₹${item.cost.toLocaleString('en-IN')}</div>
                                </div>
                                <div>
                                    <div style="font-size:0.65rem; color:var(--ws-text-muted);">Net Profit (${item.margin})</div>
                                    <div style="font-weight:900; font-size:0.82rem; color:#047857;">+₹${item.profit.toLocaleString('en-IN')}</div>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
            }
        };

        /* ── Follow-ups Table & Mobile Card Renderer ── */
        var currentFollowupFilter = 'all';
        var currentFollowupSearchQuery = '';

        function filterFollowups(filter, btn) {
            currentFollowupFilter = filter || 'all';

            // 1. Update active filter pills
            var pills = document.querySelectorAll('#followupFilterPills .ws-filter-pill');
            pills.forEach(function(p) {
                p.classList.remove('active');
            });
            if (btn && btn.classList) {
                btn.classList.add('active');
            } else {
                // Find matching pill by filter
                var targetIdx = { 'all': 0, 'pending': 1, 'today': 2, 'completed': 3 }[filter] || 0;
                if (pills[targetIdx]) pills[targetIdx].classList.add('active');
            }

            // 2. Update active KPI Card highlights
            var kpiCards = {
                'all': document.getElementById('kpiCardAll'),
                'pending': document.getElementById('kpiCardPending'),
                'today': document.getElementById('kpiCardToday'),
                'completed': document.getElementById('kpiCardCompleted')
            };
            Object.keys(kpiCards).forEach(function(k) {
                if (kpiCards[k]) {
                    if (k === filter) {
                        kpiCards[k].classList.add('active-filter');
                    } else {
                        kpiCards[k].classList.remove('active-filter');
                    }
                }
            });

            renderFollowupsTable();
        };

        function handleFollowupSearch(val) {
            currentFollowupSearchQuery = (val || '').trim();
            var clearBtn = document.getElementById('followupSearchClear');
            if (clearBtn) clearBtn.style.display = currentFollowupSearchQuery ? 'block' : 'none';
            renderFollowupsTable();
        };

        function clearFollowupSearch() {
            var input = document.getElementById('followupSearchInput');
            if (input) {
                input.value = '';
                input.focus();
            }
            var clearBtn = document.getElementById('followupSearchClear');
            if (clearBtn) clearBtn.style.display = 'none';
            currentFollowupSearchQuery = '';
            renderFollowupsTable();
        };

        function renderFollowupsTable() {
            var tbody = document.getElementById('crmFollowupsTbody');
            var mobList = document.getElementById('crmFollowupsMobileList');
            if (!tbody && !mobList) return;

            var customers = getResellerCustomers();
            var allFollowups = [];
            var todayStr = new Date().toISOString().split('T')[0];

            var countTotal = 0;
            var countPending = 0;
            var countToday = 0;
            var countCompleted = 0;

            customers.forEach(function(c) {
                (c.followups || []).forEach(function(f) {
                    allFollowups.push({ customer: c, task: f });
                    countTotal++;
                    if (f.status === 'Completed') {
                        countCompleted++;
                    } else {
                        countPending++;
                        if (f.date === todayStr) {
                            countToday++;
                        }
                    }
                });
            });

            // 1. Sync KPI Count Badges
            var elStatTot = document.getElementById('statFollowupsTotal');
            var elStatPend = document.getElementById('statFollowupsPending');
            var elStatTod = document.getElementById('statFollowupsToday');
            var elStatComp = document.getElementById('statFollowupsCompleted');
            if (elStatTot) elStatTot.textContent = countTotal;
            if (elStatPend) elStatPend.textContent = countPending;
            if (elStatTod) elStatTod.textContent = countToday;
            if (elStatComp) elStatComp.textContent = countCompleted;

            // 2. Sync Filter Pill Count Badges
            var elPillAll = document.getElementById('badgeCountAll');
            var elPillPend = document.getElementById('badgeCountPending');
            var elPillTod = document.getElementById('badgeCountToday');
            var elPillComp = document.getElementById('badgeCountCompleted');
            if (elPillAll) elPillAll.textContent = countTotal;
            if (elPillPend) elPillPend.textContent = countPending;
            if (elPillTod) elPillTod.textContent = countToday;
            if (elPillComp) elPillComp.textContent = countCompleted;

            // 3. Sync Sidebar Nav Due Badge
            var navDueBadge = document.getElementById('navFollowupsDueBadge');
            if (navDueBadge) {
                if (countToday > 0) {
                    navDueBadge.textContent = countToday;
                    navDueBadge.style.display = 'inline-flex';
                } else {
                    navDueBadge.style.display = 'none';
                }
            }

            // 4. Apply Status & Search Filtering
            var filtered = allFollowups.filter(function(item) {
                // Status filter
                if (currentFollowupFilter === 'pending' && item.task.status === 'Completed') return false;
                if (currentFollowupFilter === 'completed' && item.task.status !== 'Completed') return false;
                if (currentFollowupFilter === 'today' && (item.task.date !== todayStr || item.task.status === 'Completed')) return false;

                // Search query filter
                if (currentFollowupSearchQuery) {
                    var q = currentFollowupSearchQuery.toLowerCase();
                    var matchName = (item.customer.name || '').toLowerCase().indexOf(q) !== -1;
                    var matchPhone = (item.customer.mobile || '').indexOf(q) !== -1 || (item.customer.whatsapp || '').indexOf(q) !== -1;
                    var matchNote = (item.task.note || '').toLowerCase().indexOf(q) !== -1;
                    var matchCity = (item.customer.city || '').toLowerCase().indexOf(q) !== -1;
                    if (!matchName && !matchPhone && !matchNote && !matchCity) return false;
                }

                return true;
            });

            // Sort: Today and Pending first, then by date
            filtered.sort(function(a, b) {
                if (a.task.status === 'Completed' && b.task.status !== 'Completed') return 1;
                if (a.task.status !== 'Completed' && b.task.status === 'Completed') return -1;
                return (a.task.date || '').localeCompare(b.task.date || '');
            });

            // 5. Render Desktop Table
            if (tbody) {
                if (filtered.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="6" style="text-align:center; padding:38px 20px; color:#8C8072;">
                                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="1.8" style="margin-bottom:8px; display:inline-block;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                <div style="font-weight:800; font-size:0.92rem; color:#1E293B;">No follow-up reminders found</div>
                                <div style="font-size:0.76rem; color:#7D7162; margin-top:2px;">Try selecting another filter or schedule a new reminder.</div>
                            </td>
                        </tr>
                    `;
                } else {
                    tbody.innerHTML = filtered.map(function(item) {
                        var isCompleted = item.task.status === 'Completed';
                        var isDueToday = item.task.date === todayStr && !isCompleted;
                        var isOverdue = item.task.date < todayStr && !isCompleted;

                        var statusBadgeHtml = '';
                        if (isCompleted) {
                            statusBadgeHtml = '<span class="crm-tag" style="background:#DCFCE7; color:#15803D; border:1px solid #86EFAC; font-weight:800; font-size:0.70rem;">✓ Completed</span>';
                        } else if (isDueToday) {
                            statusBadgeHtml = '<span class="crm-tag" style="background:#FFE4E6; color:#E11D48; border:1px solid #FDA4AF; font-weight:800; font-size:0.70rem;">🚨 Due Today</span>';
                        } else if (isOverdue) {
                            statusBadgeHtml = '<span class="crm-tag" style="background:#FEF2F2; color:#DC2626; border:1px solid #FECACA; font-weight:800; font-size:0.70rem;">⏳ Overdue</span>';
                        } else {
                            statusBadgeHtml = '<span class="crm-tag" style="background:#FEF3C7; color:#B45309; border:1px solid #FDE68A; font-weight:800; font-size:0.70rem;">⏳ Pending</span>';
                        }

                        var formattedDate = item.task.date;
                        try {
                            var d = new Date(item.task.date);
                            formattedDate = d.toLocaleDateString('en-IN', { day:'numeric', month:'short', year:'numeric' });
                        } catch(e) {}

                        return `
                            <tr>
                                <td>
                                    <div class="ws-followup-date-box">
                                        <div class="ws-followup-date-main">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2" style="display:inline-block;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                            <span>${formattedDate}</span>
                                        </div>
                                        <div class="ws-followup-time-tag">
                                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                            <span>${item.task.time || '11:00 AM'}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="ws-followup-cust-name" onclick="openCustomerProfileModal(${item.customer.id})" title="View Customer Profile">
                                        <div class="ws-followup-avatar-initial">${(item.customer.name || 'C').charAt(0)}</div>
                                        <div>
                                            <div style="font-weight:800; color:#1E293B;">${item.customer.name}</div>
                                            <div style="font-size:0.68rem; color:#7D7162; font-weight:600;">📍 ${item.customer.city || 'Surat'}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size:0.78rem; font-weight:700; color:#1E293B; display:flex; align-items:center; gap:5px;">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#25D366" stroke-width="2.2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                        <span>${item.customer.mobile}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="ws-followup-note-card">
                                        ${item.task.note}
                                    </div>
                                </td>
                                <td style="text-align:center;">${statusBadgeHtml}</td>
                                <td style="text-align:center;">
                                    <div style="display:flex; gap:6px; justify-content:center; align-items:center; flex-wrap:wrap;">
                                        <button type="button" class="ws-btn-followup-wa" onclick="sendCustomerWhatsAppFollowup(${item.customer.id}, '${(item.task.note || '').replace(/'/g, "\\'")}')" title="Send WhatsApp Message">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                            <span>WhatsApp</span>
                                        </button>
                                        ${!isCompleted ? `
                                            <button type="button" class="ws-btn-followup-done" onclick="markFollowupCompleted(${item.customer.id}, ${item.task.id})" title="Mark as Done">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                <span>Done</span>
                                            </button>
                                        ` : ''}
                                        <button type="button" class="ws-btn-action-icon danger" onclick="deleteFollowupTask(${item.customer.id}, ${item.task.id})" title="Delete Reminder" style="background:transparent; border:none; color:#DC2626; cursor:pointer; padding:4px; border-radius:6px; display:inline-flex; align-items:center; justify-content:center;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    }).join('');
                }
            }

            // 6. Render Mobile Responsive Cards
            if (mobList) {
                if (filtered.length === 0) {
                    mobList.innerHTML = `
                        <div style="text-align:center; padding:30px 16px; background:#FFFFFF; border:1.5px solid #EFE6D5; border-radius:14px; color:#8C8072;">
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="1.8" style="margin-bottom:8px; display:inline-block;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            <div style="font-weight:800; font-size:0.92rem; color:#1E293B;">No follow-ups found</div>
                            <div style="font-size:0.76rem; color:#7D7162; margin-top:2px;">Try another filter or schedule a new reminder.</div>
                        </div>
                    `;
                } else {
                    mobList.innerHTML = filtered.map(function(item) {
                        var isCompleted = item.task.status === 'Completed';
                        var isDueToday = item.task.date === todayStr && !isCompleted;
                        var cardClass = isCompleted ? 'completed' : (isDueToday ? 'today' : 'pending');

                        var formattedDate = item.task.date;
                        try {
                            var d = new Date(item.task.date);
                            formattedDate = d.toLocaleDateString('en-IN', { day:'numeric', month:'short' });
                        } catch(e) {}

                        var dueBadge = isDueToday ? '🚨 Due Today' : (isCompleted ? '✓ Completed' : '📅 ' + formattedDate);

                        return `
                            <div class="ws-mobile-followup-card ${cardClass}">
                                <div class="ws-mobile-followup-top">
                                    <span class="ws-mobile-followup-due">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                        <span>${dueBadge} &bull; ${item.task.time || '11:00 AM'}</span>
                                    </span>
                                    <span style="font-size:0.68rem; font-weight:800; padding:2px 8px; border-radius:6px; ${isCompleted ? 'background:#DCFCE7; color:#15803D;' : (isDueToday ? 'background:#FFE4E6; color:#E11D48;' : 'background:#FEF3C7; color:#B45309;')}">
                                        ${item.task.status}
                                    </span>
                                </div>
                                <div class="ws-mobile-followup-cust" onclick="openCustomerProfileModal(${item.customer.id})">
                                    <div class="ws-followup-avatar-initial">${(item.customer.name || 'C').charAt(0)}</div>
                                    <div>
                                        <div style="font-weight:800; font-size:0.90rem; color:#1E293B;">${item.customer.name}</div>
                                        <div style="font-size:0.72rem; color:#7D7162; font-weight:600;">📞 ${item.customer.mobile} &bull; 📍 ${item.customer.city || 'Surat'}</div>
                                    </div>
                                </div>
                                <div class="ws-mobile-followup-note">
                                    ${item.task.note}
                                </div>
                                <div class="ws-mobile-followup-actions">
                                    <button type="button" class="ws-btn-followup-wa" onclick="sendCustomerWhatsAppFollowup(${item.customer.id}, '${(item.task.note || '').replace(/'/g, "\\'")}')">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                        <span>WhatsApp Chat</span>
                                    </button>
                                    ${!isCompleted ? `
                                        <button type="button" class="ws-btn-followup-done" onclick="markFollowupCompleted(${item.customer.id}, ${item.task.id})">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            <span>Mark Done</span>
                                        </button>
                                    ` : `
                                        <button type="button" class="ws-btn-followup-done" style="background:#F1F5F9; border-color:#CBD5E1; color:#64748B !important; cursor:default;">
                                            <span>✓ Done</span>
                                        </button>
                                    `}
                                </div>
                            </div>
                        `;
                    }).join('');
                }
            }
        };

        /* ── Recommendations Center Renderer ── */
        /* ── Tailored Recommendation Engine ── */
        function populateRecommendationSelect() {
            var select = document.getElementById('recommendationCustomerSelect');
            if (!select) return;
            var customers = getResellerCustomers();
            select.innerHTML = '<option value="">-- Choose Customer --</option>' + customers.map(function(c) {
                var vipTag = (c.tags && c.tags.length > 0) ? ' [' + c.tags.slice(0, 2).join(', ') + ']' : '';
                return '<option value="' + c.id + '">' + c.name + ' (' + c.city + vipTag + ')</option>';
            }).join('');
            if (customers.length > 0) {
                select.value = customers[0].id;
                generateCustomerRecommendations(customers[0].id);
            }
        }
        window.populateRecommendationSelect = populateRecommendationSelect;

        function generateCustomerRecommendations(custId) {
            var grid = document.getElementById('recommendationsProductGrid');
            var insightBar = document.getElementById('recommendationCustomerInsightBar');
            if (!grid) return;

            var customers = getResellerCustomers();
            var c = customers.find(function(x) { return Number(x.id) === Number(custId); }) || customers[0];
            
            var el = document.getElementById('ws-catalog-data');
            var prods = (window.allProducts && window.allProducts.length > 0) ? window.allProducts : (el ? JSON.parse(el.textContent || '[]') : []);
            
            // A hardcoded set of six products (ids 101-106, Rs 1,850-4,200 with
            // invented MRPs) used to load whenever the catalogue was empty, so a
            // reseller could pitch and order sarees that do not exist.
            if (prods.length === 0) {
                if (insightBar) insightBar.innerHTML = '';
                grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:30px; color:var(--ws-text-muted);">No products are published yet, so there is nothing to recommend.</div>';
                return;
            }

            if (!c) {
                if (insightBar) insightBar.innerHTML = '';
                grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:30px; color:var(--ws-text-muted);">Please select a customer to view recommendations.</div>';
                return;
            }

            // Update Dynamic Customer Persona Bar
            if (insightBar) {
                var initials = (c.name || 'C').split(' ').map(function(w){return w[0];}).slice(0,2).join('').toUpperCase();
                // The tags used to default to ['VIP', 'Repeat'], the city/state to
                // Surat/Gujarat, the order count to 1 and lifetime value to
                // Rs 4,500 for a customer with none of that recorded, and every
                // customer was labelled "Prefers: Pure Silk & Sarees".
                var tagHtml = (Array.isArray(c.tags) ? c.tags : []).filter(function(t) { return String(t).trim() !== ''; }).map(function(t, idx) {
                    var cls = idx === 0 ? 'gold' : (idx === 1 ? 'green' : '');
                    return '<span class="ws-rec-persona-pill ' + cls + '">' + t + '</span>';
                }).join('');
                var place = [c.city, c.state].filter(function(v) { return String(v || '').trim() !== ''; }).join(', ');
                var orderCount = Number(c.totalOrders) || 0;
                var spend = Number(c.totalPurchase) || 0;
                var factBits = [];
                if (place) factBits.push(place);
                if (orderCount > 0) {
                    factBits.push(orderCount + ' order' + (orderCount > 1 ? 's' : '')
                        + (spend > 0 ? ' (₹' + spend.toLocaleString('en-IN') + ')' : ''));
                }

                insightBar.innerHTML = `
                    <div class="ws-rec-persona-left">
                        <div class="ws-rec-persona-avatar">${initials}</div>
                        <div>
                            <div class="ws-rec-persona-name">${c.name}</div>
                            ${factBits.length ? `<div class="ws-rec-persona-city">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                ${factBits.join(' &bull; ')}
                            </div>` : ''}
                        </div>
                        <div class="ws-rec-persona-pills">
                            ${tagHtml}
                        </div>
                    </div>
                    <button class="ws-rec-persona-chat-btn" onclick="sendCustomerWhatsAppMessage(${c.id})" title="Open WhatsApp Chat">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2z"/></svg>
                        <span>Chat on WA</span>
                    </button>
                `;
            }

            grid.innerHTML = prods.slice(0, 6).map(function(p, idx) {
                // Cost used to fall back to 2199, MRP to 3499, the category to
                // 'Pure Silk' and the photo to product1.png, and every card carried
                // an invented "99% Match" score that nothing computed.
                var cost = Number(p.wholesale_price || p.price) || 0;
                var mrp = Number(p.retail_price) || 0;
                var estProfit = (cost > 0 && mrp > cost) ? mrp - cost : 0;
                var catName = p.category || '';
                var imgUrl = p.image || '/assets/images/no-image.svg';
                var craft = p.fabric || '';

                return `
                    <article class="ws-rec-card">
                        <div class="ws-rec-img-wrap">
                            <img src="${imgUrl}" alt="${p.name}" class="ws-rec-img" loading="lazy">
                            ${catName ? `<span class="ws-rec-badge-cat">${catName}</span>` : ''}
                        </div>
                        <div class="ws-rec-card-body">
                            <div>
                                <h3 class="ws-rec-card-title" title="${p.name}">${p.name}</h3>
                                ${craft ? `<div class="ws-rec-card-craft">
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="var(--ws-gold-primary)" stroke-width="2"><path d="M20.38 3.46L16 2 12 5.5 8 2l-4.38 1.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"></path></svg>
                                    <span>${craft}</span>
                                </div>` : ''}
                            </div>

                            <div>
                                <div class="ws-rec-pricing-box">
                                    <div>
                                        <div class="ws-rec-cost-label">${cost > 0 ? 'Cost: ₹' + cost.toLocaleString('en-IN') : 'Cost: on request'}</div>
                                        ${mrp > 0 ? `<div class="ws-rec-mrp-val">MRP: ₹${mrp.toLocaleString('en-IN')}</div>` : ''}
                                    </div>
                                    ${estProfit > 0 ? `<div class="ws-rec-margin-box">
                                        <div class="ws-rec-profit-label">Margin</div>
                                        <span class="ws-rec-margin-pill">
                                            +₹${estProfit.toLocaleString('en-IN')}
                                        </span>
                                    </div>` : ''}
                                </div>

                                <div class="ws-rec-actions-row">
                                    <button class="ws-rec-btn-create-order" onclick="openResellerQuickOrderDrawer(${c.id}, ${p.id})" title="Create Order for ${c.name}">
                                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                        <span>Order</span>
                                    </button>
                                    <button class="ws-rec-btn-wa-pitch" onclick="pitchProductToCustomerWhatsApp(${c.id}, ${p.id})" title="Pitch ${p.name} to ${c.name} on WhatsApp" aria-label="Pitch on WhatsApp">
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2z"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </article>
                `;
            }).join('');
        }
        window.generateCustomerRecommendations = generateCustomerRecommendations;

        function pitchProductToCustomerWhatsApp(custId, prodId) {
            var customers = getResellerCustomers();
            var c = customers.find(function(x) { return Number(x.id) === Number(custId); });
            if (!c) return;

            var el = document.getElementById('ws-catalog-data');
            var prods = (window.allProducts && window.allProducts.length > 0) ? window.allProducts : (el ? JSON.parse(el.textContent || '[]') : []);
            var p = prods.find(function(x) { return Number(x.id) === Number(prodId); });

            // Previously: an unknown product became "Exclusive Pure Silk Saree" at
            // Rs 3,499, and a customer with no number on file was messaged at
            // 9876543210 - a real stranger's number.
            if (!p) {
                if (typeof showWsToast === 'function') showWsToast('That product is no longer in the catalogue. Please refresh the page.');
                return;
            }
            var phone = String(c.whatsapp || c.mobile || '').replace(/[^0-9]/g, '');
            if (phone.length === 10) phone = '91' + phone;
            if (phone.length < 10) {
                if (typeof showWsToast === 'function') showWsToast('No WhatsApp number is saved for ' + c.name + '. Add one first.');
                return;
            }

            var pName = p.name || '';
            var pPrice = Number(p.retail_price || p.price) || 0;
            // Signed with the logged-in reseller's own name when there is one. The
            // old message was signed "*Rajesh Kumar* (Reseller Partner)" for
            // everybody, and claimed Silk Mark certification and 24-hr dispatch
            // for every product.
            var senderName = '';
            try {
                var meRaw = localStorage.getItem('dtbrands_user');
                if (meRaw) {
                    var me = JSON.parse(meRaw) || {};
                    senderName = String(me.name || me.full_name || me.business_name || '').trim();
                }
            } catch (e) { senderName = ''; }


            var text = 'Namaste ' + c.name + ' ji 🙏,\n\nI handpicked this piece specially for you:\n\n*' + pName + '*\n';
            if (pPrice > 0) text += '✨ *Price*: ₹' + pPrice.toLocaleString('en-IN') + '\n';
            if (p.fabric) text += '💎 *Fabric*: ' + p.fabric + '\n';
            if (p.color) text += '🎨 *Colour*: ' + p.color + '\n';
            text += '\n' + window.location.origin + '/product.php?id=' + p.id + '\n';
            text += '\nWould you like me to reserve this piece or share the full catalogue?';
            text += '\n\nWarm regards' + (senderName ? ',\n*' + senderName + '*' : '');

            var url = 'https://api.whatsapp.com/send?phone=' + phone + '&text=' + encodeURIComponent(text);
            window.open(url, '_blank');
            if (typeof showWsToast === 'function') {
                showWsToast('📲 Opening WhatsApp pitch for ' + c.name + '...');
            }
        }
        window.pitchProductToCustomerWhatsApp = pitchProductToCustomerWhatsApp;



    




        /* ── CRM Bulk Actions & Modal Controllers ── */
        function toggleCustomerSelect(id, isChecked) {
            if (isChecked) {
                selectedCustomerIds.add(id);
            } else {
                selectedCustomerIds.delete(id);
            }
            updateBulkToolbarState();
        }
        window.toggleCustomerSelect = toggleCustomerSelect;

        function toggleSelectAllCustomers(masterCheckbox) {
            var customers = getResellerCustomers();
            if (masterCheckbox.checked) {
                customers.forEach(function(c) { selectedCustomerIds.add(c.id); });
            } else {
                selectedCustomerIds.clear();
            }
            renderCrmCustomers();
            updateBulkToolbarState();
        }
        window.toggleSelectAllCustomers = toggleSelectAllCustomers;

        function updateBulkToolbarState() {
            var bar = document.getElementById('crmBulkActionBar');
            var countEl = document.getElementById('crmSelectedCount');
            if (countEl) countEl.textContent = selectedCustomerIds.size;
            if (bar) {
                bar.style.display = selectedCustomerIds.size > 0 ? 'flex' : 'none';
            }
        }
        window.updateBulkToolbarState = updateBulkToolbarState;

        function clearCustomerSelection() {
            selectedCustomerIds.clear();
            var master = document.getElementById('crmMasterCheckbox');
            if (master) master.checked = false;
            renderCrmCustomers();
            updateBulkToolbarState();
            showWsToast('Selection cleared.');
        }
        window.clearCustomerSelection = clearCustomerSelection;

        function bulkWhatsAppCustomers() {
            if (selectedCustomerIds.size === 0) {
                showWsToast('Please select at least one customer.');
                return;
            }
            var customers = getResellerCustomers();
            var selected = customers.filter(function(c) { return selectedCustomerIds.has(c.id); });
            var msg = prompt('Enter WhatsApp broadcast message template:', 'Namaste! Check out our latest festive saree catalogue at exclusive reseller discounts: https://jaihanumantex.in/shop.php');
            if (!msg) return;

            var first = selected[0];
            var cleanPhone = first.whatsapp || first.mobile;
            cleanPhone = cleanPhone.replace(/[^0-9]/g, '');
            if (cleanPhone.length === 10) cleanPhone = '91' + cleanPhone;
            window.open('https://api.whatsapp.com/send?phone=' + cleanPhone + '&text=' + encodeURIComponent(msg), '_blank');
            showWsToast('🚀 Opened WhatsApp broadcast for ' + selected.length + ' selected customers!');
        }
        window.bulkWhatsAppCustomers = bulkWhatsAppCustomers;

        function bulkAddTagToCustomers() {
            if (selectedCustomerIds.size === 0) {
                showWsToast('Please select at least one customer.');
                return;
            }
            var tag = prompt('Enter tag name to add (e.g. VIP, FESTIVE, HIGH VALUE, PROMO):', 'PROMO');
            if (!tag) return;
            tag = tag.trim().toUpperCase();
            var customers = getResellerCustomers();
            customers.forEach(function(c) {
                if (selectedCustomerIds.has(c.id)) {
                    if (!c.tags) c.tags = [];
                    if (!c.tags.includes(tag)) c.tags.push(tag);
                }
            });
            saveResellerCustomers(customers);
            showWsToast('🏷️ Added tag "' + tag + '" to ' + selectedCustomerIds.size + ' customers!');
        }
        window.bulkAddTagToCustomers = bulkAddTagToCustomers;

        function exportSelectedCustomersCSV() {
            if (selectedCustomerIds.size === 0) {
                exportCustomersCSV();
                return;
            }
            var customers = getResellerCustomers();
            var selected = customers.filter(function(c) { return selectedCustomerIds.has(c.id); });
            var headers = ["ID", "Name", "Mobile", "WhatsApp", "Email", "City", "State", "Pincode", "Tags", "Total Orders", "Total Purchase (INR)", "Total Profit (INR)"];
            var rows = selected.map(function(c) {
                return [
                    c.id,
                    '"' + (c.name || '').replace(/"/g, '""') + '"',
                    c.mobile || '',
                    c.whatsapp || '',
                    c.email || '',
                    '"' + (c.city || '') + '"',
                    '"' + (c.state || '') + '"',
                    c.pincode || '',
                    '"' + (c.tags || []).join('; ') + '"',
                    c.totalOrders || 0,
                    c.totalPurchase || 0,
                    c.totalProfit || 0
                ];
            });

            var csvContent = "data:text/csv;charset=utf-8," + [headers.join(",")].concat(rows.map(function(e) { return e.join(","); })).join("\n");
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "reseller_selected_customers_" + new Date().toISOString().slice(0,10) + ".csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            showWsToast('📥 Exported ' + selected.length + ' selected customers to CSV!');
        }
        window.exportSelectedCustomersCSV = exportSelectedCustomersCSV;

        /* ── Saved Filters Modals ── */
        function openSavedFiltersModal() {
            var m = document.getElementById('resellerSavedFiltersModal');
            if (m) m.classList.add('active');
        }
        window.openSavedFiltersModal = openSavedFiltersModal;

        function closeSavedFiltersModal() {
            var m = document.getElementById('resellerSavedFiltersModal');
            if (m) m.classList.remove('active');
        }
        window.closeSavedFiltersModal = closeSavedFiltersModal;

        function saveCurrentFilterPreset() {
            var name = prompt('Enter a name for this filter preset:', 'My Custom Filter');
            if (!name) return;
            showWsToast('💾 Saved filter preset: ' + name);
            closeSavedFiltersModal();
        }
        window.saveCurrentFilterPreset = saveCurrentFilterPreset;

        /* ── Order Detail Modal Controller ── */
        function openWsOrderModal(orderId) {
            var modal = document.getElementById('wsOrderDetailsModal') || document.getElementById('resellerOrderModal');
            if (modal) {
                modal.classList.add('active');
            } else {
                showWsToast('📦 Viewing Order Details for #' + orderId);
            }
        }
        window.openWsOrderModal = openWsOrderModal;

        function closeWsOrderModal() {
            var modal = document.getElementById('wsOrderDetailsModal') || document.getElementById('resellerOrderModal');
            if (modal) modal.classList.remove('active');
        }
        window.closeWsOrderModal = closeWsOrderModal;


// ── Global Window Function Safe Exposer ──
(function() {
    var exposedList = [
        'switchWsTab', 'setOverviewFilter', 'switchSalesChartStyle', 'filterByPriceTier',
        'handleWholesalerLogout', 'initResellerApp', 'checkResellerSecurity', 'loginAsDemoReseller',
        'openWsCatalogCategoryModal', 'closeWsCatalogCategoryModal', 'openSmartShareModal', 'closeSmartShareModal',
        'openWalletTopupModal', 'closeWalletTopupModal', 'openEditAddressDrawer', 'closeEditAddressDrawer',
        'selectGstMode', 'toggleSameAsBillingAddress', 'saveGstSettings', 'saveAddressBookSettings',
        'saveProfileSettings', 'updateWholesaleCartBadge', 'updateWholesaleWishlistBadge',
        'animateTargetGauge', 'showWsToast', 'toggleSidebar', 'getResellerCustomers',
        'saveResellerCustomers', 'renderCrmCustomers', 'updateCrmCounts', 'filterCustomersByTag',
        'handleCustomerSearch', 'clearCustomerSearch', 'openCustomerProfileModal', 'closeCustomerProfileModal',
        'switchProfileTab', 'openAddCustomerModal', 'closeAddCustomerModal', 'handleSaveCustomerSubmit',
        'setCustWhatsappSame', 'toggleCustTagChip', 'syncCustTagChips', 'insertCustNotePrompt', 'handleSmartPinAutoFill',
        'handleSmartInputChange', 'clearSmartInput',
        'openResellerQuickOrderDrawer', 'closeResellerQuickOrderDrawer', 'handleQoCustomerSearchInput',
        'handleQoCustomerSearchFocus', 'clearQoCustomerSearch', 'selectQoCustomer', 'resetQoCustomerSelection',
        'handleQoCustomerChange', 'handleQoProductSearchInput', 'handleQoProductSearchFocus',
        'clearQoProductSearch', 'selectQoProduct', 'resetQoProductSelection',
        'handleQoProductChange', 'calculateQoProfit', 'handleQuickOrderSubmit', 'openRepeatOrderModal',
        'closeRepeatOrderModal', 'recalcRepeatOrderTotal', 'handleRepeatOrderConfirm', 'openAddNoteModal',
        'closeAddNoteModal', 'handleSaveNoteSubmit', 'openScheduleFollowupModal', 'closeScheduleFollowupModal',
        'handleSaveFollowupSubmit', 'markFollowupCompleted', 'deleteFollowupTask', 'sendCustomerWhatsAppFollowup',
        'setFollowupDatePreset', 'insertFollowupTaskPrompt', 'filterFollowups', 'handleFollowupSearch', 'clearFollowupSearch',
        'renderDashboardCrmWidgets', 'renderTopCustomersList',
        'switchTopCustomersPeriod', 'handleGlobalSearch', 'sendCustomerWhatsAppMessage', 'exportCustomersCSV',
        'openMobileSearchOverlay', 'closeMobileSearchOverlay', 'handleMobileSearchInput', 'clearMobileGlobalSearch', 'clearGlobalSearch',
        'exportProfitLedgerCSV', 'openResellerNotificationsModal', 'closeResellerNotificationsModal',
        'renderProfitLedger', 'renderFollowupsTable', 'populateRecommendationSelect',
        'generateCustomerRecommendations', 'pitchProductToCustomerWhatsApp', 'convertNumberToIndianWords', 'applyAdvancedOrderFilters',
        'resetAdvancedOrderFilters', 'openSaveFilterModal', 'openSavedFiltersModal', 'closeSavedFiltersModal',
        'saveCurrentFilterPreset', 'renderOrdersView', 'renderReportsView', 'renderTrackingTab',
        'renderTicketsView', 'renderAddressBookData',
        'directAddWholesaleToCart', 'toggleWholesaleWishlist', 'openQuickOrderModal',
        'shareWholesaleProduct', 'shareProductCard', 'openWishlistDrawer'
    ];

    exposedList.forEach(function(name) {
        try {
            var fn = eval('typeof ' + name + ' !== "undefined" ? ' + name + ' : null');
            if (typeof fn === 'function') {
                window[name] = fn;
            }
        } catch(e) {}
    });

    document.addEventListener('click', function(e) {
        var custSearchWrap = document.querySelector('#qoCustSearchRow .ws-qo-search-wrap');
        var custResultsBox = document.getElementById('qoCustomerSearchResults');
        if (custResultsBox && custSearchWrap && !custSearchWrap.contains(e.target)) {
            custResultsBox.style.display = 'none';
        }

        var prodSearchWrap = document.querySelector('#qoProdSearchRow .ws-qo-search-wrap');
        var prodResultsBox = document.getElementById('qoProductSearchResults');
        if (prodResultsBox && prodSearchWrap && !prodSearchWrap.contains(e.target)) {
            prodResultsBox.style.display = 'none';
        }
    });
})();

