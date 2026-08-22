<?php
/**
 * reseller-table.php — DT Brand's & Jai Hanuman Tex
 * Master Reseller Directory Table Component
 */

$resellers_data = [
    [
        'id' => 'RES-1048',
        'name' => 'Shree Krishna Sarees & Boutique',
        'contact' => 'Rameshwar Vyas',
        'email' => 'krishna.boutique@gmail.com',
        'phone' => '+91 98251 44321',
        'city' => 'Surat, Gujarat',
        'tier' => 'Platinum',
        'orders' => 142,
        'purchase' => 845000,
        'credit' => 65000,
        'credit_limit' => 150000,
        'status' => 'Active',
        'kyc' => 'Verified',
        'joined' => '2025-11-12'
    ],
    [
        'id' => 'RES-1047',
        'name' => 'Ananya Designer Studio',
        'contact' => 'Ananya Sharma',
        'email' => 'ananya.studio@yahoo.com',
        'phone' => '+91 98765 43210',
        'city' => 'Jaipur, Rajasthan',
        'tier' => 'Gold',
        'orders' => 88,
        'purchase' => 520000,
        'credit' => 42000,
        'credit_limit' => 100000,
        'status' => 'Active',
        'kyc' => 'Verified',
        'joined' => '2025-12-04'
    ],
    [
        'id' => 'RES-1046',
        'name' => 'Vardhman Silk Emporium',
        'contact' => 'Ketan Jain',
        'email' => 'vardhman.silks@gmail.com',
        'phone' => '+91 94280 11223',
        'city' => 'Ahmedabad, Gujarat',
        'tier' => 'Gold',
        'orders' => 64,
        'purchase' => 380000,
        'credit' => 28000,
        'credit_limit' => 80000,
        'status' => 'Active',
        'kyc' => 'Verified',
        'joined' => '2026-01-10'
    ],
    [
        'id' => 'RES-1045',
        'name' => 'Royal Heritage Silks',
        'contact' => 'Pooja Agarwal',
        'email' => 'royal.silks@outlook.com',
        'phone' => '+91 91234 56789',
        'city' => 'Indore, Madhya Pradesh',
        'tier' => 'Silver',
        'orders' => 32,
        'purchase' => 195000,
        'credit' => 15000,
        'credit_limit' => 50000,
        'status' => 'Active',
        'kyc' => 'Verified',
        'joined' => '2026-02-14'
    ],
    [
        'id' => 'RES-1044',
        'name' => 'Mahalaxmi Fashion Hub',
        'contact' => 'Suresh Patel',
        'email' => 'mahalaxmi.fashion@gmail.com',
        'phone' => '+91 98980 99887',
        'city' => 'Rajkot, Gujarat',
        'tier' => 'Bronze',
        'orders' => 0,
        'purchase' => 0,
        'credit' => 0,
        'credit_limit' => 25000,
        'status' => 'Pending',
        'kyc' => 'Needs Review',
        'joined' => '2026-08-20'
    ],
    [
        'id' => 'RES-1043',
        'name' => 'Gitanjali Sarees Kolkata',
        'contact' => 'Debabrata Sen',
        'email' => 'gitanjali.sarees@rediffmail.com',
        'phone' => '+91 98310 12345',
        'city' => 'Kolkata, West Bengal',
        'tier' => 'Silver',
        'orders' => 0,
        'purchase' => 0,
        'credit' => 0,
        'credit_limit' => 50000,
        'status' => 'Pending',
        'kyc' => 'Pending',
        'joined' => '2026-08-21'
    ],
    [
        'id' => 'RES-1042',
        'name' => 'Kavita Dress Materials',
        'contact' => 'Kavita Choudhary',
        'email' => 'kavita.dress@gmail.com',
        'phone' => '+91 98200 44556',
        'city' => 'Mumbai, Maharashtra',
        'tier' => 'Silver',
        'orders' => 18,
        'purchase' => 98000,
        'credit' => 78000,
        'credit_limit' => 50000,
        'status' => 'Suspended',
        'kyc' => 'Verified',
        'joined' => '2026-03-01'
    ],
    [
        'id' => 'RES-1041',
        'name' => 'Apex Textiles Agency',
        'contact' => 'Vikas Malhotra',
        'email' => 'apex.textiles@ukexport.com',
        'phone' => '+91 98111 22334',
        'city' => 'Delhi, NCR',
        'tier' => 'Bronze',
        'orders' => 0,
        'purchase' => 0,
        'credit' => 0,
        'credit_limit' => 0,
        'status' => 'Rejected',
        'kyc' => 'Rejected',
        'joined' => '2026-08-15'
    ]
];
?>

