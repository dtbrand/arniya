# Module 8: Retail Management Suite — DT Brand's & Jai Hanuman Tex

## 1. Overview
The **Retail Management Suite** (`/Frontend/Admin/retail/`) is DT Brand's executive direct-to-consumer (D2C) administrative headquarters. It governs retail customer behavior, direct sales and gross/net revenue analysis, retail product pricing and margins, campaign discounts and coupons, visual merchandising collections, active shopping bag sessions, abandoned cart recovery, 7-step checkout funnel drop-offs, customer cohorts, wishlist demand, reviews moderation, and export studio.

## 2. Integration Architecture (Non-Duplication)
Retail Management interfaces seamlessly with existing core modules:
- **Products**: Connected to `/Frontend/Admin/products/`
- **Orders**: Connected to `/Frontend/Admin/orders/`
- **Customers**: Connected to `/Frontend/Admin/customers/`
- **Catalogue**: Connected to `/Frontend/Admin/catalogue/`
- **Pricing & Discounts**: Connected to `/Frontend/Admin/pricing/`

## 3. Directory Layout
```text
Frontend/Admin/retail/
├── index.php                 # Retail Dashboard Hub with 12-Card KPI Ribbon & Velocity Chart
├── customers.php             # Retail Customer Directory with AOV, Orders & Profile Dossiers
├── orders.php                # Retail Orders List with Item Breakdown & Quick View Modals
├── sales.php                 # Retail Sales Performance (Gross, Net, Discounts, Returns)
├── revenue.php               # Retail Net Revenue Studio & Periodical Financial Breakdowns
├── pricing.php               # Retail Pricing & Margin Control (MRP vs Selling Price)
├── discounts.php             # Retail Promotional Codes & Coupon Discounts
├── catalogue.php             # Retail Merchandising & Collection Management
├── products.php              # Retail Products Channel Visibility Manager
├── cart.php                  # Live Shopping Bag Monitor (Active Sessions)
├── abandoned-carts.php       # Abandoned Cart Inspector & 1-Click WhatsApp Recovery
├── checkout.php              # 7-Step Checkout Funnel & Conversion Drop-off Diagnostics
├── segments.php              # Retail Customer Segments & Behavioral Cohorts
├── activity.php              # Real-Time Retail Activity Stream & Audit Log
├── reviews.php               # Retail Product Ratings & Reviews Analytics
├── wishlist.php              # Customer Wishlist Demand & Popularity Index
├── analytics.php             # Retail Sourcing & Sales Velocity Growth Analytics
├── export.php                # Multi-Format Retail Export Studio (CSV, XLS, PDF)
│
├── components/               # 18 Reusable Production Components
├── assets/css/               # 10 Responsive CSS Stylesheets
└── assets/js/                # 12 JavaScript Engines & Modal Handlers
```

## 4. Master Design & Quality Standard
- **Inter / Plus Jakarta Sans Typography**: High-contrast typography hierarchy (`#111827`, `#181512`, `#8A681F`).
- **Animated Gold & Platinum Focus Lines**: Smooth conic-gradient rotating borders on all focused inputs.
- **Indian Rupee (`₹`) SVG Standard**: 100% vector SVG standard for all currency metrics.
- **Zero Dead Buttons**: Fully connected modal engines, client-side live search/filters, debounced query filtering, and WhatsApp notification generators.
