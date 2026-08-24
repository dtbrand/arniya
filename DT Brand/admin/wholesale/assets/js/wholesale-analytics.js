/**
 * wholesale-analytics.js — DT Brand's & Jai Hanuman Tex
 * Wholesale Analytics Engine, Dynamic Timeframe Switching & CSV Exporter
 */

(function () {
    'use strict';

    const timeframeData = {
        '6m': {
            total: '₹1.42 Cr Total',
            bars: [
                { label: 'Nov', val: '₹14.2L', height: '45%' },
                { label: 'Dec', val: '₹18.5L', height: '60%' },
                { label: 'Jan', val: '₹21.0L', height: '68%' },
                { label: 'Feb', val: '₹24.8L', height: '80%' },
                { label: 'Mar', val: '₹28.4L', height: '90%' },
                { label: 'Apr (Peak)', val: '₹35.1L', height: '100%', active: true }
            ]
        },
        'q_festive': {
            total: '₹1.88 Cr Peak',
            bars: [
                { label: 'Rakhi', val: '₹28.5L', height: '70%' },
                { label: 'Teej', val: '₹32.0L', height: '80%' },
                { label: 'Navratri', val: '₹41.2L', height: '92%' },
                { label: 'Diwali', val: '₹48.6L', height: '100%', active: true },
                { label: 'Chhath', val: '₹22.5L', height: '60%' },
                { label: 'Wedding', val: '₹38.2L', height: '88%' }
            ]
        },
        'fy26': {
            total: '₹2.95 Cr Full FY',
            bars: [
                { label: 'Q1', val: '₹58.2L', height: '65%' },
                { label: 'Q2', val: '₹72.4L', height: '80%' },
                { label: 'Q3', val: '₹89.8L', height: '95%' },
                { label: 'Q4 (Est)', val: '₹98.5L', height: '100%', active: true }
            ]
        }
    };

    // ── Change Analytics Timeframe ──
    window.changeAnalyticsTimeframe = function (period) {
        const data = timeframeData[period] || timeframeData['6m'];

        // Update active button pills
        document.querySelectorAll('.dt-analytics-tf-btn').forEach(btn => {
            if (btn.getAttribute('data-tf') === period) {
                btn.className = 'dt-btn dt-btn-gold dt-btn-sm dt-analytics-tf-btn';
            } else {
                btn.className = 'dt-btn dt-btn-pale dt-btn-sm dt-analytics-tf-btn';
            }
        });

        // Update Total Pill
        const totalEl = document.getElementById('analyticsTotalPill');
        if (totalEl) totalEl.innerText = data.total;

        // Render Bar Charts
        const wrap = document.getElementById('analyticsChartBarsWrap');
        if (wrap) {
            wrap.innerHTML = data.bars.map(b => `
                <div class="dt-chart-bar-group">
                    <span class="dt-chart-bar-val" ${b.active ? 'style="color:#8A681F; font-weight:900;"' : ''}>${b.val}</span>
                    <div class="dt-chart-bar-pill ${b.active ? 'active' : ''}" style="height:${b.height};"></div>
                    <span class="dt-chart-bar-label" ${b.active ? 'style="color:#8A681F; font-weight:900;"' : ''}>${b.label}</span>
                </div>
            `).join('');
        }

        window.showToast(`📊 Timeframe switched to: ${period.toUpperCase()}`);
    };

    // ── Export Analytics CSV Report ──
    window.exportAnalyticsReport = function () {
        const rows = [
            ['Metric / Dimension', 'Period', 'Value (INR)', 'YoY Growth (%)'],
            ['Annual Wholesale GMV', 'FY 2025-26', '14200000', '+24.6%'],
            ['Average Wholesale Lot Order Value', 'LTM', '118500', '+12.4%'],
            ['On-Time Trade Credit Settlement', 'LTM', '99.2%', '+3.8%'],
            ['Re-Order Retention Rate', 'Active B2B Accounts', '88.5%', '+5.2%'],
            ['Top 1: Shree Balaji Textile Emporium', 'Surat (64 Orders)', '2450000', 'Platinum VIP'],
            ['Top 2: Varanasi Weaves & Silks', 'Varanasi (48 Orders)', '1890000', 'Platinum VIP'],
            ['Top 3: Jaipur Royal Saree Distributors', 'Jaipur (36 Orders)', '1240000', 'Gold Distributor'],
            ['Top 4: Kanchipuram Silk Syndicate', 'Chennai (28 Orders)', '980000', 'Silver Bulk'],
            ['Top 5: Kolkata Handloom Guild', 'Kolkata (22 Orders)', '820000', 'Silver Bulk']
        ];

        let csvContent = 'data:text/csv;charset=utf-8,' + rows.map(e => e.join(',')).join('\n');
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', 'Wholesale_GMV_Analytics_Report_2026.csv');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        window.showToast('📊 Exported: Wholesale_GMV_Analytics_Report_2026.csv');
    };

})();
