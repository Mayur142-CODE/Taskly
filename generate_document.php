<?php
require_once 'config.php';

$topic = $_POST['topic'] ?? '';
$type = $_POST['type'] ?? 'Report';
$details = $_POST['details'] ?? '';
$length = $_POST['length'] ?? 'medium';
$style = $_POST['style'] ?? 'professional';
$template = $_POST['template'] ?? 'modern';

// Build comprehensive prompt for proper HTML formatting
$prompt = "Create a well-structured $type about: $topic\n\n";

if (!empty($details)) {
    $prompt .= "Additional requirements: $details\n\n";
}

$prompt .= "Document specifications:\n";
$prompt .= "- Type: $type\n";
$prompt .= "- Length: $length\n";
$prompt .= "- Writing style: $style\n\n";

$prompt .= "IMPORTANT: Format the output as clean HTML with proper structure:\n";
$prompt .= "- Use <h1> for main title\n";
$prompt .= "- Use <h2> for major sections\n";
$prompt .= "- Use <h3> for subsections\n";
$prompt .= "- Use <p> for paragraphs\n";
$prompt .= "- Use <strong> for emphasis\n";
$prompt .= "- Use <em> for italics\n";
$prompt .= "- Use <ul> and <li> for bullet points\n";
$prompt .= "- Use <ol> and <li> for numbered lists\n";
$prompt .= "- Do NOT use Markdown syntax (##, **, *, etc.)\n";
$prompt .= "- Do NOT use code blocks or backticks (```) \n";
$prompt .= "- Do NOT wrap content in ```html or ``` tags\n";
$prompt .= "- Return ONLY the HTML content, no code block wrappers\n";
$prompt .= "- Ensure proper paragraph spacing and professional formatting\n\n";

// Add length-specific instructions with strict word count requirements
switch ($length) {
    case 'short':
        $prompt .= "CRITICAL: Generate a SHORT document (EXACTLY 1-2 pages, 500-800 words):\n";
        $prompt .= "- 1 main title\n";
        $prompt .= "- Brief introduction (1-2 paragraphs, ~100-150 words)\n";
        $prompt .= "- 2-3 main sections with concise content (~150-200 words each)\n";
        $prompt .= "- Short conclusion (1 paragraph, ~100 words)\n";
        $prompt .= "- TOTAL TARGET: 500-800 words maximum\n";
        break;
    case 'medium':
        $prompt .= "CRITICAL: Generate a MEDIUM document (EXACTLY 3-5 pages, 1200-2000 words):\n";
        $prompt .= "- 1 main title\n";
        $prompt .= "- Introduction/Abstract (2-3 paragraphs, ~200-300 words)\n";
        $prompt .= "- 4-5 main sections with detailed content (~250-350 words each)\n";
        $prompt .= "- Comprehensive conclusion (2 paragraphs, ~200 words)\n";
        $prompt .= "- TOTAL TARGET: 1200-2000 words\n";
        break;
    case 'long':
        $prompt .= "CRITICAL: Generate a LONG document (EXACTLY 6-10 pages, 2500-4000 words):\n";
        $prompt .= "- 1 main title\n";
        $prompt .= "- Detailed introduction/Abstract (3-4 paragraphs, ~300-400 words)\n";
        $prompt .= "- 6-8 main sections with comprehensive content (~350-500 words each)\n";
        $prompt .= "- Multiple subsections within each main section (2-3 subsections per main section)\n";
        $prompt .= "- Detailed conclusion with recommendations (3-4 paragraphs, ~300-400 words)\n";
        $prompt .= "- Include examples, case studies, and detailed explanations\n";
        $prompt .= "- TOTAL TARGET: 2500-4000 words MINIMUM\n";
        $prompt .= "- ENSURE the document is comprehensive and fills 6-10 pages when printed\n";
        break;
}

$prompt .= "\nIMPORTANT REQUIREMENTS:\n";
$prompt .= "- Make it comprehensive, informative, and professionally written\n";
$prompt .= "- STRICTLY follow the word count requirements specified above\n";
$prompt .= "- If generating a LONG document, ensure it has substantial content that would fill 6-10 printed pages\n";
$prompt .= "- Include detailed explanations, examples, and comprehensive coverage of the topic\n";
$prompt .= "- Do not stop writing until you have reached the minimum word count requirement";

$result = callGeminiAPI($prompt);

if ($result['success']) {
    // Clean and format the HTML response
    $document = cleanAndFormatDocument($result['data']);
    
    echo json_encode([
        'success' => true,
        'document' => $document
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $result['error']
    ]);
}

function cleanAndFormatDocument($content) {
    // Remove HTML code block wrappers
    $content = preg_replace('/```html\s*/', '', $content);
    $content = preg_replace('/```\s*$/', '', $content);
    $content = preg_replace('/^```\s*/', '', $content);
    $content = str_replace('```', '', $content);
    
    // Remove any remaining backticks
    $content = str_replace('`', '', $content);
    
    // Convert any remaining Markdown to HTML
    $content = convertMarkdownToHtml($content);
    
    // Clean up HTML formatting
    $content = preg_replace('/\n\s*\n/', '</p><p>', $content);
    
    // Don't wrap everything in <p> tags if it already has proper HTML structure
    if (!preg_match('/<h[1-6]|<p>|<div>/', $content)) {
        $content = '<p>' . $content . '</p>';
    }
    
    $content = str_replace('<p></p>', '', $content);
    $content = str_replace('<p><h', '<h', $content);
    $content = str_replace('</h1></p>', '</h1>', $content);
    $content = str_replace('</h2></p>', '</h2>', $content);
    $content = str_replace('</h3></p>', '</h3>', $content);
    $content = str_replace('</h4></p>', '</h4>', $content);
    $content = str_replace('<p><ul>', '<ul>', $content);
    $content = str_replace('</ul></p>', '</ul>', $content);
    $content = str_replace('<p><ol>', '<ol>', $content);
    $content = str_replace('</ol></p>', '</ol>', $content);
    
    // Clean up extra whitespace
    $content = preg_replace('/\s+/', ' ', $content);
    $content = str_replace('> <', '><', $content);
    
    return trim($content);
}

function convertMarkdownToHtml($text) {
    // Convert Markdown headers to HTML
    $text = preg_replace('/^### (.*$)/m', '<h3>$1</h3>', $text);
    $text = preg_replace('/^## (.*$)/m', '<h2>$1</h2>', $text);
    $text = preg_replace('/^# (.*$)/m', '<h1>$1</h1>', $text);
    
    // Convert bold and italic
    $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);
    $text = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $text);
    
    // Convert bullet points
    $text = preg_replace('/^\* (.*$)/m', '<li>$1</li>', $text);
    $text = preg_replace('/(<li>.*<\/li>)/s', '<ul>$1</ul>', $text);
    
    // Convert numbered lists
    $text = preg_replace('/^\d+\. (.*$)/m', '<li>$1</li>', $text);
    
    return $text;
}