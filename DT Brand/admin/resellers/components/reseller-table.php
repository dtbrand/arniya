<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * reseller-table.php — High-Density Responsive Reseller Master Table with Column Toggling
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */

$resellers_data = [];
if (!empty($resellersList)) {
    foreach ($resellersList as $r) {
        $name = $r['name'] ?? 'Reseller Partner';
        $parts = explode(' ', $name);
        $initials = strtoupper(($parts[0][0] ?? '') . ($parts[1][0] ?? ''));
        $orders = (int)($r['total_orders'] ?? 0);
        $spend = (float)($r['lifetime_spend'] ?? 0);
        $credit = (float)($r['outstanding_balance'] ?? 0);
        $creditLimit = (float)($r['credit_limit'] ?? 50000);
        $tier = $r['tier'] ?? 'Gold VIP';

        $resellers_data[] = [
            'id' => 'RES-' . $r['id'],
            'name' => $name,
            'biz_name' => $name . ' (Reseller Hub)',
            'initials' => $initials ?: 'RS',
            'avatar_color' => 'gold',
            'contact' => $name,
            'email' => $r['email'] ?? 'partner@reseller.com',
            'phone' => $r['phone'] ?? '+91 70463 63528',
            'city' => ($r['city'] ?? 'Surat') . ', ' . ($r['state'] ?? 'GJ'),
            'tier' => $tier,
            'tier_margin' => '25% Margin',
            'tier_class' => 'gold',
            'orders' => $orders,
            'purchase' => $spend,
            'credit' => $credit,
            'credit_limit' => $creditLimit,
            'last_order' => 'Active',
            'status' => ucfirst($r['status'] ?? 'Active'),
            'status_class' => 'emerald',
            'kyc' => 'Verified',
            'joined' => '2026'
        ];
    }
}
?>

