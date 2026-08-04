<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoanBridge - Loan Eligibility</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --primary: #0d6efd;
        --bg-gradient: linear-gradient(135deg, #f5f7fa, #c3cfe2);
    }
    body {
        font-family: 'Inter', sans-serif;
        background: var(--bg-gradient);
        min-height: 100vh;
    }
        .form-control {
        border-radius: .75rem;
        padding: .75rem 1rem;
        transition: border-color .2s ease, box-shadow .2s ease;
    }
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 .5rem rgba(13,110,253,.25);
    }
    .btn-primary {
        border-radius: .5rem;
        padding: .75rem 1.5rem;
    }
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 36px rgba(0,0,0,0.15);
    }
    .btn-primary {
        background: var(--primary);
        border: none;
        padding: 0.75rem 1.25rem;
        font-weight: 600;
        transition: background 0.3s ease, transform 0.2s ease;
    }
    .btn-primary:hover {
        background: #0b5ed7;
        transform: translateY(-2px);
    }
    .alert { animation: fadeIn 0.4s ease; }
    @keyframes fadeIn { from {opacity:0; transform:translateY(-10px);} to {opacity:1; transform:translateY(0);} }
</style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">LoanBridge</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Apply Loan</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="/admin">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link text-white text-decoration-none">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/admin">Admin Panel</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-dismiss all alerts after 10 seconds
        $(document).ready(function() {
            function autoDismissAlerts() {
                $('.alert').each(function() {
                    var alertEl = $(this);
                    if (!alertEl.data('auto-dismiss-set')) {
                        alertEl.data('auto-dismiss-set', true);
                        setTimeout(function() {
                            alertEl.fadeOut(500, function() { $(this).remove(); });
                        }, 10000);
                    }
                });
            }
            autoDismissAlerts();
            // Also watch for dynamically injected alerts (e.g. from AJAX)
            var observer = new MutationObserver(autoDismissAlerts);
            observer.observe(document.body, { childList: true, subtree: true });
        });
    </script>
</body>
</html>
