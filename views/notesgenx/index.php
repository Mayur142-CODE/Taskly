<?php
// Initialize notes array
$notesFile = __DIR__ . '/../../storage/notes.json';
$notes = [];

if (file_exists($notesFile)) {
    $notes = json_decode(file_get_contents($notesFile), true);
}

// Reverse notes to show newest first
$notes = array_reverse($notes ?? []);
?>

<!-- Header Section -->
<div class="card content-card mb-4">
    <div class="card-body">
       <h1></h1>
       <h1> </h1>
    </div>
</div>

<!-- Usage Guide Section -->
<div class="card content-card mb-4">
    <div class="card-body">
        <h5 class="card-title d-flex align-items-center gap-2 mb-3">
            <i class="fas fa-info-circle text-primary"></i>
            How to Use NotesGenX
        </h5>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="text-center">
                    <div class="icon-box bg-primary-subtle mb-3 mx-auto" style="width: 50px; height: 50px;">
                        <i class="fas fa-edit text-primary"></i>
                    </div>
                    <h6 class="fw-bold text-dark">1. Enter Topic</h6>
                    <small class="text-muted">Type any subject or topic you want to study</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="icon-box bg-success-subtle mb-3 mx-auto" style="width: 50px; height: 50px;">
                        <i class="fas fa-list text-success"></i>
                    </div>
                    <h6 class="fw-bold text-dark">2. Choose Style</h6>
                    <small class="text-muted">Select note format: Summary, Detailed, or Bullet Points</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="icon-box bg-warning-subtle mb-3 mx-auto" style="width: 50px; height: 50px;">
                        <i class="fas fa-magic text-warning"></i>
                    </div>
                    <h6 class="fw-bold text-dark">3. Generate</h6>
                    <small class="text-muted">AI creates comprehensive study notes instantly</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="icon-box bg-info-subtle mb-3 mx-auto" style="width: 50px; height: 50px;">
                        <i class="fas fa-download text-info"></i>
                    </div>
                    <h6 class="fw-bold text-dark">4. Export</h6>
                    <small class="text-muted">Copy to clipboard or download as PDF</small>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Main Content Grid -->
