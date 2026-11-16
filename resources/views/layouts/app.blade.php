<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FRAMEO - Self Photo Studio')</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-brand {
            font-weight: 800;
            letter-spacing: 2px;
        }
        .btn-dark-frameo {
            background-color: #1a1a1a;
            color: #ffffff;
            border-radius: 8px;
        }
        .btn-dark-frameo:hover {
            background-color: #333333;
            color: #ffffff;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">FRAMEO.</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Beranda & Paket</a>
                    </li>
                    @auth
                        @if(Auth::user()->role === 'customer')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/my-reservations') }}">Reservasi Saya</a>
                            </li>
                        @elseif(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link fw-semibold text-dark" href="{{ url('/admin/dashboard') }}">Dashboard Admin</a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                        <li class="nav-item me-2">
                            <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-dark-frameo btn-sm px-3" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-medium" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-1"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="flex-grow-1 py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-top py-3 mt-auto text-center text-muted small">
        <div class="container">
            &copy; {{ date('Y') }} FRAMEO Self Photo Studio. All rights reserved.
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
