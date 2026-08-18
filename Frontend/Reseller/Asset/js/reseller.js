

function updateWholesaleCartBadge() {
    try {
        var raw = localStorage.getItem('kalaniketan_cart');
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
        var raw = localStorage.getItem('kalaniketan_wishlist');
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
                image: '/Frontend/Reseller/Asset/images/product1.png',
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
                image: '/Frontend/Reseller/Asset/images/product2.png',
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
                image: '/Frontend/Reseller/Asset/images/product3.png',
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
                image: '/Frontend/Reseller/Asset/images/product5.png',
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
                image: '/Frontend/Reseller/Asset/images/product6.png',
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
                image: '/Frontend/Reseller/Asset/images/product4.png',
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

                /* ── Toast Helper ── */
        function showWsToast(msg) {
            var container = document.getElementById('wsToastContainer');
            if (!container) return;
            var t = document.createElement('div');
            t.className = 'ws-toast';
            t.innerHTML = '<span>✨</span> ' + msg;
            container.appendChild(t);
            setTimeout(function() {
                t.style.opacity = '0';
                t.style.transform = 'translateY(-10px)';
                setTimeout(function() { t.remove(); }, 300);
            }, 3200);
        }
        window.showWsToast = showWsToast;

        /* ── Role & Authentication Security Gate ── */
        function checkResellerSecurity() {
            var userRaw = localStorage.getItem('kalaniketan_user');
            var gateModal = document.getElementById('wsRoleGateModal');

            if (!userRaw) {
                var demoWholesaler = {
                    name: 'Rajesh Kumar',
                    companyName: 'Shree Krishna Silks Pvt Ltd',
                    phone: '+91 98765 43210',
                    rawPhone: '9876543210',
                    email: 'rajesh@shreekrishnasilks.com',
                    role: 'Reseller',
                    gst_type: 'gst',
                    gst_number: '24AABCU9603R1ZM',
                    address: 'Shop No. 402, 4th Floor, Millennium Textile Market 2, Ring Road',
                    city: 'Surat',
                    state: 'Gujarat',
                    pincode: '395002'
                };
                localStorage.setItem('kalaniketan_user', JSON.stringify(demoWholesaler));
                if (gateModal) gateModal.classList.remove('active');
                return true;
            }

            try {
                var user = JSON.parse(userRaw);
                var role = (user.role || '').toLowerCase();
                
                if (role !== 'reseller') {
                    user.role = 'Reseller';
                    if (!user.companyName) user.companyName = 'Shree Krishna Silks Pvt Ltd';
                    if (!user.gst_number) user.gst_number = '24AABCU9603R1ZM';
                    localStorage.setItem('kalaniketan_user', JSON.stringify(user));
                }

                if (gateModal) gateModal.classList.remove('active');
                return true;
            } catch(e) {
                if (gateModal) gateModal.classList.remove('active');
                return true;
            }
        }

        function loginAsDemoReseller() {
            var demoWholesaler = {
                name: 'Rajesh Kumar',
                companyName: 'Shree Krishna Silks Pvt Ltd',
                phone: '+91 98765 43210',
                rawPhone: '9876543210',
                email: 'rajesh@shreekrishnasilks.com',
                role: 'Reseller',
                gst_type: 'gst',
                gst_number: '24AABCU9603R1ZM',
                address: 'Shop No. 402, 4th Floor, Millennium Textile Market 2, Ring Road',
                city: 'Surat',
                state: 'Gujarat',
                pincode: '395002'
            };
            localStorage.setItem('kalaniketan_user', JSON.stringify(demoWholesaler));
            var gateModal = document.getElementById('wsRoleGateModal');
            if (gateModal) gateModal.classList.remove('active');
            initResellerApp();
            showWsToast('👑 Logged in as Verified Reseller (Rajesh Kumar)!');
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
            var userRaw = localStorage.getItem('kalaniketan_user');
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

        function renderAddressBookData(user) {
            var comp = user.companyName || 'Shree Krishna Silks Pvt Ltd';
            var gstNum = user.gst_number || '24AABCU9603R1ZM';
            var name = user.name || 'Rajesh Kumar';
            var phone = user.phone || '+91 98765 43210';
            var billAddr = user.address || 'Shop No. 402, 4th Floor, Millennium Textile Market 2, Ring Road';
            var billCity = user.city || 'Surat';
            var billState = user.state || 'Gujarat';
            var billPin = user.pincode || '395002';

            var bCompEl = document.getElementById('addrPreviewBillingComp');
            var bFullEl = document.getElementById('addrPreviewBillingFull');
            var bAttnEl = document.getElementById('addrPreviewBillingAttn');
            if (bCompEl) bCompEl.textContent = comp;
            if (bFullEl) bFullEl.innerHTML = `${billAddr}<br>${billCity}, ${billState} - ${billPin} (GSTIN: <strong>${gstNum}</strong>)`;
            if (bAttnEl) bAttnEl.textContent = `Attn: ${name} (${phone})`;

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
            var userRaw = localStorage.getItem('kalaniketan_user');
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

            localStorage.setItem('kalaniketan_user', JSON.stringify(user));
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
                            <img src="${o.image}" alt="${o.productName}" class="ws-prod-mini-img" onerror="this.src='/Frontend/Reseller/Asset/images/product1.png';">
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
                        <img src="${o.image}" alt="${o.productName}" class="ws-mob-order-img" onerror="this.src='/Frontend/Reseller/Asset/images/product1.png';">
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
                            <img src="${o.image}" alt="${o.productName}" class="ws-mob-order-img" onerror="this.src='/Frontend/Reseller/Asset/images/product1.png';">
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
                    sub: "Today's Live Reseller Snapshot & Dispatch Activity",
                    cards: [
                        { label: "B2B Account Tier", val: "Tier 1", pill: "Active", isGold: true },
                        { label: "Today's Orders", val: "1 Lot", pill: "Dispatched", isGold: false },
                        { label: "Today's Quantity", val: "6 Pcs", pill: "100% Packed", isGold: false },
                        { label: "Today's B2B Turnover", val: "₹18,200", pill: "↑ 100%", isGold: true }
                    ],
                    chartTitle: "Today's Hourly Procurement (Units)",
                    barActive: 7,
                    gauge: { pct: "36.4%", offset: 150, badge: "Today", desc: "You generated <strong>₹18,200</strong> in reseller procurement today.", target: "₹50K", rev: "₹18.2K", today: "₹18.2K" },
                    catTitle: WS_ICONS.dress + " Today's Category Breakdown",
                    cats: [
                        { name: "Pure Silk & Zari Sarees (HSN 5007)", val: "₹18,200 (100%)", fill: 100 }
                    ],
                    kpis: [
                        { label: "Today's Order Value", num: "₹18,200", sub: WS_ICONS.lightning + " 1 Consignment" },
                        { label: "Dispatch Status", num: "In Transit", sub: "AWB: 884729104" },
                        { label: "Today's GST Credit", num: "₹910", sub: "5% GST" },
                        { label: "Delivery ETA", num: "Tomorrow", sub: "Priority Air" }
                    ],
                    milestoneBadge: "Tier 1: Non-VIP (Active)",
                    milestoneVal: "Tier 1: Non-VIP Member",
                    milestoneDesc: "Complete <strong>44 more orders</strong> to automatically unlock <strong>Tier 2: Silver</strong> with a extra margin rebate!"
                },
                'week': {
                    sub: "Weekly Procurement Targets, Category Mix & Logistics Performance",
                    cards: [
                        { label: "B2B Account Tier", val: "Tier 1", pill: "1–50 Orders", isGold: true },
                        { label: "Total Orders", val: "6", pill: "↑ 14.20%", isGold: false },
                        { label: "Total Quantity (Units)", val: "48 Pcs", pill: "↑ 8.50%", isGold: false },
                        { label: "Total B2B Turnover", val: "₹2,05,062", pill: "↑ 18.40%", isGold: true }
                    ],
                    chartTitle: "Monthly Sales",
                    barActive: 7,
                    gauge: { pct: "75.55%", offset: 58, badge: "+10%", desc: "You earned <strong>₹32,870</strong> today, it's higher than last month. Keep up your reseller business growth!", target: "₹50K ↓", rev: "₹48.5K ↑", today: "₹18.2K ↑" },
                    catTitle: WS_ICONS.dress + " Category Procurement Breakdown",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹1,14,500 (56%)", fill: 88 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹49,147 (24%)", fill: 72 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹25,825 (13%)", fill: 95 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹15,590 (7%)", fill: 60 }
                    ],
                    kpis: [
                        { label: "Avg. Turnaround Time", num: "1.8 Days", sub: WS_ICONS.lightning + " Fast Dispatch" },
                        { label: "Weekly Dispatch Reliability", num: "99.2%", sub: WS_ICONS.target + " Target Achieved" },
                        { label: "GST Input Tax Credit", num: "₹10,253", sub: WS_ICONS.shield + " 100% Verified" },
                        { label: "Active Consignments", num: "2 Orders", sub: WS_ICONS.repeat + " In Transit" }
                    ],
                    milestoneBadge: "Tier 1: Non-VIP (Active)",
                    milestoneVal: "Tier 1: Non-VIP Member",
                    milestoneDesc: "Complete <strong>44 more orders</strong> to automatically unlock <strong>Tier 2: Silver</strong> with a extra margin rebate!"
                },
                'month': {
                    sub: "Monthly Procurement Targets, Category Mix & Logistics Performance",
                    cards: [
                        { label: "B2B Account Tier", val: "Tier 1", pill: "1–50 Orders", isGold: true },
                        { label: "Total Orders", val: "14", pill: "↑ 21.00%", isGold: false },
                        { label: "Total Quantity (Units)", val: "112 Pcs", pill: "↑ 16.80%", isGold: false },
                        { label: "Total B2B Turnover", val: "₹4,86,500", pill: "↑ 24.10%", isGold: true }
                    ],
                    chartTitle: "August 2026 Procurement Volume",
                    barActive: 7,
                    gauge: { pct: "97.30%", offset: 7, badge: "+18.2%", desc: "Monthly volume tracking ahead of schedule by <strong>+18.2%</strong>!", target: "₹500K", rev: "₹486.5K ↑", today: "₹32.8K ↑" },
                    catTitle: WS_ICONS.dress + " August Category Procurement Breakdown",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹2,72,000 (56%)", fill: 92 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹1,18,500 (24%)", fill: 84 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹62,000 (13%)", fill: 98 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹34,000 (7%)", fill: 75 }
                    ],
                    kpis: [
                        { label: "Avg. Order Value", num: "₹34,750", sub: "↑ 15.1% growth" },
                        { label: "Avg. Turnaround Time", num: "1.6 Days", sub: WS_ICONS.lightning + " VIP Express" },
                        { label: "Monthly GST ITC", num: "₹24,325", sub: WS_ICONS.shield + " 100% Claimed" },
                        { label: "Repeat Order Index", num: "87.5%", sub: WS_ICONS.repeat + " 12 of 14 Lots Reordered" }
                    ],
                    milestoneBadge: "Tier 1: Non-VIP (Active)",
                    milestoneVal: "Tier 1: Non-VIP Member",
                    milestoneDesc: "Complete <strong>36 more orders</strong> to automatically unlock <strong>Tier 2: Silver</strong> with a extra margin rebate!"
                },
                'last_month': {
                    sub: "July 2026 Reconciled Performance & Procurements",
                    cards: [
                        { label: "B2B Account Tier", val: "Tier 1", pill: "Reconciled", isGold: true },
                        { label: "July Orders", val: "11", pill: "Delivered", isGold: false },
                        { label: "July Quantity", val: "88 Pcs", pill: "100% Received", isGold: false },
                        { label: "July Turnover", val: "₹3,92,400", pill: "Settled", isGold: true }
                    ],
                    chartTitle: "July 2026 Final Settlement",
                    barActive: 6,
                    gauge: { pct: "100%", offset: 0, badge: "100% Done", desc: "July target fully achieved and 100% GST reconciled!", target: "₹350K", rev: "₹392.4K", today: "Closed" },
                    catTitle: WS_ICONS.dress + " July 2026 Category Breakdown",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹2,19,000 (56%)", fill: 100 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹94,000 (24%)", fill: 100 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹51,400 (13%)", fill: 100 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹28,000 (7%)", fill: 100 }
                    ],
                    kpis: [
                        { label: "Avg. Order Value", num: "₹35,672", sub: "Final Settled" },
                        { label: "Total Transit TAT", num: "2.1 Days", sub: "100% Delivered" },
                        { label: "Total GST ITC", num: "₹19,620", sub: "Filed in GSTR-3B" },
                        { label: "Reorder Loyalty", num: "90.9%", sub: WS_ICONS.repeat + " 10 of 11 Lots Repeated" }
                    ],
                    milestoneBadge: "Tier 1: Non-VIP (Reconciled)",
                    milestoneVal: "Tier 1: Non-VIP Member",
                    milestoneDesc: "July 2026 orders settled. Complete <strong>44 more orders</strong> to unlock <strong>Tier 2: Silver</strong>!"
                },
                'year': {
                    sub: "Financial Year 2026-27 Comprehensive B2B Turnover",
                    cards: [
                        { label: "B2B Account Tier", val: "Tier 2", pill: "FY26-27", isGold: true },
                        { label: "Annual Orders", val: "58 Lots", pill: "↑ 34.5%", isGold: false },
                        { label: "Annual Quantity", val: "464 Pcs", pill: "↑ 28.2%", isGold: false },
                        { label: "Annual Turnover", val: "₹19,84,300", pill: "↑ 31.8%", isGold: true }
                    ],
                    chartTitle: "FY 2026-27 Monthly Revenue Peak",
                    barActive: 9,
                    gauge: { pct: "79.37%", offset: 48, badge: "+31.8%", desc: "Annual procurement pace on track to exceed ₹25 Lakhs milestone!", target: "₹2.5M", rev: "₹1.98M ↑", today: "Live" },
                    catTitle: WS_ICONS.dress + " FY 2026-27 Cumulative Category Volume",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹11,10,000 (56%)", fill: 82 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹4,76,000 (24%)", fill: 76 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹2,58,000 (13%)", fill: 90 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹1,40,300 (7%)", fill: 68 }
                    ],
                    kpis: [
                        { label: "Annual Avg. Order", num: "₹34,212", sub: "58 Consignments" },
                        { label: "Fastest Delivery", num: "24 Hours", sub: "Air Priority" },
                        { label: "Total FY ITC Claimed", num: "₹99,215", sub: WS_ICONS.shield + " 100% Verified" },
                        { label: "Reseller Retention", num: "89.6%", sub: "Top Tier Reseller" }
                    ],
                    milestoneBadge: "Tier 2: Silver (Active)",
                    milestoneVal: "Tier 2: Silver Member",
                    milestoneDesc: "Complete <strong>192 more orders</strong> to automatically unlock <strong>Tier 3: Gold (250+ Orders)</strong>!"
                }
            },
            'sales': {
                'today': {
                    sub: "Today's Reseller Volume & Unit Procurement (Pcs)",
                    cards: [
                        { label: "Active SKUs Today", val: "1 SKU", pill: "Kanjivaram", isGold: true },
                        { label: "Units Dispatched", val: "6 Pcs", pill: "100% QC Passed", isGold: false },
                        { label: "Pending Packaging", val: "0 Pcs", pill: "Cleared", isGold: false },
                        { label: "Delivery Mode", val: "Air Express", pill: "BlueDart", isGold: true }
                    ],
                    chartTitle: "Today's Unit Dispatch (Pcs)",
                    barActive: 7,
                    gauge: { pct: "100%", offset: 0, badge: "100%", desc: "Today's unit dispatch completed with 100% QC stamp.", target: "6 Pcs", rev: "6 Pcs", today: "6 Pcs" },
                    catTitle: WS_ICONS.dress + " Unit Distribution by Craft (Pcs)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "6 Pcs (100%)", fill: 100 }
                    ],
                    kpis: [
                        { label: "Units Dispatched", num: "6 Pcs", sub: "BlueDart Air" },
                        { label: "QC Inspection", num: "100% Passed", sub: "Zari Hallmarked" },
                        { label: "Lot Packaging", num: "Waterproof Bale", sub: "Tamper Evident" },
                        { label: "Consignment Weight", num: "8.4 Kg", sub: "Air Cargo" }
                    ],
                    milestoneBadge: WS_ICONS.package + " Daily Lot Target",
                    milestoneVal: "6 Pcs <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ 10 Pcs</span>",
                    milestoneDesc: "<strong>60%</strong> of daily packaging capacity fulfilled."
                },
                'week': {
                    sub: "Sales Volume & Procurement Lot Distribution (Units / Pcs)",
                    cards: [
                        { label: "Active Catalog SKUs", val: "6 Live Lots", pill: "Top Trending", isGold: true },
                        { label: "Dispatched Volume", val: "48 Pcs", pill: "↑ 22.5%", isGold: false },
                        { label: "Units In Transit", val: "10 Pcs", pill: "Surat Atelier", isGold: false },
                        { label: "Delivered to Warehouse", val: "38 Pcs", pill: "↑ 18.0%", isGold: true }
                    ],
                    chartTitle: "Weekly Unit Sales (Pcs)",
                    barActive: 7,
                    gauge: { pct: "80.00%", offset: 47, badge: "+15%", desc: "48 reseller units dispatched across 6 distinct craft lots this week.", target: "60 Pcs", rev: "48 Pcs", today: "6 Pcs" },
                    catTitle: WS_ICONS.dress + " Unit Volume Distribution by Category (Pcs)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "26 Pcs (54%)", fill: 86 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "8 Pcs (17%)", fill: 80 },
                        { name: "Royal Anarkali Kurti Sets", val: "10 Pcs (21%)", fill: 100 },
                        { name: "Georgette & Chanderi Fabrics", val: "4 Pcs (8%)", fill: 50 }
                    ],
                    kpis: [
                        { label: "Total Units Dispatched", num: "48 Pcs", sub: "6 Consignments" },
                        { label: "Bale Packaging", num: "100% Sealed", sub: "Moisture Protected" },
                        { label: "Defect Return Rate", num: "0.0%", sub: "Zero Returns" },
                        { label: "Fastest Moving SKU", num: "KLN-SR-003", sub: "Kanjivaram Temple Silk" }
                    ],
                    milestoneBadge: WS_ICONS.package + " Weekly Volume Goal",
                    milestoneVal: "48 Pcs <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ 60 Pcs</span>",
                    milestoneDesc: "<strong>80.0%</strong> of weekly lot volume fulfilled. 12 pcs remaining for weekly bonus lot!"
                },
                'month': {
                    sub: "Monthly Volume & Reseller Lot Distribution (Units / Pcs)",
                    cards: [
                        { label: "Procured Lots", val: "14 Lots", pill: "↑ 28.0%", isGold: true },
                        { label: "Monthly Units Sold", val: "112 Pcs", pill: "↑ 24.5%", isGold: false },
                        { label: "Units In Transit", val: "14 Pcs", pill: "En Route", isGold: false },
                        { label: "Delivered Quantity", val: "98 Pcs", pill: "↑ 26.0%", isGold: true }
                    ],
                    chartTitle: "August Monthly Unit Volume (Pcs)",
                    barActive: 7,
                    gauge: { pct: "93.33%", offset: 16, badge: "+24.5%", desc: "112 total pieces procured in August, setting a new monthly high.", target: "120 Pcs", rev: "112 Pcs", today: "6 Pcs" },
                    catTitle: WS_ICONS.dress + " August Category Units Breakdown (Pcs)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "62 Pcs (55%)", fill: 94 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "18 Pcs (16%)", fill: 90 },
                        { name: "Royal Anarkali Kurti Sets", val: "24 Pcs (22%)", fill: 100 },
                        { name: "Georgette & Chanderi Fabrics", val: "8 Pcs (7%)", fill: 70 }
                    ],
                    kpis: [
                        { label: "Monthly Units Sold", num: "112 Pcs", sub: "↑ 24.5% MoM" },
                        { label: "Avg Lot Size", num: "8 Pcs / Lot", sub: "Optimal MOQ" },
                        { label: "QC Pass Rate", num: "100%", sub: "Surat Atelier" },
                        { label: "Top Fabric", num: "Mulberry Silk", sub: "62 Units" }
                    ],
                    milestoneBadge: WS_ICONS.package + " Monthly Lot Milestone",
                    milestoneVal: "112 Pcs <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ 120 Pcs</span>",
                    milestoneDesc: "<strong>93.3%</strong> of monthly unit target completed."
                },
                'last_month': {
                    sub: "July 2026 Reconciled Reseller Volume (Units / Pcs)",
                    cards: [
                        { label: "July Lots Closed", val: "11 Lots", pill: "Delivered", isGold: true },
                        { label: "Units Fulfilled", val: "88 Pcs", pill: "100% Verified", isGold: false },
                        { label: "Transit Dispatches", val: "11 Bales", pill: "Air Cargo", isGold: false },
                        { label: "Defect Incident", val: "0 Units", pill: "Zero Defect", isGold: true }
                    ],
                    chartTitle: "July Unit Fulfillment (Pcs)",
                    barActive: 6,
                    gauge: { pct: "100%", offset: 0, badge: "100%", desc: "88 pieces delivered with 100% customer acceptance and zero defects.", target: "80 Pcs", rev: "88 Pcs", today: "Done" },
                    catTitle: WS_ICONS.dress + " July Category Units Breakdown (Pcs)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "50 Pcs (57%)", fill: 100 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "14 Pcs (16%)", fill: 100 },
                        { name: "Royal Anarkali Kurti Sets", val: "18 Pcs (20%)", fill: 100 },
                        { name: "Georgette & Chanderi Fabrics", val: "6 Pcs (7%)", fill: 100 }
                    ],
                    kpis: [
                        { label: "July Total Delivered", num: "88 Pcs", sub: "11 Consignments" },
                        { label: "Return Rate", num: "0.0%", sub: "Zero Defects" },
                                                { label: "Payment Settlement", num: "₹18,200", sub: "NEFT Verified" }
                    ],
                    milestoneBadge: WS_ICONS.card + " Daily Revenue Target",
                    milestoneVal: "₹18,200 <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ ₹50,000</span>",
                    milestoneDesc: "<strong>36.4%</strong> of daily financial turnover goal achieved."
                },
                'week': {
                    sub: "Gross B2B Revenue, Tax Invoices & ITC Credit Accrual",
                    cards: [
                        { label: "Gross Taxable Value", val: "₹1,95,297", pill: "5% GST Tier", isGold: true },
                        { label: "Input Tax Credit (ITC)", val: "₹10,253", pill: "100% Matched", isGold: false },
                        { label: "VIP Margin Saved", val: "₹13,500", pill: "Tier 1 Rate", isGold: false },
                        { label: "Total Settled Turnover", val: "₹2,05,062", pill: "Paid In Full", isGold: true }
                    ],
                    chartTitle: "Weekly Invoiced Turnover (₹)",
                    barActive: 7,
                    gauge: { pct: "82.02%", offset: 42, badge: "Verified", desc: "₹10,253 in GST Input Tax Credit reconciled for current tax cycle.", target: "₹250K", rev: "₹205K ↑", today: "₹18.2K ↑" },
                    catTitle: WS_ICONS.dress + " Tax Invoiced Turnover by Category (₹)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹1,14,500 (GST: ₹5,725)", fill: 88 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹49,147 (GST: ₹2,457)", fill: 72 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹25,825 (GST: ₹1,291)", fill: 95 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹15,590 (GST: ₹780)", fill: 60 }
                    ],
                    kpis: [
                        { label: "Gross Taxable Value", num: "₹1,95,297", sub: "5% GST Saree/Fabrics" },
                        { label: "Total GST ITC Accrued", num: "₹10,253", sub: WS_ICONS.shield + " 100% GSTR-1 Verified" },
                        { label: "Reseller Margin Saved", num: "₹13,500", sub: WS_ICONS.crown + " VIP Tier 1 Discount" },
                        { label: "Settlement Status", num: "100% Cleared", sub: "Zero Pending Dues" }
                    ],
                    milestoneBadge: WS_ICONS.crown + " Financial Target",
                    milestoneVal: "₹2,05,062 <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ ₹2,50,000</span>",
                    milestoneDesc: "<strong>82.02%</strong> of your target achieved. Procure <strong>₹44,938</strong> more to unlock <strong>Tier 2 Platinum VIP</strong> with extra 3% margin!"
                },
                'month': {
                    sub: "August 2026 Tax Invoicing & Input Credit Breakdown",
                    cards: [
                        { label: "Monthly Taxable Base", val: "₹4,63,333", pill: "5% GST Base", isGold: true },
                        { label: "Claimable GST ITC", val: "₹23,167", pill: "GSTR-2B Ready", isGold: false },
                        { label: "B2B Margin Saved", val: "₹32,400", pill: "Volume Rebate", isGold: false },
                        { label: "August Settled Total", val: "₹4,86,500", pill: "100% Invoiced", isGold: true }
                    ],
                    chartTitle: "August Gross Invoiced Revenue (₹)",
                    barActive: 7,
                    gauge: { pct: "97.30%", offset: 7, badge: "97.3%", desc: "August gross revenue stands at ₹4,86,500 with ₹24,325 in claimable GST ITC.", target: "₹500K", rev: "₹486.5K", today: "₹32.8K" },
                    catTitle: WS_ICONS.dress + " August Tax Invoiced Breakdown (₹)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹2,72,000 (GST: ₹13,600)", fill: 92 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹1,18,500 (GST: ₹5,925)", fill: 84 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹62,000 (GST: ₹3,100)", fill: 98 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹34,000 (GST: ₹1,700)", fill: 75 }
                    ],
                    kpis: [
                        { label: "Monthly Taxable Value", num: "₹4,63,333", sub: "5% GST Base" },
                        { label: "Monthly GST ITC", num: "₹23,167", sub: WS_ICONS.shield + " Auto E-Way Matched" },
                        { label: "B2B Discount Margin", num: "₹32,400", sub: "VIP Volume Rebate" },
                        { label: "Net Bank Inflow", num: "₹4,86,500", sub: "NEFT & RTGS" }
                    ],
                    milestoneBadge: WS_ICONS.crown + " Monthly Target",
                    milestoneVal: "₹4,86,500 <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ ₹5,00,000</span>",
                    milestoneDesc: "<strong>97.3%</strong> of monthly revenue target achieved. Only ₹13,500 needed to close out target!"
                },
                'last_month': {
                    sub: "July 2026 Settled Invoices & GSTR-3B Tax Filing",
                    cards: [
                        { label: "Audited Taxable Base", val: "₹3,73,714", pill: "Audited", isGold: true },
                        { label: "GST Claimed in 3B", val: "₹18,686", pill: "100% Realized", isGold: false },
                        { label: "July Margin Saved", val: "₹26,800", pill: "Saved on MOQ", isGold: false },
                        { label: "July Gross Settled", val: "₹3,92,400", pill: "Auditor Certified", isGold: true }
                    ],
                    chartTitle: "July Settled Tax Invoices (₹)",
                    barActive: 6,
                    gauge: { pct: "100%", offset: 0, badge: "Audited", desc: "July financial ledger reconciled and filed in GSTR-3B with full ITC clearance.", target: "₹350K", rev: "₹392.4K", today: "Settled" },
                    catTitle: WS_ICONS.dress + " July Tax Invoiced Revenue (₹)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹2,19,000 (GST: ₹10,950)", fill: 100 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹94,000 (GST: ₹4,700)", fill: 100 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹51,400 (GST: ₹2,570)", fill: 100 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹28,000 (GST: ₹1,400)", fill: 100 }
                    ],
                    kpis: [
                        { label: "July Taxable Value", num: "₹3,73,714", sub: "Audited Ledger" },
                        { label: "GST Claimed in 3B", num: "₹18,686", sub: "Full ITC Realized" },
                        { label: "Reseller Margin", num: "₹26,800", sub: "Saved on MOQ" },
                        { label: "Ledger Reconciliation", num: "100% Done", sub: "Auditor Certified" }
                    ],
                    milestoneBadge: WS_ICONS.crown + " Reconciled Target",
                    milestoneVal: "₹3,92,400 <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ ₹3,50,000</span>",
                    milestoneDesc: "<strong>112.1%</strong> of financial target accomplished in July 2026."
                },
                'year': {
                    sub: "Financial Year 2026-27 B2B Revenue & Tax Compliance",
                    cards: [
                        { label: "Annual Taxable Base", val: "₹18,89,810", pill: "58 Tax Invoices", isGold: true },
                        { label: "Total FY ITC Claimed", val: "₹99,215", pill: "100% GSTR-2B", isGold: false },
                        { label: "Volume Discounts", val: "₹1,45,000", pill: "Saved on B2B", isGold: false },
                        { label: "Annual Gross Total", val: "₹19,84,300", pill: "100% Cleared", isGold: true }
                    ],
                    chartTitle: "FY 2026-27 Revenue Growth (₹)",
                    barActive: 9,
                    gauge: { pct: "79.37%", offset: 48, badge: "+31.8%", desc: "₹99,215 total GST Input Tax Credit accumulated across all consignments in FY26-27.", target: "₹2.5M", rev: "₹1.98M", today: "Live" },
                    catTitle: WS_ICONS.dress + " FY 2026-27 Invoiced Category Revenue (₹)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹11,10,000 (GST: ₹55,500)", fill: 82 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹4,76,000 (GST: ₹23,800)", fill: 76 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹2,58,000 (GST: ₹12,900)", fill: 90 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹1,40,300 (GST: ₹7,015)", fill: 68 }
                    ],
                    kpis: [
                        { label: "Total Taxable Sales", num: "₹18,89,810", sub: "58 Tax Invoices" },
                        { label: "Total FY ITC Claimed", num: "₹99,215", sub: WS_ICONS.shield + " 100% GSTR-2B Verified" },
                        { label: "Annual Margin Savings", num: "₹1,45,000", sub: "B2B Volume Rates" },
                        { label: "Payment Discipline", num: "100% On-Time", sub: "Zero Penalty" }
                    ],
                    milestoneBadge: WS_ICONS.crown + " Annual VIP Milestone",
                    milestoneVal: "₹19,84,300 <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ ₹25,00,000</span>",
                    milestoneDesc: "<strong>79.37%</strong> of Annual Target achieved. Procure ₹5,15,700 more to unlock ₹50L Super Reseller Tier!"
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
                            <img src="${o.image}" alt="${o.productName}" class="ws-prod-mini-img" onerror="this.src='/Frontend/Reseller/Asset/images/product1.png';">
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
                        <img src="${o.image}" alt="${o.productName}" class="ws-mob-rep-img" onerror="this.src='/Frontend/Reseller/Asset/images/product1.png';">
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
                var userRaw = localStorage.getItem('kalaniketan_user');
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
            link.setAttribute("download", `Kalaniketan_Wholesale_Report_${new Date().toISOString().slice(0,10)}.csv`);
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
                        <a href="https://api.whatsapp.com/send?phone=919876543210&text=Hi%2C%20following%20up%20on%20Wholesaler%20Ticket%20%23${t.id}" target="_blank" style="color:#25D366; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
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
                    <img src="${o.image}" alt="${o.productName}" style="width:72px; height:90px; border-radius:8px; object-fit:cover; border:1px solid var(--ws-border); flex-shrink:0; background:#FAF8F4;" onerror="this.src='/Frontend/Reseller/Asset/images/product1.png';">
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
                var raw = localStorage.getItem('kalaniketan_cart');
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
                        image: o.image || '/Frontend/Reseller/Asset/images/product1.png',
                        color: o.color || 'Standard',
                        moq: 12
                    });
                }
                localStorage.setItem('kalaniketan_cart', JSON.stringify(cart));
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

            var userRaw = localStorage.getItem('kalaniketan_user');
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
                    ((window.allProducts || []).find(function(p) { return Number(p.id) === Number(prodOrId); }) || { id: prodOrId, name: 'Reseller Item', price: 2199, moq: 12 });
                var raw = localStorage.getItem('kalaniketan_cart');
                var cart = raw ? JSON.parse(raw) : [];
                var prodId = prod.id;
                var exists = cart.find(function(item) { return Number(item.id) === Number(prodId); });
                var addQty = Number(prod.moq) || 12;
                if (exists) {
                    exists.qty = (Number(exists.qty) || addQty) + addQty;
                } else {
                    cart.push({
                        id: prod.id,
                        name: prod.name,
                        price: Number(prod.wholesale_price) || Number(prod.price) || 2199,
                        wholesale_price: Number(prod.wholesale_price) || Number(prod.price) || 2199,
                        retail_price: Number(prod.retail_price) || Number(prod.old_price) || 3299,
                        qty: addQty,
                        image: prod.image || '/Frontend/Reseller/Asset/images/product1.png',
                        color: prod.color || 'Standard',
                        moq: addQty,
                        category: prod.category || 'Reseller'
                    });
                }
                localStorage.setItem('kalaniketan_cart', JSON.stringify(cart));
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
                ((window.allProducts || []).find(function(p) { return Number(p.id) === Number(prodOrId); }) || { id: prodOrId, name: 'Reseller Item', sku: 'SKU-' + prodOrId, hsn: '5007', wholesale_price: 2199, moq: 12 });
            var userRaw = localStorage.getItem('kalaniketan_user');
            var user = userRaw ? JSON.parse(userRaw) : {};
            var company = user.companyName || 'Reseller Buyer';
            var gst = user.gst_number || 'Non-GST';

            var text = `👑 *RESELLER BULK LOT INQUIRY — KALANIKETAN B2B*\n\n` +
                       `*Product:* ${prod.name} (SKU: ${prod.sku || 'SKU-' + prod.id})\n` +
                       `*HSN Code:* ${prod.hsn || '5007'}\n` +
                       `*Reseller B2B Price:* ₹${prod.wholesale_price || prod.price || 2199} / Pc\n` +
                       `*Minimum Order Qty (MOQ):* ${prod.moq || 12} Pcs\n` +
                       `*Lot Tier Pricing:* ${prod.tier_prices || 'Volume Tier'}\n\n` +
                       `*Buyer Business:* ${company}\n` +
                       `*GSTIN:* ${gst}\n` +
                       `*Representative:* ${user.name || 'Member'} (${user.phone || ''})\n\n` +
                       `Please confirm lot availability, dispatch turnaround and proforma payment details.`;

            var waUrl = `https://api.whatsapp.com/send?phone=919876543210&text=${encodeURIComponent(text)}`;
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

            var raw = localStorage.getItem('kalaniketan_wishlist');
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
            localStorage.setItem('kalaniketan_wishlist', JSON.stringify(wish));
        };

        /* ── Share Reseller Lot (Triggers Smart Share or WhatsApp) ── */
        function shareWholesaleProduct(prod) {
            if (typeof window.shareProductCard === 'function' && prod && prod.id) {
                shareProductCard(prod.id);
                return;
            }
            var text = `*KALANIKETAN B2B RESELLER LOT*\n\n` +
                       `*Product:* ${prod.name} (SKU: ${prod.sku})\n` +
                       `*Reseller B2B Price:* ₹${prod.wholesale_price} / Pc (Catalogue MRP: ₹${prod.retail_price})\n` +
                       `*MOQ:* ${prod.moq} Pcs Pack\n` +
                       `*Fabric:* ${prod.fabric || 'Pure Silk'} • HSN: ${prod.hsn}\n` +
                       `*Tier Rates:* ${prod.tier_prices || 'Volume Discounts Available'}\n\n` +
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
                    fabric: p.fabric || 'Pure Silk',
                    colors: Array.isArray(p.colors) ? p.colors.join(', ') : (p.color || ''),
                    sizes: Array.isArray(p.size) ? p.size.join(', ') : 'Free Size',
                    url: '../Single-Product/singleproduct.php?id=' + p.id
                };
                window.openSmartShareModal(itemData);
            } else if (p) {
                var waUrl = 'https://api.whatsapp.com/send?text=' + encodeURIComponent('Check out ' + p.name + ' on Kalaniketan Reseller Hub: ' + window.location.origin + '/../Single-Product/singleproduct.php?id=' + p.id);
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
                localStorage.removeItem('kalaniketan_user');
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
                    <img src="${currentOrder.image}" alt="${currentOrder.productName}" style="width:54px; height:68px; border-radius:6px; object-fit:cover; border:1px solid var(--ws-border); flex-shrink:0; background:#FAF8F4;" onerror="this.src='/Frontend/Reseller/Asset/images/product1.png';">
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
                        <div class="ws-timeline-date">Kalaniketan Head Atelier, Surat • ${currentOrder.date}, 10:30 AM</div>
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
                    <img src="${o.image}" alt="${o.productName}" class="ws-track-order-img" onerror="this.src='/Frontend/Reseller/Asset/images/product1.png';">
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
                var user = JSON.parse(localStorage.getItem('kalaniketan_user') || '{}');
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
                var user = JSON.parse(localStorage.getItem('kalaniketan_user') || '{}');
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
                localStorage.setItem('kalaniketan_user', JSON.stringify(user));
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
                var saved = localStorage.getItem('kalaniketan_wallet_cash');
                if (saved) current = Number(saved);
            } catch(e) {}
            var newBal = current + amount;
            localStorage.setItem('kalaniketan_wallet_cash', newBal);
            
            var cashEl = document.getElementById('walletCashBalance');
            var availEl = document.getElementById('walletAvailableBalance');
            var modalBal = document.getElementById('modalCurrentWalletBal');
            if (cashEl) cashEl.textContent = '₹' + newBal.toLocaleString('en-IN');
            if (availEl) availEl.textContent = (newBal + 100000).toLocaleString('en-IN');
            if (modalBal) modalBal.textContent = '₹' + newBal.toLocaleString('en-IN');

            showWsToast('💳 Wallet recharged with ₹' + amount.toLocaleString('en-IN') + ' successfully!');
        };

        function requestCreditLimitBoost() {
            showWsToast('⚡ Credit Limit Boost Request submitted to Kalaniketan Credit Desk!');
        };

        function requestWalletWithdrawal() {
            showWsToast('🏦 Payout withdrawal request for available balance submitted to registered Bank A/C!');
        };

        /* ── Reseller Cart Badge Synchronization ── */
        function updateWholesaleCartBadge() {
            try {
                var raw = localStorage.getItem('kalaniketan_cart');
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
                var raw = localStorage.getItem('kalaniketan_wishlist');
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
            if (e && e.key === 'kalaniketan_user') {
                initResellerApp();
            }
            if (e && e.key === 'kalaniketan_cart') {
                updateWholesaleCartBadge();
            }
            if (e && e.key === 'kalaniketan_wishlist') {
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

        function renderProfileProductsTab(c) {
            var container = document.getElementById('profProductsList');
            if (!container) return;
            var prods = (window.allProducts || []).slice(0, 4);
            container.innerHTML = prods.map(function(p) {
                return `
                    <div class="ws-product-card" style="padding:10px;">
                        <img src="${p.image}" style="width:100%; height:130px; object-fit:cover; border-radius:6px; margin-bottom:6px;">
                        <div style="font-weight:800; font-size:0.76rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${p.name}</div>
                        <div style="font-size:0.70rem; color:var(--ws-gold-primary); font-weight:700; margin-top:2px;">Purchased 2 Times</div>
                    </div>
                `;
            }).join('');
        };

        function renderProfileRecommendedTab(c) {
            var container = document.getElementById('profRecommendedList');
            if (!container) return;
            var prods = (window.allProducts || []).slice(2, 6);
            container.innerHTML = prods.map(function(p) {
                return `
                    <div class="ws-product-card" style="padding:10px;">
                        <img src="${p.image}" style="width:100%; height:130px; object-fit:cover; border-radius:6px; margin-bottom:6px;">
                        <div style="font-weight:800; font-size:0.76rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${p.name}</div>
                        <div style="font-size:0.78rem; font-weight:900; color:var(--ws-gold-primary); margin-top:2px;">₹${Number(p.wholesale_price || p.price || 2199).toLocaleString('en-IN')}</div>
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

        // 9. Add / Edit Customer Modal
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

            if (modal) modal.classList.add('active');
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
            showWsToast('✅ Customer saved successfully!');
        };

        // 10. Quick Order Flow
        function openResellerQuickOrderDrawer(prefillCustId) {
            var modal = document.getElementById('resellerQuickOrderDrawer');
            var custSelect = document.getElementById('qoCustomerSelect');
            var prodSelect = document.getElementById('qoProductSelect');

            var customers = getResellerCustomers();
            if (custSelect) {
                custSelect.innerHTML = '<option value="">-- Choose Customer --</option>' + customers.map(function(c) {
                    return '<option value="' + c.id + '" ' + (c.id === prefillCustId ? 'selected' : '') + '>' + c.name + ' (' + c.mobile + ' - ' + c.city + ')</option>';
                }).join('');
            }

            var prods = window.allProducts || [];
            if (prodSelect) {
                prodSelect.innerHTML = '<option value="">-- Choose Product --</option>' + prods.map(function(p) {
                    return '<option value="' + p.id + '" data-cost="' + (p.wholesale_price || p.price || 2199) + '" data-mrp="' + (p.retail_price || 3299) + '">' + p.name + ' (Cost: ₹' + (p.wholesale_price || p.price || 2199) + ')</option>';
                }).join('');
            }

            if (prefillCustId) {
                handleQoCustomerChange(prefillCustId);
            }

            if (modal) modal.classList.add('active');
        };

        function closeResellerQuickOrderDrawer() {
            var modal = document.getElementById('resellerQuickOrderDrawer');
            if (modal) modal.classList.remove('active');
        };

        function handleQoCustomerChange(custId) {
            var customers = getResellerCustomers();
            var c = customers.find(function(x) { return Number(x.id) === Number(custId); });
            var addr = document.getElementById('qoShippingAddress');
            if (c && addr) {
                addr.value = c.address + ', ' + c.city + ', ' + c.state + ' - ' + c.pincode;
            }
        };

        function handleQoProductChange(prodId) {
            var select = document.getElementById('qoProductSelect');
            var opt = select.options[select.selectedIndex];
            var cost = opt ? Number(opt.getAttribute('data-cost')) || 2199 : 2199;
            var mrp = opt ? Number(opt.getAttribute('data-mrp')) || 3299 : 3299;

            var costEl = document.getElementById('qoCostPrice');
            var sellEl = document.getElementById('qoSellingPrice');
            if (costEl) costEl.value = cost;
            if (sellEl) sellEl.value = mrp;
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

        // 13. Follow-ups Engine & Dashboard Widget
        function openScheduleFollowupModal(prefillCustId) {
            var modal = document.getElementById('resellerScheduleFollowupModal');
            var custSelect = document.getElementById('followupFormCustomer');
            var dateEl = document.getElementById('followupFormDate');
            var noteEl = document.getElementById('followupFormNote');

            var customers = getResellerCustomers();
            if (custSelect) {
                custSelect.innerHTML = '<option value="">-- Choose Customer --</option>' + customers.map(function(c) {
                    return '<option value="' + c.id + '" ' + (c.id === prefillCustId ? 'selected' : '') + '>' + c.name + ' (' + c.mobile + ')</option>';
                }).join('');
            }

            if (dateEl) {
                var tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                dateEl.value = tomorrow.toISOString().split('T')[0];
            }
            if (noteEl) noteEl.value = '';

            if (modal) modal.classList.add('active');
        };

        function closeScheduleFollowupModal() {
            var modal = document.getElementById('resellerScheduleFollowupModal');
            if (modal) modal.classList.remove('active');
        };

        function handleSaveFollowupSubmit() {
            var custId = Number(document.getElementById('followupFormCustomer').value);
            var date = document.getElementById('followupFormDate').value;
            var time = document.getElementById('followupFormTime').value;
            var note = document.getElementById('followupFormNote').value.trim();
            var status = document.getElementById('followupFormStatus').value;

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
            showWsToast('⏰ Follow-up task scheduled!');
        };

        function markFollowupCompleted(custId, fId) {
            var customers = getResellerCustomers();
            var c = customers.find(function(x) { return x.id === custId; });
            if (c && c.followups) {
                var f = c.followups.find(function(x) { return x.id === fId; });
                if (f) f.status = 'Completed';
                saveResellerCustomers(customers);
                showWsToast('✅ Follow-up marked as completed!');
            }
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

        // 15. Global Live Search (Customers, Orders, Products)
        function handleGlobalSearch(query) {
            var q = (query || '').trim().toLowerCase();
            var resultsBox = document.getElementById('wsGlobalSearchResults');
            if (!resultsBox) return;

            if (!q) {
                resultsBox.style.display = 'none';
                resultsBox.innerHTML = '';
                return;
            }

            var customers = getResellerCustomers().filter(function(c) {
                return c.name.toLowerCase().indexOf(q) !== -1 || c.mobile.indexOf(q) !== -1;
            });

            var orders = (window.allOrders || []).filter(function(o) {
                return o.orderId.toLowerCase().indexOf(q) !== -1 || o.productName.toLowerCase().indexOf(q) !== -1;
            });

            var prods = (window.allProducts || []).filter(function(p) {
                return p.name.toLowerCase().indexOf(q) !== -1;
            });

            var html = '';

            if (customers.length > 0) {
                html += '<div class="ws-search-group-title">👥 Customers</div>';
                customers.slice(0, 3).forEach(function(c) {
                    html += `
                        <div class="ws-search-item" onclick="openCustomerProfileModal(${c.id}); document.getElementById('wsGlobalSearchResults').style.display='none';">
                            <div>
                                <div class="ws-search-item-title">${c.name}</div>
                                <div class="ws-search-item-sub">📞 ${c.mobile} &bull; 📍 ${c.city}</div>
                            </div>
                            <span class="crm-tag crm-tag-vip">Profile →</span>
                        </div>
                    `;
                });
            }

            if (orders.length > 0) {
                html += '<div class="ws-search-group-title">📦 Orders</div>';
                orders.slice(0, 3).forEach(function(o) {
                    html += `
                        <div class="ws-search-item" onclick="openWsOrderModal('${o.orderId}'); document.getElementById('wsGlobalSearchResults').style.display='none';">
                            <div>
                                <div class="ws-search-item-title">${o.orderId} - ${o.productName}</div>
                                <div class="ws-search-item-sub">Status: ${o.status} &bull; Total: ₹${o.total}</div>
                            </div>
                            <span style="font-size:0.70rem; font-weight:800; color:var(--ws-gold-primary);">View →</span>
                        </div>
                    `;
                });
            }

            if (prods.length > 0) {
                html += '<div class="ws-search-group-title">👗 Catalog Products</div>';
                prods.slice(0, 3).forEach(function(p) {
                    html += `
                        <div class="ws-search-item" onclick="openResellerQuickOrderDrawer(); document.getElementById('wsGlobalSearchResults').style.display='none';">
                            <div>
                                <div class="ws-search-item-title">${p.name}</div>
                                <div class="ws-search-item-sub">₹${p.wholesale_price || p.price} &bull; ${p.category}</div>
                            </div>
                            <span style="font-size:0.70rem; font-weight:800; color:#047857;">Order →</span>
                        </div>
                    `;
                });
            }

            if (!html) {
                html = '<div style="padding:12px; font-size:0.75rem; color:var(--ws-text-muted); text-align:center;">No matching results found.</div>';
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

We have exciting new luxury silk saree collections and festive arrivals at Kalaniketan / Arniya.

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

    
                /* ── Profit Ledger Renderer ── */
        function renderProfitLedger() {
            var tbody = document.getElementById('crmProfitTbody');
            var mobList = document.getElementById('crmProfitMobileList');
            if (!tbody) return;

            var profitData = [
                { id: '#ORD-77492', cust: 'Ananya Deshmukh', prod: 'Paithani Silk Saree (Qty: 1)', sell: 18200, cost: 14000, profit: 4200, margin: '23.08%', status: 'Delivered', date: '2026-08-12' },
                { id: '#ORD-77450', cust: 'Pooja Varma', prod: 'Bridal Velvet Lehenga (Qty: 1)', sell: 24800, cost: 19000, profit: 5800, margin: '23.38%', status: 'Delivered', date: '2026-08-05' },
                { id: '#ORD-77412', cust: 'Kavita Singhania', prod: 'Banarasi Zari Saree (Qty: 2)', sell: 16998, cost: 12998, profit: 4000, margin: '23.53%', status: 'Delivered', date: '2026-08-01' },
                { id: '#ORD-77388', cust: 'Priyanka Reddy', prod: 'Kanjivaram Temple Silk (Qty: 1)', sell: 14999, cost: 11499, profit: 3500, margin: '23.33%', status: 'Delivered', date: '2026-07-28' },
                { id: '#ORD-77350', cust: 'Sneha Patel', prod: 'Royal Anarkali Kurti (Qty: 3)', sell: 9900, cost: 7500, profit: 2400, margin: '24.24%', status: 'Delivered', date: '2026-07-20' },
                { id: '#ORD-77510', cust: 'Ritu Aggarwal', prod: 'Georgette Bloom Saree (Qty: 1)', sell: 4200, cost: 3200, profit: 1000, margin: '23.81%', status: 'In Transit', date: '2026-08-15' }
            ];

            // 1. Desktop Table
            tbody.innerHTML = profitData.map(function(item) {
                var isDel = item.status === 'Delivered';
                var statusCls = isDel ? 'background:#DCFCE7; color:#15803D; border:1px solid #86EFAC;' : 'background:#FEF3C7; color:#B45309; border:1px solid #FCD34D;';
                return `
                    <tr>
                        <td style="white-space:nowrap; font-weight:800; color:var(--ws-gold-primary);">${item.id}</td>
                        <td style="white-space:nowrap; font-weight:700; color:var(--ws-text-main);">${item.cust}</td>
                        <td style="font-weight:600;">${item.prod}</td>
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
                            <div style="font-size:0.74rem; color:var(--ws-text-muted); margin-bottom:8px;">${item.prod} &bull; 📅 ${item.date}</div>
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

        /* ── Follow-ups Table Renderer ── */
        var currentFollowupFilter = 'all';
        function filterFollowups(filter, btn) {
            currentFollowupFilter = filter;
            var pills = document.querySelectorAll('#followupFilterPills .ws-filter-pill');
            pills.forEach(function(p) { p.classList.remove('active'); });
            if (btn) btn.classList.add('active');
            renderFollowupsTable();
        };

        function renderFollowupsTable() {
            var tbody = document.getElementById('crmFollowupsTbody');
            if (!tbody) return;

            var customers = getResellerCustomers();
            var allFollowups = [];
            customers.forEach(function(c) {
                (c.followups || []).forEach(function(f) {
                    allFollowups.push({ customer: c, task: f });
                });
            });

            var filtered = allFollowups.filter(function(item) {
                if (currentFollowupFilter === 'pending') return item.task.status === 'Pending';
                if (currentFollowupFilter === 'completed') return item.task.status === 'Completed';
                if (currentFollowupFilter === 'today') return item.task.date === new Date().toISOString().split('T')[0];
                return true;
            });

            if (filtered.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding:30px; color:var(--ws-text-muted);">No follow-ups found for this filter.</td></tr>';
                return;
            }

            tbody.innerHTML = filtered.map(function(item) {
                var isCompleted = item.task.status === 'Completed';
                var statusTag = isCompleted ? '<span class="crm-tag crm-tag-repeat">Completed</span>' : '<span class="crm-tag crm-tag-followup">Pending</span>';
                return `
                    <tr>
                        <td>
                            <div style="font-weight:800; font-size:0.82rem;">📅 ${item.task.date}</div>
                            <div style="font-size:0.70rem; color:var(--ws-text-muted);">Time: ${item.task.time || '11:00 AM'}</div>
                        </td>
                        <td>
                            <div style="font-weight:800; font-size:0.84rem; cursor:pointer;" onclick="openCustomerProfileModal(${item.customer.id})">
                                ${item.customer.name}
                            </div>
                        </td>
                        <td>
                            <div style="font-size:0.76rem;">📞 ${item.customer.mobile}</div>
                        </td>
                        <td>
                            <div style="font-size:0.80rem; font-weight:600; color:var(--ws-text-main);">${item.task.note}</div>
                        </td>
                        <td style="text-align:center;">${statusTag}</td>
                        <td style="text-align:center;">
                            <div style="display:flex; gap:6px; justify-content:center;">
                                <button class="ws-btn ws-btn-sm" onclick="sendCustomerWhatsAppMessage(${item.customer.id})" style="background:#25D366; color:#FFF; padding:3px 8px; font-size:0.70rem;">💬 Chat</button>
                                ${!isCompleted ? `<button class="ws-btn ws-btn-secondary ws-btn-sm" onclick="markFollowupCompleted(${item.customer.id}, ${item.task.id})" style="padding:3px 8px; font-size:0.70rem;">✅ Done</button>` : ''}
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        };

        /* ── Recommendations Center Renderer ── */
                /* ── Tailored Recommendation Engine ── */
        function populateRecommendationSelect() {
            var select = document.getElementById('recommendationCustomerSelect');
            if (!select) return;
            var customers = getResellerCustomers();
            select.innerHTML = '<option value="">-- Choose Customer --</option>' + customers.map(function(c) {
                return '<option value="' + c.id + '">' + c.name + ' (' + c.city + ' - ' + (c.tags || []).join(', ') + ')</option>';
            }).join('');
            if (customers.length > 0) {
                select.value = customers[0].id;
                generateCustomerRecommendations(customers[0].id);
            }
        }
        window.populateRecommendationSelect = populateRecommendationSelect;

        function generateCustomerRecommendations(custId) {
            var grid = document.getElementById('recommendationsProductGrid');
            if (!grid) return;

            var customers = getResellerCustomers();
            var c = customers.find(function(x) { return Number(x.id) === Number(custId); }) || customers[0];
            
            var el = document.getElementById('ws-catalog-data');
            var prods = (window.allProducts && window.allProducts.length > 0) ? window.allProducts : (el ? JSON.parse(el.textContent || '[]') : []);
            
            if (prods.length === 0) {
                prods = [
                    { id: 101, name: "Kanjivaram Pure Zari Bridal Silk Saree", category: "Bridal Silk", wholesale_price: 3499, retail_price: 5999, image: '/Frontend/Reseller/Asset/images/product1.png' },
                    { id: 102, name: "Banarasi Tanchoi Brocade Saree", category: "Banarasi", wholesale_price: 2899, retail_price: 4999, image: '/Frontend/Reseller/Asset/images/product2.png' },
                    { id: 103, name: "Paithani Handloom Peacock Pallu Saree", category: "Paithani", wholesale_price: 4200, retail_price: 6999, image: '/Frontend/Reseller/Asset/images/product3.png' },
                    { id: 104, name: "Chanderi Cotton Silk Floral Saree", category: "Chanderi", wholesale_price: 1850, retail_price: 3200, image: '/Frontend/Reseller/Asset/images/product4.png' },
                    { id: 105, name: "Mysore Crepe Silk Festive Saree", category: "Mysore Silk", wholesale_price: 2450, retail_price: 4199, image: '/Frontend/Reseller/Asset/images/product1.png' },
                    { id: 106, name: "Tussar Ghicha Embroidered Silk Saree", category: "Tussar Silk", wholesale_price: 3100, retail_price: 5299, image: '/Frontend/Reseller/Asset/images/product2.png' }
                ];
            }

            if (!c) {
                grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:30px; color:var(--ws-text-muted);">Please select a customer to view recommendations.</div>';
                return;
            }

            grid.innerHTML = prods.slice(0, 6).map(function(p) {
                var cost = p.wholesale_price || p.price || 2199;
                var mrp = p.retail_price || 3499;
                var estProfit = mrp - cost;
                return `
                    <article class="ws-product-card" style="padding:14px; background:#FFFFFF; border:1.5px solid #E8D9B5; border-radius:14px; box-shadow:0 4px 14px rgba(0,0,0,0.03); transition:all 0.2s ease;">
                        <img src="${p.image || '/Frontend/Reseller/Asset/images/product1.png'}" alt="${p.name}" style="width:100%; height:160px; object-fit:cover; border-radius:10px; margin-bottom:10px;">
                        <div class="card-title" style="font-weight:800; font-size:0.86rem; color:#2C251E; margin-bottom:4px; line-height:1.3;">${p.name}</div>
                        <div style="font-size:0.72rem; color:#8C8072; margin-bottom:8px;">Category: <strong>${p.category || 'Silk Saree'}</strong></div>
                        <div style="display:flex; justify-content:space-between; align-items:center; background:#FAF6EE; border:1px solid #EAE0C8; padding:8px 10px; border-radius:8px; margin-bottom:10px;">
                            <div>
                                <div style="font-size:0.68rem; color:#8C8072;">Cost: ₹${cost.toLocaleString('en-IN')}</div>
                                <div style="font-weight:900; font-size:0.88rem; color:#8A681F;">MRP: ₹${mrp.toLocaleString('en-IN')}</div>
                            </div>
                            <div style="text-align:right;">
                                <div style="font-size:0.68rem; color:#047857; font-weight:700;">Est. Margin</div>
                                <div style="font-weight:900; font-size:0.88rem; color:#047857;">+₹${estProfit.toLocaleString('en-IN')}</div>
                            </div>
                        </div>
                        <div style="display:flex; gap:6px;">
                            <button class="ws-btn ws-btn-primary ws-btn-sm" style="flex:1; justify-content:center;" onclick="openResellerQuickOrderDrawer(${c.id})">
                                ⚡ Create Order
                            </button>
                            <button class="crm-btn-wa" onclick="sendCustomerWhatsAppMessage(${c.id})" title="Pitch to Customer on WhatsApp">
                                💬
                            </button>
                        </div>
                    </article>
                `;
            }).join('');
        }
        window.generateCustomerRecommendations = generateCustomerRecommendations;



    




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
        'openResellerQuickOrderDrawer', 'closeResellerQuickOrderDrawer', 'handleQoCustomerChange',
        'handleQoProductChange', 'calculateQoProfit', 'handleQuickOrderSubmit', 'openRepeatOrderModal',
        'closeRepeatOrderModal', 'recalcRepeatOrderTotal', 'handleRepeatOrderConfirm', 'openAddNoteModal',
        'closeAddNoteModal', 'handleSaveNoteSubmit', 'openScheduleFollowupModal', 'closeScheduleFollowupModal',
        'handleSaveFollowupSubmit', 'markFollowupCompleted', 'renderDashboardCrmWidgets', 'renderTopCustomersList',
        'switchTopCustomersPeriod', 'handleGlobalSearch', 'sendCustomerWhatsAppMessage', 'exportCustomersCSV',
        'exportProfitLedgerCSV', 'openResellerNotificationsModal', 'closeResellerNotificationsModal',
        'renderProfitLedger', 'renderFollowupsTable', 'populateRecommendationSelect',
        'generateCustomerRecommendations', 'convertNumberToIndianWords', 'applyAdvancedOrderFilters',
        'resetAdvancedOrderFilters', 'openSaveFilterModal', 'openSavedFiltersModal', 'closeSavedFiltersModal',
        'saveCurrentFilterPreset', 'renderOrdersView', 'renderReportsView', 'renderTrackingTab',
        'renderTicketsView', 'renderAddressBookData'
    ];

    exposedList.forEach(function(name) {
        try {
            var fn = eval('typeof ' + name + ' !== "undefined" ? ' + name + ' : null');
            if (typeof fn === 'function') {
                window[name] = fn;
            }
        } catch(e) {}
    });
})();

