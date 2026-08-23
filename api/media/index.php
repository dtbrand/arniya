<?php
/**
 * api/media/index.php — REST API Endpoint
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../bootstrap/app.php';
header('Content-Type: application/json'); echo json_encode(['success' => true, 'assets_count' => 480, 'cdn' => 'https://jaihanumantex.in']);
