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
    if (empty($data['websiteId']) || empty($data['pageName'])) {
        throw new Exception('Missing required fields: websiteId or pageName');
    }
    
    $websiteId = $data['websiteId'];
    $pageName = $data['pageName'];
    $websiteDir = "generated_websites/$websiteId";
    
    // Check if website directory exists
    if (!file_exists($websiteDir)) {
        throw new Exception('Website directory not found');
    }
    
    // Build prompt for the specific page
    $prompt = buildPagePrompt($data, $pageName);
    
    // Call Gemini API
    $result = callGeminiAPI($prompt);
    
    if (!$result['success']) {
        throw new Exception('Failed to generate page: ' . $result['error']);
    }
    
    // Parse the response to extract filename and content
    $response = $result['data'];
    $parsedResult = parsePageResponse($response, $pageName);
    
    // Save the page file
    $filename = $parsedResult['filename'];
    $content = $parsedResult['content'];
    
    file_put_contents("$websiteDir/$filename", $content);
    
    echo json_encode([
        'success' => true,
        'filename' => $filename,
        'pageName' => $pageName,
        'websiteId' => $websiteId
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

function buildPagePrompt($data, $pageName, $metadata = []) {
    $websiteName = $data['websiteName'];
    $websiteType = $data['websiteType'];
    $ownerName = $data['ownerName'];
    $tagline = $data['tagline'] ?? '';
    $colorScheme = $data['colorScheme'] ?? 'modern';
    $layout = $data['layout'] ?? 'modern';
    
    // Get website type specific data
    $typeSpecificData = getWebsiteTypeDataForPage($data, $websiteType);
    
    // Get common data
    $email = $data['email'] ?? '';
    $phone = $data['phone'] ?? '';
    $location = $data['location'] ?? '';
    $linkedin = $data['linkedin'] ?? '';
    $github = $data['github'] ?? '';
    $twitter = $data['twitter'] ?? '';
    $instagram = $data['instagram'] ?? '';
    
    // Get tech stack from metadata or data
    $techStack = $metadata['techStack'] ?? $data['techStack'] ?? 'php-tailwind';
    $headerFile = $metadata['headerFile'] ?? 'header.php';
    $footerFile = $metadata['footerFile'] ?? 'footer.php';
    
    $prompt = "Generate a UNIQUE and CREATIVE '$pageName' page content for a $websiteType website. NO EXPLANATIONS. ONLY CODE.\n\n";
    
    $prompt .= "CREATIVITY REQUIREMENTS:\n";
    $prompt .= "- Make this page DISTINCTIVE and memorable for $websiteType\n";
    $prompt .= "- Use creative layouts that reflect the $websiteType nature\n";
    $prompt .= "- Avoid generic/template-like designs\n";
    $prompt .= "- Consider the $websiteType industry for design inspiration\n";
    $prompt .= "- Add unique interactive elements and animations suitable for $websiteType\n";
    $prompt .= "- Use creative color combinations and typography optimized for $websiteType\n";
    $prompt .= getPageTypeRequirements($websiteType, $pageName) . "\n\n";
    
    $prompt .= "DATA: $websiteName | $websiteType | $ownerName | $tagline | $email | $phone | $location | $linkedin | $github | $twitter | $instagram | $colorScheme | $layout\n";
    $prompt .= $typeSpecificData . "\n\n";
    
    $prompt .= "STRUCTURE:\n";
    $prompt .= "<?php include 'header.php'; ?>\n";
    $prompt .= "[PAGE CONTENT WITH TAILWIND CSS CLASSES]\n";
    $prompt .= "<?php include 'footer.php'; ?>\n\n";
    
    $prompt .= getPageSpecificInstructions($pageName, $websiteType);
    
    if ($techStack === 'html-bootstrap') {
        $prompt .= "STRUCTURE:\n";
        $prompt .= "<!DOCTYPE html>\n";
        $prompt .= "<html lang=\"en\">\n";
        $prompt .= "<head>\n";
        $prompt .= "    <!-- Copy head content from header.html -->\n";
        $prompt .= "</head>\n";
        $prompt .= "<body>\n";
        $prompt .= "    <!-- Copy navigation from header.html -->\n";
        $prompt .= "    \n";
        $prompt .= "    <!-- MAIN PAGE CONTENT WITH BOOTSTRAP 5 CLASSES -->\n";
        $prompt .= "    <main>\n";
        $prompt .= "        [SPECIFIC PAGE CONTENT HERE]\n";
        $prompt .= "    </main>\n";
        $prompt .= "    \n";
        $prompt .= "    <!-- Copy footer content from footer.html -->\n";
        $prompt .= "</body>\n";
        $prompt .= "</html>\n\n";
        
        $prompt .= "STRICT RULES:\n";
        $prompt .= "- FILENAME: " . ($pageName === 'home' ? 'index.html' : strtolower($pageName) . '.html') . "\n";
        $prompt .= "- Generate a COMPLETE standalone HTML page\n";
        $prompt .= "- Use ONLY Bootstrap 5 classes for styling\n";
        $prompt .= "- NO Tailwind, use custom CSS from style.css if needed\n";
        $prompt .= "- Mobile-first responsive design\n";
        $prompt .= "- Creative $colorScheme theme\n";
        $prompt .= "- Font Awesome icons\n";
        $prompt .= "- Bootstrap components and utilities\n";
        $prompt .= "- Semantic HTML5 elements\n";
        $prompt .= "- NO explanatory text\n";
        $prompt .= "- NO markdown code blocks\n";
        $prompt .= "- Start with FILENAME: then complete HTML code\n";
        $prompt .= "- Use provided data in content\n";
        $prompt .= "- Each page should be a complete, functional HTML file\n";
        $prompt .= "- Navigation should link to other pages (index.html, about.html, etc.)\n";
        $prompt .= "- MANDATORY: Use https://dummyimage.com/{width}x{height}/cccccc/000000&text=Description for ALL images\n";
        $prompt .= "- Add proper alt attributes and responsive classes\n";
        $prompt .= "- Use './' for ALL internal links\n";
    } else {
        $prompt .= "STRUCTURE:\n";
        $prompt .= "<?php include '$headerFile'; ?>\n";
        $prompt .= "[PAGE CONTENT WITH TAILWIND CSS CLASSES]\n";
        $prompt .= "<?php include '$footerFile'; ?>\n\n";
        
        $prompt .= "STRICT RULES:\n";
        $prompt .= "- FILENAME: " . ($pageName === 'home' ? 'index.php' : strtolower($pageName) . '.php') . "\n";
        $prompt .= "- Use ONLY Tailwind CSS classes\n";
        $prompt .= "- NO Bootstrap, NO custom CSS\n";
        $prompt .= "- Mobile-first responsive design\n";
        $prompt .= "- Creative $colorScheme theme\n";
        $prompt .= "- Font Awesome icons\n";
        $prompt .= "- Semantic HTML5 elements\n";
        $prompt .= "- NO explanatory text\n";
        $prompt .= "- NO markdown code blocks\n";
        $prompt .= "- Start with FILENAME: then raw code\n";
        $prompt .= "- Use provided data in content\n";
        $prompt .= "- MANDATORY: Use https://dummyimage.com/{width}x{height}/cccccc/000000&text=Description for ALL images\n";
        $prompt .= "- Add proper alt attributes and responsive classes\n";
        $prompt .= "- Use './' for ALL internal links\n";
    }
    
    return $prompt;
}

function getWebsiteTypeDataForPage($data, $websiteType) {
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

function getPageTypeRequirements($websiteType, $pageName) {
    $requirements = "";
    
    switch($websiteType) {
        case 'business':
            $requirements = "- Use professional business language and tone\n" .
                           "- Focus on credibility and trust-building\n" .
                           "- Include clear value propositions\n" .
                           "- Optimize for lead generation and conversions";
            break;
            
        case 'blog':
            $requirements = "- Use engaging and conversational tone\n" .
                           "- Focus on content readability and engagement\n" .
                           "- Include author personality and expertise\n" .
                           "- Optimize for content sharing and SEO";
            break;
            
        case 'landing':
            $requirements = "- Use persuasive and action-oriented language\n" .
                           "- Focus on single conversion goal\n" .
                           "- Include clear benefits and social proof\n" .
                           "- Optimize for maximum conversion rates";
            break;
            
        case 'portfolio':
        default:
            $requirements = "- Use creative and personal language\n" .
                           "- Focus on showcasing skills and personality\n" .
                           "- Include creative presentation elements\n" .
                           "- Optimize for professional opportunities";
            break;
    }
    
    return $requirements;
}

function getPageSpecificInstructions($pageName, $websiteType = 'portfolio') {
    $pageLower = strtolower($pageName);
    
    switch ($pageLower) {
        case 'home':
            return getHomePageInstructions($websiteType);
                   
        case 'about':
            return getAboutPageInstructions($websiteType);
                   
        case 'projects':
        case 'services':
        case 'portfolio':
            return getProjectsServicesInstructions($websiteType);
                   
        case 'contact':
            return getContactPageInstructions($websiteType);
                   
        case 'blog':
            return getBlogPageInstructions($websiteType);
            
        case 'team':
            return getTeamPageInstructions($websiteType);
            
        case 'categories':
            return getCategoriesPageInstructions($websiteType);
            
        case 'archive':
            return getArchivePageInstructions($websiteType);
                   
        case 'gallery':
            return "GALLERY PAGE CONTENT:\n" .
                   "- Image gallery grid\n" .
                   "- Image placeholders\n" .
                   "- Lightbox functionality\n" .
                   "- Categories/filters\n" .
                   "- Responsive image layout\n\n";
                   
        default:
            return "PAGE CONTENT:\n" .
                   "- Create appropriate content for the '$pageName' page\n" .
                   "- Make it relevant to the $websiteType website type\n" .
                   "- Include engaging and professional content\n\n";
    }
}

function getHomePageInstructions($websiteType) {
    switch($websiteType) {
        case 'business':
            return "HOME PAGE CONTENT:\n" .
                   "- Hero section with company name, value proposition, and CTA\n" .
                   "- Services overview with icons\n" .
                   "- Why choose us section\n" .
                   "- Client testimonials\n" .
                   "- Featured case studies or projects\n" .
                   "- Contact information and CTA\n" .
                   "- Trust indicators (certifications, awards)\n\n";
                   
        case 'blog':
            return "HOME PAGE CONTENT:\n" .
                   "- Hero section with blog title, tagline, and author intro\n" .
                   "- Featured/latest blog posts\n" .
                   "- Popular categories\n" .
                   "- About the author section\n" .
                   "- Newsletter signup\n" .
                   "- Social media links\n" .
                   "- Search functionality\n\n";
                   
        case 'landing':
            return "LANDING PAGE CONTENT:\n" .
                   "- Compelling hero section with main value proposition\n" .
                   "- Key benefits and features\n" .
                   "- Social proof (testimonials, reviews, logos)\n" .
                   "- Prominent call-to-action buttons\n" .
                   "- FAQ section\n" .
                   "- Pricing or offer details\n" .
                   "- Contact information\n\n";
                   
        case 'portfolio':
        default:
            return "HOME PAGE CONTENT:\n" .
                   "- Hero section with name, tagline, and call-to-action\n" .
                   "- Brief about section\n" .
                   "- Skills overview\n" .
                   "- Featured projects/work\n" .
                   "- Contact information\n" .
                   "- Social media links\n\n";
    }
}

function getAboutPageInstructions($websiteType) {
    switch($websiteType) {
        case 'business':
            return "ABOUT PAGE CONTENT:\n" .
                   "- Company story and mission\n" .
                   "- Company values and vision\n" .
                   "- Team introduction\n" .
                   "- Company achievements and milestones\n" .
                   "- Industry experience\n" .
                   "- Office/company photos\n" .
                   "- Call-to-action to contact or learn more\n\n";
                   
        case 'blog':
            return "ABOUT PAGE CONTENT:\n" .
                   "- Author bio and background\n" .
                   "- Why the blog was started\n" .
                   "- Blog topics and expertise\n" .
                   "- Author achievements and credentials\n" .
                   "- Personal interests and hobbies\n" .
                   "- Author photo\n" .
                   "- Contact information\n\n";
                   
        case 'landing':
            return "ABOUT PAGE CONTENT:\n" .
                   "- Company/product background\n" .
                   "- Problem we solve\n" .
                   "- Our solution approach\n" .
                   "- Team credentials\n" .
                   "- Success stories\n" .
                   "- Call-to-action\n\n";
                   
        case 'portfolio':
        default:
            return "ABOUT PAGE CONTENT:\n" .
                   "- Detailed bio/story\n" .
                   "- Professional background\n" .
                   "- Skills and expertise\n" .
                   "- Education/experience\n" .
                   "- Personal interests/hobbies\n" .
                   "- Professional photo placeholder\n\n";
    }
}

function getProjectsServicesInstructions($websiteType) {
    switch($websiteType) {
        case 'business':
            return "SERVICES PAGE CONTENT:\n" .
                   "- Service offerings with descriptions\n" .
                   "- Service benefits and features\n" .
                   "- Pricing information (if applicable)\n" .
                   "- Case studies and success stories\n" .
                   "- Process or methodology\n" .
                   "- Client testimonials\n" .
                   "- Contact form for inquiries\n\n";
                   
        case 'blog':
            return "PROJECTS PAGE CONTENT:\n" .
                   "- Writing projects and publications\n" .
                   "- Guest posts and collaborations\n" .
                   "- Speaking engagements\n" .
                   "- Awards and recognition\n" .
                   "- Media mentions\n" .
                   "- Portfolio of best articles\n\n";
                   
        case 'landing':
            return "FEATURES PAGE CONTENT:\n" .
                   "- Detailed feature breakdown\n" .
                   "- Benefits for each feature\n" .
                   "- Comparison with competitors\n" .
                   "- Use cases and examples\n" .
                   "- Screenshots or demos\n" .
                   "- Call-to-action buttons\n\n";
                   
        case 'portfolio':
        default:
            return "PROJECTS PAGE CONTENT:\n" .
                   "- Portfolio showcase\n" .
                   "- Project descriptions\n" .
                   "- Technologies used\n" .
                   "- Project images/screenshots placeholders\n" .
                   "- Links to live demos/repositories\n" .
                   "- Client testimonials\n\n";
    }
}

function getContactPageInstructions($websiteType) {
    switch($websiteType) {
        case 'business':
            return "CONTACT PAGE CONTENT:\n" .
                   "- Business contact form (name, email, company, service interest, message)\n" .
                   "- Office address and map\n" .
                   "- Business hours\n" .
                   "- Multiple contact methods (phone, email, chat)\n" .
                   "- Social media links\n" .
                   "- Response time expectations\n" .
                   "- Call-to-action for consultations\n\n";
                   
        case 'blog':
            return "CONTACT PAGE CONTENT:\n" .
                   "- Contact form for collaborations and inquiries\n" .
                   "- Speaking engagement requests\n" .
                   "- Guest post opportunities\n" .
                   "- Social media links\n" .
                   "- Email for direct contact\n" .
                   "- Response time information\n\n";
                   
        case 'landing':
            return "CONTACT PAGE CONTENT:\n" .
                   "- Lead capture form with qualification questions\n" .
                   "- Phone number for immediate contact\n" .
                   "- Live chat option\n" .
                   "- Support email\n" .
                   "- FAQ section\n" .
                   "- Conversion-focused messaging\n\n";
                   
        case 'portfolio':
        default:
            return "CONTACT PAGE CONTENT:\n" .
                   "- Contact form (name, email, subject, message)\n" .
                   "- Contact information display\n" .
                   "- Social media links\n" .
                   "- Location/address if provided\n" .
                   "- Professional email and phone\n" .
                   "- Call-to-action for getting in touch\n\n";
    }
}

function getBlogPageInstructions($websiteType) {
    return "BLOG PAGE CONTENT:\n" .
           "- Blog post listings with excerpts\n" .
           "- Sample blog posts relevant to the niche\n" .
           "- Categories and tags\n" .
           "- Search functionality\n" .
           "- Recent posts sidebar\n" .
           "- Author bio section\n" .
           "- Social sharing buttons\n" .
           "- Newsletter signup\n\n";
}

function getTeamPageInstructions($websiteType) {
    return "TEAM PAGE CONTENT:\n" .
           "- Team member profiles with photos\n" .
           "- Role descriptions and expertise\n" .
           "- Professional backgrounds\n" .
           "- Individual achievements\n" .
           "- Contact information for each member\n" .
           "- Team culture and values\n" .
           "- Join our team section\n\n";
}

function getCategoriesPageInstructions($websiteType) {
    return "CATEGORIES PAGE CONTENT:\n" .
           "- List of all blog categories\n" .
           "- Category descriptions\n" .
           "- Post counts for each category\n" .
           "- Featured posts from each category\n" .
           "- Search functionality\n" .
           "- Tag cloud\n\n";
}

function getArchivePageInstructions($websiteType) {
    return "ARCHIVE PAGE CONTENT:\n" .
           "- Chronological list of all posts\n" .
           "- Monthly/yearly groupings\n" .
           "- Post titles and dates\n" .
           "- Search and filter options\n" .
           "- Pagination for large archives\n" .
           "- Popular posts section\n\n";
}

function parsePageResponse($response, $pageName) {
    $result = [
        'filename' => strtolower($pageName) . '.php',
        'content' => ''
    ];
    
    // Extract filename if provided
    if (preg_match('/FILENAME:\s*([^\n]+)/i', $response, $matches)) {
        $result['filename'] = trim($matches[1]);
        // Remove the filename line from content
        $response = preg_replace('/FILENAME:\s*[^\n]+\n?/i', '', $response);
    }
    
    // Clean up the content
    $result['content'] = cleanCodeBlock(trim($response));
    
    // Ensure we have a valid filename
    if (empty($result['filename']) || $result['filename'] === '.php' || $result['filename'] === '.html') {
        // Determine file extension based on content
        $extension = (strpos($result['content'], '<?php') !== false) ? '.php' : '.html';
        $result['filename'] = strtolower($pageName) . $extension;
    }
    
    // Special case for home page
    if (strtolower($pageName) === 'home') {
        $result['filename'] = strpos($result['filename'], '.html') !== false ? 'index.html' : 'index.php';
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
