<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * wholesale-credit.php — DT Brand's & Jai Hanuman Tex
 * Revolving Credit Line, Headroom Progress & Double-Entry Ledger (100% Dynamic)
 */
require_once __DIR__ . '/wholesale-data.php';
$whl_id = isset($_GET['id']) ? $_GET['id'] : (isset($wholesale['id']) ? $wholesale['id'] : 'WHL-8012');
$wholesale = isset($wholesale) && is_array($wholesale) ? $wholesale : getWholesalePartner($whl_id);

$sanctioned = max(0, (float)$wholesale['sanctioned_limit']);
$utilized = max(0, (float)$wholesale['utilized_credit']);
$available = max(0, (float)$wholesale['available_credit']);

$util_pct = $sanctioned > 0 ? round(($utilized / $sanctioned) * 100, 1) : 0;
$avail_pct = $sanctioned > 0 ? round(100 - $util_pct, 1) : 100;

$credit_txns = getWholesaleCreditTxns($wholesale['id']);
?>

<div style="display:flex; flex-direction:column; gap:16px;">
    <!-- ══ AMBIENT GLASS CREDIT METRICS BANNER ══ -->
    <div class="dt-wholesale-credit-hero">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
            <div>
                <span style="font-size:0.68rem; color:#FFE57F; font-weight:800; text-transform:uppercase;">REVOLVING WHOLESALE CREDIT FACILITY</span>
                <h3 style="font-size:1.2rem; font-weight:900; color:#FFFFFF; margin:2px 0 0 0;"><?php echo htmlspecialchars($wholesale['legal_name']); ?> Credit Line</h3>
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="openCreditAdjustmentModal('<?php echo $wholesale['id']; ?>', <?php echo $sanctioned; ?>, <?php echo $utilized; ?>)">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                    <span>Adjust Credit Limit</span>
                </button>
                <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="openRecordSettlementModal('<?php echo $wholesale['id']; ?>', <?php echo $utilized; ?>)">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Record Settlement</span>
                </button>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:12px; margin-top:6px;">
            <div style="background:rgba(255,255,255,0.06); border:1px solid rgba(212,175,55,0.3); border-radius:8px; padding:10px 14px;">
                <span style="font-size:0.65rem; color:#F5ECCE; font-weight:800; text-transform:uppercase;">SANCTIONED CREDIT</span>
                <div id="heroSanctionedLimit" style="font-size:1.25rem; font-weight:900; color:#FFE57F;">₹<?php echo number_format($sanctioned); ?></div>
            </div>
            <div style="background:rgba(255,255,255,0.06); border:1px solid rgba(212,175,55,0.3); border-radius:8px; padding:10px 14px;">
                <span style="font-size:0.65rem; color:#F5ECCE; font-weight:800; text-transform:uppercase;">CURRENT UTILIZED</span>
                <div id="heroUtilizedCredit" style="font-size:1.25rem; font-weight:900; color:#FFFFFF;">₹<?php echo number_format($utilized); ?></div>
            </div>
            <div style="background:rgba(21,128,61,0.15); border:1px solid rgba(134,239,172,0.4); border-radius:8px; padding:10px 14px;">
                <span style="font-size:0.65rem; color:#86EFAC; font-weight:800; text-transform:uppercase;">AVAILABLE HEADROOM</span>
                <div id="heroAvailableCredit" style="font-size:1.25rem; font-weight:900; color:#86EFAC;">₹<?php echo number_format($available); ?></div>
            </div>
        </div>

        <div style="display:flex; flex-direction:column; gap:4px; margin-top:4px;">
            <div style="display:flex; justify-content:space-between; font-size:0.7rem;">
                <span id="progressPctText" style="color:#F5ECCE; font-weight:700;"><?php echo $sanctioned > 0 ? $util_pct . '% Used' : 'Prepaid Account'; ?></span>
                <span id="progressAvailText" style="color:#86EFAC; font-weight:700;"><?php echo $sanctioned > 0 ? $avail_pct . '% (₹' . number_format($available) . ') Available' : 'No Credit Assigned'; ?></span>
            </div>
            <div class="dt-wholesale-progress-wrap">
                <div id="creditUtilizationProgressBar" class="dt-wholesale-progress-bar" style="width:<?php echo min(100, $util_pct); ?>%;"></div>
            </div>
        </div>
    </div>

    <!-- ══ DOUBLE-ENTRY LEDGER TABLE AUDIT CARD ══ -->
    <div class="dt-card" style="background:#FFFFFF; border:1.5px solid #EAE5D9; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.02); overflow:hidden;">
        <!-- Toolbar Header -->
        <div style="padding:12px 16px; border-bottom:1.5px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:28px; height:28px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                </div>
                <div>
                    <h4 style="font-size:0.9rem; font-weight:800; color:#181512; margin:0;">Revolving Credit Double-Entry Ledger</h4>
                    <p style="font-size:0.7rem; color:#78716C; margin:1px 0 0 0;">Immutable double-entry log of order debits, settlements, and credit renewals.</p>
                </div>
            </div>

            <!-- Filter & Search Controls -->
            <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                <!-- Live Search Box -->
                <div style="position:relative; width:200px;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#78716C" stroke-width="2.2" style="position:absolute; left:9px; top:50%; transform:translateY(-50%); pointer-events:none;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" id="wholesaleLedgerSearchInput" class="dt-wholesale-input" style="width:100%; height:30px; padding-left:28px; font-size:0.72rem; border-radius:6px; border:1.2px solid #EAE5D9; box-sizing:border-box;" placeholder="Search Txn, Order, UTR..." oninput="filterWholesaleCreditLedger()">
                </div>

                <!-- Type Filter -->
                <select id="wholesaleLedgerTypeFilter" class="dt-wholesale-input" style="height:30px; font-size:0.72rem; padding:0 8px; border-radius:6px; border:1.2px solid #EAE5D9; box-sizing:border-box;" onchange="filterWholesaleCreditLedger()">
                    <option value="all">All Types</option>
                    <option value="debit">Debits (Orders)</option>
                    <option value="credit">Credits (Settlements)</option>
                </select>

                <!-- Export Button -->
                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="exportWholesaleLedgerStatement('<?php echo $wholesale['id']; ?>')">
                    <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Export CSV</span>
                </button>
            </div>
        </div>

        <div style="overflow-x:auto; width:100%;">
            <table class="dt-wholesale-table">
                <thead>
                    <tr>
                        <th style="white-space:nowrap;">Txn Reference</th>
                        <th style="white-space:nowrap;">Timestamp</th>
                        <th style="white-space:nowrap;">Narration / Description</th>
                        <th style="text-align:right; white-space:nowrap;">Debit (₹)</th>
                        <th style="text-align:right; white-space:nowrap;">Credit (₹)</th>
                        <th style="text-align:right; white-space:nowrap;">Utilized After</th>
                        <th style="text-align:right; white-space:nowrap;">Available Credit</th>
                        <th style="text-align:right; white-space:nowrap;">Voucher</th>
                    </tr>
                </thead>
                <tbody id="wholesaleCreditLedgerTbody">
                    <?php foreach ($credit_txns as $tx): ?>
                        <tr class="wholesale-ledger-row" data-type="<?php echo $tx['debit'] !== '—' ? 'debit' : 'credit'; ?>" style="border-bottom:1px solid #F1ECE1;">
                            <td class="wledger-id-cell" style="font-family:monospace; font-weight:800; color:#8A681F; white-space:nowrap;"><?php echo $tx['id']; ?></td>
                            <td style="color:#78716C; font-size:0.75rem; white-space:nowrap;"><?php echo $tx['date']; ?></td>
                            <td class="wledger-desc-cell" style="font-weight:700; color:#181512; white-space:nowrap;"><?php echo htmlspecialchars($tx['desc']); ?></td>
                            <td style="text-align:right; font-weight:900; color:#DC2626; white-space:nowrap;"><?php echo $tx['debit']; ?></td>
                            <td style="text-align:right; font-weight:900; color:#15803D; white-space:nowrap;"><?php echo $tx['credit']; ?></td>
                            <td style="text-align:right; font-weight:700; color:#181512; white-space:nowrap;"><?php echo $tx['utilized_after']; ?></td>
                            <td style="text-align:right; font-weight:900; color:#8A681F; white-space:nowrap;"><?php echo $tx['avail_after']; ?></td>
                            <td style="text-align:right; white-space:nowrap;">
                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="viewWholesaleVoucher('<?php echo $tx['id']; ?>', '<?php echo addslashes($tx['desc']); ?>', '<?php echo $tx['debit'] !== '—' ? '-' . $tx['debit'] : '+' . $tx['credit']; ?>', '<?php echo $tx['date']; ?>', 'ORD-WHL-4821', 'Wholesale Finance Desk', '<?php echo addslashes($wholesale['name']); ?>', '<?php echo $wholesale['gstin']; ?>', '<?php echo $wholesale['id']; ?>')">
                                    <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                    <span>Voucher</span>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
