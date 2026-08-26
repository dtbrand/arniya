# 👑 DT BRAND'S & JAI HANUMAN TEX — MASTER ARCHITECTURE & FULL SYSTEM AUDIT
> **Comprehensive Mastermind Blueprint, UI/UX Ecosystem, Popup & Modal Mapping, Backend Core Architecture, REST API Suite, Database Schema & Performance Standard**
> *Platform: DT Brand's Luxury Ethnic Handlooms & B2B Wholesale CRM*
> *Deployment Target: Hostinger Production Server (`147.93.99.134` / `/public_html/`) & GitHub (`dtbrand/arniya`)*

---

## 🏛️ 1. Complete Architecture Overview

```text
┌────────────────────────────────────────────────────────────────────────────────────────────────────────┐
│                              DT BRAND'S MULTI-CHANNEL COMMERCE ENGINE                                  │
├────────────────────────────────────────────────────────────────────────────────────────────────────────┤
│ 🌐 STOREFRONT & PORTALS          │ 👑 ADMIN EXECUTIVE SUITE           │ 🔌 REST API & SERVICES          │
│ • Home Page (/)                  │ • Executive Command (/admin/)      │ • /api/products.php            │
│ • Shop Catalog (/shop)           │ • Products Hub (/admin/products/)  │ • /api/orders.php              │
│ • Product PDP (/product.php?id=) │ • Orders Hub (/admin/orders/)      │ • /api/customers.php           │
│ • Wholesale B2B (/wholesale)     │ • Catalogue Hub (/admin/catalogue/)│ • /api/auth.php                │
│ • Reseller Hub (/reseller)       │ • Wholesalers (/admin/wholesale/)  │ • /api/cart.php                │
│ • Retailer Hub (/retailer)       │ • Resellers (/admin/resellers/)    │ • /api/wishlist.php            │
│ • Account Portal (/account)      │ • Customers (/admin/customers/)    │ • /api/db_health.php           │
├──────────────────────────────────┴────────────────────────────────────┴────────────────────────────────┤
│ 🧠 BACKEND CORE ENGINES (PHP 8.2+ OOP PDO)                                                             │
│ • Database.php (Multi-Candidate Connection Pool: localhost, 127.0.0.1, utf8mb4)                        │
│ • ProductCatalog.php (Dynamic MySQL Catalog, Category Taxonomy, Tiered Wholesale Pricing)             │
│ • OrderManager.php (Transactional Order Placement, Multi-Item Batching, Stock Decrement)               │
│ • CustomerManager.php (Multi-Channel Identity CRM, Credit Balances, Tier Resolution)                  │
│ • PricingCalculator.php (B2B Volume Tiering, 5% Textile GST, Margin & Commission Algorithms)          │
├────────────────────────────────────────────────────────────────────────────────────────────────────────┤
│ 🗄️ LIVE MYSQL DATABASE (u602484543_demodt121 — 21 Production Tables)                                  │
│ • products, categories, subcategories, brands, attributes, product_media, product_reviews              │
│ • orders, order_items, order_status_history, coupons, quotations, whatsapp_logs                       │
│ • customers, wallets, wallet_transactions, admins, banners, settings, activity_logs                    │
└────────────────────────────────────────────────────────────────────────────────────────────────────────┘
```

---

## 📱 2. Front-End Pages & Portals Mapping

| Page URL | Template File | Primary Purpose | Key Components Included | Database Integrations |
|---|---|---|---|---|
| **`/` (Home)** | `DT Brand/index.php` | Luxury Brand Storefront Landing | Hero Slider, Curated Collections, Featured Grid, Testimonials, Footer | `categories`, `products`, `banners`, `settings` |
| **`/shop`** | `DT Brand/shop.php` | Full E-Commerce Product Catalog | Category Pills, Live Price Filters, QuickView, Grid/List Views, Cart Drawer | `products`, `categories`, `coupons` |
| **`/product.php?id=X`** | `DT Brand/product.php` | Single Product PDP (Product Detail Page) | High-Res Zoom Gallery, MOQ Lots, Pincode Checker, WhatsApp Enquiry, Size Modal | `products`, `product_reviews`, `categories` |
| **`/wholesale`** | `DT Brand/wholesale.php` | Wholesale B2B Bulk Purchasing Portal | Tiered MOQ Pricing (8/16/32+ Pcs), Bale Calculator, Direct Depot Dispatch | `products`, `categories`, `customers` |
| **`/reseller`** | `DT Brand/reseller.php` | Zero-Investment Reseller Dashboard | Profit Margin Calculator, 1-Click WhatsApp Media Sharing, Customer CRM, Earnings | `products`, `orders`, `customers` |
| **`/retailer`** | `DT Brand/retailer.php` | Retailer Fast-Order Hub | Single Unit Fast Reorders, Live Inventory Tracker, Direct Dispatch | `products`, `orders`, `customers` |
| **`/account`** | `DT Brand/account.php` | Customer Identity & Authentication | Unified Sign In, WhatsApp OTP, Wholesale/Reseller Registration, Past Orders | `customers`, `orders`, `wallets` |

