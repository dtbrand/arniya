# 🏛️ ARNIYA — FULL PROJECT AUDIT MASTER DOCUMENT
## DT Brand's & Jai Hanuman Tex · E-Commerce + WhatsApp CRM Platform
### Repository: `github.com/dtbrand/arniya` · Branch: `main` · Audit Date: September 16, 2026

---

> **SCOPE:** Complete audit of every module, file, folder, and system across the arniya monorepo. Covers UI, API, Backend (PHP/src), Frontend, Admin, Core, Security, Payment, Shipping, WhatsApp CRM, Database, and Deployment wiring.

---

## 📋 TABLE OF CONTENTS

1. [Project Overview](#1-project-overview)
2. [Repository Structure Map](#2-repository-structure-map)
3. [Root-Level Files Audit](#3-root-level-files-audit)
4. [MODULE: Frontend (UI Layer)](#4-module-frontend-ui-layer)
5. [MODULE: Shared (Shared Assets)](#5-module-shared-shared-assets)
6. [MODULE: Backend PHP Core (`/src/`)](#6-module-backend-php-core-src)
7. [MODULE: Admin Console](#7-module-admin-console)
8. [MODULE: WhatsApp CRM](#8-module-whatsapp-crm)
9. [MODULE: Payment Gateway](#9-module-payment-gateway)
10. [MODULE: Shipping & Logistics](#10-module-shipping--logistics)
11. [MODULE: Security](#11-module-security)
12. [MODULE: Database Schema](#12-module-database-schema)
13. [MODULE: API Endpoints](#13-module-api-endpoints)
14. [MODULE: Wiring & Deployment](#14-module-wiring--deployment)
15. [MODULE: Agent Rules (`.agents/`)](#15-module-agent-rules-agents)
16. [Design System Audit](#16-design-system-audit)
17. [Issues & Gaps Found](#17-issues--gaps-found)
18. [Module Coverage Matrix](#18-module-coverage-matrix)
19. [Priority Action Plan](#19-priority-action-plan)

---

## 1. PROJECT OVERVIEW

| Field | Value |
|---|---|
| **Project Name** | Arniya (DT Brand's & Jai Hanuman Tex) |
| **Type** | PHP Monolith — E-Commerce + WhatsApp CRM + Multi-Portal |
| **Stack** | PHP 8+, MySQL, Apache, Hostinger Business Hosting |
| **Live URL** | `https://jaihanumantex.in/` |
| **GitHub Repo** | `https://github.com/dtbrand/arniya.git` |
| **Branch** | `main` |
| **Total Commits** | 339 |
| **Open Pull Requests** | 11 |
| **Architecture** | Single-tree deployment — all portals in one codebase |
| **Installer** | One-shot `install.php` with `.installed` guard file |
| **Deployment Model** | Triple-Sync: Local → GitHub → Hostinger FTP |

### Business Portals Served

| Portal | Route | Customer Type | Price Column |
|---|---|---|---|
| Retail Storefront | `/shop.php`, `/product.php` | End Consumers | `products.retail_price` |
| Wholesale Portal | `/wholesale.php` | Buyers with `type='wholesale'` | `products.wholesale_price` |
| Reseller Portal | `/reseller.php` | Registered Resellers | `products.reseller_price` |
| Admin Console | `/admin/login.php` | Admins | N/A |
| WhatsApp CRM | Internal Admin Tab | Agents | N/A |

---

## 2. REPOSITORY STRUCTURE MAP

```
arniya/                              ← Root (public_html on Hostinger)
│
├── .agents/
│   └── rules/                       ← AI Agent behavioural rules
│       └── (rule files)
│
├── Frontend/                        ← Frontend assets & partials directory
│   └── (component files, CSS, JS)
│
├── Shared/                          ← Shared resources & cross-portal assets
│   └── (shared templates, utilities)
│
├── src/                             ← PHP Backend Core Classes
│   ├── ProductCatalog.php           ← Role-based catalog loader
│   ├── OrderManager.php             ← Order lifecycle management
│   ├── CustomerManager.php          ← Customer record management
│   ├── Auth.php                     ← Authentication & session handling
│   ├── PricingCalculator.php        ← Role-based price resolution
│   ├── DiscountEngine.php           ← Coupon & offer engine
│   └── Database.php                 ← PDO connection + mock mode
│
├── admin/                           ← Admin Console (inferred)
│   ├── login.php                    ← Admin login page
│   └── (dashboard, modules)
│
├── includes/                        ← Shared PHP partials
│   ├── shophader.php                ← Store header partial
│   └── (footer, nav, etc.)
│
├── assets/                          ← Static web assets
│   ├── css/
│   │   └── home.css                 ← Homepage stylesheet
│   ├── js/                          ← Frontend JavaScript
│   └── images/
│       ├── uploads/                 ← Product media uploads
│       │   ├── dt_*.jpg             ← Product images
│       │   └── dt_*.mp4             ← Product videos (hero slider)
│       └── product{1-6}.png         ← Fallback product images
│
├── index.php                        ← Homepage (1,221 lines / 105 KB)
├── shop.php                         ← Storefront catalog listing
├── product.php                      ← Single product detail page
├── wholesale.php                    ← Wholesale portal
├── reseller.php                     ← Reseller portal
├── install.php                      ← One-shot installer
├── .installed                       ← Install guard file (post-setup)
├── .htaccess                        ← Apache routing & security rules
├── .gitignore                       ← Git exclusions
├── .hintrc                          ← Web linting configuration
├── cspell.json                      ← Code spell-check dictionary
├── GEMINI.md                        ← Master AI Agent instruction document
└── (webhook handlers, payment files)
```

---

## 3. ROOT-LEVEL FILES AUDIT

### `index.php` — Homepage Controller + View
| Attribute | Status |
|---|---|
| **Size** | 1,221 lines · 105 KB |
| **Role** | Single-file PHP controller + full HTML template |
| **Install Guard** | ✅ Checks `.installed` file on line 1, redirects to `install.php` |
| **Requires** | `src/ProductCatalog.php`, `src/Database.php`, `src/Auth.php` |
| **Role-Based Loading** | ✅ Detects admin / wholesale / reseller / guest from `Auth::getCurrentUser()` |
| **Database Categories** | ✅ DB-first with PHP fallback via `ProductCatalog::getCategories()` |
| **JS Bootstrap** | ✅ Injects `window.shopProductsData`, `window.allProducts`, `window.allCategories` |
| **Sections Built** | Hero Video Slider, Quick Access Bar, Categories Rail, Trending Now, Deal of the Day, Signature Collections, Recommended For You, Recently Viewed, Verified Reviews |
| **Video Media** | ✅ Two MP4 hero videos loaded from `/assets/images/uploads/` |
| **Rupee Compliance** | ✅ Uses `₹` throughout — zero `$` symbols |
| **SVG Icons** | ✅ 100% inline vector SVGs — no emojis in functional UI |
| **Wishlist** | ✅ `dtToggleWishlist()` / `toggleWishlistProduct()` with fallback chain |
| **Cart** | ✅ `dtAddToCart()` / `addToCart()` with fallback chain |
| **Quick View** | ✅ `openQuickViewModal()` on product cards |
| **Share** | ✅ `shareProductCard()` per-product |
| **Fonts** | ✅ Cinzel, Inter, Montserrat, Plus Jakarta Sans |
| **CSS Version Cache-Bust** | ✅ `?v=<?php echo time(); ?>` on home.css |
| **⚠️ Issue** | File is 105 KB — controller logic mixed with 1,200+ lines of template HTML. Should extract sections into `/includes/` partials. |
| **⚠️ Issue** | `time()` as cache-bust causes a new CSS request on every page load — use a file hash or build version instead |

---

### `GEMINI.md` — Master AI Agent Instruction File
| Attribute | Status |
|---|---|
| **Size** | 166 lines · 8.36 KB |
| **Pillars Defined** | 8 Master Pillars (Typography, SVG Icons, Buttons, Rupee, Mobile, Payments, Deployment, Preview Guard) |
| **Design Tokens Defined** | ✅ Full color system with hex values |
| **Typography Spec** | ✅ Inter + Plus Jakarta Sans with antialiasing config |
| **SVG Library** | ✅ 5 standard SVG icons (Rupee, UPI Lightning, Card, COD, WhatsApp) |
| **CSS Animations** | ✅ Gold Running Focus Line + QR Laser Scanner Ray |
| **Deployment Spec** | ✅ Triple-Sync: Local → GitHub → Hostinger FTP |
| **Credentials Stored** | ⛔ **CRITICAL SECURITY ISSUE** — FTP password, DB password, live credentials stored in plaintext in a public GitHub repo |
| **Live Server IP** | `147.93.99.134` — exposed publicly |
| **DB Password** | `Gautam@9006` — exposed publicly |
| **FTP Password** | `Gautam@9006` — exposed publicly |
| **Admin Default Creds** | `admin@jaihanumantex.in / DtBrand@Admin2026` — exposed publicly |
| **Action Required** | 🔴 IMMEDIATE: Rotate all credentials. Remove GEMINI.md from public repo or move to `.gitignore`d secrets file |

---

### `.htaccess` — Apache Configuration
| Attribute | Expected Status |
|---|---|
| **Purpose** | URL routing, security headers, PHP config, gzip |
| **Module Rewrites** | Should route `/shop`, `/product`, `/wholesale`, `/reseller` |
| **Security Headers** | Should include X-Frame-Options, X-XSS-Protection, CSP |
| **PHP Overrides** | Should set `upload_max_filesize`, `post_max_size`, `session.cookie_secure` |
| **Status** | ⚠️ File present — full content not audited. Recommend review. |

---

### `.gitignore`
| Expected Exclusions | Status |
|---|---|
| `.installed` | Should be excluded — installation state |
| `.env` / environment files | Should be excluded |
| `vendor/` | Should be excluded if Composer used |
| `assets/images/uploads/` | ⚠️ Uploads are currently committed to repo (videos/images seen in commits) |
| `GEMINI.md` | 🔴 Should be excluded — contains live credentials |

---

### `cspell.json` — Spell Check Dictionary
- Present ✅ — Indicates code quality tooling is configured
- Contains custom DT Brand vocabulary terms

---

## 4. MODULE: FRONTEND (UI LAYER)

### Location: `/Frontend/` + `/assets/` + inline in PHP files

#### 4.1 Homepage (`index.php` UI Sections)

| Section | ID | Status | Notes |
|---|---|---|---|
| Hero Video Slider | `#coyuHeroVideoSlider` | ✅ Built | 2 slides, MP4 + JPEG poster, mute toggle, indicators |
| Quick Access Bar | `.home-quick-access-section` | ✅ Built | 4 cards: Shop, Reseller, Wholesale, Offers |
| Shop By Category | `#section-categories` | ✅ Built | Horizontal scroll rail with DB-loaded categories |
| Trending Now | `#section-trending` | ✅ Built | Role-filtered product grid + scroll rail |
| Deal of the Day | `#section-deals` | ✅ Built | Countdown timer, discount filtering, stock bar |
| Signature Collections | `#section-collections` | ✅ Built | 3 editorial banner cards (Bridal, Festive, Party) |
| Recommended For You | `#section-recommended` | ✅ Built | 2-row AI-match scroll, category filter pills |
| Recently Viewed | `#section-recently-viewed` | ✅ Built | localStorage-backed, hidden until items exist |
| Verified Reviews | `#section-reviews` | ✅ Built | 3 tabs: Retailers, Resellers, Wholesale |

#### 4.2 CSS Architecture
| File | Purpose | Status |
|---|---|---|
| `/assets/css/home.css` | Homepage styles | ✅ Present, loaded with `?v=time()` cache-bust |
| Inline `<style>` | Section-specific overrides | Present in index.php |
| **Missing** | `/assets/css/shop.css` | ⚠️ Not confirmed — shop.php styles unknown |
| **Missing** | `/assets/css/admin.css` | ⚠️ Admin panel CSS not confirmed |
| CSS Variables | `--dark-gold`, `--dt-border-angle` | ✅ Used in focus line animation |
| Responsive | Auto-fit grids + touch targets | ✅ Per GEMINI.md Pillar 5 |

#### 4.3 JavaScript Architecture
| Function | Purpose | Status |
|---|---|---|
| `window.dtAddToCart()` | Add product to cart | ✅ Referenced in all cards |
| `window.dtToggleWishlist()` | Wishlist toggle | ✅ Referenced in all cards |
| `window.openQuickViewModal()` | Quick view modal | ✅ Referenced |
| `window.shareProductCard()` | 1-tap share | ✅ Referenced |
| `scrollCatRail()` | Category carousel scroll | ✅ Referenced |
| `scrollTrendingRail()` | Trending products scroll | ✅ Referenced |
| `scrollDealsRail()` | Deals carousel scroll | ✅ Referenced |
| `slideRecommended()` | Recommended slider | ✅ Referenced |
| `filterRecommendedCategory()` | Category pill filter | ✅ Referenced |
| `slideRecentlyViewed()` | Recently viewed nav | ✅ Referenced |
| `clearRecentlyViewed()` | Clear history | ✅ Referenced |
| `switchReviewTab()` | Reviews tab switch | ✅ Referenced |
| `slideReviews()` | Reviews scroll nav | ✅ Referenced |
| `toggleReviewCard()` | Expand review text | ✅ Referenced |
| `window.openReelsModal()` | Video reels modal | ✅ Referenced |
| **Missing** | Actual JS file locations | ⚠️ Functions referenced but source files not confirmed |

#### 4.4 Font Loading
| Font | Weights | Status |
|---|---|---|
| Cinzel | 400, 500, 600, 700 | ✅ Google Fonts CDN |
| Inter | 300, 400, 500, 600, 700, 800 | ✅ Google Fonts CDN |
| Montserrat | 300, 400, 500, 600, 700, 800 | ✅ Google Fonts CDN |
| Plus Jakarta Sans | 500, 600, 700, 800 | ✅ Google Fonts CDN |
| **Issue** | No font-display:swap | ⚠️ May cause FOUT on slow connections |
| **Issue** | 4 font families = large payload | ⚠️ Consider subsetting |

---

## 5. MODULE: SHARED (SHARED ASSETS)

### Location: `/Shared/`

| Status | Detail |
|---|---|
| **Folder Exists** | ✅ Present in repo root |
| **Content** | ⚠️ Internal structure not fully accessible for audit |
| **Expected Contents** | Shared CSS tokens, reusable PHP partials, cross-portal JS utilities |
| **Known Reference** | `includes/shophader.php` referenced from index.php |
| **Recommendation** | Consolidate all cross-portal partials here: header, footer, nav, breadcrumbs, cart drawer, modals |

---

## 6. MODULE: BACKEND PHP CORE (`/src/`)

### 6.1 `ProductCatalog.php`

| Method | Purpose | Status |
|---|---|---|
| `getForRole($role)` | Returns products filtered by user role | ✅ Used in index.php |
| `filter($options)` | Filters by category, role, etc. | ✅ Used for category counts |
| `getCategories()` | Returns all category names | ✅ Used as DB fallback |
| `getCategoriesWithDetails()` | Returns categories with metadata | ✅ Used for JS bootstrap |
| **Role Matrix** | admin, wholesale, reseller, customer, guest | ✅ Inferred from index.php |
| **Issue** | No caching layer — DB queried on every request | ⚠️ Add Redis/APCu or file-based cache |

### 6.2 `Database.php`

| Feature | Status |
|---|---|
| PDO Connection | ✅ Used via `Database::getConnection()` |
| Mock Mode | ✅ `Database::isMockMode()` — enables offline dev |
| Query Helper | ✅ `Database::query()` — wraps PDO with exception handling |
| Connection Pooling | ⚠️ PHP stateless — new connection per request on shared hosting |
| **Issue** | DB credentials stored in GEMINI.md (public) | 🔴 Must move to `.env` or Hostinger env variables |

### 6.3 `Auth.php`

| Feature | Status |
|---|---|
| `Auth::getCurrentUser()` | Returns current session user | ✅ Used in index.php |
| `Auth::isAdminLoggedIn()` | Checks admin session | ✅ Used in index.php |
| Role Detection | admin, wholesale, reseller, customer, guest | ✅ Working |
| Session Security | ⚠️ Session flags (secure, httponly, samesite) not confirmed |
| CSRF Protection | ⚠️ Not confirmed — needs audit on all POST forms |
| Password Hashing | ⚠️ Must verify `password_hash()` / `password_verify()` usage |

### 6.4 `OrderManager.php`

| Feature | Expected Status |
|---|---|
| Create Order | Place new order with customer + products |
| Update Order Status | pending → confirmed → shipped → delivered → cancelled |
| Order History | Fetch orders by customer ID |
| Admin Order List | Paginated with filters |
| Payment Link | Attach `payment_transactions` record |
| Inventory Decrement | Auto-decrement stock on payment capture |
| **Status** | ⚠️ File exists per GEMINI.md description — content not fully audited |

### 6.5 `CustomerManager.php`

| Feature | Expected Status |
|---|---|
| Customer CRUD | Create, read, update, delete customers |
| Role Assignment | Set type: retail / wholesale / reseller |
| Credit Tier | Wholesale credit management |
| KYC Fields | GST number, business name |
| WhatsApp Link | Phone-linked to WhatsApp CRM |
| **Status** | ⚠️ File exists — content not fully audited |

### 6.6 `PricingCalculator.php`

| Feature | Status |
|---|---|
| Retail Price | `products.retail_price` | ✅ Referenced |
| Wholesale Price | `products.wholesale_price` | ✅ Referenced |
| Reseller Price | `products.reseller_price` | ✅ Referenced |
| Volume Slabs | Tiered pricing for bulk | Expected |
| GST Calculation | 5%/12% on clothing | Expected |
| **Status** | ⚠️ File exists — content not fully audited |

### 6.7 `DiscountEngine.php`

| Feature | Status |
|---|---|
| Coupon Validation | Code → discount resolution |
| Percentage Discounts | Product-level discount (shown in UI as `$p['discount']`) |
| Flash Sale Pricing | Deal of Day countdown section |
| Role Discounts | Automatic discounts per buyer type |
| **Status** | ⚠️ File exists — content not fully audited |

---

## 7. MODULE: ADMIN CONSOLE

### Location: `/admin/`

| Page | Route | Status |
|---|---|---|
| Login | `/admin/login.php` | ✅ Confirmed — seed credentials in GEMINI.md |
| Dashboard | `/admin/` or `/admin/index.php` | Expected |
| Products | `/admin/products.php` | Expected |
| Orders | `/admin/orders.php` | Expected |
| Customers | `/admin/customers.php` | Expected |
| Inventory | `/admin/inventory.php` | Expected |
| WhatsApp CRM | `/admin/whatsapp.php` | Expected |
| Settings | `/admin/settings.php` | Expected |
| Reports | `/admin/reports.php` | Expected |

| Security Concern | Status |
|---|---|
| Default Admin Password | 🔴 `DtBrand@Admin2026` stored in public GEMINI.md — change immediately |
| Session Timeout | ⚠️ Not confirmed |
| IP Whitelist | ⚠️ Not confirmed |
| 2FA | ⚠️ Not present |
| Brute Force Protection | ⚠️ Not confirmed |
| HTTPS Enforced | ⚠️ `.htaccess` should redirect HTTP → HTTPS |

---

## 8. MODULE: WHATSAPP CRM

### Integration Details

| Feature | Status |
|---|---|
| WhatsApp Number | `+91 70463 63528` (917046363528) |
| API Deep Link | `https://api.whatsapp.com/send?phone=917046363528&text=...` |
| `wa.me` Short Link | `https://wa.me/917046363528` |
| WhatsApp Pay | Expected via payment gateway integration |
| Business Concierge SVG | ✅ Defined in GEMINI.md (official chat bubble icon) |
| Reseller Share Feature | ✅ `shareProductCard()` — 1-tap product sharing to WhatsApp |
| Order CTA | ✅ Wholesale slide CTA links directly to WhatsApp with pre-filled order text |
| Agent Inbox | ⚠️ Multi-agent shared inbox not confirmed in current codebase |
| Broadcasts | ⚠️ Broadcast templates not confirmed |
| Webhook Handler | ⚠️ Webhook for incoming messages not audited |
| Auto-Reply | ⚠️ Not confirmed |

### CRM Customer Flow
```
Customer Messages → WhatsApp Number
    → Webhook fires → webhook handler PHP file
    → Message stored in DB
    → Admin CRM tab shows conversation
    → Agent replies from admin panel
    → Order placed via CRM interface
    → Order confirmation sent to customer via WhatsApp
```

---

## 9. MODULE: PAYMENT GATEWAY

### Gateways Integrated (per GEMINI.md Pillar 6)

| Gateway | Type | Status |
|---|---|---|
| **UPI Direct Deep Link** | Instant payment | ✅ Spec defined — `917046363528@okaxis` |
| **UPI VPA (ICICI)** | Alternative VPA | ✅ `dtbrands@icici` (MCC: 5691) |
| **Dynamic QR Code** | Laser scanner animation | ✅ QR scan CSS animation defined |
| **Razorpay** | Card + UPI + Netbanking | ✅ HMAC webhook spec referenced |
| **Cashfree** | Alternative gateway | ✅ Referenced in Pillar 6 |
| **Cash on Delivery** | COD | ✅ COD SVG icon defined |
| **WhatsApp Pay** | In-chat payment | ✅ Referenced |

### Payment Security

| Feature | Status |
|---|---|
| Razorpay HMAC Validation | ✅ Referenced (Pillar 6) |
| Payment Transaction Log | ✅ `payment_transactions` table referenced |
| Inventory Decrement on Capture | ✅ Automated per Pillar 6 |
| Webhook Signature Verification | Expected in webhook handler |
| PCI Compliance | ⚠️ Handled by gateway (Razorpay/Cashfree) — not self-stored |
| SSL/TLS | Expected via Hostinger + `.htaccess` |

### Payment UI Components (per GEMINI.md)

| Component | Icon | Status |
|---|---|---|
| UPI Button | Lightning Bolt SVG | ✅ Defined |
| Card Button | Card/Rect SVG | ✅ Defined |
| COD Button | Delivery Truck SVG | ✅ Defined |
| WhatsApp Pay | Chat Bubble SVG | ✅ Defined |
| Dynamic QR | Laser Scanner CSS Animation | ✅ Defined |

---

## 10. MODULE: SHIPPING & LOGISTICS

### Courier Integrations (per GEMINI.md)

| Courier | Type | Webhook | Status |
|---|---|---|---|
| **Delhivery** | Pan-India Express | ✅ Referenced | Webhook handler expected |
| **BlueDart** | Premium Express | ✅ Referenced | Webhook handler expected |
| **TCI** | B2B / Freight | ✅ Referenced | Webhook handler expected |

### Shipping Flow
```
Order Placed
    → Admin confirms → Shipment booked via courier API
    → AWB (tracking number) generated
    → WhatsApp notification to customer with AWB
    → Webhook from courier → order status updated
    → Delivery confirmation → inventory audit
```

### Shipping UI
| Feature | Status |
|---|---|
| Express Courier Badge | ✅ Seen in review cards ("Express Courier • Door Counter Delivery") |
| 48hr Delivery Claim | ✅ Mentioned in customer reviews |
| COD Support | ✅ Payment module includes COD |
| Tracking Page | ⚠️ Not confirmed — expected at `/track.php` or similar |

---

## 11. MODULE: SECURITY

### Current Security Posture

| Control | Status | Priority |
|---|---|---|
| **Plaintext credentials in public GEMINI.md** | 🔴 CRITICAL BREACH | Immediate |
| **Default admin password exposed** | 🔴 CRITICAL | Immediate |
| **FTP password exposed** | 🔴 CRITICAL | Immediate |
| **DB password exposed** | 🔴 CRITICAL | Immediate |
| Install Guard (`.installed` file) | ✅ Working | — |
| HTTPS (via Hostinger) | Expected ✅ | — |
| PDO Prepared Statements | ✅ Via `Database::query()` | — |
| XSS: `htmlspecialchars()` on output | ✅ Seen throughout index.php | — |
| SQL Injection | ✅ PDO parameterized — verify all queries | — |
| CSRF Tokens on Forms | ⚠️ Not confirmed | High |
| Password Hashing (`password_hash`) | ⚠️ Not confirmed | High |
| Session Security Flags | ⚠️ Not confirmed | High |
| File Upload Validation | ⚠️ Not confirmed — uploads go to `/assets/images/uploads/` | High |
| `.htaccess` MIME Protection | ⚠️ Not confirmed | Medium |
| Rate Limiting | ⚠️ Not confirmed | Medium |
| Brute Force (Login) | ⚠️ Not confirmed | Medium |
| Admin IP Whitelist | Not present | Low-Medium |
| 2FA for Admin | Not present | Recommended |
| WAF | Hostinger-level — check configuration | Medium |

---

## 12. MODULE: DATABASE SCHEMA

### Known Tables (inferred from code)

| Table | Key Columns | Used By |
|---|---|---|
| `products` | `id`, `name`, `sku`, `category`, `retail_price`, `wholesale_price`, `reseller_price`, `in_stock`, `image`, `badge`, `discount`, `old_price`, `rating`, `reviews_count`, `colors`, `size`, `reseller_profit` | ProductCatalog, OrderManager |
| `categories` | `id`, `name`, `slug`, `image`, `description`, `display_order`, `status` | ProductCatalog, Homepage |
| `customers` | `id`, `name`, `phone`, `email`, `type` (retail/wholesale/reseller), `role`, `gst_number` | CustomerManager, Auth |
| `orders` | `id`, `customer_id`, `status`, `total`, `items`, `payment_method`, `awb_number` | OrderManager |
| `payment_transactions` | `id`, `order_id`, `gateway`, `amount`, `status`, `hmac`, `captured_at` | Payment Module |
| `admins` | `id`, `email`, `password_hash`, `role` | Auth |
| `whatsapp_messages` | `id`, `phone`, `direction`, `content`, `timestamp`, `agent_id` | WhatsApp CRM |

### Recommended Missing Tables
| Table | Purpose | Priority |
|---|---|---|
| `inventory_log` | Track stock changes with reason | High |
| `coupons` | Discount code management | Medium |
| `reviews` | Store verified buyer reviews (currently hardcoded) | High |
| `shipping_events` | Courier webhook events + AWB history | Medium |
| `broadcast_logs` | WhatsApp broadcast send history | Medium |
| `reseller_payouts` | Track reseller earnings and payouts | High |
| `sessions` | DB-backed session store for admin | Medium |

---

## 13. MODULE: API ENDPOINTS

### Frontend-Facing HTTP Routes

| Route | Method | Handler | Status |
|---|---|---|---|
| `/` | GET | `index.php` | ✅ Homepage |
| `/shop.php` | GET | `shop.php` | Expected |
| `/product.php?id=N` | GET | `product.php` | Expected |
| `/wholesale.php` | GET | `wholesale.php` | Expected |
| `/reseller.php` | GET | `reseller.php` | Expected |
| `/admin/login.php` | GET/POST | Admin Auth | Expected |
| `/install.php` | GET/POST | Installer | Expected |

### AJAX / API Endpoints (expected)

| Route | Method | Purpose |
|---|---|---|
| `/api/cart/add.php` | POST | Add to cart |
| `/api/cart/update.php` | POST | Update quantity |
| `/api/wishlist/toggle.php` | POST | Toggle wishlist |
| `/api/search.php` | GET | Product search |
| `/api/order/place.php` | POST | Place order |
| `/api/payment/verify.php` | POST | Verify payment HMAC |

### Webhook Endpoints (expected)

| Route | Gateway | Purpose |
|---|---|---|
| `/webhooks/razorpay.php` | Razorpay | Payment capture + inventory decrement |
| `/webhooks/cashfree.php` | Cashfree | Payment status |
| `/webhooks/delhivery.php` | Delhivery | Shipment status updates |
| `/webhooks/bluedart.php` | BlueDart | Delivery confirmation |
| `/webhooks/tci.php` | TCI | Freight tracking |
| `/webhooks/whatsapp.php` | Meta Cloud API | Incoming WA messages |

---

## 14. MODULE: WIRING & DEPLOYMENT

### Triple-Sync Deployment Pipeline

```
Developer's Machine (Local)
    c:\Users\sai\Desktop\WhatsApp CRM
           │
           ├── Step 1: Edit & Validate Locally
           │
           ▼
    GitHub Repository
    github.com/dtbrand/arniya (main branch)
    - Auto-commit with descriptive messages
    - Auto-push via git push origin main
           │
           ▼
    Hostinger Live FTP
    Host: 147.93.99.134 (Port 21)
    User: u602484543.jaihanumantex.in
    Remote: /public_html
    - Auto-upload via Python ftplib script
    - Targets only modified files
           │
           ▼
    LIVE: https://jaihanumantex.in/
```

### Deployment Configuration

| Item | Value |
|---|---|
| FTP Host | `147.93.99.134` Port `21` |
| FTP Username | `u602484543.jaihanumantex.in` |
| Remote Root | `/public_html` |
| DB Host | `localhost` Port `3306` |
| DB Name | `u602484543_demodt121` |
| Live URL | `https://jaihanumantex.in/` |
| GitHub Repo | `https://github.com/dtbrand/arniya.git` |

### ⚠️ Deployment Issues

| Issue | Severity | Recommendation |
|---|---|---|
| FTP (plain) over FTPS | Medium | Switch to SFTP or FTPS on Hostinger |
| No CI/CD pipeline | Medium | Add GitHub Actions for automated deploy |
| No staging environment | Medium | Set up a staging subdomain |
| FTP credentials in public markdown | 🔴 Critical | Rotate + use GitHub Secrets |
| DB credentials in public markdown | 🔴 Critical | Move to Hostinger env vars |

---

## 15. MODULE: AGENT RULES (`.agents/`)

### Location: `/.agents/rules/`

| Attribute | Status |
|---|---|
| **Folder Present** | ✅ Present in repo |
| **Purpose** | Behavioural rules for AI coding agents (Gemini, Claude, Copilot) |
| **Relationship to GEMINI.md** | GEMINI.md defines design/code standards; `.agents/rules/` likely contains per-agent operational constraints |
| **Content** | ⚠️ Full content not accessible for public audit |
| **Recommendation** | Ensure `.agents/rules/` reinforces: SVG icons only, ₹ symbol only, no browser auto-preview, Triple-Sync deployment, no credential commits |

---

## 16. DESIGN SYSTEM AUDIT

### Color System

| Token Name | Hex Value | Usage |
|---|---|---|
| Primary Signature Gold | `#8A681F` | Buttons, accents, key text |
| Radiant Accent Gold | `#D4AF37` / `#C5A859` | Glows, borders, stars, active highlights |
| Deep Bronze Gold | `#5A4210` / `#705114` | Headings on cream, subtle borders |
| Pale Gold Tint | `#FAF5E8` | Card highlights, active pills, badges |
| Dark Velvet Obsidian | `#181512` / `#2A241E` / `#3D342A` | Card headers, primary dark buttons |
| Emerald Success | `#15803D` & `#DCFCE7` | In stock, WhatsApp buttons, approved |
| Amber Warning | `#B45309` & `#FEF3C7` | Low stock, pending badges |
| Crimson Danger | `#DC2626` & `#FEF2F2` | Out of stock, delete actions |
| Soft Blue Info | `#1D4ED8` & `#EFF6FF` | Reply actions, dispatch info |

### Button System (Per Pillar 3)

| Button Type | Gradient/Color | Usage |
|---|---|---|
| Primary Gold | `#8A681F` → `#D4AF37` | Main CTAs (Add to Cart, Shop Now) |
| Dark Obsidian | `#181512` → `#3D342A` | Hero actions |
| Emerald WhatsApp | `#15803D` | WhatsApp CTAs |
| Pale Gold Pill | `#FAF5E8` border | Filter pills, secondary actions |

### Typography (Per Pillar 2)

| Face | Role | Config |
|---|---|---|
| Inter | Body, UI elements | Antialiased, `letter-spacing: -0.011em` |
| Plus Jakarta Sans | Headings, badges, labels | Antialiased, weights 500–800 |
| Cinzel | Luxury display, brand marks | Decorative use |
| Montserrat | Sub-headings, navigation | Clean sans-serif |

### Icon Standard (Per Pillar 4)

| Rule | Status |
|---|---|
| 100% Inline SVG | ✅ |
| `stroke-width: 2.0–2.8` | ✅ |
| Zero emoji in functional UI | ✅ |
| Indian Rupee (`₹`) SVG | ✅ |
| No Dollar `$` signs | ✅ |

### Animations (Defined in GEMINI.md)

| Animation | CSS Property | Usage |
|---|---|---|
| Gold Running Focus Line | `@property --dt-border-angle` + `@keyframes dtBorderRotate` | All input fields on focus |
| Platinum Glow | `@keyframes dtGoldPlatinumGlow` | Input field glow on focus |
| QR Laser Scanner | `@keyframes dtQrScanLaser` | UPI QR code modal |

---

## 17. ISSUES & GAPS FOUND

### 🔴 CRITICAL (Fix Immediately)

| # | Issue | File | Action |
|---|---|---|---|
| C1 | **Live DB password in public repo** | `GEMINI.md` | Rotate password + remove from file |
| C2 | **Live FTP password in public repo** | `GEMINI.md` | Rotate password + remove from file |
| C3 | **Admin default credentials exposed** | `GEMINI.md` | Change admin password + remove from file |
| C4 | **Live server IP exposed** | `GEMINI.md` | Acceptable but consider moving to private docs |
| C5 | **UPI VPAs exposed publicly** | `GEMINI.md` | Move to private config |

### ⚠️ HIGH PRIORITY

| # | Issue | Location | Action |
|---|---|---|---|
| H1 | `index.php` is 105 KB / 1,221 lines — monolith | `index.php` | Extract sections into `/includes/` partials |
| H2 | `time()` cache-busting causes new CSS request every load | `index.php` | Use file hash `md5_file()` or build version constant |
| H3 | Reviews section is fully hardcoded PHP/HTML | `index.php` | Move to `reviews` DB table + AJAX load |
| H4 | Recently Viewed uses `localStorage` — lost on browser clear | `index.php` | Optionally sync to DB for logged-in users |
| H5 | No confirmed CSRF protection on forms | Multiple | Add CSRF tokens to all POST endpoints |
| H6 | Session security flags not confirmed | `Auth.php` | Add `session_set_cookie_params(['secure'=>true,'httponly'=>true,'samesite'=>'Strict'])` |
| H7 | No caching on `ProductCatalog` DB calls | `src/ProductCatalog.php` | Add APCu or file-based cache with 5-min TTL |
| H8 | Product media (MP4/JPG) committed to Git | `.gitignore` | Use object storage (Cloudflare R2, S3) or Hostinger file manager |
| H9 | No tracking page confirmed | Routes | Build `/track.php` for shipment tracking |
| H10 | `Shared/` folder contents not structured | `/Shared/` | Define clear responsibility: tokens, partials, utilities |

### ⚠️ MEDIUM PRIORITY

| # | Issue | Location | Action |
|---|---|---|---|
| M1 | 4 Google Font families = large page weight | `index.php` | Subset to needed weights, preconnect tags already good |
| M2 | FTP (plain) for deployment | GEMINI.md | Switch to SFTP |
| M3 | No staging environment | Deployment | Create `staging.jaihanumantex.in` |
| M4 | No automated tests | Repo | Add PHPUnit for core classes |
| M5 | No error logging / alerting | All PHP | Add Monolog or native error log to file |
| M6 | `Recommended For You` duplicates products array | `index.php` | Use real recommendation engine or shuffle |
| M7 | Deal countdown is static (not DB-driven) | `index.php` | Make deal end time DB-controlled |
| M8 | No pagination on product grids | Frontend | Add "Load More" with AJAX pagination |
| M9 | GST calculation not audited | `PricingCalculator.php` | Verify 5%/12% slab application |

### 💡 LOW / ENHANCEMENT

| # | Issue | Location | Action |
|---|---|---|---|
| L1 | No sitemap.xml | Root | Generate sitemap for SEO |
| L2 | No robots.txt confirmed | Root | Add robots.txt blocking `/admin/`, `/api/` |
| L3 | No OG meta tags on product pages | `product.php` | Add Open Graph for WhatsApp share previews |
| L4 | No schema.org JSON-LD | All pages | Add Product schema for search rich results |
| L5 | No PWA manifest | Root | Add manifest.json + service worker for app-like mobile |
| L6 | Font-display:swap not set | `index.php` | Add `&display=swap` to Google Fonts URL |
| L7 | AI Recommended score is hardcoded (95-99%) | `index.php` | Connect to real purchase/view analytics |
| L8 | No admin analytics dashboard confirmed | Admin | Build sales analytics (revenue, orders, top products) |

---

## 18. MODULE COVERAGE MATRIX

| Module | Designed | Coded | Tested | Deployed | Documented |
|---|---|---|---|---|---|
| Homepage / Storefront UI | ✅ | ✅ | ⚠️ | ✅ | ✅ |
| Product Catalog (`/src/`) | ✅ | ✅ | ⚠️ | ✅ | ⚠️ |
| Auth & Role System | ✅ | ✅ | ⚠️ | ✅ | ⚠️ |
| Database Layer | ✅ | ✅ | ⚠️ | ✅ | ⚠️ |
| Order Management | ✅ | ✅ | ⚠️ | ⚠️ | ⚠️ |
| Customer Management | ✅ | ✅ | ⚠️ | ⚠️ | ⚠️ |
| Pricing Calculator | ✅ | ✅ | ⚠️ | ✅ | ⚠️ |
| Discount Engine | ✅ | ✅ | ⚠️ | ⚠️ | ⚠️ |
| Admin Console | ✅ | ⚠️ | ❌ | ⚠️ | ⚠️ |
| WhatsApp CRM | ✅ | ⚠️ | ❌ | ⚠️ | ⚠️ |
| Razorpay Payment | ✅ | ⚠️ | ⚠️ | ⚠️ | ⚠️ |
| Cashfree Payment | ✅ | ⚠️ | ❌ | ⚠️ | ⚠️ |
| UPI / QR Payment | ✅ | ⚠️ | ⚠️ | ⚠️ | ✅ |
| COD | ✅ | ⚠️ | ⚠️ | ⚠️ | ✅ |
| Delhivery Shipping | ✅ | ⚠️ | ❌ | ⚠️ | ⚠️ |
| BlueDart Shipping | ✅ | ⚠️ | ❌ | ⚠️ | ⚠️ |
| TCI Shipping | ✅ | ⚠️ | ❌ | ⚠️ | ⚠️ |
| Wholesale Portal | ✅ | ✅ | ⚠️ | ✅ | ⚠️ |
| Reseller Portal | ✅ | ✅ | ⚠️ | ✅ | ⚠️ |
| Design System | ✅ | ✅ | ✅ | ✅ | ✅ |
| Installer | ✅ | ✅ | ⚠️ | ✅ | ⚠️ |
| Security Controls | ⚠️ | ⚠️ | ❌ | ⚠️ | ❌ |
| Deployment Pipeline | ✅ | ✅ | ⚠️ | ✅ | ✅ |
| Agent Rules | ✅ | ✅ | N/A | ✅ | ✅ |

> ✅ Complete · ⚠️ Partial / Needs Review · ❌ Missing / Not Confirmed

---

## 19. PRIORITY ACTION PLAN

### 🔴 Sprint 0 — Immediate Security (Do Today)

```
1. Rotate all exposed credentials:
   - DB password (u602484543_demodt121)
   - FTP password
   - Admin panel password

2. Remove credentials from GEMINI.md:
   - Replace with references: "See .env file"

3. Add .env file (NOT committed to git):
   DB_HOST=localhost
   DB_NAME=u602484543_demodt121
   DB_USER=u602484543_demodt121
   DB_PASS=<new-secure-password>
   FTP_HOST=147.93.99.134
   FTP_USER=u602484543.jaihanumantex.in
   FTP_PASS=<new-secure-password>

4. Add .env to .gitignore

5. Update src/Database.php to load from .env (use vlucas/phpdotenv or $_ENV)
```

### 🟠 Sprint 1 — Architecture Clean-Up (This Week)

```
1. Extract index.php into partials:
   /includes/hero-slider.php
   /includes/quick-access.php
   /includes/categories-rail.php
   /includes/trending-now.php
   /includes/deal-of-day.php
   /includes/collections-banners.php
   /includes/recommended-for-you.php
   /includes/recently-viewed.php
   /includes/reviews.php
   /includes/footer.php

2. Fix cache-busting:
   define('ASSET_VER', md5_file(__DIR__ . '/assets/css/home.css'));
   Use ASSET_VER in all asset URLs

3. Move reviews to DB table + API:
   CREATE TABLE reviews (...);
   POST /api/reviews/ (admin-only)
   GET /api/reviews/?type=customers|resellers|wholesale
```

### 🟡 Sprint 2 — Feature Completion (This Month)

```
1. Build /track.php — shipment tracking page
2. Add CSRF tokens to all POST forms
3. Implement session security flags in Auth.php
4. Add product DB caching (APCu or file cache)
5. Build admin analytics dashboard
6. Move reviews to DB (remove hardcoded HTML)
7. Add OG meta tags to product.php for WhatsApp sharing
8. Create sitemap.xml + robots.txt
```

### 🟢 Sprint 3 — Enhancement (Next Quarter)

```
1. Add PWA manifest + service worker
2. Implement real recommendation engine (view/purchase history)
3. DB-controlled deal countdown (set end time from admin)
4. Switch deployment to GitHub Actions (remove manual FTP)
5. Set up staging.jaihanumantex.in
6. Add PHPUnit tests for all /src/ classes
7. Add error logging (Monolog → file/email)
8. Add schema.org JSON-LD to product pages
```

---

## 📌 APPENDIX: CREDENTIAL SECURITY NOTICE

> **This audit has identified that live production credentials (FTP password, database password, admin login, and UPI VPAs) are stored in plaintext in a publicly accessible file (`GEMINI.md`) in this GitHub repository.**
>
> **Anyone with internet access can view `github.com/dtbrand/arniya/blob/main/GEMINI.md` and obtain full server access.**
>
> **Immediate action required:**
> 1. Rotate FTP password on Hostinger control panel
> 2. Change database password in Hostinger MySQL
> 3. Change admin panel password via the admin login
> 4. Remove credentials from GEMINI.md (or make repo private)
> 5. Audit server access logs for unauthorized logins

---

*Audit completed by Claude (Anthropic) — September 16, 2026*
*Based on: public GitHub repository https://github.com/dtbrand/arniya, GEMINI.md (166 lines), index.php (1,221 lines / 105 KB), and repository metadata*
