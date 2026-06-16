<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskly - AI Productivity Suite</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary-color: #64748b;
            --accent-color: #f59e0b;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --dark-color: #0f172a;
            --light-color: #f8fafc;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            line-height: 1.6;
            color: var(--dark-color);
            background-color: #ffffff;
            overflow-x: hidden;
        }

        /* Dark Theme */
        body.dark-theme {
            background-color: #0f172a;
            color: #f1f5f9;
        }

        body.dark-theme .bg-white {
            background-color: #1e293b !important;
        }

        body.dark-theme .text-dark {
            color: #f1f5f9 !important;
        }

        body.dark-theme .border {
            border-color: #334155 !important;
        }

        /* Header Styles */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            padding: 1rem 0;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: var(--shadow-md);
            padding: 0.5rem 0;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
            text-decoration: none;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            color: var(--secondary-color) !important;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem !important;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary-color) !important;
            background-color: rgba(37, 99, 235, 0.1);
        }

        /* Dropdown Styles */
        .dropdown-menu {
            border: none;
            box-shadow: var(--shadow-lg);
            border-radius: 0.75rem;
            padding: 0.5rem;
            margin-top: 0.5rem;
        }

        .dropdown-item {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: rgba(37, 99, 235, 0.1);
            color: var(--primary-color);
        }

        .dropdown-item i {
            width: 20px;
        }

        /* Navbar Toggler */
        .navbar-toggler {
            border: none;
            padding: 0.25rem 0.5rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2837, 99, 235, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Hero Section */
        .hero-section {
            background: var(--gradient-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ffffff" stop-opacity="0.1"/><stop offset="100%" stop-color="%23ffffff" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"/><circle cx="800" cy="300" r="150" fill="url(%23a)"/><circle cx="400" cy="700" r="120" fill="url(%23a)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            max-width: 600px;
        }

        .btn-hero {
            background: white;
            color: var(--primary-color);
            border: none;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 0.75rem;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-hero:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
            color: var(--primary-color);
        }

        /* Features Section */
        .features-section {
            padding: 5rem 0;
            background: var(--light-color);
        }

        .feature-card {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .feature-icon {
            width: 4rem;
            height: 4rem;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }

        .feature-description {
            color: var(--secondary-color);
            line-height: 1.6;
        }

        /* CTA Section */
        .cta-section {
            background: var(--gradient-secondary);
            padding: 5rem 0;
            text-align: center;
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
        }

        .cta-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Footer */
        .footer {
            background: var(--dark-color);
            color: white;
            padding: 3rem 0 1rem;
        }

        .footer-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
        }

        .footer-description {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 1.5rem;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: white;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1rem;
            margin-top: 2rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Tool Page Styles */
        .tool-header {
            background: var(--gradient-primary);
            padding: 3rem 0;
            color: white;
            text-align: center;
        }

        .tool-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .tool-description {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        .tool-content {
            padding: 3rem 0;
        }

        .tool-card {
            background: white;
            border-radius: 1rem;
            box-shadow: var(--shadow-md);
            border: none;
            overflow: hidden;
        }

        .tool-card-header {
            background: var(--light-color);
            padding: 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .tool-card-body {
            padding: 2rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .cta-title {
                font-size: 2rem;
            }

            .tool-title {
                font-size: 2rem;
            }
        }

        /* Animation Classes */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .fade-in-up.animate {
            opacity: 1;
            transform: translateY(0);
        }

        /* Theme Toggle */
        .theme-toggle {
            background: none;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Mobile Bottom Navigation */
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1050;
            padding: 0.5rem 0;
            display: none;
        }

        .mobile-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0.5rem;
            text-decoration: none;
            color: #6c757d;
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            margin: 0 0.25rem;
        }

        .mobile-nav-item:hover,
        .mobile-nav-item.active {
            color: var(--primary-color);
            background-color: rgba(37, 99, 235, 0.1);
            text-decoration: none;
        }

        .mobile-nav-item i {
            font-size: 1.2rem;
            margin-bottom: 0.25rem;
        }

        .mobile-nav-item span {
            font-size: 0.7rem;
            font-weight: 500;
        }

        /* Show mobile nav on small screens */
        @media (max-width: 991.98px) {
            .mobile-bottom-nav {
                display: block;
            }
            
            body {
                padding-bottom: 70px;
            }
            
            .navbar {
                display: none;
            }
        }

        /* Hide regular navbar on mobile */
        @media (max-width: 991.98px) {
            .navbar {
                display: none !important;
            }
        }

        /* Dark theme adjustments */
        body.dark-theme .navbar {
            background: rgba(15, 23, 42, 0.95);
            border-bottom-color: rgba(255, 255, 255, 0.1);
        }

        body.dark-theme .mobile-bottom-nav {
            background: #1e293b;
            border-top-color: rgba(255, 255, 255, 0.1);
        }

        body.dark-theme .mobile-nav-item {
            color: #94a3b8;
        }

        body.dark-theme .mobile-nav-item:hover,
        body.dark-theme .mobile-nav-item.active {
            color: var(--primary-color);
            background-color: rgba(37, 99, 235, 0.1);
        }

        body.dark-theme .feature-card {
            background: #1e293b;
            color: #f1f5f9;
        }

        body.dark-theme .features-section {
            background: #0f172a;
        }

        body.dark-theme .tool-card {
            background: #1e293b;
            color: #f1f5f9;
        }

        body.dark-theme .tool-card-header {
            background: #334155;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-tasks me-2"></i>Taskly
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="navbarDropdown">
                            AI Tools
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="index.php?page=emailgenx">
                                <i class="fas fa-envelope me-2"></i>EmailGenX
                            </a></li>
                            <li><a class="dropdown-item" href="index.php?page=notesgenx">
                                <i class="fas fa-sticky-note me-2"></i>NotesGenX
                            </a></li>
                            <li><a class="dropdown-item" href="index.php?page=ideagenx">
                                <i class="fas fa-lightbulb me-2"></i>IdeaGenX
                            </a></li>
                            <li><a class="dropdown-item" href="index.php?page=docgenx">
                                <i class="fas fa-file-alt me-2"></i>DocGenX
                            </a></li>
                            <li><a class="dropdown-item" href="index.php?page=webgenx">
                                <i class="fas fa-globe me-2"></i>WebGenX
                            </a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <button class="theme-toggle" id="themeToggle" title="Toggle Theme">
                            <i class="fas fa-moon"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?php include $content; ?>
    </main>

    <!-- Mobile Bottom Navigation -->
    <nav class="mobile-bottom-nav">
        <div class="container-fluid">
            <div class="row g-0">
                <div class="col">
                    <a href="index.php" class="mobile-nav-item" id="mobile-home">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </div>
                <div class="col">
                    <a href="index.php?page=emailgenx" class="mobile-nav-item" id="mobile-email">
                        <i class="fas fa-envelope"></i>
                        <span>Email</span>
                    </a>
                </div>
                <div class="col">
                    <a href="index.php?page=notesgenx" class="mobile-nav-item" id="mobile-notes">
                        <i class="fas fa-sticky-note"></i>
                        <span>Notes</span>
                    </a>
                </div>
                <div class="col">
                    <a href="index.php?page=webgenx" class="mobile-nav-item" id="mobile-web">
                        <i class="fas fa-globe"></i>
                        <span>Website</span>
                    </a>
                </div>
                <div class="col">
                    <a href="index.php?page=ideagenx" class="mobile-nav-item" id="mobile-idea">
                        <i class="fas fa-lightbulb"></i>
                        <span>Ideas</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="footer-brand">Taskly</div>
                    <p class="footer-description">
                        Empowering productivity with AI-driven tools for modern professionals. 
                        Generate emails, notes, ideas, documents, and websites effortlessly.
                    </p>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">AI Tools</h6>
                    <ul class="footer-links">
                        <li><a href="index.php?page=emailgenx">EmailGenX</a></li>
                        <li><a href="index.php?page=notesgenx">NotesGenX</a></li>
                        <li><a href="index.php?page=ideagenx">IdeaGenX</a></li>
                        <li><a href="index.php?page=docgenx">DocGenX</a></li>
                        <li><a href="index.php?page=webgenx">WebGenX</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Company</h6>
                    <ul class="footer-links">
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="#privacy">Privacy Policy</a></li>
                        <li><a href="#terms">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-12 mb-4">
                    <h6 class="fw-bold mb-3">Stay Updated</h6>
                    <p class="footer-description">
                        Get the latest updates on new AI tools and features.
                    </p>
                    <div class="d-flex gap-2">
                        <input type="email" class="form-control" placeholder="Enter your email">
                        <button class="btn btn-primary">Subscribe</button>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Taskly. All rights reserved. Powered by AI Innovation.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Initialize Bootstrap dropdowns
        const dropdownElementList = document.querySelectorAll('.dropdown-toggle');
        const dropdownList = [...dropdownElementList].map(dropdownToggleEl => new bootstrap.Dropdown(dropdownToggleEl));

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Theme toggle
        const themeToggle = document.getElementById('themeToggle');
        const body = document.body;
        const themeIcon = themeToggle.querySelector('i');

        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        if (savedTheme === 'dark') {
            body.classList.add('dark-theme');
            themeIcon.classList.replace('fa-moon', 'fa-sun');
        }

        themeToggle.addEventListener('click', function() {
            body.classList.toggle('dark-theme');
            
            if (body.classList.contains('dark-theme')) {
                themeIcon.classList.replace('fa-moon', 'fa-sun');
                localStorage.setItem('theme', 'dark');
            } else {
                themeIcon.classList.replace('fa-sun', 'fa-moon');
                localStorage.setItem('theme', 'light');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Active navigation highlighting
        const currentPage = new URLSearchParams(window.location.search).get('page') || 'dashboard';
        
        // Desktop navigation
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link, .dropdown-item');
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href && href.includes(`page=${currentPage}`)) {
                link.classList.add('active');
            }
        });
        
        // Mobile navigation
        const mobileNavItems = document.querySelectorAll('.mobile-nav-item');
        mobileNavItems.forEach(item => {
            const href = item.getAttribute('href');
            if (href) {
                if (currentPage === 'dashboard' && href === 'index.php') {
                    item.classList.add('active');
                } else if (href.includes(`page=${currentPage}`)) {
                    item.classList.add('active');
                }
            }
        });
    </script>
</body>
</html>
