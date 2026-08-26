<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * return-panel.php — Return Request Management Partial
 * DT Brand's & Jai Hanuman Tex
 */
$returns_list = [
    [
        'id' => 'RMA-9021',
        'order_id' => 'DTB-001618',
        'type' => 'customer',
        'type_label' => 'Customer Return',
        'customer' => 'Shree Saree Niketan',
        'contact' => '+91 98221 00192',
        'city' => 'Surat Wholesale Lot',
        'product' => 'Chanderi Zari Tissue Festive Saree (x5)',
        'sku' => 'SKU-CHN-ZRI-882',
        'reason' => 'Shade Variation in Lot',
        'amount' => 12450,
        'status' => 'pending',
        'status_label' => 'Pending Review',
        'date' => '20 Aug 2026',
        'carrier' => 'BlueDart Air Reverse',
        'awb' => 'BLU-REV-99210',
        'note' => 'Customer reported 2 sarees had significant color variation from master swatch. High-resolution photos & unbroken unboxing video submitted.',
        'video_duration' => '0:42 HD',
        'qc_status' => 'Pending Depot Intake'
    ],
    [
        'id' => 'RMA-9020',
        'order_id' => 'DTB-001614',
        'type' => 'customer',
        'type_label' => 'Customer Return',
        'customer' => 'Kavita Agarwal',
        'contact' => '+91 98765 43210',
        'city' => 'Ahmedabad Retail',
        'product' => 'Banarasi Katan Silk Handloom (x1)',
        'sku' => 'SKU-BAN-KTN-104',
        'reason' => 'Defective Zari Thread',
        'amount' => 6490,
        'status' => 'confirmed',
        'status_label' => 'Approved for Pickup',
        'date' => '19 Aug 2026',
        'carrier' => 'Delhivery Surface',
        'awb' => 'DLV-REV-88312',
        'note' => 'Pallu zari thread pull defect near the border. QC approved for 100% reverse courier replacement/refund.',
        'video_duration' => '0:35 HD',
        'qc_status' => 'Verified by Quality Dept'
    ],
    [
        'id' => 'RMA-9019',
        'order_id' => 'DTB-001595',
        'type' => 'rto',
        'type_label' => 'RTO Consignment',
        'customer' => 'Vardhman Tex Godown',
        'contact' => '+91 98220 19283',
        'city' => 'Surat Central Depot',
        'product' => 'Pure Kanjivaram Bridal Silk (x2)',
        'sku' => 'SKU-KNJ-BRD-550',
        'reason' => 'RTO: Buyer Godown Closed (3 Attempts)',
        'amount' => 24000,
        'status' => 'shipped',
        'status_label' => 'Depot Inspection',
        'date' => '17 Aug 2026',
        'carrier' => 'VRL Cargo Depot',
        'awb' => 'VRL-RTO-77192',
        'note' => 'Transporter attempted delivery 3 times. Consignee godown was shut for inventory. Returned to Surat depot dock in tamper-proof bag.',
        'video_duration' => '1:10 HD',
        'qc_status' => 'Dock Receiving Scan Done'
    ],
    [
        'id' => 'RMA-9018',
        'order_id' => 'DTB-001588',
        'type' => 'customer',
        'type_label' => 'Customer Return',
        'customer' => 'Ananya Silks Bangalore',
        'contact' => '+91 98450 11223',
        'city' => 'Bangalore Hub',
        'product' => 'Organza Digital Floral Saree (x10)',
        'sku' => 'SKU-ORG-FLR-202',
        'reason' => 'Wrong Catalog Color Dispatched',
        'amount' => 18500,
        'status' => 'delivered',
        'status_label' => 'Completed & Restocked',
        'date' => '15 Aug 2026',
        'carrier' => 'DTDC Express Air',
        'awb' => 'DTC-REV-39108',
        'note' => 'Received Pastel Green instead of Rose Gold edition. Package returned, verified intact, and credited to B2B Wholesale Ledger.',
        'video_duration' => '0:55 HD',
        'qc_status' => 'Restocked to Central Rack B-12'
    ]
];

