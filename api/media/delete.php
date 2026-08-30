<?php
/**
 * api/media/delete.php — Delete an uploaded media file
 * DT Brand's & Jai Hanuman Tex
 *
 * The media library's Delete button used to only remove the DOM card — the
 * file stayed on disk forever. This endpoint unlinks the real file, but only
 * for filenames that actually live inside assets/images/uploads/ and only
 * for a logged-in admin. The basename() + realpath() containment check is
 * what stops "../.env" or "src/Database.php" style traversal.
 */

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../_guard.php';

use DTBrand\Database;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

dt_api_require_admin('delete media files');

$filename = basename(trim((string)($_POST['filename'] ?? '')));
if ($filename === '' || $filename === '.htaccess' || str_contains($filename, '.' ) === false) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'A valid filename is required.']);
    exit;
}

$uploadDir = realpath(__DIR__ . '/../../assets/images/uploads');
if ($uploadDir === false) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'The uploads directory does not exist.']);
    exit;
}

$target = realpath($uploadDir . DIRECTORY_SEPARATOR . $filename);
if ($target === false || strpos($target, $uploadDir . DIRECTORY_SEPARATOR) !== 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'File not found inside the uploads directory.']);
    exit;
}

// Never delete the PHP engine guard itself.
if (basename($target) === '.htaccess') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Refusing to delete the uploads .htaccess guard.']);
    exit;
}

if (!is_file($target)) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'No such file: ' . $filename]);
    exit;
}

if (!@unlink($target)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'The server refused to delete the file (permissions?).']);
    exit;
}

echo json_encode(['success' => true, 'filename' => $filename, 'message' => 'File deleted.']);
