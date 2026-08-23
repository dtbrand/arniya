<?php
/**
 * api/customers/index.php — REST API Endpoint
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../bootstrap/app.php';
header('Content-Type: application/json'); echo json_encode(['success' => true, 'data' => \DTBrand\CustomerManager::getAll()]);