$tab_filter = $_GET['tab'] ?? 'all';
$tab_status_map = [
    'requested' => 'pending',
    'approved' => 'confirmed',
    'received' => 'shipped',
    'completed' => 'delivered'
];
if ($tab_filter !== 'all' && isset($tab_status_map[$tab_filter])) {
    $target_status = $tab_status_map[$tab_filter];
    $filtered_returns = array_filter($returns_list, function($item) use ($target_status) {
        return $item['status'] === $target_status;
    });
    if (!empty($filtered_returns)) {
        $returns_list = array_values($filtered_returns);
    }
}
?>
<!-- ══ 4-Card Master RMA KPI Ribbon ══ -->
<div class="dt-master-kpi-grid" style="margin-bottom:14px;">
    <div class="dt-master-kpi-card active">
        <div class="dt-kpi-header">
            <span class="dt-kpi-tag">Total RMA Volume</span>
            <div class="dt-kpi-icon-pill gold">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
            </div>
        </div>
        <div class="dt-kpi-number-wrap">
            <span class="dt-kpi-main-number">₹61,440</span>
            <span class="dt-kpi-trend-pill gold">8 Claims</span>
        </div>
        <div style="font-size:11px; color:#64748B; margin-top:2px;">Customer Returns + RTO Packages</div>
    </div>

    <div class="dt-master-kpi-card">
        <div class="dt-kpi-header">
            <span class="dt-kpi-tag">Pending Review</span>
            <div class="dt-kpi-icon-pill amber">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            </div>
        </div>
        <div class="dt-kpi-number-wrap">
            <span class="dt-kpi-main-number">₹12,450</span>
            <span class="dt-kpi-trend-pill amber">2 Action Req.</span>
        </div>
        <div style="font-size:11px; color:#64748B; margin-top:2px;">Unboxing Evidence Verification</div>
    </div>

    <div class="dt-master-kpi-card">
        <div class="dt-kpi-header">
            <span class="dt-kpi-tag">Approved for Pickup</span>
            <div class="dt-kpi-icon-pill blue">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
            </div>
        </div>
        <div class="dt-kpi-number-wrap">
            <span class="dt-kpi-main-number">₹18,940</span>
            <span class="dt-kpi-trend-pill blue">3 Reverse AWB</span>
        </div>
        <div style="font-size:11px; color:#64748B; margin-top:2px;">Courier Assigned &amp; In-Transit</div>
    </div>

    <div class="dt-master-kpi-card">
        <div class="dt-kpi-header">
            <span class="dt-kpi-tag">Depot Restocked</span>
            <div class="dt-kpi-icon-pill emerald">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
            </div>
        </div>
        <div class="dt-kpi-number-wrap">
            <span class="dt-kpi-main-number">₹30,050</span>
            <span class="dt-kpi-trend-pill emerald">100% Audited</span>
        </div>
        <div style="font-size:11px; color:#64748B; margin-top:2px;">Surat Central Rack B2B Inventory</div>
    </div>
</div>

