<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * customer-addresses.php — Customer Shipping & Billing Address Management
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
?>

<!-- ══ CUSTOMER ADDRESS BOOK ══ -->
<div>
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
        <h4 style="font-size:0.9rem; font-weight:800; color:#181512; margin:0;">Saved Shipping & Billing Addresses</h4>
        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('Add Address modal opened')">+ Add Address</button>
    </div>

    <div class="dt-cust-address-grid">
        <!-- Default Shipping Address -->
        <div class="dt-cust-address-card default">
            <div>
                <div class="dt-cust-address-head">
                    <span class="dt-cust-address-type">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        Default Shipping Address
                    </span>
                    <span class="dt-status-pill active" style="font-size:0.6rem;">Default</span>
                </div>
                <div class="dt-cust-address-body" style="margin-top:8px;">
                    <strong>Pooja Sharma</strong><br>
                    Plot No. 42, Pocket B-4, Sector 11<br>
                    Rohini, New Delhi, Delhi — 110085<br>
                    Phone: +91 98110 29381
                </div>
            </div>
            <div style="display:flex; gap:6px; border-top:1px solid #EAE5D9; padding-top:8px;">
                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('Edit address')">Edit</button>
            </div>
        </div>

        <!-- Secondary Office Address -->
        <div class="dt-cust-address-card">
            <div>
                <div class="dt-cust-address-head">
                    <span class="dt-cust-address-type" style="color:#78716C;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                        Work / Office Address
                    </span>
                </div>
                <div class="dt-cust-address-body" style="margin-top:8px;">
                    <strong>Pooja Sharma (Tech Park)</strong><br>
                    Tower 3, 5th Floor, Cyber Hub<br>
                    DLF Phase 2, Gurugram, HR — 122002<br>
                    Phone: +91 98110 29381
                </div>
            </div>
            <div style="display:flex; gap:6px; border-top:1px solid #EAE5D9; padding-top:8px;">
                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('Address set as default')">Set as Default</button>
                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('Edit address')">Edit</button>
            </div>
        </div>
    </div>
</div>
