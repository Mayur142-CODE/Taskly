<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskly - AI Productivity Suite</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.6/dist/chart.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root {
            --bs-primary: #3b82f6;
            --bs-primary-rgb: 59, 130, 246;
            --bs-secondary: #6c757d;
            --bs-success: #22c55e;
            --bs-info: #06b6d4;
            --bs-warning: #f59e0b;
            --bs-danger: #ef4444;
            --bs-light: #f8f9fa;
            --bs-dark: #1e293b;
        }
        
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background-color: #f8fafc;
        }
        
        .dark-mode {
            background-color: #1e293b;
            color: #f1f5f9;
        }
        
        .dark-mode .bg-white {
            background-color: #334155 !important;
        }
        
        .dark-mode .text-dark {
            color: #f1f5f9 !important;
        }
        
        .dark-mode .border {
            border-color: #475569 !important;
        }
        
        .sidebar {
            background-color: white;
            border-right: none;
            min-height: 100vh;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            margin-right: 0;
        }
        
        .dark-mode .sidebar {
            background-color: #1e293b;
            border-right-color: #475569;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        
        .sidebar-link {
            transition: all 0.2s ease;
            border-radius: 0.5rem;
            margin: 2px 0;
        }
        
        .sidebar-link:hover {
            background-color: #f1f5f9;
            color: #3b82f6;
            text-decoration: none;
        }
        
        .sidebar-link.active {
            background-color: #3b82f6;
            color: white;
        }
        
        .dark-mode .sidebar-link:hover {
            background-color: #475569;
            color: #60a5fa;
        }
        
        .card-hover {
            transition: all 0.2s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        
        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }
        
        .icon-box {
            width: 40px;
            height: 40px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .stats-card {
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.2s ease;
        }
        
        .stats-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            transform: translateY(-1px);
        }
        
        .dark-mode .stats-card {
            background-color: #334155;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }
        
        .dark-mode .stats-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }
        
        .content-card {
            border: none;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.06);
            border-radius: 12px;
        }
        
        .dark-mode .content-card {
            background-color: #334155;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.25);
        }
    </style>
    <style>
        * {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #f8fafc;
            min-height: 100vh;
        }
        
        .dark body {
            background: #1e293b;
        }
        
        /* Clean card design */
        .card {
            background: white;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            transition: all 0.2s ease-in-out;
        }
        
        .dark .card {
            background: #334155;
            border: 1px solid #475569;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3);
        }
        
        .card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transform: translateY(-1px);
        }
        
        .dark .card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.4), 0 2px 4px -1px rgba(0, 0, 0, 0.3);
        }
        
        /* Sidebar styles */
        .sidebar {
            background: white;
            border-right: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }
        
        .dark .sidebar {
            background: #1e293b;
            border-right: 1px solid #475569;
        }
        
        .sidebar-link {
            transition: all 0.2s ease-in-out;
            border-radius: 8px;
            margin: 2px 0;
        }
        
        .sidebar-link.active {
            background: #3b82f6;
            color: white;
        }
        
        .sidebar-link:hover {
            background: #f1f5f9;
            color: #3b82f6;
        }
        
        .dark .sidebar-link:hover {
            background: #475569;
            color: #60a5fa;
        }
        
        /* Mobile menu */
        .mobile-menu {
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mobile-menu.open {
            transform: translateX(0);
        }
        
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #3b82f6, #ec4899);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #2563eb, #db2777);
        }
        
        /* Loading animation */
        .loading-dots {
            display: inline-block;
        }
        
        .loading-dots::after {
            content: '';
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% { content: ''; }
            25% { content: '.'; }
            50% { content: '..'; }
            75% { content: '...'; }
        }
        
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Button effects */
        .btn-primary {
            background: #3b82f6;
            transition: all 0.2s ease-in-out;
        }
        
        .btn-primary:hover {
            background: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        }
        
        .btn-secondary {
            background: #6b7280;
            transition: all 0.2s ease-in-out;
        }
        
        .btn-secondary:hover {
            background: #4b5563;
        }
        
        /* Notification styles */
        .notification {
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        /* Mobile Bottom Navigation */
        .mobile-nav-item {
            color: #6c757d !important;
            transition: all 0.2s ease;
            border-radius: 8px;
            min-width: 60px;
        }
        
        .mobile-nav-item:hover,
        .mobile-nav-item.active {
            color: #3b82f6 !important;
            background-color: rgba(59, 130, 246, 0.1);
        }
        
        .mobile-nav-item i {
            transition: all 0.2s ease;
        }
        
        .mobile-nav-item.active i {
            transform: scale(1.1);
        }
        
        /* Dark Theme Styles */
        body.dark {
            background-color: #1a1a1a !important;
            color: #e5e5e5 !important;
        }
        
        body.dark .bg-light {
            background-color: #2d2d2d !important;
        }
        
        body.dark .bg-white {
            background-color: #1e1e1e !important;
        }
        
        body.dark .text-dark {
            color: #e5e5e5 !important;
        }
        
        body.dark .text-muted {
            color: #a0a0a0 !important;
        }
        
        body.dark .card {
            background-color: #1e1e1e !important;
            border-color: #404040 !important;
        }
        
        body.dark .content-card {
            background-color: #1e1e1e !important;
            border-color: #404040 !important;
        }
        
        body.dark .border-bottom {
            border-color: #404040 !important;
        }
        
        body.dark .border-top {
            border-color: #404040 !important;
        }
        
        body.dark .sidebar {
            background-color: #1e1e1e !important;
            border-color: #404040 !important;
        }
        
        body.dark .form-control {
            background-color: #2d2d2d !important;
            border-color: #404040 !important;
            color: #e5e5e5 !important;
        }
        
        body.dark .form-control:focus {
            background-color: #2d2d2d !important;
            border-color: #3b82f6 !important;
            color: #e5e5e5 !important;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25) !important;
        }
        
        body.dark .form-select {
            background-color: #2d2d2d !important;
            border-color: #404040 !important;
            color: #e5e5e5 !important;
        }
        
        body.dark .btn-light {
            background-color: #404040 !important;
            border-color: #404040 !important;
            color: #e5e5e5 !important;
        }
        
        body.dark .btn-light:hover {
            background-color: #4a4a4a !important;
            border-color: #4a4a4a !important;
        }
        
        body.dark .btn-outline-primary {
            border-color: #3b82f6 !important;
            color: #3b82f6 !important;
        }
        
        body.dark .btn-outline-primary:hover {
            background-color: #3b82f6 !important;
            color: white !important;
        }
        
        body.dark .btn-outline-danger {
            border-color: #ef4444 !important;
            color: #ef4444 !important;
        }
        
        body.dark .btn-outline-danger:hover {
            background-color: #ef4444 !important;
            color: white !important;
        }
        
        body.dark .badge.bg-light {
            background-color: #404040 !important;
            color: #e5e5e5 !important;
        }
        
        body.dark .icon-box {
            border-color: #404040 !important;
        }
        
        body.dark .navbar {
            background-color: #1e1e1e !important;
            border-color: #404040 !important;
        }
        
        body.dark .mobile-nav-item {
            color: #a0a0a0 !important;
        }
        
        body.dark .mobile-nav-item:hover,
        body.dark .mobile-nav-item.active {
            color: #3b82f6 !important;
            background-color: rgba(59, 130, 246, 0.1) !important;
        }
        
        body.dark .sidebar-link {
            color: #a0a0a0 !important;
        }
        
        body.dark .sidebar-link:hover,
        body.dark .sidebar-link.active {
            background-color: rgba(59, 130, 246, 0.1) !important;
            color: #3b82f6 !important;
        }
        
        body.dark .input-group-text {
            background-color: #2d2d2d !important;
            border-color: #404040 !important;
            color: #e5e5e5 !important;
        }
        
        body.dark .alert {
            background-color: #2d2d2d !important;
            border-color: #404040 !important;
            color: #e5e5e5 !important;
        }
        
        body.dark .table {
            color: #e5e5e5 !important;
        }
        
        body.dark .table th,
        body.dark .table td {
            border-color: #404040 !important;
        }
        
        body.dark .dropdown-menu {
            background-color: #1e1e1e !important;
            border-color: #404040 !important;
        }
        
        body.dark .dropdown-item {
            color: #e5e5e5 !important;
        }
        
        body.dark .dropdown-item:hover {
            background-color: #2d2d2d !important;
            color: #e5e5e5 !important;
        }
        
        /* Additional Dark Theme Text Fixes */
        body.dark h1, body.dark h2, body.dark h3, body.dark h4, body.dark h5, body.dark h6 {
            color: #e5e5e5 !important;
        }
        
        body.dark p {
            color: #e5e5e5 !important;
        }
        
        body.dark .card-title {
            color: #e5e5e5 !important;
        }
        
        body.dark .card-text {
            color: #a0a0a0 !important;
        }
        
        body.dark .fw-bold {
            color: #e5e5e5 !important;
        }
        
        body.dark .fw-medium {
            color: #e5e5e5 !important;
        }
        
        body.dark small {
            color: #a0a0a0 !important;
        }
        
        body.dark .badge {
            color: #e5e5e5 !important;
        }
        
        body.dark .badge.border {
            border-color: #404040 !important;
        }
        
        body.dark .list-group-item {
            background-color: #1e1e1e !important;
            border-color: #404040 !important;
            color: #e5e5e5 !important;
        }
        
        body.dark .nav-link {
            color: #a0a0a0 !important;
        }
        
        body.dark .nav-link:hover {
            color: #3b82f6 !important;
        }
        
        body.dark .breadcrumb {
            background-color: #2d2d2d !important;
        }
        
        body.dark .breadcrumb-item {
            color: #a0a0a0 !important;
        }
        
        body.dark .breadcrumb-item.active {
            color: #e5e5e5 !important;
        }
        
        body.dark .form-label {
            color: #e5e5e5 !important;
        }
        
        body.dark .form-text {
            color: #a0a0a0 !important;
        }
        
        body.dark .input-group-text {
            background-color: #2d2d2d !important;
            border-color: #404040 !important;
            color: #e5e5e5 !important;
        }
        
        body.dark .modal-content {
            background-color: #1e1e1e !important;
            border-color: #404040 !important;
        }
        
        body.dark .modal-header {
            border-color: #404040 !important;
        }
        
        body.dark .modal-footer {
            border-color: #404040 !important;
        }
        
        body.dark .modal-title {
            color: #e5e5e5 !important;
        }
        
        body.dark .close {
            color: #e5e5e5 !important;
        }
        
        /* Collapsible Sidebar Styles */
        .sidebar-collapsed {
            width: 60px !important;
            transition: width 0.3s ease;
            overflow: hidden;
        }
        
        .sidebar-collapsed .sidebar-brand {
            text-align: center;
            padding: 8px 2px !important;
        }
        
        .sidebar-collapsed .sidebar-brand h3 {
            display: none;
        }
        
        .sidebar-collapsed .sidebar-brand i {
            font-size: 1.2rem;
        }
        
        .sidebar-collapsed .sidebar-link span {
            display: none;
        }
        
        .sidebar-collapsed .sidebar-link {
            justify-content: center !important;
            padding: 8px 2px !important;
            margin: 1px 2px !important;
            border-radius: 6px;
            position: relative;
        }
        
        .sidebar-collapsed .sidebar-link i {
            margin: 0 !important;
            font-size: 1.1rem;
        }
        
        .sidebar-collapsed .p-3 {
            padding: 0.2rem !important;
        }
        
        .sidebar-collapsed #themeToggleSidebar span {
            display: none;
        }
        
        .sidebar-collapsed #themeToggleSidebar {
            padding: 4px !important;
            margin: 0 2px;
        }
        
        /* Tooltip Styles for Collapsed Sidebar */
        .sidebar-collapsed .sidebar-link::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 65px;
            top: 50%;
            transform: translateY(-50%);
            background: #333;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.875rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
            z-index: 1000;
            pointer-events: none;
        }
        
        .sidebar-collapsed .sidebar-link::before {
            content: '';
            position: absolute;
            left: 60px;
            top: 50%;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-right-color: #333;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
            z-index: 1000;
        }
        
        .sidebar-collapsed .sidebar-link:hover::after,
        .sidebar-collapsed .sidebar-link:hover::before {
            opacity: 1;
            visibility: visible;
        }
        
        body.dark .sidebar-collapsed .sidebar-link::after {
            background: #555;
            color: #e5e5e5;
        }
        
        body.dark .sidebar-collapsed .sidebar-link::before {
            border-right-color: #555;
        }
        
        .main-content-collapsed {
            margin-left: 60px !important;
            transition: margin-left 0.3s ease;
        }
        
        .main-content {
            transition: margin-left 0.3s ease;
        }
        
        @media (max-width: 991.98px) {
            .sidebar-collapsed {
                width: 280px !important;
            }
            .main-content-collapsed {
                margin-left: 280px !important;
            }
        }

        body.dark .pagination .page-link {
            background-color: #2d2d2d !important;
            border-color: #404040 !important;
            color: #e5e5e5 !important;
        }
        
        body.dark .pagination .page-link:hover {
            background-color: #404040 !important;
            border-color: #404040 !important;
            color: #e5e5e5 !important;
        }
        
        body.dark .pagination .page-item.active .page-link {
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
        }
        
        body.dark .toast {
            background-color: #1e1e1e !important;
            border-color: #404040 !important;
            color: #e5e5e5 !important;
        }
        
        body.dark .toast-header {
            background-color: #2d2d2d !important;
            border-color: #404040 !important;
            color: #e5e5e5 !important;
        }
        
        body.dark .progress {
            background-color: #2d2d2d !important;
        }
        
        body.dark .progress-bar {
            background-color: #3b82f6 !important;
        }
        
        body.dark .spinner-border {
            color: #3b82f6 !important;
        }
        
        body.dark .spinner-grow {
            color: #3b82f6 !important;
        }
        
        body.dark .accordion-item {
            background-color: #1e1e1e !important;
            border-color: #404040 !important;
        }
        
        body.dark .accordion-button {
            background-color: #2d2d2d !important;
            color: #e5e5e5 !important;
            border-color: #404040 !important;
        }
        
        body.dark .accordion-button:not(.collapsed) {
            background-color: #3b82f6 !important;
            color: white !important;
        }
        
        body.dark .accordion-body {
            background-color: #1e1e1e !important;
            color: #e5e5e5 !important;
        }
        
        body.dark .offcanvas {
            background-color: #1e1e1e !important;
            color: #e5e5e5 !important;
        }
        
        body.dark .offcanvas-header {
            border-color: #404040 !important;
        }
        
        body.dark .offcanvas-title {
            color: #e5e5e5 !important;
        }
        
        body.dark .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
        
        /* Badge color overrides for dark theme */
        body.dark .badge.bg-primary-subtle {
            background-color: rgba(59, 130, 246, 0.2) !important;
            color: #93c5fd !important;
        }
        
        body.dark .badge.bg-success-subtle {
            background-color: rgba(34, 197, 94, 0.2) !important;
            color: #86efac !important;
        }
        
        body.dark .badge.bg-warning-subtle {
            background-color: rgba(245, 158, 11, 0.2) !important;
            color: #fde047 !important;
        }
        
        body.dark .badge.bg-info-subtle {
            background-color: rgba(14, 165, 233, 0.2) !important;
            color: #7dd3fc !important;
        }
        
        body.dark .badge.bg-danger-subtle {
            background-color: rgba(239, 68, 68, 0.2) !important;
            color: #fca5a5 !important;
        }
        
        /* Icon box colors for dark theme */
        body.dark .icon-box.bg-primary-subtle {
            background-color: rgba(59, 130, 246, 0.2) !important;
        }
        
        body.dark .icon-box.bg-success-subtle {
            background-color: rgba(34, 197, 94, 0.2) !important;
        }
        
        body.dark .icon-box.bg-warning-subtle {
            background-color: rgba(245, 158, 11, 0.2) !important;
        }
        
        body.dark .icon-box.bg-info-subtle {
            background-color: rgba(14, 165, 233, 0.2) !important;
        }
        
        body.dark .icon-box.bg-danger-subtle {
            background-color: rgba(239, 68, 68, 0.2) !important;
        }
        
        /* Text color overrides for colored elements */
        body.dark .text-primary {
            color: #93c5fd !important;
        }
        
        body.dark .text-success {
            color: #86efac !important;
        }
        
        body.dark .text-warning {
            color: #fde047 !important;
        }
        
        body.dark .text-info {
            color: #7dd3fc !important;
        }
        
        body.dark .text-danger {
            color: #fca5a5 !important;
        }
        
        /* Placeholder text for dark theme */
        body.dark .form-control::placeholder {
            color: #6b7280 !important;
        }
        
        body.dark .form-select option {
            background-color: #2d2d2d !important;
            color: #e5e5e5 !important;
        }
        
        /* Search input specific styling */
        body.dark input[type="text"] {
            color: #e5e5e5 !important;
        }
        
        body.dark input[type="text"]::placeholder {
            color: #6b7280 !important;
        }
    </style>
