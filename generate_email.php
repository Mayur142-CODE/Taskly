<?php
require_once 'config.php';

$subject = $_POST['subject'] ?? '';
$context = $_POST['context'] ?? '';
$tone = $_POST['tone'] ?? 'formal';

$prompt = "Write a professional email with the following details:
Subject: $subject
Context: $context
Tone: $tone

Please format it as a complete email with proper greeting and signature.";

$result = callGeminiAPI($prompt);

if ($result['success']) {
    echo json_encode([
        'success' => true,
        'email' => $result['data']
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $result['error']
    ]);
}