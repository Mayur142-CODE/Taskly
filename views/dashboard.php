<?php
// Simplified dashboard - only essential data
?>

<!-- Welcome Header -->
<div class="mb-4">
    <h2 class="h4 fw-bold text-dark mb-0">Dashboard</h2>
</div>

<!-- Quick Links Only -->
<div class="card content-card">
    <div class="card-body">
        <h5 class="card-title d-flex align-items-center gap-2 mb-4">
            <i class="fas fa-rocket text-primary"></i>
            Quick Links
        </h5>
        <div class="row g-3">

            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="index.php?page=emailgenx" class="card card-hover text-decoration-none h-100">
                    <div class="card-body d-flex align-items-center gap-3 p-3">
                        <div class="icon-box bg-success-subtle flex-shrink-0">
                            <i class="fas fa-envelope text-success"></i>
                        </div>
                        <div class="flex-grow-1 min-width-0">
                            <h6 class="fw-medium text-dark mb-1">EmailGenX</h6>
                            <small class="text-muted">Create emails</small>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="index.php?page=notesgenx" class="card card-hover text-decoration-none h-100">
                    <div class="card-body d-flex align-items-center gap-3 p-3">
                        <div class="icon-box bg-warning-subtle flex-shrink-0">
                            <i class="fas fa-sticky-note text-warning"></i>
                        </div>
                        <div class="flex-grow-1 min-width-0">
                            <h6 class="fw-medium text-dark mb-1">NotesGenX</h6>
                            <small class="text-muted">Smart notes</small>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="index.php?page=ideagenx" class="card card-hover text-decoration-none h-100">
                    <div class="card-body d-flex align-items-center gap-3 p-3">
                        <div class="icon-box bg-info-subtle flex-shrink-0">
                            <i class="fas fa-lightbulb text-info"></i>
                        </div>
                        <div class="flex-grow-1 min-width-0">
                            <h6 class="fw-medium text-dark mb-1">IdeaGenX</h6>
                            <small class="text-muted">Generate ideas</small>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="index.php?page=docgenx" class="card card-hover text-decoration-none h-100">
                    <div class="card-body d-flex align-items-center gap-3 p-3">
                        <div class="icon-box bg-purple-subtle flex-shrink-0">
                            <i class="fas fa-file-alt text-purple"></i>
                        </div>
                        <div class="flex-grow-1 min-width-0">
                            <h6 class="fw-medium text-dark mb-1">DocGenX</h6>
                            <small class="text-muted">Generate docs</small>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="index.php?page=webgenx" class="card card-hover text-decoration-none h-100">
                    <div class="card-body d-flex align-items-center gap-3 p-3">
                        <div class="icon-box bg-success-subtle flex-shrink-0">
                            <i class="fas fa-globe text-success"></i>
                        </div>
                        <div class="flex-grow-1 min-width-0">
                            <h6 class="fw-medium text-dark mb-1">WebGenX</h6>
                            <small class="text-muted">Complete website generator</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Card hover effects */
.card-hover {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: 1px solid rgba(0,0,0,0.05);
}

.card-hover:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1) !important;
}

/* Icon box styling */
.icon-box {
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    width: 40px;
    height: 40px;
}

/* Purple color for DocGenX */
.bg-purple-subtle {
    background-color: rgba(139, 69, 193, 0.1);
}

.text-purple {
    color: #8b45c1;
}

/* Responsive adjustments */
@media (max-width: 767.98px) {
    .card-body {
        padding: 1rem;
    }
    
    .row.g-3 {
        gap: 0.75rem;
    }
}
</style>