<?php
/**
 * scratch_api_test.php — CLI Test Harness for api/notifications.php
 */
$_SERVER['REQUEST_METHOD'] = $argv[1] ?? 'POST';
$action = $argv[2] ?? 'stats';
if (session_status() === PHP_SESSION_NONE) {
    @session_start();
}
$_SESSION['admin_logged_in'] = true;
$_SESSION['admin_user'] = ['id' => 1, 'name' => 'Admin'];
$_SESSION['csrf_token'] = 'test_token_123';

$_POST = [
    'action' => $action,
    'csrf_token' => 'test_token_123'
];

if ($action === 'send_test') {
    $_POST['channel'] = 'sms';
    $_POST['recipient'] = '+91 97234 11223';
    $_POST['template_key'] = 'dt_dispatch_sms';
    $_POST['variables'] = ['customer_name' => 'Aarav', 'order_no' => 'DT-11223'];
}

require __DIR__ . '/../api/notifications.php';
