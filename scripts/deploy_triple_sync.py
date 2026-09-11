import os
import sys
import ftplib
import time

FILES_TO_DEPLOY = [
    '.htaccess',
    'src/Auth.php',
    'src/CustomerManager.php',
    'src/OrderManager.php',
    'src/PaymentManager.php',
    'src/ProductCatalog.php',
    'api/_guard.php',
    'api/products.php',
    'api/search.php',
    'api/wishlist.php',
    'api/cart.php',
    'api/orders.php',
    'api/wholesale.php',
    'api/retailer.php',
    'api/reseller.php',
    'api/auth.php',
    'api/customer_addresses.php',
    'Shared/cart.php',
    'Shared/checkout.php',
    'Shared/wishlist.php',
    'cart.php',
    'checkout.php',
    'wishlist.php',
    'index.php',
    'shop.php',
    'product.php',
    'wholesale.php',
    'retailer.php',
    'reseller.php',
    'account.php',
    'assets/js/dt-cart-sync.js',
    'assets/js/singleproduct.js',
    'assets/js/wholesale.js',
    'assets/js/retailer.js',
    'assets/js/reseller.js',
    'assets/js/modals.js',
    'assets/css/wholesale.css',
    'assets/css/retailer.css',
    'assets/css/reseller.css',
    'config/session.php',
    'config/database.php',
    'adminlogin.php',
    'admin.php',
    'admin/index.php',
    'admin/login.php',
    'admin/login/index.php',
    'admin/logout.php',
    'admin/includes/adminguard.php',
    'admin/products/components/product-pricing.php',
    'admin/products/assets/js/product-form.js',
    'admin/products/assets/js/variants.js',
    'tests/test_unit_pricing.php',
    'tests/test_guard_security.php',
    'tests/test_b2b_api_security.php',
    'test_master_spec.php',
    'admin/orders/index.php',
    'admin/orders/pending.php',
    'admin/orders/confirmed.php',
    'admin/orders/processing.php',
    'admin/orders/packed.php',
    'admin/orders/shipped.php',
    'admin/orders/out-for-delivery.php',
    'admin/orders/delivered.php',
    'admin/orders/cancelled.php',
    'admin/orders/returned.php',
    'admin/orders/refunded.php',
    'admin/orders/failed.php',
    'admin/orders/returns.php',
    'admin/orders/refunds.php',
    'admin/orders/ledger.php',
    'admin/orders/components/order-table.php',
    'admin/orders/components/order-actions.php',
    'admin/orders/assets/js/orders.js',
    'admin/orders/assets/js/order-status.js',
    'admin/orders/assets/js/bulk-actions.js',
    'admin/orders/assets/js/order-list.js',
    'admin/orders/assets/js/order-view.js',
    'admin/customers/components/customer-addresses.php',
    'admin/customers/assets/js/customer-view.js',
    'api/brands.php',
    'admin/products/index.php',
    'admin/products/brands/index.php',
    'admin/shipping/index.php',
    'admin/shipping/methods.php',
    'admin/shipping/rates.php',
    'admin/shipping/tracking.php',
    'admin/shipping/zones.php',
    'admin/shipping/labels.php',
    'admin/shipping/exceptions.php',
    'admin/shipping/audit.php',
    'tests/test_unit_shipping_admin.php',
    'database/migrations/2026_09_12_000003_create_shipping_admin_tables.sql',
    'api/shipping.php',
    'api/webhooks/delhivery.php',
    'api/webhooks/razorpay.php',
    'admin/payments/index.php',
    'admin/payments/pending.php',
    'admin/payments/refunds.php',
    'admin/payments/successful.php',
    'admin/payments/view.php',
    'admin/payments/failed.php',
    'admin/payments/razorpay.php',
    'admin/payments/reconciliation.php',
    'admin/payments/webhooks.php',
    'admin/payments/audit.php',
    'database/migrations/2026_09_12_000004_create_payment_admin_tables.sql',
    'tests/test_unit_payment_admin.php',
    'src/ContentManager.php',
    'api/content.php',
    'admin/marketing/banners.php',
    'admin/marketing/sliders.php',
    'admin/marketing/homepage.php',
    'admin/marketing/collections.php',
    'admin/marketing/curation.php',
    'admin/marketing/announcements.php',
    'admin/marketing/seo.php',
    'admin/marketing/share-templates.php',
    'admin/marketing/social.php',
    'database/migrations/2026_09_12_000005_create_marketing_content_tables.sql',
    'tests/test_unit_content_marketing_admin.php',
    'admin/reports/index.php',
    'admin/reports/gst.php',
    'admin/reports/revenue.php',
    'admin/reports/sales.php',
    'api/attributes.php',
    '.user.ini',
    'admin/products/attributes/index.php',
    'admin/products/attributes/values.php',
    'api/cors.php',
    'api/customer_notes.php',
    'admin/orders/export.php',
    'admin/customers/index.php',
    'admin/customers/view.php',
    'admin/customers/edit.php',
    'admin/customers/retailers.php',
    'admin/customers/resellers.php',
    'admin/customers/wholesalers.php',
    'admin/customers/pending.php',
    'admin/customers/active.php',
    'admin/customers/inactive.php',
    'admin/customers/new.php',
    'admin/customers/export.php',
    'admin/customers/segments.php',
    'admin/customers/tags.php',
    'admin/customers/orders.php',
    'admin/customers/addresses.php',
    'admin/customers/activity.php',
    'admin/customers/notes.php',
    'admin/customers/analytics.php',
    'admin/customers/_require-customer.php',
    'admin/customers/components/customer-summary.php',
    'admin/customers/components/customer-stats.php',
    'admin/customers/components/customer-profile.php',
    'admin/customers/components/customer-orders.php',
    'admin/customers/components/customer-activity.php',
    'admin/customers/components/customer-notes.php',
    'admin/customers/components/customer-table.php',
    'admin/customers/components/customer-filters.php',
    'admin/customers/components/customer-status.php',
    'admin/customers/components/customer-segments.php',
    'admin/customers/components/customer-tags.php',
    'admin/customers/components/customer-search.php',
    'admin/customers/components/bulk-actions.php',
    'admin/customers/assets/js/customer-list.js',
    'admin/customers/assets/js/customer-filters.js',
    'admin/customers/assets/js/customer-status.js',
    'admin/customers/assets/js/bulk-actions.js',
    'admin/customers/assets/js/customers.js',
    'tests/test_unit_customer_management.php',
    'src/InventoryManager.php',
    'admin/inventory/index.php',
    'admin/inventory/adjustment.php',
    'admin/inventory/low-stock.php',
    'admin/inventory/stock-in.php',
    'admin/inventory/stock-out.php',
    'admin/inventory/ledger.php',
    'admin/inventory/export.php',
    'admin/inventory/components/nav.php',
    'admin/includes/adminsidebar.php',
    'database/migrations/2026_09_09_000001_add_master_price_fields.sql',
    'database/migrations/2026_09_11_000001_add_full_price_matrix_columns.sql',
    'database/migrations/2026_09_12_000001_create_inventory_ledger.sql',
    'database/migrations/2026_09_12_000002_create_coupon_usages_and_audit.sql',
    'src/DiscountEngine.php',
    'api/coupons.php',
    'admin/marketing/index.php',
    'admin/marketing/coupons.php',
    'admin/marketing/discount-rules.php',
    'admin/marketing/usage.php',
    'admin/marketing/expired.php',
    'admin/marketing/audit.php',
    'admin/marketing/banners.php',
    'admin/marketing/campaigns.php',
    'admin/marketing/marketing.css',
    'admin/marketing/marketing.js',
    'tests/test_unit_coupons_and_discounts.php',
    'database/schema.sql',
    'install.php',
    'includes/bootstrap.php',
    'includes/header.php',
    'db_reset_migrations.php',
    'robots.txt',
    'sitemap.php',
]

