import os
import glob

workspace = r"c:\Users\sai\Desktop\DT Reseller HUB"
cust_dir = os.path.join(workspace, "admin", "customers")
comp_dir = os.path.join(cust_dir, "components")

old_pattern = "/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;"

# 1. Root customer files
cust_files = glob.glob(os.path.join(cust_dir, "*.php"))
new_cust_guard = "/* DT admin access guard */ $__dtg = __DIR__ . '/../includes/adminguard.php'; if (!is_file($__dtg)) $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;"

count_cust = 0
for f in cust_files:
    with open(f, 'r', encoding='utf-8', errors='ignore') as fp:
        content = fp.read()
    if old_pattern in content:
        content = content.replace(old_pattern, new_cust_guard)
        with open(f, 'w', encoding='utf-8') as fp:
            fp.write(content)
        count_cust += 1
        print(f"Updated customer file: {os.path.basename(f)}")

# 2. Customer components
comp_files = glob.glob(os.path.join(comp_dir, "*.php"))
new_comp_guard = "/* DT admin access guard */ $__dtg = __DIR__ . '/../../includes/adminguard.php'; if (!is_file($__dtg)) $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;"

count_comp = 0
for f in comp_files:
    with open(f, 'r', encoding='utf-8', errors='ignore') as fp:
        content = fp.read()
    if old_pattern in content:
        content = content.replace(old_pattern, new_comp_guard)
        with open(f, 'w', encoding='utf-8') as fp:
            fp.write(content)
        count_comp += 1
        print(f"Updated component file: {os.path.basename(f)}")

print(f"\nTotal updated: {count_cust} customer files, {count_comp} component files.")