---

## 🪟 3. Pop-ups, Modals, Drawers & Interactive Overlays Mapping

| Modal / Popup | Component File / Trigger | Features & User Actions | Backend / JS Flow |
|---|---|---|---|
| **🛒 Cart Drawer** | `shared/cart-drawer.php` (`openCartDrawer()`) | Slide-over cart, quantity +/- steppers, item removal, coupon input, subtotal, checkout trigger | `localStorage` + `window.cartState` + `/api/cart.php` |
| **💳 Checkout Modal** | `shared/checkout.php` (`openCheckout()`) | Full-screen luxury checkout overlay, address fields, 10-digit phone validator, payment methods (Razorpay, UPI, COD, Wire), WhatsApp order invoice creation | Submits POST to `/api/orders.php`, writes to MySQL `orders` & `order_items`, updates customer spend, decrements stock |
| **👁️ QuickView Modal** | `shared/quickview.php` (`openQuickView(id)`) | Instant product preview without leaving page, image switcher, price breakdown, size picker, instant add-to-cart | Dynamically populated via `window.allProducts` / `/api/products.php?id=X` |
| **❤️ Wishlist Modal** | `shared/wishlist.php` (`openWishlist()`) | Saved favorite items list, 1-click move to cart, instant removal | `localStorage` + `/api/wishlist.php` |
| **📐 Size Chart Modal** | `shared/size-chart.php` (`openSizeChartModal()`) | Ethnic saree, blouse & kurti measurements (Inches & CM), drape guidance | Self-contained luxury modal |
| **🚚 Pincode Estimator** | `product.php` (`checkPincode()`) | Live delivery date estimation (Delhivery Express Priority 2-4 days) | Dynamic JavaScript calculation based on entered pincode |
| **💬 WhatsApp Share Modal** | `wholesale.php` / `reseller.php` | 1-Click share high-res product catalog, wholesale lot pricing, and description to buyer | Native WhatsApp API link generation (`api.whatsapp.com/send`) |
| **🚪 Admin Logout Modal** | `admin/Includes/adminheader.php` | Obsidian luxury confirmation modal on Sign Out click | Controlled via `openDtLogoutModal()` / `closeDtLogoutModal()` |

---

## 👑 4. Admin Suite Modules Mapping

| Module Name | Directory / URL | Key Features | Real Database Metrics |
|---|---|---|---|
| **Executive Command** | `/admin/` & `/admin/admin.php` | Real-time overview of Sales Analytics, Live Orders, Gross Margins, Low Stock warnings | `SELECT COALESCE(SUM(total_amount), 0) FROM orders`, `COUNT(*) FROM products` |
| **Products Management** | `/admin/products/` | Dual View Switcher (WooCommerce Table + Wholesale Grid), Real SKU filters, Stock alerts, Star featured toggle | Dynamic loop from `ProductCatalog::getAll()`, valuations, category links |
| **Add / Edit Product** | `/admin/products/add.php` & `edit.php` | Multi-image media uploader, wholesale vs retail pricing, MOQ configurations, fabric & weave settings | Direct CRUD to `products` and `product_media` tables |
| **Catalogue & Taxonomy** | `/admin/catalogue/` | Taxonomy Flow (Root Categories ➔ Subcategories ➔ Collections ➔ Total SKUs), Hierarchy Tree | Dynamic loop from `categories`, `subcategories`, `collections` |
| **Orders & Logistics** | `/admin/orders/` | 12-Card KPI status ribbon, Bulk courier label printing, Invoice generation, Status updates | Dynamic query on `orders` and `order_items` |
| **Wholesale B2B CRM** | `/admin/wholesale/` | Corporate buyer accounts, credit limits, outstanding ledger, wholesale price tier manager | `customers WHERE type = 'wholesale'` |
| **Reseller Portal CRM** | `/admin/resellers/` | Reseller partner registrations, commission tracking, active catalog shares | `customers WHERE type = 'reseller'` |
| **Customers Directory** | `/admin/customers/` | Shopper directory, lifetime order history, total spend analytics, WhatsApp chat trigger | `customers` table |
| **Inventory & Stock** | `/admin/inventory/` | Depot stock levels, SKU replenishment alerts, warehouse depot tracking | `products` stock management |
| **WhatsApp CRM Live** | `/admin/whatsapp/` | Direct customer broadcast engine, abandoned checkout recovery, dispatch tracking alerts | `whatsapp_logs`, `orders` |

---

## 🔌 5. REST API Suite & Backend Endpoints

