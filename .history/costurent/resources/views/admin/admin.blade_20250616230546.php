{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') | Admin Panel</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            overflow-x: hidden;
        }
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #343a40;
            color: #fff;
            transition: all 0.3s;
            z-index: 1030;
        }
        #sidebar .nav-link {
            color: #ddd;
            font-weight: 500;
            transition: background 0.3s, color 0.3s;
        }
        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background: #0d6efd;
            color: #fff;
        }
        #content {
            margin-left: 250px;
            padding: 2rem;
            min-height: 100vh;
            background: #f8f9fa;
        }
        .topbar {
            height: 56px;
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            z-index: 1040;
        }
        .topbar .user-info {
            font-weight: 500;
            color: #333;
        }
        @media (max-width: 768px) {
            #sidebar {
                left: -250px;
            }
            #sidebar.active {
                left: 0;
            }
            #content {
                margin-left: 0;
                padding-top: 56px;
            }
            .topbar {
                left: 0;
            }
            #sidebarToggle {
                display: inline-block;
                cursor: pointer;
                color: #0d6efd;
                font-size: 1.5rem;
                margin-right: auto;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav id="sidebar" class="shadow d-flex flex-column">
        <div class="text-center py-4 border-bottom">
            <img src="{{ asset('https://b2472105.smushcdn.com/2472105/wp-content/uploads/2025/03/Poses-Perfil-Profesional-Hombres-jul.-23-2022-6-819x1024.jpg?lossy=1&strip=1&webp=1') }}" alt="Admin" class="rounded-circle mb-2" width="80" height="80">
            <h3 class="fw-bold text-white m-0">Admin Panel</h3>
        </div>
        <div class="px-3 pt-3 flex-grow-1">
            <ul class="nav flex-column">
                <li class="nav-item mb-1">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('admin.clientes.index') }}" class="nav-link {{ request()->routeIs('admin.clientes.*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill me-2"></i> Clientes
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('admin.disfraces.index') }}" class="nav-link {{ request()->routeIs('admin.disfraces.*') ? 'active' : '' }}">
                        <i class="bi bi-person-badge-fill me-2"></i> Disfraces
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('admin.alquileres.index') }}" class="nav-link {{ request()->routeIs('admin.alquileres.*') ? 'active' : '' }}">
                        <i class="bi bi-bag-check-fill me-2"></i> Alquileres
                    </a>
                </li>
            </ul>
        </div>

        <!-- Botón de Cerrar Sesión al final del sidebar -->
        <div class="mt-auto px-3 pb-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger w-100">
                    <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                </button>
            </form>
        </div>
    </nav>

    <div id="content">
        <div class="topbar">
            <span id="sidebarToggle" class="d-md-none"><i class="bi bi-list"></i></span>
            <div class="user-info d-flex align-items-center gap-3 ms-auto">
                <span>Bienvenido, {{ auth()->user()->nombre ?? 'Admin' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Cerrar sesión">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>

        <main class="mt-5 pt-3">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS + Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
    @stack('scripts')
</body>
</html>
