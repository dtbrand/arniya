/**
 * dashboard.js — ARNIYA Executive Dashboard Interactive Analytics Engine
 * DT Brand's & Jai Hanuman Tex
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        renderRevenueChart('30d');
        renderCategoryPieChart();
        renderUserTypeChart();
        renderKPISparklines();
        initMetricToggles();
    });

    // ════ 1. PRIMARY MULTI-CHANNEL REVENUE CANVAS CHART ════
    let currentMetric = 'revenue'; // 'revenue' | 'orders' | 'profit'
    let currentPeriod = '30d';

    window.updateDashboardDateRange = function(range) {
        currentPeriod = range;
        renderRevenueChart(range);
    };

    function initMetricToggles() {
        const toggles = document.querySelectorAll('.adm-metric-toggle');
        toggles.forEach(function(btn) {
            btn.addEventListener('click', function() {
                toggles.forEach(function(b) { b.classList.remove('active'); });
                this.classList.add('active');
                currentMetric = this.getAttribute('data-metric') || 'revenue';
                renderRevenueChart(currentPeriod);
            });
        });
    }

    function renderRevenueChart(period) {
        const canvas = document.getElementById('admRevenueChart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const dpr = window.devicePixelRatio || 1;
        const rect = canvas.getBoundingClientRect();

        canvas.width = rect.width * dpr;
        canvas.height = rect.height * dpr;
        ctx.scale(dpr, dpr);

        const w = rect.width;
        const h = rect.height;
        ctx.clearRect(0, 0, w, h);

        // Datasets based on selected metric
        let dataB2B = [42, 48, 55, 50, 68, 72, 85, 94, 88, 102, 115, 128];
        let dataReseller = [22, 28, 32, 30, 42, 45, 52, 58, 62, 68, 74, 82];
        let dataB2C = [15, 18, 22, 20, 26, 29, 34, 38, 41, 46, 50, 56];
        const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        if (period === '7d') {
            dataB2B = [12, 15, 18, 14, 22, 26, 30];
            dataReseller = [8, 10, 12, 9, 14, 16, 19];
            dataB2C = [5, 6, 8, 7, 10, 11, 13];
        }

        const maxVal = 140;
        const padX = 40;
        const padY = 24;
        const chartW = w - padX * 2;
        const chartH = h - padY * 2;

        // Draw Light Gridlines
        ctx.strokeStyle = '#EFE9DC';
        ctx.lineWidth = 1;
        ctx.setLineDash([4, 4]);

        for (let i = 0; i <= 4; i++) {
            const y = padY + (chartH / 4) * i;
            ctx.beginPath();
            ctx.moveTo(padX, y);
            ctx.lineTo(w - padX, y);
            ctx.stroke();

            // Value Labels
            ctx.fillStyle = '#A8A29E';
            ctx.font = '10px Plus Jakarta Sans, sans-serif';
            ctx.fillText('₹' + Math.round(maxVal - (maxVal / 4) * i) + 'k', 6, y + 4);
        }
        ctx.setLineDash([]);

        // Plot Function
        function plotLine(data, strokeColor, fillColor) {
            const stepX = chartW / (data.length - 1);
            const points = [];

            for (let i = 0; i < data.length; i++) {
                const px = padX + i * stepX;
                const py = padY + chartH - (data[i] / maxVal) * chartH;
                points.push({ x: px, y: py });
            }

            // Fill Area Gradient
            if (fillColor) {
                const grad = ctx.createLinearGradient(0, padY, 0, h - padY);
                grad.addColorStop(0, fillColor);
                grad.addColorStop(1, 'rgba(255, 255, 255, 0)');

                ctx.beginPath();
                ctx.moveTo(points[0].x, points[0].y);
                for (let i = 1; i < points.length; i++) {
                    const cx = (points[i - 1].x + points[i].x) / 2;
                    ctx.bezierCurveTo(cx, points[i - 1].y, cx, points[i].y, points[i].x, points[i].y);
                }
                ctx.lineTo(points[points.length - 1].x, h - padY);
                ctx.lineTo(points[0].x, h - padY);
                ctx.closePath();
                ctx.fillStyle = grad;
                ctx.fill();
            }

            // Stroke Line
            ctx.beginPath();
            ctx.moveTo(points[0].x, points[0].y);
            for (let i = 1; i < points.length; i++) {
                const cx = (points[i - 1].x + points[i].x) / 2;
                ctx.bezierCurveTo(cx, points[i - 1].y, cx, points[i].y, points[i].x, points[i].y);
            }
            ctx.strokeStyle = strokeColor;
            ctx.lineWidth = 2.5;
            ctx.stroke();

            // Draw Dots
            points.forEach(function(pt) {
                ctx.beginPath();
                ctx.arc(pt.x, pt.y, 4, 0, Math.PI * 2);
                ctx.fillStyle = '#FFFFFF';
                ctx.fill();
                ctx.strokeStyle = strokeColor;
                ctx.lineWidth = 2;
                ctx.stroke();
            });
        }

        // Draw datasets
        plotLine(dataB2B, '#8A681F', 'rgba(138, 104, 31, 0.16)');
        plotLine(dataReseller, '#7C3AED', 'rgba(124, 58, 237, 0.10)');
        plotLine(dataB2C, '#16A34A', 'rgba(22, 163, 74, 0.08)');
    }

    // ════ 2. SALES BY CATEGORY DONUT CHART ════
    function renderCategoryPieChart() {
        const canvas = document.getElementById('admCategoryChart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const dpr = window.devicePixelRatio || 1;
        const rect = canvas.getBoundingClientRect();

        canvas.width = rect.width * dpr;
        canvas.height = rect.height * dpr;
        ctx.scale(dpr, dpr);

        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        const radius = Math.min(centerX, centerY) - 15;
        const innerRadius = radius * 0.65;

        const slices = [
            { val: 45, color: '#8A681F', label: 'Silk Sarees' },
            { val: 25, color: '#D4AF37', label: 'Bridal Lehengas' },
            { val: 18, color: '#16A34A', label: 'Designer Kurtis' },
            { val: 12, color: '#0284C7', label: 'Unstitched Fabrics' }
        ];

        let startAngle = -Math.PI / 2;

        slices.forEach(function(slice) {
            const sliceAngle = (slice.val / 100) * Math.PI * 2;
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius, startAngle, startAngle + sliceAngle);
            ctx.arc(centerX, centerY, innerRadius, startAngle + sliceAngle, startAngle, true);
            ctx.closePath();
            ctx.fillStyle = slice.color;
            ctx.fill();
            startAngle += sliceAngle;
        });

        // Center Text
        ctx.fillStyle = '#1C1917';
        ctx.font = 'bold 16px Cinzel, serif';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText('100%', centerX, centerY - 6);

        ctx.fillStyle = '#78716C';
        ctx.font = '10px Plus Jakarta Sans, sans-serif';
        ctx.fillText('Catalog Share', centerX, centerY + 12);
    }

    // ════ 3. SALES BY USER TYPE CHART ════
    function renderUserTypeChart() {
        const canvas = document.getElementById('admUserTypeChart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const dpr = window.devicePixelRatio || 1;
        const rect = canvas.getBoundingClientRect();

        canvas.width = rect.width * dpr;
        canvas.height = rect.height * dpr;
        ctx.scale(dpr, dpr);

        const w = rect.width;
        const h = rect.height;

        const data = [
            { label: 'Wholesale B2B', val: 52, color: '#8A681F' },
            { label: 'Resellers', val: 28, color: '#7C3AED' },
            { label: 'Retailers', val: 12, color: '#0284C7' },
            { label: 'Direct B2C', val: 8, color: '#16A34A' }
        ];

        const barH = 22;
        const gap = 14;
        let startY = 16;

        data.forEach(function(item) {
            ctx.fillStyle = '#1C1917';
            ctx.font = 'bold 11px Plus Jakarta Sans, sans-serif';
            ctx.textAlign = 'left';
            ctx.fillText(item.label, 10, startY + 12);

            ctx.fillStyle = '#78716C';
            ctx.textAlign = 'right';
            ctx.fillText(item.val + '% (₹' + (item.val * 82000).toLocaleString() + ')', w - 10, startY + 12);

            // Bar background
            ctx.fillStyle = '#EFE9DC';
            ctx.beginPath();
            ctx.roundRect(10, startY + 18, w - 20, 8, 4);
            ctx.fill();

            // Bar fill
            ctx.fillStyle = item.color;
            ctx.beginPath();
            ctx.roundRect(10, startY + 18, (w - 20) * (item.val / 100), 8, 4);
            ctx.fill();

            startY += barH + gap;
        });
    }

    // ════ 4. SVG SPARKLINES GENERATOR FOR ALL 22 KPI CARDS ════
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

    // Window Resize Handler to redraw canvas charts crisply
    window.addEventListener('resize', function() {
        renderRevenueChart(currentPeriod);
        renderCategoryPieChart();
        renderUserTypeChart();
    });

})();
