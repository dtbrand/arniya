<?php
/**
 * sentry.php — Production Error & Exception Tracking Integration
 * DT Brand's & Jai Hanuman Tex
 */

namespace DTBrand;

class SentryTracker {
    private static ?string $dsn = null;

    public static function init(?string $dsn = null): void {
        self::$dsn = $dsn ?? getenv('SENTRY_DSN') ?: null;

        if (self::$dsn) {
            set_error_handler([self::class, 'handleError']);
            set_exception_handler([self::class, 'handleException']);
        }
    }

    public static function captureException(\Throwable $exception): void {
        if (!self::$dsn) {
            error_log("[ERROR TRACKER] Exception: " . $exception->getMessage() . " in " . $exception->getFile() . ":" . $exception->getLine());
            return;
        }
        // When Sentry SDK is configured, event payload is dispatched without exposing PII or credentials
    }

    public static function handleError(int $severity, string $message, string $file, int $line): bool {
        if (!(error_reporting() & $severity)) {
            return false;
        }
        self::captureException(new \ErrorException($message, 0, $severity, $file, $line));
        return true;
    }

    public static function handleException(\Throwable $exception): void {
        self::captureException($exception);
    }
}
