<?php
session_start();

// Get the requested page from query parameter
$page = $_GET['page'] ?? 'dashboard';

// Update last activity
$_SESSION['last_activity'] = [
    'tool' => ucfirst($page),
    'timestamp' => date('Y-m-d H:i:s')
];

// Define valid pages and their corresponding files
$validPages = [
    'dashboard' => 'views/dashboard_professional.php',
    'emailgenx' => 'views/emailgenx/index.php',
    'notesgenx' => 'views/notesgenx/index.php',
    'ideagenx' => 'views/ideagenx/index.php',
    'docgenx' => 'views/docgenx/index.php',
    'webgenx' => 'views/webgenx/index.php'
];

// Set the content file based on the requested page
$content = $validPages[$page] ?? $validPages['dashboard'];


// Include the professional layout with the content
include 'views/layouts/professional.php';