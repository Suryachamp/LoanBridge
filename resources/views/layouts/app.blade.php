<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyBeing - Loan Eligibility</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { background-color: #f8f9fa; }
        .navbar { box-shadow: 0 2px 4px rgba(0,0,0,.1); }
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
                    <li class="nav-item">
                        <a class="nav-link" href="/admin">Admin Panel</a>
                    </li>
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
