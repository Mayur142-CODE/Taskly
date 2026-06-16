<?php
require_once 'vendor/autoload.php'; // You'll need to install required packages via composer

use PhpOffice\PhpWord\PhpWord;
use Dompdf\Dompdf;

$content = $_POST['content'] ?? '';
$filename = $_POST['filename'] ?? 'notes';
$format = $_POST['format'] ?? 'txt';

switch ($format) {
    case 'pdf':
        // Create PDF
        $dompdf = new Dompdf();
        $html = "<html><body><div style='font-family: Arial, sans-serif;'>" . nl2br(htmlspecialchars($content)) . "</div></body></html>";
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '.pdf"');
        echo $dompdf->output();
        break;

    case 'doc':
        // Create DOC
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $section->addText($content);
        
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '.docx"');
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output');
        break;

    case 'txt':
    default:
        // Create TXT
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="' . $filename . '.txt"');
        echo $content;
        break;
}