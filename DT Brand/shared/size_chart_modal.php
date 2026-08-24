<?php
/**
 * DT Brand/shared/size_chart_modal.php — Ethnic Wear & Saree Size Guide Modal
 */
?>
<!-- ════════════ SIZE CHART MODAL ════════════ -->
<div class="dt-modal-backdrop" id="dtSizeChartBackdrop" onclick="if(event.target===this) closeSizeChartModal();">
    <div class="dt-modal-card" style="max-width: 620px;">
        <div class="dt-modal-header">
            <div>
                <h3 class="dt-modal-title">Saree &amp; Ethnic Wear Measurements Guide</h3>
                <p style="margin:2px 0 0; font-size:0.75rem; color:#64748B;">Surat Handloom Standard Sizing &amp; Draping Specs</p>
            </div>
            <button class="dt-modal-close" onclick="closeSizeChartModal()" aria-label="Close">&times;</button>
        </div>

        <div class="dt-modal-body" style="padding: 16px 20px;">
            <div style="margin-bottom: 16px;">
                <h4 style="margin: 0 0 8px; font-size: 0.88rem; color: #111827; font-weight: 700;">1. Standard Saree Dimensions</h4>
                <table style="width: 100%; border-collapse: collapse; font-size: 0.82rem; text-align: left;">
                    <thead>
                        <tr style="background: #FAF5E8; border-bottom: 1.5px solid #D4AF37;">
                            <th style="padding: 8px 10px; color: #8A681F;">Measurement</th>
                            <th style="padding: 8px 10px; color: #8A681F;">Standard Metric</th>
                            <th style="padding: 8px 10px; color: #8A681F;">Imperial (Yards/Inches)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 8px 10px; font-weight: 600; color: #1F2937;">Saree Body Length</td>
                            <td style="padding: 8px 10px; color: #475569;">5.50 Metres</td>
                            <td style="padding: 8px 10px; color: #475569;">6.01 Yards</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 8px 10px; font-weight: 600; color: #1F2937;">Blouse Piece Length</td>
                            <td style="padding: 8px 10px; color: #475569;">0.80 Metres</td>
                            <td style="padding: 8px 10px; color: #475569;">31.5 Inches (Unstitched)</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 8px 10px; font-weight: 600; color: #1F2937;">Total Cut Length</td>
                            <td style="padding: 8px 10px; color: #475569;">6.30 Metres</td>
                            <td style="padding: 8px 10px; color: #475569;">6.88 Yards</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 10px; font-weight: 600; color: #1F2937;">Saree Width (Panna)</td>
                            <td style="padding: 8px 10px; color: #475569;">1.12 - 1.15 Metres</td>
                            <td style="padding: 8px 10px; color: #475569;">44 - 45 Inches</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div>
                <h4 style="margin: 0 0 8px; font-size: 0.88rem; color: #111827; font-weight: 700;">2. Kurti &amp; Ready-to-Wear Size Matrix</h4>
                <table style="width: 100%; border-collapse: collapse; font-size: 0.82rem; text-align: center;">
                    <thead>
                        <tr style="background: #FAF5E8; border-bottom: 1.5px solid #D4AF37;">
                            <th style="padding: 8px 10px; color: #8A681F; text-align: left;">Size Tag</th>
                            <th style="padding: 8px 10px; color: #8A681F;">Bust (Inches)</th>
                            <th style="padding: 8px 10px; color: #8A681F;">Waist (Inches)</th>
                            <th style="padding: 8px 10px; color: #8A681F;">Hip (Inches)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 8px 10px; font-weight: 700; color: #111827; text-align: left;">S (Small)</td>
                            <td style="padding: 8px 10px; color: #475569;">36"</td>
                            <td style="padding: 8px 10px; color: #475569;">32"</td>
                            <td style="padding: 8px 10px; color: #475569;">38"</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 8px 10px; font-weight: 700; color: #111827; text-align: left;">M (Medium)</td>
                            <td style="padding: 8px 10px; color: #475569;">38"</td>
                            <td style="padding: 8px 10px; color: #475569;">34"</td>
                            <td style="padding: 8px 10px; color: #475569;">40"</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 8px 10px; font-weight: 700; color: #111827; text-align: left;">L (Large)</td>
                            <td style="padding: 8px 10px; color: #475569;">40"</td>
                            <td style="padding: 8px 10px; color: #475569;">36"</td>
                            <td style="padding: 8px 10px; color: #475569;">42"</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            <td style="padding: 8px 10px; font-weight: 700; color: #111827; text-align: left;">XL (Extra Large)</td>
                            <td style="padding: 8px 10px; color: #475569;">42"</td>
                            <td style="padding: 8px 10px; color: #475569;">38"</td>
                            <td style="padding: 8px 10px; color: #475569;">44"</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 10px; font-weight: 700; color: #111827; text-align: left;">XXL (Double XL)</td>
                            <td style="padding: 8px 10px; color: #475569;">44"</td>
                            <td style="padding: 8px 10px; color: #475569;">40"</td>
                            <td style="padding: 8px 10px; color: #475569;">46"</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="dt-modal-footer">
            <button class="dt-btn-gold" style="width: 100%;" onclick="closeSizeChartModal()">Got It &bull; Close Guide</button>
        </div>
    </div>
</div>

<script>
function openSizeChartModal() {
    var m = document.getElementById('dtSizeChartBackdrop');
    if (m) m.classList.add('active');
}
function closeSizeChartModal() {
    var m = document.getElementById('dtSizeChartBackdrop');
    if (m) m.classList.remove('active');
}
</script>
