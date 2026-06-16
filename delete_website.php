<?php
session_start();
header('Content-Type: application/json');

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['folder'])) {
    echo json_encode(['success' => false, 'error' => 'Missing folder parameter']);
    exit;
}

$folderName = $input['folder'];
$websitesDir = __DIR__ . '/storage/websites/';
$folderPath = $websitesDir . $folderName;

// Validate folder exists and is within websites directory
if (!is_dir($folderPath) || strpos(realpath($folderPath), realpath($websitesDir)) !== 0) {
    echo json_encode(['success' => false, 'error' => 'Website folder not found']);
    exit;
}

try {
    // Check if this is the current session website
    $isCurrentSession = false;
    if (isset($_SESSION['generated_website'])) {
        $currentPath = $_SESSION['generated_website']['folder_path'];
        $isCurrentSession = (realpath($folderPath) === realpath($currentPath));
    }
    
    // Delete the folder and all its contents
    $deleted = deleteDirectory($folderPath);
    
    if (!$deleted) {
        throw new Exception('Failed to delete website folder');
    }
    
    // Clear session data if this was the current website
    if ($isCurrentSession) {
        unset($_SESSION['generated_website']);
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Website deleted successfully',
        'was_current_session' => $isCurrentSession
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Error deleting website: ' . $e->getMessage()
    ]);
}

/**
 * Recursively delete a directory and all its contents
 */
function deleteDirectory($dir) {
    if (!is_dir($dir)) {
        return false;
    }
    
    $files = array_diff(scandir($dir), ['.', '..']);
    
    foreach ($files as $file) {
        $filePath = $dir . DIRECTORY_SEPARATOR . $file;
        
        if (is_dir($filePath)) {
            deleteDirectory($filePath);
        } else {
            unlink($filePath);
        }
    }
    
    return rmdir($dir);
}
?>
