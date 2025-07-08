<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') | Cliente</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />

    <style>
  

        body {
            background: #f5f4f8;
            overflow-x: hidden;
        }

        #sidebar {
            min-width: 220px;
            max-width: 220px;
            min-height: 100vh;
            background: #2a2a3b;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
        }

        #sidebar .nav-link {
            color: #ccc;
            padding: 12px 20px;
            border-radius: 6px;
            margin-bottom: 6px;
            transition: all 0.2s ease-in-out;
        }

        #sidebar .nav-link:hover {
            background: #6f42c1;
            color: #fff;
        }

        #sidebar .nav-link.active {
            background: linear-gradient(to right, #6f42c1, #a88cf5);
            color: #fff;
            font-weight: 600;
        }

        #sidebar .nav-link i {
            font-size: 1.1rem;
        }

        #content {
            margin-left: 220px;
            padding: 2rem;
            min-height: 100vh;
            background: 
                linear-gradient(rgba(245, 244, 248, 0.57), rgba(245, 244, 248, 0.95)),
                url('https://i.pinimg.com/736x/b8/ab/7b/b8ab7bdd5bccc2db473fd68b5c7b93c5.jpg'); /* Fondo con disfraces */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .topbar {
            height: 60px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar span {
            font-weight: 500;
            color: #333;
        }

        .user-image {
            border: 2px solid #6f42c1;
        }
    </style>
    @stack('styles')
</head>
<body>

    {{-- Sidebar --}}
    <nav id="sidebar" class="d-flex flex-column shadow-sm">
        <div class="text-center py-4 border-bottom border-dark">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQGxS5jMgw9yIKNHAb2QShoLjOrnDxOhXG18Q&s"
                 alt="Usuario"
                 class="rounded-circle user-image mb-2"
                 width="80" height="80">
            <h5 class="text-white m-0">{{ auth()->user()->nombre }}</h5>
        </div>

        <ul class="nav flex-column p-3">
            <li class="nav-item">
                <a href="{{ route('cliente.dashboard') }}" class="nav-link {{ request()->routeIs('cliente.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door me-2"></i> Mi Perfil
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('cliente.catalogo') }}" class="nav-link {{ request()->routeIs('cliente.catalogo') ? 'active' : '' }}">
                    <i class="bi bi-shop me-2"></i> Catálogo
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('cliente.alquileres.index') }}" class="nav-link {{ request()->routeIs('cliente.alquileres') ? 'active' : '' }}">
                    <i class="bi bi-bag-check me-2"></i> Mis Alquileres
                </a>
            </li>
            <li class="nav-item mt-3">
                <a href="{{ route('logout') }}" class="nav-link text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>

    {{-- Contenido principal --}}
    <div id="content">
        <div class="topbar mb-4">
            <span>Bienvenid@, {{ auth()->user()->nombre }}</span>
        </div>

        <main>
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>