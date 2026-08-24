<?php
/**
 * wholesale-table.php — DT Brand's & Jai Hanuman Tex
 * Master Wholesale Accounts Directory Table with Dynamic Column Visibility Manager
 */

$status_filter = isset($status_filter) ? $status_filter : 'all';

$wholesalers = [];
if (!empty($wholesalersList)) {
    foreach ($wholesalersList as $w) {
        $name = $w['name'] ?? 'Wholesale Partner';
        $orders = (int)($w['total_orders'] ?? 0);
        $spend = (float)($w['lifetime_spend'] ?? 0);
        $avgOrder = $orders > 0 ? ($spend / $orders) : 0;
        $tier = $w['tier'] ?? 'Platinum Wholesale';
        $status = ucfirst($w['status'] ?? 'Active');

        $wholesalers[] = [
            'id' => 'WHL-' . $w['id'],
            'name' => $name,
            'legal_name' => $name . ' Enterprises',
            'contact' => $name,
            'email' => $w['email'] ?? 'partner@wholesale.com',
            'phone' => $w['phone'] ?? '+91 98765 43210',
            'city' => ($w['city'] ?? 'Surat') . ', ' . ($w['state'] ?? 'GJ'),
            'tier' => $tier,
            'tier_badge' => 'gold',
            'orders' => $orders,
            'purchase_val' => '₹' . number_format($spend),
            'avg_order' => '₹' . number_format($avgOrder),
            'payment_terms' => 'Net 30 Days',
            'credit_status' => 'Good (₹' . number_format($w['credit_limit'] ?? 100000) . ' Limit)',
            'credit_badge' => 'emerald',
            'verification' => 'Verified KYC',
            'verification_badge' => 'emerald',
            'status' => $status,
            'status_type' => strtolower($status) === 'active' ? 'approved' : strtolower($status),
            'last_activity' => 'Active'
        ];
    }
}

?>

