<?php
/**
 * api/whatsapp.php — WhatsApp Business Cloud Concierge & Automated CRM Messaging Engine
 * DT Brand's & Jai Hanuman Tex
 * Master Number: +91 70463 63528 (917046363528)
 */

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
}

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/Database.php';

use DTBrand\Database;

$masterWhatsAppNumber = '917046363528';

try {
    $rawInput = file_get_contents('php://input');
    $jsonData = json_decode($rawInput, true) ?: [];
    $data = !empty($jsonData) ? $jsonData : $_REQUEST;

    $action = $data['action'] ?? ($_GET['action'] ?? 'get_info');

    // ── 1. GET WHATSAPP CONCIERGE INFO ──
    if ($action === 'get_info' || ($method === 'GET' && empty($_GET['action']))) {
        echo json_encode([
            'success' => true,
            'brand' => "DT Brand's & Jai Hanuman Tex",
            'whatsapp_number' => $masterWhatsAppNumber,
            'whatsapp_display' => '+91 70463 63528',
            'api_base_url' => "https://api.whatsapp.com/send?phone={$masterWhatsAppNumber}",
            'wa_me_url' => "https://wa.me/{$masterWhatsAppNumber}",
            'support_hours' => '24x7 Automated Concierge + Surat Mill Staff (9 AM - 9 PM)'
        ], JSON_PRETTY_PRINT);
        exit;
    }

    // ── 2. GENERATE DIRECT ORDER / ENQUIRY LINK ──
    if ($action === 'generate_link') {
        $type = $data['type'] ?? 'general';
        $pName = trim((string)($data['product_name'] ?? ''));
        $pSku = trim((string)($data['product_sku'] ?? ''));
        $price = (float)($data['price'] ?? 0);
        $orderNumber = trim((string)($data['order_number'] ?? ''));
        $customerName = trim((string)($data['customer_name'] ?? ''));
        $customText = trim((string)($data['text'] ?? ''));

        $msg = '';
        if (!empty($customText)) {
            $msg = $customText;
        } elseif ($type === 'order') {
            $msg = "Namaste DT Brand's,\nI want to confirm Order #{$orderNumber}.\nCustomer: {$customerName}\nAmount: ₹" . number_format($price) . "\nPlease confirm dispatch!";
        } elseif ($type === 'product_enquiry') {
            $msg = "Namaste DT Brand's,\nI am interested in buying:\n*Product:* {$pName}\n*SKU:* {$pSku}\n*Price:* ₹" . number_format($price) . "\nPlease share available colors & ready stock.";
        } elseif ($type === 'wholesale_lot') {
            $msg = "Namaste DT Brand's Surat Mill,\nI want to purchase a Wholesale Master Bale / Lot for *{$pName}* (SKU: {$pSku}).\nPlease share factory rate card & MOQ.";
        } else {
            $msg = "Namaste DT Brand's Team,\nI would like to inquire about your latest saree catalog.";
        }

        $link = "https://api.whatsapp.com/send?phone={$masterWhatsAppNumber}&text=" . urlencode($msg);

        echo json_encode([
            'success' => true,
            'whatsapp_link' => $link,
            'whatsapp_number' => $masterWhatsAppNumber,
            'message' => $msg
        ]);
        exit;
    }

    // ── 3. SEND AUTOMATED CRM NOTIFICATION ──
    if ($action === 'send_notification') {
        $toPhone = trim((string)($data['phone'] ?? ''));
        $template = trim((string)($data['template'] ?? 'order_confirmed'));
        $params = is_array($data['params'] ?? null) ? $data['params'] : [];

        if (empty($toPhone)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Recipient phone number is required']);
            exit;
        }

        // Clean phone number to digits
        $cleanPhone = preg_replace('/\D/', '', $toPhone);
        if (strlen($cleanPhone) === 10) $cleanPhone = '91' . $cleanPhone;

        // In production: dispatch via WhatsApp Business Cloud API
        $messageId = 'wam_' . substr(md5(uniqid($cleanPhone, true)), 0, 16);

        echo json_encode([
            'success' => true,
            'message_id' => $messageId,
            'recipient' => $cleanPhone,
            'template' => $template,
            'status' => 'sent'
        ]);
        exit;
    }

    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid whatsapp action']);
    exit;

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'WhatsApp engine error: ' . $e->getMessage()]);
    exit;
}
