<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - HR Portal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Vite -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8f9fc;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .sidebar .nav-link {
            color: #fff;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            margin: 0.25rem 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: #fff;
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }

        .navbar-brand {
            font-weight: 700;
            color: #fff !important;
        }

        .user-info {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
        }

        .user-name {
            color: #fff;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .user-role {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.75rem;
        }

        .page-header {
            background: #fff;
            border-bottom: 1px solid #e3e6f0;
            padding: 1.5rem 0;
            margin-bottom: 2rem;
        }

        .page-title {
            color: #5a5c69;
            font-weight: 600;
            margin: 0;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            color: #858796;
        }

        .breadcrumb-item a {
            color: #5a5c69;
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: #4e73df;
        }

        .breadcrumb-item.active {
            color: #858796;
        }

        @media (max-width: 767.98px) {
            .sidebar {
                margin-left: -250px;
                transition: margin-left 0.3s ease;
            }

            .sidebar.show {
                margin-left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
            }
        }

        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1000;
            background: #4e73df;
            color: white;
            border: none;
            border-radius: 0.25rem;
            padding: 0.5rem;
        }

        .alert {
            border: none;
            border-radius: 0.5rem;
        }

        .btn {
            border-radius: 0.375rem;
            font-weight: 500;
        }

        .table {
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #5a5c69;
            background-color: #f8f9fc;
        }

        .badge {
            font-weight: 500;
        }

        .form-control, .form-select {
            border-radius: 0.375rem;
            border: 1px solid #d1d3e2;
        }

        .form-control:focus, .form-select:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .text-primary {
            color: #4e73df !important;
        }

        .bg-primary {
            background-color: #4e73df !important;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Sidebar Toggle Button (Mobile) -->
        <button class="sidebar-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse" id="sidebar">
            <div class="position-sticky pt-3">
                <!-- User Info -->
                <div class="user-info text-center">
                    <div class="user-avatar">
                        <i class="fas fa-user-tie fa-lg"></i>
                    </div>
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">HR Manager</div>
                </div>
                
                <!-- Navigation Menu -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('hr.dashboard') ? 'active' : '' }}" 
                           href="{{ route('hr.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span class="ms-2">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('hr.employee-registration*') ? 'active' : '' }}" 
                           href="{{ route('hr.employee-registration') }}">
                            <i class="fas fa-user-plus"></i>
                            <span class="ms-2">Register Employee</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('hr.employees*') ? 'active' : '' }}" 
                           href="{{ route('hr.employees.index') }}">
                            <i class="fas fa-users"></i>
                            <span class="ms-2">Employee Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('passwords*') ? 'active' : '' }}" 
                           href="{{ route('passwords.index') }}">
                            <i class="fas fa-key"></i>
                            <span class="ms-2">Password Manager</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-chart-bar"></i>
                            <span class="ms-2">Reports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-cog"></i>
                            <span class="ms-2">Settings</span>
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <a class="nav-link text-warning" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="ms-2">Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-title">
                                @yield('page-title', 'HR Portal')
                            </h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    @yield('breadcrumbs')
                                </ol>
                            </nav>
                        </div>
                        <div class="btn-toolbar">
                            @yield('page-actions')
                            <div class="btn-group ms-2">
                                <a href="{{ route('logout') }}" 
                                   class="btn btn-outline-danger"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-1"></i>
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            
            if (window.innerWidth <= 767.98) {
                if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
