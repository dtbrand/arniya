import os
import sys
import ftplib

FILES_TO_DEPLOY = [
    'src/Auth.php',
    'src/CustomerManager.php',
    'src/OrderManager.php',
    'api/_guard.php',
    'admin/includes/adminguard.php',
    'api/wholesale.php',
    'api/retailer.php',
    'api/reseller.php',
    'api/orders.php',
    'api/auth.php',
    'api/customer_addresses.php',
    'Shared/checkout.php',
    'account.php',
    'admin/orders/index.php',
    'admin/orders/components/order-table.php',
    'admin/orders/components/order-actions.php',
    'admin/orders/assets/js/orders.js',
    'admin/orders/assets/js/order-status.js',
    'admin/orders/assets/js/bulk-actions.js',
    'index.php',
    'wholesale.php',
    'retailer.php',
    'reseller.php',
    'assets/js/wholesale.js',
    'assets/js/retailer.js',
    'assets/js/reseller.js',
    'assets/css/wholesale.css',
    'assets/css/retailer.css',
    'assets/css/reseller.css',
    'admin/customers/components/customer-addresses.php',
    'admin/customers/assets/js/customer-view.js',
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

def deploy_to_server(srv):
    print(f"\n{'='*60}")
    print(f"Deploying to {srv['name']} ({srv['user']})...")
    print(f"{'='*60}")
    
    try:
        ftp = ftplib.FTP()
        ftp.connect(srv['host'], srv['port'], timeout=30)
        ftp.login(srv['user'], srv['pass'])
        ftp.set_pasv(True)
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

        try:
            ensure_remote_dir(ftp, remote_dir)
            with open(local_path, 'rb') as fp:
                ftp.storbinary(f"STOR {remote_filename}", fp)
            
            # verify size
            remote_size = ftp.size(remote_filename)
            local_size = os.path.getsize(local_path)
            print(f"  [OK] {rel_path} -> {remote_filename} ({remote_size} bytes, local: {local_size} bytes)")
            success_count += 1
        except Exception as e:
            print(f"  [FAIL] {rel_path}: {e}")
            fail_count += 1

    try:
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
