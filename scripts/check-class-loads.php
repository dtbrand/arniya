<?php
/** Standalone-load check: each src class must load as the ONLY include. */
chdir(dirname(__DIR__));
$classes = ['Database', 'ProductCatalog', 'OrderManager', 'CustomerManager', 'Auth', 'DiscountEngine', 'PricingCalculator'];
$fail = 0;
foreach ($classes as $c) {
    $fqcn = 'DTBrand\\' . $c;
    $probe = sys_get_temp_dir() . '/_load_' . $c . '.php';
    file_put_contents($probe, '<?php
require_once ' . var_export(dirname(__DIR__) . '/src/' . $c . '.php', true) . ';
echo class_exists(' . var_export($fqcn, true) . ') ? "OK" : "CLASS-MISSING";
');
    $out = shell_exec('php ' . escapeshellarg($probe) . ' 2>&1');
    echo $c, ': ', trim((string)$out), "\n";
    if (trim((string)$out) !== 'OK') $fail = 1;
}
exit($fail);