# DT Brand's — Module 2: Products & Catalogue Management Suite

## 🌟 Overview
Module 2 is a desktop-first, production-grade Product Management and Catalog Suite built specifically for **DT Brand's & Jai Hanuman Tex**.

## 📁 Architecture & File Layout
```
Frontend/Admin/products/
├── index.php                 # Master Products Catalogue & 11-col Data Table
├── add.php                   # Add Product Studio with live pricing & SEO previews
├── edit.php                  # Edit Product Studio
├── view.php                  # Detailed Product Overview & Analytics Hub
├── duplicate.php             # Fast SKU cloning utility
│
├── categories/               # Taxonomy Root Management
│   ├── index.php
│   ├── add.php
│   ├── edit.php
│   └── view.php
│
├── subcategories/            # Sub-category collections
│   ├── index.php
│   ├── add.php
│   └── edit.php
│
├── brands/                   # House labels & Brand management
│   ├── index.php
│   ├── add.php
│   └── edit.php
│
├── attributes/               # Color, Fabric, Weave, Size attributes
│   ├── index.php
│   ├── add.php
│   ├── edit.php
│   └── values.php
│
├── variants/                 # Dynamic multi-variant combinations matrix
│   ├── index.php
│   ├── add.php
│   ├── edit.php
│   └── view.php
│
├── media/                    # Media asset vault & High-Res upload dropzone
│   ├── index.php
│   ├── upload.php
│   └── gallery.php
│
├── reviews/                  # Customer reviews & 5-star moderation
│   ├── index.php
│   ├── pending.php
│   ├── approved.php
│   ├── rejected.php
│   └── reported.php
│
├── featured/                 # Featured spotlight catalog
│   └── index.php
│
├── best-sellers/             # High volume ranking catalog
│   └── index.php
│
├── new-arrivals/             # 2026 Drops & Festive arrivals
│   └── index.php
│
├── imports/                  # 7-Step CSV / Excel import wizard
│   ├── index.php
│   ├── upload.php
│   ├── preview.php
│   ├── errors.php
│   └── history.php
│
├── exports/                  # Multi-format catalog export studio
│   ├── index.php
│   └── history.php
│
├── components/               # 16 Reusable UI Components
│   ├── product-table.php
│   ├── product-card.php
│   ├── product-filters.php
│   ├── product-search.php
│   ├── product-stats.php
│   ├── bulk-actions.php
│   ├── product-status.php
│   ├── product-gallery.php
│   ├── product-form.php
│   ├── product-pricing.php
│   ├── product-inventory.php
│   ├── product-variants.php
│   ├── product-shipping.php
│   ├── product-seo.php
│   ├── product-activity.php
│   └── product-permissions.php
│
└── assets/
    ├── css/                  # 8 Modular Luxury Gold Stylesheets
    └── js/                   # 9 Modular UI Controllers
```

## 💎 Features Included
- **9 KPI Summary Cards** with real-time percentages and trend indicators.
- **16-Column Desktop Data Table** with responsive overflow, sticky headers, and action menus.
- **Multi-Tier Pricing Calculator** for live MRP discount and gross margin preview.
- **Google SEO SERP Preview** updating live on title/slug input.
- **7-Step Import Wizard** with column mapping and validation breakdown.
