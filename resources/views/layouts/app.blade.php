<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoanBridge - Loan Eligibility</title>
    
    <!-- Google Fonts: Plus Jakarta Sans for headers, Inter for UI text -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        :root {
            color-scheme: dark;
            --primary: #4f46e5;
            --primary-light: #818cf8;
            --primary-dark: #3730a3;
            --secondary: #10b981;
            --bg-gradient: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #311042 100%);
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-card-bg: rgba(255, 255, 255, 0.05);
            --glass-card-hover-border: rgba(255, 255, 255, 0.15);
            --text-muted: #94a3b8;
            --text-main: #f8fafc;
            --bs-body-color: #f8fafc;
            --bs-heading-color: #ffffff;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-gradient);
            background-attachment: fixed;
            color: var(--text-main) !important;
            min-height: 100vh;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6,
        .h1, .h2, .h3, .h4, .h5, .h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: #ffffff !important;
        }

        p, span, div, label {
            color: inherit;
        }

        /* Floating glass header */
        .navbar {
            background: rgba(15, 23, 42, 0.4) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--glass-border);
            padding: 1rem 0;
            z-index: 1000;
        }
        
        .navbar-brand {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #a5b4fc 0%, #818cf8 50%, #c084fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .navbar-nav .nav-link {
            color: #cbd5e1 !important;
            font-weight: 500;
            padding: 0.5rem 1.2rem !important;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-1px);
        }

        /* Modern Sidebar */
        .dashboard-sidebar {
            background: rgba(15, 23, 42, 0.3);
            backdrop-filter: blur(16px);
            border-right: 1px solid var(--glass-border);
            height: calc(100vh - 76px);
            position: sticky;
            top: 76px;
            padding: 2rem 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .sidebar-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-muted);
            padding-left: 1rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.85rem 1.25rem;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 0.75rem;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-link i {
            font-size: 1.25rem;
            transition: transform 0.3s ease;
        }

        .sidebar-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.06);
        }

        .sidebar-link:hover i {
            transform: scale(1.15);
        }

        .sidebar-link.active {
            color: #ffffff;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.2) 0%, rgba(129, 140, 248, 0.1) 100%);
            border-left: 3px solid var(--primary-light);
            font-weight: 600;
        }

        /* Glassmorphism Main Content Grid */
        .main-content {
            padding: 2.5rem;
        }

        /* Premium Glass Card with subtle glowing effects */
        .glass-card {
            background: var(--glass-card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 1.25rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -50%;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.03), transparent);
            transform: skewX(-25deg);
            transition: 0.75s;
            pointer-events: none;
        }

        .glass-card:hover::before {
            left: 125%;
        }

        .glass-card:hover {
            transform: translateY(-6px);
            border-color: var(--glass-card-hover-border);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4), 0 0 40px rgba(99, 102, 241, 0.1);
        }

        .card-header {
            background: rgba(255, 255, 255, 0.01) !important;
            border-bottom: 1px solid var(--glass-border) !important;
            padding: 1.5rem !important;
        }

        .card-body {
            padding: 1.75rem !important;
        }

        /* Super Premium Form Elements */
        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #cbd5e1;
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--glass-border);
            color: #ffffff;
            border-radius: 0.75rem;
            padding: 0.75rem 1.15rem;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-control:focus, .form-select:focus {
            background: rgba(15, 23, 42, 0.8);
            border-color: var(--primary-light);
            color: #ffffff;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.25);
        }

        .form-control::placeholder {
            color: #64748b;
        }

        /* Buttons with high-tech glowing state */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 0.75rem;
            padding: 0.85rem 2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 20px rgba(79, 70, 229, 0.4);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.6);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* Dynamic Table Customization — kill ALL Bootstrap white backgrounds and fix text color */
        .table,
        .table > :not(caption) > * > * {
            color: #ffffff !important;
            background-color: transparent !important;
            border-color: var(--glass-border) !important;
            --bs-table-bg: transparent !important;
            --bs-table-striped-bg: rgba(255, 255, 255, 0.02) !important;
            --bs-table-hover-bg: rgba(255, 255, 255, 0.04) !important;
            --bs-table-active-bg: transparent !important;
            --bs-table-color: #ffffff !important;
            --bs-table-striped-color: #ffffff !important;
            --bs-table-hover-color: #ffffff !important;
            --bs-table-active-color: #ffffff !important;
        }

        .table-light,
        .table-light > th,
        .table-light > td,
        .table-dark,
        .table-dark > th,
        .table-dark > td,
        .table-striped > tbody > tr:nth-of-type(odd) > * {
            background-color: transparent !important;
            --bs-table-bg: transparent !important;
            --bs-table-color: #ffffff !important;
            --bs-table-striped-color: #ffffff !important;
            color: #ffffff !important;
        }

        .table thead {
            background: rgba(255, 255, 255, 0.03) !important;
        }

        .table th {
            color: #ffffff !important;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--glass-border) !important;
        }

        .table td {
            font-size: 0.9rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--glass-border) !important;
        }

        .table-hover > tbody > tr:hover > * {
            background-color: rgba(255, 255, 255, 0.04) !important;
            color: #ffffff !important;
        }

        /* Card-header overrides — no white backgrounds */
        .card-header.bg-light,
        .card-header.bg-white,
        .card-header.bg-dark {
            background: rgba(255, 255, 255, 0.01) !important;
            color: #ffffff !important;
        }

        /* Table-dark header override */
        .table-dark,
        thead.table-dark {
            background: rgba(255, 255, 255, 0.03) !important;
            --bs-table-bg: transparent !important;
        }

        /* Button outline overrides for dark theme */
        .btn-outline-primary {
            color: var(--primary-light) !important;
            border-color: var(--primary-light) !important;
            background: transparent !important;
        }
        .btn-outline-primary:hover {
            background: rgba(79, 70, 229, 0.15) !important;
            color: #ffffff !important;
        }

        .btn-outline-secondary,
        .btn-secondary {
            color: #cbd5e1 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            background: rgba(255, 255, 255, 0.03) !important;
        }
        .btn-secondary:hover,
        .btn-outline-secondary:hover {
            background: rgba(255, 255, 255, 0.08) !important;
            color: #ffffff !important;
        }

        .btn-outline-danger {
            color: #f87171 !important;
            border-color: rgba(239, 68, 68, 0.3) !important;
            background: transparent !important;
        }
        .btn-outline-danger:hover {
            background: rgba(239, 68, 68, 0.15) !important;
            color: #ffffff !important;
        }

        .btn-danger {
            background: rgba(239, 68, 68, 0.25) !important;
            border-color: rgba(239, 68, 68, 0.3) !important;
            color: #fca5a5 !important;
        }
        .btn-danger:hover {
            background: rgba(239, 68, 68, 0.4) !important;
            color: #ffffff !important;
        }

        /* Card footer override */
        .card-footer {
            background: transparent !important;
            border-top: 1px solid var(--glass-border) !important;
        }

        /* Pagination for dark theme */
        .page-link {
            background: rgba(255, 255, 255, 0.03) !important;
            border-color: var(--glass-border) !important;
            color: #cbd5e1 !important;
        }
        .page-link:hover {
            background: rgba(79, 70, 229, 0.15) !important;
            color: #ffffff !important;
        }
        .page-item.active .page-link {
            background: var(--primary) !important;
            border-color: var(--primary) !important;
            color: #ffffff !important;
        }
        .page-item.disabled .page-link {
            background: rgba(255, 255, 255, 0.01) !important;
            color: #475569 !important;
        }

        /* Custom alert styles */
        .alert {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid var(--glass-border);
            border-radius: 0.75rem;
            color: #ffffff;
            backdrop-filter: blur(10px);
            animation: slideInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .alert-success {
            border-color: rgba(16, 185, 129, 0.3);
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.1);
        }

        .alert-danger {
            border-color: rgba(239, 68, 68, 0.3);
            box-shadow: 0 4px 20px rgba(239, 68, 68, 0.1);
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #0f172a;
        }
        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }

        @media (max-width: 992px) {
            .dashboard-sidebar { display: none; }
        }
    </style>
