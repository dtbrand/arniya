/**
 * admin.js — Luxury Executive Admin Dashboard & WhatsApp CRM Engine
 * DT Brand's & Jai Hanuman Tex
 */

(function() {
    'use strict';

    // ════ SAMPLE STATE & DATASETS ════
    let products = [
        {
            id: 111,
            sku: 'KLN-SR-111',
            hsn: '5007',
            name: 'Pure Dola Silk Meenakari Saree',
            category: 'Sarees',
            retail_price: 3499,
            wholesale_price: 1399,
            reseller_price: 1599,
            moq: 8,
            stock: 95,
            image: '/Frontend/Shop/Asset/images/product2.png',
            badge: 'New Catalogue',
            color: 'Crimson Rani',
            fabric: 'Dola Silk',
            status: 'In Stock'
        },
        {
            id: 109,
            sku: 'KLN-KT-109',
            hsn: '6204',
            name: 'Party Festive Sharara Suit Set',
            category: 'Kurtis',
            retail_price: 2699,
            wholesale_price: 989,
            reseller_price: 1199,
            moq: 8,
            stock: 125,
            image: '/Frontend/Shop/Asset/images/product5.png',
            badge: 'New Arrival',
            color: 'Teal Blue',
            fabric: 'Chanderi Gotapatti',
            status: 'In Stock'
        },
        {
            id: 110,
            sku: 'KLN-SR-110',
            hsn: '5007',
            name: 'Paithani Rich Pallu Saree',
            category: 'Sarees',
            retail_price: 3199,
            wholesale_price: 1249,
            reseller_price: 1449,
            moq: 8,
            stock: 110,
            image: '/Frontend/Shop/Asset/images/product1.png',
            badge: 'New Catalogue',
            color: 'Bottle Green',
            fabric: 'Art Silk Peacock Pallu',
            status: 'In Stock'
        },
        {
            id: 106,
            sku: 'KLN-SR-106',
            hsn: '5007',
            name: 'Chanderi Silk Festive Saree',
            category: 'Sarees',
            retail_price: 1599,
            wholesale_price: 649,
            reseller_price: 799,
            moq: 12,
            stock: 190,
            image: '/Frontend/Shop/Asset/images/product1.png',
            badge: 'Festive Hot',
            color: 'Peacock Green',
            fabric: 'Chanderi Zari',
            status: 'In Stock'
        },
        {
            id: 6,
            sku: 'KLN-LH-006',
            hsn: '6204',
            name: 'Bridal Zardosi Lehenga Set',
            category: 'Lehengas',
            retail_price: 24999,
            wholesale_price: 16499,
            reseller_price: 18999,
            moq: 2,
            stock: 35,
            image: '/Frontend/Shop/Asset/images/product6.png',
            badge: 'Bridal Couture',
            color: 'Crimson Red',
            fabric: 'Micro Velvet & Zari',
            status: 'In Stock'
        },
        {
            id: 104,
            sku: 'KLN-KT-104',
            hsn: '6204',
            name: 'Chikan Embroidered Rayon Kurti',
            category: 'Kurtis',
            retail_price: 999,
            wholesale_price: 399,
            reseller_price: 499,
            moq: 18,
            stock: 8,
            image: '/Frontend/Shop/Asset/images/product6.png',
            badge: 'Low Stock',
            color: 'Pastel Mint',
            fabric: 'Lakhnavi Handwork',
            status: 'Low Stock'
        },
        {
            id: 114,
            sku: 'KLN-GW-114',
            hsn: '6204',
            name: 'Indo-Western Embroidered Gown',
            category: 'Gowns',
            retail_price: 4599,
            wholesale_price: 1999,
            reseller_price: 2299,
            moq: 6,
            stock: 65,
            image: '/Frontend/Shop/Asset/images/product6.png',
            badge: 'New Catalogue',
            color: 'Wine Burgundy',
            fabric: 'Silk Velvet Zari',
            status: 'In Stock'
        },
        {
            id: 116,
            sku: 'KLN-DM-116',
            hsn: '5208',
            name: 'Pure Cotton Unstitched Suit Lot',
            category: 'Dress Materials',
            retail_price: 1499,
            wholesale_price: 599,
            reseller_price: 749,
            moq: 12,
            stock: 180,
            image: '/Frontend/Shop/Asset/images/product8.png',
            badge: 'New Arrival',
            color: 'Pastel Sky',
            fabric: '60x60 Cambric Cotton',
            status: 'In Stock'
        }
    ];

    let orders = [
        {
            id: 'ORD-9842',
            date: 'Today, 04:30 PM',
            customer: 'Ananya Sharma',
            phone: '9876543210',
            city: 'Mumbai, MH',
            channel: 'B2C Shop',
            items: 'Nilambari Silk Saree (Qty: 1)',
            total: 4899,
            payment: 'Prepaid (UPI)',
            status: 'In Transit',
            tracking: 'DELHIVERY: DL789234901'
        },
        {
            id: 'ORD-9841',
            date: 'Today, 02:15 PM',
            customer: 'Vardhman Textiles (Rajesh K.)',
            phone: '9822019283',
            city: 'Surat, GJ',
            channel: 'Wholesale B2B',
            items: 'Pure Dola Silk Lot (Qty: 24 pcs)',
            total: 33576,
            payment: 'Bank Wire / RTGS',
            status: 'Packed',
            tracking: 'TCI FREIGHT: TCI-66291'
        },
        {
            id: 'ORD-9840',
            date: 'Today, 11:45 AM',
            customer: 'Pooja Varma (Reseller #RS-402)',
            phone: '9711823901',
            city: 'Jaipur, RJ',
            channel: 'Reseller',
            items: 'Chikan Rayon Kurti (Qty: 3)',
            total: 2997,
            payment: 'COD',
            status: 'Confirmed',
            tracking: 'Pending Dispatch'
        },
        {
            id: 'ORD-9839',
            date: 'Yesterday, 06:10 PM',
            customer: 'Meera Boutique',
            phone: '9920194820',
            city: 'Bengaluru, KA',
            channel: 'Retailer',
            items: 'Bridal Zardosi Lehenga (Qty: 2)',
            total: 32998,
            payment: 'Credit (Net 15)',
            status: 'Delivered',
            tracking: 'BLUEDART: BD992018273'
        },
        {
            id: 'ORD-9838',
            date: 'Yesterday, 03:20 PM',
            customer: 'Sneha Patel',
            phone: '9428019283',
            city: 'Ahmedabad, GJ',
            channel: 'B2C Shop',
            items: 'Georgette Bloom Saree (Qty: 1)',
            total: 3299,
            payment: 'Prepaid (Card)',
            status: 'Delivered',
            tracking: 'DELHIVERY: DL782019283'
        }
    ];

    let partners = [
        {
            id: 'WS-101',
            name: 'Rajesh Kumar (Vardhman Tex)',
            phone: '9822019283',
            type: 'Wholesaler',
            tier: 'Tier 1 (Diamond)',
            gst: '24AAACR4920M1Z2',
            orders_count: 18,
            total_spend: '₹4,85,200',
            kyc: 'Verified'
        },
        {
            id: 'RS-402',
            name: 'Pooja Varma (Pooja Collection)',
            phone: '9711823901',
            type: 'Reseller',
            tier: 'Gold Reseller',
            gst: 'Unregistered (Individual)',
            orders_count: 42,
            total_spend: '₹1,24,600',
            kyc: 'Verified'
        },
        {
            id: 'WS-104',
            name: 'Sunil Aggarwal (Radha Silks)',
            phone: '9810293847',
            type: 'Wholesaler',
            tier: 'Tier 2 (Gold)',
            gst: '07AAACR1122K1Z9',
            orders_count: 6,
            total_spend: '₹1,42,000',
            kyc: 'Pending KYC'
        },
        {
            id: 'RT-209',
            name: 'Meera Singhania (Meera Boutique)',
            phone: '9920194820',
            type: 'Retailer',
            tier: 'VIP Retailer',
            gst: '29AAACR3920L1Z4',
            orders_count: 14,
            total_spend: '₹3,60,000',
            kyc: 'Verified'
        }
    ];

    let waLeads = [
        {
            name: 'Kavita Joshi',
            phone: '9820198273',
            inquiry: 'Interested in Paithani Rich Pallu Saree wholesale batch (20 pcs)',
            time: '5m ago',
            tag: 'Wholesale Lead'
        },
        {
            name: 'Amitabh Textiles',
            phone: '9930198201',
            inquiry: 'Need GST invoice download for Consignment #ORD-9841',
            time: '24m ago',
            tag: 'Order Support'
        },
        {
            name: 'Simran Sethi (Reseller)',
            phone: '9711823944',
            inquiry: 'How to calculate 25% margin in smart share catalog links?',
            time: '1h ago',
            tag: 'Reseller Help'
        },
        {
            name: 'Ritu Chawla',
            phone: '9811029381',
            inquiry: 'Is the Crimson Red Bridal Lehenga available in Free Size?',
            time: '2h ago',
            tag: 'Product Inquiry'
        }
    ];

    // ════ INITIALIZATION ════
    document.addEventListener('DOMContentLoaded', function() {
        initSidebar();
        initTabs();
        initCharts();
        renderProductsTable();
        renderOrdersTable();
        renderPartnersTable();
        renderWhatsAppLeads();
        initSearchInputs();
        initBroadcaster();
        renderKPISparklines();
        initLiveTickers();
    });

    function renderKPISparklines() {
        const sparkContainers = document.querySelectorAll('.adm-kpi-sparkline');
        sparkContainers.forEach(function(el) {
            const isUp = el.getAttribute('data-trend') === 'up';
            const color = isUp ? '#16A34A' : '#DC2626';
            const points = isUp 
                ? '0,18 10,14 20,16 30,10 40,12 50,6 60,4' 
                : '0,4 10,8 20,6 30,12 40,10 50,16 60,18';

            el.innerHTML = '<svg viewBox="0 0 60 22" width="60" height="22">' +
                '<polyline points="' + points + '" fill="none" stroke="' + color + '" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>' +
                '</svg>';
        });
    }

    function initLiveTickers() {
        const liveUsersEl = document.getElementById('liveUsersCount');
        if (liveUsersEl) {
            setInterval(function() {
                const current = parseInt(liveUsersEl.innerText.replace(/,/g, ''), 10) || 142;
                const change = Math.floor(Math.random() * 5) - 2;
                const updated = Math.max(90, current + change);
                liveUsersEl.innerText = updated.toLocaleString();
            }, 4000);
        }
    }

    // ════ SIDEBAR TOGGLE ════
    function initSidebar() {
        const sidebar = document.getElementById('admSidebar');
        const toggleBtn = document.getElementById('admSidebarToggleBtn');
        const mobileToggle = document.getElementById('admMobileMenuBtn');
        const backdrop = document.getElementById('admSidebarBackdrop');

        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
            });
        }

        const sealMini = document.querySelector('.adm-brand-seal-mini');
        if (sealMini && sidebar) {
            sealMini.addEventListener('click', function(e) {
                if (sidebar.classList.contains('collapsed')) {
                    e.preventDefault();
                    e.stopPropagation();
                    sidebar.classList.remove('collapsed');
                }
            });
        }

        if (mobileToggle && sidebar) {
            mobileToggle.addEventListener('click', function() {
                sidebar.classList.toggle('mobile-open');
                if (backdrop) backdrop.style.display = sidebar.classList.contains('mobile-open') ? 'block' : 'none';
            });
        }

        if (backdrop) {
            backdrop.addEventListener('click', function() {
                if (sidebar) sidebar.classList.remove('mobile-open');
                backdrop.style.display = 'none';
            });
        }
    }

    // ════ SIDEBAR SUBMENU ACCORDION ════
    window.toggleSidebarSubmenu = function(el) {
        const parentLi = el.closest('.adm-nav-has-sub');
        if (parentLi) {
            parentLi.classList.toggle('open');
        }
    };

    // ════ TAB ROUTING ════
    window.switchAdmTab = function(tabId) {
        const tabs = document.querySelectorAll('.adm-tab-panel');
        const navItems = document.querySelectorAll('.adm-nav-item');
        const subnavItems = document.querySelectorAll('.adm-subnav-item');

        tabs.forEach(tab => tab.classList.remove('active'));
        navItems.forEach(item => item.classList.remove('active'));
        subnavItems.forEach(item => item.classList.remove('active'));

        const targetTab = document.getElementById('tab-' + tabId);
        const targetNav = document.getElementById('navItem-' + tabId);
        const targetSubnav = document.getElementById('subnav-' + tabId);

        if (targetTab) targetTab.classList.add('active');
        if (targetNav) targetNav.classList.add('active');
        if (targetSubnav) targetSubnav.classList.add('active');

        // Close mobile sidebar if open
        const sidebar = document.getElementById('admSidebar');
        const backdrop = document.getElementById('admSidebarBackdrop');
        if (sidebar) sidebar.classList.remove('mobile-open');
        if (backdrop) backdrop.style.display = 'none';

        // Re-render chart if switching to overview
        if (tabId === 'overview') {
            setTimeout(renderRevenueChart, 50);
        }

        // Scroll to top smoothly
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    function initTabs() {
        // Support hash URL like #orders, #products
        const hash = window.location.hash.replace('#', '');
        if (hash && document.getElementById('tab-' + hash)) {
            window.switchAdmTab(hash);
        }
    }

    // ════ SEARCH INPUTS & 1-TAP CLEAR BUTTON ENGINE (STRICT RULE) ════
    function initSearchInputs() {
        const searchConfigs = [
            { inputId: 'admGlobalSearch', clearId: 'admGlobalSearchClear', handler: handleGlobalSearch },
            { inputId: 'admProdSearch', clearId: 'admProdSearchClear', handler: filterProducts },
            { inputId: 'admOrderSearch', clearId: 'admOrderSearchClear', handler: filterOrders },
            { inputId: 'admPartnerSearch', clearId: 'admPartnerSearchClear', handler: filterPartners },
            { inputId: 'admCustomerSearch', clearId: 'admCustomerSearchClear', handler: filterCustomers }
        ];

        searchConfigs.forEach(cfg => {
            const input = document.getElementById(cfg.inputId);
            const clearBtn = document.getElementById(cfg.clearId);

            if (input) {
                input.addEventListener('input', function() {
                    if (clearBtn) {
                        clearBtn.style.display = this.value.trim() ? 'flex' : 'none';
                    }
                    if (typeof cfg.handler === 'function') cfg.handler(this.value.trim());
                });

                if (clearBtn) {
                    clearBtn.addEventListener('click', function() {
                        input.value = '';
                        clearBtn.style.display = 'none';
                        input.focus();
                        if (typeof cfg.handler === 'function') cfg.handler('');
                    });
                }
            }
        });
    }

    function handleGlobalSearch(query) {
        if (!query) return;
        const q = query.toLowerCase();
        // Check if matching order or product or customer
        const foundOrder = orders.find(o => o.id.toLowerCase().includes(q) || o.customer.toLowerCase().includes(q));
        if (foundOrder) {
            window.switchAdmTab('orders');
            const searchBox = document.getElementById('admOrderSearch');
            if (searchBox) { searchBox.value = query; filterOrders(query); }
            return;
        }
        const foundProd = products.find(p => p.name.toLowerCase().includes(q) || p.sku.toLowerCase().includes(q));
        if (foundProd) {
            window.switchAdmTab('products');
            const searchBox = document.getElementById('admProdSearch');
            if (searchBox) { searchBox.value = query; filterProducts(query); }
        }
    }

    // ════ HIGH-DEFINITION DYNAMIC RESPONSIVE CANVAS CHARTS ════
    function initCharts() {
        renderRevenueChart();
        renderCategoryDoughnut();
    }

    // Auto resize listener with debouncing
    let chartResizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(chartResizeTimer);
        chartResizeTimer = setTimeout(initCharts, 120);
    });

    function renderRevenueChart() {
        const canvas = document.getElementById('admRevenueChart');
        if (!canvas) return;
        const parent = canvas.parentElement;
        const containerWidth = parent.clientWidth || parent.getBoundingClientRect().width || 320;
        const ctx = canvas.getContext('2d');
        
        // Crisp Retina scaling
        const dpr = window.devicePixelRatio || 1;
        const w = containerWidth;
        const h = 240;
        canvas.width = w * dpr;
        canvas.height = h * dpr;
        canvas.style.width = w + 'px';
        canvas.style.height = h + 'px';
        ctx.scale(dpr, dpr);

        const padL = w < 480 ? 36 : 46;
        const padR = w < 480 ? 12 : 20;
        const padT = 24;
        const padB = 34;

        ctx.clearRect(0, 0, w, h);

        const labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        const b2bData = [45000, 58000, 72000, 68000, 94000, 115000, 142000];
        const b2cData = [24000, 31000, 28000, 39000, 48000, 62000, 78000];

        const maxVal = 160000;

        // Draw horizontal grid lines
        ctx.strokeStyle = '#EBE7DE';
        ctx.lineWidth = 1;
        ctx.fillStyle = '#8C8478';
        ctx.font = '10px Plus Jakarta Sans, sans-serif';
        ctx.textAlign = 'right';

        for (let i = 0; i <= 4; i++) {
            const yVal = (maxVal / 4) * i;
            const yPos = h - padB - ((h - padT - padB) * (yVal / maxVal));
            ctx.beginPath();
            ctx.moveTo(padL, yPos);
            ctx.lineTo(w - padR, yPos);
            ctx.stroke();
            ctx.fillText('₹' + (yVal / 1000) + 'k', padL - 6, yPos + 3);
        }

        // Draw labels on X axis
        ctx.textAlign = 'center';
        const stepX = (w - padL - padR) / (labels.length - 1);
        labels.forEach((lbl, i) => {
            const x = padL + (i * stepX);
            ctx.fillText(lbl, x, h - padB + 16);
        });

        // Function to draw smooth line curve with area fill
        function drawCurve(data, strokeColor, fillGradient, dotColor) {
            ctx.beginPath();
            const points = data.map((val, i) => {
                const x = padL + (i * stepX);
                const y = h - padB - ((h - padT - padB) * (val / maxVal));
                return { x, y };
            });

            ctx.moveTo(points[0].x, points[0].y);
            for (let i = 0; i < points.length - 1; i++) {
                const xc = (points[i].x + points[i + 1].x) / 2;
                const yc = (points[i].y + points[i + 1].y) / 2;
                ctx.quadraticCurveTo(points[i].x, points[i].y, xc, yc);
            }
            ctx.lineTo(points[points.length - 1].x, points[points.length - 1].y);

            // Stroke
            ctx.strokeStyle = strokeColor;
            ctx.lineWidth = 2.8;
            ctx.stroke();

            // Fill area
            ctx.lineTo(points[points.length - 1].x, h - padB);
            ctx.lineTo(points[0].x, h - padB);
            ctx.closePath();
            ctx.fillStyle = fillGradient;
            ctx.fill();

            // Draw points
            points.forEach(p => {
                ctx.beginPath();
                ctx.arc(p.x, p.y, 3.8, 0, Math.PI * 2);
                ctx.fillStyle = dotColor;
                ctx.fill();
                ctx.lineWidth = 2;
                ctx.strokeStyle = '#FFFFFF';
                ctx.stroke();
            });
        }

        // B2B Gold Curve
        const gradGold = ctx.createLinearGradient(0, padT, 0, h - padB);
        gradGold.addColorStop(0, 'rgba(138, 104, 31, 0.28)');
        gradGold.addColorStop(1, 'rgba(138, 104, 31, 0.01)');
        drawCurve(b2bData, '#8A681F', gradGold, '#8A681F');

        // B2C Green Curve
        const gradGreen = ctx.createLinearGradient(0, padT, 0, h - padB);
        gradGreen.addColorStop(0, 'rgba(37, 211, 102, 0.22)');
        gradGreen.addColorStop(1, 'rgba(37, 211, 102, 0.01)');
        drawCurve(b2cData, '#15803D', gradGreen, '#15803D');
    }

    function renderCategoryDoughnut() {
        const canvas = document.getElementById('admCategoryChart');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        const dpr = window.devicePixelRatio || 1;
        const size = 180;
        canvas.width = size * dpr;
        canvas.height = size * dpr;
        canvas.style.width = size + 'px';
        canvas.style.height = size + 'px';
        ctx.scale(dpr, dpr);

        const cx = size / 2, cy = size / 2, outerR = (size / 2) - 8, innerR = outerR - 26;
        const catData = [
            { label: 'Sarees', share: 0.45, color: '#8A681F' },
            { label: 'Kurtis', share: 0.25, color: '#C5A859' },
            { label: 'Lehengas', share: 0.18, color: '#100E0C' },
            { label: 'Dress Mat.', share: 0.12, color: '#15803D' }
        ];

        let startAngle = -Math.PI / 2;

        catData.forEach(seg => {
            const endAngle = startAngle + (seg.share * Math.PI * 2);
            ctx.beginPath();
            ctx.arc(cx, cy, outerR, startAngle, endAngle);
            ctx.arc(cx, cy, innerR, endAngle, startAngle, true);
            ctx.closePath();
            ctx.fillStyle = seg.color;
            ctx.fill();
            startAngle = endAngle;
        });

        // Center total text
        ctx.fillStyle = '#181512';
        ctx.font = 'bold 15px Cinzel, serif';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText('100%', cx, cy - 5);
        ctx.font = '9.5px Plus Jakarta Sans, sans-serif';
        ctx.fillStyle = '#7A7266';
        ctx.fillText('Product Share', cx, cy + 11);
    }

    // ════ PRODUCT CATALOG RENDERING & CRUD ════
    function renderProductsTable(filteredList) {
        const list = filteredList || products;
        const tbody = document.getElementById('admProductsTableBody');
        if (!tbody) return;

        if (list.length === 0) {
            tbody.innerHTML = `<tr><td colspan="11" style="text-align:center; padding:30px; color:#8C8478;">No products found matching the criteria.</td></tr>`;
            return;
        }

        tbody.innerHTML = list.map(p => {
            const badgeClass = p.status === 'In Stock' ? 'success' : (p.status === 'Low Stock' ? 'warning' : 'danger');
            const brand = p.brand || (p.category === 'Silk Sarees' || p.category === 'Sarees' ? 'DT Signature' : (p.category === 'Lehengas' ? 'DT Couture' : 'Arniya Heritage'));
            const variants = p.variants || (p.color ? `Color: ${p.color}` : '3 Colors');
            const resellerPrice = p.reseller_price || Math.round(p.retail_price * 0.77);
            const rating = p.rating || '5.0 ★';

            return `
                <tr>
                    <td style="text-align:center;">
                        <input type="checkbox" class="dt-prod-row-check" onchange="if(typeof window.handleRowSelect==='function') window.handleRowSelect();" style="cursor:pointer;">
                    </td>
                    <td>
                        <div class="adm-table-prod-cell">
                            <img src="${p.image}" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" alt="${p.name}" class="adm-prod-thumb">
                            <div class="adm-prod-meta">
                                <a href="/Frontend/Admin/products/view.php?id=${p.id}" class="adm-prod-title" style="color:#181512; text-decoration:none; font-weight:700;">${p.name}</a>
                                <span class="adm-prod-sub">SKU: ${p.sku} | HSN: ${p.hsn} | Fabric: ${p.fabric}</span>
                            </div>
                        </div>
                    </td>
                    <td><strong>${p.category}</strong></td>
                    <td><span style="font-size:0.75rem; color:#8A681F; font-weight:700;">${brand}</span></td>
                    <td><span style="background:#FAF5E8; padding:2px 6px; border-radius:4px; font-size:0.72rem; font-weight:700; color:#5A4210;">${variants}</span></td>
                    <td>
                        <div style="display:flex; flex-direction:column; gap:2px;">
                            <span style="font-weight:700; color:#181512;">₹${p.retail_price.toLocaleString('en-IN')} (Retail)</span>
                            <span style="font-size:0.72rem; color:#7E22CE; font-weight:700;">₹${resellerPrice.toLocaleString('en-IN')} (Reseller)</span>
                            <span style="font-size:0.72rem; color:#8A681F; font-weight:700;">₹${p.wholesale_price.toLocaleString('en-IN')} (Wholesale)</span>
                        </div>
                    </td>
                    <td><span style="font-weight:700; background:#FAF5E8; color:#8A681F; padding:2px 8px; border-radius:6px; border:1px solid rgba(212,175,55,0.3);">${p.moq} pcs</span></td>
                    <td><strong>${p.stock} units</strong></td>
                    <td><span style="color:#F59E0B; font-weight:800;">${rating}</span> <small style="color:#7A7266;">(128)</small></td>
                    <td><span class="adm-badge ${badgeClass}">${p.status}</span></td>
                    <td>
                        <div class="adm-action-btn-group">
                            <a href="/Frontend/Admin/products/view.php?id=${p.id}" class="adm-action-btn" title="View Details">👁️</a>
                            <a href="/Frontend/Admin/products/edit.php?id=${p.id}" class="adm-action-btn" title="Edit">✏️</a>
                            <a href="/Frontend/Admin/products/duplicate.php?id=${p.id}" class="adm-action-btn" title="Duplicate">📋</a>
                            <button type="button" class="adm-action-btn wa" title="Share via WhatsApp" onclick="window.shareProductWhatsApp(${p.id})">💬</button>
                            <button type="button" class="adm-action-btn danger" title="Delete Product" onclick="window.deleteProduct(${p.id})">🗑️</button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
    }

    function filterProducts(query) {
        const catFilter = document.getElementById('admProdCatFilter') ? document.getElementById('admProdCatFilter').value : 'all';
        const brandFilter = document.getElementById('admProdBrandFilter') ? document.getElementById('admProdBrandFilter').value : 'all';
        const stockFilter = document.getElementById('admProdStockFilter') ? document.getElementById('admProdStockFilter').value : 'all';
        const q = (query || (document.getElementById('admProdSearch') ? document.getElementById('admProdSearch').value : '')).toLowerCase();

        const filtered = products.filter(p => {
            const brand = p.brand || (p.category === 'Silk Sarees' || p.category === 'Sarees' ? 'DT Signature' : (p.category === 'Lehengas' ? 'DT Couture' : 'Arniya Heritage'));
            const matchesQuery = !q || p.name.toLowerCase().includes(q) || p.sku.toLowerCase().includes(q) || p.category.toLowerCase().includes(q) || (p.fabric && p.fabric.toLowerCase().includes(q));
            const matchesCat = catFilter === 'all' || p.category.toLowerCase().includes(catFilter.toLowerCase());
            const matchesBrand = brandFilter === 'all' || brand.toLowerCase().includes(brandFilter.toLowerCase());
            const matchesStock = stockFilter === 'all' || p.status.toLowerCase().replace(' ', '') === stockFilter.toLowerCase().replace(' ', '');
            return matchesQuery && matchesCat && matchesBrand && matchesStock;
        });

        renderProductsTable(filtered);
    }

    window.filterProducts = filterProducts;

    // ════ ORDERS MANAGEMENT & WHATSAPP DISPATCH ════
    function renderOrdersTable(filteredList) {
        const list = filteredList || orders;
        const tbody = document.getElementById('admOrdersTableBody');
        if (!tbody) return;

        if (list.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" style="text-align:center; padding:30px; color:#8C8478;">No orders found matching criteria.</td></tr>`;
            return;
        }

        tbody.innerHTML = list.map(o => {
            const statusClass = o.status === 'Delivered' ? 'success' : (o.status === 'In Transit' || o.status === 'Packed' ? 'info' : (o.status === 'Confirmed' ? 'gold' : 'warning'));
            return `
                <tr>
                    <td>
                        <div style="display:flex; flex-direction:column; gap:2px;">
                            <strong style="color:#181512; font-size:0.86rem;">${o.id}</strong>
                            <span style="font-size:0.7rem; color:#8C8478;">${o.date}</span>
                        </div>
                    </td>
                    <td>
                        <div style="display:flex; flex-direction:column; gap:2px;">
                            <strong>${o.customer}</strong>
                            <span style="font-size:0.72rem; color:#8A681F;">+91 ${o.phone} • ${o.city}</span>
                        </div>
                    </td>
                    <td><span style="font-weight:700; font-size:0.75rem; background:#F8F6F0; padding:3px 8px; border-radius:6px; border:1px solid #E5E1D7;">${o.channel}</span></td>
                    <td><span style="font-size:0.8rem; color:#3B352E;">${o.items}</span></td>
                    <td><strong>₹${o.total.toLocaleString('en-IN')}</strong> <br><span style="font-size:0.68rem; color:#15803D;">${o.payment}</span></td>
                    <td><span class="adm-badge ${statusClass}">${o.status}</span></td>
                    <td>
                        <div class="adm-action-btn-group">
                            <button class="adm-action-btn wa" title="Send WhatsApp Status Alert" onclick="window.sendOrderWhatsApp('${o.id}')">
                                <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            </button>
                            <button class="adm-action-btn" title="View & Print GST Invoice" onclick="window.openInvoiceModal('${o.id}')">
                                <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
    }

    function filterOrders(query) {
        const channel = document.getElementById('admOrderChannelFilter') ? document.getElementById('admOrderChannelFilter').value : 'all';
        const status = document.getElementById('admOrderStatusFilter') ? document.getElementById('admOrderStatusFilter').value : 'all';
        const q = (query || (document.getElementById('admOrderSearch') ? document.getElementById('admOrderSearch').value : '')).toLowerCase();

        const filtered = orders.filter(o => {
            const matchesQuery = !q || o.id.toLowerCase().includes(q) || o.customer.toLowerCase().includes(q) || o.phone.includes(q);
            const matchesChannel = channel === 'all' || o.channel.toLowerCase().includes(channel.toLowerCase());
            const matchesStatus = status === 'all' || o.status.toLowerCase().replace(' ', '') === status.toLowerCase().replace(' ', '');
            return matchesQuery && matchesChannel && matchesStatus;
        });

        renderOrdersTable(filtered);
    }

    window.filterOrders = filterOrders;

    // ════ PARTNERS & WHOLESALER KYC RENDERING ════
    function renderPartnersTable(filteredList) {
        const list = filteredList || partners;
        const tbody = document.getElementById('admPartnersTableBody');
        if (!tbody) return;

        tbody.innerHTML = list.map(p => {
            const kycClass = p.kyc === 'Verified' ? 'success' : 'warning';
            return `
                <tr>
                    <td><strong>${p.id}</strong></td>
                    <td>
                        <div style="display:flex; flex-direction:column; gap:2px;">
                            <strong style="color:#181512;">${p.name}</strong>
                            <span style="font-size:0.72rem; color:#8A681F;">+91 ${p.phone}</span>
                        </div>
                    </td>
                    <td><span style="font-weight:700; color:#181512;">${p.type}</span></td>
                    <td><span style="background:#FAF5E8; color:#8A681F; padding:2px 8px; border-radius:6px; font-weight:700; border:1px solid rgba(212,175,55,0.3);">${p.tier}</span></td>
                    <td><code style="font-size:0.75rem; background:#F2EFE8; padding:2px 6px; border-radius:4px;">${p.gst}</code></td>
                    <td><strong>${p.total_spend}</strong> (${p.orders_count} orders)</td>
                    <td><span class="adm-badge ${kycClass}">${p.kyc}</span></td>
                    <td>
                        <div class="adm-action-btn-group">
                            <button class="adm-action-btn wa" title="Chat on WhatsApp" onclick="window.openDirectWhatsApp('${p.phone}', 'Hello ${p.name}, regarding your DT Brand partner account...')">
                                <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            </button>
                            ${p.kyc === 'Pending KYC' ? `<button class="adm-action-btn" title="Approve KYC" style="color:#15803D;" onclick="window.approveKYC('${p.id}')">✓</button>` : ''}
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
    }

    function filterPartners(query) {
        const q = (query || (document.getElementById('admPartnerSearch') ? document.getElementById('admPartnerSearch').value : '')).toLowerCase();
        const filtered = partners.filter(p => !q || p.name.toLowerCase().includes(q) || p.phone.includes(q) || p.id.toLowerCase().includes(q) || p.type.toLowerCase().includes(q));
        renderPartnersTable(filtered);
    }
    window.filterPartners = filterPartners;

    function filterCustomers(query) {
        // Customer directory filter
        const q = (query || '').toLowerCase();
        const rows = document.querySelectorAll('#admCustomersTableBody tr');
        rows.forEach(r => {
            const text = r.textContent.toLowerCase();
            r.style.display = !q || text.includes(q) ? '' : 'none';
        });
    }
    window.filterCustomers = filterCustomers;

    // ════ WHATSAPP CRM LEADS & BROADCASTER ════
    function renderWhatsAppLeads() {
        const container = document.getElementById('admWaLeadsList');
        if (!container) return;

        container.innerHTML = waLeads.map(lead => {
            const initial = lead.name.charAt(0);
            return `
                <div class="adm-wa-lead-item" onclick="window.openDirectWhatsApp('${lead.phone}', 'Hello ${lead.name}, regarding your inquiry with DT Brand...')">
                    <div class="adm-wa-lead-left">
                        <div class="adm-wa-avatar">${initial}</div>
                        <div class="adm-wa-lead-meta">
                            <span class="adm-wa-lead-name">${lead.name} <small style="color:#8A681F;">+91 ${lead.phone}</small></span>
                            <span class="adm-wa-lead-inquiry">${lead.inquiry}</span>
                        </div>
                    </div>
                    <div style="display:flex; flex-direction:column; align-items:flex-end; gap:4px;">
                        <span class="adm-badge gold" style="font-size:0.64rem;">${lead.tag}</span>
                        <span style="font-size:0.68rem; color:#8C8478;">${lead.time}</span>
                    </div>
                </div>
            `;
        }).join('');
    }

    function initBroadcaster() {
        const templateSelect = document.getElementById('admBroadcastTemplate');
        const audienceSelect = document.getElementById('admBroadcastAudience');
        const msgTextarea = document.getElementById('admBroadcastMessage');
        const previewBox = document.getElementById('admBroadcastPreview');

        const templates = {
            'catalogue': "✨ *DT BRAND'S LUXURY ETHNIC FRESH CATALOGUE* ✨\n\nDear {Name},\nExplore our latest 2026 Pure Silk Sarees & Designer Lehengas crafted for premium festive collections.\n\n👉 *View & Order Online:* https://jaihanumantex.in/Frontend/Shop/shop.php\n\n_Special 15% VIP Discount Applied!_",
            'festive': "🔥 *EXCLUSIVE FESTIVE BONANZA — 40% OFF* 🔥\n\nNamaste {Name},\nStock up your boutique with high-margin Silk Sarees & Sharara Suits before wedding season rush.\n\n📦 *Wholesale MOQ:* Only 8 pcs\n🚚 *Dispatch:* 24 Hours Express",
            'wholesale_drop': "💎 *WHOLESALE BULK LOT PRICE DROP ALERT* 💎\n\nDear Partner,\nPrices on Chanderi & Dola Silk lots reduced by up to ₹250/pc for 30+ pc lots.\n\n📲 Reply YES to receive full PDF Catalogue with HSN codes."
        };

        if (templateSelect && msgTextarea && previewBox) {
            templateSelect.addEventListener('change', function() {
                const key = this.value;
                if (templates[key]) {
                    msgTextarea.value = templates[key];
                    updatePreview();
                }
            });

            msgTextarea.addEventListener('input', updatePreview);

            function updatePreview() {
                let text = msgTextarea.value || '';
                text = text.replace('{Name}', 'Rajesh Kumar');
                previewBox.innerHTML = text.replace(/\n/g, '<br>').replace(/\*(.*?)\*/g, '<strong>$1</strong>').replace(/_(.*?)_/g, '<em>$1</em>');
            }
        }
    }

    // ════ MODALS & POPUPS ════
    window.openAddProductModal = function() {
        document.getElementById('admProductModalTitle').textContent = 'Add New Ethnic Product';
        document.getElementById('admProductId').value = '';
        document.getElementById('admProductName').value = '';
        document.getElementById('admProductSku').value = 'KLN-SR-' + Math.floor(100 + Math.random() * 900);
        document.getElementById('admProductHsn').value = '5007';
        document.getElementById('admProductCategory').value = 'Sarees';
        document.getElementById('admProductRetailPrice').value = '';
        document.getElementById('admProductWholesalePrice').value = '';
        document.getElementById('admProductMoq').value = '8';
        document.getElementById('admProductStock').value = '50';
        document.getElementById('admProductFabric').value = 'Pure Silk';
        document.getElementById('admProductStatus').value = 'In Stock';

        document.getElementById('admProductModal').classList.add('open');
    };

    window.openEditProductModal = function(id) {
        const prod = products.find(p => p.id === id);
        if (!prod) return;

        document.getElementById('admProductModalTitle').textContent = 'Edit Product — ' + prod.name;
        document.getElementById('admProductId').value = prod.id;
        document.getElementById('admProductName').value = prod.name;
        document.getElementById('admProductSku').value = prod.sku;
        document.getElementById('admProductHsn').value = prod.hsn;
        document.getElementById('admProductCategory').value = prod.category;
        document.getElementById('admProductRetailPrice').value = prod.retail_price;
        document.getElementById('admProductWholesalePrice').value = prod.wholesale_price;
        document.getElementById('admProductMoq').value = prod.moq;
        document.getElementById('admProductStock').value = prod.stock;
        document.getElementById('admProductFabric').value = prod.fabric;
        document.getElementById('admProductStatus').value = prod.status;

        document.getElementById('admProductModal').classList.add('open');
    };

    window.closeAdmModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.remove('open');
    };

    window.saveProductForm = function(e) {
        e.preventDefault();
        const id = document.getElementById('admProductId').value;
        const name = document.getElementById('admProductName').value.trim();
        const sku = document.getElementById('admProductSku').value.trim();
        const hsn = document.getElementById('admProductHsn').value.trim();
        const category = document.getElementById('admProductCategory').value;
        const retail = parseInt(document.getElementById('admProductRetailPrice').value, 10) || 0;
        const wholesale = parseInt(document.getElementById('admProductWholesalePrice').value, 10) || 0;
        const moq = parseInt(document.getElementById('admProductMoq').value, 10) || 8;
        const stock = parseInt(document.getElementById('admProductStock').value, 10) || 0;
        const fabric = document.getElementById('admProductFabric').value.trim();
        const status = document.getElementById('admProductStatus').value;

        if (id) {
            // Update
            const p = products.find(prod => prod.id == id);
            if (p) {
                p.name = name;
                p.sku = sku;
                p.hsn = hsn;
                p.category = category;
                p.retail_price = retail;
                p.wholesale_price = wholesale;
                p.moq = moq;
                p.stock = stock;
                p.fabric = fabric;
                p.status = status;
                window.showToast('Product updated successfully: ' + name);
            }
        } else {
            // Create
            const newProd = {
                id: Date.now(),
                sku: sku,
                hsn: hsn,
                name: name,
                category: category,
                retail_price: retail,
                wholesale_price: wholesale,
                reseller_price: wholesale + 200,
                moq: moq,
                stock: stock,
                image: '/Frontend/Shop/Asset/images/product1.png',
                badge: 'New Arrival',
                color: 'Assorted',
                fabric: fabric,
                status: status
            };
            products.unshift(newProd);
            window.showToast('New product added to catalog: ' + name);
        }

        closeAdmModal('admProductModal');
        renderProductsTable();
    };

    window.deleteProduct = function(id) {
        if (confirm('Are you sure you want to remove this product from the catalog?')) {
            products = products.filter(p => p.id !== id);
            renderProductsTable();
            window.showToast('Product removed from catalog.');
        }
    };

    window.approveKYC = function(partnerId) {
        const partner = partners.find(p => p.id === partnerId);
        if (partner) {
            partner.kyc = 'Verified';
            renderPartnersTable();
            window.showToast(`Partner KYC Approved for ${partner.name}!`);
        }
    };

    // ════ WHATSAPP ACTIONS ════
    window.openDirectWhatsApp = function(phone, msg) {
        const cleanPhone = phone.replace(/[^0-9]/g, '');
        const encoded = encodeURIComponent(msg || 'Hello from DT Brand Admin');
        window.open(`https://wa.me/91${cleanPhone}?text=${encoded}`, '_blank');
    };

    window.sendOrderWhatsApp = function(orderId) {
        const order = orders.find(o => o.id === orderId);
        if (!order) return;

        const msg = `*DT BRAND'S ORDER UPDATE — ${order.id}*\n\nNamaste ${order.customer},\nYour order for *${order.items}* (Total: ₹${order.total.toLocaleString('en-IN')}) is now *${order.status}*.\n\n📦 *Tracking:* ${order.tracking}\n\nThank you for choosing DT Brand's Heritage Luxury.`;
        window.openDirectWhatsApp(order.phone, msg);
    };

    window.shareProductWhatsApp = function(id) {
        const prod = products.find(p => p.id === id);
        if (!prod) return;

        const msg = `*DT BRAND'S ETHNIC COLLECTION*\n\n*${prod.name}* (SKU: ${prod.sku})\n💎 Category: ${prod.category} | Fabric: ${prod.fabric}\n💰 Retail: ₹${prod.retail_price} | Wholesale MOQ (${prod.moq} pcs): ₹${prod.wholesale_price}/pc\n\n👉 View Online: https://jaihanumantex.in/Frontend/Shop/shop.php`;
        const encoded = encodeURIComponent(msg);
        window.open(`https://wa.me/?text=${encoded}`, '_blank');
    };

    window.launchBroadcast = function() {
        const template = document.getElementById('admBroadcastTemplate').value;
        const count = document.getElementById('admBroadcastAudience').value === 'all' ? '1,420' : '285';
        window.showToast(`🚀 WhatsApp Broadcast initiated to ${count} recipients!`);
    };

    // ════ INVOICE MODAL ════
    window.openInvoiceModal = function(orderId) {
        const order = orders.find(o => o.id === orderId);
        if (!order) return;

        document.getElementById('invOrderNumber').textContent = order.id;
        document.getElementById('invOrderDate').textContent = order.date;
        document.getElementById('invCustomerName').textContent = order.customer;
        document.getElementById('invCustomerPhone').textContent = '+91 ' + order.phone;
        document.getElementById('invCustomerCity').textContent = order.city;
        document.getElementById('invItemDesc').textContent = order.items;
        document.getElementById('invItemTotal').textContent = '₹' + order.total.toLocaleString('en-IN');
        document.getElementById('invGrandTotal').textContent = '₹' + order.total.toLocaleString('en-IN');

        document.getElementById('admInvoiceModal').classList.add('open');
    };

    // ════ EXPORT TO CSV ════
    window.exportTableToCSV = function(type) {
        let csv = '';
        let filename = `${type}_report_${Date.now()}.csv`;

        if (type === 'products') {
            csv = 'ID,SKU,Name,Category,RetailPrice,WholesalePrice,MOQ,Stock,Status\n';
            products.forEach(p => {
                csv += `"${p.id}","${p.sku}","${p.name}","${p.category}",${p.retail_price},${p.wholesale_price},${p.moq},${p.stock},"${p.status}"\n`;
            });
        } else if (type === 'orders') {
            csv = 'OrderID,Date,Customer,Phone,Channel,Items,Total,Payment,Status,Tracking\n';
            orders.forEach(o => {
                csv += `"${o.id}","${o.date}","${o.customer}","${o.phone}","${o.channel}","${o.items}",${o.total},"${o.payment}","${o.status}","${o.tracking}"\n`;
            });
        }

        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = filename;
        link.click();
        window.showToast(`Exported ${filename} successfully!`);
    };

    // ════ UNIVERSAL MODULE TABLE FILTER & SEARCH ════
    window.filterModuleTable = function(query, type) {
        const table = document.querySelector('.adm-table') || document.getElementById('moduleDataTable');
        if (!table) return;
        const rows = table.querySelectorAll('tbody tr');
        const q = (query || '').toLowerCase().trim();

        rows.forEach(row => {
            if (q === 'all' || !q) {
                row.style.display = '';
                return;
            }
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(q) ? '' : 'none';
        });
    };

    window.exportCurrentTable = function(customName) {
        const table = document.querySelector('.adm-table');
        if (!table) {
            window.showToast('No table data available to export.');
            return;
        }
        let csv = [];
        const rows = table.querySelectorAll('tr');
        rows.forEach(r => {
            let rowData = [];
            const cols = r.querySelectorAll('th, td');
            cols.forEach(c => {
                let text = c.innerText.replace(/"/g, '""').replace(/\n/g, ' ').trim();
                rowData.push(`"${text}"`);
            });
            csv.push(rowData.join(','));
        });

        const csvContent = csv.join('\n');
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const filename = (customName || 'dt_brand_admin_export') + '_' + Date.now() + '.csv';
        link.href = URL.createObjectURL(blob);
        link.download = filename;
        link.click();
        window.showToast(`📥 Exported ${filename} successfully!`);
    };

    // ════ COMMAND PALETTE (CTRL+K / CMD+K) ════
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.getElementById('admGlobalSearch');
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
                window.showToast('🔍 Global search focused. Type to navigate...');
            }
        }
    });

    // ════ GLOBAL QUICK MODAL HELPER ════
    window.openUniversalModal = function(title, bodyHtml) {
        let modal = document.getElementById('admUniversalModal');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'admUniversalModal';
            modal.className = 'adm-modal-overlay';
            modal.innerHTML = `
                <div class="adm-modal-card" style="max-width:600px; animation:admScaleIn 0.2s cubic-bezier(0.16,1,0.3,1);">
                    <div class="adm-modal-header">
                        <h3 class="adm-modal-title" id="admUniversalModalTitle"></h3>
                        <button type="button" class="adm-modal-close" onclick="window.closeUniversalModal()">✕</button>
                    </div>
                    <div class="adm-modal-body" id="admUniversalModalBody" style="padding:20px;"></div>
                </div>
            `;
            document.body.appendChild(modal);
            modal.addEventListener('click', function(e) {
                if (e.target === modal) window.closeUniversalModal();
            });
        }
        document.getElementById('admUniversalModalTitle').innerHTML = title;
        document.getElementById('admUniversalModalBody').innerHTML = bodyHtml;
        modal.classList.add('open');
    };

    window.closeUniversalModal = function() {
        const modal = document.getElementById('admUniversalModal');
        if (modal) modal.classList.remove('open');
    };

    // ════ TOAST SYSTEM ════
    window.showToast = function(msg) {
        let box = document.getElementById('admToastBox');
        if (!box) {
            box = document.createElement('div');
            box.id = 'admToastBox';
            box.className = 'adm-toast-box';
            document.body.appendChild(box);
        }

        const toast = document.createElement('div');
        toast.className = 'adm-toast';
        toast.innerHTML = `<span>✨</span> <span>${msg}</span>`;
        box.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(10px)';
            toast.style.transition = 'all 0.25s ease';
            setTimeout(() => toast.remove(), 250);
        }, 2800);
    };

    // ════ PRODUCT ACTIONS ════
    window.shareProductWhatsApp = function(id) {
        const text = encodeURIComponent('Check out Kanjivaram Pure Silk Gold Zari Saree on DT Brand\'s: https://jaihanumantex.in/Frontend/Single-Product/singleproduct.php?id=' + (id || '101'));
        window.open('https://api.whatsapp.com/send?text=' + text, '_blank');
        if (typeof window.showToast === 'function') window.showToast('📲 Opening WhatsApp share link...');
    };

    window.duplicateProduct = function(id) {
        if (typeof window.showToast === 'function') window.showToast('📋 Duplicating product SKU...');
        setTimeout(() => {
            window.location.href = '/Frontend/Admin/products/add.php?duplicated_from=' + (id || '101');
        }, 600);
    };

    window.archiveProduct = function(id) {
        if (confirm('Archive this product SKU from active catalog?')) {
            if (typeof window.showToast === 'function') window.showToast('📦 Product archived successfully');
        }
    };


    // ════ MOBILE SIDEBAR DRAWER TOGGLE ════
    document.addEventListener('DOMContentLoaded', function() {
        const mobileBtn = document.getElementById('admMobileMenuBtn');
        const sidebar = document.getElementById('admSidebar');
        const backdrop = document.getElementById('admSidebarBackdrop');
        const toggleBtn = document.getElementById('admSidebarToggleBtn');

        if (mobileBtn && sidebar) {
            mobileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                sidebar.classList.toggle('mobile-open');
                if (backdrop) {
                    backdrop.style.display = sidebar.classList.contains('mobile-open') ? 'block' : 'none';
                }
            });
        }

        if (backdrop && sidebar) {
            backdrop.addEventListener('click', function() {
                sidebar.classList.remove('mobile-open');
                backdrop.style.display = 'none';
            });
        }

        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                sidebar.classList.toggle('collapsed');
            });
        }
    });

})();