<!-- ══ MASTER RESELLER TABLE CONTAINER ══ -->
<div class="dt-cust-table-wrap">
    <table class="dt-cust-table" id="dtResellersMasterTable">
        <thead>
            <tr>
                <th class="col-checkbox" style="width:36px; text-align:center;">
                    <input type="checkbox" id="dtResellerSelectAll" onchange="toggleAllResellerCheckboxes(this)" title="Select All Resellers">
                </th>
                <th class="col-profile sortable" onclick="handleResellerSort({value:'name-asc'})">
                    RESELLER PROFILE ↕
                </th>
                <th class="col-contact">CONTACT DETAILS</th>
                <th class="col-tier">TIER &amp; MARGIN</th>
                <th class="col-orders sortable" style="text-align:center;" onclick="handleResellerSort({value:'orders-high'})">
                    ORDERS ↕
                </th>
                <th class="col-gmv sortable" onclick="handleResellerSort({value:'purchase-high'})">
                    LIFETIME GMV ↕
                </th>
                <th class="col-lastorder">LAST ORDER</th>
                <th class="col-joined">JOINED DATE</th>
                <th class="col-status">STATUS</th>
                <th class="col-actions" style="text-align:right; min-width:110px; padding-right:14px;">QUICK ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($resellers_data)): ?>
                <tr>
                    <td colspan="9" style="text-align:center; padding:36px 16px; color:#64748B;">
                        <div style="font-size:14px; font-weight:800; color:#181512; margin-bottom:4px;">No Resellers Found</div>
                        <p style="font-size:12px; color:#64748B; margin:0 0 14px 0;">There are currently 0 reseller partners registered in the database.</p>
                        <a href="/admin/resellers/edit.php?id=new" class="dt-btn dt-btn-gold dt-btn-sm" style="display:inline-flex; align-items:center; gap:6px;">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>Add First Reseller</span>
                        </a>
                    </td>
                </tr>
            <?php else: ?>
            <?php foreach ($resellers_data as $r): ?>
                <tr class="dt-reseller-row"
                    data-id="<?php echo $r['id']; ?>"
                    data-status="<?php echo $r['status']; ?>"
                    data-name="<?php echo htmlspecialchars($r['name']); ?>"
                    data-purchase="<?php echo $r['purchase']; ?>"
                    data-orders="<?php echo $r['orders']; ?>"
                    data-joined="<?php echo $r['joined']; ?>"
                    data-search="<?php echo htmlspecialchars($r['id'] . ' ' . $r['name'] . ' ' . $r['biz_name'] . ' ' . $r['contact'] . ' ' . $r['email'] . ' ' . $r['phone'] . ' ' . $r['city'] . ' ' . $r['tier'] . ' ' . $r['status']); ?>">
                    
                    <td class="col-checkbox" style="text-align:center;">
                        <input type="checkbox" class="dt-reseller-row-checkbox" value="<?php echo $r['id']; ?>" onchange="handleRowCheckboxChange()" style="cursor:pointer;">
                    </td>

                    <!-- Reseller Profile -->
                    <td class="col-profile">
                        <div class="dt-cust-avatar-cell">
                            <div class="dt-cust-avatar <?php echo $r['avatar_color']; ?>">
                                <?php echo $r['initials']; ?>
                            </div>
                            <div class="dt-cust-name-wrap">
                                <div class="dt-cust-name-row">
                                    <a href="/admin/resellers/view.php?id=<?php echo $r['id']; ?>" class="dt-cust-name">
                                        <?php echo htmlspecialchars($r['name']); ?>
                                    </a>
                                    <?php if (strpos($r['tier'], 'Platinum') !== false || strpos($r['tier'], 'Gold') !== false): ?>
                                        <span class="dt-tier-badge gold-tier" style="font-size:0.65rem; padding:1px 5px;">VIP</span>
                                    <?php endif; ?>
                                </div>
                                <div style="font-size:0.68rem; color:#78716C; font-weight:600;">
                                    #<?php echo $r['id']; ?> • <?php echo htmlspecialchars($r['city']); ?>
                                </div>
                            </div>
                        </div>
                    </td>

                    <!-- Contact Details -->
                    <td class="col-contact">
                        <div style="font-weight:700; color:#181512; font-size:0.76rem;"><?php echo htmlspecialchars($r['phone']); ?></div>
                        <div style="color:#78716C; font-size:0.7rem;"><?php echo htmlspecialchars($r['email']); ?></div>
                    </td>

                    <!-- Tier & Margin -->
                    <td class="col-tier">
                        <span class="dt-reseller-badge <?php echo $r['tier_class']; ?>" style="font-size:0.7rem;">
                            <?php echo $r['tier']; ?> (<?php echo $r['tier_margin']; ?>)
                        </span>
                    </td>

                    <!-- Orders -->
                    <td class="col-orders" style="text-align:center; font-weight:800; color:#181512;">
                        <a href="/admin/resellers/orders.php?reseller_id=<?php echo $r['id']; ?>" style="color:#181512; text-decoration:none;">
                            <?php echo $r['orders']; ?> Orders
                        </a>
                    </td>

                    <!-- Lifetime GMV -->
                    <td class="col-gmv">
                        <div style="font-weight:900; color:#181512; font-size:0.82rem;">
                            ₹<?php echo number_format($r['purchase']); ?>
                        </div>
                        <div style="font-size:0.65rem; color:#78716C;">
                            Credit: ₹<?php echo number_format($r['credit']); ?>
                        </div>
                    </td>

                    <!-- Last Order -->
                    <td class="col-lastorder" style="color:#181512; font-weight:600; font-size:0.72rem;">
                        <?php echo $r['last_order']; ?>
                    </td>

                    <!-- Joined Date -->
                    <td class="col-joined" style="color:#78716C; font-size:0.72rem;">
                        <?php echo $r['joined']; ?>
                    </td>

                    <!-- Status -->
                    <td class="col-status">
                        <?php if ($r['status'] === 'Active'): ?>
                            <span class="dt-reseller-badge emerald">● Active</span>
                        <?php elseif ($r['status'] === 'Pending'): ?>
                            <span class="dt-reseller-badge amber">● Pending</span>
                        <?php elseif ($r['status'] === 'Suspended'): ?>
                            <span class="dt-reseller-badge purple">● Suspended</span>
                        <?php else: ?>
                            <span class="dt-reseller-badge rose">● Rejected</span>
                        <?php endif; ?>
                    </td>

                    <!-- Quick Actions -->
                    <td class="col-actions" style="text-align:right; padding-right:14px;">
                        <div style="display:inline-flex; align-items:center; justify-content:flex-end; gap:6px;">
                            <!-- WhatsApp 1-Click Action -->
                            <a href="https://wa.me/<?php echo str_replace(['+', ' '], '', $r['phone']); ?>?text=Namaste%20<?php echo urlencode($r['name']); ?>%20ji,%20greetings%20from%20DT%20Brand's%20Wholesale%20Hub!" 
                               target="_blank" 
                               class="dt-btn dt-btn-emerald" 
                               style="padding:4px 8px; font-size:0.7rem; border-radius:6px;" 
                               title="1-Click WhatsApp Direct Connect">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="#FFFFFF"><path d="M17.472 14.382c-.301-.15-1.781-.878-2.057-.978-.276-.1-.476-.15-.676.15-.2.3-.776.978-.952 1.178-.175.2-.351.225-.652.075-.301-.15-1.27-.468-2.42-1.493-.895-.798-1.5-1.784-1.676-2.084-.175-.3-.019-.462.132-.612.136-.135.301-.35.452-.525.15-.175.2-.3.301-.5.101-.2.05-.375-.025-.525-.075-.15-.676-1.63-.927-2.234-.244-.588-.492-.508-.676-.518l-.576-.01c-.2 0-.526.075-.802.375-.276.3-1.053 1.029-1.053 2.508s1.078 2.906 1.228 3.106c.15.2 2.122 3.24 5.141 4.544.718.31 1.279.496 1.716.635.722.23 1.378.197 1.897.12.578-.087 1.781-.728 2.032-1.431.25-.703.25-1.305.175-1.43-.075-.126-.276-.201-.577-.351zM12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.978-1.406C8.423 21.498 10.155 22 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"></path></svg>
                            </a>

                            <!-- View 360° Profile -->
                            <a href="/admin/resellers/view.php?id=<?php echo $r['id']; ?>" 
                               class="dt-btn dt-btn-pale" 
                               style="padding:4px 8px; font-size:0.7rem; border-radius:6px;" 
                               title="View 360° Executive Dossier">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </a>

                            <!-- Edit Account -->
                            <a href="/admin/resellers/edit.php?id=<?php echo $r['id']; ?>" 
                               class="dt-btn dt-btn-pale" 
                               style="padding:4px 8px; font-size:0.7rem; border-radius:6px;" 
                               title="Edit Reseller Account">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- ══ PAGINATION CONTROLS ══ -->
    <div class="dt-cust-pagination">
        <div id="dtResellerFilteredCount">
            Showing <strong>1–<?php echo count($resellers_data); ?></strong> of <strong><?php echo count($resellers_data); ?></strong> Resellers
        </div>
        <div class="dt-cust-pages-wrap">
            <button type="button" class="dt-cust-page-btn" disabled title="First Page">«</button>
            <button type="button" class="dt-cust-page-btn active">1</button>
            <button type="button" class="dt-cust-page-btn" disabled title="Next Page">»</button>
        </div>
    </div>
</div>

<!-- Empty State -->
<div id="dtResellerEmptyState" style="display:none; padding:40px 20px; text-align:center; background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:12px; margin-top:10px;">
    <div style="width:48px; height:48px; border-radius:50%; background:#FAF5E8; color:#8A681F; display:inline-flex; align-items:center; justify-content:center; margin-bottom:12px;">
        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#8A681F" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
    </div>
    <h4 style="font-size:0.95rem; font-weight:800; color:#181512; margin:0 0 4px 0;">No matching resellers found</h4>
    <p style="font-size:0.75rem; color:#78716C; margin:0 0 14px 0;">Try adjusting your keyword or clearing active status filters.</p>
    <button type="button" class="dt-btn dt-btn-pale" onclick="clearResellerSearch()">Clear Search Filters</button>
</div>
