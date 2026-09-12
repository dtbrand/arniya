<?php
/**
 * api/db_sync.php — PERMANENTLY DISABLED FOR DATABASE SAFETY & CREDENTIAL DEFENSE
 * DT Brand's & Jai Hanuman Tex — Live Production Architecture
 */
http_response_code(403);
header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'success' => false,
    'error'   => 'forbidden',
    'message' => 'Forbidden: Legacy database synchronization script is permanently locked in production.'
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
exit;