<div class="row g-4">
    <!-- Input Panel -->
    <div class="col-xl-4">
        <div class="card content-card">
            <div class="card-body">
                <h5 class="card-title d-flex align-items-center gap-2 mb-4">
                    <i class="fas fa-edit text-warning"></i>
                    Create New Notes
                </h5>
                
                <form id="notesForm">
                    <!-- Topic Input -->
                    <div class="mb-3">
                        <label class="form-label fw-medium text-dark">Study Topic / Subject</label>
                        <div class="input-group">
                            <span class="input-group-text bg-warning-subtle border-warning-subtle">
                                <i class="fas fa-lightbulb text-warning"></i>
                            </span>
                            <input type="text" 
                                   name="topic" 
                                   id="topicInput"
                                   class="form-control border-warning-subtle" 
                                   placeholder="e.g., Machine Learning, Photosynthesis, World War II" 
                                   required>
                        </div>
                    </div>
                    
                    <!-- Content Type -->
                    <div class="mb-3">
                        <label class="form-label fw-medium text-dark">Content Type</label>
                        <select name="contentType" 
                                id="contentType" 
                                class="form-select">
                            <option value="topic">Topic/Concept</option>
                            <option value="syllabus">Syllabus</option>
                            <option value="text">Text Content</option>
                        </select>
                    </div>
                    
                    <!-- Content Input -->
                    <div id="contentInputArea" class="mb-3">
                        <label class="form-label fw-medium text-dark">Additional Content</label>
                        <textarea name="content" 
                                  id="contentTextarea"
                                  rows="6" 
                                  class="form-control" 
                                  placeholder="Enter syllabus points, text to summarize, or leave empty for topic-based notes..."></textarea>
                    </div>
                    
                    <!-- Note Style -->
                    <div class="mb-4">
                        <label class="form-label fw-medium text-dark">Note Style</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="style" id="detailed" value="detailed" checked>
                                <label class="btn btn-outline-warning w-100 text-start" for="detailed">
                                    <i class="fas fa-list-ul me-2"></i>
                                    <div>
                                        <div class="fw-medium">Detailed</div>
                                        <small class="text-muted">Comprehensive notes</small>
                                    </div>
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="style" id="summary" value="summary">
                                <label class="btn btn-outline-primary w-100 text-start" for="summary">
                                    <i class="fas fa-compress-alt me-2"></i>
                                    <div>
                                        <div class="fw-medium">Summary</div>
                                        <small class="text-muted">Key points only</small>
                                    </div>
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="style" id="bullet" value="bullet">
                                <label class="btn btn-outline-success w-100 text-start" for="bullet">
                                    <i class="fas fa-list me-2"></i>
                                    <div>
                                        <div class="fw-medium">Bullet Points</div>
                                        <small class="text-muted">Organized lists</small>
                                    </div>
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="style" id="qa" value="qa">
                                <label class="btn btn-outline-info w-100 text-start" for="qa">
                                    <i class="fas fa-question-circle me-2"></i>
                                    <div>
                                        <div class="fw-medium">Q&A Format</div>
                                        <small class="text-muted">Questions & answers</small>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Generate Button -->
                    <button type="submit" 
                            id="generateBtn"
                            class="btn btn-warning w-100 d-flex align-items-center justify-content-center gap-2 py-3">
                        <i class="fas fa-magic"></i>
                        <span>Generate Smart Notes</span>
                    </button>
                </form>
            </div>
        </div>

    </div>

    <!-- Output Panel -->
    <div class="col-xl-8">
        <!-- Generated Notes Display -->
        <div class="card content-card mb-4">
            <div class="card-header bg-transparent border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="fas fa-file-alt text-warning"></i>
                        Generated Notes
                    </h5>
                    <div class="d-flex gap-2">
                        <button id="copyNotesBtn" class="btn btn-outline-primary btn-sm d-none">
                            <i class="fas fa-copy me-1"></i>Copy Notes
                        </button>
                        <button id="exportPdfBtn" class="btn btn-outline-danger btn-sm d-none">
                            <i class="fas fa-file-pdf me-1"></i>Export PDF
                        </button>
                        <button id="exportWordBtn" class="btn btn-outline-primary btn-sm d-none">
                            <i class="fas fa-file-word me-1"></i>Export Word
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div id="notesOutput" style="max-height: 500px; overflow-y: auto; padding: 1.5rem;">
                    <div class="d-flex flex-column align-items-center justify-content-center text-center h-100 py-5">
                        <div class="icon-box bg-warning-subtle mb-4" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="fas fa-sticky-note text-warning"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Ready to Generate Notes</h5>
                        <p class="text-muted">Enter a topic and select your preferred style to generate AI-powered study notes instantly.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
/* Custom scrollbar for notes output */
#notesOutput::-webkit-scrollbar {
    width: 6px;
}

#notesOutput::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

#notesOutput::-webkit-scrollbar-thumb {
    background: #ffc107;
    border-radius: 10px;
}

#notesOutput::-webkit-scrollbar-thumb:hover {
    background: #e0a800;
}

