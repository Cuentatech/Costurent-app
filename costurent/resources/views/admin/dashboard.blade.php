{{-- resources/views/admin/dashboard.blade.php --}}

@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
<div class="container-fluid">
    <div class="row min-vh-100">
        
        {{-- Sidebar --}}
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <h5 class="sidebar-heading px-3 mb-3">Menú Admin</h5>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('admin.clientes.index')) active @endif" href="{{ route('admin.clientes.index') }}">
                            <i class="bi bi-people-fill me-2"></i> Clientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('admin.alquileres.index')) active @endif" href="{{ route('admin.alquileres.index') }}">
                            <i class="bi bi-bag-check-fill me-2"></i> Alquileres
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        {{-- Contenido principal --}}
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h1 class="h2 mb-4">Panel de Administración</h1>

            {{-- Estadísticas principales --}}
            <div class="row text-white mb-5">
                <div class="col-md-4 mb-4">
                    <div class="card bg-primary shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-people-fill display-4 me-3"></i>
                            <div>
                                <h5 class="card-title">Total de Clientes</h5>
                                <h3 class="card-text">{{ $totalClientes }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card bg-success shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-bag-check-fill display-4 me-3"></i>
                            <div>
                                <h5 class="card-title">Alquileres Activos</h5>
                                <h3 class="card-text">{{ $alquileresActivos }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card bg-warning shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-clock-history display-4 me-3"></i>
                            <div>
                                <h5 class="card-title">Alquileres Retrasados</h5>
                                <h3 class="card-text">{{ $alquileresRetrasados }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Aquí puedes agregar más contenido o widgets --}}
        </main>
    </div>
</div>
@endsection