</head>
<body id="body" class="bg-light">
    
    <!-- Mobile Bottom Navigation -->
    <nav class="navbar navbar-light bg-white border-top position-fixed bottom-0 start-0 end-0 d-lg-none" style="z-index: 1050; height: 70px;">
        <div class="container-fluid px-0">
            <div class="d-flex justify-content-around align-items-center w-100">
                <a href="index.php?page=dashboard" class="nav-link text-center p-2 mobile-nav-item" id="mobile-nav-dashboard">
                    <i class="fas fa-home d-block mb-1" style="font-size: 1.2rem;"></i>
                    <small class="d-block" style="font-size: 0.7rem;">Dashboard</small>
                </a>
                <a href="index.php?page=emailgenx" class="nav-link text-center p-2 mobile-nav-item" id="mobile-nav-emailgenx">
                    <i class="fas fa-envelope d-block mb-1" style="font-size: 1.2rem;"></i>
                    <small class="d-block" style="font-size: 0.7rem;">EmailGenX</small>
                </a>
                <a href="index.php?page=notesgenx" class="nav-link text-center p-2 mobile-nav-item" id="mobile-nav-notesgenx">
                    <i class="fas fa-sticky-note d-block mb-1" style="font-size: 1.2rem;"></i>
                    <small class="d-block" style="font-size: 0.7rem;">NotesGenX</small>
                </a>
                <a href="index.php?page=ideagenx" class="nav-link text-center p-2 mobile-nav-item" id="mobile-nav-ideagenx">
                    <i class="fas fa-lightbulb d-block mb-1" style="font-size: 1.2rem;"></i>
                    <small class="d-block" style="font-size: 0.7rem;">IdeaGenX</small>
                </a>
                <a href="index.php?page=webgenx" class="nav-link text-center p-2 mobile-nav-item" id="mobile-nav-webgenx">
                    <i class="fas fa-globe d-block mb-1" style="font-size: 1.2rem;"></i>
                    <small class="d-block" style="font-size: 0.7rem;">WebGenX</small>
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Notification Container -->
    <div id="notificationContainer" class="position-fixed" style="top: 1rem; right: 1rem; z-index: 1050;"></div>
    
    <div class="d-flex min-vh-100" style="gap: 0; margin: 0; padding: 0;">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar position-fixed position-lg-relative d-lg-flex flex-column" style="width: 280px; z-index: 1030; transform: translateX(-100%); transition: transform 0.3s ease;">
        <style>
            @media (max-width: 991.98px) {
                #sidebar {
                    display: none !important;
                }
                .main-content {
                    margin-left: 0 !important;
                    padding-bottom: 80px !important;
                }
                body {
                    padding-bottom: 70px;
                }
            }
            @media (min-width: 992px) {
                #sidebar {
                    transform: translateX(0) !important;
                }
                .main-content {
                    margin-left: 280px !important;
                }
            }
        </style>
            <!-- Logo Section -->
            <div class="p-3 border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box bg-primary">
                        <i class="fas fa-tasks text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Taskly</h5>
                        <small class="text-muted">AI Productivity Suite</small>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-fill p-3">
                <div class="nav nav-pills flex-column">
                    <a href="index.php" class="nav-link sidebar-link d-flex align-items-center gap-2 px-3 py-2 text-dark" id="nav-dashboard" data-tooltip="Dashboard">
                        <i class="fas fa-home"></i>
                        <span class="fw-medium">Dashboard</span>
                    </a>
                    <a href="index.php?page=emailgenx" class="nav-link sidebar-link d-flex align-items-center gap-2 px-3 py-2 text-dark" id="nav-emailgenx" data-tooltip="EmailGenX">
                        <i class="fas fa-envelope"></i>
                        <span class="fw-medium">EmailGenX</span>
                    </a>
                    <a href="index.php?page=notesgenx" class="nav-link sidebar-link d-flex align-items-center gap-2 px-3 py-2 text-dark" id="nav-notesgenx" data-tooltip="NotesGenX">
                        <i class="fas fa-sticky-note"></i>
                        <span class="fw-medium">NotesGenX</span>
                    </a>
                    <a href="index.php?page=ideagenx" class="nav-link sidebar-link d-flex align-items-center gap-2 px-3 py-2 text-dark" id="nav-ideagenx" data-tooltip="IdeaGenX">
                        <i class="fas fa-lightbulb"></i>
                        <span class="fw-medium">IdeaGenX</span>
                    </a>
                    <a href="index.php?page=docgenx" class="nav-link sidebar-link d-flex align-items-center gap-2 px-3 py-2 text-dark" id="nav-docgenx" data-tooltip="DocGenX">
                        <i class="fas fa-file-alt"></i>
                        <span class="fw-medium">DocGenX</span>
                    </a>
                    <a href="index.php?page=webgenx" class="nav-link sidebar-link d-flex align-items-center gap-2 px-3 py-2 text-dark" id="nav-webgenx" data-tooltip="WebGenX">
                        <i class="fas fa-globe"></i>
                        <span class="fw-medium">WebGenX</span>
                    </a>
                </div>
            </nav>
            
            <!-- Bottom Section -->
            <div class="p-3 border-top">
                <button id="themeToggleSidebar" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2 mb-2" title="Toggle Theme">
                    <i class="fas fa-moon"></i>
                    <span>Theme</span>
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <div id="mainContent" class="flex-fill main-content" style="margin-left: 280px;">
            <!-- Top Header -->
            <header class="bg-white border-bottom px-4 px-md-5 py-4">
                <div class="d-flex align-items-center">
                    <button id="sidebarToggle" class="btn btn-light me-3 d-none d-lg-block" title="Toggle Sidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h4 class="mb-0 fw-bold text-dark"></h4>
                </div>
            </header>
            
            <!-- Content Area -->
            <main class="p-3 bg-light min-vh-100">
                <?php include $content; ?>
            </main>
        </div>
    </div>
