<?php
/**
 * modals.php — ARNIYA Admin Shared Reusable Modals & Dialogs
 */
?>
<!-- ══ Modal 1: Export Dashboard Modal ══ -->
<div class="adm-modal-backdrop" id="admExportModal" style="display:none;">
    <div class="adm-modal-box">
        <div class="adm-modal-header">
            <h3 class="adm-modal-title">📊 Export ARNIYA Business Intelligence</h3>
            <button type="button" class="adm-modal-close" onclick="window.closeAdmModal('admExportModal')">✕</button>
        </div>
        <div class="adm-modal-body">
            <p class="adm-modal-desc">Select report format and date granularity to download current metrics.</p>
            <div class="adm-export-grid">
                <label class="adm-export-option">
                    <input type="radio" name="export_format" value="csv" checked>
                    <div class="adm-export-card">
                        <span class="adm-export-icon">📄</span>
                        <div class="adm-export-name">CSV Spreadsheet</div>
                        <span class="adm-export-sub">Raw structured data</span>
                    </div>
                </label>
                <label class="adm-export-option">
                    <input type="radio" name="export_format" value="excel">
                    <div class="adm-export-card">
                        <span class="adm-export-icon">📊</span>
                        <div class="adm-export-name">Excel (.xlsx)</div>
                        <span class="adm-export-sub">Formatted workbooks</span>
                    </div>
                </label>
                <label class="adm-export-option">
                    <input type="radio" name="export_format" value="pdf">
                    <div class="adm-export-card">
                        <span class="adm-export-icon">📑</span>
                        <div class="adm-export-name">PDF Executive Report</div>
                        <span class="adm-export-sub">Print-ready summary</span>
                    </div>
                </label>
                <label class="adm-export-option">
                    <input type="radio" name="export_format" value="print">
                    <div class="adm-export-card">
                        <span class="adm-export-icon">🖨️</span>
                        <div class="adm-export-name">Direct Print</div>
                        <span class="adm-export-sub">Thermal & A4 layout</span>
                    </div>
                </label>
            </div>
            <div class="adm-form-group" style="margin-top:16px;">
                <label class="adm-form-label">Data Modules to Include</label>
                <div class="adm-checkbox-list">
                    <label><input type="checkbox" checked> Gross Revenue & Net Profit</label>
                    <label><input type="checkbox" checked> Wholesale & Reseller Consignments</label>
                    <label><input type="checkbox" checked> Inventory & Low Stock Alerts</label>
                    <label><input type="checkbox" checked> GST Tax Summary</label>
                </div>
            </div>
        </div>
        <div class="adm-modal-footer">
            <button type="button" class="adm-btn-secondary" onclick="window.closeAdmModal('admExportModal')">Cancel</button>
            <button type="button" class="adm-btn-primary" onclick="window.triggerExportDownload()">⬇️ Download Export</button>
        </div>
    </div>
</div>

<!-- ══ Modal 2: Dashboard Customization Modal ══ -->
<div class="adm-modal-backdrop" id="admCustomizeModal" style="display:none;">
    <div class="adm-modal-box">
        <div class="adm-modal-header">
            <h3 class="adm-modal-title">🎨 Customize Dashboard Widgets</h3>
            <button type="button" class="adm-modal-close" onclick="window.closeAdmModal('admCustomizeModal')">✕</button>
        </div>
        <div class="adm-modal-body">
            <p class="adm-modal-desc">Toggle and reorder widgets to tailor your command center view.</p>
            <div class="adm-widget-toggles">
                <label class="adm-widget-item"><input type="checkbox" id="toggle_live_status" checked> <span>Live Business Ticker</span></label>
                <label class="adm-widget-item"><input type="checkbox" id="toggle_kpi_cards" checked> <span>22 Core KPI Metric Cards</span></label>
                <label class="adm-widget-item"><input type="checkbox" id="toggle_revenue_chart" checked> <span>Revenue & Sales Analytics Chart</span></label>
                <label class="adm-widget-item"><input type="checkbox" id="toggle_order_pipeline" checked> <span>Order Status Pipeline Flow</span></label>
                <label class="adm-widget-item"><input type="checkbox" id="toggle_user_analytics" checked> <span>Sales by User Type (B2C, Reseller, Retailer, Wholesaler)</span></label>
                <label class="adm-widget-item"><input type="checkbox" id="toggle_top_products" checked> <span>Top Selling Sarees & Products</span></label>
                <label class="adm-widget-item"><input type="checkbox" id="toggle_low_stock" checked> <span>Low Stock Warning Center</span></label>
                <label class="adm-widget-item"><input type="checkbox" id="toggle_approvals" checked> <span>Pending Approval Hub (KYC / B2B)</span></label>
                <label class="adm-widget-item"><input type="checkbox" id="toggle_funnel" checked> <span>Cart & Checkout Funnel</span></label>
                <label class="adm-widget-item"><input type="checkbox" id="toggle_system_health" checked> <span>System Health & Diagnostics</span></label>
            </div>
        </div>
        <div class="adm-modal-footer">
            <button type="button" class="adm-btn-secondary" onclick="window.resetDashboardLayout()">Reset Default</button>
            <button type="button" class="adm-btn-primary" onclick="window.saveDashboardLayout()">Save Layout</button>
        </div>
    </div>
</div>

<!-- ══ Modal 3: Confirmation Dialog Modal ══ -->
<div class="adm-modal-backdrop" id="admConfirmModal" style="display:none;">
    <div class="adm-modal-box adm-modal-sm">
        <div class="adm-modal-header">
            <h3 class="adm-modal-title" id="admConfirmTitle">Confirm Action</h3>
            <button type="button" class="adm-modal-close" onclick="window.closeAdmModal('admConfirmModal')">✕</button>
        </div>
        <div class="adm-modal-body">
            <p class="adm-modal-desc" id="admConfirmMessage">Are you sure you want to proceed with this action?</p>
        </div>
        <div class="adm-modal-footer">
            <button type="button" class="adm-btn-secondary" onclick="window.closeAdmModal('admConfirmModal')">Cancel</button>
            <button type="button" class="adm-btn-primary danger" id="admConfirmActionBtn">Confirm</button>
        </div>
    </div>
</div>
