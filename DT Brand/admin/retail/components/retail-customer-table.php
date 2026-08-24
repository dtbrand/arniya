<?php
/**
 * retail-customer-table.php — DT Brand's & Jai Hanuman Tex
 * Retail Customer Directory Table Component
 */
require_once __DIR__ . '/retail-data.php';
$customers = getRetailCustomers();
?>

<div class="dt-retail-card">
    <div class="dt-retail-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            <h4 class="dt-retail-card-title">Retail Customer Directory</h4>
        </div>

        <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
            <div style="position:relative; width:200px;">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#78716C" stroke-width="2.2" style="position:absolute; left:9px; top:50%; transform:translateY(-50%); pointer-events:none;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" id="retailCustSearchInput" class="dt-retail-input" style="width:100%; height:30px; padding-left:28px; font-size:0.72rem; border-radius:6px; border:1.2px solid #EAE5D9; box-sizing:border-box;" placeholder="Search customer, email, phone..." oninput="filterRetailCustomers()">
            </div>

            <select id="retailCustStatusFilter" class="dt-retail-input" style="height:30px; font-size:0.72rem; padding:0 8px; border-radius:6px; border:1.2px solid #EAE5D9; box-sizing:border-box;" onchange="filterRetailCustomers()">
                <option value="all">All Statuses</option>
                <option value="vip gold">VIP Gold</option>
                <option value="active">Active</option>
                <option value="new customer">New Customer</option>
            </select>

            <a href="/DT%20Brand/admin/customers/" class="dt-btn dt-btn-pale dt-btn-sm">Full Customers Module →</a>
        </div>
    </div>

    <div style="overflow-x:auto; width:100%;">
        <table class="dt-retail-table">
            <thead>
                <tr>
                    <th style="width:30px;"><input type="checkbox" onchange="toggleAllRetailCheckboxes(this)"></th>
                    <th>Customer Name</th>
                    <th>Contact Info</th>
                    <th style="text-align:right;">Orders</th>
                    <th style="text-align:right;">Total Spent</th>
                    <th style="text-align:right;">AOV</th>
                    <th>Last Order</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody id="retailCustomersTableBody">
                <?php foreach ($customers as $c): ?>
                    <tr class="retail-customer-row" data-status="<?php echo strtolower($c['status']); ?>">
                        <td><input type="checkbox" class="retail-row-checkbox" onchange="updateRetailBulkActionCount()"></td>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div class="dt-retail-cust-avatar"><?php echo strtoupper(substr($c['name'], 0, 1)); ?></div>
                                <div class="dt-retail-cust-meta">
                                    <span class="retail-cust-name-cell dt-retail-cust-name"><?php echo htmlspecialchars($c['name']); ?></span>
                                    <span class="dt-retail-cust-sub">ID: <?php echo $c['id']; ?></span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:0.72rem;">
                                <span class="retail-cust-email-cell" style="color:#181512; display:block;"><?php echo $c['email']; ?></span>
                                <span class="retail-cust-phone-cell" style="color:#78716C;"><?php echo $c['phone']; ?></span>
                            </div>
                        </td>
                        <td style="text-align:right; font-weight:800; color:#181512;"><?php echo $c['orders']; ?></td>
                        <td style="text-align:right; font-weight:900; color:#8A681F;">₹<?php echo number_format($c['spent']); ?></td>
                        <td style="text-align:right; font-weight:700; color:#15803D;">₹<?php echo number_format($c['aov']); ?></td>
                        <td style="font-size:0.72rem; color:#78716C;"><?php echo $c['last_order']; ?></td>
                        <td><span class="dt-status-pill-clean <?php echo $c['badge']; ?>"><?php echo $c['status']; ?></span></td>
                        <td style="font-size:0.72rem; color:#78716C;"><?php echo $c['joined']; ?></td>
                        <td style="text-align:right; white-space:nowrap;">
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="openCustomerQuickView('<?php echo addslashes($c['name']); ?>', '<?php echo $c['email']; ?>', '<?php echo $c['phone']; ?>', '<?php echo $c['orders']; ?> Orders', '₹<?php echo number_format($c['spent']); ?>', '<?php echo $c['status']; ?>')">
                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                <span>Inspect</span>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Customer Quick View Modal -->
<div id="dtRetailCustomerModal" class="dt-modal-backdrop">
    <div class="dt-modal-dialog">
        <div class="dt-modal-head">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Retail Customer Profile Particulars</strong>
            </div>
            <button type="button" onclick="closeRetailModal('dtRetailCustomerModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>
        <div class="dt-modal-body">
            <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:12px 14px; display:flex; flex-direction:column; gap:6px; font-size:0.78rem;">
                <div style="display:flex; justify-content:space-between;"><span style="color:#78716C;">Full Name:</span><strong id="quickCustName" style="color:#181512;">—</strong></div>
                <div style="display:flex; justify-content:space-between;"><span style="color:#78716C;">Email Address:</span><strong id="quickCustEmail" style="color:#181512;">—</strong></div>
                <div style="display:flex; justify-content:space-between;"><span style="color:#78716C;">Phone / WhatsApp:</span><strong id="quickCustPhone" style="color:#8A681F;">—</strong></div>
                <div style="display:flex; justify-content:space-between;"><span style="color:#78716C;">Total Orders:</span><strong id="quickCustOrders" style="color:#181512;">—</strong></div>
                <div style="display:flex; justify-content:space-between;"><span style="color:#78716C;">Lifetime Spent:</span><strong id="quickCustSpent" style="color:#15803D;">—</strong></div>
                <div style="display:flex; justify-content:space-between;"><span style="color:#78716C;">Customer Standing:</span><span id="quickCustStatus" class="dt-status-pill-clean gold">—</span></div>
            </div>
        </div>
        <div class="dt-modal-foot">
            <button type="button" class="dt-btn dt-btn-pale" onclick="closeRetailModal('dtRetailCustomerModal')">Close</button>
            <a href="/DT%20Brand/admin/customers/" class="dt-btn dt-btn-gold">Open Full Customer Dossier</a>
        </div>
    </div>
</div>
