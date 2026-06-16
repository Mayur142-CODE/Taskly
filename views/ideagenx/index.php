<?php
// IdeaGenX - AI-Powered Creative Idea Generation
require_once __DIR__ . '/../layouts/ui_components.php';



// Define how-to-use steps
$howToSteps = [
    ['color' => 'primary', 'icon' => 'fas fa-edit', 'title' => 'Enter Topic', 'description' => 'Describe your project, challenge, or area of interest'],
    ['color' => 'success', 'icon' => 'fas fa-cog', 'title' => 'Choose Category', 'description' => 'Select idea category and target audience'],
    ['color' => 'warning', 'icon' => 'fas fa-sliders-h', 'title' => 'Set Quantity', 'description' => 'Choose how many ideas you want (5-20)'],
    ['color' => 'info', 'icon' => 'fas fa-lightbulb', 'title' => 'Generate', 'description' => 'AI creates innovative ideas with implementation steps']
];

// echo renderToolHeader($toolName, $description, $iconClass, $badges);
echo renderHowToUseGuide($howToSteps);
echo getCommonToolStyles();
?>

<div class="tool-content">
    <div class="container">
        <div class="row g-4">
            <!-- Left Panel - Input Form -->
            <div class="col-lg-6">
                <?php echo renderToolCard('Generate Ideas', 'fas fa-edit text-info', '
                
                <form id="ideaForm">
                    <div class="mb-3">
                        <label class="form-label fw-medium text-dark">Topic / Subject</label>
                        <input type="text" 
                               name="topic" 
                               class="form-control" 
                               placeholder="e.g., Business idea for college students, App features, Marketing strategies..."
                               required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium text-dark">Industry / Category</label>
                        <select name="category" class="form-select">
                            <option value="">Select category (optional)...</option>
                            <option value="business">Business & Entrepreneurship</option>
                            <option value="technology">Technology & Apps</option>
                            <option value="marketing">Marketing & Advertising</option>
                            <option value="education">Education & Learning</option>
                            <option value="health">Health & Wellness</option>
                            <option value="entertainment">Entertainment & Media</option>
                            <option value="environment">Environment & Sustainability</option>
                            <option value="social">Social Impact</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium text-dark">Target Audience</label>
                        <input type="text" 
                               name="audience" 
                               class="form-control" 
                               placeholder="e.g., College students, Small businesses, Parents...">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-medium text-dark">Number of Ideas</label>
                        <select name="count" class="form-select">
                            <option value="5">5 Ideas</option>
                            <option value="10" selected>10 Ideas</option>
                            <option value="15">15 Ideas</option>
                            <option value="20">20 Ideas</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-info w-100 d-flex align-items-center justify-content-center gap-2">
                        <i class="fas fa-lightbulb"></i>
                        <span>Generate Ideas</span>
                    </button>
                </form>
                '); ?>
            </div>

            <!-- Right Panel - Output -->
            <div class="col-lg-6">
                <!-- Generated Ideas Output -->
                <div id="ideasOutput" class="d-none">
                    <?php echo renderToolCard('Generated Ideas', 'fas fa-lightbulb text-success', '
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Click on any idea to copy it</span>
                            <button onclick="copyAllIdeas()" id="copyAllButton" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-copy me-1"></i>Copy All
                            </button>
                        </div>
                        <div id="ideasContent" style="max-height: 600px; overflow-y: auto;">
                            <!-- Ideas will be inserted here -->
                        </div>
                    ', 'mb-0'); ?>
                </div>
                
                <!-- Loading State -->
                <div id="loadingState" class="d-none">
                    <?php echo renderLoadingState('Generating your innovative ideas...'); ?>
                </div>
                
                <!-- Initial State -->
                <div id="initialState">
                    <?php echo renderInitialState('fas fa-lightbulb', 'Your generated ideas will appear here', 'Fill out the form and click "Generate Ideas" to get started'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('ideaForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    
    // Show loading state
    document.getElementById('initialState').classList.add('d-none');
    document.getElementById('loadingState').classList.remove('d-none');
    document.getElementById('ideasOutput').classList.add('d-none');

    try {
        const response = await fetch('generate_ideas.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            const ideasContainer = document.getElementById('ideasContent');
            ideasContainer.innerHTML = '';
            
            // Handle structured ideas array
            const ideas = Array.isArray(data.ideas) ? data.ideas : [];
            
            // Update the header with count information
            const copyButton = document.getElementById('copyAllButton');
            if (copyButton && data.count) {
                copyButton.innerHTML = `<i class="fas fa-copy me-1"></i>Copy All (${data.count})`;
            }
            
            ideas.forEach((idea, index) => {
                const card = document.createElement('div');
                card.className = 'card mb-4 border-0 shadow-sm';
                card.innerHTML = `
                    <div class="card-header bg-info text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-lightbulb me-2"></i>Idea #${index + 1}
                            </h5>
                            <button onclick="copyIdea(this)" 
                                    class="btn btn-light btn-sm">
                                <i class="fas fa-copy me-1"></i>Copy
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Idea Title -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="icon-box bg-primary-subtle me-2" style="width: 24px; height: 24px;">
                                    <i class="fas fa-star text-primary" style="font-size: 0.75rem;"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-primary">Idea</h6>
                            </div>
                            <p class="text-dark mb-0 ps-4">${idea.title || 'Creative Idea'}</p>
                        </div>
                        
                        <!-- Details -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="icon-box bg-success-subtle me-2" style="width: 24px; height: 24px;">
                                    <i class="fas fa-info-circle text-success" style="font-size: 0.75rem;"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-success">Details</h6>
                            </div>
                            <p class="text-dark mb-0 ps-4">${idea.details || 'Detailed explanation of the idea.'}</p>
                        </div>
                        
                        <!-- Practical Steps -->
                        <div class="mb-0">
                            <div class="d-flex align-items-center mb-2">
                                <div class="icon-box bg-warning-subtle me-2" style="width: 24px; height: 24px;">
                                    <i class="fas fa-tasks text-warning" style="font-size: 0.75rem;"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-warning">Practical Steps</h6>
                            </div>
                            <div class="ps-4">
                                <div class="text-dark mb-0">${formatPracticalSteps(idea.practical || 'Implementation steps for this idea.')}</div>
                            </div>
                        </div>
                    </div>
                `;
                ideasContainer.appendChild(card);
            });
            
            document.getElementById('loadingState').classList.add('d-none');
            document.getElementById('ideasOutput').classList.remove('d-none');
            
            // Show success notification
            if (typeof showTaskNotification === 'function') {
                showTaskNotification('idea_generated');
            }
        } else {
            document.getElementById('loadingState').classList.add('d-none');
            document.getElementById('initialState').classList.remove('d-none');
            if (typeof showNotification === 'function') {
                showNotification('Error: ' + data.error, 'error');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('loadingState').classList.add('d-none');
        document.getElementById('initialState').classList.remove('d-none');
        if (typeof showNotification === 'function') {
            showNotification('An error occurred while generating ideas. Please try again.', 'error');
        }
    }
});

function formatPracticalSteps(practicalText) {
    // Check if the text already contains numbered steps
    if (practicalText.match(/^\d+\./m)) {
        // Convert numbered list to HTML ordered list
        const steps = practicalText.split(/\d+\./).filter(step => step.trim());
        if (steps.length > 1) {
            const listItems = steps.map(step => `<li>${step.trim()}</li>`).join('');
            return `<ol class="mb-0 ps-3">${listItems}</ol>`;
        }
    }
    
    // If no numbered format, try to split by sentences and create numbered list
    const sentences = practicalText.split(/[.!?]+/).filter(s => s.trim().length > 10);
    if (sentences.length > 1) {
        const listItems = sentences.map(sentence => `<li>${sentence.trim()}.</li>`).join('');
        return `<ol class="mb-0 ps-3">${listItems}</ol>`;
    }
    
    // Fallback: return as paragraph
    return `<p class="mb-0">${practicalText}</p>`;
}

function copyIdea(button) {
    // Get the entire idea card content
    const card = button.closest('.card');
    const ideaContent = card.querySelector('.card-body').innerText;
    
    navigator.clipboard.writeText(ideaContent).then(() => {
        button.innerHTML = '<i class="fas fa-check me-1"></i>Copied!';
        if (typeof showTaskNotification === 'function') {
            showTaskNotification('content_copied');
        }
        setTimeout(() => {
            button.innerHTML = '<i class="fas fa-copy me-1"></i>Copy';
        }, 2000);
    }).catch(error => {
        console.error('Error copying idea:', error);
        if (typeof showNotification === 'function') {
            showNotification('Failed to copy idea. Please try again.', 'error');
        }
    });
}

function copyAllIdeas() {
    const cards = Array.from(document.querySelectorAll('#ideasContent .card'));
    const allIdeas = cards.map((card, index) => {
        const ideaContent = card.querySelector('.card-body').innerText;
        return ideaContent;
    }).join('\n\n' + '='.repeat(50) + '\n\n');
    
    navigator.clipboard.writeText(allIdeas);
    
    const button = document.getElementById('copyAllButton');
    button.innerHTML = '<i class="fas fa-check me-1"></i>Copied!';
    
    if (typeof showTaskNotification === 'function') {
        showTaskNotification('content_copied');
    }
    
    setTimeout(() => {
        button.innerHTML = '<i class="fas fa-copy me-1"></i>Copy All';
    }, 2000);
}
</script>

<style>
/* Custom scrollbar for ideas content */
#ideasContent::-webkit-scrollbar {
    width: 6px;
}

#ideasContent::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

#ideasContent::-webkit-scrollbar-thumb {
    background: #06b6d4;
    border-radius: 10px;
}

#ideasContent::-webkit-scrollbar-thumb:hover {
    background: #0891b2;
}

/* Enhanced card styling for grouped ideas */
.card.mb-4 {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card.mb-4:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

/* Icon box styling for idea components */
.icon-box {
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
}

/* Clean professional styling for practical steps lists */
.card-body ol {
    padding-left: 20px;
    margin-bottom: 0;
}

.card-body ol li {
    margin-bottom: 8px;
    line-height: 1.6;
    padding-left: 5px;
}

.card-body ol li:last-child {
    margin-bottom: 0;
}
</style>