<!-- ══ Toolbar & Debounced Live Search ══ -->
<div class="dt-returns-toolbar">
    <div class="dt-returns-toolbar-left">
        <input type="text" id="rmaSearchInput" oninput="window.DT_RETURNS.handleSearch(this.value)" placeholder="Search RMA ID, Order ID, Customer, Courier AWB..." class="dt-order-search-input" style="height:36px; padding-left:12px; width:100%; border-radius:6px; box-sizing:border-box;">
        <button type="button" onclick="document.getElementById('rmaSearchInput').value=''; window.DT_RETURNS.handleSearch('');" style="position:absolute; right:8px; top:50%; transform:translateY(-50%); border:none; background:transparent; cursor:pointer; color:#94A3B8; font-size:12px;">✕</button>
    </div>
    <div class="dt-returns-toolbar-right">
        <!-- Quick Filter by Type -->
        <select id="rmaTypeFilterSelect" onchange="window.DT_RETURNS.filterByType(this.value)" class="dt-order-search-input" style="height:36px; font-weight:700; border-radius:6px; min-width:180px;">
            <option value="all">All RMA &amp; RTO Types</option>
            <option value="customer">Customer RMA Claims</option>
            <option value="rto">RTO Courier Returns</option>
        </select>

        <!-- Column Visibility Dropdown -->
        <div class="dt-col-dropdown-wrap" style="position:relative;">
            <button type="button" class="dt-btn dt-btn-pale" style="height:36px; padding:0 10px; font-size:11.5px; font-weight:700; white-space:nowrap; display:inline-flex; align-items:center; gap:5px;" onclick="window.DT_RETURNS.toggleColumnMenu(event)" title="Show or Hide Table Columns">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="9" y1="3" x2="9" y2="21"></line>
                    <line x1="15" y1="3" x2="15" y2="21"></line>
                </svg>
                <span>Columns</span>
                <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            
            <div id="rmaColumnVisibilityMenu" class="dt-col-menu" style="display:none; position:absolute; right:0; top:calc(100% + 6px); width:230px; background:#FFFFFF; border:1px solid #D4AF37; border-radius:8px; box-shadow:0 8px 24px rgba(0,0,0,0.14); padding:10px 12px; z-index:99999;">
                <div style="font-size:10.5px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:8px; display:flex; justify-content:space-between; align-items:center; border-bottom:1px dashed #E2DFD7; padding-bottom:6px;">
                    <span>Toggle Visible Columns</span>
                    <button type="button" onclick="window.DT_RETURNS.resetAllColumns()" style="background:none; border:none; font-size:10px; color:#1D4ED8; font-weight:700; cursor:pointer; padding:0;">Reset All</button>
                </div>
                <div style="display:flex; flex-direction:column; gap:5px; font-size:11px; color:#1E293B;">
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-rma-id" checked onchange="window.DT_RETURNS.toggleColumn('col-rma-id', this.checked)"> <span>Return ID &amp; Type</span></label>
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-rma-order" checked onchange="window.DT_RETURNS.toggleColumn('col-rma-order', this.checked)"> <span>Order Ref</span></label>
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-rma-customer" checked onchange="window.DT_RETURNS.toggleColumn('col-rma-customer', this.checked)"> <span>Customer &amp; Consignee</span></label>
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-rma-product" checked onchange="window.DT_RETURNS.toggleColumn('col-rma-product', this.checked)"> <span>Product Details</span></label>
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-rma-reason" checked onchange="window.DT_RETURNS.toggleColumn('col-rma-reason', this.checked)"> <span>Claim Reason</span></label>
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-rma-amount" checked onchange="window.DT_RETURNS.toggleColumn('col-rma-amount', this.checked)"> <span>Valuation (₹)</span></label>
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-rma-status" checked onchange="window.DT_RETURNS.toggleColumn('col-rma-status', this.checked)"> <span>Status Badge</span></label>
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-rma-actions" checked onchange="window.DT_RETURNS.toggleColumn('col-rma-actions', this.checked)"> <span>Row Actions</span></label>
                </div>
            </div>
        </div>

        <button type="button" onclick="window.location.reload();" class="dt-btn dt-btn-pale" style="height:36px; padding:0 12px; font-size:11.5px; font-weight:700; white-space:nowrap; display:inline-flex; align-items:center; gap:5px;">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
            <span>Refresh</span>
        </button>
    </div>
</div>

