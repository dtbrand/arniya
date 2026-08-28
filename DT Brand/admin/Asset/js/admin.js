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
            image: '/assets/images/product2.png',
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
            image: '/assets/images/product5.png',
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
            image: '/assets/images/product1.png',
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
            image: '/assets/images/product1.png',
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
            image: '/assets/images/product6.png',
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
            image: '/assets/images/product6.png',
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
            image: '/assets/images/product6.png',
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
            image: '/assets/images/product8.png',
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
            phone: '7046363528',
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
            phone: '7046363528',
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
            phone: '7046363528',
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
            phone: '7046363528',
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
            phone: '7046363528',
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
            phone: '7046363528',
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
            phone: '7046363528',
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
            phone: '7046363528',
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
            phone: '7046363528',
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
            phone: '7046363528',
            inquiry: 'Interested in Paithani Rich Pallu Saree wholesale batch (20 pcs)',
            time: '5m ago',
            tag: 'Wholesale Lead'
        },
        {
            name: 'Amitabh Textiles',
            phone: '7046363528',
            inquiry: 'Need GST invoice download for Consignment #ORD-9841',
            time: '24m ago',
            tag: 'Order Support'
        },
        {
            name: 'Simran Sethi (Reseller)',
            phone: '7046363528',
            inquiry: 'How to calculate 25% margin in smart share catalog links?',
            time: '1h ago',
            tag: 'Reseller Help'
        },
        {
            name: 'Ritu Chawla',
            phone: '7046363528',
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
        renderRefSalesChart();

        window.addEventListener('resize', function() {
            renderRefSalesChart();
        });
    });

    function renderRefSalesChart() {
        const canvas = document.getElementById('admRefSalesChart');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        if (!ctx) return;

        const dpr = window.devicePixelRatio || 1;
        const rect = canvas.getBoundingClientRect();
        const width = rect.width || canvas.parentElement.clientWidth || 500;
        const height = 180;

        canvas.width = width * dpr;
        canvas.height = height * dpr;
        canvas.style.width = width + 'px';
        canvas.style.height = height + 'px';
        ctx.scale(dpr, dpr);

        ctx.clearRect(0, 0, width, height);

        const padLeft = 45;
        const padRight = 20;
        const padTop = 15;
        const padBottom = 25;
        const chartW = width - padLeft - padRight;
        const chartH = height - padTop - padBottom;

        // Y-axis grid & labels
        const ySteps = ['₹200k', '₹150k', '₹100k', '₹50k', '₹0k'];
        ctx.font = '10px "Plus Jakarta Sans", sans-serif';
        ctx.fillStyle = '#8A681F';
        ctx.textAlign = 'right';

        ySteps.forEach((label, i) => {
            const y = padTop + (chartH / (ySteps.length - 1)) * i;
            ctx.fillText(label, padLeft - 8, y + 3);

            // Dashed grid line
            ctx.beginPath();
            ctx.setLineDash([3, 3]);
            ctx.strokeStyle = '#F0EBE0';
            ctx.lineWidth = 1;
            ctx.moveTo(padLeft, y);
            ctx.lineTo(width - padRight, y);
            ctx.stroke();
        });
        ctx.setLineDash([]);

        // Data for bars (Running month & last month)
        const barData = [
            { lm: 0.3, rm: 0.4 }, { lm: 0.25, rm: 0.35 }, { lm: 0.45, rm: 0.5 }, { lm: 0.35, rm: 0.6 },
            { lm: 0.5, rm: 0.4 }, { lm: 0.4, rm: 0.7 }, { lm: 0.3, rm: 0.55 }, { lm: 0.6, rm: 0.9 },
            { lm: 0.55, rm: 0.8 }, { lm: 0.7, rm: 0.65 }, { lm: 0.45, rm: 0.5 }, { lm: 0.35, rm: 0.45 },
            { lm: 0.5, rm: 0.6 }, { lm: 0.6, rm: 0.75 }, { lm: 0.4, rm: 0.5 }, { lm: 0.3, rm: 0.4 }
        ];

        const barSpacing = chartW / barData.length;
        const barW = Math.max(5, Math.min(12, barSpacing * 0.42));

        barData.forEach((d, idx) => {
            const x = padLeft + idx * barSpacing + (barSpacing - barW * 2) / 2;

            // Last Month bar (Light slate/cream)
            const lmH = d.lm * chartH;
            ctx.fillStyle = '#E2E8F0';
            ctx.beginPath();
            if (ctx.roundRect) {
                ctx.roundRect(x, padTop + chartH - lmH, barW, lmH, [3, 3, 0, 0]);
            } else {
                ctx.rect(x, padTop + chartH - lmH, barW, lmH);
            }
            ctx.fill();

            // Running Month bar (Signature Radiant Gold Gradient & Emerald Peak)
            const rmH = d.rm * chartH;
            if (idx === 7) {
                ctx.fillStyle = '#16A34A'; // Peak sale day in emerald
            } else {
                const goldGrad = ctx.createLinearGradient(0, padTop + chartH - rmH, 0, padTop + chartH);
                goldGrad.addColorStop(0, '#D4AF37');
                goldGrad.addColorStop(1, '#8A681F');
                ctx.fillStyle = goldGrad;
            }
            ctx.beginPath();
            if (ctx.roundRect) {
                ctx.roundRect(x + barW + 2, padTop + chartH - rmH, barW, rmH, [3, 3, 0, 0]);
            } else {
                ctx.rect(x + barW + 2, padTop + chartH - rmH, barW, rmH);
            }
            ctx.fill();
        });

        // Spline curve line overlay
        const linePoints = [
            { x: padLeft, y: padTop + chartH * 0.65 },
            { x: padLeft + chartW * 0.18, y: padTop + chartH * 0.45 },
            { x: padLeft + chartW * 0.35, y: padTop + chartH * 0.6 },
            { x: padLeft + chartW * 0.55, y: padTop + chartH * 0.15 },
            { x: padLeft + chartW * 0.75, y: padTop + chartH * 0.4 },
            { x: padLeft + chartW * 0.95, y: padTop + chartH * 0.3 }
        ];

        ctx.beginPath();
        ctx.strokeStyle = '#181512';
        ctx.lineWidth = 2.4;
        ctx.lineJoin = 'round';
        ctx.lineCap = 'round';

        ctx.moveTo(linePoints[0].x, linePoints[0].y);
        for (let i = 0; i < linePoints.length - 1; i++) {
            const xc = (linePoints[i].x + linePoints[i + 1].x) / 2;
            const yc = (linePoints[i].y + linePoints[i + 1].y) / 2;
            ctx.quadraticCurveTo(linePoints[i].x, linePoints[i].y, xc, yc);
        }
        ctx.lineTo(linePoints[linePoints.length - 1].x, linePoints[linePoints.length - 1].y);
        ctx.stroke();

        // Prominent node points with gold ring
        [linePoints[1], linePoints[3], linePoints[4]].forEach(pt => {
            ctx.beginPath();
            ctx.arc(pt.x, pt.y, 4.5, 0, Math.PI * 2);
            ctx.fillStyle = '#8A681F';
            ctx.fill();
            ctx.lineWidth = 2;
            ctx.strokeStyle = '#D4AF37';
            ctx.stroke();
        });
    }

    window.switchAdmRefTimeRange = function(range, btn) {
        document.querySelectorAll('.adm-ref-time-pill').forEach(p => p.classList.remove('active'));
        if (btn) btn.classList.add('active');

        fetch('/api/orders.php?action=analytics&range=' + encodeURIComponent(range))
            .then(res => res.json())
            .then(data => {
                const amtEl = document.querySelector('.adm-ref-sales-amt');
                const growthEl = document.querySelector('.adm-ref-sales-growth');
                const total = data.total_sales || 0;
                const count = data.order_count || 0;
                if (amtEl) amtEl.textContent = '₹' + Number(total).toLocaleString('en-IN');
                if (growthEl) {
                    growthEl.textContent = (count > 0 ? (count + ' verified orders in ' + range) : '0 live orders recorded • Database live & ready');
                }
            })
            .catch(() => {});

        renderRefSalesChart();
        if (window.showToast) {
            window.showToast('Sales analytics updated: ' + range + ' view', 'success');
        }
    };


    function renderKPISparklines() {
        const sparkContainers = document.querySelectorAll('.adm-kpi-sparkline');
        if (!sparkContainers.length) return;

        // Realistic financial waveforms for distinct KPI metrics
        const waveProfiles = {
            up: [
                { path: "M 2 28 C 16 26, 26 30, 40 18 C 54 8, 68 14, 88 4", endX: 88, endY: 4 },
                { path: "M 2 26 C 14 28, 28 16, 44 18 C 58 20, 70 8, 88 3", endX: 88, endY: 3 },
                { path: "M 2 30 C 18 20, 32 22, 48 12 C 62 6, 74 10, 88 5", endX: 88, endY: 5 },
                { path: "M 2 24 C 16 30, 30 14, 46 16 C 60 18, 74 6, 88 2", endX: 88, endY: 2 }
            ],
            down: [
                { path: "M 2 4 C 16 6, 28 16, 44 14 C 58 20, 72 24, 88 28", endX: 88, endY: 28 },
                { path: "M 2 6 C 18 4, 30 20, 48 18 C 62 24, 74 22, 88 30", endX: 88, endY: 30 }
            ]
        };

        sparkContainers.forEach(function(el, idx) {
            const isUp = el.getAttribute('data-trend') !== 'down';
            const profiles = isUp ? waveProfiles.up : waveProfiles.down;
            const profile = profiles[idx % profiles.length];
            const gradId = 'kpiGrad_' + idx + '_' + (isUp ? 'up' : 'down');
            const strokeColor = isUp ? '#16A34A' : '#DC2626';
            const fillColor = isUp ? '#22C55E' : '#EF4444';

            const svgHtml = '<svg viewBox="0 0 92 32" width="90" height="32" style="overflow:visible; display:block;">' +
                '<defs>' +
                    '<linearGradient id="' + gradId + '" x1="0" y1="0" x2="0" y2="1">' +
                        '<stop offset="0%" stop-color="' + fillColor + '" stop-opacity="0.32" />' +
                        '<stop offset="100%" stop-color="' + fillColor + '" stop-opacity="0.0" />' +
                    '</linearGradient>' +
                '</defs>' +
                // Area fill under curve
                '<path d="' + profile.path + ' L ' + profile.endX + ' 32 L 2 32 Z" fill="url(#' + gradId + ')" stroke="none" />' +
                // Smooth curved line
                '<path d="' + profile.path + '" fill="none" stroke="' + strokeColor + '" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" />' +
                // Glowing outer pulse ring
                '<circle cx="' + profile.endX + '" cy="' + profile.endY + '" r="5.5" fill="none" stroke="' + strokeColor + '" stroke-width="1.2" opacity="0.35" />' +
                // Crisp end point dot
                '<circle cx="' + profile.endX + '" cy="' + profile.endY + '" r="3" fill="' + strokeColor + '" stroke="#FFFFFF" stroke-width="1.5" />' +
            '</svg>';

            el.innerHTML = svgHtml;
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

    // ════ SIDEBAR CONTROLS (DELEGATES TO adminsidebar.php) ════
    function initSidebar() {
        // Self-contained in adminsidebar.php to guarantee zero conflicting listeners
    }

    // ════ TAB ROUTING ════
    window.switchAdmTab = function(tabId) {
        const tabs = document.querySelectorAll('.adm-tab-panel');
        const navItems = document.querySelectorAll('.adm-nav-item');
        const subnavItems = document.querySelectorAll('.adm-subnav-item');
        const dockItems = document.querySelectorAll('.adm-mobile-bottom-dock .adm-dock-item');

        tabs.forEach(tab => tab.classList.remove('active'));
        navItems.forEach(item => item.classList.remove('active'));
        subnavItems.forEach(item => item.classList.remove('active'));
        dockItems.forEach(item => item.classList.remove('active'));

        const targetTab = document.getElementById('tab-' + tabId);
        const targetNav = document.getElementById('navItem-' + tabId);
        const targetSubnav = document.getElementById('subnav-' + tabId);

        if (targetTab) targetTab.classList.add('active');
        if (targetNav) targetNav.classList.add('active');
        if (targetSubnav) targetSubnav.classList.add('active');

        // Sync mobile bottom dock active tab
        dockItems.forEach(item => {
            const onclick = item.getAttribute('onclick') || '';
            const href = item.getAttribute('href') || '';
            if (onclick.includes(tabId) || (tabId === 'overview' && href.includes('admin.php')) || (tabId === 'products' && href.includes('products'))) {
                item.classList.add('active');
            }
        });

        // Close mobile sidebar if open
        const sidebar = document.getElementById('admSidebar');
        const backdrop = document.getElementById('admSidebarBackdrop');
        if (sidebar) sidebar.classList.remove('mobile-open');
        if (backdrop) backdrop.style.display = 'none';

        // Re-render chart if switching to overview
        if (tabId === 'overview') {
            setTimeout(renderRefSalesChart, 50);
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

    // ════ MOBILE SEARCH BAR CONTROLS (SHOP PAGE STYLE) ════
    window.openAdmMobileSearch = function() {
        const header = document.getElementById('admHeaderMain') || document.querySelector('.adm-header');
        if (header) {
            header.classList.add('mobile-search-active');
            setTimeout(() => {
                const mobInput = document.getElementById('admMobileGlobalSearch');
                if (mobInput) mobInput.focus();
            }, 50);
        }
    };

    window.closeAdmMobileSearch = function() {
        const header = document.getElementById('admHeaderMain') || document.querySelector('.adm-header');
        if (header) {
            header.classList.remove('mobile-search-active');
            const mobInput = document.getElementById('admMobileGlobalSearch');
            if (mobInput) {
                mobInput.value = '';
                const mobClear = document.getElementById('admMobileGlobalSearchClear');
                if (mobClear) mobClear.style.display = 'none';
            }
        }
    };

    // ════ NEXT-LEVEL LIVE SEARCH ENGINE WITH AUTOCOMPLETE DROPDOWN ════
    function handleGlobalSearch(query, isMobile) {
        const targetContainer = isMobile 
            ? document.getElementById('admMobileGlobalSearchResults') 
            : document.getElementById('admGlobalSearchResults');

        if (!targetContainer) return;

        if (!query || query.trim().length === 0) {
            targetContainer.style.display = 'none';
            targetContainer.innerHTML = '';
            return;
        }

        const q = query.trim().toLowerCase();
        
        // Match Products
        const matchingProds = (products || []).filter(p => 
            (p.name && p.name.toLowerCase().includes(q)) || 
            (p.sku && p.sku.toLowerCase().includes(q)) ||
            (p.category && p.category.toLowerCase().includes(q)) ||
            (p.fabric && p.fabric.toLowerCase().includes(q))
        ).slice(0, 4);

        // Match Orders
        const matchingOrders = (orders || []).filter(o => 
            (o.id && o.id.toLowerCase().includes(q)) || 
            (o.customer && o.customer.toLowerCase().includes(q)) ||
            (o.city && o.city.toLowerCase().includes(q)) ||
            (o.status && o.status.toLowerCase().includes(q))
        ).slice(0, 3);

        // Match Partners / Wholesalers
        const matchingPartners = (partners || []).filter(pt => 
            (pt.name && pt.name.toLowerCase().includes(q)) || 
            (pt.city && pt.city.toLowerCase().includes(q)) ||
            (pt.phone && pt.phone.toLowerCase().includes(q))
        ).slice(0, 3);

        const totalMatches = matchingProds.length + matchingOrders.length + matchingPartners.length;

        if (totalMatches === 0) {
            targetContainer.innerHTML = `
                <div class="adm-live-search-empty">
                    <div style="font-size:22px; margin-bottom:6px;">🔍</div>
                    <div style="font-weight:700; color:#181512; margin-bottom:3px;">No direct matches found for "${query}"</div>
                    <div style="font-size:11px; color:#64748B;">Try searching by Product Name (e.g. <i>Saree</i>), SKU (e.g. <i>KLN-SR-111</i>), or Order # (e.g. <i>DTB-001620</i>).</div>
                </div>
            `;
            targetContainer.style.display = 'block';
            return;
        }

        let html = `
            <div class="adm-live-search-header">
                <span>🔍 Instant Live Results for "<b>${query}</b>"</span>
                <span class="adm-live-search-count-badge">${totalMatches} Result${totalMatches === 1 ? '' : 's'}</span>
            </div>
        `;

        // 👗 PRODUCTS SECTION
        if (matchingProds.length > 0) {
            html += `
                <div class="adm-live-search-group">
                    <div class="adm-live-search-group-title">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        <span>Products &amp; SKUs (${matchingProds.length})</span>
                    </div>
            `;
            matchingProds.forEach(p => {
                html += `
                    <div class="adm-live-search-item" onclick="window.selectSearchProduct('${p.id}', '${p.sku}')">
                        <img src="${p.image}" onerror="this.src='/assets/images/product1.png';" alt="${p.name}" class="adm-live-search-thumb">
                        <div class="adm-live-search-info">
                            <div class="adm-live-search-title">${p.name}</div>
                            <div class="adm-live-search-sub">
                                <span style="font-weight:700; color:#8A681F;">${p.sku}</span>
                                <span>•</span>
                                <span>${p.category}</span>
                                <span>•</span>
                                <span style="color:#15803D; font-weight:700;">₹${(p.wholesale_price || 0).toLocaleString()} (Wholesale)</span>
                            </div>
                        </div>
                        <span class="adm-live-search-badge" style="background:#DCFCE7; color:#15803D; border:1px solid #BBF7D0;">${p.stock} in Stock</span>
                    </div>
                `;
            });
            html += `</div>`;
        }

        // 📦 ORDERS SECTION
        if (matchingOrders.length > 0) {
            html += `
                <div class="adm-live-search-group">
                    <div class="adm-live-search-group-title">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span>Wholesale Orders (${matchingOrders.length})</span>
                    </div>
            `;
            matchingOrders.forEach(o => {
                const statusColor = o.status === 'Delivered' ? '#15803D' : (o.status === 'Processing' ? '#B45309' : '#1D4ED8');
                const statusBg = o.status === 'Delivered' ? '#DCFCE7' : (o.status === 'Processing' ? '#FEF3C7' : '#EFF6FF');
                html += `
                    <div class="adm-live-search-item" onclick="window.selectSearchOrder('${o.id}')">
                        <div class="adm-live-search-avatar" style="border-radius:6px; font-size:10px;">📦</div>
                        <div class="adm-live-search-info">
                            <div class="adm-live-search-title">Order #${o.id} — ${o.customer}</div>
                            <div class="adm-live-search-sub">
                                <span>${o.city || 'Surat Central Depot'}</span>
                                <span>•</span>
                                <span style="font-weight:700; color:#181512;">₹${(o.amount || 0).toLocaleString()}</span>
                            </div>
                        </div>
                        <span class="adm-live-search-badge" style="background:${statusBg}; color:${statusColor}; border:1px solid ${statusColor}33;">${o.status}</span>
                    </div>
                `;
            });
            html += `</div>`;
        }

        // 👤 PARTNERS SECTION
        if (matchingPartners.length > 0) {
            html += `
                <div class="adm-live-search-group">
                    <div class="adm-live-search-group-title">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span>Wholesalers &amp; Partners (${matchingPartners.length})</span>
                    </div>
            `;
            matchingPartners.forEach(pt => {
                const initials = pt.name ? pt.name.split(' ').map(w => w[0]).join('').substring(0,2).toUpperCase() : 'PT';
                html += `
                    <div class="adm-live-search-item" onclick="window.selectSearchPartner('${pt.name}')">
                        <div class="adm-live-search-avatar">${initials}</div>
                        <div class="adm-live-search-info">
                            <div class="adm-live-search-title">${pt.name}</div>
                            <div class="adm-live-search-sub">
                                <span>${pt.city}</span>
                                <span>•</span>
                                <span>${pt.phone}</span>
                            </div>
                        </div>
                        <span class="adm-live-search-badge" style="background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37;">${pt.tier || 'Verified Wholesaler'}</span>
                    </div>
                `;
            });
            html += `</div>`;
        }

        // Footer
        html += `
            <div class="adm-live-search-footer">
                <span>Click any record to navigate</span>
                <span style="color:#8A681F; font-weight:800; cursor:pointer;" onclick="window.executeGlobalSearch('${query}')">View Full Results ➔</span>
            </div>
        `;

        targetContainer.innerHTML = html;
        targetContainer.style.display = 'block';
    }

    window.selectSearchProduct = function(prodId, sku) {
        hideAllLiveSearchResults();
        if (typeof window.switchAdmTab === 'function') {
            window.switchAdmTab('products');
            const searchBox = document.getElementById('admProdSearch');
            if (searchBox) {
                searchBox.value = sku || '';
                if (typeof filterProducts === 'function') filterProducts();
            }
        }
        if (window.showToast) window.showToast(`👗 Navigated to Product SKU: ${sku}`);
    };

    window.selectSearchOrder = function(orderId) {
        hideAllLiveSearchResults();
        window.location.href = `/DT%20Brand/admin/orders/view.php?id=${encodeURIComponent(orderId)}`;
    };

    window.selectSearchPartner = function(partnerName) {
        hideAllLiveSearchResults();
        if (typeof window.switchAdmTab === 'function') {
            window.switchAdmTab('partners');
            const searchBox = document.getElementById('admPartnerSearch');
            if (searchBox) {
                searchBox.value = partnerName || '';
                if (typeof filterPartners === 'function') filterPartners();
            }
        }
        if (window.showToast) window.showToast(`👤 Navigated to Partner: ${partnerName}`);
    };

    window.executeGlobalSearch = function(query) {
        hideAllLiveSearchResults();
        if (!query || !query.trim()) return;
        const q = query.trim().toLowerCase();

        // Check matching order first
        const foundOrder = (orders || []).find(o => o.id.toLowerCase().includes(q) || o.customer.toLowerCase().includes(q));
        if (foundOrder) {
            window.location.href = `/DT%20Brand/admin/orders/view.php?id=${encodeURIComponent(foundOrder.id)}`;
            return;
        }

        // Check products
        const foundProd = (products || []).find(p => p.name.toLowerCase().includes(q) || p.sku.toLowerCase().includes(q));
        if (foundProd) {
            if (typeof window.switchAdmTab === 'function') {
                window.switchAdmTab('products');
                const searchBox = document.getElementById('admProdSearch');
                if (searchBox) {
                    searchBox.value = query;
                    if (typeof filterProducts === 'function') filterProducts();
                }
            }
            return;
        }

        // Fallback to Orders table search
        if (typeof window.switchAdmTab === 'function') {
            window.switchAdmTab('orders');
            const searchBox = document.getElementById('admOrderSearch');
            if (searchBox) {
                searchBox.value = query;
                if (typeof filterOrders === 'function') filterOrders();
            }
        }
    };

    function hideAllLiveSearchResults() {
        const d = document.getElementById('admGlobalSearchResults');
        if (d) d.style.display = 'none';
        const md = document.getElementById('admMobileGlobalSearchResults');
        if (md) md.style.display = 'none';
    }

    // Auto-dismiss live search on click outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#admHeaderSearchContainer') && !e.target.closest('#admMobileFullSearchBar')) {
            hideAllLiveSearchResults();
        }
    });

    // Auto-dismiss on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideAllLiveSearchResults();
            if (typeof window.closeAdmMobileSearch === 'function') window.closeAdmMobileSearch();
        }
    });

    // ════ SEARCH INPUTS & 1-TAP CLEAR BUTTON ENGINE (STRICT RULE) ════
    function initSearchInputs() {
        const searchConfigs = [
            { inputId: 'admGlobalSearch', clearId: 'admGlobalSearchClear', handler: (q) => handleGlobalSearch(q, false) },
            { inputId: 'admMobileGlobalSearch', clearId: 'admMobileGlobalSearchClear', handler: (q) => handleGlobalSearch(q, true) },
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

                // Focus trigger to reopen if query present
                input.addEventListener('focus', function() {
                    if (this.value.trim().length > 0 && typeof cfg.handler === 'function') {
                        cfg.handler(this.value.trim());
                    }
                });

                // Enter key to execute search directly
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        if (typeof window.executeGlobalSearch === 'function') {
                            window.executeGlobalSearch(this.value.trim());
                        }
                    }
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

    // ════ HIGH-DEFINITION DYNAMIC RESPONSIVE CANVAS CHARTS ════
    
    function renderAppCircularGauge() {
        const canvas = document.getElementById('admAppCircularGauge');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        const dpr = window.devicePixelRatio || 1;
        const size = 110;
        canvas.width = size * dpr;
        canvas.height = size * dpr;
        canvas.style.width = size + 'px';
        canvas.style.height = size + 'px';
        ctx.scale(dpr, dpr);

        const cx = size / 2, cy = size / 2, r = (size / 2) - 10;
        ctx.clearRect(0, 0, size, size);

        // Background track arc
        ctx.beginPath();
        ctx.arc(cx, cy, r, -Math.PI * 0.8, Math.PI * 0.8, false);
        ctx.strokeStyle = '#FAF5E8';
        ctx.lineWidth = 7.5;
        ctx.lineCap = 'round';
        ctx.stroke();

        // Active progress arc (84.5% complete)
        const progress = 0.845;
        const totalAngle = Math.PI * 1.6;
        const endAngle = (-Math.PI * 0.8) + (totalAngle * progress);

        const grad = ctx.createLinearGradient(0, 0, size, size);
        grad.addColorStop(0, '#8A681F');
        grad.addColorStop(0.5, '#D4AF37');
        grad.addColorStop(1, '#16A34A');

        ctx.beginPath();
        ctx.arc(cx, cy, r, -Math.PI * 0.8, endAngle, false);
        ctx.strokeStyle = grad;
        ctx.lineWidth = 7.5;
        ctx.lineCap = 'round';
        ctx.stroke();
    }

    function initCharts() {
        renderAppCircularGauge();
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
        const h = 150;
        canvas.width = w * dpr;
        canvas.height = h * dpr;
        canvas.style.width = w + 'px';
        canvas.style.height = h + 'px';
        ctx.scale(dpr, dpr);

        ctx.clearRect(0, 0, w, h);

        const labels = ['01', '02', '03', '04', '05', '06', '07'];
        const b2bBars = [65, 80, 50, 95, 70, 110, 85];
        const b2cBars = [40, 55, 35, 60, 45, 75, 55];
        const maxVal = 120;

        const padL = 20, padR = 20, padT = 15, padB = 25;
        const chartW = w - padL - padR;
        const chartH = h - padT - padB;

        // Draw light horizontal dashed grid lines
        ctx.strokeStyle = '#F0ECE1';
        ctx.lineWidth = 1;
        ctx.setLineDash([4, 4]);

        for (let i = 1; i <= 3; i++) {
            const y = padT + (chartH / 3) * i;
            ctx.beginPath();
            ctx.moveTo(padL, y);
            ctx.lineTo(w - padR, y);
            ctx.stroke();
        }
        ctx.setLineDash([]); // reset

        // Draw rounded dual bars for each day
        const slotW = chartW / labels.length;
        const barW = Math.min(10, slotW * 0.22);
        const gap = 3;

        labels.forEach((lbl, i) => {
            const centerX = padL + (i * slotW) + (slotW / 2);
            const x1 = centerX - barW - (gap / 2);
            const x2 = centerX + (gap / 2);

            // B2B Gold Bar
            const barH1 = (b2bBars[i] / maxVal) * chartH;
            const y1 = h - padB - barH1;

            ctx.fillStyle = '#8A681F';
            ctx.beginPath();
            ctx.roundRect ? ctx.roundRect(x1, y1, barW, barH1, [4, 4, 0, 0]) : ctx.rect(x1, y1, barW, barH1);
            ctx.fill();

            // B2C Green Bar
            const barH2 = (b2cBars[i] / maxVal) * chartH;
            const y2 = h - padB - barH2;

            ctx.fillStyle = '#15803D';
            ctx.beginPath();
            ctx.roundRect ? ctx.roundRect(x2, y2, barW, barH2, [4, 4, 0, 0]) : ctx.rect(x2, y2, barW, barH2);
            ctx.fill();

            // X-axis day label
            ctx.fillStyle = '#8C8478';
            ctx.font = '10px Plus Jakarta Sans, sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText(lbl, centerX, h - padB + 16);
        });
    }

    function renderCategoryDoughnut() {
        const canvas = document.getElementById('admCategoryChart');
        if (!canvas) return;
        const parent = canvas.parentElement;
        const containerWidth = parent.clientWidth || parent.getBoundingClientRect().width || 280;
        const ctx = canvas.getContext('2d');
        const dpr = window.devicePixelRatio || 1;

        const w = Math.min(340, containerWidth);
        const h = 180;
        canvas.width = w * dpr;
        canvas.height = h * dpr;
        canvas.style.width = w + 'px';
        canvas.style.height = h + 'px';
        ctx.scale(dpr, dpr);

        ctx.clearRect(0, 0, w, h);

        const cx = w / 2;
        const cy = h / 2;

        // Helper to draw a luxury 3D glass bubble with specular highlights
        function drawLuxuryGlassBubble(x, y, r, fillGrad, strokeColor, shadowColor, pctText, labelText, pctColor, lblColor) {
            ctx.save();
            ctx.shadowColor = shadowColor || 'rgba(138, 104, 31, 0.18)';
            ctx.shadowBlur = 12;
            ctx.shadowOffsetY = 4;

            ctx.beginPath();
            ctx.arc(x, y, r, 0, Math.PI * 2);
            ctx.fillStyle = fillGrad;
            ctx.fill();

            ctx.lineWidth = 2;
            ctx.strokeStyle = strokeColor;
            ctx.stroke();
            ctx.restore();

            // Specular glass gloss highlight (top-left arc)
            ctx.save();
            ctx.beginPath();
            ctx.arc(x, y, r - 3, -Math.PI * 0.85, -Math.PI * 0.25);
            ctx.lineWidth = Math.max(1.5, r * 0.05);
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.75)';
            ctx.stroke();
            ctx.restore();

            // Main Percentage Typography
            ctx.fillStyle = pctColor;
            ctx.font = '800 ' + (r > 45 ? '19px' : (r > 30 ? '15px' : (r > 22 ? '13px' : '11px'))) + ' Plus Jakarta Sans, sans-serif';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(pctText, x, y - (r > 28 ? 6 : 0));

            // Sub-label below percentage
            if (r > 24 && labelText) {
                ctx.fillStyle = lblColor;
                ctx.font = '700 ' + (r > 45 ? '10px' : '8.5px') + ' Plus Jakarta Sans, sans-serif';
                ctx.fillText(labelText, x, y + (r > 45 ? 11 : 9));
            }
        }

        // Bubble 1: Sarees (48%) - Luxury Master Gold Glass Bubble
        const grad1 = ctx.createRadialGradient(cx - 56, cy - 16, 4, cx - 44, cy - 4, 52);
        grad1.addColorStop(0, '#FFFFFF');
        grad1.addColorStop(0.35, '#FAF5E8');
        grad1.addColorStop(1, '#EBD8A5');
        drawLuxuryGlassBubble(cx - 44, cy - 4, 52, grad1, '#8A681F', 'rgba(138, 104, 31, 0.25)', '48%', 'Sarees', '#5A4210', '#8A681F');

        // Bubble 2: Kurtis (32%) - Fresh Emerald Glass Bubble
        const grad2 = ctx.createRadialGradient(cx + 34, cy - 32, 3, cx + 42, cy - 24, 38);
        grad2.addColorStop(0, '#FFFFFF');
        grad2.addColorStop(0.35, '#DCFCE7');
        grad2.addColorStop(1, '#A7F3D0');
        drawLuxuryGlassBubble(cx + 42, cy - 24, 38, grad2, '#15803D', 'rgba(22, 163, 74, 0.25)', '32%', 'Kurtis', '#15803D', '#16A34A');

        // Bubble 3: Lehengas (13%) - Radiant Amber Glass Bubble
        const grad3 = ctx.createRadialGradient(cx + 26, cy + 32, 2, cx + 32, cy + 38, 27);
        grad3.addColorStop(0, '#FFFFFF');
        grad3.addColorStop(0.35, '#FEF3C7');
        grad3.addColorStop(1, '#FDE68A');
        drawLuxuryGlassBubble(cx + 32, cy + 38, 27, grad3, '#D97706', 'rgba(217, 119, 6, 0.25)', '13%', 'Lehengas', '#B45309', '#D97706');

        // Bubble 4: Dress Materials (7%) - Royal Amethyst Glass Bubble
        const grad4 = ctx.createRadialGradient(cx + 70, cy + 20, 2, cx + 74, cy + 24, 19);
        grad4.addColorStop(0, '#FFFFFF');
        grad4.addColorStop(0.35, '#F3E8FF');
        grad4.addColorStop(1, '#DDD6FE');
        drawLuxuryGlassBubble(cx + 74, cy + 24, 19, grad4, '#7E22CE', 'rgba(126, 34, 206, 0.25)', '7%', '', '#6B21A8', '#7E22CE');
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
                            <img src="${p.image}" onerror="this.src='/assets/images/product1.png';" alt="${p.name}" class="adm-prod-thumb">
                            <div class="adm-prod-meta">
                                <a href="/DT%20Brand/admin/products/view.php?id=${p.id}" class="adm-prod-title" style="color:#181512; text-decoration:none; font-weight:700;">${p.name}</a>
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
                            <a href="/DT%20Brand/admin/products/view.php?id=${p.id}" class="adm-action-btn" title="View Details">👁️</a>
                            <a href="/DT%20Brand/admin/products/edit.php?id=${p.id}" class="adm-action-btn" title="Edit">✏️</a>
                            <a href="/DT%20Brand/admin/products/duplicate.php?id=${p.id}" class="adm-action-btn" title="Duplicate">📋</a>
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
            'catalogue': "✨ *DT BRAND'S LUXURY ETHNIC FRESH CATALOGUE* ✨\n\nDear {Name},\nExplore our latest 2026 Pure Silk Sarees & Designer Lehengas crafted for premium festive collections.\n\n👉 *View & Order Online:* https://jaihanumantex.in/shop\n\n_Special 15% VIP Discount Applied!_",
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
                image: '/assets/images/product1.png',
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

    // An earlier window.shareProductWhatsApp stood here. It read the demo
    // `products` array at the top of this file, so it shared invented prices and
    // MOQs for any id that happened to match a sample row and did nothing for a
    // real product id. It was shadowed by the definition further down anyway.
    // The surviving one fetches the product from /api/products.php.

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
    // These three used to be demo stubs. shareProductWhatsApp sent one hardcoded
    // title ("Kanjivaram Pure Silk Gold Zari Saree") for every product, pointing
    // at /Frontend/Single-Product/singleproduct.php - a path that does not exist -
    // and fell back to product id 101 when no id was passed. duplicateProduct
    // only navigated to add.php?duplicated_from=... (nothing reads that) and
    // archiveProduct said "archived successfully" without touching the database.
    window.shareProductWhatsApp = function(id) {
        var pid = Number(id) || 0;
        if (pid <= 0) return;
        fetch('/api/products.php?id=' + encodeURIComponent(pid))
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (!data || !data.success || !data.product) {
                    if (typeof window.showToast === 'function') window.showToast('⚠️ That product could not be loaded, so nothing was shared.');
                    return;
                }
                var p = data.product;
                var lines = ["*DT BRAND'S — " + (p.name || p.title || 'Product') + '*'];
                if (p.sku) lines.push('SKU: ' + p.sku);
                if (p.category) lines.push('Category: ' + p.category);
                if (p.fabric) lines.push('Fabric: ' + p.fabric);
                if (Number(p.retail_price) > 0) lines.push('Retail: ₹' + Number(p.retail_price).toLocaleString('en-IN'));
                if (Number(p.wholesale_price) > 0) {
                    lines.push('Wholesale: ₹' + Number(p.wholesale_price).toLocaleString('en-IN') + '/pc'
                        + (Number(p.moq) > 0 ? ' (MOQ ' + Number(p.moq) + ' pcs)' : ''));
                }
                lines.push('', window.location.origin + '/product.php?id=' + pid);
                window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent(lines.join('\n')), '_blank');
            })
            .catch(function() {
                if (typeof window.showToast === 'function') window.showToast('⚠️ Network error - nothing was shared.');
            });
    };

    window.duplicateProduct = function(id) {
        var pid = Number(id) || 0;
        if (pid <= 0) return;
        if (typeof window.showToast === 'function') window.showToast('📋 Duplicating product in the database...');
        fetch('/api/products.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=duplicate&id=' + encodeURIComponent(pid)
        })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data && data.success) {
                    if (typeof window.showToast === 'function') window.showToast('✨ Duplicated. Reloading...');
                    setTimeout(function() { window.location.reload(); }, 500);
                } else {
                    alert('Could not duplicate: ' + ((data && data.message) || 'unknown error'));
                }
            })
            .catch(function() { alert('Network error while duplicating the product.'); });
    };

    window.archiveProduct = function(id) {
        var pid = Number(id) || 0;
        if (pid <= 0) return;
        // The products table has no "archived" state; draft is the one that
        // takes a product off the storefront while keeping the row.
        if (!confirm('Move this product to draft so it no longer appears on the storefront?')) return;
        fetch('/api/products.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=toggle_status&id=' + encodeURIComponent(pid) + '&status=draft'
        })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data && data.success) {
                    if (typeof window.showToast === 'function') window.showToast('📦 Product moved to draft.');
                    setTimeout(function() { window.location.reload(); }, 500);
                } else {
                    alert('Could not archive: ' + ((data && data.message) || 'unknown error'));
                }
            })
            .catch(function() { alert('Network error while archiving the product.'); });
    };

})();

