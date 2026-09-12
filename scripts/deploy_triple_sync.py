#!/usr/bin/env python3
"""
deploy_triple_sync.py — Unified Dual-FTP Deployment & Synchronizer
Deploys all updated code across BOTH live production storefronts:
1. HarmitEthnic (https://harmitethnic.com/) -> u602484543.harmitethnic.com
2. JaiHanumanTex (https://jaihanumantex.in/) -> u602484543.jaihanumantex.in
DT Brand's & Jai Hanuman Tex
"""
import ftplib
import os
import sys
import time

# Ensure immediate unbuffered console output
sys.stdout.reconfigure(line_buffering=True)

FTP_HOST = '147.93.99.134'
FTP_PORT = 21
FTP_PASS = 'Gautam@9006'
BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))

SERVERS = [
    {
        'name': 'HarmitEthnic (harmitethnic.com)',
        'url': 'https://harmitethnic.com',
        'host': FTP_HOST,
        'port': FTP_PORT,
        'user': 'u602484543.harmitethnic.com',
        'pass': FTP_PASS,
        'root': '/public_html'
    },
    {
        'name': 'JaiHanumanTex (jaihanumantex.in)',
        'url': 'https://jaihanumantex.in',
        'host': FTP_HOST,
        'port': FTP_PORT,
        'user': 'u602484543.jaihanumantex.in',
        'pass': FTP_PASS,
        'root': '/public_html'
    }
]

# Explicit list of directories to synchronize completely
SYNC_DIRECTORIES = [
    'api',
    'src',
    'config',
    'database/migrations',
    'admin',
    'assets',
    'includes',
    'Shared',
    'tests',
]

# Root files to synchronize
SYNC_ROOT_FILES = [
    '.htaccess',
    'index.php',
    'shop.php',
    'product.php',
    'wholesale.php',
    'retailer.php',
    'reseller.php',
    'account.php',
    'cart.php',
    'checkout.php',
    'wishlist.php',
    'about-us.php',
    'adminlogin.php',
    'admin.php',
    'dt_install_direct.php',
    'install.php',
    'test_master_spec.php',
    'sitemap.php',
]

EXCLUDE_EXTENSIONS = {'.pyc', '.log', '.tmp', '.zip'}
EXCLUDE_FILES = {'.env'} # CRITICAL: NEVER overwrite domain-specific .env!

def gather_files_to_deploy():
    deploy_files = set()

    for d in SYNC_DIRECTORIES:
        full_dir = os.path.join(BASE_DIR, d)
        if not os.path.isdir(full_dir):
            continue
        for root, dirs, files in os.walk(full_dir):
            for f in files:
                ext = os.path.splitext(f)[1].lower()
                if ext in EXCLUDE_EXTENSIONS or f in EXCLUDE_FILES:
                    continue
                rel = os.path.relpath(os.path.join(root, f), BASE_DIR).replace('\\', '/')
                deploy_files.add(rel)

    for rel in SYNC_ROOT_FILES:
        full_path = os.path.join(BASE_DIR, rel)
        if os.path.isfile(full_path):
            deploy_files.add(rel.replace('\\', '/'))

    return sorted(list(deploy_files))

def ensure_remote_dir(ftp, remote_dir):
    if not remote_dir or remote_dir == '.':
        return
    parts = [p for p in remote_dir.replace('\\', '/').split('/') if p]
    current = ''
    for part in parts:
        current = current + '/' + part
        try:
            ftp.mkd(current)
        except ftplib.error_perm:
            pass

def deploy_to_server(srv, files):
    print(f"\n{'='*70}")
    print(f"Deploying to {srv['name']} ({srv['user']})...")
    print(f"Remote Root: {srv['root']}")
    print(f"{'='*70}")

    ftp = ftplib.FTP()
    try:
        ftp.connect(srv['host'], srv['port'], timeout=30)
        ftp.login(srv['user'], srv['pass'])
        ftp.set_pasv(True)
    except Exception as e:
        print(f"[-] Login failed: {e}")
        return False

    pwd = ftp.pwd()
    print(f"[+] Logged in successfully. Current dir: {pwd}")
    if 'public_html' in ftp.nlst() and pwd != '/public_html':
        ftp.cwd('public_html')
        print(f"  Changed directory to: {ftp.pwd()}")

    uploaded_count = 0
    skipped_count = 0
    failed_count = 0

    for idx, rel_path in enumerate(files, 1):
        local_path = os.path.join(BASE_DIR, rel_path)
        if not os.path.isfile(local_path):
            failed_count += 1
            continue

        local_size = os.path.getsize(local_path)
        remote_path = rel_path.replace('\\', '/')

        # Check if already identical on remote server
        try:
            rsize = ftp.size(remote_path)
            if rsize == local_size:
                skipped_count += 1
                continue
        except Exception:
            pass

        remote_dir = os.path.dirname(remote_path)
        uploaded = False

        for attempt in range(1, 4):
            try:
                if remote_dir:
                    ensure_remote_dir(ftp, remote_dir)
                with open(local_path, 'rb') as fp:
                    ftp.storbinary(f'STOR {remote_path}', fp)
                print(f"  [OK] [{idx}/{len(files)}] {rel_path} ({local_size} bytes)")
                uploaded_count += 1
                uploaded = True
                break
            except Exception as e:
                print(f"  [ATTEMPT {attempt} FAILED] {rel_path}: {e}")
                time.sleep(1)
                try:
                    ftp.close()
                except Exception:
                    pass
                try:
                    ftp = ftplib.FTP()
                    ftp.connect(srv['host'], srv['port'], timeout=30)
                    ftp.login(srv['user'], srv['pass'])
                    ftp.set_pasv(True)
                    if 'public_html' in ftp.nlst() and ftp.pwd() != '/public_html':
                        ftp.cwd('public_html')
                except Exception:
                    pass

        if not uploaded:
            print(f"  [FAIL] {remote_path} could not be uploaded after 3 attempts.")
            failed_count += 1

    try:
        ftp.quit()
    except Exception:
        pass

    print(f"\nResult for {srv['name']}: {uploaded_count} uploaded, {skipped_count} identical (skipped), {failed_count} failed.\n")
    return failed_count == 0

def main():
    print("========================================================================")
    print("  DT BRAND'S & JAI HANUMAN TEX — DUAL-FTP TRIPLE-SYNC DEPLOYMENT")
    print("========================================================================")

    files = gather_files_to_deploy()
    print(f"Total files in synchronization manifest: {len(files)}")

    overall_ok = True
    for srv in SERVERS:
        ok = deploy_to_server(srv, files)
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
