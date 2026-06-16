<?php
require_once 'config.php';

$topic = $_POST['topic'] ?? '';
$contentType = $_POST['contentType'] ?? 'topic';
$content = $_POST['content'] ?? '';
$style = $_POST['style'] ?? 'detailed';

// Build the prompt based on input type and style
$prompt = "Generate study notes for the following topic: $topic\n\n";

if ($contentType === 'syllabus') {
    $prompt .= "Based on this syllabus:\n$content\n\n";
} elseif ($contentType === 'text') {
    $prompt .= "Based on this content:\n$content\n\n";
}

// Add style instructions with HTML formatting
switch ($style) {
    case 'summary':
        $prompt .= "Please provide a concise summary with key points and main concepts.";
        break;
    case 'bullet':
        $prompt .= "Please format the notes as bullet points, organized by main topics and subtopics.";
        break;
    case 'qa':
        $prompt .= "Please format the notes as a series of important questions and their detailed answers.";
        break;
    default: // detailed
        $prompt .= "Please provide detailed notes including definitions, explanations, examples, and key concepts.";
}

$prompt .= "\n\nPlease include:\n";
$prompt .= "- Clear headings and subheadings\n";
$prompt .= "- Important definitions and concepts\n";
$prompt .= "- Examples where applicable\n";
$prompt .= "- Key points to remember\n";
$prompt .= "- Bullet points for lists\n";
$prompt .= "- Bold text for important terms\n";
$prompt .= "- Italic text for emphasis\n\n";

$prompt .= "IMPORTANT: Format your response using proper HTML tags:\n";
$prompt .= "- Use <h1> for main title\n";
$prompt .= "- Use <h2> for major sections\n";
$prompt .= "- Use <h3> for subsections\n";
$prompt .= "- Use <p> for paragraphs\n";
$prompt .= "- Use <ul> and <li> for bullet points\n";
$prompt .= "- Use <ol> and <li> for numbered lists\n";
$prompt .= "- Use <strong> for important terms\n";
$prompt .= "- Use <em> for emphasis\n";
$prompt .= "- Use <u> for underlined text\n";
$prompt .= "- Make sure all HTML tags are properly closed\n\n";

$prompt .= "CRITICAL: Do NOT use markdown code blocks like ```html or ```. Provide the HTML content directly without any markdown formatting or code block indicators.\n\n";

$prompt .= "Structure the notes with clear sections and make them visually appealing with proper formatting.";

$result = callGeminiAPI($prompt);

if ($result['success']) {
    // Clean the generated content to remove markdown code blocks
    $cleanedNotes = cleanGeneratedContent($result['data']);
    
    echo json_encode([
        'success' => true,
        'notes' => $cleanedNotes
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $result['error']
    ]);
}

function cleanGeneratedContent($content) {
    // Remove markdown code blocks (various formats)
    $content = preg_replace('/```html\s*\n?/', '', $content);
    $content = preg_replace('/```HTML\s*\n?/', '', $content);
    $content = preg_replace('/```\s*\n?/', '', $content);
    
    // Remove any remaining markdown code indicators
    $content = preg_replace('/^```.*$/m', '', $content);
    
    // Remove backticks at start/end of content
    $content = preg_replace('/^`+/', '', $content);
    $content = preg_replace('/`+$/', '', $content);
    
    // Remove any "html" text that might be left over
    $content = preg_replace('/^html\s*\n?/i', '', $content);
    
    // Clean up extra whitespace and newlines
    $content = preg_replace('/\n{3,}/', "\n\n", $content);
    $content = preg_replace('/^\s+/', '', $content);
    
    // Trim leading and trailing whitespace
    $content = trim($content);
    
    return $content;
}