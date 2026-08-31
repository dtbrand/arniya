<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * customer-status.php — Status Update & Account Suspension Modal
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
?>

<!-- ══ CUSTOMER STATUS MODAL ══ -->
<div id="dtCustStatusModal" class="dt-modal-backdrop" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(3px);">
    <div class="dt-card" style="width:95%; max-width:440px; margin:auto; border-radius:12px; border:1.5px solid var(--dt-gold-primary); box-shadow:0 12px 36px rgba(0,0,0,0.3);">
        <div class="dt-card-head" style="border-bottom:1.5px solid #F1ECE1; padding-bottom:10px; margin-bottom:14px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:28px; height:28px; border-radius:7px; background:var(--dt-gold-pale); border:1px solid var(--dt-gold-radiant); display:flex; align-items:center; justify-content:center; color:var(--dt-gold-primary);">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                </div>
                <h3 class="dt-card-title" style="font-size:1.05rem;">Update Customer Status</h3>
            </div>
            <button type="button" onclick="closeCustomerStatusModal()" style="background:none; border:none; font-size:1.2rem; cursor:pointer; color:#78716C;">✕</button>
        </div>

        <form onsubmit="submitCustomerStatusChange(event)" style="display:flex; flex-direction:column; gap:12px;">
            <p style="font-size:0.75rem; color:#78716C; margin:0;">Modifying account standing for customer <strong id="dtCustStatusTargetId" style="color:#181512;">#CUST-1042</strong>:</p>

            <div>
                <label style="font-size:0.74rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Select Account Status</label>
                <select id="dtCustNewStatusSelect" class="dt-cust-select" style="width:100%;">
                    <option value="active">Active Verified (Full Ordering & Wishlist Access)</option>
                    <option value="inactive">Inactive / Dormant Account</option>
                    <option value="suspended">Suspended (Block Ordering & Cod Abuse Protection)</option>
                </select>
            </div>

            <div>
                <label style="font-size:0.74rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Reason / Internal Staff Memo</label>
                <textarea id="dtCustStatusReasonInput" class="dt-cust-search-input" style="height:70px; resize:none; padding-left:12px;" placeholder="Optional reason for status adjustment (logged in audit trail)..."></textarea>
            </div>

            <div style="display:flex; align-items:center; justify-content:flex-end; gap:8px; border-top:1.5px solid #F1ECE1; padding-top:12px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeCustomerStatusModal()">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">Confirm Status Update</button>
            </div>
        </form>
    </div>
</div>
