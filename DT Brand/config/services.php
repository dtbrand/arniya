<?php
/**
 * config/services.php — Third-Party Services Integration Configuration
 * DT Brand's & Jai Hanuman Tex
 */

return [
    'sentry' => [
        'dsn' => getenv('SENTRY_DSN') ?: '',
        'traces_sample_rate' => 1.0,
        'environment' => getenv('APP_ENV') ?: 'production'
    ],
    'cdn' => [
        'url' => getenv('CDN_URL') ?: 'https://jaihanumantex.in',
        'enabled' => true
    ]
];