<div style="overflow-x:auto; -webkit-overflow-scrolling:touch; width:100%;">
    <table class="dt-reseller-table" id="dtResellersMasterTable">
        <thead>
            <tr>
                <th style="width:40px; text-align:center;">
                    <input type="checkbox" id="dtResellerSelectAll" onchange="toggleAllResellerCheckboxes(this)" style="cursor:pointer;">
                </th>
                <th>Reseller / Business</th>
                <th>Contact &amp; Location</th>
                <th>Tier</th>
                <th style="text-align:center;">Orders</th>
                <th style="text-align:right;">Total GMV (₹)</th>
                <th style="text-align:right;">Credit Balance</th>
                <th>KYC Status</th>
                <th>Account Status</th>
                <th>Joined</th>
                <th style="text-align:center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resellers_data as $r): ?>
                <tr class="dt-reseller-row" 
                    data-id="<?php echo $r['id']; ?>"
                    data-status="<?php echo $r['status']; ?>"
                    data-name="<?php echo htmlspecialchars($r['name']); ?>"
                    data-purchase="<?php echo $r['purchase']; ?>"
                    data-orders="<?php echo $r['orders']; ?>"
                    data-joined="<?php echo $r['joined']; ?>"
                    data-search="<?php echo htmlspecialchars($r['id'] . ' ' . $r['name'] . ' ' . $r['contact'] . ' ' . $r['email'] . ' ' . $r['phone'] . ' ' . $r['city'] . ' ' . $r['tier'] . ' ' . $r['status']); ?>">
                    
                    <td style="text-align:center;">
                        <input type="checkbox" class="dt-reseller-row-checkbox" value="<?php echo $r['id']; ?>" onchange="handleRowCheckboxChange()" style="cursor:pointer;">
                    </td>

                    <!-- Business / Reseller -->
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div class="dt-reseller-avatar">
                                <?php echo strtoupper(substr($r['name'], 0, 1)); ?>
                            </div>
                            <div>
                                <a href="/Frontend/Admin/resellers/view.php?id=<?php echo $r['id']; ?>" style="font-weight:800; color:#181512; text-decoration:none; font-size:0.82rem; display:block;">
                                    <?php echo htmlspecialchars($r['name']); ?>
                                </a>
                                <small style="color:#8A681F; font-weight:800; font-size:0.68rem;"><?php echo $r['id']; ?></small>
                            </div>
                        </div>
                    </td>

                    <!-- Contact & Location -->
                    <td>
                        <div style="font-weight:700; color:#181512; font-size:0.78rem;"><?php echo htmlspecialchars($r['contact']); ?></div>
                        <div style="color:#78716C; font-size:0.7rem;"><?php echo htmlspecialchars($r['phone']); ?></div>
                        <div style="color:#A8A29E; font-size:0.65rem;"><?php echo htmlspecialchars($r['city']); ?></div>
                    </td>

                    <!-- Tier -->
                    <td>
                        <?php 
                        $tierClass = strtolower($r['tier']);
                        if ($tierClass === 'gold') $tierClass = 'gold-tier';
                        ?>
                        <span class="dt-tier-badge <?php echo $tierClass; ?>">
                            ★ <?php echo $r['tier']; ?>
                        </span>
                    </td>

                    <!-- Orders -->
                    <td style="text-align:center; font-weight:800; color:#181512;">
                        <a href="/Frontend/Admin/resellers/orders.php?reseller_id=<?php echo $r['id']; ?>" style="color:#1D4ED8; text-decoration:none;">
                            <?php echo $r['orders']; ?>
                        </a>
                    </td>

                    <!-- Total Purchase -->
                    <td style="text-align:right; font-weight:900; color:#8A681F;">
                        ₹<?php echo number_format($r['purchase']); ?>
                    </td>

                    <!-- Credit Balance -->
                    <td style="text-align:right;">
                        <div style="font-weight:800; color:<?php echo $r['credit'] > $r['credit_limit'] ? '#DC2626' : '#181512'; ?>;">
                            ₹<?php echo number_format($r['credit']); ?>
                        </div>
                        <small style="font-size:0.65rem; color:#78716C;">Limit: ₹<?php echo number_format($r['credit_limit']); ?></small>
                    </td>

                    <!-- KYC Status -->
                    <td>
                        <?php if ($r['kyc'] === 'Verified'): ?>
                            <span class="dt-reseller-badge emerald">✓ Verified</span>
                        <?php elseif ($r['kyc'] === 'Needs Review'): ?>
                            <span class="dt-reseller-badge amber">⏳ Needs Review</span>
                        <?php elseif ($r['kyc'] === 'Rejected'): ?>
                            <span class="dt-reseller-badge rose">✕ Rejected</span>
                        <?php else: ?>
                            <span class="dt-reseller-badge gold">● Pending</span>
                        <?php endif; ?>
                    </td>

                    <!-- Account Status -->
                    <td>
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

                    <!-- Joined -->
                    <td style="color:#78716C; font-size:0.72rem; white-space:nowrap;">
                        <?php echo date('d M Y', strtotime($r['joined'])); ?>
                    </td>

                    <!-- Actions -->
                    <td style="text-align:center; white-space:nowrap;">
                        <div style="display:inline-flex; align-items:center; gap:5px;">
                            <a href="/Frontend/Admin/resellers/view.php?id=<?php echo $r['id']; ?>" class="dt-btn dt-btn-pale dt-btn-sm" title="View 360° Profile">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#705114" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                <span>View</span>
                            </a>

                            <?php if ($r['status'] === 'Pending'): ?>
                                <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="openApprovalModal('<?php echo $r['id']; ?>', '<?php echo htmlspecialchars($r['name']); ?>', '<?php echo $r['tier']; ?>')" title="Approve Application">
                                    <span>Approve</span>
                                </button>
                                <button type="button" class="dt-btn dt-btn-rose dt-btn-sm" onclick="openRejectionModal('<?php echo $r['id']; ?>', '<?php echo htmlspecialchars($r['name']); ?>')" title="Reject Application">
                                    <span>Reject</span>
                                </button>
                            <?php else: ?>
                                <a href="/Frontend/Admin/resellers/edit.php?id=<?php echo $r['id']; ?>" class="dt-btn dt-btn-pale dt-btn-sm" title="Edit Profile">
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#705114" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </a>
                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="toggleResellerSuspension('<?php echo $r['id']; ?>', '<?php echo $r['status']; ?>')" title="<?php echo $r['status'] === 'Suspended' ? 'Reactivate Reseller' : 'Suspend Reseller'; ?>">
                                    <?php if ($r['status'] === 'Suspended'): ?>
                                        <span style="color:#15803D;">Reactivate</span>
                                    <?php else: ?>
                                        <span style="color:#DC2626;">Suspend</span>
                                    <?php endif; ?>
                                </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Empty State -->
