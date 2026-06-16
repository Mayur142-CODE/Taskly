<?php
// Gemini API Configuration
define('GEMINI_API_KEY', 'AIzaSyAJgHYnjxUX-V1bmJBosHSqnRPdjbuv-PU');
define('GEMINI_API_ENDPOINT', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-thinking-exp-01-21:generateContent');

// 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-thinking-exp-01-21:generateContent');

/**
 * 
 * Call Gemini API with the given prompt
 * @return array ['success' => bool, 'data' => string|null, 'error' => string|null]
 */
function callGeminiAPI($prompt) {
    if (empty($prompt)) {
        return [
            'success' => false,
            'data' => null,
            'error' => 'Prompt cannot be empty'
        ];
    }

    $ch = curl_init(GEMINI_API_ENDPOINT);
    
    $data = [
        'contents' => [
            [
                'parts' => [
                    [
                        'text' => $prompt
                    ]
                ]
            ]
        ]
    ];
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'X-goog-api-key: ' . GEMINI_API_KEY
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    // Check for cURL errors
    if ($curlError) {
        return [
            'success' => false,
            'data' => null,
            'error' => 'API Connection Error: ' . $curlError
        ];
    }

    // Check HTTP response code
    if ($httpCode !== 200) {
        $errorMessage = 'API Error: ';
        switch ($httpCode) {
            case 400:
                $errorMessage .= 'Bad Request - The API request was invalid';
                break;
            case 401:
                $errorMessage .= 'Unauthorized - Invalid API key or authentication failed';
                break;
            case 403:
                $errorMessage .= 'Forbidden - The API key doesn\'t have permission to access this resource';
                break;
            case 429:
                $errorMessage .= 'Too Many Requests - API rate limit exceeded';
                break;
            case 500:
                $errorMessage .= 'Internal Server Error - Something went wrong on Google\'s servers';
                break;
            case 503:
                $errorMessage .= 'Service Unavailable - Gemini API is temporarily unavailable';
                break;
            default:
                $errorMessage .= 'HTTP Status ' . $httpCode . ' - ' . print_r(json_decode($response, true), true);
        }
        
        return [
            'success' => false,
            'data' => null,
            'error' => $errorMessage
        ];
    }

    $result = json_decode($response, true);

    // Check if response is valid JSON
    if (json_last_error() !== JSON_ERROR_NONE) {
        return [
            'success' => false,
            'data' => null,
            'error' => 'Invalid API Response Format'
        ];
    }

    // Check if response has the expected structure
    if (!isset($result['candidates'][0]['content']['parts'][0]['text'])) {
        return [
            'success' => false,
            'data' => null,
            'error' => 'Unexpected API Response Structure'
        ];
    }

    return [
        'success' => true,
        'data' => $result['candidates'][0]['content']['parts'][0]['text'],
        'error' => null
    ];
}