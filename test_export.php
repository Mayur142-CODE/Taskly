<?php
// Simple test script to verify export dependencies
echo "<h2>DocGenX Export Test</h2>";

// Test 1: Check if vendor/autoload.php exists
if (file_exists('vendor/autoload.php')) {
    echo "✅ Composer autoload found<br>";
    require_once 'vendor/autoload.php';
} else {
    echo "❌ Composer autoload NOT found<br>";
    exit;
}

// Test 2: Check if required classes exist
$classes = [
    'PhpOffice\PhpWord\PhpWord',
    'PhpOffice\PhpWord\IOFactory', 
    'Dompdf\Dompdf'
];

foreach ($classes as $class) {
    if (class_exists($class)) {
        echo "✅ Class {$class} available<br>";
    } else {
        echo "❌ Class {$class} NOT available<br>";
    }
}

// Test 3: Try creating a simple PDF
try {
    $dompdf = new \Dompdf\Dompdf();
    $html = '<html><body><h1>Test PDF</h1><p>This is a test document.</p></body></html>';
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    echo "✅ PDF generation test successful<br>";
} catch (Exception $e) {
    echo "❌ PDF generation failed: " . $e->getMessage() . "<br>";
}

// Test 4: Try creating a simple Word document
try {
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $section = $phpWord->addSection();
    $section->addText('Test Word Document');
    echo "✅ Word document creation test successful<br>";
} catch (Exception $e) {
    echo "❌ Word document creation failed: " . $e->getMessage() . "<br>";
}

echo "<br><strong>Test completed!</strong>";
?>
