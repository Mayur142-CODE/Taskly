<?php
// Debug file to test IdeaGenX routing
echo "Debug: IdeaGenX Access Test<br>";
echo "Current URL: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "Page parameter: " . ($_GET['page'] ?? 'not set') . "<br>";
echo "Include path: views/ideagenx/index.php<br>";

if (file_exists('views/ideagenx/index.php')) {
    echo "File exists: YES<br>";
    echo "File permissions: " . substr(sprintf('%o', fileperms('views/ideagenx/index.php')), -4) . "<br>";
} else {
    echo "File exists: NO<br>";
}

echo "<hr>";
echo "Testing include:<br>";

try {
    include 'views/ideagenx/index.php';
} catch (Exception $e) {
    echo "Error including file: " . $e->getMessage();
}
?>