<script>
// Enhanced Theme Management
function setTheme(theme) {
    const body = document.getElementById('body');
    const themeIcon = document.querySelector('#themeToggle i');
    
    if (theme === 'dark') {
        body.classList.add('dark');
        localStorage.setItem('theme', 'dark');
        if (themeIcon) themeIcon.className = 'fas fa-sun';
    } else {
        body.classList.remove('dark');
        localStorage.setItem('theme', 'light');
        if (themeIcon) themeIcon.className = 'fas fa-moon';
    }
    
    // Add theme transition effect
    body.style.transition = 'all 0.3s ease';
    setTimeout(() => {
        body.style.transition = '';
    }, 300);
}

function toggleTheme() {
    const isDark = document.getElementById('body').classList.contains('dark');
    setTheme(isDark ? 'light' : 'dark');
    // Only show notification when user explicitly changes theme
    showNotification('Theme changed successfully!', 'success');
}

// Mobile Menu Management
function toggleMobileMenu() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('mobileMenuOverlay');
    const menuBtn = document.getElementById('mobileMenuBtn');
    const mainContent = document.getElementById('mainContent');
    
    sidebar.classList.toggle('show');
    overlay.classList.toggle('d-none');
    mainContent.classList.toggle('sidebar-open');
    
    // Update menu button icon
    const icon = menuBtn.querySelector('i');
    if (sidebar.classList.contains('show')) {
        icon.className = 'fas fa-times';
    } else {
        icon.className = 'fas fa-bars';
    }
}

