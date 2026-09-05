<?php
/** Append the dt_db_unavailable_banner helper to admin/settings/_shared.php. */
$path = dirname(__DIR__) . '/admin/settings/_shared.php';
$src = file_get_contents($path);
if (strpos($src, 'function dt_db_unavailable_banner') !== false) {
    echo "already there\n";
    exit(0);
}
$helper = <<<'PHP'


/** Banner shown when the settings table is unreachable. Pages call this
 *  instead of reading $dtSettingsLive directly so phpstan sees the read
 *  inside the helper (the variable is assigned at the top of this file). */
function dt_db_unavailable_banner(string $label = 'Database unreachable'): string
{
    global $dtSettingsLive;
    if ($dtSettingsLive === false) {
        return '<p style="font-size:11.5px; color:#B45309; padding:0 18px 12px;">⚠ '
            . htmlspecialchars($label)
            . ' — values shown are defaults and cannot be saved right now.</p>';
    }
    return '';
}
PHP;
$src = str_replace('?>', $helper . '?>', $src);
file_put_contents($path, $src);
echo "appended\n";
exit(0);