SERVERS = [
    {
        'name': 'HarmitEthnic (harmitethnic.com)',
        'host': '147.93.99.134',
        'port': 21,
        'user': 'u602484543.harmitethnic.com',
        'pass': 'Gautam@9006',
        'root': '/public_html'
    },
    {
        'name': 'JaiHanumanTex (jaihanumantex.in)',
        'host': '147.93.99.134',
        'port': 21,
        'user': 'u602484543.jaihanumantex.in',
        'pass': 'Gautam@9006',
        'root': '/public_html'
    }
]

BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))

def ensure_remote_dir(ftp, remote_dir):
    parts = [p for p in remote_dir.replace('\\', '/').split('/') if p]
    ftp.cwd('/')
    current = ''
    for part in parts:
        current += '/' + part
        try:
            ftp.cwd(current)
        except ftplib.error_perm:
            try:
                ftp.mkd(current)
                ftp.cwd(current)
            except Exception as e:
                print(f"    [!] Could not create dir {current}: {e}")

def connect_ftp(srv):
    ftp = ftplib.FTP()
    ftp.connect(srv['host'], srv['port'], timeout=30)
    ftp.login(srv['user'], srv['pass'])
    ftp.makepasv = lambda: ftplib.parse229(ftp.sendcmd('EPSV'), ftp.sock.getpeername())
    return ftp

