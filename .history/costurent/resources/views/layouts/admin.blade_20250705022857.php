<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') | Admin Panel</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --sidebar-hover: rgba(255, 255, 255, 0.1);
            --sidebar-active: rgba(255, 255, 255, 0.2);
            --content-bg: #f8fafc;
        }


        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--content-bg);
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--sidebar-bg);
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1030;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header img {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.3);
            transition: transform 0.3s ease;
        }

        .sidebar-header img:hover {
            transform: scale(1.05);
        }

        .sidebar-header h5 {
            margin: 0.75rem 0 0 0;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .sidebar-nav {
            padding: 1rem 0;
            flex-grow: 1;
        }

        .nav-item {
            margin: 0.25rem 0.75rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 0.75rem 1rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-link:hover {
            background: var(--sidebar-hover);
            color: white;
            transform: translateX(4px);
        }

        .nav-link.active {
            background: var(--sidebar-active);
            color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .nav-link i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 1rem 0.75rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-logout {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 12px;
            background: rgba(220, 53, 69, 0.9);
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: rgba(220, 53, 69, 1);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        #content {
            margin-left: var(--sidebar-width);
            background: var(--content-bg);
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            max-width: 100%;
            overflow-x: hidden;
        }

        .topbar {
            height: var(--topbar-height);
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .topbar .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-weight: 500;
            color: #64748b;
        }

        .btn-topbar-logout {
            padding: 0.5rem 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: white;
            color: #dc3545;
            transition: all 0.3s ease;
        }

        .btn-topbar-logout:hover {
            background: #dc3545;
            color: white;
            border-color: #dc3545;
        }

        .main-content {
            max-width: 100%;
            box-sizing: border-box;
        }

        #sidebarToggle {
            display: none;
            font-size: 1.5rem;
            color: #667eea;
            cursor: pointer;
            margin-right: auto;
        }

        @media (max-width: 768px) {
            #sidebar {
                left: calc(-1 * var(--sidebar-width));
            }

            #sidebar.active {
                left: 0;
            }

            #content {
                margin-left: 0;
                width: 100%;
            }

            #sidebarToggle {
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav id="sidebar" class="d-flex flex-column">
        <div class="sidebar-header">
            @php
                $imagen = auth()->user()->imagen 
                    ? asset('storage/' . auth()->user()->imagen)
                    : asset('images/default-user.png');
            @endphp

            <img src="{{ $imagen }}?t={{ time() }}" alt="Admin">
            <h5>{{ auth()->user()->nombre ?? 'Administrador' }}</h5>
        </div>

        <div class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.perfil') }}" class="nav-link {{ request()->routeIs('admin.perfil') ? 'active' : '' }}">
                        <i class="bi bi-person-circle"></i> Mi Perfil
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.clientes.index') }}" class="nav-link {{ request()->routeIs('admin.clientes.*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i> Clientes
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.disfraces.index') }}" class="nav-link {{ request()->routeIs('admin.disfraces.*') ? 'active' : '' }}">
                        <i class="bi bi-person-badge-fill"></i> Disfraces
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.alquileres.index') }}" class="nav-link {{ request()->routeIs('admin.alquileres.*') ? 'active' : '' }}">
                        <i class="bi bi-bag-check-fill"></i> Alquileres
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-logout">
                    <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                </button>
            </form>
        </div>
    </nav>

    <div id="content">
        <div class="topbar">
            <span id="sidebarToggle"><i class="bi bi-list"></i></span>
            <div class="user-info">
                <span>Bienvenido, {{ auth()->user()->nombre ?? 'Admin' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-topbar-logout" title="Cerrar sesión">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>

        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
    @stack('scripts')
</body>
</html>