<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;
use Dompdf\Dompdf;
use Dompdf\Options;

try {

    $content = $_POST['content'] ?? '';
    $format = $_POST['format'] ?? 'pdf';
    $filename = $_POST['filename'] ?? 'document';
    $template = $_POST['template'] ?? 'modern';
    $toolName = $_POST['toolName'] ?? 'docgenx';

    // Generate proper filename with timestamp
    $timestamp = date('Y-m-d_H-i-s');
    $cleanFilename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $filename);
    $finalFilename = $toolName . '_' . $cleanFilename . '_' . $timestamp;

    switch ($format) {
        case 'pdf':
            try {
                // Configure Dompdf options
                $options = new Options();
                $options->set('defaultFont', 'Arial');
                $options->set('isRemoteEnabled', true);
                $options->set('isHtml5ParserEnabled', true);
                
                $dompdf = new Dompdf($options);
                
                // Clean and prepare HTML
                $cleanContent = cleanHtmlForPdf($content);
                $templateStyles = getTemplateStyles($template);
                $html = "
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset='UTF-8'>
                    <style>
                        {$templateStyles}
                        body { 
                            font-family: 'Times New Roman', serif; 
                            font-size: 12pt; 
                            line-height: 1.6; 
                            margin: 1in;
                            color: #333;
                            text-align: justify;
                        }
                        
                        /* Headings */
                        h1 { 
                            font-size: 20pt;
                            font-weight: bold;
                            text-align: center;
                            margin: 30px 0 20px 0;
                            color: #2c3e50;
                            page-break-after: avoid;
                            text-decoration: underline;
                        }
                        h2 { 
                            font-size: 16pt;
                            font-weight: bold;
                            margin: 25px 0 15px 0;
                            color: #34495e;
                            border-bottom: 2px solid #3498db;
                            padding-bottom: 5px;
                            page-break-after: avoid;
                        }
                        h3 { 
                            font-size: 14pt;
                            font-weight: bold;
                            margin: 20px 0 10px 0;
                            color: #34495e;
                            page-break-after: avoid;
                        }
                        h4, h5, h6 { 
                            font-size: 12pt;
                            font-weight: bold;
                            margin: 15px 0 8px 0;
                            color: #34495e;
                            page-break-after: avoid;
                        }
                        
                        /* Paragraphs */
                        p { 
                            margin: 12px 0;
                            text-indent: 0.5in;
                            text-align: justify;
                            line-height: 1.6;
                        }
                        
                        /* Lists */
                        ul { 
                            margin: 12px 0;
                            padding-left: 40px;
                            list-style-type: disc;
                        }
                        ol { 
                            margin: 12px 0;
                            padding-left: 40px;
                            list-style-type: decimal;
                        }
                        li { 
                            margin: 6px 0;
                            text-align: justify;
                            line-height: 1.5;
                        }
                        
                        /* Text formatting */
                        strong, b { 
                            font-weight: bold;
                            color: #2c3e50;
                        }
                        em, i { 
                            font-style: italic;
                            color: #555;
                        }
                        u { 
                            text-decoration: underline;
                        }
                        s, strike { 
                            text-decoration: line-through;
                        }
                        
                        /* Alignment classes */
                        .ql-align-center { text-align: center !important; text-indent: 0; }
                        .ql-align-right { text-align: right !important; text-indent: 0; }
                        .ql-align-justify { text-align: justify !important; }
                        .ql-align-left { text-align: left !important; text-indent: 0; }
                        
                        /* Font sizes */
                        .ql-size-small { font-size: 10pt; }
                        .ql-size-large { font-size: 14pt; }
                        .ql-size-huge { font-size: 18pt; }
                        
                        /* Colors */
                        .ql-color-red { color: #e74c3c; }
                        .ql-color-blue { color: #3498db; }
                        .ql-color-green { color: #27ae60; }
                        .ql-color-orange { color: #f39c12; }
                        .ql-color-purple { color: #9b59b6; }
                        
                        /* Background colors */
                        .ql-bg-yellow { background-color: #f1c40f; padding: 2px; }
                        .ql-bg-red { background-color: #e74c3c; color: white; padding: 2px; }
                        .ql-bg-blue { background-color: #3498db; color: white; padding: 2px; }
                        
                        /* Indentation */
                        .ql-indent-1 { margin-left: 30px; }
                        .ql-indent-2 { margin-left: 60px; }
                        .ql-indent-3 { margin-left: 90px; }
                        
                        /* Blockquotes */
                        blockquote {
                            margin: 15px 0;
                            padding: 10px 20px;
                            border-left: 4px solid #3498db;
                            background-color: #f8f9fa;
                            font-style: italic;
                        }
                        
                        /* Code blocks */
                        code {
                            background-color: #f4f4f4;
                            padding: 2px 4px;
                            font-family: 'Courier New', monospace;
                            font-size: 11pt;
                        }
                        
                        /* Tables */
                        table {
                            border-collapse: collapse;
                            width: 100%;
                            margin: 15px 0;
                        }
                        th, td {
                            border: 1px solid #ddd;
                            padding: 8px;
                            text-align: left;
                        }
                        th {
                            background-color: #f2f2f2;
                            font-weight: bold;
                        }
                        
                        /* Abstract/Introduction styling */
                        p:first-of-type {
                            font-weight: bold;
                            text-indent: 0;
                            margin-top: 20px;
                        }
                    </style>
                </head>
                <body>
                    {$cleanContent}
                </body>
                </html>";
                
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                
                // Clear any previous output
                if (ob_get_level()) {
                    ob_end_clean();
                }
                
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . $finalFilename . '.pdf"');
                header('Cache-Control: private, max-age=0, must-revalidate');
                header('Pragma: public');
                
                echo $dompdf->output();
                exit;
                
            } catch (Exception $e) {
                error_log("PDF Export Error: " . $e->getMessage());
                http_response_code(500);
                echo json_encode(['error' => 'PDF generation failed: ' . $e->getMessage()]);
            }
            break;

        case 'doc':
            try {
                $phpWord = new PhpWord();
                
                // Set document properties for better MS Word compatibility
                $properties = $phpWord->getDocInfo();
                $properties->setCreator('Taskly - AI Productivity Suite');
                $properties->setCompany('Taskly');
                $properties->setTitle($cleanFilename);
                $properties->setDescription('Generated by ' . ucfirst($toolName));
                $properties->setCategory('AI Generated Content');
                $properties->setLastModifiedBy('Taskly AI');
                $properties->setCreated(time());
                $properties->setModified(time());
                
                // Set document settings for better compatibility
                $phpWord->getSettings()->setThemeFontLang(new \PhpOffice\PhpWord\Style\Language('en-US'));
                $phpWord->getSettings()->setUpdateFields(true);
                $phpWord->getSettings()->setZoom(100);
                
                // Define styles based on template
                $wordStyles = getWordTemplateStyles($template);
                
                // Apply template-specific styles
                foreach ($wordStyles['fonts'] as $styleName => $styleConfig) {
                    $phpWord->addFontStyle($styleName, $styleConfig);
                }
                
                foreach ($wordStyles['paragraphs'] as $styleName => $styleConfig) {
                    $phpWord->addParagraphStyle($styleName, $styleConfig);
                }
                
                
                $section = $phpWord->addSection([
                    'marginTop' => 1440,    // 1 inch
                    'marginBottom' => 1440,
                    'marginLeft' => 1440,
                    'marginRight' => 1440,
                ]);
                
                // Convert HTML content to Word format with proper styling
                if (!empty($content)) {
                    // Clean content for Word
                    $cleanContent = cleanHtmlForWord($content);
                    
                    // Always use our custom formatting for better control
                    addFormattedContentToWord($section, $cleanContent);
                } else {
                    $section->addText('No content to export.', [
                        'size' => 12, 
                        'name' => 'Times New Roman',
                        'color' => '333333'
                    ]);
                }
                
                // Clear any previous output
                if (ob_get_level()) {
                    ob_end_clean();
                }
                
                header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                header('Content-Disposition: attachment; filename="' . $finalFilename . '.docx"');
                header('Cache-Control: private, max-age=0, must-revalidate');
                header('Pragma: public');
                
                $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
                $objWriter->save('php://output');
                exit;
                
            } catch (Exception $e) {
                error_log("Word Export Error: " . $e->getMessage());
                http_response_code(500);
                echo json_encode(['error' => 'Word document generation failed: ' . $e->getMessage()]);
            }
            break;
            
        default:
            http_response_code(400);
            echo json_encode(['error' => 'Unsupported format']);
            break;
    }

} catch (Exception $e) {
    error_log("Export Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Export failed: ' . $e->getMessage()]);
}

function cleanHtmlForPdf($html) {
    // Remove HTML code block wrappers
    $html = preg_replace('/```html\s*/', '', $html);
    $html = preg_replace('/```\s*$/', '', $html);
    $html = preg_replace('/^```\s*/', '', $html);
    $html = str_replace('```', '', $html);
    $html = str_replace('`', '', $html);
    
    // Remove Quill-specific classes and clean up HTML
    $html = preg_replace('/class="[^"]*ql-[^"]*"/', '', $html);
    $html = str_replace(['<p><br></p>', '<p></p>'], '', $html);
    $html = preg_replace('/<p>\s*<\/p>/', '', $html);
    
    // Convert any remaining markdown-style formatting
    $html = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $html);
    $html = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $html);
    $html = preg_replace('/^### (.*$)/m', '<h3>$1</h3>', $html);
    $html = preg_replace('/^## (.*$)/m', '<h2>$1</h2>', $html);
    $html = preg_replace('/^# (.*$)/m', '<h1>$1</h1>', $html);
    
    // Ensure proper paragraph structure
    $html = preg_replace('/\n\n+/', '</p><p>', $html);
    
    return $html;
}

function cleanHtmlForWord($html) {
    // Remove HTML code block wrappers
    $html = preg_replace('/```html\s*/', '', $html);
    $html = preg_replace('/```\s*$/', '', $html);
    $html = preg_replace('/^```\s*/', '', $html);
    $html = str_replace('```', '', $html);
    $html = str_replace('`', '', $html);
    
    // Clean HTML for Word compatibility
    $html = preg_replace('/class="[^"]*ql-[^"]*"/', '', $html);
    $html = str_replace(['<p><br></p>', '<p></p>'], '<p>&nbsp;</p>', $html);
    $html = preg_replace('/<span[^>]*>/', '', $html);
    $html = str_replace('</span>', '', $html);
    
    // Convert any remaining markdown-style formatting
    $html = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $html);
    $html = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $html);
    $html = preg_replace('/^### (.*$)/m', '<h3>$1</h3>', $html);
    $html = preg_replace('/^## (.*$)/m', '<h2>$1</h2>', $html);
    $html = preg_replace('/^# (.*$)/m', '<h1>$1</h1>', $html);
    
    return $html;
}

function addFormattedContentToWord($section, $html) {
    // Clean and prepare HTML
    $html = '<div>' . $html . '</div>';
    
    // Parse HTML and add formatted content to Word document
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    @$dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    
    $xpath = new DOMXPath($dom);
    
    // Try to find content in body first, then in div
    $contentNode = $xpath->query('//body')->item(0);
    if (!$contentNode) {
        $contentNode = $xpath->query('//div')->item(0);
    }
    
    if ($contentNode && $contentNode->hasChildNodes()) {
        parseNodeForWord($section, $contentNode);
    } else {
        // Enhanced fallback - parse HTML manually
        parseHtmlManually($section, $html);
    }
}

function parseHtmlManually($section, $html) {
    // Remove HTML tags but preserve structure for manual parsing
    $lines = explode("\n", $html);
    
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) continue;
        
        // Check for headings
        if (preg_match('/<h1[^>]*>(.*?)<\/h1>/i', $line, $matches)) {
            $section->addText($matches[1], 'titleStyle', 'titleParagraph');
            $section->addTextBreak(2);
        } elseif (preg_match('/<h2[^>]*>(.*?)<\/h2>/i', $line, $matches)) {
            $section->addText($matches[1], 'headingStyle', 'headingParagraph');
            $section->addTextBreak(1);
        } elseif (preg_match('/<h3[^>]*>(.*?)<\/h3>/i', $line, $matches)) {
            $section->addText($matches[1], [
                'size' => 14,
                'bold' => true,
                'name' => 'Times New Roman',
                'color' => '34495e'
            ]);
            $section->addTextBreak(1);
        } elseif (preg_match('/<p[^>]*>(.*?)<\/p>/i', $line, $matches)) {
            $text = strip_tags($matches[1]);
            if (!empty(trim($text))) {
                $textRun = $section->addTextRun('normalParagraph');
                
                // Parse inline formatting
                parseInlineFormatting($textRun, $matches[1]);
                $section->addTextBreak(1);
            }
        } elseif (preg_match('/<li[^>]*>(.*?)<\/li>/i', $line, $matches)) {
            $section->addListItem(strip_tags($matches[1]), 0, [
                'size' => 12,
                'name' => 'Times New Roman'
            ]);
        } else {
            // Plain text line
            $text = strip_tags($line);
            if (!empty(trim($text))) {
                $section->addText($text, [
                    'size' => 12,
                    'name' => 'Times New Roman'
                ]);
                $section->addTextBreak(1);
            }
        }
    }
}

function parseInlineFormatting($textRun, $html) {
    // Split text by HTML tags while preserving them
    $parts = preg_split('/(<[^>]+>)/', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
    
    $currentStyle = [
        'size' => 12,
        'name' => 'Times New Roman'
    ];
    
    foreach ($parts as $part) {
        if (preg_match('/<(\/?)(\w+)([^>]*)>/', $part, $matches)) {
            $isClosing = !empty($matches[1]);
            $tag = strtolower($matches[2]);
            $attributes = $matches[3];
            
            if (!$isClosing) {
                switch ($tag) {
                    case 'strong':
                    case 'b':
                        $currentStyle['bold'] = true;
                        $currentStyle['color'] = '2c3e50';
                        break;
                    case 'em':
                    case 'i':
                        $currentStyle['italic'] = true;
                        $currentStyle['color'] = '555555';
                        break;
                    case 'u':
                        $currentStyle['underline'] = 'single';
                        break;
                    case 's':
                    case 'strike':
                        $currentStyle['strikethrough'] = true;
                        break;
                    case 'span':
                        // Parse span attributes for colors, sizes, etc.
                        if (preg_match('/class="([^"]*)"/', $attributes, $classMatches)) {
                            $classes = explode(' ', $classMatches[1]);
                            foreach ($classes as $class) {
                                switch ($class) {
                                    case 'ql-color-red':
                                        $currentStyle['color'] = 'e74c3c';
                                        break;
                                    case 'ql-color-blue':
                                        $currentStyle['color'] = '3498db';
                                        break;
                                    case 'ql-color-green':
                                        $currentStyle['color'] = '27ae60';
                                        break;
                                    case 'ql-size-small':
                                        $currentStyle['size'] = 10;
                                        break;
                                    case 'ql-size-large':
                                        $currentStyle['size'] = 14;
                                        break;
                                    case 'ql-size-huge':
                                        $currentStyle['size'] = 18;
                                        break;
                                }
                            }
                        }
                        break;
                }
            } else {
                switch ($tag) {
                    case 'strong':
                    case 'b':
                        unset($currentStyle['bold']);
                        $currentStyle['color'] = '333333';
                        break;
                    case 'em':
                    case 'i':
                        unset($currentStyle['italic']);
                        $currentStyle['color'] = '333333';
                        break;
                    case 'u':
                        unset($currentStyle['underline']);
                        break;
                    case 's':
                    case 'strike':
                        unset($currentStyle['strikethrough']);
                        break;
                    case 'span':
                        // Reset to default style
                        $currentStyle = [
                            'size' => 12,
                            'name' => 'Times New Roman',
                            'color' => '333333'
                        ];
                        break;
                }
            }
        } else {
            // Regular text
            if (!empty(trim($part))) {
                $textRun->addText($part, $currentStyle);
            }
        }
    }
}

function parseNodeForWord($section, $node) {
    foreach ($node->childNodes as $child) {
        switch ($child->nodeName) {
            case 'h1':
                $section->addText($child->textContent, 'titleStyle', 'titleParagraph');
                $section->addTextBreak();
                break;
                
            case 'h2':
                $section->addText($child->textContent, 'headingStyle', 'headingParagraph');
                $section->addTextBreak();
                break;
                
            case 'h3':
                $section->addText($child->textContent, [
                    'size' => 14,
                    'bold' => true,
                    'name' => 'Times New Roman',
                    'color' => '34495e'
                ]);
                $section->addTextBreak();
                break;
                
            case 'p':
                if (trim($child->textContent)) {
                    $textRun = $section->addTextRun('normalParagraph');
                    parseInlineElements($textRun, $child);
                    $section->addTextBreak(1);
                }
                break;
                
            case 'ul':
                foreach ($child->childNodes as $li) {
                    if ($li->nodeName === 'li') {
                        $listItemRun = $section->addTextRun();
                        $listItemRun->addText('• ', ['size' => 12, 'name' => 'Times New Roman']);
                        parseInlineElements($listItemRun, $li);
                        $section->addTextBreak();
                    }
                }
                $section->addTextBreak();
                break;
                
            case 'ol':
                $counter = 1;
                foreach ($child->childNodes as $li) {
                    if ($li->nodeName === 'li') {
                        $listItemRun = $section->addTextRun();
                        $listItemRun->addText($counter . '. ', ['size' => 12, 'name' => 'Times New Roman']);
                        parseInlineElements($listItemRun, $li);
                        $section->addTextBreak();
                        $counter++;
                    }
                }
                $section->addTextBreak();
                break;
                
            case 'blockquote':
                $section->addText($child->textContent, [
                    'size' => 12,
                    'name' => 'Times New Roman',
                    'italic' => true,
                    'color' => '555555'
                ]);
                $section->addTextBreak();
                break;
                
            case 'code':
                $section->addText($child->textContent, [
                    'size' => 11,
                    'name' => 'Courier New',
                    'color' => '333333'
                ]);
                break;
                
            case '#text':
                if (trim($child->textContent)) {
                    $section->addText(trim($child->textContent), [
                        'size' => 12,
                        'name' => 'Times New Roman'
                    ]);
                }
                break;
                
            default:
                if ($child->hasChildNodes()) {
                    parseNodeForWord($section, $child);
                }
                break;
        }
    }
}

function parseInlineElements($textRun, $node) {
    foreach ($node->childNodes as $child) {
        switch ($child->nodeName) {
            case 'strong':
            case 'b':
                $textRun->addText($child->textContent, [
                    'bold' => true,
                    'size' => 12,
                    'name' => 'Times New Roman',
                    'color' => '2c3e50'
                ]);
                break;
                
            case 'em':
            case 'i':
                $textRun->addText($child->textContent, [
                    'italic' => true,
                    'size' => 12,
                    'name' => 'Times New Roman',
                    'color' => '555555'
                ]);
                break;
                
            case 'u':
                $textRun->addText($child->textContent, [
                    'underline' => 'single',
                    'size' => 12,
                    'name' => 'Times New Roman'
                ]);
                break;
                
            case 's':
            case 'strike':
                $textRun->addText($child->textContent, [
                    'strikethrough' => true,
                    'size' => 12,
                    'name' => 'Times New Roman'
                ]);
                break;
                
            case 'code':
                $textRun->addText($child->textContent, [
                    'size' => 11,
                    'name' => 'Courier New',
                    'color' => '333333'
                ]);
                break;
                
            case 'span':
                // Handle span with classes for colors, sizes, etc.
                $style = [
                    'size' => 12,
                    'name' => 'Times New Roman'
                ];
                
                if ($child->hasAttribute('class')) {
                    $classes = explode(' ', $child->getAttribute('class'));
                    foreach ($classes as $class) {
                        switch ($class) {
                            case 'ql-color-red':
                                $style['color'] = 'e74c3c';
                                break;
                            case 'ql-color-blue':
                                $style['color'] = '3498db';
                                break;
                            case 'ql-color-green':
                                $style['color'] = '27ae60';
                                break;
                            case 'ql-size-small':
                                $style['size'] = 10;
                                break;
                            case 'ql-size-large':
                                $style['size'] = 14;
                                break;
                            case 'ql-size-huge':
                                $style['size'] = 18;
                                break;
                        }
                    }
                }
                
                if ($child->hasChildNodes()) {
                    parseInlineElements($textRun, $child);
                } else {
                    $textRun->addText($child->textContent, $style);
                }
                break;
                
            case '#text':
                $textRun->addText($child->textContent, [
                    'size' => 12,
                    'name' => 'Times New Roman'
                ]);
                break;
                
            default:
                if ($child->hasChildNodes()) {
                    parseInlineElements($textRun, $child);
                } else {
                    $textRun->addText($child->textContent, [
                        'size' => 12,
                        'name' => 'Times New Roman'
                    ]);
                }
                break;
        }
    }
}

function convertHtmlToText($html) {
    // Convert basic HTML to formatted text
    $text = strip_tags($html, '<p><br><strong><em><u><h1><h2><h3><h4><h5><h6>');
    $text = str_replace(['<br>', '<br/>', '<br />'], "\n", $text);
    $text = preg_replace('/<p[^>]*>/', "\n", $text);
    $text = str_replace('</p>', "\n", $text);
    $text = preg_replace('/<h[1-6][^>]*>/', "\n\n", $text);
    $text = preg_replace('/<\/h[1-6]>/', "\n", $text);
    $text = strip_tags($text);
    $text = preg_replace('/\n{3,}/', "\n\n", $text);
    return trim($text);
}

function getTemplateStyles($template) {
    switch ($template) {
        case 'modern':
            return "
                /* Modern Business Template */
                body { 
                    font-family: 'Arial', sans-serif; 
                    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                }
                h1 { 
                    background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
                    color: white !important;
                    padding: 20px;
                    border-radius: 10px;
                    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
                }
                h2 { 
                    color: #667eea !important;
                    border-left: 5px solid #667eea;
                    padding-left: 15px;
                    background: rgba(102, 126, 234, 0.1);
                    padding: 10px 15px;
                }
            ";
            
        case 'academic':
            return "
                /* Academic Paper Template */
                body { 
                    font-family: 'Times New Roman', serif;
                    line-height: 2.0;
                }
                h1 { 
                    text-align: center;
                    text-transform: uppercase;
                    letter-spacing: 2px;
                    border-top: 3px solid #2c3e50;
                    border-bottom: 3px solid #2c3e50;
                    padding: 20px 0;
                }
                h2 { 
                    text-align: center;
                    font-variant: small-caps;
                    border-bottom: 1px solid #34495e;
                }
                p { text-indent: 0.75in; }
            ";
            
        case 'creative':
            return "
                /* Creative Layout Template */
                body { 
                    font-family: 'Georgia', serif;
                    background: linear-gradient(45deg, #ff9a9e 0%, #fecfef 50%, #fecfef 100%);
                }
                h1 { 
                    color: #e91e63 !important;
                    text-align: center;
                    font-size: 28pt !important;
                    text-shadow: 3px 3px 6px rgba(233, 30, 99, 0.3);
                    border: 3px dashed #e91e63;
                    padding: 25px;
                }
                h2 { 
                    color: #9c27b0 !important;
                    background: rgba(156, 39, 176, 0.1);
                    padding: 15px;
                    border-radius: 25px;
                    text-align: center;
                }
                p { 
                    background: rgba(255, 255, 255, 0.8);
                    padding: 15px;
                    border-radius: 10px;
                    margin: 15px 0;
                }
            ";
            
        case 'minimal':
            return "
                /* Minimal Clean Template */
                body { 
                    font-family: 'Helvetica', sans-serif;
                    color: #2c3e50;
                    background: #ffffff;
                }
                h1 { 
                    font-weight: 300 !important;
                    color: #2c3e50 !important;
                    border-bottom: 1px solid #ecf0f1;
                    padding-bottom: 10px;
                    text-decoration: none !important;
                }
                h2 { 
                    font-weight: 400 !important;
                    color: #34495e !important;
                    margin-top: 40px;
                    border: none !important;
                    text-decoration: none !important;
                }
                p { 
                    color: #7f8c8d;
                    text-indent: 0 !important;
                    margin: 20px 0;
                }
            ";
            
        case 'corporate':
            return "
                /* Corporate Formal Template */
                body { 
                    font-family: 'Arial', sans-serif;
                    background: #f8f9fa;
                }
                h1 { 
                    background: #1a237e;
                    color: white !important;
                    padding: 25px;
                    text-align: center;
                    margin: -1in -1in 30px -1in;
                    font-size: 24pt !important;
                }
                h2 { 
                    background: #3f51b5;
                    color: white !important;
                    padding: 12px 20px;
                    margin: 25px -20px 15px -20px;
                    border: none !important;
                }
                p { 
                    background: white;
                    padding: 15px;
                    border-left: 4px solid #3f51b5;
                    margin: 15px 0;
                }
            ";
            
        case 'technical':
            return "
                /* Technical Manual Template */
                body { 
                    font-family: 'Courier New', monospace;
                    background: #263238;
                    color: #eceff1;
                }
                h1 { 
                    background: #00bcd4;
                    color: #263238 !important;
                    padding: 20px;
                    font-family: 'Arial', sans-serif;
                    text-transform: uppercase;
                    letter-spacing: 3px;
                }
                h2 { 
                    color: #00bcd4 !important;
                    border-left: 5px solid #00bcd4;
                    padding-left: 15px;
                    background: rgba(0, 188, 212, 0.1);
                    font-family: 'Arial', sans-serif;
                }
                p { 
                    background: rgba(236, 239, 241, 0.05);
                    padding: 10px;
                    border: 1px solid #37474f;
                    font-size: 11pt;
                }
                code { 
                    background: #37474f;
                    color: #4caf50;
                    padding: 5px;
                }
            ";
            
        default:
            return ""; // Default styling (current)
    }
}

function getWordTemplateStyles($template) {
    switch ($template) {
        case 'modern':
            return [
                'fonts' => [
                    'titleStyle' => [
                        'size' => 22,
                        'bold' => true,
                        'name' => 'Arial',
                        'color' => '667eea'
                    ],
                    'headingStyle' => [
                        'size' => 16,
                        'bold' => true,
                        'name' => 'Arial',
                        'color' => '667eea'
                    ],
                    'normalStyle' => [
                        'size' => 12,
                        'name' => 'Arial'
                    ]
                ],
                'paragraphs' => [
                    'titleParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                        'spaceAfter' => 480,
                        'spaceBefore' => 240
                    ],
                    'headingParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT,
                        'spaceAfter' => 240,
                        'spaceBefore' => 360
                    ],
                    'normalParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH,
                        'spaceAfter' => 240,
                        'lineHeight' => 1.4
                    ]
                ]
            ];
            
        case 'academic':
            return [
                'fonts' => [
                    'titleStyle' => [
                        'size' => 20,
                        'bold' => true,
                        'name' => 'Times New Roman',
                        'color' => '2c3e50'
                    ],
                    'headingStyle' => [
                        'size' => 16,
                        'bold' => true,
                        'name' => 'Times New Roman',
                        'color' => '34495e',
                        'smallCaps' => true
                    ],
                    'normalStyle' => [
                        'size' => 12,
                        'name' => 'Times New Roman'
                    ]
                ],
                'paragraphs' => [
                    'titleParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                        'spaceAfter' => 480,
                        'spaceBefore' => 240
                    ],
                    'headingParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                        'spaceAfter' => 240,
                        'spaceBefore' => 360
                    ],
                    'normalParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH,
                        'spaceAfter' => 240,
                        'lineHeight' => 2.0,
                        'indentation' => ['firstLine' => 1080] // 0.75 inch
                    ]
                ]
            ];
            
        case 'creative':
            return [
                'fonts' => [
                    'titleStyle' => [
                        'size' => 24,
                        'bold' => true,
                        'name' => 'Georgia',
                        'color' => 'e91e63'
                    ],
                    'headingStyle' => [
                        'size' => 18,
                        'bold' => true,
                        'name' => 'Georgia',
                        'color' => '9c27b0'
                    ],
                    'normalStyle' => [
                        'size' => 12,
                        'name' => 'Georgia'
                    ]
                ],
                'paragraphs' => [
                    'titleParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                        'spaceAfter' => 600,
                        'spaceBefore' => 300
                    ],
                    'headingParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                        'spaceAfter' => 300,
                        'spaceBefore' => 400
                    ],
                    'normalParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH,
                        'spaceAfter' => 300,
                        'lineHeight' => 1.5
                    ]
                ]
            ];
            
        case 'minimal':
            return [
                'fonts' => [
                    'titleStyle' => [
                        'size' => 20,
                        'bold' => false,
                        'name' => 'Helvetica',
                        'color' => '2c3e50'
                    ],
                    'headingStyle' => [
                        'size' => 16,
                        'bold' => false,
                        'name' => 'Helvetica',
                        'color' => '34495e'
                    ],
                    'normalStyle' => [
                        'size' => 12,
                        'name' => 'Helvetica',
                        'color' => '7f8c8d'
                    ]
                ],
                'paragraphs' => [
                    'titleParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT,
                        'spaceAfter' => 360,
                        'spaceBefore' => 240
                    ],
                    'headingParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT,
                        'spaceAfter' => 240,
                        'spaceBefore' => 480
                    ],
                    'normalParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT,
                        'spaceAfter' => 300,
                        'lineHeight' => 1.6
                    ]
                ]
            ];
            
        case 'corporate':
            return [
                'fonts' => [
                    'titleStyle' => [
                        'size' => 24,
                        'bold' => true,
                        'name' => 'Arial',
                        'color' => 'ffffff'
                    ],
                    'headingStyle' => [
                        'size' => 16,
                        'bold' => true,
                        'name' => 'Arial',
                        'color' => 'ffffff'
                    ],
                    'normalStyle' => [
                        'size' => 12,
                        'name' => 'Arial'
                    ]
                ],
                'paragraphs' => [
                    'titleParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                        'spaceAfter' => 480,
                        'spaceBefore' => 240
                    ],
                    'headingParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT,
                        'spaceAfter' => 240,
                        'spaceBefore' => 360
                    ],
                    'normalParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH,
                        'spaceAfter' => 240,
                        'lineHeight' => 1.5
                    ]
                ]
            ];
            
        case 'technical':
            return [
                'fonts' => [
                    'titleStyle' => [
                        'size' => 20,
                        'bold' => true,
                        'name' => 'Arial',
                        'color' => '263238'
                    ],
                    'headingStyle' => [
                        'size' => 16,
                        'bold' => true,
                        'name' => 'Arial',
                        'color' => '00bcd4'
                    ],
                    'normalStyle' => [
                        'size' => 11,
                        'name' => 'Courier New',
                        'color' => '263238'
                    ]
                ],
                'paragraphs' => [
                    'titleParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                        'spaceAfter' => 480,
                        'spaceBefore' => 240
                    ],
                    'headingParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT,
                        'spaceAfter' => 240,
                        'spaceBefore' => 360
                    ],
                    'normalParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH,
                        'spaceAfter' => 200,
                        'lineHeight' => 1.3
                    ]
                ]
            ];
            
        default:
            // Default template (current styling)
            return [
                'fonts' => [
                    'titleStyle' => [
                        'size' => 20,
                        'bold' => true,
                        'name' => 'Times New Roman',
                        'color' => '2c3e50',
                        'underline' => 'single'
                    ],
                    'headingStyle' => [
                        'size' => 16,
                        'bold' => true,
                        'name' => 'Times New Roman',
                        'color' => '34495e',
                        'underline' => 'single'
                    ],
                    'normalStyle' => [
                        'size' => 12,
                        'name' => 'Times New Roman'
                    ]
                ],
                'paragraphs' => [
                    'titleParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                        'spaceAfter' => 480,
                        'spaceBefore' => 240
                    ],
                    'headingParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT,
                        'spaceAfter' => 240,
                        'spaceBefore' => 360
                    ],
                    'normalParagraph' => [
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH,
                        'spaceAfter' => 240,
                        'lineHeight' => 1.6,
                        'indentation' => ['firstLine' => 720]
                    ]
                ]
            ];
    }
}