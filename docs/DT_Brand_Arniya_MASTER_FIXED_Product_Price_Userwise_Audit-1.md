# DT BRAND / ARNIYA — MASTER PRODUCT AUDIT & FIXED USER-WISE SHOPPING SPECIFICATION

## MASTER STATUS

This document is the FIXED specification for the Product, Pricing, Variant, Quantity/MCQ, Wishlist, Cart, Checkout, Order, Payment, Inventory, Security and Testing modules.

IMPORTANT:
- These business rules are FIXED.
- Do not invent, add, remove, merge, rename or reinterpret price fields.
- Do not impose additional business rules.
- Audit the existing project first, then implement only what is required by this document.
- Frontend and backend/API must follow the same rules.
- Server-side validation is mandatory.
- Multiple agents may work in parallel, but all agents must follow this same master file.
- A feature is complete only after end-to-end testing and regression testing.

---

# 1. USER ROLES

The shopping system must support these five user types:

1. Guest
2. Customer
3. Wholesaler
4. Retailer
5. Reseller

Every role must have a complete and consistent product-shopping experience.

---

# 2. COMPLETE SHOPPING FLOW

Every applicable user module must be audited and tested across:

HOME
→ Product Sections
→ Categories
→ Collections
→ Search
→ Filter
→ Sort
→ Product Cards
→ Product Detail
→ Images/Gallery
→ Color
→ Size
→ Product Type
→ Role-Based Price
→ Quantity / MCQ
→ Wishlist
→ Cart
→ Checkout
→ Address
→ Shipping
→ Payment
→ Order Confirmation
→ My Orders
→ Invoice

No page, component, API or checkout step may accidentally use another role's price.

---

# 3. PRODUCT TYPES

The product system must support:

1. SINGLE PIECE
2. FULL SET

These are separate selling modes.

---

# 4. SINGLE PIECE — FIXED PRODUCT RULE

Single Piece means:

ONE selected Color + ONE selected Size = ONE Piece.

Example product:

Colours:
- Red
- Mehrun
- Rama

Sizes:
- S
- M
- L
- XL

If the user selects:

Color = Red
Size = S

Result:

1 Piece

If the user selects:

Color = Rama
Size = XL

Result:

1 Piece

The selected Color + Size must identify the exact product variant.

---

# 5. NORMAL SINGLE-PIECE PURCHASE USERS

Single Piece normal purchase is allowed for:

- Guest
- Customer
- Retailer
- Reseller

Example:

Color: Red
Size: S
Quantity: 1 Piece

The system must correctly preserve:
- Product
- Variant
- Color
- Size
- SKU
- Quantity
- Role-specific price

Do not convert normal users' selected Color + Size into the wholesaler MCQ.

---

# 6. WHOLESALER SINGLE-PIECE — FIXED MCQ

Wholesaler Single Piece purchase uses a FIXED MCQ.

The MCQ is calculated from:

AVAILABLE COLOUR COUNT × AVAILABLE SIZE COUNT

Example:

3 Colours:
- Red
- Mehrun
- Rama

4 Sizes:
- S
- M
- L
- XL

Calculation:

3 × 4 = 12 Pieces MCQ

The complete combination is:

Red:
- S
- M
- L
- XL

Mehrun:
- S
- M
- L
- XL

Rama:
- S
- M
- L
- XL

TOTAL = 12 PIECES

This is FIXED.

Wholesaler must not bypass the fixed MCQ by submitting an arbitrary quantity.

Examples:

2 Colours × 3 Sizes = 6 Pieces MCQ
4 Colours × 4 Sizes = 16 Pieces MCQ
5 Colours × 6 Sizes = 30 Pieces MCQ

FORMULA:

WHOLESALE SINGLE-PIECE MCQ
=
AVAILABLE COLOURS × AVAILABLE SIZES

The implementation must count the actual available/sellable Color × Size combinations according to the existing product/variant availability model.

---

# 7. FIXED PRICE FIELDS — DO NOT CHANGE

## SINGLE PIECE

### Price
Only these roles:

- Reseller
- Retailer
- Wholesaler

### Sale Price
Only these roles:

- Reseller
- Retailer
- Wholesaler

### Customer Price
Only these users:

- Guest
- Customer

### Customer Sale Price
Only these users:

- Guest
- Customer

---

# 8. SINGLE PIECE PRICE MATRIX

| Single Piece Field | Guest | Customer | Retailer | Reseller | Wholesaler |
|---|---|---|---|---|---|
| Price | ❌ | ❌ | ✅ | ✅ | ✅ |
| Sale Price | ❌ | ❌ | ✅ | ✅ | ✅ |
| Customer Price | ✅ | ✅ | ❌ | ❌ | ❌ |
| Customer Sale Price | ✅ | ✅ | ❌ | ❌ | ❌ |