/* Formatted content styling */
.formatted-content {
    line-height: 1.6;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.formatted-content h1 {
    color: #2c3e50;
    font-size: 1.8rem;
    font-weight: bold;
    margin: 1.5rem 0 1rem 0;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #ffc107;
}

.formatted-content h2 {
    color: #34495e;
    font-size: 1.4rem;
    font-weight: bold;
    margin: 1.2rem 0 0.8rem 0;
    background: rgba(255, 193, 7, 0.1);
    padding: 0.5rem;
    border-left: 4px solid #ffc107;
}

.formatted-content h3 {
    color: #495057;
    font-size: 1.2rem;
    font-weight: 600;
    margin: 1rem 0 0.6rem 0;
}

.formatted-content p {
    margin: 0.8rem 0;
    text-align: justify;
    color: #495057;
}

.formatted-content ul, .formatted-content ol {
    margin: 1rem 0;
    padding-left: 2rem;
}

.formatted-content li {
    margin: 0.4rem 0;
    color: #495057;
}

.formatted-content strong {
    color: #2c3e50;
    font-weight: 600;
}

.formatted-content em {
    color: #6c757d;
    font-style: italic;
}

.formatted-content u {
    text-decoration: underline;
    text-decoration-color: #ffc107;
}

.formatted-content blockquote {
    background: rgba(255, 193, 7, 0.1);
    border-left: 4px solid #ffc107;
    margin: 1rem 0;
    padding: 1rem;
    font-style: italic;
}

.formatted-content code {
    background: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 3px;
    font-family: 'Courier New', monospace;
    font-size: 0.9em;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('notesForm');
    const generateBtn = document.getElementById('generateBtn');
    const notesOutput = document.getElementById('notesOutput');
    const copyBtn = document.getElementById('copyNotesBtn');
    const exportPdfBtn = document.getElementById('exportPdfBtn');
    const exportWordBtn = document.getElementById('exportWordBtn');
    
    let currentNotes = '';
    
    // No template buttons or style selection needed since they were removed
    
    // Form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const topic = formData.get('topic').trim();
        
        if (!topic) {
            showNotification('Please enter a topic!', 'error');
            return;
        }
        
        // Show loading state
        generateBtn.disabled = true;
        generateBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Generating...';
        notesOutput.innerHTML = `
            <div class="d-flex flex-column align-items-center justify-content-center text-center h-100 py-5">
                <div class="spinner-border text-warning mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h5 class="fw-bold text-dark mb-2">Generating Notes...</h5>
                <p class="text-muted">AI is analyzing your topic and creating comprehensive notes.</p>
            </div>
        `;
        
        try {
            const response = await fetch('generate_notes.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                currentNotes = result.notes;
                // Render HTML content properly
                notesOutput.innerHTML = `<div class="text-dark formatted-content">${result.notes}</div>`;
                copyBtn.classList.remove('d-none');
                exportPdfBtn.classList.remove('d-none');
                exportWordBtn.classList.remove('d-none');
                if (typeof showTaskNotification === 'function') {
                    showTaskNotification('notes_generated');
                }
            } else {
                throw new Error(result.error || 'Failed to generate notes');
            }
        } catch (error) {
            console.error('Error:', error);
            notesOutput.innerHTML = `
                <div class="d-flex flex-column align-items-center justify-content-center text-center h-100 py-5">
                    <i class="fas fa-exclamation-triangle text-danger mb-3" style="font-size: 3rem;"></i>
                    <h5 class="fw-bold text-dark mb-2">Generation Failed</h5>
                    <p class="text-muted mb-3">${error.message}</p>
                    <button onclick="location.reload()" class="btn btn-warning">Try Again</button>
                </div>
            `;
            if (typeof showNotification === 'function') {
                showNotification('Failed to generate notes. Please try again.', 'error');
            }
        } finally {
            generateBtn.disabled = false;
            generateBtn.innerHTML = '<i class="fas fa-magic"></i><span class="ms-2">Generate Smart Notes</span>';
        }
    });
    
    // Copy notes as plain text
    copyBtn.addEventListener('click', function() {
        // Convert HTML to plain text
        const plainText = htmlToPlainText(currentNotes);
        
        navigator.clipboard.writeText(plainText).then(() => {
            const button = copyBtn;
            button.innerHTML = '<i class="fas fa-check me-1"></i>Copied!';
            if (typeof showTaskNotification === 'function') {
                showTaskNotification('content_copied');
            }
            setTimeout(() => {
                button.innerHTML = '<i class="fas fa-copy me-1"></i>Copy Notes';
            }, 2000);
        });
    });
    
    // Function to convert HTML to plain text
    function htmlToPlainText(html) {
        // Create a temporary div element
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;
        
        // Get all text nodes and format them properly
        let plainText = '';
        
        // Process each element to maintain structure
        const elements = tempDiv.querySelectorAll('*');
        let processedElements = new Set();
        
        function processElement(element) {
            if (processedElements.has(element)) return '';
            processedElements.add(element);
            
            let text = '';
            const tagName = element.tagName.toLowerCase();
            
            // Add appropriate spacing/formatting based on element type
            switch (tagName) {
                case 'h1':
                case 'h2':
                case 'h3':
                case 'h4':
                case 'h5':
                case 'h6':
                    text = '\n\n' + element.textContent.trim() + '\n' + '='.repeat(element.textContent.trim().length) + '\n';
                    break;
                case 'p':
                    text = '\n' + element.textContent.trim() + '\n';
                    break;
                case 'li':
                    const listParent = element.closest('ol, ul');
                    const isOrdered = listParent && listParent.tagName.toLowerCase() === 'ol';
                    const prefix = isOrdered ? '  ' + (Array.from(listParent.children).indexOf(element) + 1) + '. ' : '  • ';
                    text = prefix + element.textContent.trim() + '\n';
                    break;
                case 'ul':
                case 'ol':
                    // Don't add text for list containers, their children (li) will handle it
                    return '';
                case 'br':
                    text = '\n';
                    break;
                default:
                    // For other elements, just get the direct text content
                    if (element.children.length === 0) {
                        text = element.textContent;
                    }
                    break;
            }
            
            return text;
        }
        
        // Process elements in document order
        for (let element of tempDiv.querySelectorAll('h1, h2, h3, h4, h5, h6, p, ul, ol, li, br')) {
            plainText += processElement(element);
        }
        
        // If no structured elements found, just get all text
        if (!plainText.trim()) {
            plainText = tempDiv.textContent || tempDiv.innerText || '';
        }
        
        // Clean up extra whitespace
        plainText = plainText.replace(/\n{3,}/g, '\n\n');
        plainText = plainText.replace(/^\s+|\s+$/g, '');
        
        return plainText;
    }
    
    // Export functions
    async function exportDocument(format) {
        if (!currentNotes) return;
        
        try {
            const formData = new FormData();
            formData.append('content', currentNotes);
            formData.append('format', format);
            formData.append('filename', 'notes');
            formData.append('template', 'academic'); // Use academic template for notes
            formData.append('toolName', 'notesgenx'); // Add tool name for proper file naming
            
            const response = await fetch('export_document.php', {
                method: 'POST',
                body: formData
            });
            
            if (!response.ok) {
                throw new Error('Export failed');
            }
            
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            // Use topic name for filename
            const topicInput = document.querySelector('input[name="topic"]');
            const topic = topicInput ? topicInput.value.trim() : 'notes';
            const sanitizedTopic = topic.replace(/[^a-zA-Z0-9_-]/g, '_');
            a.download = `${sanitizedTopic}.${format === 'doc' ? 'docx' : format}`;
            a.click();
            window.URL.revokeObjectURL(url);
            
            if (typeof showNotification === 'function') {
                showNotification(`${format.toUpperCase()} exported successfully!`, 'success');
            }
        } catch (error) {
            console.error('Error:', error);
            if (typeof showNotification === 'function') {
                showNotification(`Error exporting ${format.toUpperCase()}. Please try again.`, 'error');
            }
        }
    }
    
    // Export PDF
    exportPdfBtn.addEventListener('click', () => exportDocument('pdf'));
    
    // Export Word
    exportWordBtn.addEventListener('click', () => exportDocument('doc'));
});
</script>