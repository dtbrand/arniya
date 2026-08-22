<?php
/**
 * wholesale-table.php — DT Brand's & Jai Hanuman Tex
 * Master Wholesale Directory Table Component
 */
$wholesalers = [
    [
        'id' => 'WHL-8012',
        'name' => 'Shree Balaji Textile Emporium',
        'legal_name' => 'Shree Balaji Silk Mills Pvt Ltd',
        'contact' => 'Rameshwar Agarwal',
        'email' => 'balaji.textiles.surat@gmail.com',
        'phone' => '+91 98251 44321',
        'city' => 'Surat, Gujarat',
        'tier' => 'Platinum Wholesale',
        'tier_badge' => 'gold',
        'orders' => 64,
        'purchase_val' => '₹24,50,000',
        'avg_order' => '₹38,280',
        'payment_terms' => 'Net 30 Days',
        'credit_status' => 'Good (₹2.9L Avail)',
        'credit_badge' => 'emerald',
        'verification' => 'Verified KYC',
        'verification_badge' => 'emerald',
        'status' => 'Active',
        'status_type' => 'approved',
        'last_activity' => '2 hrs ago'
    ],
    [
        'id' => 'WHL-8013',
        'name' => 'Varanasi Weaves & Silks Syndicate',
        'legal_name' => 'Varanasi Weaves Wholesale Hub LLP',
        'contact' => 'Mukesh Chourasia',
        'email' => 'varanasi.weaves@yahoo.com',
        'phone' => '+91 98765 88990',
        'city' => 'Varanasi, UP',
        'tier' => 'Platinum Wholesale',
        'tier_badge' => 'gold',
        'orders' => 48,
        'purchase_val' => '₹18,90,000',
        'avg_order' => '₹39,375',
        'payment_terms' => 'Net 45 Days',
        'credit_status' => 'Good (₹1.8L Avail)',
        'credit_badge' => 'emerald',
        'verification' => 'Verified KYC',
        'verification_badge' => 'emerald',
        'status' => 'Active',
        'status_type' => 'approved',
        'last_activity' => 'Today, 11:30 AM'
    ],
    [
        'id' => 'WHL-8014',
        'name' => 'Jaipur Royal Saree Distributors',
        'legal_name' => 'Royal Saree Hub Rajasthan',
        'contact' => 'Dinesh Shekhawat',
        'email' => 'jaipur.royalsaree@gmail.com',
        'phone' => '+91 94280 22334',
        'city' => 'Jaipur, Rajasthan',
        'tier' => 'Gold Distributor',
        'tier_badge' => 'emerald',
        'orders' => 36,
        'purchase_val' => '₹12,40,000',
        'avg_order' => '₹34,440',
        'payment_terms' => 'Net 15 Days',
        'credit_status' => 'Good (₹80k Avail)',
        'credit_badge' => 'emerald',
        'verification' => 'Verified KYC',
        'verification_badge' => 'emerald',
        'status' => 'Active',
        'status_type' => 'approved',
        'last_activity' => 'Yesterday'
    ],
    [
        'id' => 'WHL-8015',
        'name' => 'Kanchipuram Silk Stockists',
        'legal_name' => 'Kanchi Handloom Stockists Ltd',
        'contact' => 'S. Rajagopalan',
        'email' => 'kanchi.stockists@gmail.com',
        'phone' => '+91 91234 55667',
        'city' => 'Chennai, Tamil Nadu',
        'tier' => 'Silver Bulk Partner',
        'tier_badge' => 'blue',
        'orders' => 18,
        'purchase_val' => '₹6,80,000',
        'avg_order' => '₹37,770',
        'payment_terms' => 'Advance 50%',
        'credit_status' => 'Normal',
        'credit_badge' => 'blue',
        'verification' => 'Verified KYC',
        'verification_badge' => 'emerald',
        'status' => 'Active',
        'status_type' => 'approved',
        'last_activity' => '3 days ago'
    ],
    [
        'id' => 'WHL-8016',
        'name' => 'Mahalaxmi Silk House Rajkot',
        'legal_name' => 'Mahalaxmi Enterprise',
        'contact' => 'Pravin Solanki',
        'email' => 'mahalaxmi.rajkot@gmail.com',
        'phone' => '+91 98980 11223',
        'city' => 'Rajkot, Gujarat',
        'tier' => 'Bronze Starter',
        'tier_badge' => 'amber',
        'orders' => 0,
        'purchase_val' => '₹0',
        'avg_order' => '₹0',
        'payment_terms' => 'Prepaid / Proforma',
        'credit_status' => 'No Credit',
        'credit_badge' => 'amber',
        'verification' => 'Pending Review',
        'verification_badge' => 'amber',
        'status' => 'Pending Review',
        'status_type' => 'pending',
        'last_activity' => 'Submitted 20 Aug'
    ],
    [
        'id' => 'WHL-8017',
        'name' => 'Kolkata Saree Emporium Hub',
        'legal_name' => 'Kolkata Silk Syndicate',
        'contact' => 'Subhashish Ghosh',
        'email' => 'kolkata.emporium@rediffmail.com',
        'phone' => '+91 98310 99887',
        'city' => 'Kolkata, West Bengal',
        'tier' => 'Silver Bulk Partner',
        'tier_badge' => 'blue',
        'orders' => 12,
        'purchase_val' => '₹4,50,000',
        'avg_order' => '₹37,500',
        'payment_terms' => 'Net 30 Days',
        'credit_status' => 'Exhausted (₹0 Avail)',
        'credit_badge' => 'crimson',
        'verification' => 'Verified KYC',
        'verification_badge' => 'emerald',
        'status' => 'Suspended',
        'status_type' => 'suspended',
        'last_activity' => 'Overdue 14 Days'
    ]
];
?>

