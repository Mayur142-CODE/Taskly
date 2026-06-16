<!-- How to Use Guide -->
<section class="py-5">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="text-center">
                    <div class="feature-icon bg-primary bg-opacity-10 mx-auto mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-pencil-alt text-primary fs-4"></i>
                    </div>
                    <h6 class="fw-bold">1. Enter Title</h6>
                    <p class="text-muted small">Provide a clear document title and topic</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="feature-icon bg-success bg-opacity-10 mx-auto mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-list text-success fs-4"></i>
                    </div>
                    <h6 class="fw-bold">2. Add Requirements</h6>
                    <p class="text-muted small">Describe content, structure, and key points</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="feature-icon bg-warning bg-opacity-10 mx-auto mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-file-alt text-warning fs-4"></i>
                    </div>
                    <h6 class="fw-bold">3. Choose Format</h6>
                    <p class="text-muted small">Select document type and format style</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="feature-icon bg-info bg-opacity-10 mx-auto mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-download text-info fs-4"></i>
                    </div>
                    <h6 class="fw-bold">4. Generate & Export</h6>
                    <p class="text-muted small">AI creates document, export as PDF or Word</p>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="row g-4">
    <!-- Left Panel - Input Form -->
    <div class="col-lg-4">
        <div class="card content-card">
            <div class="card-body">
                <h5 class="card-title d-flex align-items-center gap-2 mb-4">
                    <i class="fas fa-edit text-success"></i>
                    Create Document
                </h5>
                
                <form id="docForm">
                    <div class="mb-3">
                        <label class="form-label fw-medium text-dark">Document Title</label>
                        <input type="text" 
                               name="topic" 
                               class="form-control" 
                               placeholder="Enter document title or topic..."
                               required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium text-dark">Document Type</label>
                        <select name="type" class="form-select">
                            <option value="Report">Business Report</option>
                            <option value="Essay">Academic Essay</option>
                            <option value="Article">Article</option>
                            <option value="Proposal">Project Proposal</option>
                            <option value="Manual">User Manual</option>
                            <option value="Letter">Formal Letter</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium text-dark">Content Details</label>
                        <textarea name="details" 
                                 rows="4" 
                                 class="form-control" 
                                 placeholder="Describe what you want to include in the document..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium text-dark">Document Length</label>
                        <select name="length" class="form-select">
                            <option value="short">Short (1-2 pages)</option>
                            <option value="medium" selected>Medium (3-5 pages)</option>
                            <option value="long">Long (6-10 pages)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium text-dark">Writing Style</label>
                        <select name="style" class="form-select">
                            <option value="professional">Professional</option>
                            <option value="academic">Academic</option>
                            <option value="casual">Casual</option>
                            <option value="technical">Technical</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-medium text-dark">Document Template</label>
                        <select name="template" class="form-select">
                            <option value="modern">Modern Business</option>
                            <option value="academic">Academic Paper</option>
                            <option value="creative">Creative Layout</option>
                            <option value="minimal">Minimal Clean</option>
                            <option value="corporate">Corporate Formal</option>
                            <option value="technical">Technical Manual</option>
                        </select>
                        <div class="form-text">Choose a layout template for your document</div>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2">
                        <i class="fas fa-magic"></i>
                        <span>Generate Document</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Panel - Output -->
    <div class="col-lg-8">
        <!-- Generated Document Output -->
        <div id="docOutput" class="d-none">
            <div class="card content-card">
                <div class="card-header bg-transparent border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="fas fa-file-alt text-success"></i>
                            Generated Document
                        </h5>
                        <div class="d-flex gap-2">
                            <button onclick="exportDocument('pdf')" 
                                    class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-file-pdf me-1"></i>Export PDF
                            </button>
                            <button onclick="exportDocument('doc')" 
                                    class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-file-word me-1"></i>Export Word
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="editor" style="max-height: 500px; overflow-y: auto;">
                        <!-- Quill editor will be initialized here -->
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Loading State -->
        <div id="loadingState" class="d-none">
            <div class="card content-card">
                <div class="card-body text-center py-5">
                    <div class="spinner-border text-success mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mb-0">Generating your document...</p>
                </div>
            </div>
        </div>
        
        <!-- Initial State -->
        <div id="initialState">
            <div class="card content-card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-file-alt text-muted mb-3" style="font-size: 3rem;"></i>
                    <h6 class="text-muted">Your generated document will appear here</h6>
                    <p class="text-muted small mb-0">Fill out the form and click "Generate Document" to get started</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom scrollbar for document editor */
#editor .ql-editor::-webkit-scrollbar {
    width: 6px;
}

#editor .ql-editor::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

#editor .ql-editor::-webkit-scrollbar-thumb {
    background: #22c55e;
    border-radius: 10px;
}

#editor .ql-editor::-webkit-scrollbar-thumb:hover {
    background: #16a34a;
}

/* Ensure the editor container has proper scrolling */
#editor .ql-container {
    max-height: 450px;
    overflow-y: auto;
}

