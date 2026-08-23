<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/Frontend',
        __DIR__ . '/Shared',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->exclude(['vendor', 'node_modules', 'scratch', '.uix'])
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$config = new PhpCsFixer\Config();
return $config
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
        'single_quote' => true,
        'no_trailing_whitespace' => true,
        'no_whitespace_in_blank_line' => true,
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(false);
