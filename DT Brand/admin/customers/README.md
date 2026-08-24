# 👥 DT BRAND'S ADMIN PANEL — MODULE 5: CUSTOMER MANAGEMENT

> **Production Module Documentation & Architecture Specification**  
> DT Brand's & Jai Hanuman Tex — Master Wholesale & Direct CRM Console

---

## 📌 1. Module Overview

Module 5 provides an enterprise-grade **Customer Relationship Management (CRM) & Shopper Directory** designed specifically for DT Brand's direct retail shoppers (`4,820 Shoppers`). It is strictly isolated from wholesale/reseller B2B partner accounts while providing deep 360° customer dossiers, lifetime financial analytics, and 1-click WhatsApp connectivity.

---

## 📂 2. File & Component Architecture

```text
Frontend/Admin/customers/
├── index.php                 (Main Customer Dashboard & Master Directory)
├── new.php                   (New Customer Registrations)
├── active.php                (Active Verified Customer Accounts)
├── inactive.php              (Inactive & Dormant Accounts)
├── view.php                  (Customer 360° Profile & Deep Dossier)
├── edit.php                  (Edit Customer Details & Preferences)
├── orders.php                (Customer Order History & Logistics Tracker)
├── addresses.php             (Customer Shipping & Billing Addresses)
├── activity.php              (Audit Trail & Security Timeline)
├── notes.php                 (Internal Staff Notes & Action Items)
├── tags.php                  (Customer Tagging Studio)
├── segments.php              (Dynamic Customer Segmentation Engine)
├── export.php                (Customer Export Studio - CSV / Excel / PDF)
├── analytics.php             (Customer Growth, LTV & Retention Analytics)
│
├── components/
│   ├── customer-table.php    (High-density responsive customer table)
│   ├── customer-stats.php    (8-Card KPI Ribbon & Status Flow Pills)
│   ├── customer-search.php   (Debounced search bar + quick suggestions)
│   ├── customer-filters.php  (Advanced multi-criteria filter modal)
│   ├── customer-status.php   (Status update & suspension modal)
│   ├── customer-profile.php  (Profile card with KYC & contact actions)
│   ├── customer-summary.php  (LTV & financial summary badge)
│   ├── customer-orders.php   (Customer order list partial)
│   ├── customer-addresses.php(Billing/shipping address cards)
│   ├── customer-activity.php (Visual timeline event stream)
│   ├── customer-notes.php    (Staff notes & memo system)
│   ├── customer-tags.php     (Tag manager & pill chip editor)
│   ├── customer-segments.php (Segment criteria builder cards)
│   └── bulk-actions.php      (Multi-select floating action bar)
│
└── assets/
    ├── css/
    │   ├── customers.css          (Core styling, layout & badges)
    │   ├── customer-list.css      (Table, toolbar & pagination)
    │   ├── customer-view.css      (360° detail dossier layout)
    │   ├── customer-profile.css   (Profile header & contact pills)
    │   ├── customer-segments.css  (Segment builder & criteria UI)
    │   └── customer-analytics.css (Charts, heatmaps & metric cards)
    │
    └── js/
        ├── customers.js           (Core module controller & toasts)
        ├── customer-list.js       (Live search, sorting & pagination)
        ├── customer-view.js       (Tab switcher & copy contact tools)
        ├── customer-filters.js    (Filter presets & range picker)
        ├── customer-status.js     (Status confirmation modal logic)
        ├── bulk-actions.js        (Select-all & batch operations)
        ├── customer-tags.js       (Tag assignment & chip remover)
        └── customer-segments.js   (Segment rule calculator)
```

---

## 👑 3. Golden Design Standards Followed

- **100% Real Indian Rupee (`₹`) Vector SVGs**: All financial metrics, AOV, and lifetime spend values use Indian Rupee currency tokens.
- **DT Brand's Luxury Buttons**: Master Gold Gradient (`#8A681F` to `#D4AF37`), Pale Gold Secondary Pills (`#FAF5E8`), and WhatsApp Emerald (`#15803D`).
- **Zero Emojis in Buttons & Headers**: Inline vector SVGs exclusively.
- **Fluid Auto-Sizing**: All cards, tables, and modals auto-adjust across desktop (1366px, 1440px, 1920px), tablet, and mobile.
- **No Dead Buttons**: Every action link, modal trigger, filter chip, and export button is backed by working JavaScript.
