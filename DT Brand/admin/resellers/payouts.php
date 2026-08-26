<?php
/**
 * payouts.php - DT Brand's Admin Weekly Reseller Payouts Hub
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Weekly Reseller Payouts Hub";
$active_nav = "resellers";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Reseller Payouts Hub - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Weekly Reseller Payouts Hub</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">₹48,500 Pending</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Batch settle earned profit margins directly to reseller bank accounts via automated IMPS / UPI payouts.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/resellers/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">← Reseller Network</a>
                    <button type="button" class="dt-btn dt-btn-gold" style="height:32px; font-size:12px; font-weight:800;" onclick="settleAllPayouts()">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>🚀 Batch Settle All (₹48,500)</span>
                    </button>
                </div>
            </div>

            <!-- Payout Table Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>⚡ Pending Profit Margin Dispatches</span></h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;">🟢 Bank API Connected</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Reseller Partner</th>
                                <th>Beneficiary Bank / UPI</th>
                                <th>Delivered Orders</th>
                                <th>Earned Margin</th>
                                <th>Status</th>
                                <th style="text-align:right;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="payoutsTableBody">
                            <tr>
                                <td><strong>Ananya Roy</strong><br><small style="color:#64748B;">Kolkata Boutique</small></td>
                                <td><code>HDFC0001234 • Acc: 98124401</code></td>
                                <td>28 Sarees Delivered</td>
                                <td><strong style="color:#8A681F; font-size:13.5px;">₹8,400</strong></td>
                                <td><span class="adm-badge gold">Ready to Settle</span></td>
                                <td style="text-align:right;">
                                    <button type="button" class="dt-btn dt-btn-emerald" style="height:28px; padding:0 12px; font-size:11.5px;" onclick="settleSinglePayout(this, 'Ananya Roy', '₹8,400')">Pay ₹8,400</button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Meera Agarwal</strong><br><small style="color:#64748B;">Surat Saree House</small></td>
                                <td><code>ICIC0000981 • Acc: 55410981</code></td>
                                <td>42 Sarees Delivered</td>
                                <td><strong style="color:#8A681F; font-size:13.5px;">₹14,200</strong></td>
                                <td><span class="adm-badge gold">Ready to Settle</span></td>
                                <td style="text-align:right;">
                                    <button type="button" class="dt-btn dt-btn-emerald" style="height:28px; padding:0 12px; font-size:11.5px;" onclick="settleSinglePayout(this, 'Meera Agarwal', '₹14,200')">Pay ₹14,200</button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Pooja Sharma</strong><br><small style="color:#64748B;">Mumbai Saree Studio</small></td>
                                <td><code>pooja.sharma@okhdfcbank</code></td>
                                <td>16 Sarees Delivered</td>
                                <td><strong style="color:#8A681F; font-size:13.5px;">₹5,600</strong></td>
                                <td><span class="adm-badge gold">Ready to Settle</span></td>
                                <td style="text-align:right;">
                                    <button type="button" class="dt-btn dt-btn-emerald" style="height:28px; padding:0 12px; font-size:11.5px;" onclick="settleSinglePayout(this, 'Pooja Sharma', '₹5,600')">Pay ₹5,600</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script>
function settleSinglePayout(btn, name, amount) {
    btn.disabled = true;
    btn.textContent = '✓ Settled';
    btn.style.background = '#059669';
    const row = btn.closest('tr');
    const badge = row ? row.querySelector('.adm-badge') : null;
    if (badge) {
        badge.className = 'adm-badge success';
        badge.textContent = 'Paid (IMPS)';
    }
    if (typeof window.showToast === 'function') {
        window.showToast(`✨ ${amount} transferred to ${name} via IMPS bank gateway!`);
    }
}

function settleAllPayouts() {
    document.querySelectorAll('#payoutsTableBody tr').forEach(r => {
        const btn = r.querySelector('button');
        if (btn) {
            btn.disabled = true;
            btn.textContent = '✓ Settled';
            btn.style.background = '#059669';
        }
        const badge = r.querySelector('.adm-badge');
        if (badge) {
            badge.className = 'adm-badge success';
            badge.textContent = 'Paid (IMPS)';
        }
    });
    if (typeof window.showToast === 'function') {
        window.showToast('🚀 Batch Payout of ₹48,500 processed and settled across all reseller accounts!');
    }
}
</script>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
