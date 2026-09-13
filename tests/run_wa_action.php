<?php
$raw = file_get_contents('php://stdin');
$input = json_decode($raw, true) ?: [];
$_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__);
$_SERVER['REQUEST_METHOD'] = $input['method'] ?? 'GET';
$_GET = $input['params'] ?? [];
$_POST = $input['params'] ?? [];
$_REQUEST = $input['params'] ?? [];
require_once __DIR__ . '/../src/Database.php';
\DTBrand\Database::setPdo(null, true);
require __DIR__ . '/../api/whatsapp.php';
