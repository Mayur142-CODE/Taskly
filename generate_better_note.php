<?php
require_once 'config.php';

$data = json_decode(file_get_contents('php://input'), true);
$content = $data['content'] ?? '';

$prompt = "Improve and enhance the following note, making it more organized and clear:

$content

Please maintain the key points while improving clarity and structure.";

$improvedNote = callGeminiAPI($prompt);

echo json_encode([
    'success' => true,
    'improvedNote' => $improvedNote
]);