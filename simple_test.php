<?php
header('Content-Type: application/json');

try {
    // Test 1: Basic PHP functionality
    echo json_encode([
        'success' => true,
        'message' => 'PHP is working',
        'post_data' => $_POST,
        'php_version' => phpversion(),
        'zip_available' => class_exists('ZipArchive'),
        'temp_dir' => sys_get_temp_dir(),
        'downloads_exists' => is_dir(__DIR__ . '/downloads'),
        'downloads_writable' => is_writable(__DIR__ . '/downloads')
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
