# DT Brand's & Jai Hanuman Tex — Module 4: Order Management

## 👑 Overview

The **Order Management Module** is the enterprise fulfillment, dispatch, and tracking center for DT Brand's & Jai Hanuman Tex. It handles multi-channel wholesale B2B lot consignments, reseller orders, and retail parcels with 100% real Indian Rupee (`₹`) SVG currency, crisp inline vector icons, and an interactive state workflow.

---

## 📁 Architecture & File Structure

```text
Frontend/Admin/orders/
├── index.php                 (Main Orders Dashboard)
├── pending.php               (Pending Verification Orders)
├── processing.php            (Processing & Picking)
├── confirmed.php             (Payment Confirmed)
├── packed.php                (Packed in Master Cartons)
├── shipped.php               (In-Transit Consignments)
├── out-for-delivery.php      (Out for Delivery Today)
├── delivered.php             (Delivered Consignments)
├── cancelled.php             (Cancelled Orders)
├── failed.php                (Failed Gateway Orders)
├── returned.php              (Returned Consignments)
├── refunded.php              (Refunds Ledger)
├── view.php                  (Single Order Details)
├── invoice.php               (B2B Tax Invoice)
├── packing-slip.php          (Warehouse Packing Slip)
├── shipping-label.php        (Courier Shipping Label)
├── returns.php               (Return Merchandise Management)
├── refunds.php               (Refunds Management)
├── export.php                (Order Export Studio)
│
├── components/
│   ├── order-stats.php       (12-Card KPI Metrics Ribbon)
│   ├── order-search.php      (Debounced Live Search)
│   ├── order-filters.php     (Advanced Filters Drawer)
│   ├── order-table.php       (Master Orders Table)
│   ├── order-status.php      (Status Badges & Helpers)
│   ├── order-status-timeline.php (Visual Progression Stepper)
│   ├── order-items.php       (Order Line Items Breakdown)
│   ├── order-summary.php     (Financial Summary)
│   ├── customer-summary.php  (Customer Profile & WhatsApp)
│   ├── payment-summary.php   (Payment Gateway & Transaction)
│   ├── shipping-summary.php  (Logistics & Dispatch)
│   ├── order-address.php     (Billing & Shipping Addresses)
│   ├── order-notes.php       (Internal Notes Manager)
│   ├── order-activity.php    (Audit Trail Log)
│   ├── order-actions.php     (Status & Cancel Modals)
│   ├── return-panel.php      (RMA Return Actions)
│   ├── refund-panel.php      (Refund Drawer)
│   ├── invoice-preview.php   (Invoice Layout Partial)
│   ├── packing-slip-preview.php (Packing Slip Partial)
│   └── shipping-label-preview.php (Shipping Label Partial)
│
└── assets/
    ├── css/ (orders.css, order-list.css, order-view.css, order-status.css, returns.css, refunds.css, documents.css)
    └── js/  (orders.js, order-list.js, order-view.js, order-filters.js, order-status.js, bulk-actions.js, returns.js, refunds.js, documents.js)
```

---

## 🎯 Key Features

- **12-Card KPI Metrics Ribbon**: Real-time order metrics across every lifecycle stage.
- **0ms Debounced Live Search**: Instant filtering by Order ID, customer name, phone, and SKU.
- **Full Workflow Validations**: Update status modal with reason logs and cancellation safeguards.
- **Printable B2B Invoices & Slips**: GST tax invoice, packing slip, and shipping labels with barcodes.
- **RMA Returns & Refund Drawer**: Authorize reverse pickups and calculate eligible refunds.
- **Triple-Sync Deployment**: Synced locally, on GitHub, and deployed live to Hostinger FTP.
