<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Sistem Kasir Restoran</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }
    .sidebar {
        min-height: 100vh;
        background-color: #343a40;
        padding-top: 20px;
    }
    .sidebar .nav-link {
        color: #fff;
        padding: 10px 15px;
        margin: 2px 10px;
        border-radius: 4px;
    }
    .sidebar .nav-link:hover {
        background-color: #495057;
        color: #fff;
    }
    .sidebar .nav-link.active {
        background-color: #007bff;
        color: #fff;
    }
    .main-content {
        padding: 20px;
        background-color: #f8f9fa;
    }
    .navbar {
        background-color: #343a40 !important;
    }
    .navbar-brand {
        color: #fff !important;
        font-weight: bold;
    }
    .navbar-nav .nav-link {
        color: #fff !important;
    }
    .card {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        font-weight: bold;
    }
    .btn {
        border-radius: 4px;
    }
    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
    }
</style>

</head>
<body>
    <div id="app">
        @if(Auth::check())          
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    WARYUL
                </a>
                
                <div class="navbar-nav ms-auto">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->namauser }} ({{ ucfirst(Auth::user()->role) }})
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Keluar</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->routeIs('dashboard')) ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                        
                        @if(in_array(Auth::user()->role, ['admin']))
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->routeIs('mejas.*')) ? 'active' : '' }}" href="{{ route('mejas.index') }}">
                                Meja
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->routeIs('menus.*')) ? 'active' : '' }}" href="{{ route('menus.index') }}">
                                Menu
                            </a>
                        </li>
                        @endif
                        
                        @if(in_array(Auth::user()->role, ['waiter']))
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->routeIs('menus.*')) ? 'active' : '' }}" href="{{ route('menus.index') }}">
                                Menu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->routeIs('pelanggans.*')) ? 'active' : '' }}" href="{{ route('pelanggans.index') }}">
                                Pelanggan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->routeIs('pesanans.*')) ? 'active' : '' }}" href="{{ route('pesanans.index') }}">
                                Pesanan
                            </a>
                        </li>
                        @endif
                        
                        @if(Auth::user()->role == 'kasir')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->routeIs('transaksis.*')) ? 'active' : '' }}" href="{{ route('transaksis.index') }}">
                                Transaksi
                            </a>
                        </li>
                        @endif
                        
                        @if(in_array(Auth::user()->role, ['waiter', 'kasir', 'owner']))
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->routeIs('laporan.*')) ? 'active' : '' }}" href="{{ route('laporan.index') }}">
                                Laporan
                            </a>
                        </li>
                        @endif
                    </ul>
                </nav>

                <!-- Konten Utama -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                    @yield('content')
                </main>
            </div>
        </div>
        @else
            @yield('content')
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</body>
</html>
