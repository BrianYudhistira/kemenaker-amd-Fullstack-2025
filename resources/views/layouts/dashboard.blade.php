<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Dashboard') - PetCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        :root {
            --sidebar-bg: #ffffff;
            --main-bg: #f8f9fa;
            --border-color: #dee2e6;
            --text-primary: #000000;
            --text-secondary: #6c757d;
            --hover-bg: #e9ecef;
            --active-bg: #000000;
        }
        body { background-color: var(--main-bg); padding-top: 56px; }
        .navbar { 
            background-color: #000000 !important; 
            border-bottom: 1px solid #000000; 
        }
        .sidebar { 
            background-color: var(--sidebar-bg); 
            border-right: 1px solid var(--border-color);
            position: fixed;
            top: 56px;
            bottom: 0;
            left: 0;
            z-index: 100;
            overflow-y: auto;
        }
        .main-content {
            margin-left: 0;
        }
        @media (min-width: 768px) {
            .main-content {
                margin-left: 16.666667%;
            }
        }
        @media (min-width: 1200px) {
            .main-content {
                margin-left: 16.666667%;
            }
        }
        .nav-link { 
            color: var(--text-secondary); 
            transition: all 0.2s ease;
            border-radius: 6px;
            padding: 8px 12px;
        }
        .nav-link:hover { 
            color: var(--text-primary); 
            background-color: var(--hover-bg); 
        }
        .nav-link.active { 
            color: #ffffff !important; 
            background-color: var(--active-bg) !important; 
            font-weight: 500; 
        }
        .nav-pills .nav-link.active {
            color: #ffffff !important; 
            background-color: #000000 !important; 
        }
        .navbar-nav .nav-link:hover {
            background-color: #1a1a1a;
        }
        .navbar-nav .nav-link.text-white:hover {
            background-color: #2a2a2a;
        }
    </style>
    @yield('extra-css')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark p-2 fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="/">PetCare+</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTop" aria-controls="navbarTop" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTop">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->is('overview') ? 'text-white' : 'text-white-50' }}" href="/overview">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('owners*') ? 'text-white' : 'text-white-50' }}" href="/owners">Owners</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('pets*') ? 'text-white' : 'text-white-50' }}" href="/pets">Pets</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('checkups*') ? 'text-white' : 'text-white-50' }}" href="/checkups">Checkups</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <aside class="col-md-3 col-xl-2 px-0 sidebar">
                <div class="d-flex flex-column align-items-stretch pt-3 px-3 h-100">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item mb-1"><a href="/overview" class="nav-link {{ request()->is('overview') ? 'active' : '' }}">Overview</a></li>
                        <li class="mb-1"><a href="/owners" class="nav-link {{ request()->is('owners*') ? 'active' : '' }}">Owners</a></li>
                        <li class="mb-1"><a href="/pets" class="nav-link {{ request()->is('pets*') ? 'active' : '' }}">Pets</a></li>
                        <li class="mb-1"><a href="/checkups" class="nav-link {{ request()->is('checkups*') ? 'active' : '' }}">Checkups</a></li>
                    </ul>
                    <div class="mt-auto small text-muted py-3 border-top">&copy; {{ date('Y') }} PetCare+</div>
                </div>
            </aside>
            <main class="col-md-9 col-xl-10 main-content py-4 px-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    @yield('extra-js')
</body>
</html>