/* Better document formatting in editor */
#editor .ql-editor {
    font-family: 'Times New Roman', serif;
    font-size: 14px;
    line-height: 1.6;
    color: #333;
}

#editor .ql-editor h1 {
    font-size: 24px;
    font-weight: bold;
    margin: 20px 0 15px 0;
    color: #2c3e50;
    text-align: center;
}

#editor .ql-editor h2 {
    font-size: 20px;
    font-weight: bold;
    margin: 18px 0 12px 0;
    color: #34495e;
    border-bottom: 2px solid #3498db;
    padding-bottom: 5px;
}

#editor .ql-editor h3 {
    font-size: 16px;
    font-weight: bold;
    margin: 15px 0 10px 0;
    color: #34495e;
}

#editor .ql-editor p {
    margin: 10px 0;
    text-align: justify;
}

#editor .ql-editor ul, #editor .ql-editor ol {
    margin: 10px 0;
    padding-left: 30px;
}

#editor .ql-editor li {
    margin: 5px 0;
}

#editor .ql-editor strong {
    font-weight: bold;
    color: #2c3e50;
}

#editor .ql-editor em {
    font-style: italic;
    color: #7f8c8d;
}
</style>

<!-- Include Quill.js -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
// Initialize Quill editor
const quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [{ 'header': 1 }, { 'header': 2 }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'script': 'sub'}, { 'script': 'super' }],
            [{ 'indent': '-1'}, { 'indent': '+1' }],
            [{ 'size': ['small', false, 'large', 'huge'] }],
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'font': [] }],
            [{ 'align': [] }],
            ['clean']
        ]
    }
});

document.getElementById('docForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    
    // Show loading state
    document.getElementById('initialState').classList.add('d-none');
    document.getElementById('loadingState').classList.remove('d-none');
    document.getElementById('docOutput').classList.add('d-none');

    try {
        const response = await fetch('generate_document.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            quill.root.innerHTML = data.document;
            
            document.getElementById('loadingState').classList.add('d-none');
            document.getElementById('docOutput').classList.remove('d-none');
            
            // Show success notification
            if (typeof showTaskNotification === 'function') {
                showTaskNotification('document_generated');
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
            showNotification('An error occurred while generating the document. Please try again.', 'error');
        }
    }
});

async function exportDocument(format) {
    const content = quill.root.innerHTML;
    
    // Validate content
    if (!content || content.trim() === '<p><br></p>' || content.trim() === '') {
        if (typeof showNotification === 'function') {
            showNotification('Please generate some content before exporting.', 'warning');
        }
        return;
    }
    
    const formData = new FormData();
    formData.append('content', content);
    formData.append('format', format);
    formData.append('filename', 'document');
    
    // Get template from form if available
    const templateSelect = document.querySelector('select[name="template"]');
    const template = templateSelect ? templateSelect.value : 'modern';
    formData.append('template', template);
    
    try {
        // Show loading state
        const exportButtons = document.querySelectorAll('[onclick*="exportDocument"]');
        exportButtons.forEach(btn => {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Exporting...';
        });
        
        // Add toolName for proper file naming
        formData.append('toolName', 'docgenx');
        
        const response = await fetch('export_document.php', {
            method: 'POST',
            body: formData
        });
        
        // Check if response is ok
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        // Check content type to handle errors
        const contentType = response.headers.get('content-type');
        
        if (contentType && contentType.includes('application/json')) {
            // Error response
            const errorData = await response.json();
            throw new Error(errorData.error || 'Export failed');
        }
        
        // Success - handle file download
        const blob = await response.blob();
        
        if (blob.size === 0) {
            throw new Error('Generated file is empty');
        }
        
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        // Use topic name for filename
        const topicInput = document.querySelector('input[name="topic"]');
        const topic = topicInput ? topicInput.value.trim() : 'document';
        const sanitizedTopic = topic.replace(/[^a-zA-Z0-9_-]/g, '_');
        a.download = format === 'pdf' ? `${sanitizedTopic}.pdf` : `${sanitizedTopic}.docx`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
        
        if (typeof showNotification === 'function') {
            showNotification(`${format.toUpperCase()} exported successfully!`, 'success');
        }
        
    } catch (error) {
        console.error('Export error:', error);
        if (typeof showNotification === 'function') {
            showNotification('Export failed: ' + error.message, 'error');
        }
    } finally {
        // Reset button states
        const exportButtons = document.querySelectorAll('[onclick*="exportDocument"]');
        exportButtons.forEach(btn => {
            btn.disabled = false;
            if (btn.textContent.includes('PDF')) {
                btn.innerHTML = '<i class="fas fa-file-pdf me-1"></i>Export PDF';
            } else {
                btn.innerHTML = '<i class="fas fa-file-word me-1"></i>Export Word';
            }
        });
    }
}
</script>

<style>
.feature-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.feature-icon:hover {
    transform: scale(1.1);
}
</style>