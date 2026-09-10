# DT Brand / Arniya — NEXT-LEVEL COMPLETE AUDIT + FIX + PRODUCTION-READY MASTER SPECIFICATION
## Version: V2 — Admin Complete + UI Complete + API/DB Complete + Security + QA + Deployment

**Repository:** https://github.com/dtbrand/arniya  
**Project:** DT Brand / Arniya PHP + MySQL eCommerce  
**Execution mode:** Multi-agent coding workflow  
**Goal:** Audit the ENTIRE repository, identify every missing/incomplete/broken option, implement required fixes, and deliver a production-ready system without breaking existing business rules.

---

# 0. NON-NEGOTIABLE EXECUTION RULE

This document is the master implementation contract.

Agents MUST:

1. Inspect the real repository before changing code.
2. Audit every relevant PHP, JS, CSS, SQL, config, API, admin, frontend, test and deployment file.
3. Never assume that an option exists merely because a menu/link exists.
4. Never create a UI-only option without a working backend/API/database mapping.
5. Never create a backend-only feature with no usable admin/frontend path when the feature requires UI.
6. Never silently change business pricing, roles, product types, MOQ/MCQ or checkout rules.
7. Preserve existing working functionality.
8. Fix security issues before production deployment.
9. Add migrations for schema changes.
10. Add tests for every critical business rule.
11. Produce an audit report listing:
   - existing
   - missing
   - incomplete
   - duplicated
   - broken
   - insecure
   - deprecated
   - recommended
12. Do not mark the project complete until the Definition of Done in this document passes.

---

# 1. ABSOLUTE BUSINESS RULES

## 1.1 Roles

Exactly these customer-facing roles:

1. Guest
2. Customer
3. Retailer
4. Reseller
5. Wholesaler

Do NOT invent additional customer roles.

Admin/staff permissions are separate from customer roles.

---

# 2. PRODUCT TYPES

Exactly:

1. SINGLE PIECE
2. FULL SET

Do not introduce another purchasing type unless explicitly approved.

---

# 3. SINGLE PIECE RULE

For a Single Piece product:

- Customer selects ONE available Color.
- Customer selects ONE available Size.
- One Color + one Size = one variant/piece.
- Normal quantity is allowed according to existing stock/MOQ rules.

Example:

Colors:
- Red
- Mehrun
- Rama

Sizes:
- S
- M
- L
- XL

Examples:
- Red + S = 1 piece
- Red + M = 1 piece
- Rama + XL = 1 piece

Guest, Customer, Retailer and Reseller can purchase Single Piece.

Wholesaler does NOT purchase a single selected variant as a normal 1-piece purchase.

---

# 4. WHOLESALER MCQ RULE

Wholesaler Single Piece purchase uses MCQ:

**MCQ = AVAILABLE COLOUR COUNT × AVAILABLE SIZE COUNT**

Example:

3 available colors × 4 available sizes = 12 pieces.

Required combinations:

- Red-S
- Red-M
- Red-L
- Red-XL
- Mehrun-S
- Mehrun-M
- Mehrun-L
- Mehrun-XL
- Rama-S
- Rama-M
- Rama-L
- Rama-XL

IMPORTANT:

MCQ MUST be calculated server-side from actual sellable/available variants.

Do not count:

- disabled variants
- deleted variants
- unavailable variants
- variants outside the active/sellable state

unless the current database/business implementation explicitly defines that state as sellable.

Never trust:

- client-side MCQ
- hidden input MCQ
- JavaScript-calculated quantity
- request total
- request price

The API/backend must recalculate.

---

# 5. FULL SET RULE

Full Set purchasing is available ONLY to:

- Retailer
- Wholesaler

Not available to:

- Guest
- Customer
- Reseller

The exact Full Set quantity/MCQ behavior is not to be invented.

Agents MUST:

1. Audit the existing Full Set implementation.
2. Preserve the existing approved logic.
3. Identify missing logic.
4. Document ambiguity.
5. Do not introduce a new business formula without approval.

---

# 6. FIXED PRICE FIELDS

## 6.1 SINGLE PIECE

Required fields:

- Price — Reseller
- Sale Price — Reseller
- Price — Retailer
- Sale Price — Retailer
- Price — Wholesaler
- Sale Price — Wholesaler
- Customer Price — Guest + Customer
- Customer Sale Price — Guest + Customer

## 6.2 FULL SET

Required fields:

- Price — Retailer
- Sale Price — Retailer
- Price — Wholesaler
- Sale Price — Wholesaler

DO NOT add:

- Full Set Customer Price
- Full Set Customer Sale Price
- Full Set Reseller Price
- Full Set Reseller Sale Price

DO NOT add extra customer-facing price tiers.

---

# 7. MASTER PRICE MATRIX

| User | Single Piece Price | Single Piece Sale Price | Full Set Price | Full Set Sale Price |
|---|---|---|---|---|
| Guest | Customer Price | Customer Sale Price | Not available | Not available |
| Customer | Customer Price | Customer Sale Price | Not available | Not available |
| Retailer | Retailer Price | Retailer Sale Price | Retailer Price | Retailer Sale Price |
| Reseller | Reseller Price | Reseller Sale Price | Not available | Not available |
| Wholesaler | Wholesale Price | Wholesale Sale Price | Wholesale Price | Wholesale Sale Price |

This matrix is authoritative.

---

# 8. PRICE DISPLAY RULE

Every price shown anywhere must come from the same authoritative price engine.

Audit and fix:

- Home
- Homepage sections
- Category
- Collection
- Search
- Filters
- Product cards
- Product detail
- Related products
- Similar products
- Wishlist
- Cart
- Checkout
- Order summary
- Payment summary
- Confirmation
- My Orders
- Invoice
- Admin preview
- Product sharing
- WhatsApp sharing where price is shown
- API responses
- JSON endpoints
- structured data where applicable

Never calculate final price independently in multiple places.

---

# 9. PRICE SECURITY

Never trust client supplied:

- price
- sale price
- MRP
- subtotal
- discount
- total
- role
- channel
- MCQ
- stock
- product title

The server must retrieve authoritative values.

Every checkout/order must recalculate:

1. role
2. channel
3. product
4. variant
5. product type
6. price
7. sale price
8. quantity/MCQ
9. discount
10. shipping
11. tax if applicable
12. final total
13. stock

---

# 10. REPOSITORY-WIDE AUDIT

Audit:

```text
/
├── .agents/
├── .github/
├── Shared/
├── admin/
├── api/
├── assets/
├── config/
├── database/
├── docs/
├── includes/
├── public/
├── scripts/
├── src/
├── storage/
├── tests/
├── *.php
├── .htaccess
├── composer.json
├── package.json
├── README.md
├── SECURITY.md
└── deployment/configuration files
```

Do not limit the audit to visible frontend pages.

---

# 11. ADMIN MASTER REQUIREMENT

The admin panel must be treated as a complete operational application, not a collection of links.

Every admin module must have:

- working route
- permission check
- page/view
- API/controller where required
- database mapping
- validation
- CSRF protection
- audit logging
- search
- filters
- sorting
- pagination
- loading state
- empty state
- error state
- permission denied state
- responsive/mobile UI
- confirmation dialogs for destructive actions
- success/error feedback
- safe bulk actions where appropriate

If a menu option has no working implementation, it must either be implemented or removed from navigation.

---

# 12. COMPLETE ADMIN NAVIGATION

Implement/audit the following structure.

## 12.1 Dashboard

Required:

- Today sales
- Revenue
- Orders
- Pending orders
- Processing orders
- Shipped orders
- Delivered orders
- Cancelled orders
- Low stock
- Out of stock
- Customers
- Retailers
- Resellers
- Wholesalers
- Returns/refunds if supported
- Failed payments
- Failed webhooks
- System health
- Recent orders
- Recent customers
- Recent activity
- Top products
- Top categories
- Sales trend
- Order trend
- Stock alerts
- Quick actions

Filters:

- Today
- Yesterday
- 7 days
- 30 days
- Custom date range

All dashboard figures must be permission-aware.

---

# 13. ADMIN GLOBAL UI

Required admin shell:

- Responsive sidebar
- Collapsible sidebar
- Top navigation
- Breadcrumbs
- Page title
- Global search
- Notifications
- Admin profile
- Logout
- Quick actions
- Command/search palette if architecture supports it
- Mobile navigation
- Keyboard accessibility
- Focus states
- Accessible labels
- Confirmation modal
- Toast notification
- Drawer
- Tabs
- Data table
- Filter drawer
- Pagination
- Skeleton loading
- Empty state
- Error state

Do not create a visually attractive UI that is functionally disconnected from backend logic.

---

# 14. ADMIN CATALOG MODULE

Required navigation:

```text
Catalog
├── Products
├── Add Product
├── Categories
├── Subcategories
├── Brands
├── Attributes
├── Colors
├── Sizes
├── Variants
├── Media Library
├── Reviews
├── Featured Products
├── Best Sellers
├── New Arrivals
├── Product Status
├── Bulk Import
├── Export
├── Import Templates
├── SKU Tools
└── Product Audit
```

---

# 15. ADMIN PRODUCT LIST

Required:

- Search
- SKU search
- Title search
- Category filter
- Brand filter
- Product type filter
- Status filter
- Stock filter
- Featured filter
- Bestseller filter
- New arrival filter
- Price range
- Date range
- Sort
- Pagination
- Column chooser if supported
- Bulk selection

Bulk actions:

- Activate
- Draft
- Archive
- Restore
- Delete where safe
- Feature
- Unfeature
- Bestseller
- Remove bestseller
- New arrival
- Remove new arrival
- Adjust stock
- Export

All bulk operations must be permission protected and audited.

---

# 16. ADMIN ADD PRODUCT STUDIO

Sections:

1. Basic information
2. Product type
3. Category
4. Subcategory
5. Brand
6. Description
7. Fabric/material
8. Product attributes
9. Colors
10. Sizes
11. Variants
12. Inventory
13. Pricing
14. Full Set pricing
15. Media
16. SEO
17. Shipping
18. Status
19. Publishing
20. Audit/activity

---

# 17. ADMIN PRODUCT TYPE UI

When:

### SINGLE PIECE

Show:

- Single Piece pricing
- Customer pricing
- Reseller pricing
- Retailer pricing
- Wholesaler pricing
- Colors
- Sizes
- Variants
- Variant stock
- Wholesaler MCQ preview

### FULL SET

Show:

- Retailer pricing
- Wholesaler pricing
- Full Set sale prices
- Existing approved Full Set configuration

Hide invalid price fields.

The UI must NOT show fields forbidden by the fixed matrix.

---

# 18. ADMIN PRICE MATRIX UI

Create a dedicated reusable price matrix component.

Example:

```text
SINGLE PIECE

Guest / Customer
Customer Price
Customer Sale Price

Reseller
Price
Sale Price

Retailer
Price
Sale Price

Wholesaler
Price
Sale Price


FULL SET

Retailer
Price
Sale Price

Wholesaler
Price
Sale Price
```

Required features:

- Clear labels
- Currency formatting
- Decimal validation
- Empty/null handling
- Server validation
- Dirty-state warning
- Save validation
- Price preview
- Role preview
- Price history
- Last updated
- Updated by
- Audit log

Do not introduce additional price columns.

---

# 19. ADMIN ROLE PREVIEW

Provide a safe read-only preview:

```text
Preview as:
[ Guest ]
[ Customer ]
[ Retailer ]
[ Reseller ]
[ Wholesaler ]
```

Preview must:

- never change actual user role
- never grant permission
- never alter cart
- never create orders
- only render role-specific product/price behavior

Use it to verify:

- visible price
- sale price
- product type availability
- variant availability
- MCQ
- Full Set visibility

---

# 20. VARIANT ADMIN

Required:

- Variant list
- Color
- Size
- SKU
- Stock
- Price fields as permitted by architecture
- Image
- Status
- Variant creation
- Edit
- Disable
- Restore
- Bulk status
- Bulk stock
- Variant audit

Unique variant constraints must be enforced server-side.

---

# 21. MCQ ADMIN TOOL

For Single Piece products:

Show:

```text
Available Colors: X
Available Sizes: Y
Wholesaler MCQ: X × Y = Z
```

