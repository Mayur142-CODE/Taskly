<?php
$notesFile = __DIR__ . '/storage/notes.json';
$content = $_POST['content'] ?? '';

if (!empty($content)) {
    $notes = [];
    if (file_exists($notesFile)) {
        $notes = json_decode(file_get_contents($notesFile), true);
    }
    
    $newNote = [
        'id' => time(),
        'content' => $content,
        'timestamp' => date('Y-m-d H:i:s')
    ];
    
    array_unshift($notes, $newNote);
    
    if (!is_dir(__DIR__ . '/storage')) {
        mkdir(__DIR__ . '/storage', 0777, true);
    }
    
    file_put_contents($notesFile, json_encode($notes, JSON_PRETTY_PRINT));
    
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Content is required']);
}