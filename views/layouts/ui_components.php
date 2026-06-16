<?php
/**
 * Shared UI Components for Taskly - AI Productivity Suite
 * Ensures consistent design across all tools
 */

function renderToolHeader($toolName, $description, $iconClass, $badges = []) {
    $badgeHtml = '';
    foreach ($badges as $badge) {
        $badgeHtml .= '<span class="badge bg-' . $badge['color'] . '-subtle text-' . $badge['color'] . ' px-3 py-2">';
        $badgeHtml .= '<i class="' . $badge['icon'] . ' me-1"></i>' . $badge['text'];
        $badgeHtml .= '</span>';
    }
    
    return '
    <!-- Tool Header -->
    <div class="tool-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
                        <div class="bg-white bg-opacity-20 rounded-3 p-3">
                            <i class="' . $iconClass . ' fs-1"></i>
                        </div>
                    </div>
                    <h1 class="tool-title">' . $toolName . '</h1>
                    <p class="tool-description">' . $description . '</p>
                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                        ' . $badgeHtml . '
                    </div>
                </div>
            </div>
        </div>
    </div>';
}

function renderHowToUseGuide($steps) {
    $stepsHtml = '';
    foreach ($steps as $index => $step) {
        $stepNumber = $index + 1;
        $stepsHtml .= '
        <div class="col-md-3">
            <div class="text-center">
                <div class="icon-box bg-' . $step['color'] . '-subtle mb-3 mx-auto" style="width: 50px; height: 50px;">
                    <i class="' . $step['icon'] . ' text-' . $step['color'] . '"></i>
                </div>
                <h6 class="fw-bold text-dark">' . $stepNumber . '. ' . $step['title'] . '</h6>
                <small class="text-muted">' . $step['description'] . '</small>
            </div>
        </div>';
    }
    
    return '
    <!-- Usage Guide Section -->
    <div class="tool-content">
        <div class="container">
            <div class="tool-card mb-4">
                <div class="tool-card-header">
                    <h5 class="mb-0 d-flex align-items-center gap-2">
                        <i class="fas fa-info-circle text-info"></i>
                        How to Use This Tool
                    </h5>
                </div>
                <div class="tool-card-body">
                    <div class="row g-4">
                        ' . $stepsHtml . '
                    </div>
                </div>
            </div>
        </div>
    </div>';
}

function renderToolCard($title, $iconClass, $content, $additionalClasses = '') {
    return '
    <div class="tool-card ' . $additionalClasses . '">
        <div class="tool-card-header">
            <h5 class="mb-0 d-flex align-items-center gap-2">
                <i class="' . $iconClass . '"></i>
                ' . $title . '
            </h5>
        </div>
        <div class="tool-card-body">
            ' . $content . '
        </div>
    </div>';
}

function renderLoadingState($message = 'Processing your request...') {
    return '
    <div class="tool-card">
        <div class="tool-card-body text-center py-5">
            <div class="spinner-border text-primary mb-3" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted mb-0">' . $message . '</p>
        </div>
    </div>';
}

function renderInitialState($iconClass, $title, $description) {
    return '
    <div class="tool-card">
        <div class="tool-card-body text-center py-5">
            <i class="' . $iconClass . ' text-muted mb-3" style="font-size: 3rem;"></i>
            <h6 class="text-muted">' . $title . '</h6>
            <p class="text-muted small mb-0">' . $description . '</p>
        </div>
    </div>';
}