Also display the actual generated combinations.

Example:

```text
Red-S
Red-M
Red-L
Red-XL
...
```

This is read-only calculation based on sellable variants.

---

# 22. INVENTORY ADMIN

Required:

```text
Inventory
├── Stock Overview
├── Variant Stock
├── Low Stock
├── Out of Stock
├── Stock Adjustments
├── Stock Movements
├── Inventory Ledger
├── Bulk Stock Update
├── Import
├── Export
└── Stock Audit
```

Required data:

- Product
- Variant
- Previous quantity
- Adjustment
- New quantity
- Reason
- Admin
- Timestamp
- Reference/order if applicable

Never silently overwrite stock.

Prefer ledger-style tracking for adjustments.

---

# 23. ORDERS ADMIN

Required:

```text
Orders
├── All Orders
├── Pending
├── Processing
├── Paid
├── Shipped
├── Delivered
├── Cancelled
├── Returned
├── Refunded
├── Order Detail
├── Payments
├── Shipping
├── Invoices
└── Order Export
```

Audit status transitions.

Do not allow invalid state transitions.

Order detail should include:

- Customer
- Role
- Order number
- Items
- Variants
- Quantity
- MCQ
- Price
- Discount
- Shipping
- Tax if applicable
- Total
- Payment status
- Shipping status
- Tracking
- Notes
- Timeline
- Audit log

---

# 24. ORDER ADMIN ACTIONS

Permission-controlled actions:

- View
- Edit allowed metadata
- Change status
- Mark payment status where approved
- Add note
- Generate invoice
- Generate packing slip
- Add tracking
- Cancel
- Return/refund where supported
- Export

Never permit changing historical financial values without an explicit audited correction workflow.

---

# 25. CUSTOMER MANAGEMENT

Required:

```text
Customers
├── All Customers
├── Customer Details
├── Retailers
├── Resellers
├── Wholesalers
├── Addresses
├── Order History
├── Account Status
├── Verification/Approval if existing
└── Customer Audit
```

Do not automatically introduce a new approval policy if the business rules do not define one.

Any role assignment must be:

- permission protected
- audited
- validated
- impossible for unauthorized admins

---

# 26. COUPONS / DISCOUNTS

Audit/create:

```text
Marketing
├── Coupons
├── Discount Rules
├── Coupon Usage
├── Expired Coupons
└── Coupon Audit
```

Validate:

- code
- status
- start date
- end date
- usage limit
- per-user limit
- applicable products
- applicable categories
- role/channel restrictions if already supported

Never trust discount totals from browser.

---

# 27. SHIPPING ADMIN

Required where supported:

```text
Shipping
├── Zones
├── States
├── Cities
├── Pincodes
├── Rates
├── Carrier Configuration
├── Shipments
├── Tracking
├── Labels
├── Exceptions
└── Shipping Audit
```

Audit existing shipping business rules before changing them.

Never expose provider secrets in admin UI.

Show:

- configured/not configured
- connection status
- last successful call
- last error
- safe test action

---

# 28. PAYMENT ADMIN

Required:

```text
Payments
├── Transactions
├── Payment Details
├── Failed Payments
├── Razorpay
├── Reconciliation
├── Refunds if supported
├── Webhook Events
└── Payment Audit
```

Webhook processing must be:

- authenticated
- verified
- idempotent
- transaction-safe
- replay-safe
- logged

Do not decrement stock twice on webhook replay.

Use unique event IDs where supported.

---

# 29. MARKETING / CONTENT ADMIN

Audit and implement where architecture supports:

```text
Marketing
├── Banners
├── Sliders
├── Homepage Sections
├── Collections
├── Featured Products
├── Best Sellers
├── New Arrivals
├── Announcements
├── SEO
├── Share Templates
└── Social Links
```

Every content option must map to:

UI → backend → database/storage → frontend rendering.

---

# 30. REVIEWS ADMIN

Required:

- Review list
- Product filter
- Rating filter
- Status
- Search
- View
- Approve if moderation exists
- Reject/hide
- Delete where appropriate
- Audit trail

Prevent unauthorized modification of review ownership.

---

# 31. NOTIFICATION ADMIN

Audit:

```text
Notifications
├── Templates
├── Email
├── SMS
├── WhatsApp
├── In-App
├── Delivery Logs
├── Failed Messages
├── Retry
└── Provider Status
```

Secrets must never be displayed.

Templates should support safe variable substitution.

---

# 32. INTEGRATIONS ADMIN

Existing/possible integrations must be audited:

- Razorpay
- Delhivery
- BlueDart
- TCI
- WhatsApp
- Email provider
- SMS provider

Required UI:

- Integration status
- Enable/disable where supported
- Configuration status
- Test connection
- Last request
- Last error
- Webhook status
- Safe diagnostics

NEVER display:

- API secrets
- passwords
- tokens
- private keys

Mask secrets.

---

# 33. REPORTS / ANALYTICS

Required reports:

- Sales
- Orders
- Revenue
- Products
- Categories
- Inventory
- Customers
- Role distribution
- Retailer sales
- Reseller sales
- Wholesaler sales
- Payments
- Shipping
- Coupons
- Returns/refunds if supported

Export:

- CSV
- Excel where existing stack supports it
- PDF where appropriate

Exports must be permission-controlled.

---

# 34. ADMIN USERS / ROLES / PERMISSIONS

Separate admin permissions from customer roles.

Required:

```text
Admin Security
├── Admin Users
├── Admin Roles
├── Permissions
├── Sessions
├── Login Audit
└── Security Events
```

Permission actions should support, where applicable:

- view
- create
- edit
- delete
- archive
- restore
- import
- export
- approve
- publish
- adjust_stock
- refund
- manage_users
- manage_settings
- manage_integrations
- view_logs

Do not grant every permission by default.

Super-admin behavior must be explicit.

---

# 35. AUDIT LOG ADMIN

Required:

- Login
- Logout
- Failed login
- Product create/edit/delete
- Price changes
- Stock changes
- Order status changes
- Payment actions
- Role changes
- Admin permission changes
- Settings changes
- Integration changes
- Bulk actions
- Imports/exports
- Security events

