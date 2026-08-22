/**
 * retail-dashboard.js — DT Brand's & Jai Hanuman Tex
 * Retail Dashboard Dynamic Timeframe Switcher & Sales Chart Rendering
 */

(function () {
    'use strict';

    const dashboardTimeframeData = {
        'today': {
            rev: '₹1,84,200',
            orders: '54 Orders',
            aov: '₹3,411',
            bars: [
                { label: '6 AM', val: '₹12K', height: '20%' },
                { label: '9 AM', val: '₹38K', height: '55%' },
                { label: '12 PM', val: '₹52K', height: '80%' },
                { label: '3 PM', val: '₹44K', height: '65%' },
                { label: '6 PM', val: '₹68K', height: '95%' },
                { label: '9 PM', val: '₹76K', height: '100%', active: true }
            ]
        },
        '7d': {
            rev: '₹14,20,500',
            orders: '380 Orders',
            aov: '₹3,738',
            bars: [
                { label: 'Mon', val: '₹1.8L', height: '55%' },
                { label: 'Tue', val: '₹1.9L', height: '60%' },
                { label: 'Wed', val: '₹2.1L', height: '70%' },
                { label: 'Thu', val: '₹2.0L', height: '65%' },
                { label: 'Fri', val: '₹2.4L', height: '80%' },
                { label: 'Sat', val: '₹2.8L', height: '90%' },
                { label: 'Sun', val: '₹3.2L', height: '100%', active: true }
            ]
        },
        '30d': {
            rev: '₹58,40,000',
            orders: '1,624 Orders',
            aov: '₹3,596',
            bars: [
                { label: 'Week 1', val: '₹12.4L', height: '60%' },
                { label: 'Week 2', val: '₹14.8L', height: '75%' },
                { label: 'Week 3', val: '₹15.2L', height: '80%' },
                { label: 'Week 4', val: '₹16.0L', height: '90%' }
            ]
        }
    };

    window.switchRetailDashboardTimeframe = function (period) {
        const data = dashboardTimeframeData[period] || dashboardTimeframeData['30d'];

        document.querySelectorAll('.dt-retail-tf-btn').forEach(btn => {
            if (btn.getAttribute('data-tf') === period) {
                btn.className = 'dt-btn dt-btn-gold dt-btn-sm dt-retail-tf-btn';
            } else {
                btn.className = 'dt-btn dt-btn-pale dt-btn-sm dt-retail-tf-btn';
            }
        });

        const wrap = document.getElementById('retailSalesChartWrap');
        if (wrap) {
            wrap.innerHTML = data.bars.map(b => `
                <div class="dt-retail-chart-group">
                    <span class="dt-chart-bar-val" ${b.active ? 'style="color:#8A681F; font-weight:900;"' : ''}>${b.val}</span>
                    <div class="dt-retail-chart-pill ${b.active ? 'active' : ''}" style="height:${b.height};"></div>
                    <span class="dt-chart-bar-label" ${b.active ? 'style="color:#8A681F; font-weight:900;"' : ''}>${b.label}</span>
                </div>
            `).join('');
        }

        window.showToast(`📊 Retail Dashboard timeframe updated: ${period.toUpperCase()}`);
    };

})();
