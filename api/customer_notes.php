<?php
/**
 * api/customer_notes.php — Internal staff notes attached to a customer.
 * DT Brand's & Jai Hanuman Tex
 *
 * The dossier's "Staff Notes" tab had no backend at all: the save button raised
 * a "Note Saved!" toast and the text was gone on reload. This endpoint gives it
 * real storage in the customer_notes table.
 *
 * Admin-only in full. These notes are internal commercial remarks about named
 * people, so the read side is privileged too.
 */

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/_guard.php';

use DTBrand\Database;

dt_api_require_admin('read or write customer notes');

/** Distinguish "table not created yet" from a genuine query failure. */
function dt_notes_missing_table(\Exception $e): bool
{
    return strpos($e->getMessage(), '42S02') !== false
        || stripos($e->getMessage(), "doesn't exist") !== false
        || stripos($e->getMessage(), 'Base table or view not found') !== false;
}

function dt_notes_fail(int $code, string $message, array $extra = []): void
{
    http_response_code($code);
    echo json_encode(array_merge(['success' => false, 'message' => $message], $extra), JSON_PRETTY_PRINT);
    exit;
}

$pdo = Database::getConnection();
if ($pdo === null || Database::isMockMode()) {
    dt_notes_fail(503, 'The database is unavailable, so notes cannot be read or saved.');
}

$method = $_SERVER['REQUEST_METHOD'];

// ── READ ──
if ($method === 'GET') {
    $customerId = (int)($_GET['customer_id'] ?? 0);
    if ($customerId <= 0) {
        dt_notes_fail(400, 'A customer_id is required.');
    }

    try {
        $stmt = $pdo->prepare("
            SELECT `id`, `author_name`, `note_text`, `is_important`, `created_at`
            FROM `customer_notes`
            WHERE `customer_id` = ?
            ORDER BY `is_important` DESC, `created_at` DESC, `id` DESC
        ");
        $stmt->execute([$customerId]);
        echo json_encode([
            'success' => true,
            'notes'   => $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [],
        ], JSON_PRETTY_PRINT);
    } catch (\Exception $e) {
        if (dt_notes_missing_table($e)) {
            dt_notes_fail(503, 'The customer_notes table has not been created yet. Run database/migrate.php to add it.', ['needs_migration' => true]);
        }
        dt_notes_fail(500, 'Could not read notes for this customer.');
    }
    exit;
}

// ── CREATE ──
if ($method === 'POST') {
    $raw  = file_get_contents('php://input');
    $json = json_decode($raw, true) ?: [];
    $data = array_merge($_POST, $json);

    $customerId = (int)($data['customer_id'] ?? 0);
    $noteText   = trim((string)($data['note_text'] ?? ''));
    $important  = !empty($data['is_important']) ? 1 : 0;

    if ($customerId <= 0) {
        dt_notes_fail(400, 'A customer_id is required.');
    }
    if ($noteText === '') {
        dt_notes_fail(400, 'The note is empty, so there was nothing to save.');
    }
    if (mb_strlen($noteText) > 5000) {
        dt_notes_fail(400, 'That note is too long. Please keep it under 5,000 characters.');
    }

    // Refuse to attach a note to a customer who does not exist, rather than
    // leaving an orphan row that no dossier will ever display.
    try {
        $chk = $pdo->prepare("SELECT `id` FROM `customers` WHERE `id` = ? LIMIT 1");
        $chk->execute([$customerId]);
        if ($chk->fetchColumn() === false) {
            dt_notes_fail(404, 'No customer matches that id.');
        }
    } catch (\Exception $e) {
        dt_notes_fail(500, 'Could not verify the customer record.');
    }

    if (session_status() === PHP_SESSION_NONE) {
        @session_start();
    }
    $authorId   = isset($_SESSION['admin_user']['id']) ? (int)$_SESSION['admin_user']['id'] : null;
    $authorName = trim((string)($_SESSION['admin_user']['name'] ?? ''));
    if ($authorName === '') $authorName = 'Admin';

    try {
        $stmt = $pdo->prepare("
            INSERT INTO `customer_notes`
                (`customer_id`, `author_id`, `author_name`, `note_text`, `is_important`)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$customerId, $authorId, $authorName, $noteText, $important]);

        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => 'Note saved.',
            'note'    => [
                'id'          => (int)$pdo->lastInsertId(),
                'author_name' => $authorName,
                'note_text'   => $noteText,
                'is_important' => $important,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
        ], JSON_PRETTY_PRINT);
    } catch (\Exception $e) {
        if (dt_notes_missing_table($e)) {
            dt_notes_fail(503, 'The customer_notes table has not been created yet. Run database/migrate.php to add it, then save this note again.', ['needs_migration' => true]);
        }
        dt_notes_fail(500, 'The note could not be saved.');
    }
    exit;
}

// ── DELETE ──
if ($method === 'DELETE') {
    $raw  = file_get_contents('php://input');
    $json = json_decode($raw, true) ?: [];
    $noteId = (int)($json['id'] ?? ($_GET['id'] ?? 0));

    if ($noteId <= 0) {
        dt_notes_fail(400, 'A note id is required.');
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM `customer_notes` WHERE `id` = ?");
        $stmt->execute([$noteId]);
        if ($stmt->rowCount() === 0) {
            dt_notes_fail(404, 'That note no longer exists.');
        }
        echo json_encode(['success' => true, 'message' => 'Note deleted.'], JSON_PRETTY_PRINT);
    } catch (\Exception $e) {
        if (dt_notes_missing_table($e)) {
            dt_notes_fail(503, 'The customer_notes table has not been created yet.', ['needs_migration' => true]);
        }
        dt_notes_fail(500, 'The note could not be deleted.');
    }
    exit;
}

dt_notes_fail(405, 'Method not allowed.');