Log:

- actor
- action
- entity
- entity ID
- before state where safe
- after state where safe
- IP where policy permits
- timestamp
- request correlation ID

Do not log passwords, tokens or secrets.

---

# 36. SYSTEM ADMIN

Required/audit:

```text
System
├── General Settings
├── Environment Status
├── Database Status
├── Migration Status
├── Cache
├── Storage
├── Logs
├── Cron/Jobs
├── Health
├── Maintenance Mode
├── Feature Flags
└── Backup/Restore if implemented
```

Dangerous operations must require:

- explicit permission
- confirmation
- CSRF protection
- audit log
- preferably re-authentication

---

# 37. DEVELOPER / API ADMIN

Useful production admin tools:

```text
Developer
├── API Registry
├── API Health
├── Webhook Events
├── Queue/Jobs
├── Migration Status
├── Route Map
└── System Diagnostics
```

Diagnostics must not expose secrets.

---

# 38. ADMIN ROUTE COMPLETENESS AUDIT

For every navigation item:

```text
MENU
 ↓
ROUTE
 ↓
CONTROLLER/PHP
 ↓
PERMISSION
 ↓
CSRF
 ↓
VALIDATION
 ↓
API
 ↓
DATABASE
 ↓
AUDIT LOG
 ↓
UI RESPONSE
```

If any link is orphaned, broken or fake, fix it.

---

# 39. ADMIN UI COMPONENT LIBRARY

Create/reuse components:

- DataTable
- SearchBox
- FilterBar
- FilterDrawer
- Pagination
- Modal
- ConfirmationDialog
- Drawer
- Tabs
- FormSection
- PriceMatrix
- VariantGrid
- MediaUploader
- StatusBadge
- AuditTimeline
- ActivityFeed
- Toast
- ErrorPanel
- EmptyState
- LoadingSkeleton
- APIResponseViewer
- JSONViewer
- DateRangePicker
- BulkActionBar

Avoid duplicate implementations of the same component.

---

# 40. DATABASE AUDIT

Map every UI field to a real persisted location.

For every feature document:

```text
UI field
→ request parameter
→ validation
→ service/domain logic
→ SQL
→ DB column/table
→ response
→ UI rendering
```

If a required field has no DB representation:

- create migration
- add indexes
- add foreign keys where appropriate
- add constraints
- update model/service
- update API
- update UI
- add tests

---

# 41. DATABASE INTEGRITY

Audit:

- Primary keys
- Foreign keys
- Unique constraints
- NOT NULL rules
- ENUM usage
- Indexes
- Duplicate records
- orphan records
- cascade behavior
- transaction boundaries
- decimal precision
- timestamp consistency

Never destroy historical order data accidentally.

---

# 42. MONEY STORAGE

Do not use PHP floating point arithmetic as the authoritative financial calculation.

Prefer:

- DECIMAL in MySQL with sufficient precision, or
- integer minor units where architecture supports it.

Audit:

- product prices
- sale prices
- discounts
- shipping
- tax
- order totals
- payment totals
- refund values

Round consistently.

---

# 43. PRICE HISTORY

Recommended production feature:

```text
Price History
- product
- product type
- role
- old value
- new value
- changed by
- changed at
- reason
```

Do not expose sensitive internal audit data to customers.

---

# 44. CART AUDIT

Audit:

- product ID
- variant ID
- product type
- quantity
- role
- price
- stock
- MCQ
- stale product
- disabled variant
- price changes

At checkout, recalculate everything.

Cart should never become the authoritative financial source.

---

# 45. WISHLIST AUDIT

Audit:

- authentication
- user ownership
- product existence
- disabled/deleted product behavior
- variant behavior
- price rendering
- CSRF
- IDOR protection

A user must never access another user's wishlist by changing an ID.

---

# 46. CHECKOUT AUDIT

Required flow:

```text
Cart
→ Login/Guest eligibility
→ Address
→ Product validation
→ Variant validation
→ Role validation
→ Product type validation
→ Price recalculation
→ Discount validation
→ Shipping calculation
→ Total calculation
→ Order creation
→ Payment
→ Payment verification
→ Stock transaction
→ Confirmation
```

Do not trust browser totals.

---

# 47. PAYMENT IDEMPOTENCY

Payment/order operations must be safe against:

- refresh
- duplicate request
- webhook replay
- network retry
- browser retry
- duplicate payment callback

Use unique transaction/event/order constraints where appropriate.

---

# 48. STOCK SAFETY

Stock decrement must be:

- transactional
- atomic
- race-condition aware
- idempotent

Prevent:

- negative stock
- duplicate decrement
- overselling
- webhook replay decrement

Use DB transaction/locking strategy appropriate to the existing schema.

---

# 49. AUTHENTICATION SECURITY

Audit and fix:

- Password hashing
- Session regeneration
- Session fixation
- Cookie flags
- SameSite
- Secure
- HttpOnly
- Session timeout
- Logout invalidation
- Failed login handling
- Brute-force protection
- Password reset
- Account enumeration
- Authorization

Production must fail closed when database/auth services fail.

Do NOT create fake/synthetic active users as a production fallback.

---

# 50. CRITICAL CREDENTIAL AUDIT

Search entire repository/history for:

```text
password
DB_PASS
DB_PASSWORD
API_KEY
SECRET
TOKEN
PRIVATE_KEY
RAZORPAY
WHATSAPP
DELHIVERY
BLUEDART
TCI
```

Immediately remove hard-coded production credentials.

Rotate any credential that was committed.

Do not merely delete the current file if secrets remain in Git history.

Use environment/secret management.

---

# 51. BOOTSTRAP ADMIN SECURITY

Audit and remove hard-coded/default admin credentials.

Do not ship:

```text
ADMIN_PASSWORD
default password
known seeded credentials
fallback admin password
```

Production bootstrap must require secure initialization.

After setup:

- disable installer
- remove installer access
- verify no reset endpoint is exposed
- verify no migration reset endpoint is exposed

---

# 52. INSTALLER SECURITY

Audit `install.php`.

Production requirements:

- installer disabled after installation
- no database credential leakage
- no default admin credential leakage
- no arbitrary SQL execution
- no unauthorized reset
- no public migration execution