<!-- ══ Master RMA Ledger Table ══ -->
<div class="dt-order-table-card">
    <div class="dt-rma-table-wrap">
        <table class="dt-order-table" id="rmaLedgerTable" style="min-width:1080px; width:100%;">
            <thead>
                <tr>
                    <th class="col-rma-id" style="width:115px; white-space:nowrap;">Return ID</th>
                    <th class="col-rma-order" style="width:110px; white-space:nowrap;">Order Ref</th>
                    <th class="col-rma-customer" style="min-width:190px;">Customer</th>
                    <th class="col-rma-product" style="min-width:210px;">Product &amp; Qty</th>
                    <th class="col-rma-reason" style="min-width:170px;">Reason</th>
                    <th class="col-rma-amount" style="width:95px; white-space:nowrap;">Amount</th>
                    <th class="col-rma-status" style="width:130px; white-space:nowrap;">Status</th>
                    <th class="col-rma-actions" style="width:250px; text-align:right; white-space:nowrap;">Actions</th>
                </tr>
            </thead>
            <tbody id="rmaTableBody">
                <?php foreach ($returns_list as $r): ?>
                <tr id="returnRow_<?php echo $r['id']; ?>" data-id="<?php echo $r['id']; ?>" data-type="<?php echo $r['type']; ?>" data-status="<?php echo $r['status']; ?>">
                    <td class="col-rma-id" style="white-space:nowrap;">
                        <div style="font-weight:800; color:#8A681F;"><?php echo $r['id']; ?></div>
                        <span class="dt-return-type-pill <?php echo $r['type'] === 'rto' ? 'rto' : ''; ?>"><?php echo $r['type_label']; ?></span>
                    </td>
                    <td class="col-rma-order" style="white-space:nowrap;">
                        <a href="/admin/orders/view.php?id=<?php echo $r['order_id']; ?>" class="dt-order-id-link"><?php echo $r['order_id']; ?></a>
                        <div style="font-size:10px; color:#64748B; margin-top:1px;"><?php echo $r['date']; ?></div>
                    </td>
                    <td class="col-rma-customer">
                        <div style="font-weight:750; color:#181512; font-size:12px; line-height:1.3;"><?php echo htmlspecialchars($r['customer']); ?></div>
                        <div style="font-size:10.5px; color:#64748B; margin-top:1px;"><?php echo $r['city']; ?> • <?php echo $r['contact']; ?></div>
                    </td>
                    <td class="col-rma-product">
                        <div style="font-weight:600; color:#334155; font-size:12px;"><?php echo htmlspecialchars($r['product']); ?></div>
                        <div style="font-size:10px; color:#8A681F; font-weight:700; margin-top:1px;"><?php echo $r['sku']; ?></div>
                    </td>
                    <td class="col-rma-reason">
                        <span class="dt-return-reason-pill"><?php echo htmlspecialchars($r['reason']); ?></span>
                    </td>
                    <td class="col-rma-amount" style="font-weight:800; color:#DC2626; font-size:12.5px; white-space:nowrap;">
                        ₹<?php echo number_format($r['amount']); ?>
                    </td>
                    <td class="col-rma-status" style="white-space:nowrap;">
                        <span class="dt-status-badge <?php echo $r['status']; ?>">
                            <span class="dt-status-dot"></span>
                            <span><?php echo $r['status_label']; ?></span>
                        </span>
                    </td>
                    <td class="col-rma-actions" style="text-align:right; white-space:nowrap;">
                        <div style="display:inline-flex; align-items:center; justify-content:flex-end; gap:5px;">
                            <!-- View Return & Evidence Button -->
                            <button type="button" class="dt-btn" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8; height:28px; padding:0 8px; font-size:11px; font-weight:700;" onclick="window.DT_RETURNS.viewRmaDetails('<?php echo $r['id']; ?>')" title="View Evidence Photos, Unboxing Video & Details">
                                <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                <span>View</span>
                            </button>

                            <?php if ($r['status'] === 'pending'): ?>
                            <!-- Approve Action -->
                            <button type="button" class="dt-btn dt-btn-gold" style="height:28px; padding:0 9px; font-size:11px;" onclick="window.DT_RETURNS.approveReturn('<?php echo $r['id']; ?>')" title="Approve Return for Reverse Pickup">
                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="#181512" stroke-width="2.4"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <span>Approve</span>
                            </button>
                            <!-- Reject Action Popup Trigger -->
                            <button type="button" class="dt-btn dt-btn-danger" style="height:28px; padding:0 9px; font-size:11px;" onclick="window.DT_RETURNS.openRejectModal('<?php echo $r['id']; ?>')" title="Reject Claim">
                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                <span>Reject</span>
                            </button>
                            <?php endif; ?>

                            <!-- WhatsApp Slip Trigger -->
                            <button type="button" onclick="window.DT_RETURNS.shareWhatsApp('<?php echo $r['id']; ?>')" class="dt-btn" style="background:#15803D; border:1px solid #166534; color:#FFFFFF; height:28px; padding:0 8px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:3px;" title="WhatsApp Update">
                                <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="#FFFFFF"><path d="M17.472 14.382c-.301-.15-1.78-.878-2.056-.979-.276-.1-.476-.15-.677.15-.2.301-.777.979-.953 1.179-.176.2-.351.226-.652.075s-1.272-.469-2.423-1.496c-.896-.799-1.501-1.786-1.677-2.087-.176-.301-.019-.464.132-.614.136-.135.301-.351.451-.527.15-.176.2-.301.301-.501.101-.2.05-.376-.025-.527-.075-.15-.677-1.632-.927-2.234-.244-.587-.492-.507-.677-.516-.176-.008-.376-.01-.576-.01s-.527.075-.803.376c-.276.301-1.053 1.028-1.053 2.508 0 1.479 1.078 2.908 1.229 3.109.15.2 2.122 3.24 5.141 4.544.718.31 1.279.496 1.716.635.722.23 1.38.197 1.9-.12.58-.352 1.78-1.454 2.03-2.86.251-1.406.251-2.61.176-2.86-.075-.251-.276-.376-.576-.527zM12 2C6.477 2 2 6.477 2 12c0 1.77.462 3.433 1.27 4.887L2 22l5.24-1.374A9.953 9.953 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"></path></svg>
                                <span>WhatsApp</span>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════ -->
