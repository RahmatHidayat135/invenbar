<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'InvenBar') }}</title>

    <!-- Bootstrap Lokal -->
    <link href="{{ asset('bootstrap/font/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="min-vh-100 bg-light pb-4">
        {{-- Navigation --}}
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center fw-bold text-primary" href="{{ url('/') }}">
                    <i class="bi bi-box-seam fs-3 me-2"></i> InvenBar
                </a>

                <!-- Menu -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold text-primary' : '' }}"
                               href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('barang.*') ? 'active fw-bold text-primary' : '' }}"
                               href="{{ route('barang.index') }}">Barang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('lokasi.*') ? 'active fw-bold text-primary' : '' }}"
                               href="{{ route('lokasi.index') }}">Lokasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('kategori.*') ? 'active fw-bold text-primary' : '' }}"
                               href="{{ route('kategori.index') }}">Kategori</a>
                        </li>

                        {{-- ✅ Menu Sumber Dana baru ditambahkan di sini --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('sumber-dana.*') ? 'active fw-bold text-primary' : '' }}"
                               href="{{ route('sumber-dana.index') }}">Sumber Dana</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('peminjaman.*') ? 'active fw-bold text-primary' : '' }}"
                               href="{{ route('peminjaman.index') }}">Peminjaman</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.*') ? 'active fw-bold text-primary' : '' }}"
                               href="{{ route('user.index') }}">User</a>
                        </li>
                    </ul>

                    <!-- Dropdown User -->
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-bold" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                {{ auth()->user()->name ?? 'Administrator' }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @hasSection('header')
            <header class="bg-white shadow-sm">
                <div class="container py-4">
                    @yield('header')
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="container mt-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS Lokal -->
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