</head>
<body>
    <!-- Navbar Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center gap-2" href="/">
                <i class="bi bi-cpu text-indigo-400"></i> LoanBridge
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-2">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="bi bi-file-earmark-plus me-1"></i> Apply Loan</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="/admin"><i class="bi bi-grid-1x2-fill me-1"></i> Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link text-white text-decoration-none d-flex align-items-center"><i class="bi bi-box-arrow-right me-1"></i> Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/admin"><i class="bi bi-lock me-1"></i> Admin Panel</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar for large screens -->
            <nav class="col-lg-2 d-none d-lg-flex dashboard-sidebar">
                <div class="sidebar-title">Loan Options</div>
                <a href="/" class="sidebar-link {{ Request::is('/') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i> Apply Loan
                </a>
                @auth
                    <a href="/admin" class="sidebar-link {{ Request::is('admin*') ? 'active' : '' }}">
                        <i class="bi bi-grid"></i> Dashboard
                    </a>
                @else
                    <a href="/admin" class="sidebar-link {{ Request::is('admin*') ? 'active' : '' }}">
                        <i class="bi bi-shield-lock"></i> Admin Panel
                    </a>
                @endauth
            </nav>
            
            <!-- Main Content Area -->
            <main class="col-lg-10 main-content">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function(){
            function autoDismiss(){
                $('.alert').each(function(){
                    var $a=$(this);
                    if(!$a.data('dismissed')){ 
                        $a.data('dismissed',true); 
                        setTimeout(()=>{
                            $a.fadeOut(500,function(){$(this).remove();});
                        },10000); 
                    }
                });
            }
            autoDismiss();
            const obs=new MutationObserver(autoDismiss);
            obs.observe(document.body,{childList:true,subtree:true});
        });
    </script>
</body>
</html>
