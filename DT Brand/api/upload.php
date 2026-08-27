<?php
/**
 * api/upload.php — Secure Media & Image Upload API
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/_guard.php';

// Admin-only. The single caller is the admin product gallery
// (admin/products/assets/js/product-gallery.js). This endpoint writes files into
// a web-served directory, so leaving it open to anonymous POSTs let any visitor
// fill the disk — and, combined with the extension bug fixed below, drop a
// executable file onto the site.
dt_api_require_admin('upload media');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
        exit;
    }

    if (empty($_FILES['file']) && empty($_FILES['image']) && empty($_FILES['media'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'No file uploaded.']);
        exit;
    }

    $uploadedFile = $_FILES['file'] ?? ($_FILES['image'] ?? $_FILES['media']);
    if ($uploadedFile['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Upload error code: ' . $uploadedFile['error']]);
        exit;
    }

    $allowedMimes = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
        'video/mp4'  => 'mp4',
    ];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $uploadedFile['tmp_name']);
    finfo_close($finfo);

    if (!isset($allowedMimes[$mimeType])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid file type: ' . $mimeType]);
        exit;
    }

    // Limit file size (max 25MB for videos, 10MB for images)
    $maxBytes = strpos($mimeType, 'video') !== false ? 26214400 : 10485760;
    if ($uploadedFile['size'] > $maxBytes) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'File size exceeds maximum allowed limit.']);
        exit;
    }

    // The extension is derived from the VERIFIED content type, never from the
    // uploaded filename. It used to be taken straight from the client:
    //     $ext = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
    // A file can be a valid PNG (so finfo reports image/png and the type check
    // passes) while also containing PHP code in a metadata chunk. Named
    // "x.php", it was written as dt_<date>_<rand>.php into a web-served
    // directory — a remote code execution path.
    $ext = $allowedMimes[$mimeType];
    $safeName = 'dt_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;

    $uploadDir = __DIR__ . '/../assets/images/uploads';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Defence in depth: even if a bad name ever reaches this directory, refuse
    // to let the web server treat anything in it as a script.
    $htaccess = $uploadDir . '/.htaccess';
    if (!is_file($htaccess)) {
        @file_put_contents($htaccess, implode("\n", [
            '# Uploads are data, never code.',
            'php_flag engine off',
            '<FilesMatch "\.(php|php[0-9]|phtml|phar|pl|py|cgi|asp|aspx|sh)$">',
            '    Require all denied',
            '</FilesMatch>',
            ''
        ]));
    }

    $destination = $uploadDir . '/' . $safeName;
    if (move_uploaded_file($uploadedFile['tmp_name'], $destination)) {
        $publicUrl = '/assets/images/uploads/' . $safeName;
        echo json_encode([
            'success' => true,
            'url' => $publicUrl,
            'filename' => $safeName,
            'mime' => $mimeType,
            'size' => $uploadedFile['size'],
            'message' => 'File uploaded successfully!'
        ], JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to save uploaded file.']);
    }

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Upload Exception: ' . $e->getMessage()]);
}
