<?php
$notesFile = __DIR__ . '/storage/notes.json';
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? 0;

if ($id && file_exists($notesFile)) {
    $notes = json_decode(file_get_contents($notesFile), true);
    $notes = array_filter($notes, fn($note) => $note['id'] !== $id);
    file_put_contents($notesFile, json_encode(array_values($notes), JSON_PRETTY_PRINT));
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid note ID']);
}