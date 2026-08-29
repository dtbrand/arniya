# 👑 Module 6: Reseller Management Suite

## 🏢 DT Brand's & Jai Hanuman Tex — Admin Production System

Module 6 provides complete enterprise management for DT Brand's boutique social sellers, wholesale resellers, and drop-shippers.

---

### 📂 File Structure

```text
Admin/resellers/
├── index.php                 # Master Reseller Dashboard & Directory
├── pending.php               # Pending Applications Review Queue
├── approved.php              # Approved Resellers Active Directory
├── rejected.php              # Rejected Resellers Archive
├── suspended.php             # Suspended Resellers View
├── view.php                  # Reseller 360° Executive Profile Hub
├── edit.php                  # Reseller Profile Editor & Onboarding Form
├── applications.php          # Reseller Application Review Queue
├── verification.php          # KYC & Identity / Business Verification Studio
├── documents.php             # KYC Document Vault & File Storage
├── business.php              # Reseller Business, GSTIN & Legal Information
├── addresses.php             # Showroom, Billing & Primary Dispatch Addresses
├── orders.php                # Reseller Sourced Orders & Dropship History
├── pricing.php               # Tiered Pricing, Margins & MOQ Studio
├── credit.php                # B2B Credit Limit, Wallet Balance & Ledger
├── commissions.php           # Reseller Commissions & Weekly Settlement Hub
├── activity.php              # Reseller Audit Trail & Activity Log
├── notes.php                 # Internal Staff CRM Memos & Notes
├── tags.php                  # Reseller Dynamic Tagging Studio
├── segments.php              # Performance Cohorts & Reseller Clusters
├── analytics.php             # Reseller Growth, GMV Velocity & Payout Analytics
├── export.php                # Reseller Data Export Studio (CSV / Excel / PDF)
│
├── components/
│   ├── reseller-table.php    # Master Data Table with Filters & Sorting
│   ├── reseller-stats.php    # 8-Card Executive KPI Ribbon
│   ├── reseller-search.php   # Search Toolbar with Actions
│   ├── reseller-filters.php  # Advanced Multi-Dimension Filter Drawer
│   ├── reseller-status.php   # Status Update & Credit Adjustment Modals
│   ├── reseller-profile.php  # Luxury Gold & Silver/Platinum Hero Banner
│   ├── reseller-business.php # Business Legal & GSTIN Component
│   ├── reseller-documents.php# Document Vault Grid Component
│   ├── reseller-verification.php # 4-Stage Verification Audit Component
│   ├── reseller-orders.php   # Orders History Component
│   ├── reseller-pricing.php  # Tier Pricing & Discount Cards
│   ├── reseller-credit.php   # Credit Ledger & Balance Banner
│   ├── reseller-commission.php # Commission Tracking Component
│   ├── reseller-activity.php # Activity Timeline Component
│   ├── reseller-notes.php    # Staff Internal Notes Component
│   ├── reseller-tags.php     # Dynamic Tags Studio Component
│   ├── reseller-segments.php # Cohorts & Clusters Component
│   └── bulk-actions.php      # Multi-Record Batch Action Bar
│
├── assets/
│   ├── css/
│   │   ├── resellers.css
│   │   ├── reseller-list.css
│   │   ├── reseller-view.css
│   │   ├── reseller-business.css
│   │   ├── reseller-documents.css
│   │   ├── reseller-pricing.css
│   │   ├── reseller-credit.css
│   │   └── reseller-analytics.css
│   │
│   └── js/
│       ├── resellers.js
│       ├── reseller-list.js
│       ├── reseller-view.js
│       ├── reseller-filters.js
│       ├── reseller-status.js
│       ├── reseller-verification.js
│       ├── reseller-documents.js
│       ├── reseller-pricing.js
│       ├── reseller-credit.js
│       ├── reseller-commission.js
│       └── bulk-actions.js
│
└── README.md
```

---

### 👑 Master Design Standards Adherence
- **100% Vector SVG Icons**: Zero emojis in buttons or table headers.
- **100% Styled Buttons**: Primary Radiant Gold, Dark Obsidian, Emerald, and Pale Gold buttons.
- **Animated Focus Border**: Gold & Platinum mix rotating conic-gradient focus line.
- **Real-Time Interactivity**: Zero dead buttons; search filtering, sorting, pagination, and multi-format exports fully functional.
