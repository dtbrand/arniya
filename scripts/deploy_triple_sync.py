import os
import sys
import ftplib
import time

FILES_TO_DEPLOY = [
    'src/Auth.php',
    'src/CustomerManager.php',
    'src/OrderManager.php',
    'src/ProductCatalog.php',
    'api/_guard.php',
    'api/products.php',
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
    'admin/includes/adminguard.php',
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
    'api/shipping.php',
    'api/webhooks/delhivery.php',
    'admin/payments/index.php',
    'admin/payments/pending.php',
    'admin/payments/refunds.php',
    'admin/payments/successful.php',
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
    'admin/customers/components/customer-summary.php',
    'admin/customers/components/customer-stats.php',
    'admin/customers/components/customer-profile.php',
    'admin/customers/components/customer-orders.php',
    'admin/customers/components/customer-activity.php',
    'admin/customers/components/customer-notes.php',
    'admin/customers/components/customer-table.php',
    'admin/customers/assets/js/customer-list.js',
    'database/migrations/2026_09_09_000001_add_master_price_fields.sql',
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

        uploaded = False
        for attempt in range(1, 4):
            try:
                if ftp is None:
                    ftp = connect_ftp(srv)
                ensure_remote_dir(ftp, remote_dir)
                with open(local_path, 'rb') as fp:
                    ftp.storbinary(f"STOR {remote_filename}", fp)
                
                # verify size
                remote_size = ftp.size(remote_filename)
                local_size = os.path.getsize(local_path)
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