<!-- 🪟 1. VIEW RMA DETAILS, EVIDENCE PHOTOS & VIDEO MODAL         -->
<!-- ══════════════════════════════════════════════════════════════ -->
<div id="viewRmaModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.65); z-index:999999; backdrop-filter:blur(4px); align-items:center; justify-content:center;" onclick="if(event.target===this)window.DT_RETURNS.closeRmaModal()">
    <div style="background:#FFFFFF; border:1.5px solid #D4AF37; border-radius:12px; width:95%; max-width:760px; max-height:88vh; height:auto; box-shadow:0 14px 44px rgba(0,0,0,0.35); overflow:hidden; display:flex; flex-direction:column; font-family:'Plus Jakarta Sans', sans-serif;">
        <!-- Modal Header -->
        <div style="padding:14px 20px; background:#FAF8F4; border-bottom:1.5px solid #E2DFD7; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:32px; height:32px; border-radius:7px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="M9 12l2 2 4-4"></path></svg>
                </div>
                <div>
                    <h3 style="margin:0; font-size:14px; font-weight:800; color:#181512;">RMA Claim &amp; Defect Inspection Evidence</h3>
                    <p style="margin:2px 0 0 0; font-size:11px; color:#64748B;">Surat Central Depot Dock • <strong id="viewRmaIdText" style="color:#8A681F;">RMA-9021</strong></p>
                </div>
            </div>
        </div>

        <!-- Modal Body Content (Fluid Scrollable Container) -->
        <div id="viewRmaModalBody" style="padding:18px 20px; flex:1 1 auto; min-height:0; overflow-y:auto; display:flex; flex-direction:column; gap:14px; font-size:12px; color:#181512;">
            <!-- Loaded dynamically by JS -->
        </div>

        <!-- Modal Footer -->
        <div style="padding:12px 20px; background:#FAF8F4; border-top:1.5px solid #E2DFD7; display:flex; justify-content:space-between; align-items:center; flex-shrink:0; flex-wrap:wrap; gap:8px;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_RETURNS.closeRmaModal()" style="height:32px; padding:0 14px; font-size:11.5px;">✕ Close</button>
            <div style="display:flex; gap:8px;">
                <button type="button" id="modalRejectBtn" class="dt-btn dt-btn-danger" style="height:32px; padding:0 12px; font-size:11.5px;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    <span>Reject Claim</span>
                </button>
                <button type="button" id="modalWhatsAppBtn" class="dt-btn" style="background:#15803D; border:1px solid #166534; color:#FFFFFF; height:32px; padding:0 12px; font-size:11.5px; font-weight:700; display:inline-flex; align-items:center; gap:4px;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="#FFFFFF"><path d="M17.472 14.382c-.301-.15-1.78-.878-2.056-.979-.276-.1-.476-.15-.677.15-.2.301-.777.979-.953 1.179-.176.2-.351.226-.652.075s-1.272-.469-2.423-1.496c-.896-.799-1.501-1.786-1.677-2.087-.176-.301-.019-.464.132-.614.136-.135.301-.351.451-.527.15-.176.2-.301.301-.501.101-.2.05-.376-.025-.527-.075-.15-.677-1.632-.927-2.234-.244-.587-.492-.507-.677-.516-.176-.008-.376-.01-.576-.01s-.527.075-.803.376c-.276.301-1.053 1.028-1.053 2.508 0 1.479 1.078 2.908 1.229 3.109.15.2 2.122 3.24 5.141 4.544.718.31 1.279.496 1.716.635.722.23 1.38.197 1.9-.12.58-.352 1.78-1.454 2.03-2.86.251-1.406.251-2.61.176-2.86-.075-.251-.276-.376-.576-.527zM12 2C6.477 2 2 6.477 2 12c0 1.77.462 3.433 1.27 4.887L2 22l5.24-1.374A9.953 9.953 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"></path></svg>
                    <span>WhatsApp</span>
                </button>
                <button type="button" id="modalApproveBtn" class="dt-btn dt-btn-gold" style="height:32px; padding:0 14px; font-size:11.5px; font-weight:800;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.4"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Approve Pickup</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════ -->
