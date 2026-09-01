<?php
/**
 * scripts/strip-duplicate-shared-requires.php — Remove every _shared.php require
 * that lives inside a <?php ... ?> block but is not the very first line of
 * admin/settings/general.php (and any other settings page). They are all
 * inline-injected leftovers that re-evaluate _shared.php in the middle of
 * the document, which is invalid PHP.
 */
$root = dirname(__DIR__);
$files = glob($root . '/admin/settings/*.php') ?: [];
foreach ($files as $f) {
    if (basename($f) === '_shared.php') continue;
    $src = file_get_contents($f);
    // If a doc opens with <?php followed by a _shared require, the line is
    // legitimate; everything after is unparsed HTML and inline-PHP requires
    // inserted by mistake. Remove every _shared require after the first.
    $parts = preg_split('/(<\?php\b)/', $src, -1, PREG_SPLIT_DELIM_CAPTURE);
    $first = true;
    $out = '';
    foreach ($parts as $chunk) {
        if ($chunk === '') continue;
        if (str_starts_with($chunk, '<?php')) {
            // This is a real PHP opener; only the first opener may load _shared.
            if ($first) {
                $first = false;
                $out .= $chunk;
                continue;
            }
            // strip a leading require of _shared.php in this opener
            $chunk = preg_replace('/^\s*require_once\s+[^;]+_shared\.php\s*;\s*/', '', $chunk);
            $out .= $chunk;
        } else {
            // Plain text/html fragment.
            $out .= $chunk;
        }
    }
    if ($out !== $src) {
        file_put_contents($f, $out);
        echo "cleaned: " . basename($f) . "\n";
    }
}
exit(0);