<div id="dtResellerEmptyState" style="display:none; padding:40px 20px; text-align:center;">
    <div style="width:48px; height:48px; border-radius:50%; background:#FAF5E8; color:#8A681F; display:inline-flex; align-items:center; justify-content:center; margin-bottom:12px;">
        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#8A681F" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
    </div>
    <h4 style="font-size:0.95rem; font-weight:800; color:#181512; margin:0 0 4px 0;">No matching resellers found</h4>
    <p style="font-size:0.75rem; color:#78716C; margin:0 0 14px 0;">Try adjusting your keyword or clearing active status filters.</p>
    <button type="button" class="dt-btn dt-btn-pale" onclick="clearResellerSearch()">Clear Search Filters</button>
</div>

<!-- Pagination Bar -->
<div class="dt-reseller-pagination">
    <div id="dtResellerFilteredCount">Showing <?php echo count($resellers_data); ?> of <?php echo count($resellers_data); ?> resellers</div>
    <div style="display:flex; align-items:center; gap:6px;">
        <button type="button" class="dt-page-btn" onclick="window.showToast('Previous Page')">‹ Previous</button>
        <button type="button" class="dt-page-btn active">1</button>
        <button type="button" class="dt-page-btn" onclick="window.showToast('Page 2')">2</button>
        <button type="button" class="dt-page-btn" onclick="window.showToast('Page 3')">3</button>
        <button type="button" class="dt-page-btn" onclick="window.showToast('Next Page')">Next ›</button>
    </div>
</div>