<div class="dt-card">
    <!-- Table Header Toolbar -->
    <div class="dt-card-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; padding:14px 18px;">
        <div style="display:flex; align-items:center; gap:8px;">
            <div style="width:32px; height:32px; border-radius:8px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F; flex-shrink:0;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            </div>
            <div>
                <h4 style="font-size:0.95rem; font-weight:800; color:#181512; margin:0; display:flex; align-items:center; flex-wrap:wrap; gap:6px;">
                    <span>Master Wholesale Accounts Directory</span>
                    <span id="wholesaleVisibleCountBadge" class="dt-status-pill-clean gold" style="font-size:0.68rem;">Showing <?php echo count($wholesalers); ?> Wholesalers</span>
                </h4>
                <p style="font-size:0.72rem; color:#78716C; margin:2px 0 0 0;">Manage wholesale corporate accounts, commercial margins, and revolving credit ledgers.</p>
            </div>
        </div>

        <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
            <!-- Column Hide / Show Dropdown Button -->
            <div class="dt-col-dropdown-wrap" style="position:relative;">
                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="toggleWholesaleColumnMenu(event)" title="Show or Hide Table Columns">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="9" y1="3" x2="9" y2="21"></line>
                        <line x1="15" y1="3" x2="15" y2="21"></line>
                    </svg>
                    <span>Columns</span>
                    <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                
                <div id="wholesaleColumnVisibilityMenu" class="dt-col-menu" style="display:none; position:absolute; right:0; top:calc(100% + 6px); width:230px; background:#FFFFFF; border:1.5px solid #D4AF37; border-radius:8px; box-shadow:0 10px 30px rgba(0,0,0,0.18); padding:10px 12px; z-index:99999;">
                    <div style="font-size:10.5px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:8px; display:flex; justify-content:space-between; align-items:center; border-bottom:1px dashed #E2DFD7; padding-bottom:6px;">
                        <span>Visible Columns</span>
                        <button type="button" onclick="resetWholesaleColumns()" style="background:none; border:none; font-size:10px; color:#1D4ED8; font-weight:700; cursor:pointer; padding:0;">Reset All</button>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:6px; font-size:11px; color:#1E293B; max-height:260px; overflow-y:auto;">
                        <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-whl-name" checked onchange="toggleWholesaleColumn('col-whl-name', this.checked)"> <span>Business Name &amp; ID</span></label>
                        <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-whl-contact" checked onchange="toggleWholesaleColumn('col-whl-contact', this.checked)"> <span>Contact Person</span></label>
                        <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-whl-tier" checked onchange="toggleWholesaleColumn('col-whl-tier', this.checked)"> <span>Wholesale Tier</span></label>
                        <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-whl-orders" checked onchange="toggleWholesaleColumn('col-whl-orders', this.checked)"> <span>Orders Count</span></label>
                        <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-whl-purchase" checked onchange="toggleWholesaleColumn('col-whl-purchase', this.checked)"> <span>Purchase Value (₹)</span></label>
                        <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-whl-terms" checked onchange="toggleWholesaleColumn('col-whl-terms', this.checked)"> <span>Payment Terms</span></label>
                        <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-whl-credit" checked onchange="toggleWholesaleColumn('col-whl-credit', this.checked)"> <span>Credit Status</span></label>
                        <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-whl-verify" checked onchange="toggleWholesaleColumn('col-whl-verify', this.checked)"> <span>Verification KYC</span></label>
                        <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-whl-status" checked onchange="toggleWholesaleColumn('col-whl-status', this.checked)"> <span>Account Status</span></label>
                        <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-whl-activity" checked onchange="toggleWholesaleColumn('col-whl-activity', this.checked)"> <span>Last Activity</span></label>
                        <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-whl-actions" checked onchange="toggleWholesaleColumn('col-whl-actions', this.checked)"> <span>Row Actions</span></label>
                    </div>
                </div>
            </div>

            <!-- Filters Toggle -->
            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="toggleAdvancedFilters()">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                <span>Filters</span>
            </button>

            <!-- Export Link -->
            <a href="/DT%20Brand/admin/wholesale/export.php" class="dt-btn dt-btn-pale dt-btn-sm">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                <span>Export</span>
            </a>

            <!-- Clean Add Wholesaler Button (Single +) -->
            <a href="/DT%20Brand/admin/wholesale/edit.php?id=new" class="dt-btn dt-btn-gold dt-btn-sm" style="font-weight:800;">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>Add Wholesaler</span>
            </a>
        </div>
    </div>

    <!-- Search & Quick Filter Component -->
    <?php include __DIR__ . '/wholesale-search.php'; ?>

    <!-- Advanced Filter Drawer Component -->
    <?php include __DIR__ . '/wholesale-filters.php'; ?>

    <!-- Bulk Actions Component -->
    <?php include __DIR__ . '/bulk-actions.php'; ?>

    <!-- Master Wholesale Table Wrap -->
    <div class="dt-wholesale-table-wrap">
        <table class="dt-wholesale-table">
            <thead>
                <tr>
                    <th class="col-whl-cb" style="width:38px; text-align:center;">
                        <input type="checkbox" id="masterWholesaleCheckbox" onchange="toggleSelectAllWholesale(this)" style="cursor:pointer; accent-color:#8A681F;">
                    </th>
                    <th class="col-whl-name" style="white-space:nowrap;">Business Name &amp; ID</th>
                    <th class="col-whl-contact" style="white-space:nowrap;">Contact Person</th>
                    <th class="col-whl-tier" style="white-space:nowrap;">Wholesale Tier</th>
                    <th class="col-whl-orders" style="text-align:right; white-space:nowrap;">Orders</th>
                    <th class="col-whl-purchase" style="text-align:right; white-space:nowrap;">Purchase Value (₹)</th>
                    <th class="col-whl-terms" style="white-space:nowrap;">Payment Terms</th>
                    <th class="col-whl-credit" style="white-space:nowrap;">Credit Status</th>
                    <th class="col-whl-verify" style="white-space:nowrap;">Verification</th>
                    <th class="col-whl-status" style="white-space:nowrap;">Status</th>
                    <th class="col-whl-activity" style="white-space:nowrap;">Last Activity</th>
                    <th class="col-whl-actions" style="text-align:right; white-space:nowrap; padding-right:18px;">Actions</th>
                </tr>
            </thead>
            <tbody id="wholesaleTableBody">
                <?php if (empty($wholesalers)): ?>
                    <tr>
                        <td colspan="12" style="text-align:center; padding:36px 16px; color:#64748B;">
                            <div style="font-size:14px; font-weight:800; color:#181512; margin-bottom:4px;">No Wholesale Accounts Found</div>
                            <p style="font-size:12px; color:#64748B; margin:0 0 14px 0;">There are currently 0 wholesale accounts registered in the database.</p>
                            <a href="/DT%20Brand/admin/wholesale/edit.php?id=new" class="dt-btn dt-btn-gold dt-btn-sm" style="display:inline-flex; align-items:center; gap:6px;">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                <span>Add First Wholesale Partner</span>
                            </a>
                        </td>
                    </tr>
                <?php else: ?>
                <?php foreach ($wholesalers as $w): ?>
                    <tr id="whlRow_<?php echo $w['id']; ?>" class="wholesale-row-item" data-tier="<?php echo strtolower($w['tier']); ?>" data-status="<?php echo $w['status_type']; ?>">
                        <td class="col-whl-cb" style="text-align:center;">
                            <input type="checkbox" class="whl-row-checkbox" value="<?php echo $w['id']; ?>" onchange="onWholesaleRowCheck()" style="cursor:pointer; accent-color:#8A681F;">
                        </td>
                        <td class="col-whl-name whl-name-cell" style="white-space:nowrap;">
                            <div>
                                <a href="/DT%20Brand/admin/wholesale/view.php?id=<?php echo $w['id']; ?>" style="font-weight:800; font-size:0.84rem; color:#181512;">
                                    <?php echo htmlspecialchars($w['name']); ?>
                                </a>
                                <div style="font-size:0.7rem; color:#78716C; margin-top:2px;">
                                    <span class="whl-id-cell" style="font-family:monospace; color:#8A681F; font-weight:800;"><?php echo $w['id']; ?></span> • <?php echo htmlspecialchars($w['city']); ?>
                                </div>
                            </div>
                        </td>
                        <td class="col-whl-contact whl-contact-cell" style="white-space:nowrap;">
                            <div style="font-weight:700; color:#181512;"><?php echo htmlspecialchars($w['contact']); ?></div>
                            <div style="font-size:0.7rem; color:#78716C; font-family:monospace; margin-top:1px;"><?php echo $w['phone']; ?></div>
                        </td>
                        <td class="col-whl-tier" style="white-space:nowrap;">
                            <span class="dt-status-pill-clean <?php echo $w['tier_badge']; ?>">
                                <?php echo $w['tier']; ?>
                            </span>
                        </td>
                        <td class="col-whl-orders" style="text-align:right; font-weight:800; color:#181512; white-space:nowrap;"><?php echo $w['orders']; ?></td>
                        <td class="col-whl-purchase" style="text-align:right; font-weight:900; color:#181512; font-size:0.85rem; white-space:nowrap;"><?php echo $w['purchase_val']; ?></td>
                        <td class="col-whl-terms" style="font-size:0.74rem; font-weight:700; color:#181512; white-space:nowrap;"><?php echo $w['payment_terms']; ?></td>
                        <td class="col-whl-credit" style="white-space:nowrap;">
                            <span class="dt-status-pill-clean <?php echo $w['credit_badge']; ?>">
                                <?php echo $w['credit_status']; ?>
                            </span>
                        </td>
                        <td class="col-whl-verify" style="white-space:nowrap;">
                            <span class="dt-status-pill-clean <?php echo $w['verification_badge']; ?>">
                                <?php echo $w['verification']; ?>
                            </span>
                        </td>
                        <td class="col-whl-status whl-status-cell" style="white-space:nowrap;">
                            <span class="dt-status-pill-clean <?php echo $w['status_type'] === 'approved' ? 'emerald' : ($w['status_type'] === 'pending' ? 'amber' : 'crimson'); ?>">
                                <?php echo strtoupper($w['status']); ?>
                            </span>
                        </td>
                        <td class="col-whl-activity" style="color:#78716C; font-size:0.72rem; white-space:nowrap;"><?php echo $w['last_activity']; ?></td>
                        <td class="col-whl-actions" style="text-align:right; white-space:nowrap; padding-right:18px;">
                            <div style="display:flex; justify-content:flex-end; align-items:center; gap:6px;">
                                <a href="/DT%20Brand/admin/wholesale/view.php?id=<?php echo $w['id']; ?>" class="dt-btn dt-btn-pale dt-btn-sm" title="View Profile">
                                    <span>View</span>
                                </a>
                                <?php if ($w['status_type'] === 'pending'): ?>
                                    <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" onclick="openApproveModal('<?php echo $w['id']; ?>', '<?php echo addslashes($w['name']); ?>', '<?php echo $w['tier']; ?>')">
                                        <span>Approve</span>
                                    </button>
                                <?php elseif ($w['status_type'] === 'approved'): ?>
                                    <a href="/DT%20Brand/admin/wholesale/orders.php?id=<?php echo $w['id']; ?>" class="dt-btn dt-btn-info dt-btn-sm" title="View Orders">
                                        <span>Orders</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    <div style="padding:12px 18px; border-top:1.5px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; background:#FAF8F4; font-size:0.75rem;">
        <span style="color:#78716C; font-weight:600;">Showing <?= count($wholesalers) ?> of <?= count($wholesalers) ?> Wholesale Accounts</span>
        <div style="display:flex; align-items:center; gap:6px;">
            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" disabled>Previous</button>
            <button type="button" class="dt-btn dt-btn-gold dt-btn-sm">1</button>
            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" disabled>Next</button>
        </div>
    </div>
</div>
