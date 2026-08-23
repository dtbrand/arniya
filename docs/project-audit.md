# DT Brand's & Jai Hanuman Tex — Comprehensive Engineering System Audit

**Document Version:** 1.0.0  
**Generated Date:** 2026-08-23  
**Target Platform:** PHP 8.2+ / Apache / MySQL (u602484543_arniya)  
**Deployment Infrastructure:** Hostinger Live Production (FTP / HTTP 200) + GitHub Action CI/CD

---

## 1. Executive System Overview

DT Brand's & Jai Hanuman Tex is an enterprise-grade luxury ethnic textile, wholesale, reseller, and retail commerce platform. It integrates a direct-to-consumer digital storefront with a comprehensive B2B partner distribution ecosystem and a real-time WhatsApp CRM control center.

---

## 2. Directory Tree & Architecture Topology

```text
c:\Users\sai\Desktop\WhatsApp CRM
├── .github/                       # CI/CD Workflows, Dependabot, Issue & PR Templates
├── .editorconfig                  # Code formatting standardization
├── .gitignore                     # Security & secret exclusion rules
├── .htaccess                      # Apache rewrite rules, Gzip compression & browser caching
├── AGENTS.md                      # Master Autonomous AI Multi-Agent Directives & Quality Standard
├── composer.json                  # PHP dependency management, scripts & PSR-4 autoloading
├── package.json                   # JS/CSS developer tooling (ESLint, Prettier, Stylelint, Playwright)
├── phpstan.neon                   # PHPStan static analysis configuration (Level 1)
├── phpunit.xml                    # PHPUnit automated test suite runner
├── database/                      # Database migrations, schema definitions, and migration runner
├── docs/                          # Architecture, APIs (OpenAPI), disaster recovery, audits
├── Frontend/                      # Frontend Application Modules
│   ├── Admin/                     # Module 1–8 Enterprise Admin Suite & CRM Console
│   │   ├── catalogue/             # Saree collections & seasonal lookbooks
│   │   ├── customers/             # Customer profiles, segments, ledger & VIP tiers
│   │   ├── dashboard/             # 12-Card KPI ribbon, sales charts & activity feeds
│   │   ├── orders/                # Multi-channel orders, dispatches & invoice studio
│   │   ├── pricing/               # MRP, wholesale, reseller & retail pricing matrices
│   │   ├── products/              # Product catalog, attributes, categories & variants
│   │   ├── resellers/             # Reseller partners, digital passes & commission ledgers
│   │   ├── retail/                # Retail management suite, shopping bags & abandoned carts
│   │   ├── reviews/               # Verified buyer reviews & rating analytics
│   │   ├── system/                # Diagnostics, database optimization, logs & backups
│   │   ├── whatsapp/              # WhatsApp CRM broadcasts, templates & order notices
│   │   └── wholesale/             # B2B wholesale buyers, lot pricing & credit vouchers
│   ├── Home/                      # Luxury ethnic flagship landing page
│   ├── Reseller/                  # Reseller portal, smart share & catalogue generator
│   ├── Retailer/                  # Retailer buyer catalog & order booking
│   ├── Shop/                      # Full product showcase, multi-facet filtering & search
│   ├── Single-Product/            # High-conversion single product page & WhatsApp enquiry
│   └── Wholesale/                 # B2B wholesale portal with volume tiering
├── Shared/                        # Shared Core Business Logic & Partials
│   ├── Asset/                     # Shared branding assets, icons & media
│   ├── Auth/                      # Account authentication, customer sign-in & sessions
│   └── Includes/                  # Cart, checkout, quickview, smartshare & wishlist engines
├── src/                           # Modern PSR-4 Encapsulated PHP Engines
│   ├── PricingCalculator.php      # MRP, wholesale, GST, and net total computation
│   └── DiscountEngine.php         # Coupon, promo code, and tiered discount validation
├── tests/                         # Unit, Integration & E2E Automated Test Suites
│   ├── Unit/                      # PHPUnit unit test cases
│   └── e2e/                       # Playwright browser flows & axe-core accessibility
└── scripts/                       # Deployment, backup, health check & log rotation utilities
```

---

## 3. Database Architecture & Diagnostics

- **Database Name:** `u602484543_arniya` (MySQL / MariaDB)
- **Table Structure:**
  - `products`: Product master (SKU, title, fabric, MRP, cost, stock, status)
  - `categories`: Hierarchical categories (Sarees, Silk, Cotton, Festive, Bridal)
  - `customers`: Customer accounts (B2C retail, wholesale accounts, verified resellers)
  - `orders`: Order headers (customer_id, channel, subtotal, discount, gst, total, status)
  - `order_items`: Line items (order_id, product_id, sku, qty, price, total)
  - `wholesale_accounts`: B2B wholesale credit limits, GST numbers, tier levels
  - `reseller_profiles`: Reseller commission rates, margin sharing, payout ledgers
  - `coupons`: Promotional discount codes, validity, max caps, usage limits
  - `activity_logs`: User and system audit trail

---

## 4. API & Integration Endpoints

- **Admin Diagnostic Endpoints:**
  - `GET /Frontend/Admin/system/database.php`: MySQL latency & table health
  - `GET /Frontend/Admin/system/backups.php`: Snapshot status & backup integrity
  - `GET /health.php`: JSON health endpoint returning system status
- **E-Commerce Real-Time Routers:**
  - `/Shared/Includes/cart.php`: Add, update, remove items, calculate totals
  - `/Shared/Includes/checkout.php`: Multi-step checkout, address binding & order dispatch
  - `/Shared/Includes/smartshare.php`: 1-Click WhatsApp catalog link generation
  - `/Shared/Includes/quickview.php`: Instant product preview modal

---

## 5. Security & Compliance Architecture

- **Session Handling:** `session_start()` with cookie parameters on authenticated routes.
- **Data Protection:** No plaintext passwords or API keys stored in source code.
- **Input Sanitization:** Parameter binding and type casting across controllers.
- **Least Privilege:** GitHub Actions restricted to `contents: read` by default.

---

## 6. Verification Status

| Audit Item        | Finding                                           | Status   |
| ----------------- | ------------------------------------------------- | -------- |
| Repository Tree   | 100% indexed, verified & documented               | **PASS** |
| PHP Architecture  | PHP 8.2 native, PSR-4 autoloading ready           | **PASS** |
| Frontend Assets   | Vanilla CSS + Vanilla JS, Zero heavy dependencies | **PASS** |
| Production Server | Hostinger Live Server (147.93.99.134) deployed    | **PASS** |