def deploy_to_server(srv):
    print(f"\n{'='*60}")
    print(f"Deploying to {srv['name']} ({srv['user']})...")
    print(f"{'='*60}")
    
    ftp = None
    try:
        ftp = connect_ftp(srv)
        print(f"[+] Logged in successfully. Current dir: {ftp.pwd()}")
    except Exception as e:
        print(f"[-] Login failed: {e}")
        return False

    success_count = 0
    fail_count = 0

    for rel_path in FILES_TO_DEPLOY:
        local_path = os.path.join(BASE_DIR, rel_path)
        if not os.path.isfile(local_path):
            print(f"[-] Local file not found: {local_path}")
            fail_count += 1
            continue

        remote_full = f"{srv['root']}/{rel_path}".replace('\\', '/')
        remote_dir = os.path.dirname(remote_full)
        remote_filename = os.path.basename(remote_full)

        local_size = os.path.getsize(local_path)
        # Check if remote file already exists with identical size
        try:
            if ftp is None:
                ftp = connect_ftp(srv)
            ensure_remote_dir(ftp, remote_dir)
            remote_size = ftp.size(remote_filename)
            if remote_size == local_size and '--force' not in sys.argv:
                print(f"  [UP-TO-DATE] {rel_path} ({remote_size} bytes)")
                success_count += 1
                continue
        except Exception:
            pass

        uploaded = False
        for attempt in range(1, 5):
            try:
                if ftp is None:
                    ftp = connect_ftp(srv)
                ensure_remote_dir(ftp, remote_dir)
                with open(local_path, 'rb') as fp:
                    ftp.storbinary(f"STOR {remote_filename}", fp)
                
                # verify size
                remote_size = ftp.size(remote_filename)
                print(f"  [OK] {rel_path} -> {remote_filename} ({remote_size} bytes, local: {local_size} bytes)")
                success_count += 1
                uploaded = True
                break
            except Exception as e:
                print(f"  [ATTEMPT {attempt} FAILED] {rel_path}: {e}")
                err_str = str(e)
                if 'Temporary hidden file' in err_str:
                    try:
                        temp_file = f".in.{remote_filename}."
                        ftp.delete(temp_file)
                        print(f"  [CLEANED] Deleted stale temp file {temp_file}")
                    except Exception:
                        pass
                try:
                    if ftp:
                        ftp.close()
                except Exception:
                    pass
                ftp = None
                time.sleep(1.5)

        if not uploaded:
            print(f"  [FAIL] {rel_path} could not be uploaded after 3 attempts.")
            fail_count += 1

    try:
        if ftp:
            ftp.quit()
    except Exception:
        pass

    print(f"Result for {srv['name']}: {success_count} succeeded, {fail_count} failed.\n")
    return fail_count == 0

def main():
    print("Starting Triple-Sync Live FTP Deployment for DT Brand's & Jai Hanuman Tex...")
    overall_ok = True
    for srv in SERVERS:
        ok = deploy_to_server(srv)
        if not ok:
            overall_ok = False

    if overall_ok:
        print("\n*** ALL FILES DEPLOYED TO BOTH LIVE SERVERS WITH 100% SUCCESS! ***")
        sys.exit(0)
    else:
        print("\n*** WARNING: One or more deployments had errors. Check log above. ***")
        sys.exit(1)

if __name__ == '__main__':
    main()