If installer is not needed in production, remove it or hard-block it.

---

# 53. CSRF

Every state-changing browser endpoint must have CSRF protection.

Audit:

- login where appropriate
- registration where appropriate
- profile changes
- cart mutations
- wishlist mutations
- checkout actions
- admin CRUD
- bulk actions
- stock changes
- price changes
- order actions
- settings
- integrations

Do not rely only on JavaScript.

---

# 54. IDOR / AUTHORIZATION

Test changing:

```text
?id=1
?id=2
/user/1
/user/2
/order/1
/order/2
/product/1
```

A user must never access another user's private resources.

Authorization must be checked server-side.

---

# 55. API SECURITY

Audit every `/api/*.php`.

For each endpoint document:

- method
- authentication
- authorization
- CSRF requirement
- input schema
- output schema
- rate limit
- validation
- database action
- audit logging
- error handling
- idempotency
- permissions

No admin write endpoint should be publicly writable.

---

# 56. API COMPLETENESS

For every frontend/admin action:

```text
Button
→ JS
→ fetch/XHR
→ endpoint
→ auth
→ validation
→ service
→ DB
→ response
→ UI
```

Detect:

- missing endpoint
- wrong HTTP method
- wrong parameter
- wrong response shape
- endpoint that does nothing
- frontend calling an obsolete endpoint
- endpoint not used by any UI
- API existing without authorization

---

# 57. ERROR HANDLING

Production response must never leak:

- SQL
- stack traces
- filesystem paths
- environment variables
- API secrets
- database credentials

Use:

- safe public error
- internal logging
- request/correlation ID

---

# 58. HEALTH CHECK SECURITY

Public health checks should expose only safe status.

Do not expose:

- environment values
- filesystem internals
- database credentials
- server diagnostics
- private configuration

Separate:

```text
public health
admin diagnostics
```

with authentication for detailed diagnostics.

---

# 59. UPLOAD SECURITY

Audit all image/file uploads.

Required:

- MIME validation
- extension validation
- file size limit
- image dimension limit
- randomized filename
- storage isolation
- executable upload prevention
- path traversal prevention
- SVG policy
- EXIF handling where appropriate

Never trust original filename.

---

# 60. SECURITY HEADERS

Audit:

- Content-Security-Policy
- Strict-Transport-Security
- X-Content-Type-Options
- Referrer-Policy
- Permissions-Policy
- frame protections

Do not rely on obsolete headers.

Test CSP carefully so required application functions remain working.

---

# 61. HTTPS / COOKIE SECURITY

Production:

- HTTPS only
- Secure cookies
- HttpOnly
- SameSite appropriate to application
- secure session handling
- no mixed content

---

# 62. PERFORMANCE

Audit:

- N+1 SQL
- duplicate queries
- missing indexes
- huge PHP classes
- repeated calculations
- image size
- JS bundles
- CSS bundles
- cache strategy
- pagination
- database query limits
- API response size

Use server-side pagination for large datasets.

---

# 63. SEARCH / FILTER

Audit:

- keyword search
- SKU
- category
- subcategory
- brand
- fabric
- color
- size
- price range
- product type
- availability
- sorting
- pagination

All filters must use safe parameterized queries.

---

# 64. SEO

Audit:

- title
- meta description
- canonical
- Open Graph
- product structured data
- availability
- price
- sitemap
- robots
- clean URLs
- duplicate URLs
- pagination SEO

Do not expose role-specific confidential pricing in public structured data.

---

# 65. FRONTEND UX

Required states:

- loading
- empty
- error
- success
- disabled
- out of stock
- low stock
- unavailable variant
- invalid selection
- login required
- permission denied

Mobile-first audit required.

---

# 66. PRODUCT DETAIL UX

Required:

- Product image gallery
- Variant selector
- Color selector
- Size selector
- Product type selector where applicable
- Role-aware price
- Sale price
- Stock
- quantity
- MCQ for wholesaler
- Full Set restrictions
- Add to cart
- Wishlist
- Buy Now
- Share
- Related products

Server must validate every selection.

---

# 67. WHOLESALER UI

For wholesaler Single Piece:

Display:

```text
Available Colors × Available Sizes = MCQ
```

Show combination matrix.

Do not permit arbitrary quantity that violates MCQ.

Server remains authoritative.

---

# 68. FULL SET UI

Only:

- Retailer
- Wholesaler

can see/purchase Full Set.

Guest, Customer, Reseller must not be able to bypass this by manipulating:

- URL
- POST
- API
- hidden input
- JavaScript
- product type ID

---

# 69. LOGGING

Create structured application logs for:

- auth
- payments
- orders
- stock
- webhooks
- admin actions
- errors
- integrations

Use log rotation.

Do not log secrets.

---

# 70. RATE LIMITING

Recommended/audit:

- Login
- Password reset
- Registration
- Product search
- API
- Webhooks
- Contact/support
- Admin sensitive operations

Do not rate-limit verified webhooks incorrectly.

---

# 71. DATA VALIDATION

Validate:

- IDs
- SKU
- slug
- price
- sale price
- quantity
- MCQ
- role
- product type
- email
- phone
- pincode
- address
- coupon
- tracking number
- uploaded files

Use allowlists where possible.

---

# 72. DUPLICATE DATA AUDIT

Find duplicates in:

- SKU
- slug
- variant combinations
- order numbers
- coupon codes
- webhook events
- payment references

Add unique DB constraints where business-safe.

---

# 73. ORDER NUMBER SECURITY

Do not rely on predictable identifiers for security.

Audit existing order-number generation.

Use cryptographically strong identifiers where appropriate and enforce uniqueness in DB.

---

# 74. LARGE CLASS REFACTOR

Audit oversized domain classes.

If safe, gradually separate:

```text
ProductCatalog
Pricing
Inventory
Orders
Payments
Customers
Shipping
Notifications
```

Do NOT perform a dangerous rewrite merely for code style.

Refactor incrementally with tests.

---

# 75. ADMIN IMPORT SYSTEM

Required where import exists:

