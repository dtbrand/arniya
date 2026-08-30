<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * wholesale-orders.php — DT Brand's & Jai Hanuman Tex
 * Wholesale Sourcing Orders & Bulk POs Component (100% Dynamic)
 */
require_once __DIR__ . '/wholesale-data.php';
$whl_id = isset($_GET['id']) ? $_GET['id'] : (isset($wholesale['id']) ? $wholesale['id'] : 'WHL-8012');
$wholesale = isset($wholesale) && is_array($wholesale) ? $wholesale : getWholesalePartner($whl_id);
$wholesale_orders = getWholesaleOrders($wholesale['id']);
?>

<div style="display:flex; flex-direction:column; gap:16px;">

    <!-- ══ 1. 4-CARD WHOLESALE ORDERS KPI RIBBON ══ -->
    <div class="dt-pricing-kpi-grid">
        <div class="dt-pricing-kpi-card">
            <div class="dt-pricing-kpi-top">
                <span class="dt-pricing-kpi-label">ACTIVE WHOLESALE POS</span>
                <div class="dt-pricing-kpi-icon">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                </div>
            </div>
            <div class="dt-pricing-kpi-val">412 Orders</div>
            <div class="dt-pricing-kpi-bot">
                <span>Across All B2B Accounts</span>
                <span style="color:#8A681F; font-weight:800;">+18 This Week</span>
            </div>
        </div>

        <div class="dt-pricing-kpi-card">
            <div class="dt-pricing-kpi-top">
                <span class="dt-pricing-kpi-label">TOTAL DISPATCH VALUE</span>
                <div class="dt-pricing-kpi-icon emerald">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                </div>
            </div>
            <div class="dt-pricing-kpi-val" style="color:#15803D;">₹48.2 Lakhs</div>
            <div class="dt-pricing-kpi-bot">
                <span>Total Invoice Volume</span>
                <span style="color:#15803D; font-weight:800;">Avg ₹1.17L / Lot</span>
            </div>
        </div>

        <div class="dt-pricing-kpi-card">
            <div class="dt-pricing-kpi-top">
                <span class="dt-pricing-kpi-label">IN PROCESSING &amp; PACKING</span>
                <div class="dt-pricing-kpi-icon">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
            </div>
            <div class="dt-pricing-kpi-val" style="color:#B45309;">18 Lots</div>
            <div class="dt-pricing-kpi-bot">
                <span>Surat Main Warehouse</span>
                <span style="color:#B45309; font-weight:800;">Dispatch Today</span>
            </div>
        </div>

        <div class="dt-pricing-kpi-card">
            <div class="dt-pricing-kpi-top">
                <span class="dt-pricing-kpi-label">DELIVERED &amp; SETTLED</span>
                <div class="dt-pricing-kpi-icon blue">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </div>
            </div>
            <div class="dt-pricing-kpi-val" style="color:#1D4ED8;">394 Lots</div>
            <div class="dt-pricing-kpi-bot">
                <span>100% Verified Delivery</span>
                <span style="color:#1D4ED8; font-weight:800;">98.5% On-Time</span>
            </div>
        </div>
    </div>

    <!-- ══ 2. MASTER PURCHASE ORDERS TABLE CARD ══ -->
    <div class="dt-card" style="background:#FFFFFF; border:1.5px solid #EAE5D9; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.02); overflow:hidden;">
        <!-- Toolbar Header -->
        <div style="padding:12px 16px; border-bottom:1.5px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:28px; height:28px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                </div>
                <div>
                    <h4 style="font-size:0.9rem; font-weight:800; color:#181512; margin:0;">Wholesale Purchase Orders &amp; Dispatches</h4>
                    <p style="font-size:0.7rem; color:#78716C; margin:1px 0 0 0;">Bulk saree lots, trade credit debits, and logistics fulfillment.</p>
                </div>
            </div>

            <!-- Filter & Search Controls -->
            <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                <!-- Live Search Box -->
                <div style="position:relative; width:200px;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#78716C" stroke-width="2.2" style="position:absolute; left:9px; top:50%; transform:translateY(-50%); pointer-events:none;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" id="wholesaleOrderSearchInput" class="dt-wholesale-input" style="width:100%; height:30px; padding-left:28px; font-size:0.72rem; border-radius:6px; border:1.2px solid #EAE5D9; box-sizing:border-box;" placeholder="Search PO ID, Fabric, SKU..." oninput="filterWholesaleOrders()">
                </div>

                <!-- Status Filter -->
                <select id="wholesaleOrderStatusFilter" class="dt-wholesale-input" style="height:30px; font-size:0.72rem; padding:0 8px; border-radius:6px; border:1.2px solid #EAE5D9; box-sizing:border-box;" onchange="filterWholesaleOrders()">
                    <option value="all">All Statuses</option>
                    <option value="processing">Processing Dispatch</option>
                    <option value="delivered">Delivered &amp; Settled</option>
                </select>

                <!-- Export Button -->
                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="exportWholesaleOrdersCsv('<?php echo $wholesale['id']; ?>')">
                    <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Export CSV</span>
                </button>
            </div>
        </div>

        <div style="overflow-x:auto; width:100%;">
            <table class="dt-wholesale-table">
                <thead>
                    <tr>
                        <th style="white-space:nowrap;">PO / Order ID</th>
                        <th style="white-space:nowrap;">Order Date</th>
                        <th style="white-space:nowrap;">Product Lots &amp; SKUs</th>
                        <th style="text-align:right; white-space:nowrap;">Order Total (₹)</th>
                        <th style="white-space:nowrap;">Payment Mode</th>
                        <th style="white-space:nowrap;">Fulfillment Status</th>
                        <th style="text-align:right; white-space:nowrap;">Actions</th>
                    </tr>
                </thead>
                <tbody id="wholesaleOrdersTableBody">
                    <?php foreach ($wholesale_orders as $o): ?>
                        <tr class="wholesale-order-row" data-status="<?php echo strtolower(explode(' ', $o['status'])[0]); ?>" style="border-bottom:1px solid #F1ECE1;">
                            <td class="order-id-cell" style="font-family:monospace; font-weight:800; color:#8A681F; white-space:nowrap;"><?php echo $o['id']; ?></td>
                            <td style="color:#78716C; font-size:0.75rem; white-space:nowrap;"><?php echo $o['date']; ?></td>
                            <td class="order-items-cell" style="font-weight:700; color:#181512; white-space:nowrap;"><?php echo $o['items']; ?></td>
                            <td style="text-align:right; font-weight:900; color:#181512; font-size:0.85rem; white-space:nowrap;"><?php echo $o['amount']; ?></td>
                            <td class="order-payment-cell" style="font-size:0.75rem; color:#78716C; white-space:nowrap;"><?php echo $o['payment']; ?></td>
                            <td style="white-space:nowrap;">
                                <span class="dt-status-pill-clean <?php echo $o['badge']; ?>"><?php echo $o['status']; ?></span>
                            </td>
                            <td style="text-align:right; white-space:nowrap;">
                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="openWholesaleOrderModal('<?php echo $o['id']; ?>', '<?php echo $o['date']; ?>', '<?php echo addslashes($o['items']); ?>', '<?php echo $o['amount']; ?>', '<?php echo addslashes($o['payment']); ?>', '<?php echo addslashes($o['status']); ?>', '<?php echo addslashes($wholesale['name']); ?>', '<?php echo $wholesale['id']; ?>')">
                                    <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    <span>View Order</span>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     WHOLESALE PURCHASE ORDER DETAILS MODAL