This matrix is FIXED.

No additional Single Piece price field may be introduced.

---

# 9. FULL SET — FIXED PRICE FIELDS

## Price
Only:

- Retailer
- Wholesaler

## Sale Price
Only:

- Retailer
- Wholesaler

---

# 10. FULL SET PRICE MATRIX

| Full Set Field | Guest | Customer | Retailer | Reseller | Wholesaler |
|---|---|---|---|---|---|
| Price | ❌ | ❌ | ✅ | ❌ | ✅ |
| Sale Price | ❌ | ❌ | ✅ | ❌ | ✅ |

This matrix is FIXED.

Do not add:
- Customer Full Set Price
- Reseller Full Set Price
- Guest Full Set Price
- Any other Full Set price field

unless the owner explicitly changes this specification.

---

# 11. MASTER PRICE MATRIX

| User | Single Piece Price | Single Piece Sale Price | Full Set Price | Full Set Sale Price |
|---|---|---|---|---|
| Guest | Customer Price | Customer Sale Price | Not available | Not available |
| Customer | Customer Price | Customer Sale Price | Not available | Not available |
| Retailer | Retailer Price | Retailer Sale Price | Retailer Price | Retailer Sale Price |
| Reseller | Reseller Price | Reseller Sale Price | Not available | Not available |
| Wholesaler | Wholesale Price | Wholesale Sale Price | Wholesale Price | Wholesale Sale Price |

This is the MASTER PRICE VISIBILITY RULE.

---

# 12. PRICE VISIBILITY — ALL PRODUCT SURFACES

The correct role-based price must be used consistently in:

- Home
- All product sections
- Category pages
- Collection pages
- Search results
- Filtered results
- Product cards
- Product detail
- Related products
- Similar products
- Wishlist
- Cart
- Checkout
- Order summary
- Payment summary
- Order confirmation
- My Orders
- Invoice
- Product sharing UI where price is displayed
- Applicable API responses

There must be no place where a default/global price bypasses the role-based price system.

---

# 13. PRICE FIELD IMPLEMENTATION

The Add Product/Edit Product system must expose exactly the applicable price fields.

## SINGLE PIECE PRICE FIELDS

```text
Price
├── Reseller
├── Retailer
└── Wholesaler

Sale Price
├── Reseller
├── Retailer
└── Wholesaler

Customer Price
├── Guest
└── Customer

Customer Sale Price
├── Guest
└── Customer
```

## FULL SET PRICE FIELDS

```text
Price
├── Retailer
└── Wholesaler

Sale Price
├── Retailer
└── Wholesaler
```

Do not create duplicate/conflicting price fields.

---

# 14. PRICE SECURITY

Frontend prices are display values only.

The final payable price MUST be calculated server-side.

The server must derive the applicable price from:
- authenticated user
- actual role
- product
- variant
- product type
- applicable fixed price field
- sale price
- quantity/MCQ

Never trust:
- hidden input price
- JavaScript price
- localStorage price
- submitted product price
- submitted sale price
- submitted role
- submitted subtotal
- submitted total
- submitted discount total

A user must never be able to change their role or price tier through a client request.

---

# 15. VARIANT SYSTEM

Color + Size must identify the exact variant.

Example:

Product:
Fashion Product

Variants:

Red / S
Red / M
Red / L
Red / XL

Mehrun / S
Mehrun / M
Mehrun / L
Mehrun / XL

Rama / S
Rama / M
Rama / L
Rama / XL

Every variant must preserve:
- Product ID
- Variant ID
- Color
- Size
- SKU
- Stock
- Availability/status
- Relevant existing variant data

Do not use only Product ID after a specific variant has been selected.

---

# 16. NORMAL USER SINGLE-PIECE CART

For:

- Guest
- Customer
- Retailer
- Reseller

Example:

Color = Red
Size = S
Quantity = 1

Cart line must preserve:
- Product
- Variant
- Color
- Size
- SKU
- Quantity
- Correct role price
- Correct sale price
- Subtotal

---

# 17. WHOLESALER CART

For Single Piece:

Wholesaler must use the fixed MCQ.

Example:

3 Colors × 4 Sizes = 12 Pieces

Cart must preserve the complete Color × Size combination represented by the MCQ.

The cart must not allow the wholesaler to bypass the fixed MCQ by changing the request to an arbitrary quantity.

---

# 18. FULL SET CART