- CSV template
- column mapping
- validation preview
- duplicate detection
- dry run
- error report
- row-level error
- transaction strategy
- rollback strategy
- permission
- audit log

Never import directly into production tables without validation.

---

# 76. ADMIN EXPORT SYSTEM

Required:

- permission
- filters preserved
- date range
- selected columns
- safe filenames
- large-data handling
- no secret fields

---

# 77. FEATURE FLAGS

If feature flags already exist, audit:

- storage
- admin UI
- cache invalidation
- permission
- default behavior
- rollback

Do not hide unfinished functionality behind an enabled production flag.

---

# 78. CONFIGURATION REGISTRY

Create an internal mapping:

```text
Setting
→ ENV/DB
→ Backend consumer
→ Admin UI
→ Validation
→ Cache
→ Audit
```

No orphan settings.

No UI setting that is ignored by code.

---

# 79. CRON / JOB AUDIT

Audit scheduled tasks for:

- retry
- locking
- duplicate execution
- timeout
- logging
- failure notification
- cleanup

Do not create a cron UI if the actual system has no job infrastructure.

---

# 80. CACHE AUDIT

If caching exists:

- identify cache keys
- invalidation rules
- TTL
- role-aware pricing
- product changes
- stock changes
- permissions

Never serve one user's role-specific price to another role through a shared cache.

---

# 81. PRICE CACHE SECURITY

Critical:

```text
Guest price ≠ Customer price ≠ Retailer price ≠ Reseller price ≠ Wholesaler price
```

Cache keys must include all variables that affect output.

---

# 82. API RESPONSE SECURITY

Do not return:

- hidden admin fields
- internal database columns
- password hashes
- secrets
- internal tokens
- private audit data

Use explicit response serializers/allowlists.

---

# 83. DATABASE MIGRATION RULE

Every schema modification requires:

1. migration file
2. rollback strategy where practical
3. updated seed/data handling
4. code update
5. test update
6. deployment note

Never manually alter production schema without migration tracking.

---

# 84. TEST MATRIX — ROLES × PRODUCT TYPES

At minimum:

| Role | Single Piece | Full Set |
|---|---:|---:|
| Guest | YES | NO |
| Customer | YES | NO |
| Retailer | YES | YES |
| Reseller | YES | NO |
| Wholesaler | YES via MCQ | YES |

---

# 85. PRICE TEST MATRIX

For each role test:

### Guest
- Customer Price
- Customer Sale Price
- no Full Set

### Customer
- Customer Price
- Customer Sale Price
- no Full Set

### Retailer
- Retailer Price
- Retailer Sale Price
- Full Set Retailer Price
- Full Set Retailer Sale Price

### Reseller
- Reseller Price
- Reseller Sale Price
- no Full Set

### Wholesaler
- Wholesale Price
- Wholesale Sale Price
- MCQ
- Full Set Wholesale Price
- Full Set Wholesale Sale Price

---

# 86. PRICE LEAK TEST

Test all roles against all products.

Ensure:

- no wrong role price
- no hidden forbidden price
- no API price leak
- no HTML source leak of forbidden prices
- no JSON leak
- no cached price leak
- no checkout manipulation

---

# 87. MCQ TESTS

Test:

- 3 colors × 4 sizes = 12
- disabled variant exclusion
- out-of-stock variant exclusion
- deleted variant exclusion
- no colors
- no sizes
- one color
- one size
- partial availability
- concurrent stock changes
- forged client MCQ

Server result must be authoritative.

---

# 88. FULL SET SECURITY TESTS

Attempt Full Set purchase as:

- Guest
- Customer
- Reseller

through:

- UI
- URL
- POST
- API
- manipulated product type
- manipulated role

All must fail.

---

# 89. ADMIN SECURITY TESTS

Test every sensitive admin endpoint with:

- unauthenticated user
- normal customer
- retailer
- reseller
- wholesaler
- unauthorized admin
- authorized admin

Verify correct HTTP status and no data leak.

---

# 90. IDOR TESTS

Attempt to access:

- another customer order
- another customer's wishlist
- another customer's address
- another customer's profile
- another admin resource

All must fail unless explicitly permitted.

---

# 91. PAYMENT TESTS

Test:

- success
- failure
- duplicate callback
- webhook replay
- wrong signature
- wrong amount
- wrong order
- expired order
- timeout
- duplicate payment

No duplicate stock decrement.

---

# 92. CART TESTS

Test:

- stale product
- deleted product
- disabled variant
- changed price
- changed stock
- changed role
- changed product type
- invalid quantity
- invalid variant
- forged total

---

# 93. ADMIN UI QA

Every admin page must pass:

- desktop
- tablet
- mobile
- keyboard navigation
- basic screen-reader semantics
- no horizontal overflow where avoidable
- form validation
- loading
- empty
- error
- permission denied

---

# 94. E2E TESTS

Use the existing browser test stack where available.

Minimum journeys:

1. Guest browse → product
2. Customer login → product → cart → checkout
3. Retailer login → Single Piece
4. Retailer → Full Set
5. Reseller → Single Piece
6. Wholesaler → MCQ
7. Wholesaler → Full Set
8. Admin login → dashboard
9. Admin → add product
10. Admin → edit product
11. Admin → variant management
12. Admin → price matrix
13. Admin → stock adjustment
14. Admin → order management
15. Admin → audit log

---

# 95. ACCESSIBILITY

Audit:

- labels
- contrast
- focus
- keyboard
- buttons
- form errors
- modal focus
- table semantics
- alt text
- screen-reader labels

---

# 96. RESPONSIVE ADMIN

Admin must remain usable on mobile.

Required:

- responsive sidebar
- horizontal table strategy
- card fallback where appropriate
- filter drawer
- sticky action bar where appropriate
- readable forms
- no microscopic controls

---

# 97. CODE QUALITY

Run available:

- PHPUnit
- PHPStan
- PHP-CS-Fixer
- ESLint
- Prettier
- Stylelint
- Playwright
- accessibility checks
- Lighthouse where configured

Do not ignore new errors.

---

# 98. DEPENDENCY AUDIT

Audit:

- Composer dependencies
- npm dependencies
- outdated packages
- abandoned packages
- known vulnerabilities
- unused dependencies