function renderFormField($type, $name, $label, $options = []) {
    $required = $options['required'] ?? false;
    $placeholder = $options['placeholder'] ?? '';
    $value = $options['value'] ?? '';
    $selectOptions = $options['options'] ?? [];
    $rows = $options['rows'] ?? 3;
    $classes = $options['classes'] ?? '';
    
    $requiredAttr = $required ? 'required' : '';
    $requiredLabel = $required ? ' *' : '';
    
    $fieldHtml = '';
    
    switch ($type) {
        case 'text':
        case 'email':
        case 'url':
        case 'number':
            $fieldHtml = '<input type="' . $type . '" class="form-control ' . $classes . '" id="' . $name . '" name="' . $name . '" placeholder="' . $placeholder . '" value="' . $value . '" ' . $requiredAttr . '>';
            break;
            
        case 'textarea':
            $fieldHtml = '<textarea class="form-control ' . $classes . '" id="' . $name . '" name="' . $name . '" rows="' . $rows . '" placeholder="' . $placeholder . '" ' . $requiredAttr . '>' . $value . '</textarea>';
            break;
            
        case 'select':
            $fieldHtml = '<select class="form-select ' . $classes . '" id="' . $name . '" name="' . $name . '" ' . $requiredAttr . '>';
            foreach ($selectOptions as $optValue => $optLabel) {
                $selected = ($value == $optValue) ? 'selected' : '';
                $fieldHtml .= '<option value="' . $optValue . '" ' . $selected . '>' . $optLabel . '</option>';
            }
            $fieldHtml .= '</select>';
            break;
    }
    
    return '
    <div class="mb-3">
        <label for="' . $name . '" class="form-label fw-medium text-dark">' . $label . $requiredLabel . '</label>
        ' . $fieldHtml . '
    </div>';
}

function renderActionButton($text, $iconClass, $type = 'submit', $color = 'primary', $size = 'lg', $additionalClasses = '') {
    return '
    <button type="' . $type . '" class="btn btn-' . $color . ' btn-' . $size . ' ' . $additionalClasses . '">
        <i class="' . $iconClass . ' me-2"></i>
        <span>' . $text . '</span>
    </button>';
}

function renderResultsHeader($title, $copyButtonId = null) {
    $copyButton = '';
    if ($copyButtonId) {
        $copyButton = '
        <button onclick="copyAllContent()" id="' . $copyButtonId . '" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-copy me-1"></i>Copy All
        </button>';
    }
    
    return '
    <div class="tool-card-header bg-transparent border-bottom">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark">' . $title . '</h5>
            ' . $copyButton . '
        </div>
    </div>';
}

// Common CSS for all tools
function getCommonToolStyles() {
    return '
    <style>
    /* Tool Header Styles */
    .tool-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 4rem 0 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .tool-header::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.05\'%3E%3Ccircle cx=\'30\' cy=\'30\' r=\'4\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    .tool-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    
    .tool-description {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    
    /* Tool Content Styles */
    .tool-content {
        padding: 0 0 4rem;
    }
    
    .tool-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: none;
        margin-bottom: 2rem;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .tool-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .tool-card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem;
        border-bottom: 1px solid #dee2e6;
    }
    
    .tool-card-body {
        padding: 2rem;
    }
    
    /* Form Styles */
    .form-label {
        color: #495057;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }
    
    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 0.75rem;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        transform: translateY(-2px);
    }
    
    /* Button Styles */
    .btn {
        border-radius: 0.75rem;
        font-weight: 600;
        padding: 0.875rem 2rem;
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
    }
    
    .btn-info {
        background: linear-gradient(135deg, #06beb6 0%, #48b1bf 100%);
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    
    /* Icon Box Styles */
    .icon-box {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 1rem;
        transition: all 0.3s ease;
    }
    
    .icon-box:hover {
        transform: scale(1.1);
    }
    
    /* Loading and States */
    .spinner-border {
        width: 3rem;
        height: 3rem;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .tool-header {
            padding: 2rem 0 1rem;
        }
        
        .tool-title {
            font-size: 2rem;
        }
        
        .tool-description {
            font-size: 1rem;
        }
        
        .tool-card-body {
            padding: 1.5rem;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
        }
    }
    
    @media (max-width: 576px) {
        .tool-card-body {
            padding: 1rem;
        }
        
        .tool-title {
            font-size: 1.75rem;
        }
        
        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
    </style>';
}
?>