Retailer:
- Full Set is available.
- Retailer Price / Retailer Sale Price must be used.

Wholesaler:
- Full Set is available.
- Wholesale Price / Wholesale Sale Price must be used.

Guest:
- Full Set is not available for purchase.

Customer:
- Full Set is not available for purchase.

Reseller:
- Full Set is not available for purchase.

The existing Full Set quantity/MCQ behavior must be audited end-to-end and must not be replaced with an invented rule.

---

# 19. WISHLIST

All five user types require correct wishlist behavior:

- Guest
- Customer
- Wholesaler
- Retailer
- Reseller

Wishlist must:
- Add product
- Remove product
- Display product card
- Display only the correct role price
- Preserve variant information where supported
- Never expose another user's private wishlist

---

# 20. CART VALIDATION

At every cart add/update request, server must verify:

1. Product exists.
2. Product is active/sellable.
3. Variant exists.
4. Variant belongs to the product.
5. Variant is available.
6. User role is valid.
7. Product type is allowed for that role.
8. Correct price is selected server-side.
9. Quantity is valid.
10. Wholesaler MCQ is valid.
11. Stock is sufficient.
12. Cart totals are recalculated.

Invalid requests must fail safely.

---

# 21. CHECKOUT

Checkout must recalculate everything server-side.

Flow:

Cart
→ Validate product
→ Validate variant
→ Validate role
→ Validate product type
→ Validate quantity/MCQ
→ Recalculate price
→ Recalculate subtotal
→ Apply valid shipping
→ Apply valid coupon/discount if supported
→ Calculate final amount
→ Create order

Never trust the client-submitted final amount.

---

# 22. ORDER HISTORY

Historical order data must preserve the exact purchase context:

- Product ID
- Product name snapshot where supported
- Variant ID
- SKU
- Product type
- Color
- Size
- Quantity
- MCQ where applicable
- Applied role
- Applied price
- Applied sale price
- Line total

Future product/price edits must not change old orders.

---

# 23. INVENTORY

Audit inventory at:

- Add Product
- Edit Product
- Variant
- Cart
- Checkout
- Order creation
- Payment
- Refund/return flow where already implemented

Stock changes must be safe against race conditions.

Payment callbacks must be idempotent so the same callback cannot decrement stock repeatedly.

---

# 24. ADD PRODUCT — FULL AUDIT

Audit every field and every backend endpoint.

## Basic Information
- Product name
- Slug
- Description
- Category
- Brand
- Status

## Media
- Main image
- Gallery images
- Image validation
- File type
- File size
- Secure upload
- Alt text where supported

## Product Type
- Single Piece
- Full Set

## Colors
- Add
- Edit
- Remove
- Availability

## Sizes
- Add
- Edit
- Remove
- Availability

## Variants
- Color + Size combination
- Variant ID
- SKU
- Stock
- Status
- Duplicate prevention

## SINGLE PIECE PRICE FIELDS

Exactly:

Price:
- Reseller
- Retailer
- Wholesaler

Sale Price:
- Reseller
- Retailer
- Wholesaler

Customer Price:
- Guest
- Customer

Customer Sale Price:
- Guest
- Customer

## FULL SET PRICE FIELDS

Exactly:

Price:
- Retailer
- Wholesaler

Sale Price:
- Retailer
- Wholesaler

No extra price fields.

---

# 25. ADD PRODUCT — WHOLESALER MCQ

When product is Single Piece:

MCQ is automatically based on available Color × Size combinations.

Example:

3 colours × 4 sizes = 12.

The agent must verify:
- Add Product creates correct variants.
- Available variants are counted correctly.
- MCQ is correct.
- Frontend shows correct MCQ.
- API validates correct MCQ.
- Cart preserves correct MCQ.
- Checkout preserves correct MCQ.
- Order preserves correct MCQ.
- Inventory adjustment is correct.

---

# 26. EDIT PRODUCT

Edit Product must not break:

- Existing product
- Existing variants
- Existing SKU
- Existing stock
- Existing carts
- Existing wishlists
- Existing orders

Price edits must affect new purchases according to the current fixed price matrix.

Historical orders must retain historical applied prices.

---

# 27. SKU

SKU must be:
- Unique
- Stable
- Searchable
- Correctly linked
- Preserved in order history

Do not silently change a SKU that is already referenced by historical orders.

---

# 28. SEARCH / FILTER

Audit product search and filtering for:

- Product name
- SKU
- Category
- Color
- Size
- Variant
- Brand
- Existing supported product attributes

Search results must use the correct role-based price.

---

# 29. PRODUCT CARD