Upgrade carefully and test regressions.

---

# 99. GIT / SECRET AUDIT

Search current tree AND history for:

- DB credentials
- passwords
- API keys
- tokens
- private keys
- production URLs containing credentials

Rotate exposed secrets.

Add/update:

```text
.gitignore
.env.example
secret-management documentation
```

`.env.example` must contain placeholders only.

---

# 100. PRODUCTION CONFIGURATION

Production must have:

- display_errors OFF
- secure error logging
- HTTPS
- secure cookies
- correct DB credentials outside source control
- disabled installer
- disabled debug endpoints
- safe health endpoint
- safe CORS
- secure headers
- correct file permissions
- backup strategy
- migration strategy
- monitoring

---

# 101. DEPLOYMENT CHECKLIST

Before release:

```text
[ ] Secrets rotated
[ ] .env.example sanitized
[ ] Debug disabled
[ ] Installer disabled
[ ] Reset endpoints disabled
[ ] Migrations applied
[ ] Database backup verified
[ ] HTTPS verified
[ ] Cookies verified
[ ] Admin auth verified
[ ] API auth verified
[ ] CSRF verified
[ ] IDOR verified
[ ] Price matrix verified
[ ] MCQ verified
[ ] Full Set restrictions verified
[ ] Payment webhooks verified
[ ] Stock transaction verified
[ ] Logs verified
[ ] Error pages verified
[ ] E2E tests passed
[ ] Mobile QA passed
[ ] Accessibility QA passed
```

---

# 102. BACKUP / RECOVERY

Document:

- DB backup
- file backup
- environment secret backup
- retention
- restore procedure
- recovery test

A backup is not considered valid until restore has been tested.

---

# 103. OBSERVABILITY

Recommended production monitoring:

- PHP errors
- DB errors
- failed payments
- webhook failures
- order failures
- stock failures
- login failures
- API 4xx/5xx
- slow queries
- queue failures

Use correlation/request IDs where practical.

---

# 104. ADMIN “MISSING OPTION DISCOVERY” ENGINE

Agents must automatically inspect:

- sidebar links
- dropdown links
- buttons
- forms
- JS event handlers
- fetch URLs
- API routes
- PHP routes
- DB tables
- migrations
- permissions
- docs
- tests

Generate a matrix:

| Option | UI | Route | API | DB | Permission | Test | Status |
|---|---|---|---|---|---|---|---|

Any missing cell for a required feature must be fixed.

---

# 105. ADMIN OPTION STATUS SYSTEM

Each admin option should have a clear implementation status:

- COMPLETE
- PARTIAL
- BROKEN
- MISSING
- DEPRECATED
- SECURITY RISK
- RECOMMENDED

Do not hide known broken functionality.

---

# 106. ADMIN CRUD STANDARD

For applicable entities:

```text
LIST
SEARCH
FILTER
SORT
PAGINATION
CREATE
VIEW
EDIT
ARCHIVE
RESTORE
DELETE where safe
BULK ACTION
IMPORT
EXPORT
AUDIT
```

Not every entity needs every action; the agent must document exceptions.

---

# 107. CONCURRENCY

Audit race conditions for:

- stock
- payment
- coupon usage
- order creation
- price changes
- admin edits

Use transactions/locking/version checks where appropriate.

---

# 108. SOFT DELETE

Prefer soft delete/archive for historical business entities where appropriate:

- products
- categories
- customers
- orders must generally retain historical integrity

Never physically delete records required for financial history without an explicit safe archival strategy.

---

# 109. ADMIN CONFIRMATIONS

Dangerous actions require confirmation:

- delete
- archive
- restore
- bulk delete
- stock reduction
- price update
- role change
- permission change
- integration disable
- maintenance mode
- migration/reset actions

Show what will happen.

---

# 110. BULK ACTION SAFETY

Bulk actions must:

- require permission
- validate selected IDs
- ignore unauthorized IDs
- report success/failure per item
- be auditable
- avoid partial silent failure

---

# 111. SEARCHABLE ADMIN GLOBAL SEARCH

Recommended:

Search:

- SKU
- product
- order number
- customer
- email
- phone where policy permits
- transaction reference

Respect permissions.

---

# 112. ADMIN NOTIFICATION CENTER

Show:

- low stock
- failed payments
- failed webhooks
- new orders
- system errors
- integration failures

Only show data permitted for the admin.

---

# 113. FRONTEND / ADMIN CONSISTENCY

Do not maintain separate conflicting business calculations.

Shared domain logic should determine:

- role
- product type
- price
- MCQ
- stock
- order totals

---

# 114. FILE-LEVEL AUDIT

For each major file, document:

```text
Path
Purpose
Dependencies
Inputs
Outputs
Auth
DB access
Security
Known issues
Required fix
Tests
```

Pay special attention to large classes and critical endpoints.

---

# 115. API CONTRACT DOCUMENTATION

For every important API:

```text
Endpoint
Method
Auth
Permission
Request
Validation
Response
Errors
DB impact
Side effects
Idempotency
Tests
```

Keep documentation synchronized with implementation.

---

# 116. DATABASE/API/UI CONTRACT

Every feature must satisfy:

```text
DATABASE
   ↕
DOMAIN/SERVICE
   ↕
API/CONTROLLER
   ↕
FRONTEND/ADMIN UI
```

No disconnected layer.

---

# 117. RECOMMENDED ADMIN ENHANCEMENTS

Implement only when compatible with current architecture:

- Command palette
- Saved filters
- Column visibility
- Bulk export
- Price history
- Stock ledger
- Audit timeline
- Role preview
- API health dashboard
- Webhook replay viewer
- Integration health
- System alerts
- Recently viewed products/orders
- Quick-create actions
- Draft autosave for safe forms
- Unsaved-change warning

These are recommendations, not permission to alter business pricing rules.

---

# 118. DO NOT DO

Never:

- add extra customer roles
- add extra product types
- add forbidden price fields
- invent Full Set rules
- trust client totals
- trust client MCQ
- expose secrets
- hard-code production credentials
- expose admin diagnostics publicly
- bypass authorization
- remove audit logs
- disable CSRF
- silently delete financial records
- rewrite the entire project without tests
- replace working logic with speculative architecture