<!-- 🛑 2. REJECT RMA CLAIM POPUP DRAWER / MODAL                   -->
<!-- ══════════════════════════════════════════════════════════════ -->
<div id="rejectRmaModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.65); z-index:9999999; backdrop-filter:blur(4px); align-items:center; justify-content:center;" onclick="if(event.target===this)window.DT_RETURNS.closeRejectModal()">
    <div style="background:#FFFFFF; border:1.5px solid #FECACA; border-radius:12px; width:95%; max-width:480px; box-shadow:0 14px 40px rgba(0,0,0,0.32); overflow:hidden; font-family:'Plus Jakarta Sans', sans-serif;">
        <!-- Header -->
        <div style="padding:14px 20px; background:#FEF2F2; border-bottom:1.5px solid #FECACA; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:30px; height:30px; border-radius:6px; background:#FEE2E2; border:1px solid #FCA5A5; display:flex; align-items:center; justify-content:center;">
                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#DC2626" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                </div>
                <div>
                    <h3 style="margin:0; font-size:14px; font-weight:800; color:#991B1B;">Reject Return / RMA Claim</h3>
                    <p style="margin:2px 0 0 0; font-size:11px; color:#DC2626;">Claim <strong id="rejectRmaIdText">RMA-9021</strong></p>
                </div>
            </div>
        </div>

        <!-- Form Body -->
        <form id="rejectRmaForm" onsubmit="window.DT_RETURNS.confirmReject(event)" style="padding:18px 20px; display:flex; flex-direction:column; gap:12px; font-size:12px;">
            <div>
                <label style="font-weight:700; color:#181512; margin-bottom:4px; display:block;">Primary Reason for Rejection</label>
                <select id="rejectReasonSelect" class="dt-order-search-input" style="height:36px; width:100%; font-weight:600; border-radius:6px;" required>
                    <option value="Mandatory Unboxing Video Missing / Seal Broken Prior to Recording">Mandatory Unboxing Video Missing / Damaged Proof</option>
                    <option value="Defect Not Found in Photos / Fabric Matches Master Swatch">Defect Not Found in Photos / Fabric Matches Spec</option>
                    <option value="Return Window Expired (>7 Days Past Delivery)">Return Window Expired (>7 Days Past Delivery)</option>
                    <option value="Fabric Used / Washed / Original Silk Mark Tag Removed">Fabric Used / Washed / Original Silk Mark Tag Removed</option>
                    <option value="RTO: Consignee Refused Delivery Without Valid Reason">RTO: Consignee Refused Delivery Without Valid Reason</option>
                    <option value="Custom Handloom Order (Non-Returnable B2B Lot)">Custom Handloom Order (Non-Returnable B2B Lot)</option>
                </select>
            </div>

            <div>
                <label style="font-weight:700; color:#181512; margin-bottom:4px; display:block;">Inspection QC Notes &amp; Customer Advice</label>
                <textarea id="rejectRemarksText" class="dt-order-search-input" rows="3" style="width:100%; border-radius:6px; padding:8px 10px; font-size:12px; resize:vertical;" placeholder="Provide specific remarks regarding why the return request was declined..."></textarea>
            </div>

            <div style="background:#FFFBEB; border:1px solid #FDE68A; padding:8px 12px; border-radius:6px; display:flex; align-items:center; gap:8px;">
                <input type="checkbox" id="rejectSendWhatsApp" checked style="cursor:pointer;">
                <label for="rejectSendWhatsApp" style="font-size:11px; color:#92400E; font-weight:700; cursor:pointer;">
                    Send instant WhatsApp notification with rejection explanation
                </label>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_RETURNS.closeRejectModal()" style="height:34px; padding:0 12px; font-size:11.5px;">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-danger" style="height:34px; padding:0 14px; font-size:11.5px; font-weight:800;">
                    <span>Confirm Rejection</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════ -->
