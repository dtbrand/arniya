<?php
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

    <!-- ══ DOUBLE-ENTRY LEDGER TABLE ══ -->
    <div class="dt-card">
        <div class="dt-card-head">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                <h4 class="dt-card-title">Revolving Credit Double-Entry Ledger</h4>
            </div>
            <span class="dt-status-pill-clean gold">Audit Logged</span>
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
                <tbody>
                    <?php foreach ($credit_txns as $tx): ?>
                        <tr style="border-bottom:1px solid #F1ECE1;">
                            <td style="font-family:monospace; font-weight:800; color:#8A681F; white-space:nowrap;"><?php echo $tx['id']; ?></td>
                            <td style="color:#78716C; font-size:0.75rem; white-space:nowrap;"><?php echo $tx['date']; ?></td>
                            <td style="font-weight:700; color:#181512; white-space:nowrap;"><?php echo htmlspecialchars($tx['desc']); ?></td>
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