// Enhanced Navigation
function highlightActiveSidebar() {
    const page = new URLSearchParams(window.location.search).get('page') || 'dashboard';
    
    // Handle desktop sidebar
    document.querySelectorAll('.sidebar-link').forEach(link => {
        link.classList.remove('active');
        // Add stagger animation
        link.style.animationDelay = `${Math.random() * 0.1}s`;
    });
    
    const activeLink = document.getElementById(`nav-${page}`);
    if (activeLink) {
        activeLink.classList.add('active');
    }
    
    // Handle mobile bottom navigation
    document.querySelectorAll('.mobile-nav-item').forEach(link => {
        link.classList.remove('active');
    });
    
    const activeMobileLink = document.getElementById(`mobile-nav-${page}`);
    if (activeMobileLink) {
        activeMobileLink.classList.add('active');
    }
}

// Task completion notification helper
function showTaskNotification(taskName, type = 'success') {
    const messages = {
        'email_generated': 'Email generated successfully! 📧',
        'content_generated': 'Content generated successfully! 🌐',
        'notes_generated': 'Notes generated successfully! 📝',
        'idea_generated': 'Ideas generated successfully! 💡',
        'document_generated': 'Document generated successfully! 📄',
        'content_copied': 'Content copied to clipboard! 📋',
        'file_exported': 'File exported successfully! 📥',
        'notes_saved': 'Notes saved successfully! 💾'
    };
    
    const message = messages[taskName] || `${taskName} completed successfully!`;
    showNotification(message, type);
}

