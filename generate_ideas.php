<?php
require_once 'config.php';

$topic = $_POST['topic'] ?? '';
$category = $_POST['category'] ?? '';
$audience = $_POST['audience'] ?? '';
$count = intval($_POST['count'] ?? 10);

// Ensure count is within valid range
$count = max(5, min(20, $count));

$prompt = "Generate exactly $count comprehensive and innovative ideas about: $topic\n\n";
if (!empty($category)) {
    $prompt .= "Category/Industry: $category\n";
}
if (!empty($audience)) {
    $prompt .= "Target Audience: $audience\n";
}
$prompt .= "\n";
$prompt .= "For each idea, provide:\n";
$prompt .= "1. **Idea Title**: A catchy, concise title\n";
$prompt .= "2. **Details**: A comprehensive explanation of the idea (4-6 sentences covering market opportunity, target audience, unique value proposition, and potential impact)\n";
$prompt .= "3. **Practical Steps**: 5-7 detailed actionable steps to implement this idea (format as numbered list with specific actions)\n\n";
$prompt .= "Format each idea as follows:\n";
$prompt .= "IDEA: [Title]\n";
$prompt .= "DETAILS: [Detailed explanation]\n";
$prompt .= "PRACTICAL:\n";
$prompt .= "1. [First detailed step]\n";
$prompt .= "2. [Second detailed step]\n";
$prompt .= "3. [Third detailed step]\n";
$prompt .= "4. [Fourth detailed step]\n";
$prompt .= "5. [Fifth detailed step]\n";
$prompt .= "6. [Sixth detailed step]\n";
$prompt .= "7. [Seventh detailed step if needed]\n";
$prompt .= "---\n\n";
$prompt .= "Make sure each idea is unique, creative, and actionable. Provide comprehensive details and specific, actionable steps. Each idea should be substantial and well-developed with detailed explanations and thorough implementation plans.";

$maxRetries = 3;
$attempt = 0;
$parsedIdeas = [];

while ($attempt < $maxRetries && count($parsedIdeas) < $count) {
    $attempt++;
    
    $result = callGeminiAPI($prompt);
    
    if ($result['success']) {
        // Parse the response to extract structured ideas
        $rawIdeas = $result['data'];
        $parsedIdeas = parseStructuredIdeas($rawIdeas, $count);
        
        // If we don't have enough ideas, modify prompt for retry
        if (count($parsedIdeas) < $count && $attempt < $maxRetries) {
            $remaining = $count - count($parsedIdeas);
            $prompt = "Generate exactly $remaining additional comprehensive and innovative ideas about: $topic\n\n";
            if (!empty($category)) {
                $prompt .= "Category/Industry: $category\n";
            }
            if (!empty($audience)) {
                $prompt .= "Target Audience: $audience\n";
            }
            $prompt .= "\nMake sure each idea is unique and different from previous suggestions.\n\n";
            $prompt .= "For each idea, provide:\n";
            $prompt .= "1. **Idea Title**: A catchy, concise title\n";
            $prompt .= "2. **Details**: A comprehensive explanation of the idea (4-6 sentences covering market opportunity, target audience, unique value proposition, and potential impact)\n";
            $prompt .= "3. **Practical Steps**: 5-7 detailed actionable steps to implement this idea (format as numbered list with specific actions)\n\n";
            $prompt .= "Format each idea as follows:\n";
            $prompt .= "IDEA: [Title]\n";
            $prompt .= "DETAILS: [Detailed explanation]\n";
            $prompt .= "PRACTICAL:\n";
            $prompt .= "1. [First detailed step]\n";
            $prompt .= "2. [Second detailed step]\n";
            $prompt .= "3. [Third detailed step]\n";
            $prompt .= "4. [Fourth detailed step]\n";
            $prompt .= "5. [Fifth detailed step]\n";
            $prompt .= "6. [Sixth detailed step]\n";
            $prompt .= "7. [Seventh detailed step if needed]\n";
            $prompt .= "---\n\n";
            continue;
        }
        
        break;
    } else {
        if ($attempt >= $maxRetries) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => $result['error']
            ]);
            exit;
        }
    }
}

// Ensure we have the requested number of ideas
if (count($parsedIdeas) < $count) {
    // Fill remaining slots with placeholder ideas if needed
    $remaining = $count - count($parsedIdeas);
    for ($i = 0; $i < $remaining; $i++) {
        $parsedIdeas[] = [
            'title' => 'Additional Creative Idea #' . (count($parsedIdeas) + 1),
            'details' => 'This is an innovative concept related to ' . $topic . ' that requires further exploration and development. Consider market research, feasibility analysis, and resource requirements.',
            'practical' => '1. Research the market and competition\n2. Define target audience and value proposition\n3. Create a detailed business plan\n4. Develop a prototype or proof of concept\n5. Test with potential users and gather feedback\n6. Refine the concept based on insights\n7. Plan for implementation and launch'
        ];
    }
}

// Limit to requested count
$parsedIdeas = array_slice($parsedIdeas, 0, $count);

echo json_encode([
    'success' => true,
    'ideas' => $parsedIdeas,
    'count' => count($parsedIdeas),
    'requested' => $count
]);

function parseStructuredIdeas($rawText, $expectedCount = 5) {
    $ideas = [];
    $sections = explode('---', $rawText);
    
    foreach ($sections as $section) {
        $section = trim($section);
        if (empty($section)) continue;
        
        $idea = [];
        
        // Extract IDEA
        if (preg_match('/IDEA:\s*(.+?)(?=DETAILS:|$)/s', $section, $matches)) {
            $idea['title'] = trim($matches[1]);
        }
        
        // Extract DETAILS
        if (preg_match('/DETAILS:\s*(.+?)(?=PRACTICAL:|$)/s', $section, $matches)) {
            $idea['details'] = trim($matches[1]);
        }
        
        // Extract PRACTICAL
        if (preg_match('/PRACTICAL:\s*(.+?)$/s', $section, $matches)) {
            $idea['practical'] = trim($matches[1]);
        }
        
        // Only add if we have all three components
        if (isset($idea['title']) && isset($idea['details']) && isset($idea['practical'])) {
            $ideas[] = $idea;
        }
    }
    
    // Fallback: if parsing fails, create simple ideas from lines
    if (empty($ideas)) {
        $lines = explode('\n', $rawText);
        $lines = array_filter($lines, function($line) {
            return !empty(trim($line)) && !preg_match('/^(IDEA:|DETAILS:|PRACTICAL:|---)/', $line);
        });
        
        foreach (array_slice($lines, 0, $expectedCount) as $index => $line) {
            $ideas[] = [
                'title' => trim($line) ?: 'Creative Idea #' . ($index + 1),
                'details' => 'This is a creative idea that needs further development and market research.',
                'practical' => '1. Research the concept thoroughly\n2. Analyze market potential and competition\n3. Create a detailed implementation plan\n4. Gather necessary resources and team\n5. Develop a prototype or minimum viable product\n6. Test with target audience and iterate\n7. Launch and monitor performance'
            ];
        }
    }
    
    // Ensure we don't exceed expected count
    if (count($ideas) > $expectedCount) {
        $ideas = array_slice($ideas, 0, $expectedCount);
    }
    
    return $ideas;
}