| Endpoint URL | HTTP Methods | Parameters / Payload | Description & Output |
|---|---|---|---|
| **`/api/products.php`** | `GET`, `POST`, `PUT`, `DELETE` | `id`, `category`, `search`, `page`, `limit`, product JSON | Full CRUD engine for products. Returns JSON product lists or single product object with gallery and stock. |
| **`/api/orders.php`** | `GET`, `POST` | `action=create`, `customer_name`, `customer_phone`, `items`, `payment_method` | Creates real database orders with transaction safety, decrements stock, updates customer analytics, returns order number and WhatsApp message. |
| **`/api/customers.php`** | `GET`, `POST`, `PUT`, `DELETE` | `id`, `type`, customer profile JSON | CRUD for B2B wholesalers, resellers, and retail customers. |
| **`/api/auth.php`** | `POST` | `action=login` or `action=register`, `identity`, `password`, `type` | Secure password verification via `password_verify` and registration with role handling. |
| **`/api/cart.php`** | `GET`, `POST` | `items`, `coupon_code` | Validates cart items, verifies real-time stock availability, applies discounts. |
| **`/api/wishlist.php`** | `GET`, `POST` | `customer_id`, `product_id` | Manages customer wishlist items. |
| **`/api/db_health.php`** | `GET` | `key=Gautam9006MasterInstall&action=status` | Database diagnostic endpoint: reports live connection status, table row counts, and schema validation. |

---

## 🗄️ 6. MySQL Database Schema Mapping (21 Tables)

```sql
-- Core Catalog
products (id, sku, title, slug, category_id, category, mrp, price, retail_price, wholesale_price, reseller_price, stock_qty, moq, fabric, weave, color, badge, rating, reviews_count, image, status, created_at, updated_at)
categories (id, name, slug, description, image, display_order, products_count, status, created_at)
subcategories (id, category_id, name, slug, status, created_at)
brands (id, name, slug, logo, description, status, created_at)
attributes (id, name, code, type, values_json, created_at)
product_media (id, product_id, media_url, media_type, sort_order, is_primary, created_at)
product_reviews (id, product_id, customer_name, rating, review_text, verified_buyer, status, created_at)

-- Multi-Channel Orders & Fulfillment
orders (id, order_number, customer_id, customer_name, customer_phone, channel, subtotal, discount, gst_rate, gst_amount, shipping_fee, total_amount, payment_method, payment_status, fulfillment_status, tracking_number, courier_name, created_at)
order_items (id, order_id, product_id, product_title, sku, unit_price, quantity, total_price)
order_status_history (id, order_id, old_status, new_status, comments, updated_by, created_at)
coupons (id, code, discount_type, discount_value, min_order_amount, usage_limit, times_used, expires_at, status, created_at)
quotations (id, quote_number, customer_id, items_json, total_amount, status, created_at)
whatsapp_logs (id, recipient_phone, message_type, order_id, status, sent_at)

-- Customer CRM & Wallets
customers (id, name, phone, email, password, type, city, state, tier, credit_limit, outstanding_balance, total_orders, lifetime_spend, gstin, pan, commission_rate, status, created_at)
wallets (id, customer_id, balance, currency, updated_at)
wallet_transactions (id, wallet_id, type, amount, description, reference_id, created_at)

-- System Administration & Merchandising
admins (id, name, email, password, role, status, last_login, created_at)
banners (id, title, subtitle, image, link, position, sort_order, status, created_at)
settings (id, `key`, `value`, group_name, updated_at)
activity_logs (id, user_type, user_id, action, ip_address, created_at)
```

---

## ⚡ 7. High-Performance Fast-Load PHP Architecture Standard

To guarantee sub-second server response times and ultra-smooth fluid UI performance:

1. **🚀 Gzip & Brotli Output Buffering**:
   - `DT Brand/.htaccess` automatically compresses all HTML, CSS, JavaScript, JSON, and SVG files before transmission.
2. **⚡ Smart Browser Caching (`Cache-Control` & `Expires`)**:
   - Static assets (CSS, JS, Fonts, PNG, WebP, SVG) cached for 30 days (`max-age=2592000`).
   - Dynamic API endpoints use `no-cache, must-revalidate` for live accuracy.
3. **🔄 Multi-Candidate Database Connection Engine (`Database.php`)**:
   - Tries `localhost` and `127.0.0.1` connection pool with `PDO::ATTR_PERSISTENT => false` and `PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION`.
   - Reuses working PDO connection instance across the request lifecycle without reconnect overhead.
4. **🎨 100% Signature Design System Preservation**:
   - Inter & Plus Jakarta Sans typography stack.
   - 100% Real Indian Rupee (`₹`) SVG icon standard.
   - Master Heritage Gold buttons (`#8A681F` to `#D4AF37`) & Obsidian dark containers (`#181512`).
   - Zero UI alterations — 100% visual fidelity maintained across all devices.

---

## 🔄 8. Triple-Sync Deployment Protocol

Every modification strictly follows the 3-step synchronization:
1. **Local**: Clean validation and testing in `c:\Users\sai\Desktop\WhatsApp CRM`.
2. **GitHub**: Auto-commit with clear descriptive commit message to `origin main`.
3. **Hostinger Live FTP**: Binary deployment directly to `/public_html/` on IP `147.93.99.134`.