// Notification System
function showNotification(message, type = 'info', duration = 3000) {
    const container = document.getElementById('notificationContainer');
    const notification = document.createElement('div');
    
    const icons = {
        success: 'fas fa-check-circle',
        error: 'fas fa-exclamation-circle',
        warning: 'fas fa-exclamation-triangle',
        info: 'fas fa-info-circle'
    };
    
    const colors = {
        success: 'alert-success',
        error: 'alert-danger',
        warning: 'alert-warning',
        info: 'alert-info'
    };
    
    notification.className = `alert ${colors[type]} alert-dismissible fade show position-relative mb-2`;
    notification.innerHTML = `
        <div class="d-flex align-items-center gap-2">
            <i class="${icons[type]}"></i>
            <span class="fw-medium">${message}</span>
            <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
        </div>
    `;
    
    container.appendChild(notification);
    
    // Trigger animation
    setTimeout(() => notification.classList.add('show'), 10);
    
    // Auto remove
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, duration);
}

// Enhanced Search Functionality
function initializeSearch() {
    const searchInput = document.querySelector('input[placeholder="Search tools..."]');
    if (!searchInput) return;
    
    const tools = [
        { name: 'Dashboard', url: 'index.php?page=dashboard', icon: 'fas fa-home' },
        { name: 'EmailGenX', url: 'index.php?page=emailgenx', icon: 'fas fa-envelope' },
        { name: 'NotesGenX', url: 'index.php?page=notesgenx', icon: 'fas fa-sticky-note' },
        { name: 'IdeaGenX', url: 'index.php?page=ideagenx', icon: 'fas fa-lightbulb' },
        { name: 'DocGenX', url: 'index.php?page=docgenx', icon: 'fas fa-file-alt' },
        { name: 'WebGenX', url: 'index.php?page=webgenx', icon: 'fas fa-globe' }
    ];
    
    let searchResults = null;
    
    searchInput.addEventListener('input', function(e) {
        const query = e.target.value.toLowerCase();
        
        if (query.length === 0) {
            if (searchResults) {
                searchResults.remove();
                searchResults = null;
            }
            return;
        }
        
        const filtered = tools.filter(tool => 
            tool.name.toLowerCase().includes(query)
        );
        
        if (!searchResults) {
            searchResults = document.createElement('div');
            searchResults.className = 'absolute top-full left-0 right-0 mt-2 glass-card rounded-xl p-2 z-50';
            searchInput.parentElement.style.position = 'relative';
            searchInput.parentElement.appendChild(searchResults);
        }
        
        searchResults.innerHTML = filtered.map(tool => `
            <a href="${tool.url}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-white/10 transition-all duration-200">
                <i class="${tool.icon} text-sm"></i>
                <span class="text-sm font-medium">${tool.name}</span>
            </a>
        `).join('');
    });
    
    // Close search results when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.parentElement.contains(e.target) && searchResults) {
            searchResults.remove();
            searchResults = null;
        }
    });
}

