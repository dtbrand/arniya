<?php
/**
 * logger.php — Production PSR-3 Compliant Structured Logger
 * DT Brand's & Jai Hanuman Tex
 */

namespace DTBrand;

class Logger {
    const DEBUG = 'DEBUG';
    const INFO = 'INFO';
    const WARNING = 'WARNING';
    const ERROR = 'ERROR';
    const CRITICAL = 'CRITICAL';

    private static string $logDir = __DIR__ . '/../../logs';

    private static array $sensitiveKeys = [
        'password', 'pass', 'secret', 'token', 'key', 'auth', 'card', 'cvv', 'ftp_pass'
    ];

    public static function log(string $level, string $message, array $context = []): void {
        if (!is_dir(self::$logDir)) {
            @mkdir(self::$logDir, 0755, true);
        }

        $sanitizedContext = self::sanitizeContext($context);
        $timestamp = date('Y-m-d H:i:s');
        $contextJson = !empty($sanitizedContext) ? ' ' . json_encode($sanitizedContext) : '';
        $line = "[{$timestamp}] [{$level}] {$message}{$contextJson}\n";

        $file = self::$logDir . '/app_' . date('Y-m-d') . '.log';
        @file_put_contents($file, $line, FILE_APPEND | LOCK_EX);
    }

    public static function debug(string $message, array $context = []): void {
        self::log(self::DEBUG, $message, $context);
    }

    public static function info(string $message, array $context = []): void {
        self::log(self::INFO, $message, $context);
    }

    public static function warning(string $message, array $context = []): void {
        self::log(self::WARNING, $message, $context);
    }

    public static function error(string $message, array $context = []): void {
        self::log(self::ERROR, $message, $context);
    }

    public static function critical(string $message, array $context = []): void {
        self::log(self::CRITICAL, $message, $context);
    }

    private static function sanitizeContext(array $context): array {
        $clean = [];
        foreach ($context as $k => $v) {
            if (is_array($v)) {
                $clean[$k] = self::sanitizeContext($v);
            } elseif (in_array(strtolower($k), self::$sensitiveKeys)) {
                $clean[$k] = '***REDACTED***';
            } else {
                $clean[$k] = $v;
            }
        }
        return $clean;
    }
}
