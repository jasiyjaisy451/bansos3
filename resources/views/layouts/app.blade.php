<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Bansos Pendidikan') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --red-pertamina: #ED1C24;
            --blue-pertamina: #0071BC;
            --green-pertamina: #40B14B;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--blue-pertamina), var(--green-pertamina));
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 12px 20px;
            margin: 5px 0;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateX(6px);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            background: linear-gradient(90deg, var(--red-pertamina), var(--blue-pertamina));
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: bold;
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .table th {
            background: var(--blue-pertamina);
            color: white;
        }

        .logo-pertamina {
            height: 60px;
            margin-bottom: 10px;
        }

        .sidebar-header h5 {
            font-weight: bold;
            color: white;
        }

        .alert-success {
            border-left: 5px solid var(--green-pertamina);
        }

        .alert-danger {
            border-left: 5px solid var(--red-pertamina);
        }
    </style>
</head>
<body class="bg-light">
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
            <div class="position-sticky pt-3 text-center sidebar-header">
                <img src="https://akiradata.co.id/wp-content/uploads/2020/05/logo-pertamina.png" alt="Logo Pertamina" class="logo-pertamina">
                <h5>Sistem Bansos</h5>
                <h5>Pendidikan</h5>
                <hr class="border-light">
                <ul class="nav flex-column text-start px-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('recipients.*') ? 'active' : '' }}" href="{{ route('recipients.index') }}">
                            <i class="fas fa-users me-2"></i> Data Penerima
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('recipients.scan') ? 'active' : '' }}" href="{{ route('recipients.scan') }}">
                            <i class="fas fa-qrcode me-2"></i> Scan QR Code
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <a class="nav-link text-light" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">@yield('title', 'Dashboard')</h1>
                <div class="text-muted">
                    <i class="fas fa-user me-1"></i>
                    {{ Auth::user()->name ?? 'Admin' }}
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@stack('scripts')
</body>
</html>
