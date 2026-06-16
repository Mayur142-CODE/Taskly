<?php
header('Content-Type: application/json');
require_once 'config.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Get JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!$data) {
        throw new Exception('Invalid JSON data received');
    }
    
    // Validate required fields
    $requiredFields = ['websiteName', 'websiteType', 'ownerName'];
    foreach ($requiredFields as $field) {
        if (empty($data[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }
    
    // Generate unique website ID
    $websiteId = 'website_' . uniqid() . '_' . time();
    
    // Create website directory
    $websiteDir = "generated_websites/$websiteId";
    if (!file_exists('generated_websites')) {
        mkdir('generated_websites', 0755, true);
    }
    mkdir($websiteDir, 0755, true);
    
    // Create subdirectories
    $directories = ['css', 'js', 'images', 'assets'];
    foreach ($directories as $dir) {
        mkdir("$websiteDir/$dir", 0755, true);
    }
    
    // Build prompt for folder structure and common files
    $prompt = buildStructurePrompt($data);
    
    // Call Gemini API
    $result = callGeminiAPI($prompt);
    
    if (!$result['success']) {
        throw new Exception('Failed to generate website structure: ' . $result['error']);
    }
    
    // Parse the response to extract folder structure, header, and footer
    $response = $result['data'];
    $parsedResult = parseStructureResponse($response);
    
    // Save header.php
    file_put_contents("$websiteDir/header.php", $parsedResult['header']);
    
    // Save footer.php
    file_put_contents("$websiteDir/footer.php", $parsedResult['footer']);
    
    // Save main CSS file
    file_put_contents("$websiteDir/css/style.css", $parsedResult['css']);
    
    // Save main JS file if provided
    if (!empty($parsedResult['js'])) {
        file_put_contents("$websiteDir/js/script.js", $parsedResult['js']);
    }
    
    // Save website metadata
    $metadata = [
        'websiteId' => $websiteId,
        'websiteName' => $data['websiteName'],
        'websiteType' => $data['websiteType'],
        'ownerName' => $data['ownerName'],
        'createdAt' => date('Y-m-d H:i:s'),
        'pages' => $data['pages'] ?? ['home', 'about', 'projects', 'contact'],
        'folderStructure' => $parsedResult['folderStructure']
    ];
    
    file_put_contents("$websiteDir/metadata.json", json_encode($metadata, JSON_PRETTY_PRINT));
    
    echo json_encode([
        'success' => true,
        'websiteId' => $websiteId,
        'folderStructure' => $parsedResult['folderStructure'],
        'headerContent' => $parsedResult['header'],
        'footerContent' => $parsedResult['footer'],
        'cssContent' => $parsedResult['css']
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

function buildStructurePrompt($data) {
    $websiteName = $data['websiteName'];
    $websiteType = $data['websiteType'];
    $ownerName = $data['ownerName'];
    $tagline = $data['tagline'] ?? '';
    $colorScheme = $data['colorScheme'] ?? 'modern';
    $layout = $data['layout'] ?? 'modern';
    $pages = $data['pages'] ?? ['home', 'about', 'projects', 'contact'];
    $techStack = $data['techStack'] ?? 'php-tailwind';
    
    // Get website type specific data
    $typeSpecificData = getWebsiteTypeData($data, $websiteType);
    
    $prompt = "Generate a UNIQUE and CREATIVE website structure for a $websiteType website. NO EXPLANATIONS. ONLY CODE.\n\n";
    
    $prompt .= "DATA:\n";
    $prompt .= "Name: $websiteName | Type: $websiteType | Owner: $ownerName | Tagline: $tagline | Color: $colorScheme | Layout: $layout | Pages: " . implode(', ', $pages) . " | Tech: $techStack\n";
    $prompt .= $typeSpecificData . "\n\n";
    
    $prompt .= "CREATIVITY REQUIREMENTS:\n";
    $prompt .= "- Design should be UNIQUE and reflect the $websiteType nature\n";
    $prompt .= "- Use creative color combinations and layouts specific to $websiteType\n";
    $prompt .= "- Avoid generic/template-like designs\n";
    $prompt .= "- Make it memorable and distinctive for $websiteType audience\n";
    $prompt .= "- Consider the $websiteType industry when choosing design elements\n";
    $prompt .= "- Create custom animations and interactive elements suitable for $websiteType\n";
    $prompt .= getWebsiteTypeRequirements($websiteType) . "\n\n";
    
    if ($techStack === 'html-bootstrap') {
        $prompt .= "TECHNICAL REQUIREMENTS:\n";
        $prompt .= "- Use BOOTSTRAP 5 CSS (CDN link required)\n";
        $prompt .= "- NO Tailwind, use Bootstrap classes only\n";
        $prompt .= "- Generate pure HTML files (not PHP)\n";
        $prompt .= "- Responsive mobile-first design optimized for $websiteType\n";
        $prompt .= "- Font Awesome icons (CDN)\n";
        $prompt .= "- Bootstrap components and utilities\n";
        $prompt .= "- Clean semantic HTML5\n";
        $prompt .= "- Navigation links for all specified pages\n";
        $prompt .= "- Custom CSS for unique styling and animations suitable for $websiteType\n";
        $prompt .= "- Vanilla JavaScript for creative interactions\n";
        $prompt .= getWebsiteTypeNavigation($websiteType, 'html') . "\n\n";
    } else {
        $prompt .= "TECHNICAL REQUIREMENTS:\n";
        $prompt .= "- Use TAILWIND CSS (CDN link required)\n";
        $prompt .= "- NO Bootstrap, NO custom CSS beyond Tailwind utilities\n";
        $prompt .= "- Responsive mobile-first design optimized for $websiteType\n";
        $prompt .= "- Font Awesome icons (CDN)\n";
        $prompt .= "- Smooth hover effects using Tailwind\n";
        $prompt .= "- Clean semantic HTML5\n";
        $prompt .= "- Navigation links for all specified pages\n";
        $prompt .= getWebsiteTypeNavigation($websiteType, 'php') . "\n\n";
    }
    
    $prompt .= "PLACEHOLDER IMAGE REQUIREMENTS (CRITICAL):\n";
    $prompt .= "- MANDATORY: Use ONLY this format for ALL placeholder images:\n";
    $prompt .= "- https://dummyimage.com/{width}x{height}/cccccc/000000&text=Your+Text\n";
    $prompt .= "- Example: <img src='https://dummyimage.com/600x400/cccccc/000000&text=Hero+Image' alt='Hero Image' class='img-fluid'>\n";
    $prompt .= "- Example: <img src='https://dummyimage.com/300x300/cccccc/000000&text=Profile+Photo' alt='Profile Photo' class='rounded-circle'>\n";
    $prompt .= "- Use descriptive text for each placeholder (Hero+Image, Profile+Photo, Project+Screenshot, etc.)\n";
    $prompt .= "- Default image size: 600x400 if not specified\n";
    $prompt .= "- Color scheme: Gray background (#6c757d) with white text (#ffffff)\n";
    $prompt .= "- Add proper alt attributes and responsive classes\n";
    $prompt .= "- ALWAYS use './' for internal links and assets\n";
    $prompt .= "- Example link: <a href='./about.php'>About</a>\n\n";
    
    $prompt .= "OUTPUT FORMAT (NO EXPLANATIONS):\n\n";
    
    if ($techStack === 'html-bootstrap') {
        $prompt .= "FOLDER_STRUCTURE:\n";
        $prompt .= "website/\n├── header.html\n├── footer.html\n├── css/style.css\n├── js/script.js\n├── images/\n└── assets/\n\n";
        
        $prompt .= "HEADER_HTML:\n";
        $prompt .= "[Complete HTML document head section with DOCTYPE, meta tags optimized for $websiteType, Bootstrap 5 CDN, Font Awesome CDN, CSS link to './css/style.css', and UNIQUE responsive navigation bar designed for $websiteType with links to .html files]\n\n";
        
        $prompt .= "FOOTER_HTML:\n";
        $prompt .= "[Complete footer section with Bootstrap JavaScript CDN, copyright © 2025, and closing body/html tags. Footer should be appropriate for $websiteType]\n\n";
        
        $prompt .= "CSS_STYLE:\n";
        $prompt .= "[CREATIVE custom CSS with unique colors, animations, hover effects, and distinctive styling specifically designed for $websiteType that makes this website stand out in its category]\n\n";
        
        $prompt .= "JS_SCRIPT:\n";
        $prompt .= "[Creative vanilla JavaScript for unique interactions, animations, and Bootstrap enhancements suitable for $websiteType]\n\n";
        
        $prompt .= "CRITICAL:\n";
        $prompt .= "- NO explanatory text\n";
        $prompt .= "- NO markdown code blocks\n";
        $prompt .= "- ONLY raw code\n";
        $prompt .= "- Bootstrap 5 classes for styling\n";
        $prompt .= "- UNIQUE color scheme inspired by $colorScheme but specifically tailored for $websiteType\n";
        $prompt .= "- Creative navigation design appropriate for $websiteType\n";
        $prompt .= "- SEO meta tags in header optimized for $websiteType\n";
        $prompt .= "- MANDATORY: CSS link must be './css/style.css' (not './style.css')\n";
        $prompt .= "- MANDATORY: Navigation links must point to .html files based on selected pages\n";
        $prompt .= "- MANDATORY: Use https://dummyimage.com/{width}x{height}/cccccc/000000&text=Description for ALL images\n";
        $prompt .= "- MANDATORY: Use './' for ALL internal links\n";
        $prompt .= "- MANDATORY: Use copyright © 2025 (not 2024) in footer\n";
        $prompt .= "- Make it DISTINCTIVE and memorable for $websiteType audience\n";
    } else {
        $prompt .= "FOLDER_STRUCTURE:\n";
        $prompt .= "website/\n├── header.php\n├── footer.php\n├── css/style.css\n├── js/script.js\n├── images/\n└── assets/\n\n";
        
        $prompt .= "HEADER_PHP:\n";
        $prompt .= "[Complete header.php with DOCTYPE, meta tags optimized for $websiteType, Tailwind CDN, Font Awesome CDN, CSS link to './css/style.css', and UNIQUE responsive navigation designed for $websiteType with links to .php files]\n\n";
        
        $prompt .= "FOOTER_PHP:\n";
        $prompt .= "[Complete footer.php with closing tags, JavaScript, and copyright © 2025. Footer should be appropriate for $websiteType]\n\n";
        
        $prompt .= "CSS_STYLE:\n";
        $prompt .= "[CREATIVE custom CSS for unique animations and effects that Tailwind cannot handle - make it distinctive and specifically designed for $websiteType]\n\n";
        
        $prompt .= "JS_SCRIPT:\n";
        $prompt .= "[Creative JavaScript for unique interactions and smooth animations suitable for $websiteType]\n\n";
        
        $prompt .= "CRITICAL:\n";
        $prompt .= "- NO explanatory text\n";
        $prompt .= "- NO markdown code blocks\n";
        $prompt .= "- ONLY raw code\n";
        $prompt .= "- Creative Tailwind combinations suitable for $websiteType\n";
        $prompt .= "- UNIQUE color scheme inspired by $colorScheme but specifically tailored for $websiteType\n";
        $prompt .= "- Creative navigation design appropriate for $websiteType\n";
        $prompt .= "- SEO meta tags in header optimized for $websiteType\n";
        $prompt .= "- MANDATORY: CSS link must be './css/style.css' (not './style.css')\n";
        $prompt .= "- MANDATORY: Navigation links must point to .php files based on selected pages\n";
        $prompt .= "- MANDATORY: Use https://dummyimage.com/{width}x{height}/cccccc/000000&text=Description for ALL images\n";
        $prompt .= "- MANDATORY: Use './' for ALL internal links\n";
        $prompt .= "- Make it DISTINCTIVE and memorable for $websiteType audience\n";
    }
    
    return $prompt;
}

function getWebsiteTypeData($data, $websiteType) {
    $typeData = "";
    
    switch($websiteType) {
        case 'business':
            $typeData .= "Company: " . ($data['companyDescription'] ?? '') . " | ";
            $typeData .= "Industry: " . ($data['industry'] ?? '') . " | ";
            $typeData .= "Founded: " . ($data['foundedYear'] ?? '') . " | ";
            $typeData .= "Services: " . ($data['services'] ?? '') . " | ";
            $typeData .= "Team Size: " . ($data['teamSize'] ?? '') . " | ";
            $typeData .= "Hours: " . ($data['businessHours'] ?? '') . " | ";
            $typeData .= "Projects: " . ($data['businessProjects'] ?? '');
            break;
            
        case 'blog':
            $typeData .= "Blog About: " . ($data['blogDescription'] ?? '') . " | ";
            $typeData .= "Author: " . ($data['authorName'] ?? '') . " | ";
            $typeData .= "Niche: " . ($data['blogNiche'] ?? '') . " | ";
            $typeData .= "Categories: " . ($data['blogCategories'] ?? '') . " | ";
            $typeData .= "Frequency: " . ($data['postFrequency'] ?? '') . " | ";
            $typeData .= "Author Bio: " . ($data['authorBio'] ?? '') . " | ";
            $typeData .= "Topics: " . ($data['blogTopics'] ?? '');
            break;
            
        case 'landing':
            $typeData .= "Product/Service: " . ($data['landingDescription'] ?? '') . " | ";
            $typeData .= "CTA Text: " . ($data['ctaText'] ?? '') . " | ";
            $typeData .= "CTA URL: " . ($data['ctaUrl'] ?? '') . " | ";
            $typeData .= "Features: " . ($data['landingFeatures'] ?? '');
            break;
            
        case 'portfolio':
        default:
            $typeData .= "Bio: " . ($data['bio'] ?? '') . " | ";
            $typeData .= "Skills: " . ($data['skills'] ?? '') . " | ";
            $typeData .= "Projects: " . ($data['projects'] ?? '');
            break;
    }
    
    return $typeData;
}

function getWebsiteTypeRequirements($websiteType) {
    switch($websiteType) {
        case 'business':
            return "- Focus on professional corporate design\n" .
                   "- Emphasize trust, credibility, and expertise\n" .
                   "- Include clear service offerings and value propositions\n" .
                   "- Design for lead generation and conversions\n" .
                   "- Use professional color schemes and typography\n" .
                   "- Include testimonials and case study sections\n" .
                   "- Optimize for business inquiries and contact forms";
                   
        case 'blog':
            return "- Focus on content readability and engagement\n" .
                   "- Emphasize author personality and expertise\n" .
                   "- Include blog-specific navigation (categories, archives, search)\n" .
                   "- Design for content consumption and sharing\n" .
                   "- Use typography optimized for reading\n" .
                   "- Include social sharing and subscription features\n" .
                   "- Optimize for content discovery and SEO";
                   
        case 'landing':
            return "- Focus on single conversion goal\n" .
                   "- Emphasize clear value proposition and benefits\n" .
                   "- Include prominent call-to-action buttons\n" .
                   "- Design for maximum conversion rates\n" .
                   "- Use persuasive design elements and social proof\n" .
                   "- Include testimonials and feature highlights\n" .
                   "- Optimize for lead capture and sales";
                   
        case 'portfolio':
        default:
            return "- Focus on showcasing work and personality\n" .
                   "- Emphasize creative presentation and visual appeal\n" .
                   "- Include project galleries and case studies\n" .
                   "- Design for professional networking and opportunities\n" .
                   "- Use creative layouts and interactive elements\n" .
                   "- Include skills demonstration and achievements\n" .
                   "- Optimize for career opportunities and collaborations";
    }
}

function getWebsiteTypeNavigation($websiteType, $fileType) {
    $extension = $fileType === 'html' ? '.html' : '.php';
    
    switch($websiteType) {
        case 'business':
            return "- Navigation should include: Home, About Us, Services, Portfolio/Work, Team, Blog (optional), Contact\n" .
                   "- Use professional business terminology\n" .
                   "- Include clear call-to-action in navigation (Get Quote, Contact Us)\n" .
                   "- Consider dropdown menus for services if multiple offerings";
                   
        case 'blog':
            return "- Navigation should include: Home, About, Blog, Categories, Archive, Contact\n" .
                   "- Include search functionality in header\n" .
                   "- Consider tag cloud or category dropdown\n" .
                   "- Include RSS feed link and social media icons";
                   
        case 'landing':
            return "- Minimal navigation: Logo, About (optional), Contact (optional)\n" .
                   "- Focus on single conversion goal\n" .
                   "- Prominent CTA button in navigation\n" .
                   "- Consider sticky navigation with CTA";
                   
        case 'portfolio':
        default:
            return "- Navigation should include: Home, About, Projects/Portfolio, Skills, Contact\n" .
                   "- Include social media links in navigation\n" .
                   "- Consider creative navigation animations\n" .
                   "- Include resume/CV download link if applicable";
    }
}

function parseStructureResponse($response) {
    $result = [
        'folderStructure' => '',
        'header' => '',
        'footer' => '',
        'css' => '',
        'js' => ''
    ];
    
    // Extract folder structure (works for both HTML and PHP)
    if (preg_match('/FOLDER_STRUCTURE:\s*(.*?)\s*HEADER_(?:PHP|HTML):/s', $response, $matches)) {
        $result['folderStructure'] = trim($matches[1]);
    }
    
    // Extract header (PHP or HTML)
    if (preg_match('/HEADER_PHP:\s*(.*?)\s*FOOTER_PHP:/s', $response, $matches)) {
        $result['header'] = trim($matches[1]);
    } elseif (preg_match('/HEADER_HTML:\s*(.*?)\s*FOOTER_HTML:/s', $response, $matches)) {
        $result['header'] = trim($matches[1]);
    }
    
    // Extract footer (PHP or HTML)
    if (preg_match('/FOOTER_PHP:\s*(.*?)\s*CSS_STYLE:/s', $response, $matches)) {
        $result['footer'] = trim($matches[1]);
    } elseif (preg_match('/FOOTER_HTML:\s*(.*?)\s*CSS_STYLE:/s', $response, $matches)) {
        $result['footer'] = trim($matches[1]);
    }
    
    // Extract CSS
    if (preg_match('/CSS_STYLE:\s*(.*?)\s*JS_SCRIPT:/s', $response, $matches)) {
        $result['css'] = trim($matches[1]);
    } elseif (preg_match('/CSS_STYLE:\s*(.*?)$/s', $response, $matches)) {
        $result['css'] = trim($matches[1]);
    }
    
    // Extract JavaScript
    if (preg_match('/JS_SCRIPT:\s*(.*?)$/s', $response, $matches)) {
        $result['js'] = trim($matches[1]);
    }
    
    // Clean up code blocks
    foreach ($result as $key => $value) {
        if ($key !== 'folderStructure') {
            $result[$key] = cleanCodeBlock($value);
        }
    }
    
    return $result;
}

function cleanCodeBlock($content) {
    // Remove markdown code block wrappers
    $content = preg_replace('/```[a-zA-Z]*\s*/', '', $content);
    $content = preg_replace('/```\s*$/', '', $content);
    $content = trim($content);
    
    return $content;
}

?>
