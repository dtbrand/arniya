/**
 * retail-analytics.js — DT Brand's & Jai Hanuman Tex
 * Retail Sourcing & Sales Velocity Multi-Period Engine
 */

(function () {
    'use strict';

    window.exportRetailCsvReport = function (reportType) {
        const rows = [
            ['Metric / Dimension', 'Value (INR / Count)', 'Period', 'Growth YoY'],
            ['Total Retail Sales', '5840000', 'LTM', '+28.4%'],
            ['Total Retail Orders', '1624', 'LTM', '+18.2%'],
            ['Retail Customers', '4820', 'All Time', '+32.0%'],
            ['Average Order Value', '3596', 'LTM', '+8.6%'],
            ['Units Sold', '3890', 'LTM', '+22.5%'],
            ['Cart Conversion Rate', '3.42%', 'LTM', '+0.8%']
        ];

        let csvContent = 'data:text/csv;charset=utf-8,' + rows.map(e => e.join(',')).join('\n');
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', `Retail_Analytics_Report_${reportType || '2026'}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        window.showToast(`📊 Exported Retail Analytics CSV!`);
    };

})();
