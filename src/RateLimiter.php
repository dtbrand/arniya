<?php
/**
 * RateLimiter — Sliding Window Rate Limiter with Redis Fallback to File/DB
 * DT Brand's & Jai Hanuman Tex
 * 
 * Usage:
 *   RateLimiter::check('login', $ip, 5, 15); // 5 attempts per 15 minutes
 *   RateLimiter::check('register', $ip, 3, 60); // 3 attempts per hour
 *   RateLimiter::check('forgot_password', $ip, 2, 60); // 2 per hour
 */

class RateLimiter
{
    private static array $memCache = [];
    
    /**
     * Check and increment rate limit counter
     * 
     * @param string $action    Action identifier (login, register, forgot_password, etc.)
     * @param string $key       Unique key (IP, user_id, email, etc.)
     * @param int $maxAttempts  Maximum attempts allowed
     * @param int $windowMinutes Time window in minutes
     * @return array ['allowed' => bool, 'remaining' => int, 'retry_after' => int|null]
     */
    public static function check(string $action, string $key, int $maxAttempts, int $windowMinutes): array
    {
        $now = time();
        $windowSeconds = $windowMinutes * 60;
        $cacheKey = "ratelimit:{$action}:{$key}";
        
        // Try Redis first
        if (extension_loaded('redis') && class_exists('Redis')) {
            try {
                $redisClass = 'Redis';
                $redis = new $redisClass();
                $redis->connect('127.0.0.1', 6379, 1);
                $redis->select(1); // Use DB 1 for rate limiting
                
                $pipe = $redis->multi();
                $pipe->zRemRangeByScore($cacheKey, 0, $now - $windowSeconds);
                $pipe->zCard($cacheKey);
                $results = $pipe->exec();
                
                $currentCount = (int)($results[1] ?? 0);
                
                if ($currentCount >= $maxAttempts) {
                    // Get oldest entry to calculate retry time
                    $oldest = $redis->zRange($cacheKey, 0, 0, ['withscores' => true]);
                    $retryAfter = !empty($oldest) ? ceil(($windowSeconds - ($now - (int)array_values($oldest)[0])) / 60) : $windowMinutes;
                    
                    return [
                        'allowed' => false,
                        'remaining' => 0,
                        'retry_after' => max(1, $retryAfter),
                        'limit' => $maxAttempts,
                        'window' => $windowMinutes
                    ];
                }
                
                // Add current request
                $redis->zAdd($cacheKey, $now, uniqid('req_', true));
                $redis->expire($cacheKey, $windowSeconds + 60);
                
                return [
                    'allowed' => true,
                    'remaining' => $maxAttempts - $currentCount - 1,
                    'retry_after' => null,
                    'limit' => $maxAttempts,
                    'window' => $windowMinutes
                ];
            } catch (Throwable $e) {
                // Fall through to file-based
                error_log("RateLimiter Redis error: " . $e->getMessage());
            }
        }
        
        // File-based fallback
        return self::checkFile($action, $key, $maxAttempts, $windowSeconds, $now);
    }
    
    /**
     * File-based rate limiting (for environments without Redis)
     */
    private static function checkFile(string $action, string $key, int $maxAttempts, int $windowSeconds, int $now): array
    {
        $safeKey = md5($action . ':' . $key);
        $file = rtrim(sys_get_temp_dir(), '/\\') . DIRECTORY_SEPARATOR . "ratelimit_{$action}_{$safeKey}.json";
        
        $data = ['requests' => []];
        if (file_exists($file)) {
            $content = file_get_contents($file);
            $decoded = json_decode($content, true);
            if (is_array($decoded) && isset($decoded['requests'])) {
                $data = $decoded;
            }
        }
        
        // Filter out old requests
        $data['requests'] = array_filter($data['requests'], function($ts) use ($now, $windowSeconds) {
            return ($now - $ts) < $windowSeconds;
        });
        
        $currentCount = count($data['requests']);
        
        if ($currentCount >= $maxAttempts) {
            $oldest = min($data['requests']);
            $retryAfter = ceil(($windowSeconds - ($now - $oldest)) / 60);
            
            return [
                'allowed' => false,
                'remaining' => 0,
                'retry_after' => max(1, $retryAfter),
                'limit' => $maxAttempts,
                'window' => $windowSeconds / 60
            ];
        }
        
        // Add current request
        $data['requests'][] = $now;
        file_put_contents($file, json_encode($data), LOCK_EX);
        
        return [
            'allowed' => true,
            'remaining' => $maxAttempts - $currentCount - 1,
            'retry_after' => null,
            'limit' => $maxAttempts,
            'window' => $windowSeconds / 60
        ];
    }
    
    /**
     * Get rate limit headers for response
     */
    public static function headers(array $result): array
    {
        return [
            'X-RateLimit-Limit' => $result['limit'],
            'X-RateLimit-Remaining' => max(0, $result['remaining']),
            'X-RateLimit-Window' => $result['window'] . 'm',
        ];
    }
    
    /**
     * Send rate limit headers and return 429 if not allowed
     */
    public static function enforce(string $action, string $key, int $maxAttempts, int $windowMinutes): bool
    {
        $result = self::check($action, $key, $maxAttempts, $windowMinutes);
        
        foreach (self::headers($result) as $header => $value) {
            header("{$header}: {$value}");
        }
        
        if (!$result['allowed']) {
            http_response_code(429);
            header('Retry-After: ' . ($result['retry_after'] * 60));
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'error' => 'rate_limited',
                'message' => "Too many {$action} attempts. Please try again in {$result['retry_after']} minute(s).",
                'retry_after' => $result['retry_after']
            ]);
            exit;
        }
        
        return true;
    }

    /**
     * Reset/clear rate limit counter (e.g. after successful login)
     */
    public static function clear(string $action, string $key): void
    {
        $cacheKey = "ratelimit:{$action}:{$key}";
        unset(self::$memCache[$cacheKey]);

        // Clear Redis key
        if (extension_loaded('redis') && class_exists('Redis')) {
            try {
                $redisClass = 'Redis';
                $redis = new $redisClass();
                $redis->connect('127.0.0.1', 6379, 1);
                $redis->select(1);
                $redis->del($cacheKey);
            } catch (\Throwable $e) {}
        }

        // Clear file-based key
        $safeKey = md5($action . ':' . $key);
        $file = rtrim(sys_get_temp_dir(), '/\\') . DIRECTORY_SEPARATOR . "ratelimit_{$action}_{$safeKey}.json";
        if (file_exists($file)) {
            @unlink($file);
        }
    }
}

if (!class_exists('DTBrand\\RateLimiter', false)) {
    class_alias('RateLimiter', 'DTBrand\\RateLimiter');
}