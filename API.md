# API Reference — DT Brand's & Jai Hanuman Tex

All endpoints live under `/api/` and speak JSON. There are **43 top-level PHP
endpoints plus 18 sub-routers** (measured 2026-09-13). Every write endpoint is
guarded; reads that expose business data require admin too.

## Conventions

- **Content type:** `application/json` responses (`api/cors.php` sets CORS + JSON headers).
- **Auth (admin):** `api/_guard.php` exposes `dt_api_require_admin()`; it fails
  **closed** with HTTP 401 JSON when the session is anonymous.
- **Auth (customer):** `api/auth/` issues and verifies sessions; rate limiting
  applies per action (see below).
- **Idempotency:** payment capture and order creation paths are idempotent
  (order number / event id dedup) — replays must not double-charge or double-decrement stock.
- **Money:** amounts are INR; storage normalisation happens through `src/Money.php`.

## Endpoint Map

### Storefront reads & writes

| Endpoint | Methods | Guard | Purpose |
| --- | --- | --- | --- |
| `api/products.php` | GET, POST, PUT, DELETE | Admin for writes | Product CRUD, listing, filtering |
| `api/search.php` | GET | Public | Catalogue search |
| `api/cart.php` | GET, POST | Customer/session | Cart validation, live stock check, coupon application |
| `api/wishlist.php` | GET, POST | Customer/session | Wishlist toggle & listing |
| `api/coupons.php` | GET, POST | Admin writes | Coupon CRUD + usage ledger |
| `api/orders.php` | GET, POST | Session; **401 before DB** for details | Order creation (transactional), listing |
| `api/auth.php` + `api/auth/` | POST | Rate-limited | register / login / logout / forgot / reset / OTP |
| `api/payments.php` + `api/payments/` | POST | Session | Checkout orchestration, gateway session creation (UPI deep links, Razorpay, Cashfree, COD, WhatsApp Pay) |
| `api/shipping.php` | GET, POST | Mixed | Zones, rates, pincode serviceability |
| `api/reviews.php` | GET, POST | Moderated | Verified-buyer reviews |
| `api/content.php` | GET | Public | CMS hydration (banners, sliders, collections) |
| `api/settings.php` | GET, POST | Admin | Runtime settings |
| `api/whatsapp.php` | POST | Public forms | Enquiry / order hand-off logging |
| `api/pricing.php` | GET | Tiered | Tier-aware price matrix |
| `api/wholesale.php`, `api/reseller.php`, `api/retailer.php` | GET, POST | Role-gated | Channel portals' data |
| `api/customers.php` | GET, POST, PUT, DELETE | Admin | Customer CRM CRUD |
| `api/customer_addresses.php`, `api/customer_notes.php` | GET, POST | Admin/owner | Address book, CRM notes |
| `api/upload.php` | POST | Admin | Media uploads (extension + MIME validated) |
| `api/download_product_media.php` | GET | Signed | Product media download |

### Admin operations (all `dt_api_require_admin()`)

| Endpoint | Purpose |
| --- | --- |
| `api/admin_security.php` | Roles, permissions, active sessions |
| `api/audit.php` / `api/db_audit.php` | Audit trail query/export; DB audit ledger |
| `api/reports.php` | Analytics + CSV export studio |
| `api/notifications.php` | Multi-channel notification queue, DLQ retry |
| `api/integrations.php` | Gateway credentials (masked), diagnostics |
| `api/system.php` / `api/db_optimize.php` / `api/db_sync.php` | System ops, DB optimise/sync |
| `api/developer.php` | Webhook queue, HMAC test tool, event replay |
| `api/users.php` | Admin user management |
| `api/attributes.php`, `api/brands.php`, `api/categories.php`, `api/variants.php` | Catalogue metadata CRUD |
| `api/seed_demo_catalog.php` | Catalogue seeder (admin-only, installer path) |

### Health & webhooks

| Endpoint | Guard | Purpose |
| --- | --- | --- |
| `api/health.php`, `api/db_health.php` | Admin (`db_health` runs migrations too) | Liveness + schema diagnostics |
| `api/webhooks/razorpay.php` | HMAC-SHA256 vs `RAZORPAY_WEBHOOK_SECRET`, idempotent on event id | Payment capture → stock decrement |
| `api/webhooks/cashfree.php`, `api/payments/cashfree_webhook.php` | Signature verify | Cashfree capture (see known issues) |
| `api/webhooks/delhivery.php`, `bluedart.php`, `tci.php` | Signature/secret verify | Courier status ingest |
| `api/webhooks/whatsapp.php` | Meta signature verify | WhatsApp status ingest |

## Rate Limits (`api/auth/index.php`)

| Action | Attempts | Window |
| --- | --- | --- |
| `login` | 5 | 15 minutes |
| `admin_login` | 5 | 15 minutes |
| `register` | 3 | 60 minutes |
| `forgot_password` | 2 | 60 minutes |
| `reset_password` | 3 | 60 minutes |

> **Known bug (2026-09-13 audit):** `api/auth/index.php:46` calls
> `DTBrand\RateLimiter::enforce(...)`, but `src/RateLimiter.php` declares the
> class in the **global namespace**. The call throws
> `Class "DTBrand\RateLimiter" not found` — every login/register attempt on
> this router currently fatals before auth runs. `src/Auth.php` uses the
> correct global `\RateLimiter`. Fix: either add `namespace DTBrand;` to
> `src/RateLimiter.php` (and update `src/Auth.php` + tests) or import the
> global class in the router. Details in
> `docs/audits/2026-09-13-master-audit.md`.

## Response Envelope

```json
{
  "status": "success",
  "message": "Order ORD-2026-000123 created.",
  "data": { "order_number": "ORD-2026-000123", "whatsapp_url": "https://wa.me/..." }
}
```

Errors use `status: "error"` with an appropriate HTTP code (400 validation,
401 unauthenticated, 403 forbidden, 404 missing, 500 server, 501 not implemented).
Endpoints that genuinely cannot complete log to the issues file and return **501**.

## Example: Create an Order

```bash
curl -X POST https://jaihanumantex.in/api/orders.php \
  -H "Content-Type: application/json" \
  -b "PHPSESSID=<session>" \
  -d '{
    "action": "create",
    "customer_name": "Aarav Sharma",
    "customer_phone": "9876543210",
    "items": [ { "sku": "SAR-SLK-001", "qty": 2 } ],
    "payment_method": "upi"
  }'
```

The server resolves prices from the session tier (**never** from the payload),
validates stock, writes `orders` + `order_items` inside a transaction, and
returns the order number plus the WhatsApp receipt URL.