Every product card must correctly display:

- Product image
- Product name
- Correct role price
- Correct sale price
- Product availability
- Relevant product type
- Wishlist action
- Add-to-cart action where permitted

No card may leak another role's price.

---

# 30. PRODUCT DETAIL PAGE

Audit:

- Images
- Product information
- Product type
- Color selection
- Size selection
- Variant availability
- SKU where intended
- Role-based price
- Sale price
- Quantity
- Wholesaler MCQ
- Add to cart
- Wishlist
- Related products

---

# 31. USER-WISE MODULES

## GUEST

Must audit:
- All product sections
- All cards
- All product pages
- Search
- Filter
- Wishlist
- Cart
- Checkout
- Payment
- Order flow where supported

Single Piece:
Customer Price / Customer Sale Price

Full Set:
Not purchasable.

---

## CUSTOMER

Must audit:
- All product sections
- All cards
- All product pages
- Search
- Filter
- Wishlist
- Cart
- Checkout
- Payment
- Orders
- Invoice

Single Piece:
Customer Price / Customer Sale Price

Full Set:
Not purchasable.

---

## WHOLESALER

Must audit:
- All product sections
- All cards
- All product pages
- Search
- Filter
- Wishlist
- Cart
- Checkout
- Payment
- Orders
- Invoice

Single Piece:
Wholesale Price / Wholesale Sale Price

Single Piece MCQ:
Available Colours × Available Sizes

Full Set:
Wholesale Price / Wholesale Sale Price

---

## RETAILER

Must audit:
- All product sections
- All cards
- All product pages
- Search
- Filter
- Wishlist
- Cart
- Checkout
- Payment
- Orders
- Invoice

Single Piece:
Retailer Price / Retailer Sale Price

Full Set:
Retailer Price / Retailer Sale Price

---

## RESELLER

Must audit:
- All product sections
- All cards
- All product pages
- Search
- Filter
- Wishlist
- Cart
- Checkout
- Payment
- Orders
- Invoice

Single Piece:
Reseller Price / Reseller Sale Price

Full Set:
Not purchasable.

---

# 32. ROLE-PRICE LEAK TEST

For every role, attempt to access another role's price through:

- Product page
- Product card
- Search
- Wishlist
- Cart
- Checkout
- API
- Direct URL
- Browser developer tools
- Manipulated request
- Hidden form field
- JavaScript modification

Expected:
No unauthorized price is exposed or accepted.

---

# 33. API SECURITY

Test:
- Role tampering
- Price tampering
- Product ID tampering
- Variant ID tampering
- SKU tampering
- Quantity tampering
- MCQ tampering
- Cart total tampering
- Checkout total tampering
- Unauthorized product modification
- Unauthorized order access
- IDOR
- CSRF
- SQL injection
- XSS
- Session/authentication bypass

---

# 34. DUPLICATE / RACE CONDITIONS

Test:
- Double-click Add to Cart
- Double-click Checkout
- Duplicate order submission
- Duplicate payment callback
- Simultaneous stock purchase
- Simultaneous cart update

System must not create unintended duplicate orders or double-decrement stock.

---

# 35. ERROR HANDLING

No PHP fatal error, warning, stack trace, SQL error or secret must be shown to the user.

Test:
- Product not found
- Variant not found
- Product inactive
- Variant inactive
- Out of stock
- Invalid role
- Invalid price
- Invalid quantity
- Invalid MCQ
- Payment failure
- Timeout
- Database failure
- Duplicate request

Errors must fail safely and technical details must be logged server-side.

---

# 36. PERFORMANCE / FAST LOAD

Audit and optimize:

- N+1 queries
- Duplicate API calls
- Product queries
- Variant queries
- Wishlist queries
- Cart queries
- Search queries
- Checkout queries
- Image sizes
- Lazy loading
- Pagination
- Database indexes
- Safe caching
- API response size
- JavaScript size
- CSS size

Do not remove server-side validation for performance.

---

# 37. MULTI-AGENT WORK STRUCTURE

AGENT A:
Product / Add Product / Edit Product / Variants / SKU

AGENT B:
All Role Pricing / Price Resolver / Price Visibility

AGENT C:
Wishlist / Cart / Quantity / Wholesaler MCQ

AGENT D:
Checkout / Orders / Payment / Inventory

AGENT E:
Product Cards / Product Detail / Sections / Categories / Search / Collections

AGENT F:
Authentication / Authorization / CSRF / Security / API Validation

AGENT G:
Testing / Regression / Performance / Bug Fixing

