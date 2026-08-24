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

    $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'video/mp4'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $uploadedFile['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mimeType, $allowedMimes, true)) {
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

    $ext = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
    $safeName = 'dt_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . strtolower($ext);

    $uploadDir = __DIR__ . '/../assets/images/uploads';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
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