---

# 119. MULTI-AGENT WORK SPLIT

Recommended ownership:

### Agent A — Repository / Architecture
- complete tree audit
- route map
- dependency map
- orphan detection

### Agent B — Admin
- admin navigation
- dashboard
- CRUD
- permissions
- UI components

### Agent C — Product / Pricing
- product types
- price matrix
- role preview
- variants
- MCQ

### Agent D — Orders / Cart / Checkout
- cart
- checkout
- order lifecycle
- stock

### Agent E — Payments / Shipping
- payment
- webhooks
- shipping
- integrations

### Agent F — Security
- secrets
- auth
- CSRF
- IDOR
- uploads
- headers
- sessions

### Agent G — Database
- schema
- indexes
- constraints
- migrations
- data integrity

### Agent H — QA
- PHPUnit
- static analysis
- browser tests
- accessibility
- regression

### Agent I — Deployment
- environment
- production hardening
- backup
- monitoring
- release checklist

Agents must coordinate before modifying shared core services.

---

# 120. REQUIRED FINAL AUDIT REPORT

At completion produce:

```text
1. Executive Summary
2. Repository Audit
3. Admin Audit
4. UI Audit
5. API Audit
6. Database Audit
7. Pricing Audit
8. Product Type Audit
9. MCQ Audit
10. Full Set Audit
11. Cart Audit
12. Checkout Audit
13. Order Audit
14. Payment Audit
15. Shipping Audit
16. Authentication Audit
17. Authorization Audit
18. Security Audit
19. Performance Audit
20. Accessibility Audit
21. SEO Audit
22. Test Results
23. Deployment Audit
24. Remaining Risks
25. Changed Files
26. Added Migrations
27. Added APIs
28. Added Admin Options
29. Added UI Components
30. Final Acceptance
```

---

# 121. REQUIRED CHANGE INVENTORY

List:

```text
NEW FILES
MODIFIED FILES
DELETED FILES
MIGRATIONS
NEW ROUTES
NEW APIs
NEW ADMIN OPTIONS
NEW PERMISSIONS
NEW DB INDEXES
NEW TESTS
SECURITY FIXES
BREAKING CHANGES
```

---

# 122. ZERO ORPHAN REQUIREMENT

Before completion:

- no dead admin menu
- no dead button
- no dead form
- no missing API
- no missing DB mapping
- no unauthorized write
- no untested critical price path
- no broken role path

---

# 123. PRODUCTION ACCEPTANCE MATRIX

| Area | Required |
|---|---|
| Roles | PASS |
| Single Piece | PASS |
| Full Set | PASS |
| Price Matrix | PASS |
| Wholesaler MCQ | PASS |
| Product Variants | PASS |
| Cart | PASS |
| Wishlist | PASS |
| Checkout | PASS |
| Orders | PASS |
| Payments | PASS |
| Shipping | PASS |
| Admin | PASS |
| API | PASS |
| Database | PASS |
| Security | PASS |
| Performance | PASS |
| Mobile | PASS |
| Accessibility | PASS |
| E2E | PASS |
| Deployment | PASS |

One critical failure = NOT PRODUCTION READY.

---

# 124. DEFINITION OF DONE

The project is DONE only when:

1. All fixed business rules pass.
2. All five roles work correctly.
3. Product type restrictions are enforced server-side.
4. Price matrix is exact.
5. No forbidden price fields exist in UI/API.
6. Wholesaler MCQ is server-calculated.
7. Full Set access is server-enforced.
8. Admin navigation has no broken/missing required option.
9. Every admin action maps to backend logic.
10. Every persisted field maps to DB.
11. Every sensitive action is permission protected.
12. CSRF is verified.
13. IDOR is verified.
14. Secrets are removed and rotated.
15. Installer/reset/debug paths are secured.
16. Payment/webhook processing is idempotent.
17. Stock changes are transactional.
18. Critical tests pass.
19. Browser tests pass.
20. Mobile QA passes.
21. Accessibility checks pass.
22. Production configuration is hardened.
23. Backup/restore is documented and tested.
24. Final audit report is complete.

---

# 125. FINAL AGENT EXECUTION COMMAND

Use this instruction after loading the repository:

> Perform a complete repository-wide audit of DT Brand / Arniya against this master specification. First map the existing implementation; then identify every missing, partial, duplicated, broken, insecure and orphaned feature. Implement all required fixes, with special priority on the complete Admin panel, Admin UI options, role-based price matrix, Single Piece/Full Set rules, wholesaler MCQ, cart, checkout, order, stock, payment, API, database, security and production deployment. Preserve all existing business rules. Never invent new pricing or Full Set rules. For every change update the required PHP/JS/CSS/API/DB/migration/tests/docs together. Run all available static, unit, integration, browser, accessibility and security tests. Fix failures. Finish with a complete change inventory, audit matrix and production-readiness report. Do not claim completion if any critical item remains unresolved.

---

# 126. FINAL PRIORITY ORDER

```text
P0 — SECURITY / DATA LOSS / PAYMENT / AUTHORIZATION
P1 — PRICE / ROLE / PRODUCT TYPE / MCQ / CHECKOUT / STOCK
P2 — ADMIN CORE / ORDERS / PRODUCTS / INVENTORY / PAYMENTS
P3 — API / DATABASE / INTEGRATIONS
P4 — FRONTEND UX / MOBILE / ACCESSIBILITY / SEO
P5 — ANALYTICS / REPORTS / ADVANCED ADMIN ENHANCEMENTS
```

---

# 127. FINAL QUALITY STANDARD

The result must feel like a complete production commerce platform:

- no fake buttons
- no dead routes
- no placeholder business logic
- no missing DB mappings
- no client-side financial trust
- no role leakage
- no price leakage
- no Full Set bypass
- no MCQ bypass
- no duplicate stock decrement
- no exposed credentials
- no insecure admin endpoint
- no broken mobile admin
- no untested critical workflow

**Final status must be either:**

`PRODUCTION READY`

or

`NOT PRODUCTION READY — BLOCKED BY: <exact issues>`

Never report “complete” while critical P0/P1 issues remain.
