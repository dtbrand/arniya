<?php
/**
 * config/mail.php — Mailer & SMTP Configuration
 * DT Brand's & Jai Hanuman Tex
 */

return [
    'driver' => getenv('MAIL_DRIVER') ?: 'smtp',
    'host' => getenv('MAIL_HOST') ?: 'smtp.hostinger.com',
    'port' => (int)(getenv('MAIL_PORT') ?: 465),
    'username' => getenv('MAIL_USERNAME') ?: 'info@jaihanumantex.in',
    'password' => getenv('MAIL_PASSWORD') ?: '',
    'encryption' => getenv('MAIL_ENCRYPTION') ?: 'ssl',
    'from' => [
        'address' => 'info@jaihanumantex.in',
        'name' => "DT Brand's & Jai Hanuman Tex"
    ]
];