<div class="dt-card">
    <!-- Table Header Toolbar -->
    <div class="dt-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <div style="width:30px; height:30px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            </div>
            <div>
                <h4 style="font-size:0.95rem; font-weight:800; color:#181512; margin:0;">
                    <span>Master Wholesale Accounts Directory</span>
                    <span id="wholesaleVisibleCountBadge" class="dt-status-pill-clean gold" style="font-size:0.68rem; margin-left:6px;">Showing <?php echo count($wholesalers); ?> Wholesalers</span>
                </h4>
                <p style="font-size:0.7rem; color:#78716C; margin:1px 0 0 0;">Manage wholesale corporate accounts, commercial margins, and revolving credit ledgers.</p>
            </div>
        </div>

        <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="toggleAdvancedFilters()">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                <span>Filters</span>
            </button>
            <a href="/Frontend/Admin/wholesale/export.php" class="dt-btn dt-btn-pale dt-btn-sm">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                <span>Export</span>
            </a>
            <a href="/Frontend/Admin/wholesale/edit.php?id=new" class="dt-btn dt-btn-gold dt-btn-sm">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>+ Add Wholesaler</span>
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
                    <th style="width:40px; text-align:center;">
                        <input type="checkbox" id="masterWholesaleCheckbox" onchange="toggleSelectAllWholesale(this)" style="cursor:pointer; accent-color:#8A681F;">
                    </th>
                    <th style="white-space:nowrap;">Business Name &amp; ID</th>
                    <th style="white-space:nowrap;">Contact Person</th>
                    <th style="white-space:nowrap;">Wholesale Tier</th>
                    <th style="text-align:right; white-space:nowrap;">Orders</th>
                    <th style="text-align:right; white-space:nowrap;">Purchase Value (₹)</th>
                    <th style="white-space:nowrap;">Payment Terms</th>
                    <th style="white-space:nowrap;">Credit Status</th>
                    <th style="white-space:nowrap;">Verification</th>
                    <th style="white-space:nowrap;">Status</th>
                    <th style="white-space:nowrap;">Last Activity</th>
                    <th style="text-align:right; white-space:nowrap;">Actions</th>
                </tr>
            </thead>
            <tbody id="wholesaleTableBody">
                <?php foreach ($wholesalers as $w): ?>
                    <tr id="whlRow_<?php echo $w['id']; ?>" class="wholesale-row-item" data-tier="<?php echo strtolower($w['tier']); ?>" data-status="<?php echo $w['status_type']; ?>" style="border-bottom:1px solid #F1ECE1;">
                        <td style="text-align:center;">
                            <input type="checkbox" class="whl-row-checkbox" value="<?php echo $w['id']; ?>" onchange="onWholesaleRowCheck()" style="cursor:pointer; accent-color:#8A681F;">
                        </td>
                        <td class="whl-name-cell" style="white-space:nowrap;">
                            <div>
                                <a href="/Frontend/Admin/wholesale/view.php?id=<?php echo $w['id']; ?>" style="font-weight:800; font-size:0.84rem; color:#181512;">
                                    <?php echo htmlspecialchars($w['name']); ?>
                                </a>
                                <div style="font-size:0.7rem; color:#78716C;">
                                    <span class="whl-id-cell" style="font-family:monospace; color:#8A681F; font-weight:800;"><?php echo $w['id']; ?></span> • <?php echo htmlspecialchars($w['city']); ?>
                                </div>
                            </div>
                        </td>
                        <td class="whl-contact-cell" style="white-space:nowrap;">
                            <div style="font-weight:700; color:#181512;"><?php echo htmlspecialchars($w['contact']); ?></div>
                            <div style="font-size:0.7rem; color:#78716C; font-family:monospace;"><?php echo $w['phone']; ?></div>
                        </td>
                        <td style="white-space:nowrap;">
                            <span class="dt-status-pill-clean <?php echo $w['tier_badge']; ?>">
                                <?php echo $w['tier']; ?>
                            </span>
                        </td>
                        <td style="text-align:right; font-weight:800; color:#181512; white-space:nowrap;"><?php echo $w['orders']; ?></td>
                        <td style="text-align:right; font-weight:900; color:#181512; font-size:0.85rem; white-space:nowrap;"><?php echo $w['purchase_val']; ?></td>
                        <td style="font-size:0.74rem; font-weight:700; color:#181512; white-space:nowrap;"><?php echo $w['payment_terms']; ?></td>
                        <td style="white-space:nowrap;">
                            <span class="dt-status-pill-clean <?php echo $w['credit_badge']; ?>">
                                <?php echo $w['credit_status']; ?>
                            </span>
                        </td>
                        <td style="white-space:nowrap;">
                            <span class="dt-status-pill-clean <?php echo $w['verification_badge']; ?>">
                                <?php echo $w['verification']; ?>
                            </span>
                        </td>
                        <td class="whl-status-cell" style="white-space:nowrap;">
                            <span class="dt-status-pill-clean <?php echo $w['status_type'] === 'approved' ? 'emerald' : ($w['status_type'] === 'pending' ? 'amber' : 'crimson'); ?>">
                                <?php echo strtoupper($w['status']); ?>
                            </span>
                        </td>
                        <td style="color:#78716C; font-size:0.72rem; white-space:nowrap;"><?php echo $w['last_activity']; ?></td>
                        <td style="text-align:right; white-space:nowrap;">
                            <div style="display:flex; justify-content:flex-end; gap:6px;">
                                <a href="/Frontend/Admin/wholesale/view.php?id=<?php echo $w['id']; ?>" class="dt-btn dt-btn-pale dt-btn-sm" title="View Profile">
                                    <span>View</span>
                                </a>
                                <?php if ($w['status_type'] === 'pending'): ?>
                                    <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" onclick="openApproveModal('<?php echo $w['id']; ?>', '<?php echo addslashes($w['name']); ?>', '<?php echo $w['tier']; ?>')">
                                        <span>Approve</span>
                                    </button>
                                <?php elseif ($w['status_type'] === 'approved'): ?>
                                    <a href="/Frontend/Admin/wholesale/orders.php?id=<?php echo $w['id']; ?>" class="dt-btn dt-btn-info dt-btn-sm" title="View Orders">
                                        <span>Orders</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    <div style="padding:12px 18px; border-top:1.5px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; background:#FAF8F4; font-size:0.75rem;">
        <span style="color:#78716C; font-weight:600;">Showing 1–6 of 124 Wholesalers</span>
        <div style="display:flex; align-items:center; gap:6px;">
            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" disabled>Previous</button>
            <button type="button" class="dt-btn dt-btn-gold dt-btn-sm">1</button>
            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm">2</button>
            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm">3</button>
            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm">Next</button>
        </div>
    </div>
</div>