// Loading States
function showLoading(element) {
    element.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading<span class="loading-dots"></span>';
    element.disabled = true;
}

function hideLoading(element, originalText) {
    element.innerHTML = originalText;
    element.disabled = false;
}

// Smooth Page Transitions
function initializePageTransitions() {
    const links = document.querySelectorAll('a[href*="index.php?page="]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Add loading state
            const main = document.querySelector('main');
            main.style.opacity = '0.5';
            main.style.transition = 'opacity 0.3s ease';
            
            // Navigate after animation
            setTimeout(() => {
                window.location.href = this.href;
            }, 150);
        });
    });
}

// Sidebar Toggle Functionality
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleBtn = document.getElementById('sidebarToggle');
    
    if (sidebar && mainContent) {
        sidebar.classList.toggle('sidebar-collapsed');
        
        // Update toggle button icon and main content margin
        const icon = toggleBtn.querySelector('i');
        if (sidebar.classList.contains('sidebar-collapsed')) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
            mainContent.style.marginLeft = '60px';
            localStorage.setItem('sidebarCollapsed', 'true');
        } else {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
            mainContent.style.marginLeft = '280px';
            localStorage.setItem('sidebarCollapsed', 'false');
        }
    }
}

// Initialize sidebar state on page load
function initSidebar() {
    const sidebarCollapsed = localStorage.getItem('sidebarCollapsed');
    if (sidebarCollapsed === 'true') {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('sidebarToggle');
        
        if (sidebar && mainContent) {
            sidebar.classList.add('sidebar-collapsed');
            mainContent.style.marginLeft = '60px';
            
            const icon = toggleBtn.querySelector('i');
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        }
    }
}

