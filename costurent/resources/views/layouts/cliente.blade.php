
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') | Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            overflow-x: hidden;
        }
        #sidebar {
            min-width: 220px;
            max-width: 220px;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #212529;
            color: #fff;
        }
        #sidebar .nav-link {
            color: #ddd;
        }
        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background: #0d6efd;
            color: #fff;
        }
        #content {
            margin-left: 220px;
            padding: 2rem;
            background: #f8f9fa;
            min-height: 100vh;
        }
        .topbar {
            height: 56px;
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 1.5rem;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav id="sidebar" class="d-flex flex-column shadow">
        <div class="text-center py-4 border-bottom">
            <img src="{{ asset('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQGxS5jMgw9yIKNHAb2QShoLjOrnDxOhXG18Q&s') }}" alt="Usuario" class="rounded-circle mb-2" width="80" height="80">
            <h5 class="text-white m-0">{{ auth()->user()->nombre }}</h5>
        </div>
        <ul class="nav flex-column p-3">
            <li class="nav-item mb-2">
                <a href="{{ route('cliente.dashboard') }}" class="nav-link {{ request()->routeIs('cliente.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door me-2"></i> Mi Perfil
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('cliente.catalogo') }}" class="nav-link {{ request()->routeIs('cliente.catalogo') ? 'active' : '' }}">
                    <i class="bi bi-shop me-2"></i> Catálogo
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('cliente.alquileres.index') }}" class="nav-link {{ request()->routeIs('cliente.alquileres') ? 'active' : '' }}">
                    <i class="bi bi-bag-check me-2"></i> Mis Alquileres
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('logout') }}" class="nav-link text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>

    <div id="content">
        <div class="topbar">
            <span class="me-2">Bienvenido, {{ auth()->user()->nombre }}</span>
        </div>
        <main class="mt-4">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>