══════════════════════════════════════════════════════════════ -->
<div id="dtWholesaleOrderModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px); padding:16px;">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:14px; width:95%; max-width:540px; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Wholesale Purchase Order Particulars</strong>
            </div>
            <button type="button" onclick="closeWholesaleModal('dtWholesaleOrderModal')" class="dt-drawer-close" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <div class="dt-modal-body" style="padding:18px; display:flex; flex-direction:column; gap:12px;">
            <!-- Header Strip -->
            <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:10px 14px; display:grid; grid-template-columns:1fr 1fr; gap:8px; font-size:0.75rem;">
                <div>
                    <span style="color:#78716C; display:block;">PO / Order ID:</span>
                    <strong id="modalWhlOrderId" style="font-family:monospace; color:#8A681F; font-size:0.9rem;">ORD-WHL-8112</strong>
                </div>
                <div style="text-align:right;">
                    <span style="color:#78716C; display:block;">Order Date:</span>
                    <strong id="modalWhlOrderDate" style="color:#181512;">22 Aug 2026</strong>
                </div>
            </div>

            <!-- Wholesaler Details -->
            <div style="background:#FFFFFF; border:1px solid #EAE5D9; border-radius:8px; padding:12px 14px; display:flex; flex-direction:column; gap:8px; font-size:0.78rem;">
                <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px dashed #F1ECE1; padding-bottom:6px;">
                    <span style="color:#78716C;">Partner Wholesaler:</span>
                    <strong id="modalWhlOrderPartner" style="color:#181512;">Shree Balaji Silk Mills (WHL-8012)</strong>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px dashed #F1ECE1; padding-bottom:6px;">
                    <span style="color:#78716C;">Product Lots &amp; SKUs:</span>
                    <strong id="modalWhlOrderItems" style="color:#181512; text-align:right;">120 Saree Lots (Pure Kanjeevaram &amp; Banarasi Silk)</strong>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px dashed #F1ECE1; padding-bottom:6px;">
                    <span style="color:#78716C;">Payment Terms:</span>
                    <strong id="modalWhlOrderPayment" style="color:#8A681F;">Net 30 Days (Revolving Credit)</strong>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="color:#78716C;">Fulfillment Status:</span>
                    <span id="modalWhlOrderStatus" class="dt-status-pill-clean amber">Processing Dispatch</span>
                </div>
            </div>

            <!-- Total Amount Card -->
            <div style="background:linear-gradient(135deg, #181512 0%, #2A241E 100%); border:1px solid #8A681F; border-radius:8px; padding:12px 16px; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <span style="font-size:0.68rem; color:#FFE57F; font-weight:800; text-transform:uppercase;">TOTAL COMMERCIAL INVOICE</span>
                    <div id="modalWhlOrderAmount" style="font-size:1.4rem; font-weight:900; color:#FFFFFF; margin-top:2px;">₹84,500</div>
                </div>
                <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" onclick="sendOrderWhatsAppNotice()">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#FFFFFF" stroke-width="2.3"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                    <span>WhatsApp Update</span>
                </button>
            </div>
        </div>

        <div class="dt-modal-foot" style="padding:12px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:flex-end; gap:8px; background:#FAF8F4;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="closeWholesaleModal('dtWholesaleOrderModal')">Close</button>
            <a href="/admin/orders/index.php" class="dt-btn dt-btn-gold">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                <span>Full Orders Suite</span>
            </a>
        </div>
    </div>
</div>

