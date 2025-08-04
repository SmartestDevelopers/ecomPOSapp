<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'ECommerce Store') }}</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: #343a40;
            transition: all 0.3s;
            z-index: 1000;
        }
        
        .sidebar.collapsed {
            margin-left: -250px;
        }
        
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 12px 20px;
            border-radius: 0;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #495057;
        }
        
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        
        .main-content {
            margin-left: 250px;
            transition: all 0.3s;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        
        .main-content.expanded {
            margin-left: 0;
        }
        
        .navbar-brand {
            font-weight: 600;
        }
        
        .sidebar-toggle {
            background: none;
            border: none;
            color: #495057;
            font-size: 1.2rem;
        }
        
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        
        .stats-card {
            transition: transform 0.2s;
        }
        
        .stats-card:hover {
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }
            
            .sidebar.show {
                margin-left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="p-3">
            <h5 class="text-white mb-0">
                <i class="fas fa-cog me-2"></i>Admin Panel
            </h5>
        </div>
        
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                   href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>Dashboard
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" 
                   href="{{ route('products.index') }}">
                    <i class="fas fa-box"></i>Products
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" 
                   href="{{ route('categories.index') }}">
                    <i class="fas fa-tags"></i>Categories
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" 
                   href="{{ route('admin.orders.index') }}">
                    <i class="fas fa-shopping-cart"></i>Orders
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}" 
                   href="{{ route('admin.customers') }}">
                    <i class="fas fa-users"></i>Customers
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}" 
                   href="{{ route('admin.messages') }}">
                    <i class="fas fa-envelope"></i>Messages
                </a>
            </li>
            
            <hr class="my-3" style="border-color: #495057;">
            
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}" target="_blank">
                    <i class="fas fa-external-link-alt"></i>View Store
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>Logout
                </a>
            </li>
        </ul>
        
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </nav>
    
    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <!-- Top Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
            <div class="container-fluid">
                <button class="sidebar-toggle me-3" id="sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <span class="navbar-brand mb-0">@yield('page-title', 'Admin Dashboard')</span>
                
                <div class="ms-auto">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>{{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ url('/') }}" target="_blank">
                                <i class="fas fa-external-link-alt me-2"></i>View Store
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Page Content -->
        <div class="container-fluid py-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar toggle functionality
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });
        
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>
