# 👑 DT Brand's & Jai Hanuman Tex — Module 7: Wholesale Management Suite

> **Production B2B Corporate Wholesale & Margin Management Architecture**
> Comprehensive enterprise suite for managing B2B corporate wholesale accounts, multi-tier pricing structures, revolving credit facilities, minimum order quantity (MOQ) rules, and high-volume fulfillment pipelines.

---

## 📁 Architecture Overview

```text
Frontend/Admin/wholesale/
├── index.php                      # Wholesale Dashboard & Master Accounts Directory
├── pending.php                    # Pending Application Reviews (14 Accounts)
├── approved.php                   # Approved Verified Partners (98 Accounts)
├── rejected.php                   # Rejected Applications Archive (10 Records)
├── suspended.php                  # Suspended & Credit Breach Accounts (6 Accounts)
├── applications.php               # B2B Onboarding & Review Pipeline
├── view.php                       # Master 360 Partner Profile & Interactive Dossier
├── edit.php                       # Account & Commercial Profile Editor
├── verification.php               # Business KYC & GSTIN Compliance Gateway
├── documents.php                  # Encrypted AES-256 Document Vault
├── business.php                   # Legal Entity & Tax Directory
├── addresses.php                  # Multi-Warehouse & Dispatch Hub Directory
├── orders.php                     # Wholesale Sourcing Orders & Bulk POs
├── pricing.php                    # Multi-Tier Category Margins Matrix
├── price-lists.php                # Custom Catalog Price Lists Manager
├── tiers.php                      # 4-Tier Wholesale Qualification Architecture
├── moq.php                        # Minimum Order Quantity & Volume Quantity Breaks
├── discounts.php                  # Seasonal Wholesale Promotions & Cash Rebates
├── payment-terms.php              # Commercial Settlement Horizons (Net 15/30/45)
├── credit.php                     # Revolving Credit Hub, Ledger & Certified Vouchers
├── activity.php                   # Immutable Blockchain-Grade Audit Trail Feed
├── notes.php                      # Commercial Memorandums & Risk Notes
├── tags.php                       # Commercial Account Badges & Tagging Engine
├── segments.php                   # Dynamic Wholesale Cohorts & Sourcing Clusters
├── analytics.php                  # GMV Velocity & Wholesale Retention Analytics
├── export.php                     # Multi-Format Data Exporter (CSV, XLS, High-DPI PDF)
│
├── components/                    # 21 Modular UI Partials
│   ├── wholesale-stats.php        # 8-Card Master KPI Ribbon & Flow Pills
│   ├── wholesale-table.php        # Master Account Table with 1-Line Status Badges
│   ├── wholesale-search.php       # Live Debounced Search & Quick Filter Bar
│   ├── wholesale-filters.php      # Advanced Multi-Facet Commercial Filter Drawer
│   ├── wholesale-profile.php      # Master Luxury Ambient Glass Hero & 360 Tabs
│   ├── wholesale-business.php     # Legal Business Structure & Tax Identity Card
│   ├── wholesale-documents.php    # Document Vault Table & Upload Triggers
│   ├── wholesale-verification.php # 4-Step KYC Verification Audit
│   ├── wholesale-orders.php       # Purchase Orders & Delivery Fulfillment
│   ├── wholesale-pricing.php      # Fabric Category Margins & Live Recalculation
│   ├── wholesale-price-list.php   # Catalog Price Lists
│   ├── wholesale-tier.php         # 4-Tier Benefit Matrix & Thresholds
│   ├── wholesale-moq.php          # Lot Sizing & Volume Rebates
│   ├── wholesale-discount.php     # Seasonal Rebates & Cash Discount Matrix
│   ├── wholesale-credit.php       # Revolving Credit Banner & Double-Entry Ledger
│   ├── wholesale-payment-terms.php# Net Days Terms & Grace Period Rules
│   ├── wholesale-activity.php     # Immutable Audit Log
│   ├── wholesale-notes.php        # Internal Notes
│   ├── wholesale-tags.php         # Commercial Tags
│   ├── wholesale-segments.php     # Performance Cohorts
│   └── bulk-actions.php           # Batch Operations Bar
│
└── assets/
    ├── css/                       # 9 Modular Stylesheets
    │   ├── wholesale.css          # Core Design Tokens, Buttons & Focus Animations
    │   ├── wholesale-list.css     # KPI Grids, Search & Table Layouts
    │   ├── wholesale-view.css     # Luxury Glass Hero & Sub-Tabs
    │   ├── wholesale-pricing.css  # Tier Margin Grids
    │   ├── wholesale-price-list.css # Price Lists Layout
    │   ├── wholesale-tiers.css    # Tier Matrix Cards
    │   ├── wholesale-moq.css      # Volume Breaks & MOQ Rules
    │   ├── wholesale-credit.css   # Ambient Credit Banner & Headroom Bar
    │   └── wholesale-analytics.css # Visual Velocity Bar Charts
    └── js/                        # 14 Interactive JS Modules
```

---

## 👑 Key Design & Quality Highlights
- **DT Brand's Master Gold Buttons**: High-contrast obsidian typography with radiant gold gradients.
- **Strict 1-Line Badges (`.dt-status-pill-clean`)**: Guaranteed zero multi-line wrap across all status indicators.
- **100% Indian Rupee (`₹`) Standard**: Official SVG rupee icons used across all valuations, GMV metrics, and vouchers.
- **Zero Dead Buttons**: Every button, modal trigger, document download, and credit adjuster is wired to working frontend/backend logic.
- **High-DPI PDF Export**: Integrated `jsPDF` & `html2canvas` for direct 1:1 crisp PDF dossier generation.