<!-- 🔍 3. FULL-SCREEN MEDIA & UNBOXING VIDEO LIGHTBOX VIEWER      -->
<!-- ══════════════════════════════════════════════════════════════ -->
<div id="dtMediaLightboxModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(15,12,9,0.88); z-index:99999999; backdrop-filter:blur(8px); align-items:center; justify-content:center;" onclick="if(event.target===this)window.DT_RETURNS.closeLightbox()">
    <div style="background:#181512; border:1.5px solid #D4AF37; border-radius:14px; width:95%; max-width:820px; max-height:92vh; box-shadow:0 20px 60px rgba(0,0,0,0.6); overflow:hidden; display:flex; flex-direction:column; font-family:'Plus Jakarta Sans', sans-serif; color:#FFFFFF;">
        <!-- Header -->
        <div style="padding:14px 20px; background:#241E18; border-bottom:1px solid #3D342A; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:10px;">
                <span id="lightboxTypeBadge" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-size:10px; font-weight:800; padding:2px 8px; border-radius:4px; text-transform:uppercase;">HD Evidence</span>
                <div>
                    <h4 id="lightboxTitleText" style="margin:0; font-size:13.5px; font-weight:800; color:#FAF5E8;">Evidence Inspection</h4>
                    <p id="lightboxSubText" style="margin:2px 0 0 0; font-size:11px; color:#A8A29E;">Surat Central Depot Quality Audit</p>
                </div>
            </div>
            <button type="button" onclick="window.DT_RETURNS.closeLightbox()" style="background:#2A241E; border:1px solid #5A4210; color:#D4AF37; width:28px; height:28px; border-radius:6px; cursor:pointer; font-weight:800; font-size:13px; display:flex; align-items:center; justify-content:center;">✕</button>
        </div>

        <!-- Lightbox Canvas Body -->
        <div id="lightboxMediaContent" style="padding:20px; flex:1 1 auto; overflow-y:auto; display:flex; align-items:center; justify-content:center; min-height:360px; background:#0D0B0A;">
            <!-- Dynamically populated with high-res photo or video player -->
        </div>

        <!-- Lightbox Footer -->
        <div style="padding:12px 20px; background:#241E18; border-top:1px solid #3D342A; display:flex; justify-content:space-between; align-items:center; flex-shrink:0; flex-wrap:wrap; gap:8px;">
            <div id="lightboxFooterInfo" style="font-size:11px; color:#D6D3D1;">
                Verified Continuous Proof • 100% Intact Seal
            </div>
            <div style="display:flex; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_RETURNS.closeLightbox()" style="height:32px; padding:0 14px; font-size:11.5px;">✕ Close Viewer</button>
            </div>
        </div>
    </div>
</div>


