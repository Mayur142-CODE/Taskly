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
            How to Use EmailGenX
        </h5>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="text-center">
                    <div class="icon-box bg-primary-subtle mb-3 mx-auto" style="width: 50px; height: 50px;">
                        <i class="fas fa-edit text-primary"></i>
                    </div>
                    <h6 class="fw-bold text-dark">1. Enter Subject</h6>
                    <small class="text-muted">Write a clear, concise email subject line</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="icon-box bg-success-subtle mb-3 mx-auto" style="width: 50px; height: 50px;">
                        <i class="fas fa-comment text-success"></i>
                    </div>
                    <h6 class="fw-bold text-dark">2. Describe Context</h6>
                    <small class="text-muted">Explain what you want to communicate</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="icon-box bg-warning-subtle mb-3 mx-auto" style="width: 50px; height: 50px;">
                        <i class="fas fa-sliders-h text-warning"></i>
                    </div>
                    <h6 class="fw-bold text-dark">3. Choose Tone</h6>
                    <small class="text-muted">Select appropriate tone: Formal, Friendly, or Persuasive</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="icon-box bg-info-subtle mb-3 mx-auto" style="width: 50px; height: 50px;">
                        <i class="fas fa-magic text-info"></i>
                    </div>
                    <h6 class="fw-bold text-dark">4. Generate</h6>
                    <small class="text-muted">AI creates a professional email instantly</small>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row g-4">
    <!-- Left Panel - Input Form -->
    <div class="col-lg-6">
        <div class="card content-card">
            <div class="card-body">
                <h5 class="card-title d-flex align-items-center gap-2 mb-4">
                    <i class="fas fa-edit text-primary"></i>
                    Create Email
                </h5>
                
                <form id="emailForm">
                    <div class="mb-3">
                        <label class="form-label fw-medium text-dark">Subject</label>
                        <input type="text" 
                               name="subject" 
                               class="form-control" 
                               placeholder="Enter email subject..."
                               required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium text-dark">Context / Details</label>
                        <textarea name="context" 
                                 rows="8" 
                                 class="form-control" 
                                 placeholder="Describe what you want to communicate..."
                                 required></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-medium text-dark">Tone</label>
                        <select name="tone" class="form-select">
                            <option value="formal">Formal</option>
                            <option value="friendly">Friendly</option>
                            <option value="persuasive">Persuasive</option>
                            <option value="casual">Casual</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
                        <i class="fas fa-magic"></i>
                        <span>Generate Email</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Panel - Output -->
    <div class="col-lg-6">
        <!-- Generated Email Output -->
        <div id="emailOutput" class="d-none">
            <div class="card content-card">
                <div class="card-header bg-transparent border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">Generated Email</h5>
                        <button onclick="copyEmail()" 
                                id="copyButton"
                                class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-copy me-1"></i>Copy
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="emailContent" class="text-dark">
                        <!-- Generated content will appear here -->
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Loading State -->
        <div id="loadingState" class="d-none">
            <div class="card content-card">
                <div class="card-body text-center py-5">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mb-0">Generating your email...</p>
                </div>
            </div>
        </div>
        
        <!-- Initial State -->
        <div id="initialState">
            <div class="card content-card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-envelope-open-text text-muted mb-3" style="font-size: 3rem;"></i>
                    <h6 class="text-muted">Your generated email will appear here</h6>
                    <p class="text-muted small mb-0">Fill out the form and click "Generate Email" to get started</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('emailForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    
    // Show loading state
    document.getElementById('initialState').classList.add('d-none');
    document.getElementById('loadingState').classList.remove('d-none');
    document.getElementById('emailOutput').classList.add('d-none');

    try {
        const response = await fetch('generate_email.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            document.getElementById('loadingState').classList.add('d-none');
            document.getElementById('emailOutput').classList.remove('d-none');
            document.getElementById('emailContent').innerHTML = data.email.replace(/\n/g, '<br>');
            // Show success notification when email is generated
            if (typeof showNotification === 'function') {
                showNotification('Email generated successfully! 📧', 'success');
            }
        } else {
            document.getElementById('loadingState').classList.add('d-none');
            document.getElementById('initialState').classList.remove('d-none');
            // Show error notification
            if (typeof showNotification === 'function') {
                showNotification('Error: ' + data.error, 'error');
            } else {
                alert('Error: ' + data.error);
            }
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while generating the email. Please try again.');
        document.getElementById('loadingState').classList.add('d-none');
        document.getElementById('initialState').classList.remove('d-none');
    }
});

function copyEmail() {
    const emailContent = document.getElementById('emailContent').innerText;
    navigator.clipboard.writeText(emailContent);
    
    const button = document.getElementById('copyButton');
    button.innerHTML = '<i class="fas fa-check me-1"></i>Copied!';
    
    // Show notification when content is copied
    if (typeof showNotification === 'function') {
        showNotification('Email copied to clipboard! 📋', 'success');
    }
    
    setTimeout(() => {
        button.innerHTML = '<i class="fas fa-copy me-1"></i>Copy';
    }, 2000);
}
</script>