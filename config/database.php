<?php
/**
 * config/database.php — Database Connection Configuration
 * DT Brand's & Jai Hanuman Tex — Live Hostinger Production Credentials
 */

return [
    'default' => 'mysql',
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => getenv('DB_HOST') ?: 'localhost',
            'port' => getenv('DB_PORT') ?: '3306',
            'database' => getenv('DB_NAME') ?: 'u602484543_demodt121',
            'username' => getenv('DB_USER') ?: 'u602484543_demodt121',
            'password' => getenv('DB_PASS') ?: 'Gautam@9006',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'options' => [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ]
        ]
    ]
];