Each agent MUST:
1. Read existing code before changing it.
2. Identify shared services/classes.
3. Reuse central logic.
4. Avoid duplicate logic.
5. Avoid conflicting implementations.
6. Keep changes scoped.
7. Run tests.
8. Run regression tests.
9. Report changed files.
10. Report tests performed.
11. Report unresolved issues.

---

# 38. COMPLETE TEST MATRIX

Roles:
- Guest
- Customer
- Retailer
- Reseller
- Wholesaler

Product types:
- Single Piece
- Full Set

Surfaces:
- Home
- Product Sections
- Category
- Collection
- Search
- Filter
- Product Card
- Product Detail
- Variant Selection
- Wishlist
- Cart
- Checkout
- Payment
- Order
- Invoice
- Order History

---

# 39. SINGLE PIECE TEST

Product:
3 Colours × 4 Sizes

Test Guest:
Red + S = 1 Piece
Correct Customer Price / Customer Sale Price

Test Customer:
Red + S = 1 Piece
Correct Customer Price / Customer Sale Price

Test Retailer:
Red + S = 1 Piece
Correct Retailer Price / Retailer Sale Price

Test Reseller:
Red + S = 1 Piece
Correct Reseller Price / Reseller Sale Price

Test Wholesaler:
3 × 4 = 12 Piece MCQ
Correct Wholesale Price / Wholesale Sale Price

Verify:
Product → Variant → Price → Cart → Checkout → Order → Inventory.

---

# 40. FULL SET TEST

Retailer:
Full Set → Retailer Price / Retailer Sale Price

Wholesaler:
Full Set → Wholesale Price / Wholesale Sale Price

Guest:
Full Set not purchasable.

Customer:
Full Set not purchasable.

Reseller:
Full Set not purchasable.

Test the complete flow:
Product → Selection → Price → Cart → Checkout → Order → Inventory → Invoice.

---

# 41. PRICE FIELD REGRESSION CHECK

The final Add Product form must NOT accidentally contain:

Single Piece:
- Customer Price under the normal Price group
- Guest Price as a separate purchasing field
- Full Set Reseller Price
- Full Set Customer Price
- Any unapproved additional price field

The exact fixed structure is:

SINGLE PIECE:
Price = Reseller + Retailer + Wholesaler
Sale Price = Reseller + Retailer + Wholesaler
Customer Price = Guest + Customer
Customer Sale Price = Guest + Customer

FULL SET:
Price = Retailer + Wholesaler
Sale Price = Retailer + Wholesaler

---

# 42. DEFINITION OF DONE

Do not mark complete until all are verified:

[ ] Add Product
[ ] Edit Product
[ ] Product Type
[ ] Colors
[ ] Sizes
[ ] Variants
[ ] SKU
[ ] Single Piece
[ ] Full Set
[ ] Fixed Price Fields
[ ] Fixed Sale Price Fields
[ ] Customer Price
[ ] Customer Sale Price
[ ] Role Price Visibility
[ ] Single Piece Normal Quantity
[ ] Wholesaler MCQ
[ ] MCQ Formula
[ ] Wishlist
[ ] Cart
[ ] Checkout
[ ] Payment
[ ] Order
[ ] Invoice
[ ] Inventory
[ ] Historical Price Preservation
[ ] Search
[ ] Product Cards
[ ] Product Detail
[ ] API Authorization
[ ] Price Tampering Protection
[ ] MCQ Bypass Protection
[ ] Stock Race Protection
[ ] Duplicate Order Protection
[ ] Error Handling
[ ] Security Testing
[ ] Mobile Testing
[ ] Desktop Testing
[ ] Performance Testing
[ ] Regression Testing

---

# 43. FINAL AGENT COMMAND

AUDIT
→ IMPLEMENT
→ TEST
→ FIND BUGS
→ FIX BUGS
→ RETEST
→ REGRESSION TEST
→ FINAL AUDIT

Do not claim completion only because the UI works.

The module is complete only when:

FRONTEND
+
API
+
DATABASE
+
AUTHORIZATION
+
PRICE LOGIC
+
VARIANT LOGIC
+
QUANTITY/MCQ
+
WISHLIST
+
CART
+
CHECKOUT
+
PAYMENT
+
ORDER
+
INVENTORY
+
SECURITY
+
PERFORMANCE
+
TESTS

all follow this master specification.

If existing code conflicts with this document:
1. Identify the conflict.
2. Fix it according to this document.
3. Test the affected feature.
4. Run regression tests.
5. Report changed files.
6. Report test results.
7. Report any remaining issue.

DO NOT add any business rule that is not explicitly written in this master file.

# END OF MASTER SPECIFICATION
