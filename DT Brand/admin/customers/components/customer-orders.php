<?php
/**
 * customer-orders.php — Customer Orders History Table Component
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
$customer_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : 'CUST-1042';
?>

<!-- ══ CUSTOMER RECENT ORDERS SUB-TABLE ══ -->
<div class="dt-cust-table-wrap" style="border:none; box-shadow:none;">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
        <h4 style="font-size:0.9rem; font-weight:800; color:#181512; margin:0;">Recent Purchase History (6 Orders)</h4>
        <a href="/DT%20Brand/admin/orders/index.php?search=<?php echo $customer_id; ?>" class="dt-btn dt-btn-pale dt-btn-sm">View Full Order Stream →</a>
    </div>

    <table class="dt-cust-table" style="min-width:700px;">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Date & Time</th>
                <th>Items Ordered</th>
                <th>Total Value</th>
                <th>Payment Mode</th>
                <th>Status</th>
                <th style="text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><a href="/DT%20Brand/admin/orders/view.php?id=ORD-9842" style="color:#8A681F; font-weight:800; text-decoration:none; font-family:monospace;">#ORD-9842</a></td>
                <td>Today, 11:20 AM</td>
                <td><strong>2 Items</strong> (Surat Silk Saree + Kurti)</td>
                <td><strong style="color:#181512;">₹6,850</strong></td>
                <td><span class="dt-status-pill active" style="font-size:0.65rem;">UPI Prepaid</span></td>
                <td><span class="dt-status-pill active" style="font-size:0.65rem;">● Processing</span></td>
                <td style="text-align:right;">
                    <a href="/DT%20Brand/admin/orders/view.php?id=ORD-9842" class="dt-cust-act-btn" title="View Order Details">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </a>
                </td>
            </tr>
            <tr>
                <td><a href="/DT%20Brand/admin/orders/view.php?id=ORD-9418" style="color:#8A681F; font-weight:800; text-decoration:none; font-family:monospace;">#ORD-9418</a></td>
                <td>04 Mar 2026</td>
                <td><strong>1 Item</strong> (Banarasi Katan Silk Saree)</td>
                <td><strong style="color:#181512;">₹8,900</strong></td>
                <td><span class="dt-status-pill active" style="font-size:0.65rem;">Razorpay</span></td>
                <td><span class="dt-status-pill active" style="font-size:0.65rem;">● Delivered</span></td>
                <td style="text-align:right;">
                    <a href="/DT%20Brand/admin/orders/view.php?id=ORD-9418" class="dt-cust-act-btn" title="View Order Details">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </a>
                </td>
            </tr>
            <tr>
                <td><a href="/DT%20Brand/admin/orders/view.php?id=ORD-8920" style="color:#8A681F; font-weight:800; text-decoration:none; font-family:monospace;">#ORD-8920</a></td>
                <td>18 Jan 2026</td>
                <td><strong>3 Items</strong> (Chanderi Printed Kurtis)</td>
                <td><strong style="color:#181512;">₹5,400</strong></td>
                <td><span class="dt-status-pill" style="font-size:0.65rem; background:#FAF8F4; border:1px solid #EAE5D9;">COD Verified</span></td>
                <td><span class="dt-status-pill active" style="font-size:0.65rem;">● Delivered</span></td>
                <td style="text-align:right;">
                    <a href="/DT%20Brand/admin/orders/view.php?id=ORD-8920" class="dt-cust-act-btn" title="View Order Details">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
