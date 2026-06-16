<?php
require_once 'config.php';

$problem = $_POST['problem'] ?? '';

$prompt = "Generate code for: $problem\n\n";
$prompt .= "Please provide well-commented, efficient code with explanations.";

$result = callGeminiAPI($prompt);

if ($result['success']) {
    echo json_encode([
        'success' => true,
        'code' => $result['data']
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $result['error']
    ]);
}