// Initialize everything
document.addEventListener('DOMContentLoaded', function() {
    // Theme setup
    const savedTheme = localStorage.getItem('theme') || 'light';
    setTheme(savedTheme);
    
    // Event listeners
    document.getElementById('themeToggle')?.addEventListener('click', toggleTheme);
    document.getElementById('themeToggleSidebar')?.addEventListener('click', toggleTheme);
    document.getElementById('mobileMenuBtn')?.addEventListener('click', toggleMobileMenu);
    document.getElementById('sidebarToggle')?.addEventListener('click', toggleSidebar);
    
    // Initialize sidebar state
    initSidebar();
    document.getElementById('mobileMenuOverlay')?.addEventListener('click', toggleMobileMenu);
    
    // Initialize features
    highlightActiveSidebar();
    initializeSearch();
    initializePageTransitions();
    
    // Only show notifications when tasks are completed
    // Welcome notification removed - will only show when actions are taken
    
    // Add scroll effects
    let lastScrollY = window.scrollY;
    window.addEventListener('scroll', () => {
        const header = document.querySelector('header');
        if (window.scrollY > lastScrollY) {
            header.style.transform = 'translateY(-100%)';
        } else {
            header.style.transform = 'translateY(0)';
        }
        lastScrollY = window.scrollY;
    });
    
    // Add intersection observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationDelay = `${Math.random() * 0.3}s`;
                entry.target.classList.add('animate-slide-up');
            }
        });
    }, observerOptions);
    
    // Observe all cards
    document.querySelectorAll('.glass-card').forEach(card => {
        observer.observe(card);
    });
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + K for search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.querySelector('input[placeholder="Search tools..."]');
        if (searchInput) {
            searchInput.focus();
            showNotification('Search activated! Type to find tools.', 'info');
        }
    }
    
    // Ctrl/Cmd + D for theme toggle
    if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
        e.preventDefault();
        toggleTheme();
    }
    
    // Escape to close mobile menu
    if (e.key === 'Escape') {
        const sidebar = document.getElementById('sidebar');
        if (sidebar.classList.contains('show')) {
            toggleMobileMenu();
        }
    }
});
</script>
</body>
</html>